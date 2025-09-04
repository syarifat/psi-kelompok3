<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['superadmin', 'admin', 'guru']);
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. tahun_ajaran
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 20);
            $table->boolean('aktif')->default(false);
            $table->timestamps();
        });

        // 3. kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // 4. siswa
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nis', 30)->unique();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->string('no_hp_ortu', 20);
            $table->string('rfid', 32)->unique();
            $table->enum('status', ['aktif', 'lulus', 'keluar'])->default('aktif');
            $table->timestamps();
        });

        // 5. absensi
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa']);
            $table->string('keterangan', 255)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('tahun_ajaran');
        Schema::dropIfExists('users');
    }
};
