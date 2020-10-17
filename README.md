# TafsirQ API

## Instalasi
* Clone repository
* Jalankan `composer install`
* Jalankan `php artisan key:generate`
* Buat database sesuai nama db yang ada pada file .env
* Copy `.env.example` lalu paste menjadi `.env`, sesuaikan isinya sesuai environment.

## Code Style
Cek code style

`vendor/bin/phpcs --standard=PSR2 app/`

Untuk beberapa jenis error, Code Sniffer dapat membantu memperbaiki code agar sesuai standard. Namun tidak semua bisa diperbaiki otomatis, sehingga harus diperbaiki manual.

`vendor/bin/phpcbf --standard=PSR2 app/`
