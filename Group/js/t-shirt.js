'use strict';

const leftbutton = document.querySelector('.left');
const rightbutton = document.querySelector('.right');
const front = document.querySelector('#front');
const back = document.querySelector('#back');

leftbutton.addEventListener('click', () => {
    if (back.style.display === "block") {
        front.style.display = "block";
        back.style.display = "none";
    } else {
        front.style.display = "none";
        back.style.display = "block";
    }
});

rightbutton.addEventListener('click', () => {
    if (front.style.display === "block") {
        front.style.display = "none";
        back.style.display = "block";
    } else {
        front.style.display = "block";
        back.style.display = "none";
    }
});

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

const addProduct = document.querySelector('input[type="submit"][value="カートに入れる"]');

addProduct.addEventListener('click', () => {
    const addProduct = {
        name:"t-shirt",
        price:3630,
        quantity:quantity
    };

    let cart =JSON.parse(localStorage.getItem('cart')) || [];

    cart.push(puroduct);

    localStorage.setItem('cart',JSON.stringify(cart));

    window.location.href = 'http://localhost/Group/Group/cart.php'
});

