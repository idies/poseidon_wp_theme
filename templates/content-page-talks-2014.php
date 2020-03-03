<?php 
while (have_posts()) : 
	the_post(); 
	the_content(); 
	if ( !function_exists( 'get_cfc_meta' ) ) return;
	$idies_agenda = get_cfc_meta( 'events-details' ); 
	if ( !count( $idies_agenda ) ) return;
	
?>
<table class="table table-condensed idies-agenda">
<tbody>
<?php
	$i=0;
	foreach($idies_agenda as $key => $value):
		if ($slidepdf = get_cfc_field('events-details', 'presentation-pdf' , false, $key)) {
			$view = "<a class='btn btn-primary btn-sm' href='" . $slidepdf->guid . "' target='_blank'>View&nbsp;PDF</a>";
		} elseif ($slidelink = get_cfc_field('events-details', 'panopto-link' , false, $key)) {
			$view = "<a class='btn btn-primary btn-sm' href='" . $slidelink . "' target='_blank'>View&nbsp;Online</a>";
		} else {
			$view = " ";
		}
?>
<tr>
<td>&nbsp;</td>
<td><?php echo $view; ?></td>
<td>
<?php if (strcmp(get_cfc_field('events-details','keynote',false,$key,false),"yes")===0) echo "<span class='idies-keynote'>Keynote Speaker</span><br>";?>
<?php if ($idies_title = get_cfc_field('events-details','title',false,$key,false)) echo "<span class='idies-title'>$idies_title</span><br>";?>
<?php if ($idies_speaker = get_cfc_field('events-details','speaker',false,$key,false)) echo "<span class='idies-speaker'>$idies_speaker</span>";?>
<?php if ($idies_affiliation = get_cfc_field('events-details','affiliation',false,$key,false)) echo ", <span class='idies-affiliation'>$idies_affiliation</span>\n";?>
</td>
</tr>
<?php
	endforeach;
?>
</tbody>
</table>
<?php
endwhile; 
?>
