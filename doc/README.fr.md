SmileFCKeditor - Extension qui intègre FCKeditor
Par Maxime THOMAS <maxime.thomas@smile.fr>- © 2006 Smile

Description
-----------
Cette extension propose une surcharge du datatype HTMLFields qui permet d'afficher une zone de texte FCKeditor.
Elle dispose nottament de deux plugins FCK :
- SmileeZimage : Sélection d'une image dans la médiathèque eZpublish.
- SmileeZlink : Sélection d'un contenu dans la médiathèque eZpublish.


Pré-requis
----------
Il faut que le navigateur supporte le javascript.

Contraintes
-----------
Le nom de l'extension doit rester smilefckeditor.
Il faut que l'option javascript soit activée pour que la barre d'outils fck soit activée.

Installation
------------

1 - Placer le répertoire "smilefckeditor" dans le répertoire "extension"
2 - Modifier le fichier httpd.conf du repertoire conf dans le répertoire d'installation d'Apache.
Dans les règles de réécriture dédiées à eZpublish, ajouter les lignes suivantes :

Rewriterule ^/extension/smilefckeditor/javascript/.*                							- [L]
Rewriterule ^/extension/smilefckeditor/fckeditor/.* 				             				- [L]

3 - Activer l'extension (dans le site.ini ou dans le back-office)

Lancement
---------
Le template du datatype est appelé automatiquement dans le back office, donc il n'y a rien à lancer : le
FCK est chargé dynamiquement.

Configuration
-------------
Pour configurer FCK, il suffit d'éditer le fichier :

smilefckeditor/fckeditor/fckconfig.js

Et de modifier le tableau :

FCKConfig.ToolbarSets["Default"]

Qui correspond à l'ensemble des barres d'outils de fck.
Les noms des plugins que l'ont peut ajouter sont SmileeZlink et SmileeZimage.
Il faut décommenter les lignes :

//FCKConfig.Plugins.Add('SmileeZlink') ;
//FCKConfig.Plugins.Add('SmileeZimage') ;


Pour effectuer des configurations par critère, on peut modifier le template de l'édition, en précisant le
fichier de configuration à charger. Ceci se trouve dans le fichier :

smilefckeditor/design/standard/templates/content/datatype/edit/ezhtml.tpl

Et la valeur à changer est :

  oFCKeditor{$attribute.id}.Config["CustomConfigurationsPath"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/fckconfig.js" ;	// fichier de configuration js

Que l'on pourrait éventuellement remplacer par :

{if <ma condition>}
   oFCKeditor{$attribute.id}.Config["CustomConfigurationsPath"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/fckconfig1.js" ;	// fichier de configuration js
{else}
   oFCKeditor{$attribute.id}.Config["CustomConfigurationsPath"] = "{ezsys('wwwdir')}/extension/smilefckeditor/fckeditor/fckconfig2.js" ;	// fichier de configuration js
{/if}


ATTENTION
---------
Afin que les changements prennent effet, il est recommandé de bien vider et les caches eZpublish et les caches
du navigateur !