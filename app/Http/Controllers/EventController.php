<?php

namespace App\Http\Controllers;

use DB;
use Curl;
use Session;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\EventCategory;
use App\Models\ORMaster;
use App\Models\EventCommitteeGroup;
use App\Models\EventCommittee;
use App\Models\EventTransaction;
use App\Models\CPDPoints;
use App\Models\MemberInfo;
use App\Models\EventTopic;
use App\Models\EventOrganizer;
use App\Models\EventOrganizerType;
use App\Models\EventAttend;
use App\Models\MemberType;
use App\Models\EventPrice;
use App\Models\EventSelected;
use App\Models\EventPlenary;
use App\Models\TopicQuestion;
use App\Models\TopicQuestionChoices;
use App\Models\TopicAttendTemp;
use App\Models\Chapter;
use App\Models\CertificateMaintenance;
use App\Jobs\ConventionJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Intervention\Image\Laravel\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Crypt;

class EventController extends Controller
{
    // private $pps_url = 'https://dev.pps.org.ph/';
    private $pps_url = 'https://portal.pps.org.ph/';
    // private $pps_url = 'http://127.0.0.1:8000/';



    public function downloadCertificate($folder, $filename, $id)
    {

        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->where('id',$id)
        ->first();

        $certificate_maintenance = CertificateMaintenance::select( 'tbl_certificate_maintenance.*')
        ->where('is_active',true)
        ->where('event_id',$id)
        ->first();


        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        $member_type = ["DIPLOMATE", "FELLOW", "EMERITUS FELLOW", "ACTIVE MEMBER", "GOVERNMENT_PHYSICIAN"];

        if (in_array($member->member_type_name, $member_type)) {
            if($member->suffix == null || $member->suffix == "")
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ', MD';
            }
            else {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix) . ', MD';
            }
            
        } 
        else {
            if($member->suffix == null || $member->suffix == "")
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix);
            }
            else
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . ' ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix);
            }
            
        }

        $encoded_char = mb_encode_numericentity($member_name, array(0x0080, 0xffff, 0, 0xffff), 'UTF-8');


        $cpdpoints = CPDPoints::
        where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
        ->where('tbl_cpd_points.event_id',$id)
        ->sum('points');
        

        if($cpdpoints >= $event->max_cpd)
        {
            $cpdpoints2 = $event->max_cpd;
        }
        else
        {
            $cpdpoints2 = $cpdpoints;
        }


        $fontPath = public_path('assets/fonts/calibri-bold.ttf');
        $fontPath2 = public_path('assets/fonts/NotoSans-Bold.ttf');

        $imagePath = public_path('assets/img/' . $filename);
        $imageContent = file_get_contents($imagePath);
        $image = Image::read($imageContent);
        $width = $image->width();

            // Function to adjust font size
            $adjustFontSizeForWidth = function ($text, $maxWidth, $fontPath2, $fontSize, $angle = 0) {
                do {
                    $box = imagettfbbox($fontSize, $angle, $fontPath2, $text);
                    $textWidth = abs($box[4] - $box[0]);
                    if ($textWidth > $maxWidth) {
                        $fontSize--;
                    }
                } while ($textWidth > $maxWidth && $fontSize > 1);

                return $fontSize;
            };

            $borderWidth = 1;
            $maxWidthWithBorder = $width - (2 * $borderWidth);

             // Adjust font size for member name
             $fontSizeForMemberName = $adjustFontSizeForWidth($encoded_char, $maxWidthWithBorder, $fontPath2, $certificate_maintenance->name_font_size);

        // Add adjusted text
            $image->text($encoded_char, $width / 2, $certificate_maintenance->name_horizontal, function ($font) use ($fontPath2, $fontSizeForMemberName, $certificate_maintenance) {

                // normalize: remove any surrounding quotes and ensure leading #
                $final_member_font_color = '#'.ltrim(trim($certificate_maintenance->name_font_color, " \t\n\r\0\x0B'\""), '#');

                $font->file($fontPath2);
                $font->size($fontSizeForMemberName);
                $font->color($final_member_font_color); 
                $font->align('center');
                $font->valign('top');
            });


            $image->text($cpdpoints2, $certificate_maintenance->cpd_vertical, $certificate_maintenance->cpd_horizontal, function($font) use ($fontPath, $certificate_maintenance){
                
                $final_cpd_font_color = '#'.ltrim(trim($certificate_maintenance->cpd_font_color, " \t\n\r\0\x0B'\""), '#');
                
                $font->file($fontPath);
                $font->size($certificate_maintenance->cpd_font_size);
                $font->color($final_cpd_font_color);
                $font->align('center');
                $font->valign('top');
            });


        $tempImage = tempnam(sys_get_temp_dir(), 'img_') . '.jpg';
        $image->save($tempImage);

            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

        return response()->file($tempImage, $headers)->deleteFileAfterSend(true);


    }

    public function downloadCertificateWebinar($folder, $filename, $id)
    {

        $event = Event::select( 'tbl_event.*','category.name')
        ->leftJoin('tbl_event_category as category','category.id','=','tbl_event.category_id')
        ->where('tbl_event.is_active',true)
        ->where('tbl_event.id',$id)
        ->first();

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        $member_type = ["DIPLOMATE", "FELLOW", "EMERITUS FELLOW", "ACTIVE MEMBER"];

        if (in_array($member->member_type_name, $member_type)) {
            if($member->suffix == null || $member->suffix == "")
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ', MD';
                
            }
            else
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix) . ', MD';
            }
           


        } else {
            if($member->suffix == null || $member->suffix == "")
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix);
            }
            else
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . ' ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix);
            }
            
        }

        $encoded_char = mb_encode_numericentity($member_name, array(0x0080, 0xffff, 0, 0xffff), 'UTF-8');



        $fontPath = public_path('assets/fonts/calibri-bold.ttf');
        $fontPath2 = public_path('assets/fonts/arial-unicode-ms.ttf');

        $imagePath = public_path('assets/img/' . $filename);
        $imageContent = file_get_contents($imagePath);
        $image = Image::read($imageContent);
        $width = $image->width();

            // Function to adjust font size
            $adjustFontSizeForWidth = function ($text, $maxWidth, $fontPath2, $fontSize, $angle = 0) {
                do {
                    $box = imagettfbbox($fontSize, $angle, $fontPath2, $text);
                    $textWidth = abs($box[4] - $box[0]);
                    if ($textWidth > $maxWidth) {
                        $fontSize--;
                    }
                } while ($textWidth > $maxWidth && $fontSize > 1);

                return $fontSize;
            };

            $borderWidth = 1;
            $maxWidthWithBorder = $width - (2 * $borderWidth);

             // Adjust font size for member name
             $fontSizeForMemberName = $adjustFontSizeForWidth($encoded_char, $maxWidthWithBorder, $fontPath2, 210);

        

        // Add adjusted text
            $image->text($encoded_char, $width / 2, 1750, function ($font) use ($fontPath2, $fontSizeForMemberName) {
                $font->file($fontPath2);
                $font->size($fontSizeForMemberName);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
            });


        $tempImage = tempnam(sys_get_temp_dir(), 'img_') . '.jpg';
        $image->save($tempImage);

            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

        return response()->file($tempImage, $headers)->deleteFileAfterSend(true);


    }



    public function downloadCertificate2($folder, $filename, $id, $ids)
    {

        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->where('id',$id)
        ->first();

        $certificate_maintenance = CertificateMaintenance::select( 'tbl_certificate_maintenance.*')
        ->where('is_active',true)
        ->where('event_id',$id)
        ->first();




        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',$ids)
        ->first();

        $member_type = ["DIPLOMATE", "FELLOW", "EMERITUS FELLOW", "ACTIVE MEMBER", "GOVERNMENT_PHYSICIAN"];


        if (in_array($member->member_type_name, $member_type)) {
            if($member->suffix == null || $member->suffix == "")
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ', MD';
            }
            else {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix) . ', MD';
            }
            
        } else {
            if($member->suffix == null || $member->suffix == "")
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix);
            }
            else
            {
                $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . ' ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix);
            }
        }

        $encoded_char = mb_encode_numericentity($member_name, array(0x0080, 0xffff, 0, 0xffff), 'UTF-8');


        $cpdpoints = CPDPoints::
        where('tbl_cpd_points.is_active',true)
        ->where('tbl_cpd_points.pps_no',$ids)
        ->where('tbl_cpd_points.event_id',$id)
        ->sum('points');


        if($cpdpoints >= $event->max_cpd)
        {
            $cpdpoints2 = $event->max_cpd;
        }
        else
        {
            $cpdpoints2 = $cpdpoints;
        }

        $fontPath = public_path('assets/fonts/calibri-bold.ttf');
        $fontPath2 = public_path('assets/fonts/NotoSans-Bold.ttf');

        $imagePath = public_path('assets/img/' . $filename);
        $imageContent = file_get_contents($imagePath);
        $image = Image::read($imageContent);
        $width = $image->width();

            // Function to adjust font size
            $adjustFontSizeForWidth = function ($text, $maxWidth, $fontPath2, $fontSize, $angle = 0) {
                do {
                    $box = imagettfbbox($fontSize, $angle, $fontPath2, $text);
                    $textWidth = abs($box[4] - $box[0]);
                    if ($textWidth > $maxWidth) {
                        $fontSize--;
                    }
                } while ($textWidth > $maxWidth && $fontSize > 1);

                return $fontSize;
            };

            $borderWidth = 1;
            $maxWidthWithBorder = $width - (2 * $borderWidth);

                // Adjust font size for member name
                $fontSizeForMemberName = $adjustFontSizeForWidth($encoded_char, $maxWidthWithBorder, $fontPath2, $certificate_maintenance->name_font_size);

        

        // Add adjusted text
            $image->text($encoded_char, $width / 2, $certificate_maintenance->name_horizontal, function ($font) use ($fontPath2, $fontSizeForMemberName,$certificate_maintenance) {
                
                // normalize: remove any surrounding quotes and ensure leading #
                $final_member_font_color = '#'.ltrim(trim($certificate_maintenance->name_font_color, " \t\n\r\0\x0B'\""), '#');

                $font->file($fontPath2);
                $font->size($fontSizeForMemberName);
                $font->color($final_member_font_color); 
                $font->align('center');
                $font->valign('top');
            });


            $image->text($cpdpoints2, $certificate_maintenance->cpd_vertical, $certificate_maintenance->cpd_horizontal, function($font) use ($fontPath, $certificate_maintenance){
                
                $final_cpd_font_color = '#'.ltrim(trim($certificate_maintenance->cpd_font_color, " \t\n\r\0\x0B'\""), '#');
                
                $font->file($fontPath);
                $font->size($certificate_maintenance->cpd_font_size);
                $font->color($final_cpd_font_color);
                $font->align('center');
                $font->valign('top');
            });


        $tempImage = tempnam(sys_get_temp_dir(), 'img_') . '.jpg';
        $image->save($tempImage);

            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

        return response()->file($tempImage, $headers)->deleteFileAfterSend(true);
    
    }


    public function downloadCertificateWebinar2($folder, $filename, $id, $ids)
    {

        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->where('id',$id)
        ->first();

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',$ids)
        ->first();

        $member_type = ["DIPLOMATE", "FELLOW", "EMERITUS FELLOW", "ACTIVE MEMBER"];

        if (in_array($member->member_type_name, $member_type)) {
            $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix) . ', MD';


        } else {
            $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . ' ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix);

        }

        $encoded_char = mb_encode_numericentity($member_name, array(0x0080, 0xffff, 0, 0xffff), 'UTF-8');




        $fontPath = public_path('assets/fonts/calibri-bold.ttf');
        $fontPath2 = public_path('assets/fonts/arial-unicode-ms.ttf');

        $imagePath = public_path('assets/img/' . $filename);
        $imageContent = file_get_contents($imagePath);
        $image = Image::read($imageContent);
        $width = $image->width();

            // Function to adjust font size
            $adjustFontSizeForWidth = function ($text, $maxWidth, $fontPath2, $fontSize, $angle = 0) {
                do {
                    $box = imagettfbbox($fontSize, $angle, $fontPath2, $text);
                    $textWidth = abs($box[4] - $box[0]);
                    if ($textWidth > $maxWidth) {
                        $fontSize--;
                    }
                } while ($textWidth > $maxWidth && $fontSize > 1);

                return $fontSize;
            };

            $borderWidth = 1;
            $maxWidthWithBorder = $width - (2 * $borderWidth);

                // Adjust font size for member name
                $fontSizeForMemberName = $adjustFontSizeForWidth($encoded_char, $maxWidthWithBorder, $fontPath2, 210);

        

        // Add adjusted text
            $image->text($encoded_char, $width / 2, 1750, function ($font) use ($fontPath2, $fontSizeForMemberName) {
                $font->file($fontPath2);
                $font->size($fontSizeForMemberName);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
            });



        $tempImage = tempnam(sys_get_temp_dir(), 'img_') . '.jpg';
        $image->save($tempImage);

            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

        return response()->file($tempImage, $headers)->deleteFileAfterSend(true);
    
    }


    public function eventList()
    {

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        if($member == null)
        {
            $mem_type = 0;
        }
        else
        {
            $mem_type = $member->member_type;
        }


        $pps_no = auth()->user()->pps_no;

        $event = Event::select(
                'tbl_event.*',
                DB::raw("(SELECT file_name 
                          FROM tbl_event_image 
                          WHERE event_id = tbl_event.id 
                            AND is_active = true 
                            AND status = 'UPLOADED' 
                            AND type_of_event_image = 'BANNER' 
                          ORDER BY id ASC 
                          LIMIT 1) as event_image"),
                DB::raw("(SELECT price 
                          FROM tbl_event_price 
                          WHERE event_id = tbl_event.id 
                            AND is_active = true 
                            AND member_type_id = $mem_type 
                          LIMIT 1) as prices"),
                DB::raw("(SELECT id 
                          FROM tbl_event_attend 
                          WHERE event_id = tbl_event.id 
                            AND is_active = true 
                            AND pps_no = '$pps_no'
                            AND topic_id = (
                                SELECT id 
                                FROM tbl_event_topic
                                WHERE event_id = tbl_event.id 
                                  AND is_active = true 
                                  AND is_business_meeting = true 
                                ORDER BY id ASC 
                                LIMIT 1
                            ) 
                          ORDER BY id DESC 
                          LIMIT 1) as business_meeting_attend_id")
            )
            ->where('is_active', true)
            ->get();

        
        return view('events.listing',compact('event','member'));
    }



    public function eventView($id)
    {

       

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        if($member == null)
        {
            $mem_type = 0;
        }
        else
        {
            $mem_type = $member->member_type;
        }

        $ids = Crypt::decrypt($id);
        $organizerCount = EventOrganizer::where('is_active',true)
                                        ->where('event_id',$ids)
                                        ->where('pps_no', $member->pps_no)
                                        ->count();

                

        $event = Event::select('tbl_event.*','category.name as category',
        DB::raw("(select price from tbl_event_price where event_id = tbl_event.id and is_active = true and member_type_id = $mem_type) as prices"),
        )
        ->where('tbl_event.id',$ids)
        ->join('tbl_event_category as category','category.id','=','tbl_event.category_id')
        ->first();

        $session = $event->session;
        $firstImage = EventImage::where('is_active',true)->where('status','UPLOADED')->where('event_id',$ids)->where('type_of_event_image','BANNER')->orderBy('id','asc')->first();
        $eventImage = EventImage::where('is_active',true)->where('status','UPLOADED')->where('event_id',$ids)->where('type_of_event_image','BANNER')->orderBy('id','asc')->get();

        $eventTransactionCount = EventTransaction::where('is_active',true)->where('event_id',$ids)->where('pps_no',auth()->user()->pps_no)->count();
        $eventTransaction = EventTransaction::select('tbl_event_transaction.id','tbl_event_transaction.joined_dt','tbl_event_transaction.paid',
                                                    'tbl_or_master.payment_mode','tbl_or_master.payment_dt')
                                            ->leftJoin('tbl_or_master','tbl_or_master.transaction_id','=','tbl_event_transaction.id')
                                            ->where('tbl_event_transaction.is_active',true)->where('event_id',$ids)
                                            ->where('tbl_event_transaction.pps_no',auth()->user()->pps_no)
                                            ->first();

        $eventTopic = EventTopic::where('is_active',true)->where('event_id',$ids)->orderBy('id','asc')->paginate(10);
        // $business_meeting_topic = EventTopic::where('is_active',true)
        //                                     ->where('event_id',$ids)
        //                                     ->where('is_business_meeting',true)
        //                                     ->orderBy('id','asc')
        //                                     ->first();

        // $business_meeting_attend = EventAttend::where('is_active',true)
        //         ->where('event_id',$ids)
        //         ->where('pps_no',auth()->user()->pps_no)
        //         ->where('topic_id',$business_meeting_topic->id)
        //         ->orderBy('id','DESC')
        //         ->first();


        $business_meeting_attend = EventAttend::where('is_active', true)
            ->where('event_id', $ids)
            ->where('pps_no', auth()->user()->pps_no)
            ->where('topic_id', function ($query) use ($ids) {
                $query->select('id')
                    ->from('tbl_event_topic')
                    ->where('is_active', true)
                    ->where('event_id', $ids)
                    ->where('is_business_meeting', true)
                    ->orderBy('id', 'asc')
                    ->limit(1);
            })
            ->orderBy('id', 'desc')
            ->first();
                                                         


        return view('events.view',compact('event','eventImage','firstImage','eventTransactionCount','eventTransaction','eventTopic','member','business_meeting_attend','organizerCount'));
   
    }



    public function eventOnlineVideo()
    {

        $pps = auth()->user()->pps_no;

        $event = Event::select( 'tbl_event.*',
        DB::raw("(select count(*) from tbl_event_topic where event_id = tbl_event.id and is_active = true) as topic_count"),
        DB::raw("(select id as topic_id from tbl_event_topic where event_id = tbl_event.id and is_active = true and with_examination = true order by id asc LIMIT 1) as topic_ids"),
        DB::raw("(select count(*) from tbl_event_transaction where event_id = tbl_event.id and is_active = true and pps_no = $pps) as count_attend")
        )
            ->where('is_active',true)
            ->orderBy('id','DESC')
            ->paginate(10);


        return view('events.online-video',compact('event'));
    }


    public function eventOnlineVideoSearch(Request $request)
    {
        $name = $request->input('searchinput');

        $event = Event::select( 'tbl_event.*',
        DB::raw("(select count(*) from tbl_event_topic where event_id = tbl_event.id and is_active = true) as topic_count"),
        DB::raw("(select id as topic_id from tbl_event_topic where event_id = tbl_event.id and is_active = true order by id asc LIMIT 1) as topic_ids")
        )
            ->where('is_active',true)
            ->where('title','ILIKE', "%$name%")
            ->orderBy('id','DESC')
            ->paginate(10);



            return view('events.online-video',compact('event'));
    }

    public function eventOnlineVideoView($topic_ids)
    {

        $topic_ids2 = Crypt::decrypt($topic_ids);


        $eventTopicDetails = EventTopic::select('tbl_event_topic.*','tbl_event.title','tbl_event.max_cpd')
                            ->leftJoin('tbl_event','tbl_event.id','=','tbl_event_topic.event_id')
                            ->where('tbl_event_topic.is_active',true)
                            ->where('tbl_event_topic.id',$topic_ids2)
                            ->orderBy('tbl_event_topic.order','DESC')
                            ->first();

        $event = Event::select('tbl_event.*')
                            ->where('tbl_event.is_active',true)
                            ->where('tbl_event.id',$eventTopicDetails->event_id)
                            ->first();     
                            
        if($event->status == "COMPLETED")
        {   if(!$event->for_virtual_viewing == true)
            {
                return redirect('event-online-video');
            }  
        }



        $checkEventPaid = EventTransaction::where('is_active',true)
                        ->where('pps_no',auth()->user()->pps_no)
                        ->where('event_id',$eventTopicDetails->event_id)
                        ->count();



        if($checkEventPaid == 0)
        {
            return redirect('event-online-video');
        }


        $cpdpoints = CPDPoints::
                            where('tbl_cpd_points.is_active',true)
                            ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
                            ->where('tbl_cpd_points.event_id',$eventTopicDetails->event_id)
                            ->sum('points');



        $eventTopic = EventTopic::where('is_active',true)
                                ->where('event_id',$eventTopicDetails->event_id)
                                ->where(function($query) {
                                    $query->where('is_business_meeting', '!=', true)
                                          ->orWhereNull('is_business_meeting');
                                })

                                ->orderBy('order','ASC')
                                ->paginate(15);

        //CHECK IF MEMBER HAS ALREADY CLICK THE ATTEND BUTTON
        $topic_attend_count = EventAttend::where('is_active',true)
        ->where('event_id',$eventTopicDetails->event_id)
        ->where('pps_no',auth()->user()->pps_no)
        ->where('topic_id',$topic_ids2)
        ->count();



        $eventTransaction = EventTransaction::where('is_active',true)
        ->where('pps_no',auth()->user()->pps_no)
        ->where('paid',true)
        ->where('event_id',$eventTopicDetails->event_id)
        ->first();




        return view('events.online-video-view',compact('eventTopicDetails','eventTopic','topic_attend_count','checkEventPaid','cpdpoints','eventTransaction','event'));
    }



    public function eventCreate()
    {
        $eventImage = EventImage::where('is_active',true)->where('status','PENDING')->get();

        $eventCategory = EventCategory::where('is_active',true)->get();

        $organizer = EventOrganizer::select('member.first_name','member.middle_name','member.last_name','member.suffix','member.picture','tbl_event_organizer_list.pps_no','organizer_type.organizer_type')
        ->join('tbl_member_info as member','member.pps_no','=','tbl_event_organizer_list.pps_no')
        ->join('tbl_event_organizer_type as organizer_type','organizer_type.id','=','tbl_event_organizer_list.organizer_type_id')
        ->where('tbl_event_organizer_list.is_active',true)
        ->where('tbl_event_organizer_list.status','PENDING')
        ->orderBy('tbl_event_organizer_list.id','asc')->get();

        $organizerCount = EventOrganizer::where('is_active',true)->where('status','PENDING')->count();

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('status','!=','PENDING')
        ->get();

        $organizer_type = EventOrganizerType::select('tbl_event_organizer_type.*')
        ->where('tbl_event_organizer_type.is_active',true)
        ->get();

        $member_type = MemberType::select('tbl_member_type.*')
        ->where('tbl_member_type.is_active',true)
        ->orderBy('tbl_member_type.id','ASC')
        ->get();


        return view('events.create',compact('eventImage','eventCategory','member','organizer','organizerCount','organizer_type','member_type'));
    }


    public function eventSave(Request $request)
    {

        $event = new Event();
        $event->created_by = auth()->user()->name;
        $event->is_active = true;
        $event->status = 'UPCOMING';
        $event->title = strtoupper($request->title);
        $event->category_id = $request->category;
        $event->start_dt = $request->start_dt;
        $event->end_dt = $request->end_dt;
        $event->venue = $request->venue;
        $event->description = $request->description;
        $event->price = $request->price;
        $event->points = $request->points;
        $event->participant_limit = $request->participant_limit;
        $event->examination_category = $request->examination_category;
        $event->session = $request->session;

        $event->save();

        $eventImage = EventImage::where('is_active',true)->where('status','PENDING')->where('session',$request->session)->update(['status'=>'UPLOADED','event_id'=>$event->id,'updated_by'=>auth()->user()->name]);

        $eventComittee = EventCommittee::where('is_active',true)->where('status','PENDING')->where('session',$request->session)->update(['status'=>'ACTIVE','event_id'=>$event->id,'updated_by'=>auth()->user()->name]);



        return Response()->json([
            "success" => true,
            "url"=>url('/event-listing')

      ]);

    }


    public function eventCreateSave(Request $request)
    {


        $event = new Event();
        $event->created_by = auth()->user()->name;
        $event->is_active = true;
        $event->status = 'UPCOMING';
        $event->title = strtoupper($request->event_title);
        $event->category_id = $request->event_category;
        $event->examination_category = $request->event_examination_category;
        $event->start_dt = $request->event_date_from;
        $event->end_dt = $request->event_date_to;
        $event->start_time = $request->event_start_time;
        $event->end_time = $request->event_end_time;
        $event->venue = $request->event_venue;
        $event->max_cpd = $request->max_cpd;
        $event->description = $request->event_description;
        $event->selected_members = $request->selected_members;


        $event->save();

        $last_insert = $event->id;



        foreach($request->member_type_id as $key =>$count){
            $member_price = array(
                    'is_active'=>true,
                    'created_by'=>auth()->user()->name,
                    'event_id'=>$last_insert,
                    'member_type_id'=>$request->member_type_id [$key],
                    'price'=>$request->event_price [$key],
                );

                EventPrice::insert($member_price);

        }


        foreach($request->event_topic as $key =>$count){
            $event_topic = array(
                'is_active'=>true,
                'created_by'=>auth()->user()->name,
                'event_id'=>$last_insert,
                'topic_name'=>$request->event_topic [$key],
                'points_on_site'=>$request->points_onsite [$key],
                'points_online'=>$request->points_online [$key],
                'max_attendee'=>$request->event_max_attendee [$key],
                'with_examination'=>$request->with_examination [$key],
            );

            EventTopic::insert($event_topic);
        }


        $eventImage = EventImage::where('is_active',true)->where('status','PENDING')->where('session',$request->session)->update(['status'=>'UPLOADED','event_id'=>$event->id,'updated_by'=>auth()->user()->name]);
        $eventOrganizer = EventOrganizer::where('is_active',true)->where('status','PENDING')->where('session',$request->session)->update(['status'=>'ACTIVE','event_id'=>$event->id,'updated_by'=>auth()->user()->name]);

        $event_cert = EventImage::where('event_id',$event->id)
                                    ->where('status','UPLOADED')
                                    ->where('type_of_event_image','CERTIFICATE')
                                    ->first();
        $eventupdate = Event::where('id',$event->id)->first();
        $eventupdate->certificate_image = $event_cert ? $event_cert->file_name : null;
        $eventupdate->save();              

        return Response()->json([
            "success" => true,
            "url"=>url('/event-listing')

      ]);
    }

    public function eventUpdateSubmit(Request $request)
    {

        $event_update = Event::where('is_active',true)->where('id',$request->id)->first();


        $event_update->is_active = true;
        $event_update->updated_by = auth()->user()->name;
        $event_update->title = strtoupper(trim($request->title));
        $event_update->category_id = $request->category;
        $event_update->start_dt = $request->start_dt;
        $event_update->end_dt = $request->end_dt;
        $event_update->venue = $request->venue;
        $event_update->description = $request->description;
        $event_update->price = $request->price;
        $event_update->points = $request->points;
        $event_update->participant_limit = $request->participant_limit;
        $event_update->examination_category = $request->examination_category;
        $event_update->status = $request->status;
        $event_update->save();


        $eventImage = EventImage::where('is_active',true)->where('status','PENDING')->where('event_id',$request->id)->update(['status'=>'UPLOADED']);



        return Response()->json([
            "success" => true,
            "url"=>url('/event-listing')

      ]);

    }

    public function eventImageUpload(Request $request)
    {

        return $request->token2;
    }

    public function getEventCalendar()
    {
        $events = Event::select('title','start_dt as start','end_dt as end','cat.name as category')->where('tbl_event.is_active',true)->join('tbl_event_category as cat','cat.id','=','tbl_event.category_id')->get();

        return response()->json($events);
    }

    public function checkExistEvent(Request $request)
    {
        $event = Event::where('title',strtoupper(trim($request->title)))
        ->where('start_dt',$request->start_dt)
        // ->where('end_dt',$request->end_dt)
        ->where('category_id',$request->category)
        ->where('is_active',true)
        ->exists();

        return $event;

    }

    public function checkExistEventSameId(Request $request)
    {
        $event = Event::where('title',strtoupper(trim($request->title)))
        ->where('start_dt',$request->start_dt)
        ->where('id','!=',$request->id)
        // ->where('end_dt',$request->end_dt)
        ->where('category_id',$request->category)
        ->where('is_active',true)
        ->exists();

        return $event;

    }



    public function eventImage(Request $request)
    {
        if($request->hasFile('certificate_image')) 
            {
                $count_cert = EventImage::where('status','PENDING')->count();
                if($count_cert >= 1)
                {
                    $cert = EventImage::where('status','PENDING')
                                        ->update(['updated_by' => auth()->user()->name,
                                            'status' => 'REMOVE',    
                                            ]);
                }


                $event_certificate = $request->file('certificate_image');
                $cert_picture = time() . '-' . str_replace(' ', '', trim($event_certificate->getClientOriginalName()));

                $cert_filePath = 'event/' . $cert_picture;
        
                $cert_path = Storage::disk('s3')->put($cert_filePath, file_get_contents($event_certificate = $request->file('certificate_image')));
                $cert_path = Storage::disk('s3')->url($cert_path);
    

                $certificate = new EventImage();
                $certificate->is_active = true;
                $certificate->created_by = auth()->user()->name;
                $certificate->status = 'PENDING';
                $certificate->original_file_name = $event_certificate->getClientOriginalName();
                $certificate->file_name = $cert_picture;
                $certificate->file_type = $event_certificate->getClientOriginalExtension();
                $certificate->session = $request->session;
                $certificate->type_of_event_image = 'CERTIFICATE';
                
                $certificate->save();


            }    
            

        if($request->TotalFiles > 0)
        {  
           for ($x = 0; $x < $request->TotalFiles; $x++)
           {

               if ($request->hasFile('files'.$x))
                {
                    $file = $request->file('files'.$x);
                    $name = time().'-'. $file->getClientOriginalName();
                    $filePath = 'event/' . $name;

                    $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('files'.$x)));
                    $path = Storage::disk('s3')->url($path);


                    $original_name = $file->getClientOriginalName();
                    $file_type = $file->getClientOriginalExtension();


                    $eventImage[$x]['original_file_name'] = $original_name;
                    $eventImage[$x]['file_name'] = $name;
                    $eventImage[$x]['file_type'] = $file_type;
                    $eventImage[$x]['is_active'] = true;
                    $eventImage[$x]['status'] = 'PENDING';
                    $eventImage[$x]['created_by'] = auth()->user()->name;
                    $eventImage[$x]['updated_by'] = auth()->user()->name;
                    $eventImage[$x]['session'] = $request->session;
                    $eventImage[$x]['type_of_event_image'] = 'BANNER';


                }


           }

            EventImage::insert($eventImage);
            return response()->json(['success'=>'Multiple fIle has been uploaded']);
        }
        else
        {
           return response()->json(["message" => "Please try again."]);
        }

    }

    public function eventImage2(Request $request)
    {


        if($request->TotalFiles > 0)
        {

           for ($x = 0; $x < $request->TotalFiles; $x++)
           {

               if ($request->hasFile('files'.$x))
                {
                    $file = $request->file('files'.$x);
                    $name = time().'-'. $file->getClientOriginalName();
                    $filePath = 'event/' . $name;

                    $path = Storage::disk('s3')->put($filePath, file_get_contents($file = $request->file('files'.$x)));
                    $path = Storage::disk('s3')->url($path);


                    $original_name = $file->getClientOriginalName();
                    $file_type = $file->getClientOriginalExtension();


                    $eventImage[$x]['original_file_name'] = $original_name;
                    $eventImage[$x]['file_name'] = $name;
                    $eventImage[$x]['file_type'] = $file_type;
                    $eventImage[$x]['is_active'] = true;
                    $eventImage[$x]['status'] = 'PENDING';
                    $eventImage[$x]['created_by'] = auth()->user()->name;
                    $eventImage[$x]['updated_by'] = auth()->user()->name;
                    $eventImage[$x]['event_id'] = $request->event_id;


                }


           }

            EventImage::insert($eventImage);
            return response()->json(['success'=>'File has been uploaded']);
        }
        else
        {
           return response()->json(["message" => "Please try again."]);
        }



    }

    public function eventImageDelete(Request $request)
    {
        $delete = EventImage::where('id',$request->delete_id)->first();
        $delete -> is_active =  false;
        $delete -> status =  'REMOVE';

        $delete->save();


    }


    public function eventImageDelete2(Request $request)
    {
        $delete = EventImage::where('id',$request->delete_id)->first();
        $delete -> is_active =  false;
        $delete -> status =  'REMOVE';

        $delete->save();


    }

    public function eventRemoveDelete(Request $request)
    {
        $delete = EventImage::where('id',$request->id)->first();
        $delete -> is_active =  false;
        $delete -> status =  'REMOVE';

        $delete->save();

        return "success";
    }


    public function eventJoin(Request $request)
    {
        // $ids = $request->event_id;
        // dd($ids);
        $checkUserEvent = EventTransaction::where('pps_no',$request->pps_no)->where('event_id',$request->event_id)->count();
        if($checkUserEvent >= 1)
        {
            return Response()->json([
                "success" => true,
                "url"=>url('/event-listing'),
                "exist" => true

          ]);
        }
        else{
            if($request->price == 0)
            {

                $transaction = new EventTransaction();
                $transaction->is_active = true;
                $transaction->created_by = auth()->user()->name;
                $transaction->pps_no = auth()->user()->pps_no;
                $transaction->event_id = $request->event_id;
                $transaction->paid = true;
                $transaction->joined_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');

                $transaction->save();
                $event_transaction_id = $transaction->id;

                return Response()->json([
                    "success" => true,
                    "event_transaction_id" =>  Crypt::encrypt($event_transaction_id),
                    "amount" => "free"

                ]);
            }
            else
            {
                $transaction = new EventTransaction();
                $transaction->is_active = true;
                $transaction->created_by = auth()->user()->name;
                $transaction->pps_no = auth()->user()->pps_no;
                $transaction->event_id = $request->event_id;
                $transaction->paid = false;
                $transaction->joined_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');

                $transaction->save();
                $event_transaction_id = $transaction->id;

                return Response()->json([
                    "success" => true,
                    "event_transaction_id" =>  Crypt::encrypt($event_transaction_id),
                    "amount" => "not_free"

                ]);
            }

        }



    }


    public function eventCheckJoined(Request $request)
    {

        $member_info = MemberInfo::where('pps_no', $request->pps_no)->first();

    
        $checkAnnualDuesPending = ORMaster::where('pps_no',$request->pps_no)
                                            ->where('payment_dt',null)
                                            ->count();

        $checkOrganizer = EventOrganizer::where('is_active',true)
                                        ->where('event_id',$request->event_id)
                                        ->where('pps_no',$request->pps_no)
                                        ->count();

        $checkUserEvent = EventTransaction::where('pps_no',$request->pps_no)
                                        ->where('event_id',$request->event_id)
                                        ->count();


        $checkUserEventSelected = EventSelected::where('pps_no',$request->pps_no)
                                        ->where('event_id',$request->event_id)
                                        ->count();

        $event = Event::where('id',$request->event_id)->first();

        $event_id = Crypt::encrypt($request->event_id);

        if($event->selected_members == true && ($checkUserEventSelected == 0 || $checkUserEventSelected == null))
        {
            return Response()->json([
                "success" => true,
                "action" => "notselected"


            ]);
        }
        else if($checkAnnualDuesPending >= 1 && in_array($member_info->member_type, ['2', '3', '4'])) 
            {
            if($request->price == 0)
            {

                $transaction = new EventTransaction();
                $transaction->is_active = true;
                $transaction->created_by = auth()->user()->name;
                $transaction->pps_no = auth()->user()->pps_no;
                $transaction->event_id = $request->event_id;
                $transaction->paid = true;
                $transaction->joined_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');

                $transaction->save();

                return Response()->json([
                    "success" => true,
                    "action" => "free",

                ]);
            }
            else
            {
                return Response()->json([
                    "success" => true,
                    "action" => "annualduespending",
                    "url"=>url('/event-payment-final/'.$event_id)
    
                ]);
            }
            
        }
        else if($checkOrganizer >= 1)
        {
            return Response()->json([
                "success" => true,
                "action" => "organizer",
                "url"=>url('/event-payment-final/'.$event_id)

            ]);

        }
        else if($checkUserEvent >= 1)
        {
            return Response()->json([
                "success" => true,
                "action" => "exist",
                "url"=>url('/event-payment-final/'.$event_id)

            ]);

        }

        else
        {

            if($request->price == 0)
            {

                $transaction = new EventTransaction();
                $transaction->is_active = true;
                $transaction->created_by = auth()->user()->name;
                $transaction->pps_no = auth()->user()->pps_no;
                $transaction->event_id = $request->event_id;
                $transaction->paid = true;
                $transaction->joined_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');

                $transaction->save();

                return Response()->json([
                    "success" => true,
                    "action" => "free",

                ]);
            }
            else
            {
                $event_id = Crypt::encrypt($request->event_id);
                return Response()->json([
                    "success" => true,
                    "amount" => "not_free",
                    "url"=>url('/event-payment-final/'.$event_id)

                ]);
            }

        }




        // else{


        // }



    }


    public function eventUpdate($id)
    {

        $ids = Crypt::decrypt($id);



        $attendee = EventTransaction::select('tbl_event_transaction.*','info.first_name','info.middle_name','info.last_name','info.picture')
                                    ->where('tbl_event_transaction.is_active',true)
                                    ->where('tbl_event_transaction.event_id',$ids)
                                    ->join('tbl_member_info as info','info.pps_no','=','tbl_event_transaction.pps_no')->get();

        $attendeeCount = EventTransaction::where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.event_id',$ids)->count();

        $paid = EventTransaction::where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.event_id',$ids)
        ->where('tbl_event_transaction.paid',true)->count();



        $event = Event::select('tbl_event.*','category.name as category')->where('tbl_event.id',$ids)->join('tbl_event_category as category','category.id','=','tbl_event.category_id')->first();
        $session = $event->session;
        $firstImage = EventImage::where('is_active',true)->whereIn('status',['UPLOADED','PENDING'])->where('event_id',$ids)->where('type_of_event_image','BANNER')->orderBy('id','asc')->first();
        $eventImage = EventImage::where('is_active',true)->whereIn('status',['UPLOADED','PENDING'])->where('event_id',$ids)->orderBy('id','asc')->get();

        $eventImageCount = EventImage::where('is_active',true)->whereIn('status',['UPLOADED','PENDING'])->where('event_id',$ids)->orderBy('id','asc')->count();

        $eventTransactionCount = EventTransaction::where('is_active',true)->where('event_id',$ids)->where('pps_no',auth()->user()->pps_no)->count();
        $eventTransaction = EventTransaction::where('is_active',true)->where('event_id',$ids)->where('pps_no',auth()->user()->pps_no)->first();
        $eventCategory = EventCategory::where('is_active',true)->get();

        // $eventComittee = EventCommittee::select('tbl_event_committee_list.*','info.*')
        //                                 ->where('tbl_event_committee_list.is_active',true)
        //                                 ->where('tbl_event_committee_list.status','ACTIVE')
        //                                 ->where('transaction.event_id',$ids)
        //                                 ->join('tbl_event_transaction as transaction','transaction.event_id','=','tbl_event_committee_list.event_id')
        //                                 ->join('tbl_member_info as info','info.pps_no','=','tbl_event_committee_list.pps_no')
        //                                 ->get();

        $eventComittee = EventCommittee::select('tbl_event_committee_list.*','info.*')
        ->where('tbl_event_committee_list.event_id',$ids)
        ->join('tbl_member_info as info','info.pps_no','=','tbl_event_committee_list.pps_no')
        ->paginate(10);

        $eventTopic = EventTopic::where('is_active',true)->where('event_id',$ids)->orderBy('id','asc')->get();


        return view('events.update',compact('event','eventImage','firstImage','eventTransactionCount','eventTransaction','attendee','eventCategory','ids','eventImageCount','attendeeCount','paid','eventComittee','eventTopic'));
    }


    public function eventChooseAttendance()
    {
        $this->authorize('manage-attendance', User::class);
        $title = "";
        $event = Event::select( 'tbl_event.*','cat.name',
            DB::raw("(select file_name from tbl_event_image where event_id = tbl_event.id and is_active = true and status = 'UPLOADED' order by id asc limit 1) as event_image")  )
            ->join('tbl_event_category as cat','cat.id','=','tbl_event.category_id')
            ->where('tbl_event.is_active',true)
            ->whereIn('tbl_event.status',['ONGOING','UPCOMING'])
            ->paginate(10);

        return view('events.choose-attendance',compact('event','title'));
    }

    public function eventChooseAttendanceSearch(Request $request)
    {

        $this->authorize('manage-attendance', User::class);
        $title = $request->title;
        $event = Event::select( 'tbl_event.*','cat.name',
            DB::raw("(select file_name from tbl_event_image where event_id = tbl_event.id and is_active = true and status = 'UPLOADED' order by id asc limit 1) as event_image")  )
            ->join('tbl_event_category as cat','cat.id','=','tbl_event.category_id')
            ->where('tbl_event.is_active',true)
            ->whereIn('tbl_event.status',['ONGOING','UPCOMING'])
            ->where('tbl_event.title','ILIKE', "%$request->title%")
            ->paginate(10);

            return view('events.choose-attendance',compact('event','title'));
    }

    public function eventAttendance($event_id)
    {
        $this->authorize('manage-attendance', User::class);

        $event_id = Crypt::decrypt($event_id);
        $event_name = Event::where('id',$event_id)->pluck('title')->first();

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('status','!=','PENDING')
        ->get();


        return view('events.attendance',compact('event_id','event_name','member'));
    }

    public function eventCheckCountAttendance(Request $request)
    {

        $count = EventTransaction::where('is_active',true)
                                ->where('event_id',$request->event_id)
                                ->where('pps_no',$request->pps_no)->count();
        return $count;

        // $attendee = MemberInfo::select('tbl_member_info.*','trans.joined_dt','trans.paid','or.payment_dt')
        // ->join('tbl_event_transaction as trans','trans.pps_no','=','tbl_member_info.pps_no')
        // ->join('tbl_or_master as or','or.id','=','trans.or_id')
        // ->where('trans.is_active',true)
        // ->where('tbl_member_info.is_active',true)
        // ->where('tbl_member_info.pps_no',$request->pps_no)
        // ->where('trans.event_id',$request->event_id)
        // ->first();
        // return $attendee;

    }

    public function eventCheckCountAttendanceViaPRC(Request $request)
    {
        $this->authorize('manage-attendance', User::class);

        $prc_no = $request->input('prc_no');
        $member_info = MemberInfo::where('is_active', true)
            ->where('prc_number', $prc_no)
            ->first();


        $count = EventTransaction::where('is_active',true)
                                ->where('event_id',$request->event_id)
                                ->where('pps_no',$member_info->pps_no)->count();


        return $count;

    }

    public function eventCheckCountAttendance2(Request $request)
    {
        $countTransaction = EventTransaction::where('is_active',true)
                                            ->where('pps_no',$request->pps_no)
                                            ->where('event_id',$request->event_id)->count();


            // Check if member existed in tbl_event_transaction
            if($countTransaction >= 1)
            {
                $eventTransaction = EventTransaction::where('is_active',true)
                                            ->where('pps_no',$request->pps_no)
                                            ->where('event_id',$request->event_id)->first();



                $event_transaction_id = Crypt::encrypt($eventTransaction->id);

                $url = url('/event-download-identification-card/' . $event_transaction_id);

                $event = Event::where('is_active',true)
                                ->where('id',$request->event_id)->first();

                switch($eventTransaction->attended)
                {
                    case false:
                        $eventTransaction->attended = true;
                        $eventTransaction->attended_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
                        $eventTransaction->save();

                        // Condition if member not yet paid
                        if($eventTransaction->paid == false)
                        {
                            return response()->json([
                                'status' => 'attended_not_paid',
                                'event_transaction_id' => $event_transaction_id,
                                'download_url' => $url
                            ]);


                        }
                        else
                        {
                            return response()->json([
                                'status' => 'attended_paid',
                                'event_transaction_id' => $event_transaction_id,
                                'download_url' => $url
                            ]);
                        }

                    break;

                    case true:
                        return response()->json([
                            'status' => 'existing',
                            'event_transaction_id' => $event_transaction_id,
                            'download_url' => $url
                        ]);
                    break;
                }
            }

            else
            {
                $transaction = new EventTransaction();
                $transaction->is_active = true;
                $transaction->created_by = auth()->user()->name;
                $transaction->pps_no = $request->pps_no;
                $transaction->event_id = $request->event_id;
                $transaction->paid = false;
                $transaction->joined_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
                $transaction->attended = true;
                $transaction->attended_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');

                $transaction->save();

                return response()->json([
                    'status' => 'save_not_registered',
                    'event_transaction_id' => $event_transaction_id,
                     'download_url' => $url
                ]);

            }


    }


    public function eventCheckAttendance(Request $request)
    {
        $eventTransaction = EventTransaction::where('is_active',true)
        ->where('pps_no',$request->pps_no)
        ->where('event_id',$request->event_id)
        ->first();

        if($eventTransaction->paid == true)
        {
            

            $attendee = MemberInfo::select('tbl_member_info.*','mem_type.member_type_name','trans.joined_dt','trans.paid','or.payment_dt','event.price')
            ->join('tbl_event_transaction as trans','trans.pps_no','=','tbl_member_info.pps_no')
            ->join('tbl_event as event','event.id','=','trans.event_id')
            ->leftJoin('tbl_or_master as or','or.id','=','trans.or_id')
            ->leftJoin('tbl_member_type as mem_type','mem_type.id','=','tbl_member_info.member_type')
            ->where('trans.is_active',true)
            ->where('tbl_member_info.is_active',true)
            // ->where('or.is_active',true)
            ->where('tbl_member_info.pps_no',$request->pps_no)
            ->where('trans.event_id',$request->event_id)
            ->first();

            $pictureUrl = null;
            if ($attendee->picture) {
                $pictureUrl = Storage::disk('s3')->temporaryUrl(
                    'applicant/' . $attendee->picture, now()->addMinutes(30)
                );
            }

            return response()->json([
                'attendee' => $attendee,
                'picture_url' => $pictureUrl
            ]);


        }
        else
        {
            $attendee = MemberInfo::select('tbl_member_info.*','mem_type.member_type_name','trans.joined_dt','trans.paid')
            ->join('tbl_event_transaction as trans','trans.pps_no','=','tbl_member_info.pps_no')
            ->leftJoin('tbl_member_type as mem_type','mem_type.id','=','tbl_member_info.member_type')
            ->where('trans.is_active',true)
            ->where('tbl_member_info.is_active',true)
            ->where('tbl_member_info.pps_no',$request->pps_no)
            ->where('trans.event_id',$request->event_id)
            ->first();

            $pictureUrl = null;
            if ($attendee->picture) {
                $pictureUrl = Storage::disk('s3')->temporaryUrl(
                    'applicant/' . $attendee->picture, now()->addMinutes(30)
                );
            }

            return response()->json([
                'attendee' => $attendee,
                'picture_url' => $pictureUrl
            ]);

        }

    }


    public function eventCheckAttendanceViaPRC(Request $request)
    {

        $this->authorize('manage-attendance', User::class);

        $prc_no = $request->input('prc_no');
        $member_info = MemberInfo::where('is_active', true)
            ->where('prc_number', $prc_no)
            ->first();


        $eventTransaction = EventTransaction::where('is_active',true)
        ->where('pps_no',$member_info->pps_no)
        ->where('event_id',$request->event_id)
        ->first();

        if($eventTransaction->paid == true)
        {

            $attendee = MemberInfo::select('tbl_member_info.*','mem_type.member_type_name','trans.joined_dt','trans.paid','or.payment_dt','event.price')
            ->join('tbl_event_transaction as trans','trans.pps_no','=','tbl_member_info.pps_no')
            ->join('tbl_event as event','event.id','=','trans.event_id')
            ->leftJoin('tbl_or_master as or','or.id','=','trans.or_id')
            ->leftJoin('tbl_member_type as mem_type','mem_type.id','=','tbl_member_info.member_type')
            ->where('trans.is_active',true)
            ->where('tbl_member_info.is_active',true)
            // ->where('or.is_active',true)
            ->where('tbl_member_info.pps_no',$member_info->pps_no)
            ->where('trans.event_id',$request->event_id)
            ->first();

            $pictureUrl = null;
            if ($attendee->picture) {
                $pictureUrl = Storage::disk('s3')->temporaryUrl(
                    'applicant/' . $attendee->picture, now()->addMinutes(30)
                );
            }

            return response()->json([
                'attendee' => $attendee,
                'picture_url' => $pictureUrl
            ]);


        }
        else{
            $attendee = MemberInfo::select('tbl_member_info.*','mem_type.member_type_name','trans.joined_dt','trans.paid')
            ->join('tbl_event_transaction as trans','trans.pps_no','=','tbl_member_info.pps_no')
            ->leftJoin('tbl_member_type as mem_type','mem_type.id','=','tbl_member_info.member_type')
            ->where('trans.is_active',true)
            ->where('tbl_member_info.is_active',true)
            ->where('tbl_member_info.pps_no',$member_info->pps_no)
            ->where('trans.event_id',$request->event_id)
            ->first();

            $pictureUrl = null;
            if ($attendee->picture) {
                $pictureUrl = Storage::disk('s3')->temporaryUrl(
                    'applicant/' . $attendee->picture, now()->addMinutes(30)
                );
            }

            return response()->json([
                'attendee' => $attendee,
                'picture_url' => $pictureUrl
            ]);

        }



    }

    public function eventMemberNotAttended(Request $request)
    {
        $attendee = MemberInfo::select('tbl_member_info.*','mem_type.member_type_name')
        ->leftJoin('tbl_member_type as mem_type','mem_type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',$request->pps_no)
        ->first();

        $pictureUrl = null;
        if ($attendee->picture) {
            $pictureUrl = Storage::disk('s3')->temporaryUrl(
                'applicant/' . $attendee->picture, now()->addMinutes(30)
            );
        }


        return response()->json([
            'non_attendee' => $attendee,
            'picture_url' => $pictureUrl
        ]);

    }

    public function eventMemberNotAttendedViaPRC(Request $request)
    {

        $this->authorize('manage-attendance', User::class);

        $prc_no = $request->input('prc_no');

        $attendee = MemberInfo::select('tbl_member_info.*','mem_type.member_type_name')
        ->leftJoin('tbl_member_type as mem_type','mem_type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.prc_number',$prc_no)
        ->first();

        $pictureUrl = null;
        if ($attendee->picture) {
            $pictureUrl = Storage::disk('s3')->temporaryUrl(
                'applicant/' . $attendee->picture, now()->addMinutes(30)
            );
        }


        return response()->json([
            'non_attendee' => $attendee,
            'picture_url' => $pictureUrl
        ]);

    }


    public function eventAddCommitteeGroup(Request $request)
    {

        $countExist = EventCommitteeGroup::where('is_active',true)->where('committee_group_name',$request->group_name)->first();

        if($countExist >= 1)
        {
            return "exist";
        }
        else
        {
            $committeeGroup = new EventCommitteeGroup();
            $committeeGroup->created_by = auth()->user()->name;
            $committeeGroup->is_active = true;
            $committeeGroup->committee_group_name = $request->group_name;

            $committeeGroup->save();

            return "save";

        }


    }


    public function eventGetCommitteeGroupList(Request $request)
    {

       return $request->committe_group_id;


    }


    public function eventAddCommittee(Request $request)
    {

        $countCommitteeExist = EventCommittee::where('status','PENDING')->where('pps_no',$request->pps_no)->count();
        if($countCommitteeExist >= 1)
        {
            return "exist";
        }
        else
        {
            $committee = new EventCommittee();
            $committee->created_by = auth()->user()->name;
            $committee->is_active = true;
            $committee->status = "PENDING";
            $committee->pps_no = $request->pps_no;
            $committee->session = $request->session;


            $committee->save();

            $committee2 = EventCommittee::select('member.first_name','member.middle_name','member.last_name','member.suffix','tbl_event_committee_list.pps_no')->join('tbl_member_info as member','member.pps_no','=','tbl_event_committee_list.pps_no')
            ->where('tbl_event_committee_list.is_active',true)
            ->where('tbl_event_committee_list.status','PENDING')
            ->orderBy('tbl_event_committee_list.id','asc')->get();

            return $committee2;

        }

    }

    public function eventAddOrganizer(Request $request)
    {
        $countOrganizerExist = EventOrganizer::where('status','PENDING')->where('pps_no',$request->pps_no)->count();
        if($countOrganizerExist >= 1)
        {
            return "exist";
        }
        else
        {
            $organizer = new EventOrganizer();
            $organizer->is_active = true;
            $organizer->status = 'PENDING';
            $organizer->created_by = auth()->user()->name;
            $organizer->pps_no = $request->pps_no;
            $organizer->organizer_type_id = $request->organizer_type_id;
            $organizer->session = $request->session;
            $organizer->save();

            return "success";
        }



    }

    public function eventRemoveCommittee(Request $request)
    {
        $removeCommitee = EventCommittee::where('status','PENDING')->where('pps_no',$request->pps_no)->delete();

        $committee = EventCommittee::where('status','PENDING')->where('is_active',true)->get();
        return json_encode($committee);


    }

    public function eventRemoveOrganizer(Request $request)
    {
        $removeOrganizer = EventOrganizer::where('status','PENDING')->where('pps_no',$request->pps_no)->delete();

        $organizer = EventOrganizer::where('status','PENDING')->where('is_active',true)->get();
        return json_encode($organizer);


    }


    public function eventPay($event_transaction_id)
    {
        $ids = Crypt::decrypt($event_transaction_id);
        $eventTransaction = EventTransaction::select('tbl_event_transaction.*',
                                                    'member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no',
                                                    'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type',
                                                    'event.title','event.price','event.description','event.id as eventId',
                                                    'category.name as category_name',)
        ->join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
        ->join('tbl_event_category as category','category.id','=','event.category_id')
        ->join('tbl_member_info as member','member.pps_no','=','tbl_event_transaction.pps_no')
        ->where('tbl_event_transaction.is_active',true)
        ->where('tbl_event_transaction.id',$ids)->first();

        return view('events.pay',compact('eventTransaction'));
    }

    public function eventPaymentFinal($id)
    {
        $ids = Crypt::decrypt($id);
        $pps_no_encrypt = Crypt::encrypt(auth()->user()->pps_no);


        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();


        if($member == null)
        {
            $mem_type = 0;
        }
        else
        {
            $mem_type = $member->member_type;
        }

        $event = Event::select('tbl_event.*','category.name as category',
        DB::raw("(select price from tbl_event_price where event_id = tbl_event.id and is_active = true and member_type_id = $mem_type) as prices"),
        )
        ->where('tbl_event.id',$ids)
        ->join('tbl_event_category as category','category.id','=','tbl_event.category_id')
        ->first();

        $info = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->join('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        $eventTopic = EventTopic::where('tbl_event_topic.event_id',$ids)
                                ->get();


        return view('events.payment-final',compact('event','info','eventTopic','member','pps_no_encrypt'));
    }

    public function eventPaymentOnline(Request $request)
    {


        if($request->member_type_name == 'FOREIGN DELEGATE')
        {
            $req_url = 'https://v6.exchangerate-api.com/v6/138b122e4e8702fdb6422935/latest/USD';
            $response_json = file_get_contents($req_url);
            if(false !== $response_json) {
                $response_convert = json_decode($response_json);

                $base_price = $request->price;

                $peso = round(($base_price * $response_convert->conversion_rates->PHP), 0);


            }
            if($request->payment_type == 'gcash')
            {
                $amount_temp = $peso * 1.030;
            }
            else
            {
                $amount_temp = ($peso * 1.040) + 15;
            }

            $amount = (int) $amount_temp . '00';



        }
        else
        {
            if($request->payment_type == 'gcash')
            {
                $amount = $request->price * 1.030 . '00';
            }
            else
            {
                $amount = ($request->price * 1.040) + 15 . '00';
            }

        }



        $success_url = $this->pps_url.'success-event-payment-online/'.$request->price.'/'.$request->pps_no.'/'.$request->event_id;
        $failed_url = $this->pps_url;


        $total = (float) $amount;



            $description = 'EVENT - '.$request->event_title;
            if($request->member_type_name == 'FOREIGN DELEGATE')
            {
                $name = $request->event_title . ' ( $ '. $request->price .' .00 )';
                $foreign_delegate = "yes";
                $dollar_rate = $response_convert->conversion_rates->PHP;
                $dollar_conversion = $peso;
            }
            else
            {
                $foreign_delegate = "no";
                $name = $request->event_title;
                $dollar_rate = null;
                $dollar_conversion = null;

            }

            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'email' => $request->event_email_adddress,
                            'phone' => $request->mobile_number,
                            'name' => $request->event_customer_name

                        ],
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $total,
                                'description' => $description,
                                'name'  =>  $name,
                                'quantity'  =>  1,

                            ],
                    ],
                    'metadata' => [
                        'transaction_type' => 'EVENT',
                        'event_id' => $request->event_id,
                        'pps_no' => $request->pps_no,
                        'price_session' => $request->price,
                        'is_foreign_delegate' => $foreign_delegate,
                        'pps_member' => auth()->user()->name,
                        'topic_id' => $request->topic_id,
                        'dollar_rate' => $dollar_rate,
                        'dollar_conversion' => $dollar_conversion

                    ],
                    'payment_method_types' => [
                        $request->payment_type

                    ],
                        'success_url'   =>  $success_url,
                        'cancel_url'    =>  $this->pps_url,
                        'description'   =>  $description,
                        'send_email_receipt' => true
                    ],

                ]
            ];

    
            $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                            ->withHeader('Content-Type: application/json')
                            ->withHeader('accept: application/json')
                            //->withHeader('Idempotency-Key: ' . Str::uuid())
                            ->withHeader('Authorization: Basic ' . PaymongoConfig::key())
                            ->withData($data)
                            ->asJson()
                            ->post();

                    

            return redirect()->to($response->data->attributes->checkout_url);

    }


    // public function successEventOnlinePayment($price,$pps_no,$event_id)
    // {

    //     $event = Event::select('tbl_event.*','category.name as category')
    //     ->where('tbl_event.id',$event_id)
    //     ->join('tbl_event_category as category','category.id','=','tbl_event.category_id')
    //     ->first();


    //     $info = MemberInfo::select('tbl_member_info.*','type.member_type_name')
    //     ->join('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
    //     ->where('tbl_member_info.is_active',true)
    //     ->where('tbl_member_info.pps_no',$pps_no)
    //     ->first();

    //     $session_payment_id = Session::get('online_payment_id');
    //     $session_topic_id = Session::get('topic_id');


    //     $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$session_payment_id)
