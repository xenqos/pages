/* ------------------------------------------------------------------------ */

'use strict';

function fncHanziShow(objParameter)
{
  window.location.href = './template.html?hanzi=' + encodeURIComponent(objParameter.textContent);
}

function fncHanziLoad()
{
  const objElement = document.getElementById('idHanzi');
  if (!objElement) return;

  const strHanzi = new URLSearchParams(window.location.search).get('hanzi');
  if (strHanzi) objElement.textContent = strHanzi;
}

document.addEventListener('DOMContentLoaded', fncHanziLoad);

/* ------------------------------------------------------------------------ */
