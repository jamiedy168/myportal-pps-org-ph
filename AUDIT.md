# PPS Member Portal — Full Codebase Audit
**Date:** 2026-04-05  
**Audited by:** Claude Code (claude-sonnet-4-6)  
**Laravel Version:** 9.x | **PHP:** ^8.0 | **Database:** PostgreSQL

---

## 1. ROUTES

### API Routes (`routes/api.php`)

| Method | URL | Controller@Method | Auth |
|--------|-----|-------------------|------|
| GET | `/api/user` | Closure (returns authed user) | Sanctum |
| POST | `/api/pps-final-webhook` | WebHookController@paymentWebhook | None |

> ⚠️ Two webhook routes are commented out: `pps-annual-dues-webhook` and `pps-event-webhook`. Only `pps-final-webhook` is active.

---

### Web Routes (`routes/web.php`)

#### Public / Guest Routes (no authentication required)

| Method | URL | Controller@Method | Middleware |
|--------|-----|-------------------|------------|
| GET | `/` | Redirect → sign-in | guest |
| GET | `/clear-all` | Artisan cache clear (closure) | **NONE — open to public** |
| GET | `sign-up` | RegisterController@create | guest |
| POST | `sign-up` | RegisterController@store | guest |
| GET | `apply-member/{type}` | LoginController@applyMember | guest |
| POST | `save-applicant-member` | MemberInfoController@saveApplicantMember | guest |
| GET | `check-email` | MemberInfoController@checkEmail | guest |
| GET | `check-prc-exist` | MemberInfoController@checkPRCNo | guest |
| GET | `sign-in` | SessionsController@create | guest |
| POST | `sign-in` | SessionsController@store | guest |
| GET | `reset-email` | SessionsController@resetEmail | guest |
| GET | `reset-password-form/{id}` | SessionsController@resetPasswordForm | guest |
| POST | `send-email-reset-password` | SessionsController@senEmailResetPassword | guest |
| POST | `reset-password-submit` | SessionsController@resetPasswordSubmit | guest |
| POST | `verify` | SessionsController@show | guest |
| POST | `reset-password` | SessionsController@update | guest |
| GET | `event-topic-attendance-disable` | EventController@eventTopicAttendanceDisable | guest |
| GET | `event-topic-attendance/{id}` | EventController@eventTopicAttendance | guest |
| GET | `event-topic-attend-plenary` | EventController@eventTopicAttendPlenary | guest |
| GET | `event-topic-question-answer-plenary/{id}` | EventController@eventTopicQuestionAnswerPlenary | guest |
| GET | `event-topic-speaker-a` | EventController@eventTopicSpeakerA | guest |
| GET | `event-topic-speaker-b` | EventController@eventTopicSpeakerB | guest |
| GET | `event-topic-speaker-c` | EventController@eventTopicSpeakerC | guest |
| GET | `event-topic-finalize-plenary` | EventController@eventTopicFinalizePlenary | guest |
| GET | `event-topic-attend-none-question` | EventController@eventTopicAttendNoneQuestion | guest |
| GET | `event-topic-attend-with-question` | EventController@eventTopicAttendWithQuestion | guest |
| GET | `event-topic-question-answer/{id}` | EventController@eventTopicQuestionAnswer | guest |
| GET | `event-topic-proceed-score` | EventController@eventTopicProceedScore | guest |

> ⚠️ **Security risk:** `GET /clear-all` triggers Artisan cache operations and is accessible by anyone without authentication.

#### Authenticated Routes (middleware: auth, session.timeout)

