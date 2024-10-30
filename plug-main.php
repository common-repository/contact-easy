<?php
/*
Plugin Name: Contact easy 
Plugin URI: http://rajuahmed.0fees.net
Description: This is the plugin for contact form that data is stored in wordpress data base. shortcode display form: [contact_form] and Display result: [contact_result]
Author:Raju Ahmed
Version: 1.0.0
Author URI:http://rajuahmed.0fees.net/blogs/
*/

/* adding css class file */
	function databd_plugin_styles() {
		wp_register_style( 'database-style-class', plugins_url('css/style.css', __FILE__) );
		wp_enqueue_style( 'database-style-class' );
	}
	add_action( 'wp_enqueue_scripts', 'databd_plugin_styles' );
/*End adding css class file*/


/* Start Creating wpdb*/
		register_activation_hook( __FILE__, 'pu_create_plugin_tables' );
		function pu_create_plugin_tables()
		{
			// enter code to create tables
			global $wpdb;

			$table_name = $wpdb->prefix . 'mukta';

			$sql = "CREATE TABLE $table_name (
			id int(11) NOT NULL AUTO_INCREMENT,
			name varchar(255) DEFAULT NULL,
			email varchar(255) DEFAULT NULL,
			mobile varchar(255) DEFAULT NULL,
			messege varchar(255) DEFAULT NULL,

			UNIQUE KEY id (id)
			);";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
/*End Creating wpdb*/

/*Start shortcode for insert data in the wp database*/
function databd($atts){
	extract( shortcode_atts( array(
), $atts, 'contact_form' ) );

if (isset($_POST['yourname']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['messege']) 
&& !empty($_POST['yourname']) && !empty($_POST['email']) && !empty($_POST['mobile']) && !empty($_POST['messege'])) {

			/* Chacking Email and name , mobile, message */
			$username = ereg_replace("[^A-Za-z]", "", $_POST['yourname']);
			$email = ereg("^[^@ ]+@[^@ ]+\.[^@ ]+$", $_POST['email']);
			$mobile = ereg_replace("[^0-9]", "", $_POST['mobile']);
			$messege = ereg_replace("[^A-Za-z0-9]", "", $_POST['messege']);
			
			if((!$username) || (!$email)  ||  (!$mobile)  ||  (!$messege)  )  {
				$errorMsg = "Invalid format!";
				if(!$username){
				$errorMsg .= "---  Name";
				} else if(!$email){
				$errorMsg .= "--- email"; 
				} else if(!$mobile){ 
				$errorMsg .= "--- mobile"; 
				} else if(!$messege){ 
				$errorMsg .= "--- messege"; 
				} 
			
	  $list = '
			<p><span class="error">* required field.</span></p>
			 <span class="error">* '. $errorMsg.' </span>
			<form method="post">
			<table width="50%">
			<tr>
			<th width="25%"  scope="col"><div align="right">Name:</div></th>
			<th width="25%"  scope="col"><input type="text" name="yourname">   <span class="error">* </span></th>
			</tr>
			<tr>
			<th width="25%"  scope="row"><div align="right">Email:</div></th>
			<th width="25%" ><input type="text" name="email">   <span class="error">* </span></th>
			</tr>
			<tr>
			<th width="25%"  scope="row"><div align="right">Mobile:</div></th>
			<th width="25%" ><input type="text" name="mobile">   <span class="error">* [+88017xxxxxxxx]</span></th>
			</tr>
			<tr>
			<th width="25%"  ><div align="right">Message:</div></th>
			<th width="25%" ><textarea cols="25%" rows="8" name="messege"></textarea>   <span class="error"></span></th>
			</tr>
			<tr>
			<th scope="row">&nbsp;</th>
			<th><input type="submit" value="Submit"></th>
			</tr>
			</table>
			</form>
			<br/>
			
';  } else{

					global $wpdb;
					$table = $wpdb->prefix . 'mukta';
					$data = array(
					'name' => $_POST['yourname'],
					'email'    => $_POST['email'],
					'mobile'    => $_POST['mobile'],
					'messege'    => $_POST['messege']
					);
					$format = array(
					'%s',
					'%s',
					'%s',
					'%s'
					);
					$success=$wpdb->insert( $table, $data, $format );
					if($success){
					echo '<b class="success_class">You have Successfully submitted the form</b><br/>' ; 
					 $list = '
			
			 <span class="error"> '. $errorMsg.' </span>
			<form method="post">
			<table width="50%">
			<tr>
			<th width="25%"  scope="col"><div align="right">Name:</div></th>
			<th width="25%"  scope="col"><input type="text" name="yourname">   <span class="error">* </span></th>
			</tr>
			<tr>
			<th width="25%"  scope="row"><div align="right">Email:</div></th>
			<th width="25%" ><input type="text" name="email">   <span class="error">* </span></th>
			</tr>
			<tr>
			<th width="25%"  scope="row"><div align="right">Mobile:</div></th>
			<th width="25%" ><input type="text" name="mobile">   <span class="error">* [+88017xxxxxxxx]</span></th>
			</tr>
			<tr>
			<th width="25%"  ><div align="right">Message:</div></th>
			<th width="25%" ><textarea cols="25%" rows="8" name="messege"></textarea>   <span class="error"></span></th>
			</tr>
			<tr>
			<th scope="row">&nbsp;</th>
			<th><input type="submit" value="Submit"></th>
			</tr>
			</table>
			</form>
			<br/>
			
'; 
					}}
} else{   	$list = '
			<p><span class="error">* required field.</span></p>
			<form method="post">
			<table width="50%" >
			<tr>
			<th width="25%"  scope="col"><div align="right">Name:</div></th>
			<th width="25%"  scope="col"><input type="text" name="yourname">   <span class="error">* </span></th>
			</tr>
			<tr>
			<th width="25%"  scope="row"><div align="right">Email:</div></th>
			<th width="25%" ><input type="text" name="email">   <span class="error">* </span></th>
			</tr>
			<tr>
			<th width="25%"  scope="row"><div align="right">Mobile:</div></th>
			<th width="25%" ><input type="text" name="mobile">   <span class="error">*[+88017xxxxxxxx]</span></th>
			</tr>
			<tr>
			<th width="25%"  ><div align="right">Message:</div></th>
			<th width="25%" ><textarea cols="25%" rows="8" name="messege"></textarea>   <span class="error"></span></th>
			</tr>
			<tr>
			<th scope="row">&nbsp;</th>
			<th><input type="submit" value="Submit"></th>
			</tr>
			</table>
			</form>
			<br/>
			
';        
}
return $list;
}
add_shortcode('contact_form', 'databd');

