# SSH

(Note: this doc is a work in progress.)

Sources
https://wpengine.com/support/ssh-keys-for-shell-access/?_gl=1*8zbgep*_gcl_au*MTY5NjIxNzk4OC4xNzE5OTU5OTcz*_ga*MTYzMDkwMTY4MS4xNzEwNzgzMTk1*_ga_QQ5FN8NX8W*MTcyNDg1MDYxOS4xMzEuMS4xNzI0ODUzOTI5LjYwLjAuMTQ0ODA2OTk2#Check_Local_Machine_for_Existing_SSH_Key

The command to SSH into a site's environment on WP Engine is simple, but takes some set up to be able to use.

The command is:

```shell
ssh environment@environment.ssh.wpengine.net
```

You'd swap out the words "environment" in both spots with the slug of your environment.

(You also can get the login string on the environment's overview page on WP Engine.)

EXAMPLES:

So if you want to get into the development environment for brand.com:

```shell
ssh branddev@branddev.ssh.wpengine.net
```

Another example: the development environment for Mammoth is "mammoth1dev" so:

```shell
ssh mammoth1dev@mammoth1dev.ssh.wpengine.net
```

### Important: To get started, create or make sure you have a ".ssh" directory in your User root.
(C:\Users\Chris.Hegarty\.ssh)

Open the terminal and type:

```shell

ssh-keygen -t ed25519 -f C:\Users\YourUsername\.ssh\wpengine_ed25519

```
### EXPLANATION:

The line of code ```ssh-keygen -t ed25519 -f ~/.ssh/wpengine_ed25519``` is used to generate a new SSH key pair. 

Here's a breakdown of what each part of the command does:

**ssh-keygen:** This is the command used to generate, manage, and convert authentication keys for SSH.

**-t ed25519**: This option specifies the type of key to create. In this case, it is using the Ed25519 algorithm, which is known for its security and performance.

**-f ~/.ssh/wpengine_ed25519**: This option specifies the file name and location where the generated key pair will be stored. 
The ~/.ssh/ directory is a common location for storing SSH keys, and wpengine_ed25519 is the name of the key file.
So, this command generates an Ed25519 SSH key pair and saves it in the ~/.ssh/ directory with the file name wpengine_ed25519.

## Add the key to WP Engine

You need to add the contents of the key in your WP Engine profile: https://my.wpengine.com/profile/ssh_keys

To get the contents, either
-Open the file in VS Code or whatever your IDE is and copy everything
-Run this command. You may need to type in the full path if the tilde doesnt work:

```shell
cat ~/.ssh/wpengine_ed25519.pub
```

## Make a Config file

Once that is in place, create your config file. Change directories into your .ssh directory:

(Note: you may have to type out the full path)

Within that directory, you will need a config file.

```shell
touch config

```

Paste this in, swapping out your own info inthe "IdentityFile" line:

```shell

Host *
ControlPath C:\Users\Chris.Hegarty\.ssh\socket-%C
ControlMaster auto
ControlPersist 10m

Host *.ssh.wpengine.net
IdentityFile ~/.ssh/wpengine_ed25519
IdentitiesOnly yes

```

### Troubleshooting

It sounds like there might be an issue with the path to the `.ssh` directory. Let's make sure the directory exists and is correctly referenced. You can try the following steps:

1. **Check if the `.ssh` directory exists**:
   Open PowerShell and run:
   ```powershell
   Test-Path ~/.ssh
   ```
   This command will return `True` if the directory exists and `False` if it doesn't.

2. **Create the `.ssh` directory if it doesn't exist**:
   If the directory doesn't exist, you can create it by running:
   ```powershell
   mkdir ~/.ssh
   ```

3. **Run the `ssh-keygen` command again**:
   Once the directory is confirmed to exist, try running the `ssh-keygen` command again:
   ```powershell
   ssh-keygen -t ed25519 -f ~/.ssh/wpengine_ed25519
   ```

## Start using WP-CLI