| Method | URL | Controller@Method |
|--------|-----|-------------------|
| GET | `dashboard` | DashboardController@index |
| GET | `audit-trails` | AuditController@index |
| GET | `payment-gateway` | PaymentGatewayController@index |
| POST | `payment-gateway` | PaymentGatewayController@update |
| GET | `update-member-new-info/{encodedPPSNo}` | MemberInfoController@updateMemberNewInfoView |
| POST | `update-member-new-info-submit` | MemberInfoController@updateMemberNewInfoSubmit |
| POST | `sign-out` | SessionsController@destroy |
| **VOTING** | | |
| GET | `voting-listing` | VotingController@votingListing |
| GET | `voting-create` | VotingController@votingCreate |
| POST | `voting-create-save` | VotingController@votingSave |
| GET | `voting-add-candidate` | VotingController@votingAddCandidate |
| GET | `voting-remove-candidate` | VotingController@votingRemoveCandidate |
| GET | `voting-elect/{id}` | VotingController@votingElect |
| GET | `voting-election/{id}` | VotingController@votingElectionFinal |
| GET | `voting-select-candidate` | VotingController@votingSelectCandidate |
| GET | `voting-remove-selected-candidate` | VotingController@votingRemoveSelectedCandidate |
| GET | `voting-check-allowed` | VotingController@votingCheckAllowed |
| GET | `voting-details/{id}` | VotingController@votingDetails |
| GET | `voting-add-bot-candidate` | VotingController@votingAddCandidateBot |
| GET | `voting-add-chap-rep-candidate` | VotingController@votingAddCandidateChapRep |
| GET | `voting-select-candidate-bot` | VotingController@votingSelectCandidateBOT |
| GET | `voting-select-candidate-chap-rep` | VotingController@votingSelectCandidateChapRep |
| **MEMBER** | | |
| GET | `applicant-listing` | MemberInfoController@applicantListing |
| GET | `applicant-profile/{pps_no}` | MemberInfoController@applicantProfile |
| GET | `member-listing` | MemberInfoController@memberListing |
| GET | `member-listing-all` | MemberInfoController@memberListingAll |
| GET | `member-info/{pps_no}` | MemberInfoController@memberInfo |
| GET | `member-info-update/{pps_no}` | MemberInfoController@memberInfoUpdate |
| **EVENTS** | | |
| GET | `event-listing` | EventController@eventList |
| GET | `event-view/{id}` | EventController@eventView |
| GET | `event-create` | EventController@eventCreate |
| POST | `event-save` | EventController@eventSave |
| GET | `event-update/{id}` | EventController@eventUpdate |
| POST | `event-update-submit` | EventController@eventUpdateSubmit |
| GET | `event-topic/{id}` | EventController@eventTopic |
| GET | `event-choose-attendance` | EventController@eventChooseAttendance |
| GET | `event-attendance/{event_id}` | EventController@eventAttendance |
| GET | `event-choose-print-attendance` | EventController@eventChoosePrintAttendance |
| GET | `event-print-attendance/{id}` | EventController@eventPrintAttendance |
| GET | `event-livestream` | EventController@eventLivestream |
| GET | `event-online-video` | EventController@eventOnlineVideo |
| **CASHIER** | | |
| GET | `cashier-event` | CashierController@cashierEventView |
| GET | `cashier-event-pay/{id}` | CashierController@cashierEventPay |
| GET | `cashier-event-transaction/{id}` | CashierController@cashierEventTransaction |
| GET | `cashier-annual-dues` | CashierController@cashierAnnualDuesView |
| GET | `cashier-annual-dues-transaction/{pps_no}` | CashierController@cashierAnnualDuesTransaction |
| POST | `cashier-annual-dues-pay` | CashierController@cashierAnnualDuesPay |
| POST | `cashier-annual-dues-pay-cheque` | CashierController@cashierAnnualDuesPayCheque |
| POST | `cashier-annual-dues-pay-bank-transfer` | CashierController@cashierAnnualDuesPayBankTransfer |
| GET | `cashier-new-transaction` | CashierController@cashierNewTransaction |
| GET | `cashier-new-transaction-cart/{pps_no}` | CashierController@cashierNewTransactionCart |
| POST | `cashier-transaction-pay` | CashierController@cashierTransactionPay |
| POST | `cashier-transaction-pay-cheque` | CashierController@cashierTransactionPayCheque |
| POST | `cashier-transaction-pay-bank-transfer` | CashierController@cashierTransactionPayBankTransfer |
| GET | `cashier-report` | CashierController@cashierReport |
| POST | `cashier-sync-annual-dues` | CashierController@cashierSyncAnnualDues |
| POST | `cashier-sync-event-payment` | CashierController@cashierSyncEventPayment |
| **MAINTENANCE** | | |
| GET | `user-maintenance` | MaintenanceController@userMaintenance |
| GET | `user-maintenance-edit/{pps_no}` | MaintenanceController@userMaintenanceEdit |
| GET | `email-maintenance` | MaintenanceController@emailMaintenance |
| GET | `event-livestream-maintenance` | MaintenanceController@eventLivestreamMaintenance |
| **IVS STREAMS** | | |
| GET | `admin/ivs` | IvsStreamController@index |
| GET | `admin/ivs/create` | IvsStreamController@create |
| POST | `admin/ivs` | IvsStreamController@store |
| GET | `admin/ivs/{ivsStream}/edit` | IvsStreamController@edit |
| PUT | `admin/ivs/{ivsStream}` | IvsStreamController@update |
| DELETE | `admin/ivs/{ivsStream}` | IvsStreamController@destroy |
| POST | `admin/ivs/{ivsStream}/toggle` | IvsStreamController@toggleStatus |
| POST | `admin/ivs/link-event` | IvsStreamController@linkToEvent |
| GET | `ivs/event/{event}/watch` | IvsStreamController@generateEventToken |
| GET | `ivs/{ivsStream}/watch` | IvsStreamController@generateToken |
| GET | `ivs/{ivsStream}/player` | IvsStreamController@player (signed middleware) |
| **CPD POINTS** | | |
| GET | `cpdpoints-index` | CPDPointsController@index |
| GET | `cpdpoints-member-view` | CPDPointsController@viewMemberCPD |
| GET | `cpdpoints-admin-view` | CPDPointsController@adminViewMemberCPD |
| **REPORTS** | | |
| GET | `reports-view` | ReportsController@viewReports |
| GET | `reports-choose/{id}` | ReportsController@chooseReport |
| **ANNUAL DUES** | | |
| GET | `create-annual-dues` | AnnualDuesController@annualDuesCreate |
| GET | `listing-annual-dues` | AnnualDuesController@annualDuesList |
| **ICD HOSPITAL** | | |
| GET | `icd-admitted-upload` | ICDController@admittedUpload |
| GET | `icd-admitted-view` | ICDController@admittedView |
| GET | `icd-neonatal-upload` | ICDController@neonatalUpload |
| GET | `icd-admin-admitted-view` | ICDController@adminAdmittedView |
| GET | `icd-admin-neonatal-view` | ICDController@adminNeonatalView |
| **SPECIALTY BOARD** | | |
| GET | `specialty-board-view` | SpecialtyBoardController@view |
| GET | `specialty-board-admin-view` | SpecialtyBoardController@adminView |
| **DOCUMENTS** | | |
| GET | `documents-choose-member` | DocumentsController@documentsChooseMember |
| GET | `documents-upload/{pps_no}` | DocumentsController@documentsUpload |
| **IMPERSONATION** | | |
| POST | `impersonate/{id}` | ImpersonateController@take |
| POST | `impersonate/leave` | ImpersonateController@leave |
| **DATABASE BACKUP** | | |
| GET | `admin/database-backup` | DatabaseBackupController@index |
| POST | `admin/database-backup` | DatabaseBackupController@create |
| GET | `admin/database-backup/download` | DatabaseBackupController@download |
| POST | `admin/database-backup/restore` | DatabaseBackupController@restore |
| **ANNOUNCEMENTS** | | |
| GET | `admin/announcements` | AnnouncementController@adminIndex |
| GET | `admin/announcements/create` | AnnouncementController@adminCreate |
| POST | `admin/announcements` | AnnouncementController@adminStore |
| GET | `admin/announcements/{id}/edit` | AnnouncementController@adminEdit |
| PUT | `admin/announcements/{id}` | AnnouncementController@adminUpdate |
| GET | `announcements` | AnnouncementController@memberIndex |

> **Note:** Role-based access within routes is enforced inline in controllers via `role_id` checks, not via route middleware. No route-level role guards exist.

---

## 2. CONTROLLERS

### AnnouncementController
| Method | Description |
|--------|-------------|
| `__construct` | Injects ImageUploader |
| `adminIndex` | Admin announcement listing |
| `adminCreate` | Show create form |
| `adminStore` | Save new announcement |
| `adminEdit` | Show edit form |
| `adminUpdate` | Save edits |
| `adminArchive` | Archive announcement |
| `memberIndex` | Member-facing announcement list |

**Role checks:** Inline `role_id == 1` checks in Blade views.

---

### AnnualDuesController
| Method | Description |
|--------|-------------|
| `annualDuesCreate` | Show form |
| `annualDuesSave` | Save — **uses raw `DB::select('CALL insert_annual_dues(...)')`** |
| `annualDuesUpdate` | Update |
| `annualDuesList` | List |
| `annualDuesDelete` | Delete |

---

