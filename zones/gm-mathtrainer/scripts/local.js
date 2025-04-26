/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*-----------------------------------------------------------------------------------------------*/
/*                                                                                               */
/*-----------------------------------------------------------------------------------------------*/

function fncAddition_01()
{
  const spanElementX = document.getElementById('idVarX');
  const spanElementY = document.getElementById('idVarY');
  const spanElementZ = document.getElementById('idVarZ');

  spanElementZ.style.color = '#c7c7c7';
  spanElementZ.style.backgroundColor = '#c7c7c7';

  var X = Math.floor(Math.random() * (99 - 11 + 1)) + 11;
  var Y = Math.floor(Math.random() * (9 - 1 + 1)) + 1;
  var Z = X * Y;

  spanElementX.textContent = X;
  spanElementY.textContent = Y;
  spanElementZ.textContent = Z;
}


function fncReveal()
{
  var spanElement = document.getElementById('idVarZ');
  spanElement.style.color = '#000000';
  spanElement.style.backgroundColor = '#ffffff';
}


/*--------------------------------------------------------------------------------------------------*/
//  alert('ZZZ…');
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
