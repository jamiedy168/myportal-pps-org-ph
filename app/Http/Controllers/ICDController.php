<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\RegistryAdmitted;
use App\Models\RegistryNeonatal;
use App\Imports\ICDRegistryAdmittedImport;
use App\Imports\ICDRegistryNeonatalImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\ICD10;
use App\Models\ICD10Temp;
use App\Models\HospitalAccredited;
use App\Models\RegistryPatientType;
use App\Models\RegistryHeader;
use DB;
use DateTime;



class ICDController extends Controller
{
    //

    public function admittedUpload()
    {
        $patient_type = RegistryPatientType::where('is_active', true)
            ->where('id',1)
            ->first();


        return view('icd-hospital.admitted-upload',compact('patient_type'));
    }

    public function admittedView()
    {
        // $icdadmitted = RegistryAdmitted::where('is_active', true)
        //                                 ->orderBy('created_at','DESC')
        //                                 ->paginate(15);

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd',
            DB::raw("(select count(*) from tbl_registry_admitted
          where DATE(month_year_icd) = DATE(tbl_registry_header.month_year_icd)
          and is_active = true
          and hospital_id = tbl_registry_header.hospital_id) as record_count")

        )
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 1)
            ->where('tbl_registry_header.hospital_id', auth()->user()->hospital_id)
            ->orderBy('tbl_registry_header.month_year_icd','DESC')
            ->paginate(10);

        $date_from = "";
        $date_to = "";



        return view('icd-hospital.admitted-view',compact('date_from','date_to','registry_header'));
    }

    public function admittedSearch(Request $request)
    {

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd',
            DB::raw("(
                                                    select count(*) from tbl_registry_admitted where month_year_icd = tbl_registry_header.month_year_icd and is_active = true and hospital_id = tbl_registry_header.hospital_id) as record_count")
        )
            ->where(function ($query) use ($date_from, $date_to) {
                if ($date_from) {
                    $startDate = Carbon::createFromFormat('Y-m', $date_from)->startOfMonth();
                    if ($date_to) {
                        $endDate = Carbon::createFromFormat('Y-m', $date_to)->endOfMonth();
                        $query->whereBetween('tbl_registry_header.month_year_icd', [$startDate, $endDate]);
                    } else {
                        $query->where('tbl_registry_header.month_year_icd', '>=', $startDate);
                    }
                }
            })
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 1)
            ->where('tbl_registry_header.hospital_id', auth()->user()->hospital_id)
            ->orderBy('tbl_registry_header.month_year_icd','DESC')
            ->paginate(10);


        // $icdadmitted = RegistryAdmitted::where('is_active', true)
        //             ->where(function ($query) use ($request) {
        //                 if ($request->filled('patient_initial')) {
        //                     $query->orWhere('patient_initial', 'ILIKE', "%$request->patient_initial%");
        //                 }
        //             })
        //             ->where(function ($query) use ($request) {
        //                 if ($request->filled('date_from') && $request->filled('date_to')) {
        //                     $query->whereBetween('month_year_icd', [$request->date_from, $request->date_to]);
        //                 }
        //             })
        //             ->orderBy('created_at','DESC')
        //             ->paginate(15);

        //             $patient_initial = $request->patient_initial;
        //             $date_from = $request->date_from;
        //             $date_to = $request->date_to;


        return view('icd-hospital.admitted-view',compact('date_from','date_to','registry_header'));
    }

    public function admittedViewDetails($id)
    {

        $ids = Crypt::decrypt($id);

        $patient_info = RegistryAdmitted::select('tbl_registry_admitted.*','hospital.hosp_name')
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_admitted.hospital_id')
            ->where('tbl_registry_admitted.is_active', true)
            ->where('tbl_registry_admitted.id', $ids)
            ->first();


        return view('icd-hospital.admitted-details',compact('patient_info'));
    }




    public function admittedUploadSave(Request $request)
    {
        $monthYear = $request->month_year_icd;
        [$year, $month] = explode('-', $monthYear);
        $month_year_icd = Carbon::createFromDate($year, $month, 1);
    
        $file = $request->file('file');
        $excelFile = Excel::toArray([], $file);
        $rowsWithEmptyCells = [];
    
        // Validate for empty critical cells
        foreach ($excelFile[0] as $index => $row) {
            if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[4]) || empty($row[5]) || empty($row[6])
            || empty($row[7]) || empty($row[8]) || empty($row[9]) || empty($row[10]) || empty($row[11]) || empty($row[12]) || empty($row[13])) {
                $rowsWithEmptyCells[] = $index + 1; // Row number (1-based index)
            }
        }
    
        if (!empty($rowsWithEmptyCells)) {
            return response()->json(['success' => 'empty', 'filename' => $file]);
        }
    
        // Save RegistryHeader and Import File
        $patient_registry = new RegistryHeader();
        $patient_registry->is_active = true;
        $patient_registry->created_by = auth()->user()->name;
        $patient_registry->hospital_id = auth()->user()->hospital_id;
        $patient_registry->month_year_icd = $month_year_icd;
        $patient_registry->patient_type_id = 1;
        $patient_registry->save();
    
        $registry_id = $patient_registry->id;
        Excel::import(new ICDRegistryAdmittedImport($month_year_icd, $registry_id), $file);
    
        return response()->json(['success' => 'uploaded', 'filename' => $file]);
    }
    
    

    public function admittedUploadCheckExist(Request $request)
    {
        $monthYear = $request->month_year_icd;
        [$year, $month] = explode('-', $monthYear);


        $countExist = RegistryAdmitted::where('is_active', true)
            ->whereYear('month_year_icd', $year)
            ->whereMonth('month_year_icd', $month)
            ->count();

        return $countExist;
    }


    public function neonatalUpload()
    {
        $patient_type = RegistryPatientType::where('is_active', true)
            ->where('id',2)
            ->first();


        return view('icd-hospital.neonatal-upload',compact('patient_type'));
    }

    public function neonatalView()
    {

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd',
            DB::raw("(select count(*) from tbl_registry_neonatal
          where DATE(month_year_icd) = DATE(tbl_registry_header.month_year_icd)
          and is_active = true
          and hospital_id = tbl_registry_header.hospital_id) as record_count")
        )
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 2)
            ->where('tbl_registry_header.hospital_id', auth()->user()->hospital_id)
            ->orderBy('tbl_registry_header.month_year_icd','DESC')
            ->paginate(10);

        $date_from = "";
        $date_to = "";

        return view('icd-hospital.neonatal-view',compact('date_from','date_to','registry_header'));
    }

    public function neonatalSearch(Request $request)
    {


        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd',
            DB::raw("(select count(*) from tbl_registry_neonatal
          where DATE(month_year_icd) = DATE(tbl_registry_header.month_year_icd)
          and is_active = true
          and hospital_id = tbl_registry_header.hospital_id) as record_count")
        )
            ->where(function ($query) use ($date_from, $date_to) {
                if ($date_from) {
                    $startDate = Carbon::createFromFormat('Y-m', $date_from)->startOfMonth();
                    if ($date_to) {
                        $endDate = Carbon::createFromFormat('Y-m', $date_to)->endOfMonth();
                        $query->whereBetween('tbl_registry_header.month_year_icd', [$startDate, $endDate]);
                    } else {
                        $query->where('tbl_registry_header.month_year_icd', '>=', $startDate);
                    }
                }
            })
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 2)
            ->where('tbl_registry_header.hospital_id', auth()->user()->hospital_id)
            ->orderBy('tbl_registry_header.month_year_icd','DESC')
            ->paginate(10);


        return view('icd-hospital.neonatal-view',compact('registry_header','date_from','date_to'));
    }



    public function neonatalUploadCheckExist(Request $request)
    {
        $monthYear = $request->month_year_icd;
        [$year, $month] = explode('-', $monthYear);


        $countExist = RegistryNeonatal::where('is_active', true)
            ->whereYear('month_year_icd', $year)
            ->whereMonth('month_year_icd', $month)
            ->count();

        return $countExist;
    }



    public function neonatalUploadSave(Request $request)
    {

        $monthYear = $request->month_year_icd;
        [$year, $month] = explode('-', $monthYear);

        $month_year_icd = Carbon::createFromDate($year, $month, 1);

        $patient_registry = new RegistryHeader();
        $patient_registry->is_active = true;
        $patient_registry->created_by = auth()->user()->name;
        $patient_registry->hospital_id = auth()->user()->hospital_id;
        $patient_registry->month_year_icd = $month_year_icd;
        $patient_registry->patient_type_id = 2;
        $patient_registry->save();

        $registry_id = $patient_registry->id;


        $file = $request->file('file');

        Excel::import(new ICDRegistryNeonatalImport($month_year_icd,$registry_id), $file);

        return response()->json(['success' => 'File uploaded successfully.', 'filename' => $file]);

    }



    public function neonatalViewDetails($id)
    {

        $ids = Crypt::decrypt($id);

        $neontal_info = RegistryNeonatal::select('tbl_registry_neonatal.*','hospital.hosp_name')
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_neonatal.hospital_id')
            ->where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.id', $ids)
            ->first();


        return view('icd-hospital.neonatal-details',compact('neontal_info'));
    }



    public function templateDownload()
    {
        return view('icd-hospital.template-download');
    }

    public function downloadPatientTemplate($folder, $filename)
    {
        $filePath = $folder . '/' . $filename; // Construct the full path
        $disk = Storage::disk('s3');

        if ($disk->exists($filePath)) {

            $tempImage = tempnam(sys_get_temp_dir(), $filename);
            file_put_contents($tempImage, $disk->get($filePath));

            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            return response()->file($tempImage, $headers)->deleteFileAfterSend(true);

        }

    }


    public function downloadNeonatalTemplate($folder, $filename)
    {
        $filePath = $folder . '/' . $filename; // Construct the full path
        $disk = Storage::disk('s3');

        if ($disk->exists($filePath)) {

            $tempImage = tempnam(sys_get_temp_dir(), $filename);
            file_put_contents($tempImage, $disk->get($filePath));

            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            return response()->file($tempImage, $headers)->deleteFileAfterSend(true);

        }

    }



    public function adminAdmittedView()
    {
        $icdadmitted = RegistryAdmitted::where('is_active', true)
            ->orderBy('created_at','DESC')
            ->paginate(15);

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd','hosp.hosp_name',
            DB::raw("(select count(*) from tbl_registry_admitted
              where DATE(month_year_icd) = DATE(tbl_registry_header.month_year_icd)
              and is_active = true
              and hospital_id = tbl_registry_header.hospital_id) as record_count")
        )
            ->join('tbl_hospital_accredited as hosp','hosp.id','=','tbl_registry_header.hospital_id')
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 1)
            ->orderBy('tbl_registry_header.month_year_icd','DESC')
            ->paginate(10);



        $hospital_list = HospitalAccredited::where('is_active',true)
            ->orderBy('hosp_name','ASC')
            ->get();


        $hospital_id = "";
        $date_from = "";
        $date_to = "";

        return view('icd-hospital.admin-admitted-view',compact('icdadmitted','hospital_id','date_from','date_to','hospital_list','registry_header'));
    }


    public function adminAdmittedViewSearch(Request $request)
    {

        $hospital_id = $request->hospital_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;


        $hospital_list = HospitalAccredited::where('is_active',true)
            ->orderBy('hosp_name','ASC')
            ->get();


        $icdadmitted = RegistryAdmitted::where('is_active', true)
            ->orderBy('created_at','DESC')
            ->paginate(15);


        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd','hosp.hosp_name',
            DB::raw("(select count(*) from tbl_registry_admitted
              where DATE(month_year_icd) = DATE(tbl_registry_header.month_year_icd)
              and is_active = true
              and hospital_id = tbl_registry_header.hospital_id) as record_count")
        )
            ->where(function ($query) use ($date_from, $date_to) {
                if ($date_from) {
                    $startDate = Carbon::createFromFormat('Y-m', $date_from)->startOfMonth();
                    if ($date_to) {
                        $endDate = Carbon::createFromFormat('Y-m', $date_to)->endOfMonth();
                        $query->whereBetween('tbl_registry_header.month_year_icd', [$startDate, $endDate]);
                    } else {
                        $query->where('tbl_registry_header.month_year_icd', '>=', $startDate);
                    }
                }
            })
            ->join('tbl_hospital_accredited as hosp','hosp.id','=','tbl_registry_header.hospital_id')
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 1)
            ->when($hospital_id, function ($query, $hospital_id) {
                return $query->where('tbl_registry_header.hospital_id', $hospital_id);
            })
            ->orderBy('tbl_registry_header.month_year_icd','DESC')
            ->paginate(10);



        return view('icd-hospital.admin-admitted-view',compact('icdadmitted','hospital_id','date_from','date_to','hospital_list','registry_header'));


    }

    public function adminAdmittedSearch(Request $request)
    {

        $hospital_list = HospitalAccredited::where('is_active',true)
            ->orderBy('hosp_name','ASC')
            ->get();



        $icdadmitted = RegistryAdmitted::where('is_active', true)
            ->where(function ($query) use ($request) {
                if ($request->filled('hospital_id')) {
                    $query->orWhere('hospital_id', $request->hospital_id);
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('date_from') && $request->filled('date_to')) {
                    $query->whereBetween('month_year_icd', [$request->date_from, $request->date_to]);
                }
            })
            ->orderBy('created_at','DESC')
            ->paginate(15);

        $hospital_id = $request->hospital_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;


        return view('icd-hospital.admin-admitted-view',compact('icdadmitted','hospital_id','date_from','date_to','hospital_list'));
    }


    public function adminNeonatalView()
    {


        $icdneonatal = RegistryNeonatal::where('is_active', true)
            ->orderBy('created_at','DESC')
            ->paginate(15);

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd','hosp.hosp_name',
            DB::raw("(select count(*) from tbl_registry_neonatal
          where DATE(month_year_icd) = DATE(tbl_registry_header.month_year_icd)
          and is_active = true
          and hospital_id = tbl_registry_header.hospital_id) as record_count")
        )
            ->join('tbl_hospital_accredited as hosp','hosp.id','=','tbl_registry_header.hospital_id')
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 2)
            ->orderBy('tbl_registry_header.month_year_icd','DESC')
            ->paginate(10);



        $hospital_list = HospitalAccredited::where('is_active',true)
            ->orderBy('hosp_name','ASC')
            ->get();


        $hospital_id = "";
        $date_from = "";
        $date_to = "";

        return view('icd-hospital.admin-neonatal-view',compact('icdneonatal','hospital_id','date_from','date_to','hospital_list','registry_header'));

    }


    public function adminNeonatalViewSearch(Request $request)
    {

        $hospital_id = $request->hospital_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;


        $hospital_list = HospitalAccredited::where('is_active',true)
            ->orderBy('hosp_name','ASC')
            ->get();


        $icdneonatal = RegistryNeonatal::where('is_active', true)
            ->orderBy('created_at','DESC')
            ->paginate(15);



        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd','hosp.hosp_name',
            DB::raw("(select count(*) from tbl_registry_neonatal
              where DATE(month_year_icd) = DATE(tbl_registry_header.month_year_icd)
              and is_active = true
              and hospital_id = tbl_registry_header.hospital_id) as record_count")
        )
            ->where(function ($query) use ($date_from, $date_to) {
                if ($date_from) {
                    $startDate = Carbon::createFromFormat('Y-m', $date_from)->startOfMonth();
                    if ($date_to) {
                        $endDate = Carbon::createFromFormat('Y-m', $date_to)->endOfMonth();
                        $query->whereBetween('tbl_registry_header.month_year_icd', [$startDate, $endDate]);
                    } else {
                        $query->where('tbl_registry_header.month_year_icd', '>=', $startDate);
                    }
                }
            })
            ->join('tbl_hospital_accredited as hosp','hosp.id','=','tbl_registry_header.hospital_id')
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 2)
            ->when($hospital_id, function ($query, $hospital_id) {
                return $query->where('tbl_registry_header.hospital_id', $hospital_id);
            })
            ->orderBy('tbl_registry_header.month_year_icd','DESC')
            ->paginate(10);



        return view('icd-hospital.admin-neonatal-view',compact('icdneonatal','hospital_id','date_from','date_to','hospital_list','registry_header'));


    }

    public function adminNeonatalSearch(Request $request)
    {

        $hospital_list = HospitalAccredited::where('is_active',true)
            ->orderBy('hosp_name','ASC')
            ->get();


        $icdneonatal = RegistryNeonatal::where('is_active', true)
            ->where(function ($query) use ($request) {
                if ($request->filled('hospital_id')) {
                    $query->orWhere('hospital_id', $request->hospital_id);
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('date_from') && $request->filled('date_to')) {
                    $query->whereBetween('month_year_icd', [$request->date_from, $request->date_to]);
                }
            })
            ->orderBy('created_at','DESC')
            ->paginate(15);

        $hospital_id = $request->hospital_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;


        return view('icd-hospital.admin-neonatal-view',compact('icdneonatal','hospital_list','hospital_id','date_from','date_to'));
    }


    public function adminAdmittedViewDetails($id)
    {

        $ids = Crypt::decrypt($id);


        $patient_info = RegistryAdmitted::select('tbl_registry_admitted.*','hospital.hosp_name')
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_admitted.hospital_id')
            ->where('tbl_registry_admitted.is_active', true)
            ->where('tbl_registry_admitted.id', $ids)
            ->first();


        return view('icd-hospital.admin-admitted-details',compact('patient_info'));
    }


    public function adminNeonatalViewDetails($id)
    {

        $ids = Crypt::decrypt($id);

        $neontal_info = RegistryNeonatal::select('tbl_registry_neonatal.*','hospital.hosp_name')
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_neonatal.hospital_id')
            ->where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.id', $ids)
            ->first();


        return view('icd-hospital.admin-neonatal-details',compact('neontal_info'));
    }


    public function adminNewCode()
    {
        $icdtemp = ICD10Temp::where('isactive', true)
            ->orderBy('created_at','DESC')
            ->paginate(15);

        return view('icd-hospital.admin-new-code',compact('icdtemp'));
    }


    public function adminAddCode(Request $request)
    {



        $icdtemp = new ICD10();
        $icdtemp->isactive = true;
        $icdtemp->created_by = auth()->user()->name;
        $icdtemp->description = $request->description;
        $icdtemp->save();


        $deleteicdtemp = ICD10Temp::where('isactive', true)
            ->where('id',$request->id)
            ->delete();

        return "success";
    }


    public function wardDelete(Request $request)
    {

        $delete_registry_header = RegistryHeader::where('id',$request->id)->first();
        $delete_registry_header -> is_active =  false;
        $delete_registry_header -> status =  'DELETED';
        $delete_registry_header->save();


        $update_registry_ward = RegistryAdmitted::where('registry_header_id', $request->id)
            ->update([
                'is_active' => false,
                'status' => 'DELETED'
            ]);


        return "deleted";
    }


    public function wardPatientDelete(Request $request)
    {
        $update_registry_ward = RegistryAdmitted::where('id',$request->id)->first();
        $update_registry_ward -> is_active =  false;
        $update_registry_ward -> status = 'DELETED';
        $update_registry_ward->save();

        return "deleted";
    }

    public function admittedViewPatient($id)
    {

        $ids = Crypt::decrypt($id);


        $registry_admitted = RegistryAdmitted::select('tbl_registry_admitted.patient_initial','tbl_registry_admitted.date_of_birth',
            'tbl_registry_admitted.gender','tbl_registry_admitted.type_of_patient','tbl_registry_admitted.weight',
            'tbl_registry_admitted.date_admitted','tbl_registry_admitted.date_discharged','tbl_registry_admitted.outcome',
            'tbl_registry_admitted.icd_no','tbl_registry_admitted.primary_diagnosis',
            'tbl_registry_admitted.icd_no2','tbl_registry_admitted.secondary_diagnosis',
            'tbl_registry_admitted.icd_no3','tbl_registry_admitted.tertiary_diagnosis',
            'tbl_registry_admitted.created_at','tbl_registry_admitted.created_by',
            'hospital.hosp_name')
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_admitted.hospital_id')
            ->where('tbl_registry_admitted.is_active', true)
            ->where('tbl_registry_admitted.id', $ids)
            ->first();


        return view('icd-hospital.admitted-view-patient',compact('registry_admitted'));
    }






    public function neonatalDelete(Request $request)
    {

        $delete_registry_header = RegistryHeader::where('id',$request->id)->first();
        $delete_registry_header -> is_active =  false;
        $delete_registry_header -> status =  'DELETED';
        $delete_registry_header->save();


        $update_registry_ward = RegistryNeonatal::where('registry_header_id', $request->id)
            ->update([
                'is_active' => false,
                'status' => 'DELETED'
            ]);


        return "deleted";
    }

    public function admittedViewMonth($id)
    {

        $ids = Crypt::decrypt($id);

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd',
            DB::raw("(select count(*) from tbl_registry_admitted where month_year_icd = tbl_registry_header.month_year_icd and is_active = true and hospital_id = tbl_registry_header.hospital_id) as record_count"))
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 1)
            ->where('tbl_registry_header.hospital_id', auth()->user()->hospital_id)
            ->where('tbl_registry_header.id', $ids)
            ->first();

        if ($registry_header) {
            $monthYear = DateTime::createFromFormat('Y-m-d', $registry_header->month_year_icd);

            if ($monthYear) {
                $firstDay = $monthYear->format('F 01');
                $lastDay = $monthYear->format('t, Y');
                $formattedDateRange = $firstDay . ' - ' . $lastDay;
            } else {
                $formattedDateRange = null;
            }
        } else {
            $formattedDateRange = null;
        }


        $registry_admitted = RegistryAdmitted::select('tbl_registry_admitted.id','tbl_registry_admitted.created_at','tbl_registry_admitted.created_by',
            'tbl_registry_admitted.month_year_icd','tbl_registry_admitted.patient_initial','tbl_registry_admitted.date_admitted',
            'tbl_registry_admitted.date_discharged','tbl_registry_admitted.icd_no','tbl_registry_admitted.icd_no2','tbl_registry_admitted.icd_no3'
        )
            ->where('tbl_registry_admitted.is_active', true)
            ->where('tbl_registry_admitted.hospital_id', auth()->user()->hospital_id)
            ->where('tbl_registry_admitted.registry_header_id', $ids)
            ->orderBy('tbl_registry_admitted.id','ASC')
            ->paginate(5);


        $countValues = DB::table(DB::raw('(
                (SELECT icd_no as value FROM tbl_registry_admitted WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
                UNION ALL
                (SELECT icd_no2 as value FROM tbl_registry_admitted WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
                UNION ALL
                (SELECT icd_no3 as value FROM tbl_registry_admitted WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            ) as combined'))
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->orderByDesc('count')
            ->setBindings([auth()->user()->hospital_id, $ids, auth()->user()->hospital_id, $ids, auth()->user()->hospital_id, $ids])
            ->paginate(10);



        return view('icd-hospital.admitted-view-month',compact('registry_admitted','registry_header','formattedDateRange','id','countValues'));

    }


    public function adminAdmittedViewMonth($id)
    {

        $ids = Crypt::decrypt($id);
        $searchinput = '';

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd','hospital.hosp_name',
            DB::raw("(select count(*) from tbl_registry_admitted where month_year_icd = tbl_registry_header.month_year_icd and is_active = true and hospital_id = tbl_registry_header.hospital_id) as record_count"))
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_header.hospital_id')
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 1)
            ->where('tbl_registry_header.id', $ids)
            ->first();



        if ($registry_header) {
            $monthYear = DateTime::createFromFormat('Y-m-d', $registry_header->month_year_icd);

            if ($monthYear) {
                $firstDay = $monthYear->format('F 01');
                $lastDay = $monthYear->format('t, Y');
                $formattedDateRange = $firstDay . ' - ' . $lastDay;
            } else {
                $formattedDateRange = null;
            }
        } else {
            $formattedDateRange = null;
        }

        $registry_admitted = RegistryAdmitted::select('tbl_registry_admitted.id','tbl_registry_admitted.created_at','tbl_registry_admitted.created_by',
            'tbl_registry_admitted.month_year_icd','tbl_registry_admitted.patient_initial','tbl_registry_admitted.date_admitted',
            'tbl_registry_admitted.date_discharged','tbl_registry_admitted.icd_no','tbl_registry_admitted.icd_no2','tbl_registry_admitted.icd_no3'
        )
            ->where('tbl_registry_admitted.is_active', true)
            ->where('tbl_registry_admitted.registry_header_id', $ids)
            ->orderBy('tbl_registry_admitted.id','ASC')
            ->paginate(5);


        return view('icd-hospital.admin-admitted-view-month',compact('registry_admitted','registry_header','formattedDateRange','id','searchinput'));

    }

    public function adminAdmittedViewMonthSearch(Request $request, $id)
    {

        $searchinput = $request->searchinput;
        $ids = Crypt::decrypt($id);


        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd','hospital.hosp_name',
            DB::raw("(select count(*) from tbl_registry_admitted where month_year_icd = tbl_registry_header.month_year_icd and is_active = true and hospital_id = tbl_registry_header.hospital_id) as record_count"))
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_header.hospital_id')
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 1)
            ->where('tbl_registry_header.id', $ids)
            ->first();



        if ($registry_header) {
            $monthYear = DateTime::createFromFormat('Y-m-d', $registry_header->month_year_icd);

            if ($monthYear) {
                $firstDay = $monthYear->format('F 01');
                $lastDay = $monthYear->format('t, Y');
                $formattedDateRange = $firstDay . ' - ' . $lastDay;
            } else {
                $formattedDateRange = null;
            }
        } else {
            $formattedDateRange = null;
        }

        $registry_admitted = RegistryAdmitted::select('tbl_registry_admitted.id','tbl_registry_admitted.created_at','tbl_registry_admitted.created_by',
            'tbl_registry_admitted.month_year_icd','tbl_registry_admitted.patient_initial','tbl_registry_admitted.date_admitted',
            'tbl_registry_admitted.date_discharged','tbl_registry_admitted.icd_no','tbl_registry_admitted.icd_no2','tbl_registry_admitted.icd_no3'
        )
            ->where('tbl_registry_admitted.is_active', true)
            ->where('tbl_registry_admitted.registry_header_id', $ids)
            ->where('tbl_registry_admitted.patient_initial','LIKE', '%'.strtoupper($request->searchinput).'%')
            ->orderBy('tbl_registry_admitted.id','ASC')
            ->paginate(5);



        return view('icd-hospital.admin-admitted-view-month',compact('registry_admitted','registry_header','formattedDateRange','id','searchinput'));


    }



    public function adminNeonatalViewMonthSearch(Request $request, $id)
    {

        $searchinput = $request->searchinput;
        $ids = Crypt::decrypt($id);


        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd','hospital.hosp_name',
            DB::raw("(select count(*) from tbl_registry_neonatal
          where DATE(month_year_icd) = DATE(tbl_registry_header.month_year_icd)
          and is_active = true
          and hospital_id = tbl_registry_header.hospital_id) as record_count")
        )
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_header.hospital_id')
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 2)
            ->where('tbl_registry_header.id', $ids)
            ->first();





        if ($registry_header) {
            $monthYear = DateTime::createFromFormat('Y-m-d', $registry_header->month_year_icd);

            if ($monthYear) {
                $firstDay = $monthYear->format('F 01');
                $lastDay = $monthYear->format('t, Y');
                $formattedDateRange = $firstDay . ' - ' . $lastDay;
            } else {
                $formattedDateRange = null;
            }
        } else {
            $formattedDateRange = null;
        }



        $registry_neonatal = RegistryNeonatal::where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.registry_header_id', $ids)
            ->where('tbl_registry_neonatal.patient_initial','LIKE', '%'.strtoupper($request->searchinput).'%')
            ->orderBy('tbl_registry_neonatal.id','ASC')
            ->paginate(5);



        return view('icd-hospital.admin-neonatal-view-month',compact('registry_neonatal','registry_header','formattedDateRange','id','searchinput'));


    }


    public function admittedSearchMonth(Request $request, $id)
    {
        $ids = Crypt::decrypt($id);

        $searchinput = $request->searchinput;


        $registry_admitted = RegistryAdmitted::select('tbl_registry_admitted.id','tbl_registry_admitted.created_at','tbl_registry_admitted.created_by',
            'tbl_registry_admitted.month_year_icd','tbl_registry_admitted.patient_initial','tbl_registry_admitted.date_admitted',
            'tbl_registry_admitted.date_discharged','tbl_registry_admitted.icd_no','tbl_registry_admitted.icd_no2','tbl_registry_admitted.icd_no3'
        )
            ->where('tbl_registry_admitted.is_active', true)
            ->where('tbl_registry_admitted.hospital_id', auth()->user()->hospital_id)
            ->where('tbl_registry_admitted.registry_header_id', $ids)
            ->where('tbl_registry_admitted.registry_header_id', $ids)
            ->where('tbl_registry_admitted.patient_initial', 'LIKE', '%' . $request->patient_initial . '%')
            ->orderBy('tbl_registry_admitted.id','ASC')
            ->paginate(5);

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd',
            DB::raw("(select count(*) from tbl_registry_admitted where month_year_icd = tbl_registry_header.month_year_icd and is_active = true and hospital_id = tbl_registry_header.hospital_id) as record_count"))
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 1)
            ->where('tbl_registry_header.hospital_id', auth()->user()->hospital_id)
            ->where('tbl_registry_header.id', $ids)
            ->first();

        if ($registry_header) {
            $monthYear = DateTime::createFromFormat('Y-m-d', $registry_header->month_year_icd);

            if ($monthYear) {
                $firstDay = $monthYear->format('F 01');
                $lastDay = $monthYear->format('t, Y');
                $formattedDateRange = $firstDay . ' - ' . $lastDay;
            } else {
                $formattedDateRange = null;
            }
        } else {
            $formattedDateRange = null;
        }


        $countValues = DB::table(DB::raw('(
            (SELECT icd_no as value FROM tbl_registry_admitted WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no2 as value FROM tbl_registry_admitted WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no3 as value FROM tbl_registry_admitted WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
        ) as combined'))
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->orderByDesc('count')
            ->setBindings([auth()->user()->hospital_id, $ids, auth()->user()->hospital_id, $ids, auth()->user()->hospital_id, $ids])
            ->paginate(10);



        return view('icd-hospital.admitted-view-month',compact('registry_admitted','registry_header','formattedDateRange','id','countValues'));

    }





    public function neonatalViewMonth($id)
    {

        $ids = Crypt::decrypt($id);

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd',
            DB::raw("(
                                                    select count(*) from tbl_registry_neonatal where month_year_icd = tbl_registry_header.month_year_icd and is_active = true and hospital_id = tbl_registry_header.hospital_id) as record_count"))
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 2)
            ->where('tbl_registry_header.hospital_id', auth()->user()->hospital_id)
            ->where('tbl_registry_header.id', $ids)
            ->first();

        if ($registry_header) {
            $monthYear = DateTime::createFromFormat('Y-m-d', $registry_header->month_year_icd);

            if ($monthYear) {
                $firstDay = $monthYear->format('F 01');
                $lastDay = $monthYear->format('t, Y');
                $formattedDateRange = $firstDay . ' - ' . $lastDay;
            } else {
                $formattedDateRange = null;
            }
        } else {
            $formattedDateRange = null;
        }

        $registry_neonatal = RegistryNeonatal::
        where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.hospital_id', auth()->user()->hospital_id)
            ->where('tbl_registry_neonatal.registry_header_id', $ids)
            ->orderBy('tbl_registry_neonatal.id','ASC')
            ->paginate(5);


        $countValues = DB::table(DB::raw('(
            (SELECT icd_no_1 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_2 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_3 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_4 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_5 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_6 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_7 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
        ) as combined'))
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->orderByDesc('count')
            ->setBindings([auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids])
            ->paginate(10);



        return view('icd-hospital.neonatal-view-month',compact('registry_neonatal','registry_header','formattedDateRange','id','countValues'));



    }


    public function neonatalSearchMonth(Request $request, $id)
    {


        $ids = Crypt::decrypt($id);


        $registry_neonatal = RegistryNeonatal::where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.hospital_id', auth()->user()->hospital_id)
            ->where('tbl_registry_neonatal.registry_header_id', $ids)
            ->where('tbl_registry_neonatal.patient_initial', 'LIKE', '%' . $request->patient_initial . '%')
            ->orderBy('tbl_registry_neonatal.id','ASC')
            ->paginate(5);

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd',
            DB::raw("(
                                                                    select count(*) from tbl_registry_neonatal where month_year_icd = tbl_registry_header.month_year_icd and is_active = true and hospital_id = tbl_registry_header.hospital_id) as record_count"))
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 2)
            ->where('tbl_registry_header.hospital_id', auth()->user()->hospital_id)
            ->where('tbl_registry_header.id', $ids)
            ->first();


        if ($registry_header) {
            $monthYear = DateTime::createFromFormat('Y-m-d', $registry_header->month_year_icd);

            if ($monthYear) {
                $firstDay = $monthYear->format('F 01');
                $lastDay = $monthYear->format('t, Y');
                $formattedDateRange = $firstDay . ' - ' . $lastDay;
            } else {
                $formattedDateRange = null;
            }
        } else {
            $formattedDateRange = null;
        }


        $countValues = DB::table(DB::raw('(
            (SELECT icd_no_1 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_2 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_3 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_4 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_5 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_6 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
            UNION ALL
            (SELECT icd_no_7 as value FROM tbl_registry_neonatal WHERE is_active = true AND hospital_id = ? AND registry_header_id = ?)
        ) as combined'))
            ->select('value', DB::raw('count(*) as count'))
            ->groupBy('value')
            ->orderByDesc('count')
            ->setBindings([auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids,
                auth()->user()->hospital_id, $ids])
            ->paginate(10);


        return view('icd-hospital.neonatal-view-month',compact('registry_neonatal','registry_header','formattedDateRange','id','countValues'));

    }



    public function neonatalPatientDelete(Request $request)
    {
        $update_registry_neonatal = RegistryNeonatal::where('id',$request->id)->first();
        $update_registry_neonatal -> is_active =  false;
        $update_registry_neonatal -> status = 'DELETED';
        $update_registry_neonatal->save();

        return "deleted";
    }


    public function neonatalViewPatient($id)
    {
        $ids = Crypt::decrypt($id);

        $registry_neonatal = RegistryNeonatal::select('tbl_registry_neonatal.patient_initial','tbl_registry_neonatal.created_at','tbl_registry_neonatal.created_by',
            'tbl_registry_neonatal.patient_birth_location','tbl_registry_neonatal.gestational_age','tbl_registry_neonatal.gender',
            'tbl_registry_neonatal.birth_weight','tbl_registry_neonatal.date_of_admission','tbl_registry_neonatal.date_discharged',
            'tbl_registry_neonatal.icd_no_1','tbl_registry_neonatal.diagnosis1','tbl_registry_neonatal.icd_no_2','tbl_registry_neonatal.diagnosis2',
            'tbl_registry_neonatal.icd_no_3','tbl_registry_neonatal.diagnosis3','tbl_registry_neonatal.icd_no_4','tbl_registry_neonatal.diagnosis4',
            'tbl_registry_neonatal.icd_no_5','tbl_registry_neonatal.diagnosis5','tbl_registry_neonatal.icd_no_6','tbl_registry_neonatal.diagnosis6',
            'tbl_registry_neonatal.icd_no_7','tbl_registry_neonatal.diagnosis7','tbl_registry_neonatal.maturity',
            'tbl_registry_neonatal.presentation_upon_delivery','tbl_registry_neonatal.manner_of_delivery','tbl_registry_neonatal.apgar_score',
            'tbl_registry_neonatal.einc','tbl_registry_neonatal.incomplete_einc_steps','tbl_registry_neonatal.no_of_fetuses',
            'tbl_registry_neonatal.baby_covid_status','tbl_registry_neonatal.mother_covid_status','tbl_registry_neonatal.kangaroo_mother_care',
            'tbl_registry_neonatal.type_feeding_discharge','tbl_registry_neonatal.use_donor_human_milk','tbl_registry_neonatal.highest_total_bilirubin',
            'tbl_registry_neonatal.respiratory_support','tbl_registry_neonatal.discharge_outcome',
            'hospital.hosp_name')
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_neonatal.hospital_id')
            ->where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.id', $ids)
            ->first();


        return view('icd-hospital.neonatal-view-patient',compact('registry_neonatal'));
    }


    public function adminNeonatalViewPatient($id)
    {
        $ids = Crypt::decrypt($id);

        $registry_neonatal = RegistryNeonatal::select('tbl_registry_neonatal.patient_initial','tbl_registry_neonatal.created_at','tbl_registry_neonatal.created_by',
            'tbl_registry_neonatal.patient_birth_location','tbl_registry_neonatal.gestational_age','tbl_registry_neonatal.gender',
            'tbl_registry_neonatal.birth_weight','tbl_registry_neonatal.date_of_admission','tbl_registry_neonatal.date_discharged',
            'tbl_registry_neonatal.icd_no_1','tbl_registry_neonatal.diagnosis1','tbl_registry_neonatal.icd_no_2','tbl_registry_neonatal.diagnosis2',
            'tbl_registry_neonatal.icd_no_3','tbl_registry_neonatal.diagnosis3','tbl_registry_neonatal.icd_no_4','tbl_registry_neonatal.diagnosis4',
            'tbl_registry_neonatal.icd_no_5','tbl_registry_neonatal.diagnosis5','tbl_registry_neonatal.icd_no_6','tbl_registry_neonatal.diagnosis6',
            'tbl_registry_neonatal.icd_no_7','tbl_registry_neonatal.diagnosis7','tbl_registry_neonatal.maturity',
            'tbl_registry_neonatal.presentation_upon_delivery','tbl_registry_neonatal.manner_of_delivery','tbl_registry_neonatal.apgar_score',
            'tbl_registry_neonatal.einc','tbl_registry_neonatal.incomplete_einc_steps','tbl_registry_neonatal.no_of_fetuses',
            'tbl_registry_neonatal.baby_covid_status','tbl_registry_neonatal.mother_covid_status','tbl_registry_neonatal.kangaroo_mother_care',
            'tbl_registry_neonatal.type_feeding_discharge','tbl_registry_neonatal.use_donor_human_milk','tbl_registry_neonatal.highest_total_bilirubin',
            'tbl_registry_neonatal.respiratory_support','tbl_registry_neonatal.discharge_outcome',
            'hospital.hosp_name')
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_neonatal.hospital_id')
            ->where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.id', $ids)
            ->first();



        return view('icd-hospital.admin-neonatal-view-patient',compact('registry_neonatal'));
    }


    public function adminAdmittedViewPatient($id)
    {

        $ids = Crypt::decrypt($id);


        $registry_admitted = RegistryAdmitted::select('tbl_registry_admitted.patient_initial','tbl_registry_admitted.date_of_birth',
            'tbl_registry_admitted.gender','tbl_registry_admitted.type_of_patient','tbl_registry_admitted.weight',
            'tbl_registry_admitted.date_admitted','tbl_registry_admitted.date_discharged','tbl_registry_admitted.outcome',
            'tbl_registry_admitted.icd_no','tbl_registry_admitted.primary_diagnosis',
            'tbl_registry_admitted.icd_no2','tbl_registry_admitted.secondary_diagnosis',
            'tbl_registry_admitted.icd_no3','tbl_registry_admitted.tertiary_diagnosis',
            'tbl_registry_admitted.created_at','tbl_registry_admitted.created_by',
            'hospital.hosp_name')
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_admitted.hospital_id')
            ->where('tbl_registry_admitted.is_active', true)
            ->where('tbl_registry_admitted.id', $ids)
            ->first();



        return view('icd-hospital.admin-admitted-view-patient',compact('registry_admitted'));
    }



    public function adminNeonatalViewMonth($id)
    {


        $ids = Crypt::decrypt($id);
        $searchinput = '';

        $registry_header = RegistryHeader::select('tbl_registry_header.id','tbl_registry_header.created_at','tbl_registry_header.created_by',
            'tbl_registry_header.month_year_icd','hospital.hosp_name',
            DB::raw("(select count(*) from tbl_registry_neonatal where month_year_icd = tbl_registry_header.month_year_icd and is_active = true and hospital_id = tbl_registry_header.hospital_id) as record_count"))
            ->leftJoin('tbl_hospital_accredited as hospital','hospital.id','=','tbl_registry_header.hospital_id')
            ->where('tbl_registry_header.is_active', true)
            ->where('tbl_registry_header.patient_type_id', 2)
            ->where('tbl_registry_header.id', $ids)
            ->first();




        if ($registry_header) {
            $monthYear = DateTime::createFromFormat('Y-m-d', $registry_header->month_year_icd);

            if ($monthYear) {
                $firstDay = $monthYear->format('F 01');
                $lastDay = $monthYear->format('t, Y');
                $formattedDateRange = $firstDay . ' - ' . $lastDay;
            } else {
                $formattedDateRange = null;
            }
        } else {
            $formattedDateRange = null;
        }


        $registry_neonatal = RegistryNeonatal::where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.is_active', true)
            ->where('tbl_registry_neonatal.registry_header_id', $ids)
            ->orderBy('tbl_registry_neonatal.id','ASC')
            ->paginate(5);


        return view('icd-hospital.admin-neonatal-view-month',compact('registry_neonatal','registry_header','formattedDateRange','id','searchinput'));

    }


}
