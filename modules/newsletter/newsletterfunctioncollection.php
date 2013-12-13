<?php
/**
 * File containing the NewsletterFunctionCollection class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 * @subpackage modules
 * @filesource
 */
/**
 * Class description here
 *
 * @version //autogentag//
 * @package newsletter
 * @subpackage modules
 */
class NewsletterFunctionCollection
{
    /**
     * Constructor
     *
     * @return void
     */
    function NewsletterFunctionCollection()
    {

    }

    /**
     * @param integer $listContentobjectId
     * @param integer $limit
     * @param integer $offset
     * @param boolean $asObject
     * @return array
     */
    static function fetchSubscriptionList( $listContentobjectId, $status, $limit, $offset, $asObject )
    {
        $statusId = false;

        switch( $status )
        {
            case 'pending':
                $statusId = NewsletterSubscription::STATUS_PENDING;
                break;
            case 'confirmed':
                $statusId = NewsletterSubscription::STATUS_CONFIRMED;
                break;
            case 'approved':
                $statusId = NewsletterSubscription::STATUS_APPROVED;
                break;
            case 'removed':
                $statusId = array( NewsletterSubscription::STATUS_REMOVED_ADMIN, NewsletterSubscription::STATUS_REMOVED_SELF );
                break;
            case 'bounced':
                $statusId = array( NewsletterSubscription::STATUS_BOUNCED_SOFT, NewsletterSubscription::STATUS_BOUNCED_HARD );
                break;
            case 'blacklisted':
                $statusId = NewsletterSubscription::STATUS_BLACKLISTED;
                break;
            default:
                break;

        }

        $objectList = NewsletterSubscription::fetchSubscriptionListByListId( $listContentobjectId, $statusId, $limit, $offset, $asObject );

        return array( 'result' => $objectList );
    }

    /**
     *
     * @param integer $listContentobjectId
     * @return array
     */
    static function fetchSubscriptionListCount( $listContentobjectId, $status )
    {
        $statusId = false;

        switch( $status )
        {
            case 'pending':
                $statusId = NewsletterSubscription::STATUS_PENDING;
                break;
            case 'confirmed':
                $statusId = NewsletterSubscription::STATUS_CONFIRMED;
                break;
            case 'approved':
                $statusId = NewsletterSubscription::STATUS_APPROVED;
                break;
            case 'removed':
                $statusId = array( NewsletterSubscription::STATUS_REMOVED_ADMIN, NewsletterSubscription::STATUS_REMOVED_SELF );
                break;
            case 'bounced':
                $statusId = array( NewsletterSubscription::STATUS_BOUNCED_SOFT, NewsletterSubscription::STATUS_BOUNCED_HARD );
                break;
            case 'blacklisted':
                $statusId = NewsletterSubscription::STATUS_BLACKLISTED;
                break;
            default:
                break;

        }

        $objectCount = NewsletterSubscription::fetchSubscriptionListByListIdCount( $listContentobjectId, $statusId );
        return array( 'result' => $objectCount );
    }

    /**
     * fetch all subscriptions with import_id
     * @param integer $importId
     * @param integer $limit
     * @param integer $offset
     * @param boolean $asObject
     * @return array
     */
    static function fetchImportSubscriptionList( $importId, $limit, $offset, $asObject )
    {
        $objectList = NewsletterSubscription::fetchSubscriptionListByImportId( $importId, $limit, $offset, $asObject );

        return array( 'result' => $objectList );
    }

    /**
     * count all subscriptions with import_id
     * @param integer $importId
     * @return array
     */
    static function fetchImportSubscriptionListCount( $importId )
    {
        $objectCount = NewsletterSubscription::fetchSubscriptionListByImportIdCount( $importId );
        return array( 'result' => $objectCount );
    }

    /**
     *
     * @param integer $limit
     * @param integer $offset
     * @param string $email
     * @param boolean $asObject
     * @return array
     */
    static function fetchUserList( $limit, $offset, $email, $asObject )
    {
        $objectList = NewsletterUser::fetchList( $limit, $offset, $email, $asObject );

        return array( 'result' => $objectList );
    }
    
    /**
     *
     * @param integer $limit
     * @param integer $offset
     * @param string $email
     * @param boolean $asObject
     * @return array
     */
    static function fetchUserListSearch( $searchStr, $logic='AND', $limit=0, $offset=0, $sortBy = false, $asObject = true )
    {
    	$objectList = NewsletterUserSearch::userSearch( $searchStr, $logic, $limit, $offset, $sortBy, $asObject );
    
    	return array( 'result' => $objectList );
    }

    /**
     *
     * @param unknown_type $emailSearch
     * @return array
     */
    static function fetchUserListCount( $emailSearch )
    {
        $count = NewsletterUser::fetchListCount( $emailSearch );

        return array( 'result' => $count );
    }

    /**
     *
     * @param integer $limit
     * @param integer $offset
     * @param integer $newsletterUserId
     * @param boolean $asObject
     * @return array
     */
    static function fetchEditonSendItemList( $limit, $offset, $newsletterUserId, $asObject )
    {
        $objectList = NewsletterEditionSendItem::fetchListByNewsletterUserId( $limit, $offset, $newsletterUserId, $asObject );

        return array( 'result' => $objectList );
    }

    /**
     *
     * @param integer $newsletterUserId
     * @return array
     */
    static function fetchEditonSendItemListCount( $newsletterUserId )
    {
        $count = NewsletterEditionSendItem::fetchListByNewsletterIdCount( $newsletterUserId );

        return array( 'result' => $count );
    }

}

?>