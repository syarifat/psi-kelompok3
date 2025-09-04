-- Data dummy tahun_ajaran
INSERT INTO tahun_ajaran (id, nama, aktif, created_at, updated_at) VALUES
(1, '2025/2026', 1, NOW(), NOW());

-- Data dummy kelas
INSERT INTO kelas (id, nama, tahun_ajaran_id, wali_kelas_id, created_at, updated_at) VALUES
(1, '1A', 1, NULL, NOW(), NOW()),
(2, '1B', 1, NULL, NOW(), NOW()),
(3, '1C', 1, NULL, NOW(), NOW());

-- Data dummy siswa
INSERT INTO siswa (nama, nis, kelas_id, tahun_ajaran_id, no_hp_ortu, rfid, status, created_at, updated_at) VALUES
('Budi Santoso', '1001', 1, 1, '081234567890', 'rfid1001', 'aktif', NOW(), NOW()),
('Siti Aminah', '1002', 2, 1, '081234567891', 'rfid1002', 'aktif', NOW(), NOW()),
('Andi Wijaya', '1003', 3, 1, '081234567892', 'rfid1003', 'aktif', NOW(), NOW()),
('Rina Lestari', '1004', 1, 1, '081234567893', 'rfid1004', 'aktif', NOW(), NOW()),
('Dewi Putri', '1005', 2, 1, '081234567894', 'rfid1005', 'aktif', NOW(), NOW());
