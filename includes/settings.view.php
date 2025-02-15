<?php // Pro ?>
<script type="text/javascript">
// check if jquery is loaded, if not, load. Pro
  if(typeof jQuery == 'undefined'){
        document.write('<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></'+'script>');
  }
jQuery.noConflict();
jQuery(document).ready(function() {
    disable_address();
    
    jQuery('#option-display').click(function() {
        jQuery('#speakout-options').toggle();
        if (jQuery('#speakout-options').is(':hidden') ){
            jQuery('#option-context').html("display");
            jQuery('#option-target').html("if needed for support");
        }
        else{
            jQuery('#option-context').html("hide");
            jQuery('#option-target').html("");
        }
    });
        
    jQuery('#copyToClipBoard').click(function(){
      var copiedtext = jQuery("#speakout-options-txt").text();
      //copiedtext.setSelectionRange(0, 99999); //for mobile devices
      navigator.clipboard.writeText(copiedtext);
      alert("Options copied to clipboard " + copiedtext);
    });
    
    jQuery('#licenseKeyRevoke').click( function () {
        jQuery('#speakOutLoader').css('display', 'inherit');
		var licence_key = jQuery("#license_keys").val();
        jQuery.ajax({
           type: "POST",
           url: "<?php echo admin_url('admin-ajax.php'); ?>",
           data: {action:'speakout_revoke_licence_key',key:licence_key},   
           cache: false,
           success: function(response){
               window.location.href="admin.php?page=dk_speakout_top";
           }
    	}) 
    });
    
   function disable_address(){
       var stat = jQuery('input[value="list"]').is(':checked');
        if(stat){
            jQuery('#sig_email').prop('disabled', 'disabled');
            jQuery('#sig_city').prop('disabled', 'disabled');
            jQuery('#sig_state').prop('disabled', 'disabled');
            jQuery('#sig_postcode').prop('disabled', 'disabled');
            jQuery('#sig_country').prop('disabled', 'disabled');
            jQuery('#sig_custom').prop('disabled', 'disabled');
            jQuery('#sig_custom2').prop('disabled', 'disabled');
            jQuery('#sig_custom3').prop('disabled', 'disabled');
            jQuery('#sig_custom4').prop('disabled', 'disabled');
            jQuery('#sig_custom5').prop('disabled', 'disabled');
            jQuery('#sig_custom6').prop('disabled', 'disabled');
            jQuery('#sig_custom7').prop('disabled', 'disabled');
            jQuery('#sig_custom8').prop('disabled', 'disabled');
            jQuery('#sig_custom9').prop('disabled', 'disabled');
            jQuery('#sig_message').prop('disabled', 'disabled');
            jQuery('#sig_date').prop('disabled', 'disabled');
        }
        else{
            jQuery('#sig_email').prop('disabled', false);
            jQuery('#sig_city').prop('disabled', false);
            jQuery('#sig_state').prop('disabled', false);
            jQuery('#sig_postcode').prop('disabled', false);
            jQuery('#sig_country').prop('disabled', false);
            jQuery('#sig_custom').prop('disabled', false);
            jQuery('#sig_custom2').prop('disabled', false);
            jQuery('#sig_custom3').prop('disabled', false);
            jQuery('#sig_custom4').prop('disabled', false);
            jQuery('#sig_custom5').prop('disabled', false);
            jQuery('#sig_custom6').prop('disabled', false);
            jQuery('#sig_custom7').prop('disabled', false);
            jQuery('#sig_custom8').prop('disabled', false);
            jQuery('#sig_custom9').prop('disabled', false);
            jQuery('#sig_message').prop('disabled', false);
            jQuery('#sig_date').prop('disabled', false);
        }
   }
   jQuery('input[type=radio]').change(function () { 
       disable_address();
   });
   
   // open or close T and C URL settings
   if ( jQuery( 'input#display-privacypolicy' ).is(":checked") ){
        jQuery( 'div#dk-speakout-privacypolicy-url' ).slideDown();
    }
    else{
        jQuery( 'div#dk-speakout-privacypolicy-url' ).slideUp();
    }
    
	jQuery( 'input#display-privacypolicy' ).change( function () {
	    if ( jQuery( this ).is(":checked")) {
			jQuery( 'div#dk-speakout-privacypolicy-url' ).slideDown();
		} else {
			jQuery( 'div#dk-speakout-privacypolicy-url' ).slideUp();
		}
	});

// recaptcha 
   if ( jQuery( 'input#grecaptcha-status' ).is(":checked") ){
       jQuery( 'div#dk-speakout-recaptcha-keys' ).slideDown();
       jQuery( 'div#dk-speakout-hcaptcha-keys' ).slideUp();
    }
    else{
        jQuery( 'div#dk-speakout-recaptcha-keys' ).slideUp();
    }
    
	jQuery( 'input#grecaptcha-status' ).change( function () {
	    if ( jQuery( this ).is(":checked")) {
			jQuery( 'div#dk-speakout-recaptcha-keys' ).slideDown();
            jQuery( 'div#dk-speakout-hcaptcha-keys' ).slideUp();
            jQuery('input#hcaptcha-status').prop('checked', false);
		} else {
			jQuery( 'div#dk-speakout-recaptcha-keys' ).slideUp();
		}
	});
    
// hcaptcha	
   if ( jQuery( 'input#hcaptcha-status' ).is(":checked") ){
        jQuery( 'div#dk-speakout-hcaptcha-keys' ).slideDown();
        jQuery( 'div#dk-speakout-recaptcha-keys' ).slideUp();       
    }
    else{
        jQuery( 'div#dk-speakout-hcaptcha-keys' ).slideUp();        
    }
    
    jQuery( 'input#hcaptcha-status' ).change( function () {
	    if ( jQuery( this ).is(":checked")) {
			jQuery( 'div#dk-speakout-hcaptcha-keys' ).slideDown();
            jQuery( 'div#dk-speakout-recaptcha-keys' ).slideUp();
            jQuery('input#grecaptcha-status').prop('checked', false);
		} else {
			jQuery( 'div#dk-speakout-hcaptcha-keys' ).slideUp();
		}
	});
	
});
</script>
<div class="wrap" id="dk-speakout">

	<div id="icon-dk-speakout" class="icon32"><br /></div>
	<h2><?php _e( 'SpeakOut! Petitions Settings', 'speakout' ); ?></h2>
	<?php if ( $message_update ) echo '<div id="message" class="updated"><p>' . $message_update . '</p></div>'; ?>

	<form action="" method="post" id="dk-speakout-settings">
		<?php wp_nonce_field( $nonce ); ?>
		<input type="hidden" name="action" value="<?php echo $action; ?>" />
		<input type="hidden" name="tab" id="dk-speakout-tab" value="<?php echo $tab; ?>" />

		<ul id="dk-speakout-tabbar">
			<li><a class="dk-speakout-tab-01" rel="dk-speakout-tab-01"><?php _e( 'Petition Form', 'speakout' ); ?></a></li>
            <li><a class="dk-speakout-tab-02" rel="dk-speakout-tab-02"><?php _e( 'Confirmation Emails', 'speakout' ); ?></a></li>
			<li><a class="dk-speakout-tab-03" rel="dk-speakout-tab-03"><?php _e( 'Public Signature List', 'speakout' ); ?></a></li>
            <li><a class="dk-speakout-tab-04" rel="dk-speakout-tab-04"><?php _e( 'Admin Signature List', 'speakout' ); ?></a></li>
			<li><a class="dk-speakout-tab-05" rel="dk-speakout-tab-05"><?php _e( 'Admin Display', 'speakout' ); ?></a></li>
			<li><a class="dk-speakout-tab-06" rel="dk-speakout-tab-06"><?php _e( '3rd Party extras', 'speakout' ); ?>
			<li><a class="dk-speakout-tab-07" rel="dk-speakout-tab-07"><?php _e( 'Security', 'speakout' ); ?></a></li>
            <li><a class="dk-speakout-tab-08" rel="dk-speakout-tab-08"><?php _e( 'License', 'speakout' ); ?></a></li>
            <?php /* */ ?></a></li>
            
		<?php if ( $the_settings->display_anedot == 'on' ){ ?>
			<li><a class="dk-speakout-tab-10" rel="dk-speakout-tab-10"><?php _e( 'Anedot.com Donation Form Embed', 'speakout' ); ?></a></li>
		<?php } ?>
		</ul>

		<div id="dk-speakout-tab-01" class="dk-speakout-hidden dk-speakout-tabcontent">
			<h3><?php _e( 'Petition Form', 'speakout' ); ?></h3>
            <div class='settingstab1-description'><?php _e("These settings apply to all petitions"); ?></div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e( 'Petition Theme', 'speakout' ); ?><br /><span class="description">(shortcode)</span></th>
					<td>
						<label for="theme-default"><input type="radio" name="petition_theme" id="theme-default" value="default" <?php if ( $the_settings->petition_theme == 'default' ) echo 'checked="checked"'; ?> /> <?php _e( 'Default', 'speakout' ); ?></label>
						<label for="petition-theme-basic"><input type="radio" name="petition_theme" id="petition-theme-basic"  value="basic" <?php if ( $the_settings->petition_theme == 'basic' ) echo 'checked="checked"'; ?> /> <?php _e( 'Basic', 'speakout' ); ?></label>
						<label for="petition-theme-none"><input type="radio" name="petition_theme" id="petition-theme-none" value="none" <?php if ( $the_settings->petition_theme == 'none' ) echo 'checked="checked"'; ?> /> <?php _e( 'Custom', 'speakout' ); ?> <span class="description">(<?php _e( 'use', 'speakout' ); ?> /wp-content/theme/(current theme)/petition.css) <a href='https://speakoutpetitions.com/faqconc/can-i-preserve-custom-css/' target="_blank">?</a></span></label>
					</td>
				</tr>
				<tr>
                    <th scope="row"><?php _e( 'Message editor style', 'speakout' ); ?> <span class="description"> <a href='https://speakoutpetitions.com/faqconc/can-i-format-the-petition-message/' target="_blank">?</a></th>
					<td>
						<label for="speakout-editor-html"><input type="radio" name="speakout_editor" id="speakout-editor-html" value="html" <?php if ( $the_settings->speakout_editor == 'html' ) echo 'checked="checked"'; ?> /> <?php _e( 'HTML', 'speakout' ); ?></label>
						<label for="speakout-editor-markdown"><input type="radio" name="speakout_editor" id="speakout_editor-markdown" value="markdown" <?php if ( $the_settings->speakout_editor != 'html' ) echo 'checked="checked"'; ?> /> <?php _e( 'Markdown', 'speakout' ); ?> </span></label>
					</td>
				</tr>
				<tr>
                    <th scope="row"><?php _e( 'Widget Theme', 'speakout' ); ?></th>
					<td>
						<label for="widget-theme-default"><input type="radio" name="widget_theme" id="widget-theme-default" value="default" <?php if ( $the_settings->widget_theme == 'default' ) echo 'checked="checked"'; ?> /> <?php _e( 'Default', 'speakout' ); ?></label>
						<label for="widget-theme-none"><input type="radio" name="widget_theme" id="widget-theme-none" value="none" <?php if ( $the_settings->widget_theme == 'none' ) echo 'checked="checked"'; ?> /> <?php _e( 'Custom', 'speakout' ); ?> <span class="description">(<?php _e( 'use', 'speakout' ); ?> /wp-content/theme/current theme/petition-widget.css) <a href='https://speakoutpetitions.com/faqconc/can-i-preserve-custom-css/' target="_blank">?</a></span></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Submit Button Text', 'speakout' ); ?></th>
					<td><label for="button_text"><input  name="button_text" id="button_text" type="text" class="regular-text" value="<?php echo esc_attr( $the_settings->button_text ); ?>" /></label></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Success Message', 'speakout' ); ?></th>
					<td>
						<label for="success_message"><textarea name="success_message" id="success_message" cols="80" rows="2"><?php echo $the_settings->success_message; ?></textarea></label>
						<br /><strong><?php _e( 'Accepted variables:', 'speakout' ); ?></strong> %first_name% &nbsp; %last_name% &nbsp; %signature_number%  
						<br /><strong><?php _e( 'Accepted tags:', 'speakout' ); ?></strong> &lt;a&gt; &lt;em&gt; &lt;strong> &lt;p&gt;
					&nbsp;<a href="https://speakoutpetitions.com/faqconc/how-do-i-customise-the-success-message/" target="_blank">?</a></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Petition fade out after signing?', 'speakout' ); ?></th>
					<td><input type="hidden" name="petition_fade" value="disabled" >
						<label for="petition_fade" /><input type="checkbox" name="petition_fade" value='enabled' id="petition_fade"  <?php if ( $the_settings->petition_fade == 'enabled' ) echo 'checked="checked"'; ?> /> (instead of instant hide)</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Share Message', 'speakout' ); ?></th>
					<td><label for="share_message"><input value="<?php echo esc_attr( $the_settings->share_message ); ?>" name="share_message" id="share_message" type="text" class="regular-text"  /></label></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Expiration Message', 'speakout' ); ?></th>
					<td><label for="expiration_message"><input value="<?php echo esc_attr( $the_settings->expiration_message ); ?>" name="expiration_message" id="expiration_message" type="text" class="regular-text"  /></label></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Already Signed Message', 'speakout' ); ?></th>
					<td><label for="already_signed_message"><input  name="already_signed_message" id="already_signed_message" type="text" class="regular-text" value="<?php echo esc_attr( $the_settings->already_signed_message ); ?>" /></label></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Opt-in Default', 'speakout' ); ?></th>
					<td>
						<label for="optin-checked" /><input type="radio" name="optin_default" id="optin-checked" value="checked" <?php if ( $the_settings->optin_default == 'checked' ) echo 'checked="checked"'; ?> /> <?php _e( 'Checked', 'speakout' ); ?></label>
						<label for="optin-unchecked" /><input type="radio" name="optin_default" id="optin-unchecked" value="unchecked" <?php if ( $the_settings->optin_default == 'unchecked' ) echo 'checked="checked"'; ?> /> <?php _e( 'Unchecked', 'speakout' ); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Display signature count', 'speakout' ); ?></th>
					<td>
						<label for="display-count-yes" /><input type="checkbox" name="display_count" id="display-count-yes" value="1" <?php if ( $the_settings->display_count == '1' ) echo 'checked="checked"'; ?> /> <?php _e( 'Yes', 'speakout' ); ?>  <span class="speakoutInfo">(<?php _e( 'at the bottom of the petition form', 'speakout' ); ?>)</span></label>
					</td>
				</tr>
				                <tr valign="top">
					<th scope="row"><?php _e( 'Display honorific field', 'speakout' ); ?></th>
					<td>
						<label for="display-honorific-yes" />
                        <input type="hidden" name="display_honorific" value="disabled">
                        <input type="checkbox" name="display_honorific" id="display-honorific-yes" value="enabled" <?php if ( $the_settings->display_honorific == 'enabled' ) echo 'checked="checked"'; ?> /> <?php _e( 'Yes', 'speakout' ); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Display BCC field', 'speakout' ); ?></th>
					<td>
						<label for="display-bcc-yes" />
                        <input type="hidden" name="display_bcc" value="disabled">
                        <input type="checkbox" name="display_bcc" id="display-bcc-yes" value="enabled" <?php if ( $the_settings->display_bcc == 'enabled' ) echo 'checked="checked"'; ?> /> <?php _e( 'Yes', 'speakout' ); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'EU postal code position?', 'speakout' ); ?></th>
					<td><input type="hidden" name="eu_postalcode" value="disabled" >
						<label for="display-eu_postalcode" /><input type="checkbox" name="eu_postalcode" value='enabled' id="eu_postalcode" <?php if ( $the_settings->eu_postalcode == 'enabled' ) echo 'checked="checked"'; ?> /> <?php _e( 'Yes', 'speakout' ); ?> (<?php _e( 'In EU postal code comes before city', 'speakout' ); ?>)</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Signature count format', 'speakout' ); ?></th>
					<td>
						<label for="thousands-separator" />
						    <?php _e( 'Thousands separator', 'speakout' ); ?> <input type="text" name="thousands_separator" value='<?php echo $the_settings->thousands_separator; ?>' size="1" maxlength="1"  id="thousands-separator" >  
						    <?php _e( 'Decimal separator', 'speakout' ); ?> <input type="text" name="decimal_separator" value='<?php echo $the_settings->decimal_separator; ?>' size="1" maxlength="1" id="decimal-separator" >
						<?php _e( 'currently', 'speakout' ); ?> 1<?php echo $the_settings->thousands_separator; ?>234<?php echo $the_settings->decimal_separator; ?>56</label> 
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Display Privacy Policy accept?', 'speakout' ); ?></th>
					<td><input type="hidden" name="display_privacypolicy" value="disabled" >
						<label for="display-privacypolicy" /><input type="checkbox" name="display_privacypolicy" value='enabled' id="display-privacypolicy" <?php if ( $the_settings->display_privacypolicy == 'enabled' ) echo 'checked="checked"'; ?> /> <?php _e( 'Yes', 'speakout' ); ?> (<?php _e( 'GDPR', 'speakout' ); ?>)</label>
						<div id="dk-speakout-privacypolicy-url">Privacy Policy URL: <input type="text"  name="privacypolicy_url" id="privacypolicy-url" class="regular-text" <?php if ( $the_settings->privacypolicy_url > "" )  echo 'value="'. $the_settings->privacypolicy_url . '"';  ?> ></div>
					</td>
				</tr>
				
                <tr valign="top">
					<th scope="row"><?php _e( 'Enable Google recaptcha?', 'speakout' ); ?></th>
					<td>
						
                        <label for="grecaptcha-status" />
                        <input type="hidden" name="g_recaptcha_status" value="off">
                        <input type="checkbox" name="g_recaptcha_status" id="grecaptcha-status" value="on" <?php if($the_settings->g_recaptcha_status == "on") echo 'checked="checked"';  ?> />  You will need a pair of keys from <a href="https://google.com/recaptcha" target="_blank">https://google.com/recaptcha</a></label>
					    <div id="dk-speakout-recaptcha-keys">
					        <select name="g_recaptcha_version" id="recaptcha-version">
					            <option value='2' <?php if ( $the_settings->g_recaptcha_version == 2 ) echo 'SELECTED="SELECTED"'; ?>>V2</option>
					            <option value='3' <?php if ( $the_settings->g_recaptcha_version == 3 || $the_settings->g_recaptcha_version == 0 ) echo 'SELECTED="SELECTED"'; ?>>V3</option>
					            
					        </select>
					        <label for="recaptcha-site-key" />Site key: <input type="text"  name="g_recaptcha_site_key" id="recaptcha-site-key" class="regular-text" <?php if ( $the_settings->g_recaptcha_site_key > "" )  echo 'value="'. $the_settings->g_recaptcha_site_key . '"';  ?> ></label>
					        <label for="recaptcha-secret-key" />Secret key: <input type="text"  name="g_recaptcha_secret_key" id="recaptcha-secret-key" class="regular-text" <?php if ( $the_settings->g_recaptcha_secret_key > "" )  echo 'value="'. $the_settings->g_recaptcha_secret_key . '"';  ?> ></label>
					    </div>
					</td>
				</tr>
				
                <tr valign="top">
					<th scope="row"><?php _e( 'Enable hCaptcha?', 'speakout' ); ?></th>
					<td>
						
                        <label for="hcaptcha-status" />
                        <input type="hidden" name="hcaptcha_status" value="off">
                        <input type="checkbox" name="hcaptcha_status"  id="hcaptcha-status" value="on" <?php if($the_settings->hcaptcha_status == "on") echo 'checked="checked"';  ?> /> A google alternative, you will need a pair of keys from <a href="https://hCaptcha.com/?r=61aa810f11b8" target="_blank">https://hCaptcha.com</a></label>
					    <div id="dk-speakout-hcaptcha-keys">
                           
                            <label for="hcaptcha-site-key" />Site key: <input type="text"  name="hcaptcha_site_key" id="hcaptcha-site-key" class="regular-text" <?php if ( $the_settings->hcaptcha_site_key > "" )  echo 'value="'. $the_settings->hcaptcha_site_key . '"';  ?> ></label>
                            <label for="hcaptcha-secret-key" />Secret key: <input type="text"  name="hcaptcha_secret_key" id="hcaptcha-secret-key" class="regular-text" <?php if ( $the_settings->hcaptcha_secret_key > "" )  echo 'value="'. $the_settings->hcaptcha_secret_key . '"';  ?> ></label>
					    </div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Display sharing icons?', 'speakout' ); ?></th>
					<td><input type="hidden" name="display_sharing" value="off" >
						<label for="display-sharing" /><input type="checkbox" name="display_sharing" value="on" <?php if($the_settings->display_sharing == "enabled" || $the_settings->display_sharing == "on") echo 'checked="checked"';  ?> /> Uncheck to hide Facebook and X icons</label>
					</td>
				</tr>
			</table>
		</div>

        <div id="dk-speakout-tab-02" class="dk-speakout-hidden dk-speakout-tabcontent">
			<h3><?php _e( 'Confirmation Emails', 'speakout' ); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="confirm_email"><?php _e( 'Email From', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->confirm_email ); ?>" name="confirm_email" id="confirm_email" type="text" class="regular-text" /> <span style="color:red;font-weight:bold;">To get this to work, you need to <a href="https://speakoutpetitions.com/confirmation-emails/" target = "_blank">read this</a></span></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="confirm_subject"><?php _e( 'Email Subject', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->confirm_subject ); ?>" name="confirm_subject" id="confirm_subject" type="text" class="regular-text" /> <strong><?php _e( 'Accepted variables:', 'speakout' ); ?></strong> %petition_title% &nbsp;</strong> </td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="confirm_message"><?php _e( 'Email Message', 'speakout' ); ?></label></th>
					<td>
						<textarea name="confirm_message" id="confirm_message" cols="80" rows="6"><?php echo str_replace("<br />", "", $the_settings->confirm_message); ?></textarea>
						<br /><strong><?php _e( 'Accepted variables:', 'speakout' ); ?></strong> %first_name% &nbsp; %last_name% &nbsp; %petition_title% &nbsp; %confirmation_link%
						<br /><strong><?php _e( 'Accepted tags:', 'speakout' ); ?></strong> &lt;table&gt;, &lt;tr&gt;, &lt;td&gt;, &lt;span&gt;, &lt;hr&gt;, &lt;strong&gt;, &lt;em&gt;
					</td>
				</tr>
			</table>
		</div>

		<div id="dk-speakout-tab-03" class="dk-speakout-hidden dk-speakout-tabcontent">
			<h3><?php _e( 'Public Signature List', 'speakout' ); ?></h3>
            <div class='settingstab3-description'><?php _e("These settings apply to signatures displayed on your site using the shortcode"); ?></div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="signaturelist_header"><?php _e( 'Title', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->signaturelist_header ); ?>" name="signaturelist_header" id="signaturelist_header" type="text" class="regular-text" /></td>
				</tr>
				<th scope="row"><?php _e( 'Theme', 'speakout' ); ?></th>
					<td>
						<label for="signaturelist_theme-default"><input type="radio" name="signaturelist_theme" id="signaturelist_theme-default" value="default" <?php if ( $the_settings->signaturelist_theme == 'default' ) echo 'checked="checked"'; ?> /> <?php _e( 'Default', 'speakout' ); ?></label>
                        
						<label for="signaturelist_theme-none"><input type="radio" name="signaturelist_theme" id="signaturelist_theme-none" value="custom" <?php if ( $the_settings->signaturelist_theme == 'custom' ) echo 'checked="checked"'; ?> />  <?php _e( 'Custom', 'speakout' ); ?> <span class="description">(<?php _e( 'use', 'speakout' ); ?>  /wp-content/theme/(current theme)/petition-signaturelist.css) <a href='https://speakoutpetitions.com/faqconc/can-i-preserve-custom-css/' target="_blank">?</a></span></label>
					</td>
                </tr>
                <tr><th scope="row"></th><td><?php _e("To style the signature list you are best using your theme's"); ?> <em><?php _e("Additional CSS"); ?></em> <?php _e("setting"); ?></td></tr>
				
				<tr valign="top">
					<th scope="row"><label for="signaturelist_rows"><?php _e( 'Rows', 'speakout' ); ?></span></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->signaturelist_rows ); ?>" name="signaturelist_rows" id="signaturelist_rows" type="text" class="small-text" />  <span class="description"><?php _e( '0 to display all', 'speakout' ); ?></span></td>
				</tr>
                <tr valign="top">
				<th scope="row"><?php _e( 'Display', 'speakout' ); ?><br><span class="dk-speakout-smallText"><?php _e('Changing to "list" will clear column settings below', 'speakout'); ?></span></th>
					<td>
						<label for="signaturelist_display-table"><input type="radio" name="signaturelist_display" id="signaturelist_display-table" value="table" <?php if ( $the_settings->signaturelist_display == 'table' ) echo 'checked="checked"'; ?> /> <?php _e( 'table', 'speakout' ); ?></label>
						
                        <label for="signaturelist_display-block"><input type="radio" name="signaturelist_display" id="signaturelist_display-block"  value="block" <?php if ( $the_settings->signaturelist_display == 'block' ) echo 'checked="checked"'; ?> /> <?php _e( 'inline blocks - very styleable', 'speakout' ); ?> <a href="https://speakoutpetitions.com/faqconc/can-i-style-the-signature-list/" target="_blank">?</a></label>
						
                        <label for="signaturelist_display-list"><input type="radio" name="signaturelist_display" id="signaturelist_display-list"  value="list" <?php if ( $the_settings->signaturelist_display == 'list' ) echo 'checked="checked"'; ?>  /> <?php _e( 'long list (comma separated)', 'speakout' ); ?> </label>
					</td>
				</tr>
                <tr valign="top">
					<th scope="row"><?php _e( 'Columns', 'speakout' ); ?></th>
					<td>
                        <input type="checkbox" id="sig_count" name="sig_count" checked="checked" disabled="disabled" /> 
						<label for="sig_count" class="dk-speakout-inline dk-speakout-disabled"><?php _e( 'Count', 'speakout'); ?></label><br />
                        
						<input type="checkbox" id="sig_name" name="sig_name" checked="checked" disabled="disabled" /> 
						<label for="sig_name" class="dk-speakout-inline dk-speakout-disabled"><?php _e( 'Name', 'speakout'); ?></label><br />
                        
                        <input type="checkbox" id="sig_email" name="sig_email" <?php if ( $the_settings->sig_email == 1 ) echo 'checked="checked"'; ?>  /> 
						<label for="sig_email" class="dk-speakout-inline sig_email"><?php _e( 'Email address - unless disabled', 'speakout'); ?> <a href="https://speakoutpetitions.com/faqconc/why-cant-no-email-address-be-reversed/" target="_blank">?</a> <span class="emailWarning" ><?php if($the_settings->sig_email == 1){ _e('Are you sure you want to publicly display email addresses?', 'speakout'); } ?></span></label><br />
                        
                        <input type="checkbox" id="sig_city" name="sig_city" <?php if ( $the_settings->sig_city == 1 ) echo 'checked="checked"'; ?> /> 
						<label for="sig_city" class="dk-speakout-inline"><?php _e( 'City', 'speakout'); ?></label><br />

						<input type="checkbox" id="sig_state" name="sig_state" <?php if ( $the_settings->sig_state == 1 ) echo 'checked="checked"'; ?> /> 
						<label for="sig_state" class="dk-speakout-inline"><?php _e( 'State / Province', 'speakout'); ?></label><br />

						<input type="checkbox" id="sig_postcode" name="sig_postcode" <?php if ( $the_settings->sig_postcode == 1 ) echo 'checked="checked"'; ?> /> 
						<label for="sig_postcode" class="dk-speakout-inline"><?php _e( 'Postal Code', 'speakout'); ?></label><br />

						<input type="checkbox" id="sig_country" name="sig_country" <?php if ( $the_settings->sig_country == 1 ) echo 'checked="checked"'; ?> /> 
						<label for="sig_country" class="dk-speakout-inline"><?php _e( 'Country', 'speakout'); ?></label><br />
						
						<input type="checkbox" id="sig_custom" name="sig_custom" <?php if ( $the_settings->sig_custom == 1 ) echo 'checked="checked"'; ?> /> 
						<label for="sig_custom" class="dk-speakout-inline"><?php _e( 'Custom Field 1', 'speakout'); ?></label><br />
                        
                        <input type="checkbox" id="sig_custom2" name="sig_custom2" <?php if ( $the_settings->sig_custom2 == 1 ) echo 'checked="checked"'; ?> /> 
						<label for="sig_custom2" class="dk-speakout-inline"><?php _e( 'Custom Field 2', 'speakout'); ?></label><br />
                        
                        <input type="checkbox" id="sig_custom3" name="sig_custom3" <?php if ( $the_settings->sig_custom3 == 1 ) echo 'checked="checked"'; ?>  /> 
						<label for="sig_custom3" class="dk-speakout-inline"><?php _e( 'Custom Field 3', 'speakout'); ?></label><br />
                        
                        <input type="checkbox" id="sig_custom4" name="sig_custom4" <?php if ( $the_settings->sig_custom4 == 1 ) echo 'checked="checked"'; ?>  /> 
						<label for="sig_custom4" class="dk-speakout-inline"><?php _e( 'Custom Field 4', 'speakout'); ?></label><br />
                        
                        <input type="checkbox" id="sig_custom5" name="sig_custom5" <?php if ( $the_settings->sig_custom5 == 1 ) echo 'checked="checked"'; ?>  />
						<label for="sig_custom5" class="dk-speakout-inline"><?php _e( 'Custom drop-down field', 'speakout'); ?></label><br />
						
						<input type="checkbox" id="sig_custom6" name="sig_custom6" <?php if ( $the_settings->sig_custom6 == 1 ) echo 'checked="checked"'; ?>  /> 
						<label for="sig_custom6" class="dk-speakout-inline"><?php _e( 'Custom Checkbox 1', 'speakout'); ?></label><br />
						
						<input type="checkbox" id="sig_custom7" name="sig_custom7" <?php if ( $the_settings->sig_custom7 == 1 ) echo 'checked="checked"'; ?>  /> 
						<label for="sig_custom7" class="dk-speakout-inline"><?php _e( 'Custom Checkbox 2', 'speakout'); ?></label><br />
                        
                        <input type="checkbox" id="sig_custom8" name="sig_custom8" <?php if ( $the_settings->sig_custom8 == 1 ) echo 'checked="checked"'; ?>  /> 
						<label for="sig_custom8" class="dk-speakout-inline"><?php _e( 'Custom Checkbox 3', 'speakout'); ?></label><br />
						
						<input type="checkbox" id="sig_custom9" name="sig_custom9" <?php if ( $the_settings->sig_custom9 == 1 ) echo 'checked="checked"'; ?>  /> 
						<label for="sig_custom9" class="dk-speakout-inline"><?php _e( 'Custom Checkbox 4', 'speakout'); ?></label><br />
                        
                        <input type="checkbox" id="sig_message" name="sig_message" <?php if ( $the_settings->sig_message == 1 ) echo 'checked="checked"'; ?> />
						<label for="sig_message" class="dk-speakout-inline"><?php _e( 'Custom Message', 'speakout'); ?></label><br />

						<input type="checkbox" id="sig_date" name="sig_date" <?php if ( $the_settings->sig_date == 1 ) echo 'checked="checked"'; ?> /> 
						<label for="sig_date" class="dk-speakout-inline"><?php _e( 'Date', 'speakout'); ?></label>
						
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Display country flags?', 'speakout' ); ?></th>
					<td><label for="display_flags" />
				        <input type="hidden" name="display_flags" value="off">
                        <input type="checkbox" name="display_flags"  <?php if( $the_settings->display_flags == "on"){echo 'checked="checked"'; }?> />
						     <?php _e( 'requires Country column to be enabled above', 'speakout' ); ?> 
						</label>
					</td>
				</tr>
                <tr valign="top">
					<th scope="row"><?php _e( 'Privacy', 'speakout' ); ?></th>
					<td>
						<label for="signaturelist_privacy-enabled"><input type="radio" name="signaturelist_privacy" id="signaturelist_privacy-enabled" value="enabled" <?php if ( $the_settings->signaturelist_privacy == 'enabled' ) echo 'checked="checked"'; ?> /> <?php _e( 'enabled - only show first letter of surname', 'speakout' ); ?></label>
						<label for="signaturelist_privacy-disabled"><input type="radio" name="signaturelist_privacy" id="signaturelist_privacy-disabled" value="disabled" <?php if ( $the_settings->signaturelist_privacy == 'disabled' ) echo 'checked="checked"'; ?> /> <?php _e( 'disabled', 'speakout' ); ?> </label>
					</td>
				</tr>

			</table>
		</div>

        <div id="dk-speakout-tab-04" class="dk-speakout-hidden dk-speakout-tabcontent">
            <h3><?php _e( 'Admin Signature List', 'speakout' ); ?></h3>
            <div class='settingstab4-description'><?php _e("Settings for the dashboard signature list"); ?></div>
            <table class="form-table">
                <tr valign="top">
					<th scope="row"><?php _e( 'Columns to display', 'speakout' ); ?></th>
            
					<td>
						<input type="checkbox" id="sigtab_signer" name="sigtab_signer" checked="checked" disabled /> 
						<label for="sigtab_signer" class="dk-speakout-inline"><?php _e( 'Name', 'speakout'); ?></label><br />

						<input type="checkbox" id="sigtab_email" name="sigtab_email" <?php if ( $the_settings->sigtab_email == 'on' ) echo 'checked="checked"'; ?>  /> 
						<label for="sigtab_email" class="dk-speakout-inline"><?php _e( 'Email', 'speakout'); ?></label><br />
						
						<input type="checkbox" id="sigtab_petition_info" name="sigtab_petition_info" <?php if ( $the_settings->sigtab_petition_info == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_petition_info" class="dk-speakout-inline"><?php _e( 'Petition info', 'speakout'); ?></label><br />

						<input type="hidden" name="sigtab_street_address" value="off">
                        <input type="checkbox" id="sigtab_street_address" name="sigtab_street_address" <?php if ( $the_settings->sigtab_street_address == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_street_address" class="dk-speakout-inline"><?php _e( 'Street', 'speakout'); ?></label><br />

						<input type="hidden" name="sigtab_city" value="off">
                        <input type="checkbox" id="sigtab_city" name="sigtab_city" <?php if ( $the_settings->sigtab_city == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_city" class="dk-speakout-inline"><?php _e( 'City', 'speakout'); ?></label><br />

						<input type="hidden" name="sigtab_state" value="off">
                        <input type="checkbox" id="sigtab_state" name="sigtab_state" <?php if ( $the_settings->sigtab_state == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_state" class="dk-speakout-inline"><?php _e( 'State', 'speakout'); ?></label><br />

						<input type="hidden" name="sigtab_postalcode" value="off">
                        <input type="checkbox" id="sigtab_postalcode" name="sigtab_postalcode" <?php if ( $the_settings->sigtab_postalcode == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_postalcode" class="dk-speakout-inline"><?php _e( 'Postal code', 'speakout'); ?></label><br />
						
						<input type="hidden" name="sigtab_country" value="off">
                        <input type="checkbox" id="sigtab_country" name="sigtab_country" <?php if ( $the_settings->sigtab_country == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_country" class="dk-speakout-inline"><?php _e( 'Country', 'speakout'); ?></label><br />

						<input type="hidden" name="sigtab_custom_field1" value="off">
                        <input type="checkbox" id="sigtab_custom_field1" name="sigtab_custom_field1" <?php if ( $the_settings->sigtab_custom_field1 == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_custom_field1" class="dk-speakout-inline"><?php _e( 'Custom field 1', 'speakout'); ?></label><br />
                        
                        <input type="hidden" name="sigtab_custom_field2" value="off">
                        <input type="checkbox" id="sigtab_custom_field2" name="sigtab_custom_field2" <?php if ( $the_settings->sigtab_custom_field2 == 'on' ) echo 'checked="checked"'; ?> />
						<label for="sigtab_custom_field2" class="dk-speakout-inline"><?php _e( 'Custom field 2', 'speakout'); ?></label><br />
                        
                        <input type="hidden" name="sigtab_custom_field3" value="off">
                        <input type="checkbox" id="sigtab_custom_field3" name="sigtab_custom_field3" <?php if ( $the_settings->sigtab_custom_field3 == 'on' ) echo 'checked="checked"'; ?>  />
						<label for="sigtab_custom_field3" class="dk-speakout-inline"><?php _e( 'Custom field 3', 'speakout'); ?></label><br />
                        
                        <input type="hidden" name="sigtab_custom_field4" value="off">
                        <input type="checkbox" id="sigtab_custom_field4" name="sigtab_custom_field4" <?php if ( $the_settings->sigtab_custom_field4 == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_custom_field4" class="dk-speakout-inline"><?php _e( 'Custom field 4', 'speakout'); ?></label><br />
                        
                        <input type="hidden" name="sigtab_custom_field5" value="off">
                        <input type="checkbox" id="sigtab_custom_field5" name="sigtab_custom_field5" <?php if ( $the_settings->sigtab_custom_field5 == 'on' ) echo 'checked="checked"'; ?>  />
						<label for="sigtab_custom_field5" class="dk-speakout-inline"><?php _e( 'Custom field 5', 'speakout'); ?></label><br />
						
						<input type="hidden" name="sigtab_custom_field6" value="off">
                        <input type="checkbox" id="sigtab_custom_field6" name="sigtab_custom_field6" <?php if ( $the_settings->sigtab_custom_field6 == 'on' ) echo 'checked="checked"'; ?> />
						<label for="sigtab_custom_field6" class="dk-speakout-inline"><?php _e( 'Custom Checkbox 1', 'speakout'); ?></label><br />
						
						<input type="hidden" name="sigtab_custom_field7" value="off">
                        <input type="checkbox" id="sigtab_custom_field7" name="sigtab_custom_field7" <?php if ( $the_settings->sigtab_custom_field7 == 'on' ) echo 'checked="checked"'; ?>  />
						<label for="sigtab_custom_field7" class="dk-speakout-inline"><?php _e( 'Custom Checkbox 2', 'speakout'); ?></label><br />
                        
						<input type="hidden" name="sigtab_custom_field8" value="off">
                        <input type="checkbox" id="sigtab_custom_field8" name="sigtab_custom_field8" <?php if ( $the_settings->sigtab_custom_field8 == 'on' ) echo 'checked="checked"'; ?> />
						<label for="sigtab_custom_field8" class="dk-speakout-inline"><?php _e( 'Custom Checkbox 3', 'speakout'); ?></label><br />
						
						<input type="hidden" name="sigtab_custom_field9" value="off">
                        <input type="checkbox" id="sigtab_custom_field9" name="sigtab_custom_field9" <?php if ( $the_settings->sigtab_custom_field9 == 'on' ) echo 'checked="checked"'; ?>  />
						<label for="sigtab_custom_field9" class="dk-speakout-inline"><?php _e( 'Custom Checkbox 4', 'speakout'); ?></label><br />
                        
						<input type="checkbox" id="sigtab_confirmed_status" name="sigtab_confirmed_status" <?php if ( $the_settings->sigtab_confirmed_status == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_confirmed_status" class="dk-speakout-inline"><?php _e( 'Confirmed status', 'speakout'); ?></label><br />

						<input type="checkbox" id="sigtab_optin" name="sigtab_optin" <?php if ( $the_settings->sigtab_optin == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_optin" class="dk-speakout-inline"><?php _e( 'Email Opt-in', 'speakout'); ?></label><br />
                        
                        <input type="checkbox" id="sigtab_date_signed" name="sigtab_date_signed" <?php if ( $the_settings->sigtab_date_signed == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_date_signed" class="dk-speakout-inline"><?php _e( 'Date signed', 'speakout'); ?></label><br />
						
						<input type="hidden" name="sigtab_display_time" value="off">
                        <input type="checkbox" id="sigtab_display_time" name="sigtab_display_time" <?php if ( $the_settings->sigtab_display_time == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_display_time" class="dk-speakout-inline"><?php _e( 'Display time signed?', 'speakout'); ?></label><br />

						<input type="hidden" name="sigtab_IP_address" value="off">
                        <input type="checkbox" id="sigtab_IP_address" name="sigtab_IP_address" <?php if ( $the_settings->sigtab_IP_address == 'on' ) echo 'checked="checked"'; ?> /> 
						<label for="sigtab_IP_address" class="dk-speakout-inline"><?php _e( 'IP address', 'speakout'); ?></label><br />
					</td>
				</tr>
								<tr valign="top">
					<th scope="row"><?php _e( 'CSV file includes', 'speakout' ); ?><br /><shortcode></th>
					<td>
						<label for="csv-signatures-all"><input type="radio" name="csv_signatures" id="csv-signatures-all" value="all" <?php if ( $the_settings->csv_signatures == 'all' ) echo 'checked="checked"'; ?> /> <?php _e( 'All signatures', 'speakout' ); ?></label>
						
                        <label for="csv-signatures-single-optin"><input type="radio" name="csv_signatures" id="csv-signatures-single-optin" value="single_optin"  <?php if ( $the_settings->csv_signatures == 'single_optin' ) echo 'checked="checked"'; ?> /> <?php _e( 'Only opt-in signatures', 'speakout' ); ?></label>
						
                        <label for="csv-signatures-double-optin"><input type="radio" name="csv_signatures" id="csv-signatures-double-optin"  value="double_optin"  <?php if ( $the_settings->csv_signatures == 'double_optin' ) echo 'checked="checked"'; ?> /> <?php _e( 'Only double opt-in signatures', 'speakout' ); ?> <span class="description">(<?php _e( 'opt-in + confirmed', 'speakout' ); ?>)</span></label>
                        
                        <label for="csv-signatures-confirmed"><input type="radio" name="csv_signatures" id="csv-signatures-confirmed" value="confirmed"  <?php if ( $the_settings->csv_signatures == 'confirmed' ) echo 'checked="checked"'; ?> /> <?php _e( 'Only confirmed signatures', 'speakout' ); ?> </label>
					</td>
                                    
				</tr>
            </table>
        </div>
		
		<div id="dk-speakout-tab-05" class="dk-speakout-hidden dk-speakout-tabcontent">
			<h3><?php _e( 'Admin Display', 'speakout' ); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="petitions_rows"><?php _e( 'Petitions table shows', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->petitions_rows ); ?>" name="petitions_rows" id="petitions_rows" type="text" class="small-text" /> <?php _e( 'rows - default = 20', 'speakout' ); ?></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="signatures_rows"><?php _e( 'Signatures table shows', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->signatures_rows ); ?>" name="signatures_rows" id="signatures_rows" type="text" class="small-text" /> <?php _e( 'rows - default = 50', 'speakout' ); ?></td>
				</tr>
                
			</table>
		</div>

		<div id="dk-speakout-tab-06" class="dk-speakout-hidden dk-speakout-tabcontent">
			<h3><?php _e( '3rd Party extras', 'speakout' ); ?></h3>
			<table class="form-table">
				<tr valign="top">
			        <th scope="row"><?php _e( 'Mailchimp error reporting?', 'speakout'); ?></th>
                    <td><input type="hidden" name="mailchimp_error_reporting_enabled" value="off" >
                        <input type="checkbox" name="mailchimp_error_reporting_enabled" value = "on" <?php if( $the_settings->mailchimp_error_reporting_enabled == "on" ) { echo "checked='checked'"; } ?>  /> Check to have Mailchimp errors emailed to you - if it is working, this isn't needed. 
                     <a href="https://speakoutpetitions.com/mailchimp/#mailchimp-error" target="_blank">?</a>
                     </td>
                </tr>
			
				<tr valign="top">
					<th scope="row"><?php _e( 'Debug mailchimp?', 'speakout'); ?></th>
					<td><input type="Checkbox" id="mailchimp_debug_enabled" name="mailchimp_debug_enabled" <?php if ( $the_settings->mailchimp_debug_enabled == "on" ) echo ' checked="checked"'; ?> /> <?php _e( 'if submissions not getting to mailchimp', 'speakout' ); ?> <a href="https://speakoutpetitions.com/faqconc/mailchimp/" target="blank" >?</a>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e( 'Enable Anedot.com?', 'speakout' ); ?></th>
					<td><input type="hidden" name="display_anedot" value="off" >
						<label for="display-anedot" /><input type="checkbox" name="display_anedot"  <?php if($the_settings->display_anedot == "on") echo 'checked="checked"';  ?> /> <?php _e( 'Anedot.com is a 3rd party fund raising site', 'speakout' ); ?></label>
					</td>
				</tr>
			</table>
		</div>
		
        <div id="dk-speakout-tab-07" class="dk-speakout-hidden dk-speakout-tabcontent">
			<h3><?php _e( 'Security', 'speakout' ); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="webhooks"><?php _e( 'Webhooks enabled', 'speakout' ); ?></label></th>
					<td><input type="checkbox" id="webhooks" name="webhooks" <?php if ( $the_settings->webhooks == 'on' ) echo 'checked="checked"'; ?> value = "on" /> <a href="https://speakoutpetitions.com/webhooks" target="_blank">?</a></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="updater"><?php _e( 'Enable Wordpress updater', 'speakout' ); ?></label></th>
					<td><input type="checkbox" id="updater" name="updater" <?php if ( $the_settings->updater == 'on' ) echo 'checked="checked"'; ?> value = "on" /> <a href="https://speakoutpetitions.com/wpupdater" target="_blank">?</a></td>
				</tr>
			</table>
		</div>
		
         <div id="dk-speakout-tab-08" class="dk-speakout-hidden dk-speakout-tabcontent">
             
           <?php
            $licenseFields = "";
           if(get_option( 'dk_speakout_license_key_verified' ) == 1  && get_option( 'dk_speakout_license_key' ) != ""){
		        $licenseFields = '<td><span  class="licenseKeyVerifiedText">' .  __( "Enter your license key", "speakout") . ':</span></td>
			    <td> <input type="text" id="license_key_display" name="license_key_display" size="50"  class="licenseKeyFieldVerified" value="****************" readonly>
			         <input type="hidden" id="license_key" name="license_key" value=' . get_option( 'dk_speakout_license_key' ) . '>
                </td>
			    <td> 
                    <input type="button" id="licenseKeyButton" name="licenseKeyButton"  class="licenseKeyButtonVerified" value="'. __( "Verified", "speakout"). '"  disabled="disabled" >
                </td>
                <td> 
                    <input type="button" id="licenseKeyRevoke" name="licenseKeyRevoke"  class="licenseKeyRevoke" value="'. __( "Revoke license key", "speakout"). '"  > <span><img style="display:none;" id="speakOutLoader" src="'.  WP_PLUGIN_URL . '/speakout/images/loader.gif"></span>
                </td>                
			    <tr>
                    <td>
                        <span class"upgrade-message">' . __("Thanks for upgrading", "speakout") . '</span>
                    </td>
                </tr>';
		    }

		    else{		        
		        if('dk_speakout_license_key_verified' == 1  
                   && get_option( 'dk_speakout_license_key' ) == "" 
                   || 'dk_speakout_license_key_verified' == 0  
                   && get_option( 'dk_speakout_license_key' ) != ""){
		              $licenseFields =  __("There appears to be a problem with your license key.  Either verify it again or contact", "speakout") .' <a href="https://speakoutpetitions.com/contact" target="_blank">speakoutpetitions.com/contact</a><br><br>';
		        }
		        
		        $licenseFields = $licenseFields . '
                <td>
                    <span  class="licenseKeyText">'. __( "Enter your license key", "speakout"). ':</span>
                </td>
			    <td> 
                    <input type="text" id="license_key" name="license_key" size="50"   class="licenseKeyField" placeholder="'. __( "Your license key", "speakout"). '" value="" >
                </td>
			    <td> 
                    <input type="button" id="licenseKeyButton" name="licenseKeyButton" class="licenseKeyButton" value="'. __( "Verify", "speakout"). '"  > <span><img style="display:none;" id="speakOutLoader" src="<?php echo WP_PLUGIN_URL; ?>/speakout/images/loader.gif"></span>
                </td>
			    <tr>
                    <td>
                        <br><span class ="upgrade-message">' . __("Don't have a license", "speakout") .'? <a href="https://speakoutpetitions.com/product/speakout-wordpress-petition-plugin-upgrade/" target="_blank">'. __( "Click here", "speakout"). '</a></span>
                    </td>
                </tr>';
		    }
		    ?>
   
            <table>
				<?php 
				   echo $licenseFields;
				 ?>
			</table>
             
             <br><br><div id="option-display" style="cursor:pointer;">Click to <span id="option-context">display</span> SpeakOut! options <span id="option-target">if needed for support</span></div><?php

                    $options = get_option( 'dk_speakout_options' );

                    echo '<div id="speakout-options" style="display:none;"><h1>Options:</h1><br><br><div><input type="button" id="copyToClipBoard" value="Copy to clipboard"></div><br><br>';
             
                        foreach($options as $key => $value){
                            if($key == "g_recaptcha_secret_key") $value = "*******";
                            if($key == "hcaptcha_secret_key") $value = "*******";
                            echo $key . " - " . $value . "<br />";
                        }
                    ?>
                    </div>
                    <div id="speakout-options-txt" style=visibility:hidden;>
                        <?php
                            foreach($options as $key => $value){
                                if($key == "g_recaptcha_secret_key") $value = "*******";
                                if($key == "hcaptcha_secret_key") $value = "*******";
                                echo $key . " - " . $value . "\n";
                            }
                        ?>
                    </div>

		</div>       

		<div id="dk-speakout-tab-10" class="dk-speakout-hidden dk-speakout-tabcontent">
			<h3><?php _e( 'Anedot.com Donation Form Embed', 'speakout' ); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="sigtab_anedot_page_id"><?php _e( 'Anedot.com Donation Slug', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->anedot_page_id ); ?>" name="anedot_page_id" id="anedot_page_id" type="text" class="regular-text" />
						<br /><?php _e( 'Input your Anedot.com "Account Slug" (from Settings > Brand), a slash, and then your Campaign Slug (from Campaigns > Edit > Basic).', 'speakout' ); ?>
                        <br />Example: If your donation page's URL is "https://secure.anedot.com/<strong>example/donate</strong>" then your Donation Slug is: "<strong>example/donate</strong>"</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="anedot_embed_pref"><?php _e( 'Anedot.com Embed Pref', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->anedot_embed_pref ); ?>" name="anedot_embed_pref" id="anedot_embed_pref" type="text" class="regular-text" />
						<br /><?php _e( 'Enter "true" (without quotes) to show account name header on embedded campaigns.', 'speakout' ); ?></td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="anedot_iframe_width"><?php _e( 'Anedot.com iframe Width', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->anedot_iframe_width ); ?>" name="anedot_iframe_width" id="anedot_iframe_width" type="text" class="regular-text" />
						<br /><?php _e( 'Width for donation form iframe, either as percent, e.g. "100%" (without quotes), or pixels, e.g. "375" (without quotes). Iframe is to be displayed in Success Message area, after signing of a petition.', 'speakout' ); ?></td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="anedot_iframe_height"><?php _e( 'Anedot.com iframe Height', 'speakout' ); ?></label></th>
					<td><input value="<?php echo esc_attr( $the_settings->anedot_iframe_height ); ?>" name="anedot_iframe_height" id="anedot_iframe_height" type="text" class="regular-text" />
						<br /><?php _e( 'Height for donation page iframe, either as pixels, e.g. "1570" (without quotes), or percent, e.g. "100%" (without quotes). Iframe is to be displayed in Success Message area, after signing of a petition.', 'speakout' ); ?></td>
				</tr>
			</table>
		</div>

            <!-- hidden in admin.js -->
		<p><input type="submit" name="submit" value="<?php _e( 'Save Changes' ); ?>" class="button-primary" tabindex="0" /></p>

	</form>

</div>