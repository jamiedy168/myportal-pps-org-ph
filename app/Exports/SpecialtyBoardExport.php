<?php

namespace App\Exports;


use App\Models\SpecialtyBoard;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class SpecialtyBoardExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $specialtyBoard;

    public function __construct($member_chapter,$member_type)
    {
        $this->member_chapter = $member_chapter;
        $this->member_type = $member_type;

        $this->specialtyBoard = SpecialtyBoard::select(
            'tbl_specialty_board.pps_no','memberinfo.prc_number',
            'memberinfo.first_name','memberinfo.last_name','memberinfo.middle_name','memberinfo.suffix',
            'chapter_name',
            'member_type_name',
            DB::raw("(
                select member_type_name from tbl_member_type where id = tbl_specialty_board.member_type_applied_id) as member_type_applied"),
            'tbl_specialty_board.apply_dt',


        )
         ->join('tbl_member_info as memberinfo','memberinfo.pps_no','=','tbl_specialty_board.pps_no')
         ->leftJoin('tbl_chapter','tbl_chapter.id','=','memberinfo.member_chapter')
         ->join('tbl_member_type as membertype','membertype.id','=','memberinfo.member_type')
         ->where('memberinfo.is_active',true)
         ->where('tbl_specialty_board.is_active',true)
         ->where('tbl_specialty_board.status','FOR APPROVAL')
            ->when($this->member_chapter, function ($query, $member_chapter) {
                return $query->where('memberinfo.member_chapter', $member_chapter);
            })
            ->when($this->member_type, function ($query, $member_type) {
                return $query->where('tbl_specialty_board.member_type_applied_id', $member_type);
            })
         ->get();
    }


    public function view(): View
    {
        //
        return view('specialty-board.export-excel', [
            'specialtyBoard' => $this->specialtyBoard
        ]);
    }

}
