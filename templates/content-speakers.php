<?php 
// Check required WCK plugin exists or return
if ( !check_wck() ) {
	return;
}

// if logged in and has role 'speakers'
global $current_user;
if ( get_idies_login( 'speakers' ) ) {

	// begin show speaker to do list 
	get_template_part('templates/content', 'speaker-to-do'); 

//   else if_admin
} elseif ( current_user_can('edit_others_posts') ) {
?>
	<div class="well well-sm well-danger alignleft">Please edit <a href='http://test.idies.jhu.edu/symposium/wp-admin/edit.php?post_type=speaker' >Speaker Biographies</a> from the WordPress Admin Interface.</div>
<?php 

} else {
?>	
	<div class="well well-sm well-danger alignleft">Speakers must log in to view and or edit their biography and attachments.</div>
	<a class="btn btn-primary alignleft" href="http://test.idies.jhu.edu/symposium/wp-login.php?action=lostpassword">Forgot password?</a>
<?php
}
?>
