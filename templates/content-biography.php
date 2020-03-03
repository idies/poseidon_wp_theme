<?php 

// Check required WCK plugin exists or return
if ( !check_wck() ) {
	return;
}

// if logged in and has role 'speakers'
global $current_user;
global $display_name;
global $all_bio_cfcs;
$all_bio_cfcs = array('Biography' => 'biography-meta' , 
				'Profile Picture(s)' => 'profile-picture-meta',
				'Presentation Upload(s)' => 'presentations-meta',
				);

if ( get_idies_login( 'speakers' ) ) {

	// What to do ... what to do ...
	if ( ( $current_user_cfc = get_query_var( 'cfc' ) ) ) {
		
		if ( !in_array( $current_user_cfc , $all_bio_cfcs ) ) if (idies_report_error("An unknown error has occurred.")) return;
		if ( locate_template( 'templates/content-' . $current_user_cfc . '.php' ) != '') : 
			get_template_part( 'templates/content' , $current_user_cfc ); 
		endif; 	
	}

//   else if_admin
} elseif ( current_user_can( 'edit_others_posts' ) ) {
	if ( idies_report_error('Please edit <a href=\"http://test.idies.jhu.edu/symposium/wp-admin/edit.php?post_type=speaker\" >Speaker Biographies</a> from the WordPress Admin Interface.') ) return;
} else {
	if ( idies_report_error('Speakers must log in to view and or edit their biography and attachments.') ) return;
}
			