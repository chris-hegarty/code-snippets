# WordPress Theme Comparison & Consolidation Guide
## Using GitHub Copilot Plan Mode with Claude Sonnet 4.6
### For WPE.WordPress Mono Repo — New Site Theme Planning

---

## Overview

This guide covers a phased approach to comparing six WordPress themes across
the WPE.WordPress mono repo, using the `ktg-builder` theme as a baseline,
and producing consolidated starter code for a new site.

**You are the original author of these themes.** Use that knowledge actively
throughout — correct Copilot when it misreads intent, and flag patterns you
know were deliberate decisions vs. accumulated drift.

---

## Before You Start Any Session

### VS Code Setup
- Open the **WPE.WordPress mono repo root** as your workspace
- Model: **Claude Sonnet 4.6**
- Mode: **Plan** (you are reading and synthesizing, not executing changes)
- Allow the workspace index to finish building before sending queries

### Know Your Paths
Because this is a large mono repo, always use **explicit directory paths**
in every query. Never refer to "the ktg-builder theme" without its path.

Find and record your six site paths before starting:
```
[site-directory]/wp-content/themes/[theme-name]
```

Fill these in before your first session:

| Site Directory | Theme Name | Notes |
|---|---|---|
| | ktg-builder | Baseline — your improvements |
| | ktg-builder | Baseline — your improvements |
| | | |
| | | |
| | | |
| | | |

### A Note on ACF JSON
Trust the `acf-json` files in each theme directory as the source of truth
for field group definitions. Database-stored fields from older sites are a
known gap — do not chase them. The goal is a clean JSON-first new site.

---

## Phase 1 — Establish the ktg-builder Baseline

**Goal:** Build a complete picture of your best starting point before any
comparison begins.

**Do this once.** Save the full output — you will reference it in every
subsequent session.

### Session Setup
```
@workspace I am beginning a multi-phase WordPress theme comparison across 
this mono repo. My baseline theme is ktg-builder, located at:

[site-directory]/wp-content/themes/ktg-builder

I am the original author of this theme. Before any comparison work, please 
give me a thorough inventory of this theme covering:

1. Directory and file structure — list every file and what it does
2. How functions.php is organized and what it registers
3. Key template files and what each handles
4. All custom PHP patterns, helper functions, and abstractions
5. How JavaScript is organized, enqueued, and structured
6. The acf-json directory — list every field group file, its name, 
   and what fields it defines
7. Any patterns you can identify as deliberate architectural decisions
   vs. things that look like they may have accumulated over time

Please reference actual file paths and function names throughout. Be thorough
— this inventory will be my baseline for comparing five other themes.
```

### Follow-Up Questions to Ask in Phase 1
After the initial inventory, probe deeper before moving on:

```
@workspace Looking at the ktg-builder theme at [path], are there any 
areas where the code organization seems inconsistent or where the same 
concern is handled in more than one place?
```

```
@workspace In the ktg-builder theme at [path], how does the theme 
handle the relationship between PHP template logic and JavaScript? 
Are there any data-passing patterns (wp_localize_script, inline JSON, 
data attributes) I should be aware of?
```

```
@workspace Looking at the acf-json files in [path]/acf-json, can you 
identify any field groups that appear to be site-specific vs. ones that 
look like they should be shared infrastructure for any site using 
this theme?
```

### What to Save from Phase 1
Copy the full output into a local notes file:
```
theme-comparison-notes/
  phase-1-ktg-builder-baseline.md
```
You will paste this into the Phase 3 synthesis session.

---

## Phase 2 — Compare Each Theme Against the Baseline

**Goal:** For each of the five remaining themes, produce a structured
diff against ktg-builder — capturing what each theme has added, changed,
or handled differently.

**Run one session per theme.** Do not try to compare multiple themes
in one session — the context window will not hold reliably across all of
them simultaneously.

### Session Template — Run for Each of the Five Themes

Replace `[SITE PATH]` and `[THEME NAME]` for each session:

