<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\MemberInfo;
use App\Models\MemberSchool;
use App\Models\MemberTraining;
use App\Models\MemberSubspecialty;
use App\Models\Login;
use App\Models\MaintenanceEmail;
use App\Models\MemberAcademicDegree;
use App\Models\MemberTeachingExperience;
use App\Models\MemberResearch;
use App\Models\MemberType;
use App\Models\Chapter;
use App\Models\User;
use App\Jobs\RegistrationEmail;
use App\Jobs\AcceptApplicantJob;
use App\Jobs\DisapproveApplicantJob;
use App\Models\MemberReclassification;
use App\Support\ImageUploader;

use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use function PHPUnit\Framework\isNull;



class MemberInfoController extends Controller
{
    /** @var ImageUploader */
    protected $imageUploader;

    public function __construct(ImageUploader $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    public function updateMemberNewInfoView($encodedPPSNo)
    {
        $member = MemberInfo::select('tbl_member_info.*','type.id as mem_type_id')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();



        return view('members.member-new-update-profile',compact('member'));

    }


    public function updateMemberNewInfoSubmit(Request $request)
    {
        $member = MemberInfo::select('tbl_member_info.*','type.id as mem_type_id')
            ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
            ->where('tbl_member_info.pps_no', auth()->user()->pps_no)
            ->first();

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        $member->tin_number = $request->tin_number;
        $member->house_number = $request->house_number;
        $member->street_name = $request->street_name;
        $member->barangay_name = $request->barangay_name;
        $member->city_name = $request->city_name;
        $member->province_name = $request->province_name;
        $member->postal_code = $request->postal_code;


        $member->barangay_id = $request->barangay_id;
        $member->city_id = $request->city_id;
        $member->province_id = $request->province_id;
        $member->region_id = $request->region_id;
  
        $member->country_name  = $request->country_text;  // ISO2 code (PH, US, etc.)
        $member->country_text  = $request->country_name;  // Full country name

        $member->second_completed_profile  = true;
        $member->save();

        return response()->json([
            'message' => 'saved!'
        ]);
    }




    public function saveApplicantMember(Request $request)
    {
        try {
            $checkexist = MemberInfo::where('is_active', true)
                ->where('email_address', 'ilike', $request->email_address)
                ->count();

            $checkexistPRC = MemberInfo::where('is_active', true)
                ->where('prc_number', trim($request->prc_number))
                ->count();

            if ($checkexist >= 1) {
                return response()->json([
                    "success" => false,
                    "message" => "You have an existing application or you are already a member!"
                ], 409); // 409 Conflict
            }

            // Continue with saving logic
            $notFormattedBirthday = $request->birthmonth . ' ' . $request->birthdate . ', ' . $request->birthyear;
            $birthday = date("Y-m-d", strtotime($notFormattedBirthday));

            $member = new MemberInfo();

            if ($request->hasFile('picture')) {
                $member->picture = $this->imageUploader->upload($request->file('picture'), 'applicant');
            }

            if ($request->hasFile('front_id_image')) {
                $member->front_id_image = $this->imageUploader->upload($request->file('front_id_image'), 'applicant');
            }
    
            if ($request->hasFile('back_id_image')) {
                $member->back_id_image = $this->imageUploader->upload($request->file('back_id_image'), 'applicant');
            }
    
            if ($request->hasFile('residency_certificate')) {
                $member->residency_certificate = $this->imageUploader->upload($request->file('residency_certificate'), 'applicant');
            }
    
            
            if ($request->hasFile('government_physician_certificate')) {
                $member->government_physician_certificate = $this->imageUploader->upload($request->file('government_physician_certificate'), 'applicant');
            }

            if ($request->hasFile('fellows_in_training_certificate')) {
                $member->fellows_in_training_certificate = $this->imageUploader->upload($request->file('fellows_in_training_certificate'), 'applicant');
            }
    
            if ($request->hasFile('identification_card')) {
                $member->identification_card = $this->imageUploader->upload($request->file('identification_card'), 'applicant');
            }
            

            $member->status = 'PENDING';
            $member->applied_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
            $member->is_active = true;
            $member->type = 'APPLICANT';
            $member->first_name = strtoupper($request->first_name);
            $member->middle_name = strtoupper($request->middle_name);
            $member->last_name = strtoupper($request->last_name);
            $member->suffix = strtoupper($request->suffix);
            $member->birthdate = $birthday;
            $member->country_code = $request->country_code;
            $member->mobile_number = $request->mobile_number;
            $member->telephone_number = $request->telephone_number;
            $member->email_address = $request->email_address;
            $member->prc_number = $request->prc_number;
            $member->prc_registration_dt = $request->prc_registration_dt;
            $member->prc_validity = $request->prc_validity;
            $member->pma_number = $request->pma_number;
            $member->applicant_type = $request->applicant_type;
            $member->is_foreign = $request->foreign_national;
            $member->save();

            $last_insert = $member->id;
            $pps_no = date("Ymd") . '' . $last_insert;

            $update = MemberInfo::where('id', $last_insert)->first();
            $update->pps_no = $pps_no;
            $update->save();

            RegistrationEmail::dispatch($request->email_address, $request->first_name, $request->last_name);

            return response()->json([
                "success" => true,
                "url" => url('/')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "An error occurred: " . $e->getMessage()
            ], 500); 
        }
    }



    public function checkPRCNo(Request $request)
    {
        $checkprc = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',$request->prc_number)
        ->count();


        return $checkprc;
     
    }

    public function applicantListing()
    {
        $name = null;

        $applicantList = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.type','APPLICANT')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','PENDING')
        ->orderBy('tbl_member_info.created_at', 'DESC')
        ->paginate(10);


        return view('applicants.listing',compact('applicantList','name'));
     
    }


