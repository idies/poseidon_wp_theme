<?php 
// Display the CPT
if ( !check_wck() ) return;

global $all_bio_cfcs;
$all_bio_cfcs = array('Biography' => 'biography-meta' , 
				'Profile Picture(s)' => 'profile-picture-meta',
				'Presentation Upload(s)' => 'presentations-meta',
				);
while (have_posts()) : 
	the_post(); 

?>
	<article <?php post_class(); ?>>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
<?php

	//get the speaker's id
	$this_speaker_id = get_idies_speaker_id(  );
	if ( !empty( $this_speaker_id ) ) {

		foreach ( $all_bio_cfcs as $this_speaker_cfc_title => $this_speaker_cfc_name ) {
		?>
			<h3><?php echo $this_speaker_cfc_title; ?></h3>
		<?php
			// get the CFC data for this CPT:
			$this_speaker_bio_id = get_the_ID();
			$this_speaker = get_speaker_bio_meta( $this_speaker_bio_id , $this_speaker_cfc_name );
			$this_speaker = clean_speaker_bio_meta( $this_speaker , $this_speaker_cfc_name );
			show_speaker_bio( $this_speaker , $this_speaker_cfc_name );
		}
	} else {
		//Can't find the userid ?>
		<p>There is a problem with this speaker's biography. The userid has not been set.</p>
		<?php
	}
?>
</article>
<?php 
endwhile; 
?>
