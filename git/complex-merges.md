# Complex Merges

VS Code's merge conflict resolution works well for:

✅ Content conflicts (both sides modified the same file)
✅ Edit/delete conflicts (one side modified, other deleted)
VS Code struggles with:

❌ Complex renames and directory restructuring
❌ "Added by us" files (no incoming version exists)
❌ Mass file movements.

## Command Line - Status Codes:

AU - Added by Us
What it means: You created a new file in your branch, but the incoming branch has no version of this file
Typical scenario: You're working on a feature and created new files that don't exist in the branch you're merging from
Resolution: Usually git add <file> to keep your new file
Example: Your kiewit-term-meta.php file

UA - Added by Them
What it means: The incoming branch created a new file that doesn't exist in your current branch
Typical scenario: Someone else added new files while you were working on your branch
Resolution: Usually git add <file> to accept their new file, or git rm <file> to reject it

AA - Added by Both
What it means: Both branches independently created a file with the same name
Typical scenario: Two developers unknowingly created files with identical names/paths
Resolution: Examine the files, merge content manually if needed, then git add <file>
Example: Your rest-api-auth.php file (though it turned out to be identical)

DD - Deleted by Both
What it means: Both branches deleted the same file
Typical scenario: Rare - file was independently removed by both sides
Resolution: Usually auto-resolved by Git (no action needed)

DU - Deleted by Us
What it means: You deleted a file, but the incoming branch modified it
Typical scenario: You removed an obsolete file, but someone else was still working on it
Resolution: Choose to either restore + merge their changes, or confirm deletion with git rm <file>

UD - Deleted by Them
What it means: The incoming branch deleted a file that you still have (and possibly modified)
Typical scenario: Directory restructuring, file cleanup, or they decided to remove something you were working on
Resolution: Either git add <file> to keep your version, or git rm <file> to accept their deletion
Example: All those old dev-kiewitnetwork.kiewit.com files in your case

## Senior Dev approach

# 1. Understand the conflict types
git status --porcelain | Select-String -Pattern "^AU|^UA|^AA|^DD|^DU|^UD"

# 2. For "Added by us" (AU) files - keep them
git add path/to/your-new-file.php

# 3. For "Both added" (AA) files - examine and resolve
# Check for conflict markers first:
Select-String -Path "path/to/file.php" -Pattern "^<{7}|^={7}|^>{7}"
# If no markers, just add:
git add path/to/file.php

# 4. For "Unmerged deleted" (UD) files - usually remove in restructuring
git status --porcelain | Select-String -Pattern "^UD " | ForEach-Object { $_.ToString().Substring(3) } | ForEach-Object { git rm $_ }

# 5. Verify all conflicts resolved
git status --porcelain | Select-String -Pattern "^AU|^UA|^AA|^DD|^DU|^UD"

# 6. Complete the merge
git commit

## Nuclear Commands

# Abort the merge entirely and start over
git merge --abort

# Or accept ALL incoming changes (loses your work!)
git reset --hard MERGE_HEAD

# Or accept ALL your changes (ignores incoming)
git reset --hard HEAD

## regex notes

`^<{7}|^={7}|^>{7}`

Here's a breakdown of the regex pattern ^<{7}|^={7}|^>{7}:

### Pattern Components

`^` - Start of Line Anchor
Matches only at the beginning of a line
Ensures the conflict markers appear at the start, not embedded within text

`<{7}` - Seven Less-Than Characters
`<` - Literal less-than character
`{7}` - Quantifier meaning "exactly 7 times"
Matches: `<<<<<<<`

`|` - OR Operator
Alternation - matches any one of the separated patterns
Creates three possible matches in this regex

`={7}` - Seven Equals Characters
`=` - Literal equals character
`{7}` - Exactly 7 times
Matches: `=======`

`>{7}` - Seven Greater-Than Characters
`>` - Literal greater-than character
`{7}` - Exactly 7 times
Matches: `>>>>>>>`

### What This Detects
This regex identifies Git merge conflict markers. 
When Git can't automatically resolve conflicts, it inserts these markers into files:

```php

function example() {
<<<<<<< HEAD
    return "your version";
=======
    return "their version";  
>>>>>>> branch-name
}

```

### The Three Markers

`<<<<<<<` - Current branch (HEAD/yours) - start of your changes
`=======` - Separator - divides your changes from theirs
`>>>>>>>` - Incoming branch (theirs) - end of their changes


### Powershell

`Select-String -Path "file.php" -Pattern "^<{7}|^={7}|^>{7}"`

### Bash

`grep -E "^<{7}|^={7}|^>{7}" file.php`

