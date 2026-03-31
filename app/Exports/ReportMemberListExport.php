<?php

namespace App\Exports;

use App\Models\MemberInfo;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use Log;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportMemberListExport implements FromView, ShouldAutoSize
{
    private $memberList;


    public function __construct($member_chapter,$member_type,$classification){
        $this->member_chapter = $member_chapter;
        $this->member_type = $member_type;
        $this->classification = $classification;

        Log::info('Classification value:', ['classification' => $classification]);

    

        $this->memberList = MemberInfo::select(
            'tbl_member_info.first_name',
            'tbl_member_info.middle_name',
            'tbl_member_info.last_name',
            'tbl_member_info.suffix',
            'tbl_member_info.prc_number',
            'tbl_member_info.pps_no',
            'tbl_member_info.email_address',
            DB::raw("CONCAT(tbl_member_info.country_code, ' ', tbl_member_info.mobile_number) AS contact_number"),
            'chapter.chapter_name',
            'memtype.member_type_name',
            'tbl_member_info.address',
            'tbl_member_info.birthdate',
            'tbl_member_info.gender',
            'tbl_member_info.picture',
            'tbl_member_info.vip',
            'tbl_member_info.vip_description',
            'class.description as classdescription',
            'tbl_member_info.tin_number',
            'tbl_member_info.house_number',
            'tbl_member_info.street_name',
            'tbl_member_info.barangay_name',
            'tbl_member_info.city_name',
            'tbl_member_info.province_name',
            'tbl_member_info.postal_code',
            'tbl_member_info.country_name',
            'tbl_member_info.country_text',
            'tbl_member_info.region_id',
            'tbl_member_info.pma_number'

        )
        ->leftJoin('tbl_chapter as chapter', 'chapter.id', '=', 'tbl_member_info.member_chapter')
        ->leftJoin('tbl_member_type as memtype', 'memtype.id', '=', 'tbl_member_info.member_type')
        ->leftJoin('users', 'users.pps_no', '=', 'tbl_member_info.pps_no')
        ->leftJoin('tbl_member_classification_vip as class', 'class.id', '=', 'tbl_member_info.member_classification_id')
        ->where('tbl_member_info.is_active', true)
        ->where('tbl_member_info.status', '!=', 'DISAPPROVE')
        ->where('users.role_id', 3)
        ->when($this->member_type, function ($query, $member_type) {
            return $query->whereIn('tbl_member_info.member_type', $member_type);
        })
        ->when($this->member_chapter, function ($query, $member_chapter) {
            return $query->where('tbl_member_info.member_chapter', $member_chapter);
        })
        ->when($this->classification, function ($query, $classification) {
            return $query->where('tbl_member_info.member_classification_id', $classification);
        })
        ->get();
    }

    public function view(): View
    {
        //
        return view('reports.member-generate-excel', [
            'memberList' => $this->memberList
        ]);
    }


}
