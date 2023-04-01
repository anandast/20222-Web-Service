<?php
include 'conn.php';
$err = "";
$remember = "";
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
if (isset($_COOKIE['cookie_username'])) {
    $cookie_username = $_COOKIE['cookie_username'];
    $cookie_password = $_COOKIE['cookie_password'];

    $sql = "SELECT * from users WHERE username = '$cookie_username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rows   = $result->fetch_assoc();
        if ($rows['password'] == $cookie_password) {
            $_SESSION['username'] = $cookie_username;
            $_SESSION['password'] = $cookie_password;
        }
    }
}
if (isset($_POST['login'])) {
    $user = strtolower(stripslashes($_POST['username']));
    $pass = md5($_POST['password']);
    $remember = $_POST['remember'];
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rows = $result->fetch_assoc();
        $_SESSION['username'] = $rows['username'];
        $_SESSION['password'] = $rows['password'];
        if ($remember == 1) {
            $cookie_name = "cookie_username";
            $cookie_value = $user;
            $cookie_time = time() + (60 * 60 * 24 * 30);
            setcookie($cookie_name, $cookie_value, $cookie_time, "/");

            $cookie_name = "cookie_password";
            $cookie_value = $pass;
            $cookie_time = time() + (60 * 60 * 24 * 30);
            setcookie($cookie_name, $cookie_value, $cookie_time, "/");
        }
        header('Location:index.php');
    } else {
        $err = "<h6>Username or password was wrong!</h6>";
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
</head>

<body>
    <div class="container">

        <div class="row">

            <div class="col-md-6 offset-md-3">

                <h5 class="text-center text-dark mt-5">Login</h5>
                <?php if ($err !== "") { ?>
                    <div id="login-alert" class="alert alert-danger col-sm-12">
                        <?php echo $err ?>
                    </div>
                <?php } ?>
                <div class="card my-4 bg-light mb-3">
                    <form class="card-body" action="" method="post">
                        <div class="row mb-3">
                            <label for="inputUsername" class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input required type="username" class="form-control" id="inputUsername" name="username">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input required type="password" class="form-control" id="inputPassword" name="password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" value=1 <?php if ($remember == '1') echo "checked" ?>>
                                <label class="form-check-label" for="gridCheck">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                        <div id="emailHelp" class="form-text text-center mb-5 text-dark">Not Registered? <a href="/20222 Web Service/Pertemuan2 - Latihan2/register.php" class="text-dark fw-bold">Create an account</a></div>
                    </form>
                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>