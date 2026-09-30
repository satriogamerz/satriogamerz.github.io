<?php
session_start();if(!isset($_SESSION['login'])){header("Location: auth/login.php");exit;}
require_once "config/database.php"; require_once "config/activity.php";
$conn->query("CREATE TABLE IF NOT EXISTS aktivitas (id INT AUTO_INCREMENT PRIMARY KEY,nama_pengguna VARCHAR(100),aktivitas VARCHAR(255),waktu DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB");
$data=$conn->query("SELECT * FROM aktivitas ORDER BY id DESC LIMIT 100");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Aktivitas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"><link href="assets/css/style.css" rel="stylesheet"></head><body>
<div class="sidebar"><div class="brand"><img src="assets/img/sim-logo.svg" alt="SIM" style="width:130px;max-width:90%;margin-bottom:8px">SIM MAHASISWA<small>Universitas Muhammadiyah Bengkulu</small></div><div class="menu">
<a href="index.php"><i class="bi bi-grid-1x2-fill"></i><span> Dashboard</span></a><a href="mahasiswa/index.php"><i class="bi bi-people-fill"></i><span> Data Mahasiswa</span></a><a href="prodi/index.php"><i class="bi bi-building-fill"></i><span> Program Studi</span></a><a href="profil/index.php"><i class="bi bi-person-badge-fill"></i><span> Profil</span></a><a href="laporan/index.php"><i class="bi bi-printer-fill"></i><span> Laporan</span></a><a class="active" href="aktivitas.php"><i class="bi bi-clock-history"></i><span> Aktivitas</span></a><a href="auth/logout.php"><i class="bi bi-box-arrow-right"></i><span> Logout</span></a>
</div></div>
<div class="main"><div class="topbar d-flex justify-content-between align-items-center"><div><h4 class="mb-1">Riwayat Aktivitas</h4><small class="text-muted">Aktivitas terbaru dalam sistem</small></div><button class="theme-btn" onclick="toggleTheme()"><i class="bi bi-moon-stars-fill"></i> Mode</button></div>
<div class="card-soft p-4"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>No</th><th>Pengguna</th><th>Aktivitas</th><th>Waktu</th></tr></thead><tbody>
<?php $no=1;while($r=$data->fetch_assoc()):?><tr><td><?=$no++?></td><td><?=htmlspecialchars($r['nama_pengguna'])?></td><td><i class="bi bi-check-circle text-success"></i> <?=htmlspecialchars($r['aktivitas'])?></td><td><?=htmlspecialchars($r['waktu'])?></td></tr><?php endwhile;?>
</tbody></table></div></div></div>
<script>
function toggleTheme(){document.body.classList.toggle('dark-mode');localStorage.setItem('simTheme',document.body.classList.contains('dark-mode')?'dark':'light')}
if(localStorage.getItem('simTheme')==='dark')document.body.classList.add('dark-mode');
</script></body></html>
