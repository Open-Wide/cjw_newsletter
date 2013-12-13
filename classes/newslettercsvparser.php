<?php
/**
 * File containing the NewsletterCsvParser class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 * @filesource
 */
/**
 * Class description here
 *
 * @version //autogentag//
 * @package newsletter
 */
class NewsletterCsvParser
{
    /**
     * Constructor
     *
     * @example classes/NewsletterLog.php
     * @param string $csvFileName
     * @param string $delimiter
     * @param boolean $firstRowIsLabel
     * @return void
     */
    function __construct( $csvFileName, $delimiter = ';' , $firstRowIsLabel = true)
    {

        $fp = fopen( $csvFileName, "r" );
        $rowArray = array();
        $c = 0;
        $row = array();
        $firstRow = array( 'email', 'first_name', 'last_name', 'salutation' );

        if ( $firstRowIsLabel == true )
        {
            $firstRowTmp = fgetcsv( $fp, 1000, $delimiter );
            $c++;
        }

        // Load the file
        while ( ( $row = fgetcsv( $fp, 1000, $delimiter )) !== FALSE )
        {

            for( $i=0; $i < count( $firstRow ); $i++ )
            {
                if ( array_key_exists( $i, $row ))
                    $rowArray[ $c ] [ $firstRow[$i] ] = $row[ $i ];
            }

            $c++;
        }
        fclose ( $fp );

        $this->CsvDataArray = $rowArray;
    }

    /**
     * Returns data array
     *
     * @return array
     */
    function getCsvDataArray()
    {
        return $this->CsvDataArray;
    }


    /**
     *
     * @var array
     */

    var $CsvDataArray;
}

?>
