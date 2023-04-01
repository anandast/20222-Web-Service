<?php
include 'conn.php';
$err = "";
if (isset($_POST['register'])) {
    $user = strtolower(stripslashes($_POST['inputUsername']));
    $pass = md5($_POST['inputPassword']);
    $confirmpass = md5($_POST['inputConfirmPass']);

    if ($pass !== $confirmpass) {
        $err = '<h6>Passwords do not match! Please fill match password</h6>';
    } else {
        $sql = "SELECT * FROM users WHERE username = '$user' ";
        $result = $conn->query($sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users(`username`,`password`) VALUES('$user','$pass')";
            if ($conn->query($sql) === TRUE) {
                header('Location:login.php');
            }
        } else {
            $err = "<h6>Username already in use, please use another username</h6>";
        }
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

                <h5 class="text-center text-dark mt-5">Registration Account</h5>
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
                                <input required type="username" class="form-control" id="inputUsername" name="inputUsername">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input required type="password" class="form-control" id="inputPassword" name="inputPassword">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputConfirmPass" class="col-sm-4 col-form-label">Confirm Password</label>
                            <div class="col-sm-12">
                                <input required type="password" class="form-control" id="inputConfirmPass" name="inputConfirmPass">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="register">Sign up</button>
                        <div id="emailHelp" class="form-text text-center mb-5 text-dark">Already have account? <a href="/20222 Web Service/Pertemuan2 - Latihan2/login.php" class="text-dark fw-bold">Login</a></div>
                    </form>
                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>