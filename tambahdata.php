<?php
require_once 'auth.php';
require_admin();
?>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
        <h3 class="card-header" style="text-align: center;"> Form Tambah Data
            <button type="button" class="btn btn-space btn-secondary" style="float: right; border-radius: 5px;">
                <a href="?page=tampildata" style="color: white">Kembali</a>
            </button>
        </h3>
        <div class="card-body">
            <?php
                include "koneksi.php";
                if(isset($_POST["simpan"])){
                    $idBuku = $_POST["idBuku"];
                    $namaBuku = $_POST["namaBuku"];
                    $tahunTerbit = $_POST["tahunTerbit"];
                    $pengarang = $_POST["pengarang"];
                    $idKategori = $_POST["idKategori"];
                    $gambarSampul = $_FILES["gambar_sampul"]["name"];
                    $tmp = $_FILES["gambar_sampul"]["tmp_name"];

                    $input = "INSERT INTO buku VALUES ('$idBuku','$namaBuku','$tahunTerbit','$pengarang','$idKategori','$gambarSampul')";
                    $query = mysqli_query($koneksi, $input);
                    move_uploaded_file($tmp, "./images/foto/$gambarSampul");
                    if($query){
                        echo "<div class='alert alert-success fade show' role='alert'>
                            Data Berhasil Ditambahkan! <a href='?page=tampildata'>lihat data</a>
                            </div>";
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                            Data Gagal Ditambahkan!
                            </div>";
                    }
                }
            ?>

            <form method="POST" class="needs-validation" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                        <label for="validationCustom01">id Buku</label>
                        <input type="text" class="form-control" name="idBuku" id="validationCustom01" required>
                        <div class="invalid-feedback">
                            kode tidak boleh kosong!
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                        <label for="validationCustom02">Nama Buku</label>
                        <input type="text" class="form-control" name="namaBuku" id="validationCustom02" required>
                        <div class="invalid-feedback">
                            nama buku tidak boleh kosong!
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                        <label for="validationCustom03">Tahun Terbit</label>
                        <input type="text" class="form-control" name="tahunTerbit" id="validationCustom03" required>
                        <div class="invalid-feedback">
                            tahun tidak boleh kosong
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                        <label for="validationCustom04">Pengarang</label>
                        <input type="text" class="form-control" name="pengarang" id="validationCustom04" required>
                        <div class="invalid-feedback">
                            pengarang tidak boleh kosong!
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                        <label for="validationCustom05">Kategori</label>
                        <select name="idKategori" id="validationCustom05" class="form-control" required>
                            <option value="" disabled selected hidden>Pilih Kategori...</option>
                            <?php
                            $relasi1 = "SELECT * FROM kategori";
                            $eksekusi = mysqli_query($koneksi, $relasi1);
                            while($ambilData = mysqli_fetch_array($eksekusi)){
                                echo "<option value='$ambilData[idKategori]'>$ambilData[namaKategori]</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> <br>
                        <label>File Upload</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" name="gambar_sampul" id="customFile">
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