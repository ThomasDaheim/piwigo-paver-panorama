<?php
/*
Plugin Name: PaverPanorama
Version: auto
Description: Use Paver js to show panoramas. Based on PhotoSphere plugin from Mistic.
Plugin URI: auto
Author: Thomas Feuster
Author URI: http://bilder.feuster.com
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');


if (basename(dirname(__FILE__)) != 'PaverPanorama')
{
  add_event_handler('init', 'paverpanorama_error');
  function paverpanorama_error()
  {
    global $page;
    $page['errors'][] = 'PaverPanorama folder name is incorrect, uninstall the plugin and rename it to "PaverPanorama"';
  }
  return;
}


global $prefixeTable;

define('PAVERPANORAMA_PATH' , PHPWG_PLUGINS_PATH . 'PaverPanorama/');
define('PAVERPANORAMA_ADMIN', get_root_url() . 'admin.php?page=plugin-PaverPanorama');


add_event_handler('init', 'paverpanorama_init');
function paverpanorama_init()
{
  global $conf;

  if (defined('IN_ADMIN'))
  {
    load_language('plugin.lang', PAVERPANORAMA_PATH, array(
      'force_fallback' => 'en_UK'
    ));
  }
  else
  {
    load_language('plugin.lang', PAVERPANORAMA_PATH);
  }

  $conf['PaverPanorama'] = safe_unserialize($conf['PaverPanorama']);
}

if (defined('IN_ADMIN'))
{
  $admin_file = PAVERPANORAMA_PATH . 'include/admin_events.inc.php';
  
  add_event_handler('get_admin_plugin_menu_links', 'paverpanorama_admin_plugin_menu_links',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  add_event_handler('loc_end_picture_modify', 'paverpanorama_photo_page',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  add_event_handler('get_batch_manager_prefilters', 'paverpanorama_add_prefilter',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
    
  add_event_handler('perform_batch_manager_prefilters', 'paverpanorama_apply_prefilter',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
    
  add_event_handler('loc_end_element_set_global', 'paverpanorama_loc_end_element_set_global',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
    
  add_event_handler('element_set_global_action', 'paverpanorama_element_set_global_action',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
}
else
{
  $public_file = PAVERPANORAMA_PATH . 'include/public_events.inc.php';

  add_event_handler('render_element_content', 'paverpanorama_element_content',
    EVENT_HANDLER_PRIORITY_NEUTRAL-10, $public_file);
  
  add_event_handler('loc_after_page_header', 'paverpanorama_admintools',
    EVENT_HANDLER_PRIORITY_NEUTRAL-10, $public_file);
  
  add_event_handler('loc_begin_picture', 'paverpanorama_save_admintools',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
  
  add_event_handler('loc_begin_index_thumbnails', 'paverpanorama_thumbnails_list',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
}
