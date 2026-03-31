<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\MemberInfo;
use App\Models\ChecklistDocuments;
use App\Models\ChecklistMaintenance;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;



class DocumentsController extends Controller
{
    //
    public function documentsChooseMember()
    {
        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','!=','PENDING')
        ->get();

        $document = ChecklistDocuments::join('tbl_checklist_maintenance','tbl_checklist_maintenance.id','=','tbl_checklist_documents.document_id')
                                        ->join('tbl_member_info','tbl_member_info.pps_no','=','tbl_checklist_documents.pps_no')                        
                ->where('tbl_checklist_documents.is_active', true)
                ->orderBy('tbl_checklist_documents.id','DESC')->paginate(5);

        return view('documents.search-member',compact('member','document'));
    }

    public function documentsUpload($pps_no)
    {
        $ids = Crypt::decrypt($pps_no); 

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',$ids)
        ->first();

      

        $checklist = ChecklistMaintenance::select('tbl_checklist_maintenance.*',
        DB::raw("(select count(*) from tbl_checklist_documents where document_id = tbl_checklist_maintenance.id and is_active = true and pps_no = '$ids') as document_count")  )
        
        ->where('tbl_checklist_maintenance.is_active',true)
        ->orderBy('tbl_checklist_maintenance.order_by','ASC')
        ->get();

        $distinct = ChecklistDocuments::select('document_id')->where('is_active',true)->where('pps_no',$ids)->distinct()->get();
        $countChecklistChecked = $distinct->count();

   


        $document = ChecklistDocuments::where('is_active', true)->where('pps_no',$ids)->get();

        $checklist_count = ChecklistMaintenance::where('is_active', true)->count();

        $checklist_total_get = ChecklistDocuments::join('tbl_checklist_maintenance as maintenance','maintenance.id','=','tbl_checklist_documents.document_id')
        ->where('tbl_checklist_documents.is_active',true)->where('tbl_checklist_documents.pps_no',$ids)->count();

        $image_count = ChecklistDocuments::where('is_active', true)->whereIn('file_type',['jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF'])->where('pps_no',$ids)->count();
        $pdf_count = ChecklistDocuments::where('is_active', true)->whereIn('file_type',['pdf','PDF'])->where('pps_no',$ids)->count();
        $other_count = ChecklistDocuments::where('is_active', true)->whereNotIn('file_type',['pdf','PDF','jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF'])->where('pps_no',$ids)->count();
       

        $recent_documents = ChecklistDocuments::select('tbl_checklist_maintenance.document_name','tbl_checklist_documents.file_type','tbl_checklist_documents.upload_dt')
        ->where('tbl_checklist_documents.is_active',true)
        ->join('tbl_checklist_maintenance','tbl_checklist_maintenance.id','=','tbl_checklist_documents.document_id')
        ->where('tbl_checklist_documents.pps_no',$ids)->orderBy('tbl_checklist_documents.id','DESC')
        ->paginate(10);

        return view('documents.upload',compact('checklist','member','recent_documents','document','checklist_count','checklist_total_get','image_count','pdf_count','other_count','countChecklistChecked'));

    }

    public function documentsUploadSubmit(Request $request)
    {
        // $file = $request->file('picture');
        // $name = time() . $file->getClientOriginalName();
        // $filePath = 'images/' . $name;
        // Storage::disk('s3')->put($filePath, file_get_contents($file));

     
        // $file = $request->file('files'.$x);
        // $name = time().'-'. $file->getClientOriginalName();
        // $file->move(public_path('img/event'),$name);


        if($request->TotalFiles > 0)
        {
                
           for ($x = 0; $x < $request->TotalFiles; $x++) 
           {
 
               if ($request->hasFile('images'.$x)) 
                {
               
                    $file = $request->file('images'.$x);
                    $fileName = time().'-'. $file->getClientOriginalName();
                    $filePath = 'checklist/' . $fileName;
             
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('images'.$x)));
                    $path = Storage::disk('s3')->url($path);

                    $original_name = $file->getClientOriginalName();
                    $file_type = $file->getClientOriginalExtension();
                    
                    
                    $checklist[$x]['original_file_name'] = $original_name;
                    $checklist[$x]['file_name'] = $fileName;
                    $checklist[$x]['file_type'] = $file_type;
                    $checklist[$x]['is_active'] = true;
                    $checklist[$x]['created_by'] = auth()->user()->name;
                    $checklist[$x]['pps_no'] = $request->pps_no;
                    $checklist[$x]['document_id'] = $request->document_id;
                    $checklist[$x]['upload_dt'] = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
                    
                }

           }

            ChecklistDocuments::insert($checklist);
            return response()->json(['success'=>'File has been uploaded']);
        }
        else
        {
           return response()->json(["message" => "Please try again."]);
        }

  
    }


    public function documentsDownload($file_name)
    {

        $file = Storage::disk('s3')->get('checklist/'.$file_name);

        $headers = [
            'Content-Type' => 'application/octet-stream', 
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename=$file_name",
            'filename'=> 'test'
        ];
        
        return response($file, 200, $headers);
        
    }

    public function documentsDelete(Request $request)
    {
        $delete = ChecklistDocuments::where('id',$request->id)->first();
        $delete->is_active = false;
        $delete->updated_by = auth()->user()->name;
        
        $delete->save();


        
    }


    


    
}
