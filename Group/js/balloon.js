function getRandomPastelColor() {
  const r = Math.floor(Math.random() * 128 + 128); // Light red (128 to 255)
  const g = Math.floor(Math.random() * 128 + 128); // Light green (128 to 255)
  const b = Math.floor(Math.random() * 128 + 128); // Light blue (128 to 255)
  return `rgb(${r}, ${g}, ${b})`;
}

function getRandomBorderRadius() {
  const topLeft = Math.floor(Math.random() * 100);
  const topRight = Math.floor(Math.random() * 100);
  const bottomLeft = Math.floor(Math.random() * 100);
  const bottomRight = Math.floor(Math.random() * 100);
  
  const xAxis = `${topLeft}% ${topRight}% ${bottomLeft}% ${bottomRight}%`;
  const yAxis = `${Math.floor(Math.random() * 100)}% ${Math.floor(Math.random() * 100)}% ${Math.floor(Math.random() * 100)}% ${Math.floor(Math.random() * 100)}%`;
  
  return `${xAxis} / ${yAxis}`;
}

document.querySelectorAll('.balloon').forEach(balloon => {
  balloon.addEventListener('mouseenter', function() {

    const randomColor = getRandomPastelColor();
    const randomBorderRadius = getRandomBorderRadius();
    
    balloon.style.backgroundColor = randomColor;
    balloon.style.borderRadius = randomBorderRadius;
  });
});
