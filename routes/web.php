<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberInfoController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\CPDPointsController;
use App\Http\Controllers\AnnualDuesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebHookController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\ICDController;
use App\Http\Controllers\SpecialtyBoardController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\PaymentGatewayController;

use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-all', function () {
    if (!auth()->check() || auth()->user()->role_id !== 1) {
        abort(403);
    }

    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');

    return 'All caches cleared and rebuilt successfully!';
})->middleware('auth'); // TODO P1: replace role_id check with Spatie hasRole('Admin')

Route::get('/', function () {
    return redirect('sign-in');
})->middleware('guest');



Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('apply-member/{type}', [LoginController::class, 'applyMember'])->middleware('guest')->name('apply-member');
Route::post('save-applicant-member', [MemberInfoController::class, 'saveApplicantMember'])->middleware('guest');



Route::get('update-member-new-info/{encodedPPSNo}', [MemberInfoController::class, 'updateMemberNewInfoView'])->middleware('auth');
Route::post('update-member-new-info-submit', [MemberInfoController::class, 'updateMemberNewInfoSubmit'])->middleware('auth');



Route::get('check-email', [MemberInfoController::class, 'checkEmail'])->middleware('guest');
Route::get('check-prc-exist',[MemberInfoController::class, 'checkPRCNo'])->middleware('guest');

Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');

Route::get('reset-email', [SessionsController::class, 'resetEmail'])->middleware('guest');
Route::get('reset-password-form/{id}', [SessionsController::class, 'resetPasswordForm'])->middleware('guest');

Route::post('send-email-reset-password', [SessionsController::class, 'senEmailResetPassword'])->middleware('guest');

Route::post('reset-password-submit', [SessionsController::class, 'resetPasswordSubmit'])->middleware('guest');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');

Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');


Route::get('event-topic-attendance-disable',[EventController::class, 'eventTopicAttendanceDisable'])->middleware('guest');

Route::get('event-topic-attendance/{id}',[EventController::class, 'eventTopicAttendance'])->middleware('guest');
Route::get('event-topic-attend-plenary',[EventController::class, 'eventTopicAttendPlenary'])->middleware('guest');
Route::get('event-topic-question-answer-plenary/{id}',[EventController::class, 'eventTopicQuestionAnswerPlenary'])->middleware('guest');
Route::get('event-topic-speaker-a',[EventController::class, 'eventTopicSpeakerA'])->middleware('guest');
Route::get('event-topic-speaker-b',[EventController::class, 'eventTopicSpeakerB'])->middleware('guest');
Route::get('event-topic-speaker-c',[EventController::class, 'eventTopicSpeakerC'])->middleware('guest');
Route::get('event-topic-finalize-plenary',[EventController::class, 'eventTopicFinalizePlenary'])->middleware('guest');



Route::get('event-topic-attend-none-question',[EventController::class, 'eventTopicAttendNoneQuestion'])->middleware('guest');
Route::get('event-topic-attend-with-question',[EventController::class, 'eventTopicAttendWithQuestion'])->middleware('guest');
Route::get('event-topic-question-answer/{id}',[EventController::class, 'eventTopicQuestionAnswer'])->middleware('guest');
Route::get('event-topic-proceed-score',[EventController::class, 'eventTopicProceedScore'])->middleware('guest');








// Route::get('verify', function () {
// 	return view('sessions.password.verify');
// })->middleware('guest')->name('verify');

// Route::get('reset-password/{token}', function ($token) {
// 	return view('sessions.password.reset', ['token' => $token]);
// })->middleware('guest')->name('password.reset');


// Route::post('user-profile/password', [UserController::class, 'passwordUpdate'])->middleware('auth')->name('password.change');


// Route::get('roles', [RolesController::class, 'index'])->middleware('auth')->name('roles');
// Route::post('roles/{id}', [RolesController::class, 'destroy'])->middleware('auth')->name('delete.role');
// Route::get('new-role', [RolesController::class, 'create'])->middleware('auth')->name('add.role');
// Route::post('new-role', [RolesController::class, 'store'])->middleware('auth');
// Route::post('edit-role/{id}', [RolesController::class, 'update'])->middleware('auth');
// Route::get('edit-role/{id}', [RolesController::class, 'edit'])->middleware('auth')->name('edit.role');


// Route::get('category', [CategoryController::class, 'index'])->middleware('auth')->name('category');
// Route::post('category/{id}', [CategoryController::class, 'destroy'])->middleware('auth')->name('delete.category');
// Route::get('new-category', [CategoryController::class, 'create'])->middleware('auth')->name('add.category');
// Route::post('new-category', [CategoryController::class, 'store'])->middleware('auth');
// Route::post('edit-category/{id}', [CategoryController::class, 'update'])->middleware('auth');
// Route::get('edit-category/{id}', [CategoryController::class, 'edit'])->middleware('auth')->name('edit.category');


// Route::get('tag',[TagController::class, 'index'])->middleware('auth')->name('tag');
// Route::post('tag/{id}', [TagController::class, 'destroy'])->middleware('auth')->name('delete.tag');
// Route::get('new-tag', [TagController::class, 'create'])->middleware('auth')->name('add.tag');
// Route::post('new-tag', [TagController::class, 'store'])->middleware('auth');
// Route::post('edit-tag/{id}', [TagController::class, 'update'])->middleware('auth');
// Route::get('edit-tag/{id}', [TagController::class, 'edit'])->middleware('auth')->name('edit.tag');

// Route::get('items', [ItemsController::class, 'index'])->middleware('auth')->name('items');
// Route::get('new-item', [ItemsController::class, 'create'])->middleware('auth')->name('add.item');
// Route::post('new-item',[ItemsController::class, 'store'])->middleware('auth');
// Route::get('edit-item/{id}',[ItemsController::class, 'edit'])->middleware('auth')->name('edit.item');
// Route::post('edit-item/{id}',[ItemsController::class, 'update'])->middleware('auth');
// Route::post('items/{id}', [ItemsController::class, 'destroy'])->middleware('auth')->name('delete.item');


