<?php
/* 
 * This file processes requests to view/edit the speaker's presentation uploads.
 * 
 * Provide link to Speaker-Bio Archive page for Admin and Editors.
 *
 */

$ignore_fields_titles = array( 'Unique ID' , 'Status' );

global $current_user;
global $all_bio_cfcs;

if ( !$current_user_action = get_query_var( 'action' ) ) $current_user_action = 'view';
if ( !$current_user_cfc = get_query_var( 'cfc' ) ) return;
$this_speaker_cfc_form = get_speaker_cfc_form( $current_user_cfc );
$form_id_base = 'idies-form-';

if ( !$form_name = array_search( $current_user_cfc , $all_bio_cfcs ) ) {
			if ( idies_report_error("Form not found.") ) return;
	}
?>
<hr>
<?php
// Check if user logged in and a speaker and has a biography to edit.
if ( $current_user_bio_id = get_idies_speaker_bio( $current_user->ID , 'speaker' ) ) {

	$this_speaker_info = get_user_by( 'id' , $current_user->ID);
	
	//  ** SUBMIT **  //
	if ( strcmp( 'submit' , $current_user_action ) === 0 ) :	

		//  ** Process form**  //
		$updated_speaker_info = get_updated_bio_meta( $this_speaker_cfc_form , $current_user_bio_id);
		if ( !set_updated_bio_meta( $updated_speaker_info , $current_user_bio_id , $current_user_cfc , $ignore_fields_titles , 'Started' , true) ) :
			if ( idies_report_error("Error updating") ) return;
		endif;

	//  ** DELETE **  //
	elseif ( strcmp( 'delete' , $current_user_action ) === 0 ) :	
		
		if ( !$this_attachment_id = get_query_var( 'target' ) ) :
			if (idies_report_error('Nothing to delete.') ) return;
		endif;
		$this_attachment_indx = get_query_var( 'which' );

		//  ** Process form**  //
		if ( false === delete_speaker_upload( $this_attachment_id , $this_attachment_indx , $current_user_bio_id , $current_user_cfc ) ) if (idies_report_error('An unusual error has occurred.') ) return;
		
	endif ; 
	
	// get speaker data now, after update.
	$this_speaker = get_speaker_bio_meta( $current_user_bio_id , $current_user_cfc );

	//  ** VIEW **  //
	//  ** Display pics **  //
	if ( in_array( $current_user_action , array( 'view' , 'submit' , 'delete') ) ) :
	
?>
		<a href='?action=add&cfc=<?php echo $current_user_cfc; ?>' class='btn btn-primary alignright'>Add</a><h2>My <?php echo "$form_name"; ?></h2>
<?php
		show_speaker_bio( $this_speaker , $current_user_cfc);
	endif;
	
	//  ** EDIT **  //
	//  ** Display form **  //
	if ( strcmp( 'add' , $current_user_action ) === 0 ) :
	
?>
<div class="<?php echo $current_user_cfc; ?>-form">
<form method="POST"  enctype="multipart/form-data" action="?action=submit&cfc=<?php echo $current_user_cfc; ?>">
<a class="btn btn-warning alignright" href="?action=view&cfc=<?php echo $current_user_cfc; ?>">Cancel</a><a class="btn btn-danger alignright" href="?action=add&cfc=<?php echo $current_user_cfc; ?>">Reset</a><button type="submit" class="btn btn-primary alignright">Submit</button><h2><?php echo "$form_name"; ?></h2>

<?php
		$this_form_field_num = 1;
		$this_form_field_class = $form_id_base . $this_form_field_num;
		
		foreach( $this_speaker_cfc_form['fields'] as $this_cfc_form_field ) {
		
			if ( in_array ( $this_cfc_form_field['field-title'] , $ignore_fields_titles ) ) continue;
			if ( strcmp('true',$this_speaker_cfc_form['repeater']) === 0 )  :
				$this_input_default = '';
			else :
				$this_input_default = $this_speaker[ sanitize_title( $this_cfc_form_field[ 'field-title' ] ) ];
			endif;
			
			?><div class="form-group <?php echo $this_form_field_class?>"><?php
			switch ($this_cfc_form_field['field-type']) {
				case 'text':
				case 'textarea':
					//  **  TEXT OR TEXTAREA INPUT  **  //
					idies_show_single_input( $this_cfc_form_field['field-type'] , $this_cfc_form_field['field-title'] , 
						$this_cfc_form_field['description'] , $this_cfc_form_field['required'] , $this_form_field_class ,
						$this_input_default );
					break;
				case 'upload':
					//  ** File UPLOAD  **  //
					idies_show_single_input( 'file' , $this_cfc_form_field['field-title'] , 
						$this_cfc_form_field['description'] , $this_cfc_form_field['required'] , 'upload' ,
						$this_input_default );
					break;
				case 'radio':
				case 'select':
				case 'checkbox':
					//  **  RADIO, SELECT, OR CHECKBOX INPUT  **  //
					idies_show_multiple_input( $this_cfc_form_field['field-type'] , $this_cfc_form_field['field-title'] , 
						$this_cfc_form_field['description'] , $this_cfc_form_field['required'] , $this_form_field_class , 
						$this_cfc_form_field['options'] , $this_input_default );
					break;
				default:
					if ((WP_DEBUG)) echo "<!-- DEBUG:: Unknown Field Type: ". $this_cfc_form_field['field-type']. "-->";
			}
			
			?></div><?php
			$this_form_field_class = $form_id_base . ++$this_form_field_num;
		}
?>
<a class="btn btn-warning" href="?action=view&cfc=<?php echo $current_user_cfc; ?>">Cancel</a>
<a class="btn btn-danger" href="?action=add&cfc=<?php echo $current_user_cfc; ?>">Reset</a>
<button type="submit" class="btn btn-primary">Submit</button>
</form>		
</div>
<?php		
	endif ; 
	
} else {
	//no bio page exists for this speaker
	if (idies_report_error('A Biography Page does not yet exist for you. Please contact the <a href=\"mailto:bsouter@jhu.edu\">Editor</a>.') ) return;
}
?>
<hr>
<?php

