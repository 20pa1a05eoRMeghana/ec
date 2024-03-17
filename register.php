<?php 

//register.php

$error = '';
$message = '';

if(isset($_POST['register'])) {
    $connect = mysqli_connect('localhost', 'root', '', 'user_management');

    if(empty($_POST['name'])) {
        $error = 'Please Enter Name Details';
    } elseif(empty($_POST['email'])) {
        $error = 'Please Enter Email Details';
    } elseif(empty($_POST['password'])) {
        $error = 'Please Enter Password Details';
    } else {
        $query = "SELECT user_id FROM user WHERE user_email = ?";
        $statement = $connect->prepare($query);
        $statement->bind_param("s", $_POST["email"]); // Bind parameters
        $statement->execute(); // Execute the statement
        $result = $statement->get_result(); // Get the result
        if($result->num_rows > 0) {
            $error = 'Email Already Exists';
        } else {
            $data = array(
                ':user_email'		=>	trim($_POST['email']),
                ':user_password'	=>	trim($_POST['password']),
                ':user_name'		=>	trim($_POST['name'])
            );

            $insertQuery = "INSERT INTO user (user_email, user_password, user_name) VALUES (?, ?, ?)";
            $statement = $connect->prepare($insertQuery);
            $statement->bind_param("sss", $data[':user_email'], $data[':user_password'], $data[':user_name']); // Bind parameters
            if($statement->execute()) { // Execute the statement
                $message = 'Registration Complete!';
            } else {
                $error = 'Registration Failed';
            }
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

        <title>PHP Registration</title>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center mt-5 mb-5">Registration</h1>
            <div class="row">
                <div class="col-md-4">&nbsp;</div>
                <div class="col-md-4">
                    <?php
                    if($error !== '') {
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }

                    if($message !== '') {
                        echo '<div class="alert alert-success">'.$message.'</div>';
                    }
                    ?>
                    <div class="card">
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" />
                                </div>
                                <div class="text-center">
                                    <input type="submit" name="register" value="Register" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="text-center">
    <p>
        Already have Account?
        <a href="index.php">
            Click here to login!
        </a>
    </p>
</div>
    </body>
</html>
