# Using @workspace Effectively in GitHub Copilot Plan Mode
## For WordPress Projects with Custom PHP, JavaScript, and APIs

---

## What @workspace Does

`@workspace` tells GitHub Copilot to index and reason across your **entire
repo** rather than just the file you have open. For a WordPress project with
custom PHP, JS, and APIs spread across multiple files and directories, this
is essential before planning any refactoring work.

Without it, Copilot only sees the current file.
With it, Copilot can trace hooks, filters, API calls, and dependencies across
the whole codebase before making recommendations.

---

## Before You Start a Session

### 1. Open the repo root in VS Code
Make sure VS Code has opened the **repository root folder** — not a subfolder.
Copilot's workspace index is built from whatever folder VS Code has open.

```
File → Open Folder → [your repo root]
```

### 2. Select your model
In the Copilot Chat panel:
- Click the model picker dropdown
- Select **Claude Sonnet 4.6**
- Confirm you are in **Plan** mode (not Ask or Edit)

### 3. Let the workspace index build
On first open, VS Code indexes your files in the background. Give it a minute
before sending large @workspace queries. You will see indexing activity in the
status bar.

---

## How to Use @workspace in Plan Mode

Always lead with `@workspace` when your question touches more than one file,
or when you need Copilot to understand structure before planning.

### Opening a Session — Establish Context First

Start every planning session with a broad orientation query before asking
Copilot to plan anything:

```
@workspace Before we plan any work, I want to make sure you have full context
of this codebase. Can you give me an overview of:
1. The overall directory structure and how it is organized
2. Where the custom PHP logic lives vs. core WordPress files
3. How JavaScript is loaded and structured
4. Where API integrations are defined and called
5. Any patterns you notice that will be relevant to refactoring work
```

This primes Copilot's context window with your codebase before you ask it
to make any recommendations.

---

## Useful @workspace Query Patterns for WordPress Refactoring

### Understanding custom hooks and filters
```
@workspace Can you map out all the custom add_action and add_filter calls in
this project? Where are they registered, and what do they connect to?
```

### Tracing a specific feature end to end
```
@workspace I need to refactor [feature name]. Can you trace everything involved
— the PHP that handles it, any JavaScript that calls it, and any API endpoints
it touches — before we make a plan?
```

### Identifying API integration points
```
@workspace Where are all the external API calls made in this codebase? Can you
list the endpoints, where they are called from, and what handles the responses?
```

### Finding refactoring candidates
```
@workspace Looking at the custom PHP in this project, can you identify areas
that are candidates for refactoring — things like duplicated logic, functions
doing too much, or patterns that don't follow WordPress best practices?
```

### Understanding JavaScript dependencies and structure
```
@workspace How is JavaScript organized in this project? Are scripts enqueued
via wp_enqueue_script, loaded manually, or both? Where does custom JS live
and how does it interact with the PHP layer?
```

### Asking best-practice questions grounded in your actual code
```
@workspace Given how this project is currently structured, what would a
best-practice refactoring approach look like for the custom PHP layer?
Please reference actual files and patterns you see in this codebase, not
just general WordPress advice.
```

---

## Moving from Plan Mode to Agent Mode

Once you have a plan you are satisfied with:

1. **Do not start a new chat.** Stay in the same session to preserve context.
2. Switch the mode selector from **Plan** to **Agent**.
3. Say something like:

```
The plan looks good. Please begin with Step 1. Make only the changes outlined
in the plan — do not refactor anything we have not discussed.
```

4. Review each change before approving the next step.
5. If Copilot drifts from the plan, say:

```
Stop. That is outside the scope of our plan. Please revert to only what we
agreed on in Step [X].
```

---

## Tips for Your Specific Situation

### For filling knowledge gaps before planning
You mentioned needing back-and-forth to fill in your own knowledge gaps before
committing to a plan. Use this pattern:

```
@workspace I have been given the following direction for this project:
[paste your directions here]

Before we create a plan, I have some questions about how this codebase
currently handles this area. Can you walk me through what exists today
and ask me any clarifying questions that would help us build a solid plan?
```

This puts Copilot in a questioning/teaching mode rather than immediately
jumping to implementation.

### For producing a plan you can share with your team
Once the back-and-forth is done, ask explicitly:

```
@workspace Based on everything we have discussed, please produce a written
implementation plan I can review and share. It should include:
- What we are changing and why
- The steps in order
- Which files will be affected
- Any risks or dependencies to be aware of
- What best practices this approach follows

Do not begin any implementation until I confirm the plan is approved.
```

### Keeping Copilot grounded in your actual codebase
If Copilot starts giving generic WordPress advice instead of advice specific
to your repo, redirect it:

```
Please base your answer on what you actually see in this codebase using
@workspace, not on general WordPress patterns. Reference specific files
and functions where possible.
```

---

## What @workspace Cannot Do — Know the Limits

| Limitation | What to do about it |
|---|---|
| It does not read binary files (.png, .mo, .po) | No action needed — these are not relevant to refactoring |
| Very large files may be partially indexed | Open the specific file directly so it is fully in context |
| It may miss deeply nested or unusual file locations | Explicitly reference files with their path in your prompt |
| Context can drift in a long session | Start a fresh session for a new feature or major topic |
| It does not retain memory between sessions | Start each session with the orientation query above |

---

## Quick Reference — Session Checklist

- [ ] VS Code opened at repo root
- [ ] Model set to Claude Sonnet 4.6
- [ ] Mode set to Plan
- [ ] Orientation query sent before any planning begins
- [ ] Directions from management pasted into context
- [ ] Back-and-forth Q&A complete](#)
