# Local + WPE.WordPress setup

------

## Before you start: 

-You will need admin access to your machine!

-These steps assume you have already cloned the repository to your machine, and that you already have Local installed.

----

### First, create a new site in Local. 

(Example: My Job Benefits 2025)

Instructions from Claude AI:

In Windows, we use the `New-Item` cmdlet with the `-ItemType` SymbolicLink parameter to create symbolic links. 

The syntax is a bit different from Unix-based systems, but the concept is the same - we're creating a reference from one location to another.

Here's how to set it up:

First, let's understand the paths we're working with:

•	Your Local by Flywheel sites are typically located in `C:\Users\[YourUsername]\Local Sites`

•	Let's say your repository is cloned to `C:\Users\[YourUsername]\WPE.WordPress`

Now, here's the PowerShell command to create a symbolic link:

--------------------------------------------------------------------------------------

**(IMPORTANT: You need to run PowerShell as Administrator to create symbolic links!)**

--------------------------------------------------------------------------------------

### First, navigate to your Local site's `public` folder.

NOTE: Use single quotes around paths with spaces! You'll need them because of the 'Local Sites' directory.

`cd 'C:\Users\[YourUsername]\Local Sites\[your-site-name]\app\public'`

### Remove the existing wp-content folder

```powershell
Remove-Item -Path wp-content -Recurse -Force
```

### Create the symbolic link

Again...make sure you are in your Local site's 'public folder'!
'C:\Users\[YourUsername]\Local Sites\[your-site-name]\app\public'

```powershell
New-Item -ItemType SymbolicLink -Path "wp-content" -Target "C:\Users\[YourUsername]\Development\wordpress-sites-repo\[site-folder]\wp-content"
```

Let's break this down:

•	`ItemType SymbolicLink` tells Windows we want to create a symbolic link

•	Path `wp-content` is where we want the link to appear (in your Local site).

•	Target is the actual folder in your repository that we're linking to.

For example, if your username is "John" and you're setting up a site called "company-blog", it would look like this:

### Navigate to the site folder:

`cd 'C:\Users\John\Local Sites\company-blog\app\public' `

### Remove existing wp-content
```powershell
Remove-Item -Path wp-content -Recurse -Force
```
### Create symbolic link

```powershell
New-Item -ItemType SymbolicLink -Path "wp-content" -Target 
"C:\Users\Firstname.Lastname\WPE.WordPress\site-folder\wp-content"
```
To verify the symbolic link was created correctly, you can use:
```powershell
Get-Item wp-content | Select-Object 
```
This will show you details about the symbolic link, including where it's pointing to.

Once the link is set up, you'll want to open and work in the repo folder.

---------

#### Some important things to note:
1.	You need to run PowerShell as Administrator to create symbolic links
2.	Use single quotes around paths with spaces
3.	Make sure all paths are exact - Windows is particular about this!

#### If you get a "permission denied" error, here's how to open PowerShell as Administrator:

1.	Press Windows key
2.	Type "PowerShell"
3.	Right-click on "Windows PowerShell"
4.	Select "Run as administrator"
5.  Enter your admin name and password





