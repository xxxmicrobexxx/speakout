<?php

/**
 * Class for sending emails in SpeakOut! Email Petitions plugin for WordPress
 */
class dk_speakout_Mail
{

    /**
	 * Sends petition email
	 *
	 * @param object $petition the petition being signed
	 * @param object $signature the signature
	 */
	public static function send_petition( $petition, $signature, $doBCC )
	{
        //to avoid clashing with other resources using parsedown
        if ( ! class_exists( 'Parsedown' ) ) {
            include_once( 'parsedown.php' );
        }

	    $Parsedown = new Parsedown();

		$subject = stripslashes( $petition->email_subject );

		// use custom petition message if provided
		$message = $petition->petition_message;
		if ( $signature->custom_message != '' ) {
			$message = $signature->custom_message;
		}
        $confirmation_url = '<a href="' . home_url() . '/?dkspeakoutconfirm=' . $signature->confirmation_code . '&b=' . $doBCC  . '&lang=' . get_bloginfo( 'language' ) . '">' . home_url() . '/?dkspeakoutconfirm=' . $signature->confirmation_code . '&b=' . $doBCC . '&lang=' . get_bloginfo( 'language' ) . '</a>'; 

		
		// replace user-supplied variables
		$search  = array( '%honorific%', '%first_name%', '%last_name%', '%petition_title%', '%confirmation_link%', '%address%', '%city%', '%state%', '%postcode%', '%country%', '%custom1%');
		$replace = array( strip_tags($signature->honorific), strip_tags($signature->first_name), strip_tags($signature->last_name), strip_tags($petition->title), $confirmation_url, strip_tags($signature->street_address), strip_tags($signature->city), strip_tags($signature->state), strip_tags($signature->postcode), strip_tags($signature->country), strip_tags($signature->custom_field) );
		$message = str_replace( $search, $replace, $message );
		if( $options['speakout_editor'] != "html") {
            $message = $Parsedown->text($message);
        }
		$footer = $petition->petition_footer;

		// add new line after greeting if provided
		$greeting = '';
		if ( $petition->greeting != '' ) {
			$greeting = $petition->greeting .  "<br>" . "\r\n\r\n";
		}
        
        // build custom fields to tail address
        // custom_fields gets their own line
        $customFields = "";
		if ( $petition->displays_custom_field == 1 && $petition->custom_field_included == 1) {
		    $customField1 = stripslashes( $signature->custom_field) > "" ? stripslashes( $signature->custom_field) : "-";
			$customFields = "\r\n" . "<br>" . $petition->custom_field_label . ": " . $customField1;
		}

		if ( $petition->displays_custom_field2 == 1  && $petition->custom_field2_included == 1) {
		    $customField2 = stripslashes( $signature->custom_field2) > "" ? stripslashes( $signature->custom_field2) : "-";
			$customFields .= "\r\n" . "<br>" . $petition->custom_field2_label . ": " . $customField2;
		}
        
        if ( $petition->displays_custom_field3 == 1  && $petition->custom_field3_included == 1) {
            $customField3 = stripslashes( $signature->custom_field3) > "" ? stripslashes( $signature->custom_field3) : "-";
			$customFields .= "\r\n" . "<br>" . $petition->custom_field3_label . ": " . $customField3;
		}
        
        if ( $petition->displays_custom_field4 == 1  && $petition->custom_field4_included == 1) {
            $customField4 = stripslashes( $signature->custom_field4) > "" ? stripslashes( $signature->custom_field4) : "-";
			$customFields .= "\r\n" . "<br>" . $petition->custom_field4_label . ": " . $customField4;
		}
        
        if ( $petition->displays_custom_field5 == 1  && $petition->custom_field5_included == 1) {
            $customField5 = stripslashes( $signature->custom_field5) > "" ? stripslashes( $signature->custom_field5) : "-";
			$customFields .= "\r\n" . "<br>" . $petition->custom_field5_label . ": " . $customField5;
		}

		// construct email message
		$email_message  = stripslashes( $greeting );
		$email_message .= stripslashes($message) ;
        //we dont want to strip html messages
        if ($options['speakout_editor'] != "html"){
           // $email_message .= stripslashes( $message );
        }
        else{
            
        }
		$email_message .= "\r\n\r\n--";
		$email_message .= "\r\n" . stripslashes( $signature->honorific . " " . $signature->first_name . ' ' . $signature->last_name );
		$email_message .= "\r\n" . "<br>" . $signature->email;
		$email_message .=  "<br>" . self::format_street_address( $signature );
        $email_message .=  "<br>" . $customFields;
		$email_message .= "\r\n\r\n" .  "<br><br>" . stripslashes( $footer );

		$from = stripslashes( $signature->first_name ) . " " . stripslashes( $signature->last_name ) . " <" . $signature->email . ">" ;
        
        // construct email headers
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";   
		$headers .= "From: " . $from  . "\r\n";
        $headers .= 'Reply-To: ' . $from . "\r\n" .'X-Mailer: PHP/' . phpversion() . "\r\n";
		
        // if BCC box is checked, $doBCC is returned from confirmations.php
        if((isset($_POST['bcc']) && $_POST['bcc']=="on") || $_POST['bcc'] == 1 || $doBCC == 1 ){
			$headers .= "Bcc:" . $signature->email . "\r\n";
		}
        
        //only add CC header if there is value in CC field
		if(stripslashes( $petition->target_email_CC ) > "" ) {
            
		    $headers .= "CC:" . stripslashes( $petition->target_email_CC ) . "\r\n";
		}
		        
		// send the petition email
		self::send( $petition->target_email, $subject, $email_message, $headers );

		
        if ( $options['webhooks'] == 'on' ) {
            $id = $petition->target_email;
            $title = $petition->title;
            $email = $petition->target_email;
            do_action( 'speakout_after_petition_sent', $id, $title, $doBCC, $from, $email,  $subject, $email_message );
        }
	}
    
