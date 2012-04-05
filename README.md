SmileFCKeditor - Extension that integrates FCKeditor
====================================================

* By Maxime THOMAS <maxime.thomas@smile.fr> - © 2006 Smile


Description
-----------
This extension provides an overload HTMLFields datatype that displays a text box FCKeditor.
It has two plugins Solicitating FCK:
- SmileeZimage: Selecting an image in the media eZpublish.
- SmileeZlink: Selecting a content in the media eZpublish.


Prerequisites
----------
Requires that the browser supports javascript.

Constraints
-----------
The extension name should remain smilefckeditor.
It is necessary that javascript is enabled for the toolbar fck is enabled.

Installation
------------

1 - Place the directory "smilefckeditor" in the "extension"
2 - Modify httpd.conf in conf directory of the installation directory of Apache.
In the rewrite rules dedicated to eZpublish, add the following lines:

RewriteRule ^ / extension / smilefckeditor / javascript /. * - [L]
RewriteRule ^ / extension / smilefckeditor / fckeditor /. * - [L]

3 - Enable the extension (in site.ini or in the back office)

Launching
---------
The template of the datatype is called automatically in the back office, so there is nothing to run: the
FCK is dynamically loaded.

Configuration
-------------
To configure FCK, just edit the file:

smilefckeditor / fckeditor / fckconfig.js

And to modify the table:

FCKConfig.ToolbarSets ["Default"]

Corresponding to all toolbars to fck.
The names of plugins that could add and are SmileeZlink SmileeZimage.
Uncomment the lines:

/ / FCKConfig.Plugins.Add ('SmileeZlink');
/ / FCKConfig.Plugins.Add ('SmileeZimage');


To make test configurations, we can modify the template editing, specifying the
configuration file to load. This is in the file:

smilefckeditor / design / standard / templates / content / datatype / edit / ezhtml.tpl

And the value to change is:

  oFCKeditor} {$ attribute.id. Config ["CustomConfigurationsPath"] = "{ezsys ('wwwdir')} / extension / smilefckeditor / fckeditor / fckconfig.js" / / configuration file js

That could possibly replace with:

{If} <ma condition>
   oFCKeditor} {$ attribute.id. Config ["CustomConfigurationsPath"] = "{ezsys ('wwwdir')} / extension/smilefckeditor/fckeditor/fckconfig1.js" / / configuration file js
{Else}
   oFCKeditor} {$ attribute.id. Config ["CustomConfigurationsPath"] = "{ezsys ('wwwdir')} / extension/smilefckeditor/fckeditor/fckconfig2.js" / / configuration file js
{/ If}


CAUTION
---------
So that changes take effect, it is recommended to empty caches and caches and eZpublish
Browser!

