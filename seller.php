<?php
session_start();

include('koneksi/koneksi.php');

$sql = "SELECT * FROM akun WHERE username='$_SESSION[username]' OR email='$_SESSION[username]' OR no_telp='$_SESSION[username]'";
$query = mysqli_query($koneksi, $sql);
$data_user = mysqli_fetch_array($query);

$data_foto = $data_user['foto'];

$sqlToko = "SELECT * FROM toko JOIN akun ON toko.id_akun = akun.id_akun WHERE akun.username='$_SESSION[username]' OR akun.email='$_SESSION[username]' OR akun.no_telp='$_SESSION[username]' ";
$queryToko = mysqli_query($koneksi, $sqlToko);
$toko = mysqli_fetch_array($queryToko);

$fotoToko = $toko['foto_toko'];

$wish = "SELECT * FROM wishlist JOIN akun ON wishlist.id_akun = akun.id_akun WHERE akun.username='$_SESSION[username]' OR akun.email='$_SESSION[username]' OR akun.no_telp='$_SESSION[username]' ";
$data_wish = mysqli_query($koneksi, $wish);
$total_wish = mysqli_num_rows($data_wish);

$order = "SELECT * FROM cart JOIN akun ON cart.id_akun = akun.id_akun WHERE akun.username='$_SESSION[username]' OR akun.email='$_SESSION[username]' OR akun.no_telp='$_SESSION[username]' ";
$data_order = mysqli_query($koneksi, $order);
$total_order = mysqli_num_rows($data_order);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>IndoMarket</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/font-awesome.css" rel="stylesheet" />

    <!-- Jquery UI -->
    <link type="text/css" href="./assets/css/jquery-ui.css" rel="stylesheet" />

    <!-- Argon CSS -->
    <link type="text/css" href="./assets/css/argon-design-system.min.css" rel="stylesheet" />

    <!-- Main CSS-->
    <link type="text/css" href="./assets/css/style.css" rel="stylesheet" />

    <!-- Optional Plugins-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
</head>

