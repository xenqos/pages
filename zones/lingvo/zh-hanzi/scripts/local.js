/*--------------------------------------------------------------------------*/

'use strict';

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

  window.location.href = './hanzi.html?hanzi=' + encodeURIComponent(strHanzi);
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
