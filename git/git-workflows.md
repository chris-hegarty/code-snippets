Notes 8/6

-git merge from development/story/kiewitv2dev into 1035976
-accepted incoming from style.css conflict.
-did a merge commit.
-synced up changes to 1035976 remote
-recompiled css
-committed.

3. Fetch Latest Changes (Already Done)

   You've already done:

git fetch
Pulled latest changes into development/story/kiewitv2dev
2. Switch to Your Feature Branch
   sh
   git checkout kiewitv2dev/feature/1035976
3. Merge or Rebase
   You have two options: merge or rebase.

A. Merge (Safe and Common)
This adds a merge commit in your feature branch.

sh
git merge development/story/kiewitv2dev
This will bring all the changes from the team branch into your feature branch.
Easy, preserves history.
B. Rebase (Clean Commit History)
This rewrites your feature branch commits so they appear on top of the latest team branch commits.

sh
git rebase development/story/kiewitv2dev
This creates a linear history.
If there are conflicts, you will resolve them during the rebase.
Note: If you have already pushed your feature branch and others are working on it, prefer merge to avoid rewriting shared history.

4. Push Your Updated Feature Branch
   After merging or rebasing:

sh
git push
If you rebased and already pushed earlier, you’ll need to force-push:
sh
git push --force-with-lease
(But only do this if you're sure no one else is working on your branch!)
Summary Table
Option	Command	Recommended When
Merge	git merge development/story/kiewitv2dev	Most cases, safe
Rebase	git rebase development/story/kiewitv2dev	Clean history, not shared
Best Practice
If working alone on the feature branch, either is fine.
If collaborating on the feature branch, merge is safer.
Always communicate with your team if you plan to force push after a rebase.
TL;DR:
Most teams use merge for simplicity:

sh
git checkout kiewitv2dev/feature/1035976
git merge development/story/kiewitv2dev