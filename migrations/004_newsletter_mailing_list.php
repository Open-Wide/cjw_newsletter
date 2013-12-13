<?php

/**
 * Création de la classe Newsletter Mailing List
 */
class Newsletter_004_NewsletterMailingList {

	public function up() {
		$migration = new OWMigrationContentClass( );
		$migration->startMigrationOn( 'newsletter_mailing_list' );
		$migration->createIfNotExists();

		$migration->always_available = TRUE;
		$migration->contentobject_name = '<short_title|title>';
		$migration->is_container = TRUE;

		$migration->addAttribute( 'title', array(
			'is_required' => TRUE
		) );
		$migration->addAttribute( 'short_title' );
		$migration->addAttribute( 'short_description', array(
            'data_type_string' => 'ezxmltext'
        ) );
		
		$migration->addToContentClassGroup( 'Newsletter' );
		$migration->end();
	}

	public function down() {
		$migration = new OWMigrationContentClass( );
		$migration->startMigrationOn( 'newsletter_mailing_list' );
		$migration->removeClass();
	}

}
