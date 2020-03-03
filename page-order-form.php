<?php 
global $post;
get_template_part('templates/page', 'header');

if ( ( $_REQUEST ) 
	&& ( !empty($_REQUEST[ "action" ]) )
	&& ( $_REQUEST[ "action" ] == 'submit' ) ) {
		
	$debug = false;
	
	// VARS
	if ($debug){
		$email_to = "bsouter@jhu.edu";
	} else {
		$email_to = "hentgen@jhu.edu";
	}
	$email_subject = "IDIES Order Received";
	$email_message = "<dl class='dl dl-horizontal'>";
	$successMessage = "<div class='alert alert-success'>Your request has been submitted.</div><br>\n";

	// possible form fields
	$keylabels = array(
		"fullname"=>"Requestor:",
		"priority"=>"Priority:",
		"ordertype"=>"Order Type:",
		"chargeaccount"=>"Account to Charge:",
		"tagnumber"=>"Tag Number:",
		"vendor"=>"Vendor:",
		"quoterequired"=>"Quote required?:",
		"quotetype"=>"Quote Type:",
		"reason"=>"Reason for purchase:",
		"purchaseapproved"=>"Purchase approved:",
	);
	$knownkeys = array_keys($keylabels);
	$uploadlabels = array(
		"Uploaded quote:",
		"Uploaded approval:",
	);

	// populate request array with known key-value pair
	$request = array();
	foreach ($knownkeys as $this_key){
		if (array_key_exists( $this_key , $_REQUEST ) ) {
			$request[ $this_key ] = $_REQUEST[ $this_key ];
			$email_message .= "<dt>" . $keylabels[ $this_key] . "</dt><dd>" . $_REQUEST[ $this_key] . "</dd>\n";
		}
	}
	$email_message .= "</dl>";
	
	// check uploads are good and add links to email message
	if ( !empty( $_FILES ) ) {
		$email_message .= appendUpload( "orderupload" , $uploadlabels );
	}
	
	// Send IDIES Order Request email
	if ( !wp_mail( $email_to , $email_subject , $email_message ) ) {
		echo "<div class='alert alert-danger'>Failed to send order email.</div>";
		echo "Email failed to $email_to.<br>\n";
		echo $email_message;
	} else {
		echo $successMessage;
		echo $email_message;
	}
	
	echo "<h2>Submit another purchase request</h2>\n";

}

get_template_part('templates/content', 'page'); 

/*/
FUNCTIONS
/*/
function appendUpload( $thisfile , $uploadlabels ){
	
	/// message that goes in the email about uploaded files
	$result = "";
	
	// If there are uploads, loop through the uploads, check each exists and has content
	if ( !empty( $_FILES ) && !empty( $_FILES[ $thisfile ] ) ) {
		
		$orderupload = $_FILES[ $thisfile ];
		for ( $indx = 0; $indx < count( $orderupload[ 'name' ] ); $indx++ ){
			
			if ( $orderupload['size'][ $indx ] > 0 ) {
				
				// Deal with errors
				if ( $orderupload["error"][ $indx ] > 0 ) {
					$result .= "Error uploading ". $orderupload[ 'name' ][ $indx ] . "<br />";
					
				// If successful, rename it, save it, and return its link.
				} else {
					
					// Give it a unique name by inserting a timestamp between the basename and suffix.
					$timestamp = microtime ( true );
					$suffix = pathinfo ( basename( $orderupload['name'][ $indx ] ) , PATHINFO_EXTENSION );
					$basename = basename( $orderupload[ 'name' ][ $indx ] , $suffix );
					$uploadfile = UPLOADSDIR . $basename . "." . $timestamp . "." . $suffix;

					if ( move_uploaded_file( $orderupload[ 'tmp_name' ][ $indx ], $uploadfile ) ) {
						$uploadlink = UPLOADSURL . $basename . $timestamp . "." . $suffix;
						$result .= $uploadlabels[ $indx ] . ": <a href='$uploadlink'>$uploadlink</a>. <br>\n";
					} else {
						$result .= "<div class='alert alert-danger'>Error moving $uploadfile to $uploadlink.<div>\n";
					}
				}
			}
		}
	}
	return $result;
}

