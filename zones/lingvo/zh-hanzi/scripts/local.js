/*--------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------*/


function fncOnLoad(objParameter)
{
  window.location.href = './hanzi.html?hanzi=' + encodeURIComponent(objParameter.textContent);
}

function fncSetText(strId, strValue)
{
  if (strValue === undefined || strValue === null) return;

  const objElement = document.getElementById(strId);
  if (objElement) objElement.textContent = strValue;
}

async function fncProcessHanzi()
{
  const objElement = document.getElementById('idHanzi');
  if (!objElement) return;

  const strHanzi = new URLSearchParams(window.location.search).get('hanzi');
  if (!strHanzi) return;

  //  objElement.textContent = strHanzi;

  try
  {
    const objResponse = await fetch('../../zh-resources/infos/' + encodeURIComponent(strHanzi) + '.json');
    if (!objResponse.ok) throw new Error('HTTP ' + objResponse.status);

    const objData = await objResponse.json();

    fncSetText('idHanziCharacter',          objData.character);
    fncSetText('idHanziDefinition',         objData.definition);
    fncSetText('idHanziTone',               objData.tone);
    fncSetText('idHanziPinyin',             objData.pinyin && objData.pinyin[0]);
    fncSetText('idHanziRadical',            objData.radical);
    fncSetText('idHanziDecomposition',      objData.decomposition);
    fncSetText('idHanziEtymologyType',      objData.etymology && objData.etymology.type);
    fncSetText('idHanziEtymologySemantic',  objData.etymology && objData.etymology.semantic);
    fncSetText('idHanziEtymologyPhonetic',  objData.etymology && objData.etymology.phonetic);
    fncSetText('idHanziEtymologyHint',      objData.etymology && objData.etymology.hint);
  }
  catch (objError)
  {
    console.error('Failed to load hanzi data:', objError);
  }
}

document.addEventListener('DOMContentLoaded', fncProcessHanzi);

/*--------------------------------------------------------------------------*/
