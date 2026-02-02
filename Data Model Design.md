# 📐 Data Model Design

**Project:** Laravel Dev Control Center (LDCC)
**Storage:** Local **SQLite** (single-user, desktop-first)
**Philosophy:**

* Project-centric
* Everything is *context-aware*
* Safe-by-default (especially prod)

---

## 1. Core Design Principles (read this first)

### 1️⃣ Project is the root

If it’s not tied to a **project**, it doesn’t exist.

Bad:

* Global SSH configs
* Global DBs
* Global notes

Good:

* Project → environments → servers → databases → notes

---

### 2️⃣ Environment separation is mandatory

Every destructive mistake happens because **dev/staging/prod** are mixed.

So:

* Environment is a **first-class entity**
* Every risky action checks environment type

---

### 3️⃣ Secrets never live in plaintext

* Passwords, SSH keys → OS Keychain
* SQLite only stores **references / IDs**

---

## 2. Entity Relationship Overview (mental model)

```
Project
 ├── Environments (dev / staging / prod)
 │     ├── Servers (SSH)
 │     ├── Databases
 │     ├── Runtime Config
 │     └── Notes
 ├── Git Info
 ├── Tinker History
 └── Project Notes
```

---

## 3. Tables (Detailed, production-ready)

---

## 🧩 projects

**Root entity**

```sql
projects
- id (uuid)
- name
- slug
- local_path
- framework (laravel / lumen / generic)
- php_version_id (nullable)
- node_version_id (nullable)
- git_repo (nullable)
- created_at
- updated_at
```

Why:

* `slug` for internal routing
* `local_path` enables shell + tinker + artisan
* Runtime versions override global defaults

---

## 🌍 environments

**Context safety layer**

```sql
environments
- id (uuid)
- project_id
- name (Local, Staging, Production)
- type (dev | staging | prod)
- is_default (boolean)
- created_at
```

Rules:

* Exactly **1 default**
* `type = prod` triggers guardrails

---

## 🖥️ servers

**SSH targets**

```sql
servers
- id (uuid)
- environment_id
- name
- host
- port
- username
- auth_type (key | agent)
- ssh_key_ref (nullable)
- created_at
```

Notes:

* No passwords stored
* `ssh_key_ref` → OS keychain identifier

---

## 🗄️ databases

**DB connections**

```sql
databases
- id (uuid)
- environment_id
- name
- driver (mysql | pgsql | sqlite)
- host
- port
- database
- username
- password_ref
- is_readonly (boolean)
- created_at
```

Key design choice:

* `is_readonly = true` by default on prod
* Password stored only in keychain

---

## 🧪 tinker_sessions

**Command history with context**

```sql
tinker_sessions
- id (uuid)
- project_id
- environment_id
- command
- executed_at
- is_destructive (boolean)
```

Why:

* Allows replay
* Allows warnings
* Enables “safe mode”

---

## 📝 notes

**Unified note system**

```sql
notes
- id (uuid)
- project_id
- environment_id (nullable)
- related_type (server | database | general)
- related_id (nullable)
- title
- content
- created_at
- updated_at
```

Power move:

* One table
* Context-aware
* Easy future sync

---

## 🧠 runtime_versions

**PHP / Node versions**

```sql
runtime_versions
- id (uuid)
- type (php | node)
- version
- source (brew | asdf | nvm | system)
- is_global (boolean)
```

Used by:

* Projects
* Environment overrides later

---

## 🔐 saved_commands

**SSH / Artisan / System commands**

```sql
saved_commands
- id (uuid)
- project_id
- environment_id
- name
- command
- requires_confirmation (boolean)
- created_at
```

Example:

* `php artisan migrate`
* `supervisorctl restart all`
* `tail -f storage/logs/laravel.log`

---

## 📦 git_state (cached)

**Read-only insights**

```sql
git_state
- project_id
- current_branch
- is_dirty
- last_commit_hash
- last_synced_at
```

Why cached:

* Avoid running git commands constantly

---

## ⚠️ audit_logs

**Safety + trust**

```sql
audit_logs
- id (uuid)
- project_id
- environment_id
- action
- metadata (json)
- created_at
```

Used for:

* Destructive commands
* Prod access
* Debugging mistakes

---

## 4. Guardrails (non-negotiable rules)

### PROD rules

If `environment.type = prod`:

* ❌ Disable write DB by default
* ❌ Disable `migrate:fresh`, `db:wipe`
* ✅ Require double confirmation
* ✅ Big red UI banner

---

### Command classification

When saving a command:

* Regex detect destructive intent
* Mark `is_destructive = true`
* Force confirmation forever

---

## 5. Why this model scales

You can later add:

* Team sync
* Cloud backup
* AI logs analysis
* Command templates marketplace

Without schema changes — just **new tables**.

---

## 6. Brutal honesty (Apex Advisor)

This data model is:

* ✔️ Strong enough for a paid product
* ✔️ Opinionated (good)
* ✔️ Safe for solo devs

If you simplify it further, you’ll regret it in 6 months.
If you complicate it more, you’ll never ship.

