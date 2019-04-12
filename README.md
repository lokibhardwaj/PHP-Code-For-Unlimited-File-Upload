# Introduction

Welcome to the official s42transfer project, an [Open-Source software](https://en.wikipedia.org/wiki/Open-source_software).

s42transfer is a web site permitting to upload mulitple files in a simple way and give unique links with compressed files along with multiple email sharing functionality.

A demonstration of the latest version is available on [demo.s42.io](http://demo.s42.io/)


![Screenshot1](http://demo.s42.io/screeshot/mainscreen.png)

**Main features**:
-  Multiple upload with drag & drop option => single and collective download links with multiple email sharing functionality & One delete link for single/multiple files
-  Share any large mulitple files (thanks to HTML5)
-  No database, only use basic PHP
-  Shows progression: speed, percentage and remaining upload time
-  Preview content in browser (if possible)
-  Optional Password protection (for uploading or downloading)
-  Options for plain file download and zip file download
-  Time limitation
-  Option to self-destruct after reading
-  Simple language support :en
-  Small administration interface to control theme, file upload limit, multiple email sharing feature, download option settings and other basic settings.
-  File level [Deduplication](http://en.wikipedia.org/wiki/Data_deduplication) for storage optimization
-  A basic Terms Of Service which can be adapted to your needs
-  Shortened URLs using base 64 encoding
-  API interface
-  Optional data encryption
-  Skin
...

s42transfer is a fork of the original project [Jirafeau version 1.0](https://gitlab.com/mojo42/Jirafeau) with a lot of modifications.

As it's original project, s42transfer is made in the [KISS](http://en.wikipedia.org/wiki/KISS_principle) way (Keep It Simple, Stupid).

s42transfer project won't evolve to a file manager and will focus to keep a very few dependencies.

# Screenshots

Here are some screenshots:
- [Installation part 1](http://demo.s42.io/screeshot/Installation_part_1.png)
- [Installation part 2](http://demo.s42.io/screeshot/Installation_part_2.png)
- [Installation part 3](http://demo.s42.io/screeshot/Installation_part_3.png)
- [Installation part 4](http://demo.s42.io/screeshot/Installation_part_4.png)
- [Installation part 5](http://demo.s42.io/screeshot/Installation_part_5.png)
- [Upload 1](http://demo.s42.io/screeshot/login.png)
- [Upload 2](http://demo.s42.io/screeshot/upload1.png)
- [Upload 3](http://demo.s42.io/screeshot/upload2.png)
- [Upload 4](http://demo.s42.io/screeshot/upload3.png)
- [Upload 5](http://demo.s42.io/screeshot/upload4.png) 
- [Admin 1](http://demo.s42.io/screeshot/upload_admin1.png)
- [Admin 2](http://demo.s42.io/screeshot/upload_admin2.png)
- [Admin 3](http://demo.s42.io/screeshot/upload_admin3.png)
- [Admin 4](http://demo.s42.io/screeshot/upload_admin4.png)
- [Admin 5](http://demo.s42.io/screeshot/upload_admin5.png)

# Installation
-  [Download](https://gitlab.com/jensche/s42transfer/repository/archive.zip) the last version of s42transfer from GitLab
-  Upload files on your web server
-  Don't forget to set owner of uploaded files if you need to
-  Get your web browser and go to you install location (e.g. ```http://your-web-site.org/s42transfer/```) and follow instructions
-  Some options are not configured from the minimal installation wizard, you may take a look at option documentation in ```lib/config.original.php``` and customize your ```lib/config.local.php```

Note that ```lib/config.local.php``` is auto-generated during the installation.

If you don't want to go through the installation wizard, you can just copy ```config.original.php``` to ```config.local.php``` and customize it.

# Security

```var``` directory contain all files and links. It is randomly named to limit access but you may add better protection to prevent un-authorized access to it.
You have several options:
- Configure a ```.htaccess```
- Move var folder to a place on your server which can't be directly accessed
- Disable automatic listing on your web server config or place a index.html in var's sub-directory (this is a limited solution)

If you are using Apache, you can add the following lineto your configuration to prevent people to access to your ```var``` folder:

```RedirectMatch 301 ^/var-.* http://my.service.s42transfer ```

You should also remove un-necessessary write access once the installation is done (ex: configuration file).
An other obvious basic security is to let access users to the site by HTTPS.

# Few notes about server side encryption

Data encryption can be activated in options. This feature makes the server encrypt data and send the decryt key to the user (inside download URL).
The decrypt key is not stored on the server so if you loose an url, you won't be able to retrieve file content.
In case of security troubles on the server, attacker won't be able to access files.

By activating this feature, you have to be aware of few things:
-  Data encryption has a cost (cpu) and it takes more time for downloads to complete once file sent.
-  During the download, the server will decrypt on the fly (and use resource).
-  This feature needs to have the mcrypt php module.
-  File de-duplication will stop to work (as we can't compare two encrypted files).
-  Be sure your server do not log client's requests.
-  Don't forget to enable https.

In a next step, encryption will be made by the client (in javascript), see issue #10.

# FAQ

### How do I upgrade my s42transfer ?

If you have installed s42transfer using git, it's pretty simple: just make a git pull and chown/chmod files who have the owner changed.

If you have installed s42transfer just by uploading files on your server, you can take the [last version](https://gitlab.com/jensche/s42transfer/repository/archive.zip), overwrite files and chown/chmod files if needed.

After upgrading, you can compare your ```lib/config.local.php``` and ```lib/config.original.php``` to see if new configuration items are available.

If you have some troubles:
- It should probably come from your ```lib/config.local.php``` (configuration syntax may have changed). Just compare it with ```lib/config.original.php```
- Check owner/permissions of your files.

Anyway you should off-course make a backup of your current installation before doing anything. :)

### How can I limit upload access ?

There are two ways to limit upload access (but not download):
- you can set one or more passwords in order to access the upload interface, or/and
- you can configure a list of authorized IP ([CIDR notation](https://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing#CIDR_notation)) which are allowed to access to the upload page

Check documentation of ```upload_password``` and ```upload_ip``` parameters in [lib/config.original.php](https://gitlab.com/jensche/s42transfer/blob/master/lib/config.original.php).

### I have some troubles with IE

If you have some strange behavior with IE, you may configure [compatibility mode](http://feedback.dominknow.com/knowledgebase/articles/159097-internet-explorer-ie8-ie9-ie10-and-ie11-compat).

Anyway I would recommand you to use another web browser. :)

### I found a bug, what should I do ?

Feel free to open a bug in the [GitLab's issues](https://gitlab.com/jensche/s42transfer/issues).

### How to set maximum file size ?

If your browser supports HTML5 file API, you can send files as big as you want.

For browsers who does not support HTML5 file API, the limitation come from PHP configuration.
You have to set [post_max_size](https://php.net/manual/en/ini.core.php#ini.post-max-size) and [upload_max_filesize](https://php.net/manual/en/ini.core.php#ini.upload-max-filesize) in your php configuration.

If you don't want to allow unlimited upload size, you can still setup a maximal file size in s42tranfer setting (see ```maximal_upload_size``` in your configuration)

### How can I edit an option ?

Documentation of all default options are located in [lib/config.original.php](https://gitlab.com/jensche/s42transfer/blob/master/lib/config.original.php).
If you want to change an option, just edit your ```lib/config.local.php```.

### How can I access the admin interface ?

Just go to ```/admin.php```.

### How can I use the scripting interface ?

Simply go to ```/script.php``` with your web browser.

### My downloads are incomplete or my uploads fails

Be sure your PHP installation is not using safe mode, it may cause timeouts.

### Is it possible to use an external SMTP Server?

Yes. Just configure your external Mail Account in the admin backend.

### How can I automatize the cleaning of old (expired) files?

You can call the admin.php script from the command line (CLI) with the `clean_expired` or `clean_async` commands: `sudo -u www-data php admin.php clean_expired`.

Then the command can be placed in a cron file to automatize the process. For example:

```
# m h dom mon dow user  command
12 3    * * *   www-data  php /path/to/s42/admin.php clean_expired
16 3    * * *   www-data  php /path/to/s42/admin.php clean_async
```

### Why forking ?

The original project seems not to be continued anymore and I prefer to add more features and increase security from a stable version.

### What can we expect in the future ?

Check [issues](https://gitlab.com/jensche/s42transfer/issues) to check open bugs and incoming new stuff. :)

### What is the s42transfer license ?

s42transfer is licensed under [AGPLv3](https://gitlab.com/jensche/s42transfer/blob/master/COPYING).

### How do I modify the TOS (terms of use) ?

Just edit ```tos.php``` and configure ```$org``` and ```$contact``` variables.

### What about this file deduplication thing ?

s42transfer use a very simple file level deduplication for storage optimization.

This mean that if some people upload several times the same file, this will only store one time the file and increment a counter.

If someone use his delete link or an admin cleans expired links, this will decrement the counter corresponding to the file.

If the counter falls to zero, the file is destroyed.

### What is the difference between "delete link" and "delete file and links" in admin interface ?

As explained in the previous question, files with the same md5 hash are not duplicated and a reference counter stores the number of links pointing to a single file.
So:
- The button "delete link" will delete the reference to the file but might not destroy the file.
- The button "delete file and links" will delete all references pointing to the file and will destroy the file.

### What are the different options avialble for download?

User can download plain files and zip files individually, can download combined files as a single file in zip format by selecting options available on download screen.

### How to contact someone from s42transfer ?

Feel free to create an issue if you found a bug, else you can send an email to admin@s42.io
