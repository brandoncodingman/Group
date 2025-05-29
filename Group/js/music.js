document.addEventListener("DOMContentLoaded", () => {
  const musicButton = document.getElementById("music-toggle");

  // Create audio
  const audio = new Audio("./music/FluffyPlanets.mp3");
  audio.loop = true; 
  audio.volume = 0.5; 
  let isPlaying = false;

  musicButton.addEventListener("click", () => {
    if (isPlaying) {
      audio.pause();
      musicButton.textContent = "🔇 Music Off";
    } else {
      audio.play();
      musicButton.textContent = "🔊 Music On";
    }
    isPlaying = !isPlaying;
  });
});