	/**
	 * Sends confirmation email
	 * includes a link to confirm ownership of email account used to sign petition
	 *
	 * @param object $petition the petition being signed
	 * @param object $signature the signature
	 * @param array $options custom wp_options for this plugin
	 */
	public static function send_confirmation( $petition, $signature, $options )
	{
		$email   = stripslashes( $signature->email );
		$subject = stripslashes( $options['confirm_subject'] );
		$message = stripslashes( $options['confirm_message'] );
		$message = nl2br($message);

		$doBCC = isset($_POST['bcc']) && $_POST['bcc']=="on"  || isset($_POST['bcc']) && $_POST['bcc'] == 1 ? 1 : 0;
                
		// construct confirmation URL
		$confirmation_url = '<a href="' . home_url() . '/?dkspeakoutconfirm=' . $signature->confirmation_code . '&b=' . $doBCC  . '&lang=' . get_bloginfo( 'language' ) . '">' . home_url() . '/?dkspeakoutconfirm=' . $signature->confirmation_code . '&b=' . $doBCC . '&lang=' . get_bloginfo( 'language' ) . '</a>'; 

		// add confirmation link to email if user left it out
		if ( strpos( $message, '%confirmation_link%' ) == false ) {
			$message = $message . "\r\n" . $confirmation_url;
		}

		// replace user-supplied variables
		$search  = array( '%honorific%', '%first_name%', '%last_name%', '%petition_title%', '%confirmation_link%' );
		$replace = array( strip_tags($signature->honorific), strip_tags($signature->first_name), strip_tags($signature->last_name), strip_tags($petition->title), $confirmation_url );
		$message = str_replace( $search, $replace, $message );

		// construct email headers
		$headers = "From: " . $options['confirm_email'] . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$charset = get_bloginfo( 'charset' );
		$headers .= "Content-Type: text/html; charset=" . $charset . "\r\n";
		//$headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n"; 
 		

		// send the confirmation email
		self::send( $email, $subject, $message, $headers );
		
		if ( $options['webhooks'] == 'on' ) {
            $theId = $petition->id;
            $theTitle = $petition->title;
            do_action( 'speakout_after_confirmation_sent', $theId, $theTitle, $email );
        }
	}
    
	

	//********************************************************************************
	//* Private
	//********************************************************************************

	/**
	 * Formats address portion of email signature using appropriate commas, spaces, and new-line characters
	 *
	 * @param object $signature the signature
	 * @return string address
	 */
	public static function format_street_address( $signature )
	{
		$address  = '';

		// street address gets its own line
		if ( $signature->street_address != '' ) {
			$address .=  "\r\n" . stripslashes( $signature->street_address );
		}

		// format 'city, state postcode' line with appropriate line-break, comma and spaces
		if ( $signature->city != '' || $signature->state != '' || $signature->postcode != '' ) {
			$address .= "\r\n";

			if ( $signature->city != '' ) {
				$address .= stripslashes( $signature->city );
			}

			// if both city & state are present, separate with a comma
			if ( $signature->city != '' && $signature->state != '' ) {
				$address .= ", " ;
			}

			if ( $signature->state != '' ) {
				$address .= stripslashes( $signature->state );
			}

			if ( $signature->postcode != '' ) {
				if ( $signature->city != '' || $signature->state != '' ) {
					$address .= " ";
				}
				$address .= stripslashes( $signature->postcode );
			}
		}

		// country gets its own line
		if ( $signature->country != '' ) {
			$address .= "\r\n" . stripslashes( $signature->country );
		}
        
		return $address;
	}

