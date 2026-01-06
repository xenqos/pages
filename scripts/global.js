/*-----------------------------------------------------------------------------------------------*/

// "use strict";

/*-----------------------------------------------------------------------------------------------*/

var blnPlaying = false;
var strURL = document.URL;
var numSecondsSeek = 10;

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

window.onscroll = function()
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
}

/*-----------------------------------------------------------------------------------------------*/
/* Set & Get Scroll Position                                                                     */
/*-----------------------------------------------------------------------------------------------*/

/* onunload Deprecated */
/* window.onunload = function() */

window.onbeforeunload = function()
{
  var strUrl = document.URL;
  localStorage.setItem(strUrl + '===SP', window.pageYOffset);
}

/*
window.onload = function()
{
  var strUrl = document.URL;
  var strScrollPosition = localStorage.getItem( strUrl + '===SP');
  window.scrollTo(0, strScrollPosition);
//  console.log(strScrollPosition);
}
*/

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
/* Audio, Play, Rewind                                                                           */
/*-----------------------------------------------------------------------------------------------*/

function fncPlayLink(strLink)
{
  var objAudio = new Audio(strLink);
  objAudio.play();
}

function fncPlayTrack(strTrack)
{
  var objTrack = document.getElementById(strTrack);
  var numCurrentTime = Number(localStorage.getItem(strURL + '===CT'));
  numCurrentTime = isNaN(numCurrentTime) ? 0 : Math.max(0, numCurrentTime);

  console.log(numCurrentTime);

  if (blnPlaying === false)
  {
    blnPlaying = true;
    objTrack.currentTime = numCurrentTime;
    objTrack.play();
  }
  else
  {
    blnPlaying = false;
    objTrack.pause();
    localStorage.setItem(strURL + '===CT', objTrack.currentTime);
  }
}

function fncBwrdTrack(strTrack)
{
  var objTrack = document.getElementById(strTrack);
  var numCurrentTime = localStorage.getItem(strURL + '===CT');

}

function fncFwrdTrack(strTrack)
{
  var objTrack = document.getElementById(strTrack);
  var numCurrentTime = Number(localStorage.getItem(strURL + '===CT'));
  numCurrentTime = isNaN(numCurrentTime) ? 0 : Math.max(0, numCurrentTime);

  console.log(numCurrentTime);

  if (blnPlaying === false)
  {
    blnPlaying = true;
    objTrack.currentTime = numCurrentTime + numSecondsSeek;
    objTrack.play();
  }
  else
  {
    blnPlaying = false;
    objTrack.pause();
    localStorage.setItem(strURL + '===CT', objTrack.currentTime);
  }
}

function fncRewindTrack(strTrack)
{
  var objTrack = document.getElementById(strTrack);

  localStorage.setItem(strURL + '===CT', '0');
  blnPlaying = false;

  objTrack.pause();
}

/*-----------------------------------------------------------------------------------------------*/
