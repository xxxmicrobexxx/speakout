<?php // Pro ?>
<style>
    label{margin:10px 0 5px 0;}
</style><div class="wrap" id="dk-speakout">

	<div id="icon-dk-speakout" class="icon32"><br /></div>
	<h2><?php echo $page_title; ?><span style="font-size:10px"><span class="required"> </span> = required field</span></h2>
	<?php if ( $message_update ) echo '<div id="message" class="updated"><p>' . $message_update . '</p></div>'; ?>
	<div id="message" class="error dk-speakout-error-msg"><p><?php _e( 'Error: Please correct the highlighted fields.  It may be behind a closed tab', 'speakout' ); ?></p></div>

	<form name="dk-speakout-edit-petition" id="dk-speakout-edit-petition" method="post" action="">
		<?php wp_nonce_field( $nonce ); ?>
		<input type="hidden" name="action" value="<?php echo $action; ?>" />
		<?php if ( $petition->id ) echo '<input type="hidden" name="id" value="' . esc_attr( $petition->id ) . '" />'; ?>
		<input type="hidden" name="action" value="<?php echo $action; ?>" />
		<input type="hidden" name="tab" id="dk-petition-tab" value="<?php echo $tab; ?>" />
<ul id="dk-petition-tabbar">
	<li><a class="dk-petition-tab-01" rel="dk-petition-tab-01"><?php _e( 'Petition Content', 'speakout' ); ?></a></li>
	<li><a class="dk-petition-tab-02" rel="dk-petition-tab-02"><?php _e( 'Petition Options', 'speakout' ); ?></a></li>
	<li><a class="dk-petition-tab-03" rel="dk-petition-tab-03"><?php _e( 'Display Options', 'speakout' ); ?></a></li>
    <li><a class="dk-petition-tab-04" rel="dk-petition-tab-04"><?php _e( '3rd Party Integrations', 'speakout' ); ?></a></li>
</ul>
		
