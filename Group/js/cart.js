'use strict';

let cart = [];
let total = 0;
let formSubmissionInProgress = false; // Add flag to prevent multiple submissions

// Load cart from sessionStorage on page load
function loadCart() {
    const savedCart = sessionStorage.getItem('cart');
    const savedTotal = sessionStorage.getItem('total');

    if (savedCart) {
        cart = JSON.parse(savedCart);
        total = parseInt(savedTotal) || 0;
        updateCartDisplay();
    }
}

// Save cart to sessionStorage
function saveCart() {
    sessionStorage.setItem('cart', JSON.stringify(cart));  
    sessionStorage.setItem('total', total.toString());
    // Also update the form with hidden inputs whenever cart changes
    updateFormInputs();
}

// Add item to cart (supports both simple and complex items)
function addToCart(item, price, qty = 1) {
    console.log('Adding to cart:', item, price, qty);
    
    // Check if item already exists in cart
    const existingItem = cart.find(cartItem => cartItem.item === item);

    if (existingItem) {
        existingItem.quantity += qty;
        existingItem.totalPrice = existingItem.price * existingItem.quantity;
    } else {
        cart.push({
            item: item,
            price: price,
            quantity: qty,
            totalPrice: price * qty
        });
    }

    // Recalculate total
    total = cart.reduce((sum, cartItem) => sum + cartItem.totalPrice, 0);

    saveCart();
    updateCartDisplay();

    // Show confirmation message
    alert(`${item} ${qty}個をカートに追加しました！`);
}

// Update form with hidden inputs
function updateFormInputs() {
    const form = document.querySelector('form.cart');
    if (!form) {
        console.log('Form not found, skipping form input update');
        return;
    }
    
    // Remove any existing hidden inputs to avoid duplicates
    const existingInputs = form.querySelectorAll('input[type="hidden"][name^="items"]');
    existingInputs.forEach(input => input.remove());
    
    // Add fresh hidden inputs for each cart item
    cart.forEach((item, index) => {
        const inputs = [
            { name: `items[${index}][item]`, value: item.item },
            { name: `items[${index}][item-price]`, value: item.price },
            { name: `items[${index}][item-quantity]`, value: item.quantity },
            { name: `items[${index}][item-totalPrice]`, value: item.totalPrice }
        ];
        
        inputs.forEach(inputData => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = inputData.name;
            input.value = inputData.value;
            form.appendChild(input);
        });
    });
    
    console.log('Form inputs updated. Hidden inputs count:', form.querySelectorAll('input[type="hidden"]').length);
}

// Update cart display with proper form inputs for PHP submission
function updateCartDisplay() {
    console.log('Updating cart display, current cart:', cart);
    
    const cartItems = document.getElementById('cart-items');
    const totalDisplay = document.getElementById('total');

    if (cartItems) {
        // Clear existing content
        cartItems.innerHTML = '';

        if (cart.length === 0) {
            const div = document.createElement('div');
            div.textContent = 'カートは空です';
            div.style.color = '#666';
            div.style.fontStyle = 'italic';
            div.style.textAlign = 'center';
            div.style.padding = '20px';
            cartItems.appendChild(div);
        } else {
            cart.forEach((entry, index) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'cart-item';
                itemDiv.style.border = '1px solid #ddd';
                itemDiv.style.padding = '10px';
                itemDiv.style.margin = '10px 0';
                itemDiv.style.borderRadius = '5px';
                
                // Create visible content
                const itemInfo = document.createElement('div');
                itemInfo.className = 'item-info';
                itemInfo.innerHTML = `
                    <h4>${entry.item}</h4>
                    <p>価格: ￥${entry.price}</p>
                    <div class="quantity-controls">
                        <button type="button" onclick="updateQuantity(${index}, ${entry.quantity - 1})" ${entry.quantity <= 1 ? 'disabled' : ''}>-</button>
                        <span style="margin: 0 10px;">数量: ${entry.quantity}</span>
                        <button type="button" onclick="updateQuantity(${index}, ${entry.quantity + 1})">+</button>
                    </div>
                    <p><strong>小計: ￥${entry.totalPrice}</strong></p>
                `;

                // Create remove button
                const removeBtn = document.createElement('button');
                removeBtn.textContent = '削除';
                removeBtn.className = 'remove-btn';
                removeBtn.type = 'button';
                removeBtn.style.marginTop = '10px';
                removeBtn.style.padding = '5px 10px';
                removeBtn.style.backgroundColor = '#ff4444';
                removeBtn.style.color = 'white';
                removeBtn.style.border = 'none';
                removeBtn.style.borderRadius = '3px';
                removeBtn.style.cursor = 'pointer';
                removeBtn.onclick = () => removeFromCart(index);

                // Append all elements
                itemDiv.appendChild(itemInfo);
                itemDiv.appendChild(removeBtn);
                cartItems.appendChild(itemDiv);
            });
        }
    }

    // Update total display
    if (totalDisplay) {
        totalDisplay.textContent = total;
    }

    // Update checkout button state
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.disabled = cart.length === 0;
        if (cart.length === 0) {
            checkoutBtn.style.opacity = '0.5';
            checkoutBtn.style.cursor = 'not-allowed';
        } else {
            checkoutBtn.style.opacity = '1';
            checkoutBtn.style.cursor = 'pointer';
        }
    }
    
    // Update form inputs whenever display is updated
    updateFormInputs();
}

