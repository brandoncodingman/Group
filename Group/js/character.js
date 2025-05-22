const characterArray = {
    "Earth": {
        "name": "Earth",
        "id": "earth",
        "imgSrc": "./img/earth.jfif"
    },
    "Jupiter": {
        "name": "Jupiter",
        "id": "jupiter",
        "imgSrc": "./img/jupiter.jfif"
    },
    "Mars": {
        "name": "Mars",
        "id": "mars",
        "imgSrc": "./img/mars.jfif"
    },
    "Venus": {
        "name": "Venus",
        "id": "venus",
        "imgSrc": "./img/venus.jfif"
    },
    "Mercury": {
        "name": "Mercury",
        "id": "mercury",
        "imgSrc": "./img/mercury.jfif"
    },
    "Uranus": {
        "name": "Uranus",
        "id": "uranus",
        "imgSrc": "./img/uranus.jfif"
    },
    "Saturn": {
        "name": "Saturn",
        "id": "saturn",
        "imgSrc": "./img/saturn.jfif"
    },
    "Neptune": {
        "name": "Neptune",
        "id": "neptune",
        "imgSrc": "./img/neptune.jfif"
    },
    "Moon": {
        "name": "Moon",
        "id": "moon",
        "imgSrc": "./img/moon.jfif"
    },
    "Sun": {
        "name": "Sun",
        "id": "sun",
        "imgSrc": "./img/sun.jfif"
    },
    "Earth2": {
        "name": "Earth",
        "id": "earth",
        "imgSrc": "./img/earth.jfif"
    },
    "Earth3": {
        "name": "Earth",
        "id": "earth",
        "imgSrc": "./img/earth.jfif"
    },
    "Earth4": {
        "name": "Earth",
        "id": "earth",
        "imgSrc": "./img/earth.jfif"
    },
    "Earth5": {
        "name": "Earth",
        "id": "earth",
        "imgSrc": "./img/earth.jfif"
    },
};

const selectContainer = document.querySelector('.select-container');

// Function to create character card HTML
function createCharacterCard(character) {
    const characterElem = document.createElement('div');
    characterElem.classList.add('character');
    characterElem.setAttribute('data-name', character.id);
    characterElem.setAttribute('rel', character.name);

    const imgElem = document.createElement('img');
    imgElem.classList.add('character__img');
    imgElem.src = character.imgSrc;

    const nameElem = document.createElement('p');
    nameElem.classList.add('character__name');
    nameElem.textContent = character.name;

    characterElem.appendChild(imgElem);
    characterElem.appendChild(nameElem);

    return characterElem;
}

// Add character cards to container
for (const key in characterArray) {
    const character = characterArray[key];
    const characterCard = createCharacterCard(character);
    selectContainer.appendChild(characterCard);
}

// character selection
const characterList = document.querySelectorAll('.character');

characterList.forEach(function(character) {
    character.addEventListener('click', function() {
        const activeCharacter = document.querySelector('.character.active');
        if (activeCharacter) {
            activeCharacter.classList.remove('active');
        }
        character.classList.add('active');
    });
});



