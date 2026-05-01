# Git Notes — Branch Management & Workflow

## `git pull` vs `git merge`

`git pull` is a two-step shortcut:
1. `git fetch` — downloads new commits/refs from the remote, updating remote-tracking refs (e.g. `origin/development/story/omahastreetdev`) **without touching your working branch**
2. `git merge` (or rebase, if configured) — integrates those downloaded commits into your current branch

`git merge` alone **never contacts the remote**. It only works with what's already on your machine — either a local branch or a previously-fetched remote-tracking ref.

---

## `git pull development/story/omahastreetdev` vs `git pull origin development/story/omahastreetdev`

These are **not equivalent**, and the first one will likely fail.

`git pull` syntax is: `git pull [remote] [branch]`

- `git pull origin development/story/omahastreetdev` — **correct**: fetches from the remote named `origin`, specifically the `development/story/omahastreetdev` branch, then merges it into your current branch.
- `git pull development/story/omahastreetdev` — git interprets the first argument as a **remote name**, not a branch name. Since `development/story/omahastreetdev` is not a configured remote, this will error out.

---

## Replacing `pull` with `merge`

`git merge` syntax is: `git merge [ref] [ref] ...` — it takes **refs** (branch names, commit hashes, remote-tracking refs), **not** a remote name + branch name pair.

| Command | What it does |
|---|---|
| `git merge development/story/omahastreetdev` | Merges your **local** branch of that name. No network call. Could be stale. |
| `git merge origin/development/story/omahastreetdev` | Merges the **remote-tracking ref** (last fetched state). No network call. |
| `git merge origin development/story/omahastreetdev` | Attempts an **octopus merge** of two refs named `origin` and `development/story/omahastreetdev` — almost certainly not what you want. |

So `git pull origin development/story/omahastreetdev` has **no direct single-command `merge` equivalent** — you'd split it into:
```bash
git fetch origin development/story/omahastreetdev
git merge origin/development/story/omahastreetdev
```
Note the `/` not a space when referencing the remote-tracking ref.

---

## Recommended workflow

### Updating your local shared branch after a PR completes in Azure DevOps

```bash
git checkout development/story/omahastreetdev
git fetch origin
git merge --ff-only origin/development/story/omahastreetdev
```

`--ff-only` is a safety net: if the merge can't be a simple fast-forward (e.g. you accidentally committed locally to the shared branch), it errors out rather than silently creating an unintended merge commit. Your local shared branch should always be read-only — only Azure DevOps PRs should change it.

### Bringing latest shared branch changes into your feature branch

```bash
# While on your feature branch (e.g. omahastreetdev/task/1096690)
git fetch origin
git merge origin/development/story/omahastreetdev
```

This creates a merge commit on your feature branch. Perfectly fine and safe.

### Full loop — feature branch to PR

```bash
# 1. On your feature branch, get latest from shared before you PR
git fetch origin
git merge origin/development/story/omahastreetdev

# 2. Resolve any conflicts, commit, then push your feature branch
git push origin omahastreetdev/task/1096690

# 3. Create the PR in Azure DevOps → get approval → complete merge there

# 4. After PR completes, update your local shared branch
git checkout development/story/omahastreetdev
git fetch origin
git merge --ff-only origin/development/story/omahastreetdev
```

---

## Fast-forward merges

A fast-forward happens when the branch you're merging **into** hasn't diverged at all from the branch you're merging **from** — every commit on your current branch is already an ancestor of the incoming branch. Git just moves your branch pointer forward; no new merge commit is created.

**Before:**
```
A --- B --- C          ← development/story/omahastreetdev (local)
             \
              D --- E  ← origin/development/story/omahastreetdev
```

**After fast-forward:**
```
A --- B --- C --- D --- E  ← development/story/omahastreetdev (local, pointer moved)
```

**When it can't fast-forward** (branches have diverged — a merge commit is required):
```
A --- B --- C --- X    ← your local branch (X is a commit nobody else has)
             \
              D --- E  ← origin
```

> **Key mental model:** fast-forward is not a strategy — it's a condition. It either is or isn't possible based on the commit graph. Merge strategies only come into play when a merge commit actually needs to be constructed.

---

## Merge strategies — and "ort"

When git can't fast-forward, it uses a **merge strategy** to combine two diverged histories.

**`recursive`** — was the default for years. Recursively finds the best common ancestor when there are multiple possible ones.

**`ort`** — replaced `recursive` as the default in Git 2.34 (late 2021). Stands for *Ostensibly Recursive's Twin*. Produces identical results in virtually all cases but is significantly faster. When you see `Merge made by the 'ort' strategy`, it just means git used its current default — nothing unusual is happening.

**`octopus`** — used automatically when merging three or more branches at once.

**`ours`** — keeps your current branch's content entirely, discarding incoming changes. Rarely used outside specific release management scenarios.

| Situation | What git does | Strategy used |
|---|---|---|
| Local shared branch behind remote, no local commits | Fast-forward | None needed — no new commit |
| Feature branch getting latest from shared branch | Merge commit created | `ort` (default) |
| Two branches with conflicting changes | Merge commit + conflict resolution | `ort` |

---

## Azure DevOps PR notes

- Every branch — including your own feature branches — should go through a PR in Azure DevOps into `development/story/omahastreetdev`. This is true even if you're the only reviewer.
- Whether you can approve your own PRs depends on branch policies. Check under:
  **Project Settings → Repos → Policies → Branch Policies → `development/story/omahastreetdev`**
- The relevant setting is **"Allow requestors to approve their own changes"** under the Minimum number of reviewers policy.
- Never merge or rebase onto the shared branch locally — let Azure DevOps PRs be the only thing that changes `development/story/omahastreetdev`. Your local copy should always be updated with `fetch` + fast-forward only.

---

## `pull.rebase` config

Run `git config pull.rebase` to check your setting.
- `false` (or empty) — `git pull` uses merge (default behaviour described in these notes)
- `true` — `git pull` rebases instead of merging, which changes behaviour significantly
