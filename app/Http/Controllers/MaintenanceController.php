<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\HospitalAccredited;
use App\Models\MaintenanceEmail;
use App\Models\User;
use App\Models\Chapter;
use App\Models\MemberType;
use App\Models\ClassificationVIP;
use App\Models\MemberInfo;
use App\Models\MemberReclassification;
use App\Models\Role;
use App\Models\Event;
use App\Models\EventTransaction;

use App\Jobs\SendEmailAnnualConventionJob;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    //

    public function paymentHold()
    {
        return view('errors.payment-hold');
    }

    public function emailMaintenance()
    {

        $emailList = MaintenanceEmail::select('tbl_pps_email.*')
        ->where('tbl_pps_email.is_active',true)
        ->orderBy('status', 'ASC')
        ->paginate(10);

        return view('maintenance.email-maintenance',compact('emailList'));
    }


    public function checkEmailExist(Request $request)
    {
        $pps_email = MaintenanceEmail::where('pps_email',$request->pps_email)
        ->where('is_active',true)
        ->exists();

        return $pps_email;
     
    }

    public function saveEmail(Request $request)
    {
    
        if($request->status == 'PRIMARY')
        {
            // $update_email = MaintenanceEmail::where('is_active',true);
            // $update_email->status = 'NOT USE';
            // $update_email->save();

            MaintenanceEmail::where("is_active", true)
                ->update(["status" => "SECONDARY"]);

            $email = new MaintenanceEmail();
            $email->is_active = true;
            $email->pps_email = $request->pps_email;
            $email->status = 'PRIMARY';
    
            $email->save();
        }

        else
        {
            $email = new MaintenanceEmail();
            $email->is_active = true;
            $email->pps_email = $request->pps_email;
            $email->status = 'SECONDARY';
    
            $email->save();
        }
        


        return redirect('email-maintenance')->withStatus('New email successfully created.');   

    
    }



    public function updateEmail(Request $request)
    {

        $count = MaintenanceEmail::where('status','PRIMARY')->count();

        if($request->status_update == 'PRIMARY')
        {
        MaintenanceEmail::where("is_active", true)
            ->update(["status" => "SECONDARY"]);

        $update_email = MaintenanceEmail::where('id',$request->email_id)->first();
        $update_email->pps_email = $request->pps_email_update;
        $update_email->status = $request->status_update;
        $update_email->updated_by = auth()->user()->name;
        $update_email->save();

        
        }

        else
        {
 
           
            if($count == 0)
            {
                $update_email = MaintenanceEmail::where('id',$request->email_id)->first();
                $update_email->pps_email = $request->pps_email_update;
                $update_email->status = $request->status_update;
                $update_email->updated_by = auth()->user()->name;
                $update_email->save();


                $latest = MaintenanceEmail::where('is_active',true)->orderBy('created_at','DESC')->first();
                $latest->status = 'PRIMARY';
                $latest->save();

            }
            // UPDATE STATUS AS PRIMARY IF THERE IS NO PRIMARY IN THE STATUS COLUMN
            else
            {
                $update_email = MaintenanceEmail::where('id',$request->email_id)->first();
                $update_email->pps_email = $request->pps_email_update;
                $update_email->status = $request->status_update;
                $update_email->updated_by = auth()->user()->name;
                $update_email->save();
            }
        }


        return redirect('email-maintenance')->withStatus('Email updated successfully.');   

    
    }


    public function deleteEmail(Request $request)
    {
        $delete_email = MaintenanceEmail::where('id',$request->delete_id)->first();
        $delete_email->is_active = false;
        $delete_email->updated_by = auth()->user()->name;

        $delete_email->save();

        $count = MaintenanceEmail::where('status','PRIMARY')->count();

        if($count == 0)
            {
            

                $latest = MaintenanceEmail::where('is_active',true)->orderBy('created_at','DESC')->first();
                $latest->status = 'PRIMARY';
                $latest->save();

            }
        


        return redirect('email-maintenance')->withStatus('Email deleted successfully.');   
    }



    public function userMaintenance()
    {
        $name = "";
        $userList = User::select('users.*','roles.name as roles_name',
                                 'info.first_name','info.middle_name','info.last_name','info.picture','info.prc_number',
                                 'classification.description',
                                 'type.member_type_name')
        ->leftJoin('tbl_member_info as info','info.pps_no','=','users.pps_no')
        ->leftJoin('tbl_member_classification_vip as classification','classification.id','=','info.member_classification_id')
        ->leftJoin('tbl_member_type as type','type.id','=','info.member_type')
        ->join('roles','roles.id','=','users.role_id')
        ->orderBy('name', 'ASC')
        ->paginate(10);

        return view('maintenance.user-maintenance',compact('userList','name'));
    }

    public function userSearchUser(Request $request)
    {
        $name = $request->input('searchinput');
        $userList = User::select('users.*','roles.name as roles_name',
                                'info.first_name','info.middle_name','info.last_name','info.picture','info.prc_number',
                                'classification.description',
                                'type.member_type_name')
        ->leftJoin('tbl_member_info as info','info.pps_no','=','users.pps_no')
        ->leftJoin('tbl_member_classification_vip as classification','classification.id','=','info.member_classification_id')
        ->leftJoin('tbl_member_type as type','type.id','=','info.member_type')
        ->join('roles','roles.id','=','users.role_id')
        ->where(function($query) use ($name) {
            $query
                  ->orWhere('info.first_name', 'ILIKE', "%$name%")
                  ->orWhere('info.middle_name', 'ILIKE', "%$name%")
                  ->orWhere('info.last_name', 'ILIKE', "%$name%")
                  ->orWhere('info.prc_number', 'ILIKE', "%$name%")
                  ->orWhere('users.email', 'ILIKE', "%$name%");                             
        })
        ->orderBy('name', 'ASC')
        ->paginate(10);

        return view('maintenance.user-maintenance',compact('userList','name'));
    }
    

    public function userMaintenanceEdit($pps_no)
    {
        $pps_no = Crypt::decrypt($pps_no);

        $chapter = Chapter::where('is_active',true)
        ->orderBy('chapter_name', 'ASC')
        ->get();

        $type = MemberType::where('is_active',true)
        ->orderBy('member_type_name', 'ASC')
        ->get();

        $classification = ClassificationVIP::where('is_active',true)
        ->orderBy('description', 'ASC')
        ->get();



        $role = Role::orderBy('name', 'ASC')
        ->get();

        $userInfo = User::select('users.*','roles.name as roles_name','role_id',
                                 'info.first_name','info.middle_name','info.last_name','info.picture',
                                 'info.gender','info.birthdate','info.telephone_number','info.country_code',
                                 'info.mobile_number','info.email_address','info.prc_number','info.prc_registration_dt',
                                 'info.prc_validity','info.pma_number',
                                 'info.member_chapter','info.member_type','info.member_classification_id',
                                 'info.pps_no','info.front_id_image',
                                 'chapter.chapter_name',
                                 'type.member_type_name',
                                 'classification.description',
                                 'info.is_fellows_in_training',
                                 'roles.name as rolesname')
        ->leftJoin('tbl_member_info as info','info.pps_no','=','users.pps_no')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','info.member_chapter')
        ->leftJoin('tbl_member_type as type','type.id','=','info.member_type')
        ->leftJoin('tbl_member_classification_vip as classification','classification.id','=','info.member_classification_id')
        ->leftJoin('roles','roles.id','=','users.role_id')
        ->where('users.pps_no',$pps_no)
        ->first();
        
        
        return view('maintenance.user-maintenance-edit',compact('userInfo','chapter','type','classification','role'));
    }

    public function updateUserImage(Request $request)
    {
        $member = MemberInfo::where('pps_no',$request->pps_no)
                                 ->first();


        if($request->hasFile('picture')) 
        {
            $file = $request->file('picture');
            $picture = time().'-'. $file->getClientOriginalName();
            $filePath = 'applicant/' . $picture;
    
            $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('picture')));
            $path = Storage::disk('s3')->url($path);

            $member->picture = $picture;
        }                         

        $member->updated_by = auth()->user()->name;  
        $member->save();





        $user = User::where('pps_no',$request->pps_no)->first();
        if($request->hasFile('picture')) 
        {
            $file = $request->file('picture');
            $picture = time().'-'. $file->getClientOriginalName();
            $filePath = 'applicant/' . $picture;
     
            $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('picture')));
            $path = Storage::disk('s3')->url($path);

            $user->picture = $picture;

        }

        $user->save();

        return "success";
    }

    public function updateUser(Request $request)
    {
       
    
        $full_name = strtoupper($request->first_name) .' '.strtoupper($request->last_name) . ' ' .strtoupper($request->suffix);

        $user = User::where('id',$request->user_id)
                      ->first();

        $user->updated_by = auth()->user()->name;
        $user->name = $full_name;
        $user->email = $request->email_address;
        $user->role_id = $request->roles;
        $user->is_active = $request->is_active;

        $user->save();

        if($request->pps_no != null)
        {
            $member = MemberInfo::where('pps_no',$request->pps_no)
                                 ->first();

            $member->updated_by = auth()->user()->name;    
            $member->first_name = strtoupper($request->first_name);
            $member->middle_name = strtoupper($request->middle_name);
            $member->last_name = strtoupper($request->last_name);
            $member->birthdate = $request->birthdate;
            $member->gender = $request->gender;
            $member->telephone_number = $request->telephone_number;
            $member->mobile_number = $request->mobile_number;
            $member->country_code = $request->country_code;
            $member->email_address = $request->email_address;
            $member->prc_number = $request->prc_number;
            $member->prc_registration_dt = $request->prc_registration_dt;
            $member->prc_validity = $request->prc_validity;
            $member->pma_number = $request->pma_number;

            $member->suffix = strtoupper($request->suffix);
            $member->member_chapter = $request->member_chapter;
            $member->member_type = $request->member_type;
            $member->member_classification_id = $request->member_classification;
            $member->is_fellows_in_training = $request->has('fellowintraining');
            $member->save();
        }

    

        return Response()->json([
            "success" => true,
            "url"=>url('/user-maintenance')
           
        ]);

    }

    public function userResetPassword(Request $request)
    {
        $password = "123PPS";
        $hashedPassword = Hash::make($password);

        $user = User::where('id',$request->id)
                      ->first();

        $user->updated_by = auth()->user()->name;         
        $user->password = $password;    
        $user->default_password = true;    

        $user->save();
                      
        return $hashedPassword;

    }


    public function emailUserMaintenance()
    {
        return view('maintenance.user-email-maintenance');
    } 


    public function updateUserEmail(Request $request)
    {
   
        $countExistEmail = User::where('is_active',true)
        ->where('email',$request->email_address)
        ->count();


        if($countExistEmail >= 1)
        {
            return "exist";
        }
        else
        {
            $user = User::where('is_active',true)
            ->where('id',$request->user_id)
            ->first();


            $user->email = $request->email_address;
            $user->save();



            $member = MemberInfo::where('pps_no',$user->pps_no)
            ->first();

            if(empty($member))
            {
                return "success";
               
            }

            else
            {
                $member->email_address = $request->email_address;
                $member->save();
                return "success";
            }

        
    
    
         
        }

       
    } 

    public function sendBulkEmailAnnualConvention(Request $request)
    {

        // SendEmailAnnualConventionJob::dispatch($request->id);

        // return $request->id;
    }

    public function userMaintenanceNewHospital()
    {
        $hospital_list = HospitalAccredited::where('is_active',true)
        ->orderBy('hosp_name','ASC')
        ->get();

       

        return view('maintenance.user-maintenance-new-hospital',compact('hospital_list'));
    }

    public function userMaintenanceNewAttendance()
    {
        return view('maintenance.user-maintenance-new-attendance');
    }


    
    public function userAddNewHospital(Request $request)
    {

        $countExistUsername = User::where('users.email',$request->username)
                    ->count();
        if($countExistUsername >= 1)
        {
            return "existusername";
        }
        else
        {
            $hashedPassword = Hash::make($request->default);

            $hospital_user = new User();
            $hospital_user->is_active = true;
            $hospital_user->created_by = auth()->user()->name;
            $hospital_user->name = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
            $hospital_user->email = $request->username;
            $hospital_user->role_id = 5;
            $hospital_user->password = $hashedPassword;
            $hospital_user->default_password = true;   
            $hospital_user->hospital_id = $request->hospital_id;  
            
            $hospital_user->save();

            User::whereId($hospital_user->id)->update([
                'password' => Hash::make($request->default)
            ]);

            return "saved";
        }


    }


    public function userAddNewAttendance(Request $request)
    {

        $countExistUsername = User::where('users.email',$request->username)
            ->count();
        if($countExistUsername >= 1)
        {
            return "existusername";
        }
        else
        {
            $hashedPassword = Hash::make($request->default);

            $attendance_user = new User();
            $attendance_user->is_active = true;
            $attendance_user->created_by = auth()->user()->name;
            $attendance_user->name = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
            $attendance_user->email = $request->username;
            $attendance_user->role_id = 6;
            $attendance_user->password = $hashedPassword;
            $attendance_user->default_password = true;   
            
            $attendance_user->save();

            User::whereId($attendance_user->id)->update([
                'password' => Hash::make($request->default)
            ]);

            return "saved";
        }



    }


    public function userMaintenanceUploadCertificate($pps_no)
    {

        $member = MemberInfo::select('tbl_member_info.*','membertype.member_type_name')
        ->join('tbl_member_type as membertype','membertype.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',Crypt::decrypt($pps_no))
        ->first();

    
        
        return view('maintenance.user-upload-certificate',compact('member'));
    }

    public function saveReclassification(Request $request)
    {

        $count = MemberReclassification::where('status','PENDING')
                                        ->where('pps_no', auth()->user()->pps_no)
                                        ->where('is_active',true)
                                        ->count();
        if($count >= 1)
        {
            return "exist";
        }                  
        else
        {
            $reclassification = new MemberReclassification();

            if($request->hasFile('residency_certificate')) 
                {
                    $file = $request->file('residency_certificate');
                    $residency_certificate = time().'-'. $file->getClientOriginalName();
                    $filePath = 'applicant/' . $residency_certificate;
            
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('residency_certificate')));
                    $path = Storage::disk('s3')->url($path);
    
                    $reclassification->file_name = $residency_certificate;
                }
    
            if($request->hasFile('government_physician_certificate')) 
                {
                    $file = $request->file('government_physician_certificate');
                    $government_physician_certificate = time().'-'. $file->getClientOriginalName();
                    $filePath = 'applicant/' . $government_physician_certificate;
                
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('government_physician_certificate')));
                    $path = Storage::disk('s3')->url($path);
    
                    $reclassification->file_name = $government_physician_certificate;
                }
    
            if($request->hasFile('fellows_in_training_certificate')) 
                {
                    $file = $request->file('fellows_in_training_certificate');
                    $fellows_in_training_certificate = time().'-'. $file->getClientOriginalName();
                    $filePath = 'applicant/' . $fellows_in_training_certificate;
             
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('fellows_in_training_certificate')));
                    $path = Storage::disk('s3')->url($path);
    
                    $reclassification->file_name = $fellows_in_training_certificate;
                }
    
              
                $reclassification->is_active = true;
                $reclassification->status = 'PENDING';
                $reclassification->created_by = auth()->user()->name;
                $reclassification->pps_no = auth()->user()->pps_no;
                $reclassification->save();    
    
    
        
            return "success";
        }              


    }

    public function eventLivestreamMaintenance()
    {
        $event = Event::select( 'tbl_event.*')
        ->where('tbl_event.is_active',true)
        ->paginate(10);

        return view('maintenance.event-livestream-maintenance',compact('event'));
    }

    public function eventLivestreamSelectMemberMaintenance($id)
    {
        $this->authorize('manage-items', User::class);
        $ids = Crypt::decrypt($id);

        $event = Event::select( 'tbl_event.*')
        ->where('tbl_event.is_active',true)
        ->where('tbl_event.id',$ids)
        ->first();

        $livestream_member = EventTransaction::select( 'tbl_event_transaction.*','meminfo.first_name','meminfo.middle_name','meminfo.last_name','meminfo.suffix','memtype.member_type_name')
        ->leftJoin('tbl_member_info as meminfo','meminfo.pps_no','=','tbl_event_transaction.pps_no')
        ->join('tbl_member_type as memtype','memtype.id','=','meminfo.member_type')
        ->where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.event_id',$ids)
        ->where('tbl_event_transaction.is_livestream',true)
        ->paginate(10);

        $name = "";

        $livestream_member_choose = EventTransaction::select( 'tbl_event_transaction.*','meminfo.first_name','meminfo.middle_name','meminfo.last_name','meminfo.suffix','meminfo.prc_number')
        ->leftJoin('tbl_member_info as meminfo','meminfo.pps_no','=','tbl_event_transaction.pps_no')
        ->where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.event_id',$ids)
        ->get();

    
   
        return view('maintenance.event-livestream-select-member',compact('event','livestream_member','name','livestream_member_choose','id'));
    }

    public function eventLivestreamSearchParticipant(Request $request,$id)
    {

        $name = $request->searchinput;


        $this->authorize('manage-items', User::class);
        $ids = Crypt::decrypt($id);

        $event = Event::select( 'tbl_event.*')
        ->where('tbl_event.is_active',true)
        ->where('tbl_event.id',$ids)
        ->first();

        $livestream_member = EventTransaction::select( 'tbl_event_transaction.*','meminfo.first_name','meminfo.middle_name','meminfo.last_name','meminfo.suffix','memtype.member_type_name',
        'meminfo.email_address','meminfo.prc_number')
        ->leftJoin('tbl_member_info as meminfo','meminfo.pps_no','=','tbl_event_transaction.pps_no')
        ->join('tbl_member_type as memtype','memtype.id','=','meminfo.member_type')
        ->where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.event_id',$ids)
        ->where('tbl_event_transaction.is_livestream',true)
        ->where(function($query) use ($name) {
            $query
                  ->orWhere('meminfo.first_name', 'ILIKE', "%$name%")
                  ->orWhere('meminfo.middle_name', 'ILIKE', "%$name%")
                  ->orWhere('meminfo.last_name', 'ILIKE', "%$name%")
                  ->orWhere('meminfo.prc_number', 'ILIKE', "%$name%")
                  ->orWhere('meminfo.email_address', 'ILIKE', "%$name%");                             
        })
        ->paginate(10);

     
        $livestream_member_choose = EventTransaction::select( 'tbl_event_transaction.*','meminfo.first_name','meminfo.middle_name','meminfo.last_name','meminfo.suffix')
        ->leftJoin('tbl_member_info as meminfo','meminfo.pps_no','=','tbl_event_transaction.pps_no')
        ->where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.event_id',$ids)
        ->get();

        return view('maintenance.event-livestream-select-member',compact('event','livestream_member','name','livestream_member_choose','id'));
   
    }


    


    public function eventRemoveLivestreamMember(Request $request)
    {
        $livestream_member_exist = EventTransaction::select( 'tbl_event_transaction.*')
        ->where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.event_id',$request->event_id)
        ->where('tbl_event_transaction.pps_no',$request->pps_no)
        ->first();


        $livestream_member_exist->is_livestream = false;
        $livestream_member_exist->save();  

        return "success";
    }


    public function eventAddLivestreamMember(Request $request)
    {
        $livestream_member_exist = EventTransaction::select( 'tbl_event_transaction.*')
        ->where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.event_id',$request->event_id)
        ->where('tbl_event_transaction.pps_no',$request->pps_no)
        ->first();

        if($livestream_member_exist->is_livestream == null || $livestream_member_exist->is_livestream == false)
        {
            $livestream_member_exist->is_livestream = true;
            $livestream_member_exist->save();    

            return "success";
           
        }
        else
        {
          
            return "exist";

        }


      
    }


    


    



    


}
