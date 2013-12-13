<?php
/**
 * File containing NewsletterEditionFilter class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 * @subpackage extendedattributefilter
 * @filesource
 */
/**
 * This filter allowed, fetch all lists by a specific status<br>
 * status-variants:<br>
 * ->DRAFT<br>
 * ->PROCESS<br>
 * ->ARCHIVE<br>
 * ->ABORT<br>
 *
 * <code>
 *    fetch('content','list',hash('parent_node_id', 2,
 *           'extended_attribute_filter',
 *           hash( 'id', 'NewsletterEditionFilter',
 *                 'params', hash( 'status', 'draft' ) )
 *          ) )
 * </code>
 *
 * @version //autogentag//
 * @package newsletter
 * @subpackage extendedattributefilter
 */
class NewsletterEditionFilter
{

    /**
     * Constructor
     *
     * @return void
     */
    function NewsletterListFilter()
    {
        // Empty...
    }

    /**
     *
     * @param unknown_type $parameter
     * @return array
     */
    function createSqlParts( $parameter )
    {
        $db = eZDB::instance();
        $sqlCond = false;
        $sqlTables = false;
        $sqlColumns = false;

        $status = 0;

        $siteAccessArray = array();
    if ( array_key_exists( 'status', $parameter ) )
        {
            $status = $parameter['status'];
        }

        if ( $status == 'draft' )
        {

            // draft wenn aktuelle version nicht in edition_send dann = draft


             $sql = "SELECT c.edition_contentobject_id FROM nl_edition_send c, ezcontentobject e
                                 WHERE e.id = c.edition_contentobject_id
                                 AND e.current_version = c.edition_contentobject_version ";

             $sqlCond .= ' ezcontentobject_tree.contentobject_id NOT IN (' . $sql . ' ) AND ';

             return array( 'tables' => $sqlTables, 'joins'  => $sqlCond, 'columns' => $sqlColumns );
        }
        else if ( $status == 'process' )
        {

             $sql = "SELECT c.edition_contentobject_id FROM nl_edition_send c, ezcontentobject e
                                 WHERE e.id = c.edition_contentobject_id
                                 AND e.current_version = c.edition_contentobject_version
                                 AND ( c.status = ". NewsletterEditionSend::STATUS_WAIT_FOR_PROCESS .
                                 " OR c.status = ". NewsletterEditionSend::STATUS_MAILQUEUE_CREATED .
                                 " OR c.status = ". NewsletterEditionSend::STATUS_MAILQUEUE_PROCESS_STARTED .
                                 " )";

             $sqlCond .= ' ezcontentobject_tree.contentobject_id IN (' . $sql . ' ) AND ';

             return array( 'tables' => $sqlTables, 'joins'  => $sqlCond, 'columns' => $sqlColumns );
        }
        else if ( $status == 'archive' )
        {

             $sql = "SELECT c.edition_contentobject_id FROM nl_edition_send c, ezcontentobject e
                                 WHERE e.id = c.edition_contentobject_id
                                 AND e.current_version = c.edition_contentobject_version
                                 AND c.status = ". NewsletterEditionSend::STATUS_MAILQUEUE_PROCESS_FINISHED ;


             $sqlCond .= ' ezcontentobject_tree.contentobject_id IN (' . $sql . ' ) AND ';

             return array( 'tables' => $sqlTables, 'joins'  => $sqlCond, 'columns' => $sqlColumns );
        }
        else if ( $status == 'abort' )
        {

             $sql = "SELECT c.edition_contentobject_id FROM nl_edition_send c, ezcontentobject e
                                 WHERE e.id = c.edition_contentobject_id
                                 AND e.current_version = c.edition_contentobject_version
                                 AND c.status = ". NewsletterEditionSend::STATUS_ABORT ;


             $sqlCond .= ' ezcontentobject_tree.contentobject_id IN (' . $sql . ' ) AND ';

             return array( 'tables' => $sqlTables, 'joins'  => $sqlCond, 'columns' => $sqlColumns );
        }
        else
        {
            return array( 'tables' => false, 'joins'  => false, 'columns' => false );
        }
    }
}
?>
