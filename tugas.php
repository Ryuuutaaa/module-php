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
                <li><a href="matakuliah.php">Matakuliah</a></li>
                <li><strong><a href="tugas.php">Tugas</a></strong></li>
                <li><a href="logout.php">| LOGOUT |</a></li>
            </ul>
        </div>
    </header>
    <!-- content -->
    <div class="section">
        <div class="container">
            <h2>Tugas</h2>
            <div class="box">
                <p><a href="tambah-tugas.php" class="tambah">Tambah Data</a></p>
                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Matakuliah</th>
                            <th>Deskripsi Tugas</th>
                            <th>Nama & NIM</th>
                            <th>File Tugas</th>
                            <th>Format Tugas</th>
                            <th>Status</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $tugas = mysqli_query($conn, "SELECT * FROM tb_tugas LEFT JOIN tb_matakuliah USING (matakuliah_id) ORDER BY tugas_id DESC");
                        if (mysqli_num_rows($tugas) > 0) {
                            while ($row = mysqli_fetch_array($tugas)) {
                        ?>
                                <tr>
                                    <td align="center"><?php echo $no++ ?></td>
                                    <td><?php echo $row['matakuliah_name'] ?></td>
                                    <td><?php echo $row['tugas_name'] ?></td>
                                    <td><?php echo $row['nama_nim'] ?></td>
                                    <td><a href="tugas/<?php echo $row['tugas_image'] ?>" target="_blank"><img src="tugas/<?php echo $row['tugas_image'] ?>" width=100px></a></td>
                                    <td><?php echo $row['tugas_format'] ?></td>
                                    <td><?php echo ($row['tugas_status'] == 0) ? 'Belum Mengumpulkan' : 'Selesai'; ?></td>
                                    <td align="center">
                                        <a href="edit-tugas.php?id=<?php echo $row['tugas_id'] ?>">Edit</a> ||
                                        <a href="hapus.php?idp=<?php echo $row['tugas_id'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8" align="center">Tidak Ada Data</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
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