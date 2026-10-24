/*--------------------------------------------------------------------------------------------------*/

'use strict';

/*--------------------------------------------------------------------------------------------------*/

$(document).ready(function(){ $("#idMenuButton").click(function(){ $("#idMenuEntries").toggle();}); });

/*--------------------------------------------------------------------------------------------------*/

function fnSubmitRadio(strUrl)
{
  var strValue = '';
  const objCollection = document.getElementsByClassName('clSelector');

  for (let intCounter = 0; intCounter < objCollection.length; intCounter++)
  {
    if (objCollection[intCounter].checked)
    {
      strValue = objCollection[intCounter].id;
      break;
    }
  }

  if (strValue === '')
  {
    alert('Select item.');
  }
  else
  {
    // console.log(strUrl + strValue);
    window.location.replace(strUrl + strValue);
  }
}

/*--------------------------------------------------------------------------------------------------*/

function fnSubmitCheckbox(strUrl)
{
  var strValue = '';
  const objCollection = document.getElementsByClassName('clSelector');

  for (let intCounter = 0; intCounter < objCollection.length; intCounter++)
  {
    if (objCollection[intCounter].checked)
    {
      strValue += objCollection[intCounter].name;
      strValue += ',';
    }
  }

  strValue = strValue.replace(/,$/,'');

  if (strValue === '')
  {
    alert('Select item.');
  }
  else
  {
//    console.log(strUrl + strValue);
    window.location.replace(strUrl + strValue);
  }
}

/*--------------------------------------------------------------------------------------------------*/

function fnReloadPage()
{
  // window.location.href = window.location.href;
  // window.location.replace(strUrl);
  window.location.reload();
}

/*--------------------------------------------------------------------------------------------------*/
//  alert('ZZZ…');
//  console.log('ZZZ…');
/*--------------------------------------------------------------------------------------------------*/
