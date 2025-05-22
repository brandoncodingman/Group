// Function to generate a random pastel color
function getRandomPastelColor() {
  const r = Math.floor(Math.random() * 128 + 128); // Light red (128 to 255)
  const g = Math.floor(Math.random() * 128 + 128); // Light green (128 to 255)
  const b = Math.floor(Math.random() * 128 + 128); // Light blue (128 to 255)
  return `rgb(${r}, ${g}, ${b})`;
}

// Function to generate a random border-radius shape
function getRandomBorderRadius() {
  const topLeft = Math.floor(Math.random() * 100);
  const topRight = Math.floor(Math.random() * 100);
  const bottomLeft = Math.floor(Math.random() * 100);
  const bottomRight = Math.floor(Math.random() * 100);
  
  const xAxis = `${topLeft}% ${topRight}% ${bottomLeft}% ${bottomRight}%`;
  const yAxis = `${Math.floor(Math.random() * 100)}% ${Math.floor(Math.random() * 100)}% ${Math.floor(Math.random() * 100)}% ${Math.floor(Math.random() * 100)}%`;
  
  return `${xAxis} / ${yAxis}`;
}

// Add event listeners for hover on each balloon div
document.querySelectorAll('.balloon').forEach(balloon => {
  balloon.addEventListener('mouseenter', function() {
    // Generate new random colors and border-radius
    const randomColor = getRandomPastelColor();
    const randomBorderRadius = getRandomBorderRadius();
    
    // Apply new background-color and border-radius (border stays fixed)
    balloon.style.backgroundColor = randomColor;
    balloon.style.borderRadius = randomBorderRadius;
  });
});
