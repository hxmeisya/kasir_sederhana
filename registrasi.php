<?php
require 'functions.php';

$query = "SHOW COLUMNS FROM pegawai LIKE 'admin'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$type = $row['Type'];
preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);

$enumValues = explode("','", $matches[1]);

if (isset($_POST['registrasi'])) {
    if (registrasi($_POST) > 0) {
        echo "<script>alert('User baru berhasil ditambahkan!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('User baru gagal ditambahkan! Coba lagi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Daftar</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Daftar</h3></div>
                                <div class="card-body">
                                    <form method="post" action="">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputName" name="nama" type="text" placeholder="Enter your name" required />
                                            <label for="inputName">Nama</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputAdmin" name="admin" required>
                                                <option value="">Pilih Role</option>
                                                <?php foreach ($enumValues as $value): ?>
                                                    <option value="<?php echo $value; ?>"><?php echo ucfirst($value); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="inputAdmin">Role</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPhone" name="no_hp" type="text" placeholder="Enter your phone number" required />
                                            <label for="inputPhone">No HP</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputAddress" name="alamat" type="text" placeholder="Enter your address" required />
                                            <label for="inputAddress">Alamat</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Enter a username" required />
                                            <label for="inputUsername">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputConfirmPassword" name="password2" type="password" placeholder="Confirm your password" required />
                                            <label for="inputConfirmPassword">Konfirmasi Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" name="registrasi" class="btn btn-primary">Daftar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Sudah punya akun? Masuk!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
