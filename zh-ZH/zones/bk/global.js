/*--------------------------------------------------------------------------------------------------*/

"use strict";

/*--------------------------------------------------------------------------------------------------*/

var blnPlaying = false;
var strURL = document.URL;

/*--------------------------------------------------------------------------------------------------*/
/* Change Chrome Topbar Color                                                                       */
/*--------------------------------------------------------------------------------------------------*/

/*
var varElement = document.createElement('meta');
varElement.name = 'theme-color';
varElement.content = '#000000';
document.head.appendChild(varElement);
*/


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

console.log(strParameters);

  window.open(strUrl, '', strParameters);
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
/* Chinese Sounds                                                                                           */
/*----------------------------------------------------------------------------------------------------------*/

var strDirectory = '../sounds/';
var strDirectoryZh = '../apps/ln/zh-resources/sounds/';
var strFormat = 'mp3';

var intTimeout = 1000;
var intTimeoutInitial = 100;

var intCurrentSound = 0;

var arrSounds = new Array();

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

function fncPlaySoundZh(strPhoneme)
{
  var objAudio = document.getElementById('idTrack');
  var strSound = strDirectoryZh + strPhoneme + '.' + strFormat;
  objAudio.setAttribute('src', strSound);
  objAudio.play();
}

// /*--------------------------------------------------------------------------------------------------*/
// /* Play Book                                            */
// /*--------------------------------------------------------------------------------------------------*/
//
// function fncOnLoad()
// {
//   var objTrack = document.getElementById('idTrack');
// }
//
// /*----------------------------------------------------------------------------------------------------------*/
//
// function fncPlayBook()
// {
//   var objTrack;
//   var intCurrentTime;
//   var intSC;
//
//   var intCH = document.getElementById('idCH').value;
//   var intCM = document.getElementById('idCM').value;
//   var intCS = document.getElementById('idCS').value;
//
//   if (intCH.charAt(0) == "0") { intCH = intCH.substr(1, 1); }
//   if (intCM.charAt(0) == "0") { intCM = intCM.substr(1, 1); }
//   if (intCS.charAt(0) == "0") { intCS = intCS.substr(1, 1); }
//
//   var objAudio = document.getElementById('idAudio');
//
//   var strURL = document.URL;
//
//   if (intCH === "" || isNaN(intCH))
//   {
//     document.getElementById('idCH').value = '00';
//     intCH = '00';
//   }
//
//   if (intCM === "" || isNaN(intCM))
//   {
//     document.getElementById('idCM').value = '00';
//     intCM = '00';
//   }
//
//   if (intCS === "" || isNaN(intCS))
//   {
//     document.getElementById('idCS').value = '00';
//     intCS = '00';
//   }
//
//   objTrack = document.getElementById('idTrack');
//   objTrack.currentTime = funcGetTime(intCH, intCM, intCS);
//
//   if (objTrack.currentTime == 0)
//   {
//     scrollTo(0, 0);
//   }
//   else
//   {
//     var intScrollCorrection = 00;
//     var intInnerHeight = window.innerHeight;
//     var intClientHeight = document.getElementById('idText').clientHeight;
//     var intCurrentTime = funcGetTime(intCH, intCM, intCS);
//     var intTrackDuration = Math.floor(objTrack.duration);
//     var intCurrentHeight = Math.floor(intCurrentTime * intClientHeight / intTrackDuration);
//
//     var intScrollY = intCurrentHeight + intScrollCorrection;
//
//
//     if (intScrollY < 0)
//     {
//       intScrollY = 0;
//     }
//
//     if (intScrollY > intClientHeight)
//     {
//       intScrollY = intClientHeight;
//     }
//
//     scrollTo(0, intScrollY);
//   }
//
//   if (blnPlaying == false)
//   {
//     objAudio.style.color = "#aaaaaa";
//     objTrack.play();
//     blnPlaying = true;
//   }
//   else
//   {
//     objAudio.style.color = "#ffffff";
//     objTrack.pause();
//
//     intCH = document.getElementById('idCH').value;
//     intCM = document.getElementById('idCM').value;
//     intCS = document.getElementById('idCS').value;
//
//     if (intCH.charAt(0) == "0") { intCH = intCH.substr(1, 1); }
//     if (intCM.charAt(0) == "0") { intCM = intCM.substr(1, 1); }
//     if (intCS.charAt(0) == "0") { intCS = intCS.substr(1, 1); }
//
//     intSC = document.body.scrollTop;
//
//     localStorage.setItem(strURL + '===SC', intSC);
//
//     localStorage.setItem(strURL + '===CH', intCH);
//     localStorage.setItem(strURL + '===CM', intCM);
//     localStorage.setItem(strURL + '===CS', intCS);
//
//     blnPlaying = false;
//   }
// }
//
// /*----------------------------------------------------------------------------------------------------------*/
//
// function fncUpdateInitialTimes(varTrack)
// {
//   var strURL = document.URL;
//
//   var objDH = document.getElementById('idDH');
//   var objDM = document.getElementById('idDM');
//   var objDS = document.getElementById('idDS');
//
//   var objDH = document.getElementById('idDH');
//   var objDM = document.getElementById('idDM');
//   var objDS = document.getElementById('idDS');
//
//   var intCLH = localStorage.getItem(strURL + '===CH');
//   var intCLM = localStorage.getItem(strURL + '===CM');
//   var intCLS = localStorage.getItem(strURL + '===CS');
//
//   var intSC = localStorage.getItem(strURL + '===SC');
//
//   if (intCLH < 10) { intCLH = "0" + intCLH; }
//   if (intCLM < 10) { intCLM = "0" + intCLM; }
//   if (intCLS < 10) { intCLS = "0" + intCLS; }
//
//   if (intCLH == null || intCLH === "" || isNaN(intCLH)) { document.getElementById('idCH').value = '00'; }
//   else { document.getElementById('idCH').value = intCLH; }
//
//   if (intCLM == null || intCLM === "" || isNaN(intCLM)) { document.getElementById('idCM').value = '00'; }
//   else { document.getElementById('idCM').value = intCLM; }
//
//   if (intCLS == null || intCLS === "" || isNaN(intCLS)) { document.getElementById('idCS').value = '00'; }
//   else { document.getElementById('idCS').value = intCLS; }
//
//   var intDS = Math.floor(varTrack.duration).toString();
//
//   if (isNaN(intDS))
//   {
//     objDH.innerHTML = '00';
//     objDM.innerHTML = '00';
//     objDS.innerHTML = '00';
//   }
//   else
//   {
//     objDH.innerHTML = funcGetHrs(intDS);
//     objDM.innerHTML = funcGetMns(intDS);
//     objDS.innerHTML = funcGetScs(intDS);
//   }
// }
//
// /*----------------------------------------------------------------------------------------------------------*/
//
// function fncUpdateTrackTime(varTrack)
// {
//   var objCH = document.getElementById('idCH');
//   var objCM = document.getElementById('idCM');
//   var objCS = document.getElementById('idCS');
//
//   var objDH = document.getElementById('idDH');
//   var objDM = document.getElementById('idDM');
//   var objDS = document.getElementById('idDS');
//
//   var intCS = Math.floor(varTrack.currentTime).toString();
//   var intDS = Math.floor(varTrack.duration).toString();
//
//   if (isNaN(intCS))
//   {
//     objCH.value = '00';
//     objCM.value = '00';
//     objCS.value = '00';
//   }
//   else
//   {
//     objCH.value = funcGetHrs(intCS);
//     objCM.value = funcGetMns(intCS);
//     objCS.value = funcGetScs(intCS);
//   }
//
//   if (isNaN(intDS))
//   {
//     objDH.innerHTML = '00';
//     objDM.innerHTML = '00';
//     objDS.innerHTML = '00';
//   }
//   else
//   {
//     objDH.innerHTML = funcGetHrs(intDS);
//     objDM.innerHTML = funcGetMns(intDS);
//     objDS.innerHTML = funcGetScs(intDS);
//   }
// }
//
// /*----------------------------------------------------------------------------------------------------------*/
//
// function fncGetTime(intHrs, intMns, intScs)
// {
//   var intTime = (parseInt(intHrs) * 3600 + parseInt(intMns) * 60 + parseInt(intScs)).toString();
//   return intTime;
// }
//
// /*----------------------------------------------------------------------------------------------------------*/
//
// function funcGetHrs(intSecondsTotal)
// {
//   var intHours = Math.floor(intSecondsTotal / 3600);
//
//   if (intHours < 10) { intHours = "0" + intHours; }
//   return intHours;
// }
//
// /*----------------------------------------------------------------------------------------------------------*/
//
// function fncGetMns(intSecondsTotal)
// {
//   var intHours = Math.floor(intSecondsTotal / 3600);
//   var intMinutes = Math.floor((intSecondsTotal - (intHours * 3600)) / 60);
//
//   if (intMinutes < 10) { intMinutes = "0" + intMinutes; }
//   return intMinutes;
// }
//
// /*----------------------------------------------------------------------------------------------------------*/
//
// function fncGetScs(intSecondsTotal)
// {
//   var intHours = Math.floor(intSecondsTotal / 3600);
//   var intMinutes = Math.floor((intSecondsTotal - (intHours * 3600)) / 60);
//   var intSeconds = Math.floor(intSecondsTotal - (intHours * 3600) - (intMinutes * 60));
//
//   if (intSeconds < 10) { intSeconds = "0" + intSeconds; }
//   return intSeconds;
// }
//
/*----------------------------------------------------------------------------------------------------------*/
