<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Carbon\Carbon;
use App\Models\CPDPoints;
use App\Models\Event;
use App\Models\MemberInfo;
use App\Models\CPDPointsMaintenance;
use Illuminate\Support\Facades\Crypt;

class CPDPointsController extends Controller
{
    //
    public function index()
    {
        $member = MemberInfo::select('tbl_member_info.*',
        DB::raw("(select sum(points) from tbl_cpd_points where pps_no = tbl_member_info.pps_no and is_active = true) as cpd_points")  )
      
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','!=','PENDING')
        ->get();

        $top_member = MemberInfo::select('tbl_member_info.*','tbl_cpd_points.points',
        DB::raw("(select sum(points) from tbl_cpd_points where pps_no = tbl_member_info.pps_no and is_active = true) as cpd_points")  )
        ->join('tbl_cpd_points','tbl_cpd_points.pps_no','=','tbl_member_info.pps_no')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.type','!=','APPLICANT')
        ->orderBy('cpd_points','DESC')
        ->first();


        $second_member = MemberInfo::select('tbl_member_info.*',
        DB::raw("(select sum(points) from tbl_cpd_points where pps_no = tbl_member_info.pps_no and is_active = true) as cpd_points")  )
      
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.type','!=','APPLICANT')
        ->orderBy('cpd_points','DESC')
        ->skip(1)
        ->get();




      
        return view('cpd-points.index',compact('member','top_member','second_member'));
    }

    public function view($pps_no)
    {
        $ids = Crypt::decrypt($pps_no); 
        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',$ids)
        ->first();

        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->get();

    
        $top_member_points = CPDPoints::where('is_active',true)->where('pps_no',$ids)->sum('points');

        $cpd_points_maintenance = CPDPointsMaintenance::where('is_active',true)->orderBy('id','ASC')->get();
      
        return view('cpd-points.view',compact('member','cpd_points_maintenance','event','ids','top_member_points'));
    }


    public function save(Request $request)
    {
        $cpd_points = new CPDPoints();
        $cpd_points->is_active = true;
        $cpd_points->pps_no = $request->pps_no;
        $cpd_points->points = $request->points;
        $cpd_points->event_id = $request->event_id;
        $cpd_points->category_name = $request->category_name;
        $cpd_points->created_by = auth()->user()->name;

        $cpd_points->save();
      
        return Response()->json([
            "success" => true
      ]);
    }

    public function viewMemberCPD()
    {

        $pps = auth()->user()->pps_no;

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        $cpdpoints = CPDPoints::
        where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
        ->sum('points');

        $cpdpointsyear2024 = CPDPoints::
        where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
        ->whereYear('tbl_cpd_points.created_at','2024')
        ->sum('points');

        $cpdpointsyear2023 = CPDPoints::
        where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
        ->whereYear('tbl_cpd_points.created_at','2023')
        ->sum('points');

        $cpdpointsevent = CPDPoints::select('tbl_cpd_points.*','topic.topic_name'   
        )
        ->join('tbl_event_topic as topic','topic.id','=','tbl_cpd_points.item_id')
        ->where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
        ->orderBy('tbl_cpd_points.id','DESC')
        ->first(8);


        $currentYear = now()->year; // Kunin ang kasalukuyang taon
        $years = [];
    
        for ($i = 0; $i < 5; $i++) {
            $years[] = $currentYear - $i;
        }
    

        
        $event = Event::select('tbl_event.*','category.name',
        DB::raw("(SELECT SUM(points) FROM tbl_cpd_points WHERE pps_no = $pps AND is_active = true AND event_id = tbl_event.id) AS cpd_points")
        )
        ->leftJoin('tbl_event_category as category','category.id','=','tbl_event.category_id')
        ->where('tbl_event.is_active', true)
        ->get()
        ->map(function ($event) {
           
            $eventArray = $event->toArray();
    
            $event->cpd_points = $eventArray['cpd_points'] ?? 0;
            return $event;
        })
        ->filter(function ($event) {
            return $event->cpd_points != 0 && !is_null($event->cpd_points);
        });



        return view('cpd-points.view-member-cpd',compact('member','cpdpoints','cpdpointsyear2024','cpdpointsyear2023','cpdpointsevent','years','event'));
    }



    public function viewEventCPD($id)
    {

        $ids = Crypt::decrypt($id); 


        $cpdpointsevent = CPDPoints::select('tbl_cpd_points.*','topic.topic_name'   
        )
        ->join('tbl_event_topic as topic','topic.id','=','tbl_cpd_points.item_id')
        ->where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
        ->where('tbl_cpd_points.event_id',$ids)
        ->orderBy('tbl_cpd_points.id','DESC')
        ->paginate(8);

        
        $event = Event::select( 'tbl_event.*')
        ->where('id',$ids)
        ->where('is_active',true)
        ->first();


        // $ids = Crypt::decrypt($id); 
        // $member = MemberInfo::select('tbl_member_info.*')
        // ->where('tbl_member_info.is_active',true)
        // ->where('tbl_member_info.pps_no',$ids)
        // ->first();


    
        // $top_member_points = CPDPoints::where('is_active',true)->where('pps_no',$ids)->sum('points');

        // $cpd_points_maintenance = CPDPointsMaintenance::where('is_active',true)->orderBy('id','ASC')->get();
      
        return view('cpd-points.view-event-cpd',compact('cpdpointsevent','event'));
    }

