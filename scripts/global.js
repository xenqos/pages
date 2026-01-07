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

function fncBackTrack(strTrack)
{
  var objTrack = document.getElementById(strTrack);
//  objTrack.currentTime = 0;
//  objTrack.play();
}

/*-----------------------------------------------------------------------------------------------*/

var lastTapTime = 0;

function fncPlayTrack(strTrack, event)
{
  if (event)
  {
    event.preventDefault();
  }

  // Cooldown logic: prevents 'sporadic' double-firing on sensitive screens
  var currentTime = new Date().getTime();
  var tapDelay = currentTime - lastTapTime;

  if (tapDelay < 200 && tapDelay > 0)
  {
    return;
  }

  lastTapTime = currentTime;

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
