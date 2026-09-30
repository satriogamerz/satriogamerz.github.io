<?php
session_start(); if(!isset($_SESSION['login'])){header('Location: auth/login.php');exit;} require_once 'config/database.php';
$wanted=[['Teknik Informatika','TI'],['Sistem Informasi','SI'],['Arsitektur','ARS']];
foreach($wanted as $p){$n=$conn->real_escape_string($p[0]);$k=$conn->real_escape_string($p[1]);$q=$conn->query("SELECT id FROM prodi WHERE nama_prodi='$n' LIMIT 1");if(!$q||$q->num_rows===0)$conn->query("INSERT INTO prodi(nama_prodi,kode_prodi) VALUES('$n','$k')");}
$conn->query("DELETE FROM prodi WHERE nama_prodi NOT IN ('Teknik Informatika','Sistem Informasi','Arsitektur')"); header('Location: prodi/index.php');
