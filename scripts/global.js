/*-----------------------------------------------------------------------------------------------*/

var blnPlaying = false;
var strURL = document.URL;

/*-----------------------------------------------------------------------------------------------*/
/* Reload Page                                                                                   */
/*-----------------------------------------------------------------------------------------------*/

function fncReloadPage()
{
  window.location.reload();
}

/*-----------------------------------------------------------------------------------------------*/
/* Hide Topbar                                                                                   */
/*-----------------------------------------------------------------------------------------------*/

var prevScrollPos = window.pageYOffset;

// window.onscroll = function()
// {
//   var currentScrollPos = window.pageYOffset;
//
//   if (prevScrollPos > currentScrollPos)
//   {
//     document.getElementById('idTopbar').style.top = '0';
//   }
//   else
//   {
//     document.getElementById('idTopbar').style.top = '-6.000rem';
//   }
//   prevScrollPos = currentScrollPos;
// }

window.onscroll = () =>
{
  var currentScrollPos = window.pageYOffset;

  if (prevScrollPos > currentScrollPos) {
    document.getElementById('idTopbar').style.top = '0';
  } else {
    document.getElementById('idTopbar').style.top = '-6.000rem';
  }

  prevScrollPos = currentScrollPos;
};

/*-----------------------------------------------------------------------------------------------*/
/* Set & Get Scroll Position                                                                     */
/*-----------------------------------------------------------------------------------------------*/

// window.onbeforeunload = function()
// {
//   var strUrl = document.URL;
//   localStorage.setItem(strUrl + '===SP', window.pageYOffset);
// }

window.onbeforeunload = () =>
{
  var strUrl = document.URL;
  localStorage.setItem(strUrl + '===SP', window.pageYOffset);
};

/*-----------------------------------------------------------------------------------------------*/
/* Collapse & Expand                                                                             */
/*-----------------------------------------------------------------------------------------------*/

function fncShowHide(strIdDiv)
{
  var e = document.getElementById(strIdDiv);
  e.style.display = (e.style.display === 'block') ? 'none' : 'block';
}

function fncShowHideWithMemory(strIdDiv)
{
  var strUrl = document.URL;
  var e = document.getElementById(strIdDiv);
  var strDisplayState = (e.style.display === 'block') ? 'none' : 'block';
  e.style.display = strDisplayState;
  localStorage.setItem(strUrl + '===' + strIdDiv, strDisplayState);
}

/*-----------------------------------------------------------------------------------------------*/
/* Get ScrollPosition from Local Storage                                                         */
/*-----------------------------------------------------------------------------------------------*/

function fncGetScrollPosition()
{
  var strUrl = document.URL;
  var strScrollPosition = localStorage.getItem( strUrl + '===SP');
  window.scrollTo(0, strScrollPosition);
//  console.log(strScrollPosition);
}

/*-----------------------------------------------------------------------------------------------*/
/* Get Div State from Local Storage                                                              */
/*-----------------------------------------------------------------------------------------------*/

function fncGetDivState()
{
  var strUrl = document.URL;
  var arrMatches = document.querySelectorAll('div[id^="idDiv"]');
  var numCounter;
  var strIdDiv;
  var objElement;
  var strDisplayState;

  for (numCounter = 0; numCounter < arrMatches.length; numCounter++)
  {
    strIdDiv = arrMatches[numCounter].getAttribute('id');
    objElement = document.getElementById(strIdDiv);
    strDisplayState = localStorage.getItem( strUrl + '===' + strIdDiv);

    if (strDisplayState === null)
    {
      strDisplayState = 'none';
    }
    objElement.style.display = strDisplayState;
//    console.log(strDisplayState);
  }
}

/*-----------------------------------------------------------------------------------------------*/
/* Audio                                                                        */
/*-----------------------------------------------------------------------------------------------*/

function fncPlayLink(strLink)
{
  var objAudio = new Audio(strLink);
  objAudio.play();
}

/*-----------------------------------------------------------------------------------------------*/

