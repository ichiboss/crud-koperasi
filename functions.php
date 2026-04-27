<?php
session_start();

// Fungsi untuk mengecek apakah user sudah login
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Fungsi untuk generate nomor anggota otomatis (KOP-YYYY-XXXX)
function generateNomorAnggota($conn) {
    $year = date('Y');
    $query = "SELECT MAX(nomor_anggota) as max_id FROM anggota WHERE nomor_anggota LIKE 'KOP-$year-%'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    
    if ($data['max_id']) {
        $last_num = (int)substr($data['max_id'], 9);
        $new_num = str_pad($last_num + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $new_num = "001";
    }
    
    return "KOP-$year-$new_num";
}

// Fungsi untuk membersihkan input data
function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
