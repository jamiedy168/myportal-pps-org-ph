# PPS Member Portal — Git Branching Strategy

---

## Branch Rules

| Branch | Purpose | Rules |
|--------|---------|-------|
| `main` | Production | Never commit directly. Only receives merges from `staging`. |
| `staging` | Pre-production testing | All feature and fix branches merge here first. Test on `dev.myportal.pps.org.ph` before merging to `main`. |
| `feature/*` | New features | Branch off `main`. Example: `feature/spatie-roles` |
| `fix/*` | Bug fixes | Branch off `main`. Example: `fix/event-controller-syntax` |

---

## Workflow

1. Create a branch from `main`:
   ```
   git checkout main
   git pull origin main
   git checkout -b feature/your-feature-name
   ```

2. Do your work. Commit often with clear messages.

3. Push your branch and open a PR to `staging`:
   ```
   git push origin feature/your-feature-name
   ```

4. Test on staging (`dev.myportal.pps.org.ph`). Fix any issues before proceeding.

5. Once verified on staging, open a PR from `staging` → `main`.

6. Merge to `main` only after staging is confirmed working.

---

## Rules — No Exceptions

- **Never push directly to `main`**
- **Never merge a feature branch directly to `main`** — always go through `staging` first
- Every PR must have `CHANGELOG.md` and `REBUILD.md` updated
- Every PR must pass `php -l` on all changed PHP files

---

*Last updated: 2026-04-06*
