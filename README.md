DEPLOY SERVER

1 . clone dari github
git clone https://github.com/bradi25/laraveltest.git laraveltest

2. Pindah direktori
   cd ~/laraveltest

3. Install composer image dan memasang ke directory laraveltest
   docker run --rm -v $(pwd):/app composer install

4. set permission di direktori laraveltest
   sudo chown -R $USER:$USER ~/laraveltest

5. Membuat docker compose yml
   vim ~/laraveltest/docker-compose.yml
   docker-compose.yml seperti sudah ada di atas bernama docker-compose.yml

6. Membuat docker file untuk spesifik images
   Dockerfile yang sudah ada di directory ini bernama Dockerfile

7. Membuat konfigurasi PHP
   mkdir ~/laraveltest/php
   vim ~/laraveltest/php/local.ini
   Tambahkan command ini
   upload_max_filesize=40M
   post_max_size=40M

8. Membuat konfigurasi Nginx
   mkdir -p ~/laraveltest/nginx/conf.d
   nano ~/laraveltest/nginx/conf.d/app.conf
   Tambahkan command ini
   server {
   listen 80;
   index index.php index.html;
   error_log /var/log/nginx/error.log;
   access_log /var/log/nginx/access.log;
   root /var/www/public;
   location ~ \.php$ {
   try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
   fastcgi_pass app:9000;
   fastcgi_index index.php;
   include fastcgi_params;
   fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
   fastcgi_param PATH_INFO $fastcgi_path_info;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
   gzip_static on;
   }
   }

9. Membuat konfigurasi Mysql
   mkdir ~/laraveltest/mysql
   vim ~/laraveltest/mysql/my.cnf
   Tambahkan command ini
   [mysqld]
   general_log = 1
   general_log_file = /var/lib/mysql/general.log

10. Mengubah env
    cp .env.example .env
    vim .env

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laraveltest
    DB_USERNAME=root
    DB_PASSWORD=
    Jika di production password di buat sulit tapi di sini saya buat kosong

11. Menjalankan Containers
    Command
    docker-compose up -d

12. Melihat Containers yang berjalan
    docker ps

13. Men generate key di env
    docker-compose exec app php artisan key:generate

14. Membuat User sql
    docker-compose exec db bash
    mysql -u root -p
    GRANT ALL ON laraveltest.\* TO 'laraveluser'@'%' IDENTIFIED BY '';
    FLUSH PRIVILEGES;
    exit sql
    EXIT;
    exit containers
    EXIT;

15. Migrasi Database
    docker-compose exec app php artisan migrate
