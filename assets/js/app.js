let cart = JSON.parse(localStorage.getItem("mtaa_market_cart")) || [];

document.addEventListener("DOMContentLoaded", () => {
    
    const cartCountElement = document.querySelector(".cart-count");
    cartCountElement.innerText = `(${cart.length})`;

    const cartDisplayWrapper = document.getElementById("cart-display-wrapper");

    if (cartDisplayWrapper) {
        
        const renderCartItems = () => {
            cartDisplayWrapper.innerHTML = "";

            if (cart.length === 0) {
                cartDisplayWrapper.innerHTML = '<p class="empty-cart-message">Your shopping cart is currently empty.</p>';
                return;
            }

            let orderTotalSum = 0;

            cart.forEach((item, index) => {
                const itemRow = document.createElement("div");
                itemRow.className = "cart-item-row";

                itemRow.innerHTML = `
                     <div class="cart-item-left-block">
                        <img src="${item.image || 'images/placeholder.jpg'}" alt="${item.title}" class="cart-thumb">
                        <div class="cart-item-details">
                            <h4>${item.title}</h4>
                            <p class="item-price">${item.price}</p>
                        </div>
                    </div>
                    <button class="remove-item-btn" data-index="${index}">Remove</button>
                `;


                cartDisplayWrapper.appendChild(itemRow);

                const numericPrice = parseInt(item.price.replace(/[^0-9]/g, ""), 10);
                orderTotalSum += numericPrice;
            });

            const summaryBlock = document.createElement("div");
            summaryBlock.className = "cart-summary-block";
            summaryBlock.innerHTML = `
                <h3>Grand Total: KES ${orderTotalSum.toLocaleString()}</h3>
                <button class="checkout-action-btn">Proceed to Checkout</button>
            `;
            
            cartDisplayWrapper.appendChild(summaryBlock);
            setupRemoveElementListeners();
        };

        const setupRemoveElementListeners = () => {
            const removeButtons = document.querySelectorAll(".remove-item-btn");
            
            removeButtons.forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    const itemTargetIndex = e.target.getAttribute("data-index");

                    cart.splice(itemTargetIndex, 1);
                    localStorage.setItem("mtaa_market_cart", JSON.stringify(cart));
                    cartCountElement.innerText = `(${cart.length})`;
                    renderCartItems();
                });
            });
        };

        renderCartItems();
    }

    const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
    const toast = document.getElementById("toast-notification");
    
    addToCartButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            const productCard = event.target.closest(".product-card");
            const productTitle = productCard.querySelector("h3").innerText;
            const productPrice = productCard.querySelector(".price").innerText;
            
            const productImage = productCard.querySelector("img").getAttribute("src");
            const product = {
                title: productTitle,
                price: productPrice,
                image: productImage
            };

            cart.push(product);
            localStorage.setItem("mtaa_market_cart", JSON.stringify(cart));
            cartCountElement.innerText = `(${cart.length})`;
            
            
            toast.innerText = `✅ ${productTitle} added to cart!`;
            toast.classList.add("show");

            setTimeout(() =>{
                toast.classList.remove("show");

            }, 3000);
            console.log("Product saved to LocalStorage:", product);
            console.log("Total Items in Vault:", cart.length);

        
        });
    });
});
