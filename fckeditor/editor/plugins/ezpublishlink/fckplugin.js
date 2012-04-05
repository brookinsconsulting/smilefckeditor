// Register the related command. 
// RegisterCommand takes the following arguments: CommandName, DialogCommand 
// FCKDialogCommand takes the following arguments: CommandName, Dialog Title, Path to HTML file, Width, Height 
 
FCKCommands.RegisterCommand( 'ezpublishlink', new FCKDialogCommand( 'ezpublishlink', 'Insert eZPublish link',  
FCKPlugins.Items['ezpublishlink'].Path + 'fck_ezpublishlink.php?ezsiteaccess=' + FCK.Config["ezsiteaccess"] + '&ezobject=' + FCK.Config["ezobject"] + '&ezversion=' + FCK.Config["ezversion"], 700, 500 ) ) ; 

 
// Create the toolbar button. 
// FCKToolbarButton takes the following arguments: CommandName, Button Caption 
 
var oeZPublishLinkItem = new FCKToolbarButton( 'ezpublishlink', FCKLang.eZPublishLinkBtn ) ; 
oeZPublishLinkItem.IconPath = FCKPlugins.Items['ezpublishlink'].Path + 'ezpublishlink.gif' ; 
FCKToolbarItems.RegisterItem( 'ezpublishlink', oeZPublishLinkItem ) ; 
 
// The object used for all InsertLink operations. 
var FCKeZPublishLink = new Object() ; 
 
// Add a new InsertLink at the actual selection.  
// This function will be called from the HTML file when the user clicks the OK button. 
// This function receives the values from the Dialog 
 
FCKeZPublishLink.Add = function( object, caption ) 
{ 

FCK.InsertHtml("<a href='socle_relation_id_"+object+"'>" + caption + "</a>") ; 

return true ;
}
 
//End code 