/*--------------------------------------------------------------------------------------------------*/

"use strict";

/*--------------------------------------------------------------------------------------------------*/

var blnPlaying = false;
var strURL = document.URL;

/*--------------------------------------------------------------------------------------------------*/
/* Reload Page                                                                                      */
/*--------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------*/

function fncReloadPage()
{
  window.location.reload();
}

/*--------------------------------------------------------------------------------------------------*/
/* Open Window No Decorations                                                                       */
/*--------------------------------------------------------------------------------------------------*/

function openWindowNoDecor(intWidth, intHeight, strUrl)
{
  let intLeft = (window.screen.width - intWidth)/2;
//let intTop  = (window.screen.height - intHeight)/2;
  let intTop  = 0;

  let strParameters = '';
  strParameters += 'scrollbars='  + '1'                   + ',';
  strParameters += 'resizable='   + '1'                   + ',';
  strParameters += 'status='      + '0'                   + ',';
  strParameters += 'location='    + '0'                   + ',';
  strParameters += 'toolbar='     + '0'                   + ',';
  strParameters += 'titlebar='    + '0'                   + ',';
  strParameters += 'menubar='     + '0'                   + ',';
  strParameters += 'directories=' + '0'                   + ',';
  strParameters += 'width='       + intWidth.toString()   + ',';
  strParameters += 'height='      + intHeight.toString()  + ',';
  strParameters += 'left='        + intLeft.toString()    + ',';
  strParameters += 'top='         + intTop.toString()     + ',';

  // console.log(strParameters);

  window.open(strUrl, '_blank', strParameters);
}

/*--------------------------------------------------------------------------------------------------*/
/* Hide Topbar                                                                                      */
/*--------------------------------------------------------------------------------------------------*/

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
    document.getElementById('idTopbar').style.top = '-06.000rem';
  }
  prevScrollPos = currentScrollPos;
}

/*--------------------------------------------------------------------------------------------------*/
/* Set & Get Scroll Position                                                                                      */
/*--------------------------------------------------------------------------------------------------*/

window.onunload = function()
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

/*--------------------------------------------------------------------------------------------------*/
/* Collapse & Expand                                                                                */
/*--------------------------------------------------------------------------------------------------*/

function fncShowHide(strIdDiv)
{
  var e = document.getElementById(strIdDiv);
  e.style.display = (e.style.display == 'block') ? 'none' : 'block';
}

function fncShowHideWithMemory(strIdDiv)
{
  var strUrl = document.URL;
  var e = document.getElementById(strIdDiv);
  var strDisplayState = (e.style.display == 'block') ? 'none' : 'block';
  e.style.display = strDisplayState;
  localStorage.setItem(strUrl + '===' + strIdDiv, strDisplayState);
}

/*--------------------------------------------------------------------------------------------------*/
/* Get ScrollPosition from Local Storage                                                                     */
/*--------------------------------------------------------------------------------------------------*/

function fncGetScrollPosition()
{
  var strUrl = document.URL;
  var strScrollPosition = localStorage.getItem( strUrl + '===SP');
  window.scrollTo(0, strScrollPosition);
//  console.log(strScrollPosition);
}

/*--------------------------------------------------------------------------------------------------*/
/* Get Div State from Local Storage                                                                     */
/*--------------------------------------------------------------------------------------------------*/

function fncGetDivState()
{
  var strUrl = document.URL;
  var arrMatches = document.querySelectorAll('div[id^="idDiv"]');

  for (var intCounter = 0; intCounter < arrMatches.length; intCounter++)
  {
    var strIdDiv = arrMatches[intCounter].getAttribute('id');
    var e = document.getElementById(strIdDiv);
    var strDisplayState = localStorage.getItem( strUrl + '===' + strIdDiv);
    if (strDisplayState === null)
    {
      strDisplayState = 'none';
    }
    e.style.display = strDisplayState;
//    console.log(strDisplayState);
  }
}

/*--------------------------------------------------------------------------------------------------*/
/* Audio, Play, Rewind                                                                              */
/*--------------------------------------------------------------------------------------------------*/

function fncPlayLink(strLink)
{
  var objAudio = new Audio(strLink);
  objAudio.play();
}

function fncPlayTrack(strTrack)
{
  var objTrack = document.getElementById(strTrack);
  var intCurrentTime = localStorage.getItem(strURL + '===CT');

  if (intCurrentTime == null || intCurrentTime === "" || isNaN(intCurrentTime)) { intCurrentTime = 0; }

  if (blnPlaying == false)
  {
    blnPlaying = true;
    objTrack.currentTime = intCurrentTime;
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

/*----------------------------------------------------------------------------------------------------------*/

function fncPlaySound(strPhoneme)
{
  arrSounds = strPhoneme.split(',');
  setTimeout('fncPlayNextSound(0);', intTimeoutInitial);
}

function fncPlayNextSound(intCounter)
{
  if (typeof arrSounds[intCounter] === "undefined") { return; }

  var objAudio = document.getElementById('idTrack');
  var strSound = strDirectory + arrSounds[intCounter] + '.' + strFormat;

  objAudio.setAttribute('src', strSound);
  objAudio.play();
  intCounter++;
  setTimeout('fncPlayNextSound(' + intCounter + ');', intTimeout);
}

function fncPlayFile(strFileName)
{
  var objAudio = document.getElementById('idTrack');
  var strSound = strDirectory + strPhoneme + '.' + strFormat;

  objAudio.setAttribute('src', strSound);
  objAudio.play();
}

/*--------------------------------------------------------------------------------------------------*/