### AuditController
| Method | Description |
|--------|-------------|
| `index` | Paginated audit trail listing (OwenIt) |

---

### CashierController
> Largest controller in the project. 2,400+ lines. Handles all payment processing.

| Method | Description |
|--------|-------------|
| `searchMemberDropDown` | AJAX member search (encrypted) |
| `searchMemberDropDownWithoutEncrypt` | AJAX member search (plain) |
| `cashierEventView` | Event payment dashboard |
| `cashierEventPay` | Process event payment |
| `cashierEventTransaction` | View event transaction |
| `cashierEventAddCustomer` | Add customer to event |
| `cashierEventPayment` | Submit event payment |
| `cashierEventPayManual` | Manual event payment |
| `cashierAnnualDuesView` | Annual dues dashboard |
| `cashierAnnualDuesTransaction` | View annual dues transaction |
| `cashierAnnualDuesPay` | Pay annual dues (cash) |
| `cashierAnnualDuesPayCheque` | Pay via cheque |
| `cashierAnnualDuesPayBankTransfer` | Pay via bank transfer |
| `annualDuesPaymentOnline` | PayMongo annual dues payment |
| `cashierNewTransaction` | New bundled transaction |
| `cashierNewTransactionCart` | View bundled cart |
| `cashierTransactionPay` | Pay bundled (cash) |
| `cashierTransactionPayCheque` | Pay bundled (cheque) |
| `cashierTransactionPayBankTransfer` | Pay bundled (bank transfer) |
| `cashierTransactionPaymentOnline` | Pay bundled (PayMongo) |
| `cashierReport` | Cashier reconciliation report |
| `cashierSyncEventPayment` | Sync event payments |
| `cashierSyncAnnualDues` | Sync annual dues |
| `exportExcel` | Excel export |

**Role checks:** `role_id != 4` at line 181 — only Cashiers can access cashier pay endpoint.

---

### CategoryController / TagController / ItemsController / RolesController / UserManagementController
> **Boilerplate Laravel example controllers.** All routes are commented out. Not used in production.

---

### CertificateController
| Method | Description |
|--------|-------------|
| `adminCertificateUpload` | Upload cert form |
| `adminListMember` | List members with certs |
| `uploadListMember` | Save cert upload |
| `adminSearch` | **Empty — no implementation** |
| `adminRemoveMember` | **Empty — no implementation** |
| `adminDownloadCertificate2` | Download cert by PRC number |

**⚠️ Half-built:** `adminSearch` and `adminRemoveMember` have no implementation.

---

### CPDPointsController
| Method | Description |
|--------|-------------|
| `index` | Admin CPD index |
| `view` | View member CPD by pps_no |
| `save` | Save CPD points |
| `viewMemberCPD` | Member self-view CPD |
| `viewEventCPD` | CPD per event |
| `adminViewMemberCPD` | Admin CPD overview |
| `adminSearchViewMemberCPD` | Admin CPD search |
| `adminViewMemberCPDDetails` | Admin CPD member detail |
| `adminSearchViewMemberCPDPoints` | Admin CPD points search |

---

### DashboardController
| Method | Description |
|--------|-------------|
| `index` | Dashboard — shows events, member status |
| `changeDefaultPassword` | Force default password change |

---

### DatabaseBackupController
| Method | Description |
|--------|-------------|
| `index` | List backups |
| `create` | Run pg_dump, upload to S3 |
| `download` | Generate signed S3 download URL |
| `restore` | Download from S3, run pg_restore |
| `delete` | Delete backup from S3 |

**Role checks:** `role_id !== 1` at line 187.

---

### DocumentsController
| Method | Description |
|--------|-------------|
| `documentsChooseMember` | Choose member for upload |
| `documentsUpload` | Upload form |
| `documentsUploadSubmit` | Save uploaded documents |
| `documentsDownload` | Download document |
| `documentsDelete` | Delete document |

---

### EventController
> Largest and most complex controller. ~4,700 lines. Handles events, topics, attendance, certificates, QR codes, livestreams.

Key method groups:
- **Certificate download:** `downloadCertificate`, `downloadCertificateWebinar`, `downloadCertificate2`, `downloadCertificateWebinar2`, `downloadEventIdentificationCard`
- **Event CRUD:** `eventList`, `eventView`, `eventCreate`, `eventSave`, `eventUpdate`, `eventUpdateSubmit`
- **Event images:** `eventImage`, `eventImage2`, `eventImageUpload`, `eventImageDelete`
- **Event join/pay:** `eventJoin`, `eventPay`, `eventPaymentFinal`, `eventPaymentOnline`, `successEventOnlinePayment`, `successEventPaymentMember`, `failedEventPaymentMember`
- **Event topic/attendance:** `eventTopic`, `eventTopicAttendance`, `eventTopicAttendNoneQuestion`, `eventTopicAttendWithQuestion`, `eventTopicProceedScore`
- **Event attendance print:** `eventChooseAttendance`, `eventAttendance`, `eventChoosePrintAttendance`, `eventPrintAttendance`
- **Speakers/plenary:** `eventTopicSpeakerA`, `eventTopicSpeakerB`, `eventTopicSpeakerC`, `eventTopicFinalizePlenary`
- **Livestream:** `eventFacebookLiveSave`, `eventYoutubeLiveSave`, `eventLivestream`, `eventLivestreamView`

**⚠️ Note:** A duplicate `successEventOnlinePayment` method exists — line 2063 has a commented-out version, active version is at line 2172.

---

### ICDController
> Hospital ICD-10 registry module. ~1,300 lines.

Handles admitted and neonatal patient registry uploads, views, exports, admin overviews, and month-by-month breakdowns for accredited hospitals (role_id 5).

---

### ImpersonateController
| Method | Description |
|--------|-------------|
| `take` | Start impersonating a member |
| `leave` | Stop impersonating |

**Role checks:** `role_id !== 1` at line 21 — only Admin can impersonate.

---

### IvsStreamController
| Method | Description |
|--------|-------------|
| `index` | List streams |
| `create` | Create form |
| `store` | Save stream |
| `edit` | Edit form |
| `update` | Update stream |
| `destroy` | Delete stream |
| `toggleStatus` | AJAX on/off toggle |
| `generateToken` | Member watch — generate signed URL |
| `player` | Signed URL player page |
| `generateEventToken` | Watch from event page |
| `linkToEvent` | Admin AJAX: link stream to event |

**Role checks:** `role_id !== 1` in 8 methods.

---

### LoginController
| Method | Description |
|--------|-------------|
| `applyMember` | Show member application form by type |

