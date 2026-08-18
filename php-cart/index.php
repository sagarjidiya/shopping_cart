<?php
require_once "./common/config.php";

// Show all products (Read - CRUD) & Add product to cart

// Add To Cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION["user_id"];
    $product_id = $_POST["product_id"];

    $sql = "SELECT * FROM cart WHERE user_id=? AND product_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $product_id]);

    if ($stmt->rowCount() > 0) { // check row exist - product already in a cart ?

        $sql = "UPDATE cart SET quantity=quantity+1 WHERE user_id=? AND product_id=?"; // incrase & update quantity
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $product_id]);

    } else { // product not found

        $sql = "INSERT INTO cart(user_id,product_id,quantity) VALUES(?,?,1)"; // Add the product
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $product_id]);

    }

    header("Location:index.php"); // AFTER add product - reload page
    exit;
}

// Select all - Products
$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "./common/header.php";
?>

<h1 class="text-2xl font-bold mb-6">Products</h1>

<div class="grid grid-cols-3 gap-5">

<?php foreach($products as $p){ ?>
<div class="border rounded p-4 bg-white">

    <img src="<?= $p['image']; ?>" class="w-full h-40 object-cover">

    <h2 class="font-bold mt-3"><?= $p['name']; ?></h2>

    <p><?= $p['description']; ?></p>

    <div class="flex justify-between mt-4">

        <b>₹<?= $p['price']; ?></b>

        <form method="post">

            <input type="hidden" name="product_id" value="<?= $p['id']; ?>">

            <button class="bg-blue-600 text-white px-3 py-2 rounded">
                Add To Cart
            </button>

        </form>

    </div>

</div>
<?php } ?>
</div>

<?php include "./common/footer.php"; ?>