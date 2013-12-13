<?php
/**
 * File user_view.php
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 * @subpackage modules
 * @filesource
 */

$module = $Params['Module'];
$http = eZHTTPTool::instance();
$tpl = eZTemplate::factory();

$templateFile = 'design:newsletter/user_view.tpl';

$newsLetterUserId = (int) $Params['NewsletterUserId'];
$newsletterUserObject = NewsletterUser::fetch( $newsLetterUserId );

if( !is_object( $newsletterUserObject ) )
{
    return $module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$viewParameters = array();
if( is_array( $Params['UserParameters'] ) )
{
    $viewParameters = array_merge( $viewParameters, $Params['UserParameters'] );
}

$tpl->setVariable( 'view_parameters', $viewParameters );

$tpl->setVariable( 'newsletter_user', $newsletterUserObject );

$Result = array();

$Result['content'] = $tpl->fetch( $templateFile );
$Result['path'] =  array( array( 'url'  => 'newsletter/index',
                                 'text' => ezpI18n::tr( 'newsletter/path', 'Newsletter' ) ),
                          array( 'url'  => 'newsletter/user_list',
                                 'text' => ezpI18n::tr( 'newsletter/user_list', 'Users' ) ),
                          array( 'url'  => false,
                                 'text' => $newsletterUserObject->attribute('name') ) );

?>
