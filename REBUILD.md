# PPS Member Portal — Master Rebuild Tracker
**URL:** myportal.pps.org.ph  
**Stack:** Laravel 9.52 / PHP 8.2 / PostgreSQL / AWS Elastic Beanstalk / ElastiCache Valkey  
**Members:** ~9,000 active  
**Last Updated:** 2026-04-05  

---

## ⚡ WHERE WE ARE RIGHT NOW

**Current Phase:** PHASE 0 — Codebase Audit  
**Current Task:** P0-T1 — Run full codebase audit via Claude Code  
**Next Step:** Generate and run the Phase 0 audit prompt in Claude Code  

> Every time you return, check this section first. Ask Claude: *"where are we?"* and Claude will update you instantly.

---

## 🧭 DESIGN PHILOSOPHY
> These are the rules every developer must follow. No exceptions.

1. **No Hardcoding — Ever.** If there is a choice to be made, the Admin makes it through the admin panel — not the programmer in the code.
2. **Admin Has Full Control.** No feature is "finished" unless the admin can fully manage it without touching code or the database.
3. **Spatie Roles & Permissions as the Foundation.** Every access decision goes through Spatie `hasRole()` / `can()`. No `role_id` checks anywhere in the codebase.
4. **Clean, Professional UI.** Easy to understand for both admins and members. Consistent design language across all pages.
5. **Modular Structure.** Every feature is self-contained. A new developer can open one module and understand it without reading the whole codebase.
6. **New Features Are Always Complete.** Every new feature ships with: full admin controls, proper permissions, audit trail, clean UI, and documentation.
7. **Proper Database Usage.** Everything through Eloquent — no raw `DB::` shortcuts. No connection leaks. Respect the RDS Proxy and connection pooling.
8. **Tested Before Deployed.** Every change is verified on `dev.myportal.pps.org.ph` before touching production.
9. **Documented Always.** CHANGELOG.md updated every PR. REBUILD.md updated every phase. Code comments where needed.

---

## 🏗️ INFRASTRUCTURE MAP

| Layer | Technology | Notes |
|---|---|---|
| Framework | Laravel 9.52 / PHP 8.2 | Target: upgrade to Laravel 11 eventually |
| Hosting | AWS Elastic Beanstalk (Amazon Linux 2023) | nginx + php-fpm |
| Web Server | nginx + php-fpm | |
| Database (Prod) | RDS PostgreSQL via RDS Proxy | Proxy: pps-portal-db-proxy |
| Database (Dev) | RDS PostgreSQL direct | No RDS Proxy on dev |
| Cache / Queue | ElastiCache Valkey 8.1 Serverless | TLS required, shared prod+dev with separate prefixes |
| Storage | AWS S3 | All files via `temporaryUrl()` |
| Payments | PayMongo | Webhook hardened (PR 5 & 6) |
| Local Dev | Windows / Laragon / VS Code / Claude Code | PHP 8.2, local .env → live RDS |
| Staging | dev.myportal.pps.org.ph | CNAME → EB dev environment |

---

## 👥 ROLES (Current — Pre-Spatie)

| role_id | Role Name | Notes |
|---|---|---|
| 1 | Admin | Highest role. Jamie's account. `canImpersonate()` |
| 2 | Creator | |
| 3 | Member | `canBeImpersonated()` |
| 4 | Cashier | |
| 5 | Hospital | |
| 6 | Attendance | |

> ⚠️ No "Super Admin" role exists in the DB. PR 9 planned one — do NOT introduce it without a full migration plan.

---

## ✅ COMPLETED WORK (PRs 1–12)
> This work must be preserved through the entire rebuild.

| PR | Feature | Status |
|---|---|---|
| PR 1 | Image optimization (resize, EXIF, JPEG 82%, S3 upload) | ✅ Done |
| PR 2 | Admin member profile full data view | ✅ Done |
| Bug Fix | MaintenanceController null check on picture (line 278) | ✅ Done |
| PR 3 | Audit Trails v1 (OwenIt, AuditController, sidebar) | ✅ Done |
| PR 4 | Audit Trails v2 (config fix, query optimization, pagination) | ✅ Done |
| PR 5 | PayMongo hardening (HMAC webhook, replay window, idempotency) | ✅ Done |
| PR 6 | PayMongo hardening v2 (amount/currency validation, more idempotency) | ✅ Done |
| PR 7 | Payment Gateway admin UI (DB settings, PaymongoConfig helper) | ✅ Done |
| PR 8 | Payment Gateway UI + Cashier Reconciliation (mode badge, columns) | ✅ Done |
| PR 9 | Roles/permissions plan (Spatie — planned, not yet implemented) | 📋 Planned |
| PR 10 | Member impersonation (lab404/laravel-impersonate) | ✅ Done |
| PR 11 | IVS Stream Manager (CRUD, routes, sidebar) | ✅ Done |
| PR 12 | IVS event linking (ivs_stream_id FK on tbl_event) | ✅ Done |

---

