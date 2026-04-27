<?php
include 'includes/header.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = cleanInput($_POST['nama_lengkap']);
    $nik          = cleanInput($_POST['nik']);
    $alamat       = cleanInput($_POST['alamat']);
    $telepon      = cleanInput($_POST['telepon']);
    $email        = cleanInput($_POST['email']);
    $status       = cleanInput($_POST['status']);
    
    // Generate nomor anggota
    $nomor_anggota = generateNomorAnggota($conn);

    // Cek NIK unik
    $check_nik = mysqli_query($conn, "SELECT * FROM anggota WHERE nik = '$nik'");
    if (mysqli_num_rows($check_nik) > 0) {
        $error = "NIK sudah terdaftar!";
    } else {
        $query = "INSERT INTO anggota (nomor_anggota, nama_lengkap, nik, alamat, telepon, email, status) 
                  VALUES ('$nomor_anggota', '$nama_lengkap', '$nik', '$alamat', '$telepon', '$email', '$status')";
        
        if (mysqli_query($conn, $query)) {
            $success = "Anggota berhasil ditambahkan dengan nomor: <strong>$nomor_anggota</strong>";
        } else {
            $error = "Gagal menambahkan data: " . mysqli_error($conn);
        }
    }
}
?>

<div class="row mb-3 mt-3">
  <div class="col-sm-6">
    <h1 class="m-0">Tambah Anggota Baru</h1>
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
        <h3 class="card-title">Formulir Pendaftaran Anggota</h3>
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
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required placeholder="Contoh: John Doe">
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label for="nik">NIK (Nomor Induk Kependudukan)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" name="nik" id="nik" class="form-control" required placeholder="16 digit angka">
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
                    <input type="email" name="email" id="email" class="form-control" placeholder="example@mail.com">
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label for="telepon">No. Telepon / WhatsApp</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" name="telepon" id="telepon" class="form-control" placeholder="0812xxxx">
                </div>
            </div>
          </div>

          <div class="form-group">
              <label for="alamat">Alamat Lengkap</label>
              <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Jl. Raya No. 123..."></textarea>
          </div>

          <div class="form-group" style="max-width: 300px;">
              <label for="status">Status Keanggotaan</label>
              <select name="status" id="status" class="form-control">
                  <option value="Aktif">Aktif</option>
                  <option value="Non-Aktif">Non-Aktif</option>
              </select>
          </div>
          
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
          <button type="submit" class="btn btn-primary">
              <i class="fas fa-save mr-1"></i> Simpan Data
          </button>
          <button type="reset" class="btn btn-default float-right">Reset</button>
      </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
</div>

<?php include 'includes/footer.php'; ?>
