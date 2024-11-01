<?php
// Menus
// Hook to load menu function
add_action('admin_menu', 'ssbg_menu_load');

function ssbg_menu_load() {
  add_theme_page("Simple Slideshow Background", "Simple Slideshow Background", 'manage_options', 'simple-slideshow-background', ssbg_menu_appearance);
}

function ssbg_menu_appearance() {
  // WordPress globals
  global $ssbg_option_name, $ssbg_settings, $ssbg_settings_name;
  
  $action = 'default'; 
  
  if (!empty($_REQUEST['action'])) 
    $action = $_REQUEST['action'];

  
  switch ($action){
    case 'settings_ssb':
      if(is_numeric($_REQUEST['delay'])) $ssbg_settings['delay'] = $_REQUEST['delay'];
      if($_REQUEST['enabled'] == "enabled") $ssbg_settings['enabled'] = true;
      else $ssbg_settings['enabled'] = false;
      update_option($ssbg_settings_name, $ssbg_settings);
      ssbg_form_list_images();
      break;
    case 'save_picture':
      $id = $_REQUEST['id'];
      $images = get_option($ssbg_option_name, array());
      $images[$id]['picture'] = $_REQUEST['picture'.$id];
      update_option($ssbg_option_name, array_values($images));
      //print $_REQUEST['picture'];
      ssbg_form_list_images();
      break;
    case 'delete':
      $id = $_REQUEST['id'];
      $images = get_option($ssbg_option_name, array());
      unset($images[$id]);
      update_option($ssbg_option_name, array_values($images));
      ssbg_form_list_images();
      break;
    case 'add_ssb':
      $images = get_option($ssbg_option_name, array());
      $images[] = array("picture" => '');
      update_option($ssbg_option_name, array_values($images));
      ssbg_form_list_images();
      break;
    default:
      ssbg_form_list_images();
  }
  
}

    