## 🐛 KNOWN BUGS & ISSUES
> All must be fixed during rebuild. None can be left behind.

| # | Issue | Severity | Status |
|---|---|---|---|
| B1 | Syntax error in EventController.php line 2050 | 🔴 Critical | ⏳ Pending |
| B2 | 9 Composer security vulnerabilities | 🔴 Critical | ⏳ Pending |
| B3 | Abandoned/unmaintained Composer packages | 🟡 High | ⏳ Pending |
| B4 | PSR-4 naming convention violations throughout codebase | 🟡 High | ⏳ Pending |
| B5 | Raw `DB::` calls bypassing Eloquent (query standards) | 🟡 High | ⏳ Pending |
| B6 | Hardcoded role_id checks throughout controllers and views | 🟡 High | ⏳ Pending |
| B7 | Database connection not closing properly (legacy — pre-AWS) | 🟡 High | ✅ Mitigated (RDS Proxy) |
| B8 | Missing member edit fields (Middle Name, Suffix, Barangay, etc.) | 🟠 Medium | ⏳ Pending |
| B9 | DB indexes missing on audits table (created_at, auditable_type, etc.) | 🟠 Medium | ⏳ Pending |
| B10 | PAYMONGO_WEBHOOK_SECRET not set in EB Console (prod) | 🟠 Medium | ⏳ Pending |
| B11 | PaymentGatewaySetting keys not encrypted at rest | 🟠 Medium | ⏳ Pending |
| B12 | Cache not flushed on Payment Gateway key save | 🟠 Medium | ⏳ Pending |
| B13 | Audit trail route-level middleware missing | 🟠 Medium | ⏳ Pending |
| B14 | Session-bound payment success/cancel flow incomplete | 🟠 Medium | ⏳ Pending |
| B15 | Sensitive keys exposed in Git history (APP_KEY, DB_PASSWORD, AWS keys, PayMongo keys) | 🔴 Critical | ✅ Fixed |
| B16 | .env.config contained real secrets in Git | 🔴 Critical | ✅ Fixed |

---

## 🗺️ FULL REBUILD PLAN

### PHASE 0 — Full Codebase Audit
> Goal: Understand exactly what exists before touching anything. No code changes in this phase.

| Task | Description | Status |
|---|---|---|
| P0-T1 | Run Claude Code audit — all routes, controllers, views, role checks | ✅ Done |
| P0-T2 | Map every `role_id` hardcoded check in the codebase | ✅ Done |
| P0-T3 | List all Composer packages — flag vulnerable and abandoned ones | ⏳ Pending |
| P0-T4 | List all database tables and relationships | ⏳ Pending |
| P0-T5 | Document all existing features (what works, what is half-built) | ⏳ Pending |
| P0-T6 | Set up Git branching strategy (main / staging / feature branches) | ⏳ Pending |
| P0-T7 | Fix syntax error B1 (EventController.php line 2050) | ⏳ Pending |
| P0-T8 | Fix Composer vulnerabilities B2 | ⏳ Pending |

---

### PHASE 1 — Foundation & Standards
> Goal: Establish the correct technical foundation everything else will be built on.

| Task | Description | Status |
|---|---|---|
| P1-T1 | Implement Spatie Laravel Permission (install, config, seed 6 roles) | ⏳ Pending |
| P1-T2 | Migrate existing users to Spatie roles (one-time seeder) | ⏳ Pending |
| P1-T3 | Define all permissions (every action in the system) | ⏳ Pending |
| P1-T4 | Replace all hardcoded role_id checks with Spatie hasRole()/can() | ⏳ Pending |
| P1-T5 | Role & Permission Management UI for Admin | ⏳ Pending |
| P1-T6 | Establish Service class structure (thin controllers) | ⏳ Pending |
| P1-T7 | Set up proper error logging (Sentry or Laravel Telescope) | ⏳ Pending |
| P1-T8 | Add missing DB indexes (audits table — B9) | ⏳ Pending |
| P1-T9 | Encrypt PaymentGatewaySetting keys at rest (B11) | ⏳ Pending |
| P1-T10 | Fix cache flush on Payment Gateway key save (B12) | ⏳ Pending |
| P1-T11 | Set PAYMONGO_WEBHOOK_SECRET in EB Console (B10) | ⏳ Pending |

---

### PHASE 2 — Rebuild Core Modules (One at a Time)
> Goal: Rebuild each module properly — clean, modular, admin-controlled, Spatie-protected.
> Rule: Finish and verify one module before starting the next.