// Route::get('users-management', [UserManagementController::class, 'index'])->middleware('auth')->name('users');
// Route::get('add-new-user', [UserManagementController::class, 'create'])->middleware('auth')->name('add.user');
// Route::post('add-new-user', [UserManagementController::class, 'store'])->middleware('auth');
// Route::get('edit-user/{id}',[UserManagementController::class, 'edit'])->middleware('auth')->name('edit.user');
// Route::post('edit-user/{id}',[UserManagementController::class, 'update'])->middleware('auth');
// Route::post('users-management/{id}',[UserManagementController::class, 'destroy'])->middleware('auth')->name('delete.user');












Route::middleware(['auth', 'session.timeout'])->group(function () {
	Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
    Route::get('audit-trails', [AuditController::class, 'index'])->middleware('auth')->name('audit-trails');
    Route::get('payment-gateway', [PaymentGatewayController::class, 'index'])->middleware('auth')->name('payment-gateway');
    Route::post('payment-gateway', [PaymentGatewayController::class, 'update'])->middleware('auth')->name('payment-gateway.update');

	Route::get('voting-listing',[VotingController::class, 'votingListing'])->middleware('auth')->name('voting-listing');
	Route::get('voting-create',[VotingController::class, 'votingCreate'])->middleware('auth');
	Route::post('voting-create-save', [VotingController::class, 'votingSave'])->middleware('auth');
	Route::get('voting-add-candidate',[VotingController::class, 'votingAddCandidate'])->middleware('auth');
	Route::get('voting-remove-candidate',[VotingController::class, 'votingRemoveCandidate'])->middleware('auth');
	Route::get('voting-elect/{id}',[VotingController::class, 'votingElect'])->middleware('auth');
	Route::get('voting-election/{id}',[VotingController::class, 'votingElectionFinal'])->middleware('auth');
	Route::get('voting-select-candidate',[VotingController::class, 'votingSelectCandidate'])->middleware('auth');
	Route::get('voting-remove-selected-candidate',[VotingController::class, 'votingRemoveSelectedCandidate'])->middleware('auth');
	// Route::get('voting-finalize',[VotingController::class, 'votingFinalize'])->middleware('auth');
	Route::get('voting-check-allowed',[VotingController::class, 'votingCheckAllowed'])->middleware('auth');
	Route::get('voting-details/{id}',[VotingController::class, 'votingDetails'])->middleware('auth');
	Route::get('voting-add-bot-candidate',[VotingController::class, 'votingAddCandidateBot'])->middleware('auth');
	Route::get('voting-remove-candidate-bot',[VotingController::class, 'votingRemoveCandidateBot'])->middleware('auth');
	Route::get('voting-add-chap-rep-candidate',[VotingController::class, 'votingAddCandidateChapRep'])->middleware('auth');
	Route::get('voting-remove-candidate-chap-rep',[VotingController::class, 'votingRemoveCandidateChapRep'])->middleware('auth');
	Route::get('voting-select-candidate-bot',[VotingController::class, 'votingSelectCandidateBOT'])->middleware('auth');
	Route::get('voting-select-candidate-chap-rep',[VotingController::class, 'votingSelectCandidateChapRep'])->middleware('auth');
	Route::get('voting-result/{id}',[VotingController::class, 'votingResult'])->middleware('auth');

	Route::post('voting-update',[VotingController::class, 'votingUpdate'])->middleware('auth');
	Route::post('voting-update-status',[VotingController::class, 'votingUpdateStatus'])->middleware('auth');
	Route::get('voting-add-bot-candidate-update',[VotingController::class, 'votingAddCandidateBotUpdate'])->middleware('auth');
	Route::get('voting-add-chap-rep-candidate-update',[VotingController::class, 'votingAddCandidateChapRepUpdate'])->middleware('auth');
	Route::post('voting-finalize',[VotingController::class, 'votingElectionFinalize'])->middleware('auth');


	Route::post('change-default-password',[DashboardController::class, 'changeDefaultPassword'])->middleware('auth');

	Route::post('webhook-pps-paymongo2',[WebHookController::class, 'ppsPaymongoWebhook'])->middleware('auth');


	Route::get('payment-hold', [MaintenanceController::class, 'paymentHold'])->middleware('auth');


	Route::get('check-prc', [MemberInfoController::class, 'checkPRCNo'])->middleware('auth');
	Route::post('accept-applicant', [MemberInfoController::class, 'acceptApplicant'])->middleware('auth');

	Route::post('accept-applicants', [MemberInfoController::class, 'acceptApplicant2'])->middleware('auth');


	Route::post('save-email', [MaintenanceController::class, 'saveEmail'])->middleware('auth');
	Route::post('update-email', [MaintenanceController::class, 'updateEmail'])->middleware('auth');
	Route::post('delete-email', [MaintenanceController::class, 'deleteEmail'])->middleware('auth');
	Route::get('check-email-exist', [MaintenanceController::class, 'checkEmailExist'])->middleware('auth');


	Route::post('user-maintenance-reclassification-save', [MaintenanceController::class, 'saveReclassification'])->middleware('auth');


	Route::get('event-listing',[EventController::class, 'eventList'])->middleware('auth');
	Route::get('event-create',[EventController::class, 'eventCreate'])->middleware('auth');
	Route::get('event-online-video',[EventController::class, 'eventOnlineVideo'])->middleware('auth');
	Route::get('event-online-video-view/{topic_ids}',[EventController::class, 'eventOnlineVideoView'])->middleware('auth');
	Route::get('event-online-search',[EventController::class, 'eventOnlineVideoSearch'])->middleware('auth')->name('event-online-search');

	Route::get('event-livestream-video',[EventController::class, 'eventLivestream'])->middleware('auth');
	Route::get('event-livestream-video-view/{id}',[EventController::class, 'eventLivestreamView'])->middleware('auth');
	Route::get('event-livestream-search',[EventController::class, 'eventLivestreamSearch'])->middleware('auth')->name('event-livestream-search');

	Route::get('event-online-topic-question-answer/{id}',[EventController::class, 'eventOnlineTopicQuestionAnswer'])->middleware('auth');
	Route::get('event-online-topic-proceed-score',[EventController::class, 'eventOnlineTopicProceedScore'])->middleware('auth');


	Route::get('event-online-topic-question-answer-plenary/{id}',[EventController::class, 'eventOnlineTopicQuestionAnswerPlenary'])->middleware('auth');

	Route::get('event-online-topic-question-answer-plenary-temp/{id}',[EventController::class, 'eventOnlineTopicQuestionAnswerPlenaryTemp'])->middleware('auth');


	Route::get('event-online-topic-speaker-a',[EventController::class, 'eventOnlineTopicSpeakerA'])->middleware('auth');
	Route::get('event-online-topic-speaker-a-temp',[EventController::class, 'eventOnlineTopicSpeakerATemp'])->middleware('auth');
	Route::get('event-online-topic-finalize-plenary',[EventController::class, 'eventOnlineTopicFinalizePlenary'])->middleware('auth');



	Route::get('event-save', [EventController::class, 'eventSave'])->middleware('auth');
	Route::post('event-create-save', [EventController::class, 'eventCreateSave'])->middleware('auth');
	Route::get('event-update', [EventController::class, 'eventUpdateSubmit'])->middleware('auth');
	Route::get('fetch-calendar-events', [EventController::class, 'getEventCalendar'])->middleware('auth');
	Route::get('check-existing-events', [EventController::class, 'checkExistEvent'])->middleware('auth');
	Route::get('check-existing-events-same-id', [EventController::class, 'checkExistEventSameId'])->middleware('auth');
	// Route::post('event-upload-image', [EventController::class, 'eventImageUpload'])->middleware('auth');
	Route::post('event-delete-image', [EventController::class, 'eventImageDelete'])->middleware('auth');
	Route::post('event-delete-image2', [EventController::class, 'eventImageDelete2'])->middleware('auth');
	Route::get('event-remove-image', [EventController::class, 'eventRemoveDelete'])->middleware('auth');
	Route::get('event-join', [EventController::class, 'eventJoin'])->middleware('auth');
	Route::get('event-check-joined', [EventController::class, 'eventCheckJoined'])->middleware('auth');
	Route::get('event-view/{id}',[EventController::class, 'eventView'])->middleware('auth');
	Route::get('event-update/{id}',[EventController::class, 'eventUpdate'])->middleware('auth');
	Route::post('event-upload-image', [EventController::class, 'eventImage'])->middleware('auth');
	Route::post('event-upload-image2', [EventController::class, 'eventImage2'])->middleware('auth');
	Route::get('event-choose-attendance', [EventController::class, 'eventChooseAttendance'])->middleware('auth');
	Route::get('event-choose-attendance-search', [EventController::class, 'eventChooseAttendanceSearch'])->middleware('auth');
	Route::get('event-attendance/{id}',[EventController::class, 'eventAttendance'])->middleware('auth');
	Route::get('event-attendance-check-count',[EventController::class, 'eventCheckCountAttendance'])->middleware('auth');
	Route::get('event-attendance-check-count-via-prc',[EventController::class, 'eventCheckCountAttendanceViaPRC'])->middleware('auth');
	Route::get('event-attendance-check-count2',[EventController::class, 'eventCheckCountAttendance2'])->middleware('auth');
	Route::get('event-attendance-check',[EventController::class, 'eventCheckAttendance'])->middleware('auth');
	Route::get('event-attendance-check-via-prc',[EventController::class, 'eventCheckAttendanceViaPRC'])->middleware('auth');
	Route::get('event-member-not-attended',[EventController::class, 'eventMemberNotAttended'])->middleware('auth');
	Route::get('event-member-not-attended-via-prc',[EventController::class, 'eventMemberNotAttendedViaPRC'])->middleware('auth');

	Route::get('event-add-committee-group',[EventController::class, 'eventAddCommitteeGroup'])->middleware('auth');
	Route::get('event-get-committee--group-list',[EventController::class, 'eventGetCommitteeGroupList'])->middleware('auth');
	Route::get('event-add-committee',[EventController::class, 'eventAddCommittee'])->middleware('auth');
	Route::get('event-add-organizer',[EventController::class, 'eventAddOrganizer'])->middleware('auth');
	Route::get('event-remove-committee',[EventController::class, 'eventRemoveCommittee'])->middleware('auth');
	Route::get('event-remove-organizer',[EventController::class, 'eventRemoveOrganizer'])->middleware('auth');
	Route::get('event-pay/{event_transaction_id}', [EventController::class, 'eventPay'])->middleware('auth');
	Route::get('event-payment-final/{id}', [EventController::class, 'eventPaymentFinal'])->middleware('auth');
	Route::post('event-payment', [EventController::class, 'eventPayment'])->middleware('auth');
	Route::get('success-event-payment-member/{transaction_id}/{total_amount}/{pps_no}/{eventId}', [EventController::class, 'successEventPaymentMember'])->middleware('auth');
	Route::get('failed-event-payment-member/{eventId}',[EventController::class, 'failedEventPaymentMember'])->middleware('auth');
	Route::get('event-topic/{id}',[EventController::class, 'eventTopic'])->middleware('auth');
	Route::get('/check-member-exist', [MemberInfoController::class, 'checkMemberExist'])->middleware('auth');

	Route::get('/check-member-exist-via-prc', [MemberInfoController::class, 'checkMemberExistViaPRC'])->middleware('auth');



	Route::get('choose-print-attendance', [EventController::class, 'eventChoosePrintAttendance'])->middleware('auth');
	Route::get('choose-print-attendance-search', [EventController::class, 'eventChoosePrintAttendanceSearch'])->middleware('auth');
	Route::get('print-attendance/{id}', [EventController::class, 'eventPrintAttendance'])->middleware('auth');
	Route::get('print-attendance-search/{id}', [EventController::class, 'eventPrintAttendanceSearch'])->middleware('auth');


	Route::get('event-check-attended',[EventController::class, 'eventCheckAttended'])->middleware('auth');
	Route::get('event-check-attended-via-prc',[EventController::class, 'eventCheckAttendedViaPRC'])->middleware('auth');

	
	Route::get('event-topic-download-qr/{eventtopicurl}',[EventController::class, 'eventTopicDownloadQR'])->middleware('auth');
	// Route::get('event-topic-add-question',[EventController::class, 'eventTopicAddQuestion'])->middleware('auth');

	Route::post('event-topic-add-question', [EventController::class, 'eventTopicAddQuestion'])->middleware('auth');

	Route::post('event-topic-update', [EventController::class, 'eventTopicUpdate'])->middleware('auth');

	
	Route::post('event-payment-online', [EventController::class, 'eventPaymentOnline'])->middleware('auth');
	Route::get('success-event-payment-online/{price}/{pps_no}/{event_id}', [EventController::class, 'successEventOnlinePayment'])->middleware('auth');

	Route::get('event-count-topic-attendee', [EventController::class, 'countTopicAttendee'])->middleware('auth');

	Route::get('event-topic-add-fb-live-url',[EventController::class, 'eventTopicAddFBLiveUrl'])->middleware('auth');
	
	Route::get('event-facebook-live-attend',[EventController::class, 'eventFacebookLiveAttend'])->middleware('auth');
	

	// Route::get('download-image/{folderName}/{filename}', [EventController::class, 'downloadImage'])
    // ->middleware('auth')
    // ->name('download-image');

	Route::get('event-download-certificate/{folder}/{filename}/{id}', [EventController::class, 'downloadCertificate'])->middleware('auth');

	Route::get('event-download-certificate2/{folder}/{filename}/{id}/{ids}', [EventController::class, 'downloadCertificate2'])->middleware('auth');
	Route::get('event-download-certificate-seminar-2/{folder}/{filename}/{id}/{ids}', [EventController::class, 'downloadCertificateWebinar2'])->middleware('auth');

	Route::get('event-download-certificate-seminar/{folder}/{filename}/{id}', [EventController::class, 'downloadCertificateWebinar'])->middleware('auth');


	Route::get('event-download-identification-card/{id}', [EventController::class, 'downloadEventIdentificationCard'])->middleware('auth');


	Route::get('event-topic-check-attendance',[EventController::class, 'eventTopicCheckAttendance'])->middleware('auth');


	Route::get('event-facebook-live-url', [EventController::class, 'eventFacebookLiveSave'])->middleware('auth');


	Route::get('event-youtube-live-url', [EventController::class, 'eventYoutubeLiveSave'])->middleware('auth');

	Route::get('event-questionnaire-link', [EventController::class, 'eventQuestionnaireLinkSave'])->middleware('auth');
	Route::get('event-survey-link', [EventController::class, 'eventSurveyLinkSave'])->middleware('auth');
	Route::get('event-survey-link-date-time', [EventController::class, 'eventSurveyLinkDateTimeSave'])->middleware('auth');




	
	Route::get('user-profile', [UserController::class, 'index'])->middleware('auth')->name('user-profile');
	Route::post('user-profile', [UserController::class, 'update'])->middleware('auth')->name('user.update');


	Route::post('send-email',[MemberInfoController::class, 'sendEmail'])->middleware('auth');
	Route::get('applicant-listing',[MemberInfoController::class, 'applicantListing'])->middleware('auth')->name('applicant-listing');
	Route::get('applicant-profile/{pps_no}',[MemberInfoController::class, 'applicantProfile'])->middleware('auth');
	Route::get('applicant-disapprove', [MemberInfoController::class, 'applicantDisapprove'])->middleware('auth');
	Route::post('save-member',[MemberInfoController::class, 'saveMember'])->middleware('auth');
	Route::get('applicant-list-search',[MemberInfoController::class, 'applicantListingSearch'])->middleware('auth')->name('applicant-list-search');
	Route::get('applicant-delete', [MemberInfoController::class, 'applicantDelete'])->middleware('auth');



	Route::get('member-listing',[MemberInfoController::class, 'memberListing'])->middleware('auth')->name('member-listing');
	Route::get('member-listing-all',[MemberInfoController::class, 'memberListingAll'])->middleware('auth')->name('member-listing-all');
	Route::get('member-info/{pps_no}',[MemberInfoController::class, 'memberInfo'])->middleware('auth');
	Route::get('member-listing-chapter/{id}',[MemberInfoController::class, 'memberListingChapter'])->middleware('auth');
	Route::get('member-search-listing-all',[MemberInfoController::class, 'memberSearchListingAll'])->middleware('auth')->name('member-search-listing-all');
	Route::get('member-search-listing-chapter',[MemberInfoController::class, 'memberSearchListingChapter'])->middleware('auth')->name('member-search-listing-chapter');
	Route::get('member-info-update/{pps_no}',[MemberInfoController::class, 'memberInfoUpdate'])->middleware('auth');
	Route::post('member-info-update-submit', [MemberInfoController::class, 'memberInfoUpdateSubmit'])->middleware('auth');



	Route::get('member-reclassification',[MemberInfoController::class, 'memberReclassification'])->middleware('auth')->name('member-reclassification');
	Route::get('member-reclassification-view/{id}',[MemberInfoController::class, 'memberReclassificationView'])->middleware('auth');
	Route::post('member-reclassification-save', [MemberInfoController::class, 'saveMemberReclassification'])->middleware('auth');
	Route::get('member-reclassification-search',[MemberInfoController::class, 'memberReclassificationSearch'])->middleware('auth')->name('member-reclassification-search');

	Route::get('cashier-event',[CashierController::class, 'cashierEventView'])->middleware('auth');
	Route::get('cashier-event-pay/{id}',[CashierController::class, 'cashierEventPay'])->middleware('auth');
	// Route::post('cashier-event-pay', [CashierController::class, 'cashierEventPay'])->middleware('auth');
	Route::post('cashier-event-payment', [CashierController::class, 'cashierEventPayment'])->middleware('auth');
	Route::get('success-event-payment/{transaction_id}/{total_amount}/{pps_no}', [CashierController::class, 'successEventPayment'])->middleware('auth');
	Route::get('failed-event-payment',[CashierController::class, 'failedEventPayment'])->middleware('auth');
	Route::get('cashier-event-pay-manual',[CashierController::class, 'cashierEventPayManual'])->middleware('auth');
	Route::get('cashier-event-transaction/{id}',[CashierController::class, 'cashierEventTransaction'])->middleware('auth');
	Route::get('cashier-event-add-customer',[CashierController::class, 'cashierEventAddCustomer'])->middleware('auth');
	Route::get('cashier-search-event',[CashierController::class, 'cashierSearchEventTransaction'])->middleware('auth')->name('cashier-search-event');


	Route::get('cashier-annual-dues',[CashierController::class, 'cashierAnnualDuesView'])->middleware('auth');
	Route::get('cashier-annual-dues-transaction/{pps_no}',[CashierController::class, 'cashierAnnualDuesTransaction'])->middleware('auth');
	Route::get('cashier-annual-dues-add-cart',[CashierController::class, 'cashierAnnualDuesAddCart'])->middleware('auth');
	Route::get('cashier-annual-dues-remove-cart',[CashierController::class, 'cashierAnnualDuesRemoveCart'])->middleware('auth');
	Route::post('cashier-annual-dues-pay',[CashierController::class, 'cashierAnnualDuesPay'])->middleware('auth');
	Route::post('cashier-annual-dues-pay-cheque',[CashierController::class, 'cashierAnnualDuesPayCheque'])->middleware('auth');
	Route::post('cashier-update-annual-dues-or-number', [CashierController::class, 'cashierAnnualDuesUpdateORNumber'])->middleware('auth');
	Route::post('cashier-annual-dues-choose-member', [CashierController::class, 'cashierAnnualDuesChooseMember'])->middleware('auth');
	Route::get('cashier-annual-dues-remove',[CashierController::class, 'cashierAnnualDuesRemove'])->middleware('auth');
	Route::get('cashier-annual-dues-add-annual-dues',[CashierController::class, 'cashierAddAnnualDues'])->middleware('auth');
	Route::post('cashier-annual-dues-pay-bank-transfer',[CashierController::class, 'cashierAnnualDuesPayBankTransfer'])->middleware('auth');
	Route::post('cashier-update-annual-dues-online-payment', [CashierController::class, 'cashierAnnualDuesUpdateOnlinePayment'])->middleware('auth');
	Route::post('cashier-update-event-online-payment', [CashierController::class, 'cashierEventUpdateOnlinePayment'])->middleware('auth');
	Route::get('cashier-new-transaction',[CashierController::class, 'cashierNewTransaction'])->middleware('auth');


	Route::get('/cashier/search-member-dropdown', [CashierController::class, 'searchMemberDropDown'])->name('cashier.searchMemberDropDown');
	Route::get('/cashier/search-member-dropdown-without-encrypt', [CashierController::class, 'searchMemberDropDownWithoutEncrypt'])->name('cashier.searchMemberDropDownWithoutEncrypt');


	


	Route::post('cashier-new-transaction-proceed', [CashierController::class, 'cashierNewTransactionProceed'])->middleware('auth');
	Route::get('cashier-new-transaction-cart/{pps_no}',[CashierController::class, 'cashierNewTransactionCart'])->middleware('auth');
	Route::get('cashier-transaction-add-cart-annual-dues',[CashierController::class, 'cashierTransactionAnnualDuesAddCart'])->middleware('auth');
	Route::get('cashier-transaction-add-cart-events',[CashierController::class, 'cashierTransactionEventsAddCart'])->middleware('auth');
	Route::get('cashier-transaction-remove-cart',[CashierController::class, 'cashierTransactionRemoveCart'])->middleware('auth');
	Route::post('cashier-transaction-payment-online', [CashierController::class, 'cashierTransactionPaymentOnline'])->middleware('auth');
	Route::get('success-cashier-transaction-payment-online/{pps_no}/{total}', [CashierController::class, 'successCashierTransactionPaymentMember'])->middleware('auth');
	Route::post('cashier-transaction-pay',[CashierController::class, 'cashierTransactionPay'])->middleware('auth');
	Route::post('cashier-transaction-pay-cheque',[CashierController::class, 'cashierTransactionPayCheque'])->middleware('auth');
	Route::post('cashier-transaction-pay-bank-transfer',[CashierController::class, 'cashierTransactionPayBankTransfer'])->middleware('auth');
	Route::get('cashier-report',[CashierController::class, 'cashierReport'])->middleware('auth');

	Route::post('cashier-export-excel', [CashierController::class, 'exportExcel'])->middleware('auth');



	Route::get('cashier-test-datatable',[CashierController::class, 'cashierTestDatatable'])->middleware('auth')->name('cashier.cashier-test-datatable');
	Route::post('/get-products', [CashierController::class, 'cashierTestDatatable'])->name('products.getProducts');



	Route::get('cashier-search-annual-dues',[CashierController::class, 'cashierSearchAnnualDuesTransaction'])->middleware('auth')->name('cashier-search-annual-dues');



	Route::post('cashier-annual-dues-payment-online', [CashierController::class, 'annualDuesPaymentOnline'])->middleware('auth');
	Route::get('success-cashier-annual-dues-payment-online/{pps_no}/{total}', [CashierController::class, 'successCashierAnnualDuesPaymentMember'])->middleware('auth');


	Route::post('cashier-sync-annual-dues', [CashierController::class, 'cashierSyncAnnualDues'])->middleware('auth');
	Route::post('cashier-sync-event-payment', [CashierController::class, 'cashierSyncEventPayment'])->middleware('auth');


	Route::get('documents-choose-member',[DocumentsController::class, 'documentsChooseMember'])->middleware('auth');
	Route::get('documents-upload/{pps_no}',[DocumentsController::class, 'documentsUpload'])->middleware('auth');
	Route::post('documents-upload-submit', [DocumentsController::class, 'documentsUploadSubmit'])->middleware('auth');
	Route::get('documents-download/{file_name}',[DocumentsController::class, 'documentsDownload'])->middleware('auth');
	Route::get('documents-delete', [DocumentsController::class, 'documentsDelete'])->middleware('auth');


	Route::get('create-annual-dues',[AnnualDuesController::class, 'annualDuesCreate'])->middleware('auth')->name('create-annual-dues');
	Route::post('save-annual-dues', [AnnualDuesController::class, 'annualDuesSave'])->middleware('auth');
	Route::get('listing-annual-dues',[AnnualDuesController::class, 'annualDuesList'])->middleware('auth');
	Route::post('update-annual-dues', [AnnualDuesController::class, 'annualDuesUpdate'])->middleware('auth');
	Route::get('delete-annual-dues',[AnnualDuesController::class, 'annualDuesDelete'])->middleware('auth');



	Route::get('payment-listing',[PaymentController::class, 'paymentList'])->middleware('auth');
	Route::post('payment-online', [PaymentController::class, 'paymentOnline'])->middleware('auth');
	Route::get('success-or-payment/{transaction_id}/{total_amount}/{pps_no}', [PaymentController::class, 'successOrPayment'])->middleware('auth');
	Route::get('payment-online-final/{id}',[PaymentController::class, 'paymentOnlineFinal'])->middleware('auth');
	Route::get('failed-or-payment',[EventController::class, 'failedOrPayment'])->middleware('auth');


	Route::get('event-livestream-maintenance',[MaintenanceController::class, 'eventLivestreamMaintenance'])->middleware('auth');
	Route::get('event-livestream-select-member/{id}',[MaintenanceController::class, 'eventLivestreamSelectMemberMaintenance'])->middleware('auth');
	Route::get('event-add-livestream-member', [MaintenanceController::class, 'eventAddLivestreamMember'])->middleware('auth');
	Route::get('event-livestream-search-participant/{id}',[MaintenanceController::class, 'eventLivestreamSearchParticipant'])->middleware('auth')->name('event-livestream-search-participant');
	Route::get('event-remove-livestream-member', [MaintenanceController::class, 'eventRemoveLivestreamMember'])->middleware('auth');

	// Route::get('cpdpoints-admin-view-search-points/{pps_no}',[CPDPointsController::class, 'adminSearchViewMemberCPDPoints'])->middleware('auth')->name('cpdpoints-admin-view-search-points');


	
	Route::get('email-maintenance',[MaintenanceController::class, 'emailMaintenance'])->middleware('auth');
	Route::get('user-maintenance',[MaintenanceController::class, 'userMaintenance'])->middleware('auth');
	Route::get('user-maintenance-edit/{pps_no}',[MaintenanceController::class, 'userMaintenanceEdit'])->middleware('auth');
	Route::post('user-maintenance-update',[MaintenanceController::class, 'updateUser'])->middleware('auth');
	Route::get('user-maintenance-reset-password',[MaintenanceController::class, 'userResetPassword'])->middleware('auth');
	Route::get('user-maintenance-search-user',[MaintenanceController::class, 'userSearchUser'])->middleware('auth')->name('user-maintenance-search-user');
	Route::post('user-maintenance-update-image',[MaintenanceController::class, 'updateUserImage'])->middleware('auth');

	Route::get('email-user-maintenance',[MaintenanceController::class, 'emailUserMaintenance'])->middleware('auth');
	Route::post('user-maintenance-update-email',[MaintenanceController::class, 'updateUserEmail'])->middleware('auth');

	Route::get('user-maintenance-new-hospital',[MaintenanceController::class, 'userMaintenanceNewHospital'])->middleware('auth');
	Route::post('user-maintenance-add-new-hospital',[MaintenanceController::class, 'userAddNewHospital'])->middleware('auth');


	Route::get('user-maintenance-new-attendance',[MaintenanceController::class, 'userMaintenanceNewAttendance'])->middleware('auth');
	Route::post('user-maintenance-add-new-attendance',[MaintenanceController::class, 'userAddNewAttendance'])->middleware('auth');


	Route::get('send-bulk-email-annual-convention',[MaintenanceController::class, 'sendBulkEmailAnnualConvention'])->middleware('auth');
	
	
	Route::get('user-maintenance-upload-certificate/{pps_no}',[MaintenanceController::class, 'userMaintenanceUploadCertificate'])->middleware('auth');


	Route::get('cpdpoints-index',[CPDPointsController::class, 'index'])->middleware('auth');
	Route::get('cpdpoints-view/{pps_no}',[CPDPointsController::class, 'view'])->middleware('auth');
	Route::get('cpdpoints-submit',[CPDPointsController::class, 'save'])->middleware('auth');


	Route::get('cpdpoints-member-view',[CPDPointsController::class, 'viewMemberCPD'])->middleware('auth');
	Route::get('cpdpoints-view-event-cpd/{id}',[CPDPointsController::class, 'viewEventCPD'])->middleware('auth');


	Route::get('cpdpoints-admin-view',[CPDPointsController::class, 'adminViewMemberCPD'])->middleware('auth');
	Route::get('cpdpoints-admin-view-search',[CPDPointsController::class, 'adminSearchViewMemberCPD'])->middleware('auth')->name('cpdpoints-admin-view-search');
	Route::get('cpdpoints-admin-view-member/{pps_no}',[CPDPointsController::class, 'adminViewMemberCPDDetails'])->middleware('auth');
	Route::get('cpdpoints-admin-view-search-points/{pps_no}',[CPDPointsController::class, 'adminSearchViewMemberCPDPoints'])->middleware('auth')->name('cpdpoints-admin-view-search-points');


	Route::get('icd-admitted-upload',[ICDController::class, 'admittedUpload'])->middleware('auth');
	Route::get('icd-admitted-view',[ICDController::class, 'admittedView'])->middleware('auth');
	Route::post('icd-admitted-upload-save', [ICDController::class, 'admittedUploadSave'])->middleware('auth');
	Route::get('icd-admitted-upload-check-exist',[ICDController::class, 'admittedUploadCheckExist'])->middleware('auth');
	Route::get('icd-admitted-search',[ICDController::class, 'admittedSearch'])->middleware('auth')->name('icd-admitted-search');
	Route::get('icd-admitted-view-details/{id}',[ICDController::class, 'admittedViewDetails'])->middleware('auth');

	Route::get('icd-admitted-view-patient/{id}',[ICDController::class, 'admittedViewPatient'])->middleware('auth');
    Route::get('icd-admin-admitted-view-patient/{id}',[ICDController::class, 'adminAdmittedViewPatient'])->middleware('auth');



	Route::get('icd-admitted-view-month/{id}',[ICDController::class, 'admittedViewMonth'])->middleware('auth');
	Route::get('icd-admitted-search-month/{id}', [ICDController::class, 'admittedSearchMonth'])
    ->middleware('auth')
    ->name('icd-admitted-search-month');
    Route::get('icd-admin-admitted-view-search',[ICDController::class, 'adminAdmittedViewSearch'])->middleware('auth')->name('icd-admin-admitted-view-search');
    Route::get('icd-admin-admitted-view-month/{id}',[ICDController::class, 'adminAdmittedViewMonth'])->middleware('auth');

    Route::get('icd-admin-neonatal-view-month/{id}',[ICDController::class, 'adminNeonatalViewMonth'])->middleware('auth');



    Route::get('icd-admin-admitted-view-month-search/{id}', [ICDController::class, 'adminAdmittedViewMonthSearch'])
        ->middleware('auth')
        ->name('icd-admin-admitted-view-month-search');


    Route::get('icd-admin-neonatal-view-month-search/{id}', [ICDController::class, 'adminNeonatalViewMonthSearch'])
        ->middleware('auth')
        ->name('icd-admin-neonatal-view-month-search');


    Route::get('icd-neonatal-search-month/{id}', [ICDController::class, 'neonatalSearchMonth'])
    ->middleware('auth')
    ->name('icd-neonatal-search-month');

	Route::get('icd-neonatal-view-patient/{id}',[ICDController::class, 'neonatalViewPatient'])->middleware('auth');
    Route::get('icd-admin-neonatal-view-patient/{id}',[ICDController::class, 'adminNeonatalViewPatient'])->middleware('auth');



	Route::get('icd-neonatal-view-month/{id}',[ICDController::class, 'neonatalViewMonth'])->middleware('auth');
	Route::get('icd-neonatal-upload',[ICDController::class, 'neonatalUpload'])->middleware('auth');
	Route::get('icd-neonatal-view',[ICDController::class, 'neonatalView'])->middleware('auth');
	Route::get('icd-neonatal-upload-check-exist',[ICDController::class, 'neonatalUploadCheckExist'])->middleware('auth');
	Route::post('icd-neonatal-upload-save', [ICDController::class, 'neonatalUploadSave'])->middleware('auth');
	Route::get('icd-neonatal-search',[ICDController::class, 'neonatalSearch'])->middleware('auth')->name('icd-neonatal-search');
	Route::get('icd-neonatal-view-details/{id}',[ICDController::class, 'neonatalViewDetails'])->middleware('auth');


	Route::get('icd-template-download',[ICDController::class, 'templateDownload'])->middleware('auth');
	Route::get('icd-patient-template-download/{folder}/{filename}', [ICDController::class, 'downloadPatientTemplate'])->middleware('auth');
	Route::get('icd-neonatal-template-download/{folder}/{filename}', [ICDController::class, 'downloadNeonatalTemplate'])->middleware('auth');

	Route::get('icd-delete-ward',[ICDController::class, 'wardDelete'])->middleware('auth');
	Route::get('icd-delete-ward-patient',[ICDController::class, 'wardPatientDelete'])->middleware('auth');
	Route::get('icd-delete-neonatal',[ICDController::class, 'neonatalDelete'])->middleware('auth');
	Route::get('icd-delete-neonatal-patient',[ICDController::class, 'neonatalPatientDelete'])->middleware('auth');

	Route::get('icd-admin-admitted-view',[ICDController::class, 'adminAdmittedView'])->middleware('auth');
	Route::get('icd-admin-admitted-search',[ICDController::class, 'adminAdmittedSearch'])->middleware('auth')->name('icd-admin-admitted-search');


	Route::get('icd-admin-neonatal-view',[ICDController::class, 'adminNeonatalView'])->middleware('auth');
	Route::get('icd-admin-neonatal-search',[ICDController::class, 'adminNeonatalSearch'])->middleware('auth')->name('icd-admin-neonatal-search');

    Route::get('icd-admin-neonatal-view-search',[ICDController::class, 'adminNeonatalViewSearch'])->middleware('auth')->name('icd-admin-neonatal-view-search');

	Route::get('icd-admin-admitted-view-details/{id}',[ICDController::class, 'adminAdmittedViewDetails'])->middleware('auth');
	Route::get('icd-admin-neonatal-view-details/{id}',[ICDController::class, 'adminNeonatalViewDetails'])->middleware('auth');





	Route::get('icd-admin-new-code',[ICDController::class, 'adminNewCode'])->middleware('auth');
	Route::get('icd-admin-add-code',[ICDController::class, 'adminAddCode'])->middleware('auth');



	Route::get('specialty-board-view',[SpecialtyBoardController::class, 'view'])->middleware('auth');
	Route::get('specialty-board-update-profile',[SpecialtyBoardController::class, 'updateProfile'])->middleware('auth');
	Route::post('specialty-board-update-submit',[SpecialtyBoardController::class, 'updateSubmit'])->middleware('auth');
	Route::get('specialty-board-payment/{id}',[SpecialtyBoardController::class, 'paymentDetails'])->middleware('auth');
	Route::post('specialty-board-payment-online', [SpecialtyBoardController::class, 'specialtyBoardPaymentOnline'])->middleware('auth');

	Route::get('success-specialty-board-payment-online/{price}/{pps_no}/{pricelist_id}', [SpecialtyBoardController::class, 'successSpecialtyBoardOnlinePayment'])->middleware('auth');


	Route::get('specialty-board-admin-view',[SpecialtyBoardController::class, 'adminView'])->middleware('auth');
    Route::get('specialty-board-admin-export',[SpecialtyBoardController::class, 'adminExport'])->middleware('auth');

    Route::post('specialty-board-admin-generate-export', [SpecialtyBoardController::class, 'adminGenerateExportReport'])->middleware('auth');




    Route::get('reports-view',[ReportsController::class, 'viewReports'])->middleware('auth');
	Route::get('reports-choose/{id}',[ReportsController::class, 'chooseReport'])->middleware('auth');
	Route::get('reports-member-list/{id}',[ReportsController::class, 'memberListReport'])->middleware('auth')->name('reports-member-list');;
	Route::post('reports-member-generate', [ReportsController::class, 'generateReport'])->middleware('auth');

	Route::get('reports-event-attendance-list/{id}',[ReportsController::class, 'eventAttendanceListReport'])->middleware('auth')->name('reports-event-attendance-list');;
	Route::post('reports-event-attendance-generate', [ReportsController::class, 'generateEventAttendanceReport'])->middleware('auth');



	Route::get('certificate-upload',[CertificateController::class, 'adminCertificateUpload'])->middleware('auth');
	Route::get('certificate-admin-list',[CertificateController::class, 'adminListMember'])->middleware('auth');
	Route::post('certificate-upload-save', [CertificateController::class, 'uploadListMember'])->middleware('auth');
	Route::get('certificate-admin-search', [CertificateController::class, 'adminSearch'])->middleware('auth')->name('certificate-admin-search');
	Route::get('certificate-admin-remove',[CertificateController::class, 'adminRemoveMember'])->middleware('auth');
	Route::get('certificate-admin-download/{prc_number}', [CertificateController::class, 'adminDownloadCertificate2'])->middleware('auth');

	
});

