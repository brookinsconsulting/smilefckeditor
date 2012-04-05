<?php
//
// Copyright (C) 2005 Smile. All rights reserved.
//
// Authors:
//   Emmanuel Saracco <emmanuel.saracco@smile.fr>
//	 Julian Roblin <julian.roblin@smile.fr>
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// Licencees holding a valid "eZ publish professional licence" version 2
// may use this file in accordance with the "eZ publish professional licence"
// version 2 Agreement provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" version 2 is available at
// http://ez.no/ez_publish/licences/professional/ and in the file
// PROFESSIONAL_LICENCE included in the packaging of this file.
// For pricing of this licence please contact us via e-mail to licence@ez.no.
// Further contact information is available at http://ez.no/company/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//

  include_once( "lib/ezutils/classes/ezdebug.php" );
  include_once ('lib/ezdb/classes/ezdb.php');
	include_once ('lib/ezfile/classes/ezfile.php');
	include_once ('extension/smilesocle/modules/smilesocle/functions.php');

  class smileFCKEditorDB
  {
    var $db = null;
		var $db_site_select = null ;
		var $db_site_update = null ;
		var $db_source = null ;
		var $db_target = null ;
		
    function smileFCKEditorDB ()
    {
      if (!$this->db)
      {
        $ini =& eZINI::instance ('module.ini.append.php', 
          'extension/smilesocle/settings');
        $server = $ini->variable ('SocleDatabaseSettings', 'Server');
        $user = $ini->variable ('SocleDatabaseSettings', 'User');
        $password = $ini->variable ('SocleDatabaseSettings', 'Password');
        $database = $ini->variable ('SocleDatabaseSettings', 'Database');

        $this->db =& eZDB::instance (false, array (
          'server' => $server,
          'user' => $user,
          'password' => $password,
          'database' => $database
        ), true);
      }
    }
		
		function smileGetRelatedObjects($object, $version)
		{			
				$result = array() ;
							
				$related_object = eZContentObject::relatedContentObjectArray($version, $object) ;
				
				if (is_array($related_object))
				{
				    foreach ($related_object as $object)
						{
							$property['id'] = $object->attribute('id') ;
							$property['name'] = $object->attribute('name') ;
							$property['class_name'] = $object->attribute('class_name') ;
							
							array_push($result, $property) ;
						}
				}
				
				return $result ;
		}
	}
?>