//                     ->withHeader('accept: application/json')
//                     ->withHeader('Idempotency-Key: ' . Str::uuid())
//                     ->withHeader('Authorization: Basic ' . PaymongoConfig::key())
//                     ->asJson()
//                     ->get();

    //     $event_trans_count = EventTransaction::where('is_active',true)
    //                                           ->where('event_id',$event_id)
    //                                           ->where('pps_no',$pps_no)
    //                                           ->count();
    //     if($event_trans_count < 1)
    //     {
    //         $transaction = new EventTransaction();
    //         $transaction->is_active = true;
    //         $transaction->created_by = auth()->user()->name;
    //         $transaction->event_id = $event_id;
    //         $transaction->pps_no = $pps_no;
    //         $transaction->paid = true;
    //         $transaction->joined_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
    //         $transaction->selected_topic_id = $session_topic_id;

    //         $transaction->save();

    //         $transaction_id = $transaction->id;
    //     }
    //     else
    //     {
    //         $event_trans = EventTransaction::where('is_active',true)
    //                                           ->where('event_id',$event_id)
    //                                           ->where('pps_no',$pps_no)
    //                                           ->fist();
    //         $transaction_id = $event_trans->id;
    //     }



    //     $ormaster = new ORMaster();
    //     $ormaster->is_active = true;
    //     $ormaster->created_by = auth()->user()->name;
    //     $ormaster->transaction_type = 'EVENT';
    //     $ormaster->transaction_id = $transaction_id;
    //     $ormaster->total_amount = $price;
    //     $ormaster->pps_no = $pps_no;
    //     $ormaster->payment_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
    //     $ormaster->check_out_sessions_id = $session_payment_id;
    //     $ormaster->payment_mode = $response->data->attributes->payment_method_used;

    //     if($info->member_type_name == 'FOREIGN DELEGATE')
    //     {
    //         $dollar_rate = Session::get('dollar_rate');
    //         $dollar_conversion = Session::get('dollar_conversion');


    //         $ormaster->is_dollar = true;
    //         $ormaster->dollar_rate = $dollar_rate;
    //         $ormaster->dollar_conversion = $dollar_conversion;

    //     }

    //     $ormaster->save();
    //     $or_id = $ormaster->id;



    //     $eventTransaction = EventTransaction::where('id',$transaction_id)->first();
    //     $eventTransaction->updated_by = auth()->user()->name;;
    //     $eventTransaction->or_id = $or_id;

    //     $eventTransaction->save();



    //     if($event->category == 'ANNUAL CONVENTION')
    //     {
    //         ConventionJob::dispatch($info->email_address,$info->first_name,$info->last_name);
    //     }


    //     $event_id =  Crypt::encrypt($event_id);
    //     session()->forget('online_payment_id');
    //     session()->forget('dollar_rate');
    //     session()->forget('dollar_conversion');
    //     session()->forget('topic_id');

    //     return redirect('event-view/'.$event_id)->withStatus('success');


    // }

    public function successEventOnlinePayment($price,$pps_no,$event_id)
    {
        $event = Event::select('tbl_event.*','category.name as category')
        ->where('tbl_event.id',$event_id)
        ->join('tbl_event_category as category','category.id','=','tbl_event.category_id')
        ->first();

        $info = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->join('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.pps_no',$pps_no)
        ->first();

        if($event->category == 'ANNUAL CONVENTION')
        {
            ConventionJob::dispatch($info->email_address,$info->first_name,$info->last_name,$event->title);
        }

        $event_id =  Crypt::encrypt($event_id);

        return redirect('event-view/'.$event_id)->withStatus('success');
    }



    public function eventPayment(Request $request)
    {

        if($request->total_price == 0)
        {
            $eventTransaction = EventTransaction::where('id',$request->transaction_id)->first();
            $eventTransaction->paid = true;
            $eventTransaction->updated_by = auth()->user()->name;;

            $eventTransaction->save();

            return redirect('event-view')->withStatus('success');
        }

        else
        {
            $amount = $request->total_price . '00';

            $success_url = $this->pps_url.'success-event-payment-member/'.$request->transaction_id.'/'.$request->total_price.'/'.$request->pps_no.'/'.$request->eventId;
            $failed_url = $this->pps_url.'failed-event-payment-member/'.$request->eventId;


            $total = (float) $amount;
            $description = 'EVENT - '.$request->event_title;
            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'email' => $request->event_email_adddress,
                            'name' => $request->event_customer_name

                        ],
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $total,
                                'description' => $description,
                                'name'  =>  $request->event_title,
                                'quantity'  =>  1,


                            ],

                    ],
                    'payment_method_types' => [
                        'card',
                        'gcash'

                    ],
                        'success_url'   =>  $success_url,
                        'cancel_url'    =>  $this->pps_url,
                        'description'   =>  $description,
                        'send_email_receipt' => true
                    ],

                ]
            ];
            $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                            ->withHeader('Content-Type: application/json')
                            ->withHeader('accept: application/json')
                            //->withHeader('Idempotency-Key: ' . Str::uuid())
                            ->withHeader('Authorization: Basic ' . PaymongoConfig::key())
                            ->withData($data)
                            ->asJson()
                            ->post();




            Session::put('session_id',$response->data->id);


            return redirect()->to($response->data->attributes->checkout_url);
        }

    }

    public function successEventPaymentMember($transaction_id,$total_amount,$pps_no,$eventId)
    {

        $sessionId = Session::get('session_id');


        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$sessionId)
                        ->withHeader('accept: application/json')
                            //->withHeader('Idempotency-Key: ' . Str::uuid())
                        ->withHeader('Authorization: Basic ' . PaymongoConfig::key())
                        ->asJson()
                        ->get();



        $lastTransaction = EventTransaction::orderBy('id', 'desc')->pluck('id')->first();
        $transaction_number = date('Y') . date('m'). date('d') . $lastTransaction;

        $ormaster = new ORMaster();
        $ormaster->is_active = true;
        $ormaster->created_by = auth()->user()->name;
        $ormaster->updated_by = auth()->user()->name;
        $ormaster->transaction_type = 'EVENT';
        $ormaster->transaction_id = $transaction_id;
        $ormaster->total_amount = $total_amount;
        $ormaster->pps_no = $pps_no;
        $ormaster->or_no = $transaction_number;
        $ormaster->payment_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
        $ormaster->check_out_sessions_id = $sessionId;
        $ormaster->payment_mode = $response->data->attributes->payment_method_used;

        $ormaster->save();
        $or_id = $ormaster->id;


        $eventTransaction = EventTransaction::where('id',$transaction_id)->first();
        $eventTransaction->paid = true;
        $eventTransaction->updated_by = auth()->user()->name;;
        $eventTransaction->or_id = $or_id;

        $eventTransaction->save();

        $eventIds =  Crypt::encrypt($eventId);

        session()->forget('session_id');

        return redirect('event-view/'.$eventIds)->withStatus('success');


    }

    public function failedEventPaymentMember($eventId)
    {
        return redirect('event-view/'.$eventIds)->withStatus('failed');

    }


    public function eventTopic($id)
    {
        

        $eventTopicId =  Crypt::decrypt($id);
        $eventTopic = EventTopic::select('tbl_event_topic.points_on_site','tbl_event_topic.points_online','topic_name','event.title','event.status','event.start_dt','tbl_event_topic.fb_live_url',
                                        'event.end_dt','event.start_time','event.end_time','event.venue')
                                ->leftJoin('tbl_event as event','event.id','=','tbl_event_topic.event_id')
                                ->where('tbl_event_topic.id',$eventTopicId)
                                ->first();
        $questions = TopicQuestion::where('is_active',true)
                                ->where('status','ACTIVE')
                                ->where('topic_id',$eventTopicId)
                                ->orderBy('id','ASC')
                                ->get();

        $choices = TopicQuestionChoices::where('is_active',true)
                                        ->orderBy('letter','ASC')
                                        ->get();



        // OFFICIAL QR CODE
        $eventtopicurl = request()->getSchemeAndHttpHost().'/event-topic-attendance/'.$id;

        //TEMPORARILY QR CODE
        // $eventtopicurl = 'https://qr.pps.org.ph'.'/event-topic-attendance/'.$id;

 
        return view('events.topic-question',compact('eventTopic','eventtopicurl','id','eventTopicId','questions','choices'));
    }








    public function eventTopicDownloadQR($eventtopicurl)
    {

        return response()->streamDownload(
            function () use ($eventtopicurl) {
                echo QrCode::size(200)
                    ->format('png')
                    ->generate(decrypt($eventtopicurl));
            },
            'qr-code.png',
            [
                'Content-Type' => 'image/png',
            ]
        );
    }
    
    public function eventTopicAddQuestion(Request $request)
    {


        $eventTopicQuestionCount = TopicQuestion::where('question',$request->question)
                                                ->where('topic_id',$request->topic_id)
                                                ->count();
        if($eventTopicQuestionCount >= 1)
        {
            return "exist";
        }
        else
        {

            $eventTopicQuestion = new TopicQuestion();
            $eventTopicQuestion->is_active = true;
            $eventTopicQuestion->status = 'ACTIVE';
            $eventTopicQuestion->created_by = auth()->user()->name;
            $eventTopicQuestion->updated_by = auth()->user()->name;
            $eventTopicQuestion->question = $request->question;
            $eventTopicQuestion->answer = $request->answer;
            $eventTopicQuestion->topic_id = $request->topic_id;

            $eventTopicQuestion->save();

            $eventTopicQuestionChoices = new TopicQuestionChoices();
            $eventTopicQuestionChoices->is_active = true;
            $eventTopicQuestionChoices->status = 'ACTIVE';
            $eventTopicQuestionChoices->created_by = auth()->user()->name;
            $eventTopicQuestionChoices->updated_by = auth()->user()->name;

            $eventTopicQuestionChoices->save();


            foreach($request->choices as $key =>$count){
                $choices = array_filter(array(
                        'is_active'=>true,
                        'choices_description'=>$request->choices [$key],
                        'topic_question_id'=>$eventTopicQuestion->id,
                        'letter'=>strtoupper($request->letter [$key]),
                    ));


                    TopicQuestionChoices::insert($choices);

                }
            $deletenullchoices = TopicQuestionChoices::where('choices_description',null)->delete();

            return "not exist";
        }


    }

    public function countTopicAttendee(Request $request)
    {
        $eventTransactionCount = EventTransaction::where('is_active',true)
                                                ->where('event_id',$request->event_id)
                                                ->where('selected_topic_id',$request->topic_id)
                                                ->count();

        $eventTopic = EventTopic::where('is_active',true)->where('id',$request->topic_id)->first();


        if($eventTransactionCount >= $eventTopic->max_attendee)
        {
            return "maxlimit";
        }
        else
        {
            return "allowed";
        }

    }



    public function eventTopicAttendanceDisable()
    {
        return view('events.topic-attendance-disable');
    }


    public function eventTopicAttendance($id)
    {

        $eventTopicId =  Crypt::decrypt($id);

        $eventTopic = EventTopic::select('tbl_event_topic.id','tbl_event_topic.event_id','tbl_event_topic.day',
                                        'tbl_event_topic.with_examination','tbl_event_topic.points','topic_name',
                                        'tbl_event_topic.is_business_meeting','tbl_event_topic.is_plenary','tbl_event_topic.qr_is_active',
                                        'event.title',
                                        'event.status',
                                        'event.start_dt',
                                        'event.end_dt','event.start_time','event.end_time','event.venue')
        ->leftJoin('tbl_event as event','event.id','=','tbl_event_topic.event_id')
        ->where('tbl_event_topic.id',$eventTopicId)
        ->first();


        if($eventTopic->qr_is_active == false || $eventTopic->qr_is_active == null)
        {
            return redirect('event-topic-attendance-disable');
        }
        else
        {
            $event = Event::select( 'tbl_event.*')
            ->where('is_active',true)
            ->where('tbl_event.id',$eventTopic->event_id)
            ->first();


            $chapter = Chapter::select('tbl_chapter.*')
            ->where('tbl_chapter.is_active',true)
            ->orderBy('tbl_chapter.chapter_name','ASC')
            ->get();

            return view('events.topic-attendance',compact('eventTopic','event','id','chapter'));
        }


    }



    public function eventTopicAttendNoneQuestion(Request $request)
    {


        Session::put('prc_number',$request->business_meeting_prc_number);
        Session::put('first_name',strtoupper($request->business_meeting_first_name));
        Session::put('last_name',strtoupper($request->business_meeting_last_name));
        Session::put('chapter_name',strtoupper($request->business_meeting_member_chapter));



        $prc_number = Session::get('prc_number');
        $chapter_name = Session::get('chapter_name');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');
        $first_name = Session::get('first_name');
        $last_name = Session::get('last_name');

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();



        $eventTopic = EventTopic::where('id',$request->event_topic_id)->first();




        $eventTransactionCount = EventTransaction::join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
                                                    ->join('tbl_event_category as category','category.id','=','event.category_id')
                                                    ->where('category.name','ANNUAL CONVENTION')
                                                    ->where('tbl_event_transaction.is_active',true)
                                                    ->where('tbl_event_transaction.event_id',$request->event_id)
                                                    ->where('tbl_event_transaction.pps_no',$member->pps_no)
                                                    ->count();

        //CHECK IF MEMBER HAS ALREADY CLICK THE ATTEND BUTTON
        $topic_attend_count = EventAttend::where('is_active',true)
                                           ->where('event_id',$request->event_id)
                                           ->where('pps_no',$member->pps_no)
                                           ->where('topic_id',$request->event_topic_id)
                                           ->count();

    //ALL MEMBER PAID
    if($eventTransactionCount >= 1)
    {
        //CHECK IF ALREADY ATTENDED IN THE TOPIC
        if($topic_attend_count >= 1)
        {
            session()->forget('prc_number');
            session()->forget('first_name');
            session()->forget('last_name');
            session()->forget('chapter_name');

            return Response()->json([
                "message" => 'alreadyattended',
            ]);

        }
        else
        {
            // CHECK IF QR IS NOT BUSINESS MEETING
            if($eventTopic->is_business_meeting != true)
            {
                $topic_attendance = new EventAttend();
                $topic_attendance->created_by = $created_by;
                $topic_attendance->is_active = true;
                $topic_attendance->date_attend = Carbon::now();
                $topic_attendance->event_id = $request->event_id;
                $topic_attendance->topic_id = $request->event_topic_id;
                $topic_attendance->pps_no = $member->pps_no;

                $topic_attendance->save();

                session()->forget('prc_number');
                session()->forget('first_name');
                session()->forget('last_name');
                session()->forget('chapter_name');



                return Response()->json([
                    "message" => 'success',
                    "event_topic_name"=>$request->event_topic_name,
                ]);
            }

            else
            {
                    //CHECK IF MEMBER IS DIPLOMATE, EMERITUS, FELLOW
                    if($member->member_type_name == "DIPLOMATE" || $member->member_type_name == "FELLOW" || $member->member_type_name == "EMERITUS FELLOW")
                    {
                    $topic_attendance = new EventAttend();
                    $topic_attendance->created_by = $created_by;
                    $topic_attendance->is_active = true;
                    $topic_attendance->date_attend = Carbon::now()->timezone('Asia/Manila');
                    $topic_attendance->event_id = $request->event_id;
                    $topic_attendance->topic_id = $request->event_topic_id;
                    $topic_attendance->pps_no = $member->pps_no;

                    $topic_attendance->save();


                    $topic_attendance_temp = new TopicAttendTemp();
                    $topic_attendance_temp->created_by = $created_by;
                    $topic_attendance_temp->is_active = true;
                    $topic_attendance_temp->first_name = $first_name;
                    $topic_attendance_temp->last_name = $last_name;
                    $topic_attendance_temp->prc_number = $prc_number;
                    $topic_attendance_temp->event_id = $request->event_id;
                    $topic_attendance_temp->topic_id = $request->event_topic_id;
                    $topic_attendance_temp->chapter_name = $chapter_name;

                    $topic_attendance_temp->save();

                    session()->forget('prc_number');
                    session()->forget('first_name');
                    session()->forget('last_name');
                    session()->forget('chapter_name');

                    return Response()->json([
                        "message" => 'success_business_meeting',
                        "event_topic_name"=>$request->event_topic_name,
                    ]);
                    }
                    //CHECK IF MEMBER IS NOT DIPLOMATE, EMERITUS, FELLOW
                    else
                    {

                        session()->forget('prc_number');
                        session()->forget('first_name');
                        session()->forget('last_name');
                        session()->forget('chapter_name');

                    return Response()->json([
                        "message" => 'notallowedbusinessmeeting',
                        "event_topic_name"=>$request->event_topic_name,
                    ]);


                    }

            }

        }
    }
    else
    {

        session()->forget('prc_number');
        session()->forget('first_name');
        session()->forget('last_name');
        session()->forget('chapter_name');


        return Response()->json([
            "message" => 'notpaid',
        ]);
    }




    }


    public function eventTopicAttendWithQuestion(Request $request)
    {

        Session::put('prc_number',$request->examination_prc_number);
        Session::put('first_name',strtoupper($request->examination_first_name));
        Session::put('last_name',strtoupper($request->examination_last_name));

        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');


        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();




        $eventTopic = EventTopic::where('is_active',true)
                            ->where('id',$request->event_topic_id)
                            ->first();

        $eventTransactionCount = EventTransaction::join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
                            ->join('tbl_event_category as category','category.id','=','event.category_id')
                            ->where('category.name','ANNUAL CONVENTION')
                            ->where('tbl_event_transaction.is_active',true)
                            ->where('tbl_event_transaction.event_id',$request->event_id)
                            ->where('tbl_event_transaction.pps_no',$member->pps_no)
                            ->count();


        $crypt_id = Crypt::encrypt($eventTopic->id);

        //CHECK IF MEMBER HAS ALREADY CLICK THE ATTEND BUTTON
        $topic_attend_count = EventAttend::where('is_active',true)
        ->where('event_id',$request->event_id)
        ->where('pps_no',$member->pps_no)
        ->where('topic_id',$request->event_topic_id)
        ->count();



        if($eventTransactionCount >= 1)
        {
             //CHECK IF ALREADY ATTENDED IN THE TOPIC
            if($topic_attend_count >= 1)
            {
                return Response()->json([
                    "message" => 'alreadyattended',
                ]);
            }
            else
            {
                return Response()->json([
                    "message" => 'accept',
                    "url"=>url('/event-topic-question-answer/'.$crypt_id)

                ]);
            }
        }

        else
        {
                return Response()->json([
                    "message" => 'notpaid',
                ]);
        }




    }




    public function eventTopicAttendPlenary(Request $request)
    {


        Session::put('prc_number',$request->plenary_prc_number);
        Session::put('first_name',strtoupper($request->plenary_first_name));
        Session::put('last_name',strtoupper($request->plenary_last_name));

        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');


        $member = MemberInfo::select('tbl_member_info.*')
                ->where('tbl_member_info.is_active',true)
                ->where('status','!=','PENDING')
                ->where('tbl_member_info.prc_number',$prc_number)
                ->first();



        $eventTopic = EventTopic::where('is_active',true)
                    ->where('id',$request->event_topic_id)
                    ->first();


        $eventTransactionCount = EventTransaction::join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
                    ->join('tbl_event_category as category','category.id','=','event.category_id')
                    ->where('category.name','ANNUAL CONVENTION')
                    ->where('tbl_event_transaction.is_active',true)
                    ->where('tbl_event_transaction.event_id',$request->event_id)
                    ->where('tbl_event_transaction.pps_no',$member->pps_no)
                    ->count();



        //CHECK IF MEMBER HAS ALREADY CLICK THE ATTEND BUTTON
        $topic_attend_count = EventAttend::where('is_active',true)
        ->where('event_id',$request->event_id)
        ->where('pps_no',$member->pps_no)
        ->where('topic_id',$request->event_topic_id)
        ->count();


        if($eventTransactionCount >= 1)
        {
            //CHECK IF ALREADY ATTENDED IN THE TOPIC
            if($topic_attend_count >= 1)
            {
                return Response()->json([
                    "message" => 'alreadyattended',
                ]);
            }
            else
            {
                $crypt_id = Crypt::encrypt($eventTopic->id);

                return Response()->json([
                    "message" => 'accept',
                    "url"=>url('/event-topic-question-answer-plenary/'.$crypt_id)

                ]);
            }
        }

        else
        {
                return Response()->json([
                    "message" => 'notpaid',
                ]);
        }






        // $eventTransactionCount = EventTransaction::join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
        //                                             ->join('tbl_event_category as category','category.id','=','event.category_id')
        //                                             ->where('category.name','ANNUAL CONVENTION')
        //                                             ->where('tbl_event_transaction.is_active',true)
        //                                             ->where('tbl_event_transaction.event_id',$request->event_id)
        //                                             ->where('tbl_event_transaction.pps_no',auth()->user()->pps_no)
        //                                             ->count();

        // $eventTopic = EventTopic::where('is_active',true)
        //                     ->where('id',$request->event_topic_id)
        //                     ->first();


        // $crypt_id = Crypt::encrypt($eventTopic->id);

        // return Response()->json([
        //     "message" => 'accept',
        //     "url"=>url('/event-topic-question-answer-plenary/'.$crypt_id)

        // ]);

        //CHECK IF MEMBER HAS ATTENDANCE IN THE LOBBY USING CURRENT DATE
        // $event_attend_count = EventAttend::where('is_active',true)
        // ->where('event_id',$request->event_id)
        // ->where('pps_no',$request->pps_no)
        // ->whereDate('date_attend', Carbon::today('Asia/Manila'))
        // ->count();




        //CHECK IF ALREADY ATTENDED IN THE TOPIC
        // if($topic_attend_count >= 1)
        // {
        //     return Response()->json([
        //         "message" => 'alreadyattended',
        //     ]);
        // }
        // else
        // {
        //     return Response()->json([
        //         "message" => 'accept',
        //         "url"=>url('/event-topic-question-answer-plenary/'.$crypt_id)

        //     ]);
        // }

        // if($eventTransactionCount >= 1)
        // {

        // }
        // else
        // {
        //     return Response()->json([
        //         "message" => 'notpaid',
        //     ]);
        // }


        // if($event_attend_count >= 1)
        // {

        // }

        // elseif($event_attend_count == 0)
        // {
        //     return Response()->json([
        //         "message" => 'notattended',
        //     ]);

        // }


    }


    public function eventOnlineTopicQuestionAnswer($id)
    {


        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');


        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();

        $eventTopicId =  Crypt::decrypt($id);

        $eventTopic = EventTopic::where('is_active',true)
                                    ->where('id',$eventTopicId)
                                    ->first();

        $cpdpoints = CPDPoints::
                    where('tbl_cpd_points.is_active',true)
                    ->where('tbl_cpd_points.pps_no',auth()->user()->pps_no)
                    ->where('tbl_cpd_points.event_id',$eventTopic->event_id)
                    ->sum('points');

        if($cpdpoints >= 60)
        {
            return redirect('event-online-video');
        }



        $checkEventPaid = EventTransaction::where('is_active',true)
        ->where('pps_no',auth()->user()->pps_no)
        ->where('event_id',$eventTopic->event_id)
        ->count();



        if($checkEventPaid == 0)
        {
            return redirect('event-online-video');
        }



        $eventTopicQuestion = TopicQuestion::where('is_active',true)
                                ->where('status','ACTIVE')
                                ->where('topic_id',$eventTopicId)
                                ->orderBy('id','ASC')
                                ->get();

        $eventTopicQuestionCount = TopicQuestion::where('is_active',true)
                                ->where('status','ACTIVE')
                                ->where('topic_id',$eventTopicId)
                                ->count();



        $choices = TopicQuestionChoices::where('is_active',true)
                                ->orderBy('letter','ASC')
                                ->get();


        return view('events.online-topic-question-answer',compact('eventTopic','eventTopicQuestion','choices','eventTopicQuestionCount'));

    }


    public function eventOnlineTopicQuestionAnswerPlenary($id)
    {


        $prc_number = Session::get('prc_number');

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();



        $eventTopicId =  Crypt::decrypt($id);

        $eventTopic = EventTopic::where('is_active',true)
                                    ->where('id',$eventTopicId)
                                    ->first();

        $speakerATotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',auth()->user()->pps_no)
                                    ->where('speaker_no','A')
                                    ->sum('score');

        $speakerBTotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',auth()->user()->pps_no)
                                    ->where('speaker_no','B')
                                    ->sum('score');

        $speakerCTotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',auth()->user()->pps_no)
                                    ->where('speaker_no','C')
                                    ->sum('score');

        return view('events.online-topic-question-answer-plenary',compact('eventTopic','speakerATotal','speakerBTotal','speakerCTotal'));


    }


    public function eventOnlineTopicQuestionAnswerPlenaryTemp($id)
    {


        $prc_number = Session::get('prc_number');

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.pps_no',auth()->user()->pps_no)
        ->first();



        $eventTopicId =  Crypt::decrypt($id);

        $eventTopic = EventTopic::where('is_active',true)
                                    ->where('id',$eventTopicId)
                                    ->first();

        $speakerATotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',auth()->user()->pps_no)
                                    ->where('speaker_no','A')
                                    ->sum('score');

        $speakerBTotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',auth()->user()->pps_no)
                                    ->where('speaker_no','B')
                                    ->sum('score');

        $speakerCTotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',auth()->user()->pps_no)
                                    ->where('speaker_no','C')
                                    ->sum('score');

        return view('events.online-topic-question-answer-plenary-temp',compact('eventTopic','speakerATotal','speakerBTotal','speakerCTotal'));


    }


    public function eventOnlineTopicFinalizePlenary(Request $request)
    {


        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.prc_number',auth()->user()->pps_no)
        ->first();

        $eventTopic = EventTopic::where('is_active',true)
        ->where('id',$request->event_topic_id)
        ->first();


        $topic_attendance = new EventAttend();
        $topic_attendance->created_by = auth()->user()->name;
        $topic_attendance->is_active = true;
        $topic_attendance->date_attend = Carbon::now()->timezone('Asia/Manila');
        $topic_attendance->event_id = $request->event_id;
        $topic_attendance->topic_id = $request->event_topic_id;
        $topic_attendance->pps_no = auth()->user()->pps_no;

        $topic_attendance->save();


        $cpd_points = new CPDPoints();
        $cpd_points->created_at = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
        $cpd_points->created_by = auth()->user()->name;
        $cpd_points->is_active = true;
        $cpd_points->pps_no = auth()->user()->pps_no;
        $cpd_points->points = $eventTopic->points_online;
        $cpd_points->category_name = 'EVENT';
        $cpd_points->item_id =  $request->event_topic_id;
        $cpd_points->event_id = $request->event_id;

        $cpd_points->save();





        $topic_ids = Crypt::encrypt($request->event_topic_id);
        return Response()->json([
            "success" => 'success',
            "url"=>url('/event-online-video-view/'.$topic_ids)

        ]);


    }


    public function eventOnlineTopicSpeakerA(Request $request)
    {

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',auth()->user()->pps_no)
        ->first();


        $eventPlenary = EventPlenary::where('is_active',true)
        ->where('pps_no',auth()->user()->pps_no)
        ->where('event_id',$request->event_id)
        ->where('topic_id',$request->event_topic_id)
        ->where('speaker_no','A')
        ->delete();


        $speakerA = [];


        if ($request->has('speaker1_objectives')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'OBJECTIVES',
                'score' => $request->speaker1_objectives,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_information_presented')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'INFORMATION PRESENTED',
                'score' => $request->speaker1_information_presented,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_organization')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'ORGANIZATION',
                'score' => $request->speaker1_organization,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_conclusions')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'CONCLUSIONS',
                'score' => $request->speaker1_conclusions,
                'speaker_no' => 'A',

            ];
        }

        if ($request->has('speaker1_confidence')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'CONFIDENCE',
                'score' => $request->speaker1_confidence,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_state_presence')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'STATE PRESENCE',
                'score' => $request->speaker1_state_presence,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_audience_interest')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'ABILITY TO MAINTAIN AUDIENCE INTEREST AND ENGAGEMENT',
                'score' => $request->speaker1_audience_interest,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_visual_aids')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'CLARITY OF VISUAL AIDS',
                'score' => $request->speaker1_visual_aids,
                'speaker_no' => 'A',

            ];
        }


        DB::table('tbl_event_plenary')->insert($speakerA);

        return "success";
    }


    public function eventOnlineTopicSpeakerATemp(Request $request)
    {

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',auth()->user()->pps_no)
        ->first();


        $eventPlenary = EventPlenary::where('is_active',true)
        ->where('pps_no',auth()->user()->pps_no)
        ->where('event_id',$request->event_id)
        ->where('topic_id',$request->event_topic_id)
        ->where('speaker_no','A')
        ->delete();


        $speakerA = [];


        if ($request->has('speaker1_relevance')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'Relevance of the topic',
                'score' => $request->speaker1_relevance,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_usefulness')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'Usefulness of information conveyed',
                'score' => $request->speaker1_usefulness,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_quality')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'Quality of the presentation',
                'score' => $request->speaker1_quality,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_expertise')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'Expertise of the Speaker',
                'score' => $request->speaker1_expertise,
                'speaker_no' => 'A',

            ];
        }

        if ($request->has('speaker1_delivery')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'Speaker’s delivery and style',
                'score' => $request->speaker1_delivery,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_time_management')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'Time ManagementE',
                'score' => $request->speaker1_time_management,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_environment')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => auth()->user()->pps_no,
                'criteria' => 'Environment',
                'score' => $request->speaker1_environment,
                'speaker_no' => 'A',

            ];
        }



        DB::table('tbl_event_plenary')->insert($speakerA);

        return "success";
    }



    public function eventTopicQuestionAnswer($id)
    {
        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');


        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();

        $eventTopicId =  Crypt::decrypt($id);

        $eventTopic = EventTopic::where('is_active',true)
                                    ->where('id',$eventTopicId)
                                    ->first();


        // $eventTopicQuestion = TopicQuestion::where('is_active',true)
        //                                     ->where('status','ACTIVE')
        //                                     ->where('topic_id',$eventTopicId)
        //                                     ->paginate(1);

        $eventTopicQuestion = TopicQuestion::where('is_active',true)
                                ->where('status','ACTIVE')
                                ->where('topic_id',$eventTopicId)
                                ->orderBy('id','ASC')
                                ->get();

        $eventTopicQuestionCount = TopicQuestion::where('is_active',true)
                                ->where('status','ACTIVE')
                                ->where('topic_id',$eventTopicId)
                                ->count();



        $choices = TopicQuestionChoices::where('is_active',true)
                                ->orderBy('letter','ASC')
                                ->get();


        $eventTopicAttendanceCount = EventAttend::where('is_active',true)
        ->where('pps_no',$member->pps_no)
        ->where('event_id',$eventTopic->event_id)
        ->where('topic_id',$eventTopicId)
        ->count();

        if($eventTopicAttendanceCount >= 1)
        {
            return redirect('sign-in')->withStatus('Warning! you have already attended to this topic.');
        }
        else
        {
            return view('events.topic-question-answer',compact('eventTopic','eventTopicQuestion','choices','eventTopicQuestionCount'));
        }

    }



    public function eventTopicQuestionAnswerPlenary($id)
    {

        $prc_number = Session::get('prc_number');

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();



        $eventTopicId =  Crypt::decrypt($id);

        $eventTopic = EventTopic::where('is_active',true)
                                    ->where('id',$eventTopicId)
                                    ->first();

        $speakerATotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',$member->pps_no)
                                    ->where('speaker_no','A')
                                    ->sum('score');

        $speakerBTotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',$member->pps_no)
                                    ->where('speaker_no','B')
                                    ->sum('score');

        $speakerCTotal = EventPlenary::where('is_active',true)
                                    ->where('event_id',$eventTopic->event_id)
                                    ->where('topic_id',$eventTopic->id)
                                    ->where('pps_no',$member->pps_no)
                                    ->where('speaker_no','C')
                                    ->sum('score');

                                    return view('events.topic-question-answer-plenary',compact('eventTopic','speakerATotal','speakerBTotal','speakerCTotal'));


        // $eventTopicAttendanceCount = EventAttend::where('is_active',true)
        // ->where('pps_no',auth()->user()->pps_no)
        // ->where('event_id',$eventTopic->event_id)
        // ->where('topic_id',$eventTopicId)
        // ->count();

        // if($eventTopicAttendanceCount >= 1)
        // {
        //     return redirect('sign-in')->withStatus('Warning! you have already attended to this topic.');
        // }
        // else
        // {
        //     return view('events.topic-question-answer-plenary',compact('eventTopic','speakerATotal','speakerBTotal','speakerCTotal'));
        // }


    }


    public function eventTopicProceedScore(Request $request)
    {

        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');
        $first_name = Session::get('first_name');
        $last_name = Session::get('last_name');

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();

        $eventTopic = EventTopic::where('is_active',true)
                                    ->where('id',$request->event_topic_id)
                                    ->first();

        $eventTopicAttendanceCount = EventAttend::where('is_active',true)
        ->where('pps_no',$member->pps_no)
        ->where('event_id',$request->event_id)
        ->where('topic_id',$request->event_topic_id)
        ->count();


        if($eventTopicAttendanceCount >= 1)
        {
            return "attended";
        }
        else
        {
            $topic_attendance = new EventAttend();
            $topic_attendance->created_by = $created_by;
            $topic_attendance->is_active = true;
            $topic_attendance->date_attend = Carbon::now()->timezone('Asia/Manila');
            $topic_attendance->event_id = $request->event_id;
            $topic_attendance->topic_id = $request->event_topic_id;
            $topic_attendance->pps_no = $member->pps_no;
            $topic_attendance->examination = true;

            $topic_attendance->save();

            $cpd_points = new CPDPoints();
            $cpd_points->created_at = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
            $cpd_points->created_by = $created_by;
            $cpd_points->is_active = true;
            $cpd_points->pps_no = $member->pps_no;
            $cpd_points->points = $eventTopic->points_on_site;
            $cpd_points->category_name = 'EVENT';
            $cpd_points->item_id =  $request->event_topic_id;
            $cpd_points->event_id = $request->event_id;

            $cpd_points->save();

            $topic_attendance_temp = new TopicAttendTemp();
            $topic_attendance_temp->created_by = $created_by;
            $topic_attendance_temp->is_active = true;
            $topic_attendance_temp->first_name = $first_name;
            $topic_attendance_temp->last_name = $last_name;
            $topic_attendance_temp->prc_number = $prc_number;
            $topic_attendance_temp->event_id = $request->event_id;
            $topic_attendance_temp->topic_id = $request->event_topic_id;

            $topic_attendance_temp->save();


            session()->forget('prc_number');
            session()->forget('first_name');
            session()->forget('last_name');




            return "success";
        }


    }


    public function eventOnlineTopicProceedScore(Request $request)
    {


        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.prc_number',auth()->user()->pps_no)
        ->first();




        $eventTopic = EventTopic::where('is_active',true)
                                    ->where('id',$request->event_topic_id)
                                    ->first();

        $eventTopicAttendanceCount = EventAttend::where('is_active',true)
        ->where('pps_no',auth()->user()->pps_no)
        ->where('event_id',$request->event_id)
        ->where('topic_id',$request->event_topic_id)
        ->count();


        $eventPaidCount = EventTransaction::where('is_active',true)
                                ->where('event_id',$request->event_id)
                                ->count();

        if($eventPaidCount == 0)
        {
            return Response()->json([
                "message" => 'notpaid',
                "url"=>url('/event-listing')

            ]);
        }


        else if($eventTopicAttendanceCount >= 1)
        {
            return Response()->json([
                "message" => 'attended',
                "url"=>url('/event-listing')

            ]);

        }
        else
        {
            $topic_attendance = new EventAttend();
            $topic_attendance->created_by = auth()->user()->name;
            $topic_attendance->is_active = true;
            $topic_attendance->date_attend = Carbon::now()->timezone('Asia/Manila');
            $topic_attendance->event_id = $request->event_id;
            $topic_attendance->topic_id = $request->event_topic_id;
            $topic_attendance->pps_no = auth()->user()->pps_no;
            $topic_attendance->examination = true;

            $topic_attendance->save();

            $cpd_points = new CPDPoints();
            $cpd_points->created_at = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
            $cpd_points->created_by = auth()->user()->name;
            $cpd_points->is_active = true;
            $cpd_points->pps_no = auth()->user()->pps_no;
            $cpd_points->points = $eventTopic->points_online;
            $cpd_points->category_name = 'EVENT';
            $cpd_points->item_id =  $request->event_topic_id;
            $cpd_points->event_id = $request->event_id;

            $cpd_points->save();

            $topic_ids = Crypt::encrypt($request->event_topic_id);
                return Response()->json([
                    "success" => 'success',
                    "url"=>url('/event-online-video-view/'.$topic_ids)

                ]);

        }


    }

    public function eventTopicCheckAttendance(Request $request)
    {
        $eventTopicAttendanceCount = EventAttend::where('is_active',true)
        ->where('pps_no',$request->pps_no)
        ->where('event_id',$request->event_id)
        // ->where('topic_id',$request->event_topic_id)
        ->count();

        return $eventTopicAttendanceCount;
    }

    public function eventTopicSpeakerA(Request $request)
    {


        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();


        $eventPlenary = EventPlenary::where('is_active',true)
        ->where('pps_no',$member->pps_no)
        ->where('event_id',$request->event_id)
        ->where('topic_id',$request->event_topic_id)
        ->where('speaker_no','A')
        ->delete();


        $speakerA = [];


        if ($request->has('speaker1_objectives')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'OBJECTIVES',
                'score' => $request->speaker1_objectives,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_information_presented')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'INFORMATION PRESENTED',
                'score' => $request->speaker1_information_presented,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_organization')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'ORGANIZATION',
                'score' => $request->speaker1_organization,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_conclusions')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CONCLUSIONS',
                'score' => $request->speaker1_conclusions,
                'speaker_no' => 'A',

            ];
        }

        if ($request->has('speaker1_confidence')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CONFIDENCE',
                'score' => $request->speaker1_confidence,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_state_presence')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'STATE PRESENCE',
                'score' => $request->speaker1_state_presence,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_audience_interest')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'ABILITY TO MAINTAIN AUDIENCE INTEREST AND ENGAGEMENT',
                'score' => $request->speaker1_audience_interest,
                'speaker_no' => 'A',

            ];
        }
        if ($request->has('speaker1_visual_aids')) {
            $speakerA[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CLARITY OF VISUAL AIDS',
                'score' => $request->speaker1_visual_aids,
                'speaker_no' => 'A',

            ];
        }


        DB::table('tbl_event_plenary')->insert($speakerA);

        return "success";
    }


    public function eventTopicSpeakerB(Request $request)
    {
        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();

        $eventPlenary = EventPlenary::where('is_active',true)
        ->where('pps_no',$member->pps_no)
        ->where('event_id',$request->event_id)
        ->where('topic_id',$request->event_topic_id)
        ->where('speaker_no','B')
        ->delete();


        $speakerB = [];


        if ($request->has('speaker2_objectives')) {
            $speakerB[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'OBJECTIVES',
                'score' => $request->speaker2_objectives,
                'speaker_no' => 'B',

            ];
        }
        if ($request->has('speaker2_information_presented')) {
            $speakerB[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'INFORMATION PRESENTED',
                'score' => $request->speaker2_information_presented,
                'speaker_no' => 'B',

            ];
        }
        if ($request->has('speaker2_organization')) {
            $speakerB[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'ORGANIZATION',
                'score' => $request->speaker2_organization,
                'speaker_no' => 'B',

            ];
        }
        if ($request->has('speaker2_conclusions')) {
            $speakerB[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CONCLUSIONS',
                'score' => $request->speaker2_conclusions,
                'speaker_no' => 'B',

            ];
        }

        if ($request->has('speaker2_confidence')) {
            $speakerB[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CONFIDENCE',
                'score' => $request->speaker2_confidence,
                'speaker_no' => 'B',

            ];
        }
        if ($request->has('speaker2_state_presence')) {
            $speakerB[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'STATE PRESENCE',
                'score' => $request->speaker2_state_presence,
                'speaker_no' => 'B',

            ];
        }
        if ($request->has('speaker2_audience_interest')) {
            $speakerB[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'ABILITY TO MAINTAIN AUDIENCE INTEREST AND ENGAGEMENT',
                'score' => $request->speaker2_audience_interest,
                'speaker_no' => 'B',

            ];
        }
        if ($request->has('speaker2_visual_aids')) {
            $speakerB[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CLARITY OF VISUAL AIDS',
                'score' => $request->speaker2_visual_aids,
                'speaker_no' => 'B',

            ];
        }


        DB::table('tbl_event_plenary')->insert($speakerB);

        return "success";
    }

    public function eventTopicSpeakerC(Request $request)
    {

        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();

        $eventPlenary = EventPlenary::where('is_active',true)
        ->where('pps_no',$member->pps_no)
        ->where('event_id',$request->event_id)
        ->where('topic_id',$request->event_topic_id)
        ->where('speaker_no','C')
        ->delete();


        $speakerC = [];


        if ($request->has('speaker3_objectives')) {
            $speakerC[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'OBJECTIVES',
                'score' => $request->speaker3_objectives,
                'speaker_no' => 'C',

            ];
        }
        if ($request->has('speaker3_information_presented')) {
            $speakerC[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'INFORMATION PRESENTED',
                'score' => $request->speaker3_information_presented,
                'speaker_no' => 'C',

            ];
        }
        if ($request->has('speaker3_organization')) {
            $speakerC[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'ORGANIZATION',
                'score' => $request->speaker3_organization,
                'speaker_no' => 'C',

            ];
        }
        if ($request->has('speaker3_conclusions')) {
            $speakerC[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CONCLUSIONS',
                'score' => $request->speaker3_conclusions,
                'speaker_no' => 'C',

            ];
        }

        if ($request->has('speaker3_confidence')) {
            $speakerC[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CONFIDENCE',
                'score' => $request->speaker3_confidence,
                'speaker_no' => 'C',

            ];
        }
        if ($request->has('speaker3_state_presence')) {
            $speakerC[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'STATE PRESENCE',
                'score' => $request->speaker3_state_presence,
                'speaker_no' => 'C',

            ];
        }
        if ($request->has('speaker3_audience_interest')) {
            $speakerC[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'ABILITY TO MAINTAIN AUDIENCE INTEREST AND ENGAGEMENT',
                'score' => $request->speaker3_audience_interest,
                'speaker_no' => 'C',

            ];
        }
        if ($request->has('speaker3_visual_aids')) {
            $speakerC[] = [
                'created_at' => now(),
                'created_by' => $created_by,
                'updated_at' => now(),
                'is_active' => true,
                'event_id' => $request->event_id,
                'topic_id' => $request->event_topic_id,
                'pps_no' => $member->pps_no,
                'criteria' => 'CLARITY OF VISUAL AIDS',
                'score' => $request->speaker3_visual_aids,
                'speaker_no' => 'C',

            ];
        }


        DB::table('tbl_event_plenary')->insert($speakerC);

        return "success";
    }


    public function eventTopicFinalizePlenary(Request $request)
    {

        $prc_number = Session::get('prc_number');
        $created_by = Session::get('first_name') . ' ' . Session::get('last_name');
        $first_name = Session::get('first_name');
        $last_name = Session::get('last_name');

        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','!=','PENDING')
        ->where('tbl_member_info.prc_number',$prc_number)
        ->first();

        $eventTopic = EventTopic::where('is_active',true)
        ->where('id',$request->event_topic_id)
        ->first();


        $topic_attendance = new EventAttend();
        $topic_attendance->created_by = $created_by;
        $topic_attendance->is_active = true;
        $topic_attendance->date_attend = Carbon::now()->timezone('Asia/Manila');
        $topic_attendance->event_id = $request->event_id;
        $topic_attendance->topic_id = $request->event_topic_id;
        $topic_attendance->pps_no = $member->pps_no;

        $topic_attendance->save();


        $cpd_points = new CPDPoints();
        $cpd_points->created_at = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
        $cpd_points->created_by = $created_by;
        $cpd_points->is_active = true;
        $cpd_points->pps_no = $member->pps_no;
        $cpd_points->points = $eventTopic->points_on_site;
        $cpd_points->category_name = 'EVENT';
        $cpd_points->item_id =  $request->event_topic_id;
        $cpd_points->event_id = $request->event_id;

        $cpd_points->save();


        $topic_attendance_temp = new TopicAttendTemp();
        $topic_attendance_temp->created_by = $created_by;
        $topic_attendance_temp->is_active = true;
        $topic_attendance_temp->first_name = $first_name;
        $topic_attendance_temp->last_name = $last_name;
        $topic_attendance_temp->prc_number = $prc_number;
        $topic_attendance_temp->event_id = $request->event_id;
        $topic_attendance_temp->topic_id = $request->event_topic_id;

        $topic_attendance_temp->save();



        session()->forget('prc_number');
        session()->forget('first_name');
        session()->forget('last_name');


        return "success";
    }


    public function eventCheckAttended(Request $request)
    {
        $this->authorize('manage-attendance', User::class);

        $eventTransaction = EventTransaction::where('is_active',true)
        ->where('pps_no',$request->pps_no)
        ->where('event_id',$request->event_id)
        ->where('attended',true)
        ->count();

        return $eventTransaction;

    }


    public function eventCheckAttendedViaPRC(Request $request)
    {
        $this->authorize('manage-attendance', User::class);

        $prc_no = $request->input('prc_no');
        $member_info = MemberInfo::where('is_active', true)
            ->where('prc_number', $prc_no)
            ->first();

        $eventTransaction = EventTransaction::where('is_active',true)
        ->where('pps_no',$member_info->pps_no)
        ->where('event_id',$request->event_id)
        ->where('attended',true)
        ->count();

        return response()->json([
            'event_transaction' => $eventTransaction,
            'member_info' => $member_info,
        ]);

    }


    public function eventChoosePrintAttendance()
    {
        $this->authorize('manage-attendance', User::class);
        $title = "";
        $event = Event::select( 'tbl_event.*','cat.name',
            DB::raw("(select file_name from tbl_event_image where event_id = tbl_event.id and is_active = true and status = 'UPLOADED' order by id asc limit 1) as event_image")  )
            ->join('tbl_event_category as cat','cat.id','=','tbl_event.category_id')
            ->where('tbl_event.is_active',true)
            ->whereIn('tbl_event.status',['ONGOING','UPCOMING'])
            ->paginate(10);

        return view('events.attendance-print-choose',compact('event','title'));

    }

    public function eventChoosePrintAttendanceSearch(Request $request)
    {

        $this->authorize('manage-attendance', User::class);
        $title = $request->title;
        $event = Event::select( 'tbl_event.*','cat.name',
            DB::raw("(select file_name from tbl_event_image where event_id = tbl_event.id and is_active = true and status = 'UPLOADED' order by id asc limit 1) as event_image")  )
            ->join('tbl_event_category as cat','cat.id','=','tbl_event.category_id')
            ->where('tbl_event.is_active',true)
            ->whereIn('tbl_event.status',['ONGOING','UPCOMING'])
            ->where('tbl_event.title','ILIKE', "%$request->title%")
            ->paginate(10);

        return view('events.attendance-print-choose',compact('event','title'));

    }


    public function eventPrintAttendance($id)
    {
        $this->authorize('manage-attendance', User::class);
        $name = "";

        $event_transaction = EventTransaction::select('tbl_event_transaction.*',
                        'mem_info.picture','mem_info.first_name','mem_info.middle_name','mem_info.last_name','mem_info.suffix','mem_info.prc_number',
                        'type.member_type_name',
                        'chapter.chapter_name',
                        'event.identification_card_image'
            )
            ->join('tbl_member_info as mem_info','mem_info.pps_no','=','tbl_event_transaction.pps_no')
            ->leftJoin('tbl_member_type as type','type.id','=','mem_info.member_type')
            ->leftJoin('tbl_chapter as chapter','chapter.id','=','mem_info.member_chapter')
            ->leftJoin('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
            ->where('tbl_event_transaction.is_active',true)
            ->where('tbl_event_transaction.event_id',Crypt::decrypt($id))
            ->where('tbl_event_transaction.attended',true)
            ->orderBy('tbl_event_transaction.attended_dt','DESC')
            ->paginate(10);



        return view('events.attendance-print',compact('event_transaction','id','name'));
    }

    public function eventPrintAttendanceSearch($id, Request $request)
    {

        $this->authorize('manage-attendance', User::class);

        $name = $request->input('searchTerm');

        $event_transaction = EventTransaction::select('tbl_event_transaction.*',
                        'mem_info.picture','mem_info.first_name','mem_info.middle_name','mem_info.last_name','mem_info.suffix','mem_info.prc_number',
                        'type.member_type_name',
                        'chapter.chapter_name',
                        'event.identification_card_image'
            )
            ->join('tbl_member_info as mem_info','mem_info.pps_no','=','tbl_event_transaction.pps_no')
            ->leftJoin('tbl_member_type as type','type.id','=','mem_info.member_type')
            ->leftJoin('tbl_chapter as chapter','chapter.id','=','mem_info.member_chapter')
            ->leftJoin('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
            ->where('tbl_event_transaction.is_active',true)
            ->where('tbl_event_transaction.event_id',Crypt::decrypt($id))
            ->where('tbl_event_transaction.attended',true)
            ->where(function($query) use ($name) {
                $query
                      ->orWhere('mem_info.first_name', 'ILIKE', "%$name%")
                      ->orWhere('mem_info.middle_name', 'ILIKE', "%$name%")
                      ->orWhere('mem_info.last_name', 'ILIKE', "%$name%")
                      ->orWhere('mem_info.prc_number', 'ILIKE', "%$name%");
            })
            ->orderBy('tbl_event_transaction.attended_dt','DESC','name')
            ->paginate(10);



        return view('events.attendance-print',compact('event_transaction','id','name'));
    }



    // public function downloadEventIdentificationCard($filename, $id)
    // {
    //     $this->authorize('manage-attendance', User::class);

    //     // $orig_file_name = Crypt::decrypt($filename);
    //     $orig_file_name = 'sticker-paper.png';



    //     $event_transaction_id = Crypt::decrypt($id);

    //     $event_transaction = EventTransaction::select('tbl_event_transaction.*','event.title')
    //         ->leftJoin('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
    //         ->where('tbl_event_transaction.is_active',true)
    //         ->where('tbl_event_transaction.id',$event_transaction_id)
    //         ->first();

    //     $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
    //         ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
    //         ->where('tbl_member_info.pps_no',$event_transaction->pps_no)
    //         ->first();

    //     $member_last_name = $member->last_name;
    //     $member_first_name = $member->first_name;
    //     $member_type_name = $member->member_type_name;

    //     $member_type = ["DIPLOMATE", "FELLOW", "EMERITUS FELLOW", "ACTIVE MEMBER"];

    //     if (in_array($member->member_type_name, $member_type)) {
    //         $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . '. ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix) . ', M.D.';
    //     } else {
    //         $member_name = strtoupper($member->first_name) . ' ' . substr(strtoupper($member->middle_name), 0, 1) . ' ' .  strtoupper($member->last_name) . ' ' . strtoupper($member->suffix);
    //     }

    //     $imagePath = public_path('assets/img/' . $orig_file_name);
    //     $fontPath = public_path('assets/fonts/calibri-bold.ttf');
    //     $fontPath2 = public_path('assets/fonts/calibri-regular.ttf');

    //     $encoded_char_last_name = mb_encode_numericentity($member_last_name, array(0x0080, 0xffff, 0, 0xffff), 'UTF-8');
    //     $encoded_char_first_name = mb_encode_numericentity($member_first_name, array(0x0080, 0xffff, 0, 0xffff), 'UTF-8');

    //     if($member_type_name == "DIPLOMATE" || $member_type_name == "FELLOW" || $member_type_name == "EMERITUS FELLOW")
    //     {
    //         $encoded_char_member_type_name = mb_encode_numericentity($member_type_name, array(0x0080, 0xffff, 0, 0xffff), 'UTF-8');
    //     }
    //     else
    //     {
    //         $encoded_char_member_type_name = mb_encode_numericentity("", array(0x0080, 0xffff, 0, 0xffff), 'UTF-8');
    //     }

    //     $event_name = 'EVENT: ' . ' ' . $event_transaction->title;

    //     if (!file_exists($imagePath)) {
    //         return response()->json(['error' => 'Image not found'], 404);
    //     }

    //     if (!file_exists($fontPath)) {
    //         return response()->json(['error' => 'Font file not found'], 404);
    //     }

    //     $imageContent = file_get_contents($imagePath);
    //     $img = Image::read($imageContent);
    //     $width = $img->width();



    //     // Function to adjust font size
    //     $adjustFontSizeForWidth = function ($text, $maxWidth, $fontPath, $fontSize, $angle = 0) {
    //         do {
    //             $box = imagettfbbox($fontSize, $angle, $fontPath, $text);
    //             $textWidth = abs($box[4] - $box[0]);
    //             if ($textWidth > $maxWidth) {
    //                 $fontSize--;
    //             }
    //         } while ($textWidth > $maxWidth && $fontSize > 1);

    //         return $fontSize;
    //     };

    //     $borderWidth = 1;
    //     $maxWidthWithBorder = $width - (2 * $borderWidth);

    //     // Adjust font size for member name
    //     $fontSizeForMemberLastName = $adjustFontSizeForWidth($encoded_char_last_name, $maxWidthWithBorder, $fontPath, 35);
    //     $fontSizeForMemberFirstName = $adjustFontSizeForWidth($encoded_char_first_name, $maxWidthWithBorder, $fontPath, 30);
    //     $fontSizeForMemberType = $adjustFontSizeForWidth($encoded_char_member_type_name, $maxWidthWithBorder, $fontPath, 15);


    //     $img->text($encoded_char_last_name, $width / 2, 10, function ($font) use ($fontPath, $fontSizeForMemberLastName) {
    //         $font->file($fontPath);
    //         $font->size($fontSizeForMemberLastName);
    //         $font->color('#000000');
    //         $font->align('center');
    //         $font->valign('top');
    //     });

    //     $img->text($encoded_char_first_name, $width / 2, 38, function ($font) use ($fontPath, $fontSizeForMemberFirstName) {
    //         $font->file($fontPath);
    //         $font->size($fontSizeForMemberFirstName);
    //         $font->color('#000000');
    //         $font->align('center');
    //         $font->valign('top');
    //     });


    //     $img->text($encoded_char_member_type_name, $width / 2, 65, function ($font) use ($fontPath2, $fontSizeForMemberType) {
    //         $font->file($fontPath2);
    //         $font->size($fontSizeForMemberType);
    //         $font->color('#000000');
    //         $font->align('center');
    //         $font->valign('top');
    //     });



    //     $tempImage = tempnam(sys_get_temp_dir(), 'img_') . '.jpg';
    //     $img->save($tempImage);

    //     // Generate the base64-encoded image
    //     $base64Image = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($tempImage));

    //     // Return the HTML to display the image and trigger print
    //     return response()->make(
    //         view('events.print-image', [
    //             'imageSrc' => $base64Image,
    //         ])
    //     );
    // }

    public function downloadEventIdentificationCard($id)
    {
        try {
            $event_transaction_id = Crypt::decrypt($id);

            $event_transaction = EventTransaction::select('tbl_event_transaction.*', 'event.title')
                ->leftJoin('tbl_event as event', 'event.id', '=', 'tbl_event_transaction.event_id')
                ->where('tbl_event_transaction.is_active', true)
                ->where('tbl_event_transaction.id', $event_transaction_id)
                ->first();

            $member = MemberInfo::select('tbl_member_info.*', 'type.member_type_name')
                ->leftJoin('tbl_member_type as type', 'type.id', '=', 'tbl_member_info.member_type')
                ->where('tbl_member_info.pps_no', $event_transaction->pps_no)
                ->first();


            $fontSizeLastname = '28px'; 
            $fontSizeFirstname = '28px'; 
            if (strlen($member->last_name) > 14) {
                $fontSizeLastname = '22px'; 
            }
            if (strlen($member->first_name) > 18) {
                $fontSizeFirstname = '20px'; 
            }



            $html = view('events.identification-card', [
                'member' => $member,
                'filename' => 'idcard',
                'fontSizeLastname' => $fontSizeLastname,
                'fontSizeFirstname' => $fontSizeFirstname
            ])->render();

            $pdf = Pdf::loadHTML($html)
                      ->setPaper([0, 0, 252, 180])
                      ->setOption('dpi', 96)
                      ->setOption('isHtml5ParserEnabled', true);


            return $pdf->stream('Event_ID_Card_' . $event_transaction->id . '.pdf');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Unable to generate the ID card: ' . $e->getMessage());
        }
    }

    public function eventFacebookLiveSave(Request $request)
    {
        
        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->where('id',$request->event_id)
        ->first();

        $event->fb_live_url = $request->fb_live_url;
        $event->save();

        return "success";
    }

    public function eventYoutubeLiveSave(Request $request)
    {
        
        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->where('id',$request->event_id)
        ->first();

        $event->youtube_live_url = trim($request->youtube_url);
        $event->save();

        return "success";
    }

    public function eventQuestionnaireLinkSave(Request $request)
    {
        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->where('id',$request->event_id)
        ->first();

        $event->questionnaire_link = trim($request->questionnaire_link);
        $event->save();

        return "success";

    }


    public function eventSurveyLinkSave(Request $request)
    {
        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->where('id',$request->event_id)
        ->first();

        $event->survey_link = trim($request->survey_link);
        $event->save();

        return "success";

    }

    public function eventSurveyLinkDateTimeSave(Request $request)
    {
        $event = Event::select( 'tbl_event.*')
        ->where('is_active',true)
        ->where('id',$request->event_id)
        ->first();

        $event->survey_link_date_time = $request->survey_link_date_time;
        $event->save();

        return "success";

    }



    

    public function eventTopicAddFBLiveUrl(Request $request)
    {

        $eventTopic = EventTopic::where('tbl_event_topic.id',$request->topic_id)
        ->first();

        $eventTopic->fb_live_url = trim($request->fb_live_url);
        $eventTopic->save();


        return "success";
    }

    public function eventFacebookLiveAttend(Request $request)
    {
        //CHECK IF MEMBER HAS ALREADY CLICK THE FB LIVE BUTTON
        $topic_attend_count = EventAttend::where('is_active',true)
        ->where('event_id',$request->event_id)
        ->where('pps_no',$request->pps_no)
        ->where('topic_id',$request->topic_id)
        ->count();

        if($topic_attend_count < 1)
        {
            $fb_live_attend = new EventAttend();
            $fb_live_attend->created_by = auth()->user()->name;
            $fb_live_attend->is_active = true;
            $fb_live_attend->date_attend = Carbon::now('Asia/Manila');
            $fb_live_attend->event_id = $request->event_id;
            $fb_live_attend->topic_id = $request->topic_id;
            $fb_live_attend->pps_no = $request->pps_no;

            $fb_live_attend->save();

            
        }
        return "success";
       
    }


    

    public function eventTopicUpdate(Request $request)
    {
        $eventTopic = EventTopic::where('tbl_event_topic.id',$request->topic_id)
        ->first();

        $eventTopic->topic_name = $request->topic_name;
        $eventTopic->points_on_site = $request->points_on_site;
        $eventTopic->points_online = $request->points_online;
        $eventTopic->save();

        return "success";

    }


    public function eventLivestream(Request $request)
    {

        $this->authorize('member-access', User::class);

        $pps = auth()->user()->pps_no;

        $event = Event::select( 'tbl_event.*',
            DB::raw("(select count(*) from tbl_event_transaction where event_id = tbl_event.id and is_active = true and pps_no = $pps) as paid_event"),
            DB::raw("(select is_livestream from tbl_event_transaction where event_id = tbl_event.id and is_active = true and pps_no = $pps LIMIT 1) as is_livestream"),
            DB::raw("(select date_attend from tbl_event_attend where event_id = tbl_event.id and is_active = true and pps_no = $pps ORDER BY id DESC LIMIT 1) as date_attended")
        )
            ->where('is_active',true)
            ->orderBy('id','DESC')
            ->paginate(10);

        return view('events.livestream',compact('event'));

    }


    public function eventLivestreamSearch(Request $request)
    {
        $this->authorize('member-access', User::class);

        $name = $request->input('searchinput');

            $pps = auth()->user()->pps_no;
    
            $event = Event::select( 'tbl_event.*',
                DB::raw("(select count(*) from tbl_event_transaction where event_id = tbl_event.id and is_active = true and pps_no = $pps) as paid_event"),
                DB::raw("(select is_livestream from tbl_event_transaction where event_id = tbl_event.id and is_active = true and pps_no = $pps) as is_livestream")
            )
                ->where('is_active',true)
                ->where('title','ILIKE', "%$name%")
                ->orderBy('id','DESC')
                ->paginate(10);
    
            return view('events.livestream',compact('event'));

    }



    public function eventLivestreamView($id)
    {
        $this->authorize('member-access', User::class);
        $pps = auth()->user()->pps_no;

        $ids = Crypt::decrypt($id);


        $event = Event::select( 'tbl_event.*',
        DB::raw("(select count(*) from tbl_event_transaction where event_id = tbl_event.id and is_active = true and pps_no = $pps) as paid_event"),
        DB::raw("(select is_livestream from tbl_event_transaction where event_id = tbl_event.id and is_active = true and pps_no = $pps) as is_livestream")
        )
        ->where('tbl_event.is_active',true)
        ->where('tbl_event.id',$ids)
        ->first();

        
        if($event->paid_event < 1 || $event->is_livestream == false)
        {
            return redirect('event-livestream-video');
        }

        $youtubeUrl = $event->youtube_live_url;

        // Extract the video ID from the URL
        parse_str(parse_url($youtubeUrl, PHP_URL_QUERY), $queryParams);
        $videoId = $queryParams['v'] ?? null;
        
        // Generate the embed URL with autoplay (NO MUTE) and privacy mode
        $embedUrl = "https://www.youtube-nocookie.com/embed/" . $videoId . '?theme=dark&autoplay=0&autohide=0&cc_load_policy=1&modestbranding=1&fs=1&showinfo=0&rel=0&iv_load_policy=3&mute=0&loop=1';

        //CHECK IF MEMBER HAS ALREADY CLICK THE YOUTUBE LIVE BUTTON
        $attend_count = EventAttend::where('is_active',true)
        ->where('event_id',$ids)
        ->where('pps_no',$pps)
        ->whereDate('date_attend', Carbon::now('Asia/Manila'))
        ->count();


            $youtube_live_attend = new EventAttend();
            $youtube_live_attend->created_by = auth()->user()->name;
            $youtube_live_attend->is_active = true;
            $youtube_live_attend->date_attend = Carbon::now('Asia/Manila');
            $youtube_live_attend->event_id = $ids;
            $youtube_live_attend->pps_no = $pps;

            $youtube_live_attend->save();

            

        $eventAttend = EventAttend::where('is_active',true)
        ->where('event_id',$ids)
        ->where('pps_no',$pps)
        ->orderBy('id','DESC')
        ->first();
        

        return view('events.livestream-view',compact('event','embedUrl','eventAttend'));
     
    }



}





