<?php

namespace App\Http\Controllers;
use App\Exports\ReportMemberListExport;
use App\Exports\SpecialtyBoardExport;
use App\Models\Chapter;
use Curl;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Illuminate\Http\Request;
use App\Models\MemberInfo;
use App\Models\MemberType;
use App\Models\Nationality;
use App\Models\User;
use App\Models\MemberInstitution;
use App\Models\MemberSubspecialty;
use App\Models\MemberAcademicDegree;
use App\Models\MemberResearch;
use App\Models\CPDPoints;
use App\Models\PriceList;
use App\Models\SpecialtyBoard;
use App\Models\ORMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class SpecialtyBoardController extends Controller
{
    //

    private $pps_url = 'http://127.0.0.1:8000/';

    public function view()
    {
        $member_info = MemberInfo::select('tbl_member_info.*','nat.nationality_name','type.member_type_name','chapter.chapter_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->leftjoin('tbl_nationality as nat','nat.id','=','tbl_member_info.nationality')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_member_info.member_chapter')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();


        $price_list = PriceList::where('tbl_price_list.type_description',$member_info->member_type_name)
                                ->where('tbl_price_list.category','SPECIALTY BOARD')
                                ->where('tbl_price_list.is_active',true)
                                ->first();

        $specialty_board = SpecialtyBoard::select('type.member_type_name as apply_description',
                                                    'tbl_specialty_board.apply_dt','tbl_specialty_board.status')
                                ->leftJoin('tbl_member_type as type','type.id','=','tbl_specialty_board.member_type_applied_id')
                                ->where('tbl_specialty_board.is_active',true)
                                ->where('tbl_specialty_board.pps_no',auth()->user()->pps_no)
                                ->orderBy('tbl_specialty_board','DESC')
                                ->paginate(10);

        return view('specialty-board.view',compact('member_info','price_list','specialty_board'));

    }

    public function updateProfile()
    {

        $nationality = Nationality::where('tbl_nationality.is_active',true)
        ->orderBy('tbl_nationality.nationality_name', 'ASC')
        ->get();

        $cpdpointsevent = CPDPoints::select('tbl_cpd_points.*','topic.topic_name'
                                    )
                                    ->join('tbl_event_topic as topic','topic.id','=','tbl_cpd_points.item_id')
                                    ->where('tbl_cpd_points.is_active',true)
                                    ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
                                    ->where('topic.with_examination',true)
                                    ->where(function($query) {
                                        $query->whereNull('topic.is_plenary')
                                              ->orWhere('topic.is_plenary', false);
                                    })
                                    ->orderBy('tbl_cpd_points.id','DESC')
                                    ->get();

        $cpdpointsum = CPDPoints::join('tbl_event_topic as topic','topic.id','=','tbl_cpd_points.item_id')
                                    ->where('tbl_cpd_points.is_active',true)
                                    ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
                                    ->where('topic.with_examination',true)
                                    ->where(function($query) {
                                        $query->whereNull('topic.is_plenary')
                                              ->orWhere('topic.is_plenary', false);
                                    })
                                    ->sum('tbl_cpd_points.points');


        $currentYear = date('Y');
        $startYear = 1900;
        $years = range($currentYear, $startYear);


        $member_info = MemberInfo::select('tbl_member_info.*','nat.nationality_name',
                                            'type.member_type_name','chapter.chapter_name',
                                            'ins.institution as ins_institution',
                                            'ins.date_started as ins_date_started',
                                            'ins.date_ended as ins_date_ended',
                                            'ins.department_chair as ins_department_chair',
                                            'sub.subspecialty','sub.sub_institution',
                                            'sub.sub_section_chief','sub.sub_date_started',
                                            'sub.sub_date_ended',
                                            'academic.academic_degree','academic.academic_institution',
                                            'academic.academic_dean','academic.academic_date_started','academic.academic_date_ended',
                                            'research.research_title','research.research_authorship','research.research_publication_status',
                                            'research.research_year')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->leftjoin('tbl_nationality as nat','nat.id','=','tbl_member_info.nationality')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_member_info.member_chapter')
        ->leftJoin('tbl_member_institution as ins','ins.pps_no','=','tbl_member_info.pps_no')
        ->leftJoin('tbl_member_subspecialty_training as sub','sub.pps_no','=','tbl_member_info.pps_no')
        ->leftJoin('tbl_member_academic_degree as academic','academic.pps_no','=','tbl_member_info.pps_no')
        ->leftJoin('tbl_member_research_works as research','research.pps_no','=','tbl_member_info.pps_no')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();



        $selectedYearResearch = $member_info->research_year;
        $selectedYear = $member_info->medical_school_year;

        return view('specialty-board.update-profile',compact('member_info','nationality','years','selectedYear','selectedYearResearch','cpdpointsevent','cpdpointsum'));
    }

    public function updateSubmit(Request $request)
    {

        $full_name = strtoupper($request->first_name) .' '.strtoupper($request->last_name);

        $user = User::where('pps_no',auth()->user()->pps_no)
                      ->first();
        $user->updated_by = auth()->user()->name;
        $user->name = $full_name;
        $user->email = $request->email_address;
        $user->save();


        $member = MemberInfo::where('pps_no', auth()->user()->pps_no)
        ->first();

        $member->updated_by = auth()->user()->name;
        $member->first_name = strtoupper($request->first_name);
        $member->middle_name = strtoupper($request->middle_name);
        $member->last_name = strtoupper($request->last_name);
        $member->suffix = strtoupper($request->suffix);
        $member->gender = $request->gender;
        $member->birthdate = $request->birthdate;
        $member->nationality = $request->nationality;
        $member->civil_status = $request->civil_status;
        $member->prc_number = $request->prc_number;
        $member->address = $request->address;
        $member->country_code = $request->country_code;
        $member->mobile_number = $request->mobile_number;
        $member->email_address = $request->email_address;
        $member->medical_school = $request->medical_school;
        $member->medical_school_year = $request->medical_school_year;
        $member->completed_profile = true;

        $member->save();

        $countInstitution = MemberInstitution::where('is_active',true)
                                            ->where('pps_no',auth()->user()->pps_no)
                                            ->count();

        $InsdateStarted = Carbon::parse($request->ins_date_started)->startOfMonth();
        $InsdateEnded = Carbon::parse($request->ins_date_ended)->startOfMonth();

        if($countInstitution >= 1)
        {
            $member_institution_update = MemberInstitution::where('pps_no',auth()->user()->pps_no)->first();
            $member_institution_update->updated_by = auth()->user()->name;
            $member_institution_update->institution = strtoupper($request->institution);
            $member_institution_update->date_started = $InsdateStarted;
            $member_institution_update->date_ended = $InsdateEnded;
            $member_institution_update->department_chair = strtoupper($request->ins_department_chair);

            $member_institution_update->save();
        }
        else
        {
            $member_institution = new MemberInstitution();
            $member_institution->created_by = auth()->user()->name;
            $member_institution->is_active = true;
            $member_institution->pps_no = auth()->user()->pps_no;
            $member_institution->institution = strtoupper($request->institution);
            $member_institution->date_started = $InsdateStarted;
            $member_institution->date_ended = $InsdateEnded;
            $member_institution->department_chair = strtoupper($request->ins_department_chair);


            $member_institution->save();
        }



        $countSubspecialty = MemberSubspecialty::where('is_active',true)
                                            ->where('pps_no',auth()->user()->pps_no)
                                            ->count();

        $SubdateStarted = Carbon::parse($request->sub_date_started)->startOfMonth();
        $SubdateEnded = Carbon::parse($request->sub_date_ended)->startOfMonth();

        if($countSubspecialty >= 1)
        {
            $member_subspecialty_update = MemberSubspecialty::where('pps_no',auth()->user()->pps_no)->first();

            $member_subspecialty_update->updated_by = auth()->user()->name;
            $member_subspecialty_update->subspecialty = strtoupper($request->subspecialty);
            $member_subspecialty_update->sub_institution = strtoupper($request->sub_institution);
            $member_subspecialty_update->sub_date_started = $SubdateStarted;
            $member_subspecialty_update->sub_date_ended = $SubdateEnded;
            $member_subspecialty_update->sub_section_chief = strtoupper($request->sub_section_chief);

            $member_subspecialty_update->save();
        }

        else
        {
            $member_subspecialty = new MemberSubspecialty();
            $member_subspecialty->created_by = auth()->user()->name;
            $member_subspecialty->is_active = true;
            $member_subspecialty->pps_no = auth()->user()->pps_no;
            $member_subspecialty->subspecialty = strtoupper($request->subspecialty);
            $member_subspecialty->sub_institution = strtoupper($request->sub_institution);
            $member_subspecialty->sub_date_started = $SubdateStarted;
            $member_subspecialty->sub_date_ended = $SubdateEnded;
            $member_subspecialty->sub_section_chief = strtoupper($request->sub_section_chief);



            $member_subspecialty->save();
        }


        $countAcademic = MemberAcademicDegree::where('is_active',true)
                                            ->where('pps_no',auth()->user()->pps_no)
                                            ->count();


        $AcademicdateStarted = Carbon::parse($request->academic_date_started)->startOfMonth();
        $AcademicdateEnded = Carbon::parse($request->academic_date_ended)->startOfMonth();

        if($countAcademic >= 1)
        {
            $member_academic_update = MemberAcademicDegree::where('pps_no',auth()->user()->pps_no)->first();
            $member_academic_update->updated_by = auth()->user()->name;
            $member_academic_update->academic_degree = strtoupper($request->academic_degree);
            $member_academic_update->academic_institution = strtoupper($request->academic_institution);
            $member_academic_update->academic_date_started = $AcademicdateStarted;
            $member_academic_update->academic_date_ended = $AcademicdateEnded;
            $member_academic_update->academic_dean = strtoupper($request->academic_dean);

            $member_academic_update->save();
        }

        else
        {
            $member_academic = new MemberAcademicDegree();
            $member_academic->created_by = auth()->user()->name;
            $member_academic->is_active = true;
            $member_academic->pps_no = auth()->user()->pps_no;
            $member_academic->academic_degree = strtoupper($request->academic_degree);
            $member_academic->academic_institution = strtoupper($request->academic_institution);
            $member_academic->academic_date_started = $AcademicdateStarted;
            $member_academic->academic_date_ended = $AcademicdateEnded;
            $member_academic->academic_dean = strtoupper($request->academic_dean);


            $member_academic->save();
        }



        $countResearch = MemberResearch::where('is_active',true)
                                            ->where('pps_no',auth()->user()->pps_no)
                                            ->count();

        if($countResearch >= 1)
        {
            $member_research_update = MemberResearch::where('pps_no',auth()->user()->pps_no)->first();
            $member_research_update->updated_by = auth()->user()->name;
            $member_research_update->research_title = strtoupper($request->research_title);
            $member_research_update->research_authorship = strtoupper($request->research_authorship);
            $member_research_update->research_publication_status = strtoupper($request->research_publication_status);
            $member_research_update->research_year = $request->research_publication_year;

            $member_research_update->save();

        }
        else
        {
            $member_research = new MemberResearch();
            $member_research->created_by = auth()->user()->name;
            $member_research->is_active = true;
            $member_research->pps_no = auth()->user()->pps_no;
            $member_research->research_title = strtoupper($request->research_title);
            $member_research->research_authorship = strtoupper($request->research_authorship);
            $member_research->research_publication_status = strtoupper($request->research_publication_status);
            $member_research->research_year = $request->research_publication_year;


            $member_research->save();
        }



        return "success";
    }

    public function paymentDetails($id)
    {

        $ids =  Crypt::decrypt($id);

        $price_list = PriceList::select('tbl_price_list.*')
        ->where('tbl_price_list.id',$ids)
        ->where('tbl_price_list.is_active',true)
        ->first();

        $member_info = MemberInfo::select('tbl_member_info.*','nat.nationality_name','type.member_type_name','chapter.chapter_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->leftjoin('tbl_nationality as nat','nat.id','=','tbl_member_info.nationality')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_member_info.member_chapter')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();


        return view('specialty-board.payment',compact('price_list','member_info'));
    }


    public function specialtyBoardPaymentOnline(Request $request)
    {

        if($request->payment_type == 'gcash')
        {
            $amount = $request->price * 1.030 . '00';
        }
        else
        {
            $amount = ($request->price * 1.040) + 15 . '00';
        }

        $success_url = $this->pps_url.'success-specialty-board-payment-online/'.$request->price.'/'.$request->pps_no.'/'.$request->pricelist_id;
        $failed_url = $this->pps_url;

        $total = (float) $amount;


            $description = 'SPECIALTY BOARD ('. $request->type_description . ')';
        //     if($request->member_type_name == 'FOREIGN DELEGATE')
        //     {
        //         $name = $request->event_title . ' ( $ '. $request->price .' .00 )';
        //         Session::put('dollar_rate',$response_convert->conversion_rates->PHP);
        //         Session::put('dollar_conversion',$peso);
        //     }
        //     else
        //     {
        //         $name = $request->event_title;
        //     }

            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'email' => $request->email_adddress,
                            'name' => $request->customer_name

                        ],
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $total,
                                'description' => 'SPECIALTY BOARD',
                                'name'  =>  $description,
                                'quantity'  =>  1,


                            ],

                    ],
                    'payment_method_types' => [
                        $request->payment_type

                    ],
                        'success_url'   =>  $success_url,
                        'cancel_url'    =>  $this->pps_url,
                        'description'   =>  'SPECIALTY BOARD',
                        'send_email_receipt' => true
                    ],

                ]
            ];
            $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                            ->withHeader('Content-Type: application/json')
                            ->withHeader('accept: application/json')
                            ->withHeader('Idempotency-Key: ' . Str::uuid())
                            ->withHeader('Authorization: Basic ' . PaymongoConfig::key())
                            ->withData($data)
                            ->asJson()
                            ->post();


                Session::put('session_payment_id',$response->data->id);


            return redirect()->to($response->data->attributes->checkout_url);

    }


    public function successSpecialtyBoardOnlinePayment($price,$pps_no,$pricelist_id)
    {
        $session_payment_id = Session::get('session_payment_id');

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$session_payment_id)
                        ->withHeader('accept: application/json')
                            ->withHeader('Idempotency-Key: ' . Str::uuid())
                        ->withHeader('Authorization: Basic ' . PaymongoConfig::key())
                        ->asJson()
                        ->get();

        $price_list = PriceList::where('id',$pricelist_id)->first();
        $member_type = MemberType::where('member_type_name',$price_list->type_description)->first();


        $specialty_board = new SpecialtyBoard();
        $specialty_board->created_by = auth()->user()->name;
        $specialty_board->is_active = true;
        $specialty_board->status = "FOR APPROVAL";
        $specialty_board->pps_no = $pps_no;
        $specialty_board->member_type_applied_id = $member_type->id;
        $specialty_board->is_paid = true;
        $specialty_board->no_of_takes = 1;

        $specialty_board->save();

        $transaction_id = $specialty_board->id;


        $ormaster = new ORMaster();
        $ormaster->is_active = true;
        $ormaster->created_by = auth()->user()->name;
        $ormaster->transaction_type = 'SPECIALTY BOARD';
        $ormaster->transaction_id = $transaction_id;
        $ormaster->total_amount = $price;
        $ormaster->pps_no = $pps_no;
        $ormaster->payment_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
        $ormaster->check_out_sessions_id = $session_payment_id;
        $ormaster->payment_mode = $response->data->attributes->payment_method_used;

        $ormaster->save();
        $or_id = $ormaster->id;

        $specialtyBoardTransaction = SpecialtyBoard::where('id',$transaction_id)->first();
        $specialtyBoardTransaction->updated_by = auth()->user()->name;;
        $specialtyBoardTransaction->or_master_id = $or_id;

        $specialtyBoardTransaction->save();

        session()->forget('session_payment_id');


        return redirect('specialty-board-view')->withStatus('success');

    }


    public function adminView()
    {

        $specialty_board = SpecialtyBoard::select('member.first_name','member.middle_name','member.last_name','member.prc_number')
            ->leftJoin('tbl_member_info as member','member.pps_no','=','tbl_specialty_board.pps_no')
            ->where('tbl_specialty_board.is_active',true)
            ->paginate(10);

        return view('specialty-board.view-admin',compact('specialty_board'));
    }


    public function adminExport()
    {
        $member_type = MemberType::select('tbl_member_type.*')
            ->where('tbl_member_type.is_active',true)
            ->orderBy('tbl_member_type.member_type_name','ASC')
            ->get();

        $chapter = Chapter::select('tbl_chapter.*')
            ->where('tbl_chapter.is_active',true)
            ->orderBy('tbl_chapter.chapter_name','ASC')
            ->get();

        return view('specialty-board.export-admin',compact('chapter','member_type'));
    }

    public function adminGenerateExportReport(Request $request)
    {
        $this->authorize('manage-items', User::class);

        return Excel::download(new SpecialtyBoardExport($request->member_chapter,$request->member_type), 'specialty-board-data.xlsx');

    }


}


