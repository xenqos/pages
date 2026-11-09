/* ------------------------------------------------------------------------ */

'use strict';

/* ------------------------------------------------------------------------ */


function fncOnLoad(objParameter)
{
  window.location.href = './template.html?hanzi=' + encodeURIComponent(objParameter.textContent);
}

function fncProcessHanzi()
{
  const objElement = document.getElementById('idHanzi');
  if (!objElement) return;

  const strHanzi = new URLSearchParams(window.location.search).get('hanzi');
  if (strHanzi) objElement.textContent = strHanzi;
}

document.addEventListener('DOMContentLoaded', fncProcessHanzi);

/* ------------------------------------------------------------------------ */
