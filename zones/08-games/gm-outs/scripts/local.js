/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const arrSuits = ['S', 'H', 'C', 'D'];
const arrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
let arrCards = [];
let booTurn = false;
let objConsoleLog = null;
let objOutsDiv = null;

/*--------------------------------------------------------------------------------------------------*/

function fncDealCards()
{
  arrCards.length = 0;
  objConsoleLog = document.getElementById('idConsoleLog');
  objOutsDiv = document.getElementById('idOutsDiv');
  objConsoleLog.innerHTML = '';
  objOutsDiv.innerHTML = '';

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
//    sleep(100);
    booTurn = false;
    fncDealCards();
  }
}

/*--------------------------------------------------------------------------------------------------*/

function fncCountOuts()
{
    console.clear()

//    const arrCards = [ "9D", "JD", "6H", "6S", "6C", "7D" ];

    console.log("Hand Tested: ", arrCards)
//    objConsoleLog.innerHTML += ">>> Hand Tested: " + arrCards + `\n\n`;

    // Define card representations
//    const arrRanks =
//    [
//        '2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'
//    ];
//    const arrSuits =
//    [
//        'S', 'H', 'C', 'D'
//    ];
    const arrOutsNames =
    [
        "One Pair to Set", "One Pair to Trips", "One Overcard to Pair", "Inside Straight Draw", "Two Pair to Full House",
        "One Pair to Two Pair", "No Pair to Pair", "Set to Full House", "Trips to Full House",
        "Two Overcards to Over Pair", "Set to Full Quads", "Set to Four of a Kind", "Open-Ended Straight Draw",
        "Flush Draw", "Inside Straight Draw & Two Overcards", "Inside Straight Draw & Flush",
        "Open Straight Draw & Flush Draw"
    ];

    // Card numerical value mapping function (not a separate function call)
    let numCardValue = 0;
    const fncCardValue = (strCard) =>
    {
        let numRank = -1;
        let numSuit = -1;
        let numIdx = 0;

        for (numIdx = 0; numIdx < arrRanks.length; numIdx++)
        {
            if (arrRanks[numIdx] === strCard[0])
            {
                numRank = numIdx + 2; // 2..14
                break;
            }
        }

        for (numIdx = 0; numIdx < arrSuits.length; numIdx++)
        {
            if (arrSuits[numIdx] === strCard[1])
            {
                numSuit = numIdx;
                break;
            }
        }
        return (numRank * 4) + numSuit;
    };

    // Helper to get only the rank value (2-14)
    const fncGetRankValue = (strCard) =>
    {
        let numRank = -1;
        let numIdx = 0;
        for (numIdx = 0; numIdx < arrRanks.length; numIdx++)
        {
            if (arrRanks[numIdx] === strCard[0])
            {
                numRank = numIdx + 2;
                break;
            }
        }
        return numRank;
    };

    // Helper to get only the suit (0-3)
    const fncGetSuitValue = (strCard) =>
    {
        let numSuit = -1;
        let numIdx = 0;
        for (numIdx = 0; numIdx < arrSuits.length; numIdx++)
        {
            if (arrSuits[numIdx] === strCard[1])
            {
                numSuit = numIdx;
                break;
            }
        }
        return numSuit;
    };

    // -------------------------------------------------------------------------
    // 1st Block: After Flop (arrCards[0] to arrCards[4])
    // -------------------------------------------------------------------------
    console.log("--- Outs After Flop ---");
//    objConsoleLog.innerHTML += '>>> Outs After Flop' + `\n\n`;
    objOutsDiv.innerHTML += '<h2>Flop</h2>';

    // Variables for the Flop stage
    let numFlopCardsCount = 5;
    let arrFlopRankCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // Index 2 to 14
    let arrFlopSuitCounts = [0, 0, 0, 0]; // S, H, C, D
    let arrFlopAllCardValues = [];
    let numIdx = 0;

    // Populate counts and values for Flop
    for (numIdx = 0; numIdx < numFlopCardsCount; numIdx++)
    {
        let numRank = fncGetRankValue(arrCards[numIdx]);
        let numSuit = fncGetSuitValue(arrCards[numIdx]);
        arrFlopRankCounts[numRank]++;
        arrFlopSuitCounts[numSuit]++;
        arrFlopAllCardValues.push(fncCardValue(arrCards[numIdx]));
    }

    let numHoleCard1Rank = fncGetRankValue(arrCards[0]);
    let numHoleCard2Rank = fncGetRankValue(arrCards[1]);
    let numHoleCard1Suit = fncGetSuitValue(arrCards[0]);
    let numHoleCard2Suit = fncGetSuitValue(arrCards[1]);

    // Counters for Flop Outs
    let numFlopOutsTotal = 0;
    let numFlopOutsPairSet = 0; // One Pair to Set (Hole Pocket Pair to Set)
    let numFlopOutsOnePairToTrips = 0; // NEW: One Pair (Hole-Board) to Trips
    let numFlopOutsOvercardPair = 0; // One Overcard to Pair
    let numFlopOutsInsideStraight = 0;
    let numFlopOutsTwoPairFH = 0; // Two Pair to Full House
    let numFlopOutsOnePairTwoPair = 0; // One Pair to Two Pair
    let numFlopOutsNoPairPair = 0; // No Pair to Pair (any card pairs a hole card)
    let numFlopOutsSetFH = 0; // Set to Full House
    let numFlopOutsTripsFH = 0; // Trips to Full House
    let numFlopOutsTwoOvercardsPair = 0;
    let numFlopOutsSetQuads = 0; // Set to Quads/Four of a Kind
    let numFlopOutsOESD = 0; // Open-Ended Straight Draw
    let numFlopOutsFlushDraw = 0;
    let numFlopOutsInsideStraightOvercards = 0;
    let numFlopOutsInsideStraightFlush = 0;
    let numFlopOutsOESDFlushDraw = 0;


    // --- Flop Logic ---

    // 1. Full House/Quads Draws (Set/Trips/Two Pair)
    let numRanksWithPair = 0;
    let numRanksWithThree = 0;
    let numRankPair1 = -1;
    let numRankPair2 = -1;
    let numRankTrip = -1;
    let numIdxRank = 0;

    for (numIdxRank = 2; numIdxRank <= 14; numIdxRank++)
    {
        if (arrFlopRankCounts[numIdxRank] === 2)
        {
            numRanksWithPair++;
            if (numRankPair1 === -1)
            {
                numRankPair1 = numIdxRank;
            }
            else
            {
                numRankPair2 = numIdxRank;
            }
        }
        else if (arrFlopRankCounts[numIdxRank] === 3)
        {
            numRanksWithThree++;
            numRankTrip = numIdxRank;
        }
        else if (arrFlopRankCounts[numIdxRank] === 4)
        {
            // Already Quads, no more outs for Quads/FH from this rank
        }
    }

    if (numRanksWithThree === 1)
    {
        // Set/Trips to FH/Quads logic remains the same
        numFlopOutsSetQuads = 1;
        let numOtherRanks = 0;
        for (numIdxRank = 2; numIdxRank <= 14; numIdxRank++)
        {
            if (numIdxRank !== numRankTrip && arrFlopRankCounts[numIdxRank] > 0)
            {
                numOtherRanks++;
            }
        }
        numFlopOutsSetFH = 3 * numOtherRanks;

        if (arrFlopRankCounts[numRankTrip] === 3)
        {
            numFlopOutsTripsFH = 0;
        }
        else
        {
            numFlopOutsTripsFH = numFlopOutsSetFH;
            numFlopOutsSetFH = 0;
        }
    }
    else if (numRanksWithPair >= 2)
    {
        // Two Pair to Full House
        numFlopOutsTwoPairFH = 4;
    }
    else if (numRanksWithPair === 1)
    {
        let numPairedRank = numRankPair1;

        // Check if a hole card makes the pair (One Hole Card + One Board Card)
        if ((numHoleCard1Rank === numPairedRank && arrFlopRankCounts[numHoleCard1Rank] === 2) ||
            (numHoleCard2Rank === numPairedRank && arrFlopRankCounts[numHoleCard2Rank] === 2))
        {
            // NEW LOGIC: Assign to One Pair to Trips (2 outs)
            numFlopOutsOnePairToTrips = 2;
            numFlopOutsOnePairTwoPair = 3 * 4; // Max 12 outs for any other rank to pair
        }
        else
        {
            // Paired on board. Hole cards are not paired.
        }
    }
    else // No ranks with pair or three on board
    {
        // Check hole cards for a pair.
        if (numHoleCard1Rank === numHoleCard2Rank)
        {
            // Hole Pair to Set
            numFlopOutsPairSet = 2;
        }
        else
        {
            // No Pair to Pair: 6 outs (3 for Card 1 + 3 for Card 2)
            numFlopOutsNoPairPair = 6;
            numFlopOutsOvercardPair = 3; // If only one overcard (e.g., A)
        }
    }


    // 2. Straight Draws (Logic remains the same)
    let arrStraightRanks = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    for (numIdx = 0; numIdx < numFlopCardsCount; numIdx++)
    {
        arrStraightRanks[fncGetRankValue(arrCards[numIdx])] = 1;
    }

    if (arrStraightRanks[14] === 1 && arrStraightRanks[2] === 1 && arrStraightRanks[3] === 1 && arrStraightRanks[4] === 1 && arrStraightRanks[5] === 0)
    {
        numFlopOutsInsideStraight = 4;
    }
    else if (arrStraightRanks[14] === 1 && arrStraightRanks[2] === 1 && arrStraightRanks[3] === 1 && arrStraightRanks[4] === 0 && arrStraightRanks[5] === 1)
    {
        numFlopOutsInsideStraight = 4;
    }
    for (numIdxRank = 2; numIdxRank <= 11; numIdxRank++)
    {
        let numCardsInRun = 0;
        let numGaps = 0;
        for (let numOffset = 0; numOffset < 5; numOffset++)
        {
            if (arrStraightRanks[numIdxRank + numOffset] === 1)
            {
                numCardsInRun++;
            }
            else
            {
                numGaps++;
            }
        }
        if (numCardsInRun === 4 && numGaps === 1)
        {
            numFlopOutsInsideStraight = 4;
        }
        else if (numCardsInRun === 3 && numGaps === 2)
        {
            if (arrStraightRanks[numIdxRank] === 0 && arrStraightRanks[numIdxRank + 4] === 0)
            {
                numFlopOutsOESD = 8;
            }
        }
    }


    // 3. Flush Draws (Logic remains the same)
    let numBestSuitCount = 0;
    for (numIdx = 0; numIdx < 4; numIdx++)
    {
        if (arrFlopSuitCounts[numIdx] >= numBestSuitCount)
        {
            numBestSuitCount = arrFlopSuitCounts[numIdx];
        }
    }
    if (numBestSuitCount === 4)
    {
        numFlopOutsFlushDraw = 9;
    }
    else
    {
        numFlopOutsFlushDraw = 0;
    }


    // 4. Combine/Eliminate double counts & Total Outs Calculation

    // Straight/Flush combinations first
    if (numFlopOutsInsideStraight > 0 && numFlopOutsFlushDraw > 0)
    {
        numFlopOutsInsideStraightFlush = 12; // 4 + 9 - 1
        numFlopOutsTotal = 12; // Start total with this value
    }
    else if (numFlopOutsOESD > 0 && numFlopOutsFlushDraw > 0)
    {
        numFlopOutsOESDFlushDraw = 15; // 8 + 9 - 2
        numFlopOutsTotal = 15; // Start total with this value
    }
    else
    {
        numFlopOutsTotal = numFlopOutsInsideStraight + numFlopOutsOESD + numFlopOutsFlushDraw;
    }

    // Add all non-drawing outs
    numFlopOutsTotal += numFlopOutsPairSet;
    numFlopOutsTotal += numFlopOutsOnePairToTrips;
    numFlopOutsTotal += numFlopOutsOvercardPair;
    numFlopOutsTotal += numFlopOutsTwoPairFH;
    numFlopOutsTotal += numFlopOutsSetFH;
    numFlopOutsTotal += numFlopOutsTripsFH;
    numFlopOutsTotal += numFlopOutsSetQuads;
    numFlopOutsTotal += numFlopOutsNoPairPair;


    // Final simplified Flop Outs output array alignment
    let arrFlopOutsCounts =
    [
        numFlopOutsPairSet, // One Pair to Set (0)
        numFlopOutsOnePairToTrips, // One Pair to Trips (1)
        numFlopOutsOvercardPair, // One Overcard to Pair (2)
        numFlopOutsInsideStraight > 0 ? 4 : 0, // Inside Straight Draw (3)
        numFlopOutsTwoPairFH, // Two Pair to Full House (4)
        0, // One Pair to Two Pair (5)
        numFlopOutsNoPairPair, // No Pair to Pair (6)
        numFlopOutsSetFH, // Set to Full House (7)
        numFlopOutsTripsFH, // Trips to Full House (8)
        0, // Two Overcards to Over Pair (9)
        numFlopOutsSetQuads, // Set to Full Quads (10)
        numFlopOutsSetQuads, // Set to Four of a Kind (11)
        numFlopOutsOESD > 0 ? 8 : 0, // Open-Ended Straight Draw (12)
        numFlopOutsFlushDraw, // Flush Draw (13)
        numFlopOutsInsideStraight > 0 && numFlopOutsNoPairPair > 0 ? numFlopOutsInsideStraight : 0, // Inside Straight Draw & Two Overcards (14)
        numFlopOutsInsideStraightFlush, // Inside Straight Draw & Flush (15)
        numFlopOutsOESDFlushDraw // Open Straight Draw & Flush Draw (16)
    ];

    for (numIdx = 0; numIdx < arrOutsNames.length; numIdx++)
    {
        // Custom logic to display 0 for raw draws if combined draws exist
        if (arrOutsNames[numIdx] === "Inside Straight Draw & Flush")
        {
            console.log(arrOutsNames[numIdx] + " - " + numFlopOutsInsideStraightFlush);
            if (numFlopOutsInsideStraightFlush != 0)
            {
//              objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - " + numFlopOutsInsideStraightFlush + `\n`;
              objOutsDiv.innerHTML += `<div>${arrOutsNames[numIdx]} - numFlopOutsInsideStraightFlush</div>`;
            }
        }
        else if (arrOutsNames[numIdx] === "Open Straight Draw & Flush Draw")
        {
            console.log(arrOutsNames[numIdx] + " - " + numFlopOutsOESDFlushDraw);
            if (numFlopOutsOESDFlushDraw != 0)
            {
//              objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - " + numFlopOutsOESDFlushDraw + `\n`;
              objOutsDiv.innerHTML += `<div>${arrOutsNames[numIdx]} - numFlopOutsOESDFlushDraw</div>`;
            }
        }
        else if (numFlopOutsInsideStraightFlush > 0 && (arrOutsNames[numIdx] === "Inside Straight Draw" || arrOutsNames[numIdx] === "Flush Draw"))
        {
            console.log(arrOutsNames[numIdx] + " - 0");
//            objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - 0" + `\n`;
        }
        else if (numFlopOutsOESDFlushDraw > 0 && (arrOutsNames[numIdx] === "Open-Ended Straight Draw" || arrOutsNames[numIdx] === "Flush Draw"))
        {
            console.log(arrOutsNames[numIdx] + " - 0");
//            objConsoleLog.innerHTML += + arrOutsNames[numIdx] + " - 0" `\n`;
        }
        else
        {
            // Output the calculated or combined outs
            console.log(arrOutsNames[numIdx] + " - " + arrFlopOutsCounts[numIdx]);
            if (arrFlopOutsCounts[numIdx] != 0)
            {
//              objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - " + arrFlopOutsCounts[numIdx] + `\n`;
              objOutsDiv.innerHTML += `<div>${arrOutsNames[numIdx]} - ${arrFlopOutsCounts[numIdx]}</div>`;
            }
        }
    }

    console.log("Total Outs after Flop - " + numFlopOutsTotal);
//    objConsoleLog.innerHTML += `\n` + ">>> Total Outs after Flop - " + numFlopOutsTotal + `\n\n`;
    objOutsDiv.innerHTML += `<h4>Total Outs after Flop - ${numFlopOutsTotal}</h4>`;

    console.log("\n-------------------------------------------");

    // -------------------------------------------------------------------------
    // 2nd Block: After Turn (arrCards[0] to arrCards[5])
    // -------------------------------------------------------------------------
    console.log("--- Outs After Turn ---");
//    objConsoleLog.innerHTML += `\n` + ">>> Outs After Turn" + `\n\n`;
    objOutsDiv.innerHTML += '<h2>Turn</h2>';


    // Variables for the Turn stage
    let numTurnCardsCount = 6;
    let arrTurnRankCounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    let arrTurnSuitCounts = [0, 0, 0, 0];
    let numIdxTurn = 0;

    // Populate counts and values for Turn
    for (numIdxTurn = 0; numIdxTurn < numTurnCardsCount; numIdxTurn++)
    {
        let numRank = fncGetRankValue(arrCards[numIdxTurn]);
        let numSuit = fncGetSuitValue(arrCards[numIdxTurn]);
        arrTurnRankCounts[numRank]++;
        arrTurnSuitCounts[numSuit]++;
    }

    // Counters for Turn Outs (simplified logic, focusing on major draws)
    let numTurnOutsTotal = 0;
    let numTurnOutsPairSet = 0;
    let numTurnOutsOnePairToTrips = 0;
    let numTurnOutsOvercardPair = 0;
    let numTurnOutsInsideStraight = 0;
    let numTurnOutsTwoPairFH = 0;
    let numTurnOutsOnePairTwoPair = 0;
    let numTurnOutsNoPairPair = 0;
    let numTurnOutsSetFH = 0;
    let numTurnOutsTripsFH = 0;
    let numTurnOutsSetQuads = 0;
    let numTurnOutsOESD = 0;
    let numTurnOutsFlushDraw = 0;
    let numTurnOutsInsideStraightFlush = 0;
    let numTurnOutsOESDFlushDraw = 0;

    // --- Turn Logic (Recalculate hand strength and draws) ---

    // 1. Full House/Quads Draws (Set/Trips/Two Pair)
    let numTurnRanksWithPair = 0;
    let numTurnRanksWithThree = 0;
    let numTurnRankTrip = -1;

    for (numIdxRank = 2; numIdxRank <= 14; numIdxRank++)
    {
        if (arrTurnRankCounts[numIdxRank] === 2)
        {
            numTurnRanksWithPair++;
        }
        else if (arrTurnRankCounts[numIdxRank] === 3)
        {
            numTurnRanksWithThree++;
            numTurnRankTrip = numIdxRank;
        }
        else if (arrTurnRankCounts[numIdxRank] === 4)
        {
            // Already Quads - no outs
        }
    }

    if (numTurnRanksWithThree === 1)
    {
        // Set/Trips to FH/Quads logic:

        let numOtherRanks = 0;
        for (numIdxRank = 2; numIdxRank <= 14; numIdxRank++)
        {
            if (numIdxRank !== numTurnRankTrip && arrTurnRankCounts[numIdxRank] > 0)
            {
                numOtherRanks++;
            }
        }
        numTurnOutsSetFH = 3 * numOtherRanks;

        let isHoleCardInTrips = (numHoleCard1Rank === numTurnRankTrip) || (numHoleCard2Rank === numTurnRankTrip);
        let isPocketPairInTrips = (numHoleCard1Rank === numHoleCard2Rank) && (numHoleCard1Rank === numTurnRankTrip);

        if (isPocketPairInTrips) // You have a Pocket Pair that made Trips (Set)
        {
            // This is a Set to Quads draw (1 out) and Set to FH draw (3*numOtherRanks)
            numTurnOutsSetQuads = 1;
            numTurnOutsTripsFH = 0;
        }
        else if (isHoleCardInTrips) // You have one Hole Card that made Trips (Trips)
        {
            // This is a Trips to Quads draw (1 out) and Trips to FH draw (3*numOtherRanks)
            numTurnOutsSetQuads = 1;
            numTurnOutsSetFH = 0;
        }
        else // Trips/Set is entirely on the Board (Your Case: 6H 6S 6C 7D)
        {
            // If the set is on the board, the 4th card (e.g., 6D) makes quads on the board.
            // Since your hole cards (9D JD) don't include the rank 6, hitting the 4th 6 does NOT improve your hand.
            // Therefore, Quads out is 0. FH outs are also 0 as they don't use your hole cards.
            numTurnOutsSetQuads = 0;
            numTurnOutsSetFH = 0;
            numTurnOutsTripsFH = 0;
        }
    }
    else if (numTurnRanksWithPair >= 2)
    {
        // Two Pair to Full House
        numTurnOutsTwoPairFH = 4;
    }
    else if (numTurnRanksWithPair === 1)
    {
        // Check if one hole card + one board card makes the pair
        if (numHoleCard1Rank !== numHoleCard2Rank &&
            ((arrTurnRankCounts[numHoleCard1Rank] === 2) || (arrTurnRankCounts[numHoleCard2Rank] === 2)))
        {
            // NEW LOGIC: Assign to One Pair to Trips (2 outs)
            numTurnOutsOnePairToTrips = 2;
        }
        // Check hole cards for a pocket pair
        else if (numHoleCard1Rank === numHoleCard2Rank)
        {
            // Hole Pair to Set
            numTurnOutsPairSet = 2;
        }

        // One Pair to Two Pair (simplified, less relevant after Turn)
    }
    else
    {
        // No Pair on board. Check hole cards for a pair.
        if (numHoleCard1Rank === numHoleCard2Rank)
        {
            numTurnOutsPairSet = 2; // Hole Pair to Set
        }
        else
        {
            // No Pair to Pair: 6 outs
            numTurnOutsNoPairPair = 6;
            numTurnOutsOvercardPair = 3;
        }
    }

    // --- SECONDARY FULL HOUSE/QUADS CHECK (To include your Nines/Jacks outs) ---
    // If the board has trips (e.g., 666) and your hand is unpaired (9J), your outs are the remaining 9s and Js.
    if (numTurnRanksWithThree === 1 && numTurnRankTrip !== numHoleCard1Rank && numTurnRankTrip !== numHoleCard2Rank)
    {
        // The board has trips (e.g., 666) and neither hole card is that rank.
        let outsToFH = 0;

        // Count outs to pair hole card 1 (e.g., 9D)
        if (arrTurnRankCounts[numHoleCard1Rank] === 1)
        {
            outsToFH += 2; // Remaining 9s
        }

        // Count outs to pair hole card 2 (e.g., JD)
        if (arrTurnRankCounts[numHoleCard2Rank] === 1)
        {
            outsToFH += 2; // Remaining Js
        }

        // Use the 'No Pair to Pair' variable to store these outs since it better reflects the draw.
        // For this specific case (9D JD on 6H 6S 6C 7D), your only outs are the 4 cards for FH (9s/Js).
        if (outsToFH > 0) {
            numTurnOutsNoPairPair = outsToFH;
        } else {
            // Ensure simple No Pair to Pair isn't counted if a set is on the board
            numTurnOutsNoPairPair = 0;
        }
    }

    // 2. Straight Draws (Logic remains the same)
    let arrTurnStraightRanks = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    for (numIdxTurn = 0; numIdxTurn < numTurnCardsCount; numIdxTurn++)
    {
        arrTurnStraightRanks[fncGetRankValue(arrCards[numIdxTurn])] = 1;
    }

    numTurnOutsInsideStraight = 0;
    numTurnOutsOESD = 0;

    for (numIdxRank = 2; numIdxRank <= 10; numIdxRank++)
    {
        let numCardsInRun = 0;
        let numGaps = 0;
        for (let numOffset = 0; numOffset < 5; numOffset++)
        {
            if (arrTurnStraightRanks[numIdxRank + numOffset] === 1)
            {
                numCardsInRun++;
            }
            else
            {
                numGaps++;
            }
        }

        if (numCardsInRun === 4 && numGaps === 1)
        {
            numTurnOutsInsideStraight = 4;
        }
        else if (numCardsInRun === 3 && numGaps === 2)
        {
            if (arrTurnStraightRanks[numIdxRank] === 0 && arrTurnStraightRanks[numIdxRank + 4] === 0)
            {
                numTurnOutsOESD = 8;
            }
        }
    }
    if (arrTurnStraightRanks[14] === 1 && arrTurnStraightRanks[2] === 1 && arrTurnStraightRanks[3] === 1 && arrTurnStraightRanks[4] === 1 && arrTurnStraightRanks[5] === 0)
    {
        numTurnOutsInsideStraight = 4;
    }
    else if (arrTurnStraightRanks[14] === 1 && arrTurnStraightRanks[2] === 1 && arrTurnStraightRanks[3] === 1 && arrTurnStraightRanks[4] === 0 && arrTurnStraightRanks[5] === 1)
    {
        numTurnOutsInsideStraight = 4;
    }


    // 3. Flush Draws (Logic remains the same)
    let numTurnBestSuitCount = 0;
    for (numIdx = 0; numIdx < 4; numIdx++)
    {
        if (arrTurnSuitCounts[numIdx] >= numTurnBestSuitCount)
        {
            numTurnBestSuitCount = arrTurnSuitCounts[numIdx];
        }
    }
    if (numTurnBestSuitCount === 4)
    {
        numTurnOutsFlushDraw = 9;
    }
    else
    {
        numTurnOutsFlushDraw = 0;
    }

    // 4. Combine/Eliminate double counts & Total Outs Calculation

    // Straight/Flush combinations first
    if (numTurnOutsInsideStraight > 0 && numTurnOutsFlushDraw > 0)
    {
        numTurnOutsInsideStraightFlush = 12; // 4 + 9 - 1
        numTurnOutsTotal = 12;
    }
    else if (numTurnOutsOESD > 0 && numTurnOutsFlushDraw > 0)
    {
        numTurnOutsOESDFlushDraw = 15; // 8 + 9 - 2
        numTurnOutsTotal = 15;
    }
    else
    {
        numTurnOutsTotal = numTurnOutsInsideStraight + numTurnOutsOESD + numTurnOutsFlushDraw;
    }

    // Add all non-drawing outs
    numTurnOutsTotal += numTurnOutsPairSet;
    numTurnOutsTotal += numTurnOutsOnePairToTrips;
    numTurnOutsTotal += numTurnOutsOvercardPair;
    numTurnOutsTotal += numTurnOutsTwoPairFH;
    numTurnOutsTotal += numTurnOutsSetFH;
    numTurnOutsTotal += numTurnOutsTripsFH;
    numTurnOutsTotal += numTurnOutsSetQuads;
    numTurnOutsTotal += numTurnOutsNoPairPair;

    // Final simplified Turn Outs output array alignment
    let arrTurnOutsCounts =
    [
        numTurnOutsPairSet, // One Pair to Set (0)
        numTurnOutsOnePairToTrips, // One Pair to Trips (1)
        numTurnOutsOvercardPair, // One Overcard to Pair (2)
        numTurnOutsInsideStraight, // Inside Straight Draw (3)
        numTurnOutsTwoPairFH, // Two Pair to Full House (4)
        0, // One Pair to Two Pair (5)
        numTurnOutsNoPairPair, // No Pair to Pair (6)
        numTurnOutsSetFH, // Set to Full House (7)
        numTurnOutsTripsFH, // Trips to Full House (8)
        0, // Two Overcards to Over Pair (9)
        numTurnOutsSetQuads, // Set to Full Quads (10)
        numTurnOutsSetQuads, // Set to Four of a Kind (11)
        numTurnOutsOESD, // Open-Ended Straight Draw (12)
        numTurnOutsFlushDraw, // Flush Draw (13)
        numTurnOutsInsideStraight > 0 && numTurnOutsNoPairPair > 0 ? numTurnOutsInsideStraight : 0, // Inside Straight Draw & Two Overcards (14)
        numTurnOutsInsideStraightFlush, // Inside Straight Draw & Flush (15)
        numTurnOutsOESDFlushDraw // Open Straight Draw & Flush Draw (16)
    ];

    for (numIdx = 0; numIdx < arrOutsNames.length; numIdx++)
    {
        // Custom logic to display 0 for raw draws if combined draws exist
        if (arrOutsNames[numIdx] === "Inside Straight Draw & Flush")
        {
            console.log(arrOutsNames[numIdx] + " - " + numTurnOutsInsideStraightFlush);
            if (numTurnOutsInsideStraightFlush != 0)
            {
//             objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - " + numTurnOutsInsideStraightFlush + `\n`;
              objOutsDiv.innerHTML += `<div>${arrOutsNames[numIdx]} - ${numTurnOutsInsideStraightFlush}</div>`;
            }
        }
        else if (arrOutsNames[numIdx] === "Open Straight Draw & Flush Draw")
        {
            console.log(arrOutsNames[numIdx] + " - " + numTurnOutsOESDFlushDraw);
            if (numTurnOutsOESDFlushDraw != 0)
            {
//              objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - " + numTurnOutsOESDFlushDraw + `\n`;
              objOutsDiv.innerHTML += `<div>${arrOutsNames[numIdx]} - ${numTurnOutsOESDFlushDraw}</div>`;
            }
        }
        else if (numTurnOutsInsideStraightFlush > 0 && (arrOutsNames[numIdx] === "Inside Straight Draw" || arrOutsNames[numIdx] === "Flush Draw"))
        {
            console.log(arrOutsNames[numIdx] + " - 0");
//            objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - 0" + `\n`;
        }
        else if (numTurnOutsOESDFlushDraw > 0 && (arrOutsNames[numIdx] === "Open-Ended Straight Draw" || arrOutsNames[numIdx] === "Flush Draw"))
        {
            console.log(arrOutsNames[numIdx] + " - 0");
//            objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - 0" + `\n`;
        }
        else
        {
            console.log(arrOutsNames[numIdx] + " - " + arrTurnOutsCounts[numIdx]);
            if (arrTurnOutsCounts[numIdx] != 0)
            {
//              objConsoleLog.innerHTML += arrOutsNames[numIdx] + " - " + arrTurnOutsCounts[numIdx] + `\n`;
              objOutsDiv.innerHTML += `<div>${arrOutsNames[numIdx]} - ${arrTurnOutsCounts[numIdx]}</div>`;
            }
        }
    }

    console.log("Total Outs after Turn - " + numTurnOutsTotal);
//    objConsoleLog.innerHTML += `\n` + ">>> Total Outs after Turn - " + numTurnOutsTotal + `\n\n`;
    objOutsDiv.innerHTML += `<h4>Total Outs after Turn - ${numTurnOutsTotal}</h4>`;
}

/*--------------------------------------------------------------------------------------------------*/
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
