# SIPREDI - Sistem Presensi Digital Sekolah

SIPREDI adalah aplikasi presensi digital untuk sekolah berbasis Laravel dan IoT, mendukung notifikasi WhatsApp otomatis ke orang tua siswa menggunakan WhatsApp Gateway.

## ✨ Fitur Utama

- Presensi siswa berbasis web & API (RFID/ID)
- Notifikasi WhatsApp otomatis ke orang tua jika siswa hadir/tidak hadir di sekolah
- Penandaan otomatis siswa Alpha jika tidak absen sampai jam tertentu
- Dashboard rekap presensi harian
- Manajemen data siswa, guru, dan kelas

## 🚀 Langkah Instalasi & Setup

1. **Clone repository**
	```bash
	git clone https://github.com/syarifat/sipredi.git
	cd sipredi
	```
2. **Install dependency**
	```bash
	composer update
	npm install
	```
3. **Copy file environment**
	```bash
	cp .env.example .env
	```
4. **Generate application key**
	```bash
	php artisan key:generate
	```
5. **Edit file `.env`**
	- Atur koneksi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
	- Atur konfigurasi Fonnte, APP_NAME, dan timezone jika perlu
6. **Jalankan migrasi dan seeder**
	```bash
	php artisan migrate --seed
	```
7. **Build asset frontend**
	```bash
	npm run build
	```
8. **Set permission folder storage dan bootstrap/cache**
	```bash
	chmod -R 775 storage bootstrap/cache
	```
9. **Setting cron untuk absensi otomatis**
	Jalankan perintah berikut dengan `crontab -e`:
	```
	0 9 * * * cd /home/syarifat/my_project/sipredi && php artisan notifikasi:siswa-belum-absen >> /dev/null 2>&1
	1 9 * * * cd /home/syarifat/my_project/sipredi && php artisan absensi:tandai-alpha >> /dev/null 2>&1
	```

## Contact
Email: syarifahsanit@gmail.com  
No: 087842949212

*Copyright © 2025 SAT Project.* 
