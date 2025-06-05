const form = document.getElementById('diary-form');
const container = document.getElementById('balloon-container');

form.addEventListener('submit', function (e) {
  e.preventDefault(); // prevent default form submission

  // Get and format today's date/time
  const date = new Date().toLocaleDateString('en-US', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
  });

  const title = form.title.value;
  const content = form.content.value;

  // Create balloon div
  const balloon = document.createElement('div');
  balloon.className = 'balloon';

  const originalColor = getRandomColor();
  balloon.style.backgroundColor = originalColor;
  balloon.style.border = 'black solid 10px';

  const originalBorderRadius = getRandomBorderRadius();
  balloon.style.borderRadius = originalBorderRadius;

  balloon.dataset.originalColor = originalColor;
  balloon.dataset.originalBorderRadius = originalBorderRadius;
  balloon.dataset.hovered = 'false';

  balloon.addEventListener('click', function () {
    const isHovered = balloon.dataset.hovered === 'true';

    if (!isHovered) {
      balloon.style.backgroundColor = getRandomColor();
      balloon.style.borderRadius = getRandomBorderRadius();
      balloon.classList.add('hovered');
      balloon.dataset.hovered = 'true';
    } else {
      balloon.style.backgroundColor = balloon.dataset.originalColor;
      balloon.style.borderRadius = balloon.dataset.originalBorderRadius;
      balloon.classList.remove('hovered');
      balloon.dataset.hovered = 'false';
    }
  });

  // Add content to balloon
  balloon.innerHTML = `
    <div class="balloon-date"><strong>${date}</strong></div>
    <div class="balloon-title"><em>${title}</em></div>
    <p class="balloon-text">${content}</p>
  `;

  container.insertBefore(balloon, container.firstChild);

  // ✅ Submit the form after visual effect
  // Optionally delay a tiny bit to let balloon show
  setTimeout(() => {
    form.submit(); // manually submit the form to Diary_Saves.php
  }, 100); // small delay (100ms) — adjust as needed
});

function getRandomColor() {
  const letters = '0123456789ABCDEF';
  let color = '#';
  for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

function getRandomBorderRadius() {
  const values = () => Array(4).fill().map(() => `${Math.floor(Math.random() * 50) + 20}%`).join(' ');
  return `${values()} / ${values()}`;
}
