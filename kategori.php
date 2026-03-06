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
            <center><strong>KATEGORI: <?php echo htmlspecialchars($_GET['namaKategori'] ?? 'Semua'); ?></strong></center>
        </h5>
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
                </tr>
            </thead>

            <tbody>
                <?php
                include 'koneksi.php';
                $namaKategori = $_GET['namaKategori'] ?? '';
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                $query = "SELECT * FROM buku JOIN kategori ON buku.idKategori = kategori.idKategori";
                $conditions = [];
                $params = [];
                $types = "";

                if ($namaKategori) {
                    $conditions[] = "kategori.namaKategori = ?";
                    $params[] = $namaKategori;
                    $types .= "s";
                }

                if (!empty($search)) {
                    $conditions[] = "(namaBuku LIKE ? OR pengarang LIKE ? OR tahunTerbit LIKE ? OR kategori.namaKategori LIKE ?)";
                    $searchParam = "%$search%";
                    $params = array_merge($params, [$searchParam, $searchParam, $searchParam, $searchParam]);
                    $types .= "ssss";
                }

                if (!empty($conditions)) {
                    $query .= " WHERE " . implode(" AND ", $conditions);
                }

                if (!empty($params)) {
                    $stmt = mysqli_prepare($koneksi, $query);
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
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
                            <td><?php echo $data["idBuku"]; ?></td>
                            <td><?php echo $data["namaBuku"]; ?></td>
                            <td><?php echo $data["tahunTerbit"]; ?></td>
                            <td><?php echo $data["pengarang"]; ?></td>
                            <td><?php echo $data["namaKategori"]; ?></td>
                            <td><img src="./images/foto/<?php echo $data["gambar_sampul"]; ?>" alt="sampul-buku" width="70px"></td>
                        </tr>
                <?php
                    }
                }
                if (isset($stmt)) mysqli_stmt_close($stmt);
                if (!$hasResults && !empty($search)) {
                    echo '<tr><td colspan="6" class="text-center text-muted">Tidak ada buku yang ditemukan untuk pencarian "' . htmlspecialchars($search) . '"</td></tr>';
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
                </tr>
            </tfoot>
        </table>
    </div>
</div>