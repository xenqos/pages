/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

var strHiddenColor             = '#e0e0e0';
var strHiddenBackgroundColor   = '#e0e0e0';
var strRevealedColor           = '#000000';
var strRevealedBackgroundColor = '#ffffff';

/*--------------------------------------------------------------------------------------------------*/
/*  Addition 01                                                                                     */
/*--------------------------------------------------------------------------------------------------*/

function fncAddition_01()
{
  const spanElementX = document.getElementById('id-A01-X');
  const spanElementY = document.getElementById('id-A01-Y');
  const spanElementZ = document.getElementById('id-A01-Z');

  spanElementZ.style.color           = strHiddenColor;
  spanElementZ.style.backgroundColor = strHiddenBackgroundColor;

  var X = Math.floor(Math.random() * (99 - 10 + 1)) + 10;
  var Y = Math.floor(Math.random() * (9 - 1 + 1)) + 1;
  var Z = X + Y;

  spanElementX.textContent = X;
  spanElementY.textContent = Y;
  spanElementZ.textContent = Z;
}

/*--------------------------------------------------------------------------------------------------*/
/*  Addition 02                                                                                     */
/*--------------------------------------------------------------------------------------------------*/

function fncAddition_02()
{
  const spanElementX = document.getElementById('id-A02-X');
  const spanElementY = document.getElementById('id-A02-Y');
  const spanElementZ = document.getElementById('id-A02-Z');

  spanElementZ.style.color           = strHiddenColor;
  spanElementZ.style.backgroundColor = strHiddenBackgroundColor;

  var X = Math.floor(Math.random() * (99 - 10 + 1)) + 10;
  var Y = Math.floor(Math.random() * (99 - 10 + 1)) + 10;
  var Z = X + Y;

  spanElementX.textContent = X;
  spanElementY.textContent = Y;
  spanElementZ.textContent = Z;
}

/*--------------------------------------------------------------------------------------------------*/
/*  Subtraction 01                                                                                  */
/*--------------------------------------------------------------------------------------------------*/

function fncSubtraction_01()
{
  const spanElementX = document.getElementById('id-S01-X');
  const spanElementY = document.getElementById('id-S01-Y');
  const spanElementZ = document.getElementById('id-S01-Z');

  spanElementZ.style.color           = strHiddenColor;
  spanElementZ.style.backgroundColor = strHiddenBackgroundColor;

  var X = Math.floor(Math.random() * (99 - 10 + 1)) + 10;
  var Y = Math.floor(Math.random() * (9 - 1 + 1)) + 1;
  var Z = X - Y;

  spanElementX.textContent = X;
  spanElementY.textContent = Y;
  spanElementZ.textContent = Z;
}

/*--------------------------------------------------------------------------------------------------*/
/*  Subtraction 02                                                                                  */
/*--------------------------------------------------------------------------------------------------*/

function fncSubtraction_02()
{
  const spanElementX = document.getElementById('id-S02-X');
  const spanElementY = document.getElementById('id-S02-Y');
  const spanElementZ = document.getElementById('id-S02-Z');

  spanElementZ.style.color           = strHiddenColor;
  spanElementZ.style.backgroundColor = strHiddenBackgroundColor;

  while (true)
  {
    var X = Math.floor(Math.random() * (99 - 10 + 1)) + 10;
    var Y = Math.floor(Math.random() * (99 - 10 + 1)) + 10;
    var Z = X - Y;

    if (Z >= 0)
    {
        break;
    }
  }

  spanElementX.textContent = X;
  spanElementY.textContent = Y;
  spanElementZ.textContent = Z;
}

/*--------------------------------------------------------------------------------------------------*/
/*  Multiplication 01                                                                               */
/*--------------------------------------------------------------------------------------------------*/

function fncMultiplication_01()
{
  const spanElementX = document.getElementById('id-М01-X');
  const spanElementY = document.getElementById('id-М01-Y');
  const spanElementZ = document.getElementById('id-М01-Z');

  spanElementZ.style.color           = strHiddenColor;
  spanElementZ.style.backgroundColor = strHiddenBackgroundColor;

  var X = Math.floor(Math.random() * (99 - 11 + 1)) + 11;
  var Y = Math.floor(Math.random() * (9 - 2 + 1)) + 2;
  var Z = X * Y;

  spanElementX.textContent = X;
  spanElementY.textContent = Y;
  spanElementZ.textContent = Z;
}

/*--------------------------------------------------------------------------------------------------*/
/*  Division 01                                                                               */
/*--------------------------------------------------------------------------------------------------*/

function fncDivision_01()
{
  const spanElementX = document.getElementById('id-D01-X');
  const spanElementY = document.getElementById('id-D01-Y');
  const spanElementZ = document.getElementById('id-D01-Z');

  spanElementZ.style.color           = strHiddenColor;
  spanElementZ.style.backgroundColor = strHiddenBackgroundColor;

  var X = Math.floor(Math.random() * (99 - 11 + 1)) + 11;
  var Y = Math.floor(Math.random() * (9 - 2 + 1)) + 2;
  var Z = X / Y;

  Z = Z.toFixed(3);

  spanElementX.textContent = X;
  spanElementY.textContent = Y;
  spanElementZ.textContent = Z;
}

/*--------------------------------------------------------------------------------------------------*/
/*  Reveal Element                                                                                  */
/*--------------------------------------------------------------------------------------------------*/

function fncReveal(strId)
{
  var spanElement = document.getElementById(strId.id);
  spanElement.style.color = strRevealedColor;
  spanElement.style.backgroundColor = strRevealedBackgroundColor;
}

/*--------------------------------------------------------------------------------------------------*/
/*  Populate                                                                                        */
/*--------------------------------------------------------------------------------------------------*/

function fncPopulate()
{
  fncAddition_01();
  fncAddition_02();
  fncSubtraction_01();
  fncSubtraction_02();
  fncMultiplication_01();
  fncDivision_01();
}

/*--------------------------------------------------------------------------------------------------*/
