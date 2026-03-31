<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AcceptApplicantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email_address;
    protected $first_name;
    protected $last_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_address,$first_name,$last_name)
    {
        //

        $this->email_address = $email_address;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $message = '';

        $mail_data = [
            'recipient' => $this->email_address,
            'fromEmail' => 'no-reply@pps.org.ph',
            'fromName' => 'Philippine Pediatric Society Inc.',
            'subject' => 'Member Application',
            'body' => $message,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'applicant_email' => $this->email_address
            
        ];
        \Mail::send('applicants.email-template-accept',$mail_data, function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
                    ->from($mail_data['fromEmail'], $mail_data['fromName'])
                    ->subject($mail_data['subject']);
        });
    }
}
