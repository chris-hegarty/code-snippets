# Powershell notes

## Symbolic Links

Need to be running as admin to create sym links.

"cd" works the same.

to "ls", use the command "Get-ChildItem"

pwd - Get-Location

Need to use the "New-Item" command with -ItemType SymbolicLink parameter.

Change directories to your Local site. (cd apparently works for this.)

Remove the existing wp-content folder:

```powershell

Remove-Item -Path wp-content -Recurse -Force

```

Create the sym link:

```powershell

New-Item -ItemType SymbolicLink -Path "wp-content" -Target "C:\Users\Chris.Hegarty\WPE.WordPress\[site]\wp-content"

```



