# Quick Guide: How to Investigate Merge Conflicts

## Summary of Your Situation

Based on my analysis of your repository, here's what I found regarding `suppress_filters`:

### The Story:

1. **Commit 9bcee82e1** (Nov 13, 2025) - Brad added `suppress_filters` to search.php
2. **Commit b0f43b016** (Nov 14, 2025) - Chris removed it during refactoring
3. **Currently**: The code still has `suppress_filters` (from earlier merges)

### Last 10 Merges in kiewit theme:

All 10 merges in the past month had file differences (potential conflicts):

-   Merge 2edf3e587: 23 files changed
-   Merge 537a301da: 21 files changed
-   Merge 6ccc7d370: 17 files changed
-   (See full list in analysis above)

---

## 5-Minute Quick Investigation

### Step 1: List Recent Merges

```powershell
git log --merges --oneline --since="1 month ago" -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/ | Select-Object -First 10
```

### Step 2: Pick a Merge to Investigate

```powershell
# Get parent commits for merge 2edf3e587
git show 2edf3e587 | Select-Object -First 15
# Look for the "Merge: parent1 parent2" line
```

### Step 3: See What Files Differed Between Parents

```powershell
git diff --name-only dbda58608 a72560bc8 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

### Step 4: Check a Specific File for Conflicts

```powershell
# Compare what each parent had for search.php
git diff dbda58608 a72560bc8 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php
```

### Step 5: See How the Conflict Was Resolved

```powershell
# Show the final merged version
git show 2edf3e587:kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php
```

---

## Detailed Investigation Methods

### Method A: Automated Scan

Use the included PowerShell script:

```powershell
# Run the analysis (already in your repo root)
& .\analyze-merges.ps1 -Count 10
```

### Method B: Manual Deep Dive

#### Find a merge:

```powershell
git log --merges --oneline -10 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

#### For merge hash XXXXXXXXX:

1. **Get parent commits:**

    ```powershell
    git log --pretty=%P -n 1 XXXXXXXXX
    # Returns: PARENT1 PARENT2
    ```

2. **Compare parents for a specific file:**

    ```powershell
    git diff PARENT1 PARENT2 -- path/to/file.php
    ```

3. **See what the merge chose:**

    ```powershell
    # Compare merge result to parent1
    git diff PARENT1 XXXXXXXXX -- path/to/file.php

    # Compare merge result to parent2
    git diff PARENT2 XXXXXXXXX -- path/to/file.php
    ```

4. **If both diffs show changes, there was a conflict!**

### Method C: Search for Specific Text Changes

#### Find when "suppress_filters" was added/removed:

```powershell
git log -S"suppress_filters" --oneline -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/
```

#### See the actual changes:

```powershell
git log -S"suppress_filters" -p -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php
```

---

## Real Example: Investigating Merge 2edf3e587

This merge had 23 files with differences, including search.php.

```powershell
# 1. Get parents
git show 2edf3e587 | Select-Object -First 15
# Result: Merge: dbda58608 a72560bc8

# 2. Check if parents had different versions of search.php
git diff dbda58608 a72560bc8 -- kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php

# 3. See which parent had suppress_filters
git show dbda58608:kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php | Select-String "suppress_filters"
# Result: (empty - didn't have it)

git show a72560bc8:kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php | Select-String "suppress_filters"
# Result: Found 2 lines with suppress_filters

# 4. Check what the merge kept
git show 2edf3e587:kiewitv2dev.wpengine.com/wp-content/themes/kiewit/search.php | Select-String "suppress_filters"
# Result: Kept the suppress_filters from parent2
```

**Conclusion:** The merge took parent2's version which had `suppress_filters`.

---

## Quick Reference Commands

| Task              | Command                                            |
| ----------------- | -------------------------------------------------- |
| Last 10 merges    | `git log --merges --oneline -10 -- path/to/theme/` |
| Get merge parents | `git log --pretty=%P -n 1 MERGE_HASH`              |
| Compare parents   | `git diff PARENT1 PARENT2 -- path/to/file`         |
| Show merge result | `git show MERGE_HASH:path/to/file`                 |
| Find text changes | `git log -S"text" -p -- path/to/file`              |
| Reflog history    | `git reflog \| Select-String "merge"`              |

---

## Understanding the Output

### When comparing parents (`git diff PARENT1 PARENT2`):

-   **Lines with `-`**: What parent1 had
-   **Lines with `+`**: What parent2 had
-   **Different = potential conflict**

### When both these show changes:

```powershell
git diff PARENT1 MERGE -- file.php  # Shows changes
git diff PARENT2 MERGE -- file.php  # Also shows changes
```

**= Manual conflict resolution occurred!**

### If only one shows changes:

**= Merge took the other parent's version (no conflict)**

---

## Tips

1. **Large CSS changes** often indicate conflicts (regenerated styles)
2. **Check reflog** for conflict markers in commit history
3. **ACF JSON files** frequently conflict (field group syncs)
4. **Search for specific patterns** like function names or variables
5. **Use Visual Studio Code** to diff files side-by-side

---

## Your Specific Case: suppress_filters

### Timeline Discovered:

```
9bcee82e1 (Nov 13) → Added suppress_filters
  ↓
2edf3e587 (Merge)  → Kept suppress_filters
  ↓
b0f43b016 (Nov 14) → Removed suppress_filters (refactor)
  ↓
Current state      → Still has suppress_filters
```

### Why it's still there:

The refactored version (b0f43b016) that removed it may be on a feature branch not yet merged to the main development branch.

### To check:

```powershell
git branch --contains b0f43b016
git branch --contains 9bcee82e1
```

---

## Next Steps

1. Review the markdown guide: `MERGE_CONFLICT_ANALYSIS_GUIDE.md`
2. Run the script: `.\analyze-merges.ps1`
3. Pick a merge and investigate using the methods above
4. Check if the refactored code needs to be merged
