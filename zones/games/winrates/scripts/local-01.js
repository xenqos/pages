/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const conArrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
const conArrSuits = ['S', 'H', 'C', 'D'];
let arrCards = [];
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

function fncRevealWinRate(objElementAnswer)
{
  objElementAnswer.style.color = strRevealedColor;
  objElementAnswer.style.backgroundColor = strRevealedBackgroundColor;
}

/*--------------------------------------------------------------------------------------------------*/

async function fncDealCards()
{
  arrCards.length = 0;
  objConsoleLog = document.getElementById('idConsoleLog');
  objConsoleLog.innerHTML = '';

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

  // Test Values Begin
  // arrCards = ['2H', '7C', '8S'];
  // Test Values End

  for (let numCounter = 0; numCounter < arrCards.length; numCounter++)
  {
    if (numCounter < 5)
    {
      document.getElementById('idCard' + numCounter).src = '../../../images/cards/' + arrCards[numCounter] + '.svg';
    }
    else
    {
      document.getElementById('idCard' + numCounter).src = '../../../images/cards/back.svg';
    }
  }

//  fncIdentifyBoard();

// const arrTargetSuits = fncGetRandomSuits(conArrSuits, 3);
//
// if (strHoleCards[0] === strHoleCards[1])
// {
//   document.getElementById('idNameP').textContent = strHoleCards + 'p';
//   document.getElementById('idWinRateP').textContent = conArrWinRates[strHoleCards + 'p'];
//
//   document.getElementById('idWinRateP').style.color = strHiddenColor;
//   document.getElementById('idWinRateP').style.backgroundColor = strHiddenBackgroundColor;
//
//   document.getElementById('idCard1').setAttribute('src', strImagePrefix + strHoleCards[0] + arrTargetSuits[0] + strImageSuffix);
//   document.getElementById('idCard2').setAttribute('src', strImagePrefix + strHoleCards[1] + arrTargetSuits[1] + strImageSuffix);
// }
// else
// {
//   document.getElementById('idCard1').setAttribute('src', strImagePrefix + strHoleCards[0] + arrTargetSuits[0] + strImageSuffix);
//   document.getElementById('idCard2').setAttribute('src', strImagePrefix + strHoleCards[1] + arrTargetSuits[0] + strImageSuffix);
//   document.getElementById('idCard3').setAttribute('src', strImagePrefix + strHoleCards[0] + arrTargetSuits[1] + strImageSuffix);
//   document.getElementById('idCard4').setAttribute('src', strImagePrefix + strHoleCards[1] + arrTargetSuits[2] + strImageSuffix);
//
//   document.getElementById('idNameS').textContent = strHoleCards + 's';
//   document.getElementById('idNameO').textContent = strHoleCards + 'o';
//
//   document.getElementById('idWinRateS').textContent = conArrWinRates[strHoleCards + 's'];
//   document.getElementById('idWinRateS').style.color = strHiddenColor;
//   document.getElementById('idWinRateS').style.backgroundColor = strHiddenBackgroundColor;
//
//   document.getElementById('idWinRateO').textContent = conArrWinRates[strHoleCards + 'o'];
//   document.getElementById('idWinRateO').style.color = strHiddenColor;
//   document.getElementById('idWinRateO').style.backgroundColor = strHiddenBackgroundColor;
// }
}


/*--------------------------------------------------------------------------------------------------*/
