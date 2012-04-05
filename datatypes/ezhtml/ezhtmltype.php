<?php
//
// Copyright (C) 2005 Smile. All rights reserved.
//
// Authors:
//   Julian Roblin <julian.roblin@smile.fr>
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

include_once( "kernel/classes/ezdatatype.php" );
include_once ('lib/ezutils/classes/ezhttptool.php');
include_once ('lib/ezi18n/classes/eztextcodec.php');

define( 'EZ_DATATYPESTRING_EZHTML', 'ezhtml' );
define( 'EZ_DATATYPESTRING_EZHTML_COLS_FIELD', 'data_int1' );
define( 'EZ_DATATYPESTRING_EZHTML_COLS_VARIABLE', '_eztext_cols_' );

class ezhtmltype extends eZDataType
{
    /*!
      Constructor
    */
    function ezhtmltype()
    {
        $this->eZDataType( EZ_DATATYPESTRING_EZHTML, ezi18n('content', 'HTML fields'), array( 'serialize_supported' => true,
                                  'object_serialize_map' => array( 'data_text' => 'text' ) )  );
    }
	
    /*!
     Set class attribute value for template version
    */
    function initializeClassAttribute( &$classAttribute )
    {
        if ( $classAttribute->attribute( EZ_DATATYPESTRING_EZHTML_COLS_FIELD ) == null )
            $classAttribute->setAttribute( EZ_DATATYPESTRING_EZHTML_COLS_FIELD, 10 );
        $classAttribute->store();	
    }
	
    /*!
     Sets the default value.
    */
    function initializeObjectAttribute( &$contentObjectAttribute, $currentVersion, &$originalContentObjectAttribute )
    {
        if ( $currentVersion != false )
        {
            $dataText = $originalContentObjectAttribute->attribute( "data_text" );
            $contentObjectAttribute->setAttribute( "data_text", $dataText );
        }
        $contentClassAttribute =& $contentObjectAttribute->contentClassAttribute();
				
        if ( $contentClassAttribute->attribute( "data_int1" ) == 0 )
        {
            $contentClassAttribute->setAttribute( "data_int1", 10 );
            $contentClassAttribute->store();
        }
				
				
    }

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        return $this->validateAttributeHTTPInput( $http, $base, $contentObjectAttribute, false );
    }

    /*!
    */
    function validateCollectionAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        return $this->validateAttributeHTTPInput( $http, $base, $contentObjectAttribute, true );
    }
	
    /*!
    */
    function validateAttributeHTTPInput( &$http, $base, &$contentObjectAttribute, $isInformationCollector )
    {
        if ( $http->hasPostVariable( $base . '_data_text_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $data =& $http->postVariable( $base . '_data_text_' . $contentObjectAttribute->attribute( 'id' ) );
			
            $classAttribute =& $contentObjectAttribute->contentClassAttribute();

            if ( $isInformationCollector == $classAttribute->attribute( 'is_information_collector' ) )
            {
                if ( $classAttribute->attribute( "is_required" ) )
                {
                    if ( $data == "" )
                    {
                        $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                             'Input required.' ) );
                        return EZ_INPUT_VALIDATOR_STATE_INVALID;
                    }
                }
            }
        }
		
        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }
	
    /*!
     Fetches the http post var string input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $data =& $http->postVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) );
            
            $contentObjectAttribute->setAttribute( "data_text", $data );
            return true;
        }
        return false;
    }
    
    /*!
     Fetches the http post variables for collected information
    */
    function fetchCollectionAttributeHTTPInput( &$collection, &$collectionAttribute, &$http, $base, &$contentObjectAttribute )
    {
        $dataText =& $http->postVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) );
        $collectionAttribute->setAttribute( 'data_text', $dataText );

        return true;
    }

    /*!
     Store the content. Since the content has been stored in function 
     fetchObjectAttributeHTTPInput(), this function is with empty code.
    */
    function storeObjectAttribute( &$contentObjectattribute )
    {
    }
	
    /*!
     \reimp
     Simple string insertion is supported.
    */
    function isSimpleStringInsertionSupported()
    {
        return true;
    }

    /*!
     \reimp
     Inserts the string \a $string in the \c 'data_text' database field.
    */
    function insertSimpleString( &$object, $objectVersion, $objectLanguage,
                                 &$objectAttribute, $string,
                                 &$result )
    {
        $result = array( 'errors' => array(),
                         'require_storage' => true );
        $objectAttribute->setContent( $string );
        $objectAttribute->setAttribute( 'data_text', $string );
		
        return true;
    }

    /*!
     Returns the content.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( "data_text" );
    }
	
	function fetchClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        $column = $base .EZ_DATATYPESTRING_EZHTML_COLS_VARIABLE . $classAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( $column ) )
        {
            $columnValue = $http->postVariable( $column );
            $classAttribute->setAttribute( EZ_DATATYPESTRING_EZHTML_COLS_FIELD,  $columnValue );
            return true;
        }
        return false;
    }

    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
    	$data = $contentObjectAttribute->attribute( "data_text" );
    	/*Recuperation du codec de texte*/
        $codec = eztextcodec::instance( 'iso-8859-1');
        
        /*Remplacer les balises par des espaces*/
        $data = str_replace("<", " <", $data);
        $data = str_replace(">", "> ", $data);
        $data = strip_tags($data);
        
        /*Remplacement des valeurs numeriques*/
        $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $data);
		$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);

		/*Traduction de la table de traduction avec le codec de texte*/
        $trans = get_html_translation_table(HTML_ENTITIES);
        $trans = array_flip($trans);
        foreach ($trans as $key => $val)
        {
        	$trans[$key]= $codec->convertString($val);
        }
        
        /*Remplacement des entites via la table de traduction*/
        $temp = strtr($string, $trans);
		eZDebug::writeDebug($temp, "indexation-utf8");
   			
        return $temp;
    }

    /*!
     Returns the value as it will be shown if this attribute is used in the object name pattern.
    */
    function title( &$contentObjectAttribute )
    {
		
		
        return $contentObjectAttribute->attribute("data_text");
    }

    /*!
     \return true if the datatype can be indexed
    */
    function isIndexable()
    {
        return true;
    }
	
    /*!
     \reimp
    */
    function &serializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $textColumns = $classAttribute->attribute( EZ_DATATYPESTRING_EZHTML_COLS_FIELD );
        $attributeParametersNode->appendChild( eZDOMDocument::createElementTextNode( 'text-column-count', $textColumns ) );
    }

    /*!
     \reimp
    */
    function &unserializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $textColumns = $attributeParametersNode->elementTextContentByName( 'text-column-count' );
        $classAttribute->setAttribute( EZ_DATATYPESTRING_EZHTML_COLS_FIELD, $textColumns );
    }
    
    /*!
     \reimp
    */
    function diff( $old, $new, $options = false )
    {
        include_once( 'lib/ezdiff/classes/ezdiff.php' );
        $diff = new eZDiff();
        $diff->setDiffEngineType( $diff->engineType( 'text' ) );
        $diff->initDiffEngine();
        $diffObject = $diff->diff( $old->content(), $new->content() );
        return $diffObject;
    }
    
}

eZDataType::register( EZ_DATATYPESTRING_EZHTML, "ezhtmltype" );
?>
