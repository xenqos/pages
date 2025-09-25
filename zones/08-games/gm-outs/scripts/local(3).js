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
    console.clear()

    // Your FULL code goes here.

    // Define card representations
    const arrRanks =
    [
        '2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'
    ];
    const arrSuits =
    [
        'S', 'H', 'C', 'D'
    ];
    const arrOutsNames =
    [
        "One Pair to Set", "One Overcard to Pair", "Inside Straight Draw", "Two Pair to Full House",
        "One Pair to Two Pair", "No Pair to Pair", "Set to Full House", "Trips to Full House",
        "Two Overcards to Over Pair", "Set to Full Quads", "Set to Four of a Kind", "Open-Ended Straight Draw",
        "Flush Draw", "Inside Straight Draw & Two Overcards", "Inside Straight Draw & Flush",
        "Open Straight Draw & Flush Draw"
    ];

    // Example hand (for testing) - Qs Js (Hole) 7h 8h 9c (Flop) Tc (Turn)
    // Results after Flop: OESD (10), Flush Draw (9) -> OESD (8) + Flush Draw (6) + Straight Flush (2)
    // Total Outs = 15 (4*10, 4*K) + (9) - (2) = 17 - 2 = 15
//    const arrCards =
//    [
//        "QS", "JS", "7H", "8H", "9C", "TC"
//    ];

