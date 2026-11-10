/*--------------------------------------------------------------------------*/
/* Global Variables                                                         */
/*--------------------------------------------------------------------------*/

var strUrl = document.URL;

/*--------------------------------------------------------------------------*/
/* Reload Page                                                              */
/*--------------------------------------------------------------------------*/

function fncReloadPage()
{
  window.location.reload();
}

/*--------------------------------------------------------------------------*/
/* Hide Topbar                                                              */
/*--------------------------------------------------------------------------*/

let numPrevScrollPos = window.pageYOffset;
const numScrollThreshold = 10;

window.onscroll = () =>
{
  let numCurrentScrollPos = window.pageYOffset;
  let numScrollDifference = Math.abs(numCurrentScrollPos - numPrevScrollPos);
  let objTopbarElement = document.getElementById('idTopbar');

  if (numScrollDifference > numScrollThreshold)
  {
    if (numPrevScrollPos > numCurrentScrollPos)
    {
      objTopbarElement.style.top = '0';
    }
    else
    {
      objTopbarElement.style.top = '-6.000rem';
    }

    numPrevScrollPos = numCurrentScrollPos;
  }
};

/*--------------------------------------------------------------------------*/
/* Set & Get Scroll Position                                                */
/*--------------------------------------------------------------------------*/

window.onbeforeunload = () =>
{
  localStorage.setItem(strUrl + '===SP', window.pageYOffset);
};

/*--------------------------------------------------------------------------*/
/* Collapse & Expand                                                        */
/*--------------------------------------------------------------------------*/

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

/*--------------------------------------------------------------------------*/
/* Get ScrollPosition from Local Storage                                    */
/*--------------------------------------------------------------------------*/

function fncGetScrollPosition()
{
  var strScrollPosition = localStorage.getItem(strUrl + '===SP');
  if (strScrollPosition)
  {
    window.scrollTo(0, strScrollPosition);
  }
}

/*--------------------------------------------------------------------------*/
/* Get Div State from Local Storage                                         */
/*--------------------------------------------------------------------------*/

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

/*--------------------------------------------------------------------------*/
/* Audio                                                                    */
/*--------------------------------------------------------------------------*/

var numTimeLastTap = 0;
var numTimeRewind = 10;

/*--------------------------------------------------------------------------*/

function fncPlayLink(strLink)
{
  var objAudio = new Audio(strLink);
  objAudio.play().catch(function(objError) { });
}

/*--------------------------------------------------------------------------*/

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

