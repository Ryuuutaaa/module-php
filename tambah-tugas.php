<?php
session_start();
include 'server/db.php';

if ($_SESSION['status_login'] != true) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $matakuliah = $_POST['matakuliah'];
    $nama = $_POST['nama'];
    $nama_nim = $_POST['nama_nim'];
    $format = $_POST['format'];
    $status = $_POST['status'];

    $filename = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $type1 = explode('.', $filename);
    $type2 = end($type1);
    $newname = 'tugas_' . time() . '.' . $type2;

    $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'pptx');

    if (!in_array($type2, $allowed_types)) {
        echo '<script>alert("Format File Tidak Diizinkan")</script>';
    } else {
        move_uploaded_file($tmp_name, './tugas/' . $newname);
        $date_created = date('Y-m-d H:i:s'); // Tambahkan ini untuk mendapatkan waktu saat ini

        $insert = mysqli_query($conn, "INSERT INTO tb_tugas VALUES (
            null,
            '$matakuliah',
            '$nama',
            '$nama_nim',
            '$format',
            '$newname',
            '$status',
            '$date_created'  -- Tambahkan date_created ke dalam VALUES
        )");

        if ($insert) {
            echo '<script>alert("Simpan Data Berhasil")</script>';
            echo '<script>window.location = "tugas.php"</script>';
        } else {
            echo 'Gagal ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="public/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="public/css/matakuliah.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
            <img src="public/image/logo.png" width="200px">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="matakuliah.php">Matakuliah</a></li>
                <li><strong><a href="tugas.php">Tugas</a></strong></li>
                <li><a href="logout.php">| LOGOUT |</a></li>
            </ul>
        </div>
    </header>
    <!-- content -->
    <div class="section">
        <div class="container">
            <h2>Tambah Data Tugas</h2>
            <div class="box">
                <form action="tambah-tugas.php" method="POST" enctype="multipart/form-data">
                    <select class="form-control mb-3" name="matakuliah" required>
                        <option value="">--Pilih Matakuliah--</option>
                        <?php
                        $matakuliah = mysqli_query($conn, "SELECT * FROM tb_matakuliah ORDER BY matakuliah_id DESC");
                        while ($r = mysqli_fetch_array($matakuliah)) {
                            echo '<option value="' . $r['matakuliah_id'] . '">' . $r['matakuliah_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="text" name="nama" class="form-control mb-3" placeholder="Deskripsi Tugas" required>
                    <input type="text" name="nama_nim" class="form-control mb-3" placeholder="Nama (NIM)" required>
                    <input type="file" name="gambar" class="form-control mb-3" required>
                    <select class="form-control mb-3" name="format">
                        <option value="">--Format Tugas--</option>
                        <option>jpg</option>
                        <option>jpeg</option>
                        <option>png</option>
                        <option>gif</option>
                        <option>pdf</option>
                        <option>docx</option>
                        <option>pptx</option>
                    </select>

                    <select class="form-control mb-3" name="status">
                        <option value="">--Pilih Status Tugas--</option>
                        <option value="1">Selesai</option>
                        <option value="0">Belum mengumpulkan</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="tambah">
                </form>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2021 INSTITUT BISNIS DAN TEKNOLOGI INDONESIA</small>
        </div>
    </footer>
</body>

</html>