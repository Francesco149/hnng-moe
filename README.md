The source code for [hnng.moe](http://hnng.moe).

# Requirements
* git
* Apache or compatible web servers with mod_rewrite and fileupload.
* A MySQL database.
* PHP5

## Getting started
Grab the source code:
```git clone https://github.com/Francesco149/hnng-moe.git```

Now edit conf.php to match your MySQL information and make sure to check out 
all the other settings as well.

Open your mysql command line or PhpMyAdmin and execute hnng_activity.sql, 
hnng_uploads.sql, hnng_bans.sql and hnng_urls.sql. On the MySQL command line 
this can be done like so: ```source /path/to/file.sql```. These sql files are 
in the sql folder.

Copy everything except README, .gitignore, LICENSE and sql to your web server.

You might want to adjust the upload limit in your php.ini in apache.