---

### MaintenanceController
| Method | Description |
|--------|-------------|
| `userMaintenance` | User listing |
| `userMaintenanceEdit` | Edit user form |
| `updateUser` | Save user update |
| `userResetPassword` | Reset user password |
| `emailMaintenance` | Email template management |
| `eventLivestreamMaintenance` | Manage livestream access list |
| `userMaintenanceNewHospital` | Create hospital user |
| `userMaintenanceNewAttendance` | Create attendance user |
| `sendBulkEmailAnnualConvention` | Send bulk email |
| `saveReclassification` | Save member reclassification |

---

### MemberInfoController
| Method | Description |
|--------|-------------|
| `saveApplicantMember` | Public member application submit |
| `applicantListing` | List pending applicants |
| `applicantProfile` | View applicant profile |
| `acceptApplicant` / `acceptApplicant2` | Approve applicant |
| `applicantDisapprove` | Disapprove applicant |
| `memberListing` | Member list |
| `memberInfo` | View member profile |
| `memberInfoUpdate` | Admin edit member |
| `memberInfoUpdateSubmit` | Save admin edit |
| `memberReclassification` | Reclassification list |
| `updateMemberNewInfoView` | Member self-update (new fields) |
| `updateMemberNewInfoSubmit` | Save self-update |

---

### PaymentController
| Method | Description |
|--------|-------------|
| `paymentList` | Payment listing |
| `paymentOnlineFinal` | Finalize online payment |
| `paymentOnline` | Initiate PayMongo payment |
| `successOrPayment` | Payment success callback |

**⚠️ Note:** A commented-out duplicate `paymentOnline` exists at line 75.

---

### PaymentGatewayController
| Method | Description |
|--------|-------------|
| `index` | Show gateway settings |
| `update` | Save gateway settings |

---

### RegisterController
| Method | Description |
|--------|-------------|
| `create` | Show registration form |
| `store` | Save registration |

---

### ReportsController
| Method | Description |
|--------|-------------|
| `viewReports` | Report listing |
| `chooseReport` | Choose report type |
| `memberListReport` | Member list report |
| `eventAttendanceListReport` | Event attendance report |
| `generateReport` | Generate and download report |
| `generateEventAttendanceReport` | Generate attendance report |

---

### SessionsController
| Method | Description |
|--------|-------------|
| `create` | Login form |
| `store` | Process login — **routes to dashboard based on `role_id` switch** |
| `resetEmail` | Password reset email form |
| `senEmailResetPassword` | Send reset email (note: typo in method name) |
| `resetPasswordForm` | Show reset form |
| `resetPasswordSubmit` | Submit new password |
| `show` | Verify |
| `update` | Update password |
| `destroy` | Logout |

---

### SpecialtyBoardController
| Method | Description |
|--------|-------------|
| `view` | Member specialty board view |
| `updateProfile` | Member update |
| `updateSubmit` | Save update |
| `paymentDetails` | Payment details |
| `specialtyBoardPaymentOnline` | PayMongo payment |
| `successSpecialtyBoardOnlinePayment` | Success callback |
| `adminView` | Admin view |
| `adminExport` | Export |
| `adminGenerateExportReport` | Generate export |

---

### VotingController
> Complex voting module. Handles Board of Trustees (BOT), Chapter Representatives, and custom candidates. ~1,100 lines.

| Method | Description |
|--------|-------------|
| `votingListing` | List elections |
| `votingCreate` | Create election form |
| `votingSave` | Save election |
| `votingElect` | Member voting page |
| `votingElectionFinal` | Election finalization |
| `votingSelectCandidate` | Cast vote |
| `votingFinalize` | **Commented out in routes** |
| `votingDetails` | Election details |
| `votingResult` | View results |
| `votingUpdateStatus` | Change election status |

---

### WebHookController
| Method | Description |
|--------|-------------|
| `paymentWebhook` | Active PayMongo webhook handler |

**⚠️ Note:** Two older webhook methods (`annualDuesWebhook`, `eventPaymentWebhook`) are commented out.

---

## 3. MODELS

