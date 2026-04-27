<?php
include 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM anggota WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Data tidak ditemukan! <a href='index.php' class='alert-link'>Kembali</a></div></div>";
    include 'includes/footer.php';
    exit();
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = cleanInput($_POST['nama_lengkap']);
    $nik          = cleanInput($_POST['nik']);
    $alamat       = cleanInput($_POST['alamat']);
    $telepon      = cleanInput($_POST['telepon']);
    $email        = cleanInput($_POST['email']);
    $status       = cleanInput($_POST['status']);

    // Cek NIK unik (kecuali milik sendiri)
    $check_nik = mysqli_query($conn, "SELECT * FROM anggota WHERE nik = '$nik' AND id != $id");
    if (mysqli_num_rows($check_nik) > 0) {
        $error = "NIK sudah digunakan oleh anggota lain!";
    } else {
        $query_update = "UPDATE anggota SET 
                         nama_lengkap = '$nama_lengkap',
                         nik = '$nik',
                         alamat = '$alamat',
                         telepon = '$telepon',
                         email = '$email',
                         status = '$status'
                         WHERE id = $id";
        
        if (mysqli_query($conn, $query_update)) {
            $success = "Data anggota berhasil diperbarui!";
            // Refresh data
            $data['nama_lengkap'] = $nama_lengkap;
            $data['nik'] = $nik;
            $data['alamat'] = $alamat;
            $data['telepon'] = $telepon;
            $data['email'] = $email;
            $data['status'] = $status;
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
}
?>

<div class="row mb-3 mt-3">
  <div class="col-sm-6">
    <h1 class="m-0">Edit Anggota</h1>
    <p class="text-muted text-sm">Memperbarui data anggota: <strong><?= $data['nomor_anggota'] ?></strong></p>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <a href="index.php" class="btn btn-default float-sm-right">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div><!-- /.col -->
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Formulir Edit Data</h3>
      </div>
      <!-- /.card-header -->

      <div class="card-body">
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                <?= $success ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
          <div class="row">
            <div class="col-md-6 form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required value="<?= $data['nama_lengkap'] ?>">
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label for="nik">NIK</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" name="nik" id="nik" class="form-control" required value="<?= $data['nik'] ?>">
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 form-group">
                <label for="email">Alamat Email</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" id="email" class="form-control" value="<?= $data['email'] ?>">
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label for="telepon">No. Telepon / WhatsApp</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" name="telepon" id="telepon" class="form-control" value="<?= $data['telepon'] ?>">
                </div>
            </div>
          </div>

          <div class="form-group">
              <label for="alamat">Alamat Lengkap</label>
              <textarea name="alamat" id="alamat" class="form-control" rows="3"><?= $data['alamat'] ?></textarea>
          </div>

          <div class="form-group" style="max-width: 300px;">
              <label for="status">Status Anggota</label>
              <select name="status" id="status" class="form-control">
                  <option value="Aktif" <?= $data['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                  <option value="Non-Aktif" <?= $data['status'] == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
              </select>
          </div>
          
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
          <button type="submit" class="btn btn-primary">
              <i class="fas fa-save mr-1"></i> Simpan Perubahan
          </button>
          <a href="index.php" class="btn btn-default float-right">Batal</a>
      </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
</div>

<?php include 'includes/footer.php'; ?>
