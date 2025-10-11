/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

var strRevealedColor           = '#367b36';
var strRevealedBackgroundColor = '#ffffff';

/*--------------------------------------------------------------------------------------------------*/

function fncHideHeading()
{
  const h1Element = document.querySelector('h1');
  h1Element.remove();
}

/*--------------------------------------------------------------------------------------------------*/

function fncRevealAnswer()
{
  const divElementAnswer = document.getElementById('idAnswer');

  divElementAnswer.style.color           = strRevealedColor;
  divElementAnswer.style.backgroundColor = strRevealedBackgroundColor;
}

/*--------------------------------------------------------------------------------------------------*/
