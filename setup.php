<?php
session_start();
$done = false; $error = ''; $message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim($_POST['host'] ?? '');
    $user = trim($_POST['user'] ?? '');
    $pass = $_POST['pass'] ?? '';
    $db   = trim($_POST['db'] ?? '');
    if ($host === '' || $user === '' || $db === '') {
        $error = 'Host, username, dan nama database wajib diisi.';
    } else {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = new mysqli($host, $user, $pass, $db);
            $conn->set_charset('utf8mb4');
            $sql = file_get_contents(__DIR__ . '/database.sql');
            // database.sql contains CREATE DATABASE/USE which shared hosting may reject.
            $sql = preg_replace('/CREATE DATABASE IF NOT EXISTS.*?;\s*/is', '', $sql);
            $sql = preg_replace('/USE\s+`?sistem_mahasiswa`?\s*;\s*/i', '', $sql);
            // Replace old seed prodi with exactly the requested 3.
            $sql = preg_replace('/INSERT IGNORE INTO prodi.*?;\s*/is', "INSERT IGNORE INTO prodi(id,kode_prodi,nama_prodi) VALUES (1,'TI','Teknik Informatika'),(2,'SI','Sistem Informasi'),(3,'ARS','Arsitektur');\n", $sql);
            // Remove sample student insert so an existing DB is not duplicated unnecessarily.
            $sql = preg_replace('/INSERT IGNORE INTO mahasiswa.*?;\s*/is', '', $sql);
            if (!$conn->multi_query($sql)) throw new Exception($conn->error);
            while ($conn->more_results() && $conn->next_result()) { }
            $config = "<?php\n"
        . "$" . "host = " . var_export($host,true) . ";\n"
        . "$" . "user = " . var_export($user,true) . ";\n"
        . "$" . "pass = " . var_export($pass,true) . ";\n"
        . "$" . "db = " . var_export($db,true) . ";\n"
        . "?>\n";
            if (!is_writable(__DIR__ . '/config')) throw new Exception('Folder config tidak bisa ditulis oleh server. Buat file config/db_config.php secara manual menggunakan petunjuk README.');
            file_put_contents(__DIR__ . '/config/db_config.php', $config);
            $message = 'Database berhasil terhubung dan tabel sudah dibuat. Silakan login.';
            $done = true;
        } catch (Throwable $e) { $error = $e->getMessage(); }
    }
}
?><!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Setup SIM Mahasiswa</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><style>body{min-height:100vh;background:linear-gradient(135deg,#198754,#0d6efd);display:flex;align-items:center;justify-content:center}.card{max-width:720px;width:94%;border:0;border-radius:20px}.head{background:#198754;color:white;padding:28px;text-align:center;border-radius:20px 20px 0 0}.body{padding:30px}</style></head><body><div class="card shadow-lg"><div class="head"><h2>SIM MAHASISWA</h2><div>Setup Hosting InfinityFree</div></div><div class="body"><?php if($done): ?><div class="alert alert-success"><?=$message?></div><a class="btn btn-success" href="auth/login.php">Buka Login</a><?php else: ?><p class="text-muted">Isi data dari menu <b>MySQL Databases</b> di panel hosting. Jangan gunakan username/password cPanel sebagai pengganti database.</p><?php if($error): ?><div class="alert alert-danger"><b>Gagal:</b> <?=htmlspecialchars($error)?></div><?php endif; ?><form method="post"><div class="row g-3"><div class="col-md-6"><label class="form-label">MySQL Host</label><input name="host" class="form-control" placeholder="contoh: sqlXXX.infinityfree.com" required></div><div class="col-md-6"><label class="form-label">Nama Database</label><input name="db" class="form-control" placeholder="contoh: epizXXXX_sistem" required></div><div class="col-md-6"><label class="form-label">Username Database</label><input name="user" class="form-control" placeholder="contoh: epizXXXX_user" required></div><div class="col-md-6"><label class="form-label">Password Database</label><input type="password" name="pass" class="form-control"></div></div><button class="btn btn-success w-100 mt-4">Tes Koneksi & Install Database</button></form><div class="small text-muted mt-3">Setelah berhasil, hapus file <code>setup.php</code> dari hosting demi keamanan.</div><?php endif; ?></div></div></body></html>
