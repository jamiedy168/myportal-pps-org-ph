<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;
use App\Models\Voting;
use App\Models\MemberInfo;
use App\Models\User;
use App\Models\EventSelected;
use App\Models\ORMaster;
use App\Models\CPDPoints;


class DashboardController extends Controller
{
    
    public function index(){

    
        $ormaster =  ORMaster::select('dues.description','dues.year_dues','event.title','tbl_or_master.transaction_type')->where('tbl_or_master.pps_no',auth()->user()->pps_no)
                    ->where('tbl_or_master.payment_dt','!=',null)
                    ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
                    ->leftJoin('tbl_event_transaction as event_trans','event_trans.id','=','tbl_or_master.transaction_id')
                    ->leftJoin('tbl_event as event','event.id','=','event_trans.event_id')
                    ->orderBy('tbl_or_master.id','DESC')
                    ->paginate(7);    
        

        $info = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->join('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();


        $pps = auth()->user()->pps_no;

        
        if($member == null)
        {
            $mem_type = 0;
        }
        else
        {
            $mem_type = $member->member_type;
        }

        $event = Event::select( 'tbl_event.*',
            DB::raw("(select file_name from tbl_event_image where event_id = tbl_event.id and is_active = true and status = 'UPLOADED' and type_of_event_image = 'BANNER' order by id asc limit 1) as event_image"),
            DB::raw("(
                select price from tbl_event_price where event_id = tbl_event.id and is_active = true and member_type_id = $mem_type) as prices"),
            DB::raw("(
                select paid from tbl_event_transaction where event_id = tbl_event.id and pps_no = $pps and is_active = true) as paid")
           
            )
            ->where('tbl_event.is_active',true)
            ->where('tbl_event.status','!=','COMPLETED')
            ->orderBy('tbl_event.id','DESC')
            ->paginate(3);

        $voting = Voting::select('tbl_voting.*'
                  )
                ->where('tbl_voting.is_active',true)
                ->orderBy('tbl_voting.id', 'DESC')
                ->get();

        $cpdpoints = CPDPoints::
                where('tbl_cpd_points.is_active',true)
                ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
                ->sum('points');        
          
      
        return view('dashboard.index',compact('event','member','ormaster','voting','mem_type','cpdpoints'));
    }

    public function changeDefaultPassword(Request $request)
    {

        $hashedPassword = Hash::make($request->password);

        // $user = User::where('id', $request->user_id)->firstOrFail();
        // $user->update([
        //     'updated_by' => Hash::make($request['password'])
           
        // ]);



        // $users = User::findorFail(auth()->user()->id);
        //         $users->password = $hashedPassword;
        //         $users->save();

        $user = User::where('id',$request->user_id)
                      ->first();

        $user->updated_by = auth()->user()->name;
        $user->default_password = false;

        $user->save();

        #Update the new Password
         User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return $request->user;
    }
}