/*/
BEGIN FORM HTML
/*/
?>
<form method="post" enctype="multipart/form-data" class="form-horizontal" id="idies-orders">
<input type="hidden" id="action" name="action" value="submit">
	<div class="form-group">
		<label for="fullname">Name<sup class="required">*</sup></label>
		<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full name" required>
	</div>
	<div class="form-group">
		<label for="priority" class="control-label required">Priority (choose one)</label>
		<select class="form-control" name="priority" id="priority" required>
			<option value="Priority 1">Priority 1 - RUSH</option>
			<option value="Priority 2">Priority 2 - Priority (2-3 days)</option>
			<option value="Priority 3">Priority 3 - Important (3-5 days)</option>
			<option value="Priority 4">Priority 4 - No Rush (10-day turnaround)</option>
		</select>
	</div>
	<div class="form-group">
		<label for="ordertype" class="control-label required">Type of order (choose one)</label>
		<select class="form-control" name="ordertype" id="ordertype" required>
			<option value="CAPP Equipment">CAPP Equipment</option>
			<option value="Component Equipment">Component Equipment</option>
			<option value="Supplies">Supplies</option>
			<option value="Replacement Parts">Replacement Parts</option>
			<option value="Service Agreement">Service Agreement</option>
		</select>
	</div>
	<div class="form-group">
		<label for="chargeaccount" class="control-label required">Account to charge (choose one)</label>
		<select class="form-control" name="chargeaccount" id="chargeaccount" required>
			<option value="IDIES - 80021325">IDIES</option>
			<option value="DIBBs - 90056000">DIBBs</option>
			<option value="ACCT NUMBERS 3">ACCT NUMBERS 3</option>
			<option value="ACCT NUMBERS 4">ACCT NUMBERS 4</option>
			<option value="ACCT NUMBERS 5">ACCT NUMBERS 5</option>
			<option value="ACCT NUMBERS 6">ACCT NUMBERS 6</option>
		</select>
	</div>
	<div class="form-group">
		<label for="tagnumber" class="control-label required">Tag number (choose one)</label>
		<select class="form-control" name="tagnumber" id="tagnumber" required>
			<option value="No Tag (supplies or service agreement)">No Tag (supplies or service agreement)</option>
			<option value="New Tag">New Tag</option>
			<option value="Existing Tag">Existing Tag</option>
		</select>
	</div>
	<div class="form-group">
		<label for="vendor" class="required">Vendor</label>
		<input type="text" class="form-control" id="vendor" name="vendor" required>
		<p class="help-block">New vendors require 5 business days to be set up in SAP.</p>
	</div>
	<div class="form-group">
		<div class="checkbox">
				<label for="quoterequired" ><input class="" id="quoterequired" name="quoterequired" type="checkbox" data-toggle="collapse" data-target="#quotecollapse" aria-expanded="false" aria-controls="quotecollapse"> Quote required </label>
		</div>
	</div>
	<div id="quotecollapse" class="well collapse">
		<div class="form-group">
			<label for="uploadquote">Upload quote</label>
			<input type="file" id="uploadquote" name="orderupload[]" class="form-control">
			<p class="help-block">Reason for purchase & links to supplies needed.</p>
		</div>
		<div class="form-group">
			<label for="uploadquote">Quote type</label>
			<div class="radio">
				<label for="competingquotes"><input class="xform-control" type="radio" name="quotetype" id="competingquotes" value="Competing Quotes">Competing Quotes</label><br>
				<label for="solejustification"><input  class="xform-control"type="radio" name="quotetype" id="solejustification" value="Sole Justification">Sole Justification</label><br>
			  </label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="reason">Reason for purchase & links to supplies needed</label>
			<textarea id="reason" name="reason" class="form-control" required></textarea>
	</div>
	<div class="form-group">
		<div class="checkbox">
				<label for="purchaseapproved" ><input class="xform-control" id="purchaseapproved" name="purchaseapproved" type="checkbox" data-toggle="collapse" data-target="#approvecollapse" aria-expanded="false" aria-controls="approvecollapse"> Purchase approved </label>
		</div>
	</div>
	<div id="approvecollapse" class="collapse well">
		<div class="form-group">
			<label for="uploadapproval">Upload email approval</label>
			<input type="file" id="uploadapproval" name="orderupload[]" class="form-control">
			<p class="help-block">Reason for purchase & links to supplies needed.</p>
		</div>
	</div>
	<hr>
	<div class="form-group">
		<button type="submit" value="Send" class="btn btn-primary">Submit</button>
	</div>
</form>

<hr width="50%">

<?php
/*/
END FORM HTML
/*/
?>