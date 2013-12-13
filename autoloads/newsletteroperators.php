<?php
/**
 * File containing the NewsletterOperators class
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 * @filesource
 */
/**
 * php preg_replace | str_replace tpl operator
 *
 * tpl example:
 * {$text|newsletter_preg_replace( $search_string, $replace_string )}
 * {$text|newsletter_str_replace( $search_string, $replace_string )}
 *
 * @version //autogentag//
 * @package newsletter
 */
class NewsletterOperators
{
    var $Operators;

    function __construct()
    {
        $this->Operators = array( 'newsletter_preg_replace', 'newsletter_str_replace', 'newsletter_variable' );
    }

    /*! Returns the template operators.
    */
    function operatorList()
    {
        return $this->Operators;
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'newsletter_preg_replace' => array( 'string_search' => array( 'type' => 'string',
                                                                                       'required' => true,
                                                                                       'default' => '' ),
                                                             'string_replace' => array( 'type' => 'string',
                                                                                       'required' => true,
                                                                                       'default' => '' ) ),
                      'newsletter_str_replace' => array( 'string_search' => array( 'type' => 'string',
                                                                                       'required' => true,
                                                                                       'default' => '' ),
                                                             'string_replace' => array( 'type' => 'string',
                                                                                       'required' => true,
                                                                                       'default' => '' ) ),
                      'newsletter_variable' => array( 'variable_name' => array( 'type' => 'string',
                                                                                    'required' => true,
                                                                                    'default' => '' ) )
                     );
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        switch ( $operatorName )
        {
            case 'newsletter_preg_replace':
            {
                $operatorValue = preg_replace( $namedParameters['string_search'], $namedParameters['string_replace'], $operatorValue );
            }
            break;
            case 'newsletter_str_replace':
            {
                $operatorValue = str_replace( $namedParameters['string_search'], $namedParameters['string_replace'], $operatorValue );
            }
            break;

            case 'newsletter_variable':
            {
                $returnValue = false;

                // {newsletter_variable( $namedParameters['variable_name'] )}
                switch( $namedParameters['variable_name'] )
                {
                    // {newsletter_variable( 'available_subscription_status_id_name_array' )}
                    case 'available_subscription_status_id_name_array';
                    {
                        $returnValue = NewsletterSubscription::availableStatusIdNameArray();
                    }
                    break;
                }

                $operatorValue = $returnValue;
            }
            break;
        }
    }

}
?>