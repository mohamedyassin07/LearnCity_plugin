<?php 
class LC_Admin_Debug
{
    public function __construct(){
        add_action( 'rest_api_init', function () {
            register_rest_route( 'learncity/v1', '/payment_webhook/', array(
              'methods' => 'GET',
              'callback' => array($this,'payment_webhook'),
            ) );
          } );
    }
    public function payment_webhook(){
        remote_pre($_REQUEST);
    }
}