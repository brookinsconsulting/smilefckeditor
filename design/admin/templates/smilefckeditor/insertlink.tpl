{*
//
// Copyright (C) 2005 Smile. All rights reserved.
//
// Authors:
//   Emmanuel Saracco <emmanuel.saracco@smile.fr>
//   Julian Roblin <julian.roblin@smile.fr>
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// Licencees holding a valid "eZ publish professional licence" version 2
// may use this file in accordance with the "eZ publish professional licence"
// version 2 Agreement provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" version 2 is available at
// http://ez.no/ez_publish/licences/professional/ and in the file
// PROFESSIONAL_LICENCE included in the packaging of this file.
// For pricing of this licence please contact us via e-mail to licence@ez.no.
// Further contact information is available at http://ez.no/company/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//
*}

{literal}
<script type="text/javascript">

	var oEditor = window.parent.InnerDialogLoaded() ; 
	var FCK = oEditor.FCK ; 
	var FCKLang = oEditor.FCKLang ; 
	var FCKeZPublishLink = oEditor.FCKeZPublishLink ;
	
	window.parent.SetOkButton( true ) ; // Show the "Ok" button. 
	
	if (window.addEventListener)
	{
		window.addEventListener('load', getSelection, false) ;
 	}
	else
		if (window.attachEvent)
		{
 			window.attachEvent('onload', getSelection) ;
 		}
		else
		{
 			window.onload = getSelection ;
		}
	
	function Ok() 
	{ 
		var object = false ;
		var caption = document.insertlink.caption.value ;
	
		if (document.insertlink.related_object.checked)
		{
			object = document.insertlink.related_object.value ;
		}
		else
		{
			for (i = 0 ; i < document.insertlink.related_object.length ; i++)
			{
				with (document.insertlink.related_object[i])
				{
					if (document.insertlink.related_object[i].checked)
					{
						object = document.insertlink.related_object[i].value ;
					}
	      }
	    }
		}

		if (object)
		{
			FCKeZPublishLink.Add(object, caption) ;  		
		}
	
		return true ; 
	} 
	
	function getSelection()
	{
		var selection ;
		
		if (document.all)
		{
			selection = new String(FCK.EditorDocument.selection.createRange().text) ;
		}
		else
		{
			selection = new String(FCK.EditorWindow.getSelection()); 
		}
	
		if (selection.length > 0)
		{
			document.insertlink.caption.value = selection ;
		} 
	}
	
</script>
{/literal}

<form name="insertlink">

<div>
<label>{'Caption'|i18n('content')}:</label>
<input type="text" id="caption" size="32" name="caption"/>
</div>

<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h2 class="context-title">{'Select an object to link'|i18n('content')}</h2>

{* DESIGN: Mainline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

<table width="500" class="list" cellspacing="0">
<tr>
    <th width="300" colspan="2">{'Name'|i18n('content')}</th>
    <th width="200">{'Type'|i18n('content')}</th>
</tr>
{let owner_object=fetch('content', 'object', hash('object_id', $object))}
<tr><th colspan="3">This object</th></tr>
<tr class="bglight">
    <td width="50"><input type="radio" name="related_object" value="{$owner_object.id}"></td>
    <td width="250">{$owner_object.name}</td>
    <td width="200">{$owner_object.class_name}</td>
</tr>
{/let}
{let related_object_list=fetch('smilefckeditor', 'smileGetRelatedObjects', hash('object', $object , 'version', $version))}
{section show=$related_object_list}
<tr><th colspan="3">Related objects</th></tr>
{section loop=$related_object_list sequence=array(bglight, bgdark)}
<tr class="{$:sequence}">
    <td width="50"><input type="radio" name="related_object" value="{$:item.id}"></td>
    <td width="250">{$:item.name}</td>
    <td width="200">{$:item.class_name}</td>
</tr>
{/section}
{/section}
{/let}

</table>

{* DESIGN: Content END *}</div></div></div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
    <div class="block">
		&nbsp;
    </div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</form>
