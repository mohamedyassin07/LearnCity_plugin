<?php

class LC_Admin_Dashboard_Menu {
	private $old_menu =  array();

	public function __construct() {
		add_action( 'admin_menu', array($this , 'edit_menu') , 99999999999999999999 );  
	}


	function edit_menu() {
		global $menu, $submenu;
		// pre($menu , 'menu') ;
		// pre($submenu , 'sub menu') ;
	}
}