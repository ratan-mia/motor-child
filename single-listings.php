<?php 
                    // Response Generation Function

                        $response = "";
                          //function to generate response
                          function righslide_form_generate_response($type, $message){

                            global $response;

                            if($type == "success") $response = "<div class='success'>{$message}</div>";
                            else $response = "<div class='error'>{$message}</div>";

                          }

                          //response messages
                          $missing_content = "Please supply all information.";
                          $email_invalid   = "Email Address Invalid.";
                          $message_unsent  = "Message was not sent. Try Again.";
                          $message_sent    = "Thanks! Your message has been sent.";

                          
                          //php mailer variables
                          $to = get_option('admin_email');

                       
                           
                          $headers = 'From: '. $email . "\r\n" .
                            'Reply-To: ' . $email . "\r\n";
                           // Send Enquery and Test Drive Request
                           
                           if(isset($_POST["enquiry_submit"])){
                              $firstname = $_POST['firstname'];
                              $lastname = $_POST['lastname'];
                              $email = $_POST['email'];
                              $telephone = $_POST['telephone'];
                              $enquiry = $_POST['enquiry'];

                              if ($_POST['formtype']=='enquery'){

                            $subject = "New Query From: ".get_bloginfo('name');
                            $message_sent = "Thankyou for your enquiry. Our sales team contact you soon regarding this.";

                          }
                          
                          elseif ($_POST['formtype']=='testdrive') {
                             $subject = "New Test Drive From: ".get_bloginfo('name');
                             $message_sent = "Thankyou for you request. One of our members from the sales team will set up an appointment with you for your requested test drive. Please note that test drives are subject to availabilty of cars, customer traffic in our showroom and weather conditions.";
                          }

                             //validate email
                              if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                                righslide_form_generate_response("error", $email_invalid);
                              else //email is valid
                              {
                                //validate presence of name and message
                                if(empty($firstname) || empty($lastname) || empty($telephone) || empty($enquiry)){
                                  righslide_form_generate_response("error", $missing_content);
                                }
                                else //ready to go!
                                {


                                  $sent = wp_mail($to, $subject, strip_tags($enquiry), $headers);
                                  if($sent) righslide_form_generate_response("success", $message_sent); //message sent!
                                  else righslide_form_generate_response("error", $message_unsent); //message wasn't sent


                                }
                              }
                               echo $response;
                              exit;
                              
                            }

                            // Refer a Friend

                             if(isset($_POST["refer_friend"])){
                                //user posted variables
                                $yourName = $_POST['yourName'];
                                $friendsName = $_POST['friendsName'];
                                $friendsEmail = $_POST['friendsEmail'];
                              $to = $friendsEmail;
                              $subject = $yourName." Has Referred You a Car From: ".get_bloginfo('name');
                              $headers = 'From: '. $friendsEmail . "\r\n" .
                            'Reply-To: ' . $friendsEmail . "\r\n";
                              $refrered_car = get_the_title();
                              $refrered_car_link = get_the_permalink();
                             $refer_content = "Dear 
                             ".$friendsName.",
                             Your friend ".$yourName." wanted to share ".$refrered_car." with you. Please check it out from the link below:
                                ".$refrered_car_link."

                                If you have any question of queries, please feel free to call us or visit our website for more details. 


                                Regards
                                The Asian Imports Team 
                                ";
                            $message_sent = "Thankyou. The details of the car you selcted will be emailed to your friend shortly.";

                             //validate email
                              if(!filter_var($friendsEmail, FILTER_VALIDATE_EMAIL))
                                righslide_form_generate_response("error", $email_invalid);
                              else //email is valid
                              {
                                //validate presence of name and message
                                if(empty($yourName) || empty($friendsName) ){
                                  righslide_form_generate_response("error", $missing_content);
                                }
                                else //ready to go!
                                {


                                  $sent = wp_mail($to, $subject, strip_tags($refer_content), $headers);
                                  if($sent) righslide_form_generate_response("success", $message_sent); //message sent!
                                  else righslide_form_generate_response("error", $message_unsent); //message wasn't sent
                                }
                              }
                              echo $response;
                               exit;
                               
}
            


