
// 'use strict';

// let cart = [];
// let total = 0;

// // Load cart from sessionStorage on page load
// function loadCart() {
//     const savedCart = sessionStorage.getItem('cart');
//     const savedTotal = sessionStorage.getItem('total');

//     if (savedCart) {
//         cart = JSON.parse(savedCart);
//         total = parseInt(savedTotal) || 0;
//         updateCartDisplay();
//     }
// }

// // Save cart to sessionStorage
// function saveCart() {
//     sessionStorage.setItem('cart', JSON.stringify(cart));
//     sessionStorage.setItem('total', total.toString());
// }

// // Add item to cart (supports both simple and complex items)
// function addToCart(item, price, qty = 1) {
//     // Check if item already exists in cart
//     const existingItem = cart.find(cartItem => cartItem.item === item);

//     if (existingItem) {
//         existingItem.quantity += qty;
//         existingItem.totalPrice = existingItem.price * existingItem.quantity;
//     } else {
//         cart.push({
//             item: item,
//             price: price,
//             quantity: qty,
//             totalPrice: price * qty
//         });
//     }

//     // Recalculate total
//     total = cart.reduce((sum, cartItem) => sum + cartItem.totalPrice, 0);

//     saveCart();
//     updateCartDisplay();

//     // Show confirmation message
//     alert(`${item} ${qty}個をカートに追加しました！`);
// }

// // Update cart display
// function updateCartDisplay() {
//     const cartItems = document.getElementById('cart-items');
//     const totalDisplay = document.getElementById('total');

//     if (cartItems) {
//         cartItems.innerHTML = '';

//         if (cart.length === 0) {
//             const li = document.createElement('li');
//             li.textContent = 'カートは空です';
//             li.style.color = '#666';
//             li.style.fontStyle = 'italic';
//             cartItems.appendChild(li);
//         } else {
//             cart.forEach((entry, index) => {
//                 const li = document.createElement('li');
//                 li.innerHTML = `
//                     <span class="cart-item-info">
//                         ${entry.item} - ¥${entry.price} × ${entry.quantity} = ¥${entry.totalPrice}
//                     </span>
//                 `;

//                 const removeBtn = document.createElement('button');
//                 removeBtn.textContent = '削除';
//                 removeBtn.className = 'remove-btn';
//                 removeBtn.onclick = () => removeFromCart(index);

//                 li.appendChild(removeBtn);
//                 cartItems.appendChild(li);
//             });
//         }
//     }

//     if (cartItems) {
//         cartItems.innerHTML = '';

//         if (cart.length === 0) {
//             const div = document.createElement('div');
//             div.textContent = 'カートは空です';
//             div.style.color = '#666';
//             div.style.fontStyle = 'italic';
//             cartItems.appendChild(div);
//         } else {
//             cart.forEach((entry, index) => {
//                 const div = document.createElement('div');
//                 div.classList.add('info');
//                 div.innerHTML = `
//                     <input class="item" type="text" name="item"  disabled="true">
//                     ${entry.item}
//                     </input>
//                     <input class="item-price" type="number" name="item-price"  disabled="true">
//                          ¥${entry.price} 
//                     </input>
//                     <input class="item-quantity" type="number" name="item-quantity"  disabled="true">
//                         ${entry.quantity} 
//                     </input>
//                     <input class="item-totalPrice" type="number" name=""item-totalPrice  disabled="true">
//                          ¥${entry.totalPrice}
//                     </input> `;

//                 const removeBtn = document.createElement('button');
//                 removeBtn.textContent = '削除';
//                 removeBtn.className = 'remove-btn';
//                 removeBtn.onclick = () => removeFromCart(index);

//                 div.appendChild(removeBtn);
//                 cartItems.appendChild(div);
//             });
//         }
//     }

//     if (totalDisplay) {
//         totalDisplay.textContent = total;
//     }
// }

// // Remove item from cart
// function removeFromCart(index) {
//     if (index >= 0 && index < cart.length) {
//         cart.splice(index, 1);
//         total = cart.reduce((sum, cartItem) => sum + cartItem.totalPrice, 0);

//         saveCart();
//         updateCartDisplay();

//         alert('商品をカートから削除しました');
//     }
// }

// // Clear entire cart
// function clearCart() {
//     if (cart.length === 0) {
//         alert("カートは既に空です");
//         return;
//     }

//     if (confirm("カートを空にしますか？")) {
//         cart.length = 0;
//         total = 0;

//         sessionStorage.removeItem('cart');
//         sessionStorage.removeItem('total');

//         updateCartDisplay();
//         alert("カートを空にしました");
//     }
// }

