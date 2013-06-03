<?php
/**
 * File containing the CjwNewsletterUser class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version 1.0.0rc1
 * @package cjw_newsletter
 * @filesource
 */
/**
 * Data management datatyp cjwnewsletterlist
 *
 * @version 1.0.0rc1
 * @package cjw_newsletter
 */

require_once( 'kernel/common/i18n.php' );

class CjwNewsletterUserSearch extends CjwNewsletterUser
{

    /**
     * user search
     *
     * @param string $searchStr
     * @param string $logic (OR ou AND)
     * @param integer $limit
     * @param integer $offset
     * @param boolean $sortBy
     * @param boolean $asObject
     * @return array
     */
    public static function userSearch( $searchStr, $logic='AND', $limit=0, $offset=0, $sortBy = false, $asObject = true )
    {
        if ( $sortBy == false && !is_array( $sortBy ))
        {
            $sortArr = array( 'created' => 'desc' );
        }
        else
        {
            $sortArr = $sortBy;
        }
        
        // Sécurité : on évite les injections SQL
        if(!($logic=='OR'||$logic=='AND')) {
        	$logic='OR';
        }
        
        $limitArr = null;
        $customConds = null;
        if ( !empty($searchStr) )
        {
            $db = eZDB::instance();
            $strArray=explode(' ',$searchStr);
            $customConds = " WHERE ";
            $customCondsArray=array();
            foreach($strArray as $str) {
            	$str=$db->escapeString( $str );
            	$customCondsArray[] = " (email like '%$str%' OR first_name like '%$str%' OR last_name like '%$str%') ";
            }
            $customConds.=implode($logic,$customCondsArray);
        }

        if ( (int) $limit != 0 )
        {
            $limitArr = array( 'limit' => $limit, 'offset' => $offset );
        }
        $objectList = eZPersistentObject::fetchObjectList(
                                                    self::definition(),
                                                    null,
                                                    array( ),
                                                    $sortArr,
                                                    $limitArr,
                                                    $asObject,
                                                    null,
                                                    null,
                                                    null,
                                                    $customConds );
        return $objectList;
    }

}

?>
