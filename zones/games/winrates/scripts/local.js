/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const arrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
const arrSuits = ['S', 'H', 'C', 'D'];
const arrCards = [];

let strHolePair = '';
let strHoleKey = '';
let strHoleValue = '';
let objConsoleLog = null;

let numRange = 0;

const arrRanges = [
  [0, 12],
  [13, 20],
  [21, 28],
  [29, 36],
  [37, 44],
  [45, 50],
  [51, 56]
];

const arrWinRates =
{
  'AAp': 86, 'KKp': 75, 'QQp': 69, 'JJp': 64, 'TTp': 61, '99p': 55, '88p': 52, '77p': 29, '66p': 26, '55p': 21, '44p': 9, '33p': 5, '22p': 4,
  'AKs': 69, 'AKo': 67, 'AQs': 65, 'AQo': 61, 'AJs': 59, 'AJo': 49, 'ATs': 51, 'ATo': 34,
  'A9s': 41, 'A9o': 17, 'A8s': 42, 'A8o': 10, 'A7s': 34, 'A7o': 10, 'A6s': 30, 'A6o': 10,
  'A5s': 30, 'A5o': 9,  'A4s': 31, 'A4o': 10, 'A3s': 21, 'A3o': 9,  'A2s': 20, 'A2o': 9,
  'KQs': 55, 'KQo': 39, 'KJs': 45, 'KJo': 21, 'KTs': 41, 'KTo': 9,  'K9s': 20, 'K9o': 8,
  'QJs': 44, 'QJo': 17, 'QTs': 39, 'QTo': 9,  'Q9s': 19, 'Q9o': 9,
  'JTs': 40, 'JTo': 9,  'J9s': 28, 'J9o': 8,  'T9s': 38, 'T9o': 9
};

/*--------------------------------------------------------------------------------------------------*/

const strRevealedColor           = '#cc0000';
const strRevealedBackgroundColor = '#ffffff';

const strHiddenColor             = '#e0e0e0';
const strHiddenBackgroundColor   = '#e0e0e0';

const strImagePrefix = '../../../images/cards/';
const strImageSuffix = '.svg';

/*--------------------------------------------------------------------------------------------------*/

function fncSetRange()
{
  const objRangeSelect = document.getElementById('idRange');
  const strSelectedValue = objRangeSelect.value;
  numRange = parseInt(strSelectedValue, 10);
  fncDealCards();
}

/*--------------------------------------------------------------------------------------------------*/

async function fncDealCards()
{
  objConsoleLog = document.getElementById('idConsoleLog');
  objConsoleLog.innerHTML = '';

  const numRangeBegin = arrRanges[numRange][0];
  const numRangeEnd = arrRanges[numRange][1];

  const arrKeys = Object.keys(arrWinRates);

  const numValidStart = Math.max(0, numRangeBegin);
  const numValidEnd = Math.min(numRangeEnd, arrKeys.length - 1);

  const arrSubsetKeys = arrKeys.slice(numValidStart, numValidEnd + 1);

  if (arrSubsetKeys.length === 0)
  {
    console.error('Subset range is empty. Check numRangeBegin and numRangeEndvalues.');
    return;
  }

  const numRandomIndex = Math.floor(Math.random() * arrSubsetKeys.length);
  strHoleKey = arrSubsetKeys[numRandomIndex];
  strHoleValue = arrWinRates[strHoleKey];

  arrCards[0] = '';
  arrCards[1] = '';

  arrCards[0] += strHoleKey.charAt(0);
  arrCards[1] += strHoleKey.charAt(1);

  const strSuitType = strHoleKey.charAt(2);

  const arrShuffledSuits = [...arrSuits].sort(() => Math.random() - 0.5);

  if (strSuitType === 's')
  {
    const strSuit = arrShuffledSuits[0];
    arrCards[0] += strSuit;
    arrCards[1] += strSuit;
    document.getElementById('idCount').textContent = '4';
  }
  else if (strSuitType === 'o')
  {
    arrCards[0] += arrShuffledSuits[0];
    arrCards[1] += arrShuffledSuits[1];
    document.getElementById('idCount').textContent = '12';
  }
  else if (strSuitType === 'p')
  {
    arrCards[0] += arrShuffledSuits[0];
    arrCards[1] += arrShuffledSuits[1];
    document.getElementById('idCount').textContent = '6';
  }

  document.getElementById('idCard0').src = strImagePrefix + arrCards[0] + strImageSuffix;
  document.getElementById('idCard1').src = strImagePrefix + arrCards[1] + strImageSuffix;

  document.getElementById('idWinRate').textContent = strHoleValue;

  console.log(`Dealt: ${strHoleKey} (Win Rate: ${strHoleValue}%)`);
  console.log(`Cards: ${arrCards[0]}, ${arrCards[1]}`);
  console.log(`Subset range: ${numValidStart} to ${numValidEnd} (${arrSubsetKeys.length} hands)`);
}

/*--------------------------------------------------------------------------------------------------*/

function fncRevealWinRate(objElementAnswer)
{
  objElementAnswer.style.color = strRevealedColor;
  objElementAnswer.style.backgroundColor = strRevealedBackgroundColor;
}

/*--------------------------------------------------------------------------------------------------*/
