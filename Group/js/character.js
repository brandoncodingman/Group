//char select
const tableBody = document.querySelector('table tbody');
const selectContainer = document.querySelector('.select-container'); // Add this line

// Load character facts 
fetch('./config/characterdatabase.php')
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    // error check
    if (data.error) {
      throw new Error(data.error);
    }

    // creat table from api data
    for (const key in data) {
      const character = data[key];
      character.id = key; 
      const characterCard = createCharacterCard(character);
      selectContainer.appendChild(characterCard);
    }

    const characterList = document.querySelectorAll('.character');

    characterList.forEach(character => {
      character.addEventListener('click', function () {
       
        const activeCharacter = document.querySelector('.character.active');
        if (activeCharacter) activeCharacter.classList.remove('active');
        character.classList.add('active');

        
        const characterKey = character.getAttribute('data-key');
        const selectedCharacter = data[characterKey];

        if (selectedCharacter) {
          updateTable(selectedCharacter.facts, selectedCharacter.name);
        } else {
          updateTable([], 'Character not found');
        }
      });
    });
  })
  .catch(error => {
    console.error('Failed to load character data:', error);
    
    // Display error message 
    const errorDiv = document.createElement('div');
    errorDiv.style.cssText = 'color: red; text-align: center; padding: 20px; font-size: 18px;';
    errorDiv.textContent = 'Failed to load character data. Please check your database connection.';
    selectContainer.appendChild(errorDiv);
  });

// create character card HTML
function createCharacterCard(character) {
  const characterElem = document.createElement('div');
  characterElem.classList.add('character');
  characterElem.setAttribute('data-key', character.id); 
  const imgElem = document.createElement('img');
  imgElem.classList.add('character__img');
  imgElem.src = character.imgSrc;
  imgElem.alt = character.name;

  const nameElem = document.createElement('p');
  nameElem.classList.add('character__name');
  nameElem.textContent = character.name;

  characterElem.appendChild(imgElem);
  characterElem.appendChild(nameElem);

  return characterElem;
}

// update the table
function updateTable(facts, characterName) {
  tableBody.innerHTML = ''; 

  const nameRow = document.createElement('tr');
  const nameCell = document.createElement('td');
  nameCell.textContent = characterName;
  nameCell.colSpan = 2;
  nameCell.style.fontWeight = 'bold';
  nameRow.appendChild(nameCell);
  tableBody.appendChild(nameRow);

  if (facts && facts.length > 0) {
    facts.forEach(fact => {
      const factRow = document.createElement('tr');
      const factCell = document.createElement('td');
      factCell.textContent = fact;
      factCell.colSpan = 2;
      factRow.appendChild(factCell);
      tableBody.appendChild(factRow);
    });
  } else {
    const noFactsRow = document.createElement('tr');
    const noFactsCell = document.createElement('td');
    noFactsCell.textContent = 'No facts available';
    noFactsCell.colSpan = 2;
    noFactsCell.style.fontStyle = 'italic';
    noFactsRow.appendChild(noFactsCell);
    tableBody.appendChild(noFactsRow);
  }
}