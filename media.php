<!doctype html>
<?php
require_once 'auth.php';
require_login();

// only admins may perform deletions (either via hapus.php or this handler)
if (isset($_GET['page']) && $_GET['page'] === 'hapus' && isset($_GET['idBuku'])) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ?page=tampildata");
        exit();
    }
    include 'koneksi.php';
    $idBuku = $_GET['idBuku'];
    $stmt = mysqli_prepare($koneksi, "DELETE FROM buku WHERE idBuku = ?");
    mysqli_stmt_bind_param($stmt, "s", $idBuku);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ?page=tampildata");
    exit();
}
?>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/dataTables.bootstrap5.css" rel="stylesheet">
  <!-- import Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
  <!-- container berisi navbar (header)-->
  <div class="container">

    <nav class="navbar navbar-expand-lg" style="background-color: #591369ff;">
      <div class="container-fluid">
        <nav class="navbar">
          <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: white;">
              <img src="images/utm-mataram.png" alt="Logo" width="28" height="28"
                class="d-inline-block align-text-top">
              UTM-Library
            </a>
          </div>
        </nav>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="navbar-brand" href="?page=home" style="color: white; font-size: 17.5px;">
                <i class="fas fa-home"></i> Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="?page=tabel" style="color: white;">
                <i class="fas fa-table"></i> Tabel Buku</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">
                <i class="fas fa-list"></i> Kategori Tabel
              </a>
              <ul class="dropdown-menu">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a class="dropdown-item" href="?page=tambahdata">
                    <i class="fas fa-plus-circle"></i> Form Tambah Data</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="?page=tampildata">
                    <i class="fas fa-eye"></i> Tampil Data</a></li>
              </ul>
              <?php if (!isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php" style="color: white;">
                <i class="fas fa-sign-in-alt"></i> Login</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" style="color: white;">
                <i class="fas fa-user me-2"></i><?= htmlspecialchars($_SESSION['username']); ?>
                <?php if (isset($_SESSION['role'])): ?>
                    (<?= htmlspecialchars($_SESSION['role']); ?>)
                <?php endif; ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php" style="color: white;">
                <i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
          <?php endif; ?>
          </li>
          </ul>
          <form class="d-flex" role="search" method="GET">
            <?php
            $currentParams = $_GET;
            unset($currentParams['search']); // remove search if exists to avoid duplicate
            foreach ($currentParams as $key => $value) {
                echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
            }
            ?>
            <input class="form-control me-2" type="search" name="search" placeholder="Cari nama buku, pengarang, tahun..." aria-label="Search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />
            <button class="btn btn-outline-success" type="submit">Cari</button>
          </form>
        </div>
      </div>
    </nav><br>

    <!-- diluar container dan berisi navbar (navigation pane) serta content (table) -->
    <div class="row">
      <div class="col-md-3">

        <div class="list-group">
          <a href="media.php" class="list-group-item list-group-item-action disabled" aria-current="true" style="background-color: #591369ff; color: white;">
            <i class="fas fa-bars"></i> Navigasi Tabel
          </a>
          <a href="?page=tampildata" class="list-group-item list-group-item-action">
            <i class="fas fa-eye"></i> Tampil Data</a>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <a href="?page=tambahdata" class="list-group-item list-group-item-action">
            <i class="fas fa-plus-circle"></i> Form Tambah Data</a>
          <?php endif; ?>
        </div>
        <br>
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action disabled" aria-current="true" style="background-color: #591369ff; color: white;">
            <i class="fas fa-book"></i> Kategori Buku
          </a>
          <?php
          include 'koneksi.php';
          $queryKategori = "SELECT DISTINCT namaKategori FROM kategori ORDER BY namaKategori";
          $resultKategori = mysqli_query($koneksi, $queryKategori);
          while ($kategori = mysqli_fetch_array($resultKategori)) {
            $namaKategori = $kategori['namaKategori'];
            $icon = '';
            if (strpos($namaKategori, 'Buku Fiksi') !== false) {
              $icon = '<i class="fas fa-book-open"></i>';
            } elseif (strpos($namaKategori, 'Buku Non-Fiksi') !== false) {
              $icon = '<i class="fas fa-book-reader"></i>';
            } elseif (strpos($namaKategori, 'Anak') !== false || strpos($namaKategori, 'Remaja') !== false) {
              $icon = '<i class="fas fa-child"></i>';
            } else {
              $icon = '<i class="fas fa-book"></i>';
            }
            echo '<a href="?page=kategori&namaKategori=' . urlencode($namaKategori) . '" class="list-group-item list-group-item-action">' . $icon . ' ' . htmlspecialchars($namaKategori) . '</a>';
          }
          ?>
        </div>
        <br>
      </div>
      <div class="col-md-9">
        <!-- di file ini berisi konten yang terus berubah (dinamis) -->
        <?php include "konten.php"; ?>
      </div>

    </div>
    <br>

    <!-- ini footer dah dari bootstrap docs -> card -> ambil yang body -->
    <div class="card">
      <div class="card-body">
        <center><strong>Copyright</strong> &copy; 2025 Kaziro</center>
      </div>
    </div>

    <!-- file javascript, posisi mempengaruhi desain dan interaktifitas web -->
  </div>
  <script src="js/jquery-3.7.1.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/dataTables.js"></script>
  <script src="js/dataTables.bootstrap5.js"></script>
  <script>
    new DataTable('#example');
  </script>

</body>
</php>