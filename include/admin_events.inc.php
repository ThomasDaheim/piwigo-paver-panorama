<?php
defined('PAVERPANORAMA_PATH') or die('Hacking attempt!');

function paverpanorama_admin_plugin_menu_links($menu)
{
  $menu[] = array(
    'NAME' => 'Paver Panorama',
    'URL' => PAVERPANORAMA_ADMIN,
    );

  return $menu;
}

function paverpanorama_photo_page()
{
  global $template;
  
  if (isset($_POST['submit']))
  {
    $row['is_panorama'] = isset($_POST['is_panorama']);
    
    single_update(
      IMAGES_TABLE,
      array('is_panorama' => $row['is_panorama']),
      array('id' => $_GET['image_id'])
      );
  }
  else
  {
    $query = '
SELECT is_panorama
  FROM '.IMAGES_TABLE.'
  WHERE id = '.$_GET['image_id'].'
;';
    $row = pwg_db_fetch_assoc(pwg_query($query));
  }
  
  $template->assign('is_panorama', $row['is_panorama']);
  $template->set_prefilter('picture_modify', 'paverpanorama_photo_page_prefilter');
}

function paverpanorama_photo_page_prefilter($content)
{
  $search = '<strong>{\'Linked albums\'|@translate}</strong>';
  $add = '
    <label style="font-weight:bold"><input type="checkbox" name="is_panorama" {if $is_panorama}checked{/if}> Paver Panorama</label>
  </p>
  <p>';
  
  return str_replace($search, $add.$search, $content);
}

function paverpanorama_add_prefilter($prefilters)
{
  $prefilters[] = array(
    'ID' => 'is_panorama',
    'NAME' => 'Paver Panorama',
    );
  
  return $prefilters;
}

function paverpanorama_apply_prefilter($filter_sets, $prefilter)
{
  if ($prefilter == 'is_panorama')
  {
    $query = 'SELECT id FROM '.IMAGES_TABLE.' where is_panorama = 1;';
    $filter_sets[] = query2array($query, null, 'id');
  }
  
  return $filter_sets;
}

function paverpanorama_loc_end_element_set_global()
{
  global $template;

  $template->append('element_set_global_plugins_actions', array(
    'ID' => 'set_paverpanorama',
    'NAME' => l10n('Set Paver Panorama')
    ));
  
  $template->append('element_set_global_plugins_actions', array(
    'ID' => 'unset_paverpanorama',
    'NAME' => l10n('Unset Paver Panorama')
    ));
}

function paverpanorama_element_set_global_action($action, $collection)
{
  global $redirect;

  if (strpos($action, 'paverpanorama') !== false)
  {
    $is = $action == 'set_paverpanorama';
    
    $datas = array();
    foreach ($collection as $image_id)
    {
      $datas[] = array(
        'id' => $image_id,
        'is_panorama' => $is
        );
    }

    mass_updates(
      IMAGES_TABLE,
      array('primary' => array('id'), 'update' => array('is_panorama')),
      $datas
      );

    $redirect = true;
  }
}
