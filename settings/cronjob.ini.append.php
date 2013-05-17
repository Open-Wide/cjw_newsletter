<?php /* #?ini charset="utf-8"? */

/**
 * File containing the cronjob ini
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package cjw_newsletter
 * @subpackage ini
 * @filesource
 */

/*
# php runcronjobs.php cjw_newsletter
# php runcronjobs.php -s siteaccess cjw_newsletter_mailqueue_create
# php runcronjobs.php -s siteaccess cjw_newsletter_mailqueue_process
# php runcronjobs.php -s siteaccess cjw_newsletter_users_clean_pending

[CronjobSettings]
ExtensionDirectories[]=cjw_newsletter
ScriptDirectories[]=cronjobs

# CronjobPart for Testing
[CronjobPart-cjw_newsletter]
Scripts[]=cjw_newsletter_mailqueue_create.php
Scripts[]=cjw_newsletter_mailqueue_process.php
Scripts[]=cjw_newsletter_users_clean_pending.php

[CronjobPart-cjw_newsletter_mailqueue_create]
Scripts[]=cjw_newsletter_mailqueue_create.php

[CronjobPart-cjw_newsletter_mailqueue_process]
Scripts[]=cjw_newsletter_mailqueue_process.php

[CronjobPart-cjw_newsletter_users_clean_pending]
Scripts[]=cjw_newsletter_users_clean_pending.php

[CronjobPart-cjw_test]
Scripts[]=cjw_test.php

*/ ?>
