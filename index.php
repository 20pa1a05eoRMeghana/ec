<?php

//index.php

require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';

$message = '';
$error = '';

if(isset($_GET['token'])) {
    $decoded = JWT::decode($_GET['token'], new Key($key, 'HS256'));
    $message = $decoded->msg;
}

if(isset($_POST["login"])) {
    $connect = mysqli_connect('localhost', 'root', '', 'user_management');

    if(empty($_POST["email"])) {
        $error = 'Please Enter Email Details';
    } else if(empty($_POST["password"])) {
        $error = 'Please Enter Password Details';
    } else {
        $query = "SELECT * FROM user WHERE user_email = ?";
        $statement = $connect->prepare($query);
        $statement->bind_param("s", $_POST["email"]);
        $statement->execute();
        $statement->store_result();
        $statement->bind_result($user_id, $user_name, $user_email, $user_password);
        $statement->fetch();
        if($user_email) {
            if($user_password === $_POST['password']) {
                $token = JWT::encode(
                    array(
                        'iat'		=>	time(),
                        'nbf'		=>	time(),
                        'exp'		=>	time() + 3600,
                        'data'		=>	array(
                            'user_id'	=>	$user_id,
                            'user_name'	=>	$user_name
                        )
                    ),
                    $key,
                    'HS256'
                );
                setcookie("token", $token, time() + 3600, "/", "", true, true);
                header('location:cart1.html');
            } else {
                $error = 'Wrong Password';
            }
        } else {
            $error = 'Wrong Email Address';
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login</title>
</head>
<body>
<div class="container">
    <h1 class="text-center mt-5 mb-5">Login</h1>
    <div class="row">
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">
            <?php
            if($error !== '') {
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
            if($message !== '') {
                echo '<div class="alert alert-info">'.$message.'</div>';
            }
            ?>
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                        <div class="text-center">
                            <input type="submit" name="login" class="btn btn-primary" value="Login" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <p>
        New Here?
        <a href="register.php">
            Click here to register!
        </a>
    </p>
</div>
</body>
</html>
