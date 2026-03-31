<?php

namespace App\Exports;

use App\Models\ORMaster;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class CashierReportExport implements FromView, ShouldAutoSize
{
  use Exportable;

  private $ormaster;
  private $transaction_type;


  public function __construct($transaction_type, $date_from, $date_to){
    $this->transaction_type = $transaction_type;
    $this->date_from = $date_from;
    $this->date_to = $date_to;

    $startDate = Carbon::createFromFormat('Y-m-d', $this->date_from)->startOfDay();
    $endDate = Carbon::createFromFormat('Y-m-d', $this->date_to)->endOfDay();


    if($this->transaction_type == 'ALL')
    {
            $this->ormaster = ORMaster::select('memberinfo.id','first_name','last_name','middle_name','memberinfo.prc_number',
            'email_address',
            'chapter_name',
            'membertype.member_type_name',
            'total_amount','or_no','payment_dt','payment_mode','transaction_type',
            'tbl_or_master.pps_no',
            'tbl_or_master.paymongo_payment_id',
            DB::raw("(CASE WHEN tbl_or_master.transaction_type = 'ANNUAL DUES' THEN
            (Select year_dues from tbl_annual_dues where id = tbl_or_master.transaction_id) END) AS annual_year"),
            DB::raw("(CASE WHEN tbl_or_master.transaction_type = 'EVENT' THEN
            (Select title from tbl_event where id = trans.event_id) END) AS event_title"),
            'tbl_or_master.transaction_id','tbl_or_master.check_out_sessions_id'
            )
      ->join('tbl_member_info as memberinfo','memberinfo.pps_no','=','tbl_or_master.pps_no')
      ->leftJoin('tbl_chapter','tbl_chapter.id','=','memberinfo.member_chapter')
      ->leftJoin('tbl_event_transaction as trans','trans.id','=','tbl_or_master.transaction_id')
      ->join('tbl_member_type as membertype','membertype.id','=','memberinfo.member_type')
      ->whereBetween('tbl_or_master.payment_dt', [$startDate, $endDate])
      ->get();
    }
    else {
            $this->ormaster = ORMaster::select('memberinfo.id','first_name','last_name','middle_name','memberinfo.prc_number',
            'email_address',
            'chapter_name',
            'membertype.member_type_name',
            'total_amount','or_no','payment_dt','payment_mode','transaction_type',
            'tbl_or_master.pps_no',
            'tbl_or_master.paymongo_payment_id',
            DB::raw("(CASE WHEN tbl_or_master.transaction_type = 'ANNUAL DUES' THEN
            (Select year_dues from tbl_annual_dues where id = tbl_or_master.transaction_id) END) AS annual_year"),
            DB::raw("(CASE WHEN tbl_or_master.transaction_type = 'EVENT' THEN
            (Select title from tbl_event where id = trans.event_id) END) AS event_title"),
            'tbl_or_master.transaction_id','tbl_or_master.check_out_sessions_id'
            )
      ->join('tbl_member_info as memberinfo','memberinfo.pps_no','=','tbl_or_master.pps_no')
      ->leftJoin('tbl_chapter','tbl_chapter.id','=','memberinfo.member_chapter')
      ->leftJoin('tbl_event_transaction as trans','trans.id','=','tbl_or_master.transaction_id')
      ->join('tbl_member_type as membertype','membertype.id','=','memberinfo.member_type')
      ->where('tbl_or_master.is_active',true)
      ->where('tbl_or_master.transaction_type',$this->transaction_type)
      ->whereBetween('tbl_or_master.payment_dt', [$startDate, $endDate])
      ->get();
    }
  

  }

    public function view(): View
    {
        //
        return view('cashier.cashier-excel', [
            'ormaster' => $this->ormaster
        ]);
    }

}