// // Checkout function
// // function checkout() {
// //     if (cart.length === 0) {
// //         alert("カートが空です");
// //         return;
// //     }

// //     // Create order summary
// //     let orderSummary = "ご注文内容:\n";
// //     cart.forEach(item => {
// //         orderSummary += `${item.item} × ${item.quantity} = ¥${item.totalPrice}\n`;
// //     });
// //     orderSummary += `\n合計: ¥${total}`;

// //     if (confirm(orderSummary + "\n\nこの内容で注文しますか？")) {
// //         alert("ご購入ありがとうございます！");

// //         // Clear cart after successful checkout
// //         cart.length = 0;
// //         total = 0;

// //         sessionStorage.removeItem('cart');
// //         sessionStorage.removeItem('total');

// //         updateCartDisplay();
// //     }
// // }

// function checkout() {
//   const cart = JSON.parse(localStorage.getItem('cart')) || [];

//   // フォームに隠しフィールドとして商品情報を追加
//   const form = document.querySelector('form.cart');
//   cart.forEach((item, index) => {
//     const nameInput = document.createElement('input');
//     nameInput.type = 'hidden';
//     nameInput.name = `items[${index}][name]`;
//     nameInput.value = item.name;

//     const priceInput = document.createElement('input');
//     priceInput.type = 'hidden';
//     priceInput.name = `items[${index}][price]`;
//     priceInput.value = item.price;

//     form.appendChild(nameInput);
//     form.appendChild(priceInput);
//   });

//   // 合計金額を追加
//   const totalInput = document.createElement('input');
//   totalInput.type = 'hidden';
//   totalInput.name = 'total';
//   totalInput.value = calculateTotal(cart);
//   form.appendChild(totalInput);
// }

// function calculateTotal(cart) {
//   return cart.reduce((sum, item) => sum + item.price, 0);
// }



// // Initialize cart when page loads
// window.addEventListener('load', () => {
//     loadCart();
// });

// // Export functions for use in other scripts
// window.cartFunctions = {
//     addToCart,
//     removeFromCart,
//     clearCart,
//     checkout,
//     updateCartDisplay,
//     loadCart
// };

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

// Update cart display with proper form inputs for PHP submission
function updateCartDisplay() {
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
                
                // Create visible content
                const itemInfo = document.createElement('div');
                itemInfo.className = 'item-info';
                itemInfo.innerHTML = `
                    <h4>${entry.item}</h4>
                    <p>　価格: ¥${entry.price}</p>
                    <div class="quantity-controls">
                        <span>　数量: ${entry.quantity}</span>
                    </div>
                    <p><strong>　小計: ¥${entry.totalPrice}</strong></p>
                `;

                // Create hidden inputs for PHP form submission
                const hiddenInputs = document.createElement('div');
                hiddenInputs.innerHTML = `
                    <input type="hidden" name="items[${index}][item]" value="${entry.item}">
                    <input type="hidden" name="items[${index}][item-price]" value="${entry.price}">
                    <input type="hidden" name="items[${index}][item-quantity]" value="${entry.quantity}">
                    <input type="hidden" name="items[${index}][item-totalPrice]" value="${entry.totalPrice}">
                `;

                // Create remove button
                const removeBtn = document.createElement('button');
                removeBtn.textContent = '削除';
                removeBtn.className = 'remove-btn';
                removeBtn.type = 'button';
                removeBtn.onclick = () => removeFromCart(index);

                // Append all elements
                itemDiv.appendChild(itemInfo);
                itemDiv.appendChild(hiddenInputs);
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
    }
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

// Checkout function for form submission
function checkout() {
    if (cart.length === 0) {
        alert("カートが空です");
        return false; // Prevent form submission
    }

    // Create order summary for confirmation
    let orderSummary = "ご注文内容:\n";
    cart.forEach(item => {
        orderSummary += `${item.item} × ${item.quantity} = ¥${item.totalPrice}\n`;
    });
    orderSummary += `\n合計: ¥${total}`;

    // Confirm purchase
    if (confirm(orderSummary + "\n\nこの内容で注文しますか？")) {
        // Update display one more time to ensure all hidden inputs are current
        updateCartDisplay();
        
        // Allow form submission
        return true;
    } else {
        // Cancel form submission
        return false;
    }
}

// Initialize cart when page loads
window.addEventListener('load', () => {
    loadCart();
});

// Also initialize when DOM is ready (backup)
document.addEventListener('DOMContentLoaded', () => {
    loadCart();
});

// Export functions for use in other scripts
window.cartFunctions = {
    addToCart,
    removeFromCart,
    clearCart,
    checkout,
    updateCartDisplay,
    loadCart,
    updateQuantity
};