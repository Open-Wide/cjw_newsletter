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


class CjwNewsletterTrackingGmail extends CjwNewsletterTracking
{

	protected function getClicMarker () {
		if ( $this->ini->hasVariable( 'NewsletterTracking', 'ClicMarker' )) {
			$marker = $this->ini->variable( 'NewsletterTracking', 'ClicMarker' );
			$marker = $this->replacePlaceholders( $marker );
			return $marker;
		} else {
			return '';
		}
	}
	
	protected function getReadMarker () {
		if ( $this->ini->hasVariable( 'NewsletterTracking', 'ReadMarker' )) {
			$marker = $this->ini->variable( 'NewsletterTracking', 'ReadMarker' );
			$marker = $this->replacePlaceholders( $marker );
			return $marker;
		} else {
			return '';
		}
	}


}

?>
