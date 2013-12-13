<?php
/**
 * File containing the NewsletterList class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 * @filesource
 */
/**
 * Data management datatyp newsletterlist
 *
 * @version //autogentag//
 * @package newsletter
 */

require_once( 'kernel/common/i18n.php' );

class NewsletterList extends eZPersistentObject
{

    /**
     * Initializes a new GeoadressData alias
     *
     * @param unknown_type $row
     * @return void
     */
    function NewsletterList( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    /**
     * @return void
     */
    static function definition()
    {
        return array( 'fields' => array( 'contentobject_attribute_id' => array( 'name' => 'ContentObjectAttributeId',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'contentobject_attribute_version' => array( 'name' => 'ContentObjectAttributeVersion',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'contentobject_id' => array( 'name' => 'ContentObjectId',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'contentclass_id' => array( 'name' => 'ContentClassId',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),

                                         'main_siteaccess' => array( 'name' => 'MainSiteAccess',
                                                                   'datatype' => 'string',
                                                                   'default' => '',
                                                                   'required' => true ),
                                         'siteaccess_array_string' => array( 'name' => 'SiteAccessArrayString',
                                                                   'datatype' => 'string',
                                                                   'default' => '',
                                                                   'required' => true ),
                                         'output_format_array_string' => array( 'name' => 'OutputFormatArrayString',
                                                                   'datatype' => 'string',
                                                                   'default' => '0',
                                                                   'required' => true ),
                                         'email_sender_name' => array( 'name' => 'EmailSenderName',
                                                                   'datatype' => 'string',
                                                                   'default' => '',
                                                                   'required' => false ),
                                         'email_sender' => array( 'name' => 'EmailSender',
                                                                   'datatype' => 'string',
                                                                   'default' => '',
                                                                   'required' => true ),
                                         'email_receiver_test' => array( 'name' => 'EmailReceiverTest',
                                                                   'datatype' => 'string',
                                                                   'default' => '',
                                                                   'required' => false ),
                                         'auto_approve_registered_user' => array( 'name' => 'AutoApproveRegisterdUser',
                                                                  'datatype' => 'integer',
                                                                  'default' => 0,
                                                                  'required' => true ),
                                         'skin_name' => array( 'name' => 'SkinName',
                                                                  'datatype' => 'string',
                                                                  'default' => 'default',
                                                                  'required' => true ),
                                         'personalize_content' => array( 'name' => 'PersonalizeContent',
                                                                  'datatype' => 'integer',
                                                                  'default' => 0,
                                                                  'required' => false ),
                                         'user_data_fields' => array( 'name' => 'UserDataFields',
                                                                  'datatype' => 'string',
                                                                  'default' => '',
                                                                  'required' => false ),

                                                                    ),
                      'keys' => array( 'contentobject_attribute_id', 'contentobject_attribute_version' ),
                      'function_attributes' => array( 'is_valid' => 'isValid',
                                                      'output_format_array' => 'getOutputFormatArray',
                                                      'siteaccess_array' => 'getSiteaccessArray',
                                                      'user_count' => 'getUserCount',
                                                      'user_count_statistic' => 'getUserCountStatistic',
                                                      'available_siteaccess_list' => 'getAvailableSiteAccessList',
                                                      'available_skin_array' => 'getAvailableSkinArray'

                                                       ),
                      'class_name' => 'NewsletterList',
                      'name' => 'nl_list' );
    }

    /**
     * (non-PHPdoc)
     * @see kernel/classes/eZPersistentObject#attribute($attr, $noFunction)
     */
    function attribute( $attr, $noFunction = false )
    {
        switch ( $attr )
        {
            case 'to_string':
                {
                    return $this->toString();
                } break;
            default:
                return eZPersistentObject::attribute( $attr );
        }
    }

    /**
     * @todo fill the function
     * @return boolean
     */
    function isValid()
    {
        // todo
        return true;
    }

    // fetch funktionen
    // ######################################

    /**
     * Used in datatype newsletter_list
     *
     * @param integer $attributeId
     * @param unknown_type $version
     * @return array
     */
    static function fetch( $attributeId, $version )
    {
        $objectList = eZPersistentObject::fetchObjectList(
                        NewsletterList::definition(),
                        null,
                        array( 'contentobject_attribute_id' => $attributeId,
                               'contentobject_attribute_version' => $version  ),
                        null,
                        null,
                        true
                        );

        if ( count( $objectList ) > 0 )
            return $objectList[0];
    }

    /**
     * Return array with  id => name combination for outputformats
     *
     * @return unknown_type
     */
    static function getAvailableOutputFormatArray( )
    {

        return array( '0' => ezpI18n::tr( 'newsletter/outputformat', 'HTML' ) ,
                      '1' => ezpI18n::tr( 'newsletter/outputformat', 'Text' )
                    );
    }

    /**
     *
     * @return array
     */
    function getAvailableSkinArray()
    {
        $NewsletterIni = eZINI::instance('newsletter.ini');
        $availableSkinArray = $NewsletterIni->variable('NewsletterSettings', 'AvailableSkinArray' );

        return $availableSkinArray;
    }

    /**
     * Returns available outputformats as array
     * zb. array['0'] = 'html'
     *
     * @return array
     */
    function getOutputFormatArray()
    {
        $availableOutputFormatArray = NewsletterList::getAvailableOutputFormatArray();
        $outputFormatArray = NewsletterList::stringToArray( eZPersistentObject::attribute( 'output_format_array_string' ) );

        $newOutputFormatArrayWithNames = array();
        foreach ( $outputFormatArray as $outputFormatId )
        {
            if ( array_key_exists( $outputFormatId, $availableOutputFormatArray ) )
                $newOutputFormatArrayWithNames[ $outputFormatId ] = $availableOutputFormatArray[ $outputFormatId ];
        }
        return $newOutputFormatArrayWithNames;
    }

    /**
     *
     * @return array
     */
    function getSiteaccessArray()
    {
        return $this->stringToArray( eZPersistentObject::attribute( 'siteaccess_array_string' ) );
    }

    /**
     *
     * @return array
     */
    function getSiteaccessSiteIniArray()
    {
        $siteAccessArray = $this->attribute('siteaccess_array');
        $siteAccessIniArray = array();

        foreach ( $siteAccessArray as $siteAccessName )
        {
            $siteAccessIniArray[ $siteAccessName ] = $this->getSitIniObjectBySiteAccessName( $siteAccessName );
        }

        return $siteAccessIniArray;
    }

     /**
     * Return array of list subscribers groub by status
     *
     * @return array
     */
    function getUserCountStatistic()
    {
        $userCountStatisticArray = NewsletterSubscription::fetchSubscriptionListStatistic( $this->attribute('contentobject_id') );
        return $userCountStatisticArray;
    }

    /**
     * Return count of alle subribed users
     *
     * @return unknown_type
     */
    function getUserCount()
    {
        $userCount = NewsletterSubscription::fetchSubscriptionListByListIdCount( $this->attribute('contentobject_id') );
        return $userCount;
    }

    /**
     * Returns current siteaccess + language-info + siteURL
     *
     * @return array
     */
    function getAvailableSiteaccessList()
    {
        $ini = eZINI::instance( 'site.ini' );
        $availableSiteAccessListArray = $ini->variable('SiteAccessSettings', 'AvailableSiteAccessList' );
        $availableSiteAccessListInfoArray = array();

        foreach ( $availableSiteAccessListArray as $siteAccessName )
        {
            $siteIni = $this->getSiteIniObjectBySiteAccessName( $siteAccessName );
            $locale = '-';
            $siteUrl = '-';
            if ( is_object( $siteIni ) )
            {
                $locale = $siteIni->variable( 'RegionalSettings', 'Locale' );
                $siteUrl = $siteIni->variable( 'SiteSettings', 'SiteURL' );
            }
            $availableSiteAccessListInfoArray[ $siteAccessName ] = array( 'name' => $siteAccessName,
                                                                          'locale' => $locale,
                                                                          'site_url' => $siteUrl );
        }

        return $availableSiteAccessListInfoArray;
    }

    /**
     *
     * @param string $siteAccess
     * @return object
     */
    function getSiteIniObjectBySiteAccessName( $siteAccess )
    {
        $iniObject = NULL;

        // $phpCli = 'php';
        $NewsletterIni = eZINI::instance('newsletter.ini');
        $phpCli = $NewsletterIni->variable('NewsletterSettings', 'PhpCli' );

        $cmd = "\"$phpCli\" extension/newsletter/bin/php/iniloader.php -s $siteAccess site.ini";

        // for WINDOWS replace   / => \
        $fileSep = eZSys::fileSeparator();
        $cmd = str_replace( '/', $fileSep, $cmd );

        eZDebug::writeDebug( "shell_exec( $cmd )", 'NewsletterList::getSiteIniObjectBySiteAccessName()' );

        $returnValue = shell_exec( escapeshellcmd( $cmd ) );
        $iniObject = unserialize( trim( $returnValue ) );
        return $iniObject;
    }

    /**
     * Convert array to string
     * ;$1;$2;$3;
     * for searching : begin and end is ";"
     * like %;$1;%
     *
     * @param array $array
     * @return string
     */
    static function arrayToString( $array )
    {
        return  ';' . implode( ';', $array ) . ';';
    }

    /**
     * Convert string to array
     * ;$1;$2;$3; to array( $1, $2, $3 )
     *
     * @param $string
     * @return unknown_type
     */
    static function stringToArray( $string )
    {
        return  explode( ';', substr( $string, 1, strlen( $string ) - 2 ) );
    }

}

?>
