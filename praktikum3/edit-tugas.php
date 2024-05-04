<?php
session_start();
include 'server/db.php';

if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo '<script>window.location="login.php"</script>';
    exit; // Menghentikan eksekusi kode selanjutnya jika belum login
}

if (!isset($_GET['id'])) {
    echo '<script>window.location="tugas.php"</script>';
    exit; // Menghentikan eksekusi kode selanjutnya jika tidak ada ID tugas yang diberikan
}

$id_tugas = $_GET['id'];
$tugas = mysqli_query($conn, "SELECT * FROM tb_tugas WHERE tugas_id = '$id_tugas'");
if (mysqli_num_rows($tugas) == 0) {
    echo '<script>window.location="tugas.php"</script>';
    exit; // Menghentikan eksekusi kode selanjutnya jika tidak ada data tugas dengan ID yang diberikan
}

$p = mysqli_fetch_object($tugas);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Tugas</title>
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
            <h2>Edit Data Tugas</h2>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="form-control mb-3" name="matakuliah" required>
                        <option value="">--Pilih Matakuliah--</option>
                        <?php
                        $matakuliah_query = mysqli_query($conn, "SELECT * FROM tb_matakuliah ORDER BY matakuliah_id DESC");
                        while ($r = mysqli_fetch_array($matakuliah_query)) {
                            $selected = ($r['matakuliah_id'] == $p->matakuliah_id) ? 'selected' : '';
                            echo '<option value="' . $r['matakuliah_id'] . '" ' . $selected . '>' . $r['matakuliah_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="text" name="nama" class="form-control mb-3" placeholder="Deskripsi Tugas" value="<?php echo $p->tugas_name ?>" required>
                    <input type="text" name="nama_nim" class="form-control mb-3" placeholder="Nama (NIM)" value="<?php echo $p->nama_nim ?>" required>
                    <img src="tugas/<?php echo $p->tugas_image ?>" width="100px">
                    <input type="hidden" name="file" value="<?php echo $p->tugas_image ?>">
                    <input type="file" name="gambar" class="form-control mb-3">
                    <select class="form-control mb-3" name="format">
                        <option value="">--Format File--</option>
                        <option <?php echo ($p->tugas_format == 'jpg') ? 'selected' : ''; ?>>jpg</option>
                        <option <?php echo ($p->tugas_format == 'jpeg') ? 'selected' : ''; ?>>jpeg</option>
                        <option <?php echo ($p->tugas_format == 'png') ? 'selected' : ''; ?>>png</option>
                        <option <?php echo ($p->tugas_format == 'gif') ? 'selected' : ''; ?>>gif</option>
                        <option <?php echo ($p->tugas_format == 'pdf') ? 'selected' : ''; ?>>pdf</option>
                        <option <?php echo ($p->tugas_format == 'docx') ? 'selected' : ''; ?>>docx</option>
                        <option <?php echo ($p->tugas_format == 'pptx') ? 'selected' : ''; ?>>pptx</option>
                    </select>
                    <select class="form-control mb-3" name="status">
                        <option value="">--Pilih Status--</option>
                        <option value="1" <?php echo ($p->tugas_status == 1) ? 'selected' : ''; ?>>Selesai</option>
                        <option value="0" <?php echo ($p->tugas_status == 0) ? 'selected' : ''; ?>>Belum Mengumpulkan</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="tambah">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    $matakuliah = $_POST['matakuliah'];
                    $tugas = $_POST['nama'];
                    $nama_nim = $_POST['nama_nim'];
                    $format = $_POST['format'];
                    $status = $_POST['status'];
                    $file = $_POST['file'];
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    if ($filename != '') {
                        $type1 = explode('.', $filename);
                        $type2 = $type1[1];
                        $newname = 'tugas' . time() . '.' . $type2;
                        $type_diizinkan = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'pptx');
                        if (!in_array($type2, $type_diizinkan)) {
                            echo '<script>alert("Format File Tidak Diizinkan")</script>';
                        } else {
                            unlink('./tugas/' . $file);
                            move_uploaded_file($tmp_name, './tugas/' . $newname);
                            $nama_gambar = $newname;
                        }
                    } else {
                        $nama_gambar = $file;
                    }

                    $update = mysqli_query($conn, "UPDATE tb_tugas SET 
                        matakuliah_id = '$matakuliah',
                        tugas_name = '$tugas',
                        nama_nim = '$nama_nim',
                        tugas_format = '$format',
                        tugas_image = '$nama_gambar',
                        tugas_status = '$status'
                        WHERE tugas_id = '$id_tugas' ");

                    if ($update) {
                        echo '<script>alert("Ubah Data Berhasil")</script>';
                        echo '<script>window.location = "tugas.php"</script>';
                    } else {
                        echo 'Gagal' . mysqli_error($conn);
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