# Guide: Analyzing Merge Conflicts in Git

## Overview

This guide provides methods to investigate merge conflicts and their resolutions in the kiewit theme directory.

---

## Method 1: Find Recent Merge Commits

### List the last 10 merges affecting the kiewit theme:

```powershell
git log --merges --oneline --since="1 month ago" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/ | Select-Object -First 10
```

### Save merge hashes to a file for easier processing:

```powershell
git log --merges --oneline --since="1 month ago" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/ | Select-Object -First 10 | ForEach-Object { $_.Split()[0] }
```

---

## Method 2: Examine Individual Merge Commits

### See which files were changed in a merge:

```powershell
git show <commit-hash> --stat -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

### See the full diff of a merge:

```powershell
git show <commit-hash> -p -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

### View merge with combined diff (shows changes from both parents):

```powershell
git show --cc <commit-hash> -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

---

## Method 3: Detect Conflict Resolutions

### Check if a merge had conflicts by looking for conflict markers:

```powershell
git show <commit-hash> -p | Select-String -Pattern "<<<<<<<|=======|>>>>>>>"
```

### Search merge commit messages for conflict-related keywords:

```powershell
git log --merges --grep="conflict\|resolve\|fix merge" -i --since="1 month ago" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

---

## Method 4: Compare Parent Commits

Every merge has 2+ parent commits. To see what conflicted:

### View the parent commits:

```powershell
git show <merge-commit-hash>
# Look for line: "Merge: <parent1> <parent2>"
```

### Compare what each parent changed to the same file:

```powershell
# Get parent hashes first
git log --pretty=%P -n 1 <merge-commit-hash>

# Compare parent1's version vs parent2's version of a file
git diff <parent1-hash> <parent2-hash> -- path/to/file
```

### See what the merge resolution chose:

```powershell
# Compare the merge result to parent1
git diff <parent1-hash> <merge-commit-hash> -- path/to/file

# Compare the merge result to parent2
git diff <parent2-hash> <merge-commit-hash> -- path/to/file
```

---

## Method 5: Check Reflog for Conflict Resolution Activity

The reflog shows all git operations, including conflict resolutions:

```powershell
# View recent reflog entries
git reflog --since="1 month ago" | Select-String -Pattern "merge|conflict|rebase" -Context 2

# More detailed reflog with dates
git reflog show --all --date=iso | Select-String -Pattern "merge|conflict" -Context 3
```

---

## Method 6: Search for Specific Text Changes (Like "suppress_filters")

### Find commits that added or removed specific text:

```powershell
# Search for changes to specific text
git log -S"suppress_filters" --oneline --since="1 month ago" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/

# Show the actual changes
git log -S"suppress_filters" -p --since="1 month ago" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

### Search commit messages and patches:

```powershell
git log --all --grep="suppress_filters" -p --since="1 month ago" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

---

## Method 7: Automated Analysis of Last 10 Merges

### PowerShell script to analyze multiple merges:

```powershell
# Get last 10 merge commits
$merges = git log --merges --oneline --since="1 month ago" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/ | Select-Object -First 10

# Analyze each merge
foreach ($merge in $merges) {
    $hash = ($merge -split '\s+')[0]
    Write-Host "`n========================================" -ForegroundColor Cyan
    Write-Host "MERGE: $merge" -ForegroundColor Yellow
    Write-Host "========================================" -ForegroundColor Cyan

    # Get parent commits
    $parents = git log --pretty=%P -n 1 $hash
    Write-Host "Parents: $parents`n" -ForegroundColor Green

    # Show files changed
    Write-Host "Files changed:" -ForegroundColor Magenta
    git show $hash --stat --oneline -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/

    # Check for common conflict indicators
    Write-Host "`nChecking for conflict patterns..." -ForegroundColor Magenta
    $conflicts = git show $hash -p -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/ | Select-String -Pattern "<<<<<<<|=======|>>>>>>>" -Context 1
    if ($conflicts) {
        Write-Host "POTENTIAL CONFLICTS FOUND!" -ForegroundColor Red
        $conflicts
    } else {
        Write-Host "No conflict markers found in this merge." -ForegroundColor Green
    }
}
```

---

## Method 8: Interactive Merge Analysis

### Step-by-step for a specific merge:

1. **Identify the merge commit:**

    ```powershell
    git log --merges --oneline -10 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
    ```

2. **Get parent commits:**

    ```powershell
    git show <merge-hash>
    # Note the "Merge: abc123 def456" line
    ```

3. **For each file that changed, compare parents:**

    ```powershell
    # List files changed in merge
    git show <merge-hash> --name-only -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/

    # For a specific file, see what each parent had:
    git show <parent1>:path/to/file > parent1_version.txt
    git show <parent2>:path/to/file > parent2_version.txt
    git show <merge-hash>:path/to/file > merged_version.txt

    # Compare them
    code --diff parent1_version.txt parent2_version.txt
    ```

4. **Check if the merge was a fast-forward or had actual conflicts:**
    ```powershell
    git show --cc <merge-hash>
    # If you see "++" or "--" prefixes, there were differences to merge
    ```

---

## Method 9: Look for Merge Conflicts in Specific Files

### For the search.php file specifically:

```powershell
# Find all commits that touched search.php
git log --oneline -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php | Select-Object -First 20

# Find merges that modified search.php
git log --merges --oneline -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php

