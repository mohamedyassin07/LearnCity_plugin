<?php
class LC_Override_Temps{
    
    public function __construct() {
        // set defult folder 
        $this->temps_folder = LC_FILES.'public/partials';

        // override masterstudy plugin templates
        add_filter('stm_lms_template_file',array($this, 'overriding_temps'), 10 , 2);
    }

    public function overriding_temps($file,$temp) {
        $temps = array(
            '/stm-lms-templates/buddypress/account/private/instructor.php',
            '/stm-lms-templates/buddypress/account/private/parts/buddypress.php',
            '/stm-lms-templates/account/private/instructor_parts/courses.php',
            '/stm-lms-templates/stm-lms-lesson.php',            
        );
        if(in_array($temp,$temps)){
            return LC_FILES.'public/partials';
        }
        return $file;
    }
}