// // function fncRewindTrack(strTrack)
// // {
// //   var objTrack = document.getElementById(strTrack);
// //   objTrack.currentTime = 0;
// //   localStorage.setItem(strURL + '===CT', objTrack.currentTime);
// //   blnPlaying = false;
// //   objTrack.pause();
// // }

function fncRewindTrack(strTrack)
{
  var numSecondsSeek = 2;
  var objTrack = document.getElementById(strTrack);
  var numCurrentTime = Number(localStorage.getItem(strURL + '===CT'));

  objTrack.currentTime = Math.max(0, numCurrentTime - numSecondsSeek);

  localStorage.setItem(strURL + '===CT', objTrack.currentTime);

  if (objTrack.paused)
  {
    objTrack.play().catch(() => {})
  }
}


/*-----------------------------------------------------------------------------------------------*/


// function fncRewindTrack(strTrack)
// {
//   var objTrack = document.getElementById(strTrack);
//   var numCurrentTime = Number(localStorage.getItem(strURL + '===CT'));
//   //  numCurrentTime = Number.isFinite(numCurrentTime) ? Math.max(0, numCurrentTime) : 0;
//
//   objTrack.currentTime = Math.max(0, numCurrentTime - numSecondsSeek);
//   localStorage.setItem(strURL + '===CT', objTrack.currentTime);
//
//   console.log(objTrack.currentTime);
//
//   // Android-friendly approach
//   var wasPlaying = !objTrack.paused;
//
//   if (wasPlaying) {
//     objTrack.pause();
//     // Give Android time to process
//     setTimeout(() => {
//       objTrack.currentTime = numCurrentTime - 4;
//       setTimeout(() => objTrack.play(), 50);
//     }, 50);
//   } else {
//     // Just set the time
//     objTrack.currentTime = numCurrentTime - 4;
//   }
// }


//function fncPlayTrack(strTrack)
//{
//  var objTrack = document.getElementById(strTrack);
//  var numCurrentTime = Number(localStorage.getItem(strURL + '===CT'));
//  //  numCurrentTime = Number.isFinite(numCurrentTime) ? Math.max(0, numCurrentTime) : 0;
//
//  console.log(objTrack.currentTime);
//
//  if (blnPlaying === false)
//  {
//    blnPlaying = true;
//    objTrack.play();
//  }
//  else if (blnPlaying === true)
//  {
//    blnPlaying = false;
//    localStorage.setItem(strURL + '===CT', objTrack.currentTime);
//    objTrack.pause();
//  }
//}

// function fncPlayTrack(strTrack)
// {
//   var objTrack = document.getElementById(strTrack);
//   var numCurrentTime = Number(localStorage.getItem(strURL + '===CT'));
//
//   console.log(objTrack.currentTime);
//
//   if (objTrack.paused)
//   {
//     blnPlaying = true;
//     setTimeout(() => objTrack.play(), 50);
//   }
//   else
//   {
//     blnPlaying = false;
//     localStorage.setItem(strURL + '===CT', objTrack.currentTime);
//     objTrack.pause();
//   }
// }

function fncPlayTrack(strTrack) {
  var objTrack = document.getElementById(strTrack);

  if (objTrack.paused) {
    // 1. Get the time only when starting
    var savedTime = Number(localStorage.getItem(strURL + '===CT'));
    if (savedTime > 0) {
      objTrack.currentTime = savedTime;
    }

    // 2. Play (returns a promise)
    objTrack.play().catch(() => {});
  }
  else {
    // 3. Save the actual time right before pausing
    localStorage.setItem(strURL + '===CT', objTrack.currentTime);
    objTrack.pause();
  }
}


// function fncPlayTrack(strTrack)
// {
//   var objTrack = document.getElementById(strTrack);
//   var numCurrentTime = Number(localStorage.getItem(strURL + '===CT'));
//   objTrack.currentTime = numCurrentTime;
//
//   console.log(objTrack.currentTime);
//
//   if (objTrack.paused)
//   {
//     setTimeout(() => objTrack.play(), 50);
//   }
//   else
//   {
//     localStorage.setItem(strURL + '===CT', objTrack.currentTime);
//     objTrack.pause();
//   }
// }

/*-----------------------------------------------------------------------------------------------*/