| Model | Table | Relationships / Notes |
|-------|-------|-----------------------|
| `Announcement` | `announcements` (inferred) | `creator()`, `archiver()` (BelongsTo User); scopes: `active`, `forAudience`, `public` |
| `AnnualDues` | `tbl_annual_dues` | None defined |
| `AnnualDuesCart` | `tbl_annual_dues_cart` | None defined |
| `Audit` | `audits` | `user()` relationship |
| `BackupLog` | `backup_logs` | `user()` BelongsTo |
| `CPDPoints` | `tbl_cpd_points` | None defined |
| `CPDPointsMaintenance` | `tbl_cpd_points_maintenance` | None defined |
| `Candidate` | `tbl_candidate` | None defined |
| `Category` | `categories` (inferred) | `item()` HasMany |
| `CertificateMaintenance` | `tbl_certificate_maintenance` | None defined |
| `Chapter` | `tbl_chapter` | None defined |
| `ChecklistDocuments` | `tbl_checklist_documents` | None defined |
| `ChecklistMaintenance` | `tbl_checklist_maintenance` | None defined |
| `ClassificationVIP` | `tbl_member_classification_vip` | None defined |
| `Event` | `tbl_event` | `ivsStream()` BelongsTo |
| `EventAttend` | `tbl_event_attend` | None defined |
| `EventCart` | `tbl_event_cart` | None defined |
| `EventCategory` | `tbl_event_category` | None defined |
| `EventCommittee` | `tbl_event_committee_list` | None defined |
| `EventCommitteeGroup` | `tbl_event_committee_group` | None defined |
| `EventImage` | `tbl_event_image` | None defined |
| `EventOrganizer` | `tbl_event_organizer_list` | None defined |
| `EventOrganizerType` | `tbl_event_organizer_type` | None defined |
| `EventPlenary` | `tbl_event_plenary` | None defined |
| `EventPrice` | `tbl_event_price` | None defined |
| `EventSelected` | `tbl_event_selected` | None defined |
| `EventTopic` | `tbl_event_topic` | None defined |
| `EventTransaction` | `tbl_event_transaction` | None defined |
| `HospitalAccredited` | `tbl_hospital_accredited` | None defined |
| `ICD10` | `tbl_icd10` | None defined |
| `ICD10Temp` | `tbl_icd10_temp` | None defined |
| `Item` | `items` (inferred) | `category()` BelongsTo, `tag()` BelongsToMany |
| `IvsStream` | `ivs_streams` | `isLive()`, `isComingSoon()`, `canUserWatch()` methods; accesses `tbl_member_info` via raw `DB::table` |
| `Login` | `users` | Duplicate of User model pointing to same table |
| `MaintenanceEmail` | `tbl_pps_email` | None defined |
| `MemberAcademicDegree` | `tbl_member_academic_degree` | None defined |
| `MemberInfo` | `tbl_member_info` | `age()` helper |
| `MemberInstitution` | `tbl_member_institution` | None defined |
| `MemberReclassification` | `tbl_member_reclassification` | None defined |
| `MemberResearch` | `tbl_member_research_works` | None defined |
| `MemberSchool` | `tbl_member_school` | None defined |
| `MemberSubspecialty` | `tbl_member_subspecialty_training` | None defined |
| `MemberTeachingExperience` | `tbl_member_teaching_experience` | None defined |
| `MemberTraining` | `tbl_member_training` | None defined |
| `MemberType` | `tbl_member_type` | None defined |
| `Nationality` | `tbl_nationality` | None defined |
| `ORMaster` | `tbl_or_master` | None defined |
| `PaymentGatewaySetting` | (inferred `payment_gateway_settings`) | No relationships |
| `PriceList` | `tbl_price_list` | None defined |
| `RegistryAdmitted` | `tbl_registry_admitted` | `age()` helper |
| `RegistryHeader` | `tbl_registry_header` | None defined |
| `RegistryNeonatal` | `tbl_registry_neonatal` | None defined |
| `RegistryPatientType` | `tbl_registry_patient_type` | None defined |
| `Reports` | `tbl_reports` | None defined |
| `ReportsMemberList` | `tbl_reports_member_list` | None defined |
| `Role` | `roles` (inferred) | `user()` HasMany |
| `SpecialtyBoard` | `tbl_specialty_board` | None defined |
| `SyncAnnualDues` | `tbl_sync_annual_dues` | None defined |
| `Tag` | `tags` (inferred) | `item()` BelongsToMany |
| `TestWebhook` | `test_webhook` | None defined |
| `TopicAttendTemp` | `tbl_topic_attend_temp` | None defined |
| `TopicQuestion` | `tbl_topic_question` | None defined |
| `TopicQuestionChoices` | `tbl_topic_question_choices` | None defined |
| `TransactionCart` | `tbl_transaction_cart` | None defined |
| `User` | `users` | `role()` BelongsTo Role; helpers: `isAdmin()`, `isMember()`, `isCashier()`, `isHospital()`, `isAttendance()`, `isCreator()` — all backed by hardcoded `role_id` comparisons |
| `Voting` | `tbl_voting` | None defined |
| `VotingPosition` | `tbl_voting_position` | None defined |
| `VotingSelected` | `tbl_voting_selected` | None defined |
| `VotingTransaction` | `tbl_voting_transaction` | None defined |

> ⚠️ **`Login` model** points to the `users` table — a duplicate of `User`. Should be removed.  
> ⚠️ **Most models have no defined Eloquent relationships** — queries are done with joins in controllers instead.

---

## 4. BLADE VIEWS

### annual-dues/
- `create-annual-dues.blade.php` — Create annual dues entry form
- `listing-annual-dues.blade.php` — Annual dues listing

### announcements/
- `admin-listing.blade.php` — Admin announcement management

### applicants/
- `listing.blade.php` — Applicant listing for admin
- `profile2.blade.php` — Applicant profile view
- `email-template.blade.php` — Email template (applicant)
- `email-template-accept.blade.php` — Accept email template
- `email-template-disapprove.blade.php` — Disapprove email template
- `test-email.blade.php` — Test email view

### authentication/ (unused boilerplate)
- `sign-in/` basic, cover, illustration variants
- `sign-up/` basic, cover, illustration variants
- `reset/` basic, cover, illustration, new-password, reset-password-email-template
- `lock/` basic, cover, illustration
- `verification/` basic, cover, illustration

### cashier/
- `cashier-annual-dues-transaction.blade.php` — Annual dues payment transaction
- `cashier-event-transaction.blade.php` — Event payment transaction
- `cashier-new-transaction-cart.blade.php` — Bundled transaction cart
- `test-datatable.blade.php` — Test/dev page

### components/
- `auth/navbars/navs/auth.blade.php` — Top navigation bar
- `auth/navbars/navs/guest.blade.php` — Guest nav
- `auth/navbars/sidebar.blade.php` — Main sidebar navigation
- `auth/footers/` — Footer components
- `page-template.blade.php` — Main authenticated page wrapper
- `plugins.blade.php` — JS/CSS plugin loader

### cpd-points/
- `index.blade.php` — CPD points admin index
- `view.blade.php` — Member CPD points view
- `view-event-cpd.blade.php` — CPD per event

### dashboard/
- `index.blade.php` — Main dashboard
- `automotive.blade.php`, `discover.blade.php`, `sales.blade.php`, `smart-home.blade.php` — **Unused boilerplate dashboards**

### documents/
- `search-member.blade.php` — Choose member for document upload
- `upload.blade.php` — Document upload form

### errors/
- `401.blade.php`, `403.blade.php`, `404.blade.php`, `419.blade.php`, `429.blade.php`, `500.blade.php`, `503.blade.php`, `payment-hold.blade.php`

### events/
- `listing.blade.php` — Event listing
- `view.blade.php` — Event detail page (member/admin)
- `update.blade.php` — Admin event edit
- `attendance-print-choose.blade.php` — Choose event for attendance print
- `choose-attendance.blade.php` — Attendance dashboard
- `online-video-view.blade.php` — Online video viewer
- `pay.blade.php` — Event payment
- `topic-login.blade.php` — Topic attendance login
- `topic-question-answer.blade.php` — Topic Q&A
- `topic-question-answer-plenary.blade.php` — Plenary Q&A
- `online-topic-question-answer.blade.php` — Online topic Q&A

### icd-hospital/
- `admitted-view.blade.php`, `admitted-details.blade.php`, `admitted-view-month.blade.php`
- `neonatal-view.blade.php`, `neonatal-details.blade.php`, `neonatal-view-month.blade.php`, `neonatal-view-patient.blade.php`
- `admin-admitted-details.blade.php`, `admin-neonatal-details.blade.php`, `admin-new-code.blade.php`

### ivs/
- `player.blade.php` — IVS stream player (fullscreen, signed URL)

### laravel-examples/ (boilerplate — not used in production)
- category, items, roles, tag, user-profile, users CRUD views

