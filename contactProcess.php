<?php

session_start();

// To check the origin of the POST data based on token and date and time and user IP of form submit
if ($_POST['token1'] == $_SESSION['token'] && $_POST['token2'] == $_SESSION['dateandtime'] && $_POST['token3'] == $_SERVER['REMOTE_ADDR'])
{
    require_once("contact_files/includes/recaptchalib.php");
    require_once("contact_files/includes/functions.php");

	// To prevent sending spams, check the entered code
	$privatekey = "YOUR reCAPTCHA Private KEY";
        $resp = recaptcha_check_answer ($privatekey,
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]);

	 if ($resp->is_valid) {
      
        // check server-side validation here
      	// Initialize arrays for errors
		$field_errors = array();

		// Form validation for required fields
		$field_errors = array_merge($field_errors, required_field_check('inputEmail'));
		$field_errors = array_merge($field_errors, required_field_check('inputMessage'));

      	// If there is no error, send the email
		if (empty($field_errors))
		{

            $senderName = $_POST['inputName'];
            $senderEmail = $_POST['inputEmail'];
            $message = $_POST['inputMessage'];
            $to = "YOUR EMAIL";
            $subject = $_POST['inputSubject'];

            $headers   = array();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/plain; charset=utf-8";
            $headers[] = "From: {$senderName} {$senderEmail}";
            $headers[] = "Reply-To: {$senderEmail}";
            $headers[] = "X-Mailer: PHP/".phpversion();

            mail($to, $subject, $message, implode("\r\n", $headers));
            echo "<div class='alert alert-success'>Your message has been sent. </div>";
		}
		else
		{
            echo "<div class='alert alert-error'>Server side validation error.</div>";
		}
	 }
	 else
	 {
         echo "<div class='alert alert-error'>wrong CAPTCHA code. try again.</div>";
	 }
}
else
{
    exit();
}

?>