<?php
/**
 * newsletter Operator autoloading
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag// | $Id: $
 * @package newsletter
 * @subpackage operators
 * @filesource
 */

$eZTemplateOperatorArray = array();

// $text|newsletter_preg_replace( $search_string, $replace_string )
$eZTemplateOperatorArray[] = array( 'script' => 'extension/newsletter/autoloads/newsletteroperators.php',
                                    'class' => 'NewsletterOperators',
                                    'operator_names' => array( 'newsletter_preg_replace', 'newsletter_str_replace', 'newsletter_variable' ) );

?>
