#?ini charset="iso-8859-1"?
# eZ publish configuration file for layout module
#
# NOTE: It is not recommended to edit this files directly, instead
#       a file in override should be created for setting the
#       values that is required for your site. Either create
#       a file called settings/override/layout.ini.append or
#       settings/override/layout.ini.append.php for more security
#       in non-virtualhost modes (the .php file may already be present
#       and can be used for this purpose).
#
# Consists of groups which are the layout name
# A layout group can have the followin variables
# - PageLayout - Uses a different pagelayout for this page
# - SiteDesign - Uses a different sitedesign for this page

[fullscreen]
PageLayout=fullscreen_pagelayout.tpl

[pop_up]
PageLayout=popup_pagelayout.tpl

[print]
PageLayout=print_pagelayout.tpl

[mediabrowser]
PageLayout=pagelayout_mediabrowser.tpl

