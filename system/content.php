<?php

/**
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 *                  Webspell-RM      /                        /   /                                          *
 *                  -----------__---/__---__------__----__---/---/-----__---- _  _ -                         *
 *                   | /| /  /___) /   ) (_ `   /   ) /___) /   / __  /     /  /  /                          *
 *                  _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/_____/_____/__/__/_                          *
 *                               Free Content / Management System                                            *
 *                                           /                                                               *
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 * @version         webspell-rm                                                                              *
 *                                                                                                           *
 * @copyright       2018-2024 by webspell-rm.de                                                              *
 * @support         For Support, Plugins, Templates and the Full Script visit webspell-rm.de                 *
 * @website         <https://www.webspell-rm.de>                                                             *
 * @forum           <https://www.webspell-rm.de/forum.html>                                                  *
 * @wiki            <https://www.webspell-rm.de/wiki.html>                                                   *
 *                                                                                                           *
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 * @license         Script runs under the GNU GENERAL PUBLIC LICENCE                                         *
 *                  It's NOT allowed to remove this copyright-tag                                            *
 *                  <http://www.fsf.org/licensing/licenses/gpl.html>                                         *
 *                                                                                                           *
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 * @author          Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at)                        *
 * @copyright       2005-2011 by webspell.org / webspell.info                                                *
 *                                                                                                           *
 *¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯*
 */

#Funktionen für die index.php (/includes/themes/default/)

#Title Ausgabe für die Webseite
function get_sitetitle()
{
    $sitetitle = new plugin_manager();
    if (isset($_GET['site']) and $sitetitle->plugin_updatetitle($_GET['site'])) {
        echo $sitetitle->plugin_updatetitle($_GET['site']);
    } else {
        echo PAGETITLE;
    }
}

# content Ausgabe für die index.php
function get_mainContent()
{

    global $cookievalue, $userID, $date, $loggedin, $_language, $tpl, $myclanname, $hp_url, $imprint_type, $admin_email, $admin_name;
    global $maxtopics, $plugin_path, $maxposts, $page, $action, $preview, $message, $topicID, $_database, $maxmessages, $new_chmod;
    global $hp_title, $default_format_date, $default_format_time, $register_per_ip, $rewriteBase;

    /* Startpage */
    $settings = safe_query("SELECT * FROM " . PREFIX . "settings");
    $ds = mysqli_fetch_array($settings);
    /* Main Content */

    if (!isset($_GET['site'])) {
        $site = $ds['startpage'];
    } else {
        $site = getinput($_GET['site']);
    }

    $invalide = array('\\', '/', '/\/', ':', '.');
    $site = str_replace($invalide, ' ', $site);
    $_plugin = new plugin_manager();
    $_plugin->set_debug(DEBUG);
    if (!empty($site) and $_plugin->is_plugin($site) > 0) {
        $data = $_plugin->plugin_data($site);
        //$plugin_path = $data['path'];
        if (!empty($data['path'])) {
            $plugin_path = $data['path'];
        } else {
            $plugin_path = '';
        }
        $check = $_plugin->plugin_check($data, $site);
        if ($check['status'] == 1) {
            $inc = $check['data'];
            if ($inc == "exit") {
                if ($notfoundpage = true) {
                    $site = "404";
                } else {
                    $site = $ds['startpage'];
                }
                include("includes/modules/" . $site . ".php");
            } else {
                include($check['data']);
            }
        } else {
            echo $check['data'];
        }
    } else {
        if (!file_exists("includes/modules/" . $site . ".php")) {
            if ($notfoundpage = true) {
                $site = "404";
            } else {
                $site = $ds['startpage'];
            }
        }
        include("includes/modules/" . $site . ".php");
    }
}



#Ausgabe Header Modul
function get_header_modul()
{
    $widget_menu = new widgets();
    $widget_menu->registerWidget("header_widget");
}

#Ausgabe Navi
function get_navigation_modul()
{
    global $logo, $theme_name, $themes, $site, $_language, $loggedin, $url;
    global $site, $modulname;
    $widget_menu = new widgets();
    $widget_menu->registerWidget("navigation_widget");
}

#Ausgabe content Head
function get_content_head_modul()
{
    $widget_menu = new widgets();
    $widget_menu->registerWidget("content_head_widget");
}

#Output Content Above Center
function get_content_up_modul()
{
    $widget_menu = new widgets();
    $widget_menu->registerWidget("content_up_widget");
}

