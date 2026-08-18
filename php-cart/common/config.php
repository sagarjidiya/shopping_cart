<?php

// Session already active hai → session_start() nahi chalega.

if(session_status() === PHP_SESSION_NONE ){
    session_start();
}

$host = "localhost";
$dbname = "shopping_cart";
$user = "root";
$pass = "";

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Connection Failed");

}

// Cart Count

if(!function_exists('get_cart_count')){
    function get_cart_count(){
        global $pdo;
    
        if (!isset($_SESSION['user_id'])) {
            return 0;
        } // If user isn't logged in
    
        $user_id = $_SESSION['user_id'];
    
        $sql = "SELECT SUM(quantity) AS total FROM cart WHERE user_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row['total'] == NULL) {
            return 0;
        }
    
        return $row['total'];
    }
}

?>