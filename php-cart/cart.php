<?php
require_once "./common/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Update Quantity */
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST['action'] == "update") {

        $qty = (int)$_POST['quantity'];

        $stmt = $pdo->prepare("UPDATE cart SET quantity=? WHERE id=? AND user_id=?");
        $stmt->execute([
            $qty,
            $_POST['cart_id'],
            $user_id
        ]);

    }

    if ($_POST['action'] == "remove") {

        $stmt = $pdo->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
        $stmt->execute([
            $_POST['cart_id'],
            $user_id
        ]);

    }

    header("Location: cart.php");
    exit;
}


/* Get Cart */

$stmt = $pdo->prepare("
SELECT
cart.id,
cart.quantity,
products.name,
products.price
FROM cart
JOIN products
ON cart.product_id=products.id
WHERE cart.user_id=?
");

$stmt->execute([$user_id]);

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;

include "./common/header.php";
?>

<h1 class="text-2xl font-bold mb-6">
Your Shopping Cart
</h1>

<?php if(count($items)>0){ ?>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">

    <table class="min-w-full">

        <thead class="bg-indigo-600 text-white">

            <tr>
                <th class="px-6 py-4 text-left font-semibold">Product</th>
                <th class="px-6 py-4 text-center font-semibold">Price</th>
                <th class="px-6 py-4 text-center font-semibold">Quantity</th>
                <th class="px-6 py-4 text-center font-semibold">Subtotal</th>
                <th class="px-6 py-4 text-center font-semibold">Action</th>
            </tr>

        </thead>

        <tbody class="divide-y divide-gray-200 bg-white">

        <?php foreach($items as $item){

            $subtotal = $item['price'] * $item['quantity']; // Product price × Quantity.
            $total += $subtotal;

        ?>

            <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-5 font-semibold text-gray-800">
                    <?php echo htmlspecialchars($item['name']); ?>
                </td>
  
                <td class="px-6 py-5 text-center text-gray-600">
                    $<?php echo number_format($item['price'],2); ?>
                </td>

                <td class="px-6 py-5 text-center">

                    <form method="post">

                        <input
                            type="hidden"
                            name="action"
                            value="update">

                        <input
                            type="hidden"
                            name="cart_id"
                            value="<?php echo $item['id']; ?>">

                        <input
                            type="number"
                            name="quantity"
                            value="<?php echo $item['quantity']; ?>"
                            min="1"
                            class="w-20 text-center border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            onchange="this.form.submit()">

                    </form>

                </td>

                <td class="px-6 py-5 text-center font-bold text-indigo-600">
                    $<?php echo number_format($subtotal,2); ?>
                </td>

                <td class="px-6 py-5 text-center">

                    <form method="post">

                        <input
                            type="hidden"
                            name="action"
                            value="remove">

                        <input
                            type="hidden"
                            name="cart_id"
                            value="<?php echo $item['id']; ?>">

                        <button
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<h2 class="text-xl font-bold mt-5">
Total : $<?php echo number_format($total,2); ?>
</h2>

<a
href="checkout.php"
class="bg-indigo-600 text-white px-5 py-2 rounded inline-block mt-4">
Checkout
</a>

<?php } else { ?>

<p>Your cart is empty.</p>

<?php } ?>

<?php include "./common/footer.php"; ?>