	/**
	 * Sends email using WordPress' wp_mail()
	 *
	 * @param string $to email address
	 * @param string $subject email subject
	 * @param string $message email message
	 * @param string $headers email headers, should end in newline character "\r\n"
	 */
	public static function send( $to, $subject, $message, $headers )
	{
		wp_mail( $to, $subject, $message, $headers );
		
	}
	
    /** add email to ActiveCampaign (if enabled) **/
    public static function add2ActiveCampaign( 
        $apiKey, $server, $listID,
        $map1field,     $honorific,     $map2field,     $firstname, 
        $map3field,     $lastname,      $map4field,     $email, 
        $map5field,     $street,        $map6field,     $suburb, 
        $map7field,     $state,         $map8field,     $postalCode, 
        $map9field,     $country,       $map10field,    $custom1, 
        $map11field,    $custom2,       $map12field,    $custom3, 
        $map13field,     $custom4,      $map14field,    $custom5 ){
            
            $url = "https://" . $server;

            $params = array(
                'api_key'      => $apiKey,
                'api_action'   => 'contact_add',
                'api_output'   => 'serialize',
            );

            // here we define the data 
            $aclistid = 'p[' . $listID . ']';

            $post = array(
                'field['.$map1field.']'     => $honorific,
                'email'                     => $email,
                'first_name'                => $firstname,
                'last_name'                 => $lastname,
                'field['.$map5field.']'     => $street, 
                'field['.$map6field.']'     => $suburb, 
                'field['.$map7field.']'     => $state, 
                'field['.$map8field.']'     => $postalCode, 
                'field['.$map9field.']'     => $country, 
                'field['.$map10field.']'    => $custom1, 
                'field['.$map11field.']'    => $custom2,
                'field['.$map12field.']'    => $custom3, 
                'field['.$map13field.']'    => $custom4, 
                'field['.$map14field.']'    => $custom5,
                'phone'                     => '',
                'customer_acct_name'        => '',
                'tags'                      => 'SpeakOut!',
                
                // assign to lists:
                'p[' . $listID . ']'                   => $listID, // example list ID 
                'status[' . $listID . ']'              => 1, // 1: active, 2: unsubscribed 
                'instantresponders[' . $listID . ']' => 1, // set to 0 to if you don't want to sent instant autoresponders
                'lastmessage[' . $listID . ']'       => 1, // uncomment to set "send the last broadcast campaign"
            );
            
            // This section takes the input fields and converts them to the proper format
            $query = "";
            foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
            $query = rtrim($query, '& ');

            // This section takes the input data and converts it to the proper format
            $data = "";
            foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
            $data = rtrim($data, '& ');

        // clean up the url
        $url = rtrim($url, '/ ');

        // submit your request, and show (print out) the response.
        if ( !function_exists('curl_init') ) die('CURL not supported. Speak to your web host');

        // If JSON is used, check if json_decode is present (PHP 5.2.0+)
        if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
            die('JSON not supported. Speak to your web host');
        }

        // define a final API request - GET
        $api = $url . '/admin/api.php?' . $query;

        $request = curl_init($api); // initiate curl object
        curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
        curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
        
        //curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

        $response = (string)curl_exec($request); // execute curl post and store results in $response
        if ( !$response ) {
            die('Nothing was returned. Have you set up your connection to the Active Campaign server?');
        }
        
