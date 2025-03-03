<?php // Pro
// plugin installation routine 

function dk_speakout_install() {

    global $wpdb, $db_petitions, $db_signatures, $dk_speakout_version;
    $installed_version = get_option( 'dk_speakout_version' );

    dk_speakout_translate();

    $sql_create_tables = "
		CREATE TABLE `$db_petitions` (
			`id` BIGINT(20) UNSIGNED NULL AUTO_INCREMENT,
			`title` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`target_email` VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`target_email_CC` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`email_subject` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`greeting` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`petition_message` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`petition_footer` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`address_fields` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`address_required` TINYINT NULL DEFAULT '0',
			`street_required` TINYINT NULL DEFAULT '0',
			`city_required` TINYINT NULL DEFAULT '0',
			`state_required` TINYINT NULL DEFAULT '0',
			`postcode_required` TINYINT NULL DEFAULT '0',
			`country_required` TINYINT NULL DEFAULT '0',
			`expires` TINYINT NULL,
			`expiration_date` DATETIME NULL, 
			`created_date` DATETIME NULL,
    		`goal` INT(11) NULL,
    		`increase_goal` TINYINT NULL DEFAULT '0',
    		`goal_bump` INT(8) NULL,
    		`goal_trigger` INT(3) NULL,
			`sends_email` TINYINT NULL DEFAULT '1',
			`x_message` VARCHAR(260) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`display_petition_message` TINYINT NULL DEFAULT '1',
			`requires_confirmation` TINYINT NULL DEFAULT '0',
			`return_url` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`displays_custom_field` TINYINT NULL DEFAULT '0',
            `custom_field_included` TINYINT NULL DEFAULT '1',
			`custom_field_required` TINYINT NULL DEFAULT '0',
			`custom_field_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom field 1',
			`custom_field_location` TINYINT NULL DEFAULT '1',
            `custom_field_truncated` TINYINT NULL DEFAULT '1',
            `displays_custom_field2` TINYINT NULL DEFAULT '0',
			`custom_field2_included` TINYINT NULL DEFAULT '1',
			`custom_field2_required` TINYINT NULL DEFAULT '0',
			`custom_field2_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom field 2',
			`custom_field2_location` TINYINT NULL DEFAULT '1',
            `custom_field2_truncated` TINYINT NULL DEFAULT '1',
            `displays_custom_field3` TINYINT NULL DEFAULT '0',
			`custom_field3_included` TINYINT NULL DEFAULT '1',
			`custom_field3_required` TINYINT NULL DEFAULT '0',
			`custom_field3_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom field 3',
			`custom_field3_location` TINYINT NULL DEFAULT '1',
            `custom_field3_truncated` TINYINT NULL DEFAULT '1',
            `displays_custom_field4` TINYINT NULL DEFAULT '0',
			`custom_field4_included` TINYINT NULL DEFAULT '1',
			`custom_field4_required` TINYINT NULL DEFAULT '0',
			`custom_field4_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom field 4',
			`custom_field4_location` TINYINT NULL DEFAULT '1',
            `custom_field4_truncated` TINYINT NULL DEFAULT '1',
            `displays_custom_field5` TINYINT NULL DEFAULT '0',           
			`custom_field5_included` TINYINT NULL DEFAULT '1',
			`custom_field5_required` TINYINT NULL DEFAULT '0',
			`custom_field5_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom drop down 1',
            `custom_field5_values` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`custom_field5_location` TINYINT NULL DEFAULT '1',
			`displays_custom_field6` TINYINT NULL DEFAULT '0',
            `custom_field6_included` TINYINT NULL DEFAULT '1',
			`custom_field6_required` TINYINT NULL DEFAULT '0',
			`custom_field6_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom checkbox 1',
			`custom_field6_location` TINYINT NULL DEFAULT '1',
            `custom_field6_value` TINYINT NULL DEFAULT '1',
			`displays_custom_field7` TINYINT NULL DEFAULT '0',
            `custom_field7_included` TINYINT NULL DEFAULT '1',
			`custom_field7_required` TINYINT NULL DEFAULT '0',
			`custom_field7_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom checkbox 2',
			`custom_field7_location` TINYINT NULL DEFAULT '1',
            `custom_field7_value` TINYINT NULL DEFAULT '1',
             `displays_custom_field8` TINYINT NULL DEFAULT '0',
            `custom_field8_included` TINYINT NULL DEFAULT '1',
			`custom_field8_required` TINYINT NULL DEFAULT '0',
			`custom_field8_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom checkbox 3',
			`custom_field8_location` TINYINT NULL DEFAULT '1',
            `custom_field8_value` TINYINT NULL DEFAULT '1',
            `displays_custom_field9` TINYINT NULL DEFAULT '0',
            `custom_field9_included` TINYINT NULL DEFAULT '1',
			`custom_field9_required` TINYINT NULL DEFAULT '0',
			`custom_field9_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom checkbox 4',
			`custom_field9_location` TINYINT NULL DEFAULT '1',
            `custom_field9_value` TINYINT NULL DEFAULT '1',
			`displays_custom_message` TINYINT NULL DEFAULT '0',
			`custom_message_label` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,			
			`displays_optin` TINYINT NULL DEFAULT '0',
			`optin_label` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Add me to your mailing list',
			`is_editable` TINYINT NULL DEFAULT '0',
			`redirect_url_option` TINYINT NULL DEFAULT '0',
			`redirect_url` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`redirect_delay` VARCHAR(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`url_target` TINYINT NULL DEFAULT '0',
			`hide_email_field` TINYINT NULL DEFAULT '0',
            `allow_anonymous` TINYINT NULL DEFAULT '0',
            `open_message_button` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Read the Petition',
            `open_editable_message_button` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Read or Edit the Petition',
            `cleverreach_enable` TINYINT NULL DEFAULT '0', 
            `cleverreach_clientID` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,  
            `cleverreach_clientSecret` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `cleverreach_groupID` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`cleverreach_formID` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `cleverreach_source` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Speakout! Petition',
            `mailchimp_enable` TINYINT NULL DEFAULT '0', 
            `mailchimp_api_key` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,  
            `mailchimp_server` VARCHAR(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `mailchimp_list_id` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `mailerlite_enable` TINYINT NULL DEFAULT '0', 
            `mailerlite_api_key` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,  
            `mailerlite_group_id` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_enable` TINYINT NULL DEFAULT '0', 
            `activecampaign_api_key` VARCHAR(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,  
            `activecampaign_server` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_list_id` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map1field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map2field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map3field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map4field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map5field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map6field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map7field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map8field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map9field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map10field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map11field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map12field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map13field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map14field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `activecampaign_map15field` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `sendy_enable` TINYINT DEFAULT '0' NULL, 
            `sendy_api_key` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL, 
            `sendy_server` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `sendy_list_id` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `thank_signer` TINYINT DEFAULT '0' NULL,
			`thank_signer_subject` VARCHAR(128) DEFAULT 'Thanks for signing our petition' NULL,
            `thank_signer_content` LONGTEXT DEFAULT 'We appreciate your support' NULL,
			UNIQUE KEY  `id` (`id`)
		) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ;

		CREATE TABLE `$db_signatures` (
			`id` BIGINT(20) UNSIGNED NULL AUTO_INCREMENT, 
			`petitions_id` BIGINT(20) NULL,
			`honorific` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`first_name` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`last_name` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`email` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`street_address` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`city` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`state` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`postcode` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`country` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`custom_field` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `custom_field2` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `custom_field3` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `custom_field4` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `custom_field5` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
            `custom_field6` TINYINT NULL,
            `custom_field7` TINYINT NULL,
            `custom_field8` TINYINT NULL,
            `custom_field9` TINYINT NULL,
			`optin` TINYINT NULL,
			`date` DATETIME NULL,
			`confirmation_code` VARCHAR(32) NULL,
			`is_confirmed` TINYINT NULL DEFAULT '0',
			`custom_message` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`language` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`IP_address` VARCHAR(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL,
			`anonymise` TINYINT NULL DEFAULT '0',
			UNIQUE KEY `id` (`id`),
			KEY `petitionID` (`petitions_id`)
		)ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ;";

    // create database tables

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    dbDelta( $sql_create_tables );

    //add sample petition if a new install
    //if ( version_compare( $installed_version, '0.0', '<' ) == 1 ) {
        $createDate = date( 'Y-m-d h:i:s' );
        $sql_update = "INSERT INTO $db_petitions (`title`, `target_email`, `email_subject`, `greeting`, `petition_message`, `activecampaign_map2field`, `activecampaign_map3field`, `activecampaign_map4field`, `address_fields`, `created_date` ) 
        VALUES ('Sample Petition', 'SampleEmail@example.com',  'Edit your petition', 'Dear SpeakOut! user', 'This is a sample petition to get you started.  Edit it to suit your campaign.\r\n\r\nYou can use the editor to make things <strong>bold</strong> or <em>emphasized</em><ul><li>explore the toolbar.</li></ul>Be sure to go through all the tabs at the top of this page to see the available options.', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'a:0:{}', '" . $createDate . "' );";
        $wpdb->query( $sql_update );
   // }


    // set default options
    $options = array(
        "petitions_rows" => "20",
        "signatures_rows" => "50",
        "petition_theme" => "default",
        "button_text" => __( "Sign Now", "speakout" ),
        "expiration_message" => __( "This petition is now closed.", "speakout" ),
        "success_message" => "<strong>" . __( "Thank you", "speakout" ) . ", %first_name%.</strong>\r\n<p>" . __( "Your signature has been added.", "speakout" ) . "</p>",
        "already_signed_message" => __( "This petition has already been signed using your email address.", "speakout" ),
        "share_message" => __( "Share this with your friends:", "speakout" ),
        "confirm_subject" => __( "Please confirm your email address", "speakout" ),
        "confirm_message" => __( "Hello", "speakout" ) . " %first_name%\r\n\r\n" . __( "Thank you for signing our petition %petition_title% ", "speakout" ) . ". " . __( "Please confirm your email address by clicking or copying and pasting the link below:", "speakout" ) . "\r\n%confirmation_link%\r\n\r\n" . get_bloginfo( "name" ),
        "confirm_email" => get_bloginfo( "name" ) . " <" . get_bloginfo( "admin_email" ) . ">",
        "optin_default" => "unchecked",
        "display_count" => "1",
        "signaturelist_theme" => "default",
        "signaturelist_header" => __( "Latest Signatures", "speakout" ),
        "signaturelist_rows" => "50",
        "signaturelist_columns" => serialize( array( "sig_date" ) ),
        "speakout_editor" => "html",
        "widget_theme" => "default",
        "csv_signatures" => "all",
        "signaturelist_privacy" => "enabled",
        "signaturelist_display" => "table",
        "display_bcc" => "enabled",
        "display_privacypolicy" => "disabled",
        "display_anedot" => "disabled",
        "display_sharing" => "enabled",
        "privacypolicy_url" => "",
        "display_honorific" => "enabled",
        "redirect_url_option" => "0",
        "eu_postalcode" => "",
        "thousands_separator" => ",",
        "decimal_separator" => ".",
        "advanced_option" => "0",
        "display_flags" => "off",
        "sigtab_email" => "on",
        "sigtab_petition_info" => "on",
        "sigtab_street_address" => "N",
        "sigtab_postalcode" => "N",
        "sigtab_city" => "",
        "sigtab_state" => "N",
        "sigtab_country" => "N",
        "sigtab_custom_field1" => "N",
        "sigtab_custom_field2" => "N",
        "sigtab_custom_field3" => "N",
        "sigtab_custom_field4" => "N",
        "sigtab_custom_field5" => "-",
        "sigtab_custom_field6" => "N",
        "sigtab_custom_field7" => "N",
        "sigtab_custom_field8" => "N",
        "sigtab_custom_field9" => "N",
        "sigtab_confirmed_status" => "on",
        "sigtab_date_signed" => "on",
        "sigtab_optin" => "on",
        "sigtab_IP_address" => "N",
        "sigtab_display_time" => "N",
        "petition_fade" => "disabled",
        "license_key" => "",
        "license_key_verified" => "",
        "g_recaptcha_version" => "",
        "g_recaptcha_status" => "",
        "g_recaptcha_site_key" => "",
        "hcaptcha_status" => "",
        "hcaptcha__site_key" => "",
        "hcaptcha_secret_key" => "",
        "anedot_page_id" => "",
        "anedot_embed_pref" => "",
        "anedot_iframe_width" => "",
        "anedot_iframe_height" => "",
        "webhooks" => "off",
        "mailchimp_debug" => "off",
        "updater"=>"on"

    );

    // add plugin options to wp_options table
    add_option( 'dk_speakout_options', $options );
    add_option( 'dk_speakout_version', $dk_speakout_version );

    // register options for translation in WPML
    include_once( 'class.wpml.php' );
    $wpml = new dk_speakout_WPML();
    $wpml->register_options( $options );
}

// initial install
if ( !get_option( 'dk_speakout_version' ) ) {
    dk_speakout_install();
}

// run plugin update script if needed
add_action( 'plugins_loaded', 'dk_speakout_update' );

function dk_speakout_update() {

    global $wpdb, $db_petitions, $db_signatures, $dk_speakout_version;
    $installed_version = get_option( 'dk_speakout_version' );
    $options = get_option( 'dk_speakout_options' );

    ///////////////////////////////////////////////
    //   update previous installs and Pro version
    ////////////////////////////////////////////////
	$result = $wpdb->query( "SHOW COLUMNS FROM $db_petitions LIKE 'thank_signer_subject'" );      
    if(!$result){ 
        $sql_update = "ALTER TABLE $db_petitions        
            ADD `thank_signer_subject` VARCHAR(128) DEFAULT 'Thanks for signing our petition' NULL AFTER `thank_signer`";
        $wpdb->query( $sql_update );
     }
	 
	$result = $wpdb->query( "SHOW COLUMNS FROM $db_petitions LIKE 'cleverreach_formID'" );      
    if(!$result){ 
        $sql_update = "ALTER TABLE $db_petitions        
            ADD `cleverreach_formID` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL AFTER `cleverreach_groupID`";
        $wpdb->query( $sql_update );
     }
        
    $result = $wpdb->query( "SHOW COLUMNS FROM $db_petitions LIKE 'cleverreach_enable'" );      
    if(!$result){ 
        $sql_update = "ALTER TABLE $db_petitions        
            ADD `cleverreach_enable` TINYINT NULL DEFAULT '0' AFTER `open_editable_message_button`, 
            ADD `cleverreach_clientID` VARCHAR(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL AFTER `cleverreach_enable` ,  
            ADD `cleverreach_clientSecret` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL AFTER `cleverreach_clientID`,
            ADD `cleverreach_groupID` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL AFTER `cleverreach_clientSecret`,
            ADD `cleverreach_source` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'SpeakOut! Petition' AFTER `cleverreach_groupID`";
        $wpdb->query( $sql_update );
     }    
     
    $result = $wpdb->query( "SHOW COLUMNS FROM $db_petitions LIKE 'thank_signer'" );      
    if(!$result){ 
        $sql_update = "ALTER TABLE $db_petitions        
            ADD `thank_signer` TINYINT DEFAULT '0' NULL,
            ADD `thank_signer_content` LONGTEXT NULL AFTER `thank_signer`";
    $wpdb->query( $sql_update );
    }

    if ( version_compare( $installed_version, '105.2.1', '<' ) == 1 ) {
        $sql_update = "ALTER TABLE $db_petitions  CHANGE `mailerlite_api_key` `mailerlite_api_key` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COLLATE utf8mb4_general_ci NULL DEFAULT NULL, CHANGE `mailerlite_group_id` `mailerlite_group_id` VARCHAR(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COLLATE utf8mb4_general_ci NULL DEFAULT NULL; ";
        $wpdb->query( $sql_update ); 
         
        $sql_update = "ALTER TABLE $db_signatures CHANGE `honorific` `honorific` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;";
        $wpdb->query( $sql_update );
        
         // new way of adding columns to db to ensure even people who skip versions get the changes
        $result = $wpdb->query( "SHOW COLUMNS FROM $db_signatures LIKE 'custom_field8'" );      
        if(!$result){ 
            $sql_update = "ALTER TABLE $db_signatures
                ADD `custom_field8` TINYINT NULL AFTER `custom_field7`,
                ADD `custom_field9` TINYINT NULL AFTER `custom_field8`";
            $wpdb->query( $sql_update );
        }
         
        $result = $wpdb->query( "SHOW COLUMNS FROM $db_petitions LIKE 'custom_field_truncated'" );      
        if(!$result){ 
            $sql_update = "ALTER TABLE $db_petitions        
                ADD `custom_field_truncated` TINYINT NULL DEFAULT '0' AFTER `custom_field_location`, 
                ADD `custom_field2_truncated` TINYINT NULL DEFAULT '0' AFTER `custom_field2_location`, 
                ADD `custom_field3_truncated` TINYINT NULL DEFAULT '0' AFTER `custom_field3_location`, 
                ADD `custom_field4_truncated` TINYINT NULL DEFAULT '0' AFTER `custom_field4_location`";
            $wpdb->query( $sql_update );
         }
         
        $result = $wpdb->query( "SHOW COLUMNS FROM $db_petitions LIKE 'displays_custom_field8'" );      
        if(!$result){ 
            $sql_update = "ALTER TABLE $db_petitions
                ADD `displays_custom_field8` TINYINT NULL DEFAULT '0' AFTER `custom_field7_value`,
                ADD `custom_field8_included` TINYINT NULL DEFAULT '1' AFTER `displays_custom_field8`,
                ADD `custom_field8_required` TINYINT NULL DEFAULT '0' AFTER `custom_field8_included`,
                ADD `custom_field8_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom checkbox 3' AFTER `custom_field8_required`,
                ADD `custom_field8_location` TINYINT NULL DEFAULT '1' AFTER `custom_field8_label`,
                ADD `custom_field8_value` TINYINT NULL DEFAULT '1' AFTER `custom_field8_location`,

                ADD `displays_custom_field9` TINYINT NULL DEFAULT '0' AFTER `custom_field8_value`,
                ADD `custom_field9_included` TINYINT NULL DEFAULT '1' AFTER `displays_custom_field9`,
                ADD `custom_field9_required` TINYINT NULL DEFAULT '0' AFTER `custom_field9_included`,
                ADD `custom_field9_label` VARCHAR(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL DEFAULT 'Custom checkbox 4' AFTER `custom_field9_required`,
                ADD `custom_field9_location` TINYINT NULL DEFAULT '1' AFTER `custom_field9_label`,
                ADD `custom_field9_value` TINYINT NULL DEFAULT '1' AFTER `custom_field9_location`";
            $wpdb->query( $sql_update );
        }


        $result = $wpdb->query( "SHOW COLUMNS FROM $db_petitions LIKE 'twitter_message'" );      
        if($result){ 
            $sql_update = "ALTER TABLE $db_petitions CHANGE `twitter_message` `x_message` VARCHAR(260) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;";
            $wpdb->query( $sql_update );
        }
         
        $result = $wpdb->query( "SHOW COLUMNS FROM $db_petitions LIKE 'sendy_enable'" );      
        if(!$result){ 
            $sql_update = "ALTER TABLE $db_petitions
                 ADD `sendy_enable` TINYINT DEFAULT '0' NULL AFTER `activecampaign_map15field`,
                 ADD `sendy_api_key` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL AFTER `sendy_enable`, 
                 ADD `sendy_server` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL AFTER `sendy_api_key`,
                 ADD `sendy_list_id` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NULL AFTER `sendy_server`";
            $wpdb->query( $sql_update );
        }
     }
	 
    if ( $installed_version != $dk_speakout_version ) {
        // options added after initial release
        if ( !array_key_exists( 'updater', $options ) ) {
            $options[ 'updater' ] = "on";
        }
        if ( !array_key_exists( 'mailchimp_debug', $options ) ) {
            $options[ 'mailchimp_debug' ] = "off";
        }
        if ( !array_key_exists( 'webhooks', $options ) ) {
            $options[ 'webhooks' ] = "off";
        }
        if ( !array_key_exists( 'g_recaptcha_version', $options ) ) {
            $options[ 'g_recaptcha_version' ] = "";
        }
        if ( !array_key_exists( 'g_recaptcha_status', $options ) ) {
            $options[ 'g_recaptcha_status' ] = "";
        }
        if ( !array_key_exists( 'g_recaptcha_site_key', $options ) ) {
            $options[ 'g_recaptcha_site_key' ] = "";
        }
        if ( !array_key_exists( 'g_recaptcha_secret_key', $options ) ) {
            $options[ 'g_recaptcha_secret_key' ] = "";
        }
        if ( !array_key_exists( 'hcaptcha_status', $options ) ) {
            $options[ 'hcaptcha_status' ] = "";
        }
        if ( !array_key_exists( 'hcaptcha_site_key', $options ) ) {
            $options[ 'hcaptcha_site_key' ] = "";
        }
        if ( !array_key_exists( 'hcaptcha_secret_key', $options ) ) {
            $options[ 'hcaptcha_secret_key' ] = "";
        }
        if ( !array_key_exists( 'anedot_page_id', $options ) ) {
            $options[ 'anedot_page_id' ] = "";
        }
        if ( !array_key_exists( 'anedot_embed_pref', $options ) ) {
            $options[ 'anedot_embed_pref' ] = "";
        }
        if ( !array_key_exists( 'anedot_iframe_width', $options ) ) {
            $options[ 'anedot_iframe_width' ] = "";
        }
        if ( !array_key_exists( 'anedot_iframe_height', $options ) ) {
            $options[ 'anedot_iframe_height' ] = "";
        }
        if ( !array_key_exists( 'license_key', $options ) ) {
            $options[ 'license_key' ] = "";
        }
        if ( !array_key_exists( 'thousands_separator', $options ) ) {
            $options[ 'thousands_separator' ] = ",";
        }
        if ( !array_key_exists( 'decimal_separator', $options ) ) {
            $options[ 'decimal_separator' ] = ".";
        }
        if ( !array_key_exists( 'advanced_option', $options ) ) {
            $options[ 'advanced_option' ] = "0";
        }
        if ( !array_key_exists( 'petition_fade', $options ) ) {
            $options[ 'petition_fade' ] = "disabled";
        }
        if ( !array_key_exists( 'sigtab_display_time', $options ) ) {
            $options[ 'sigtab_display_time' ] = "N";
        }

        if ( !array_key_exists( 'sigtab_email', $options ) ) {
            $options[ 'sigtab_email' ] = "on";
        }
        if ( !array_key_exists( 'sigtab_petition_info', $options ) ) {
            $options[ 'sigtab_petition_info' ] = "on";
        }
        if ( !array_key_exists( 'sigtab_street_address', $options ) ) {
            $options[ 'sigtab_street_address' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_city', $options ) ) {
            $options[ 'sigtab_city' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_state', $options ) ) {
            $options[ 'sigtab_state' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_postalcode', $options ) ) {
            $options[ 'sigtab_postalcode' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_country', $options ) ) {
            $options[ 'sigtab_country' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_custom_field1', $options ) ) {
            $options[ 'sigtab_custom_field1' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_custom_field2', $options ) ) {
            $options[ 'sigtab_custom_field2' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_custom_field3', $options ) ) {
            $options[ 'sigtab_custom_field3' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_custom_field4', $options ) ) {
            $options[ 'sigtab_custom_field4' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_custom_field5', $options ) ) {
            $options[ 'sigtab_custom_field5' ] = "Off";
        }
        if ( !array_key_exists( 'sigtab_custom_field6', $options ) ) {
            $options[ 'sigtab_custom_field7' ] = "Off";
        }
        if ( !array_key_exists( 'sigtab_custom_field7', $options ) ) {
            $options[ 'sigtab_custom_field7' ] = "Off";
        }
        if ( !array_key_exists( 'sigtab_custom_field8', $options ) ) {
            $options[ 'sigtab_custom_field8' ] = "Off";
        }
        if ( !array_key_exists( 'sigtab_custom_field9', $options ) ) {
            $options[ 'sigtab_custom_field9' ] = "Off";
        }
        if ( !array_key_exists( 'sigtab_confirmed_status', $options ) ) {
            $options[ 'sigtab_confirmed_status' ] = "on";
        }
        if ( !array_key_exists( 'sigtab_optin', $options ) ) {
            $options[ 'sigtab_optin' ] = "N";
        }
        if ( !array_key_exists( 'sigtab_date_signed', $options ) ) {
            $options[ 'sigtab_date_signed' ] = "on";
        }
        if ( !array_key_exists( 'sigtab_IP_address', $options ) ) {
            $options[ 'sigtab_IP_address' ] = "N";
        }
        if ( !array_key_exists( 'display_flags', $options ) ) {
            $options[ 'display_flags' ] = "off";
        }
        if ( !array_key_exists( 'eu_postalcode', $options ) ) {
            $options[ 'eu_postalcode' ] = "";
        }
        if ( !array_key_exists( 'display_honorific', $options ) ) {
            $options[ 'display_honorific' ] = "enabled";
        }
        if ( !array_key_exists( 'display_bcc', $options ) ) {
            $options[ 'display_bcc' ] = "enabled";
        }
        if ( !array_key_exists( 'display_privacypolicy', $options ) ) {
            $options[ 'display_privacypolicy' ] = "enabled";
        }
        if ( !array_key_exists( 'display_anedot', $options ) ) {
            $options[ 'display_anedot' ] = "disabled";
        }
        if ( !array_key_exists( 'display_sharing', $options ) ) {
            $options[ 'display_sharing' ] = "enabled";
        }
        if ( !array_key_exists( 'privacypolicy_URL', $options ) ) {
            $options[ 'privacypolicy_URL' ] = "";
        }
        if ( !array_key_exists( 'confirm_subject', $options ) ) {
            $options[ 'confirm_subject' ] = __( 'Please confirm your email address', 'speakout' );
        }
        if ( !array_key_exists( 'confirm_message', $options ) ) {
            $options[ 'confirm_message' ] = __( "Hello", "speakout" ) . " %first_name%\r\n\r\n" . __( "Thank you for signing our petition", "speakout" ) . ". " . __( "Please confirm your email address by clicking or copying and pasting the link below:", "speakout" ) . "<br />%confirmation_link%<br /><br />" . get_bloginfo( "name" );
        }
        if ( !array_key_exists( 'confirm_email', $options ) ) {
            $options[ 'confirm_email' ] = get_bloginfo( 'name' ) . ' <' . get_bloginfo( 'admin_email' ) . '>';
        }
        if ( !array_key_exists( 'signaturelist_header', $options ) ) {
            $options[ 'signaturelist_header' ] = __( 'Latest Signatures', 'speakout' );
        }
        if ( !array_key_exists( 'signaturelist_rows', $options ) ) {
            $options[ 'signaturelist_rows' ] = '50';
        }
        if ( !array_key_exists( 'optin_default', $options ) ) {
            $options[ 'optin_default' ] = 'unchecked';
        }
        if ( !array_key_exists( 'display_count', $options ) ) {
            $options[ 'display_count' ] = '1';
        }
        if ( !array_key_exists( 'signaturelist_columns', $options ) ) {
            $options[ 'signaturelist_columns' ] = serialize( array( 'sig_date' ) );
        }
        if ( !array_key_exists( 'signaturelist_theme', $options ) ) {
            $options[ 'signaturelist_theme' ] = "default";
        }
        if ( !array_key_exists( 'speakout_editor', $options ) ) {
            $options[ 'speakout_editor' ] = "html";
        }
        if ( !array_key_exists( 'widget_theme', $options ) ) {
            $options[ 'widget_theme' ] = "default";
        }
        if ( !array_key_exists( 'csv_signatures', $options ) ) {
            $options[ 'csv_signatures' ] = "all";
        }
        if ( !array_key_exists( 'signaturelist_privacy', $options ) ) {
            $options[ 'signaturelist_privacy' ] = "enabled";
        }
        if ( !array_key_exists( 'signaturelist_display', $options ) ) {
            $options[ 'signaturelist_display' ] = "table";
        }
        update_option( 'dk_speakout_options', $options );
    }

    if ( !get_option( 'dk_speakout_license_key_verified' ) ) {
        add_option( 'dk_speakout_license_key_verified', "0" );
    }
    if ( !get_option( 'dk_speakout_license_key' ) ) {
        update_option( 'dk_speakout_license_key_verified', "0" );
    }
    // update plugin version tag in db
    if ( $installed_version != $dk_speakout_version ) {
        update_option( 'dk_speakout_version', $dk_speakout_version );
    }
}