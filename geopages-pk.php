<?php
/*
Plugin Name: Editable Geo Pages
Plugin URI:
Description: Add new editable geo pages
Version: 0.3.2
Author: DMM
Author URI:
Plugin Type: Piklist
License: GPL2
*/
?>
<?php
add_action('init', 'my_init_function');
function my_init_function()
{
  if(is_admin())
  {
   include_once('class-piklist-checker.php');

   if (!piklist_checker::check(__FILE__))
   {
     return;
   }
  }
}

add_filter('piklist_post_types', 'geo_page_type');
 function geo_page_type($post_types)
 {
  $post_types['geo_page'] = array(
    'labels' => piklist('post_type_labels', 'GEO Pages')
    ,'title' => __('Enter GEO Page Label (i.e. AC, Heat)')
    ,'public' => true
    ,'rewrite' => array(
      'slug' => 'geo-page'
    )
    ,'supports' => array(
      'author'
      ,'revisions'
      ,'title'
    )
    ,'hide_meta_box' => array(
      'slug'
      ,'author'
      ,'comments'
      ,'commentstatus'
    )
  );
return $post_types;
}
//Create the page content
function print_it ( $atts ) {
extract( shortcode_atts( array(
		'name' => '', 'replacements'=> '', 'choices'=>0
	), $atts ) );
	//get the paragraph choices made and decrement the values to matcht he array indices
	$arr_val = explode("^",$choices);
if ($arr_val[0]>0) {	
	foreach ($arr_val as &$val){
	$val = $val - 1;
}
}
/*print_r ($arr_val);//check choice values */
//Get the geo page they chose to use, Send error if page not found
$page = get_page_by_title( $name , OBJECT , 'geo_page' );
if ($page =='') {
	echo 'Please verify that the Geo Page ' . $name . ' exists and that the page name matches your entry exactly';
	return;
}
//get list of terms to replace if no terms entered give an error
$iid = $page->ID;
$sea = get_post_meta($iid, 'sea_val', true);
if ($sea == '') {
	echo 'Please enter a value in the string to replace section for the Geo Page ' . $name;
	return;
}
$search_arr =  explode("^", $sea);
$search_link_arr = $search_arr;
array_walk($search_link_arr, function (&$value, $key) {
   $value=$value . '-link%';
});

//Get replacement values from shortcode
$replace_arr = explode("^", $replacements);
$replace_link_arr = str_replace(" ","-",$replace_arr);
$replace_link_arr = str_replace(",","",$replace_link_arr);

//Get meta options with all possible paragraphs and choose paragraphs based on users choices
$all_para =  get_post_meta($iid, 'all_paragraphs');
$final_array = array();
	$para_data_arr = $all_para[0]['paragraph_choices'];
	$loopstodo = count ($para_data_arr);
	$choices_picked = count ($arr_val);
	while ($choices_picked < $loopstodo) {	
		$arr_val[] = 0;
		$choices_picked++;
	}
	
	for ($i = 0; $i < $loopstodo; $i++) {
	    $final_array[]=$para_data_arr[$i]['paragraph_choice'][$arr_val[$i]];
	}
	//create string from final choices
	foreach ($final_array as $val){
	$raw_cont .= $val;
}
//combine regular and link search and replace arrays
$search_arr_final = array_merge ($search_link_arr, $search_arr);
$replace_arr_final = array_merge ($replace_link_arr, $replace_arr);

// make replacements and return value
$cont = str_replace($search_arr_final, $replace_arr_final, $raw_cont);
return do_shortcode($cont);


}
add_shortcode( 'geopage', 'print_it');


function print_it2 ( $atts ) {
extract( shortcode_atts( array(
    'name' => '', 'replacements'=> '', 'choices'=>0
  ), $atts ) );
  //get the paragraph choices made and decrement the values to matcht he array indices
  $arr_val = explode("^",$choices);
if ($arr_val[0]>0) {  
  foreach ($arr_val as &$val){
  $val = $val - 1;
}
}
//print_r ($arr_val);//check choice values 
//Get the geo page they chose to use, Send error if page not found
$page = get_page_by_title( $name , OBJECT , 'geo_page' );
if ($page =='') {
  echo 'Please verify that the Geo Page ' . $name . ' exists and that the page name matches your entry exactly';
  return;
}
//get list of terms to replace if no terms entered give an error
$iid = $page->ID;
$sea = get_post_meta($iid, 'sea_val', true);
//echo $sea;
if ($sea == '') {
  echo 'Please enter a value in the string to replace section for the Geo Page ' . $name;
  return;
}
$search_arr =  explode("^", $sea);
$search_link_arr = $search_arr;
array_walk($search_link_arr, function (&$value, $key) {
   $value=$value . '-link%';
});
//print_r($search_arr);
//Get replacement values from shortcode
$replace_arr = explode("^", $replacements);
$replace_link_arr = str_replace(" ","-",$replace_arr);
$replace_link_arr = str_replace(",","",$replace_link_arr);
//print_r($replace_arr);
//Get meta options with all possible paragraphs and choose paragraphs based on users choices
$all_para =  get_post_meta($iid, 'all_paragraphs');
//echo 'NEWWWWW';
//print_r($all_para[0]);
$num_sections = count($all_para[0]);
//echo "NUM ".$num_sections;
$final_array = array();
//get number of sections and set array to match
for ($i = 0; $i < $num_sections; $i++){
  $para_data_arr[] = $all_para[0][$i]['paragraph_choices'];
}
//print_r($para_data_arr);
  $loopstodo = count ($para_data_arr);
  $choices_picked = count ($arr_val);
  //echo $loopstodo . $choices_picked;
  while ($choices_picked < $loopstodo) {  
    $arr_val[] = 0;
    $choices_picked++;
  }
  
  for ($i = 0; $i < $loopstodo; $i++) {
    //echo "NEXT". $arr_val[$i];
    //print_r($para_data_arr[$i][$arr_val[$i]]['paragraph_choice'][0]);
      $final_array[]=$para_data_arr[$i][$arr_val[$i]]['paragraph_choice'][0];
  }
  //create string from final choices
  foreach ($final_array as $val){
  $raw_cont .= $val;
}
//combine regular and link search and replace arrays
$search_arr_final = array_merge ($search_link_arr, $search_arr);
$replace_arr_final = array_merge ($replace_link_arr, $replace_arr);

// make replacements and return value
$cont = str_replace($search_arr_final, $replace_arr_final, $raw_cont);
$cont = stripslashes($cont);
return do_shortcode($cont);


}
add_shortcode( 'geopage2', 'print_it2');


