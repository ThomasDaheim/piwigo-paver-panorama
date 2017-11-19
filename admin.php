<?php
defined('PAVERPANORAMA_PATH') or die('Hacking attempt!');

global $template, $page, $conf;

if (isset($_POST['save_config']))
{
  $conf['PaverPanorama'] = array(
    'raw_width' => intval($_POST['raw_width']),
    'display_help' => isset($_POST['display_help']),
    'auto_anim' => isset($_POST['auto_anim']),
    'display_icon' => isset($_POST['display_icon']),
    );

  conf_update_param('PaverPanorama', $conf['PaverPanorama']);
  $page['infos'][] = l10n('Information data registered in database');
}

$template->assign(array(
  'PAVERPANORAMA_PATH' => PAVERPANORAMA_PATH,
  'PaverPanorama' => $conf['PaverPanorama'],
  ));

$template->set_filename('paverpanorama_config', realpath(PAVERPANORAMA_PATH . 'template/admin.tpl'));

$template->assign_var_from_handle('ADMIN_CONTENT', 'paverpanorama_config');
