/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

let numTimeout = null;

function fncGetOuts()
{
  const arrSuits = ['S', 'H', 'C', 'D'];
  const arrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
  const arrCards = [];

  for (let intCounter = 1; intCounter <= 5; intCounter++)
  {
    const numRankIndex = Math.floor(Math.random() * arrRanks.length);
    const numRank = arrRanks[numRankIndex];

    const numSuitIndex = Math.floor(Math.random() * arrSuits.length);
    const numSuit = arrSuits[numSuitIndex];

    const strPair = numRank + numSuit;
    arrCards.push(strPair);

    document.getElementById('idCard' + intCounter).src = '../../../images/cards/' + numRank + numSuit + '.svg';
  }

  console.log(arrCards);
}

/*--------------------------------------------------------------------------------------------------*/
//  alert('ZZZ…');
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