### maintenance/
- `user-maintenance.blade.php` — User management
- `user-maintenance-edit.blade.php` — Edit user
- `email-maintenance.blade.php` — Email template management
- `email-annual-convention-bulk-template.blade.php` — Bulk email template
- `user-email-maintenance.blade.php` — User email management
- `database-backup.blade.php` — Database backup/restore UI
- `ivs/index.blade.php`, `ivs/form.blade.php` — IVS stream admin

### members/
- `listing.blade.php` — Member directory
- `member-info.blade.php` — Member profile (admin view)
- `member-update.blade.php` — Admin member edit
- `member-new-update-profile.blade.php` — Member self-update

### pages/ (boilerplate — not in use)
- `account/billing.blade.php`, `account/invoice.blade.php`, `account/security.blade.php`

### register/
- `reg.blade.php` — Member application/registration form
- `create.blade.php` — Legacy registration (boilerplate)

### reports/
- `view.blade.php` — Reports viewer

### voting/
- `listing.blade.php` — Election listing
- `details.blade.php` — Election detail and voting interface

---

## 5. HARDCODED ROLE_ID CHECKS

> **Critical:** All of these must be replaced with Spatie `hasRole()` / `can()` checks during Phase 1.

| File | Line | Code |
|------|------|------|
| `app/Http/Controllers/CashierController.php` | 181 | `if(auth()->user()->role_id != 4)` |
| `app/Http/Controllers/DatabaseBackupController.php` | 187 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/ImpersonateController.php` | 21 | `if ($admin->role_id !== 1)` |
| `app/Http/Controllers/IvsStreamController.php` | 19 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/IvsStreamController.php` | 31 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/IvsStreamController.php` | 45 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/IvsStreamController.php` | 85 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/IvsStreamController.php` | 99 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/IvsStreamController.php` | 137 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/IvsStreamController.php` | 150 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/IvsStreamController.php` | 279 | `if (auth()->user()->role_id !== 1)` |
| `app/Http/Controllers/MaintenanceController.php` | 480 | `$hospital_user->role_id = 5` |
| `app/Http/Controllers/MaintenanceController.php` | 516 | `$attendance_user->role_id = 6` |
| `app/Http/Controllers/MemberInfoController.php` | 338 | `$applicant->role_id = 3` |
| `app/Http/Controllers/MemberInfoController.php` | 407 | `$temporary->role_id = 3` |
| `app/Http/Controllers/SessionsController.php` | 173 | `switch (auth()->user()->role_id)` — login redirect |
| `app/Models/IvsStream.php` | 82 | `if ($user->role_id === 1 && $this->allow_admin)` |
| `app/Models/User.php` | 60 | `return $this->role_id == 1` (isAdmin) |
| `app/Models/User.php` | 68 | `return $this->role_id == 2` (isCreator) |
| `app/Models/User.php` | 76 | `return $this->role_id == 3` (isMember) |
| `app/Models/User.php` | 85 | `return $this->role_id == 4` (isCashier) |
| `app/Models/User.php` | 90 | `return $this->role_id == 5` (isHospital) |
| `app/Models/User.php` | 95 | `return $this->role_id == 6` (isAttendance) |
| `resources/views/components/auth/navbars/sidebar.blade.php` | 32, 48, 70, 97, 139, 160, 188, 196, 224, 245, 262, 271, 280, 295, 324, 335, 346, 386, 411, 428, 442, 507, 532, 561, 590, 615 | Multiple `role_id ==` checks throughout |
| `resources/views/dashboard/index.blade.php` | 35, 155, 243 | `role_id ==` checks |
| `resources/views/events/listing.blade.php` | 77, 117 | `role_id ==` checks |
| `resources/views/events/update.blade.php` | 24 | `role_id` hidden input |
| `resources/views/events/view.blade.php` | 15 | `role_id` hidden input |
| `resources/views/voting/details.blade.php` | 404, 414, 485 | `role_id ==` checks |
| `resources/views/voting/listing.blade.php` | 71, 91 | `role_id ==` checks |
| `resources/views/announcements/admin-listing.blade.php` | 21, 179 | `role_id ==` checks |
| `resources/views/maintenance/user-maintenance.blade.php` | 167, 174 | `role_id ==` checks |

**Total hardcoded role_id references: ~60+**

---

## 6. RAW DATABASE QUERIES (DB::)

> All `DB::raw()` calls are acceptable for computed subquery columns in SELECT. The higher-risk items are `DB::table()` inserts and the stored procedure call.

### High Priority (DB::table inserts — should use Eloquent models)

| File | Line | Usage |
|------|------|-------|
| `app/Http/Controllers/AnnualDuesController.php` | 37 | `DB::select('CALL insert_annual_dues(...)')` — **stored procedure call** |
| `app/Http/Controllers/CashierController.php` | 1641, 1670 | `DB::table('tbl_event_transaction')->insert()` |
| `app/Http/Controllers/CashierController.php` | 1783, 1813 | `DB::table('tbl_event_transaction')->insert()` |
| `app/Http/Controllers/CashierController.php` | 1937, 1971 | `DB::table('tbl_event_transaction')->insert()` |
| `app/Http/Controllers/CashierController.php` | 2097, 2133 | `DB::table('tbl_event_transaction')->insert()` |
| `app/Http/Controllers/CashierController.php` | 526 | `\DB::table('tbl_member_info')->select('*')` |
| `app/Http/Controllers/EventController.php` | 3257, 3391, 3838 | `DB::table('tbl_event_plenary')->insert()` |
| `app/Http/Controllers/EventController.php` | 3987, 4136 | `DB::table('tbl_event_plenary')->insert()` |
| `app/Models/IvsStream.php` | 86 | `\DB::table('tbl_member_info')` |

### Lower Priority (DB::raw in SELECT subqueries — acceptable but verbose)

| File | Lines |
|------|-------|
| `CashierController.php` | 108, 145, 1203, 1212, 1371, 1382 |
| `CPDPointsController.php` | 20, 27, 36, 136, 285, 360 |
| `DashboardController.php` | 57, 58, 60 |
| `DocumentsController.php` | 45 |
| `EventController.php` | 513, 521, 527, 581, 643, 644, 645, 661, 662, 1405, 1420, 1913, 4250, 4266, 4659, 4660, 4661, 4681, 4682, 4704, 4705 |
| `ICDController.php` | 46, 74, 204, 230, 378, 424, 498, 546, 756, 789, 796, 817, 863, 914, 981, 1003, 1010, 1033, 1063, 1078, 1115, 1139, 1154, 1274 |
| `MemberInfoController.php` | 498 |
| `VotingController.php` | 33, 34, 897, 915, 931, 978, 996 |

