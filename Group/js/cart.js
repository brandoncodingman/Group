
'use strict';

let cart = [];
let total = 0;

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
}

// Add item to cart (supports both simple and complex items)
function addToCart(item, price, qty = 1) {
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

// Update cart display
function updateCartDisplay() {
    const cartItems = document.getElementById('cart-items');
    const totalDisplay = document.getElementById('total');

    // if (cartItems) {
    //     cartItems.innerHTML = '';

    //     if (cart.length === 0) {
    //         const li = document.createElement('li');
    //         li.textContent = 'カートは空です';
    //         li.style.color = '#666';
    //         li.style.fontStyle = 'italic';
    //         cartItems.appendChild(li);
    //     } else {
    //         cart.forEach((entry, index) => {
    //             const li = document.createElement('li');
    //             li.innerHTML = `
    //                 <span class="cart-item-info">
    //                     ${entry.item} - ¥${entry.price} × ${entry.quantity} = ¥${entry.totalPrice}
    //                 </span>
    //             `;

    //             const removeBtn = document.createElement('button');
    //             removeBtn.textContent = '削除';
    //             removeBtn.className = 'remove-btn';
    //             removeBtn.onclick = () => removeFromCart(index);

    //             li.appendChild(removeBtn);
    //             cartItems.appendChild(li);
    //         });
    //     }
    // }

    if (cartItems) {
        cartItems.innerHTML = '';

        if (cart.length === 0) {
            const div = document.createElement('div');
            div.textContent = 'カートは空です';
            div.style.color = '#666';
            div.style.fontStyle = 'italic';
            cartItems.appendChild(div);
        } else {
            cart.forEach((entry, index) => {
                const div = document.createElement('div');
                div.classList.add('info');
                div.innerHTML = `
                    <input class="item" type="text" name="item"  disabled="true">
                    ${entry.item}
                    </input>
                    <input class="item-price" type="number" name="item-price"  disabled="true">
                         ¥${entry.price} 
                    </input>
                    <input class="item-quantity" type="number" name="item-quantity"  disabled="true">
                        ${entry.quantity} 
                    </input>
                    <input class="item-totalPrice" type="number" name=""item-totalPrice  disabled="true">
                         ¥${entry.totalPrice}
                    </input> `;

                const removeBtn = document.createElement('button');
                removeBtn.textContent = '削除';
                removeBtn.className = 'remove-btn';
                removeBtn.onclick = () => removeFromCart(index);

                div.appendChild(removeBtn);
                cartItems.appendChild(div);
            });
        }
    }

    if (totalDisplay) {
        totalDisplay.textContent = total;
    }
}

// Remove item from cart
function removeFromCart(index) {
    if (index >= 0 && index < cart.length) {
        cart.splice(index, 1);
        total = cart.reduce((sum, cartItem) => sum + cartItem.totalPrice, 0);

        saveCart();
        updateCartDisplay();

        alert('商品をカートから削除しました');
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

// Checkout function
function checkout() {
    if (cart.length === 0) {
        alert("カートが空です");
        return;
    }

    // Create order summary
    let orderSummary = "ご注文内容:\n";
    cart.forEach(item => {
        orderSummary += `${item.item} × ${item.quantity} = ¥${item.totalPrice}\n`;
    });
    orderSummary += `\n合計: ¥${total}`;

    if (confirm(orderSummary + "\n\nこの内容で注文しますか？")) {
        alert("ご購入ありがとうございます！");

        // Clear cart after successful checkout
        cart.length = 0;
        total = 0;

        sessionStorage.removeItem('cart');
        sessionStorage.removeItem('total');

        updateCartDisplay();
    }
}

// Initialize cart when page loads
window.addEventListener('load', () => {
    loadCart();
});

// Export functions for use in other scripts
window.cartFunctions = {
    addToCart,
    removeFromCart,
    clearCart,
    checkout,
    updateCartDisplay,
    loadCart
};