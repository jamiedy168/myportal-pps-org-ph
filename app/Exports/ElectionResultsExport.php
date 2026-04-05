<?php

namespace App\Exports;

use App\Models\Candidate;
use App\Models\MemberInfo;
use App\Models\VotingPosition;
use App\Models\VotingSelected;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ElectionResultsExport implements FromCollection, WithHeadings
{
    protected ?int $electionId;
    protected ?string $from;
    protected ?string $to;

    public function __construct(?int $electionId, ?string $from, ?string $to)
    {
        $this->electionId = $electionId;
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $query = VotingSelected::select(
                'tbl_voting_selected.position_id',
                'tbl_voting_selected.candidate_pps_no',
                DB::raw('COUNT(*) as votes')
            )
            ->where('tbl_voting_selected.is_active', true);

        if ($this->electionId) {
            $query->where('tbl_voting_selected.voting_id', $this->electionId);
        }

        if ($this->from && $this->to) {
            $fromDate = Carbon::parse($this->from)->startOfDay();
            $toDate = Carbon::parse($this->to)->endOfDay();
            $query->whereBetween('tbl_voting_selected.created_at', [$fromDate, $toDate]);
        }

        $results = $query
            ->groupBy('tbl_voting_selected.position_id', 'tbl_voting_selected.candidate_pps_no')
            ->orderBy('tbl_voting_selected.position_id')
            ->orderByDesc(DB::raw('COUNT(*)'))
            ->get();

        $rows = $results->map(function ($row) {
            $position = VotingPosition::where('id', $row->position_id)->first();
            $candidate = Candidate::where('pps_no', $row->candidate_pps_no)->first();
            $member = MemberInfo::select('first_name','middle_name','last_name','suffix')
                ->where('pps_no', $row->candidate_pps_no)
                ->first();

            $fullName = $member
                ? trim($member->first_name.' '.$member->middle_name.' '.$member->last_name.' '.$member->suffix)
                : ($row->candidate_pps_no ?? 'Unknown');

            return [
                'Position' => optional($position)->position ?? 'N/A',
                'Candidate' => $fullName,
                'PPS No' => $row->candidate_pps_no ?? 'N/A',
                'Votes' => $row->votes,
                'Candidate Status' => optional($candidate)->status ?? 'N/A',
            ];
        });

        return new Collection($rows);
    }

    public function headings(): array
    {
        return ['Position', 'Candidate', 'PPS No', 'Votes', 'Candidate Status'];
    }
}
