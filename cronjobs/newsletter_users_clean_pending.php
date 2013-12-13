<?php

	// to fetch instance in Cli mode for separate logdata, cause access rights phpcli + webserver
	$logInstance = NewsletterLog::getInstance( true );
	
	$message = "START: newsletter_clean_pendingUsers";
	$cli->output( $message );

    $ini = eZINI::instance( 'newsletter.ini' );
    $ConfirmationTimeOut = $ini->variable( 'NewsletterSettings', 'ConfirmationTimeOut' );
    eval('$ConfirmationTimeOut = '.$ConfirmationTimeOut.';');

    $pendingUserList=NewsletterUser::fetchUserListByStatus(NewsletterUser::STATUS_PENDING);
    $message = "--\n>> Pending Users founded : ".count($pendingUserList);
    $cli->output( $message );
    
    $i=0;
    foreach($pendingUserList as $pendingUser) {
    	if( ($pendingUser->Created+$ConfirmationTimeOut) < time()) {
    		$message = "\n  >> DELETE USER : ".$pendingUser->Email;
            $cli->output( $message );
    		$pendingUser->remove();
    		$i++;
    	}
    }
    
    $message = "--\n\n => ".count($pendingUserList)." users founded, ".$i." deleted.";
    $cli->output( $message );
    
    $message = "\nSTOP: newsletter_clean_pendingUsers";
    $cli->output( $message );

?>
