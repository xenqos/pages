/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

const arrSuits = ['S', 'H', 'C', 'D'];
const arrRanks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
let arrCards = [];
let booTurn = false;
let objConsoleLog = null;
let objOutsDiv = null;
let objOutsTable = null;
let strOutsTable = '';

/*--------------------------------------------------------------------------------------------------*/

async function fncDealCards()
{
  // Clear arrays and reset state
  arrCards.length = 0;
  booTurn = false;

  // Get DOM elements with validation
  objConsoleLog = document.getElementById('idConsoleLog');
  objOutsDiv = document.getElementById('idOutsDiv');
  objOutsTable = document.getElementById('idOutsTable');

  if (!objConsoleLog || !objOutsDiv || !objOutsTable) {
    console.error("Required DOM elements not found");
    return;
  }

  // Clear displays
  objConsoleLog.innerHTML = '';
  objOutsDiv.innerHTML = '';
  objOutsTable.innerHTML = '';
  strOutsTable = '';

  // Generate 6 unique cards
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

  // Test Values Begin (uncomment to test specific hands)
  // arrCards = ['2H', '7C', '8S', '5D', '4C', 'KS']; // Test hand
  // arrCards = ['AH', 'KH', 'QH', 'JH', 'TH', '9H']; // Straight flush test
  // arrCards = ['8S', '8H', '2H', '8D', '6H', '9H']; // Four of a Kind test
  // arrCards = ['6S', '5S', '4C', 'KH', 'TH', '9H'];  // Inside Straight Draw test
  // Test Values End

  // Display cards
  for (let numCounter = 0; numCounter < arrCards.length; numCounter++)
  {
    const objCardElement = document.getElementById('idCard' + numCounter);
    if (objCardElement) {
      if (numCounter < 5)
      {
        objCardElement.src = '../../../images/cards/' + arrCards[numCounter] + '.svg';
      }
      else
      {
        objCardElement.src = '../../../images/cards/back.svg';
      }
    }
  }

  fncCountOuts();
}

/*--------------------------------------------------------------------------------------------------*/

async function fncShowTurn()
{
  const objCard5 = document.getElementById('idCard5');
  if (!objCard5) return;

  if (booTurn === false)
  {
    objCard5.src = '../../../images/cards/' + arrCards[5] + '.svg';
    booTurn = true;
    fncCountOuts(); // Recalculate after showing turn
  }
  else
  {
    booTurn = false;
    fncDealCards();
  }
}

/*--------------------------------------------------------------------------------------------------*/

