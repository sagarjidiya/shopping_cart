<?php
require_once "./common/config.php";


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM users WHERE username=?"; // check exist usernamme 
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]); // run prepared sql quuery

    if ($stmt->rowCount() > 0) { // check matching any record ?

        $message = "Username already exists.";

    } else { // username not exist;

        $sql = "INSERT INTO users(username,password) VALUES(?,?)"; // add new user
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $password]);

        header("Location: login.php");
        exit;
    }
}

include "./common/header.php";
?>

<div class="max-w-md mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold text-center mb-5">
        Signup
    </h2>

    <?php if($message!=""){ ?>

        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <form method="post">

        <div class="mb-4">
            <label>Username</label>

            <input
                type="text"
                name="username"
                class="border w-full p-2 rounded"
                required>
        </div>

        <div class="mb-4">
            <label>Password</label>

            <input
                type="password"
                name="password"
                class="border w-full p-2 rounded"
                required>
        </div>

        <button
            class="bg-blue-600 text-white w-full p-2 rounded">
            Signup
        </button>

    </form>

    <p class="mt-4 text-center">
        <a href="login.php" class="text-blue-600">
            Already have an account? Login
        </a>
    </p>

</div>

<?php include "./common/footer.php"; ?>