    public function adminViewMemberCPD()
    {

        $name = "";

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->paginate(15);

        

        return view('cpd-points.admin-view',compact('member','name'));
    }


    public function adminSearchViewMemberCPD(Request $request)
    {

        $name = $request->input('searchinput');

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where(function($query) use ($name) {
            $query
                  ->orWhere('tbl_member_info.first_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.middle_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.last_name', 'ILIKE', "%$name%")
                  ->orWhere('tbl_member_info.prc_number', 'ILIKE', "%$name%");                             
        })
        ->orderBy('tbl_member_info.first_name', 'ASC')
        ->paginate(15);

        return view('cpd-points.admin-view',compact('member','name'));
    }


    public function adminViewMemberCPDDetails($pps_no)
    {
        $ids = Crypt::decrypt($pps_no); 
        $name = "";

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',$ids)
        ->first();

        $cpdpoints = CPDPoints::
        where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',$ids)
        ->sum('points');

        $cpdpointsevent = CPDPoints::select('tbl_cpd_points.*','topic.topic_name'   
        )
        ->join('tbl_event_topic as topic','topic.id','=','tbl_cpd_points.item_id')
        ->where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',$ids)
        ->orderBy('tbl_cpd_points.id','DESC')
        ->paginate(9);

        $cpdpointsyearcount = CPDPoints::select('tbl_cpd_points.*')
        ->where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',$ids)
        ->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])
        ->sum('tbl_cpd_points.points');

        $startYear = Carbon::now()->subYears(6)->year;
        $endYear = Carbon::now()->year;
        
        $pointsPerYear = [];

        for ($year = $startYear; $year <= $endYear; $year++) {
            $pointsSum = CPDPoints::whereYear('created_at', $year)
                                    ->where('is_active',true)
                                    ->where('pps_no',$ids)
                                    ->sum('points');
            
            $pointsPerYear[$year] = $pointsSum;
        }

        arsort($pointsPerYear);


        $event = Event::select('tbl_event.*','category.name',
        DB::raw("(SELECT SUM(points) FROM tbl_cpd_points WHERE pps_no = $ids AND is_active = true AND event_id = tbl_event.id) AS cpd_points")
        )
        ->leftJoin('tbl_event_category as category','category.id','=','tbl_event.category_id')
        ->where('tbl_event.is_active', true)
        ->get()
        ->map(function ($event) {
            // I-convert ang resulta sa isang array para mas madaling ma-access ang raw attributes.
            $eventArray = $event->toArray();
            // Siguraduhing ang cpd_points ay maayos na nai-set bilang property ng object.
            $event->cpd_points = $eventArray['cpd_points'] ?? 0;
            return $event;
        })
        ->filter(function ($event) {
            // I-filter ang mga events base sa cpd_points.
            return $event->cpd_points != 0 && !is_null($event->cpd_points);
        });


        return view('cpd-points.admin-view-member-cpd',compact('member','cpdpointsevent','cpdpointsyearcount','pointsPerYear','pps_no','name','event','ids','cpdpoints'));
    
    }

    public function adminSearchViewMemberCPDPoints(Request $request,$pps_no)
    {

        $ids = Crypt::decrypt($pps_no); 
        $name = $request->input('searchinput');


        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',$ids)
        ->first();

        $cpdpointsevent = CPDPoints::select('tbl_cpd_points.*','topic.topic_name'   
        )
        ->join('tbl_event_topic as topic','topic.id','=','tbl_cpd_points.item_id')
        ->where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',$ids)
        ->where(function($query) use ($name) {
            $query
                  ->orWhere('topic.topic_name', 'ILIKE', "%$name%");
                           
        })
        ->orderBy('tbl_cpd_points.id','DESC')
        ->paginate(9);

        $cpdpointsyearcount = CPDPoints::select('tbl_cpd_points.*')
        ->where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',$ids)
        ->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])
        ->sum('tbl_cpd_points.points');

        $startYear = Carbon::now()->subYears(6)->year;
        $endYear = Carbon::now()->year;
        
        $pointsPerYear = [];

        for ($year = $startYear; $year <= $endYear; $year++) {
            $pointsSum = CPDPoints::whereYear('created_at', $year)
                                    ->where('is_active',true)
                                    ->where('pps_no',$ids)
                                    ->sum('points');
            
            $pointsPerYear[$year] = $pointsSum;
        }

        arsort($pointsPerYear);


        $event = Event::select('tbl_event.*','category.name',
        DB::raw("(SELECT SUM(points) FROM tbl_cpd_points WHERE pps_no = $ids AND is_active = true AND event_id = tbl_event.id) AS cpd_points")
        )
        ->leftJoin('tbl_event_category as category','category.id','=','tbl_event.category_id')
        ->where('tbl_event.is_active', true)
        ->get()
        ->map(function ($event) {
            // I-convert ang resulta sa isang array para mas madaling ma-access ang raw attributes.
            $eventArray = $event->toArray();
            // Siguraduhing ang cpd_points ay maayos na nai-set bilang property ng object.
            $event->cpd_points = $eventArray['cpd_points'] ?? 0;
            return $event;
        })
        ->filter(function ($event) {
            // I-filter ang mga events base sa cpd_points.
            return $event->cpd_points != 0 && !is_null($event->cpd_points);
        });



        return view('cpd-points.admin-view-member-cpd',compact('member','cpdpointsevent','cpdpointsyearcount','pointsPerYear','pps_no','name'));
    
    }


    

}