#Ausgabe Left Side
function get_left_side_modul()
{
    $qs_arr = array();
    parse_str($_SERVER['QUERY_STRING'], $qs_arr);

    $getsite = 'startpage'; #Wird auf der Startseite angezeigt index.php
    if (isset($qs_arr['site'])) {
        $getsite = $qs_arr['site'];
    }
    if (
        @$getsite == 'contact'
        || @$getsite == 'imprint'
        || @$getsite == 'privacy_policy'
        || @$getsite == 'profile'
        || @$getsite == 'myprofile'
        || @$getsite == 'error_404'
        || @$getsite == 'report'
        || @$getsite == 'static'
        || @$getsite == 'loginoverview'
        || @$getsite == 'register'
        || @$getsite == 'lostpassword'
        || @$getsite == 'login'
        || @$getsite == 'logout'
        || @$getsite == 'footer'
        || @$getsite == 'navigation'
        || @$getsite == 'topbar'
        || @$getsite == 'articles_comments'
        || @$getsite == 'blog_comments'
        || @$getsite == 'gallery_comments'
        || @$getsite == 'news_comments'
        || @$getsite == 'news_recomments'
        || @$getsite == 'polls_comments'
        || @$getsite == 'videos_comments'
    ) {
    } elseif (@$getsite == 'forum_topic') {
        $dx = mysqli_fetch_array(safe_query("SELECT * FROM " . PREFIX . "plugins_forum_settings_widgets WHERE position='left_side_widget' OR position = 'full_activated'"));
        if (@$dx['position'] == 'left_side_widget' || @$dx['position'] == 'full_activated') {
            echo '<div id="leftcol" class="col-md-3">';
            $left_page = $widget_menu = new widgets();
            $widget_menu->registerWidget("left_side_widget");
            $widget_menu->registerWidget("full_activated");
            echo '</div>';
        } else {
        }
    } else {
        $dx = mysqli_fetch_array(safe_query("SELECT * FROM " . PREFIX . "plugins_" . $getsite . "_settings_widgets WHERE position='left_side_widget' OR position = 'full_activated'"));
        if (@$dx['position'] == 'left_side_widget' || @$dx['position'] == 'full_activated') {
            echo '<div id="leftcol" class="col-md-3">';
            $left_page = $widget_menu = new widgets();
            $widget_menu->registerWidget("left_side_widget");
            $widget_menu->registerWidget("full_activated");
            echo '</div>';
        } else {
        }
    }
}

#Ausgabe Right Side
function get_right_side_modul()
{
    $qs_arr = array();
    parse_str($_SERVER['QUERY_STRING'], $qs_arr);

    $getsite = 'startpage'; #Wird auf der Startseite angezeigt index.php
    if (isset($qs_arr['site'])) {
        $getsite = $qs_arr['site'];
    }
    if (
        @$getsite == 'contact'
        || @$getsite == 'imprint'
        || @$getsite == 'privacy_policy'
        || @$getsite == 'profile'
        || @$getsite == 'myprofile'
        || @$getsite == 'error_404'
        || @$getsite == 'report'
        || @$getsite == 'static'
        || @$getsite == 'loginoverview'
        || @$getsite == 'register'
        || @$getsite == 'lostpassword'
        || @$getsite == 'login'
        || @$getsite == 'logout'
        || @$getsite == 'footer'
        || @$getsite == 'navigation'
        || @$getsite == 'topbar'
        || @$getsite == 'articles_comments'
        || @$getsite == 'blog_comments'
        || @$getsite == 'gallery_comments'
        || @$getsite == 'news_comments'
        || @$getsite == 'news_recomments'
        || @$getsite == 'polls_comments'
        || @$getsite == 'videos_comments'
    ) {
    } elseif (@$getsite == 'forum_topic') {
        $dx = mysqli_fetch_array(safe_query("SELECT * FROM " . PREFIX . "plugins_forum_settings_widgets WHERE position='right_side_widget' OR position = 'full_activated'"));
        if (@$dx['position'] == 'right_side_widget' || @$dx['position'] == 'full_activated') {
            echo '<div id="rightcol" class="col-md-3">';
            $right_page = $widget_menu = new widgets();
            $widget_menu->registerWidget("right_side_widget");
            $widget_menu->registerWidget("full_activated");
            echo '</div>';
        } else {
        }
    } else {
        $dx = mysqli_fetch_array(safe_query("SELECT * FROM " . PREFIX . "plugins_" . $getsite . "_settings_widgets WHERE position='right_side_widget' OR position = 'full_activated'"));
        if (@$dx['position'] == 'right_side_widget' || @$dx['position'] == 'full_activated') {
            echo '<div id="rightcol" class="col-md-3">';
            $right_page = $widget_menu = new widgets();
            $widget_menu->registerWidget("right_side_widget");
            $widget_menu->registerWidget("full_activated");
            echo '</div>';
        } else {
        }
    }
}

#Output Content Below Center
function get_content_down_modul()
{
    $widget_menu = new widgets();
    $widget_menu->registerWidget("content_down_widget");
}

#Ausgabe content Foot
function get_content_foot_modul()
{
    $widget_menu = new widgets();
    $widget_menu->registerWidget("content_foot_widget");
}

#Ausgabe Footer Modul
function get_footer_modul()
{
    $widget_menu = new widgets();
    $widget_menu->registerWidget("footer_widget");
}

#Wartungsmodus wird anezeigt
function get_lock_modul()
{
    global $closed;
    $dm = mysqli_fetch_array(safe_query("SELECT * FROM " . PREFIX . "settings where closed='1'"));
    if (@$closed != '1') {
    } else {
        echo '<div class="alert alert-danger" role="alert" style="margin-bottom: -5px;">
            <center>Die Seite befindet sich im Wartungsmodus | The site is in maintenance mode | Il sito è in modalità manutenzione</center>
        </div>';
    }
}

#ckeditor Quelltext Button wird angezeigt für Superadmin
function get_editor()
{
    global $userID;
    if (issuperadmin($userID)) {
        echo '<script src="./components/ckeditor/ckeditor.js"></script>
<script src="./components/ckeditor/config.js"></script>';
    } else {
        echo '<script src="./components/ckeditor/ckeditor.js"></script>
<script src="./components/ckeditor/user_config.js"></script>';
    }
}
