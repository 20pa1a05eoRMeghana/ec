<?php
require('conn.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['product_id'])) {
    // Connect to your database here

    $product_id = $_GET['product_id'];
    $sql = "DELETE FROM products WHERE product_id = $product_id";
    
    if ($con->query($sql) === TRUE) {
        echo json_encode(["message" => "Product with ID $product_id has been deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error deleting product"]);
    }
}

// the below code is to delete the product from the cart when clicking "delete from cart"
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $_SERVER['REQUEST_URI'] === '/E-Commerce-Website-Main/user_management.php/cart') {
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['product_id'])) {
        $productId = $data['product_id'];
        $sql = "DELETE FROM cart WHERE product_id = $productId";
        if ($con->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Product deleted from cart successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error deleting product from cart"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Product ID is missing"]);
    }
    exit(); 
}

if($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];
    $product = [];
    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }

    echo json_encode(["product" => $product]);
}
if($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['id'])){
    $id = $_GET['id'];
    $users = [];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $users = $result->fetch_assoc();
    }

    echo json_encode(["users" => $users]);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/E-Commerce-Website-Main/user_management.php/cart') {
    $cart = [];
    $sql = "SELECT * FROM cart";
    $results = $con->query($sql);
    if ($results && $results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            $cart[] = $row;
        }
        echo json_encode(["success" => true, "cart" => $cart]);
    } else {
        echo json_encode(["success" => false, "message" => "No items in cart"]);
    }
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/E-Commerce-Website-Main/user_management.php/products') {
    $products = [];
    $sql = "SELECT * FROM products";
    $results = $con->query($sql);
    if ($results && $results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode(["success" => true, "products" => $products]);
    } else {
        echo json_encode(["success" => false, "message" => "No products found"]);
    }
    exit(); 
}

// the below code is to add product from products database to the cart database when clicking the "add to cart" button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/E-Commerce-Website-Main/user_management.php/cart') {
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['product_id'])) {
        $productId = $data['product_id'];
        $sql = "SELECT * FROM products WHERE product_id = $productId";
        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            $productData = $result->fetch_assoc();
            $productName = $productData['name'];
            $productPrice = $productData['price'];
            $productPic = $productData['pic']; // Retrieve product pic URL from database
            $sql = "INSERT INTO cart (product_id, name, price, pic) VALUES ($productId, '$productName', $productPrice, '$productPic')";
            if ($con->query($sql) === TRUE) {
                echo json_encode(["success" => true, "message" => "Product added to cart successfully"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error adding product to cart"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Product not found"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Product ID is missing"]);
    }
    exit(); 
}


if($_SERVER['REQUEST_METHOD']='POST' &&$_SERVER['REQUEST_URI']==='/E-Commerce-Website-Main/user_management.php/register'){
    $data= json_decode(file_get_contents("php://input"), true);
    $id = $data['id']; 
    $username = $data['username']; 
    $name = $data['name']; 
    $mobile = $data['mobile']; 
    $sql="INSERT INTO users (id,username,name,mobile) VALUES ('$id','$username','$name','$mobile')";
    if($con->query($sql)== TRUE) {
        echo json_encode(array("message"=>"New user added"));
    }
    else{
        echo json_encode(array("message"=>"Error Encountered". $con->error));

    }
}
if($_SERVER['REQUEST_METHOD']='POST' &&$_SERVER['REQUEST_URI']==='/E-Commerce-Website-Main/user_management.php/products'){
    $data= json_decode(file_get_contents("php://input"), true);
    $product_id = $data['product_id']; 
    $name = $data['name']; 
    $price = $data['price']; 
    $sql="INSERT INTO products (product_id,name,price) VALUES ('$product_id','$name','$price')";
    if($con->query($sql)== TRUE) {
        echo json_encode(array("message"=>"New product added"));
    }
    else{
        echo json_encode(array("message"=>"Error Encountered". $con->error));

    }
}
if($_SERVER['REQUEST_METHOD']='POST' &&$_SERVER['REQUEST_URI']==='/E-Commerce-Website-Main/user_management.php/orders'){
    $data= json_decode(file_get_contents("php://input"), true);
    $name = $data['name']; 
    $email = $data['email']; 
    $phone = $data['phone']; 
    $address = $data['address']; 
    $sql="INSERT INTO orders (name,email,phone,address) VALUES ('$name','$email','$phone','$address')";
    if($con->query($sql)== TRUE) {
        echo json_encode(array("message"=>"New order placed"));
    }
    else{
        echo json_encode(array("message"=>"Error Encountered". $con->error));

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get PUT request body data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Check if product ID, name, and price are provided
    if (isset($data['product_id']) && isset($data['name']) && isset($data['price'])) {
        // Sanitize input data
        $product_id = mysqli_real_escape_string($con, $data['product_id']);
        $name = mysqli_real_escape_string($con, $data['name']);
        $price = mysqli_real_escape_string($con, $data['price']);

        // Check if the product ID exists
        $check_query = "SELECT COUNT(*) AS count FROM products WHERE product_id = $product_id";
        $result = $con->query($check_query);
        $row = $result->fetch_assoc();
        $product_exists = $row['count'] > 0;

        if ($product_exists) {
            // Update product details in the database
            $sql = "UPDATE products SET name = '$name', price = '$price' WHERE product_id = $product_id";
            if ($con->query($sql) === TRUE) {
                echo json_encode(["message" => "Product details updated successfully"]);
            } else {
                echo json_encode(["error" => "Error updating product details: " . $con->error]);
            }
        } else {
            echo json_encode(["error" => "Product ID does not exist"]);
        }
    } else {
        echo json_encode(["error" => "Product ID, name, and price must be provided in JSON format"]);
    }
}

?>