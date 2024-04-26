<?php
if (isset($_POST['submit'])) {
    session_start();
    include 'server/db.php';
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $cek = mysqli_query($conn, "SELECT * FROM tb_profil WHERE username = '$user' AND password = '$pass'");
    if (mysqli_num_rows($cek) > 0) {
        $d = mysqli_fetch_object($cek);
        $_SESSION['status_login'] = true;
        $_SESSION['a_global'] = $d;
        $_SESSION['id'] = $d->admin_id;
        echo '<script>
        alert("Berhasil login")
        window.location="dashboard.php"
        </script>';
    } else {
        echo '<script>alert("Username atau Password anda salah!")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/login.css">
    <title>Document</title>
</head>

<body id="bg-login">
    <div class="box-login">
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="text" name="user" placeholder="Username" class="input-control">
            <input type="password" name="pass" placeholder="Password" class="input-control">
            <input type="submit" name="submit" value="Login" class="btn">
        </form>
    </div>
</body>

</html>