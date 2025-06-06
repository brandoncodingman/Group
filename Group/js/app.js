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


window.onload = function() {
    const video = document.getElementById("video");
    
    if (!video) {
        console.error("Video element with ID 'video' not found");
        return;
    }
    
    video.muted = true;
    
    video.loop = false;
    
    video.style.display = "block";
    video.style.position = "fixed"; 
    video.style.top = "50%";
    video.style.left = "50%";
    video.style.transform = "translate(-50%, -50%)";
    video.style.zIndex = "9999";
    video.style.width = "100%"; 
    video.style.maxWidth = "100%"; 
    video.style.height = "auto";
    video.style.objectFit = "contain"; 
    
    video.onerror = function(e) {
        console.error("Error loading video:", e);
        video.style.display = "none";
    };
    
    video.oncanplay = function() {
       
        video.play().catch(function(error) {
            console.error("Error playing video:", error);
            video.style.display = "none";
        });
    };
    
    video.onended = function() {
        video.style.display = "none";
    };
    
    const hideTimeout = setTimeout(function() {
        if (video.style.display !== "none") {
            video.pause();
            video.style.display = "none";
        }
    }, 6000);
    
    video.addEventListener('ended', function() {
        clearTimeout(hideTimeout);
    });
    
    video.load();

    video.play().catch(function(error) {
        console.error("Error playing video:", error);
        video.style.display = "none";
    });
};
