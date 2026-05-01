
# Git Basics

"So You Think You Know Git"
https://www.youtube.com/watch?v=aolI_Rz0ZqY&t=109s

Awesome interactive tool:
https://a-a-ron.github.io/visualizing-git/

## Terms

"HEAD" - Pointer to the current branch ref that you are checked out to AKA the branch you are on.
"Working Tree" - Your file system.

## Directories

Git has three directories:

### -.git
When you first initialize git it creates a .git directory.
It's local history.
Committed project snapshots live here.
It contains a "config" file.

### -Working Directory - 
Changes being made to files live here. ("Modified" directory).

### Index, AKA Staging Directory, AKA Staging Area -  
-Files with changes ready to be saved or committed TO THE NEXT SNAPSHOT live here.

## Configurations

### --system 
applied to ALL users on a machine. (rarely need this)

### --global
settings applied to the User level. (most common)

### --local
specific settings for a single git repository.
Will overwrite `--global` settings when set on a particular repository.

To check your settings:
`git config --global --list`

## Commands

There are more than 150 commands. Around 20 - 30 are foundational, common commands.
For more information about any command, do "git <name of command> --help". 

They fall into four general categories:
-Git Basics
-Git Branches
-Remote Repositories
-Undoing changes

### Basics

git init
git add
git status - shows the status of your files.
git commit
git config
git log - shows the commit history in your repository.
git diff - Shows changes between your working directory and the staging area.

### Git Branches

git branch - list, create or delete branches
git checkout - switch between branches
git merge - bring changes from one branch into another.

### Remote Repositories

git clone - Copies remote repo into a new local .git directory
git remote - Create and show linked repositories
git push - local to remote
git pull - remote to local
git fetch

### Undoing Changes

git revert - creates a new commit that does undoes a previous commit. - Is a safe command
git reset - Removes files from the staging area. a "destructive" command.

### Notes about commands

git diff will show you the changes currently in your working directory.
To see staged changes: `git diff --staged`
`git diff head` - will show all changes that havent been committed.

`git merge` 
-You must be on the branch you want to merge into. 
-Example: you want to merge "feature" into "main", you need to be on "main"
-When you run `git merge`, git is making a commit on the branch you are merging INTO.
-And since you are essentially making a new commit, you have to provide a message.
-So if you are on main, the command ends up looking like:
`git merge feature -m "Merge feature branch into main.`

`git log` - Comes with more than 100 different options.

Create a remote: 
`git remote add origin <link to remote repo>`

Send changes to the remote:
`git push -u origin main`
The "u" stands for upstream.
You need to use the "u" option when you FIRST push a local branch and there isn't a remote branch for it yet.

--oneline - will condense to hash + message only
--oneline --graph - will show where branches diverged.

`git reset` - There are three options:

`git reset --soft` - Will take a commit from your history and place it back into the staging area.

`git reset --mixed` - Same as `git reset`. Will put them into your working directory, but NOT stage them.

`git reset --hard` - Destructive command. It will take a commit from the history and trash it.

If you've trashed something, you can use the "reflog" and "cherry pick" - You can "cherry pick" a commit to add it 
back into the commit history.

## Collaborating on shared repositories

To preview changes after `git fetch` :
`git diff local-branch origin/local-branch`

## Merge strategies

Two main types you'll run into:

Fast-forward - Simplest. Can only be done with a linear commit history.
Three-way merge - Uses THREE commits to make a NEW commit in the history.

`git rebase` - Take diverging branch histories and rewrites it to be linear. 

## Popular Git workflows



## Miscellaneous Notes

The "-L" flag is used to specify a range of lines in a file.

So you can do "git log -L 15,26:path/to/file"

"git config --global rerere.enabled" if you set this to true, it will remember how you resolved merge conflicts and 
can do it automatically in the future.

"git push force-with-lease"
will check the reference and if it doesnt match, it won't push it.

"git maintenance start" - does cleanup stuff in the background.

Monorepo Stuff

"sparse-checkout"

Look up: 

"Rebase" vs "Merge" 
"squash merging" 
"Squash and Merge" 
"Rebase and Merge"
GitButler
force with lease
"git switch"









