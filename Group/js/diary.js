 const form = document.getElementById('diary-form');
      const container = document.getElementById('balloon-container');

      form.addEventListener('submit', function (e) {
        e.preventDefault();

        const date = form.date.value;
        const title = form.title.value;
        const content = form.content.value;

        // Create balloon div
        const balloon = document.createElement('div');
        balloon.className = 'balloon';

        // Set random background color
        const originalColor = getRandomColor();
        balloon.style.backgroundColor = originalColor;
        balloon.style.border= 'black solid 10px';
        // balloon.style.fontSize= '30px';
         

        // Set random complex border-radius
        const originalBorderRadius = getRandomBorderRadius();
        balloon.style.borderRadius = originalBorderRadius;

        // Store original properties for toggle
        balloon.dataset.originalColor = originalColor;
        balloon.dataset.originalBorderRadius = originalBorderRadius;
        balloon.dataset.hovered = 'false';

        // Add hover event listener
        balloon.addEventListener('click', function() {
          const isHovered = balloon.dataset.hovered === 'true';
          
          if (!isHovered) {
            // Change to click state
            balloon.style.backgroundColor = getRandomColor();
            balloon.style.borderRadius = getRandomBorderRadius();
            balloon.classList.add('hovered');
            balloon.dataset.hovered = 'true';
          } else {
            // Return to original state
            balloon.style.backgroundColor = balloon.dataset.originalColor;
            balloon.style.borderRadius = balloon.dataset.originalBorderRadius;
            balloon.classList.remove('hovered');
            balloon.dataset.hovered = 'false';
          }
        });

        // Add content
        balloon.innerHTML = `
  <div class="balloon-date"><strong>${date}</strong></div>
  <div class="balloon-title"><em>${title}</em></div>
  <p class="balloon-text">${content}</p>
`;


        // Add to container
        container.appendChild(balloon);

        // Optional: Reset form
        form.reset();
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