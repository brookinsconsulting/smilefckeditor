//Begin Code
var SmileeZimage = function(name)
{
	this.name = name;
}

SmileeZimage.prototype.Execute = function()
{
}

SmileeZimage.prototype.GetState = function()
{
	return FCK_TRISTATE_OFF;
}

if (!FCKConfig.eZlinkURL) {
	if (FCKConfig['ezsiteaccess'])
		FCKConfig.eZlinkURL = FCKConfig['ezsiteaccess']+'/layout/set/mediabrowser/(dispnodeid)/43';
	else
		FCKConfig.eZlinkURL = '/layout/set/mediabrowser/(dispnodeid)/43';
}

// Register the related commands.
FCKCommands.RegisterCommand('SmileeZimage',new FCKDialogCommand(
        'SmileeZimage',
        'SmileeZimage',
        FCKConfig.eZlinkURL, 800, 400));

// Create the "eZimage" toolbar button.
var oeZimageItem = new FCKToolbarButton('SmileeZimage', 'SmileeZimage', null, false, true );
oeZimageItem.IconPath = FCKConfig.PluginsPath + 'SmileeZimage/ezimage.gif' ;

// 'eZimage' is the name used in the Toolbar config.
FCKToolbarItems.RegisterItem( 'SmileeZimage', oeZimageItem ) ;
