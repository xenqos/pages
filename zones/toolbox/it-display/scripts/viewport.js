/*-----------------------------------------------------------------------------------------------*/

'use strict';

/*-----------------------------------------------------------------------------------------------*/

function fnShowSizes()
{
  document.getElementById('idClientWidth').innerHTML = document.documentElement.clientWidth;
  document.getElementById('idClientHeight').innerHTML = document.documentElement.clientHeight;

  document.getElementById('idOffsetWidth').innerHTML = document.documentElement.offsetWidth;
  document.getElementById('idOffsetHeight').innerHTML = document.documentElement.offsetHeight;

  document.getElementById('idOuterWidth').innerHTML = window.outerWidth;
  document.getElementById('idOuterHeight').innerHTML = window.outerHeight;

  document.getElementById('idInnerWidth').innerHTML = window.innerWidth;
  document.getElementById('idInnerHeight').innerHTML = window.innerHeight;

}


/*-----------------------------------------------------------------------------------------------*/
//  alert('ZZZ…');
//  console.log('ZZZ…');
/*-----------------------------------------------------------------------------------------------*/