---

## 7. COMPOSER PACKAGES

### Production (`require`)

| Package | Version | Status |
|---------|---------|--------|
| `php` | ^7.3\|^8.0 | ⚠️ Allows PHP 7.3 — should be locked to ^8.1 minimum |
| `laravel/framework` | ^9.0 | ⚠️ Laravel 9 — EOL. Upgrade path: 9→10→11 |
| `laravel/sanctum` | ^2.15 | ⚠️ Old — current is ^3.x for Laravel 10+ |
| `amrshawky/laravel-currency` | ^6.0 | ⚠️ Abandoned — low maintenance |
| `ashallendesign/laravel-exchange-rates` | ^7.1 | ✅ Active |
| `barryvdh/laravel-dompdf` | ^3.0 | ✅ Active |
| `endroid/qr-code` | ^5.0 | ✅ Active |
| `fruitcake/laravel-cors` | ^2.0 | ⚠️ Deprecated — CORS is built into Laravel 9+ |
| `guzzlehttp/guzzle` | ^7.8 | ✅ Active |
| `intervention/image` | ^3.10 | ✅ Active |
| `intervention/image-laravel` | ^1.3 | ✅ Active |
| `ixudra/curl` | ^6.22 | ⚠️ Low maintenance — Guzzle already included |
| `league/flysystem-aws-s3-v3` | 3.0 | ⚠️ Pinned to exact version — should be ^3.0 |
| `luigel/laravel-paymongo` | ^2.4 | ⚠️ Low maintenance |
| `maatwebsite/excel` | ^3.1 | ✅ Active |
| `mavinoo/laravel-batch` | ^2.3 | ⚠️ Low maintenance |
| `owen-it/laravel-auditing` | ^13.5 | ✅ Active |
| `predis/predis` | ^2.0 | ✅ Active |
| `simplesoftwareio/simple-qrcode` | ^4.2 | ✅ Active |
| `yajra/laravel-address` | ^0.7 | ⚠️ Very low version — limited maintenance |
| `yajra/laravel-datatables-oracle` | ^10.11 | ✅ Active |

### Development (`require-dev`)

| Package | Version | Status |
|---------|---------|--------|
| `spatie/laravel-ignition` | ^1.0 | ⚠️ Old — current is ^2.x |
| `fakerphp/faker` | ^1.17 | ✅ Active |
| `laravel/sail` | ^1.12 | ✅ Active |
| `mockery/mockery` | ^1.4.2 | ✅ Active |
| `nunomaduro/collision` | ^6.1 | ✅ Active |
| `phpunit/phpunit` | ^9.5.10 | ⚠️ Old — current stable is ^11.x |

**Missing packages needed for rebuild:**
- `spatie/laravel-permission` — for Spatie roles/permissions (Phase 1 requirement)
- `lab404/laravel-impersonate` — already used in code but not in composer.json (installed separately?)

---

## 8. DATABASE MIGRATIONS

Listed in chronological order:

| # | Migration File | Description |
|---|---------------|-------------|
| 1 | `2014_10_12_000000_create_roles_table.php` | Roles table |
| 2 | `2014_10_12_100000_create_password_resets_table.php` | Password resets |
| 3 | `2018_01_01_100000_create_ph_address_tables.php` | Philippine address tables |
| 4 | `2019_08_19_000000_create_failed_jobs_table.php` | Queue failed jobs |
| 5 | `2019_12_14_000001_create_personal_access_tokens_table.php` | Sanctum tokens |
| 6 | `2021_11_16_083132_create_users_table.php` | Users table |
| 7 | `2021_11_17_113752_create_categories_table.php` | Categories (boilerplate) |
| 8 | `2021_11_17_115150_create_tags_table.php` | Tags (boilerplate) |
| 9 | `2021_11_18_073007_create_items_table.php` | Items (boilerplate) |
| 10 | `2021_11_18_085437_create_item_tag_table.php` | Item-tag pivot (boilerplate) |
| 11 | `2023_10_11_134338_create_audits_table.php` | OwenIt audit trails |
| 12 | `2023_12_04_040235_create_jobs_table.php` | Queue jobs |
| 13 | `2026_03_29_000001_create_sessions_table.php` | Laravel sessions table |
| 14 | `2026_03_30_000001_create_payment_gateway_settings_table.php` | Payment gateway config |
| 15 | `2026_03_31_000002_create_backup_logs_table.php` | DB backup log |
| 16 | `2026_04_01_000001_create_announcements_table.php` | Announcements |
| 17 | `2026_04_01_000001_add_professional_fields_to_member_info.php` | Professional fields on member |
| 18 | `2026_04_01_100000_add_induction_date_to_member_info.php` | Induction date on member |
| 19 | `2026_04_05_000000_create_ivs_streams_table.php` | IVS streams |
| 20 | `2026_04_05_000001_add_ivs_stream_id_to_tbl_event.php` | IVS stream FK on events |

> ⚠️ **Note:** Migrations 16 and 17 share the same timestamp `2026_04_01_000001_` — this can cause ordering conflicts. One should be renamed.  
> ⚠️ **Note:** The core member portal tables (`tbl_member_info`, `tbl_event`, `tbl_chapter`, all `tbl_*` tables) have **no migrations** — they were created directly on the database outside of Laravel's migration system. This makes the schema non-reproducible from migrations alone.

---

## 9. HALF-BUILT / INCOMPLETE FEATURES

