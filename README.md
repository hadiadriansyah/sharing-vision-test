# Panduan Memulai Proyek Sharing Vision Test

Selamat datang di proyek Sharing Vision Test! Ini adalah panduan singkat untuk membantu Anda memulai dengan proyek ini.

## Langkah 1: Persiapan Lingkungan

Sebelum Anda dapat membuka localhost project, pastikan Anda telah memenuhi persyaratan berikut:

- **Server Web**: Anda harus memiliki server web yang terinstal di komputer Anda. Anda dapat menggunakan server web seperti Apache atau Nginx.

- **Bahasa Pemrograman**: Pastikan Anda telah menginstal bahasa pemrograman yang sesuai untuk proyek Anda. Misalnya, jika Anda mengembangkan situs web dengan PHP, pastikan PHP telah terinstal.

- **Database**: Pastikan Anda telah menginstal dan mengonfigurasi database server seperti MySQL.

## Langkah 2: Meng-Clone Proyek

Untuk memulai, Anda perlu meng-clone repositori proyek ini ke komputer lokal Anda. Ikuti langkah-langkah berikut:

1. Buka terminal Anda.

2. Gunakan perintah `git clone` untuk meng-clone repositori ini:

   ```bash
   git clone https://github.com/hadiadriansyah/sharing-vision-test.github
   ``` 

## Langkah 3: Setting Back-end (Server)

Ikuti langkah-langkah berikut:

1. Buka terminal Anda.

2. Jalankan service seperti Apache2, PHP dan MySQL.

3. Buat database dengan nama "article"

4. Buka folder server.
    
    ```
    cd server
    ```

5. Instalasi Dependensi: Setelah Anda masuk ke direktori proyek, Anda perlu menginstal semua dependensi PHP yang diperlukan. Gunakan Composer dengan perintah berikut:
    
    ```
    composer install
    ```

6. Konfigurasi File .env: Buat salinan file .env.example dan simpan sebagai .env. Anda dapat menggunakan perintah berikut:
    
    ```
    cp .env.example .env
    ```

    Selanjutnya, buka file .env dan konfigurasi variabel lingkungan, seperti pengaturan koneksi database dan pengaturan lainnya yang diperlukan.

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=article
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. Generate Key Aplikasi: Jalankan perintah untuk menghasilkan kunci aplikasi Laravel:
    
    ```
    php artisan key:generate
    ```

8. Migrasi Database: Jika proyek Laravel Anda menggunakan database, Anda perlu menjalankan migrasi database untuk membuat tabel-tabel yang diperlukan:
    
    ```
    php artisan migrate
    ```

9. Menjalankan Server Lokal: Terakhir, jalankan server lokal untuk menguji REST API Anda. Anda bisa menggunakan perintah ini:
    
    ```
    php artisan serve
    ```

## Panduan request untuk setiap endopoint pada Postman collection
    
Buka Postman collection disini [Postman collection sharing vision test](https://winter-firefly-531502.postman.co/workspace/New-Team-Workspace~05a330f3-4bbe-4091-85d0-8287c18a9fb6/collection/23565067-dd680d5c-c703-42f6-9ba4-3d5cccdf4c0b?action=share&creator=23565067)

atau klik link berikut untuk dokumentasi lengkap
[Dokumentasi](https://winter-firefly-531502.postman.co/workspace/05a330f3-4bbe-4091-85d0-8287c18a9fb6/documentation/23565067-dd680d5c-c703-42f6-9ba4-3d5cccdf4c0b?entity=&branch=&version=)

## Langkah 4: Front-end (Client)

Ikuti langkah-langkah berikut:

1. Buka terminal Anda.

2. Jalankan service seperti Apache2, PHP dan MySQL.

3. Buka folder client.
    
    ```
    cd client
    ```

4. Tambahkan file .htacces jika menggunakan Apache sebagai web server ubah base url sesuai prokect

    
    ```
    RewriteEngine On
    RewriteBase /sharing-vision-test/client/

    # Jangan lakukan rewrite jika direktori atau file yang sesuai ada
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f

    # Rewrite parameter kompleks menjadi clean URLs
    RewriteRule ^([\w-]+)/([\w-]+)/?$ index.php?mod=$1 [QSA,L]

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^([\w-]+)/([\w-]+)/?$ index.php?mod=$1&action=$2 [QSA,L]
    ```

    Atau jika menggunakan Nginx:
    ```
    location /sharing-vision-test/client {
        if (!-e $request_filename){
                rewrite ^/sharing-vision-test/client/([\w-]+)/?$ /sharing-vision-test/client/index.php?mod=$1 last;
        }
        if (!-e $request_filename){
                rewrite ^/sharing-vision-test/client/([\w-]+)/([\w-]+)/?$ /sharing-vision-test/client/index.php?mod=$1&action=$2 last;
        }
    }
    ```

5. Jika anda merubah project struktur anda juga harus merubah baseurl pada file index.php

6. Jalakan project

    [http://localhost/sharing-vision-test/client/](http://localhost/sharing-vision-test/client/)


