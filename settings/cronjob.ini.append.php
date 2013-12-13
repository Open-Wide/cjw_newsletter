<?php /* #?ini charset="utf-8"? */

/**
 * File containing the cronjob ini
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package newsletter
 * @subpackage ini
 * @filesource
 */

/*
# php runcronjobs.php newsletter
# php runcronjobs.php -s siteaccess newsletter_mailqueue_create
# php runcronjobs.php -s siteaccess newsletter_mailqueue_process
# php runcronjobs.php -s siteaccess newsletter_users_clean_pending

[CronjobSettings]
ExtensionDirectories[]=newsletter
ScriptDirectories[]=cronjobs

# CronjobPart for Testing
[CronjobPart-newsletter]
Scripts[]=newsletter_mailqueue_create.php
Scripts[]=newsletter_mailqueue_process.php
Scripts[]=newsletter_users_clean_pending.php

[CronjobPart-newsletter_mailqueue_create]
Scripts[]=newsletter_mailqueue_create.php

[CronjobPart-newsletter_mailqueue_process]
Scripts[]=newsletter_mailqueue_process.php

[CronjobPart-newsletter_users_clean_pending]
Scripts[]=newsletter_users_clean_pending.php

[CronjobPart-test]
Scripts[]=test.php

*/ ?>
