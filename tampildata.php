<?php
require_once 'auth.php';
require_login();
?>

<div class="card">
    <div class="card-header" style="background-color: #591369ff; color: white;">
        <center>ﾉ(≧∇≦)ﾉ</center>
    </div>
    <div class="card-body">
        <h5 class="card-title">
            <center><strong>TABEL DAFTAR BUKU</strong></center>
        </h5>
        <p align='right'>
            <a href="?page=tambahdata">
                <button type="button" style="border-radius: 5px;" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah data</button>
            </a>
        </p>
        <hr>
        <table id="example" class="table table-striped">
            <thead>
                <tr>
                    <th>id Buku</th>
                    <th>Nama Buku</th>
                    <th>Tahun Terbit</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>Sampul Buku</th>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                include "koneksi.php";
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                $query = "SELECT * FROM buku JOIN kategori ON buku.idKategori = kategori.idKategori";
                if (!empty($search)) {
                    $query .= " WHERE (namaBuku LIKE ? OR pengarang LIKE ? OR tahunTerbit LIKE ? OR namaKategori LIKE ?)";
                    $stmt = mysqli_prepare($koneksi, $query);
                    $searchParam = "%$search%";
                    mysqli_stmt_bind_param($stmt, "ssss", $searchParam, $searchParam, $searchParam, $searchParam);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                } else {
                    $result = mysqli_query($koneksi, $query);
                }
                $hasResults = mysqli_num_rows($result) > 0;
                if ($hasResults) {
                    while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $data['idBuku']; ?></td>
                        <td><?php echo $data['namaBuku']; ?></td>
                        <td><?php echo $data['tahunTerbit']; ?></td>
                        <td><?php echo $data['pengarang']; ?></td>
                        <td><?php echo $data['namaKategori']; ?></td>
                        <td><img src="./images/foto/<?php echo $data["gambar_sampul"]; ?>" alt="sampul-buku" width="90" height="60"></td>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <td>
                            <a href="?page=ubahdata&idBuku=<?= htmlspecialchars($data['idBuku']); ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Yakin ingin menghapus data ini?')) location.href='?page=hapus&idBuku=<?= htmlspecialchars($data['idBuku']); ?>';">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php
                    }
                }
                if (isset($stmt)) mysqli_stmt_close($stmt);
                if (!$hasResults && !empty($search)) {
                    echo '<tr><td colspan="7" class="text-center text-muted">Tidak ada buku yang ditemukan untuk pencarian "' . htmlspecialchars($search) . '"</td></tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>id Buku</th>
                    <th>Nama Buku</th>
                    <th>Tahun Terbit</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>Sampul Buku</th>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </tfoot>
        </table>
    </div>
</div>