| Task | Module | Description | Status |
|---|---|---|---|
| P2-T1 | Member Profile & Directory | Full rebuild — all fields, admin controls, clean UI | ⏳ Pending |
| P2-T2 | Member Edit (missing fields) | Middle Name, Suffix, Barangay, all missing fields (B8) | ⏳ Pending |
| P2-T3 | Authentication & Impersonation | Login, registration, impersonation — proper and clean | ⏳ Pending |
| P2-T4 | Membership Applications | Application flow, approval workflow, admin controls | ⏳ Pending |
| P2-T5 | Payments (PayMongo) | Already hardened — refactor to service class pattern | ⏳ Pending |
| P2-T6 | Events Module | Full rebuild — admin controls for all event settings | ⏳ Pending |
| P2-T7 | IVS Streaming | Already built — audit and clean up to standard | ⏳ Pending |
| P2-T8 | Reports & Audit Trails | Already built — audit, clean, add missing middleware (B13) | ⏳ Pending |
| P2-T9 | Cashier & Reconciliation | Full rebuild to service class pattern | ⏳ Pending |
| P2-T10 | Notifications (Email/SMS) | Admin-configurable templates, not hardcoded messages | ⏳ Pending |
| P2-T11 | Chapter Management | Full admin control over chapters | ⏳ Pending |
| P2-T12 | Specialty Board | Full rebuild to standard | ⏳ Pending |

---

### PHASE 3 — New Features (Greenfield)
> Goal: Build brand new features correctly from the start.

| Task | Feature | Description | Status |
|---|---|---|---|
| P3-T1 | Voting Infrastructure | SQS queue architecture for annual conventions | ⏳ Pending |
| P3-T2 | Database Manager | Super Admin module, S3 backup capabilities | ⏳ Pending |
| P3-T3 | VIP Exemption Logic | Proper admin-controlled VIP rules | ⏳ Pending |
| P3-T4 | Member Portal Dashboard | Clean, informative, role-aware dashboard | ⏳ Pending |
| P3-T5 | Admin Dashboard | System health, stats, quick actions | ⏳ Pending |

---

### PHASE 4 — Cleanup, Performance & Documentation
> Goal: Production-ready, documented, maintainable codebase.

| Task | Description | Status |
|---|---|---|
| P4-T1 | Remove all legacy/dead code | ⏳ Pending |
| P4-T2 | Full database optimization (indexes, query review) | ⏳ Pending |
| P4-T3 | Performance audit (slow queries, N+1 problems) | ⏳ Pending |
| P4-T4 | Write README.md (full developer onboarding guide) | ⏳ Pending |
| P4-T5 | Final CHANGELOG.md cleanup and review | ⏳ Pending |
| P4-T6 | Consider Laravel version upgrade (9 → 10 → 11) | ⏳ Pending |

---

## 📋 PROMPT LOG
> Every Claude Code prompt given is logged here so nothing is lost.

| # | Phase | Task | Prompt Summary | Date | Result |
|---|---|---|---|---|---|
| 001 | Pre-Phase 0 | Security hardening | Removed exposed secrets from Git history, rotated all API keys, protected .env and env.config | 2026-04-05 | Done |
| 002 | Phase 0 | P0-T1 Full Codebase Audit | Full audit of routes, controllers, models, views, role checks, DB queries, packages, migrations. Output saved to AUDIT.md | 2026-04-05 | AUDIT.md created — 946 lines, 10 sections |
| 003 | Phase 0 | P0-T2 | Fixed unprotected /clear-all route in web.php | 2026-04-05 | Done |

---

## 📌 RULES FOR EVERY CLAUDE CODE PROMPT
> Every prompt given to Claude Code must include these instructions.

1. Update `CHANGELOG.md` at the repo root using Keep a Changelog format
2. Update `REBUILD.md` — mark the relevant task as ✅ Done
3. Follow PSR-4 naming conventions
4. Use Eloquent — no raw `DB::` queries
5. All role/permission checks via Spatie `hasRole()` / `can()`
6. All Blade views use `<x-page-template>` component — never `@extends()`
7. Use `optional()` for all member property access (admins have no tbl_member_info)
8. Run `php -l` on all modified PHP files before finishing
9. PostgreSQL syntax only — no MySQL-specific functions
10. S3 files always via `temporaryUrl()`
11. No hardcoded values — use config or admin settings

---

## 🔑 KEY TECHNICAL FACTS
> Critical facts every developer and AI prompt must know.

- **`pps_no`** — links `users` to `tbl_member_info` (NOT `pps_number`)
- **`member_type_name`** — column in `tbl_member_type` (NOT `name`)
- **Admin users** have no `tbl_member_info` records — always null-guard
- **OwenIt Auditing** is used — NOT spatie/laravel-activitylog. `activity()` helper does NOT exist
- **ElastiCache TLS** — `scheme` key required in all Redis config blocks
- **`REDIS_PASSWORD`** must be completely unset — ElastiCache uses security group auth
- **Never edit EB server directly** — all fixes via Git + ZIP deploy
- **EB environment variables** go in EB Console — not `.env`
- **`artisan view:cache`** must run as `webapp` user — not root
- **Blade `format()`** calls go inside `@php` blocks — not inside `{{ }}`
- **`@php use Illuminate\Support\Str; @endphp`** must be line 1 before any `<x->` tags
- **Never use `route('x')` inside JS single-quoted strings** — use double quotes

---

*This document is the single source of truth for the PPS Portal rebuild.*  
*Update it after every completed task. Never skip this step.*
