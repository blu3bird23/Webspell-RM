<?php

/**
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*  
 *                                    Webspell-RM      /                        /   /                                                 *
 *                                    -----------__---/__---__------__----__---/---/-----__---- _  _ -                                *
 *                                     | /| /  /___) /   ) (_ `   /   ) /___) /   / __  /     /  /  /                                 *
 *                                    _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/_____/_____/__/__/_                                 *
 *                                                 Free Content / Management System                                                   *
 *                                                             /                                                                      *
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 * @version         Webspell-RM                                                                                                       *
 *                                                                                                                                    *
 * @copyright       2018-2022 by webspell-rm.de <https://www.webspell-rm.de>                                                          *
 * @support         For Support, Plugins, Templates and the Full Script visit webspell-rm.de <https://www.webspell-rm.de/forum.html>  *
 * @WIKI            webspell-rm.de <https://www.webspell-rm.de/wiki.html>                                                             *
 *                                                                                                                                    *
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 * @license         Script runs under the GNU GENERAL PUBLIC LICENCE                                                                  *
 *                  It's NOT allowed to remove this copyright-tag <http://www.fsf.org/licensing/licenses/gpl.html>                    *
 *                                                                                                                                    *
 * @author          Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at)                                                 *
 * @copyright       2005-2018 by webspell.org / webspell.info                                                                         *
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 *                                                                                                                                    *
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 */

/** ZENITH.Developments | GETSCHONNIK **/

$_language->readModule('plugin_installer', false, true);
include('../system/func/installer.php');
include('../system/func/update_base.php');

