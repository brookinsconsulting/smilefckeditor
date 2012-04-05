<?php
	
	include_once ('lib/ezi18n/classes/eztextcodec.php') ;
	include_once ('lib/ezutils/classes/ezhttptool.php');	

	$http =& eZHTTPTool::instance();
	
	$ezobject = $http->getVariable('ezobject') ;
	$ezversion = $http->getVariable('ezversion') ;
	$ezsiteaccess = $http->getVariable('ezsiteaccess') ;
	
	$redirect = $ezsiteaccess . '/layout/set/fckeditor/smilefckeditor/insertlink/' . $ezobject . '/' . $ezversion  ;
	
	$http->redirect($redirect)	;
	
?>