<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voting;
use App\Models\MemberInfo;
use App\Models\Candidate;
use App\Models\VotingTransaction;
use App\Models\VotingSelected;
use App\Models\VotingPosition;
use App\Models\ORMaster;
use App\Models\EventTransaction;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;

class VotingController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function votingListing()
    {
        $auth =  auth()->user()->pps_no;

        $voting = Voting::select('tbl_voting.*',
            DB::raw("(select count(*) from tbl_candidate where voting_id = tbl_voting.id and is_active = true) as candidate_count"),
            DB::raw("(select count(*) from tbl_voting_transaction where voting_id = tbl_voting.id and is_active = true and pps_no = $auth) as transcount"))
            
        ->where('tbl_voting.is_active',true)
        ->orderBy('tbl_voting.id', 'DESC')
        ->get();
        


        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

      

        return view('voting.listing',compact('voting','member'));
    }

    public function votingCreate()
    {
        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.type','MEMBER')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','ACCEPTED')
        ->orderBy('tbl_member_info.first_name', 'ASC')
        ->get();

       
        $positions = VotingPosition::where('is_active',true)
        ->where('status','ACTIVE')
        ->get();

        $candidateBot = Candidate::select('tbl_candidate.*',
                                       'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                                       'chapter.chapter_name'
                                       )
        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
        ->where('tbl_candidate.is_active',true)
        ->where('tbl_candidate.status','PENDING')
        ->where('tbl_candidate.position_id',1)
        ->orderBy('tbl_candidate.id', 'DESC')
        ->get();

        $countCandidateBot = Candidate::where('is_active',true)
        ->where('status','PENDING')
        ->where('position_id',1)
        ->count();



        $candidateChapRep = Candidate::select('tbl_candidate.*',
                                       'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                                       'chapter.chapter_name'
                                       )
        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
        ->where('tbl_candidate.is_active',true)
        ->where('tbl_candidate.status','PENDING')
        ->where('tbl_candidate.position_id',2)
        ->orderBy('tbl_candidate.id', 'DESC')
        ->get();

        $countCandidateChapRep = Candidate::where('is_active',true)
        ->where('status','PENDING')
        ->where('position_id',2)
        ->count();







        return view('voting.create',compact('member','countCandidateBot','positions','candidateBot','candidateChapRep','countCandidateChapRep'));
    }


    public function votingSave(Request $request)
    {
    

        $voting = new Voting();

        if($request->hasFile('picture')) 
        {
            $file = $request->file('picture');
            $picture = time().'-'. $file->getClientOriginalName();
            $filePath = 'others/' . $picture;
     
            $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('picture')));
            $path = Storage::disk('s3')->url($path);

            $voting->picture = $picture;

        }
 

        $voting->created_by = auth()->user()->name;
        $voting->is_active = true;
        $voting->status = "UPCOMING";
        $voting->title = strtoupper($request->voting_title);
        $voting->date_from = $request->voting_date_from;
        $voting->date_to = $request->voting_date_to;
        $voting->time_from = $request->voting_time_from;
        $voting->time_to = $request->voting_time_to;
        $voting->description = $request->voting_description;
        $voting->bot_max_vote = $request->bot_max_vote;
        $voting->chaprep_max_vote = $request->chap_rep_max_vote;


        
        $voting->save();

        Candidate::where('status', '=', 'PENDING')
                    ->where('is_active',true)
        ->update(['voting_id' => $voting->id,
                  'status' => 'ACTIVE',
                  'updated_by' => auth()->user()->name]);



        return "COMPLETED";
    }

    public function votingAddCandidate(Request $request)
    {
        $existCandidate = Candidate::where('pps_no',$request->pps_no)->where('is_active',true)->where('status','PENDING')->count();
        if($existCandidate >= 1)
        {
            return "exist";
        }
        else
        {
            $candidate = new Candidate();
            $candidate->created_by = auth()->user()->name;
            $candidate->is_active = true;
            $candidate->status = "PENDING";
            $candidate->pps_no = $request->pps_no;
    
            $candidate->save();
    
            return "completed";
        }  

    }

    public function votingAddCandidateBot(Request $request)
    {
        $existCandidate = Candidate::where('pps_no',$request->pps_no)
                                    ->where('is_active',true)
                                    ->where('status','PENDING')
                                    ->count();
        if($existCandidate >= 1)
        {
            return "exist";
        }
        else
        {
            $candidate = new Candidate();
            $candidate->created_by = auth()->user()->name;
            $candidate->is_active = true;
            $candidate->status = "PENDING";
            $candidate->pps_no = $request->pps_no;
            $candidate->position_id = 1;
    
            $candidate->save();
    
            return "completed";
        } 
    
    }


    public function votingAddCandidateChapRep(Request $request)
    {
  
        $existCandidate = Candidate::where('pps_no',$request->pps_no)
                                    ->where('is_active',true)
                                    ->where('status','PENDING')
                                    ->count();
        if($existCandidate >= 1)
        {
            return "exist";
        }
        else
        {
            $candidate = new Candidate();
            $candidate->created_by = auth()->user()->name;
            $candidate->is_active = true;
            $candidate->status = "PENDING";
            $candidate->pps_no = $request->pps_no;
            $candidate->position_id = 2;
    
            $candidate->save();
    
            return "completed";
        } 
    
    }


    



    

    public function votingRemoveCandidate(Request $request)
    {
        $candidate = Candidate::where('pps_no',$request->pps_no)
        ->where('status','PENDING')      
        ->delete();

        return "success";
    }

    public function votingRemoveCandidateBot(Request $request)
    {
        $candidate = Candidate::where('pps_no',$request->pps_no)
                                ->where('status','PENDING')
                                ->delete();

        return "success";
    }

    public function votingRemoveCandidateChapRep(Request $request)
    {
        $candidate = Candidate::where('pps_no',$request->pps_no)
                                ->where('status','PENDING')                        
                                ->delete();

        return "success";
    }





    public function votingElect($id)
    {
        $ids = Crypt::decrypt($id);
        
        $checkAnnualDuesPending = ORMaster::where('pps_no',auth()->user()->pps_no)
                                         ->where('payment_dt',null)->count(); 

        $checkAnnualConventionPayment = EventTransaction::
        join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
        ->leftJoin('tbl_event_category as category','category.id','=','event.category_id')
        ->where('tbl_event_transaction.is_active',true)
        ->where('category.name','ANNUAL CONVENTION')
        ->where('tbl_event_transaction.pps_no',auth()->user()->pps_no)
        ->count(); 

        //NEED TO MODIFY THE DATE/TIME MANUALLY
        $checkAnnualConventionPaymentTime = EventTransaction::
                join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
                ->leftJoin('tbl_event_category as category','category.id','=','event.category_id')
                ->where('tbl_event_transaction.is_active',true)
                ->where('category.name','ANNUAL CONVENTION')
                ->where('tbl_event_transaction.pps_no',auth()->user()->pps_no)
                ->where('tbl_event_transaction.joined_dt','>=', '2024-04-07 12:00:00')
                ->count(); 


        $checkifvoted = VotingTransaction::where('is_active',true)
                        ->where('status','COMPLETED')
                        ->where('voting_id',$ids)
                        ->where('pps_no',auth()->user()->pps_no)
                        ->count();

        // if($checkAnnualDuesPending >= 1)
        // {
        //     return redirect('voting-listing')->withStatus('existannualdues');
        // }
        // elseif($checkAnnualConventionPayment == 0)
        // {
        //     return redirect('voting-listing')->withStatus('notjoined');
            
        // }
        // else if($checkAnnualConventionPaymentTime >= 1)
        // {
        //     return redirect('voting-listing')->withStatus('paymenttimenotmeet');
        // }                
        if($checkifvoted >= 1)
        {
            return redirect('voting-listing')->withStatus('alreadyvoted');
        }  
        else
        {
            $voting = Voting::where('is_active',true)
            ->where('id',$ids)
            ->first();

            $botCandidate = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name'
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',1)
                        ->where('voting_id',$ids)
                        ->orderBy('member.last_name', 'ASC')
                        ->get();     
                        
            $chapRepCandidate = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name'
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',2)
                        ->where('voting_id',$ids)
                        ->orderBy('chapter.chapter_name', 'DESC')
                        ->get();              
                        
            $selectedCandidate = VotingSelected::select('tbl_voting_selected.*','position.position',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.picture')
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_voting_selected.candidate_pps_no')
                        ->join('tbl_voting_position as position','position.id','=','tbl_voting_selected.position_id')
                        ->where('tbl_voting_selected.is_active',true)
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$ids)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->orderBy('position.position', 'ASC')
                        ->get(); 

                     

            $countCandidate = VotingSelected::where('is_active',true)
                        ->where('status','PENDING')
                        ->where('voting_id',$ids)
                        ->where('pps_no',auth()->user()->pps_no)
                        ->count();      
                        
            $countVotedBOT = VotingSelected::
                        join('tbl_voting_position as position','position.id','=','tbl_voting_selected.position_id')
                        ->where('tbl_voting_selected.is_active',true)
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$ids)
                        ->where('tbl_voting_selected.position_id',1)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();    

                 
                        
            $countVotedChapRep = VotingSelected::
                        join('tbl_voting_position as position','position.id','=','tbl_voting_selected.position_id')
                        ->where('tbl_voting_selected.is_active',true)
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$ids)
                        ->where('tbl_voting_selected.position_id',2)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();              


            return view('voting.elect',compact('voting','botCandidate','chapRepCandidate','ids','selectedCandidate','countCandidate','countVotedBOT','countVotedChapRep'));
        
        }              

    }

    public function votingElectionFinal($id)
    {
        $ids = Crypt::decrypt($id);
        
        $checkAnnualDuesPending = ORMaster::where('pps_no',auth()->user()->pps_no)
                                         ->where('payment_dt',null)->count(); 

        $checkAnnualConventionPayment = EventTransaction::
        join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
        ->leftJoin('tbl_event_category as category','category.id','=','event.category_id')
        ->where('tbl_event_transaction.is_active',true)
        ->where('category.name','ANNUAL CONVENTION')
        ->where('tbl_event_transaction.pps_no',auth()->user()->pps_no)
        ->count(); 

        //NEED TO MODIFY THE DATE/TIME MANUALLY
        $checkAnnualConventionPaymentTime = EventTransaction::
                join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
                ->leftJoin('tbl_event_category as category','category.id','=','event.category_id')
                ->where('tbl_event_transaction.is_active',true)
                ->where('category.name','ANNUAL CONVENTION')
                ->where('tbl_event_transaction.pps_no',auth()->user()->pps_no)
                // ->where('tbl_event_transaction.joined_dt','>=', '2024-04-07 12:00:00')
                ->count(); 


        $checkifvoted = VotingTransaction::where('is_active',true)
                        ->where('status','COMPLETED')
                        ->where('voting_id',$ids)
                        ->where('pps_no',auth()->user()->pps_no)
                        ->count();      

        if($checkifvoted >= 1)
        {
            return redirect('voting-listing')->withStatus('alreadyvoted');
        }  
        else
        {
            $voting = Voting::where('is_active',true)
            ->where('id',$ids)
            ->first();

            $botCandidate = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name'
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',1)
                        ->where('voting_id',$ids)
                        ->orderBy('member.last_name', 'ASC')
                        ->get();     
                        
            $chapRepCandidate = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name'
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',2)
                        ->where('voting_id',$ids)
                        ->orderBy('chapter.chapter_name', 'DESC')
                        ->get();              
                     

            $countCandidate = VotingSelected::where('is_active',true)
                        ->where('status','PENDING')
                        ->where('voting_id',$ids)
                        ->where('pps_no',auth()->user()->pps_no)
                        ->count();      
                        
            $countVotedBOT = VotingSelected::
                        join('tbl_voting_position as position','position.id','=','tbl_voting_selected.position_id')
                        ->where('tbl_voting_selected.is_active',true)
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$ids)
                        ->where('tbl_voting_selected.position_id',1)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();    

                 
                        
            $countVotedChapRep = VotingSelected::
                        join('tbl_voting_position as position','position.id','=','tbl_voting_selected.position_id')
                        ->where('tbl_voting_selected.is_active',true)
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$ids)
                        ->where('tbl_voting_selected.position_id',2)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();              


            return view('voting.election',compact('voting','botCandidate','chapRepCandidate','ids',
                        'countCandidate','countVotedBOT','countVotedChapRep'));
        
        }              

    }



    public function votingSelectCandidate(Request $request)
    {
        $voting = Voting::where('is_active',true)
            ->where('id',$request->voting_id)
            ->first();

        
        $countCandidateIfVoted = VotingSelected::where('is_active',true)
            ->where('status','PENDING')
            ->where('voting_id',$request->voting_id)
            ->where('pps_no',auth()->user()->pps_no)
            ->where('candidate_pps_no',$request->pps_no)
            ->count();    

        $countVotedBOT = VotingSelected::where('tbl_voting_selected.is_active',true)
                        ->join('tbl_candidate as candidate','candidate.pps_no','=','tbl_voting_selected.candidate_pps_no')
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$request->voting_id)
                        ->where('candidate.position_id',1)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();

        $countVotedChapRep = VotingSelected::where('tbl_voting_selected.is_active',true)
                        ->join('tbl_candidate as candidate','candidate.pps_no','=','tbl_voting_selected.candidate_pps_no')
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$request->voting_id)
                        ->where('candidate.position_id',2)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();
          


        if($countCandidateIfVoted >= 1)
        {
            return "existcandidate";
        }  

        else if($countVotedBOT >= $voting->bot_max_vote)
        {
            return "exceedBOT";
        }        
        else if($countVotedChapRep >= $voting->bot_max_vote)
        {
            return "exceedChapRep";
        }   
             
        else
        {
            $selected = new VotingSelected();
            $selected->created_by = auth()->user()->name;
            $selected->is_active = true;
            $selected->status = "PENDING";
            $selected->voting_id = $request->voting_id;
            $selected->pps_no = auth()->user()->pps_no;
            $selected->candidate_pps_no = $request->pps_no;
    
            $selected->save();
    
            return "success";
        }

   
    }


    public function votingSelectCandidateBOT(Request $request)
    {
        $voting = Voting::where('is_active',true)
            ->where('id',$request->voting_id)
            ->first();

        
        $countCandidateIfVoted = VotingSelected::where('is_active',true)
            ->where('status','PENDING')
            ->where('voting_id',$request->voting_id)
            ->where('pps_no',auth()->user()->pps_no)
            ->where('candidate_pps_no',$request->pps_no)
            ->count();    

        $countVotedBOT = VotingSelected::where('tbl_voting_selected.is_active',true)
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$request->voting_id)
                        ->where('tbl_voting_selected.position_id',1)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();

          
        if($countCandidateIfVoted >= 1)
        {
            return "existcandidate";
        }  

        else if($countVotedBOT >= $voting->bot_max_vote)
        {
            return "exceedBOT";
        }          
             
        else
        {
            $selected = new VotingSelected();
            $selected->created_by = auth()->user()->name;
            $selected->is_active = true;
            $selected->status = "PENDING";
            $selected->voting_id = $request->voting_id;
            $selected->pps_no = auth()->user()->pps_no;
            $selected->candidate_pps_no = $request->pps_no;
            $selected->position_id = 1;
    
            $selected->save();
    
            return "success";
        }

   
    }


    public function votingSelectCandidateChapRep(Request $request)
    {
        $voting = Voting::where('is_active',true)
            ->where('id',$request->voting_id)
            ->first();

        
        $countCandidateIfVoted = VotingSelected::where('is_active',true)
            ->where('status','PENDING')
            ->where('voting_id',$request->voting_id)
            ->where('pps_no',auth()->user()->pps_no)
            ->where('candidate_pps_no',$request->pps_no)
            ->count();    


        $countVotedChapRep = VotingSelected::where('tbl_voting_selected.is_active',true)
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$request->voting_id)
                        ->where('tbl_voting_selected.position_id',2)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();                

          


        if($countCandidateIfVoted >= 1)
        {
            return "existcandidate";
        }  

        else if($countVotedChapRep >= $voting->chaprep_max_vote)
        {
            return "exceedChapRep";
        }          
             
        else
        {
            $selected = new VotingSelected();
            $selected->created_by = auth()->user()->name;
            $selected->is_active = true;
            $selected->status = "PENDING";
            $selected->voting_id = $request->voting_id;
            $selected->pps_no = auth()->user()->pps_no;
            $selected->candidate_pps_no = $request->pps_no;
            $selected->position_id = 2;
    
            $selected->save();
    
            return "success";
        }

   
    }

    public function votingRemoveSelectedCandidate(Request $request)
    {

        $selectedcandidate = VotingSelected::where('candidate_pps_no',$request->pps_no)->delete();

        return "success";
    }

    public function votingFinalize(Request $request)
    {
        $voting = Voting::where('is_active',true)
                        ->where('id',$request->voting_id)
                        ->first();
             

        $transaction = VotingTransaction::where('voting_id',$request->voting_id)
                                         ->where('pps_no',auth()->user()->pps_no)
                                         ->count();

         $countCandidate = VotingSelected::where('is_active',true)
                                         ->where('status','PENDING')
                                         ->where('voting_id',$request->voting_id)
                                         ->where('pps_no',auth()->user()->pps_no)
                                         ->count(); 

        $countVotedBOT = VotingSelected::where('tbl_voting_selected.is_active',true)
                        // ->join('tbl_candidate as candidate','candidate.pps_no','=','tbl_voting_selected.candidate_pps_no')
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$request->voting_id)
                        ->where('tbl_voting_selected.position_id',1)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();
                 
        $countVotedChapRep = VotingSelected::where('tbl_voting_selected.is_active',true)
                        // ->join('tbl_candidate as candidate','candidate.pps_no','=','tbl_voting_selected.candidate_pps_no')
                        ->where('tbl_voting_selected.status','PENDING')
                        ->where('tbl_voting_selected.voting_id',$request->voting_id)
                        ->where('tbl_voting_selected.position_id',2)
                        ->where('tbl_voting_selected.pps_no',auth()->user()->pps_no)
                        ->count();   
                        

        if($countCandidate == 0)
        {
            return "emptycandidate";
        }

        else if($transaction >= 1)
        {
            return "alreadyvoted";
        }
        else if($countVotedChapRep <> $voting->chaprep_max_vote)
        {
            return "lesscandidate";  
        }
                                
        else if($countVotedBOT > $voting->bot_max_vote)
        {
            return "maxbot";
        }

        else if($countVotedChapRep > $voting->chaprep_max_vote)   
        {
            return "maxchaprep";
        }        

        else
        {
            $transaction = new VotingTransaction();
            $transaction->created_by = auth()->user()->name;
            $transaction->is_active = true;
            $transaction->status = "COMPLETED";
            $transaction->voting_id = $request->voting_id;
            $transaction->pps_no = auth()->user()->pps_no;
    
            $transaction->save();
    
            VotingSelected::where('status', '=', 'PENDING')
            ->where('voting_id',$request->voting_id)
            ->where('pps_no',auth()->user()->pps_no)
            ->where('is_active',true)
            ->update(['voting_id' => $request->voting_id,
                'status' => 'COMPLETED',
                'updated_by' => auth()->user()->name,
                'transaction_id' => $transaction->id
               ]);
    
            return "success";
        }                            

    }

    public function votingCheckAllowed(Request $request)
    {
        $transaction = VotingTransaction::where('voting_id',$request->voting_id)
                                         ->where('pps_no',auth()->user()->pps_no)
                                         ->count();

        $checkAnnualDuesPending = ORMaster::where('pps_no',auth()->user()->pps_no)
                                         ->where('payment_dt',null)->count(); 
                      
        $checkAnnualConventionPayment = EventTransaction::
                                        join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
                                        ->leftJoin('tbl_event_category as category','category.id','=','event.category_id')
                                        ->where('tbl_event_transaction.is_active',true)
                                        ->where('category.name','ANNUAL CONVENTION')
                                        ->where('tbl_event_transaction.pps_no',auth()->user()->pps_no)
                                        ->count(); 

        //NEED TO MODIFY THE DATE/TIME MANUALLY
        $checkAnnualConventionPaymentTime = EventTransaction::
                                        join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
                                        ->leftJoin('tbl_event_category as category','category.id','=','event.category_id')
                                        ->where('tbl_event_transaction.is_active',true)
                                        ->where('category.name','ANNUAL CONVENTION')
                                        ->where('tbl_event_transaction.pps_no',auth()->user()->pps_no)
                                        ->where('tbl_event_transaction.joined_dt','>=', '2024-04-07 12:00:00')
                                        ->count(); 
        
                                                

        if($transaction >= 1)
        {
            return "alreadyvoted";
        }
        // else if($checkAnnualDuesPending >= 1)
        // {
        //     return "existannualdues";
        // }
        // elseif($checkAnnualConventionPayment == 0)
        // {
        //     return "notjoined";
        // }
        // else if($checkAnnualConventionPaymentTime >= 1)
        // {
        //     return "paymenttimenotmeet";
        // }
     

        else
        {
            $voting_id = Crypt::encrypt($request->voting_id);
            return $voting_id;
        }

        
    }

    public function votingDetails($id)
    {
        $ids = Crypt::decrypt($id);

        $voting = Voting::where('is_active',true)
                        ->where('id',$ids)
                        ->first();

        $member = MemberInfo::select('tbl_member_info.*')
                        ->where('tbl_member_info.type','MEMBER')
                        ->where('tbl_member_info.is_active',true)
                        ->where('tbl_member_info.status','ACCEPTED')
                        ->orderBy('tbl_member_info.first_name', 'ASC')
                        ->get();                

            

        $candidate = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name'
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('voting_id',$ids)
                        ->orderBy('tbl_candidate.id', 'DESC')
                        ->get();  

        $candidateBOT = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name'
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',1)
                        ->where('voting_id',$ids)
                        ->orderBy('member.last_name', 'ASC')
                        ->get();   

        $candidateChapRep = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name'
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',2)
                        ->where('voting_id',$ids)
                        ->orderBy('chapter.chapter_name', 'DESC')
                        ->get();   

        $candidates = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name',
                        DB::raw("(select count(*) from tbl_voting_selected where voting_id = $ids and candidate_pps_no = tbl_candidate.pps_no) as voting_count")

                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('voting_id',$ids)
                        ->orderBy('voting_count', 'DESC')
                        ->get();  
                        
                        $auth =  auth()->user()->pps_no;

    $candidateVotedBOT = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name',
                           DB::raw("(select count(*) from tbl_voting_selected where voting_id = $ids and pps_no = $auth and candidate_pps_no = tbl_candidate.pps_no) as voted")
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',1)
                        ->where('voting_id',$ids)
                        ->orderBy('tbl_candidate.id', 'DESC')
                        ->get();                     

    $candidateVotedChapRep = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name',
                           DB::raw("(select count(*) from tbl_voting_selected where voting_id = $ids and pps_no = $auth and candidate_pps_no = tbl_candidate.pps_no) as voted")
                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',2)
                        ->where('voting_id',$ids)
                        ->orderBy('tbl_candidate.id', 'DESC')
                        ->get(); 


    $countCandidateBot = Candidate::where('is_active',true)
                        ->where('voting_id',$ids)
                        ->where('position_id',1)
                        ->count();


    $countCandidateChapRep = Candidate::where('is_active',true)
                        ->where('voting_id',$ids)
                        ->where('position_id',1)
                        ->count();

           
                        

        return view('voting.details',compact('voting','candidate','candidates',
                    'candidateBOT','candidateChapRep','candidateVotedChapRep','candidateVotedBOT',
                    'countCandidateBot','countCandidateChapRep','member'));

    }


    public function votingResult($id)
    {
        $ids = Crypt::decrypt($id);

        
        $voting = Voting::where('is_active',true)
                        ->where('id',$ids)
                        ->first();

        $BOTcandidates = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name',
                        DB::raw("(select count(*) from tbl_voting_selected where voting_id = $ids and candidate_pps_no = tbl_candidate.pps_no) as voting_count")

                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',1)
                        ->where('voting_id',$ids)
                        ->orderBy('voting_count', 'DESC')
                        ->get();                    
        

        $ChapRepcandidates = Candidate::select('tbl_candidate.*',
                        'member.first_name','member.middle_name','member.last_name','member.suffix','member.prc_number','member.picture',
                        'chapter.chapter_name',
                        'type.member_type_name',
                        DB::raw("(select count(*) from tbl_voting_selected where voting_id = $ids and candidate_pps_no = tbl_candidate.pps_no) as voting_count")

                        )
                        ->join('tbl_member_info as member','member.pps_no','=','tbl_candidate.pps_no')
                        ->leftJoin('tbl_chapter as chapter','chapter.id','=','member.member_chapter')
                        ->leftJoin('tbl_member_type as type','type.id','=','member.member_type')
                        ->where('tbl_candidate.is_active',true)
                        ->where('tbl_candidate.status','ACTIVE')
                        ->where('tbl_candidate.position_id',2)
                        ->where('voting_id',$ids)
                        ->orderBy('voting_count', 'DESC')
                        ->get();    
        return view('voting.result',compact('voting','BOTcandidates','ChapRepcandidates'));
    }

    

    

    public function votingUpdate(Request $request)
    {
        $voting = Voting::where('is_active',true)
        ->where('id',$request->voting_id)
        ->first();

        
        if($request->hasFile('picture')) 
        {
            $file = $request->file('picture');
            $picture = time().'-'. $file->getClientOriginalName();
            $filePath = 'others/' . $picture;
     
            $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('picture')));
            $path = Storage::disk('s3')->url($path);

            $voting->picture = $picture;
        }
        

        $voting->title = $request->title;
        $voting->date_from = $request->date_from;
        $voting->date_to = $request->date_to;
        $voting->time_from = $request->time_from;
        $voting->time_to = $request->time_to;
        $voting->description = $request->description;
        

        $voting->save();

        return "success";
    }

    public function votingUpdateStatus(Request $request)
    {
        $voting = Voting::where('is_active',true)
        ->where('id',$request->voting_id)
        ->first();
        
        $voting->status = $request->status2;
        $voting->save();

        return "success";
    }

    
    public function votingAddCandidateBotUpdate(Request $request)
    {
 
        $existCandidate = Candidate::where('pps_no',$request->pps_no)
                                    ->where('is_active',true)
                                    ->where('voting_id',$request->voting_id)
                                    ->count();
                    

        if($existCandidate >= 1)
        {
            return "exist";
        }
        else
        {
            $candidate = new Candidate();
            $candidate->created_by = auth()->user()->name;
            $candidate->is_active = true;
            $candidate->status = "ACTIVE";
            $candidate->pps_no = $request->pps_no;
            $candidate->voting_id = $request->voting_id;
            $candidate->position_id = 1;
    
            $candidate->save();
    
            return "completed";
        } 
    
    }



    public function votingAddCandidateChapRepUpdate(Request $request)
    {
 
        $existCandidate = Candidate::where('pps_no',$request->pps_no)
                                    ->where('is_active',true)
                                    ->where('voting_id',$request->voting_id)
                                    ->count();
                    

        if($existCandidate >= 1)
        {
            return "exist";
        }
        else
        {
            $candidate = new Candidate();
            $candidate->created_by = auth()->user()->name;
            $candidate->is_active = true;
            $candidate->status = "ACTIVE";
            $candidate->pps_no = $request->pps_no;
            $candidate->voting_id = $request->voting_id;
            $candidate->position_id = 2;
    
            $candidate->save();
    
            return "completed";
        } 
    
    }



    
}
