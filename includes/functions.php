<?php

function getProductsByCategory($pdo, $categoryId)
{
    $stmt = $pdo->prepare("
        SELECT * FROM products 
        WHERE category_id = :cat_id 
        AND is_active = TRUE 
        ORDER BY id DESC
    ");
    $stmt->execute(['cat_id' => $categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function displayProductCard($item)
{
?>
    <div class="product-card">
        <img src="/assets/images/<?php echo htmlspecialchars($item['image']); ?>"
            alt="<?php echo htmlspecialchars($item['name']); ?>">
        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
        <p class="price">KES <?php echo number_format($item['price'], 0); ?></p>
        <button class="add-to-cart-btn" data-id="<?php echo htmlspecialchars($item['id']); ?>">
            Add to Cart
        </button>
    </div>
<?php
}
function checkAdminSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
    }
}
