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


