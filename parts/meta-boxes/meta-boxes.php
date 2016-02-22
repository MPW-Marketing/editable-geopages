<?php
/*
Title: Geo Pages
Description: Enter Choices for paragraphs
Post Type: geo_page
Priority: high
Order: 0
*/
	$para_num = 1;
piklist('field', array(
  'type' => 'html'
  ,'label' => 'Geo Page Builder'
  ,'value' => '<p>Enter the values you want to replace next to "Values to replace", multiple values may be entered by seperating them with a ^, values must be entered in the same order as the replacements listed in the shortcode. For example to replace %geo% and %geoimage% with Utica and utica-ny you would enter %geo%^%geoimage% in this box and your shortcode may look like <br />
[geopage name="AC" replacements = "Utica^utica-ny" choices="1^2"]<br />
Use the outer Plus to add new sections, use the innter Plus to add more options for each section</p>'
));
piklist('field', array(
    'type' => 'text'
    ,'field' => 'sea_val'
    ,'label' => 'Value to replace'
    ,'description' => 'Enter the values you want to replace'
    ,'value' => '%geo%'
    ,'help' => 'These are the values that will be replaced in the outputted text. It is recomended to use values that will not appear in your text elsewhere such as %geo%'
    ,'attributes' => array(
      'class' => 'text'
    )
  ));
  piklist('field', array(
      'type' => 'group'
      ,'field' => 'all_paragraphs'
      ,'label' => __('Enter Post Content') 
	  ,'description' => __('Enter the HTML for your paragraphs. Use the plus signs to add more paragraphs or choices for any of the paragraphs')
      ,'columns' => 12
      ,'add_more' => true
      ,'fields' => array(
        array(
          'type' => 'hidden'
			  ,'field' => 'has_paragraphs'
		  ,'value' => '1'
        )
        ,array(
          'type' => 'group'
          ,'field' => 'paragraph_choices'
          ,'add_more' => true
          ,'fields' => array(
            array(
		  		'type' => 'editor'
  				 ,'field' => 'paragraph_choice'
    			 ,'label' => __('Enter Paragraph Option')
    			 ,'description' => __('Enter the HTML for this paragraph use the values you entered above anywhere you want the text to be replaced. Use the plus sign in this area to add more choices for this paragraph')
    			 ,'value' => 'Enter Paragraph Content Here'
    			 ,'add_more' => true
    			 ,'options' => array (
      		  			'wpautop' => true
     					,'media_buttons' => true
      					,'tabindex' => ''
    					,'editor_css' => ''
      					,'editor_class' => ''
      					,'teeny' => false
      					,'dfw' => false
      					,'tinymce' => false
      					,'quicktags' => true
    					)
            )
          )
        )
      )
    ));

 ?>