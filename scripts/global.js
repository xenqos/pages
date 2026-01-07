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

function fncRewindTrack(strTrack)
{
  var objTrack = document.getElementById(strTrack);
  objTrack.currentTime = 0;
  objTrack.play();
}

function XfncRewindTrack(strTrack)
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

// function fncPlayTrack(strTrack)
// {
//   var objTrack = document.getElementById(strTrack);
//
//   if (objTrack.paused)
//   {
//     var savedTime = Number(localStorage.getItem(strURL + '===CT'));
//
//     // Only set currentTime if there is a significant difference.
//     // Frequent micro-adjustments to currentTime can 'choke' the Android decoder.
//     if (savedTime > 0 && Math.abs(objTrack.currentTime - savedTime) > 0.5)
//     {
//       objTrack.currentTime = savedTime;
//     }
//
//     // Fire play immediately to secure the User Gesture token.
//     var playPromise = objTrack.play();
//
//     if (playPromise !== undefined)
//     {
//       playPromise.catch(function(error)
//       {
//         // If Android blocks it, we log it but the app won't crash.
//         console.log("Playback prevented: " + error);
//       });
//     }
//   }
//   else
//   {
//     // Pause first so the user hears the audio stop instantly.
//     objTrack.pause();
//
//     // Then perform the "heavy" write to disk.
//     localStorage.setItem(strURL + '===CT', objTrack.currentTime);
//   }
// }

function fncPlayTrackXX(strTrack)
{
  var objTrack = document.getElementById(strTrack);

  if (objTrack.paused)
  {
    objTrack.play();
  }
  else
  {
    objTrack.pause();
  }
}

function fncPlayTrackXXX(strTrack)
{
  var objTrack = document.getElementById(strTrack);

  if (objTrack.paused)
  {
    // On Android Firefox, play() returns a Promise.
    // We must catch potential rejections (like 'User Guesture' loss).
    var playPromise = objTrack.play();

    if (playPromise !== undefined)
    {
      playPromise.catch(function(error)
      {
        // This prevents the 'Sporadic' hang by allowing
        // the user to try tapping again immediately.
        console.log("Playback interrupted: " + error);
      });
    }
  }
  else
  {
    objTrack.pause();
  }
}


function fncPlayTrack(strTrack, event)
{
  // Prevent the 'ghost click' from firing later
  if (event)
  {
    event.preventDefault();
  }

  var objTrack = document.getElementById(strTrack);

  if (objTrack.paused)
  {
    objTrack.play().catch(function() {});
  }
  else
  {
    objTrack.pause();
  }
}

/*-----------------------------------------------------------------------------------------------*/
