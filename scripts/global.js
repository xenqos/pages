/*-----------------------------------------------------------------------------------------------*/
/* Global Variables                                                                              */
/*-----------------------------------------------------------------------------------------------*/

var strUrl = document.URL;
var numTimeLastTap = 0;
var numTimeRewind = 10;
var prevScrollPos = window.pageYOffset;

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

window.onscroll = () =>
{
  var currentScrollPos = window.pageYOffset;

  if (prevScrollPos > currentScrollPos)
  {
    document.getElementById('idTopbar').style.top = '0';
  }
  else
  {
    document.getElementById('idTopbar').style.top = '-6.000rem';
  }

  prevScrollPos = currentScrollPos;
};

/*-----------------------------------------------------------------------------------------------*/
/* Set & Get Scroll Position                                                                     */
/*-----------------------------------------------------------------------------------------------*/

window.onbeforeunload = () =>
{
  localStorage.setItem(strUrl + '===SP', window.pageYOffset);
};

/*-----------------------------------------------------------------------------------------------*/
/* Collapse & Expand                                                                             */
/*-----------------------------------------------------------------------------------------------*/

function fncShowHide(strIdDiv)
{
  var objElement = document.getElementById(strIdDiv);
  objElement.style.display = (objElement.style.display === 'block') ? 'none' : 'block';
}

function fncShowHideWithMemory(strIdDiv)
{
  var objElement = document.getElementById(strIdDiv);
  var strDisplayState = (objElement.style.display === 'block') ? 'none' : 'block';

  objElement.style.display = strDisplayState;
  localStorage.setItem(strUrl + '===' + strIdDiv, strDisplayState);
}

/*-----------------------------------------------------------------------------------------------*/
/* Get ScrollPosition from Local Storage                                                         */
/*-----------------------------------------------------------------------------------------------*/

function fncGetScrollPosition()
{
  var strScrollPosition = localStorage.getItem(strUrl + '===SP');
  if (strScrollPosition)
  {
    window.scrollTo(0, strScrollPosition);
  }
}

/*-----------------------------------------------------------------------------------------------*/
/* Get Div State from Local Storage                                                              */
/*-----------------------------------------------------------------------------------------------*/

function fncGetDivState()
{
  var arrMatches = document.querySelectorAll('div[id^="idDiv"]');
  var numCounter;
  var strIdDiv;
  var objElement;
  var strDisplayState;

  for (numCounter = 0; numCounter < arrMatches.length; numCounter++)
  {
    strIdDiv = arrMatches[numCounter].getAttribute('id');
    objElement = document.getElementById(strIdDiv);
    strDisplayState = localStorage.getItem(strUrl + '===' + strIdDiv);

    if (strDisplayState === null)
    {
      strDisplayState = 'none';
    }
    objElement.style.display = strDisplayState;
  }
}

/*-----------------------------------------------------------------------------------------------*/
/* Audio                                                                                         */
/*-----------------------------------------------------------------------------------------------*/

function fncPlayLink(strLink)
{
  var objAudio = new Audio(strLink);
  objAudio.play().catch(function(objError) { });
}

/*-----------------------------------------------------------------------------------------------*/

function fncRewindTrack(strTrack, event)
{
  if (event)
  {
    event.preventDefault();
  }

  var numTimeNow = new Date().getTime();

  if (numTimeNow - numTimeLastTap < 250)
  {
    return;
  }

  numTimeLastTap = numTimeNow;

  var objTrack = document.getElementById(strTrack);
  var numTimeTarget = Math.max(0, objTrack.currentTime - numTimeRewind);

  objTrack.currentTime = numTimeTarget;
  objTrack.play().catch(function(objError) { });
}

/*-----------------------------------------------------------------------------------------------*/

function fncPlayTrack(strTrack, event)
{
  if (event)
  {
    event.preventDefault();
  }

  var numTimeNow = new Date().getTime();

  if (numTimeNow - numTimeLastTap < 250)
  {
    return;
  }

  numTimeLastTap = numTimeNow;

  var objTrack = document.getElementById(strTrack);

  if (objTrack.paused)
  {
    if (objTrack.currentTime < 1)
    {
      objTrack.currentTime = 0;

      objTrack.onseeked = function()
      {
        objTrack.play().catch(function(objError) { });
        objTrack.onseeked = null;
      };
    }
    else
    {
      objTrack.play().catch(function(objError) { });
    }
  }
  else
  {
    objTrack.pause();
  }
}

/*-----------------------------------------------------------------------------------------------*/
