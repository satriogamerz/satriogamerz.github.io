<?php
header('Content-Type: text/html; charset=utf-8');
$php = PHP_VERSION;
$mysqli = extension_loaded('mysqli');
$root = __DIR__;
echo '<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Cek Hosting</title><style>body{font-family:Arial;background:#f4f6f9;padding:30px}.box{max-width:760px;margin:auto;background:#fff;padding:28px;border-radius:16px;box-shadow:0 8px 30px #0001}li{margin:10px 0}.ok{color:#198754}.bad{color:#dc3545}code{background:#eee;padding:2px 5px;border-radius:4px}</style></head><body><div class="box"><h2>SIM Mahasiswa — Cek Hosting</h2>';
echo '<ul><li>PHP: <b>'.htmlspecialchars($php).'</b></li>';
echo '<li>MySQLi: '.($mysqli?'<b class="ok">AKTIF</b>':'<b class="bad">TIDAK AKTIF</b>').'</li>';
echo '<li>Folder aplikasi: <code>'.htmlspecialchars($root).'</code></li></ul>';
if(!$mysqli){echo '<p class="bad">Ekstensi mysqli tidak aktif. Aktifkan versi PHP yang menyediakan MySQLi dari panel hosting.</p>';}
elseif(file_exists(__DIR__.'/config/db_config.php')){
  require __DIR__.'/config/db_config.php';
  try{$c=new mysqli($host,$user,$pass,$db); echo '<p class="ok"><b>Koneksi database: BERHASIL.</b></p>'; $c->close();}
  catch(Throwable $e){echo '<p class="bad"><b>Koneksi database gagal:</b> '.htmlspecialchars($e->getMessage()).'</p>';}
}else echo '<p>Database belum dikonfigurasi. Buka <a href="setup.php">setup.php</a>.</p>';
echo '<hr><p>Jika halaman ini tampil, PHP hosting dapat menjalankan aplikasi.</p></div></body></html>';
