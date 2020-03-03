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
?>
<tr>
<td><span class="idies-hour"><?php the_cfc_field('events-details', 'hour' , false, $key); ?>&nbsp;<?php the_cfc_field('events-details', 'ampm' , false, $key); ?></span></td>
<td>
<?php if ($idies_break = get_cfc_field('events-details','break',false,$key,false)) echo "<span class='idies-break'>$idies_break</span>";?>
<?php if (strcmp(get_cfc_field('events-details','keynote',false,$key,false),"yes")===0) echo "<span class='idies-keynote'>Keynote Speaker</span><br>";?>
<?php if ($idies_title = get_cfc_field('events-details','title',false,$key,false)) echo "<span class='idies-title'>$idies_title</span><br>";?>
<?php if ($idies_speaker = get_cfc_field('events-details','speaker',false,$key,false)) echo "<span class='idies-speaker'>$idies_speaker</span>";?>
<?php if ($idies_affiliation = get_cfc_field('events-details','affiliation',false,$key,false)) echo ", <span class='idies-affiliation'>$idies_affiliation</span>\n";?>
</td>
<?php 
// break
//title
//speaker
//affiliation
//keynote
?>
</tr>
<?php
	endforeach;
?>
</tbody>
</table>
<?php
endwhile; 
?>
