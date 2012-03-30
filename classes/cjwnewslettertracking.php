<?php
/**
 * File containing the CjwNewsletterList class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package cjw_newsletter
 * @filesource
 */
/**
 * Data management datatyp cjwnewsletterlist
 *
 * @version //autogentag//
 * @package cjw_newsletter
 */

//require_once( 'kernel/common/i18n.php' );


/*$html = "
<html>
	<body>
		<a href='http://www.toto.fr/niarf/grpoj.php'>Test</a>
		<a href='http://www.toto.fr/niarf/grpoj.php#ancre'>Test</a>
		<a href='http://www.toto.fr/niarf/grpoj.php?param=oihg&stamp=gfe'>Test</a>
		<a href='http://www.toto.fr/niarf/grpoj.php?param=oihg&stamp=gfe#ancre'>Test</a>
	</body>
</html>
";

echo $html;
echo "
-----------------------------------------------------------------
";
//$html = CjwNewsletterTracking::insertClicMarkers( $html, $clicMarker, 'param' );
//$html = CjwNewsletterTracking::insertMarkers( $html );
$CjwNewsletterTracking = new CjwNewsletterTracking();
$html = $CjwNewsletterTracking_>insertMarkers( $html );

echo $html;
echo "
-----------------------------------------------------------------
";*/


class CjwNewsletterTracking
{
	
	//const DEFAULT_CLIC_MARKER_TYPE = "param";
	
	//private $mode = "generic";
	protected $newsletterEditionSendObject = false;
	
	protected $newsletterUserObject = false;
	
	protected $editionContentObject = false;
	
	protected $html = false;
	
	protected $ini = false;
	
	
	public function __construct( $editionContentObject=false, $newsletterUserObject=false ) {
		
		$this->ini = eZINI::instance( 'cjw_newsletter.ini' );
		
		$this->setEditionContentObject( $editionContentObject );
		
		$this->setNewsletterUserObject( $newsletterUserObject );

	}
	
	public function insertMarkers ( $html ) {

		$html = $this->insertClicMarkers( $html, $this->getClicMarker(), $this->getClicMarkerType() );
														   
		$html = $this->insertReadMarker( $html, $this->getReadMarker() );
		
		return $html;
		
	}
	
	protected function insertClicMarkers ( $html, $clicMarker, $clicMarkerType = "param" ) {
		
		switch ( $clicMarkerType ) {
	    	case 'anchor':
	            $linkSearchPattern = '#(href)=("|\')(?!mailto)([^\'"]*)("|\')#';
	            $linkReplacePattern = '$1="$3#'.$clicMarker.'"';
	    		break;
	    		
	    	case 'param':
	    		/* 1. Url contenant une ancre et des paramètres
	    		 * 2. Url contenant une ancre sans paramètres
	    		 * 3. Url contenant des paramètres sans ancre
	    		 * 4. Url sans ancre ni paramètre
	    		 */
	    		$linkSearchPattern = array('#(href)=("|\')(?!mailto)([^\'"]*\?[^\'"]*)(\#[^\?"\']*)("|\')#',
	    		                           '#(href)=("|\')(?!mailto)([^\?"\']*)(\#[^\?"\']*)("|\')#',
	    		                           '#(href)=("|\')(?!mailto)([^\#\'"]*\?[^\#\'"]*)("|\')#',
	                                       '#(href)=("|\')(?!mailto)([^\#\?"\']*)("|\')#');
	    		
	            $linkReplacePattern = array('$1="$3&'.$clicMarker.'$4"',
	                                        '$1="$3?'.$clicMarker.'$4"',
	                                        '$1="$3&'.$clicMarker.'"',
	                                        '$1="$3?'.$clicMarker.'"');
	            
	    		break;
	    		
	    	default:
	    		return $html;
	    }
	    
	    $output = preg_replace( $linkSearchPattern, $linkReplacePattern, $html );
		
		return $output;
	}
	
