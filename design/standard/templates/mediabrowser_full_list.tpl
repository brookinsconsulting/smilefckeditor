<div class="content-navigation-childlist">
    <table class="list" cellspacing="0">
    <tr>
        {* Remove column *}
        <th class="remove"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" title="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" onclick="ezjs_toggleCheckboxes( document.children, 'DeleteIDArray[]' ); return false;" /></th>

        {* Name column *}
        <th class="name">{'Name'|i18n( 'design/admin/node/view/full' )}</th>

        {* Class type column *}
        <th class="class">{'Type'|i18n( 'design/admin/node/view/full' )}</th>

    </tr>
	<form name="fck">
    {section var=Nodes loop=$children sequence=array( bglight, bgdark )}
    	{let child_name=$Nodes.item.name|wash
         	node_name=$node.name}

        <tr class="{$Nodes.sequence}">

        {* Radio selector *}
        <td>
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
            type="radio" name="lien" />
        </td>
        {if ne($Nodes.item.class_name, 'Répertoire')}

       	{/if}

        {* Name *}
        <td>{$Nodes.item.class_identifier|class_icon( small, '[%classname]'|i18n( 'design/admin/node/view/thumbnail',, hash( '%classname', $Nodes.item.name ) ) )}
        {if ne($Nodes.item.children_count,0)}
        	<a href="{concat(''|ezurl(no), $node.path_identification_string|wash, "/(dispnodeid)/", $Nodes.item.node_id)}">
        {/if}
         		{$Nodes.item.name}</a>
        </td>

        {* Class type *}
        <td class="class">{$Nodes.item.class_name|wash()}</td>

  </tr>
		{/let}
	{/section}
</form>
</table>
</div>

