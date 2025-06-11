// Global character loader 
document.addEventListener('DOMContentLoaded', function() {
    console.log('DEBUG: Global character loader starting...');
    
    const characterImg = document.getElementById('character');
    if (!characterImg) {
        console.log('DEBUG: No character image element found on this page');
        return;
    }

    fetch('./actions/get_user_character.php')
        .then(response => {
            console.log('DEBUG: Get user character response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('DEBUG: User character data:', data);
            if (data.success && data.character_key && data.character_data.img_src) {
                characterImg.src = data.character_data.img_src;
                console.log('DEBUG: Updated character image to:', data.character_data.img_src);
                console.log('DEBUG: Character loaded:', data.character_data.name);
            } else {
                console.log('DEBUG: No user character found, keeping default image');
            }
        })
        .catch(error => {
            console.log('DEBUG: Error loading user character (keeping default):', error);
        });
});

function updateGlobalCharacterImage(imageSrc) {
    console.log('DEBUG: Updating global character image to:', imageSrc);
    const characterImg = document.getElementById('character');
    if (characterImg && imageSrc) {
        characterImg.src = imageSrc;
        console.log('DEBUG: Global character image updated successfully');
    } else {
        console.log('DEBUG: Character image element not found or no image source provided');
    }
}