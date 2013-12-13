<?php
/**
 * File containing the NewsletterUtils class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 * @filesource
 */
/**
 * class with some useful functions
 *
 * @version //autogentag//
 * @package newsletter
 */
class NewsletterUtils extends eZPersistentObject
{

    function __construct(){ }

    /**
     * generate a unique hash md5
     *
     * @param string $flexibleVar is used as a part of string for md5
     * @return string md5
     */
    static function generateUniqueMd5Hash( $flexibleVar = '' )
    {
        $stringForHash = $flexibleVar. '-'. microtime( true ). '-' . mt_rand(). '-' . mt_rand();
        return md5( $stringForHash );
    }
}

?>