<?php
session_start();
require_once '../includes/db.php';

// Simple guard (replace with real login check)
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = (float) $_POST['price'];
    $stock       = (int) $_POST['stock'];
    $category_id = (int) $_POST['category_id'];
    $imageName   = null;

    // Handle image upload
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $imageName = uniqid('prod_', true) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $imageName);
        } else {
            $message = 'Invalid image type.';
        }
    }

    if ($name && $price > 0 && !$message) {
        $stmt = $pdo->prepare(
            "INSERT INTO products (category_id, name, description, price, image, stock)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$category_id, $name, $description, $price, $imageName, $stock]);
        $message = 'Product added!';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
</head>

<body>
    <h1>Add Product</h1>
    <?php if ($message): ?><p><?= htmlspecialchars($message) ?></p><?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product name" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock" value="0">
        <select name="category_id" required>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Add Product</button>
    </form>
</body>

</html>