ob_start();
if (stm_is_magazine()) {
    add_filter('body_class', 'stm_listing_magazine_body_class');
}
?>
<?php get_header();?>

<?php get_template_part('partials/page_bg');?>
<?php get_template_part('partials/title_box');?>

<div class="stm-single-car-page">
    <?php if (stm_is_motorcycle()) {
    get_template_part('partials/single-car-motorcycle/tabs');
}?>

    <?php
$recaptcha_enabled    = get_theme_mod('enable_recaptcha', 0);
$recaptcha_public_key = get_theme_mod('recaptcha_public_key');
$recaptcha_secret_key = get_theme_mod('recaptcha_secret_key');
if (!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)) {
    wp_enqueue_script('stm_grecaptcha');
}
?>

    <div class="container">

        <?php if (have_posts()):

    $template = 'partials/single-car/car-main';
    if (is_listing()) {
        $template = 'partials/single-car-listing/car-main';
    } elseif (stm_is_boats()) {
    $template = 'partials/single-car-boats/boat-main';
} elseif (stm_is_motorcycle()) {
    $template = 'partials/single-car-motorcycle/car-main';
}

while (have_posts()): the_post();

    $vc_status = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);

    if ($vc_status != 'false' && $vc_status == true) {
        the_content();
    } else {
        get_template_part($template);
    }

endwhile;

endif;?>

        <div class="clearfix">
            <?php /*
if ( comments_open() || get_comments_number() ) {
comments_template();
} */

require_once get_stylesheet_directory() . '/related-car-listing.php';
?>


        </div>
    </div>
    <!--cont-->

    <?php

require_once get_stylesheet_directory() . '/print-car-listing.php';

