/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const conArrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
const conArrSuits = ['S', 'H', 'C', 'D'];
const conArrCards = [];
let strHolePair = '';
let strHoleKey = '';
let strHoleValue = '';
let objConsoleLog = null;

const conArrWinRates =
{
'AAp': 86, 'KKp': 75, 'QQp': 69, 'JJp': 64, 'TTp': 61, '99p': 55, '88p': 52, '77p': 29, '66p': 26, '55p': 21, '44p': 8, '33p': 5, '22p': 4,
'AKs': 69, 'AKo': 67, 'AQs': 65, 'AQo': 61, 'AJs': 59, 'AJo': 49, 'ATs': 51, 'ATo': 34,
'A9s': 41, 'A9o': 17, 'A8s': 42, 'A8o': 10, 'A7s': 34, 'A7o': 10, 'A6s': 30, 'A6o': 10,
'A5s': 30, 'A5o': 9,  'A4s': 31, 'A4o': 10, 'A3s': 21, 'A3o': 9,  'A2s': 20, 'A2o': 9,
'KQs': 55, 'KQo': 39, 'KJs': 45, 'KJo': 21, 'KTs': 41, 'KTo': 9,  'K9s': 20, 'K9o': 8,
'QJs': 44, 'QJo': 17, 'QTs': 39, 'QTo': 9,  'Q9s': 19, 'Q9o': 9,
'JTs': 40, 'JTo': 9,  'J9s': 28, 'J9o': 8,
'T9s': 38, 'T9o': 9
};

/*--------------------------------------------------------------------------------------------------*/

const strRevealedColor           = '#cc0000';
const strRevealedBackgroundColor = '#ffffff';

const strHiddenColor             = '#e0e0e0';
const strHiddenBackgroundColor   = '#e0e0e0';

const strImagePrefix = '../../../images/cards/';
const strImageSuffix = '.svg';

/*--------------------------------------------------------------------------------------------------*/

async function fncDealCards()
{
  objConsoleLog = document.getElementById('idConsoleLog');
  objConsoleLog.innerHTML = '';

  // Define subset range (positions 0 to 12 inclusive)
  // const SUBSET_START = 0;
  // const SUBSET_END = 12;

  const SUBSET_START = 13;
  const SUBSET_END = 20;


  // Get all keys from conArrWinRates
  const keys = Object.keys(conArrWinRates);

  // Validate subset range
  const validStart = Math.max(0, SUBSET_START);
  const validEnd = Math.min(SUBSET_END, keys.length - 1);

  // Get subset of keys based on the specified range
  const subsetKeys = keys.slice(validStart, validEnd + 1);

  // Check if subset is not empty
  if (subsetKeys.length === 0) {
    console.error('Subset range is empty. Check SUBSET_START and SUBSET_END values.');
    return;
  }

  // Get random key from the subset
  const randomIndex = Math.floor(Math.random() * subsetKeys.length);
  strHoleKey = subsetKeys[randomIndex];
  strHoleValue = conArrWinRates[strHoleKey];  // Save to global variable

  // Initialize card strings
  conArrCards[0] = '';
  conArrCards[1] = '';

  // Add the first character of strHoleKey to conArrCards[0]
  conArrCards[0] += strHoleKey.charAt(0);
  // Add the second character of strHoleKey to conArrCards[1]
  conArrCards[1] += strHoleKey.charAt(1);

  // Get the third character (suit type indicator)
  const suitType = strHoleKey.charAt(2);

  // Get a shuffled copy of suits for random selection
  const shuffledSuits = [...conArrSuits].sort(() => Math.random() - 0.5);

  if (suitType === 's') {
    // 's' for suited - same suit for both cards
    const suit = shuffledSuits[0];
    conArrCards[0] += suit;
    conArrCards[1] += suit;
    document.getElementById('idCount').textContent = '4';
  } else if (suitType === 'o') {
    // 'o' for offsuited - different suits
    conArrCards[0] += shuffledSuits[0];
    conArrCards[1] += shuffledSuits[1];
    document.getElementById('idCount').textContent = '12';
  } else if (suitType === 'p') {
    // 'p' for pocket pair - different suits (can't have same card)
    conArrCards[0] += shuffledSuits[0];
    conArrCards[1] += shuffledSuits[1];
    document.getElementById('idCount').textContent = '6';
  }

  // Display the cards
  document.getElementById('idCard0').src = strImagePrefix + conArrCards[0] + strImageSuffix;
  document.getElementById('idCard1').src = strImagePrefix + conArrCards[1] + strImageSuffix;

  // Display the Win Rate
  document.getElementById('idWinRate').textContent = strHoleValue;

  // Optional: Log the hole pair and win rate for debugging
  console.log(`Dealt: ${strHoleKey} (Win Rate: ${strHoleValue}%)`);
  console.log(`Cards: ${conArrCards[0]}, ${conArrCards[1]}`);
  console.log(`Subset range: ${validStart} to ${validEnd} (${subsetKeys.length} hands)`);
}

/*--------------------------------------------------------------------------------------------------*/

function fncRevealWinRate(objElementAnswer)
{
  objElementAnswer.style.color = strRevealedColor;
  objElementAnswer.style.backgroundColor = strRevealedBackgroundColor;
}

/*--------------------------------------------------------------------------------------------------*/