/*End shortcode for insert data in the wp database*/


/*Start displaying shortcode*/
function show_data_shortcode($atts){
	extract( shortcode_atts( array(
), $atts, 'contact_result' ) );
//contents
		$output='<div class="output_class">';
		global $wpdb;	 	 
		$table_cearch = $wpdb->prefix . 'mukta';
		$results = $wpdb->get_results("SELECT * FROM $table_cearch  ");	 
		
		foreach($results as $r) {	 
		$output_name=  $r->name; 
		$output_gender=  $r->email; 
		$output_roll=  $r->mobile; 
		$output_message=  $r->messege; 
		$output .= '
						<table width="100%" border="2" bordercolor="#006699">
						<tr>
						<th bgcolor="#41A62A" scope="col">Name</th>
						<th bgcolor="#41A62A" scope="col">Email</th>
						<th bgcolor="#41A62A" scope="col">Mobile</th>
						<th bgcolor="#41A62A" scope="col">Message</th>
						</tr>
						<tr>
						<th width="25%" scope="row"><div align="justify">'.$output_name.'</div></th>
						<td width="25%"><div align="justify">'.$output_gender.'</div></td>
						<td width="25%"><div align="justify">'.$output_roll.'</div></td>
						<td width="25%"><div align="justify">'.$output_message.'</div></td>
						</tr >
						</table>
						

		';        }
		$output .='</div>';
return $output;
}
add_shortcode('contact_result', 'show_data_shortcode');
/*End displaying shortcode*/
?>