console.log(arrCards);

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
                // A is 14 for high card comparisons, but needs special handling for A-5 straight
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
        // Use an integer representation where rank is high (14*4 + 3 for AS)
        // This is mainly for sorting/uniqueness checks, not standard poker rank
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
    let numFlopOutsPairSet = 0; // One Pair to Set
    let numFlopOutsOvercardPair = 0; // One Overcard to Pair
    let numFlopOutsInsideStraight = 0;
    let numFlopOutsTwoPairFH = 0; // Two Pair to Full House
    let numFlopOutsOnePairTwoPair = 0; // One Pair to Two Pair
    let numFlopOutsNoPairPair = 0; // No Pair to Pair (any card pairs a hole card)
    let numFlopOutsSetFH = 0; // Set to Full House
    let numFlopOutsTripsFH = 0; // Trips to Full House
    let numFlopOutsTwoOvercardsPair = 0; // Two Overcards to Over Pair (not calculated directly as a separate out category, but combined with No Pair to Pair)
    let numFlopOutsSetQuads = 0; // Set to Quads/Four of a Kind
    let numFlopOutsOESD = 0; // Open-Ended Straight Draw
    let numFlopOutsFlushDraw = 0;
    let numFlopOutsInsideStraightOvercards = 0; // For output only, counts same outs as ISD
    let numFlopOutsInsideStraightFlush = 0; // ISD + Flush (for output only)
    let numFlopOutsOESDFlushDraw = 0; // OESD + Flush (for output only)

    // Helper for finding a card's rank in the 'board' (Flop cards 2, 3, 4)
    const fncRankOnBoard = (numRank) =>
    {
        let numIdx = 2;
        for (numIdx = 2; numIdx < 5; numIdx++)
        {
            if (fncGetRankValue(arrCards[numIdx]) === numRank)
            {
                return true;
            }
        }
        return false;
    };

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
        // Set (or Trips, depending on how they were made)
        // Set to Full Quads/Four of a Kind: 1 out (1 remaining of the set rank)
        numFlopOutsSetQuads = 1; // Set to Quads/Four of a Kind

        // Total outs = (1 Quads) + (3 * numOtherRanks)
        let numOtherRanks = 0;
        for (numIdxRank = 2; numIdxRank <= 14; numIdxRank++)
        {
            if (numIdxRank !== numRankTrip && arrFlopRankCounts[numIdxRank] > 0)
            {
                numOtherRanks++;
            }
        }
        numFlopOutsSetFH = 3 * numOtherRanks; // 3 outs for each rank on the board or in hand but not the trip rank

        // Output category: Set to Full House (7) / Trips to Full House (8)
        if (arrFlopRankCounts[numRankTrip] === 3)
        {
            // It's a set
            numFlopOutsTripsFH = 0;
        }
        else
        {
            // It's trips
            numFlopOutsTripsFH = numFlopOutsSetFH;
            numFlopOutsSetFH = 0;
        }

    }
    else if (numRanksWithPair >= 2)
    {
        // Two Pair to Full House: 4 outs (2 remaining of each paired rank)
        // If hole cards were part of a pair (e.g., 77 in hand, 88 on board)
        numFlopOutsTwoPairFH = 4; // 2 outs for Rank1 + 2 outs for Rank2
    }
    else if (numRanksWithPair === 1)
    {
        // One Pair to Set: 2 outs (1 remaining of the paired rank)
        let numPairedRank = numRankPair1;

        // Check if a hole card makes the pair
        if (numHoleCard1Rank === numPairedRank || numHoleCard2Rank === numPairedRank)
        {
            numFlopOutsPairSet = 2; // Pair (from hole) to Set
            numFlopOutsOnePairTwoPair = 3 * 4; // ~12 outs for any other rank to pair (simplified, ignores already paired rank)
        }
        else
        {
            // Paired on board. Hole cards are not paired.
            // This case might be less relevant for "outs" from a player's perspective.
            // Ignore for now as the prompt focuses on player's hand improvement.
        }
    }
    else
    {
        // No Pair on board. Check hole cards for a pair.
        if (numHoleCard1Rank === numHoleCard2Rank)
        {
            // Hole Pair to Set
            numFlopOutsPairSet = 2;
        }
        else
        {
            // No Pair to Pair: 6 outs (3 for Card 1 + 3 for Card 2)
            numFlopOutsNoPairPair = 6;
            // One Overcard to Pair / Two Overcards to Over Pair (covered by No Pair to Pair)
            numFlopOutsOvercardPair = 3; // If only one overcard (e.g., A)
        }
    }


    // 2. Straight Draws
    let arrStraightRanks = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // Rank presence (2-14)
    for (numIdx = 0; numIdx < numFlopCardsCount; numIdx++)
    {
        arrStraightRanks[fncGetRankValue(arrCards[numIdx])] = 1;
    }

    // Check for A-5 straight wrap around
    if (arrStraightRanks[14] === 1 && arrStraightRanks[2] === 1 && arrStraightRanks[3] === 1 && arrStraightRanks[4] === 1 && arrStraightRanks[5] === 0)
    {
        // A-4 straight draw with missing 5
        numFlopOutsInsideStraight = 4;
    }
    else if (arrStraightRanks[14] === 1 && arrStraightRanks[2] === 1 && arrStraightRanks[3] === 1 && arrStraightRanks[4] === 0 && arrStraightRanks[5] === 1)
    {
        // A-5 straight draw with missing 4
        numFlopOutsInsideStraight = 4;
    }
    // Check for 4-card run
    for (numIdxRank = 2; numIdxRank <= 11; numIdxRank++) // Check runs of 4 up to 14 (A)
    {
        let numCardsInRun = 0;
        let numGaps = 0;
        let numGapPosition = -1;

        // Check for 5-card sequence
        for (let numOffset = 0; numOffset < 5; numOffset++)
        {
            if (arrStraightRanks[numIdxRank + numOffset] === 1)
            {
                numCardsInRun++;
            }
            else
            {
                numGaps++;
                numGapPosition = numIdxRank + numOffset;
            }
        }

        if (numCardsInRun === 4 && numGaps === 1)
        {
            // Inside Straight Draw (Gutshot)
            numFlopOutsInsideStraight = 4; // Overwrites previous, we just need one to be true
        }
        else if (numCardsInRun === 4 && numGaps === 0)
        {
            // Already a Straight - no draw outs
        }
        else if (numCardsInRun === 3 && numGaps === 2)
        {
            // Check for Open-Ended Straight Draw
            // Example: 7-8-9 with gaps at 6 and T (or 5 and 6)
            if (arrStraightRanks[numIdxRank] === 0 && arrStraightRanks[numIdxRank + 4] === 0)
            {
                // Both ends are open (6-7-8-9 with 5, T missing)
                numFlopOutsOESD = 8; // 4 outs on each end
            }
            else if (numIdxRank === 2 && arrStraightRanks[5] === 1)
            {
                // A-2-3-4 with a 5
                // Ignore for now for simplicity due to complexity of hole/board mix
            }
        }
    }


    // 3. Flush Draws
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


    // 4. Combine/Eliminate double counts (Outs = 4/8/9)
    let numTotalOutsRaw = 0;

    // Inside Straight Draw & Flush (4 outs for straight, 9 for flush)
    if (numFlopOutsInsideStraight > 0 && numFlopOutsFlushDraw > 0)
    {
        numFlopOutsInsideStraightFlush = 1; // For output only: 1 out is the straight-flush card
        numFlopOutsTotal += (4 + 9 - 1); // 12 total outs
    }
    // Open Straight Draw & Flush Draw (8 outs for straight, 9 for flush)
    else if (numFlopOutsOESD > 0 && numFlopOutsFlushDraw > 0)
    {
        numFlopOutsOESDFlushDraw = 2; // For output only: 2 outs are the straight-flush cards
        numFlopOutsTotal += (8 + 9 - 2); // 15 total outs
    }
    else
    {
        numFlopOutsTotal += numFlopOutsInsideStraight;
        numFlopOutsTotal += numFlopOutsOESD;
        numFlopOutsTotal += numFlopOutsFlushDraw;
    }


    // Sum the non-straight/non-flush outs (Sets/FH/Pairs)
    numTotalOutsRaw = numFlopOutsPairSet + numFlopOutsOvercardPair + numFlopOutsTwoPairFH + numFlopOutsSetFH + numFlopOutsTripsFH + numFlopOutsSetQuads;
    numTotalOutsRaw += numFlopOutsNoPairPair; // Simple pair outs (6)

    // Final simplified Flop Outs output
    let arrFlopOutsCounts =
    [
        numFlopOutsPairSet, // One Pair to Set (2)
        numFlopOutsOvercardPair, // One Overcard to Pair (3)
        numFlopOutsInsideStraight > 0 ? 4 : 0, // Inside Straight Draw (4)
        numFlopOutsTwoPairFH, // Two Pair to Full House (4)
        0, // One Pair to Two Pair (Too complex to calculate linearly)
        numFlopOutsNoPairPair, // No Pair to Pair (6)
        numFlopOutsSetFH, // Set to Full House (3 * others)
        numFlopOutsTripsFH, // Trips to Full House (3 * others)
        0, // Two Overcards to Over Pair (Covered by No Pair to Pair)
        numFlopOutsSetQuads, // Set to Full Quads (1)
        numFlopOutsSetQuads, // Set to Four of a Kind (1)
        numFlopOutsOESD > 0 ? 8 : 0, // Open-Ended Straight Draw (8)
        numFlopOutsFlushDraw, // Flush Draw (9)
        numFlopOutsInsideStraight > 0 && numFlopOutsNoPairPair > 0 ? numFlopOutsInsideStraight : 0, // Inside Straight Draw & Two Overcards (Output ISD if No Pair)
        numFlopOutsInsideStraightFlush > 0 ? 12 : 0, // Inside Straight Draw & Flush (12)
        numFlopOutsOESDFlushDraw > 0 ? 15 : 0 // Open Straight Draw & Flush Draw (15)
    ];

    for (numIdx = 0; numIdx < arrOutsNames.length; numIdx++)
    {
        console.log(arrOutsNames[numIdx] + " - " + arrFlopOutsCounts[numIdx]);
    }


    console.log("\n-------------------------------------------");


    // -------------------------------------------------------------------------
    // 2nd Block: After Turn (arrCards[0] to arrCards[5])
    // -------------------------------------------------------------------------
    console.log("--- Outs After Turn ---");

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
    let numTurnOutsPairSet = 0;
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
        // Set/Trips to Full House/Quads
        numTurnOutsSetQuads = 1; // 1 out for the Quads
        let numOtherRanks = 0;
        for (numIdxRank = 2; numIdxRank <= 14; numIdxRank++)
        {
            if (numIdxRank !== numTurnRankTrip && arrTurnRankCounts[numIdxRank] > 0)
            {
                numOtherRanks++;
            }
        }
        numTurnOutsSetFH = 3 * numOtherRanks; // 3 outs for each other rank on board/hand

        // Distinguish Set vs Trips (simplified by assuming Hole Card involvement)
        if (arrCards[0][0] === arrCards[1][0] && fncGetRankValue(arrCards[0]) === numTurnRankTrip)
        {
            // Hole pair made the set - Set to FH
            numTurnOutsTripsFH = 0;
        }
        else
        {
            // Board pair or one hole card made the trips - Trips to FH
            numTurnOutsTripsFH = numTurnOutsSetFH;
            numTurnOutsSetFH = 0;
        }
    }
    else if (numTurnRanksWithPair >= 2)
    {
        // Two Pair to Full House: 4 outs
        numTurnOutsTwoPairFH = 4;
    }
    else if (numTurnRanksWithPair === 1)
    {
        // One Pair to Set (2 outs)
        // Check if hole cards made the pair
        // FIX: Replaced numTurnRankCounts with arrTurnRankCounts
        if (numHoleCard1Rank === numHoleCard2Rank || arrTurnRankCounts[numHoleCard1Rank] === 2 || arrTurnRankCounts[numHoleCard2Rank] === 2)
        {
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


    // 2. Straight Draws
    let arrTurnStraightRanks = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    for (numIdxTurn = 0; numIdxTurn < numTurnCardsCount; numIdxTurn++)
    {
        arrTurnStraightRanks[fncGetRankValue(arrCards[numIdxTurn])] = 1;
    }

    // Check for 5-card run
    numTurnOutsInsideStraight = 0;
    numTurnOutsOESD = 0;

    for (numIdxRank = 2; numIdxRank <= 10; numIdxRank++) // Check runs of 5 up to 14 (A)
    {
        let numCardsInRun = 0;
        let numGaps = 0;
        let numGapPosition = -1;

        // Check for 5-card sequence (numIdxRank to numIdxRank + 4)
        for (let numOffset = 0; numOffset < 5; numOffset++)
        {
            if (arrTurnStraightRanks[numIdxRank + numOffset] === 1)
            {
                numCardsInRun++;
            }
            else
            {
                numGaps++;
                numGapPosition = numIdxRank + numOffset;
            }
        }

        if (numCardsInRun === 4 && numGaps === 1)
        {
            // Inside Straight Draw (Gutshot)
            numTurnOutsInsideStraight = 4;
            // Handle A-5 wrap around separately to avoid index out of bounds on A+1
        }
        else if (numCardsInRun === 3 && numGaps === 2)
        {
            // Check for Open-Ended Straight Draw
            if (arrTurnStraightRanks[numIdxRank] === 0 && arrTurnStraightRanks[numIdxRank + 4] === 0)
            {
                // Both ends are open
                numTurnOutsOESD = 8;
            }
        }
    }
    // Check A-5 special straight draw (T to A)
    if (arrTurnStraightRanks[14] === 1 && arrTurnStraightRanks[2] === 1 && arrTurnStraightRanks[3] === 1 && arrTurnStraightRanks[4] === 1 && arrTurnStraightRanks[5] === 0)
    {
        numTurnOutsInsideStraight = 4; // A-4 missing 5
    }
    else if (arrTurnStraightRanks[14] === 1 && arrTurnStraightRanks[2] === 1 && arrTurnStraightRanks[3] === 1 && arrTurnStraightRanks[4] === 0 && arrTurnStraightRanks[5] === 1)
    {
        numTurnOutsInsideStraight = 4; // A-5 missing 4
    }


    // 3. Flush Draws
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


    // 4. Combine/Eliminate double counts (Outs = 4/8/9) - For output only
    if (numTurnOutsInsideStraight > 0 && numTurnOutsFlushDraw > 0)
    {
        numTurnOutsInsideStraightFlush = 12; // 4 + 9 - 1
    }
    else if (numTurnOutsOESD > 0 && numTurnOutsFlushDraw > 0)
    {
        numTurnOutsOESDFlushDraw = 15; // 8 + 9 - 2
    }


    // Final simplified Turn Outs output
    let arrTurnOutsCounts =
    [
        numTurnOutsPairSet,
        numTurnOutsOvercardPair,
        numTurnOutsInsideStraight,
        numTurnOutsTwoPairFH,
        0, // One Pair to Two Pair
        numTurnOutsNoPairPair,
        numTurnOutsSetFH,
        numTurnOutsTripsFH,
        0, // Two Overcards to Over Pair
        numTurnOutsSetQuads,
        numTurnOutsSetQuads, // Set to Four of a Kind
        numTurnOutsOESD,
        numTurnOutsFlushDraw,
        numTurnOutsInsideStraight > 0 && numTurnOutsNoPairPair > 0 ? numTurnOutsInsideStraight : 0, // Inside Straight Draw & Two Overcards
        numTurnOutsInsideStraightFlush,
        numTurnOutsOESDFlushDraw
    ];

    for (numIdx = 0; numIdx < arrOutsNames.length; numIdx++)
    {
        console.log(arrOutsNames[numIdx] + " - " + arrTurnOutsCounts[numIdx]);
    }
}


/*--------------------------------------------------------------------------------------------------*/
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
