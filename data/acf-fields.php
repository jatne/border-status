<?php
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
		'page_title' 	=> 'WPK Settings',
		'menu_title'	=> 'WPK Settings',
		'menu_slug' 	=> 'wpk-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array(
    'key' => 'group_5fb4ff1e4dbcd',
    'title' => 'Border Ports of Entry',
    'fields' => array(
      array(
        'key' => 'field_5fb50fbf837a2',
        'label' => 'Border Ports of Entry',
        'name' => 'wpk_border_ports',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
        ),
        'default_value' => array(
        ),
        'allow_null' => 0,
        'multiple' => 1,
        'ui' => 1,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'wpk-settings',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));

  endif;