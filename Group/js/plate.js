'use strict';

//初期値設定
let quantity = 1;

const quantityElement = document.getElementById('quantity');
const decreaseBtn = document.getElementById('decrease');
const increaseBtn = document.getElementById('increase');

decreaseBtn.addEventListener('click', () => {
    if (quantity > 1) {
        quantity--;
        quantityElement.textContent = quantity;
    }
});

increaseBtn.addEventListener('click', () => {
    if (quantity < 10) {
        quantity++;
        quantityElement.textContent = quantity;
    }
});

let cart = [];
let total = 0;

function addToCart(item, price, qty = 1) {
    //既存の商品があるかチェック
    const existingItem = cart.find(cartItem => cartItem.item === item);

    if (existingItem) {
        existingItem.quantity += qty;
        existingItem.totalPrice = existingItem.price * existingItem.quantity
    } else {
        cart.push({
            item: item,
            price: price,
            quantity: qty,
            totalPrice: price * qty
        });

        total = cart.reduce((sum, cartItem) => sum + cartItem.totalPrice, 0);

        sessionStorage.setItem('cart', JSON.stringify(cart));
        sessionStorage.setItem('total', total.toString());
    }

    function updateCartDisplay() {
        const cartItems = document.getElementById('cart-items')
        const totalDisplay = document.getElementById('total');

        if (cartItems) {
            cartItems.innerHTML = '';
            cart.forEach((entry, index) => {
                const li = document.createElement("li");
                li.innerHTML = `
                ${entry.item}-¥${entry.price} × ${entry.quantity} =¥{entry.totalPlice}`;

                const removeBtn = document.createElement('buttom');
                removeBtn.textContent = '削除';
                removeBtn.onclick = () => removeFromCart(index);
                li.appendChild(removeBtn);
                cartItems.appendChild(li);
            });
        }

        if (totalDisplay) {
            totalDisplay.textContent = `¥${total}`;
        }
    }
}

function removeFromCart(index) {
    cart.splice(index, 1);
    total = cart.reduce((sum, carItem) => sum + cartItem.totalPrice, 0);

    sessionStorage.setItem('cart', JSON.stringify(cart));
    sessionStorage.setItem('total', total.toString);

    updateCartDisplay();
}

function checkout() {
    if (cart.length === 0) {
        alert("カートが空です。");
        return;
    }
    alert("ご購入ありがとうございます。");
    cart.length = 0;
    total = 0;

    sessionStorage.removeItem('cart');
    sessionStorage.removeItem('Item');

    updateCartDisplay();
}

window.addEventListener('load', () => {
    const savedCart = sessionStorage.getItem('cart');
    const savedTotal = sessionStorage.getItem('total');

    if (savedCart) {
        cart = JSON.parse(savedCart);
        total = parseInt(savedTotal) || 0;
       updateCartDisplay();
    }
})

const addProductBtn = document.querySelector('input[type="submit"][value="カートに入れる"]')

if (addProductBtn) {
    addProductBtn.addEventListener('click', (e) => {
        e.preventDefault();

        addToCart("plate", 1650, quantity);

        window.location.href = 'http://localhost/Group/Group/cart.php';
    });
}