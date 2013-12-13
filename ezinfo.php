<?php
/**
 * File containing newsletterInfo class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 */
/**
 * Class description here
 *
 * @version //autogentag//
 * @package newsletter
 */
class newsletterInfo
{
    // set manually - is used in email header, and in file header @version
    const SOFTWARE_VERSION = '1.0.0.201102111706';

    static function info()
    {
        return array( 'Name'             => ' Newsletter - Multi Channel Marketing',
                      'Version'          => self::SOFTWARE_VERSION,
                      'eZ version'       => '4.x',
                      'Copyright'        => '(C) 2007-' . date( 'Y' ) . ' <a href="http://www.-network.com"> Network</a> [ <a href="http://www.coolscreen.de">coolscreen.de - enterprise internet</a> &amp; <a href="http://www.jac-systeme.de">JAC Systeme</a> &amp; <a href="http://www.webmanufaktur.ch">Webmanufaktur</a> ]',
                      'License'          => 'GNU General Public License v2.0',
                      'More Information' => '<a href="http://projects.ez.no/newsletter">http://projects.ez.no/newsletter</a>'
                    );
    }

    /**
     * get some additional infos about the newsletter
     * for future use
     */
    static function packageInfo()
    {
        $infoArray = array();
        $infoArray[ 'release_version' ] = '//release_version//';

        // is set when building the package
        $infoArray[ 'release_svn_revision' ] = '//release_svn_revision//';
        return $infoArray;
    }
}
?>
