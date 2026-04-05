<?php

namespace App\Exports;

use App\Models\CPDPoints;
use App\Models\MemberInfo;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CPDPointsExport implements FromCollection, WithHeadings
{
    protected ?string $from;
    protected ?string $to;
    protected ?string $chapterId;
    protected ?string $memberTypeId;

    public function __construct(?string $from, ?string $to, ?string $chapterId, ?string $memberTypeId)
    {
        $this->from = $from;
        $this->to = $to;
        $this->chapterId = $chapterId;
        $this->memberTypeId = $memberTypeId;
    }

    public function collection()
    {
        $query = CPDPoints::select(
                'tbl_cpd_points.pps_no',
                DB::raw('SUM(tbl_cpd_points.points) as total_points')
            )
            ->where('tbl_cpd_points.is_active', true);

        if ($this->from && $this->to) {
            $fromDate = Carbon::parse($this->from)->startOfDay();
            $toDate = Carbon::parse($this->to)->endOfDay();
            $query->whereBetween('tbl_cpd_points.created_at', [$fromDate, $toDate]);
        }

        $query->groupBy('tbl_cpd_points.pps_no');

        $summary = $query->get();

        $rows = $summary->map(function ($row) {
            $member = MemberInfo::select(
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix',
                    'member_type',
                    'member_chapter'
                )
                ->where('pps_no', $row->pps_no)
                ->first();

            if ($this->chapterId && optional($member)->member_chapter != $this->chapterId) {
                return null;
            }
            if ($this->memberTypeId && optional($member)->member_type != $this->memberTypeId) {
                return null;
            }

            $fullName = $member
                ? trim($member->first_name.' '.$member->middle_name.' '.$member->last_name.' '.$member->suffix)
                : 'Unknown';

            return [
                'Member' => $fullName,
                'PPS No' => $row->pps_no,
                'Total Points' => $row->total_points,
            ];
        })->filter();

        return new Collection($rows->values());
    }

    public function headings(): array
    {
        return ['Member', 'PPS No', 'Total Points'];
    }
}
