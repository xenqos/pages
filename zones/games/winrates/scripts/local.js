/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const arrWinRates =
{
'AAp': 86, 'KKp': 75, 'QQp': 69, 'JJp': 64, 'TTp': 61, '99p': 55, '88p': 52, '77p': 29, '66p': 26, '55p': 21, '44p': 8, '33p': 5, '22p': 4,
'AKs': 69, 'AKo': 67, 'AQs': 65, 'AQo': 61, 'AJs': 59, 'AJo': 49, 'ATs': 51, 'ATo': 34,
'A9s': 41, 'A9o': 17, 'A8s': 42, 'A8o': 10, 'A7s': 34, 'A7o': 10, 'A6s': 30, 'A6o': 10,
'A5s': 30, 'A5o': 9,  'A4s': 31, 'A4o': 10, 'A3s': 21, 'A3o': 9,  'A2s': 20, 'A2o': 9,
'KQs': 55, 'KQo': 39, 'KJs': 45, 'KJo': 21, 'KTs': 41, 'K9s': 20,
'QJs': 44, 'QJo': 17, 'QTs': 39, 'QTo': 9,  'Q9s': 19, 'Q9o': 9,
'JTs': 40, 'JTo': 9,  'J9s': 28, 'J9o': 8,
'T9s': 38, 'T9o': 9
};

const arrSuits = ['S', 'H', 'C', 'D'];

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

function fncGetRandomSuits(arrTemp, intNumberOfSuits) {
  const arrSource = [...arrTemp];
  const arrResult = [];

  if (intNumberOfSuits > arrSource.length)
  {
    intNumberOfSuits = arrSource.length;
  }strHiddenColor

  for (let i = 0; i < intNumberOfSuits; i++)
  {
    const randomIndex = Math.floor(Math.random() * arrSource.length);
    const selectedElement = arrSource[randomIndex];
    arrResult.push(selectedElement);
    arrSource.splice(randomIndex, 1);
  }

  return arrResult;
}

/*--------------------------------------------------------------------------------------------------*/

function fncDealCards()
{
  var objHoleCards = document.querySelector('meta[name="hole-cards"]');
  var strHoleCards = objHoleCards.getAttribute('content');

  const arrTargetSuits = fncGetRandomSuits(arrSuits, 3);

  if (strHoleCards[0] === strHoleCards[1])
  {
    document.getElementById('idNameP').textContent = strHoleCards + 'p';
    document.getElementById('idWinRateP').textContent = arrWinRates[strHoleCards + 'p'];

    document.getElementById('idWinRateP').style.color = strHiddenColor;
    document.getElementById('idWinRateP').style.backgroundColor = strHiddenBackgroundColor;

    document.getElementById('idCard1').setAttribute('src', strImagePrefix + strHoleCards[0] + arrTargetSuits[0] + strImageSuffix);
    document.getElementById('idCard2').setAttribute('src', strImagePrefix + strHoleCards[1] + arrTargetSuits[0] + strImageSuffix);
  }
  else
  {
    document.getElementById('idCard1').setAttribute('src', strImagePrefix + strHoleCards[0] + arrTargetSuits[0] + strImageSuffix);
    document.getElementById('idCard2').setAttribute('src', strImagePrefix + strHoleCards[1] + arrTargetSuits[0] + strImageSuffix);
    document.getElementById('idCard3').setAttribute('src', strImagePrefix + strHoleCards[0] + arrTargetSuits[1] + strImageSuffix);
    document.getElementById('idCard4').setAttribute('src', strImagePrefix + strHoleCards[1] + arrTargetSuits[2] + strImageSuffix);

    document.getElementById('idNameS').textContent = strHoleCards + 's';
    document.getElementById('idNameO').textContent = strHoleCards + 'o';

    document.getElementById('idWinRateS').textContent = arrWinRates[strHoleCards + 's'];
    document.getElementById('idWinRateS').style.color = strHiddenColor;
    document.getElementById('idWinRateS').style.backgroundColor = strHiddenBackgroundColor;

    document.getElementById('idWinRateO').textContent = arrWinRates[strHoleCards + 'o'];
    document.getElementById('idWinRateO').style.color = strHiddenColor;
    document.getElementById('idWinRateO').style.backgroundColor = strHiddenBackgroundColor;
  }
}

/*--------------------------------------------------------------------------------------------------*/
