
        const videoElement = document.getElementById('videoElement');
        const imageElement = document.getElementById('imageElement');

        videoElement.onended = function() {
            videoElement.style.display = 'none';
            imageElement.style.display = 'block';
        };