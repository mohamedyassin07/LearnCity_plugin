<?php

class LC_Public_Courses
{
    public function __construct(){
        $this->show_tut_kit_on_creating_course();
    }

    function show_tut_kit_on_creating_course() {
        $path = $_SERVER['REQUEST_URI'];
        $strips = explode('/', $path);
        $index  = count($strips)-2;
        if( $strips[$index] == 'edit-course'){
            wp_enqueue_script( 'show_tut_kit', LC_URL . 'public/js/show_tut_kit.js', array( 'jquery' ), $this->version, false );
        }
    }
}
