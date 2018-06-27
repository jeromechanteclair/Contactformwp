<?php
/*
Plugin Name: Winslow contact
Plugin URI: 
Description: Simple formulaire de contact
Version: 1.0
Author: Jerome Chanteclair
Author URI: 
*/
    



function html_form_code() {
    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p>';
    
    echo '<input type="text" class="form-control" name="cf-name" placeholder="Nom" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40"  />';
    echo '</p>';
    echo '<p>';
    
    echo '<input type="email" class="form-control" placeholder="E-mail"  name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40"required />';
    echo '</p>';
    echo '<p>';
   
    echo '<input type="text" class="form-control" placeholder="Sujet" name="cf-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : '' ) . '" size="40"required />';
    echo '</p>';
    echo '<p>';

    echo '<textarea rows="10" class="form-control" placeholder="Votre message" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit"class="btn btnhero" name="cf-submitted" value="Envoyer"/></p>';
    echo '</form>';
}

function deliver_mail() {

    // if the submit button is clicked, send the email
    if ( isset( $_POST['cf-submitted'] ) ) {

        // sanitize form values
        $name    = sanitize_text_field( $_POST["cf-name"] );
        $email   = sanitize_email( $_POST["cf-email"] );
        $subject = sanitize_text_field( $_POST["cf-subject"] );
        $message = esc_textarea( $_POST["cf-message"] );

        // get the blog administrator's email address
        $to = get_option( 'admin_email' );

        $headers = "From: $name <$email>" . "\r\n";

        // If email has been process for sending, display a success message
        if ( wp_mail( $to, $subject, $message, $headers ) ) {
            echo '<div>';
            echo '<h5>Votre message a bien été envoyé !</h5>';
            echo '</div>';
        } else {
            echo 'Une erreur est apparue';
        }
    }
}

function cf_shortcode() {
    ob_start();
    deliver_mail();
    html_form_code();

    return ob_get_clean();
}


add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );


?>