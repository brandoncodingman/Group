// Character movement 
    
      const character = document.getElementById("character");
      const speed = 10;

      let posX = 100;
      let posY = 100;

      document.addEventListener("keydown", function (e) {
        switch (e.key) {
          case "ArrowUp":
            posY = Math.max(0, posY - speed);
            break;
          case "ArrowDown":
            posY = Math.min(
              window.innerHeight - character.offsetHeight,
              posY + speed
            );
            break;
          case "ArrowLeft":
            posX = Math.max(0, posX - speed);
            break;
          case "ArrowRight":
            posX = Math.min(
              window.innerWidth - character.offsetWidth,
              posX + speed
            );
            break;
        }
        character.style.top = posY + "px";
        character.style.left = posX + "px";
      });

      // Generate a random pastel color
      function getRandomPastelColor() {
        const r = Math.floor(Math.random() * 128 + 128); // Light red
        const g = Math.floor(Math.random() * 128 + 128); // Light green
        const b = Math.floor(Math.random() * 128 + 128); // Light blue
        return `rgb(${r}, ${g}, ${b})`;
      }

      // Add hover effect to change background color to a random pastel color
      const fancyBoxes = document.querySelectorAll(".fancy-box");
      fancyBoxes.forEach((box) => {
        box.addEventListener("mouseenter", function () {
          const randomColor = getRandomPastelColor();
          box.style.backgroundColor = randomColor;
        });
      });

      // Animate images on load
      window.addEventListener("load", () => {
        const topImage = document.getElementById("top-image");
        const bottomImage = document.getElementById("bottom-image");

        // Apply the slide-in effect to both images after a slight delay
        setTimeout(() => {
          topImage.classList.add("slide-in");
          bottomImage.classList.add("slide-in");
        }, 100); // Delay to ensure proper animation start

        // Optional: Hide after animation
        setTimeout(() => {
          topImage.classList.add("hide");
          bottomImage.classList.add("hide");
        }, 1600); // After the slide-in animation
      });