async function fncCountOuts()
{
  console.clear();
  console.log("Hand Tested: ", arrCards);

  // Validate arrCards
  if (!arrCards || arrCards.length < 5) {
    console.error("Insufficient cards for calculation");
    return;
  }

  // Clear previous output
  objOutsTable = document.getElementById('idOutsTable');
  if (!objOutsTable) return;

  strOutsTable = '<br><table class="clNoBorder"><tbody>';

  // FIXED: Removed duplicate "Four of a Kind" entry since it's the same as "Quads"
  const arrOutsNames = [
    "One Pair to Set", "One Pair to Trips", "One Overcard to Pair", "Inside Straight Draw", "Two Pair to Full House",
    "One Pair to Two Pair", "No Pair to Pair", "Set to Full House", "Trips to Full House",
    "Two Overcards to Over Pair", "Set to Quads", "Open-Ended Straight Draw",
    "Flush Draw", "Inside Straight Draw & Two Overcards", "Inside Straight Draw & Flush",
    "Open Straight Draw & Flush Draw"
  ];

  // Helper functions
  const fncGetRank = (strCard) => '23456789TJQKA'.indexOf(strCard[0]) + 2;
  const fncGetSuit = (strCard) => 'SHCD'.indexOf(strCard[1]);

  // Process both stages: Flop (5 cards) and Turn (6 cards if shown)
  const fncProcessStage = (numCards, strStageName) =>
  {
    const blnIsFlop = (strStageName === "Flop");
    const arrStageCards = arrCards.slice(0, numCards);

    // Rank & suit counts
    const arrRankCount = Array(15).fill(0);  // index 2..14 (A)
    const arrSuitCount = Array(4).fill(0);
    const arrPresentRanks = Array(15).fill(0);

    arrStageCards.forEach(strCard =>
    {
      const numRank = fncGetRank(strCard);
      const numSuit = fncGetSuit(strCard);
      arrRankCount[numRank]++;
      arrSuitCount[numSuit]++;
      arrPresentRanks[numRank] = 1;
    });

    const numHole1Rank = fncGetRank(arrCards[0]);
    const numHole2Rank = fncGetRank(arrCards[1]);
    const numHole1Suit = fncGetSuit(arrCards[0]);
    const numHole2Suit = fncGetSuit(arrCards[1]);
    const blnIsPocketPair = numHole1Rank === numHole2Rank;

    let objOuts = {
      numPairToSet: 0,
      numOnePairToTrips: 0,
      numNoPairToPair: 0,
      numTwoPairToFH: 0,
      numSetToFH: 0,
      numTripsToFH: 0,
      numSetToQuads: 0,
      numOesd: 0,
      numGutshot: 0,
      numFlushDraw: 0,
      numOvercardOuts: 0,
      numTwoOvercardsOuts: 0,
      numOnePairToTwoPair: 0
    };

    // === 1. Analyze board and hand ===
    let numPairs = 0;
    let numTrips = 0;
    let numQuads = 0;
    let numTripRank = -1;
    let numPairedRank = -1;
    let arrPairedRanks = [];

    for (let numR = 2; numR <= 14; numR++)
    {
      const numCount = arrRankCount[numR];
      if (numCount === 2) {
        numPairs++;
        numPairedRank = numR;
        arrPairedRanks.push(numR);
      }
      if (numCount === 3) {
        numTrips++;
        numTripRank = numR;
      }
      if (numCount === 4) numQuads++;
    }

    // Calculate highest board rank for overcard calculations
    let numHighestBoardRank = 0;
    for (let i = 2; i < arrStageCards.length; i++) {
      const numRank = fncGetRank(arrStageCards[i]);
      if (numRank > numHighestBoardRank) numHighestBoardRank = numRank;
    }

    // === 2. Overcard calculations ===
    if (!blnIsPocketPair && numPairs === 0 && numTrips === 0) {
      // Single overcard
      if (numHole1Rank > numHighestBoardRank) objOuts.numOvercardOuts += 3;
      if (numHole2Rank > numHighestBoardRank) objOuts.numOvercardOuts += 3;

      // Two overcards (both hole cards higher than any board card)
      if (numHole1Rank > numHighestBoardRank && numHole2Rank > numHighestBoardRank) {
        objOuts.numTwoOvercardsOuts = 6; // 3 + 3
      }
    }

    // === 3. Made hands & improvement outs ===
    if (numTrips === 1)
    {
      const blnYouHaveSet = blnIsPocketPair && numHole1Rank === numTripRank;
      const blnYouHaveTrips = (numHole1Rank === numTripRank || numHole2Rank === numTripRank);

      if (blnYouHaveSet || blnYouHaveTrips) {
        objOuts.numSetToQuads = 1; // Only 1 card can make quads
      }

      // Full house draws from trips/set
      let numSingletons = 0;
      for (let numR = 2; numR <= 14; numR++)
      {
        if (arrRankCount[numR] === 1) numSingletons++;
      }

      if (blnYouHaveSet) {
        objOuts.numSetToFH = 3 * numSingletons;
      }
      if (blnYouHaveTrips && !blnYouHaveSet) {
        objOuts.numTripsToFH = 3 * numSingletons;
      }
    }
    else if (numPairs >= 2)
    {
      // Two pair on board
      objOuts.numTwoPairToFH = 4; // 4 cards can make full house
    }
    else if (numPairs === 1)
    {
      // One pair on board
      if (numHole1Rank === numPairedRank || numHole2Rank === numPairedRank)
      {
        // You have one card of the paired rank
        objOuts.numOnePairToTrips = 2;
      }

      // One pair to two pair (if you have a different card than the paired rank)
      if (!blnIsPocketPair) {
        if (numHole1Rank !== numPairedRank) objOuts.numOnePairToTwoPair += 3;
        if (numHole2Rank !== numPairedRank) objOuts.numOnePairToTwoPair += 3;
      }
    }

    // === 4. Pocket pair or unpaired hole cards ===
    if (numPairs === 0 && numTrips === 0)
    {
      if (blnIsPocketPair)
      {
        objOuts.numPairToSet = 2; // 2 cards to make set
      }
      else
      {
        // No pair to pair
        let numOuts1 = Math.max(0, 3 - arrRankCount[numHole1Rank]);
        let numOuts2 = Math.max(0, 3 - arrRankCount[numHole2Rank]);
        objOuts.numNoPairToPair = numOuts1 + numOuts2;
      }
    }

    // Special case: board has trips, you have nothing in it
    if (numTrips === 1 && numHole1Rank !== numTripRank && numHole2Rank !== numTripRank)
    {
      let numFhOuts = 0;
      if (arrRankCount[numHole1Rank] === 1) numFhOuts += 2;
      if (arrRankCount[numHole2Rank] === 1) numFhOuts += 2;
      objOuts.numNoPairToPair = numFhOuts;
    }

    // === 5. SIMPLIFIED Straight draws - FIXED VERSION ===
    const fncCheckStraightOuts = () =>
    {
      let numOesd = 0;
      let numGutshot = 0;

      // First check if we already have a straight
      for (let numLow = 2; numLow <= 10; numLow++)
      {
        if (arrPresentRanks[numLow] && arrPresentRanks[numLow+1] &&
            arrPresentRanks[numLow+2] && arrPresentRanks[numLow+3] &&
            arrPresentRanks[numLow+4]) {
          return { numOesd: 0, numGutshot: 0 };
        }
      }

      // Check for wheel straight
      if (arrPresentRanks[14] && arrPresentRanks[2] && arrPresentRanks[3] &&
          arrPresentRanks[4] && arrPresentRanks[5]) {
        return { numOesd: 0, numGutshot: 0 };
      }

      // Collect all possible straight completion cards
      let arrPossibleOesdCards = [];
      let arrPossibleGutshotCards = [];

      // Check each possible straight window
      for (let numLow = 2; numLow <= 10; numLow++)
      {
        const arrWindow = [numLow, numLow+1, numLow+2, numLow+3, numLow+4];
        let numHave = 0;
        let arrMissing = [];

        arrWindow.forEach(numR =>
        {
          if (arrPresentRanks[numR]) numHave++;
          else arrMissing.push(numR);
        });

        if (numHave === 4)
        {
          // We have 4 of 5 cards for a straight
          const numMissing = arrMissing[0];

          // Check if missing card creates an open-ended or gutshot
          if (numMissing === numLow || numMissing === numLow + 4) {
            // Open-ended straight draw
            if (!arrPossibleOesdCards.includes(numMissing)) {
              arrPossibleOesdCards.push(numMissing);
            }
          } else {
            // Gutshot (inside straight draw)
            if (!arrPossibleGutshotCards.includes(numMissing)) {
              arrPossibleGutshotCards.push(numMissing);
            }
          }
        }
      }

      // Check wheel windows separately
      // Check A-2-3-4-X (needs 5)
      if (arrPresentRanks[14] && arrPresentRanks[2] &&
          arrPresentRanks[3] && arrPresentRanks[4]) {
        if (!arrPresentRanks[5]) {
          if (!arrPossibleOesdCards.includes(5)) {
            arrPossibleOesdCards.push(5);
          }
        }
      }

      // Check A-2-3-5-X (needs 4)
      if (arrPresentRanks[14] && arrPresentRanks[2] &&
          arrPresentRanks[3] && arrPresentRanks[5]) {
        if (!arrPresentRanks[4]) {
          if (!arrPossibleGutshotCards.includes(4)) {
            arrPossibleGutshotCards.push(4);
          }
        }
      }

      // Check A-2-4-5-X (needs 3)
      if (arrPresentRanks[14] && arrPresentRanks[2] &&
          arrPresentRanks[4] && arrPresentRanks[5]) {
        if (!arrPresentRanks[3]) {
          if (!arrPossibleGutshotCards.includes(3)) {
            arrPossibleGutshotCards.push(3);
          }
        }
      }

      // Check 2-3-4-5-X (needs A or 6)
      if (arrPresentRanks[2] && arrPresentRanks[3] &&
          arrPresentRanks[4] && arrPresentRanks[5]) {
        if (!arrPresentRanks[14] && !arrPossibleOesdCards.includes(14)) {
          arrPossibleOesdCards.push(14); // Ace
        }
        if (!arrPresentRanks[6] && !arrPossibleOesdCards.includes(6)) {
          arrPossibleOesdCards.push(6);  // Six
        }
      }

      // Count the unique cards
      numOesd = arrPossibleOesdCards.length * 4;
      numGutshot = arrPossibleGutshotCards.length * 4;

      // Cap at maximums
      if (numOesd > 8) numOesd = 8;
      if (numGutshot > 8) numGutshot = 8;

      return { numOesd, numGutshot };
    };

    const objStraight = fncCheckStraightOuts();
    objOuts.numOesd = objStraight.numOesd;
    objOuts.numGutshot = objStraight.numGutshot;

    // === 6. Flush draw ===
    const numMaxSuit = Math.max(...arrSuitCount);
    const numMaxSuitIndex = arrSuitCount.indexOf(numMaxSuit);

    // Check if we have flush draw (4 of same suit)
    if (numMaxSuit === 4) {
      // Check if we have cards in that suit
      let numOurCardsInSuit = 0;
      if (numHole1Suit === numMaxSuitIndex) numOurCardsInSuit++;
      if (numHole2Suit === numMaxSuitIndex) numOurCardsInSuit++;

      if (numOurCardsInSuit >= 1) {
        objOuts.numFlushDraw = 9; // 13 - 4 already seen
      }
    } else if (numMaxSuit === 5) {
      // Already have a flush
      objOuts.numFlushDraw = 0;
    }

    // === 7. Combo draws ===
    let numComboGutshotFlush = 0;
    let numComboOesdFlush = 0;

    // Inside straight + flush
    if (objOuts.numGutshot > 0 && objOuts.numFlushDraw > 0) {
      // Typically 12 outs: 4 for gutshot + 9 for flush - 1 overlap
      numComboGutshotFlush = 12;
    }

    // Open-ended + flush
    if (objOuts.numOesd > 0 && objOuts.numFlushDraw > 0) {
      // Typically 15 outs: 8 for OESD + 9 for flush - 2 overlap
      numComboOesdFlush = 15;
    }

    // === 8. Exclusion filters (dead / tainted outs) ===
    // Applies the 8 criteria for discounting outs that improve the hand
    // but are still likely to lose at showdown against a realistic opponent range.

    // Identify board-only cards (indices 2..numCards-1) and their ranks
    const arrBoardCards = arrStageCards.slice(2);
    const arrBoardRanks = arrBoardCards.map(fncGetRank);

    // Is the board paired / has trips / has quads (from our earlier counters)?
    const blnBoardPaired  = numPairs >= 1;
    const blnBoardTrips   = numTrips >= 1;
    const blnBoardTwoPair = numPairs >= 2;

    // --- Criterion 1 & 2: Pairing a weak hole card into a dominated / easily
    //     counterfeited two pair.
    //     A two-pair out for hole card X is discounted when:
    //       (a) X is ranked 6 or lower  (weak kicker, very likely dominated), OR
    //       (b) X is lower than the highest unpaired board card (dominated kicker), OR
    //       (c) the board already has a pair that can be counterfeited later
    //           (on the flop only — on the turn there is no later street to counterfeit).
    if (objOuts.numOnePairToTwoPair > 0 && !blnIsPocketPair)
    {
      // Highest unpaired board rank (singleton on the board)
      let numHighestUnpairedBoard = 0;
      arrBoardRanks.forEach(numR => {
        if (arrRankCount[numR] === 1 && numR > numHighestUnpairedBoard)
          numHighestUnpairedBoard = numR;
      });

      // Evaluate each hole card's two-pair out individually (3 outs each)
      const fncHoleCardTwoPairExcluded = (numHoleRank) => {
        if (numHoleRank === numPairedRank) return true; // already pairs the board pair — not a two-pair out

        // Criterion 1: rank 6 or lower is a weak kicker
        if (numHoleRank <= 6) return true;

        // Criterion 2a: hole card is lower than highest unpaired board card → dominated kicker
        if (numHighestUnpairedBoard > 0 && numHoleRank < numHighestUnpairedBoard) return true;

        // Criterion 2b: flop only — board is already paired, two pair is
        //               trivially counterfeited by any river board pair
        if (blnIsFlop && blnBoardPaired) return true;

        return false;
      };

      let numFiltered = 0;
      if (fncHoleCardTwoPairExcluded(numHole1Rank)) numFiltered += 3;
      if (fncHoleCardTwoPairExcluded(numHole2Rank)) numFiltered += 3;
      objOuts.numOnePairToTwoPair = Math.max(0, objOuts.numOnePairToTwoPair - numFiltered);
    }

    // --- Criterion 3: Improving into a hand still behind the board texture.
    //     (a) Making a pair when the board already has trips → you still lose to quads/FH.
    //     (b) No-pair-to-pair when board has trips (already handled structurally, but
    //         guard against any residual value when our pair is lower than trip rank).
    if (blnBoardTrips)
    {
      // Any simple pair draw is meaningless against board trips
      objOuts.numNoPairToPair = 0;
      // Overcard outs are also irrelevant — a high pair still loses to trips
      objOuts.numOvercardOuts   = 0;
      objOuts.numTwoOvercardsOuts = 0;
    }

    // --- Criterion 4 & 7 & 8: Straight / flush outs tainted by board pairing.
    //     When the completing card pairs the board (i.e. its rank already appears on
    //     the board), anyone holding that rank now has trips/full house.
    //     We filter straight outs by re-running the straight window check and removing
    //     any completion rank that is already present on the board.
    //     For flush draws, if the board is paired we reduce by 1 tainted out per
    //     board-paired suit card that is in the flush suit (conservative estimate: -1).
    if (objOuts.numGutshot > 0)
    {
      // Re-derive gutshot completion ranks to check for board-pairing taint
      const arrGutshotTainted = [];
      for (let numLow = 2; numLow <= 10; numLow++)
      {
        const arrWindow = [numLow, numLow+1, numLow+2, numLow+3, numLow+4];
        let numHave = 0; let arrMissing = [];
        arrWindow.forEach(numR => { if (arrPresentRanks[numR]) numHave++; else arrMissing.push(numR); });
        if (numHave === 4)
        {
          const numMissing = arrMissing[0];
          const blnIsGutshot = (numMissing !== numLow && numMissing !== numLow + 4);
          if (blnIsGutshot && arrBoardRanks.includes(numMissing))
          {
            if (!arrGutshotTainted.includes(numMissing)) arrGutshotTainted.push(numMissing);
          }
        }
      }
      // Each tainted rank removes 4 outs (all 4 suits of that rank)
      objOuts.numGutshot = Math.max(0, objOuts.numGutshot - arrGutshotTainted.length * 4);
    }

    if (objOuts.numOesd > 0)
    {
      const arrOesdTainted = [];
      for (let numLow = 2; numLow <= 10; numLow++)
      {
        const arrWindow = [numLow, numLow+1, numLow+2, numLow+3, numLow+4];
        let numHave = 0; let arrMissing = [];
        arrWindow.forEach(numR => { if (arrPresentRanks[numR]) numHave++; else arrMissing.push(numR); });
        if (numHave === 4)
        {
          const numMissing = arrMissing[0];
          const blnIsOesd = (numMissing === numLow || numMissing === numLow + 4);
          if (blnIsOesd && arrBoardRanks.includes(numMissing))
          {
            if (!arrOesdTainted.includes(numMissing)) arrOesdTainted.push(numMissing);
          }
        }
      }
      objOuts.numOesd = Math.max(0, objOuts.numOesd - arrOesdTainted.length * 4);
    }

    // Criterion 7: Flush completing into a paired board (someone may have a full house).
    // Conservatively remove 1 out per board-paired rank that shares the flush suit.
    if (objOuts.numFlushDraw > 0 && blnBoardPaired)
    {
      let numTaintedFlushOuts = 0;
      arrBoardCards.forEach(strCard => {
        const numR = fncGetRank(strCard);
        const numS = fncGetSuit(strCard);
        if (arrRankCount[numR] >= 2 && numS === numMaxSuitIndex) numTaintedFlushOuts++;
      });
      objOuts.numFlushDraw = Math.max(0, objOuts.numFlushDraw - numTaintedFlushOuts);
    }

    // --- Criterion 5: Dominated overcard outs.
    //     If a hole card is an Ace or King and the board is unpaired, overcards are
    //     generally valid. But if both hole cards are overcards yet one is ≤ 9
    //     (e.g. Q and 4 both over a 2-3 board), the lower overcard is dominated
    //     against any realistic broadway-holding opponent. Remove 3 outs for any
    //     overcard ranked 9 or lower when the other hole card is already an overcard.
    if (objOuts.numOvercardOuts > 0)
    {
      const blnH1Over = numHole1Rank > numHighestBoardRank;
      const blnH2Over = numHole2Rank > numHighestBoardRank;
      if (blnH1Over && blnH2Over)
      {
        // Both are overcards — discard the weaker one if it is ≤ 9
        if (numHole1Rank <= 9) objOuts.numOvercardOuts = Math.max(0, objOuts.numOvercardOuts - 3);
        if (numHole2Rank <= 9) objOuts.numOvercardOuts = Math.max(0, objOuts.numOvercardOuts - 3);
        // Recompute twoOvercards if one was removed
        if (objOuts.numOvercardOuts < 6) objOuts.numTwoOvercardsOuts = 0;
      }
    }

    // --- Criterion 6: Runner-runner / backdoor draws.
    //     These are never counted as outs in this calculator (they would only appear
    //     as combo entries, which already require an explicit flush or straight draw
    //     to be present — so backdoor-only hands correctly produce 0 outs already).
    //     No additional code needed; this criterion is satisfied by the existing logic.

    // Recompute combo draws after filtering (criteria 4/7/8 may have zeroed the draws)
    if (objOuts.numGutshot === 0 || objOuts.numFlushDraw === 0) numComboGutshotFlush = 0;
    if (objOuts.numOesd    === 0 || objOuts.numFlushDraw === 0) numComboOesdFlush    = 0;

    // === 9. Total outs ===
    let numTotalOuts = 0;

    // Add combo draws first (they replace individual draws)
    if (numComboGutshotFlush > 0) {
      numTotalOuts += numComboGutshotFlush;
    } else if (numComboOesdFlush > 0) {
      numTotalOuts += numComboOesdFlush;
    } else {
      // Add individual draws if no combo
      numTotalOuts += objOuts.numOesd + objOuts.numGutshot + objOuts.numFlushDraw;
    }

    // Add improvement outs
    numTotalOuts += objOuts.numPairToSet + objOuts.numOnePairToTrips + objOuts.numNoPairToPair +
                    objOuts.numTwoPairToFH + objOuts.numSetToFH + objOuts.numTripsToFH +
                    objOuts.numSetToQuads + objOuts.numOvercardOuts + objOuts.numOnePairToTwoPair;

    // === 10. Prepare display array ===
    // FIXED: Removed duplicate entry for "Four of a Kind" (index 11)
    const arrOutDisplay = [
      objOuts.numPairToSet,
      objOuts.numOnePairToTrips,
      objOuts.numOvercardOuts,
      objOuts.numGutshot,
      objOuts.numTwoPairToFH,
      objOuts.numOnePairToTwoPair,
      objOuts.numNoPairToPair,
      objOuts.numSetToFH,
      objOuts.numTripsToFH,
      objOuts.numTwoOvercardsOuts,
      objOuts.numSetToQuads,          // Index 10: Set to Quads
      objOuts.numOesd,                // Index 11: Open-Ended Straight Draw (moved up)
      objOuts.numFlushDraw,           // Index 12: Flush Draw
      (objOuts.numGutshot > 0 && objOuts.numOvercardOuts > 0) ? (objOuts.numGutshot + objOuts.numOvercardOuts) : 0,
      numComboGutshotFlush,
      numComboOesdFlush
    ];

    // === 11. Render table ===
    strOutsTable += `<tr><td colspan=2 class='m'><b>${strStageName}</b></td></tr>`;

    for (let numI = 0; numI < arrOutsNames.length; numI++)
    {
      const strName = arrOutsNames[numI];
      const numVal = arrOutDisplay[numI];

      // Skip if value is 0
      if (numVal === 0) continue;

      // Skip individual draws when combo draw exists (to avoid double counting)
      if (numComboGutshotFlush > 0) {
        if (strName === "Inside Straight Draw" || strName === "Flush Draw") continue;
      }
      if (numComboOesdFlush > 0) {
        if (strName === "Open-Ended Straight Draw" || strName === "Flush Draw") continue;
      }

      console.log(`${strStageName}: ${strName} - ${numVal}`);
      strOutsTable += `<tr><td>${strName}</td><td>${numVal}</td></tr>`;
    }

    console.log(`${strStageName} Total Outs: ${numTotalOuts}`);
    strOutsTable += `<tr><td>Total</td><td class='e'><b>${numTotalOuts}</b><br><br></td></tr>`;

    if (!blnIsFlop) strOutsTable += `<tr><td colspan=2>&nbsp;</td></tr>`;
  };

  // === Run both stages ===
  fncProcessStage(5, "Flop");
  if (arrCards.length >= 6 && booTurn) {
    fncProcessStage(6, "Turn");
  }

  strOutsTable += `</tbody></table>`;
  objOutsTable.innerHTML = strOutsTable;

  // Also update global variable
  window.strOutsTable = strOutsTable;
}

/*--------------------------------------------------------------------------------------------------*/
// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
  fncDealCards();
});
/*--------------------------------------------------------------------------------------------------*/
