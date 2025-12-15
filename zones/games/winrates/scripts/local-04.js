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

const strRevealedColor           = '#367b36';
const strRevealedBackgroundColor = '#ffffff';

const strHiddenColor             = '#e0e0e0';
const strHiddenBackgroundColor   = '#e0e0e0';

const strImagePrefix = '../../../../images/cards/';
const strImageSuffix = '.svg';

/*--------------------------------------------------------------------------------------------------*/

async function fncDealCards()
{
  objConsoleLog = document.getElementById('idConsoleLog');
  objConsoleLog.innerHTML = '';

  // Get random key from conArrWinRates
  const keys = Object.keys(conArrWinRates);
  const randomIndex = Math.floor(Math.random() * keys.length);
  strHolePair = keys[randomIndex];  // strHoleKey
  const strHoleValue = conArrWinRates[strHolePair];  // strHoleValue

  // Initialize card strings
  conArrCards[0] = '';
  conArrCards[1] = '';

  // Add the first character of strHolePair to conArrCards[0]
  conArrCards[0] += strHolePair.charAt(0);
  // Add the second character of strHolePair to conArrCards[1]
  conArrCards[1] += strHolePair.charAt(1);

  // Get the third character (suit type indicator)
  const suitType = strHolePair.charAt(2);

  // Get a shuffled copy of suits for random selection
  const shuffledSuits = [...conArrSuits].sort(() => Math.random() - 0.5);

  if (suitType === 's') {
    // 's' for suited - same suit for both cards
    const suit = shuffledSuits[0];
    conArrCards[0] += suit;
    conArrCards[1] += suit;
  } else if (suitType === 'o') {
    // 'o' for offsuited - different suits
    conArrCards[0] += shuffledSuits[0];
    conArrCards[1] += shuffledSuits[1];
  } else if (suitType === 'p') {
    // 'p' for pocket pair - different suits (can't have same card)
    conArrCards[0] += shuffledSuits[0];
    conArrCards[1] += shuffledSuits[1];
  }

  // Display the cards
  document.getElementById('idCard0').src = '../../../images/cards/' + conArrCards[0] + '.svg';
  document.getElementById('idCard1').src = '../../../images/cards/' + conArrCards[1] + '.svg';

  // Optional: Log the hole pair and win rate for debugging
  console.log(`Dealt: ${strHolePair} (Win Rate: ${strHoleValue}%)`);
  console.log(`Cards: ${conArrCards[0]}, ${conArrCards[1]}`);
}

/*--------------------------------------------------------------------------------------------------*/

function fncRevealWinRate(objElementAnswer)
{
  objElementAnswer.style.color = strRevealedColor;
  objElementAnswer.style.backgroundColor = strRevealedBackgroundColor;
}

/*--------------------------------------------------------------------------------------------------*/
