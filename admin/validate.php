<?php

include_once('conn.php');

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    
    // Prepare the SQL statement
    $stmt = $con->prepare("SELECT * FROM adminlogin");
    
    // Execute the SQL statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Fetch all rows as an associative array
    $users = $result->fetch_all(MYSQLI_ASSOC);
    
    // Check each user
    $authenticated = false;
    foreach($users as $user) {
        if (($user['username'] == $username) && ($user['password'] == $password)) {
            $authenticated = true;
            break; // No need to continue once authenticated
        }
    }
    
    if ($authenticated) {
        // Redirect to admin page
        header("location: adminpage.php");
        exit(); // Terminate script after redirection
    } else {
        // Display error message
        echo "<script language='javascript'>";
        echo "alert('WRONG INFORMATION')";
        echo "</script>";
        die(); // Terminate script
    }
}
?>
