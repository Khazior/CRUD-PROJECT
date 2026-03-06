<?php
require_once 'auth.php';
require_admin();

include "koneksi.php";
if (isset($_GET["idBuku"])) {
    $idBuku = $_GET["idBuku"];
    $tampil = "SELECT * FROM buku WHERE idBuku = '$idBuku'";
    $qtampil = mysqli_query($koneksi, $tampil);
    $data = mysqli_fetch_array($qtampil);
}
?>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h3 class="card-header" style="text-align: center;">Form Ubah Data
                <button type="button" class="btn btn-space btn-secondary" style="float: right; border-radius: 5px">
                    <a href="?page=tampildata" style="color: white;">Kembali</a>
                </button>
            </h3>
            <div class="card-body">
                <?php
                include "koneksi.php";
                if (isset($_POST["simpan"])) {
                    $namaBuku = $_POST["namaBuku"];
                    $tahunTerbit = $_POST["tahunTerbit"];
                    $pengarang = $_POST["pengarang"];
                    $kategori = $_POST["idKategori"];
                    $gambarSampul = $_FILES["gambar_sampul"]["name"];
                    $tmp = $_FILES["gambar_sampul"]["tmp_name"];

                    if (strlen($gambarSampul > 0)) {
                        $input = "UPDATE buku SET namaBuku='$namaBuku', tahunTerbit='$tahunTerbit', pengarang='$pengarang', idKategori='$kategori', gambar_sampul='$gambarSampul' WHERE idBuku='$idBuku'";
                        $query = mysqli_query($koneksi, $input);
                        move_uploaded_file($tmp, "./images/foto/$gambarSampul");
                    } else {
                        $input = "UPDATE buku SET namaBuku='$namaBuku', tahunTerbit='$tahunTerbit', pengarang='$pengarang', idKategori='$kategori' WHERE idBuku='$idBuku'";
                        $query = mysqli_query($koneksi, $input);
                    }

                    if ($query) {
                        echo "<div class='alert alert-success fade show' role='alert'>
                            Data Berhasil Diubah! <a href='?page=tampildata'>Lihat Data</a>
                            </div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>
                            Data Gagal Diubah!
                            </div>";
                    }
                }
                ?>

                <form method="POST" class="needs-validation" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                            <label for="validationCustom01">id Buku</label>
                            <input type="text" class="form-control" name="idBuku" value="<?php echo $data["idBuku"]; ?>" id="validationCustom01" disabled>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                            <label for="validationCustom02">Nama Buku</label>
                            <input type="text" class="form-control" name="namaBuku" value="<?php echo $data["namaBuku"]; ?>" id="validationCustom02" required>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                            <label for="validationCustom03">Tahun Terbit</label>
                            <input type="text" class="form-control" name="tahunTerbit" value="<?php echo $data["tahunTerbit"]; ?>" id="validationCustom03" required>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                            <label for="validationCustom04">Pengarang</label>
                            <input type="text" class="form-control" name="pengarang" value="<?php echo $data["pengarang"]; ?>" id="validationCustom04" required>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                            <label for="validationCustom05">Kategori</label>
                            <select name="idKategori" id="validationCustom05" class="form-control">
                                <?php
                                $relasi1 = "SELECT * FROM kategori";
                                $eksekusi = mysqli_query($koneksi, $relasi1);
                                while ($ambilData = mysqli_fetch_array($eksekusi)) {
                                    $pilih = ($data["idKategori"] == $ambilData["idKategori"]) ? "selected" : "";
                                    echo "<option value='{$ambilData['idKategori']}' {$pilih}>{$ambilData['namaKategori']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                            <img src="./images/foto/<?php echo $data["gambar_sampul"]; ?>" width="70px" alt="sampul-buku">
                            <label>Foto Saat Ini</label>

                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" name="gambar_sampul" id="customFile">
                                <label class="custom-file-label" for="customFile">Pilih file...</label>
                            </div> <br>

                            <button type="submit" name="simpan" class="btn btn-space btn-primary" style="border-radius: 5px;">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-space btn-secondary" style="border-radius: 5px;">
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>