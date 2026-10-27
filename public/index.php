<?php
require_once '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

//get products from database
$flash_deals = getProductsByCategory($pdo, 1);
$household_items = getProductsByCategory($pdo, 2);
$groceries = getProductsByCategory($pdo, 3);
$electronics = getProductsByCategory($pdo, 4);
?>
<main>


    <div>Explore our products</div>
    <!-- search -->
    <form class="search-container" action="/search" method="GET">
        <input type="text" name="search" placeholder="search for a product...">
        <button type="submit"> Search </button>
    </form>
    <!-- hero section -->
    <section id="hero">
        <p>We offer budget friendly items at discount prices</p>

    </section>
    <!-- flash deals -->
    <section id="flash_deals">
        <h2>Today's Best Offers</h2>
        <div class="description">
            <p>Don't miss out on our limited-time price drops. Up to 50% off select products!</p>
        </div>

        <div class="product-grid">
            <?php if (empty($flash_deals)): ?>
                <p class="empty-message">No Flash Deals available at the moment.</p>
            <?php else: ?>
                <?php foreach ($flash_deals as $item): ?>
                    <?php displayProductCard($item); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    <section id="household_items" class="category-section">
        <h2>HouseHold Items</h2>
        <div class="product-grid">
            <?php if (empty($household_items)): ?>
                <p class="empty-message">No household items available currently.</p>
            <?php else: ?>
                <?php foreach ($household_items as $item): ?>
                    <?php displayProductCard($item); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    <section id="groceries" class="category-section">
        <h2>Groceries & Fresh Food</h2>
        <div class="product-grid">
            <?php if (empty($groceries)): ?>
                <p class="empty-message">No groceries available currently.</p>
            <?php else: ?>
                <?php foreach ($groceries as $item): ?>
                    <?php displayProductCard($item); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section id="electronics" class="category-section">
        <h2>Electronics & Gadgets</h2>
        <div class="product-grid">
            <?php if (empty($electronics)): ?>
                <p class="empty-message">No electronics available currently.</p>
            <?php else: ?>
                <?php foreach ($electronics as $item): ?>
                    <?php displayProductCard($item); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</main>
<?php include '../includes/footer.php'; ?>