function curl_json2array($url)
{
  $ssl = 0;
  if (substr($url, 0, 7) == "http://") {
    $ssl = 0;
  } else {
    $ssl = 1;
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
  $output = curl_exec($ch);
  curl_close($ch);
  return json_decode($output, true);
}
function getter($url)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
$getversion = $version;

####### Plugins #########
$url = $updateserverurl . '/plugin/plugin-base_v.' . $getversion . '/list.json';
@$check = fopen($url, "r");
if ($check) {
  $plugin = @file_get_contents($updateserverurl . '/plugin/plugin-base_v.' . $getversion . '/list.json');
  $server_status = '(Alpha Server)';
} else {
  $plugin = @file_get_contents($dangerupdateserverurl . '/plugin/plugin-base_v.' . $getversion . '/list.json');
  $server_status = '(Beta Server)';
}
#######################

if (!$getnew = $plugin) {
  echo '<div class="card">
        <div class="card-header">
            ' . $_language->module['plugin_installer'] . '
        </div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page"><a href="admincenter.php?site=plugin_installer">' . $_language->module['plugin_installer'] . '</a></li>
          <li class="breadcrumb-item active" aria-current="page">Error</li>
        </ol>
      </nav>

    <div class="card-body">

      <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">' . $_language->module['plugin_installer'] . '</h4>
          ' . $_language->module['info_error'] . '
          <hr>
          <i><b>' . $_language->module['error'] . '</b></i>
      </div></div></div>';
} else {


  if (isset($_GET['deinstall']) == 'plugin') {
    $dir = $_GET['dir'];

    // Inizio Pulitura di widget  e plugin dal database
    $dir = $_GET['dir'];
    $modulname = trim($dir, '/');
    // Recupera il plugin dal database
    $plugin_name_query = safe_query("SELECT modulname FROM " . PREFIX . "settings_plugins WHERE modulname = '" . $modulname . "'");

    if (mysqli_num_rows($plugin_name_query) > 0) {
      $plugin_name = mysqli_fetch_assoc($plugin_name_query)['modulname'];

      echo '<div class="alert alert-info"><strong><i class="bi bi-trash3"></i> ' . $_language->module['delete_plugin'] . ':</strong> ' . htmlspecialchars($plugin_name, ENT_QUOTES, 'UTF-8') . '</div>';

      // 1️ Remove widgets from the general table
      $delete_widgets = safe_query("DELETE FROM `" . PREFIX . "settings_plugins_widget` WHERE `modulname` = '$plugin_name'");

      // 2 Find and clean tables `PREFIX.plugins_*_settings_widgets`
      $tables_query = safe_query("SHOW TABLES LIKE '" . PREFIX . "plugins\_%\_settings_widgets'");
      while ($table = mysqli_fetch_array($tables_query)) {
        $table_name = $table[0];

        // Check if the table has a `modulname` field
        $check_column = safe_query("SHOW COLUMNS FROM `$table_name` LIKE 'modulname'");
        if (mysqli_num_rows($check_column) > 0) {
          // Remove the corresponding row
          safe_query("DELETE FROM `$table_name` WHERE `modulname` = '$plugin_name'");
        }
      }
    }

    // 3 Remove the plugin from the main table
    $delete_plugin = safe_query("DELETE FROM `" . PREFIX . "settings_plugins` WHERE `modulname` = '$plugin_name'");

    // Fine Pulitura di widget  e plugin dal database

    $name = str_replace("/", "", $dir);
    require_once('../includes/plugins' . $dir . 'uninstall.php');
    recursiveRemoveDirectory('../includes/plugins' . $dir);

    // Se il parametro redirect=true è presente, dopo la disinstallazione fa il redirect a plugin_manager
    if (isset($_GET['redirect']) && $_GET['redirect'] == 'true') {
      echo '<script>setTimeout(function(){ window.location.href = "admincenter.php?site=plugin_manager"; }, 0);</script>';
      exit;
    }

    header('Location: ?site=plugin_installer');
    exit;
  } elseif (!empty($_GET['do'])) {
    echo '<div class="card">
        <div class="card-header">
            ' . $_language->module['plugin_installer'] . '
        </div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page"><a href="admincenter.php?site=plugin_installer">' . $_language->module['plugin_installer'] . '</a></li>
          <li class="breadcrumb-item active" aria-current="page">Install</li>
        </ol>
      </nav>

    <div class="card-body">';
    $dir = $_GET['dir'];
    $dir = str_replace('/', '', $dir);
    ############ Plugin und Modul Einstellung ###############
    DeleteData("navigation_website_sub", "modulname", $dir);
    DeleteData("navigation_dashboard_links", "modulname", $dir);
    DeleteData("settings_plugins", "modulname", $dir);
    DeleteData("settings_plugins_widget", "modulname", $dir);
    $id = $_GET['id'];
    echo rmmodinstall('plugin', 'install', $dir, $id, $getversion);
    echo '</div></div>';
  } elseif (!empty($_GET['re'])) {
    echo '<div class="card">
        <div class="card-header">
            ' . $_language->module['plugin_installer'] . '
        </div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page"><a href="admincenter.php?site=plugin_installer">' . $_language->module['plugin_installer'] . '</a></li>
          <li class="breadcrumb-item active" aria-current="page">Install</li>
        </ol>
      </nav>

    <div class="card-body">';
    $dir = $_GET['dir'];
    $dir = str_replace('/', '', $dir);
    ############ Plugin und Modul Einstellung ###############
    DeleteData("navigation_website_sub", "modulname", $dir);
    DeleteData("navigation_dashboard_links", "modulname", $dir);
    DeleteData("settings_plugins", "modulname", $dir);
    DeleteData("settings_plugins_widget", "modulname", $dir);
    $id = $_GET['id'];
    echo rmmodinstall('plugin', 'install', $dir, $id, $getversion);
    echo '</div></div>';
  } elseif (!empty($_GET['up'])) {
    echo '<div class="card">
        <div class="card-header">
            ' . $_language->module['plugin_installer_update'] . '
        </div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item" aria-current="page"><a href="admincenter.php?site=plugin_installer">' . $_language->module['plugin_installer'] . '</a></li>
          <li class="breadcrumb-item" aria-current="page">Update</li>
        </ol>
      </nav>

    <div class="card-body">';
    $dir = $_GET['dir'];
    $dir = str_replace('/', '', $dir);
    ############ Plugin und Modul Einstellung ###############
    DeleteData("navigation_website_sub", "modulname", $dir);
    DeleteData("navigation_dashboard_links", "modulname", $dir);
    DeleteData("settings_plugins", "modulname", $dir);/*
  DeleteData("settings_plugins_widget","modulname",$dir);*/
    $id = $_GET['id'];
    echo rmmodinstall('plugin', 'update', $dir, $id, $getversion);
    echo '</div></div>';
  } else {
    try {

      ####### Plugins #########
      $url = $updateserverurl . '/plugin/plugin-base_v.' . $getversion . '/list.json';
      @$check = fopen($url, "r");
      if ($check) {
        $url = $updateserverurl . '/plugin/plugin-base_v.' . $getversion . '/list.json';
        $imgurl = $updateserverurl . '/plugin/plugin-base_v.' . $getversion . '';
      } else {
        $url = $dangerupdateserverurl . '/plugin/plugin-base_v.' . $getversion . '/list.json';
        $imgurl = $dangerupdateserverurl . '/plugin/plugin-base_v.' . $getversion . '';
      }
      #######################

      $result = curl_json2array($url);
      $anz = (count($result) - 1);
      $output = "";
      $input = "";
      $install_datei = "";

      for ($plug = 1; $plug <= $anz; $plug++) {
        $installedversion = 'n/a';
        $translate = new multiLanguage(detectCurrentLanguage());
        $translate->detectLanguages($result['item' . $plug]['name']);
        $result['item' . $plug]['name'] = $translate->getTextByLanguage($result['item' . $plug]['name']);

        $translate = new multiLanguage(detectCurrentLanguage());
        $translate->detectLanguages($result['item' . $plug]['description']);
        $result['item' . $plug]['description'] = $translate->getTextByLanguage($result['item' . $plug]['description']);

        $translate = new multiLanguage(detectCurrentLanguage());
        $translate->detectLanguages($result['item' . $plug]['plus_plugin']);
        $result['item' . $plug]['plus_plugin'] = $translate->getTextByLanguage($result['item' . $plug]['plus_plugin']);

        $ergebnis = safe_query("SELECT * FROM `" . PREFIX . "settings_plugins` WHERE `modulname`='" . $result['item' . $plug]['modulname'] . "'");
        if (mysqli_num_rows($ergebnis) == '1') {
          $row = mysqli_fetch_assoc($ergebnis);
          if ($row['version'] !== '') {
            $installedversion = $row['version'];
          }
        }

        if ($result['item' . $plug]['version'] > $installedversion) {
          $installed_version = '<span class="badge text-bg-warning">' . $installedversion . '</span>';
        } elseif ($result['item' . $plug]['version'] == $installedversion) {
          $installed_version = '<span class="badge text-bg-success">' . $installedversion . '</span>';
        } else {
          $installed_version = $installedversion;
        }

        $output .= '  <tr>';
        $output .= '<td><h5>' . $result['item' . $plug]['name'] . '</h5>
                        <div class="imageHold">
                          <div><img class="featured-image img-thumbnail" style="z-index: 1;" src="' . $imgurl . '' . $result['item' . $plug]['path'] . $result['item' . $plug]['preview'] . '" alt="{img}" /></div>
                        </div>
                        </td>';
        $output .= '<td>' . $result['item' . $plug]['description'] . '<hr>
                          <table class="table table-borderless"><tr>';

        if ($result['item' . $plug]['widgets'] == "") {
          $output .= '<td width="50%"></td>';
        } else {
          $output .= '<td width="50%" class="table-success"><b>' . $_language->module['plus_widgets'] . ':</b><br>' . $result['item' . $plug]['widgets'] . '</td>';
        }

        if ($result['item' . $plug]['required'] == "") {
          $output .= '<td></td>';
        } else {
          $output .= '<td class="table-success"><b>' . $_language->module['plus_plugin'] . ':</b><br>' . $result['item' . $plug]['plus_plugin'] . '</td>';
        }

        $output .= '</tr></table></td>';
        $output .= '<td>' . $_language->module['plugin_lang'] . ': ' . $result['item' . $plug]['languages'] . '<hr>
                            ' . $_language->module['plugin_ver'] . ' ' . $result['item' . $plug]['version'] . '<br />
                            ' . $_language->module['inst_plugin_ver'] . ' ' . $installed_version . '<br />
                            ' . $_language->module['required'] . ' ' . $result['item' . $plug]['req'] . '<br />
                            
                            ' . $_language->module['plugin_update'] . ': ' . $result['item' . $plug]['update'] . '<br />
                            Coding by: ' . $result['item' . $plug]['author'] . '</td>';

        include("../system/version.php");
        if (is_dir("../includes/plugins/" . $result['item' . $plug]['path'])) {
          $output .= '<td>';

          if ($result['item' . $plug . '']['version'] === $installedversion) {
            $output .= '<div class="d-grid gap-2"><a class="btn btn-success mb-3" data-toggle="tooltip" data-html="true" title="' . $_language->module['tooltip_3'] . ' " href="?site=plugin_installer&re=install&id=' . $plug . '&dir=' . $result['item' . $plug]['path'] . '"><i class="bi bi-arrow-repeat"></i> ' . $_language->module['reinstall'] . '</a></div>';
          } else {
            $output .= '<div class="d-grid gap-2"><a class="btn btn-warning mb-3" data-toggle="tooltip" data-html="true" title="' . $_language->module['tooltip_4'] . ' " href="?site=plugin_installer&id=' . $plug . '&up=install&dir=' . $result['item' . $plug]['path'] . '"><i class="bi bi-cloud-arrow-down"></i> ' . $_language->module['update'] . ' to Ver. ' . $result['item' . $plug]['version'] . '</a></div>';
          }

          if (
            @$row['modulname'] == 'footer'
            || @$row['modulname'] == 'navigation'
          ) {


            $output .= '';
          } else {

            $output .= ' 
              <!-- Button trigger modal -->
              <div class="d-grid gap-2"><button type="button" class="btn btn-danger mb-3" data-toggle="tooltip" data-html="true" title="' . $_language->module['tooltip_2'] . ' " data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="admincenter.php?site=plugin_installer&deinstall=plugin&dir=' . $result['item' . $plug]['path'] . '&modulname=' . $result['item' . $plug]['modulname'] . '"><i class="bi bi-trash3"></i> 
              ' . $_language->module['plugin_deinstallieren'] . '
              </button></div></th>';
            echo '
              <!-- Button trigger modal END-->            

              <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                             <h5 class="modal-title" id="modalLabel"><i class="bi bi-trash3"></i> ' . $_language->module['plugin_deinstallieren'] . '</h5>
                             <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                             <p><i class="bi bi-info-circle"></i> ' . $_language->module['delete_info'] . '</p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> ' . $_language->module['close'] . '</button>
                              <a class="btn btn-danger btn-ok"><i class="bi bi-trash3"></i> ' . $_language->module['plugin_deinstallieren'] . '</a>
                          </div>
                      </div>
                  </div>
              </div>';
          }
        } else {

          if ($result['item' . $plug]['req'] == $version) {
            if (@$result['item' . $plug]['aktive'] == '0') {
              $output .= '<td><div class="d-grid gap-2"><button class="btn btn-info" data-toggle="tooltip" data-html="true" title="' . $_language->module['tooltip_5'] . ' " style="width: 160px"><i class="bi bi-layout-sidebar"></i> ' . $_language->module['no_install'] . '</button></div></td>';
            } else {
              $output .= '<td><div class="d-grid gap-2"><a class="btn btn-success" data-toggle="tooltip" data-html="true" title="' . $_language->module['tooltip_6'] . ' " href="?site=plugin_installer&do=install&id=' . $plug . '&dir=' . $result['item' . $plug]['path'] . '"><i class="bi bi-plus-circle"></i> ' . $_language->module['installation'] . '</a></div></td>';
            }
            $output .= '  </tr>';
          } else {
            $output .= '<td><div class="d-grid gap-2"><button class="btn btn-info" data-toggle="tooltip" data-html="true" title="' . $_language->module['tooltip_1'] . ' " ><i class="bi bi-ban"></i> ' . $_language->module['incompatible'] . '</button> ' . $_language->module['no_ver'] . '</div></td>';
            $output .= '  </tr>';
          }
        }
      }
    } catch (Exception $e) {
      echo $e->message();
      return false;
    }

    $_language->readModule('plugin_installer');
    $_language->readModule('plugin_installer', false, true);

    echo '<div class="card">
        <div class="card-header"><i class="bi bi-plugin"></i> ' . $_language->module['plugin_installer'] . '
        </div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page"><a href="admincenter.php?site=plugin_installer">' . $_language->module['plugin_installer'] . '</a></li>
    <li class="breadcrumb-item active" aria-current="page">new & edit</li>
  </ol>
</nav>

<div class="card-body">

<div class="alert alert-success" role="alert">
  <h4 class="alert-heading"><i class="bi bi-plugin"></i> ' . $_language->module['plugin_installer'] . '</h4><p class="text-sm-start">' . $server_status . '</p>
  ' . $_language->module['info'] . '
  <hr>
  <i class="bi bi-info-circle" style="font-size: 1rem; color: #ffc107;"></i> ' . $_language->module['all_plugins_1'] . ' ' . $anz . ' ' . $_language->module['all_plugins_2'] . '
</div>

    
    <!-- END -->
    <!-- plugin_installer_content -->
    <div class="table-responsive"><table id="plugini" class="table table-striped">
      <thead>
        <tr>
          <th style="width: 22%"><b>' . $_language->module['preview'] . '</b></th>
          <th style="width: 48%"><b>' . $_language->module['description'] . '</b></th>
          <th style="width: 12%"><b>' . $_language->module['version'] . '</b></th>
          <th style="width: 12%"><b>' . $_language->module['options'] . '</b></th>
        </tr>
      </thead>
      <tbody>
        ' . $output . '
        
       </table>
      </div>
      </div>
      </div>
    ';
  }
}
