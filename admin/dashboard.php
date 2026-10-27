<?php
require_once 'auth.php';
require_once '../includes/db.php';

$message = '';

// ---- Handle actions (POST only) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $id     = (int) ($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($action === 'toggle') {
        $pdo->prepare("UPDATE products SET is_active = NOT is_active WHERE id = ?")->execute([$id]);
        $message = 'Product visibility updated.';
    } elseif ($action === 'delete') {
        try {
            $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $image = $stmt->fetchColumn();

            $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);

            if ($image && file_exists('../assets/images/' . $image)) {
                unlink('../assets/images/' . $image);
            }
            $message = 'Product deleted.';
        } catch (PDOException $e) {
            $message = 'Cannot delete: this product is part of existing orders. Deactivate it instead.';
        }
    }
}

// ---- Stats ----
$stats = $pdo->query("
    SELECT
        (SELECT COUNT(*) FROM products)                                AS total_products,
        (SELECT COUNT(*) FROM products WHERE is_active = 1)            AS active_products,
        (SELECT COUNT(*) FROM products WHERE stock <= 5)               AS low_stock,
        (SELECT COUNT(*) FROM orders WHERE status = 'pending')         AS pending_orders
")->fetch(PDO::FETCH_ASSOC);

// ---- Product list with optional filter ----
$filter = (int) ($_GET['category'] ?? 0);
$sql = "SELECT p.*, c.name AS category_name
        FROM products p JOIN categories c ON c.id = p.category_id";
$params = [];
if ($filter) {
    $sql .= " WHERE p.category_id = ?";
    $params[] = $filter;
}
$sql .= " ORDER BY p.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
function v($key, $default = '')
{
    global $product;
    return htmlspecialchars($_POST[$key] ?? $product[$key] ?? $default);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <header class="admin-bar">
        <strong>MtaaMarket Admin</strong>
        <nav>
            <a href="dashboard.php">Products</a>
            <a href="edit_product.php">+ Add product</a>
            <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['admin_name'] ?? 'admin') ?>)</a>
        </nav>
    </header>

    <main class="admin-main">
        <?php if ($message): ?><p class="flash"><?= htmlspecialchars($message) ?></p><?php endif; ?>

        <div class="stat-grid">
            <div class="stat"><span><?= $stats['total_products'] ?></span>Total products</div>
            <div class="stat"><span><?= $stats['active_products'] ?></span>Active</div>
            <div class="stat"><span><?= $stats['low_stock'] ?></span>Low stock (≤5)</div>
            <div class="stat"><span><?= $stats['pending_orders'] ?></span>Pending orders</div>
        </div>

        <form method="GET" class="filter">
            <select name="category" onchange="this.form.submit()">
                <option value="0">All categories</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $filter === (int)$c['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$products): ?>
                    <tr>
                        <td colspan="7">No products yet.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($products as $p): ?>
                    <tr class="<?= $p['is_active'] ? '' : 'inactive' ?>">
                        <td>
                            <?php if ($p['image']): ?>
                                <img src="../assets/images/<?= htmlspecialchars($p['image']) ?>" width="50" alt="">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['category_name']) ?></td>
                        <td><?= number_format($p['price'], 2) ?></td>
                        <td class="<?= $p['stock'] <= 5 ? 'low' : '' ?>"><?= (int)$p['stock'] ?></td>
                        <td><?= $p['is_active'] ? 'Active' : 'Hidden' ?></td>
                        <td class="actions">
                            <a href="edit_product.php?id=<?= $p['id'] ?>">Edit</a>

                            <form method="POST">
                                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button name="action" value="toggle">
                                    <?= $p['is_active'] ? 'Hide' : 'Show' ?>
                                </button>
                            </form>

                            <form method="POST" onsubmit="return confirm('Delete this product permanently?');">
                                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button name="action" value="delete" class="danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>