```
@workspace I am comparing WordPress themes in this mono repo against 
a ktg-builder baseline.

The theme I am analyzing today is [THEME NAME], located at:
[SITE PATH]/wp-content/themes/[THEME NAME]

My ktg-builder baseline is at:
[BASELINE SITE PATH]/wp-content/themes/ktg-builder

Please compare [THEME NAME] against ktg-builder and give me:

1. ADDITIONS — What exists in [THEME NAME] that ktg-builder does NOT have.
   Include new template files, new functions, new PHP patterns, new JS 
   behavior, and new ACF field groups. For each addition, note whether it 
   looks like a deliberate improvement or a site-specific customization.

2. DIFFERENCES — Where [THEME NAME] handles something differently than 
   ktg-builder. Show me both approaches and note which appears stronger.

3. REGRESSIONS — Anything in ktg-builder that [THEME NAME] appears to 
   have removed, simplified away, or broken from the original pattern.

4. ACF JSON — Compare the acf-json directories of both themes. What field 
   groups exist in [THEME NAME] that are not in ktg-builder? What is 
   missing? Are any field groups clearly evolved versions of ktg-builder 
   equivalents?

5. JAVASCRIPT — Any meaningful differences in how JS is organized, 
   enqueued, or structured compared to ktg-builder.

6. YOUR ASSESSMENT — Which patterns from [THEME NAME] are clearly worth 
   carrying forward into a new consolidated theme?

Please reference actual file paths and function names. Be specific — I need 
to capture every meaningful difference, not just a high-level summary.
```

### Follow-Up Questions for Each Theme Session

```
@workspace In [THEME NAME] at [path], are there any customizations that 
look like they were added to work around a limitation in the original 
ktg-builder theme, rather than as a deliberate feature addition?
```

```
@workspace Looking at the ACF field groups in [THEME NAME] at [path]/acf-json,
are there any that look like they evolved from a ktg-builder field group 
rather than being net-new? If so, which version appears more complete?
```

### What to Save from Each Phase 2 Session
```
theme-comparison-notes/
  phase-2-[theme-name]-vs-ktg-builder.md
```

---

## Phase 3 — Synthesize Into a Consolidated Recommendation

**Goal:** Take everything from Phases 1 and 2 and produce a clear
recommendation for the new theme's structure, patterns, and ACF strategy.

**This session uses your saved notes, not @workspace directly.**
Paste your Phase 1 and Phase 2 outputs into the chat rather than
relying on Copilot to re-read the mono repo. This gives you a reliable,
controlled context for the synthesis.

### Session Prompt

```
I have completed a structured comparison of six WordPress themes from our 
mono repo. Below are my comparison notes from each phase. Please read 
through all of them before responding.

I am the original author of the ktg-builder baseline theme. I need you to 
synthesize these findings into a consolidated recommendation for a new 
WordPress theme that represents the best of what exists across all six.

--- PHASE 1: BASELINE INVENTORY ---
[paste phase-1-ktg-builder-baseline.md contents here]

--- PHASE 2: THEME COMPARISONS ---
[paste each phase-2-[theme-name].md contents here, one after another]

---

Based on all of the above, please provide:

1. RECOMMENDED FILE STRUCTURE — The directory and file layout for the 
   new consolidated theme. Note which files come from which source theme 
   and why.

2. FUNCTIONS.PHP ARCHITECTURE — How should functions.php be organized 
   in the new theme? Should it stay as one file or be split into includes?
   What should it register and in what order?

3. PHP PATTERNS TO CARRY FORWARD — The specific PHP approaches, helper 
   functions, and abstractions from across the six themes that should be 
   included in the new theme, and which source theme each comes from.

4. JAVASCRIPT STRATEGY — How should JS be organized and enqueued in the 
   new theme, based on the best patterns seen across the six?

5. ACF JSON STRATEGY — A recommended set of field groups for the new theme.
   For each field group: which source theme it comes from (or if it is a 
   consolidation of multiple), what it should contain, and how the acf-json 
   directory should be structured.

6. WHAT TO LEAVE BEHIND — Patterns, customizations, or files from the six 
   themes that should NOT be carried forward, and why.

7. NEW BEST PRACTICES — Anything we should introduce in the new theme that 
   none of the six currently implement cleanly. Focus on WordPress and 
   ACF best practices.

Please present this as a structured recommendation I can review with my 
team before any code is written.
```

### What to Save from Phase 3
```
theme-comparison-notes/
  phase-3-consolidated-recommendation.md
```

---

## Phase 4 — Generate the Starter Code

**Goal:** Turn the Phase 3 recommendation into actual starter files
for the new theme, reviewed and approved piece by piece.

**Do not generate everything at once.** Review and approve each piece
before moving to the next. This keeps you in control and prevents
Copilot from making assumptions that compound across files.

### Session Start
```
Based on the consolidated recommendation we just produced, I am ready 
to begin generating starter code for the new theme.

Please start with the directory structure only — list every file and 
folder we will create, with a one-line description of each file's purpose.

Do not generate any file contents yet. I want to review and approve the 
full structure before we write any code.
```