/*--------------------------------------------------------------------------*/

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
    if (objTrack.currentTime < 0.1)
    {
      if (objTrack.currentTime === 0)
      {
        objTrack.play().catch(function(objError) { });
      }
      else
      {
        objTrack.currentTime = 0;
        objTrack.onseeked = function()
        {
          objTrack.play().catch(function(objError) { });
          objTrack.onseeked = null;
        };
      }
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

/*--------------------------------------------------------------------------*/

var strHanziSoundsDir = '../../zh-resources/sounds/';
var strSoundType = 'opus';

var objAudio = new Audio();

function fncPlayHanzi(strHanziSound)
{
  var strSound = strHanziSoundsDir + strHanziSound + '.' + strSoundType;

  objAudio.src = strSound;
  objAudio.play().catch(function (err)
  {
    console.error('Cannot play:', strSound, err);
  });
}

document.addEventListener('click', function (e)
{
  var objLink = e.target.closest('a[data-hanzi-sound]');
  if (!objLink) return;
  e.preventDefault();
  fncPlayHanzi(objLink.dataset.hanziSound);
});

/*--------------------------------------------------------------------------*/
/* Images                                                                   */
/*--------------------------------------------------------------------------*/

function getFullScreen(objElement)
{
  if (objElement.requestFullscreen)
  {
    objElement.requestFullscreen();
  }
}

/*--------------------------------------------------------------------------*/
/* Hanzi SVG                                                                */
/*--------------------------------------------------------------------------*/

function fncGetHanzi()
{
  return new URLSearchParams(window.location.search).get('hanzi');
}

/*--------------------------------------------------------------------------*/

function fncOnLoad(objParameter)
{
  const strText = (objParameter.value !== undefined) ? objParameter.value : objParameter.textContent;
  const strHanzi = strText.trim();
  if (!strHanzi) return;

  window.location.href = '/zones/lingvo/zh-hanzi/pages/hanzi.html?hanzi=' + encodeURIComponent(strHanzi);
}

/*--------------------------------------------------------------------------*/

function fncSetText(strId, strValue)
{
  if (strValue === undefined || strValue === null) return;

  const objElement = document.getElementById(strId);
  if (objElement) objElement.textContent = strValue;
}

/*--------------------------------------------------------------------------*/

function fncGetColors()
{
  const blnDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

  return {
    stroke:  blnDark ? '#dbdbdb' : '#000000',
    radical: blnDark ? '#dbdbdb' : '#000000',
    outline: blnDark ? '#333333' : '#eeeeee'
  };
}

/*--------------------------------------------------------------------------*/

async function fncProcessHanzi()
{
  const strHanzi = fncGetHanzi();
  if (!strHanzi) return;

  const objElement = document.getElementById('idHanzi');
  if (!objElement) return;

  //  objElement.textContent = strHanzi;

  const objColors = fncGetColors();

  var objStrokes = HanziWriter.create('idGridTarget', strHanzi,
  {
    width:                280,
    height:               280,
    padding:              0,

    highlightOnComplete:  false,
    delayBetweenStrokes:  500,
    delayBetweenLoops:    1000,

    strokeColor:          objColors.stroke,
    radicalColor:         objColors.radical,
    outlineColor:         objColors.outline,

    //    strokeColor:          '#000000',
    //    radicalColor:         '#000000',
    //    outlineColor:         '#eeeeee',

    charDataLoader: function(char, onComplete) {
      $.getJSON('../../zh-resources/strokes/' + strHanzi + '.json', function(charData) {
        onComplete(charData);
      });
    }
  });

  document.getElementById('idHanziPlay').addEventListener('click', function()
  {
    objStrokes.animateCharacter();
  });

  document.getElementById('idHanziQuiz').addEventListener('click', function()
  {
    objStrokes.quiz();
  });

  try
  {
    const objResponse = await fetch('../../zh-resources/infos/' + encodeURIComponent(strHanzi) + '.json');
    if (!objResponse.ok) throw new Error('HTTP ' + objResponse.status);

    const objData = await objResponse.json();

    const objCharacter = document.getElementById('idHanziCharacter');

    if (objCharacter && objData.tone !== undefined && objData.tone !== null)
    {
      const objSpan = document.createElement('span');
      objSpan.className   = 'clTone' + objData.tone;
      objSpan.textContent = strHanzi;

      objCharacter.textContent = '';
      objCharacter.appendChild(objSpan);
    }

    //    fncSetText('idHanziCharacter',          objData.character);
    fncSetText('idHanziDefinition',         objData.definition);
    fncSetText('idHanziTone',               objData.tone);
    fncSetText('idHanziPinyin',             objData.pinyin && objData.pinyin[0]);
    fncSetText('idHanziRadical',            objData.radical);
    fncSetText('idHanziDecomposition',      objData.decomposition);
    fncSetText('idHanziEtymologyType',      objData.etymology && objData.etymology.type);
    fncSetText('idHanziEtymologySemantic',  objData.etymology && objData.etymology.semantic);
    fncSetText('idHanziEtymologyPhonetic',  objData.etymology && objData.etymology.phonetic);
    fncSetText('idHanziEtymologyHint',      objData.etymology && objData.etymology.hint);

    const strPinyin = objData.pinyin && objData.pinyin[0];
    const objSound  = document.getElementById('idHanziSound');

    if (strPinyin && objSound)
    {
      objSound.addEventListener('click', function()
      {
        fncPlayHanzi(strPinyin);
      });
    }
  }
  catch (objError)
  {
    console.error('Failed to load hanzi data:', objError);
  }
}

/*--------------------------------------------------------------------------*/

document.addEventListener('DOMContentLoaded', fncProcessHanzi);

/*--------------------------------------------------------------------------*/

