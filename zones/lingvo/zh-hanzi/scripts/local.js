/* ------------------------------------------------------------------------ */

'use strict';

/* ------------------------------------------------------------------------ */


function fncOnLoad(objParameter)
{
  window.location.href = './hanzi.html?hanzi=' + encodeURIComponent(objParameter.textContent);
}

/*
function fncProcessHanzi()
{
  const objElement = document.getElementById('idHanzi');
  if (!objElement) return;

  const strHanzi = new URLSearchParams(window.location.search).get('hanzi');
  if (strHanzi) objElement.textContent = strHanzi;
}
*/

async function fncProcessHanzi()
{
  const objElement = document.getElementById('idHanzi');
  if (!objElement) return;

  const strHanzi = new URLSearchParams(window.location.search).get('hanzi');
  if (!strHanzi) return;

  objElement.textContent = strHanzi;

  try
  {
    const objResponse = await fetch('../../zh-resources/infos/' + encodeURIComponent(strHanzi) + '.json');
    if (!objResponse.ok) throw new Error('HTTP ' + objResponse.status);

    const objData = await objResponse.json();

    console.log(objData.definition);   // "the classics; to experience, to undergo"
    console.log(objData.pinyin[0]);    // "jīng"
    console.log(objData.etymology.hint); // "thread"
  }
  catch (objError)
  {
    console.error('Failed to load hanzi data:', objError);
  }
}

document.addEventListener('DOMContentLoaded', fncProcessHanzi);

/* ------------------------------------------------------------------------ */
