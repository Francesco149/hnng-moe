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

if you use nginx, here's a config file by @its2016cmon:
```
server {
    listen *:80;
    root /var/www/hnng;
    index index.php;
    server_name _;

    rewrite ^/about/?$ /index.php?act=about last;
    rewrite ^/api/?$ /index.php?act=api last;
    rewrite ^/donate/?$ /index.php?act=donate last;
    rewrite ^/privacy/?$ /index.php?act=privacy last;
    rewrite ^/manteinance/?$ /index.php?act=manteinance last;
    rewrite ^/notfound/?$ /index.php?act=notfound last;
    rewrite ^/wip/?$ /index.php?act=wip last;
    rewrite ^/do/?$ /index.php?act=createlink last;
    rewrite ^/sharefiles/?$ /index.php?act=sharefiles last;
    rewrite ^/doupload/?$ /index.php?act=doupload last;
    rewrite ^/reveal/?$ /index.php?act=reveal last;
    rewrite ^/reveallink/?$ /index.php?act=reveallink last;
    rewrite ^/f/([a-z0-9-]+)/?(.*)?$ /getfile.php?fileid=$1&$2 last;
    rewrite ^/r/([a-z0-9-]+)/?$ /revealurl.php?urlid=$1 last;
    rewrite ^/([a-z0-9-]+)/?$ /geturl.php?urlid=$1 last;

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    location ~ \.php$ {
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass unix:/var/run/php5-fpm.sock;
            fastcgi_index index.php;
            include /etc/nginx/fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_intercept_errors off;
            fastcgi_buffer_size 8k;
            fastcgi_buffers 8 8k;
            fastcgi_busy_buffers_size 16k;
        }
}
```
