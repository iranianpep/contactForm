<?php
session_start();
require_once('contact_files/includes/recaptchalib.php');
?>

<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="contact_files/css/bootstrap.min.css" rel="stylesheet">
    <link href="contact_files/css/custom.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 10px;
        background-color: #f5f5f5;
      }
    </style>
    <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://twitter.github.io/bootstrap/assets/js/html5shiv.js"></script>
    <![endif]-->
    
    <!-- Change reCaptcha theme -->
      <script type="text/javascript">
      var RecaptchaOptions = {
	 theme : 'custom',
	 custom_theme_widget: 'recaptcha_widget'
      };
      </script>
    
  </head>

  <body>

    <div class="container">

    <?php

	// To check the origin of the POST data based on token and date and time of form submit
	$token = sha1(uniqid(rand(), true));
	$_SESSION['token'] = $token;

	$date = date("D M d, Y G:i");
	$_SESSION['dateandtime'] = $date;

    $userIp = $_SERVER['REMOTE_ADDR'];

	?>
      
      <form id="contact_form" name="contact_form" class="form-contact" action="" onSubmit="return false;">
        <h2 class="form-contact-heading">Contact Us</h2>
        <div class="control-group">
            <input type="text" id="inputName" name="inputName" placeholder="Name" class="input-block-level" dir="auto" maxlength="100">
        </div>
        <div class="control-group">
            <input type="text" id="inputEmail" name="inputEmail" placeholder="Email *" class="input-block-level" maxlength="100">

        </div>
        <div class="control-group">
            <input type="text" id="inputSubject" name="inputSubject" placeholder="Subject" class="input-block-level" dir="auto" maxlength="100">
        </div>
        <div class="control-group">
              <textarea class="input-block-level" rows="4" name="inputMessage" placeholder="Message *" style="max-width: 100%;" dir="auto"></textarea>

        </div>
	<div class="control-group">
	  
	      <div id="recaptcha_widget" class="form-captcha" style="display:none">
		<div id="recaptcha_image" style="max-width:210px;"></div>
		<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
	     
		<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="input-block-level" placeholder="Enter the words / numbers" />
		<br/>
		<span><a href="javascript:Recaptcha.reload()"><i class="icon-refresh"></i></a></span>
		<span class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')"><i class="icon-volume-up"></i></a></span>
		<span class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')"><i class="icon-eye-open"></i></a></span>
		<span><a href="javascript:Recaptcha.showhelp()"><i class="icon-question-sign"></i></a></span>
		<span style="font-size: 10px; padding-left: 25%;">powered by <a href="http://www.google.com/recaptcha" target="_blank">reCAPTCHA</a></span>
	      </div>
	     
	      <script type="text/javascript"
		 src="http://www.google.com/recaptcha/api/challenge?k=YOUR reCAPTCHA PUBLIC KEY">
	      </script>
	      <noscript>
		<iframe src="http://www.google.com/recaptcha/api/noscript?k=YOUR reCAPTCHA PUBLIC KEY"
		     height="300" width="500" frameborder="0"></iframe><br>
		<textarea name="recaptcha_challenge_field" rows="3" cols="40">
		</textarea>
		<input type="hidden" name="recaptcha_response_field"
		     value="manual_challenge">
	      </noscript>
	      
	</div>
	    <input type="hidden" name="token1" value="<?php echo $token; ?>" />
	    <input type="hidden" name="token2" value="<?php echo $date; ?>" />
        <input type="hidden" name="token3" value="<?php echo $userIp; ?>" />
        <input class="btn btn-primary" type="submit" name="submit" id="submitBtn" disabled="disabled" value="send" />
        <img src="contact_files/img/ajax-loader.gif" alt="ajax loader icon" class="ajaxLoader" /><br/><br/>
          <div id="resultMessage" style="display: none;"></div>

          <div style="font-size: 10px;">Designed by <a href="http://keepcoding.ehsanabbasi.com/" target="_blank">Ehsan Abbasi</a></div>
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="contact_files/js/bootstrap-button.js"></script>
    <script src="contact_files/js/jquery.validate.min.js"></script>
    <script src="contact_files/js/jquery.validate.extended.js"></script>

    <script type="text/javascript">
	  $(document).ready(function(){
			
                        // disable submit button in case of disabled javascript browsers
                        $(function(){
                          $('#submitBtn').attr('disabled', false);
                        });
            
			$("#contact_form").validate({
				rules:{
					inputEmail:{
                                            required: true,
                                            email: true
						},
                                        inputMessage:{
                                            required: true
                                        },
					recaptcha_response_field:{
					  required: true
					}
				},
                                highlight: function(element) {
                                  $(element).closest('.control-group').removeClass('success').addClass('error');},
                                success: function(element) {
                                  $(element).closest('.control-group').removeClass('error').addClass('success');
                                  $(element).closest('.control-group').find('label').remove();
                                },
                                errorClass: "help-inline"
			});
                        
                        $("#contact_form").submit(function()
                                                  {
                                                    if ($("#contact_form").valid())
                                                    {

                                                      // Disable button while processing
                                                      $('#submitBtn').attr('disabled', true);

                                                      // show ajax loader icon
                                                      $('.ajaxLoader').fadeIn("fast");

                                                      var dataString = $("#contact_form").serialize();

                                                    $.ajax({
                                                      type: "POST",
                                                      url: "contactProcess.php",
                                                      data: dataString,
                                                      success: function(dataString) {
                                                            $("#resultMessage").html(dataString).fadeIn("slow");

                                                          // If is successful, reset the form
                                                          if (dataString == "<div class='alert alert-success'>Your message has been sent. </div>")
                                                              $('#contact_form')[0].reset();

                                                          // hide ajax loader icon
                                                          $('.ajaxLoader').fadeOut("fast");

                                                          // Enable button after processing
                                                          $('#submitBtn').attr('disabled', false);

                                                          setTimeout(function() {
                                                              $("#resultMessage").fadeOut("slow")
                                                          }, 5000);

                                                          // Reload the captcha code after each submit
                                                          Recaptcha.reload();

                                                        }
                                                      });
                                                      
                                                    }

                                                      return false;

                                                  });

		});
	  </script>

</body></html>
