<?php

/*!
  \class   SmileLinktomedia smilelinktomedia.php
  \ingroup eZTemplateOperators
  \brief   Prend en charge l'op�rateur de template linktomedia qui transforme une cha�ne de type "smileobject://12" en lien vers la source de l'objet 12
  \version 1.0
  \date    12 Octobre 2005 3:39:24 pm
  \author  Guillaume Boit

*/

include_once("kernel/classes/ezcontentobjecttreenode.php");
include_once("kernel/classes/ezcontentobject.php");

class SmileLinktomedia
{
    /*!
      Constructeur, par d�faut ne fait rien.
    */
    function SmileLinktomedia()
    {
       $this->Operators = array( 'linktomedia', 'linktopicture');
    }

    /* Return an array with the template operator name.
    */
    function &operatorList()
    {
        return $this->Operators;
    }
    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }    
    
    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array('linktomedia' => array('lien' => array('type' => 'string', 'required' => true, 'default' => '')), 
					 'linktopicture' => array('lien' => array('type' => 'string', 'required' => true, 'default' => ''),
											  'chemin' => array('type' => 'string', 'required' => false, 'default' => '')
											 ) 
					);
    }
    /*!
     Ex�cute la fonction PHP correspondant � l'op�rateur "cleanup" et modifie \a $operatorValue.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        // Exemple de code, ce code doit �tre modifi� pour que l'op�rateur fasse ce qu'il doit faire. Actuellement il effectue juste un "trim" du texte.
        switch ( $operatorName )
        {
            case 'linktomedia':
            {
				$operatorValue=	$this->linkToMedia($operatorValue);
            } break;
            
            case 'linktopicture':
            {
            	$operatorValue = $this->linkToPicture( $namedParameters['lien'], $namedParameters['chemin'] );
            } break;
        }
    }
    
    function linkToMedia($lien)
    {
    	return $this->linkToPicture($lien, '');
    }
    
    function linkToPicture($lien, $chemin)
    {
    	//eZDebug::writeDebug($lien);
    	//eZDebug::writeDebug($chemin);
    	if ($chemin == '') 
    	{
    		$chemin = '/';	
    	}
    	$expleznode = explode("smileobject://", $lien);
		$iterator = 0;
		foreach ($expleznode as $segmeznode) {
			if ($iterator != 0) { //on parcourt les segments commen�ant par des num�ros de noeuds
				$explnumeroarray = explode('"', $segmeznode);
				$explnumero = $explnumeroarray[0];
				$noeud =& eZContentObjectTreeNode::fetch($explnumero);
				if($noeud){
					$data_map = $noeud->attribute('data_map');
					switch($noeud->attribute('class_identifier')) {
						case 'image':
						{
							$attributes = $data_map['image']->content();
							$originalpic=$attributes->attribute('original');
							$uri = eZSys::wwwDir().'/'.$originalpic['full_path'];
						}break;
						case 'lien':
						{
							$attributes = $data_map['location']->content();
							$uri = $attributes;
						}break;
						case 'file':
						case 'flash':
						{
							$object_id = $noeud->attribute('contentobject_id');
							$version = $noeud->attribute('contentobject_version_object');
							$attribute = $data_map['file']->content();
							$attribute_id = $attribute->attribute('contentobject_attribute_id');
							$uri = eZSys::indexDir().'/content/download/'.$object_id.'/'.$attribute_id.'/file';
						}break;
						default: //URL vers le noeud cible
						{
							$uri = eZSys::indexDir().'/'.$noeud->attribute('path_identification_string');
						}
					}
					$explnumeroarray[0]=$uri;
					$expleznode[$iterator]=implode('"', $explnumeroarray);
				}
				else { //le n�ud n'existe plus

					$finbalise = strpos('>', $explnumeroarray[1])+1;
					$explnumeroarray[1] = substr($explnumeroarray[1], $finbalise);
					array_shift($explnumeroarray);//suppression de la fin de la balise contenant le lien
					$expleznode[$iterator]=implode('"', $explnumeroarray);

					$debutbalise = strrpos($expleznode[$iterator-1], '<');
					$debut = substr($expleznode[$iterator-1], 0, $debutbalise); //suppresion du d�but de la balise
					$expleznode[$iterator-1] = $debut;

					//remarque : les fermeture de balise (</a>) restent dans le code.
				}

			}
			$iterator++;
		}
		
		return implode('', $expleznode);
    	
    }

	function ezurl($url,$quotes)
	{
	    if ( preg_match( "#^[a-zA-Z0-9]+:#", $url ) or
	         substr( $url, 0, 2 ) == '//' )
	    {
	        /* Do nothing */
	    }
	    else
	    {
	        if ( strlen( $url ) > 0 && $url[0] == '#' )
	        {
	            $url = htmlspecialchars( $url );
	        }
	        else
	        {
	            if ( strlen( $url ) == 0 )
	            {
	                $url = '/';
	            }
	            else if ( $url[0] != '/' )
	            {
	                $url = '/' . $url;
	            }

	            $url = eZSys::indexDir() . $url;
	            $url = preg_replace( "#(//)#", "/", $url );
	            $url = preg_replace( "#^(.+)(/+)$#", '$1', $url );
	            $url = htmlspecialchars( $url );
	        }
	    }
	    $url = $this->applyQuotes( $url, $quotes );

	    return $url;
	}



    
    var $Operators;
}

?>