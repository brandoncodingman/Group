//char select - DEBUG VERSION
const tableBody = document.querySelector('table tbody');
const selectContainer = document.querySelector('.select-container'); 
const purchaseButton = document.getElementById('purchase-button');

let charactersData = {};
let selectedCharacterKey = null;

console.log('DEBUG: Script loaded, elements found:', {
  tableBody: !!tableBody,
  selectContainer: !!selectContainer,
  purchaseButton: !!purchaseButton
});

// Load user's current character on page load
function loadUserCharacter() {
  fetch('./actions/get_user_character.php')
    .then(response => response.json())
    .then(data => {
      console.log('DEBUG: User character data:', data);
      if (data.success && data.character_key) {
        updateCharacterImage(data.character_data.img_src);
        console.log('DEBUG: Loaded user character:', data.character_data.name);
      }
    })
    .catch(error => {
      console.log('DEBUG: No user character found or error:', error);
    });
}

// Load character facts 
fetch('./config/characterdatabase.php')
  .then(response => {
    console.log('DEBUG: Fetch response status:', response.status);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('DEBUG: Raw data from PHP:', data);
    
    // error check
    if (data.error) {
      console.error('DEBUG: Data contains error:', data.error);
      throw new Error(data.error);
    }

    charactersData = data;
    console.log('DEBUG: Characters data stored:', charactersData);

    for (const key in data) {
      const character = data[key];
      character.id = key;
      console.log('DEBUG: Processing character:', key, character);
      
      const characterCard = createCharacterCard(character);
      selectContainer.appendChild(characterCard);
    }

    const characterList = document.querySelectorAll('.character');
    console.log('DEBUG: Found character elements:', characterList.length);

    characterList.forEach(character => {
      character.addEventListener('click', function () {
        console.log('DEBUG: Character clicked:', character.getAttribute('data-key'));
       
        const activeCharacter = document.querySelector('.character.active');
        if (activeCharacter) activeCharacter.classList.remove('active');
        character.classList.add('active');

        const characterKey = character.getAttribute('data-key');
        selectedCharacterKey = characterKey;
        const selectedCharacter = data[characterKey];

        console.log('DEBUG: Selected character data:', selectedCharacter);

        if (selectedCharacter) {
          updateTable(selectedCharacter.facts, selectedCharacter.name, selectedCharacter.points);
          // purchase button
          purchaseButton.disabled = false;
          purchaseButton.textContent = `Buy (${selectedCharacter.points} points)`;
          console.log('DEBUG: Purchase button updated:', purchaseButton.textContent);
        } else {
          updateTable([], 'Character not found', 0);
          purchaseButton.disabled = true;
          purchaseButton.textContent = 'Buy';
          console.log('DEBUG: Character not found, button disabled');
        }
      });
    });

    //  disable purchase button initially
    if (purchaseButton) {
      purchaseButton.disabled = true;
      console.log('DEBUG: Purchase button initially disabled');
    }

    // Load user's current character after characters are loaded
    loadUserCharacter();
  })
  .catch(error => {
    console.error('DEBUG: Failed to load character data:', error);
     
    const errorDiv = document.createElement('div');
    errorDiv.style.cssText = 'color: red; text-align: center; padding: 20px; font-size: 18px;';
    errorDiv.textContent = 'Failed to load character data. Please check your database connection.';
    if (selectContainer) {
      selectContainer.appendChild(errorDiv);
    }
  });

if (purchaseButton) {
  purchaseButton.addEventListener('click', function() {
    console.log('DEBUG: Purchase button clicked, selectedCharacterKey:', selectedCharacterKey);
    
    if (!selectedCharacterKey) {
      alert('Please select a character first');
      return;
    }

    const selectedCharacter = charactersData[selectedCharacterKey];
    console.log('DEBUG: About to purchase character:', selectedCharacter);
    
    if (confirm(`Purchase ${selectedCharacter.name} for ${selectedCharacter.points} points?`)) {
      purchaseCharacter(selectedCharacterKey);
    }
  });
} else {
  console.error('DEBUG: Purchase button not found!');
}

// Purchase function
function purchaseCharacter(characterKey) {
  console.log('DEBUG: Starting purchase for character:', characterKey);
  
  purchaseButton.disabled = true;
  purchaseButton.textContent = 'Processing...';

  fetch('./actions/purchase_character.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      character_key: characterKey
    })
  })
  .then(response => {
    console.log('DEBUG: Purchase response status:', response.status);
    return response.json();
  })
  .then(data => {
    console.log('DEBUG: Purchase response data:', data);
    
    if (data.success) {
      updateCharacterImage(data.character.imgSrc);
      
      updatePointsDisplay(data.newPoints);
      
      alert(`Successfully purchased ${data.character.name}! You spent ${data.spent} points.`);
      
      // Reset button
      purchaseButton.disabled = false;
      purchaseButton.textContent = `Buy (${charactersData[selectedCharacterKey].points} points)`;
    } else {
      console.error('DEBUG: Purchase failed:', data.error);
      alert(data.error || 'Purchase failed');
      purchaseButton.disabled = false;
      purchaseButton.textContent = `Buy (${charactersData[selectedCharacterKey].points} points)`;
    }
  })
  .catch(error => {
    console.error('DEBUG: Purchase error:', error);
    alert('Purchase failed. Please try again.');
    purchaseButton.disabled = false;
    purchaseButton.textContent = `Buy (${charactersData[selectedCharacterKey].points} points)`;
  });
}

// Function to update the character image
function updateCharacterImage(imageSrc) {
  console.log('DEBUG: Updating character image to:', imageSrc);
  const characterImg = document.getElementById('character');
  if (characterImg && imageSrc) {
    characterImg.src = imageSrc;
    console.log('DEBUG: Character image updated successfully');
  } else {
    console.log('DEBUG: Character image element not found or no image source provided');
  }
}

function updatePointsDisplay(newPoints) {
  console.log('DEBUG: Updating points display to:', newPoints);
  const pointElements = document.querySelectorAll('.point-value');
  console.log('DEBUG: Found point elements:', pointElements.length);
  pointElements.forEach(el => {
    el.textContent = newPoints;
  });
}

// create character card 
function createCharacterCard(character) {
  console.log('DEBUG: Creating card for character:', character);
  
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

  // Add points 
  const pointsElem = document.createElement('p');
  pointsElem.classList.add('character__points');
  pointsElem.textContent = `${character.points || 'Unknown'} points`;
  pointsElem.style.cssText = 'color: #ffd700; font-weight: bold; margin-top: 5px;';

  console.log('DEBUG: Character points for', character.name, ':', character.points);

  characterElem.appendChild(imgElem);
  characterElem.appendChild(nameElem);
  characterElem.appendChild(pointsElem);

  return characterElem;
}

// update table
function updateTable(facts, characterName, characterPoints = 0) {
  console.log('DEBUG: Updating table for:', characterName, 'Points:', characterPoints);
  
  tableBody.innerHTML = ''; 

  const nameRow = document.createElement('tr');
  const nameCell = document.createElement('td');
  nameCell.textContent = characterName;
  nameCell.colSpan = 2;
  nameCell.style.fontWeight = 'bold';
  nameRow.appendChild(nameCell);
  tableBody.appendChild(nameRow);

  // Add points row
  const pointsRow = document.createElement('tr');
  const pointsCell = document.createElement('td');
  pointsCell.innerHTML = `<strong>Cost: ${characterPoints || 'Unknown'} points</strong>`;
  pointsCell.colSpan = 2;
  pointsCell.style.color = '#ffd700';
  pointsRow.appendChild(pointsCell);
  tableBody.appendChild(pointsRow);

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