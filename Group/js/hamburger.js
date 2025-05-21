// Get the hamburger button and navigation
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('#nav');

// Toggle the active class on hamburger click
hamburger.addEventListener('click', () => {
  nav.classList.toggle('active');
});
