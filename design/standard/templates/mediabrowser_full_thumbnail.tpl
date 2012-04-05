{* This template displays a collection of child nodes as thumbnails. *}
{* It is included/used from within the children.tpl if the user's viewmode is set to list. *}
<div class="content-navigation-childlist">
<table class="list-thumbnails" cellspacing="0">
    <tr>
    {def $compteur = 0}
    <form name="fck">
    {section var=Nodes loop=$children sequence=array( bglight, bgdark )}
    {let child_name=$Nodes.item.name|wash}
        <td width="25%">
        {if ne($Nodes.item.children_count,0)}
	        <a href="{''|ezurl(no)}/{concat("(dispnodeid)/",$Nodes.item.node_id)}">
	    {/if}
	        {$Nodes.item.class_identifier|class_icon( normal, '[%classname]'|i18n( 'design/admin/node/view/thumbnail',, hash( '%classname', $Nodes.item.name ) ) )}
			</a>
        <div class="controls">
        {* Radio selector *}
        <input 	{if eq($Nodes.item.class_name, 'Répertoire')}
            			disabled=true
            		{/if}
            		{if ne($Nodes.item.class_name, 'Image')}
            			title="Sélectionnez le média à lier"
            		{else}
            			title="Sélectionnez le média à lier."
            			imgwidth="{$Nodes.item.data_map.image.content.original.width}"
            			imgheight="{$Nodes.item.data_map.image.content.original.height}"
            		{/if}
            		value="smileobject://{$Nodes.item.node_id}"
        type="radio" name="lien" value="smileobject://{$Nodes.item.node_id}" />
        <p>{$child_name}</p>
        </div>
    {/let}
</td>
{delimiter modulo=4}
</tr><tr>
{/delimiter}
{set $compteur=inc($compteur)}
{/section}
</form>
{undef $compteur}
</tr>
</table>
</div>
