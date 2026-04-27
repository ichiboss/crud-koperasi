<?php
include 'includes/header.php';

// Ambil statistik
$total_anggota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM anggota"))['count'];
$aktif_anggota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM anggota WHERE status = 'Aktif'"))['count'];
$non_aktif = $total_anggota - $aktif_anggota;

// Fitur Pencarian
$search = "";
$where = "";
if (isset($_GET['search'])) {
    $search = cleanInput($_GET['search']);
    $where = " WHERE nama_lengkap LIKE '%$search%' OR nomor_anggota LIKE '%$search%' OR nik LIKE '%$search%'";
}

$query = "SELECT * FROM anggota" . $where . " ORDER BY tanggal_daftar DESC";
$result = mysqli_query($conn, $query);
?>

<div class="row mb-3 mt-3">
  <div class="col-sm-6">
    <h1 class="m-0">Dashboard Anggota</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <a href="tambah.php" class="btn btn-primary float-sm-right">
      <i class="fas fa-plus"></i> Tambah Anggota
    </a>
  </div><!-- /.col -->
</div>

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-4 col-12">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $total_anggota ?></h3>
        <p>Total Anggota</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-12">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $aktif_anggota ?></h3>
        <p>Anggota Aktif</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-check"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-12">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= $non_aktif ?></h3>
        <p>Non-Aktif</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-times"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->

<!-- Data Table -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Anggota</h3>

        <div class="card-tools">
          <form action="" method="GET">
            <div class="input-group input-group-sm" style="width: 250px;">
              <input type="text" name="search" class="form-control float-right" placeholder="Cari anggota..." value="<?= htmlspecialchars($search) ?>">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
                <?php if($search): ?>
                  <a href="index.php" class="btn btn-default"><i class="fas fa-times"></i></a>
                <?php endif; ?>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>No. Anggota</th>
              <th>Nama Lengkap</th>
              <th>NIK</th>
              <th>Telepon</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td class="text-primary font-weight-bold"><?= $row['nomor_anggota'] ?></td>
                  <td>
                      <div><strong><?= $row['nama_lengkap'] ?></strong></div>
                      <div class="text-muted small"><?= $row['email'] ?></div>
                  </td>
                  <td><?= $row['nik'] ?></td>
                  <td><?= $row['telepon'] ?></td>
                  <td>
                      <?php if($row['status'] == 'Aktif'): ?>
                          <span class="badge badge-success px-2 py-1">Aktif</span>
                      <?php else: ?>
                          <span class="badge badge-danger px-2 py-1">Non-Aktif</span>
                      <?php endif; ?>
                  </td>
                  <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                        <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                  <i class="fas fa-inbox fa-3x mb-3 d-block text-gray"></i>
                  Tidak ada data anggota ditemukan.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>

<?php include 'includes/footer.php'; ?>
