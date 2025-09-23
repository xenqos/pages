/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

let numCounter = 0;

const arrSuits = ['S', 'H', 'C', 'D'];
const arrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];

let numRankIndex = 0;
let numRank = 0;

let numSuitIndex = 0;
let numSuit = 0;

let strCard = '';

let arrHole = [];
let arrFlop = [];
let strTurn = '';

/*--------------------------------------------------------------------------------------------------*/

function fncDealFlop()
{
  arrHole.length = 0;
  arrFlop.length = 0;

  /* Hole */

  for (numCounter = 1; numCounter <= 2; numCounter++)
  {
    numRankIndex = Math.floor(Math.random() * arrRanks.length);
    numRank = arrRanks[numRankIndex];
    numSuitIndex = Math.floor(Math.random() * arrSuits.length);
    numSuit = arrSuits[numSuitIndex];
    strCard = numRank + numSuit;
    arrHole.push(strCard);

    document.getElementById('idHole' + numCounter).src = '../../../images/cards/' + numRank + numSuit + '.svg';
  }

  /* Flop */

  for (numCounter = 1; numCounter <= 3; numCounter++)
  {
    numRankIndex = Math.floor(Math.random() * arrRanks.length);
    numRank = arrRanks[numRankIndex];
    numSuitIndex = Math.floor(Math.random() * arrSuits.length);
    numSuit = arrSuits[numSuitIndex];
    strCard = numRank + numSuit;
    arrFlop.push(strCard);

    document.getElementById('idFlop' + numCounter).src = '../../../images/cards/' + numRank + numSuit + '.svg';
  }

  /* Turn */

  numRankIndex = Math.floor(Math.random() * arrRanks.length);
  numRank = arrRanks[numRankIndex];
  numSuitIndex = Math.floor(Math.random() * arrSuits.length);
  numSuit = arrSuits[numSuitIndex];
  strTurn = numRank + numSuit;

  document.getElementById('idTurn').src = '../../../images/cards/back.svg';
}

/*--------------------------------------------------------------------------------------------------*/

function fncDealTurn()
{
  document.getElementById('idTurn').src = '../../../images/cards/' + strTurn + '.svg';
}

/*--------------------------------------------------------------------------------------------------*/
//  alert('ZZZ…');
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