// Update quantity of specific item
function updateQuantity(index, newQuantity) {
    if (index >= 0 && index < cart.length) {
        if (newQuantity <= 0) {
            removeFromCart(index);
        } else {
            cart[index].quantity = newQuantity;
            cart[index].totalPrice = cart[index].price * newQuantity;
            
            // Recalculate total
            total = cart.reduce((sum, cartItem) => sum + cartItem.totalPrice, 0);
            
            saveCart();
            updateCartDisplay();
        }
    }
}

// Remove item from cart
function removeFromCart(index) {
    if (index >= 0 && index < cart.length) {
        const removedItem = cart[index];
        cart.splice(index, 1);
        total = cart.reduce((sum, cartItem) => sum + cartItem.totalPrice, 0);

        saveCart();
        updateCartDisplay();

        alert(`${removedItem.item}をカートから削除しました`);
    }
}

// Clear entire cart
function clearCart() {
    if (cart.length === 0) {
        alert("カートは既に空です");
        return;
    }

    if (confirm("カートを空にしますか？")) {
        cart.length = 0;
        total = 0;

        sessionStorage.removeItem('cart');
        sessionStorage.removeItem('total');

        updateCartDisplay();
        alert("カートを空にしました");
    }
}

// Simplified checkout function - now handles form submission directly
function checkout(event) {
    console.log('Checkout called, cart:', cart);
    
    // Prevent multiple submissions
    if (formSubmissionInProgress) {
        console.log('Form submission already in progress');
        if (event) event.preventDefault();
        return false;
    }
    
    if (cart.length === 0) {
        alert("カートが空です");
        if (event) event.preventDefault();
        return false;
    }

    // Create order summary for confirmation
    let orderSummary = "ご注文内容:\n";
    cart.forEach(item => {
        orderSummary += `${item.item} × ${item.quantity} = ${item.totalPrice}\n`;
    });
    orderSummary += `\n合計: ${total}`;

    // Confirm purchase
    if (confirm(orderSummary + "\n\nこの内容で注文しますか？")) {
        // Set flag to prevent multiple submissions
        formSubmissionInProgress = true;
        
        // Ensure form inputs are up to date
        updateFormInputs();
        
        console.log('Form submission approved');
        // Let the form submit naturally
        return true;
    } else {
        console.log('Form submission cancelled by user');
        if (event) event.preventDefault();
        return false;
    }
}

// Function to clear cart after successful purchase
function clearCartAfterPurchase() {
    cart.length = 0;
    total = 0;
    sessionStorage.removeItem('cart');
    sessionStorage.removeItem('total');
    updateCartDisplay();
    formSubmissionInProgress = false; // Reset flag
}

// Initialize cart when page loads
function initializeCart() {
    console.log('Initializing cart system');
    loadCart();
    
    // Set up form submission handler
    const form = document.querySelector('form.cart');
    if (form) {
        // Ensure we have form inputs ready
        updateFormInputs();
        
        // Add single event listener for form submission
        form.addEventListener('submit', function(e) {
            console.log('Form submit event triggered');
            // Call checkout with the event object
            if (!checkout(e)) {
                // checkout function already called preventDefault if needed
                console.log('Form submission prevented');
                return false;
            }
            console.log('Form submission allowed');
        });
    }
}

// Initialize cart when DOM is ready
document.addEventListener('DOMContentLoaded', initializeCart);

// Export functions for use in other scripts
window.cartFunctions = {
    addToCart,
    removeFromCart,
    clearCart,
    checkout,
    updateCartDisplay,
    loadCart,
    updateQuantity,
    clearCartAfterPurchase,
    updateFormInputs
};