        curl_close($request); // close curl object
        $response = json_decode($response);
         if( $response->result_code == 0 ){
           mail(get_option('admin_email'),"Active Campaign error", "There has been an error adding an email address (" . $email . ") to Active Campaign in the SpeakOut! plugin.");
        }
    } // end Active Campaign.
	
    // Add email to CleverReach (if enabled)
	public static function add2CleverReach( $clientID, $clientSecret, $groupID, $email, $honorific, $firstname, $lastname, $source ){
	    
        // The official CleverReach URL, no need to change this.
        $token_url = "https://rest.cleverreach.com/oauth/token.php";
        
        // We use curl to make the request
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $token_url);
        curl_setopt($curl,CURLOPT_USERPWD, $clientID . ":" . $clientSecret);
        curl_setopt($curl,CURLOPT_POSTFIELDS, array("grant_type" => "client_credentials"));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close ($curl);
        
        // The final $result contains the access_token and some other information besides.
        // For you to debug if necessary, we dump it out here.
        // mail(get_option('admin_email'), "Success", "response = " . print_r($result) );


        // The CleverReach OAuth token endpoint
        $tokenUrl = 'https://rest.cleverreach.com/oauth/token.php';

        // Step 1: Get OAuth access token
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type'    => 'client_credentials',
            'client_id'     => $clientID
            'client_secret' => $clientSecret
        ]));

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            mail(get_option('admin_email'), "CleverReach Access Error", 'Error retrieving access token in SpeakOut! plugin: ' . curl_error($ch)); 
            curl_close($ch); // Close before terminating the process
            //return false; // Handle failure gracefully
            exit;
        }

        // Close the connection
        curl_close($ch);

        // Decode the JSON response to get the access token
        $tokenData = json_decode($response, true);

        if (!isset($tokenData['access_token'])) {
                mail(get_option('admin_email'), "CleverReach Failure", "Failed to authorise conection to server in SpeakOut! plugin. Response: " . $response);
            return false; // Handle failure gracefully
        }

        $accessToken = $tokenData['access_token'];

        // CleverReach group (list) ID where you want to add the subscriber
        $groupId = $groupID;

        // Subscriber data
        $subscriberData = [
            'email' => $email,
            'source' => $honorific ."|". $firstname ."|". $lastname ."|". $source, // Indicate the source of this subscriber
            'global_attributes' => array(
                'salutation'=>$honorific,
                'firstname'=>$firstname,
                'lastname'=>$lastname,
            ),
            'registered'=>time(),
            'activated' => 1,  // Activate the subscriber immediately
        ];

        // Initialize cURL to send the subscriber data
        $ch = curl_init();

        // The CleverReach API endpoint for adding a subscriber to a group
        $apiUrl = "https://rest.cleverreach.com/v3/groups.json/{$groupId}/receivers";

        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken,
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($subscriberData));

        // Execute the request
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            mail(get_option('admin_email'), "CleverReach Failure", "Failed to add connect or subscriber in SpeakOut! plugin. Response: " . $response);
            curl_close($ch); // Close before terminating the process
        } else {
            // Decode the response
            $result = json_decode($response, true);

            if (isset($result['id'])) {
                curl_close($ch);
            } else {
                mail(get_option('admin_email'), "CleverReach Subscription Failure", "Failed to add subscriber in SpeakOut! plugin. Response: " . $response);
                curl_close($ch);
            }
        }
    } // end cleverreach
   
    /** add email to mailchimp (if enabled) **/
    public static function add2MailChimp( $email, $firstname, $lastname, $country, $listID, $apiKey, $server, $options){

        $postData = array(
            "email_address" => $email,
            "status" => "subscribed",
            "merge_fields" => array(
                "FNAME"  => $firstname,
                "LNAME"  => $lastname,
                "COUNTRY"=>$country
                )
        );

        // Setup cURL
        $ch = curl_init('https://' . $server . '.api.mailchimp.com/3.0/lists/'.$listID.'/members/');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: apikey '.$apiKey,
                'Content-Type: application/json'
            ),
            // Send the request 
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));
        // put results into decoded array
        $response = json_decode(curl_exec($ch));
        
        // We can get mailchimp debug results - enable in settings.
        if( $response->status != "subscribed" && $options["mailchimp_error_reporting_enabled"] == "on"){
            $responseOutput = print_r($response, true);
             mail(get_option('admin_email'),"Mailchimp error", "There has been an error adding an email address (" . $email . ") to Mailchimp in the SpeakOut! plugin." .  "\n\r" . "\n\r" . "The error is: " . $response->detail . "\n\r" . "\n\r" . "You may need to send this to Steve via https://SpeakOutPetitions.com/contact ");
        }

    } // end mailchimp
 
    /** add email to mailerlite (if enabled) **/
    public static function add2Mailerlite( $email, $firstname, $lastname, $groupID, $apiKey){

        $postData = array(
            "email" => $email,
            "fields" => array(
            "name"=> $firstname,
            "last_name"=> $lastname
            )
        );
    
        $ch = curl_init('https://api.mailerlite.com/api/v2/groups/' . $groupID . '/subscribers');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'X-MailerLite-ApiKey: '.$apiKey,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));
        
        // Send the request and put results into decoded array
        $response = json_decode(curl_exec($ch));
        if( $response->status == "Error" ){
            mail(get_option('admin_email'),"Mailerlite error", "There has been an error adding an email address (" . $email . ") to Mailerlite in the SpeakOut! plugin.");
        }
    }  // end mailerlite
} // end class

?>