Route::group(['middleware' => 'auth'], function () {

	// Route::get('charts', function () {
	// 	return view('pages.charts');
	// })->name('charts');

	// Route::get('notifications', function () {
	// 	return view('pages.notifications');
	// })->name('notifications');

	// Route::get('pricing-page', function () {
	// 	return view('pages.pricing-page');
	// })->name('pricing-page');

    // Route::get('rtl', function () {
	// 	return view('pages.rtl');
	// })->name('rtl');

	// Route::get('sweet-alerts', function () {
	// 	return view('pages.sweet-alerts');
	// })->name('sweet-alerts');

	// Route::get('widgets', function () {
	// 	return view('pages.widgets');
	// })->name('widgets');

	// Route::get('vr-default', function () {
	// 	return view('pages.vr.vr-default');
	// })->name('vr-default');

	// Route::get('vr-info', function () {
	// 	return view("pages.vr.vr-info");
	// })->name('vr-info');

	// Route::get('new-user', function () {
	// 	return view('pages.users.new-user');
	// })->name('new-user');

    // Route::get('reports', function () {
	// 	return view('pages.users.reports');
	// })->name('reports');

    // Route::get('general', function () {
	// 	return view('pages.projects.general');
	// })->name('general');

	// Route::get('new-project', function () {
	// 	return view('pages.projects.new-project');
	// })->name('new-project');

	// Route::get('timeline', function () {
	// 	return view('pages.projects.timeline');
	// })->name('timeline');

	// Route::get('overview', function () {
	// 	return view('pages.profile.overview');
	// })->name('overview');

	// Route::get('projects', function () {
	// 	return view("pages.profile.projects");
	// })->name('projects');

	// Route::get('billing', function () {
	// 	return view('pages.account.billing');
	// })->name('billing');

    // Route::get('invoice', function () {
	// 	return view('pages.account.invoice');
	// })->name('invoice');

    // Route::get('security', function () {
	// 	return view('pages.account.security');
	// })->name('security');

	// Route::get('settings', function () {
	// 	return view('pages.account.settings');
	// })->name('settings');

	// Route::get('referral', function () {
	// 	return view('ecommerce.referral');
	// })->name('referral');

	// Route::get('details', function () {
	// 	return view('ecommerce.orders.details');
	// })->name('details');

	// Route::get('list', function () {
	// 	return view("ecommerce.orders.list");
	// })->name('list');

	// Route::get('edit-product', function () {
	// 	return view('ecommerce.products.edit-product');
	// })->name('edit-product');

    // Route::get('new-product', function () {
	// 	return view('ecommerce.products.new-product');
	// })->name('new-product');

    // Route::get('product-page', function () {
	// 	return view('ecommerce.products.product-page');
	// })->name('product-page');

    // Route::get('products-list', function () {
	// 	return view('ecommerce.products.products-list');
	// })->name('products-list');

	// Route::get('automotive', function () {
	// 	return view('dashboard.automotive');
	// })->name('automotive');

	// Route::get('discover', function () {
	// 	return view('dashboard.discover');
	// })->name('discover');

	// Route::get('sales', function () {
	// 	return view('dashboard.sales');
	// })->name('sales');

	// Route::get('smart-home', function () {
	// 	return view("dashboard.smart-home");
	// })->name('smart-home');

	// Route::get('404', function () {
	// 	return view('errors.404');
	// })->name('404');

    // Route::get('500', function () {
	// 	return view('errors.500');
	// })->name('500');

    // Route::get('basic-lock', function () {
	// 	return view('authentication.lock.basic');
	// })->name('basic-lock');

    // Route::get('cover-lock', function () {
	// 	return view('authentication.lock.cover');
	// })->name('cover-lock');

    // Route::get('illustration-lock', function () {
	// 	return view('authentication.lock.illustration');
	// })->name('illustration-lock');

    // Route::get('basic-reset', function () {
	// 	return view('authentication.reset.basic');
	// })->name('basic-reset');

    // Route::get('cover-reset', function () {
	// 	return view('authentication.reset.cover');
	// })->name('cover-reset');

    // Route::get('illustration-reset', function () {
	// 	return view('authentication.reset.illustration');
	// })->name('illustration-reset');

    // Route::get('basic-sign-in', function () {
	// 	return view('authentication.sign-in.basic');
	// })->name('basic-sign-in');

    // Route::get('cover-sign-in', function () {
	// 	return view('authentication.sign-in.cover');
	// })->name('cover-sign-in');

    // Route::get('illustration-sign-in', function () {
	// 	return view('authentication.sign-in.illustration');
	// })->name('illustration-sign-in');

    // Route::get('basic-sign-up', function () {
	// 	return view('authentication.sign-up.basic');
	// })->name('basic-sign-up');

    // Route::get('cover-sign-up', function () {
	// 	return view('authentication.sign-up.cover');
	// })->name('cover-sign-up');

    // Route::get('illustration-sign-up', function () {
	// 	return view('authentication.sign-up.illustration');
	// })->name('illustration-sign-up');

    // Route::get('basic-verification', function () {
	// 	return view('authentication.verification.basic');
	// })->name('basic-verification');

    // Route::get('cover-verification', function () {
	// 	return view('authentication.verification.cover');
	// })->name('cover-verification');

    // Route::get('illustration-verification', function () {
	// 	return view('authentication.verification.illustration');
	// })->name('illustration-verification');

    // Route::get('calendar', function () {
	// 	return view('applications.calendar');
	// })->name('calendar');

    // Route::get('crm', function () {
	// 	return view('applications.crm');
	// })->name('crm');

    // Route::get('datatables', function () {
	// 	return view('applications.datatables');
	// })->name('datatables');

    // Route::get('kanban', function () {
	// 	return view('applications.kanban');
	// })->name('kanban');

    // Route::get('stats', function () {
	// 	return view('applications.stats');
	// })->name('stats');

    // Route::get('wizard', function () {
	// 	return view('applications.wizard');
	// })->name('wizard');



});
