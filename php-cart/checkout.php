<?php

require_once './common/config.php';

// User must login
if (!isset($_SESSION['user_id'])) {

    header("Location: login.php?redirect=checkout.php");
    exit;

}

// Delete logged-in user's cart
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("DELETE FROM cart WHERE user_id=?");
$stmt->execute([$user_id]);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Confirmed</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center px-5">

    <!-- Success Card -->

    <div class="w-full max-w-md">

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center">
            <div class="w-10 h-10 mx-auto mb-6 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fa-solid fa-check text-green-600 text-2xl"></i>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-3">

                Order Confirmed!

            </h1>

            <p class="text-gray-500 leading-relaxed mb-7">

                Thank you for your purchase.
                Your order has been successfully placed.

            </p>
            <a href="index.php" class="inline-flex items-center justify-center gap-2
                      w-full bg-indigo-600 hover:bg-indigo-700
                      text-white px-6 py-3 rounded-lg
                      font-semibold transition duration-200">

                <i class="fa-solid fa-bag-shopping"></i>

                Continue Shopping

            </a>

        </div>

        <p class="text-center text-gray-400 text-sm mt-5">

            <i class="fa-solid fa-shield-check mr-1"></i>

            Thank you for shopping with us

        </p>

    </div>

</body>

</html>