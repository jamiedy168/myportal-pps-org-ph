<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\MemberInfo;

class SendEmailAnnualConventionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $mails = MemberInfo::select('first_name','email_address')->get();
        // $users = MemberInfo::pluck('email_address');

        foreach($mails as $dat)
            {

                    \Mail::send('maintenance.email-annual-convention-bulk-template', ["data1"=>$dat], function($message) use ($dat) {
                    $message->from('no-reply@pps.org.ph', 'Test Reminder');
                    $message->to($dat['email']);
                    $message->subject('Reminder');
                 });

            }

        // $emailsAlumni = ['ricky.gacesp061296@gmail.com', 'ricky.gacesp1296@gmail.com'];

    
        //     $message = '';
        //     $mail_data = [
        //         'recipient' => $emailsAlumni,
        //         'fromEmail' => 'no-reply@pps.org.ph',
        //         'fromName' => 'Philippine Pediatric Society Inc.',
        //         'subject' => 'TEST EMAIL',
        //         'body' => $message,     
        //     ];
    
            
        //     \Mail::send('maintenance.email-annual-convention-bulk-template',$mail_data, function($message) use ($mail_data){
        //         $message->to($mail_data['recipient'])
        //                 ->from($mail_data['fromEmail'], $mail_data['fromName'])
        //                 ->subject($mail_data['subject']);
        //     });
     
        
    }
}
