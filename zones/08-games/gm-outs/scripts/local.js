/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const arrSuits = ['S', 'H', 'C', 'D'];
const arrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
let arrCards = [];
let booTurn = false;

/*--------------------------------------------------------------------------------------------------*/

function fncDealCards()
{
  arrCards.length = 0;

  while (arrCards.length < 6)
  {
    let numRankIndex = Math.floor(Math.random() * arrRanks.length);
    let strRank = arrRanks[numRankIndex];

    let numSuitIndex = Math.floor(Math.random() * arrSuits.length);
    let strSuit = arrSuits[numSuitIndex];

    let strCard = strRank + strSuit;

    if (!arrCards.includes(strCard))
    {
      arrCards.push(strCard);
    }
  }

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
}

/*--------------------------------------------------------------------------------------------------*/

function fncShowTurn()
{
  if (booTurn === false)
  {
    document.getElementById('idCard5').src = '../../../images/cards/' + arrCards[5] + '.svg';
    booTurn = true;
  }
  else
  {
    booTurn = false;
    fncDealCards();
  }
}

/*--------------------------------------------------------------------------------------------------*/
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
