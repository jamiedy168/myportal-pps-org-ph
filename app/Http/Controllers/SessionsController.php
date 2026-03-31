<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Jobs\SendEmailResetPasswordJob;
use App\Models\MaintenanceEmail;
use App\Models\MemberType;
use App\Models\MemberInfo;
use App\Models\User;
use Str;
use App\Models\Audit;
use Carbon\Carbon;
use Session;


class SessionsController extends Controller
{

    public function create()
    {
        $type = MemberType::where('is_active',true)
        ->whereNotIn('member_type_name',['DIPLOMATE','FELLOW','EMERITUS FELLOW','ACTIVE MEMBER'])
        ->orderBy('id', 'ASC')
        ->get();


        return view('sessions.create',compact('type'));
    }

    public function resetEmail()
    {
    
        return view('authentication.reset.reset-email');
    }

    public function senEmailResetPassword(Request $request)
    {
        $crypt = Crypt::encrypt($request->email_address);

        $user = User::where('email',$request->email_address)
                      ->where('is_active',true) 
                      ->count();
        $userInfo = User::where('email',$request->email_address)
                ->where('is_active',true) 
                ->first();              

        if($user >= 1)
        {
            $emaiPPS = MaintenanceEmail::where('tbl_pps_email.is_active',true)
            ->where('status','PRIMARY')
            ->pluck('pps_email')->first();

            $message = '';
    
                $mail_data = [
                    'recipient' => $request->email_address,
                    'fromEmail' => 'no-reply@pps.org.ph',
                    'fromName' => 'Philippine Pediatric Society Inc.',
                    'subject' => 'Reset Password',
                    'body' => $message,
                    'crypt' => $crypt,
                    'full_name' => $userInfo->name
                ];
                \Mail::send('authentication.reset.reset-password-email-template',$mail_data, function($message) use ($mail_data){
                    $message->to($mail_data['recipient'])
                            ->from($mail_data['fromEmail'], $mail_data['fromName'])
                            ->subject($mail_data['subject']);
                });

            return Response()->json([
                "success" => true,
                "url"=>url('/sign-in')
                
            ]);
        }

        else
        {
            return "notfound";
        }

  
    }


    public function resetPasswordForm($id)
    {
        $email_address = Crypt::decrypt($id);

        return view('authentication.reset.new-password',compact('email_address'));
        
    }

    public function resetPasswordSubmit(Request $request)
    {
        $hashedPassword = Hash::make($request->password);

        $user = User::where('email',$request->email_address)
        ->first();

        $user->updated_by = $user->name;
        $user->default_password = false;

        $user->save();    

        User::whereId($user->id)->update([
            'password' => Hash::make($request->password)
        ]);
        
        return Response()->json([
            "success" => true,
            "url"=>url('/sign-in')
           
        ]);
    }


    
    

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }


        $data = [
            'auditable_id' => auth()->user()->id,
            'auditable_type' => "App\Models\Login",
            'event'      => "logged in",
            'url'        => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id'    => auth()->user()->id,
        ];

        $details = Audit::create($data);


        session()->regenerate();
        session()->regenerateToken();


        
        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        if($member != null)
        {
            Session::put('member_type',$member->member_type_name);   
        }
        

        switch (auth()->user()->role_id) {
            case 1:
                return redirect()->intended('/');
            case 2:
                return redirect()->intended('/');
            case 3:
                return redirect()->intended('/');
            case 4:
                return redirect()->intended('/');
            case 5:
                return redirect('/icd-template-download');
            case 6:
                return redirect('/event-choose-attendance');
                   
            default:
                return redirect()->intended('/');
        }

        
        return redirect()->intended('/');


        // return redirect('/dashboard');

    }

    public function show(){

        if(env('IS_DEMO')){

            return back()->with('demo', 'This is a demo version. You can not change the password.');
        }
        else{
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
    }

    public function update(){
        
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]); 
          
        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }


    public function destroy(Request $request)
    {
        $data = [
            'auditable_id' => auth()->user()->id,
            'auditable_type' => "App\Models\Login",
            'event'      => "logged out",
            'url'        => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id'    => auth()->user()->id,
        ];

        $details = Audit::create($data);


        $request->session()->forget('url.intended');

        auth()->logout();

        // Fully invalidate the session and rotate the CSRF token to avoid stale tokens lingering after logout
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/sign-in');
    }



}
