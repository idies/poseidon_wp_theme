<?php
if ( !function_exists( 'get_cfc_meta' ) ) return;
$resources = get_cfc_meta( 'resources-meta' ); 
foreach( $resources as $key => $value ) : 
	
	$resource_id = get_cfc_field('resources-meta', 'resource-id', false, $key);
	$resource_title = get_cfc_field('resources-meta', 'title', false, $key);
	$resource_description = get_cfc_field('resources-meta', 'description', false, $key);
	$resource_email = get_cfc_field('resources-meta', 'contact-email', false, $key);
	$resource_contact = get_cfc_field('resources-meta', 'contact-name', false, $key);
	$resource_url = get_cfc_field('resources-meta', 'url', false, $key);
	$resource_link = get_cfc_field('resources-meta', 'link-text', false, $key);
	
	echo "<div class='resource-meta'>\n";
	if (!empty($resource_title)) {
		echo "<h2 ";
		if (!empty($resource_id)) echo " id='" . $resource_id . "'";
		echo ">" . $resource_title . "</h2>\n";
	}
	echo "<div class='well well-sm well-default'>";
	if (!empty($resource_description)) echo  "<p>" . $resource_description . "</p>\n";
	if (!empty($resource_email)){
		echo "<p>For more info, please contact <a href='$resource_email'>";
		the_cfc_field('resources-meta', 'contact-name', false, $key);
		echo "</a>.</p>\n";
	}
	if (!empty($resource_url)) echo "<p><a class='btn btn-sm btn-primary' href='" . $resource_url . "'>" . $resource_link . "</a></p>\n";
	echo "</div>\n";
	echo "</div>\n";
endforeach;
