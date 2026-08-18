<?php require_once "./common/config.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Shopping Cart</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<header class="bg-white shadow">
    <div class="max-w-5xl mx-auto flex justify-between items-center p-4">

        <a href="index.php" class="text-2xl font-bold text-blue-600">
            Gadget Shop
        </a>

        <div class="space-x-4">

            <a href="index.php">Products</a>

            <a href="cart.php">
                Cart (<?php echo get_cart_count(); ?>)
            </a>
    

            <!-- user is login ?? -->
            <?php if(isset($_SESSION['user_id'])){ ?> 

                <span>
                    Hello,
                    <?php echo $_SESSION['username']; ?>
                </span>
                <!-- destroy session -->
                <a href="logout.php" class="text-red-500"> 
                    Logout
                </a>

            <?php } else { ?>

                <a href="login.php">
                    Login
                </a>

                <a href="signup.php">
                    Signup
                </a>

            <?php } ?>

        </div>

    </div>
</header>

<div class="max-w-5xl mx-auto p-5">