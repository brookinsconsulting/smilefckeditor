<?php
//
// Copyright (C) 2005 Smile. All rights reserved.
//
// Authors:
//   Julian Roblin <julian.roblin@smile.fr>
//   Emmanuel Saracco <emmanuel.saracco@smile.fr>
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

	require_once 'lib/ezutils/classes/ezsys.php' ;
	require_once 'kernel/classes/datatypes/ezbinaryfile/ezbinaryfile.php' ;

  class StringOperators
  {
		var $db = null ;
	
    /*! Constructor  */
    function StringOperators()
    {
      $this->Operators = array (
        'fckObjectIdConvert' 
      );
			
			if (!$this->db)
      {
        $ini =& eZINI::instance ();
        $server = $ini->variable ('DatabaseSettings', 'Server');
        $user = $ini->variable ('DatabaseSettings', 'User');
        $password = $ini->variable ('DatabaseSettings', 'Password');
        $database = $ini->variable ('DatabaseSettings', 'Database');

        $this->db =& eZDB::instance (false, array (
          'server' => $server,
          'user' => $user,
          'password' => $password,
          'database' => $database
        ), true);
      }
    }

    /*!Returns the operators in this class. */
    function &operatorList()
    {
      return $this->Operators;
    }

    /*!
     \return true to tell the template engine that the parameter list
    exists per operator type, this is needed for operator classes
    that have multiple operators.
    */
    function namedParameterPerOperator()
    {
      return true;
    }

    /*!
     The first operator has two parameters, the other has none.
     See eZTemplateOperator::namedParameterList()
    */
    function namedParameterList()
    {
      return array ( 
        'fckObjectIdConvert' => array (
	  'string1' => array (
	    'type' => 'string',
	    'required' => true,
            'default' => '' 
	  ) 
	)  
      );
    }

    /*!
     Executes the needed operator(s).
     Checks operator names, and calls the appropriate functions.
    */
    function modify (&$tpl, &$operatorName, &$operatorParameters, 
                     &$rootNamespace, &$currentNamespace, &$operatorValue, 
		     &$namedParameters)
    {		
		
      switch ( $operatorName )
      {
	case 'fckObjectIdConvert':
	  $operatorValue = $this->fckObjectIdConvert ($namedParameters['string1']);
	   break;
      }
    }

    /*!
     \Remove the tags and display normal text
    */
    function fckObjectIdConvert( $string1 )
    {
                        // preg_match_all('/href=".*socle_relation_id_([0-9]+)(\?.*)?(#.*)?"/Ui', $string1, &$matches);
                        // remplacé pour ne pas manger de lien (si plusieurs liens à la suite...)
			//preg_match_all('/href="[^"]*socle_relation_id_([0-9]+)(\?[^"]*)?(#[^"]*)?"/Ui', $string1, &$matches);
			preg_match_all('/href="[^"]*socle_relation_id_([0-9]+)(\?[^"]*)?(#[^"]*)?"/Ui', $string1, $matches);
			
			if (is_array($matches))
			{
				$count = count($matches[0]) ;
			
			  for ($cpt = 0 ; $cpt < $count ; $cpt++)
				{
					$string1 = str_replace($matches[0][$cpt], 'href="' . $this->getIdentificationStringPath($matches[1][$cpt]) . $matches[2][$cpt] . $matches[3][$cpt] .'"', $string1) ;
				}
			}
			
      return $string1;
    }
		
		/*!
		 get identification string path
		*/
		
		function getIdentificationStringPath($object_id)
		{				
			$result = null ;
		
			$object = eZContentObject::fetch($object_id) ;
			
			if (isset($object))
			{
				$class = eZContentClass::fetch($object->attribute('contentclass_id')) ;
			
				$index_dir = str_replace('_admin_', '_user_', eZSys::indexDir()) ;
			
				if ($class->attribute('identifier') == 'file')
				{
						$attribute_list = $object->contentObjectAttributes() ;
						
						$attribute = array_pop($attribute_list) ;
				
						$binary_file = eZBinaryFile::fetch($attribute->attribute('id'), $attribute->attribute('version')) ;
				
				    $url	= $index_dir
				    			. '/content/download/'
									. $object_id
									. '/'
									. $attribute->attribute('id')
									. '/'
									. $binary_file->attribute('original_filename') ;
				}
				else
				{
					$sql = 
			
						'
							SELECT
								path_identification_string
							FROM
								ezcontentobject_tree
							WHERE
								contentobject_id = ' . $object->attribute('id') . '
							AND
								contentobject_version = ' . $object->attribute('current_version') . '
						'
					;
				
					$result = array_pop($this->db->arrayQuery($sql)) ;
				
					if (isset($result['path_identification_string']))
					{
						$url	= $index_dir
									. '/'
									. $result['path_identification_string'] ; 
					}
					else
					{
						$url	= '' ;
					}	
				}

				$db =& eZDB::instance();
			
				$query = 
			
				'
					SELECT
						data_text
					FROM
						ezcontentclass_attribute, ezcontentobject_attribute
					WHERE
						ezcontentclass_attribute.identifier LIKE \'webtrend_url_param\'
					AND
						ezcontentclass_attribute.id = ezcontentobject_attribute.contentclassattribute_id
					AND
						contentobject_id = ' . $object_id . '
					AND
						ezcontentclass_attribute.version = 0
					AND
						ezcontentobject_attribute.version = ' . $object->attribute('current_version') . '
					
				'
				;
			
				$result = $db->arrayQuery($query) ;
			
				if (isset($result[0]['data_text']) && !empty($result[0]['data_text']))
				{
					if (strpos($url, '?') === false)
					{
						$url .= '?' . $result[0]['data_text'] ;
					}
					else
					{
						$url .= '&' . $result[0]['data_text']  ;
					}
				}
				
				return $url ;
			}
			
			return $result ;
			
		}

    /// \privatesection
    var $Operators;
  }
?>