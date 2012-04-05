//Begin Code
var SmileeZlink = function(name)
{
	this.name = name;
}

SmileeZlink.prototype.Execute = function()
{

}

SmileeZlink.prototype.GetState = function()
{
	return FCK_TRISTATE_OFF;
}

if (!FCKConfig.eZimageURL) {
	if (FCKConfig['ezsiteaccess'])
		FCKConfig.eZimageURL = FCKConfig['ezsiteaccess']+'/layout/set/mediabrowser/(dispnodeid)/2';
	else
		FCKConfig.eZimageURL = '/layout/set/mediabrowser/(dispnodeid)/2';
}

// Register the related commands.
FCKCommands.RegisterCommand('SmileeZlink',new FCKDialogCommand(
        'SmileeZlink',
        'SmileeZlink',
        FCKConfig.eZimageURL, 800, 400));

// Create the "eZlink" toolbar button.
var oeZlinkItem = new FCKToolbarButton('SmileeZlink', 'SmileeZlink', null, false, true );
oeZlinkItem.IconPath = FCKConfig.PluginsPath + 'SmileeZlink/ezlink.gif' ;

// 'eZlink' is the name used in the Toolbar config.
FCKToolbarItems.RegisterItem( 'SmileeZlink', oeZlinkItem ) ;
