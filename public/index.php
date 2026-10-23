<?php
require_once 'db.php';
include '../includes/header.php';

function getProductsByCategory($pdo, $categoryId)
{
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = :cat_id AND is_active =TRUE");
    $stmt->execute(['cat_id' => $categoryId]);
    return $stmt->fetchAll();
}
?>
<main>


    <div>Explore our products</div>
    <form class="search-container" action="/search" method="GET">
        <input type="text" name="search" placeholder="search for a product...">
        <button type="submit"> Search </button>
    </form>
    <section id="hero">
        <p>We offer budget friendly items at discount prices</p>

    </section>
    <section id="flash_deals">
        <h2>Today's Best Offers</h2>
        <img src="" alt="discount price tags banner">
        <div class="description">
            <p>Don't miss out on our limited-time price drops. Up to 50% off select products!</p>
        </div>
        <div class="product-grid">
            <?php
            $flash_deals = getProductsByCategory($pdo, 1);
            if (empty($flash_deals)):
            ?>
                <p class="empty-cart-message">No Flash Deals items available currently.</p>
                <?php else: foreach ($flash_deals as $item): ?>
                    <div class="product-card">
                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <h3> <?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="price">KES <?php echo number_format($item['price'], 0); ?></p>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
            <?php endforeach;
            endif; ?>
            <div class="product-card">
                <img src="" alt="Beauty products">
                <h3>beauty products</h3>
                <p class="price">KES 880</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/ceramicmugs.jpeg" alt="6-Ceramic Mugs">
                <h3>6-Ceramic Mugs</h3>
                <p class="price">KES 2000</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/wig.jpeg" alt="Natural Silky Wig">
                <h3>Natural Silky Wig</h3>
                <p class="price">KES 1750</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>
    </section>
    <section id="household_items" class="category-section">
        <h2>HouseHold Items</h2>
        <div class="product-grid">
            <div class="product-card">
                <img src="/assets/images/6_plastic_containers.jpg" alt="Plastic Storage Containers">
                <h3>6-Piece Storage Containers</h3>
                <p class="price">KES 450</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/microfibre_cloths(4pk).jpg" alt="Microfiber Cleaning Cloths">
                <h3>Microfiber Cloths (4 Pack)</h3>
                <p class="price">KES 250</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/cordless_electric_c.jpg" alt="Stainless Steel Kettle">
                <h3>Electric Cordless Kettle</h3>
                <p class="price">KES 1,200</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/knife.jpeg" alt="stainless steal knife">
                <h3>stainless steel knife</h3>
                <p class="price">KES 1000 </p>
                <button class="add-to-cart-btn">Add to Cart</button>

            </div>
            <div class="product-card">
                <img src="/assets/images/peeler.jpeg" alt="Peeler">
                <h3>Peeler</h3>
                <p class="price">KES 350</p>
                <button class="add-to-cart-btn">Add to Cart</button>

            </div>
            <div class="product-card">
                <img src="/assets/images/pan.jpeg" alt="Non-stick cooking pan">
                <h3>Non-stick cooking pan</h3>
                <p class="price">KES 1500</p>
                <button class="add-to-cart-btn">Add to Cart</button>

            </div>
            <div class="product-card">
                <img src="/assets/images/thermos.jpeg" alt="Thermos flask">
                <h3>Thermos flask</h3>
                <p class="price">KES 880</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>
    </section>
    <section id="groceries" class="category-section">
        <h2>Groceries & Fresh Food</h2>
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <img src="/assets/images/fresh_tomatoes.jpg" alt="Fresh Tomatoes">
                <h3>Fresh Tomatoes (1kg)</h3>
                <p class="price">KES 120</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <!-- Product 2 -->
            <div class="product-card">
                <img src="/assets/images/long_grain_rice.jpg" alt="Daawat Rice">
                <h3>Long Grain Rice (2kg)</h3>
                <p class="price">KES 340</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <!-- Product 3 -->
            <div class="product-card">
                <img src="/assets/images/pure_vegetable_oil.jpg" alt="Cooking Oil">
                <h3>Pure Vegetable Oil (1L)</h3>
                <p class="price">KES 290</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/cheese.jpeg" alt=" Cheddar Cheese">
                <h3> Cheddar Cheese</h3>
                <p class="price">KES 450</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/eggs.jpeg" alt="Eggs">
                <h3> Eggs(tray)</h3>
                <p class="price">KES 450</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/flour1kg.jpeg" alt=" Wheat flour">
                <h3> Wheat flour (1kg)</h3>
                <p class="price">KES 120</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/sugar1kg.jpeg" alt=" Sugar">
                <h3> Sugar (1kg)</h3>
                <p class="price">KES 150</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/long_grain_rice.jpg" alt=" Whole grain rice">
                <h3> Whole milk(1L)</h3>
                <p class="price">KES 70</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="Spagetti">
                <h3>Spagetti (400g)</h3>
                <p class="price">KES 200</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>
    </section>

    <section id="electronics" class="category-section">
        <h2>Electronics & Gadgets</h2>
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <img src="/assets/images/powe_bank.jpg" alt="10000mAh Power Bank">
                <h3>10,000mAh Fast Power Bank</h3>
                <p class="price">KES 1,500</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <!-- Product 2 -->
            <div class="product-card">
                <img src="/assets/images/earpuds.jpg" alt="Bluetooth Earbuds">
                <h3>Wireless Sports Earbuds</h3>
                <p class="price">KES 950</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <!-- Product 3 -->
            <div class="product-card">
                <img src="/assets/images/type_c_cable.jpg" alt="USB Type-C Cable">
                <h3>Braided Type-C Cable (1m)</h3>
                <p class="price">KES 200</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/55inches_TV.jpeg" alt="55 inch tv">
                <h3>Television (55-inch)</h3>
                <p class="price">KES 20,000</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/projector.jpeg" alt="projector">
                <h3>Projector</h3>
                <p class="price">KES 1200</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/mouse.jpeg" alt="wireless mouse">
                <h3>Mouse wireless</h3>
                <p class="price">KES 380</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="" alt="Laptop cooling pad">
                <h3>Laptop cooling pad</h3>
                <p class="price">KES 950</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="/assets/images/router.jpeg" alt="wireless router">
                <h3>Wireless router</h3>
                <p class="price">KES 1000</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="" alt="Smart watch">
                <h3>Smart watch</h3>
                <p class="price">KES 600</p>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>
    </section>
    <?php include '../includes/footer.php'; ?>
    /*
    <?php
    require_once '../config/db.php';
    require_once '../includes/functions.php';
    include '../includes/header.php';

    // Get products from database by category
    $flash_deals     = getProductsByCategory($pdo, 1); // Flash Deals
    $household_items = getProductsByCategory($pdo, 2); // Household
    $groceries       = getProductsByCategory($pdo, 3); // Groceries
    $electronics     = getProductsByCategory($pdo, 4); // Electronics
    ?>

    <main>
        <div class="page-title">Explore our products</div>

        <!-- Search -->
        <form class="search-container" action="/search" method="GET">
            <input type="text" name="search" placeholder="Search for a product...">
            <button type="submit">Search</button>
        </form>

        <!-- Hero -->
        <section id="hero">
            <p>We offer budget friendly items at discount prices</p>
        </section>

        <!-- ==================== FLASH DEALS ==================== -->
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

        <!-- ==================== HOUSEHOLD ITEMS ==================== -->
        <section id="household_items" class="category-section">
            <h2>Household Items</h2>
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

        <!-- ==================== GROCERIES ==================== -->
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

        <!-- ==================== ELECTRONICS ==================== -->
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
    */