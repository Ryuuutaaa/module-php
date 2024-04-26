<?php
session_start();
include 'server/db.php';

if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
    exit;
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
                <li><strong><a href="matakuliah.php">Matakuliah</a></strong></li>
                <li><a href="tugas.php">Tugas</a></li>
                <li><a href="logout.php">| LOGOUT |</a></li>
            </ul>
        </div>
    </header>
    <!-- content -->
    <div class="section">
        <div class="container">
            <h2>Tambah Data Matakuliah</h2>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama Matakuliah" class="form-control mb-3" required>
                    <input type="submit" name="submit" value="Submit" class="tambah">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    $nama = mysqli_real_escape_string($conn, ucwords($_POST['nama']));
                    $insert = mysqli_query($conn, "INSERT INTO tb_matakuliah (matakuliah_name) VALUES ('$nama')");
                    if ($insert) {
                        echo '<script>alert("Tambah Matakuliah BERHASIL")</script>';
                        echo '<script>window.location = "matakuliah.php"</script>';
                    } else {
                        echo 'gagal ' . mysqli_error($conn);
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2021 - INSTITUT BISNIS DAN TEKNOLOGI INDONESIA</small>
        </div>
    </footer>
</body>

</html>