# See the evolution of search.php through merges
git log --merges -p -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php
```

---

## Method 10: Using Git's Merge Base

### Find the common ancestor where branches diverged:

```powershell
# For a merge commit, find where the parents diverged
$parents = git log --pretty=%P -n 1 <merge-hash>
$parent1 = ($parents -split ' ')[0]
$parent2 = ($parents -split ' ')[1]

# Find merge base (common ancestor)
git merge-base $parent1 $parent2

# Compare changes from base to each parent
git diff <merge-base>..$parent1 -- path/to/file
git diff <merge-base>..$parent2 -- path/to/file
```

---

## Practical Example: Analyzing Recent Merge (2b242e396)

```powershell
# 1. View the merge
git show 2b242e396 --stat

# 2. Get parents
git log --pretty=%P -n 1 2b242e396
# Result: 058cc83d3 7416a358c

# 3. Compare what each parent changed to search.php
git diff 058cc83d3 7416a358c -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php

# 4. See what the merge chose
git show 2b242e396 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php

# 5. Check if there were differences
git diff 058cc83d3 2b242e396 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php
git diff 7416a358c 2b242e396 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php
```

---

## Tips for Identifying Actual Conflicts

1. **Look for combined diff markers (`++` and `--`):** These indicate changes from both parents
2. **Search reflog:** Conflict resolutions often leave traces in reflog
3. **Check file sizes:** Large changes in CSS files might indicate conflict resolution artifacts
4. **Look for duplicate code:** Sometimes conflicts leave duplicate functions or blocks
5. **Examine commit messages:** Developers often mention conflicts in commit messages
6. **Check timestamps:** Multiple commits close together might indicate conflict resolution iterations

---

## Common Conflict Patterns in WordPress/PHP

-   **Function redeclaration:** Same function defined in both branches
-   **Different implementations:** Same feature implemented differently
-   **Formatting conflicts:** Different indentation or code style
-   **Dependency conflicts:** Different versions of includes/requires
-   **CSS conflicts:** Same selectors with different properties (common in style.css)

---

## Automation Script: Full Merge History Analysis

Save this as `analyze-merges.ps1`:

```powershell
param(
    [int]$Count = 10,
    [string]$Path = "kiewitv2dev.wpengine.com/wp-content/themes/kiewit/",
    [string]$Since = "1 month ago"
)

$merges = git log --merges --format="%H|%s|%P" --since=$Since -- $Path | Select-Object -First $Count

Write-Host "`n╔═══════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║   MERGE CONFLICT ANALYSIS - Last $Count Merges              ║" -ForegroundColor Cyan
Write-Host "╚═══════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

$i = 1
foreach ($merge in $merges) {
    $parts = $merge -split '\|'
    $hash = $parts[0]
    $subject = $parts[1]
    $parents = $parts[2] -split ' '

    Write-Host "[$i/$Count] " -NoNewline -ForegroundColor Yellow
    Write-Host "Merge: " -NoNewline -ForegroundColor White
    Write-Host $hash.Substring(0,9) -ForegroundColor Cyan
    Write-Host "      $subject" -ForegroundColor Gray
    Write-Host "      Parents: " -NoNewline -ForegroundColor White
    Write-Host $parents[0].Substring(0,9) -NoNewline -ForegroundColor Green
    Write-Host " + " -NoNewline
    Write-Host $parents[1].Substring(0,9) -ForegroundColor Green

    # Check for conflicts
    $filesChanged = git diff --name-only $parents[0] $parents[1] -- $Path
    $conflictCount = ($filesChanged | Measure-Object).Count

    if ($conflictCount -gt 0) {
        Write-Host "      Potential conflicts in $conflictCount file(s):" -ForegroundColor Yellow
        $filesChanged | ForEach-Object {
            $file = $_
            $shortPath = $file -replace '.*themes/kiewit/', 'kiewit/'

            # Check if merge resolution differs from both parents
            $diffParent1 = git diff $parents[0] $hash -- $file 2>$null
            $diffParent2 = git diff $parents[1] $hash -- $file 2>$null

            if ($diffParent1 -and $diffParent2) {
                Write-Host "        ⚠️  " -NoNewline -ForegroundColor Red
                Write-Host $shortPath -ForegroundColor Red
            } else {
                Write-Host "        ✓  " -NoNewline -ForegroundColor Green
                Write-Host $shortPath -ForegroundColor Gray
            }
        }
    } else {
        Write-Host "      ✓ Fast-forward merge (no conflicts)" -ForegroundColor Green
    }

    Write-Host ""
    $i++
}

Write-Host "═══════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "Analysis complete!" -ForegroundColor Green
```

Run it with:

```powershell
.\analyze-merges.ps1 -Count 10
```

---

## Quick Reference Commands

```powershell
# Last 10 merges in kiewit theme
git log --merges --oneline -10 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/

# Find merges with specific text changes
git log --merges -S"suppress_filters" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/

# Show merge with both parent diffs
git show --cc <merge-hash>

# Get merge parents
git log --pretty=%P -n 1 <merge-hash>

# Compare parents
git diff <parent1> <parent2> -- path/to/file

# Check reflog for conflict resolutions
git reflog | Select-String -Pattern "merge|conflict"
```

---

## Notes

-   Merge commits in Git have 2+ parent commits
-   A "clean" merge means git auto-resolved everything
-   Conflicts show up in reflog but not in the final commit
-   Use `--cc` flag to see combined diff from all parents
-   The `-S` flag searches for text additions/removals (pickaxe search)
-   PowerShell's `Select-String` is like grep but Windows-friendly
