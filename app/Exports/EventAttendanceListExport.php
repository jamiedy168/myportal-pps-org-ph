<?php

namespace App\Exports;

use App\Models\MemberInfo;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class EventAttendanceListExport implements FromView, ShouldAutoSize
{

    private $attendance;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;

        $this->memberList = MemberInfo::select(
            'tbl_member_info.first_name',
            'tbl_member_info.middle_name',
            'tbl_member_info.last_name',
            'tbl_member_info.suffix',
            'tbl_member_info.prc_number',
            'tbl_member_info.pps_no',
            'chapter.chapter_name',
            'memtype.member_type_name',
            'tbl_event_transaction.joined_dt',
            'tbl_event_transaction.attended_dt',

        )
        ->leftJoin('tbl_chapter as chapter', 'chapter.id', '=', 'tbl_member_info.member_chapter')
        ->leftJoin('tbl_member_type as memtype', 'memtype.id', '=', 'tbl_member_info.member_type')
        ->leftJoin('users', 'users.pps_no', '=', 'tbl_member_info.pps_no')
        ->leftJoin('tbl_event_transaction', 'tbl_event_transaction.pps_no', '=', 'tbl_member_info.pps_no')
        ->where('tbl_member_info.is_active', true)
        ->where('tbl_member_info.status', '!=', 'DISAPPROVE')
        ->where('users.role_id', 3)
        ->where('tbl_event_transaction.event_id', $event_id)
        ->where('tbl_event_transaction.attended', true)
        ->where('tbl_event_transaction.is_active', true)
        ->get();
    }

    public function view(): View
    {

        return view('reports.event-attendance-generate-excel', [
            'memberListAttendance' => $this->memberList
        ]);
    }
}
