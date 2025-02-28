<?php

session_start();

//for use with javascript unescape function
function encode($input) {
	$temp = '';
	$length = strlen($input);
	for($i = 0; $i < $length; $i++) {
		$temp .= '%' . bin2hex($input[$i]);
	}
	return $temp;
}


//if posting only
if(isset($_POST['submit'])) {
	$return = array('type' => 'error', 'session' => $_SESSION);
	// $answer = isset($_POST['autovalue'/]) ? trim($_POST['autovalue']) : false;

	// $to = 'edwardforcpu@gmail.com';
	$to = 'jaiminsonal2015@gmail.com';

	$name = isset($_POST['name']) ? trim($_POST['name']) : '';
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$persons = isset($_POST['persons']) ? trim($_POST['persons']) : '';
	$message = isset($_POST['message']) ? trim($_POST['message']) : '';
	// $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
	$subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'RSVP Form Submission';

	$events = implode('<br />', $_POST['whichevent']);

	if($name && $email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: My Wedding Website <no-reply@sonalwedsjaimin.com>\r\n";

		$message .= 'New Signup for your Wedding<br />';
		$message .= ' <br /> Name: ' . $name;
		$message .= ' <br /> Email: ' . $email;
		if($persons) {
			$message .= ' <br /> Number of Persons: ' . $persons;
		}

		$message .= ' <br /> Attending the following event(s):';
		$message .= " <br /> " . $events;

		if (isset($_POST['brideorgroom'])) {
			if ($_POST['brideorgroom'] == 'jaimin') {
				$to = 'jaiminsonal2015@gmail.com';
			} else {
				$to = 'sonaljaimin2015@gmail.com';
			}
		}

		@$send = mail($to, $subject, $message, $headers);

		if($send) {
			$return['type'] = 'success';
			// $return['message'] = 'Email successfully sent.';
			$return['message'] = $events;
		} else {
			$return['type'] = 'error';
			$return['message'] = "Error sending email.";
		}

	} else {
		$return['type'] = 'error';
		$return['message'] = 'Error validating email.';
	}


	die(json_encode($return));
}


?>
