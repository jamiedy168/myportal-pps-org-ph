# Changelog

All notable changes to the **PPS Member Portal** are documented here.

Format follows [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).  
Versioning follows [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

> **Version scheme**  
> `MAJOR.MINOR.PATCH`  
> - MAJOR — breaking change or major architectural shift  
> - MINOR — new feature added in a backwards-compatible manner  
> - PATCH — backwards-compatible bug fix  

---

## [PR 11 + PR 12 — IVS Stream Manager] - 2026-04-05
### Summary
Full IVS (Amazon Interactive Video Service) livestream module built from scratch.
Allows admins to configure multiple live streams and control who can watch.
Members see live stream links in the sidebar and on event pages.

### New Files Created
- database/migrations/..._create_ivs_streams_table.php
- database/migrations/..._add_ivs_stream_id_to_tbl_event.php
- app/Models/IvsStream.php
- app/Http/Controllers/IvsStreamController.php
- resources/views/maintenance/ivs/index.blade.php
- resources/views/maintenance/ivs/form.blade.php
- resources/views/ivs/player.blade.php

### Files Modified
- app/Models/Event.php — added ivs_stream_id to $fillable, added ivsStream() BelongsTo relationship
- app/Http/Controllers/EventController.php — added ->with('ivsStream') to eventView() and eventUpdate() queries, added $ivsStreams to eventUpdate() compact()
- app/Http/Controllers/IvsStreamController.php — added all CRUD methods
- resources/views/components/auth/navbars/sidebar.blade.php — added IVS Stream Manager link under Maintenance
- resources/views/events/update.blade.php — added IVS stream dropdown and AJAX save button
- resources/views/events/view.blade.php — added Watch Live / Coming Soon button
- routes/web.php — registered all 11 IVS routes

### Database Changes
- New table: ivs_streams (id, name, button_label, ivs_url, status, starts_at,
  ends_at, allowed_types JSON, allow_vip, allow_all_members, allow_admin,
  created_by, updated_by, timestamps)
- New column: tbl_event.ivs_stream_id (nullable bigint FK to ivs_streams.id)

### Features
- Admin: IVS Stream Manager under Maintenance sidebar
- Admin: Create, edit, delete IVS streams with name, custom button label, IVS URL
- Admin: Manual ON/OFF toggle per stream (instant AJAX, no page reload)
- Admin: Scheduled auto on/off using starts_at and ends_at (Asia/Manila timezone)
- Admin: Per-stream access control: Admin, All Members, VIP, or specific
  member types (Diplomate, Fellow, Emeritus Fellow, Allied Health,
  Resident/Trainees, Government Physician, Fellows-in-Training, Active Member)
- Admin: Link any IVS stream to any event via dropdown on event edit page
- Member sidebar: Shows live streams as clickable Watch Now links (red dot)
- Member sidebar: Shows coming soon streams as disabled badges
- Member sidebar: Only shows streams the member is allowed to watch
- Member event page: Watch Live button (red) next to Back button when stream is live
- Member event page: Coming Soon button (disabled, yellow) when stream is scheduled
- Member event page: No button when stream is off or not linked to event
- Player: Standalone fullscreen page, no portal layout
- Player: 12-hour signed URL token — stateless, zero DB lookup, safe for
  9000 concurrent viewers
- Player: IVS URL obfuscated via base64_encode in Blade / atob() in JavaScript
- Player: Right-click disabled, DevTools keyboard shortcuts blocked
- Player: Live badge, stream name, watermark
- Security: All access checks in generateToken() and generateEventToken()
  before signed URL is issued — player page requires no auth middleware
- Audit: Laravel Log entry written on every access grant

### Fixed (during implementation)
- Created missing app/Models/IvsStream.php (never generated in first pass)
- Restored full $fillable array in Event.php after Codex incorrectly replaced
  entire array with only ['ivs_stream_id']
- Added all missing IvsStreamController methods (index, create, store, edit,
  update, destroy, toggleStatus, generateToken, memberTypeOptions)
- Fixed player() method to validate signed URL and check isLive() before rendering
- Created all missing migration files (ivs_streams table and ivs_stream_id column)
- Registered all 11 missing IVS routes in routes/web.php
- Created missing Blade views: index.blade.php, form.blade.php, player.blade.php
- Removed incorrect activity() calls (spatie/laravel-activitylog not installed)
- Fixed route order: ivs/event/{event}/watch placed before ivs/{ivsStream}/watch

### Routes Registered
- GET    admin/ivs                       admin.ivs.index
- GET    admin/ivs/create                admin.ivs.create
- POST   admin/ivs                       admin.ivs.store
- GET    admin/ivs/{ivsStream}/edit      admin.ivs.edit
- PUT    admin/ivs/{ivsStream}           admin.ivs.update
- DELETE admin/ivs/{ivsStream}           admin.ivs.destroy
- POST   admin/ivs/{ivsStream}/toggle    admin.ivs.toggle
- POST   admin/ivs/link-event            admin.ivs.link-event
- GET    ivs/event/{event}/watch         ivs.event.watch
- GET    ivs/{ivsStream}/watch           ivs.watch
- GET    ivs/{ivsStream}/player          ivs.player (signed middleware only)

---

## [Unreleased]
> Changes staged but not yet deployed to production.

### Added
- Committed 38 previously untracked programmer files to Git for backup: new controllers (Announcement, Certificate, DatabaseBackup, Impersonate, IvsStream), models (Announcement, BackupLog, IvsStream), exports (CPDPoints, ElectionResults), migrations (6 files), Blade views (announcements, IVS player, database backup, IVS maintenance, pagination), config (professional.php), and platform/nginx configs.

### Security
- `.gitignore` — added `.env.example` so it can never be accidentally committed again.
- `.env.example` — fully rewritten with generic placeholders only (`your-aws-key-here`, etc.). No real values, org names, endpoints, or credentials.
- `routes/web.php` — `GET /clear-all` route now protected with `auth` middleware and Admin-only (`role_id === 1`) check. Previously open to the public internet with no authentication. TODO P1: convert to Spatie `hasRole('Admin')`.
- `.gitignore` updated to explicitly block `*.zip`, `/storage/logs`, `.DS_Store`, `Thumbs.db`, and `.env.*.backup` from ever being committed. `.env` and `.env.backup` entries consolidated and confirmed present.
- `.ebextensions/env.config` — replaced `APP_KEY` and `DB_PASSWORD` with `REPLACED_SEE_AWS_CONSOLE` placeholders. Real values must be set in the AWS Elastic Beanstalk console environment variables, never in committed files.
- `.env` confirmed not tracked by git.

### Fixed
- `resources/views/events/view.blade.php` (+15 lines / -11 lines)
  Event view crashed for admin users without `tbl_member_info` because the page
  dereferenced `$member` properties unguarded. Price block is now null-safe,
  member-only actions are hidden when `$member` is null, and price rendering
  falls back to `number_format($event->prices ?? 0, 2)`.
- `config/database.php` (+28 lines / -12 lines)
  Replaced entire Redis connection block to support AWS ElastiCache Valkey 8.1
  Serverless at myportal-pps-org-ph-cd5oow.serverless.use1.cache.amazonaws.com.
  Added missing `scheme => env('REDIS_SCHEME', 'tls')` to all four connection
  blocks (default, cache, session, queue) — without this, TLS connections fail
  silently and Laravel falls back to 127.0.0.1.
  Added missing `queue` connection block so REDIS_QUEUE_DB=3 is honoured.
  Moved prefix to per-connection level to avoid double-prefixing with phpredis.
  Removed null password workaround — REDIS_PASSWORD must be completely unset
  in EB Console for ElastiCache Valkey (no password auth, security group only).

### Added
- `.platform/hooks/prebuild/00_install_redis.sh` (+15 lines)
  New prebuild hook. Verifies phpredis extension is loaded on every EB
  deployment on Amazon Linux 2023. Prevents silent Valkey connection failures
  if extension is missing after an instance refresh or environment rebuild.

- `.platform/hooks/postdeploy/01_queue_worker.sh` (+14 lines)
  New postdeploy hook. Restarts Laravel queue workers after every deployment
  so workers pick up new application code without manual intervention.
  Queue uses Redis DB 3 (REDIS_QUEUE_DB=3), prefix pps_portal_.

- `.platform/hooks/postdeploy/02_fpm_tune.sh` (+16 lines)
  New postdeploy hook. Clears and rebuilds Laravel config, route, and view
  cache after every deployment. Eliminates stale config cache that was causing
  REDIS_HOST to show 127.0.0.1 instead of the real Valkey endpoint even after
  EB environment variables were correctly set.

### Changed
- `.env.example` (+18 lines / -5 lines)
  Updated Redis/Valkey section with real production endpoint, all DB index
  variables, and clear comments explaining REDIS_PASSWORD must be left
  completely unset in EB Console for ElastiCache Valkey authentication.

---

## [PR 12] - 2026-04-05
### Added
- ivs_stream_id nullable column added to tbl_event (FK reference to ivs_streams.id)
- ivsStream() BelongsTo relationship added to Event model
- IvsStreamController::generateEventToken() — member clicks Watch Live from event page, validates stream is live, generates 12-hour signed URL, redirects to player
- IvsStreamController::linkToEvent() — admin AJAX endpoint to link/unlink IVS stream to an event
- New routes: ivs.event.watch (auth) and admin.ivs.link-event (auth POST)
- Event edit page (update.blade.php): IVS stream dropdown, Save IVS Link button, AJAX save, current stream display
- Event view page (view.blade.php): Watch Live button (red, opens new tab) when stream is live; Coming Soon button (disabled, yellow) when stream is coming soon; no button when stream is off or not linked
- Player reuses existing resources/views/ivs/player.blade.php — no new player view
- YouTube livestream methods and youtube_live_url column untouched — both systems work alongside each other
- $ivsStreams passed to event edit view via eventUpdate() in EventController
- ->with('ivsStream') eager loading added to eventView() and eventUpdate() queries
### Fixed
- Added missing IVS Stream Manager link to Maintenance sidebar dropdown
- Added missing IVS routes to routes/web.php — all admin.ivs.* routes, ivs.watch, ivs.event.watch, admin.ivs.link-event, and ivs.player were never registered, causing RouteNotFoundException on every page load
- Added all missing IvsStreamController methods: index, create, store, edit, update, destroy, toggleStatus, generateToken, memberTypeOptions(); player() now validates signed URL and stream live state before rendering
- Created missing Blade views:
  resources/views/maintenance/ivs/index.blade.php
  resources/views/maintenance/ivs/form.blade.php
  resources/views/ivs/player.blade.php
- Fixed Blade syntax error in form.blade.php: collapsed multi-line ternary expressions for starts_at and ends_at into single lines
- Added IVS stream links in Events sidebar for members (role_id 3) and admins (role_id 1) with live/coming-soon badges
- Fixed persistent Blade parse error in form.blade.php: moved starts_at/ends_at formatting into @php block to avoid backslash escape issues

---

## [PR 10] - 2026-04-05
### Added
- Member impersonation ("View as Member") using lab404/laravel-impersonate v1.7.7
- Admin only: "View as Member" button on member profile page (member-info.blade.php)
- Impersonation restricted to role_id 4 (Member) and 7 (Applicant) only — admins cannot be impersonated
- Fixed red banner shown on all pages during impersonation with one-click return to admin
- Audit log entries written on impersonation start and end (ImpersonateController)
- Laravel Log entries written on impersonation start and end for server-side tracing

### Fixed
- Corrected role IDs for impersonation: canBeImpersonated() now correctly targets role_id 3 (Member)
- Removed non-existent role_id 7 (Applicant) from impersonation check
- Updated comments to reflect actual role names (Admin, not Super Admin)
- Removed activity() calls from ImpersonateController — spatie/laravel-activitylog is not installed; project uses OwenIt Auditing. Laravel Log::info() retained for audit trail.

---

## [1.3.0] — 2026-04-01

### Added
- Primary Institution, Specialty, and Induction Date fields across registration, member self-update, and admin member update forms (Induction Date view-only for members).
- Config-driven option lists for Primary Institution and Specialty.
- Dashboard improvements: member status badge, PRC expiry popup (once per month per member), uniform 3:1 event banner aspect ratio.

### Changed
- Admin member update excludes the “Not Yet Defined” chapter option.
- Registration type picker hides “Foreign Delegate 2”.

### Files
- app/Models/MemberInfo.php
- app/Http/Controllers/MemberInfoController.php
- app/Http/Controllers/SessionsController.php
- app/Http/Controllers/DashboardController.php
- resources/views/dashboard/index.blade.php
- resources/views/members/member-update.blade.php
- resources/views/members/member-new-update-profile.blade.php
- resources/views/members/member-info.blade.php
- resources/views/register/reg.blade.php
- public/assets/js/member-update.js
- public/assets/js/member.js
- public/assets/js/custom-member-applicant.js
- database/migrations/2026_04_01_100000_add_induction_date_to_member_info.php
- config/professional.php

---

## [1.2.0] — 2026-03-31

### Added
- Database Backup & Restore feature in Admin → Maintenance
  - New controller, model, migration, routes, sidebar entry, and S3 storage flow for `.dump` backups (PostgreSQL custom format).
  - System status checks for exec, pg_dump, pg_restore, /tmp write, and S3 reachability.
  - Auto-prunes to latest 30 backups; signed URL downloads; typed RESTORE confirmation.

### Fixed
- Admin member update: consistent input wrappers/IDs, chapter dropdown lists all chapters, country select restores saved value.
- PayMongo checkout: removed stray `\n` tokens causing parse errors.

---

## [1.1.0] — 2026-03-30

### Added
- PayMongo gateway settings table and cached loader (`PaymongoConfig`) with Redis-backed TTL.

---

## [1.0.0] — 2026-03-29

### Added
- Initial PPS Member Portal release on AWS EB + RDS PostgreSQL + Redis + S3.
- Core modules: registration/login, dashboard, events with PayMongo, member listing/edit, audit trails, session timeout, annual dues, CPD points, specialty board, voting.

---

## Deployment Notes

- Platform: AWS Elastic Beanstalk (Amazon Linux 2023, nginx + php-fpm)
- Database: RDS PostgreSQL (`DB_CONNECTION=pgsql`)
- Redis: ElastiCache for cache/sessions/queues
- S3: `pps-membership-system` bucket (`applicant/`, `database-backups/`)
- Run after deploy: `php artisan migrate`, `php artisan config:cache`, `php artisan route:cache`, `php artisan view:clear`

---

*Maintained by: PPS Portal development team*  
*Last updated: 2026-04-01*
