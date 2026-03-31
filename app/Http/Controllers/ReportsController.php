<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\Reports;
use App\Models\MemberType;
use App\Models\Chapter;
use App\Models\MemberInfo;
use App\Models\Event;
use App\Models\ReportsMemberList;
use App\Models\ClassificationVIP;
use App\Exports\ReportMemberListExport;
use App\Exports\EventAttendanceListExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function viewReports()
    {
        $this->authorize('manage-items', User::class);

        $reports = Reports::where('is_active', true)
        ->orderBy('id','ASC')
        ->paginate(12);  

        return view('reports.view',compact('reports'));
    }

    public function chooseReport($id)
    {
        $this->authorize('manage-items', User::class);

        $ids = Crypt::decrypt($id);

        $reports = Reports::where('is_active', true)
        ->where('id', $ids)
        ->first();  
        $reports->link = $id;
        $reports->save();

 

        return redirect()->route($reports->module, ['id' => $id]);



        //MEMBER LIST REPORT
        // if($ids == 1)
        // {
        //     return redirect()->route('reports-member-list', ['id' => $id]);
        // }
    }


    public function memberListReport($id)
    {
        $this->authorize('manage-items', User::class);

        $ids = Crypt::decrypt($id);

        $reports = Reports::where('is_active', true)
        ->where('id', $ids)
        ->first();  

        $member_type = MemberType::select('tbl_member_type.*')
        ->where('tbl_member_type.is_active',true)
        ->orderBy('tbl_member_type.member_type_name','ASC')
        ->get();

            
        $chapter = Chapter::select('tbl_chapter.*')
        ->where('tbl_chapter.is_active',true)
        ->orderBy('tbl_chapter.chapter_name','ASC')
        ->get();

        $excludedDescriptions = ['Non-Member', 'Member'];

        $classification = ClassificationVIP::select('tbl_member_classification_vip.*')
        ->where('tbl_member_classification_vip.is_active', true)
        ->whereNotIn('tbl_member_classification_vip.description', $excludedDescriptions)
        ->orderBy('tbl_member_classification_vip.description', 'ASC')
        ->get();


        $reports_member = ReportsMemberList::select('tbl_reports_member_list.status','tbl_reports_member_list.member_type',
                                                    'tbl_reports_member_list.chapter','chapter.chapter_name',
                                                    'tbl_reports_member_list.created_by')
        ->where('tbl_reports_member_list.is_active', true)
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','tbl_reports_member_list.chapter')
        ->orderBy('tbl_reports_member_list.id','DESC')
        ->paginate(10);  
        

        return view('reports.member-generate',compact('reports','member_type','chapter','reports_member','classification'));

    }


    public function eventAttendanceListReport($id)
    {
        $this->authorize('manage-items', User::class);

        $ids = Crypt::decrypt($id);

        $reports = Reports::where('is_active', true)
        ->where('id', $ids)
        ->first();  

        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->orderBy('id','ASC')
        ->get();


        return view('reports.event-attendance-generate',compact('reports','event'));

    }


    public function generateReport(Request $request)
    {


        $this->authorize('manage-items', User::class);

        $reports = new ReportsMemberList();
        $reports->is_active = true;
        $reports->status = "COMPLETED";
        $reports->created_by = auth()->user()->name;
        $reports->member_type = $request->member_type_texts;
        $reports->chapter = $request->member_chapter;
        $reports->save();


        return Excel::download(new ReportMemberListExport($request->member_chapter,$request->member_type, $request->classification), 'member-list-data.xlsx');


        return "success";
    }


    public function generateEventAttendanceReport(Request $request)
    {

        $this->authorize('manage-items', User::class);
        return Excel::download(new EventAttendanceListExport($request->event_id), 'event-attendance-list.xlsx');

        return "success";
        
    }




    



    
}
