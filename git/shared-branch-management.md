# Shared branch management notes

git pull vs git merge
git pull is a two-step shortcut:

git fetch — downloads new commits/refs from the remote, updating your remote-tracking refs (e.g. origin/development/story/omahastreetcar) without touching your working branch
git merge (or rebase, if configured) — integrates those downloaded commits into your current branch

**git merge alone never contacts the remote. It only works with what's already on your machine — either a local branch or a previously-fetched remote-tracking ref.**

### git pull development/story/omahastreetcar vs git pull origin development/story/omahastreetcar
These are not equivalent, and the first one will likely fail.

git pull syntax is: git pull [remote] [branch]

git pull origin development/story/omahastreetcar — correct: fetches from the remote named origin, specifically the development/story/omahastreetcar branch, then merges it into your current branch.
git pull development/story/omahastreetcar — git interprets the first argument as a remote name, not a branch name. Since development/story/omahastreetcar is almost certainly not a configured remote, this will error out.

### Replacing pull with merge
This is where it gets importantly different:

git merge syntax is: git merge [ref] [ref] ...
— it takes refs (branch names, commit hashes, remote-tracking refs), **_not a remote name + branch name pair_**.

Examples:

`git merge development/story/omahastreetcar` - Merges your local branch of that name. No network call. Could be stale.

`git merge origin/development/story/omahastreetcar` - Merges the remote-tracking ref ... FROM THE LAST FETCHED STATE.
- No network call.
- Attempts an octopus merge of two refs named origin and development/story/omahastreetcar — almost certainly not what 
you want, and will likely fail or produce a mess.
- `git pull origin development/story/omahastreetcar` - has no direct single-command merge equivalent — you'd need to split it:

1. git fetch origin development/story/omahastreetcar
2. git merge origin/development/story/omahastreetcar (note the slash not the space).

## When you are on a feature branch and want latest from shared branch:

Since pull.rebase is false, git pull uses merge. While on omahastreetdev/task/1096690, the cleanest way to bring in 
the shared branch's latest is two steps:

git fetch origin
git merge origin/development/story/omahastreetcar

What this produces: a merge commit on your feature branch — "Merge branch 'origin/development/story/omahastreetcar' into omahastreetdev/task/1096690". 
This is perfectly fine and safe. It's honest about when you integrated changes.

You could also do git pull origin development/story/omahastreetcar from your feature branch and it would do the same 
thing in one step.
But the explicit fetch + merge is better while you're still building confidence, because fetch never changes your 
working files and you can inspect origin/development/story/omahastreetcar before committing to the merge.

## PR Merge Workflow

After approving and completing in Azure DevOps -
`git fetch origin`
`git merge --ff-only origin/development/story/omahastreetcar`
--ff-only here is a safety net: after a PR completes in Azure DevOps, the shared branch should be strictly ahead of your local copy, so a fast-forward is always possible. 
If it ever fails with --ff-only, that's a signal something unexpected happened (e.g. you accidentally committed to the shared branch locally) and you want to know about it before blindly merging.

One thing to watch: don't merge or rebase onto the shared branch locally — let Azure DevOps PRs be the only thing that changes development/story/omahastreetcar. Your local copy of it should always just be a read-only mirror that you update with fetch + fast-forward. 
The only direction you should merge locally is from the shared branch into your feature branch.

Every branch — including your own feature branches — should go through a PR in Azure DevOps into development/story/omahastreetcar. This is true even if you're the only one reviewing it.

Why this matters for your workflow:

It keeps the shared branch's history clean and consistent — every change arrives the same way regardless of who authored it
It gives you (or a teammate) a diff to review before anything lands on the shared branch
It means your local development/story/omahastreetcar stays strictly read-only, which protects against accidental local commits to it
Azure DevOps can enforce branch policies (required reviewers, build checks, etc.) that would be bypassed by a local 
merge.

### The complete loop:

# On your feature branch, get latest from shared before you PR
git fetch origin
git merge origin/development/story/omahastreetcar

# Resolve any conflicts, commit, then push your feature branch
git push origin omahastreetdev/task/1096690

# Then create the PR in Azure DevOps → get approval → complete merge there

git checkout development/story/omahastreetcar
git fetch origin
git merge --ff-only origin/development/story/omahastreetcar

Then switch back to your next feature branch and repeat.

## Notes

Fast-forward merges
A fast-forward happens when the branch you're merging into hasn't diverged at all from the branch you're merging from — meaning every commit on your current branch is already an ancestor of the incoming branch. Git doesn't need to create a new merge commit; it just moves your branch pointer forward along the existing line of commits.

BEFORE:
A --- B --- C          ← development/story/omahastreetdev (local)
\
D --- E  ← origin/development/story/omahastreetdev

AFTER
A --- B --- C --- D --- E  ← development/story/omahastreetdev (local, pointer moved)

WHEN IT CAN'T FAST FORWARD:

A --- B --- C --- X    ← your local branch (X is a commit nobody else has)
\
D --- E  ← origin

Here the branches have diverged. A true merge commit is required to join them, and --ff-only would refuse and error out — which is exactly why it's a useful safety check on a branch that should only ever be updated by Azure DevOps PRs.

