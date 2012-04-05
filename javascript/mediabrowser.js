
  //var sUrl = GetE('txtUrl').value ;
  window.onload = function () {
    // Show the "Ok" button.
    window.parent.SetOkButton( true ) ;
    if(window.parent.document.title == 'SmileeZimage') {
    	document.forms[1].nurBilder.value="true";
    }
	else {
		document.forms[1].nurBilder.value="false";
	}

	if ((document.forms[1].nurBilder.value=="true")&&
			(document.forms[0].lien.title=="S?lectionnez le m?dia ? lier"))
	  	document.forms[0].lien.disabled = true;
	else {
		for (i=0; i<document.forms[0].lien.length; ++i) {
			if ((document.forms[1].nurBilder.value=="true")&&
				(document.forms[0].lien[i].title=="S?lectionnez le m?dia ? lier"))
		  	document.forms[0].lien[i].disabled = true;
		}
	}
  }

  function Ok() {
    var link = '';
    if (document.forms[0].lien.value) link=document.forms[0].lien.value;
    for (i=0; i<document.forms[0].lien.length; ++i) {
      if (document.forms[0].lien[i].checked) {
        link = document.forms[0].lien[i].value;
        if (document.forms[0].lien[i].imgwidth) {
	       var width = document.forms[0].lien[i].imgwidth;
     	   var height = document.forms[0].lien[i].imgheight;
        }
      }
    }

    if (document.forms[1].nurBilder.value=="false") {
    	var oEditor	= window.parent.InnerDialogLoaded() ;
    	oEditor.FCKUndo.SaveUndoStep() ;
    	oEditor.FCK.CreateLink(link);
    }
    else
    {
    	var oEditor	= window.parent.InnerDialogLoaded() ;
   		oEditor.FCKUndo.SaveUndoStep() ;
    	oImage = oEditor.FCK.CreateElement( 'IMG' ) ;
    	oImage.setAttribute('src', link, 0);
    	if (typeof(width) != "undefined") {
    		oImage.setAttribute('width', width, 0);
    		oImage.setAttribute('height', height, 0);
    	}
    }
    window.top.close() ;
    return true;
  }