<div id="post-body-content">
    <div id="dk-petition-tab-01" class="dk-petition-tabcontent">
    	<div class="postbox">		
    	    <div id="titlediv">
				<div id="titlewrap">
					<label for="title" class="required"><?php _e( 'Title', 'speakout' ); ?></label>
					<input type="text"  name="title" size="100" tabindex="1" value="<?php echo stripslashes( stripcslashes( $petition->title ) ); ?>" id="title" <?php if($petition->title == ""){ echo " placeholder='"; _e( 'Enter title here', 'speakout' ); echo "'"; }?>/>
				</div>
			</div>
  
				<div class="dk-speakout-checkbox sends_email">
					
					<?php 
					    if ( $petition->sends_email == '0' && $petition->hide_email_field == '1'){
					        echo '<input type="checkbox" name="sends_email_dummy" id="sends_email_dummy" checked="checked" disabled="disabled"/>';
					        echo '<input type="hidden" name="sends_email" id="sends_email" value="1" />';
					}
					else{ 
					     $isChecked = $petition->sends_email == '0' ? 'checked="checked"' : '';
					        echo '<input type="checkbox" name="sends_email" id="sends_email" ' . $isChecked . ' />';
					 } 
					 ?>
					<label for="sends_email" class="dk-speakout-inline"><?php _e( 'Do not send email (only collect signatures)', 'speakout' ); ?></label>
				</div>
				<div class="dk-speakout-petition-content">
					<div class="dk-speakout-email-headers">
						<label for="target_email"><?php _e( 'Target Email', 'speakout' ); ?><span class="required"></span><span class='normalText'> <?php _e( 'you may enter multiple addresses separated by commas', 'speakout' ); ?></span> </label> 
						<input name="target_email" id="target_email" value="<?php echo esc_attr( $petition->target_email ); ?>" size="40" maxlength="300" type="text" />
						
						<label for="target_email_CC"><?php _e( 'CC Email', 'speakout' ); ?> <span class='normalText'><?php _e( 'you may enter multiple addresses separated by commas', 'speakout' ); ?></span></label> 
						<input name="target_email_CC" id="target_email_CC" value="<?php echo esc_attr( $petition->target_email_CC ); ?>" size="40" maxlength="300" type="text" />

						<label for="email_subject" class="required"><?php _e( 'Email Subject', 'speakout' ); ?></label>
						<input name="email_subject" id="email_subject" value="<?php echo stripslashes( esc_attr( $petition->email_subject ) ); ?>" size="40" maxlength="80" type="text" />

						<label for="greeting" class="required"><?php _e( 'Greeting', 'speakout' ); ?></label>
						<input name="greeting" id="greeting" value="<?php echo stripslashes( esc_attr( $petition->greeting ) ); ?>" size="40" maxlength="80" type="text" />
					</div>
				</div>

            <label for="petition_message"  class="required" style="clear: both;
    float:left;"><?php _e( 'Petition Message', 'speakout' ); ?></label>  <div class="mtop"><span>&nbsp;&nbsp;(this can now be Markdown or HTML - see settings)</span></div>
           
             <?php //markdown editor 
                if(  $options['speakout_editor'] != "html" ){ ?>
                    
                    <textarea name="petition_message" id="petition_message" rows="10" cols="80"><?php echo $petition->petition_message; ?></textarea>
            <?php }
                else{ //or html editor
                    
                    $initial_data = htmlspecialchars_decode(stripslashes($petition->petition_message));
                    $settings = array(
                        'text_area_name'=>'petition_message',
                        'tinymce' => true,
                        'media_buttons' => false,
                    );
                    $id = 'petition_message';
                    wp_editor($initial_data, $id, $settings); 
                } ?>
            
                <div class="insert_tags"><?php _e('You can personalise the message by inserting tags'); ?>: %honorific%  %first_name%  %last_name% %petition_title% %confirmation_link% %address% %city% %state% %postcode% %country% %custom1% <a href='https://speakoutpetitions.com/faqconc/include-user-fields-in-petition-message/' target='_blank'>?</a></div>
                <div class="markdown"><?php _e('You or the signer can format the message using Markdown syntax - see'); ?> <a href="https://speakoutpetitions.com/markdown-guide/" target="_new">https://speakoutpetitions.com/markdown-guide</a></div>
			
 				<label for="petition_footer"><?php _e( 'Petition Footer (below signature)', 'speakout' ); ?></label>
				<textarea name="petition_footer" id="petition_footer" rows="3" cols="80"><?php echo stripslashes( esc_textarea( $petition->petition_footer ) ); ?></textarea>
		</div>

		<div class="postbox">
			<label for="x_message"><?php _e( 'X (Twitter) Message', 'speakout' ); ?></label>
				<textarea name="x_message" id="x_message" rows="2" cols="80"><?php echo stripslashes ( esc_textarea( $petition->x_message ) ); ?></textarea>
				<div id="x-counter"></div> 
		</div>

	</div> <!-- end tab 1 -->

    <div id="dk-petition-tab-02" class="dk-speakout-hidden dk-petition-tabcontent">
        <div class="postbox">
    		<div id="minor-publishing">
    
    			<div class="misc-pub-section  dk-speakout-hide-email-option" <?php if ( $petition->hide_email_field == '1' ){ echo 'style="display:block;"'; }else{ echo 'style="display:none;"';} ?> >
    			  <div class="dk-speakout-checkbox"> 
    			  <?php 
					    if ( $petition->hide_email_field == '1' ){
					        echo '<input type="checkbox" name="hide_email_field_dummy" id="hide_email_field_dummy" checked="checked" disabled="disabled"/>';
					        echo '<input type="hidden" name="hide_email_field" id="hide_email_field" value="1" />';
					}
					else{ ?>
					        <input type="checkbox" name="hide_email_field" id="hide_email_field" />
					        
					<?php 
					} 
					 ?>
    			   
    					<label for="hide_email_field" id="hide-email-field-label" class="dk-speakout-inline"><?php _e( "Don't collect email address", 'speakout'); ?></label><br>
    					<span class="hide_email_warning"><?php _e( "This cannot be reversed", 'speakout'); ?> <a href='https://speakoutpetitions.com/faqconc/why-cant-no-email-address-be-reversed/' target="_blank">?</a></span>
    				</div>
    			</div>
    
    			<div class="misc-pub-section">
    			    <div class="dk-speakout-checkbox" <?php  if ( $petition->hide_email_field == '1' ){echo 'style="display:none;"'; } ?> >
                        <input type="checkbox" name="allow_anonymous" id="allow-anonymous" <?php if ( $petition->allow_anonymous == 1 ) echo 'checked="checked"'; ?> />
    					<label for="allow_anon" id="allow-anonymous-label" class="dk-speakout-inline"><?php _e( "Allow public anonymous", 'speakout'); ?></label> <a href="https://speakoutpetitions.com/faqconc/can-people-sign-anonymously/" target="_blank">?</a><br>
    				</div>
    			</div>
    			
    									
    			<!-- Email Confirmation -->
    			<div class="misc-pub-section">
    				<div class="dk-speakout-checkbox">
    					<input type="checkbox" name="requires_confirmation" id="requires_confirmation" <?php if ( $petition->requires_confirmation == 1 ) echo 'checked="checked"'; ?> />
    					<label for="requires_confirmation" id="requires_confirmation-label" class="dk-speakout-inline"><?php _e( 'Confirm signatures', 'speakout'); ?></label>
    				</div>
    				<div class="margin-20-left dk-speakout-returnurl dk-speakout-subsection <?php if ( $petition->requires_confirmation != 1 ) echo 'dk-speakout-hidden'; ?>">
    					<label for="return_url"><?php _e( 'Return URL', 'speakout'); ?>:</label>
    					<input id="return_url" name="return_url" value="<?php echo esc_attr( $petition->return_url ); ?>" size="30" maxlength="200" type="text" />
    				</div>
    			</div>
    			
    			<!-- Editable -->
    			<div class="misc-pub-section">
    				<div class="dk-speakout-checkbox">
    					<input type="checkbox" name="is_editable" id="is_editable" <?php if ( $petition->is_editable == 1 ) echo 'checked="checked"'; ?> />
    					<label for="is_editable" class="dk-speakout-inline"><?php _e( 'Allow message to be edited', 'speakout'); ?></label>
    				</div>
    			</div>
    
    			<!-- Signature Goal -->
    			<div class="misc-pub-section">
    				<div class="dk-speakout-checkbox">
    					<input type="checkbox" name="has_goal" id="has_goal" <?php if ( $petition->goal > 0 ) echo 'checked="checked"'; ?> />
    					<label for="has_goal" class="dk-speakout-inline"><?php _e( 'Set signature goal', 'speakout'); ?></label>
    				</div>
    				<div class="margin-20-left dk-speakout-goal dk-speakout-subsection <?php if ( $petition->goal < 1 ) echo ' dk-speakout-hidden'; ?>">
    					<label for="goal"><?php _e( 'Goal', 'speakout'); ?>:</label>
    					<input id="goal" name="goal" value="<?php echo esc_attr( $petition->goal ); ?>" size="8" maxlength="8" type="text" /><br />
        					<input type="checkbox" name="increase_goal" id="increase_goal" <?php if( $petition->increase_goal == 1 ) echo 'checked="checked"'; ?> />
        					<?php _e( 'Auto increase goal', 'speakout'); ?> 
        					    <span class='goal-options <?php if( $petition->increase_goal < 1 ) echo "dk-speakout-hidden"; ?>'><?php _e( 'by', 'speakout'); ?> <input id="goal_bump" name="goal_bump" value="<?php echo esc_attr( $petition->goal_bump ); ?>" size="8" maxlength="8" type="text" /> 
        					    <?php _e( 'when count', 'speakout'); ?> = <input id="goal_trigger" name="goal_trigger" value="<?php echo esc_attr( $petition->goal_trigger ); ?>" size="3" maxlength="3" type="text" />% <?php _e( 'of goal', 'speakout'); ?></span> <a href="https://speakoutpetitions.com/faqconc/auto-update-the-goal/" target=_blank">?</a>
    				</div>
    			</div>
    
    			<!-- Expiration Date -->
    			<div class="misc-pub-section misc-pub-section-last">
    				<div class="dk-speakout-checkbox">
    					<input type="checkbox" name="expires" id="expires" <?php if ( $petition->expires == 1 ) echo 'checked="checked"'; ?> />
    					<label for="expires" class="dk-speakout-inline"><?php _e( 'Set expiration date', 'speakout'); ?></label>
    				</div>
    				<div class="dk-speakout-date dk-speakout-subsection <?php if ( $petition->expires != 1 ) echo 'dk-speakout-hidden'; ?>">
    					<select id="month" name="month">
    						<option value="01" <?php if ( $x_date['month'] == '01' ) echo 'selected="selected"'; ?>><?php _e( 'Jan', 'speakout'); ?></option>
    						<option value="02" <?php if ( $x_date['month'] == '02' ) echo 'selected="selected"'; ?>><?php _e( 'Feb', 'speakout'); ?></option>
    						<option value="03" <?php if ( $x_date['month'] == '03' ) echo 'selected="selected"'; ?>><?php _e( 'Mar', 'speakout'); ?></option>
    						<option value="04" <?php if ( $x_date['month'] == '04' ) echo 'selected="selected"'; ?>><?php _e( 'Apr', 'speakout'); ?></option>
    						<option value="05" <?php if ( $x_date['month'] == '05' ) echo 'selected="selected"'; ?>><?php _e( 'May', 'speakout'); ?></option>
    						<option value="06" <?php if ( $x_date['month'] == '06' ) echo 'selected="selected"'; ?>><?php _e( 'Jun', 'speakout'); ?></option>
    						<option value="07" <?php if ( $x_date['month'] == '07' ) echo 'selected="selected"'; ?>><?php _e( 'Jul', 'speakout'); ?></option>
    						<option value="08" <?php if ( $x_date['month'] == '08' ) echo 'selected="selected"'; ?>><?php _e( 'Aug', 'speakout'); ?></option>
    						<option value="09" <?php if ( $x_date['month'] == '09' ) echo 'selected="selected"'; ?>><?php _e( 'Sep', 'speakout'); ?></option>
    						<option value="10" <?php if ( $x_date['month'] == '10' ) echo 'selected="selected"'; ?>><?php _e( 'Oct', 'speakout'); ?></option>
    						<option value="11" <?php if ( $x_date['month'] == '11' ) echo 'selected="selected"'; ?>><?php _e( 'Nov', 'speakout'); ?></option>
    						<option value="12" <?php if ( $x_date['month'] == '12' ) echo 'selected="selected"'; ?>><?php _e( 'Dec', 'speakout'); ?></option>
    					</select>
    					<input id="day" name="day" value="<?php echo esc_attr( $x_date['day'] ); ?>" size="2" maxlength="2" type="text" />
    					,
    					<input id="year" name="year" value="<?php echo esc_attr( $x_date['year'] ); ?>" size="4" maxlength="4" type="text" />
    					@
    					<input id="hour" name="hour" value="<?php echo esc_attr( $x_date['hour'] ); ?>" size="2" maxlength="2" type="text" />
    					:
    					<input id="minutes" name="minutes" value="<?php echo esc_attr( $x_date['minutes'] ); ?>" size="2" maxlength="2" type="text" />
    				</div>
    			</div>
    			
                <!-- Reirection URL -->
    			<div class="misc-pub-section">
    				<div class="dk-speakout-checkbox">
    					<input type="checkbox" name="redirect_url_option" id="redirect_url_option" <?php if ( $petition->redirect_url_option > 0 ) echo 'checked="checked"'; ?> />
    					<label for="redirect_url_option" class="dk-speakout-inline"><?php _e( 'Redirect after successful sign', 'speakout'); ?></label>
    				</div>
    				<div class="margin-20-left dk-redirection-url dk-speakout-subsection <?php if ( $petition->redirect_url_option == 0 ) echo 'dk-speakout-hidden'; ?>">
    					<label for="redirect_url"><?php _e( 'Full URL', 'speakout'); ?>:</label>
    					<input id="redirect_url" name="redirect_url" value="<?php echo esc_attr( $petition->redirect_url ); ?>" size="30"  type="text" /><br>
    					<?php _e( 'Delay?', 'speakout' ); ?>
    					<label for="redirect_delay"><input value="<?php echo esc_attr( $petition->redirect_delay ); ?>" name="redirect_delay" id="redirect_delay" type="text" size="4" /> <?php _e( 'milliseconds', 'speakout' ); ?></label><br>
    					<label for="url_target"><input name="url_target" id="url_target" type="checkbox" <?php if ( $petition->url_target > 0 ) echo 'checked="checked"'; ?> /><?php echo __("Open in new window (target='_blank')", 'speakout'); ?></label><a href='https://speakoutpetitions.com/faqconc/why-doesnt-the-redirection-to-an-external-site-work/' target="_blank" class="warningIcon">&#9888;</a>
    					
    				</div>
    			</div>
    			
    			<!-- Email to signer -->
    			<div class="misc-pub-section">
    				<div class="dk-speakout-checkbox">
    					<input type="checkbox" name="thank_signer" id="thank_signer" <?php if ( $petition->thank_signer > 0 ) echo 'checked="checked"'; ?> />
    					<label for="thank_signer" id="thank_signer-label" class="dk-speakout-inline"><?php _e( 'Email to signer?', 'speakout'); ?></label> <a href="https://speakoutpetitions.com/faqconc/include-user-fields-in-thank-you-email/" target = "_blank">?</a>
    				</div>
    				<div class="margin-20-left dk-speakout-thanksigner dk-speakout-subsection <?php if ( $petition->thank_signer != 1 ) echo 'dk-speakout-hidden'; ?>">
    					<label for="thank_signer_content"><?php _e( 'Email content', 'speakout'); ?>:</label>
                        <?php
                            $initial_data = htmlspecialchars_decode(stripslashes($petition->thank_signer_content));
                             //check to make sure there is some content, if not revert to default
                             if( $petition->thank_signer > 0 && $petition->thank_signer_content == ""){
                                 $initial_data  = 'Dear %first_name%,
                                 
                                 Thanks for signing our petition, your participation makes a difference.
                                 
                                 Yours sincerely,
                                 
                                 %petition_title%';
                             }
                            $settings = array(
                                'text_area_name'=>'thank_signer_content',
                                'tinymce' => true,
                                'media_buttons' => false,
                                'quicktags' => false,
                                'editor_height' => 300
                            );
                            $id = 'thank_signer_content';
                            wp_editor($initial_data, $id, $settings); 
                        ?>

                        <div class="insert_tags"><?php _e('You can personalise the message by inserting tags'); ?>: %honorific%  %first_name%  %last_name% %petition_title% <a href='https://speakoutpetitions.com/faqconc/include-user-fields-in-thank-you-email/' target='_blank'>?</a></div>
    				</div>
    			</div>
    		</div>
        </div> <!-- end postbox -->
    </div> <!-- end tab 2 -->
    
    <div id="dk-petition-tab-03" class="dk-speakout-hidden dk-petition-tabcontent">
        <div class="postbox">
        	<div id="minor-publishing">
        	   <!-- read petition option -->
                <div class="misc-pub-section">
        		    <div class="dk-speakout-checkbox">
        				<label for="open_message_button" class="dk-speakout-inline"><?php _e( 'Text to open/close petition message', 'speakout'); ?></label>
        				<input type="text" name="open-message-button" id="open-message-button" value="<?php echo $petition->open_message_button; ?>" /> <a href="https://speakoutpetitions.com/faqconc/can-i-change-read-the-petition-text/" target="_blank">?</a>
        				
        			</div>
                    <div class="dk-speakout-checkbox">
        				<label for="open_editable_message_button" class="dk-speakout-inline"><?php _e( 'Text to open/close editable petition message', 'speakout'); ?></label>
        				<input type="text" name="open-editable-message-button" id="open-editable-message-button" value="<?php echo $petition->open_editable_message_button; ?>" /> <a href="https://speakoutpetitions.com/faqconc/can-i-change-read-the-petition-text/" target="_blank">?</a>
        				
        			</div>
        		</div>        		
        		<!-- Email Opt-in -->
        		<div class="misc-pub-section">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-optin" id="displays-optin" <?php if ( $petition->displays_optin == '1' ) echo 'checked="checked"'; ?> />
        				<label for="displays-optin" id="displays-optin-label" class="dk-speakout-inline"><?php _e( 'Display opt-in checkbox', 'speakout'); ?></label>
        			</div>
        			<div class="margin-20-left dk-speakout-optin dk-speakout-subsection <?php if ( $petition->displays_optin != '1' ) echo 'dk-speakout-hidden'; ?>">
        				<label for="optin-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="optin-label" name="optin-label" value="<?php echo stripslashes( esc_attr( $petition->optin_label ) ); ?>" size="30" maxlength="200" type="text" />
        			</div>
        		</div>
        		
        		<div class="misc-pub-section">
        		    <div class="dk-speakout-checkbox">
        				<input type="checkbox" name="display_petition_message" id="display_petition_message" <?php if ( $petition->display_petition_message == 1 || $action == "create") echo 'checked="checked"'; ?> />
        				<label for="display_petition_message" class="dk-speakout-inline"><?php _e( 'Display petition message', 'speakout'); ?></label>
        			</div>
        		</div>
        		
        		<div class="misc-pub-section">
        			<div class="dk-speakout-checkbox ">
        				<input type="checkbox" name="display-address" id="display-address" <?php if ( count( $petition->address_fields ) > 0 ) echo 'checked="checked"'; ?> />
        				<label for="display-address" class="dk-speakout-inline"><?php _e( 'Display address fields', 'speakout'); ?></label>
        			</div>
        			
        			<div class="dk-speakout-address dk-speakout-subsection <?php if( count( $petition->address_fields ) == 0 ) echo 'dk-speakout-hidden'; ?>">
        			    
        			    <table id="dk-speakout-address-block" class="margin-20-left" cellspacing = "0">
        			        <tr style="font-size:80%;">
        			            <td><?php _e( 'Display', 'speakout'); ?>?</td>
        			            <td><?php _e( 'Required', 'speakout'); ?>?</td>
        			            <td></td>
        			        </tr>
        			        <tr>
        			            <td><input type="checkbox" id="street" name="street" <?php if ( in_array( 'street', $petition->address_fields ) ) echo 'checked="checked"'; ?> /></td>
        			            <td><input type="checkbox" id="street-required"  name="street-required" <?php if ( $petition->street_required == 1 ) echo 'checked="checked"'; ?> /></td>
        						<td class="keep-left"><label for="street" ><?php _e( 'Street', 'speakout'); ?></label></td>
                            </tr>
                            <tr>
        						<td><input type="checkbox" id="city" name="city" <?php if ( in_array( 'city', $petition->address_fields ) ) echo 'checked="checked"'; ?> /></td>
        						<td><input type="checkbox" id="city-required" name="city-required" <?php if ( $petition->city_required == 1 ) echo 'checked="checked"'; ?> /></td>
        						<td class="keep-left"><label for="city"><?php _e( 'City', 'speakout'); ?></label></td>
                            </tr>
                            <tr>
        						<td><input type="checkbox" id="state" name="state" <?php if ( in_array( 'state', $petition->address_fields ) ) echo 'checked="checked"'; ?> /></td>
        						<td style="text-align:center"><input type="checkbox" id="state-required"  name="state-required" <?php if ( $petition->state_required == 1 ) echo 'checked="checked"'; ?> /></td>
        						<td class="keep-left"><label for="state"><?php _e( 'State / Province', 'speakout'); ?></label></td>
                            </tr>
                            <tr>
        						<td valign="top"><input type="checkbox" id="postcode" name="postcode" <?php if ( in_array( 'postcode', $petition->address_fields ) ) echo 'checked="checked"'; ?> /></td>
        						<td valign="top" style="text-align:center"><input type="checkbox" id="postcode-required"  name="postcode-required"<?php if ( $petition->postcode_required == 1 ) echo 'checked="checked"'; ?> /></td>
        						<td class="keep-left"><label for="postcode"><?php _e( 'Postal Code - see settings for EU style', 'speakout'); ?></label></td>
                            </tr>
                            <tr>
        						<td><input type="checkbox" id="country" name="country" <?php if ( in_array( 'country', $petition->address_fields ) ) echo 'checked="checked"'; ?> /></td>
        						<td style="text-align:center"><input type="checkbox" id="country-required"  name="country-required"<?php if ( $petition->country_required == 1 ) echo 'checked="checked"'; ?> /></td>
        						<td class="keep-left"><label for="country"><?php _e( 'Country', 'speakout'); ?></label></td>
        					</tr>
        				
        				</table>
        				
                   </div>
        		</div>
        
        		<!-- Custom Field #1 -->
        		<div class="misc-pub-section lineAbove lineBelow">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field" id="displays-custom-field" <?php if ( $petition->displays_custom_field == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-field" class="dk-speakout-inline"><?php _e( 'Display custom field 1', 'speakout'); ?></label> <a href="https://speakoutpetitions.com/faqconc/can-i-add-a-custom-field/" target="_blank">?</a><i class="fa-solid fa-info"></i>
        			</div>
        			
        			<div class="margin-20-left dk-speakout-custom-field dk-speakout-subsection <?php if( $petition->displays_custom_field != 1 ) echo 'dk-speakout-hidden'; ?>">							    
        			    <label for="custom-field-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field-label" name="custom-field-label" value="<?php 
            				if($petition->custom_field_label > "" ){ 
            				    echo trim( stripslashes( esc_attr( $petition->custom_field_label ) ) );
            				    } 
            				else{ 
            				    echo "Custom field 1"; 
            				} 
                        ?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field == 1 ) echo ' required="required"'; ?> /><br />
                        
                        <input type="checkbox" id="custom-field-required" name="custom-field-required" value="1"  <?php if ( $petition->custom_field_required == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field-required"><?php _e( 'Required', 'speakout'); ?></label><br /><br />
        				        				
        				<?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field-location" id="custom-field-location-top" value="1" <?php if ($petition->custom_field_location == 1) {echo ' checked="checked"';} ?> />
        				<label for="custom-field-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field-location" id="custom-field-location-middle" value="2" <?php if ($petition->custom_field_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field-location" id="custom-field-location-bottom" value="3" <?php if ($petition->custom_field_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label><br /><br />
        				
                        <input type="checkbox" id="custom-field-included" name="custom-field-included" value="1" <?php if ( $petition->custom_field_included == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field-included"><?php _e( 'Include with petition', 'speakout'); ?></label><br />
        				
        				<label for="custom-field-truncated"><input type="checkbox" id="custom-field-truncated" name="custom-field-truncated" value="1"  <?php if ( $petition->custom_field_truncated == 1 ) echo 'checked="checked"'; ?> /><?php _e( 'Trim when displaying', 'speakout'); ?> <a href="https://speakoutpetitions.com/faqconc/truncating-custom-fields/" target="_blank">?</a> </label>	
        			</div>
        		</div>
 
        		<!-- Custom Field #2 -->
        		<div class="misc-pub-section lineBelow">
                    <div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field2" id="displays-custom-field2" <?php if ( $petition->displays_custom_field2 == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-field2" class="dk-speakout-inline"><?php _e( 'Display custom field 2', 'speakout'); ?></label>
        			</div>
        			
        			<div class="margin-20-left dk-speakout-custom-field2 dk-speakout-subsection <?php if( $petition->displays_custom_field2 != 1 ) echo 'dk-speakout-hidden'; ?>">							    
        			    <label for="custom-field2-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field2-label" name="custom-field2-label" value="<?php 
            				if($petition->custom_field2_label > "" ){ 
            				    echo trim( stripslashes( esc_attr( $petition->custom_field2_label ) ) );
            				    } 
            				else{ 
            				    echo "Custom field 2"; 
            				} 
                        ?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field2 == 1 ) echo ' required="required"'; ?> /><br />
                        
                        <input type="checkbox" id="custom-field2-required" name="custom-field2-required" value="1"  <?php if ( $petition->custom_field2_required == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field2-required"><?php _e( 'Required', 'speakout'); ?></label><br /><br />
        				        				
        				<?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field2-location" id="custom-field2-location-top" value="1" <?php if ($petition->custom_field2_location == 1) {echo ' checked="checked"';} ?> />
        				<label for="custom-field2-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field2-location" id="custom-field2-location-middle" value="2" <?php if ($petition->custom_field2_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field2-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field2-location" id="custom-field2-location-bottom" value="3" <?php if ($petition->custom_field2_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field2-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label><br /><br />
        				
                        <input type="checkbox" id="custom-field2-included" name="custom-field2-included" value="1" <?php if ( $petition->custom_field2_included == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field2-included"><?php _e( 'Include with petition', 'speakout'); ?></label><br />
        				
        				<label for="custom-field2-truncated"><input type="checkbox" id="custom-field2-truncated" name="custom-field2-truncated" value="1"  <?php if ( $petition->custom_field2_truncated == 1 ) echo 'checked="checked"'; ?> /><?php _e( 'Trim when displaying', 'speakout'); ?></label>	
        			</div>
        		</div>
                
        		<!-- Custom Field #3 -->
        		<div class="misc-pub-section lineBelow">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field3" id="displays-custom-field3" <?php if ( $petition->displays_custom_field3 == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-field3" class="dk-speakout-inline"><?php _e( 'Display custom field 3', 'speakout'); ?></label>
        			</div>
        			
        			<div class="margin-20-left dk-speakout-custom-field3 dk-speakout-subsection <?php if( $petition->displays_custom_field3 != 1 ) echo 'dk-speakout-hidden'; ?>">							    
        			    <label for="custom-field3-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field3-label" name="custom-field3-label" value="<?php 
            				if($petition->custom_field3_label > "" ){ 
            				    echo trim( stripslashes( esc_attr( $petition->custom_field3_label ) ) );
            				    } 
            				else{ 
            				    echo "Custom field 3"; 
            				} 
                        ?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field3 == 1 ) echo ' required="required"'; ?> /><br />
                        
                        <input type="checkbox" id="custom-field3-required" name="custom-field3-required" value="1"  <?php if ( $petition->custom_field3_required == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field3-required"><?php _e( 'Required', 'speakout'); ?></label><br /><br />
        				        				
        				<?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field3-location" id="custom-field3-location-top" value="1" <?php if ($petition->custom_field3_location == 1) {echo ' checked="checked"';} ?> />
        				<label for="custom-field3-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field3-location" id="custom-field3-location-middle" value="2" <?php if ($petition->custom_field3_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field3-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field3-location" id="custom-field3-location-bottom" value="3" <?php if ($petition->custom_field3_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field3-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label><br /><br />
        				
                        <input type="checkbox" id="custom-field3-included" name="custom-field3-included" value="1" <?php if ( $petition->custom_field3_included == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field3-included"><?php _e( 'Include with petition', 'speakout'); ?></label><br />
        				
        				<label for="custom-field3-truncated"><input type="checkbox" id="custom-field3-truncated" name="custom-field3-truncated" value="1"  <?php if ( $petition->custom_field3_truncated == 1 ) echo 'checked="checked"'; ?> /><?php _e( 'Trim when displaying', 'speakout'); ?></label>	
        			</div>
        		</div>
                
                
        		<!-- Custom Field #4 -->
        		<div class="misc-pub-section lineBelow">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field4" id="displays-custom-field4" <?php if ( $petition->displays_custom_field4 == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-field4" class="dk-speakout-inline"><?php _e( 'Display custom field 4', 'speakout'); ?></label>
        			</div>
        			
        			<div class="margin-20-left dk-speakout-custom-field4 dk-speakout-subsection <?php if( $petition->displays_custom_field4 != 1 ) echo 'dk-speakout-hidden'; ?>">							    
        			    <label for="custom-field4-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field4-label" name="custom-field4-label" value="<?php 
            				if($petition->custom_field4_label > "" ){ 
            				    echo trim( stripslashes( esc_attr( $petition->custom_field4_label ) ) );
            				    } 
            				else{ 
            				    echo "Custom field 4"; 
            				} 
                        ?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field4 == 1 ) echo ' required="required"'; ?> /><br />
                        
                        <input type="checkbox" id="custom-field4-required" name="custom-field4-required" value="1"  <?php if ( $petition->custom_field4_required == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field4-required"><?php _e( 'Required', 'speakout'); ?></label><br /><br />
        				        				
        				<?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field4-location" id="custom-field4-location-top" value="1" <?php if ($petition->custom_field4_location == 1) {echo ' checked="checked"';} ?> />
        				<label for="custom-field4-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field4-location" id="custom-field4-location-middle" value="2" <?php if ($petition->custom_field4_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field4-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field4-location" id="custom-field4-location-bottom" value="3" <?php if ($petition->custom_field4_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field4-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label><br /><br />
        				
                        <input type="checkbox" id="custom-field4-included" name="custom-field4-included" value="1" <?php if ( $petition->custom_field4_included == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field4-included"><?php _e( 'Include with petition', 'speakout'); ?></label><br />
        				
        				<label for="custom-field4-truncated"><input type="checkbox" id="custom-field4-truncated" name="custom-field4-truncated" value="1"  <?php if ( $petition->custom_field4_truncated == 1 ) echo 'checked="checked"'; ?> /><?php _e( 'Trim when displaying', 'speakout'); ?></label>	
        			</div>
        		</div>
                
        		<!-- Custom Field #5 -->
        		<div class="misc-pub-section lineBelow">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field5" id="displays-custom-field5" <?php if ( $petition->displays_custom_field5 == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom5-field" class="dk-speakout-inline"><?php _e( 'Display custom drop-down', 'speakout'); ?> 1</label>
        			</div>
        			<div class="margin-20-left dk-speakout-custom-field5 dk-speakout-subsection <?php if( $petition->displays_custom_field5 != 1 ) echo 'dk-speakout-hidden'; ?>">							    
        			   <input type="checkbox" id="custom-field5-included" name="custom-field5-included" <?php if ( $petition->custom_field5_included == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field5-included"><?php _e( 'Include with petition', 'speakout'); ?></label><br />
        				
        				
        				<input type="checkbox" id="custom-field5-required" name="custom-field5-required" value="1" <?php if ( $petition->custom_field5_required == 1 ) echo 'checked="checked"'; ?> /> 
        				<label for="custom-field5-required"><?php _e( 'Required', 'speakout'); ?></label><br />
        				
        				<label for="custom-field5-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field5-label" name="custom-field5-label" value="<?php 
            				if($petition->custom_field5_label > "" ){ 
            				    echo trim( stripslashes( esc_attr( $petition->custom_field5_label ) ) );
            				    } 
            				else{ 
            				    echo "Custom drop down 1"; 
            				} 
                        ?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field5 == 1 ) echo ' required="required"'; ?> /><br />
        				
        				<label for="custom-field5-values"><?php _e( 'Values', 'speakout'); ?>:</label>
        				<input id="custom-field5-values" name="custom-field5-values" value="<?php echo stripslashes( esc_attr( $petition->custom_field5_values ) ); ?>" size="60" maxlength="400" type="text" <?php if ( $petition->displays_custom_field5 == 1 ) echo ' required="required"'; ?> /> Separate each value with a <strong>|</strong> character. e.g. one|two|three
        				
        				<br /><?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field5-location" id="custom-field5-location-top" value="1" <?php if ($petition->custom_field5_location == 1) {echo ' checked="checked"';} ?> />
        				<label for="custom-field5-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field5-location" id="custom-field5-location-middle" value="2" <?php if ($petition->custom_field5_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field5-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
        
                        <input type="radio" name="custom-field5-location" id="custom-field5-location-bottom" value="3" <?php if ($petition->custom_field5_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field5-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label>
        			</div>
        		</div>
        		
          		<!-- Custom Field #6 -->
        		<div class="misc-pub-section lineBelow">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field6" id="displays-custom-field6" <?php if ( $petition->displays_custom_field6 == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-field6" class="dk-speakout-inline"><?php _e( 'Display custom checkbox 1', 'speakout'); ?></label>
        			</div>
        			<div class="margin-20-left dk-speakout-custom-field6 dk-speakout-subsection <?php if( $petition->displays_custom_field6 != 1 ) echo 'dk-speakout-hidden'; ?>">							    

        				<label for="custom-field6-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field6-label" name="custom-field6-label" value="<?php  
                            if($petition->custom_field6_label > ""){
                                echo trim( stripslashes( esc_attr( $petition->custom_field6_label ) ) );
                            }
                            else{
                                echo "Checkbox 1";
                            }
                        ?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field6 == 1 ) echo ' required="required"'; ?> />
        				
        				<br /><?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field6-location" id="custom-field6-location-top" value="1" <?php if ($petition->custom_field6_location == 1) {echo ' checked="checked"';} ?> />
        				<label for="custom-field6-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field6-location" id="custom-field6-location-middle" value="2" <?php if ($petition->custom_field6_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field6-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
        
                        <input type="radio" name="custom-field6-location" id="custom-field6-location-bottom" value="3" <?php if ($petition->custom_field6_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field6-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label>
        			</div>
        		</div>
                      		
        		
          		<!-- Custom Field #7 -->
        		<div class="misc-pub-section lineBelow">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field7" id="displays-custom-field7" <?php if ( $petition->displays_custom_field7 == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-field7" class="dk-speakout-inline"><?php _e( 'Display custom checkbox 2', 'speakout'); ?></label>
        			</div>
        			<div class="margin-20-left dk-speakout-custom-field7 dk-speakout-subsection <?php if( $petition->displays_custom_field7 != 1 ) echo 'dk-speakout-hidden'; ?>">							    
        				
        				<label for="custom-field7-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field7-label" name="custom-field7-label" value="<?php 
        				    if($petition->custom_field7_label > ""){
        				        echo trim( stripslashes( esc_attr( $petition->custom_field7_label ) ) ); 
        				    }
        				    else{
        				        echo "Checkbox 2";
        				    }
        				?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field7 == 1 ) echo ' required="required"'; ?> />
        				
        				<br /><?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field7-location" id="custom-field7-location-top" value="1" <?php if ($petition->custom_field7_location == 1) {echo ' checked="checked"' ;} ?> />
        				<label for="custom-field7-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field7-location" id="custom-field7-location-middle" value="2" <?php if ($petition->custom_field7_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field7-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
        
                        <input type="radio" name="custom-field7-location" id="custom-field7-location-bottom" value="3" <?php if ($petition->custom_field7_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field7-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label>
        			</div>
        		</div>
                
                
                <!-- Custom Field #8 -->
        		<div class="misc-pub-section lineBelow">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field8" id="displays-custom-field8" <?php if ( $petition->displays_custom_field8 == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-field8" class="dk-speakout-inline"><?php _e( 'Display custom checkbox 3', 'speakout'); ?></label>
        			</div>
        			<div class="margin-20-left dk-speakout-custom-field8 dk-speakout-subsection <?php if( $petition->displays_custom_field8 != 1 ) echo 'dk-speakout-hidden'; ?>">							    
        				
        				<label for="custom-field8-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field8-label" name="custom-field8-label" value="<?php 
        				    if($petition->custom_field8_label > ""){
        				        echo trim( stripslashes( esc_attr( $petition->custom_field8_label ) ) ); 
        				    }
        				    else{
        				        echo "Checkbox 3";
        				    }
        				?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field8 == 1 ) echo ' required="required"'; ?> />
        				
        				<br /><?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field8-location" id="custom-field8-location-top" value="1" <?php if ($petition->custom_field8_location == 1) {echo ' checked="checked"' ;} ?> />
        				<label for="custom-field8-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field8-location" id="custom-field8-location-middle" value="2" <?php if ($petition->custom_field8_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field8-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
        
                        <input type="radio" name="custom-field8-location" id="custom-field8-location-bottom" value="3" <?php if ($petition->custom_field8_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field8-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label>
        			</div>
        		</div>
                
                               <!-- Custom Field #9 -->
        		<div class="misc-pub-section lineBelow">
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-field9" id="displays-custom-field9" <?php if ( $petition->displays_custom_field9 == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-field9" class="dk-speakout-inline"><?php _e( 'Display custom checkbox 4', 'speakout'); ?></label>
        			</div>
        			<div class="margin-20-left dk-speakout-custom-field9 dk-speakout-subsection <?php if( $petition->displays_custom_field9 != 1 ) echo 'dk-speakout-hidden'; ?>">							    
        				
        				<label for="custom-field9-label"><?php _e( 'Label', 'speakout'); ?>:</label>
        				<input id="custom-field9-label" name="custom-field9-label" value="<?php 
        				    if($petition->custom_field9_label > ""){
        				        echo trim( stripslashes( esc_attr( $petition->custom_field9_label ) ) ); 
        				    }
        				    else{
        				        echo "Checkbox 4";
        				    }
        				?>" size="30" maxlength="200" type="text" <?php if ( $petition->displays_custom_field9 == 1 ) echo ' required="required"'; ?> />
        				
        				<br /><?php _e( 'Location', 'speakout'); ?><br /><input type="radio" name="custom-field9-location" id="custom-field9-location-top" value="1" <?php if ($petition->custom_field9_location == 1) {echo ' checked="checked"' ;} ?> />
        				<label for="custom-field9-location-top"><?php _e( 'Top', 'speakout'); ?></label><br />
                        <input type="radio" name="custom-field9-location" id="custom-field9-location-middle" value="2" <?php if ($petition->custom_field9_location == 2) {echo ' checked="checked"';}  ?>/>
        				<label for="custom-field9-location-middle"><?php _e( 'Above email', 'speakout'); ?></label><br />
        
                        <input type="radio" name="custom-field9-location" id="custom-field9-location-bottom" value="3" <?php if ($petition->custom_field9_location == 3) {echo ' checked="checked"'; } ?>/>
        				<label for="custom-field9-location-bottom"><?php _e( 'Bottom', 'speakout'); ?></label>
        			</div>
        		</div>
                      	        		
        		
        		<!-- Custom Message -->
        		<div class="misc-pub-section   misc-pub-section-last">
        		    
        			<div class="dk-speakout-checkbox">
        				<input type="checkbox" name="displays-custom-message" id="displays-custom-message" <?php if ( $petition->displays_custom_message == 1 ) echo 'checked="checked"'; ?> />
        				<label for="displays-custom-message" class="dk-speakout-inline"><?php _e( 'Display custom message', 'speakout'); ?></label>
        			</div><span class="margin-20-left"><?php _e( 'Displayed beneath `Thank you` after petition is signed', 'speakout'); ?></span><br />
        			
        			<div class="margin-20-left dk-speakout-custom-message dk-speakout-subsection <?php if( $petition->displays_custom_message != 1 ) echo 'dk-speakout-hidden'; ?>">
        				<label for="custom-message-label"><?php _e( 'Message', 'speakout'); ?>:</label>
        				<input id="custom-message-label" name="custom-message-label" value="<?php echo stripslashes( esc_attr( $petition->custom_message_label ) ); ?>" size="30" maxlength="200" type="text" />
        			</div>
        			
        		</div>
    		</div>
    	</div>
    </div> <!-- end tab 3 -->
    
    <div id="dk-petition-tab-04" class="dk-speakout-hidden dk-petition-tabcontent">
        <div class="postbox">
            <div class="optin-warning"><?php _e("You must also enable 'Display opt-in checkbox' under the Display Options tab", 'speakout'); ?></div>
            
            <div id="minor-publishing">
                
                <div class="misc-pub-section">
                    <div class="dk-speakout-checkbox ">
                        <input type="checkbox" name="activecampaign-enable" id="activecampaign-enable" <?php if ( $petition->activecampaign_enable == 1 ) echo 'checked="checked"'; ?> />
                        <label for="dk-speakout-activecampaign-enable" class="dk-speakout-inline"><?php _e( 'Enable ActiveCampaign', 'speakout'); ?></label>
                    </div>
                    
                    <div class="margin-20-left activecampaign-fields dk-speakout-subsection <?php if( $petition->activecampaign_enable != 1 ) echo 'dk-speakout-hidden'; ?>">

                        <div class="infoText">All fields are required. More info <a href="https://speakoutpetitions.com/faqconc/activecampaign/" target="_new">here</a>.</div>
   
                        <label for="activecampaign-api-key"><?php _e( 'API Key', 'speakout'); ?></label>
                        <input type="text" id="activecampaign-api-key" name="activecampaign-api-key" value="<?php echo $petition->activecampaign_api_key; ?>" size="90"  <?php if ( $petition->activecampaign_enable == 1 ) echo ' required="required"'; ?> /><br> 
                    
                        <label for="activecampaign-server"><?php _e( 'Server URL', 'speakout'); ?>:&nbsp;&nbsp;&nbsp;https://</label>
                        <input type="text" id="activecampaign-server" name="activecampaign-server" value="<?php echo $petition->activecampaign_server; ?>" size="30" <?php if ( $petition->activecampaign_enable == 1 ) echo ' required="required"'; ?> /><br />
                        <div id="activecapaign_instructions" <?php if($petition->activecampaign_server && $petition->activecampaign_api_key){ echo "style='display:none;' ";} ?>>Add these fields and update the petition to reveal your lists and to map fields</div>
                        <div id="activecampaign-form-fields" <?php if($petition->activecampaign_server  === ""  || ($petition->activecampaign_api_key === "" )){ echo "style='display:none;' ";} ?>>
                            <input type="hidden" id="allFieldsReturned" value='<?php if ($petition->activecampaign_enable) echo $allFieldsList; ?>'>
							<input type="hidden" id="alllistsReturned_new" value='<?php if ($petition->activecampaign_enable) echo json_encode($new_lists_array); ?>'>
                            <input type="hidden" id="selectedFieldsReturned" value='<?php if ($petition->activecampaign_enable) echo $selectedFieldList; ?>'>
                             
                            
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-list-id"><?php _e( 'Select list', 'speakout'); ?></label>
                                <select id="activecampaign-list-id" name="activecampaign-list-id">
                                    <?php if ($petition->activecampaign_enable) echo $listOption; ?>
                                </select>
								<input type="hidden" id="selected_list_id" value="<?php echo $petition->activecampaign_list_id ?>"
								<br /><br />
                            </div>
                            
                            <span class="mapIntro"><?php _e("Map the SpeakOut! fields to your Active Campaign fields. Leave those you don't use blank.", "speakout"); ?><br />
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map1value"><?php _e( 'Honorific', 'speakout'); ?>-></label>
								<input type="hidden" id="selected_activecampaign_map1field" value="<?php echo $petition->activecampaign_map1field ?>"/>
                                <select id="activecampaign-map1value" name="activecampaign-map1value">
                                    <?php if ($petition->activecampaign_enable) echo $optionList; ?>
                                </select><br />
                            </div>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map2value"><?php _e( 'First Name', 'speakout'); ?>-></label>
                                <input type="text" id="activecampaign-map2value" name="activecampaign-map2value" value="FIRSTNAME"  readonly="readonly"/><span class="activecampaign-fixed">fixed</span><br />
                            </div>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map3value"><?php _e( 'Last Name', 'speakout'); ?>-></label>
                                <input type="text" id="activecampaign-map3value" name="activecampaign-map3value" value="LASTNAME"  readonly="readonly"/><span class="activecampaign-fixed">fixed</span><br />
                            </div>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map4value"><?php _e( 'Email', 'speakout'); ?>-></label>
                                <input type="text" id="activecampaign-map4value" name="activecampaign-map4value" value="EMAIL" readonly="readonly"  /><span class="activecampaign-fixed">fixed</span><br />
                            </div>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map5value"><?php _e( 'Street', 'speakout'); ?>-></label>
								<input type="hidden" id="selected_activecampaign_map5field" value="<?php echo $petition->activecampaign_map5field ?>"/>
                                <select id="activecampaign-map5value" name="activecampaign-map5value">
                                    <?php if ($petition->activecampaign_enable) echo $optionList; ?>
                                </select><br />
                            </div>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map6value"><?php _e( 'Suburb', 'speakout'); ?>-></label>
								<input type="hidden" id="selected_activecampaign_map6field" value="<?php echo $petition->activecampaign_map6field ?>"/>
                                <select id="activecampaign-map6value" name="activecampaign-map6value">
                                    <?php if ($petition->activecampaign_enable) echo $optionList; ?>
                                </select><br />
                            </div>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map7value"><?php _e( 'State', 'speakout'); ?>-></label>
								<input type="hidden" id="selected_activecampaign_map7field" value="<?php echo $petition->activecampaign_map7field ?>"/>
                                <select id="activecampaign-map7value" name="activecampaign-map7value">
                                    <?php if ($petition->activecampaign_enable) echo $optionList; ?>
                                </select><br />     
                            </div>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map8value"><?php _e( 'Postal Code', 'speakout'); ?>-></label>
								<input type="hidden" id="selected_activecampaign_map8field" value="<?php echo $petition->activecampaign_map8field ?>"/>
                                <select id="activecampaign-map8value" name="activecampaign-map8value">
                                    <?php if ($petition->activecampaign_enable) echo $optionList; ?>
                                </select><br />                        
                            </div>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map9value"><?php _e( 'Country', 'speakout'); ?>-></label>
								<input type="hidden" id="selected_activecampaign_map9field" value="<?php echo $petition->activecampaign_map9field ?>"/>
                                <select id="activecampaign-map9value" name="activecampaign-map9value">
                                    <?php if ($petition->activecampaign_enable) echo $optionList; ?>
                                </select><br />                        
                            </div>
                            <div class="customfieldtitle">Enabled Custom Fields</div>
                            
                            <?php 
                            $fieldEnabled = false;
                            // don't display the fields for mapping if they aren't enabled
                            if($petition->displays_custom_field){ 
                                $fieldEnabled = true; // flag to check at least one is enabled
                            ?>
                            <div class="acfieldlist">
                                <label for="activecampaign-map10"><?php echo $petition->custom_field_label ?>-></label>
								<input type="hidden" id="selected_activecampaign_map10field" value="<?php echo $petition->activecampaign_map10field ?>"/>
                                <select id="activecampaign-map10value" name="activecampaign-map10value" class="activecampaign_customfields_dropdowns">
                                    <?php if ($petition->activecampaign_enable) echo $optionList; ?>
                                </select> <span class="customName">(Custom 1)</span><br />                        
                            </div>
                            <?php } 
                            
                            if($petition->displays_custom_field2){
                                $fieldEnabled = true;
                            ?>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map11value"><?php echo $petition->custom_field2_label; ?>-></label>
								<input type="hidden" id="selected_activecampaign_map11field" value="<?php echo $petition->activecampaign_map11field ?>" />
                                <select id="activecampaign-map11value" name="activecampaign-map11value" class="activecampaign_customfields_dropdowns">
                                    <?php echo $optionList;  ?>
                                </select> <span class="customName">(Custom 2)</span><br />                        
                            </div>
                            <?php } 
                            

                            if($petition->displays_custom_field3){
                                $fieldEnabled = true;
                            ?>
                            
                            <div class="acfieldlist">
                                <label for="activecampaign-map12value"><?php echo $petition->custom_field3_label ?>-></label>
								<input type="hidden" id="selected_activecampaign_map12field" value="<?php echo $petition->activecampaign_map12field ?>"/>
                                <select id="activecampaign-map12value" name="activecampaign-map12value" class="activecampaign_customfields_dropdowns">
                                    <?php echo $optionList; ?>
                                </select> <span class="customName">(Custom 3)</span><br />                        
                            </div>
                            <?php } 
                            
                            if($petition->displays_custom_field4){
                                $fieldEnabled = true;
                            ?>
                            <div class="acfieldlist">
                                <label for="activecampaign-map13"><?php echo $petition->custom_field4_label ?>-></label>
								<input type="hidden" id="selected_activecampaign_map13field" value="<?php echo $petition->activecampaign_map13field ?>"/>
                                <select id="activecampaign-map13value" name="activecampaign-map13value" class="activecampaign_customfields_dropdowns">
                                    <?php echo $optionList; ?>
                                </select> <span class="customName">(Custom 4)</span><br />                        
                            </div>
                            <?php } 
                            
                            if($petition->displays_custom_field5){
                                $fieldEnabled = true;
                            ?>
                            <div class="acfieldlist">
                                <label for="activecampaign-map14value"><?php echo $petition->custom_field5_label ?>-></label>
								<input type="hidden" id="selected_activecampaign_map14field" value="<?php echo $petition->activecampaign_map14field ?>"/>
                                <select id="activecampaign-map14value" name="activecampaign-map14value" class="activecampaign_customfields_dropdowns">
                                    <?php echo $optionList; ?>
                                </select> <span class="customName">(Custom 5)</span><br />
                            </div>
                            <?php } 
                            if( $fieldEnabled != true) { echo "<span class='speakoutDefaulto'>None</span>";}
                            ?>
								
                        </div>
                    </div>
                </div>

                <div class="misc-pub-section">
                
                    <div class="dk-speakout-checkbox ">
                        <input type="checkbox" name="cleverreach-enable" id="cleverreach-enable" <?php if ( $petition->cleverreach_enable == 1 ) echo 'checked="checked"'; ?> />
                        <label for="dk-speakout-cleverreach-enable" class="dk-speakout-inline"><?php _e( 'Enable CleverReach', 'speakout'); ?></label>
                    </div>
                    
                    <div class="margin-20-left cleverreach-fields dk-speakout-subsection <?php if( $petition->cleverreach_enable != 1 ) echo 'dk-speakout-hidden'; ?>">	
                        <div class="infoText">All fields are required. More info <a href="https://speakoutpetitions.com/cleverreach/" target="_new">here</a>.</div>
                        <label for="cleverreach-clientID"><?php _e( 'Client ID ', 'speakout'); ?></label>
                        <input type="text" id="cleverreach-clientID" name="cleverreach-clientID" value="<?php echo $petition->cleverreach_clientID; ?>" size="16"  <?php if ( $petition->cleverreach_enable == 1 ) echo ' required="required"'; ?> /><br> 
                        
                        <label for="cleverreach-client-secret"><?php _e( 'Client Secret', 'speakout'); ?></label>
                        <input type="text" id="cleverreach-clientSecret" name="cleverreach-clientSecret" value="<?php echo $petition->cleverreach_clientSecret; ?>" size="48" <?php if ( $petition->cleverreach_enable == 1 ) echo ' required="required"'; ?> /><br />
                        
                        <label for="cleverreach-groupID"><?php _e( 'Group ID', 'speakout'); ?></label>
                        <input type="text" id="cleverreach-groupID" name="cleverreach-groupID" value="<?php echo $petition->cleverreach_groupID; ?>" size="16" <?php if ( $petition->cleverreach_enable == 1 ) echo ' required="required"'; ?> /><br />
                        
                        <label for="cleverreach-source"><?php _e( 'Source', 'speakout'); ?></label>
                        <input type="text" id="cleverreach-source" name="cleverreach-source" value="<?php echo $petition->cleverreach_source; ?>" size="16" <?php if ( $petition->cleverreach_enable == 1 ) echo ' required="required"'; ?> /><br />
                    </div>
                </div>

                

                <div class="misc-pub-section">
                
                    <div class="dk-speakout-checkbox ">
                        <input type="checkbox" name="mailchimp-enable" id="mailchimp-enable" <?php if ( $petition->mailchimp_enable == 1 ) echo 'checked="checked"'; ?> />
                        <label for="dk-speakout-mailchimp-enable" class="dk-speakout-inline"><?php _e( 'Enable MailChimp', 'speakout'); ?></label>
                    </div>
                    
                    <div class="margin-20-left mailchimp-fields dk-speakout-subsection <?php if( $petition->mailchimp_enable != 1 ) echo 'dk-speakout-hidden'; ?>">	
                        <div class="infoText">All fields are required. More info <a href="https://speakoutpetitions.com/faqconc/mailchimp/" target="_new">here</a>.</div>
                        <label for="mailchimp-api-key"><?php _e( 'API Key', 'speakout'); ?></label>
                        <input type="text" id="mailchimp-api-key" name="mailchimp-api-key" value="<?php echo $petition->mailchimp_api_key; ?>" size="50"  <?php if ( $petition->mailchimp_enable == 1 ) echo ' required="required"'; ?> /><br> 
                        
                        <label for="mailchimp-server"><?php _e( 'Server ID', 'speakout'); ?></label>
                        <input type="text" id="mailchimp-server" name="mailchimp-server" value="<?php echo $petition->mailchimp_server; ?>" size="5" <?php if ( $petition->mailchimp_enable == 1 ) echo ' required="required"'; ?> /><br />
                        
                        <label for="mailchimp-list-id"><?php _e( 'List ID', 'speakout'); ?></label>
                        <input type="text" id="mailchimp-list-id" name="mailchimp-list-id" value="<?php echo $petition->mailchimp_list_id; ?>" <?php if ( $petition->mailchimp_enable == 1 ) echo ' required="required"'; ?> /><br />
                        <br>To enable mailchimp debugging, see <a href="https://pro.speakoutpetitions.com/wp-admin/admin.php?page=dk_speakout_settings">the settings page</a>.
                    </div>
                </div>
                    
                <div class="misc-pub-section">
                
                    <div class="dk-speakout-checkbox ">
                        <input type="checkbox" name="mailerlite-enable" id="mailerlite-enable" <?php if ( $petition->mailerlite_enable == 1 ) echo 'checked="checked"'; ?> />
                        <label for="dk-speakout-mailerlite-enable" class="dk-speakout-inline"><?php _e( 'Enable Mailerlite', 'speakout'); ?></label>
                    </div>
                    
                    <div class="margin-20-left mailerlite-fields dk-speakout-subsection <?php if( $petition->mailerlite_enable != 1 ) echo 'dk-speakout-hidden'; ?>">	
                        <div class="infoText">All fields are required. More info <a href="https://speakoutpetitions.com/faqconc/mailerlite/" target="_new">here</a>.</div>
                        <label for="mailerlite-api-key"><?php _e( 'API Key', 'speakout'); ?></label>
                        <input type="text" id="mailerlite-api-key" name="mailerlite-api-key" value="<?php echo $petition->mailerlite_api_key; ?>" size="50"  <?php if ( $petition->mailerlite_enable == 1 ) echo ' required="required"'; ?> /><br> 
                            
                        <label for="mailerlite-group-id"><?php _e( 'Group ID', 'speakout'); ?></label>
                        <input type="text" id="mailerlite-group-id" name="mailerlite-group-id" value="<?php echo $petition->mailerlite_group_id; ?>" <?php if ( $petition->mailerlite_enable == 1 ) echo ' required="required"'; ?> /><br />
                    </div>
                </div>
                
                
                <div class="misc-pub-section">
                
                    <div class="dk-speakout-checkbox ">
                        <input type="checkbox" name="sendy-enable" id="sendy-enable" <?php if ( $petition->sendy_enable == 1 ) echo 'checked="checked"'; ?> />
                        <label for="dk-speakout-sendy-enable" class="dk-speakout-inline"><?php _e( 'Enable Sendy', 'speakout'); ?></label>
                    </div>
                    
                    <div class="margin-20-left sendy-fields dk-speakout-subsection <?php if( $petition->sendy_enable != 1 ) echo 'dk-speakout-hidden'; ?>">	
                        <div class="infoText">All fields are required. More info <a href="https://speakoutpetitions.com/faqconc/sendy/" target="_new">here</a>.</div>
                        
                        <label for="sendy-server"><?php _e( 'Installation URL', 'speakout'); ?></label>
                        <input type="text" id="sendy-server" name="sendy-server" value="<?php echo $petition->sendy_server; ?>" size="30" <?php if ( $petition->sendy_enable == 1 ) echo 'required="required"'; ?> /><br />
                        
                        <label for="sendy-api-key"><?php _e( 'API Key', 'speakout'); ?></label>
                        <input type="text" id="sendy-api-key" name="sendy-api-key" value="<?php echo $petition->sendy_api_key; ?>" size="30"  <?php if ( $petition->sendy_enable == 1 ) echo 'required="required"'; ?> /><br> 
                    
                        <label for="sendy-list-id"><?php _e( 'List ID', 'speakout'); ?></label>
                        <input type="text" id="sendy-list-id" name="sendy-list-id" value="<?php echo $petition->sendy_list_id; ?>" size="30" <?php if ( $petition->sendy_enable == 1 ) echo 'required="required"'; ?> /><br />
                    </div>
                </div>
             </div>   
        </div>
    </div> <!-- end tab 4 -->
</div>


		<input type="submit" name="Submit" id="dk_speakout_submit" value="<?php echo esc_attr( $button_text ); ?>" class="button-primary" />
	</form>

</div>