| Feature | Location | Issue |
|---------|----------|-------|
| `GET /clear-all` | `routes/web.php:44` | No auth guard — anyone can flush and rebuild all caches |
| `CertificateController@adminSearch` | `CertificateController.php:24` | Empty method body — no implementation |
| `CertificateController@adminRemoveMember` | `CertificateController.php:29` | Empty method body — no implementation |
| Voting finalize | `VotingController@votingFinalize`, `routes/web.php:191` | Route is commented out — finalize voting is non-functional |
| `EventController` duplicate `successEventOnlinePayment` | `EventController.php:2063` | Old version commented out — unclear which is correct |
| `PaymentController` duplicate `paymentOnline` | `PaymentController.php:75` | Old version commented out |
| `WebHookController` old webhooks | `api.php:22-23` | Two webhook routes commented out — may break older integrations |
| Annual dues stored procedure | `AnnualDuesController.php:37` | Uses `DB::select('CALL insert_annual_dues(...)')` — stored procedure dependency, not portable |
| Boilerplate routes (100+ lines) | `routes/web.php:650-860` | Massive block of commented-out example routes still in codebase |
| Boilerplate controllers/views | `CategoryController`, `TagController`, `ItemsController`, `RolesController`, `UserManagementController`, `laravel-examples/` views | All unused — left from original Laravel scaffold |
| `Login` model | `app/Models/Login.php` | Duplicate model pointing to `users` table — same as `User` model |
| Missing migrations for core tables | `database/migrations/` | All `tbl_*` tables have no migrations — schema not tracked in Git |
| `TestWebhook` model | `app/Models/TestWebhook.php` | Dev/test artifact — should be removed |
| `applicants/test-email.blade.php` | `resources/views/applicants/` | Test view — should not be in production |
| `cashier/test-datatable.blade.php` | `resources/views/cashier/` | Test view — should not be in production |
| Duplicate timestamp migrations | `2026_04_01_000001_*` (two files) | Will cause migration ordering issues |
| `typo: senEmailResetPassword` | `SessionsController.php` | Method name typo — `senEmail` instead of `sendEmail` |
| `failedOrPayment` route | `routes/web.php:479` | References `EventController@failedOrPayment` but method is not listed in controller |
| `lab404/laravel-impersonate` | `composer.json` | Used in code and working, but not in `composer.json` — installed via other means? |

---

## 10. OVERALL SUMMARY

### What This System Does

The PPS Member Portal is a full-featured membership management system for the Philippine Pediatric Society (~9,000 members). It handles:

- **Member registration and applications** — public application forms, admin approval workflow
- **Member profiles and directory** — admin and self-service profile management
- **Events** — creation, registration, attendance tracking, QR codes, CPD points, certificates
- **Payments** — PayMongo integration for event fees and annual dues; cashier manual payment flow (cash, cheque, bank transfer)
- **Voting** — annual convention elections (BOT, Chapter Representatives, custom positions)
- **IVS Livestreaming** — Amazon IVS integration for live events with access control
- **ICD Hospital Registry** — admitted and neonatal patient registry for accredited hospitals
- **Specialty Board** — member specialty board applications and payment
- **Reports and Audit Trails** — OwenIt-based audit logging, report generation
- **Admin Maintenance** — user management, email maintenance, database backup/restore

### How It Was Built

The project started as a standard Laravel 9 scaffold (with boilerplate example CRUD controllers and views still present and unused). The real application was built organically on top — controllers grew very large (EventController is ~4,700 lines), the database uses a `tbl_` prefix naming convention, and the schema was built directly on PostgreSQL rather than through Laravel migrations. Role-based access is implemented entirely through hardcoded `role_id` integer comparisons rather than a permissions framework.

### Main Problems Found

1. **🔴 No route-level authorization** — All role checks are inline in controller methods. No middleware gates, no Spatie permissions. A logged-in user of any role can reach any route URL.

2. **🔴 60+ hardcoded `role_id` checks** — Scattered across controllers, models, and Blade views. Changing any role requires a codebase-wide search-and-replace.

3. **🔴 `GET /clear-all` is publicly accessible** — Any anonymous user can flush and rebuild all Laravel caches.

4. **🔴 Core schema not in migrations** — All `tbl_*` tables were created directly on the database. The schema cannot be reproduced from `php artisan migrate` alone.

5. **🟡 EventController is 4,700+ lines** — A single file handles certificates, attendance, topics, payments, images, QR codes, livestreams. Violates single-responsibility. Very hard to maintain or test.

6. **🟡 CashierController is 2,400+ lines** — Same problem. Payment processing logic is repeated across 4 payment methods (cash, cheque, bank transfer, online) with duplicated code blocks.

7. **🟡 Extensive `DB::raw` and `DB::table` usage** — Most subqueries use raw SQL. `DB::table()->insert()` is used instead of Eloquent models. One stored procedure (`CALL insert_annual_dues`) creates a hard dependency on the database.

8. **🟡 Large amounts of boilerplate left in codebase** — Unused example controllers (Category, Tag, Item, Roles, UserManagement), unused Blade views (`laravel-examples/`, multiple `authentication/` variants), unused routes (100+ commented-out lines), and test views (`test-datatable`, `test-email`).

9. **🟡 Laravel 9 (EOL)** — No upgrade path implemented. `fruitcake/laravel-cors` is deprecated (CORS is built-in from Laravel 9+). `amrshawky/laravel-currency` and `mavinoo/laravel-batch` are abandoned.

10. **🟠 No test coverage** — No feature tests or unit tests exist. The boilerplate `phpunit.xml` is present but no test files were written for any application feature.

11. **🟠 Duplicate migration timestamps** — Two migration files share `2026_04_01_000001_` prefix which can cause ordering conflicts.

12. **🟠 `Login` model duplicates `User` model** — Both point to the `users` table.

13. **🟠 Missing Eloquent relationships** — Most models have no defined relationships. Controllers use manual joins instead, which bypasses Eloquent's lazy/eager loading and makes N+1 problems invisible.

### Recommended Priority of Fixes

| Priority | Fix |
|----------|-----|
| 🔴 1 | Add auth middleware to `GET /clear-all` or remove it |
| 🔴 2 | Install Spatie Laravel Permission and replace all `role_id` checks (Phase 1) |
| 🔴 3 | Write migrations for all `tbl_*` tables so the schema is reproducible |
| 🔴 4 | Fix the syntax error in `EventController.php` line ~2050 (B1) |
| 🟡 5 | Run `composer audit` and update vulnerable packages (B2) |
| 🟡 6 | Break up `EventController` and `CashierController` into service classes |
| 🟡 7 | Replace `DB::table()->insert()` calls with Eloquent model usage |
| 🟡 8 | Remove all boilerplate (example controllers, views, commented-out routes) |
| 🟠 9 | Add Eloquent relationships to models; remove manual joins |
| 🟠 10 | Remove `Login` model duplicate, `TestWebhook` model, and test views |
| 🟠 11 | Rename duplicate `2026_04_01_000001_` migration file |
| 🟠 12 | Remove/replace deprecated packages (`fruitcake/laravel-cors`, `amrshawky/laravel-currency`) |
| 🟢 13 | Upgrade Laravel 9 → 10 → 11 (after foundation is stable) |

---

*Audit generated: 2026-04-05*  
*Next step: P0-T1 complete — proceed to P0-T2 (map all role_id checks) or jump to Phase 1 (Spatie)*
