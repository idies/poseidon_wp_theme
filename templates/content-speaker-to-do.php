<?php
global $current_user;
global $display_name;
global $all_bio_cfcs;
$all_bio_cfcs = array('Biography' => 'biography-meta' , 
				'Profile Picture(s)' => 'profile-picture-meta',
				'Presentation Upload(s)' => 'presentations-meta',
				);

//Return if there is no speaker to do meta
if ( !$idies_todos = get_cfc_meta( 'speaker-to-do-meta' ) ) return;

// Check if user logged in and a speaker and has a biography to edit.
if ( $current_user_bio_id = get_idies_speaker_bio( $current_user->ID , 'speaker' ) ) {

?>
<p><span class="text-info x-large"><em>Thank you</em></span> for agreeing to speak at the Institute for Data Intensive Engineering and Science's 2015 Symposium! </p>

<p>Please use these pages to edit your <strong>Biography</strong> and upload your <strong>Profile Picture</strong> and <strong>Presentation Files</strong> for the Symposium and <em>Annual Review</em> (a printed publication).</p>

<div class="h3">Your To-Do List</div>

<p>Check your To-Do List progress below.</p>

<div class="clearfix"></div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php

	$todo_num = 1;
	$todo_in = ' in ';
	$todo_collapsed = '';

	//get the to do lists
	foreach ($idies_todos as $this_idies_todo) {
		
		$this_speaker_status = get_speaker_status( $current_user->ID, $current_user_bio_id , $this_idies_todo['cfc-slug']);

?>
<div class="panel <?php echo $this_speaker_status['panel']; ?>">
	<div class="panel-heading" role="tab" id="heading<?php echo $todo_num; ?>">
		<h4 class="panel-title" title="<?php echo $this_speaker_status['msg']; ?>"><span title="<?php echo $this_speaker_status['msg']; ?>" class="glyphicon <?php echo $this_speaker_status['glyph']; ?>"></span>
		<a data-toggle="collapse" class="<?php echo $todo_collapsed; ?>" data-parent="#accordion" href="#collapse<?php echo $todo_num; ?>" aria-expanded="true" aria-controls="collapse<?php echo $todo_num; ?>">
		<?php echo $this_idies_todo['title']; ?>
		</a>
		</h4>		
	</div>
	<div id="collapse<?php echo $todo_num; ?>" class="panel-collapse collapse <?php echo $todo_in; ?>" role="tabpanel" aria-labelledby="heading<?php echo $todo_num; ?>">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-6 col-md-9">
					<?php echo $this_idies_todo['description']; ?>
				</div>
				<div class="col-xs-3 col-md-3">
				<?php  if (strcmp( $this_idies_todo['cfc-slug'] , 'biography-meta' ) === 0 ) :	?>
					<a class="btn btn-primary alignright" href="<?php echo home_url() . $this_idies_todo['slug'] . '?action=view&cfc=' . $this_idies_todo['cfc-slug'] ; ?>">View <?php $this_idies_todo['link']; ?></a>
					<a class="btn btn-primary alignright" href="<?php echo home_url() . $this_idies_todo['slug'] . '?action=edit&cfc=' . $this_idies_todo['cfc-slug'] ; ?>">Edit <?php $this_idies_todo['link']; ?></a>
				<?php  elseif ( in_array( $this_idies_todo['cfc-slug'] , $all_bio_cfcs ) ):	?>
					<a class="btn btn-primary alignright" href="<?php echo home_url() . $this_idies_todo['slug'] . '?action=view&cfc=' . $this_idies_todo['cfc-slug'] ; ?>">List <?php $this_idies_todo['link']; ?></a>
					<a class="btn btn-primary alignright" href="<?php echo home_url() . $this_idies_todo['slug'] . '?action=add&cfc=' . $this_idies_todo['cfc-slug'] ; ?>">Add <?php $this_idies_todo['link']; ?></a>
				<?php  endif;	?>
				</div>
				<div class="col-xs-12">
					<br>
					<?php if (!empty($this_speaker_status['notes'])) echo '<span class="label label-danger medium" >' . $this_speaker_status['notes'] . '</span>'; ?>
				</div>
			</div>
		</div>
	</div>
</div> 
<?php

		$todo_num++;
		$todo_in = '';
		$todo_collapsed = ' collapsed ';
				
	}	
?>
</div> 
<div class="clearfix"></div>
<?php
} else {
			//no bio page for this speaker
?>
<div class="well well-sm well-danger alignleft">A Biography Page does not yet exist for you. Please contact the <a href="mailto:bsouter@jhu.edu">Editor</a>.</div>
<?php
}
