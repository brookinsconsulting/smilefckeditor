{*
//
// Copyright (C) 2005 Smile. All rights reserved.
//
// Authors:
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

{default attribute_base='ContentObjectAttribute' html_class='full'}

<script type="text/javascript" src={'/extension/smilefckeditor/fckeditor/fckeditor.js'|ezroot}></script>
<textarea id="{$attribute_base}_fcke_{$attribute.id}"
          class="{eq( $html_class, 'half' )|choose( 'box', 'halfbox' )}"
	  name="{$attribute_base}_data_text_{$attribute.id}"
	  cols="70">{$attribute.content|wash}</textarea>

<script type="text/javascript">

  var oFCKeditor{$attribute.id} = new FCKeditor ("{$attribute_base}_fcke_{$attribute.id}");

  oFCKeditor{$attribute.id}.BasePath = {'/extension/smilefckeditor/fckeditor/'|ezroot()} ;	// chemin vers fckeditor
  oFCKeditor{$attribute.id}.Height = 20*{$attribute.contentclass_attribute.data_int1};
  oFCKeditor{$attribute.id}.Config["StylesXmlPath"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/fckstyles.xml" ;		// fichier au format XML pour la liste déroulantes de style
  oFCKeditor{$attribute.id}.Config["LinkBrowserURL"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&ServerPath={ezsys('wwwdir')}/{ezini('FileSettings','VarDir')}/storage/fckeditor" ;
  oFCKeditor{$attribute.id}.Config["ImageBrowserURL"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&ServerPath={ezsys('wwwdir')}/{ezini('FileSettings','VarDir')}/storage/fckeditor" ;
  oFCKeditor{$attribute.id}.Config["FlashBrowserURL"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php&ServerPath={ezsys('wwwdir')}/{ezini('FileSettings','VarDir')}/storage/fckeditor" ;
  oFCKeditor{$attribute.id}.Config["BaseHref"] = '' ;
  oFCKeditor{$attribute.id}.Config["CustomConfigurationsPath"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/fckconfig.js" ;	// fichier de configuration js


  oFCKeditor{$attribute.id}.Config["ezobject"] = {$attribute.contentobject_id} ;		// identifiant de l'objet
  oFCKeditor{$attribute.id}.Config["ezsiteaccess"] = "{ezsys('indexdir')}" ;			// url ezpublish
  oFCKeditor{$attribute.id}.Config["ezversion"] = {$attribute.version} ;				// version de l'objet

  oFCKeditor{$attribute.id}.ReplaceTextarea ();

</script>
{/default}

