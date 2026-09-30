<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: auth/login.php"); exit; }
require_once "config/database.php";
function total($conn,$sql){$r=$conn->query($sql)->fetch_assoc();return (int)$r['total'];}
$total_mahasiswa=total($conn,"SELECT COUNT(*) total FROM mahasiswa");
$total_prodi=total($conn,"SELECT COUNT(*) total FROM prodi");
$total_laki=total($conn,"SELECT COUNT(*) total FROM mahasiswa WHERE jenis_kelamin='Laki-laki'");
$total_perempuan=total($conn,"SELECT COUNT(*) total FROM mahasiswa WHERE jenis_kelamin='Perempuan'");
$prodiChart=$conn->query("SELECT p.nama_prodi,COUNT(m.id) jumlah FROM prodi p LEFT JOIN mahasiswa m ON m.prodi_id=p.id GROUP BY p.id ORDER BY p.nama_prodi");
$genderChart=$conn->query("SELECT jenis_kelamin,COUNT(*) jumlah FROM mahasiswa GROUP BY jenis_kelamin");
$angkatanChart=$conn->query("SELECT angkatan,COUNT(*) jumlah FROM mahasiswa GROUP BY angkatan ORDER BY angkatan");
$terbaru=$conn->query("SELECT m.*,p.nama_prodi FROM mahasiswa m JOIN prodi p ON m.prodi_id=p.id ORDER BY m.id DESC LIMIT 5");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard - SIM Mahasiswa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script></head><body>
<div class="sidebar"><div class="brand">SIM MAHASISWA<small>Universitas Muhammadiyah Bengkulu</small></div><div class="menu">
<div class="menu-title">Menu Utama</div>
<a class="active" href="index.php"><i class="bi bi-grid-1x2-fill"></i><span> Dashboard</span></a>
<a href="mahasiswa/index.php"><i class="bi bi-people-fill"></i><span> Data Mahasiswa</span></a>
<a href="prodi/index.php"><i class="bi bi-building-fill"></i><span> Program Studi</span></a>
<div class="menu-title mt-2">Lainnya</div>
<a href="profil/index.php"><i class="bi bi-person-badge-fill"></i><span> Profil</span></a>
<a href="laporan/index.php"><i class="bi bi-printer-fill"></i><span> Laporan</span></a>
<a href="aktivitas.php"><i class="bi bi-clock-history"></i><span> Aktivitas</span></a><a href="auth/logout.php"><i class="bi bi-box-arrow-right"></i><span> Logout</span></a>
<button class="theme-btn ms-2" onclick="toggleTheme()"><i class="bi bi-moon-stars-fill"></i></button></div></div>
<div class="main">
<div class="topbar d-flex justify-content-between align-items-center"><div><h4 class="mb-1">Dashboard</h4><small class="text-muted">Sistem Informasi Manajemen Mahasiswa</small></div><div><i class="bi bi-person-circle me-1"></i><?=htmlspecialchars($_SESSION['nama_lengkap'])?></div></div>
<div class="alert alert-success card-soft border-0"><h5 class="mb-1">Selamat Datang, <?=htmlspecialchars($_SESSION['nama_lengkap'])?>! 👋</h5><p class="mb-0">Universitas Muhammadiyah Bengkulu — Program Studi Teknik Informatika</p></div>
<div class="row g-3">
<?php foreach([['Total Mahasiswa',$total_mahasiswa,'people-fill'],['Program Studi',$total_prodi,'building-fill'],['Laki-laki',$total_laki,'gender-male'],['Perempuan',$total_perempuan,'gender-female']] as $s): ?>
<div class="col-6 col-xl-3"><div class="stat d-flex justify-content-between align-items-center"><div><small class="text-muted"><?=$s[0]?></small><h2 class="mt-2 mb-0"><?=$s[1]?></h2></div><div class="icon"><i class="bi bi-<?=$s[2]?>"></i></div></div></div>
<?php endforeach; ?></div>
<div class="row g-3 mt-1">
<div class="col-lg-6"><div class="card-soft p-3"><h5>Mahasiswa per Program Studi</h5><canvas id="prodiChart" height="150"></canvas></div></div>
<div class="col-lg-6"><div class="card-soft p-3"><h5>Komposisi Jenis Kelamin</h5><canvas id="genderChart" height="150"></canvas></div></div>
</div>
<div class="row g-3 mt-1">
<div class="col-lg-6"><div class="card-soft p-3"><h5>Mahasiswa per Angkatan</h5><canvas id="angkatanChart" height="150"></canvas></div></div>
<div class="col-lg-6"><div class="card-soft p-3"><h5 class="mb-3">Akses Cepat</h5><div class="row g-2">
<div class="col-6"><a class="quick d-block p-3 rounded bg-light" href="mahasiswa/tambah.php"><i class="bi bi-person-plus-fill text-success fs-4"></i><div class="fw-semibold mt-2">Tambah Mahasiswa</div><small class="text-muted">Input data baru</small></a></div>
<div class="col-6"><a class="quick d-block p-3 rounded bg-light" href="prodi/index.php"><i class="bi bi-building text-success fs-4"></i><div class="fw-semibold mt-2">Kelola Prodi</div><small class="text-muted">Data program studi</small></a></div>
</div></div></div></div>
<div class="card-soft p-3 mt-3"><div class="d-flex justify-content-between align-items-center mb-3"><div><h5 class="mb-1">Mahasiswa Terbaru</h5><small class="text-muted">Lima data terakhir</small></div><a href="mahasiswa/index.php" class="btn btn-success btn-sm">Lihat Semua</a></div>
<div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>No</th><th>NPM</th><th>Nama</th><th>JK</th><th>Program Studi</th><th>Angkatan</th></tr></thead><tbody>
<?php $no=1;while($m=$terbaru->fetch_assoc()): ?><tr><td><?=$no++?></td><td><?=$m['npm']?></td><td><?=htmlspecialchars($m['nama'])?></td><td><?=$m['jenis_kelamin']?></td><td><?=$m['nama_prodi']?></td><td><?=$m['angkatan']?></td></tr><?php endwhile; ?>
</tbody></table></div></div>
<div class="card-soft p-3 mt-3"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">Aktivitas Terbaru</h5><a href="aktivitas.php" class="btn btn-sm btn-outline-success">Lihat Semua</a></div><?php require_once "config/activity.php"; $conn->query("CREATE TABLE IF NOT EXISTS aktivitas (id INT AUTO_INCREMENT PRIMARY KEY,nama_pengguna VARCHAR(100),aktivitas VARCHAR(255),waktu DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB"); $acts=$conn->query("SELECT * FROM aktivitas ORDER BY id DESC LIMIT 5"); ?><div class="mt-3"><?php while($a=$acts->fetch_assoc()): ?><div class="activity-item"><strong><?=htmlspecialchars($a['aktivitas'])?></strong><br><small class="text-muted"><?=htmlspecialchars($a['nama_pengguna'])?> • <?=htmlspecialchars($a['waktu'])?></small></div><?php endwhile; ?></div></div><div class="footer text-center">SIM Mahasiswa • Muhamad Satrio • 2355201088 • Kelas 7.4 • Teknik Informatika • UMB</div>
</div>
<script>
new Chart(document.getElementById('prodiChart'),{type:'bar',data:{labels:[<?php $a=[];while($r=$prodiChart->fetch_assoc())$a[]="'".addslashes($r['nama_prodi'])."'";echo implode(',',$a);?>],datasets:[{label:'Mahasiswa',data:[<?php $prodiChart=$conn->query("SELECT p.nama_prodi,COUNT(m.id) jumlah FROM prodi p LEFT JOIN mahasiswa m ON m.prodi_id=p.id GROUP BY p.id ORDER BY p.nama_prodi");$a=[];while($r=$prodiChart->fetch_assoc())$a[]=$r['jumlah'];echo implode(',',$a);?>]}]},options:{responsive:true,plugins:{legend:{display:false}}}});
new Chart(document.getElementById('genderChart'),{type:'doughnut',data:{labels:[<?php $a=[];while($r=$genderChart->fetch_assoc())$a[]="'".$r['jenis_kelamin']."'";echo implode(',',$a);?>],datasets:[{data:[<?php $genderChart=$conn->query("SELECT jenis_kelamin,COUNT(*) jumlah FROM mahasiswa GROUP BY jenis_kelamin");$a=[];while($r=$genderChart->fetch_assoc())$a[]=$r['jumlah'];echo implode(',',$a);?>]}]}});
new Chart(document.getElementById('angkatanChart'),{type:'line',data:{labels:[<?php $a=[];while($r=$angkatanChart->fetch_assoc())$a[]="'".$r['angkatan']."'";echo implode(',',$a);?>],datasets:[{label:'Mahasiswa',data:[<?php $angkatanChart=$conn->query("SELECT angkatan,COUNT(*) jumlah FROM mahasiswa GROUP BY angkatan ORDER BY angkatan");$a=[];while($r=$angkatanChart->fetch_assoc())$a[]=$r['jumlah'];echo implode(',',$a);?>],tension:.3}]},options:{responsive:true}});
</script></body></html>
<script>function toggleTheme(){document.body.classList.toggle('dark-mode');localStorage.setItem('simTheme',document.body.classList.contains('dark-mode')?'dark':'light')}if(localStorage.getItem('simTheme')==='dark')document.body.classList.add('dark-mode');</script>