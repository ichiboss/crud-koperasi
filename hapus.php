<?php
require_once 'functions.php';
require_once 'config/database.php';
checkLogin();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $query = "DELETE FROM anggota WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?status=deleted");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