?>
    <!--Start Left Nav Actions-->
    <!--  <div id="actions">
                <h3 style="text-align:center;"><a href="/contact-us/">Gulshan-2, Dhaka</a></h3>
                <h4 style="text-align:center;"><a href="tel:+880188600300" class="ti">+880188-600300</a></h4>
                <button id="enquery-btn">Enquire Now</button>
                <form method="post" target="_blank">
                    <input type="submit" name="create_pdf" class="actions-btn" value="PRINT" />
                </form>
                <button id="testdrive-btn">Book a Test Drive</button>
                <button id="email-friend-btn">Email a Friend</button>
            </div> -->
    <!--End Left Nav Actions-->

    <!-- Enquiry Form -->
    <div id="rightslide" class="enquirySlide">
        <div class="inner" id="enqContent" style=" display:none;">
            <a href="javascript:void(0);" class="closeSlide">X</a>

            <form action="<?php the_permalink(); ?>" method="post" id="pageEnquiry" name="pageEnquiry">
                <b class="ttl">Got a Quesiton?</b>
                <p class="txt">If you've got any questions about this Bmw X5, please feel free to send us an email using the form below:</p>
                <input type="text" name="firstname" id="firstname" maxlength="35" placeholder="First Name" value="<?php echo esc_attr($_POST['firstname']); ?>">
                <input type="text" name="lastname" id="lastname" maxlength="35" placeholder="Last Name" value="<?php echo esc_attr($_POST['lastname']); ?>">
                <input type="email" name="email" id="email" maxlength="65" class="" placeholder="Email Address" value="<?php echo esc_attr($_POST['email']); ?>">

                <input type="tel" name="telephone" id="telephone" maxlength="35" class="" placeholder="Telephone" value="<?php echo esc_attr($_POST['telephone']); ?>">

                <textarea name="enquiry" id="enquiry" rows="5" placeholder="Your questions..."><?php echo esc_attr($_POST['enquiry']); ?></textarea>
                <br>
                <input type="hidden" id="formtype" name="formtype" value="">
                <div class="form-action-btn">
                    <button type="submit" id="enquiry_submit" name="enquiry_submit">Send</button>
                    <button type="button" class="cancel-btn">Cancel</button>
                </div>
                <br>
                <br>
                <br>
                <div id="response">
                    <?php echo $response; ?>
                </div>
            </form>

            <form action="<?php the_permalink(); ?>" method="post" id="sendFriend" name="sendFriend" class='none'>
                <b class="ttl">Email a Friend</b>
                <p class="txt">If you'd like to email the details of this
                    <?php echo get_the_title() ;?> to a friend, please use the form below:</p>
                <input type="text" name="yourName" id="yourName" maxlength="65" value="<?php echo esc_attr($_POST['yourName']); ?>" placeholder="Your Name">
                <input type="text" name="friendsName" id="friendsName" maxlength="65" value="<?php echo esc_attr($_POST['friendsName']); ?>" placeholder="Friend's Name">
                <input type="email" name="friendsEmail" id="friendsEmail" value="<?php echo esc_attr($_POST['friendsEmail']); ?>" maxlength="65" class="" placeholder="Friend's Email">

                <br>
                <div class="form-action-btn">

                    <button type="submit" id="refer_friend" name="refer_friend">Send</button>
                    <button type="button" class="cancel-btn">Cancel</button>
                </div>
                <br>
                <br>
                <br>
                <div id="response_refer">
                    <?php echo $response; ?>
                </div>
            </form>
        </div>
    </div>
    <!-- Enquiry Form [end] -->
    <script>
        jQuery(document).ready(function($) {

            $('#actions button').click(function() {

                var buttonId = $(this).attr('id');

                if (buttonId == "email-friend-btn") {
                    $('#sendFriend').show();
                    $('#pageEnquiry').hide();
                } else {
                    $('#sendFriend').hide();
                    $('#pageEnquiry').show();

                    if (buttonId == "testdrive-btn") {
                        var ttl = "Request Test Drive";
                        var txt = "If you'd like to take <?php echo get_the_title() ;?> car a test drive, please feel free to send us an email using the form below:";
                        $('#rightslide input[name="formtype"]').val('testdrive');
                    } else {
                        var ttl = "Got a Quesiton?";
                        var txt = "If you've got any questions about this <?php echo get_the_title() ;?>, please feel free to send us an email using the form below:";
                        $('#rightslide input[name="formtype"]').val('enquery');

                    }
                    $('#rightslide').find('#pageEnquiry .ttl').html(ttl);
                    $('#rightslide').find('#pageEnquiry .txt').html(txt);

                }

                if ($('#rightslide').width() == 0) {
                    var boxwidth = 300;
                    $('#enqContent').delay(300).fadeIn(200);

                } else {
                    $('#enqContent').fadeOut(0);
                    var boxwidth = 0;
                }
                $('#rightslide').animate({
                    'width': boxwidth + 'px'
                }, 100);
            });


            $('form-action-btn button[type="submit"]')
            $('.closeSlide,.cancel-btn').click(function(event) {
                $('#enqContent').fadeOut(0);
                $('#rightslide').animate({
                    'width': '0px'
                }, 100);
            });

            $('#enquiry_submit').click(function(event) {
                event.preventDefault();
                var firstname = $('#firstname').val();
                var lastname = $('#lastname').val();
                var email = $('#email').val();
                var telephone = $('#telephone').val();
                var enquiry = $('#enquiry').val();
                var formtype = $('#formtype').val();
                $.ajax({
                    type: 'post',
                    data: {
                        enquiry_submit: 1,
                        firstname: firstname,
                        lastname: lastname,
                        email: email,
                        telephone: telephone,
                        enquiry: enquiry,
                        formtype: formtype
                    },
                    success: function(response) {
                        $('#response').html(response);
                    }
                });
            });

            $('#refer_friend').click(function(event) {
                event.preventDefault();
                var yourName = $('#yourName').val();
                var friendsName = $('#friendsName').val();
                var friendsEmail = $('#friendsEmail').val();

                $.ajax({
                    type: 'post',
                    data: {
                        refer_friend: 1,
                        yourName: yourName,
                        friendsName: friendsName,
                        friendsEmail: friendsEmail
                    },
                    success: function(response) {
                        $('#response_refer').html(response);
                    }
                });
            });


        });
    </script>
</div>
<!--single car page-->
<?php get_footer();?>