<body>
    <header class="header clearfix">
        <div class="top-bar d-none d-sm-block pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 text-left right-2">

                    </div>
                    <div class="col-md-6 text-right d-md-none d-lg-block">
                        <ul class="top-links account-links">
                            <?php

                            if ($_SESSION['status'] == "seller") {
                                echo ("
                                    <li>
                                    <i class='ni ni-bag-17'></i> 
                                    <a href='seller.php'>Seller</a>
                                    </li>
                                    <li>
                                    <i class='fa fa-user-circle-o'></i> 
                                    <a href='account.php'>" . $data_user['nama'] . "</a>
                                    </li>
                                    <li>
                                    <i class='fa fa-power-off'></i> 
                                    <a href='#modalKeluar' data-toggle='modal' data-target='#modalKeluar' role='button'>Keluar</a>
                                    </li>");
                            } elseif ($_SESSION['status'] == "member") {
                                echo ("
                                    <li>
                                    <i class='fa fa-address-card-o'></i> 
                                    <a href='register_seller.php'>Ingin Buka Toko?</a>
                                    </li>
                                    <li>
                                    <i class='fa fa-user-circle-o'></i> 
                                    <a href='account.php'>" . $data_user['nama'] . "</a>
                                    </li>
                                    <li>
                                    <i class='fa fa-power-off'></i> 
                                    <a href='#modalKeluar' data-toggle='modal' data-target='#modalKeluar' role='button'>Keluar</a>
                                    </li>");
                            } else {
                                echo ("
                                    <li>
                                    <i class='fa fa-power-off'></i> 
                                    <a href='login.php'>Masuk</a>
                                    </li>");
                            }

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Log Out -->
        <div class="modal fade" id="modalKeluar" tabindex="-1" role="dialog" aria-labelledby="modalKeluar"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logOutModalLabel">Konfirmasi Keluar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin untuk keluar?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a href="proses/logout.php" class="btn btn-danger">Keluar</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="header-main border-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-12 col-sm-6">
                        <a class="navbar-brand mr-lg-5" href="./index.php"> <i class="fa fa-shopping-bag fa-3x"></i>
                            <span class="logo">IndoMarket</span> </a>
                    </div>
                    <div class="col-lg-7 col-12 col-sm-6">
                        <form action="products.php" method="get" class="search">
                            <div class="input-group w-100">
                                <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari" />
                                <div class="input-group-append">
                                    <button id="btnCari" class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-2 col-12 col-sm-6">
                        <div class="right-icons pull-right d-none d-lg-block">
                            <?php
                            if ($_SESSION['status'] == 'member' || $_SESSION['status'] == 'seller'){

                                echo "
                                <div class='single-icon wishlist'>
                                <a href='wishlist.php'><i class='fa fa-heart-o fa-2x'></i></a>
                                <span class='badge badge-default'>".$total_wish."</span>
                                </div>
                                <div class='single-icon shopping-cart'>
                                <a href='cart.php''><i class='fa fa-shopping-cart fa-2x'></i></a>
                                <span class='badge badge-default'>".$total_order."</span>
                                </div>";
                            } else {
                                echo "
                                <div class='single-icon wishlist'>
                                <a href='login.php'><i class='fa fa-heart-o fa-2x'></i></a>
                                </div>
                                <div class='single-icon shopping-cart'>
                                <a href='login.php''><i class='fa fa-shopping-cart fa-2x'></i></a>
                                </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class='navbar navbar-main navbar-expand-lg navbar-light border-top border-bottom'>
            <div class='container'>
                <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#main_nav'
                    aria-controls='main_nav' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>

                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="index.php">Beranda</a>
                        </li>
                        <?php

                    if ($_SESSION['status'] == 'member') {
                        echo ("      
                          <ul class='navbar-nav'>
                          <li class='nav-item dropdown'>
                          <a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' aria-expanded='true'>Laman</a>
                          <div class='dropdown-menu'>
                          <a class='dropdown-item' href='products.php'>Produk</a>
                          <a class='dropdown-item' href='cart.php'>Keranjang</a>
                          <a class='dropdown-item' href='order_detail.php'>Rincian Pesanan</a>
                          </div>
                          </li>
                          <li class='nav-item d-lg-none'>
                          <a class='nav-link' href='register_seller.php'>Ingin Buka Toko?</a>
                          </li>
                          <li class='nav-item d-lg-none'>
                          <a class='nav-link' href='account.php'>$data_user[nama]</a>
                          </li>
                          <li class='nav-item d-lg-none'>
                          <a class='nav-link' href='#modalKeluar' data-toggle='modal' data-target='#modalKeluar' role='button'>Keluar</a>
                          </li>
                          </ul>
                          ");
                    } elseif ($_SESSION['status'] == 'seller') {
                        echo ("<ul class='navbar-nav'>
                          <li class='nav-item dropdown'>
                          <a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' aria-expanded='true'>Laman</a>
                          <div class='dropdown-menu'>
                          <a class='dropdown-item' href='products.php'>Produk</a>
                          <a class='dropdown-item' href='cart.php'>Keranjang</a>
                          <a class='dropdown-item' href='order_detail.php'>Rincian Pesanan</a>
                          </div>
                          </li>
                          <li class='nav-item d-lg-none'>
                          <a class='nav-link' href='register_seller.php'>Ingin Buka Toko?</a>
                          </li>
                          <li class='nav-item d-lg-none'>
                          <a class='nav-link' href='account.php'>$data_user[nama]</a>
                          </li>
                          <li class='nav-item d-lg-none'>
                          <a class='nav-link' href='#modalKeluar' data-toggle='modal' data-target='#modalKeluar'>Keluar</a>
                          </li>
                          </ul>");
                    } else {
                        echo ("<a class='nav-link' href='products.php'>Produk</a>
                            <li class='nav-item d-lg-none'>
                            <a class='nav-link' href='login.php'>Masuk</a>
                            </li>");
                    }

                    ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- breadcumb -->
    <section class="breadcrumb-section pb-3 pt-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Akun Saya</li>
                <li class="breadcrumb-item active" aria-current="page">Seller</li>
            </ol>
        </div>
    </section>

    <!-- profile -->
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="col-12">
                <div class="product-details">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                                    href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                                    aria-selected="true">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                                    href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                    aria-selected="false">Pesanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                                    href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                                    aria-selected="false">Produk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab"
                                    href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4"
                                    aria-selected="false">Stok Produk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab"
                                    href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5"
                                    aria-selected="false">Rincian Toko</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                                    aria-labelledby="tabs-icons-text-1-tab">
                                    <div class="text-center mt-5">
                                        <?php
            if (empty($fotoToko)) {
                echo "<i class='fa fa-user-circle-o mb-3' style='font-size: 10em;'></i>";
            }else{
                echo "<img src='img/".$fotoToko."' class='rounded mx-auto d-flex mb-3' width='300' alt='profile' />";
            }
            ?>
                                        <h3>Nama Toko</h3>
                                        <p><?php echo $toko['nama_toko']; ?></p>
                                        <h5>Alamat Toko</h5>
                                        <p><?php echo $toko['alamat_toko']; ?></p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                                    aria-labelledby="tabs-icons-text-2-tab">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Produk</th>
                                                <th></th>
                                                <th>Variasi</th>
                                                <th>Warna</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
            $sql_tabel="SELECT * FROM checkout JOIN akun ON checkout.id_akun = akun.id_akun JOIN barang ON checkout.id_barang = barang.id_barang JOIN toko ON barang.id_toko = toko.id_toko WHERE akun.username='$_SESSION[username]' OR akun.email='$_SESSION[username]' OR akun.no_telp='$_SESSION[username]'";
            $data_tabel = mysqli_query($koneksi, $sql_tabel);
            $total_tabel = mysqli_num_rows($data_tabel);

            if (!empty($total_tabel)){
                $no = 1;
                foreach ($koneksi->query($sql_tabel) as $data) :
                    echo "<tr>
                    <td>".$no++."</td>
                    <td>".$data['nama_barang']."</td>
                    <td><img src='img/".$data['foto_barang']."' width='100' height='100'></td>
                    <td>".$data['variasi_order']."</td>
                    <td>".$data['warna_order']."</td>
                    <td>".$data['jumlah']."</td>
                    <td>Rp. ".number_format($data['harga_barang'],2,",",".")."</td>
                    <td>".$data['status_order']."</td>
                    <td>
                    <a href='update-order.php?id_checkout=".$data['id_checkout']."' type='button' class='btn btn-warning'>Ubah</a>
                    </td>
                    </tr>";
                endforeach;
                ?>
                                        </tbody>
                                    </table>
                                    <?php } elseif (empty($total_tabel)) {
        echo "</tbody>
        </table>
        <p class='text-center'>Tidak ada pesanan</p>";
    } ?>
                                </div>
                                <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                                    aria-labelledby="tabs-icons-text-3-tab">
                                    <button class="btn btn-primary mb-3" data-toggle="modal"
                                        data-target="#addProductModal">Tambah Produk</button>
                                    <table class="table">
                                        <tr>
                                            <th>No</th>
                                            <th>Produk</th>
                                            <th></th>
                                            <th>Variasi</th>
                                            <th>Warna</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                        <?php
    $sql="SELECT * FROM barang JOIN toko ON barang.id_toko = toko.id_toko JOIN akun ON toko.id_akun = akun.id_akun WHERE akun.username='$_SESSION[username]' OR akun.email='$_SESSION[username]' OR akun.no_telp='$_SESSION[username]' ";
    $data = mysqli_query($koneksi, $sql);
    $total = mysqli_num_rows($data);

    if (!empty($total)){
        $no = 1;
        foreach ($koneksi->query($sql) as $data) :
            echo "<tr>
                <td>".$no++."</td>
                <td>".$data['nama_barang']."</td>
                <td>
                <img src='img/".$data['foto_barang']."' width='100' height='100'>
                </td>
                <td>".$data['variasi']."</td>
                <td>".$data['warna']."</td>
                <td>Rp. ".number_format($data['harga_barang'],2,",",".")."</td>
                <td>
                    <a href='edit_produk.php?id_barang=".$data['id_barang']."' type='button' class='btn btn-warning'>Ubah Produk</a>
                <a href='tambah_stok.php?id_barang=".$data['id_barang']."' type='button' class='btn btn-primary'>Tambah Stok</a>
                <a href='proses/hapus.php?id_barang=".$data['id_barang']."&tipe=produk' type='button' class='btn btn-danger'>Hapus</a>
                </td>
            </tr>
            ";
        endforeach;
        ?>
                                    </table>
                                    <?php } elseif (empty($total)) {
    echo "</table>
    <p class='text-center'>Tidak ada produk</p>";
} ?>
                                </div>
                                <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel"
                                    aria-labelledby="tabs-icons-text-4-tab">
                                    <table class="table">
                                        <tr>
                                            <th>No</th>
                                            <th>Produk</th>
                                            <th></th>
                                            <th>Variasi</th>
                                            <th>Warna</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                        <?php
    $sql="SELECT * FROM barang  JOIN toko ON barang.id_toko = toko.id_toko JOIN stok ON barang.id_barang = stok.id_barang JOIN akun ON toko.id_akun = akun.id_akun WHERE akun.username='$_SESSION[username]' OR akun.email='$_SESSION[username]' OR akun.no_telp='$_SESSION[username]' ";
    $data = mysqli_query($koneksi, $sql);
    $total = mysqli_num_rows($data);

    if (!empty($total)){
        $no = 1;
        foreach ($koneksi->query($sql) as $data) :
            echo "<tr>
                <td>".$no++."</td>
                <td>".$data['nama_barang']."</td>
                <td>
                <img src='img/".$data['foto_barang']."' width='100' height='100'>
                </td>
                <td>".$data['variasi_stok']."</td>
                <td>".$data['warna_stok']."</td>
                <td>".$data['stok_barang']."</td>
                <td>
                <a href='edit_stok.php?id_stok=".$data['id_stok']."&id_barang=".$data['id_barang']."' type='button' class='btn btn-warning'>Ubah Stok</a>
                </td>
            </tr>
            ";
        endforeach;
        ?>
                                    </table>
                                    <?php } elseif (empty($total)) {
    echo "</table>
    <p class='text-center'>Tidak ada produk</p>";
} ?>
                                </div>
                                <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel"
                                    aria-labelledby="tabs-icons-text-5-tab">
                                    <h3>Rincian Toko</h3>
                                    <form method="POST" action="proses/update_toko.php" class="row g-3"
                                        enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            <label for="inputFirstName2" class="form-label">Gambar Profil Toko</label>
                                            <input class="form-control" name="foto_toko" type="file"
                                                id="inputPicture" />
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputFirstName2" class="form-label">Nama Toko</label>
                                            <input type="text" name="nama_toko" class="form-control"
                                                id="inputLastName2" />
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputAddress2" class="form-label">Alamat Toko</label>
                                            <input type="text" name="alamat_toko" class="form-control"
                                                id="inputAddress2" />
                                        </div>
                                        <div>
                                            <input type="hidden" name="id_akun"
                                                value="<?php echo $data_user['id_akun']; ?>">
                                            <input type="hidden" name="id_toko" value="<?php echo $toko['id_toko']; ?>">
                                        </div>
                                        <div class="container">
                                            <button type="submit" class="btn btn-primary mb-5 mt-3">Perbarui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end profile -->

    <!-- modal add product -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="proses/tambah_barang.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nameProduct" class="form-label">Nama Produk</label>
                            <input type="text" name="nama_barang" class="form-control" id="nameProduct" />
                            <input type="hidden" name="id_toko" class="form-control"
                                value="<?php echo $toko['id_toko']; ?>" readonly />
                        </div>
                        <div class="mb-3">
                            <label for="descProduct" class="form-label">Deskripsi Produk</label>
                            <textarea name="deskripsi" class="form-control" id="descProduct" rows="3"></textarea>
                        </div>
                        <div class="mb-3">

                            <label for="descProduct" class="form-label">Kategori Produk</label>
                            <select class="form-control" name="jenis_barang">
                                <option selected disabled>-- Pilih Kategori Barang --</option>
                                <?php
                        $sql = "SELECT * FROM kategori";
                        foreach ($koneksi->query($sql) as $data) :
                            ?>
                                <option value="<?php echo $data['jenis_barang']; ?>">
                                    <?php echo $data['jenis_barang']; ?></option>
                                <?php
                        endforeach;
                        ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Gambar Produk</label>
                            <input class="form-control" type="file" name="foto_barang" id="formFile">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="text" name="harga_barang" class="form-control" id="price" />
                        </div>
                        <div class="mb-3">
                            <label for="variant" class="form-label">Variasi</label>
                            <input type="text" name="variasi" class="form-control" id="variasi" />
                            <!-- <button class="btn btn-primary mt-3 mb-3" onclick="tambahVarian()">Tambah</button> -->
                        </div>
                        <div>
                            <ul id="tampilanVariasi"></ul>
                        </div>
                        <div class="mb-3">
                            <label for="colorVariant" class="form-label">Warna</label>
                            <input type="text" name="warna" class="form-control" id="variasi2" />
                            <!-- <button class="btn btn-primary mt-3 mb-3" onclick="tambahVarian2()">Tambah</button> -->
                        </div>
                        <div>
                            <ul id="tampilanVariasi2"></ul>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer bg-primary">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer about">
                            <div class="logo-footer"><i class="fa fa-shopping-bag fa-3x"></i> <span
                                    class="logo">IndoMarket</span></div>
                            <p class="text"></p>
                            <p class="call">
                                Punya Pertanyaan? Hubungi Kami<span><a href="tel:08113030391">0811 3030 391</a></span>
                            </p>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer links">
                            <h4>Informasi</h4>
                            <ul>
                                <li><a href="#">Tentang Kami</a></li>
                                <li><a href="#">Syarat &amp; Ketentuan</a></li>
                                <li><a href="#">Kontak Kami</a></li>
                                <li><a href="#">Kebijakan Privasi</a></li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer links">
                            <h4>Layanan</h4>
                            <ul>
                                <li><a href="#">Metode Pembayaran</a></li>
                                <li><a href="#">Ajukan Pengembalian</a></li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer social">
                            <h4>Kontak Kami</h4>
                            <!-- Single Widget -->
                            <div class="contact">
                                <ul>
                                    <li>Jl. Cipunegara No. 54, Purwantoro, Kec. Blimbing, Kota Malang, Jawa Timur</li>
                                    <li>65122 Indonesia</li>
                                    <li>info@indomarket.com</li>
                                    <li>0811 3030 391</li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                            <ul>
                                <li>
                                    <a href="#"><i class="ti-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ti-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ti-flickr"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ti-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="copyright-inner border-top">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="left">
                                <p>Copyright ?? 2022 <a href="http://indokoding.net" target="_blank">IndoKoding.net</a> -
                                    All Rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Core -->
    <script src="./assets/js/core/jquery.min.js"></script>
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/core/jquery-ui.min.js"></script>

    <!-- Optional plugins -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Argon JS -->
    <script src="./assets/js/argon-design-system.js"></script>


    <!-- Main JS-->
    <script src="./assets/js/main.js"></script>

    <script type="text/javascript">
    // tombol tambah
    // function tambahVarian() {
    //   var li = document.createElement("li");
    //   var inputValue = document.getElementById("variasi").value;
    //   var t = document.createTextNode(inputValue);
    //   li.appendChild(t);
    //   document.getElementById("tampilanVariasi").appendChild(li);
    //   document.getElementById("variasi").value = "";

    //   var span = document.createElement("span");
    //   var txt = document.createTextNode("\u00D7");
    //   span.className = "close";
    //   span.appendChild(txt);
    //   li.appendChild(span);

    //   for (i = 0; i < close.length; i++) {
    //     close[i].onclick = function () {
    //       var div = this.parentElement;
    //       div.style.display = "none";
    //     };
    //   }
    // }

    // function tambahVarian2() {
    //   var li = document.createElement("li");
    //   var inputValue = document.getElementById("variasi2").value;
    //   var t = document.createTextNode(inputValue);
    //   li.appendChild(t);
    //   document.getElementById("tampilanVariasi2").appendChild(li);
    //   document.getElementById("variasi2").value = "";

    //   var span = document.createElement("span");
    //   var txt = document.createTextNode("\u00D7");
    //   span.className = "close";
    //   span.appendChild(txt);
    //   li.appendChild(span);

    //   for (i = 0; i < close.length; i++) {
    //     close[i].onclick = function () {
    //       var div = this.parentElement;
    //       div.style.display = "none";
    //     };
    //   }
    // }

    // // tombol hapus di setiap list
    // var close = document.getElementsByClassName("close");
    // var i;
    // for (i = 0; i < close.length; i++) {
    //   close[i].onclick = function() {
    //     li.style.display = "none";
    //   }
    // }

    // var close = document.getElementsByClassName("close");
    // var i;
    // for (i = 0; i < close.length; i++) {
    //   close[i].onclick = function() {
    //     li.style.display = "none";
    //   }
    // }
    </script>

</body>

</html>