### Recommended Generation Order
After approving the structure, work through files in this order:

1. **`functions.php` scaffold** — organization and includes only, no full
   implementation yet
2. **`acf-json/` directory** — consolidated field group JSON files first,
   since everything else may depend on them
3. **Core template files** — `index.php`, `header.php`, `footer.php`,
   `page.php`, `single.php`
4. **Custom template parts** — whatever the consolidation recommendation
   identified
5. **JavaScript** — enqueue setup first, then individual JS files
6. **`style.css`** — theme registration header and base styles

### For Each File Generation Step
```
Please generate [filename] based on our consolidated recommendation.
After generating this file, stop and wait for my review before 
moving to the next file.

Remind me at the end of each file what the next suggested file is.
```

### ACF JSON Generation Prompt
```
Please generate the acf-json field group files for the new theme based 
on the ACF strategy in our consolidated recommendation.

For each field group file:
- Use the correct ACF JSON format
- Set the "modified" timestamp to today's date
- Include only fields that were identified in our recommendation
- Name each file using ACF's standard naming convention

Generate one field group file at a time and wait for my approval.
```

---

## Handling ACF JSON in the New Site

Because ACF sync issues have been a persistent problem across every project
in this repo, follow these steps when setting up the new site.

### Setup Checklist for New Site ACF JSON
- [ ] Create `wp-content/themes/[new-theme]/acf-json/` directory before
  activating the theme
- [ ] Confirm ACF PRO is installed and activated on the new local site
- [ ] In WordPress Admin → Custom Fields → Tools, confirm the load and
  save points are set to the theme's `acf-json` directory
- [ ] After importing or activating field groups, immediately verify files
  appeared in `acf-json/` — do not assume they saved
- [ ] Add a `wp-config.php` constant to make sync behavior explicit:

```php
// Force ACF to load from JSON — add to wp-config.php
define( 'ACF_FIELD_GROUP_STORE', 'json' );
```

### ACF JSON Copilot Prompt — New Site Audit
Run this at the start of any ACF work on the new site:

```
@workspace Looking at the new theme at [path]/acf-json, please confirm:
1. Which field groups are present as JSON files
2. Whether the JSON files appear valid and complete
3. Whether there are any field group keys that appear duplicated or 
   that may indicate a database/JSON sync conflict
```

---

## Notes Directory Structure

Create this in a location outside the mono repo (or in a personal notes
repo) to keep your comparison work organized:

```
theme-comparison-notes/
  phase-1-ktg-builder-baseline.md
  phase-2-[theme-name-1]-vs-ktg-builder.md
  phase-2-[theme-name-2]-vs-ktg-builder.md
  phase-2-[theme-name-3]-vs-ktg-builder.md
  phase-2-[theme-name-4]-vs-ktg-builder.md
  phase-2-[theme-name-5]-vs-ktg-builder.md
  phase-3-consolidated-recommendation.md
  phase-4-approved-file-structure.md
```

---

## Quick Reference — Full Phase Checklist

### Phase 1 — Baseline
- [ ] Explicit path confirmed for both ktg-builder sites
- [ ] Full baseline inventory completed
- [ ] Follow-up questions on ACF JSON asked
- [ ] Output saved to `phase-1-ktg-builder-baseline.md`

### Phase 2 — Comparisons (repeat for each of five themes)
- [ ] Theme 1 compared and saved
- [ ] Theme 2 compared and saved
- [ ] Theme 3 compared and saved
- [ ] Theme 4 compared and saved
- [ ] Theme 5 compared and saved

### Phase 3 — Synthesis
- [ ] All Phase 1 and Phase 2 notes pasted into session
- [ ] Consolidated recommendation produced
- [ ] Recommendation reviewed and approved
- [ ] Output saved to `phase-3-consolidated-recommendation.md`

### Phase 4 — Starter Code
- [ ] Directory structure approved before any code generated
- [ ] functions.php scaffold approved
- [ ] acf-json field groups generated and verified
- [ ] Core template files generated one at a time
- [ ] JavaScript enqueue setup approved
- [ ] New site ACF JSON checklist completed

---

## A Note on the Retroactive Plan

Once the new site is running cleanly with consolidated patterns and solid
ACF JSON, that theme becomes the de facto new baseline for the other sites
in the repo. When your company resolves the Cursor/model cost situation,
the Phase 2 comparison notes you saved will already be the foundation for
planning those retroactive improvements — you will not need to redo the
comparison work.

---