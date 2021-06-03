<?php
class LC_BuddyPress {
    public function __construct() {
        add_action('action', array($this,'method'), 999);
        add_action('wp_insert_post', array($this, 'create_group_for_new_courses'), 10, 3 );
        add_action('add_user_course', array($this, 'add_user_to_course_group'), 10, 2 );
    }

    public function create_group_for_new_courses($post_id, $post, $update) {
        if ($post->post_type == 'stm-courses' && $post->post_status == 'publish' && empty(get_post_meta( $post_id, 'bp_group' ))) {
            $args = array(
                'group_id'     => 0,
                'creator_id'   => get_current_user_id(),
                'name'         => $post->post_title,
                'description'  => 'this is the' . $post->post_title . ' Course official Group',
                'status'       => 'private',
                'enable_forum' => 1
            );
            $group_id = groups_create_group($args);
            update_post_meta( $post_id, 'bp_group', $group_id );
        }
    }

    public function add_user_to_course_group($user_id, $course_id){
        $group_id = get_post_meta($course_id , 'bp_group' , true );
        remote_pre(array($course_id , $user_id));
        if(!empty($group_id)){
            remote_pre(array($course_id , $user_id , $group_id));
            groups_join_group( $group_id, $user_id );
        }
    }   
}


// function add_members_to_nfl_group($user_id){ // I suppose when you add the parameter $user_id in the fuction and then pass it trough the action 'bp_core_activated_user', the action returns the ID of the memeber beeing activated. 
//     $nfl_team = bp_get_profile_field_data('field=2&user_id='.$user_id); // I erased the function get_member_nfl_team() and put the variable here with the new $user_id
//     $nfl_team_slug = str_replace(" ", "-", strtolower($nfl_team));
//     $group_slug = "aficionados-a-los-".$nfl_team_slug;
//     $group_id = BP_Groups_Group::group_exists($group_slug);    
//     groups_join_group( $group_id, $user_id ); // Instead of groups_accept_invite() as @henrywright suggested
// }
// add_action( 'bp_core_activated_user', 'add_members_to_nfl_group' );
// groups_join_group( $group_id, $user_id ); // Instead of groups_accept_invite() as @henrywright suggested



// function my_disable_bp_registration() {
//     remove_action( 'bp_init',    'bp_core_wpsignup_redirect' );
//     remove_action( 'bp_screens', 'bp_core_screen_signup' );
// }
// add_action( 'bp_loaded', 'my_disable_bp_registration' );


// add_filter( 'bp_get_signup_page', "firmasite_redirect_bp_signup_page");
// function firmasite_redirect_bp_signup_page($page ){
//     return bp_get_root_domain() . '/wp-signup.php'; 
// }  


// add_filter( 'option_active_plugins', function( $plugins ){
// 		$myplugins = array("buddypress/bp-loader.php");
// 		if( false === $is_contact_page ){
// 			$plugins = array_diff( $plugins, $myplugins );
// 		}
// 		return $plugins;
// 	} 
// );