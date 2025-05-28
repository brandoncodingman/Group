// Character movement 
const character = document.getElementById("character");
const speed = 10; 

let posX = 100; 
let posY = 100; 

function updateCharacterImage(imageUrl) {
  character.src = imageUrl;
}


document.addEventListener("keydown", function (e) {
    switch (e.key) {
        case "ArrowUp":
            posY = Math.max(0, posY - speed);
            break;
        case "ArrowDown":
            posY = Math.min(window.innerHeight - character.offsetHeight, posY + speed);
            break;
        case "ArrowLeft":
            posX = Math.max(0, posX - speed);
            break;
        case "ArrowRight":
            posX = Math.min(window.innerWidth - character.offsetWidth, posX + speed);
            break;
    }
    
    character.style.top = posY + "px";
    character.style.left = posX + "px";
});


updateCharacterImage('./img/default.png');  



//index table
function toggleDetails(row) {
    const nextRow = row.nextElementSibling;
    if (nextRow && nextRow.classList.contains('details')) {
      nextRow.style.display = nextRow.style.display === 'table-row' ? 'none' : 'table-row';
    }
  }
//         // Apply the slide-in effect to both images after a slight delay
//         setTimeout(() => {
//           topImage.classList.add("slide-in");
//           bottomImage.classList.add("slide-in");
//         }, 100); // Delay to ensure proper animation start

//         // Optional: Hide after animation
//         setTimeout(() => {
//           topImage.classList.add("hide");
//           bottomImage.classList.add("hide");
//         }, 1600); // After the slide-in animation
//       });


//       //onload function that displays a video
// window.onload = function() {
//     var video = document.getElementById("video");
    
//     // Ensure the video is muted (required for autoplay in some browsers)
//     video.muted = true;

//     // Display the video and position it in the center
//     video.style.display = "block";
//     video.style.position = "absolute";
//     video.style.top = "50%";
//     video.style.left = "50%";
//     video.style.transform = "translate(-50%, -50%)";
//     video.style.zIndex = "9999";
//     video.style.width = "100%";
//     video.style.height = "auto";
    
//     // Wait for the video to be ready to play
//     video.oncanplay = function() {
//         // Play the video once it's ready
//         video.play();
        
//         // Set a timeout to pause and hide the video after 6 seconds
//         setTimeout(function() {
//             video.pause();  // Pause the video
//             video.style.display = "none";  // Hide the video
//         }, 6000);  // 6 seconds
//     };

//     // Start loading the video (this step is important to trigger the oncanplay event)
//     video.load();
// }







