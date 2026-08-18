<?php
require_once "./common/config.php";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // on click login 

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : "index.php";

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) { // chec user found in db

        if ($user["password"] == $password) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: ".$redirect);
            exit;

        } else {

            $error = "Wrong Password";

        }

    } else {

        $error = "Username not found";

    }

}

include "./common/header.php";
?>

<div class="max-w-md mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold text-center mb-5">
        Login
    </h2>

    <?php if($error!=""){ ?>

        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?php echo $error; ?>
        </div>

    <?php } ?>

    <!-- action inside write "<php echo $_SERVER['PHP_SELF'] >" ACTION PERFORM SAME page  -->

    <form method="post">

        <div class="mb-4">
            <label>Username</label>

            <input
                type="text"
                name="username"
                value="<?php echo htmlspecialchars($username); ?>"
                value="<?php echo htmlspecialchars($username);?>"
                class="border w-full p-2 rounded";\
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

        <button class="bg-blue-600 text-white w-full p-2 rounded">
            Login
        </button>

    </form>

    <p class="mt-4 text-center">
        <a href="signup.php" class="text-blue-600">
            Create New Account
        </a>
    </p>

</div>

<?php include "./common/footer.php"; ?>