    public function applicantListingSearch(Request $request)
    {
        $name = $request->input('searchinput');

        $applicantList = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.type','APPLICANT')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','PENDING')
        ->where(function($query) use ($name) {
            $query
                  ->orWhere('tbl_member_info.first_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.middle_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.last_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.prc_number', 'ILIKE', "%$name%");                             
        })
        ->orderBy('tbl_member_info.created_at', 'DESC')
        ->paginate(10);


        return view('applicants.listing',compact('applicantList','name'));
     
    }

    public function applicantProfile($pps_no)
    {
        $pps_no = Crypt::decrypt($pps_no);

        $applicantInfo = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.type','APPLICANT')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',$pps_no)
        ->first();  

        $member_type = MemberType::select('tbl_member_type.*')
        ->where('tbl_member_type.is_active',true)
        ->orderBy('tbl_member_type.member_type_name','ASC')
        ->get();

        $chapter = Chapter::select('tbl_chapter.*')
        ->where('tbl_chapter.is_active',true)
        ->orderBy('tbl_chapter.chapter_name','ASC')
        ->get();
     

        return view('applicants.profile',compact('applicantInfo','member_type','chapter'));

    }

    public function sendEmail(Request $request)
    {

        if($this->isOnline()){
            $mail_data = [
                'recipient' => 'ricky.gacesp061296@gmail.com',
                'fromEmail' => 'no-reply@pps.org.ph',
                'fromName' => $request->name,
                'subject' => $request->subject,
                'body' => $request->message
            ];
            \Mail::send('applicants.email-template',$mail_data, function($message) use ($mail_data){
                $message->to($mail_data['recipient'])
                        ->from($mail_data['fromEmail'], $mail_data['fromName'])
                        ->subject($mail_data['subject']);
            });
            return redirect()->back()->with('success','Email Sent');
        }
        else
        {
            return redirect()->back()->with('error','Email not sent');
        }
     
    }

    public function isOnline($site = "https://youtube.com/")
    {
        if(@fopen($site, "r"))
        {
            return true;
        }
        else{
            return false;
        }
    }


    public function saveMember(Request $request)
    {
        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.pps_no',$request->pps_no)
        ->first();
        dd($member);

    }


    public function checkEmail(Request $request)
    {
        $email = Login::select('users.*')
        ->where('users.email',$request->email)
        ->count();

        return $email;
     
    }

    public function acceptApplicant2(Request $request)
    {
               
            $hashedPassword = Hash::make($request->password);
            $applicant = new Login();
            $applicant->is_active = true;
            $applicant->temporary_member = true;
            $applicant->created_by = auth()->user()->name;
    
            $applicant->name = $request->first_name.' '.$request->last_name;
            $applicant->email = $request->email_address;
            $applicant->role_id = 3;
            $applicant->password = $hashedPassword;
            $applicant->default_password = true;
            $applicant->picture = $request->picture;
            $applicant->pps_no = $request->pps_no;
            
            $applicant->save();


    
            $member = MemberInfo::select('tbl_member_info.*')
            ->where('tbl_member_info.pps_no',$request->pps_no)
            ->first();
    
            $member->status = 'ACCEPTED';
            $member->type = 'MEMBER';
            $member->member_approve_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');

            $member->member_type = $request->member_type;

            $member->updated_by = auth()->user()->name;
            $member->save();




            AcceptApplicantJob::dispatch($request->email_address,$request->first_name,$request->last_name,$request->member_type);

        return Response()->json([
            "success" => true,
            "url"=>url('/applicant-listing')
           
      ]);


    }


    
    public function acceptApplicant(Request $request)
    {
        $countUser = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.pps_no',$request->pps_no)
        ->count();

        if($countUser >= 1)
        {            
            $member = MemberInfo::select('tbl_member_info.*')
            ->where('tbl_member_info.pps_no',$request->pps_no)
            ->first();
    
            $member->type = 'TEMPORARY MEMBER';
            $member->updated_by = auth()->user()->name;
            $member->save();
             
        }

        else
        {

            $hashedPassword = Hash::make($request->password);
            $temporary = new Login();
            $temporary->is_active = true;
            $temporary->temporary_member = true;
            $temporary->temporary_member = false;
            $temporary->created_by = auth()->user()->name;
    
            $temporary->name = $request->first_name.' '.$request->last_name;
            $temporary->email = $request->email;
            $temporary->role_id = 3;
            $temporary->password = $hashedPassword;
            $temporary->picture = $request->picture;
            $temporary->pps_no = $request->pps_no;
            $temporary->save();


    
            $member = MemberInfo::select('tbl_member_info.*')
            ->where('tbl_member_info.pps_no',$request->pps_no)
            ->first();
    
            $member->type = 'TEMPORARY MEMBER';
            $member->updated_by = auth()->user()->name;
            $member->save();

        }


        $emaiPPS = MaintenanceEmail::where('tbl_pps_email.is_active',true)
        ->where('status','PRIMARY')
        ->pluck('pps_email')->first();

        $message = '';

            $mail_data = [
                'recipient' => $request->email,
                'fromEmail' => 'no-reply@pps.org.ph',
                'fromName' => 'Philippine Pediatric Society Inc.',
                'subject' => 'Member Application',
                'body' => $message,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'applicant_email' => $request->email,
            ];
            \Mail::send('applicants.email-template-accept',$mail_data, function($message) use ($mail_data){
                $message->to($mail_data['recipient'])
                        ->from($mail_data['fromEmail'], $mail_data['fromName'])
                        ->subject($mail_data['subject']);
            });
        

       
        
       
        return redirect('applicant-listing')->withStatus($request->first_name . ' ' . $request->last_name .' SUCCESSFULLY ADDED AS TEMPORARY MEMBER.');
    }

    public function applicantDisapprove(Request $request)
    {
        

        DisapproveApplicantJob::dispatch($request->email_address,$request->first_name,$request->last_name,$request->disapprove_reason,$request->disapprove_by);


        $disapprove = MemberInfo::where('pps_no',$request->pps_no)
        ->where('type','APPLICANT')
        ->where('status','PENDING')
        ->where('is_active',true)->delete();

        // $disapprove_by = auth()->user()->name;

        // $disapprove = MemberInfo::where('pps_no',$request    ->pps_no)
        //                             ->where('type','APPLICANT')
        //                             ->where('status','PENDING')
        //                             ->where('is_active',true)->first();

        // $disapprove->disapprove_reason = $request->disapprove_reason;
        // $disapprove->status = 'DISAPPROVE';
        // $disapprove->disapprove_by = $disapprove_by;
        // $disapprove->save();

        return Response()->json([
            "success" => true,
            "url"=>url('/applicant-listing')
      ]);
    }


    public function applicantDelete(Request $request)
    {
        $disapprove = MemberInfo::where('id',$request->id)->delete();

        return "success";
    }

    
    public function memberListing()
    {

        $chapter = Chapter::select('tbl_chapter.*',
            DB::raw("(select count(*) from tbl_member_info where member_chapter = tbl_chapter.id and is_active = true) as member_count"))
        ->orderBy('tbl_chapter.chapter_name','ASC')
        ->get();

        return view('members.listing',compact('chapter'));
    }




    public function memberListingAll()
    {
        $name = "";
        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name','chapter.chapter_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_member_info.member_chapter')
        ->where('tbl_member_info.status','!=','PENDING')
        ->paginate(10);
 
        return view('members.member-listing',compact('member','name'));
    }

    public function memberSearchListingAll(Request $request)
    {

        $name = $request->input('searchinput');

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name','chapter.chapter_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_member_info.member_chapter')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where(function($query) use ($name) {
            $query
                  ->orWhere('tbl_member_info.first_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.middle_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.last_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.prc_number', 'ILIKE', "%$name%");                             
        })
        ->paginate(10);

        return view('members.member-listing',compact('member','name'));
  

    }


    public function memberInfo($pps_no)
    {
        $pps_no = Crypt::decrypt($pps_no);

        $member_info = MemberInfo::select(
                'tbl_member_info.*',
                'type.member_type_name',
                'classification.description as classification_name',
                'chapter.chapter_name'
            )
            ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
            ->leftJoin('tbl_member_classification_vip as classification','classification.id','=','tbl_member_info.member_classification_id')
            ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_member_info.member_chapter')
            ->where('tbl_member_info.status','!=','PENDING')
            ->where('tbl_member_info.pps_no',$pps_no)
            ->first();  
        
 
        return view('members.member-info',compact('member_info'));
    }


    public function memberListingChapter($id)
    {
        $ids = Crypt::decrypt($id);
        $name = "";

        $chapter = Chapter::select('tbl_chapter.*')
        ->where('id',$ids)
        ->first();

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name','chapter.chapter_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_member_info.member_chapter')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->paginate(10);  

        $diplomate_count = MemberInfo::
        leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where('tbl_member_info.is_active',true)
        ->where('type.member_type_name','DIPLOMATE')
        ->count(); 

        $fellow_count = MemberInfo::
        leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where('tbl_member_info.is_active',true)
        ->where('type.member_type_name','FELLOW')
        ->count(); 

        $emeritus_fellow = MemberInfo::
        leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where('tbl_member_info.is_active',true)
        ->where('type.member_type_name','EMERITUS FELLOW')
        ->count(); 

        $vip = MemberInfo::
        leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.vip',true)
        ->count(); 
 

        
        return view('members.member-listing-chapter',compact('chapter','member','diplomate_count','fellow_count','emeritus_fellow','vip','ids','name'));
    }

    public function memberSearchListingChapter(Request $request)
    {
        $ids = $request->ids;
        $name = $request->input('searchinput');

        $chapter = Chapter::select('tbl_chapter.*')
        ->where('id',$ids)
        ->first();

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name','chapter.chapter_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_member_info.member_chapter')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where(function($query) use ($name) {
            $query
                  ->orWhere('tbl_member_info.first_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.middle_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.last_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.prc_number', 'ILIKE', "%$name%");                             
        })
        ->paginate(10);  

        $diplomate_count = MemberInfo::
        leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where('tbl_member_info.is_active',true)
        ->where('type.member_type_name','DIPLOMATE')
        ->count(); 

        $fellow_count = MemberInfo::
        leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where('tbl_member_info.is_active',true)
        ->where('type.member_type_name','FELLOW')
        ->count(); 

        $emeritus_fellow = MemberInfo::
        leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where('tbl_member_info.is_active',true)
        ->where('type.member_type_name','EMERITUS FELLOW')
        ->count(); 

        $vip = MemberInfo::
        leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.member_chapter',$ids)
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.vip',true)
        ->count(); 
 
        return view('members.member-listing-chapter',compact('chapter','member','diplomate_count','fellow_count','emeritus_fellow','vip','ids','name'));

    }


    public function memberInfoUpdate($pps_no)
    {
        $pps = Crypt::decrypt($pps_no);


        
        $userInfo = User::select('users.*','roles.name as roles_name','role_id',
                                 'info.first_name','info.middle_name','info.last_name','info.suffix',
                                 'info.picture','info.gender','info.telephone_number','info.country_code',
                                 'info.member_chapter','info.member_type','info.member_classification_id',
                                 'info.pps_no','info.birthdate','info.mobile_number','info.email_address',
                                 'info.prc_number','info.prc_registration_dt','info.prc_validity','info.pma_number',
                                 'info.front_id_image','info.back_id_image','info.id as infoids','info.tin_number',
                                 'info.house_number','info.street_name','info.region_id','info.province_id',
                                 'info.city_id','info.barangay_id','info.postal_code',
                                 'chapter.chapter_name',
                                 'type.member_type_name',
                                 'classification.description',
                                 'roles.name as rolesname')
        ->leftJoin('tbl_member_info as info','info.pps_no','=','users.pps_no')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','info.member_chapter')
        ->leftJoin('tbl_member_type as type','type.id','=','info.member_type')
        ->leftJoin('tbl_member_classification_vip as classification','classification.id','=','info.member_classification_id')
        ->leftJoin('roles','roles.id','=','users.role_id')
        ->where('users.pps_no',$pps)
        ->first();

        $chapter = Chapter::select('tbl_chapter.*')
        ->where('tbl_chapter.is_active',true)
        ->orderBy('tbl_chapter.chapter_name','ASC')
        ->get();
        
    
        return view('members.member-update',compact('userInfo','chapter'));
    }

    public function memberInfoUpdateSubmit(Request $request)
    {

        $email_count = User::where('email',$request->email_address)
                    ->where('id','!=',$request->user_id)
                    ->count();

        if($email_count >= 1)
        {
            return "exist";
        }            
        else
        {
            
            $member = MemberInfo::where('id',$request->id)->first();

            if($request->hasFile('picture')) 
            {
                $member->picture = $this->imageUploader->upload($request->file('picture'), 'applicant');
            }


            $member->first_name = $request->first_name;
            $member->middle_name = $request->middle_name;
            $member->last_name = $request->last_name;
            $member->suffix = $request->suffix;
            $member->birthdate = $request->birthdate;
            $member->gender = $request->gender;
            $member->telephone_number = $request->telephone_number;
            $member->country_code = $request->country_code;
            $member->mobile_number = $request->mobile_number;
            $member->email_address = $request->email_address;
            $member->prc_number = $request->prc_number;
            $member->prc_registration_dt = $request->prc_registration_dt;
            $member->prc_validity = $request->prc_validity;
            $member->pma_number = $request->pma_number;
            $member->member_chapter = $request->member_chapter;
            $member->vip = $request->has('vip');
            $member->vip_description = $request->vip_description;

            $member->tin_number = $request->tin_number;
            $member->house_number = $request->house_number;
            $member->street_name = $request->street_name;
            $member->region_id = $request->region_id;
            $member->province_id = $request->province_id;
            $member->province_name = $request->province_name;
            $member->city_id = $request->city_id;
            $member->city_name = $request->city_name;
            $member->barangay_id = $request->barangay_id;
            $member->barangay_name = $request->barangay_name;
            $member->postal_code = $request->postal_code;
            
  
            $member->country_name  = $request->country_text;  // ISO2 code (PH, US, etc.)
            $member->country_text  = $request->country_name;  // Full country name



            $member->save();
    
    
            $user = User::where('id',$request->user_id)->first();
            if($request->hasFile('picture')) 
            {
                $user->picture = $this->imageUploader->upload($request->file('picture'), 'applicant');
            }

            
            $user->name = $request->first_name .' '. $request->middle_name .' '. $request->last_name . ' ' . $request->suffix;
            $user->email = $request->email_address;
            $user->save();
    
            return "success";
        }

                    
    


    }
 

    public function checkMemberExist(Request $request)
    {
        $pps_no = $request->input('pps_no');
        $checkMemberExist = MemberInfo::where('is_active', true)
            ->where('pps_no', $pps_no)
            ->count();

        return $checkMemberExist;
    }


    public function checkMemberExistViaPRC(Request $request)
    {
        $prc_no = $request->input('prc_no');
        $checkMemberExist = MemberInfo::where('is_active', true)
            ->where('prc_number', $prc_no)
            ->count();

        return $checkMemberExist;
    }



    public function memberReclassification()
    {
        $reclassificationList = MemberReclassification::select('tbl_member_reclassification.*',
                                                               'meminfo.first_name','meminfo.middle_name','meminfo.last_name','meminfo.suffix',
                                                               'meminfo.picture','meminfo.prc_number',
                                                               'type.member_type_name')
                                    ->leftJoin('tbl_member_info as meminfo','meminfo.pps_no','=','tbl_member_reclassification.pps_no')
                                    ->leftJoin('tbl_member_type as type','type.id','=','meminfo.member_type')
                                    ->where('tbl_member_reclassification.is_active',true)
                                    ->where('tbl_member_reclassification.status','PENDING')
                                    ->orderBy('tbl_member_reclassification.id', 'ASC')
                                    ->paginate(10);

                                    $name ="";

        return view('members.member-reclassification-list',compact('reclassificationList','name'));
    }

    public function memberReclassificationSearch(Request $request)
    {
        $name = $request->input('searchinput');

        $reclassificationList = MemberReclassification::select('tbl_member_reclassification.*',
                                                               'meminfo.first_name','meminfo.middle_name','meminfo.last_name','meminfo.suffix',
                                                               'meminfo.picture','meminfo.prc_number',
                                                               'type.member_type_name')
                                    ->leftJoin('tbl_member_info as meminfo','meminfo.pps_no','=','tbl_member_reclassification.pps_no')
                                    ->leftJoin('tbl_member_type as type','type.id','=','meminfo.member_type')
                                    ->where('tbl_member_reclassification.is_active',true)
                                    ->where('tbl_member_reclassification.status','PENDING')
                                    ->where(function($query) use ($name) {
                                        $query
                                              ->orWhere('meminfo.first_name', 'ILIKE', "%$name%")
                                              ->orWhere('meminfo.middle_name', 'ILIKE', "%$name%")
                                              ->orWhere('meminfo.last_name', 'ILIKE', "%$name%")
                                              ->orWhere('meminfo.prc_number', 'ILIKE', "%$name%");                             
                                    })
                                    ->orderBy('tbl_member_reclassification.id', 'ASC')
                                    ->paginate(10);

        return view('members.member-reclassification-list',compact('reclassificationList','name'));
    }

    

    public function memberReclassificationView($id)
    {

        $reclassification = MemberReclassification::select('tbl_member_reclassification.*',
                                                        'meminfo.first_name','meminfo.middle_name','meminfo.last_name','meminfo.suffix',
                                                        'meminfo.picture','meminfo.prc_number','meminfo.member_type',
                                                        'type.member_type_name',
                                                        'chapter.chapter_name')
                ->leftJoin('tbl_member_info as meminfo','meminfo.pps_no','=','tbl_member_reclassification.pps_no')
                ->leftJoin('tbl_member_type as type','type.id','=','meminfo.member_type')
                ->leftJoin('tbl_chapter as chapter','chapter.id','=','meminfo.member_chapter')
                ->where('tbl_member_reclassification.is_active',true)
                ->where('tbl_member_reclassification.status','PENDING')
                ->where('tbl_member_reclassification.id', Crypt::decrypt($id))
                ->first();

                
        $member_type = MemberType::select('tbl_member_type.*')
                        ->where('tbl_member_type.is_active',true)
                        ->orderBy('tbl_member_type.member_type_name','ASC')
                        ->get();

        return view('members.member-reclassification-view',compact('reclassification','member_type'));
    }



    



    public function saveMemberReclassification(Request $request)
    {

        $reclassification = MemberReclassification::select('tbl_member_reclassification.*',
                                                        'meminfo.first_name','meminfo.middle_name','meminfo.last_name','meminfo.suffix',
                                                        'meminfo.picture','meminfo.prc_number','meminfo.member_type',
                                                        'type.member_type_name',
                                                        'chapter.chapter_name')
                ->leftJoin('tbl_member_info as meminfo','meminfo.pps_no','=','tbl_member_reclassification.pps_no')
                ->leftJoin('tbl_member_type as type','type.id','=','meminfo.member_type')
                ->leftJoin('tbl_chapter as chapter','chapter.id','=','meminfo.member_chapter')
                ->where('tbl_member_reclassification.is_active',true)
                ->where('tbl_member_reclassification.status','PENDING')
                ->where('tbl_member_reclassification.id', $request->reclassification_id)
                ->first();

            $reclassification->status = 'COMPLETED';
            $reclassification->save();


            $member_info = MemberInfo::select('tbl_member_info.*','type.member_type_name')
                                        ->where('tbl_member_info.is_active',true)
                                        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
                                        ->where('tbl_member_info.pps_no',$reclassification->pps_no)
                                        ->first();

                                       
           if($member_info->member_type_name == 'RESIDENT/TRAINEES')          
           {
            $member_info->residency_certificate = $reclassification->file_name;
           }   
           else if($member_info->member_type_name == 'GOVERNMENT_PHYSICIAN')                
           {
            $member_info->government_physician_certificate = $reclassification->file_name;
           }
           else if($member_info->member_type_name == 'FELLOWS-IN-TRAINING')
           {
            $member_info->fellows_in_training_certificate = $reclassification->file_name;
           }
                    
                
            $member_info->member_type = $request->member_type_id;
            $member_info->updated_by = auth()->user()->name;
            $member_info->save();


        return "success";
    }


    
    
}
