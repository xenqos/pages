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
//    if (numCounter < 5)
//    {
      document.getElementById('idCard' + numCounter).src = '../../../images/cards/' + arrCards[numCounter] + '.svg';
//    }
//    else
//    {
//      document.getElementById('idCard' + numCounter).src = '../../../images/cards/back.svg';
//    }
  }

  fncCountOuts();
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

function fncCountOuts()
{
//    const arrCards = ['6S', 'TC', '3H', '6C', 'TS', '9H'];

    console.clear()
    console.log(arrCards)

    const arrOutsNames =
    [
        "One Pair to Set",
        "One Overcard to Pair",
        "Inside Straight Draw",
        "Two Pair to Full House",
        "One Pair to Two Pair",
        "No Pair to Pair",
        "Set to Full House",
        "Trips to Full House",
        "Two Overcards to Over Pair",
        "Set to Full Quads",
        "Set to Four of a Kind",
        "Open-Ended Straight Draw",
        "Flush Draw",
        "Inside Straight Draw & Two Overcards",
        "Inside Straight Draw & Flush",
        "Open Straight Draw & Flush Draw"
    ];

let objOuts = {
  "One Pair to Set": 0,
  "One Overcard to Pair": 0,
  "Inside Straight Draw": 0,
  "Two Pair to Full House": 0,
  "One Pair to Two Pair": 0,
  "No Pair to Pair": 0,
  "Set to Full House": 0,
  "Trips to Full House": 0,
  "Two Overcards to Over Pair": 0,
  "Set to Full Quads": 0,
  "Set to Four of a Kind": 0,
  "Open-Ended Straight Draw": 0,
  "Flush Draw": 0,
  "Inside Straight Draw & Two Overcards": 0,
  "Inside Straight Draw & Flush": 0,
  "Open Straight Draw & Flush Draw": 0
};

    const arrRanks = ['2','3','4','5','6','7','8','9','T','J','Q','K','A'];
    const arrSuits = ['S','H','C','D'];

    const objOutsFlop = {};
    const objOutsTurn = {};

    for (let intI = 0; intI < arrOutsNames.length; intI++)
    {
        objOutsFlop[arrOutsNames[intI]] = 0;
        objOutsTurn[arrOutsNames[intI]] = 0;
        objOutsTurn[arrOutsNames[intI]] = 0;
    }

    // =========================================================
    // AFTER FLOP CHECK
    // =========================================================

    let arrCurrCards = arrCards.slice(0, 5);

    const arrFlopCards = arrCards.slice(0, 5);
    const arrFlopRanks = [];
    const arrFlopSuits = [];
    const objFlopRankCount = {};
    const objFlopSuitCount = {};

    for (let intI = 0; intI < arrFlopCards.length; intI++)
    {
        const strCard = arrFlopCards[intI];
        const strRank = strCard[0];
        const strSuit = strCard[1];

        arrFlopRanks.push(strRank);
        arrFlopSuits.push(strSuit);

        if (objFlopRankCount[strRank] == undefined)
        {
            objFlopRankCount[strRank] = 1;
        }
        else
        {
            objFlopRankCount[strRank]++;
        }

        if (objFlopSuitCount[strSuit] == undefined)
        {
            objFlopSuitCount[strSuit] = 1;
        }
        else
        {
            objFlopSuitCount[strSuit]++;
        }
    }

    const arrHoleRanks = [arrCards[0][0], arrCards[1][0]];
    const arrHoleSuits = [arrCards[0][1], arrCards[1][1]];

    // One Pair to Set
    for (let intI = 0; intI < 2; intI++)
    {
        const strRank = arrHoleRanks[intI];
        if (objFlopRankCount[strRank] == 1)
        {
            objOutsFlop["One Pair to Set"] += 2;
        }
        else if (objFlopRankCount[strRank] == 2)
        {
            objOutsFlop["One Pair to Set"] += 1;
        }
    }

    // One Overcard to Pair
    let intOvercards = 0;
    for (let intI = 0; intI < 2; intI++)
    {
        let strRank = arrHoleRanks[intI];
        let intHigher = 0;
        for (let intJ = 2; intJ <= 4; intJ++)
        {
            if (arrRanks.indexOf(strRank) <= arrRanks.indexOf(arrCards[intJ][0]))
            {
                intHigher = 1;
            }
        }
        if (intHigher == 0)
        {
            intOvercards++;
        }
    }
    if (intOvercards == 1)
    {
        objOutsFlop["One Overcard to Pair"] = 3;
    }
    else if (intOvercards == 2)
    {
        objOutsFlop["One Overcard to Pair"] = 6;
        objOutsFlop["Two Overcards to Over Pair"] = 6;
    }

    // No Pair to Pair
    let intPairs = 0;
    for (let intI = 0; intI < 2; intI++)
    {
        const strRank = arrHoleRanks[intI];
        if (objFlopRankCount[strRank] >= 1)
        {
            intPairs++;
        }
    }
    if (intPairs == 0)
    {
        objOutsFlop["No Pair to Pair"] = 6;
    }

    // One Pair to Two Pair
    if (intPairs == 1)
    {
        let intUnmatched = 0;
        for (let intI = 0; intI < 2; intI++)
        {
            if (objFlopRankCount[arrHoleRanks[intI]] == undefined)
            {
                intUnmatched++;
            }
        }
        if (intUnmatched == 1)
        {
            objOutsFlop["One Pair to Two Pair"] = 3;
        }
    }


/*
    // Inside Straight Draw
    const arrAllRanksFlop = arrFlopRanks.slice();
    if (arrAllRanksFlop.indexOf(arrHoleRanks[0]) == -1)
    {
        arrAllRanksFlop.push(arrHoleRanks[0]);
    }
    if (arrAllRanksFlop.indexOf(arrHoleRanks[1]) == -1)
    {
        arrAllRanksFlop.push(arrHoleRanks[1]);
    }

    let arrSorted = arrAllRanksFlop.slice().sort(function(a, b)
    {
        return arrRanks.indexOf(a) - arrRanks.indexOf(b);
    });

    for (let intI = 0; intI < arrRanks.length - 3; intI++)
    {
        let intHit = 0;
        let intGap = 0;
        for (let intJ = 0; intJ < 4; intJ++)
        {
            if (arrSorted.indexOf(arrRanks[intI + intJ]) != -1)
            {
                intHit++;
            }
            else
            {
                intGap++;
            }
        }
        if (intHit == 3 && intGap == 1)
        {
            objOutsFlop["Inside Straight Draw"] = 4;
        }
        if (intHit == 4 && intGap == 0)
        {
            objOutsFlop["Open-Ended Straight Draw"] = 8;
        }
    }
*/

// ==== Inside Straight Draw Detection ====
let numOutsInsideStraight = 0;
let arrInsideMissingRanks = [];

let objRankToValue = {
  '2': 2, '3': 3, '4': 4, '5': 5,
  '6': 6, '7': 7, '8': 8, '9': 9,
  'T': 10, 'J': 11, 'Q': 12, 'K': 13, 'A': 14
};


let arrValueToRank = {};
for (let key in objRankToValue)
{
  arrValueToRank[objRankToValue[key]] = key;
}

let arrSeenRanks = [];
for (let i = 0; i < arrCurrCards.length; i++)
{
  let strRank = arrCurrCards[i][0];
  if (arrSeenRanks.indexOf(strRank) === -1)
  {
    arrSeenRanks.push(strRank);
  }
}

let arrSeenValues = arrSeenRanks.map(function(rank) {
  return objRankToValue[rank];
});

for (let start = 2; start <= 10; start++) // 10 is the highest starting point for a 5-card straight
{
  let countInSequence = 0;
  let missing = [];

  for (let offset = 0; offset < 5; offset++)
  {
    let value = start + offset;
    if (arrSeenValues.indexOf(value) >= 0)
    {
      countInSequence++;
    }
    else
    {
      missing.push(value);
    }
  }

  // Exactly 1 card missing in the sequence, and it's not at the ends (gutshot)
  if (countInSequence === 4 && missing.length === 1)
  {
    let missVal = missing[0];

    // Not missing from ends → gutshot only if missing is not first or last
    if (missVal !== start && missVal !== (start + 4))
    {
      let strMissingRank = arrValueToRank[missVal];
      if (arrInsideMissingRanks.indexOf(strMissingRank) === -1)
      {
        arrInsideMissingRanks.push(strMissingRank);
      }
    }
  }
}

numOutsInsideStraight = arrInsideMissingRanks.length * 4;
objOuts["Inside Straight Draw"] = numOutsInsideStraight;


    // Flush Draw
    for (let intI = 0; intI < arrSuits.length; intI++)
    {
        const strSuit = arrSuits[intI];
        let intCount = 0;
        for (let intJ = 0; intJ < 5; intJ++)
        {
            if (arrFlopCards[intJ][1] == strSuit)
            {
                intCount++;
            }
        }
        if (arrHoleSuits[0] == strSuit)
        {
            intCount++;
        }
        if (arrHoleSuits[1] == strSuit)
        {
            intCount++;
        }
        if (intCount == 4)
        {
            objOutsFlop["Flush Draw"] = 9;
        }
    }

    // Inside Straight Draw & Flush
    if (objOutsFlop["Inside Straight Draw"] == 4 && objOutsFlop["Flush Draw"] == 9)
    {
        objOutsFlop["Inside Straight Draw & Flush"] = 12;
    }

    // Open Straight Draw & Flush Draw
    if (objOutsFlop["Open-Ended Straight Draw"] == 8 && objOutsFlop["Flush Draw"] == 9)
    {
        objOutsFlop["Open Straight Draw & Flush Draw"] = 15;
    }

    // Inside Straight Draw & Two Overcards
    if (objOutsFlop["Inside Straight Draw"] == 4 && objOutsFlop["Two Overcards to Over Pair"] == 6)
    {
        objOutsFlop["Inside Straight Draw & Two Overcards"] = 10;
    }

    // =========================================================
    // AFTER TURN CHECK
    // =========================================================

arrCurrCards = arrCards.slice(0, 6);

    const arrTurnCards = arrCards.slice(0, 6);
    const objTurnRankCount = {};
    const arrTurnRanks = [];

    for (let intI = 0; intI < arrTurnCards.length; intI++)
    {
        const strRank = arrTurnCards[intI][0];
        arrTurnRanks.push(strRank);
        if (objTurnRankCount[strRank] == undefined)
        {
            objTurnRankCount[strRank] = 1;
        }
        else
        {
            objTurnRankCount[strRank]++;
        }
    }

    let strTripsRank = "";
    let intPairCount = 0;

    for (let strKey in objTurnRankCount)
    {
        const intCount = objTurnRankCount[strKey];

        if (intCount == 3)
        {
            strTripsRank = strKey;
        }

        if (intCount == 2)
        {
            intPairCount++;
        }

        if (intCount == 4)
        {
            objOutsTurn["Set to Full Quads"] = 0;
            objOutsTurn["Set to Four of a Kind"] = 0;
        }
    }

    // Set to Full House
    if (strTripsRank != "" && intPairCount >= 1)
    {
        objOutsTurn["Set to Full House"] = 6;
    }

    // Trips to Full House
    if (strTripsRank != "")
    {
        for (let strKey in objTurnRankCount)
        {
            if (strKey != strTripsRank && objTurnRankCount[strKey] == 2)
            {
                objOutsTurn["Trips to Full House"] = 6;
            }
        }
    }

    // Set to Four of a Kind
    if (strTripsRank != "")
    {
        objOutsTurn["Set to Four of a Kind"] = 1;
    }

    // =========================================================
    // OUTPUT
    // =========================================================

    console.log("=== OUTS AFTER FLOP ===");
    for (let intI = 0; intI < arrOutsNames.length; intI++)
    {
        const strName = arrOutsNames[intI];
        const intOuts = objOutsFlop[strName];
        console.log(strName + " - " + intOuts);
    }

    console.log("=== OUTS AFTER TURN ===");
    for (let intI = 0; intI < arrOutsNames.length; intI++)
    {
        const strName = arrOutsNames[intI];
        const intOuts = objOutsTurn[strName];
        console.log(strName + " - " + intOuts);
    }
}

/*--------------------------------------------------------------------------------------------------*/
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
