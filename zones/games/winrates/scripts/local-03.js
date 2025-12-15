/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const conArrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
const conArrSuits = ['S', 'H', 'C', 'D'];
let arrCards = [];
let strHolePair = '';
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

  let validCardsFound = false;

  while (!validCardsFound)
  {
    arrCards.length = 0;

    // Deal two unique cards
    while (arrCards.length < 2)
    {
      let numRankIndex = Math.floor(Math.random() * conArrRanks.length);
      let strRank = conArrRanks[numRankIndex];

      let numSuitIndex = Math.floor(Math.random() * conArrSuits.length);
      let strSuit = conArrSuits[numSuitIndex];

      let strCard = strRank + strSuit;

      if (!arrCards.includes(strCard))
      {
        arrCards.push(strCard);
      }
    }

    // Create strHolePair
    strHolePair = '';

    // Get ranks from both cards
    let rank1 = arrCards[0].charAt(0); // First character is rank
    let rank2 = arrCards[1].charAt(0);

    // Sort ranks according to specified order: A, K, Q, J, T, 9, 8, 7, 6, 5, 4, 3, 2
    const sortOrder = ['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'];

    // Get index in sortOrder
    let index1 = sortOrder.indexOf(rank1);
    let index2 = sortOrder.indexOf(rank2);

    // Add higher rank (lower index in sortOrder) first
    if (index1 < index2) {
      strHolePair += rank1 + rank2;
    } else if (index1 > index2) {
      strHolePair += rank2 + rank1;
    } else {
      // Same rank - pocket pair
      strHolePair += rank1 + rank2;
    }

    // Determine suit type and add suffix
    let suit1 = arrCards[0].charAt(1); // Second character is suit
    let suit2 = arrCards[1].charAt(1);

    if (rank1 === rank2) {
      // Pocket pair
      strHolePair += 'p';
    } else if (suit1 === suit2) {
      // Suited
      strHolePair += 's';
    } else {
      // Offsuited
      strHolePair += 'o';
    }

    // Check if strHolePair exists in conArrWinRates
    if (conArrWinRates.hasOwnProperty(strHolePair)) {
      validCardsFound = true;

      // Display the cards
      for (let numCounter = 0; numCounter < arrCards.length; numCounter++)
      {
        document.getElementById('idCard' + numCounter).src = '../../../images/cards/' + arrCards[numCounter] + '.svg';
      }
    }
    // If not found, loop will continue
  }
}

/*--------------------------------------------------------------------------------------------------*/
