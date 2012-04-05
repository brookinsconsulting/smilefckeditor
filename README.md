SmileFCKeditor - Extension qui int�gre FCKeditor
Par Maxime THOMAS <maxime.thomas@smile.fr>- � 2006 Smile

Description
-----------
Cette extension propose une surcharge du datatype HTMLFields qui permet d'afficher une zone de texte FCKeditor.
Elle dispose nottament de deux plugins FCK :
- SmileeZimage : S�lection d'une image dans la m�diath�que eZpublish.
- SmileeZlink : S�lection d'un contenu dans la m�diath�que eZpublish.


Pr�-requis
----------
Il faut que le navigateur supporte le javascript.

Contraintes
-----------
Le nom de l'extension doit rester smilefckeditor.
Il faut que l'option javascript soit activ�e pour que la barre d'outils fck soit activ�e.

Installation
------------

1 - Placer le r�pertoire "smilefckeditor" dans le r�pertoire "extension"
2 - Modifier le fichier httpd.conf du repertoire conf dans le r�pertoire d'installation d'Apache.
Dans les r�gles de r��criture d�di�es � eZpublish, ajouter les lignes suivantes :

Rewriterule ^/extension/smilefckeditor/javascript/.*                							- [L]
Rewriterule ^/extension/smilefckeditor/fckeditor/.* 				             				- [L]

3 - Activer l'extension (dans le site.ini ou dans le back-office)

Lancement
---------
Le template du datatype est appel� automatiquement dans le back office, donc il n'y a rien � lancer : le
FCK est charg� dynamiquement.

Configuration
-------------
Pour configurer FCK, il suffit d'�diter le fichier :

smilefckeditor/fckeditor/fckconfig.js

Et de modifier le tableau :

FCKConfig.ToolbarSets["Default"]

Qui correspond � l'ensemble des barres d'outils de fck.
Les noms des plugins que l'ont peut ajouter sont SmileeZlink et SmileeZimage.
Il faut d�commenter les lignes :

//FCKConfig.Plugins.Add('SmileeZlink') ;
//FCKConfig.Plugins.Add('SmileeZimage') ;


Pour effectuer des configurations par crit�re, on peut modifier le template de l'�dition, en pr�cisant le
fichier de configuration � charger. Ceci se trouve dans le fichier :

smilefckeditor/design/standard/templates/content/datatype/edit/ezhtml.tpl

Et la valeur � changer est :

  oFCKeditor{$attribute.id}.Config["CustomConfigurationsPath"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/fckconfig.js" ;	// fichier de configuration js

Que l'on pourrait �ventuellement remplacer par :

{if <ma condition>}
   oFCKeditor{$attribute.id}.Config["CustomConfigurationsPath"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/fckconfig1.js" ;	// fichier de configuration js
{else}
   oFCKeditor{$attribute.id}.Config["CustomConfigurationsPath"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/fckconfig2.js" ;	// fichier de configuration js
{/if}


ATTENTION
---------
Afin que les changements prennent effet, il est recommand� de bien vider et les caches eZpublish et les caches
du navigateur !