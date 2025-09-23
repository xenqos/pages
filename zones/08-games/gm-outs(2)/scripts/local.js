/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const arrSuits = ['S', 'H', 'C', 'D'];
const arrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
const arrCards = [];

/*--------------------------------------------------------------------------------------------------*/

function fncGetOuts()
{
  arrCards.length = 0;

  for (let intCounter = 1; intCounter <= 6; intCounter++)
  {
    const numRankIndex = Math.floor(Math.random() * arrRanks.length);
    const numRank = arrRanks[numRankIndex];

    const numSuitIndex = Math.floor(Math.random() * arrSuits.length);
    const numSuit = arrSuits[numSuitIndex];

    const strPair = numRank + numSuit;
    arrCards.push(strPair);

    if (intCounter < 6)
    {
      document.getElementById('idCard' + intCounter).src = '../../../images/cards/' + numRank + numSuit + '.svg';
    }
    else
    {
      document.getElementById('idCard' + intCounter).src = '../../../images/cards/back.svg';
    }
  }

  console.log(arrCards);
}

/*--------------------------------------------------------------------------------------------------*/

function fncShowTurn()
{
  document.getElementById('idCard6').src = '../../../images/cards/' + arrCards[5] + '.svg';
}

/*--------------------------------------------------------------------------------------------------*/
//  alert('ZZZ…');
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