	protected function replacePlaceholders ( $marker ) {
		
		$searchArray = array( '{{LIST_ALIAS}}',
	                          '{{NL_ALIAS}}',
	                          '{{USER}}'
	                         );
	    $replaceArray = array( $this->getListAlias(),
	                           $this->getNlAlias(),
	                           $this->getUser()
	                          );
	
	    /******************************************************
	     * Remplacement des blocks "{{.*}}" dans les marqueurs
	     ******************************************************/ 
	    $contentObjectTimestamp = time();	
    	// Blocks simples
        $marker = str_replace( $searchArray, $replaceArray, $marker );
        
        // Blocks dates
        preg_match_all('#{{DATE=([^}]+)}}#',$marker,$dateArray); 
        foreach ($dateArray[1] as $dateFormat) {
        	$marker = str_replace( '{{DATE='.$dateFormat.'}}', date($dateFormat,$contentObjectTimestamp), $marker );
        }
        
    	// Blocks attributs
        preg_match_all('#{{ATTRIBUTE=([^}]+)}}#',$marker,$attrArray); 
        foreach ($attrArray[1] as $attrIdentifier) {
        	$marker = str_replace( '{{ATTRIBUTE='.$attrIdentifier.'}}', $this->getNlAttribute($attrIdentifier), $marker );
        }
        
        // Suppression des blocks non remplacés
        $marker = preg_replace( '#{{[^}]*}}#', '', $marker );
	    
	    return $marker;
	}
	
	protected function insertReadMarker ( $html, $readMarker ) {
		$output = str_replace( "</body>", $readMarker . "\n</body>", $html );
		return $output;
	}
	
	
	
	
	protected function setNewsletterUserObject ($newsletterUserObject) {
		if ( $newsletterUserObject instanceof CjwNewsletterUser ) {
			$this->newsletterUserObject = $newsletterUserObject;
			return true;
		} else {
			return false;
		}
	}
	
	protected function setEditionContentObject ($editionContentObject) {
		if ( $editionContentObject instanceof eZContentObject ) {
			$this->editionContentObject = $editionContentObject;
			return true;
		} else {
			return false;
		}
	}
	
	
	protected function getClicMarkerType () {
		if ( $this->ini->hasVariable( 'NewsletterTracking', 'ClicMarkerType' )) {
			return $this->ini->variable( 'NewsletterTracking', 'ClicMarkerType' );
		} else {
			return "param";
		}
	}
	
	protected function getClicMarker () {
		/*$marker = "date={{DATE=Y-m-d-H-i-s}}&toto={{ATTRIBUTE=toto}}&list_alias={{LIST_ALIAS}}&nl_alias={{NL_ALIAS}}&user={{USER}}";
		
		$marker = $this->replacePlaceholders( $marker );
		return $marker;*/
		
		if ( $this->ini->hasVariable( 'NewsletterTracking', 'ClicMarker' )) {
			$marker = $this->ini->variable( 'NewsletterTracking', 'ClicMarker' );
			$marker = $this->replacePlaceholders( $marker );
			return $marker;
		} else {
			return '';
		}
	}
	
	protected function getReadMarker () {
		/*$marker = "<img src='toto' />";
		$marker = $this->replacePlaceholders( $marker );
		return $marker;*/
		
		if ( $this->ini->hasVariable( 'NewsletterTracking', 'ReadMarker' )) {
			$marker = $this->ini->variable( 'NewsletterTracking', 'ReadMarker' );
			$marker = $this->replacePlaceholders( $marker );
			return $marker;
		} else {
			return '';
		}
	}
	
	protected function getListAlias() {
		if ( $this->editionContentObject instanceof eZContentObject ) {
			$path_array = explode( '/', $this->editionContentObject->MainNode()->PathIdentificationString );
			if (count( $path_array ) > 1) {
				return $path_array[ count( $path_array )-2 ];
			}
		}
		return '';
	}
	
	protected function getNlAlias() {
		if ( $this->editionContentObject instanceof eZContentObject ) {
			$path_array = explode( '/', $this->editionContentObject->MainNode()->PathIdentificationString );
			if (count( $path_array ) > 0) {
				return $path_array[ count( $path_array )-1 ];
			}
		}
		return '';
	}
	
	protected function getUser() {
		if ( $this->newsletterUserObject instanceof CjwNewsletterUser ) {
			return $this->newsletterUserObject->attribute('id');
		}
		return '';
	}
	
	protected function getNlAttribute( $identifier ) {
		if ( $this->editionContentObject instanceof eZContentObject ) {
			$dataMap = $contentObject->dataMap();
			if ($dataMap[$identifier]) {
				return $dataMap[$identifier]->DataText;
			}
		}
		return '';
	}

}

?>
