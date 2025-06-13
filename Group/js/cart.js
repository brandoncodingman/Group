'use strict';
//cart variables
let cart = [];
let total = 0;
let formSubmissionInProgress = false; 

// Load cart 
function loadCart() {
    const savedCart = sessionStorage.getItem('cart');
    const savedTotal = sessionStorage.getItem('total');

    if (savedCart) {
        cart = JSON.parse(savedCart);
        total = parseInt(savedTotal) || 0;
        updateCartDisplay();
    }
}

// Save cart 
function saveCart() {
    sessionStorage.setItem('cart', JSON.stringify(cart));  
    sessionStorage.setItem('total', total.toString());
    // Also update the form with hidden inputs whenever cart changes
    updateFormInputs();
}

// Add item to cart 
function addToCart(item, price, qty = 1) {
    console.log('Adding to cart:', item, price, qty);
    
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

    total = cart.reduce((sum, cartItem) => sum + cartItem.totalPrice, 0);

    saveCart();
    updateCartDisplay();

    alert(`${item} ${qty}個をカートに追加しました！`);
}

function updateFormInputs() {
    const form = document.querySelector('form.cart');
    if (!form) {
        console.log('Form not found, skipping form input update');
        return;
    }
    
    const existingInputs = form.querySelectorAll('input[type="hidden"][name^="items"]');
    existingInputs.forEach(input => input.remove());
    
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

function updateCartDisplay() {
    console.log('Updating cart display, current cart:', cart);
    
    const cartItems = document.getElementById('cart-items');
    const totalDisplay = document.getElementById('total');

    if (cartItems) {
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
                
                const itemInfo = document.createElement('div');
                itemInfo.className = 'item-info';
                itemInfo.innerHTML = `
                    <h4>${entry.item}</h4>
                    <p>価格: ￥${entry.price}</p>
                    <div class="quantity-controls">                      
                        <span style="margin: 0 10px;">数量: ${entry.quantity}</span>
                    </div>
                    <p><strong>小計: ￥${entry.totalPrice}</strong></p>
                `;

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

                itemDiv.appendChild(itemInfo);
                itemDiv.appendChild(removeBtn);
                cartItems.appendChild(itemDiv);
            });
        }
    }

    if (totalDisplay) {
        totalDisplay.textContent = total;
    }

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
    
    updateFormInputs();
}

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

// checkout function 
function checkout(event) {
    console.log('Checkout called, cart:', cart);
    
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

    let orderSummary = "ご注文内容:\n";
    cart.forEach(item => {
        orderSummary += `${item.item} × ${item.quantity} = ${item.totalPrice}\n`;
    });
    orderSummary += `\n合計: ${total}`;

    if (confirm(orderSummary + "\n\nこの内容で注文しますか？")) {
        formSubmissionInProgress = true;
        
        updateFormInputs();
        
        console.log('Form submission approved');
        return true;
    } else {
        console.log('Form submission cancelled by user');
        if (event) event.preventDefault();
        return false;
    }
}

function clearCartAfterPurchase() {
    cart.length = 0;
    total = 0;
    sessionStorage.removeItem('cart');
    sessionStorage.removeItem('total');
    updateCartDisplay();
    formSubmissionInProgress = false; // Reset flag
}

function initializeCart() {
    console.log('Initializing cart system');
    loadCart();
    
    const form = document.querySelector('form.cart');
    if (form) {
        updateFormInputs();
        
        form.addEventListener('submit', function(e) {
            console.log('Form submit event triggered');
            if (!checkout(e)) {
                console.log('Form submission prevented');
                return false;
            }
            console.log('Form submission allowed');
        });
    }
}

document.addEventListener('DOMContentLoaded', initializeCart);

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