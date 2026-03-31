<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DisapproveApplicantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email_address;
    protected $first_name;
    protected $last_name;
    protected $disapprove_reason;
    protected $disapprove_by;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_address,$first_name,$last_name,$disapprove_reason,$disapprove_by)
    {
        //
        $this->email_address = $email_address;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->disapprove_reason = $disapprove_reason;
        $this->disapprove_by = $disapprove_by;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $message = 'Good day ';

        $mail_data = [
            'recipient' => $this->email_address,
            'fromEmail' => 'no-reply@pps.org.ph',
            'fromName' => 'Philippine Pediatric Society Inc.',
            'subject' => 'Member Application',
            'body' => $message,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'applicant_email' => $this->email_address,
            'disapprove_reason' => $this->disapprove_reason,
            'disapprove_by' => $this->disapprove_by
        ];
        \Mail::send('applicants.email-template-disapprove',$mail_data, function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
                    ->from($mail_data['fromEmail'], $mail_data['fromName'])
                    ->subject($mail_data['subject']);
        });
    }
}
