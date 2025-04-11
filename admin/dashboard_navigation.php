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
error_reporting(E_ALL);
ini_set('display_errors', 1);

$_language->readModule('dashnavi', false, true);

$ergebnis = safe_query("SELECT * FROM ".PREFIX."navigation_dashboard_links WHERE modulname='ac_dashnavi'");
    while ($db=mysqli_fetch_array($ergebnis)) {
      $accesslevel = 'is'.$db['accesslevel'].'admin';

if (!$accesslevel($userID) || mb_substr(basename($_SERVER[ 'REQUEST_URI' ]), 0, 15) != "admincenter.php") {
    die($_language->module[ 'access_denied' ]);
}
}

if (isset($_GET[ 'delete' ])) {
    $linkID = $_GET[ 'linkID' ];
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_GET[ 'captcha_hash' ])) {
        safe_query("DELETE FROM " . PREFIX . "navigation_dashboard_links WHERE linkID='$linkID' ");
    } else {
        echo $_language->module[ 'transaction_invalid' ];
        redirect("admincenter.php?site=dashboard_navigation",3);
    return false;
    }
} elseif (isset($_GET[ 'delcat' ])) {
    $catID = $_GET[ 'catID' ];
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_GET[ 'captcha_hash' ])) {
        safe_query("UPDATE " . PREFIX . "navigation_dashboard_links SET catID='0' WHERE catID='$catID' ");
        safe_query("DELETE FROM " . PREFIX . "navigation_dashboard_categories WHERE catID='$catID' ");
    } else {
        echo $_language->module[ 'transaction_invalid' ];
    }
} elseif (isset($_POST[ 'sortieren' ])) {
    if(isset($_POST[ 'sortcat' ])) { $sortcat = $_POST[ 'sortcat' ]; } else { $sortcat="";}
    $sortlinks = $_POST[ 'sortlinks' ];

    if (is_array($sortcat) AND !empty($sortcat)) {
        foreach ($sortcat as $sortstring) {
            $sorter = explode("-", $sortstring);
            safe_query("UPDATE " . PREFIX . "navigation_dashboard_categories SET sort='$sorter[1]' WHERE catID='$sorter[0]' ");
        }
    }
    if (is_array($sortlinks)) {
        foreach ($sortlinks as $sortstring) {
            $sorter = explode("-", $sortstring);
            safe_query("UPDATE " . PREFIX . "navigation_dashboard_links SET sort='$sorter[1]' WHERE linkID='$sorter[0]' ");
        }
    }
} elseif (isset($_POST[ 'save' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
        $anz = mysqli_num_rows(
            safe_query("SELECT linkID FROM " . PREFIX . "navigation_dashboard_links WHERE catID='" . $_POST[ 'catID' ] . "'")
        );
        safe_query(
            "INSERT INTO " . PREFIX . "navigation_dashboard_links ( catID, name, url, accesslevel, sort )
            values (
            '" . $_POST[ 'catID' ] . "',
            '" . $_POST[ 'name' ] . "',
            '" . $_POST[ 'url' ] . "',
            '" . $_POST[ 'accesslevel' ] . "',
            '" . ($anz + 1) . "'
            )"
        );
    } else {
        echo $_language->module[ 'transaction_invalid' ];
    }
} elseif (isset($_POST[ 'savecat' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])
    ) {
        $anz = mysqli_num_rows(safe_query("SELECT catID FROM " . PREFIX . "navigation_dashboard_categories"));
        safe_query(
            "INSERT INTO " . PREFIX . "navigation_dashboard_categories ( fa_name, name, accesslevel, sort )
            values( '" . $_POST[ 'fa_name' ] . "', '" . $_POST[ 'name' ] . "', '" . $_POST[ 'accesslevel' ] . "', '" . ($anz + 1) . "' )"
        );
    } else {
        echo $_language->module[ 'transaction_invalid' ];
    }
} elseif (isset($_POST[ 'saveedit' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
        safe_query(
            "UPDATE " . PREFIX . "navigation_dashboard_links
            SET catID='" . $_POST[ 'catID' ] . "', name='" . $_POST[ 'name' ] . "', url='" . $_POST[ 'url' ] . "',
                accesslevel='" . $_POST[ 'accesslevel' ] . "'
            WHERE linkID='" . $_POST[ 'linkID' ] . "'"
        );
    } else {
        echo $_language->module[ 'transaction_invalid' ];
    }
} elseif (isset($_POST[ 'saveeditcat' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
        safe_query(
            "UPDATE " . PREFIX . "navigation_dashboard_categories SET fa_name='" . $_POST[ 'fa_name' ] . "', name='" . $_POST[ 'name' ] . "', 
                accesslevel='" . $_POST[ 'accesslevel' ] . "'
            WHERE catID='" . $_POST[ 'catID' ] . "' "
        );
    } else {
        echo $_language->module[ 'transaction_invalid' ];
    }
}

if (isset($_GET[ 'action' ])) {
    $action = $_GET[ 'action' ];
} else {
    $action = '';
}

if ($action == "add") {
    echo '<div class="card">
        <div class="card-header"><i class="bi bi-menu-app"></i> 
            ' . $_language->module[ 'dashnavi' ] . '
        </div>
            
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admincenter.php?site=dashboard_navigation">' . $_language->module['dashnavi'] . '</a></li>
    <li class="breadcrumb-item active" aria-current="page">' . $_language->module['add_link'] . '</li>
  </ol>
</nav>
     <div class="card-body">';

    $ergebnis = safe_query("SELECT * FROM " . PREFIX . "navigation_dashboard_categories ORDER BY sort");
    $cats = '<select class="form-select" name="catID">';
    while ($ds = mysqli_fetch_array($ergebnis)) {
         $name = $ds['name'];
    $translate = new multiLanguage(detectCurrentLanguage());
    $translate->detectLanguages($name);
    $name = $translate->getTextByLanguage($name);
    
    $data_array = array();
    $data_array['$name'] = $ds['name'];


        
        $cats .= '<option value="' . $ds[ 'catID' ] . '">' . $name . '</option>';
    }
    $cats .= '</select>';

    $accesslevel = '<option value="any">' . $_language->module[ 'admin_any' ] . '</option>
    <option value="super">' . $_language->module[ 'admin_super' ] . '</option>
    <option value="forum">' . $_language->module[ 'admin_forum' ] . '</option>
    <option value="files">' . $_language->module[ 'admin_files' ] . '</option>
    <option value="page">' . $_language->module[ 'admin_page' ] . '</option>
    <option value="feedback">' . $_language->module[ 'admin_feedback' ] . '</option>
    <option value="news">' . $_language->module[ 'admin_news' ] . '</option>
    <option value="polls">' . $_language->module[ 'admin_polls' ] . '</option>
    <option value="clanwars">' . $_language->module[ 'admin_clanwars' ] . '</option>
    <option value="user">' . $_language->module[ 'admin_user' ] . '</option>
    <option value="cash">' . $_language->module[ 'admin_cash' ] . '</option>
    <option value="gallery">' . $_language->module[ 'admin_gallery' ] . '</option>';

    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();

    echo '<form class="form-horizontal" method="post" action="admincenter.php?site=dashboard_navigation">
    <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['category'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      ' . $cats . '</em></span>
    </div>
    </div>
 <div class="mb-3 row">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-8">'.$_language->module['info'].'</div>
  </div> 


    <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['name'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
        <input class="form-control" type="text" name="name" size="60"></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['url'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
        <input class="form-control" type="text" name="url" size="60"></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['accesslevel'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
        <select class="form-select" name="accesslevel">' . $accesslevel . '</select></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <div class="col-md-offset-2 col-md-10">
      <input type="hidden" name="captcha_hash" value="' . $hash . '"><button class="btn btn-success" type="submit" name="save"><i class="bi bi-box-arrow-down"></i> ' . $_language->module[ 'add_link' ] . '</button>
    </div>
  </div>
   
          </form></div></div>';
} elseif ($action == "edit") {
    echo '<div class="card">
        <div class="card-header"><i class="bi bi-menu-app"></i> 
            ' . $_language->module[ 'dashnavi' ] . '
        </div>
            
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admincenter.php?site=dashboard_navigation">' . $_language->module['dashnavi'] . '</a></li>
    <li class="breadcrumb-item active" aria-current="page">' . $_language->module['edit_link'] . '</li>
  </ol>
</nav>
     <div class="card-body">';

    $linkID = $_GET[ 'linkID' ];
    $ergebnis = safe_query("SELECT * FROM " . PREFIX . "navigation_dashboard_links WHERE linkID='$linkID'");
    $ds = mysqli_fetch_array($ergebnis);

    $category = safe_query("SELECT * FROM " . PREFIX . "navigation_dashboard_categories ORDER BY sort");
    $cats = '<select class="form-select" name="catID">';
    while ($dc = mysqli_fetch_array($category)) {
        $name = $dc['name'];
    $translate = new multiLanguage(detectCurrentLanguage());
    $translate->detectLanguages($name);
    $name = $translate->getTextByLanguage($name);
    
    $data_array = array();
    $data_array['$name'] = $dc['name'];
        
        if ($ds[ 'catID' ] == $dc[ 'catID' ]) {
            $selected = " selected=\"selected\"";
        } else {
            $selected = "";
        }
        $cats .= '<option value="' . $dc[ 'catID' ] . '"' . $selected . '>' . $name . '</option>';
    }
    $cats .= '</select>';

    $accesslevel = '<option value="any">' . $_language->module[ 'admin_any' ] . '</option>
    <option value="super">' . $_language->module[ 'admin_super' ] . '</option>
    <option value="forum">' . $_language->module[ 'admin_forum' ] . '</option>
    <option value="files">' . $_language->module[ 'admin_files' ] . '</option>
    <option value="page">' . $_language->module[ 'admin_page' ] . '</option>
    <option value="feedback">' . $_language->module[ 'admin_feedback' ] . '</option>
    <option value="news">' . $_language->module[ 'admin_news' ] . '</option>
    <option value="polls">' . $_language->module[ 'admin_polls' ] . '</option>
    <option value="clanwars">' . $_language->module[ 'admin_clanwars' ] . '</option>
    <option value="user">' . $_language->module[ 'admin_user' ] . '</option>
    <option value="cash">' . $_language->module[ 'admin_cash' ] . '</option>
    <option value="gallery">' . $_language->module[ 'admin_gallery' ] . '</option>';
    $accesslevel =
        str_replace(
            'value="' . $ds[ 'accesslevel' ] . '"',
            'value="' . $ds[ 'accesslevel' ] . '" selected="selected"',
            $accesslevel
        );

    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();

    echo '<form class="form-horizontal" method="post" action="admincenter.php?site=dashboard_navigation">

    <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['category'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      ' . $cats . '</em></span>
    </div>
  </div>
  
  <div class="mb-3 row">

       
    <label class="col-md-2 control-label">'.$_language->module['name'].':</label>
    <div class="col-md-8"> '.$_language->module['info'].' <span class="text-muted small"><em>
      <input class="form-control" type="text" name="name" value="' . getinput($ds[ 'name' ]) . '" size="60"></em></span>
    </div>
  </div>
  
  <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['url'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" name="url" value="' . getinput($ds[ 'url' ]) . '" size="60"></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['accesslevel'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      <select class="form-select" name="accesslevel">' . $accesslevel . '</select></em></span>
    </div>
  </div>
<div class="mb-3 row">
    <div class="col-md-offset-2 col-md-10">
      <input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="linkID" value="' . $linkID . '">
      <button class="btn btn-warning" type="submit" name="saveedit"><i class="bi bi-box-arrow-down"></i> ' . $_language->module[ 'edit_link' ] . '</button>
    </div>
  </div>

    </form>
    </div></div>';
} elseif ($action == "addcat") {
    echo '<div class="card">
        <div class="card-header"><i class="bi bi-menu-app"></i> 
            ' . $_language->module[ 'dashnavi' ] . '
        </div>
            
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admincenter.php?site=dashboard_navigation">' . $_language->module['dashnavi'] . '</a></li>
    <li class="breadcrumb-item active" aria-current="page">' . $_language->module['add_category'] . '</li>
  </ol>
</nav>
     <div class="card-body">';

    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();

    $accesslevel = '<option value="any">' . $_language->module[ 'admin_any' ] . '</option>
    <option value="super">' . $_language->module[ 'admin_super' ] . '</option>
    <option value="forum">' . $_language->module[ 'admin_forum' ] . '</option>
    <option value="files">' . $_language->module[ 'admin_files' ] . '</option>
    <option value="page">' . $_language->module[ 'admin_page' ] . '</option>
    <option value="feedback">' . $_language->module[ 'admin_feedback' ] . '</option>
    <option value="news">' . $_language->module[ 'admin_news' ] . '</option>
    <option value="polls">' . $_language->module[ 'admin_polls' ] . '</option>
    <option value="clanwars">' . $_language->module[ 'admin_clanwars' ] . '</option>
    <option value="user">' . $_language->module[ 'admin_user' ] . '</option>
    <option value="cash">' . $_language->module[ 'admin_cash' ] . '</option>
    <option value="gallery">' . $_language->module[ 'admin_gallery' ] . '</option>';

    echo '<form class="form-horizontal" method="post" action="admincenter.php?site=dashboard_navigation">

    <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['fa_name'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" name="fa_name" size="60"></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['name'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" name="name" size="60"></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['accesslevel'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      <select class="form-select" name="accesslevel">' . $accesslevel . '</select></em></span>
    </div>
  </div>
<div class="mb-3 row">
    <div class="col-md-offset-2 col-md-10">
      <input type="hidden" name="captcha_hash" value="'.$hash.'" />
      <button class="btn btn-success" type="submit" name="savecat"><i class="bi bi-box-arrow-down"></i> ' . $_language->module[ 'add_category' ] . '</button>
    </div>
  </div>

    </form>
    </div></div>';
} elseif ($action == "editcat") {
    echo '<div class="card">
        <div class="card-header"><i class="bi bi-menu-app"></i> 
            ' . $_language->module[ 'dashnavi' ] . '
        </div>
            
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admincenter.php?site=dashboard_navigation">' . $_language->module['dashnavi'] . '</a></li>
    <li class="breadcrumb-item active" aria-current="page">' . $_language->module['edit_category'] . '</li>
  </ol>
</nav>
     <div class="card-body">';

    $catID = $_GET[ 'catID' ];
    $ergebnis = safe_query("SELECT * FROM " . PREFIX . "navigation_dashboard_categories WHERE catID='$catID'");
    $ds = mysqli_fetch_array($ergebnis);

    $accesslevel = '<option value="any">' . $_language->module[ 'admin_any' ] . '</option>
    <option value="super">' . $_language->module[ 'admin_super' ] . '</option>
    <option value="forum">' . $_language->module[ 'admin_forum' ] . '</option>
    <option value="files">' . $_language->module[ 'admin_files' ] . '</option>
    <option value="page">' . $_language->module[ 'admin_page' ] . '</option>
    <option value="feedback">' . $_language->module[ 'admin_feedback' ] . '</option>
    <option value="news">' . $_language->module[ 'admin_news' ] . '</option>
    <option value="polls">' . $_language->module[ 'admin_polls' ] . '</option>
    <option value="clanwars">' . $_language->module[ 'admin_clanwars' ] . '</option>
    <option value="user">' . $_language->module[ 'admin_user' ] . '</option>
    <option value="cash">' . $_language->module[ 'admin_cash' ] . '</option>
    <option value="gallery">' . $_language->module[ 'admin_gallery' ] . '</option>';
    $accesslevel =
        str_replace(
            'value="' . $ds[ 'accesslevel' ] . '"',
            'value="' . $ds[ 'accesslevel' ] . '" selected="selected"',
            $accesslevel
        );

    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();

    echo '<form class="form-horizontal" method="post" action="admincenter.php?site=dashboard_navigation">

    <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['fa_name'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" name="fa_name" value="' . getinput($ds[ 'fa_name' ]) . '" size="60"></em></span>
    </div>
  </div>

  <div class="mb-3 row">
    <label class="col-md-2 control-label">' . $_language->module[ 'name' ] . ':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" name="name" value="' . getinput($ds[ 'name' ]) . '" size="60"></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <label class="col-md-2 control-label">'.$_language->module['accesslevel'].':</label>
    <div class="col-md-8"><span class="text-muted small"><em>
      <select class="form-select" name="accesslevel">' . $accesslevel . '</select></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <div class="col-md-offset-2 col-md-10">
      <input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="catID" value="' . $catID . '">
      <button class="btn btn-warning" type="submit" name="saveeditcat"><i class="bi bi-box-arrow-down"></i> ' . $_language->module[ 'edit_category' ] . '</button>
    </div>
  </div>
    </form></div></div>';
} else {
    echo '<div class="card">
        <div class="card-header"><i class="bi bi-menu-app"></i>
            ' . $_language->module[ 'dashnavi' ] . '
        </div>
           <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">' . $_language->module[ 'dashnavi' ] . '</li>
  </ol>
</nav>

<div class="card-body">

<div class="mb-3 row">
    <label class="col-md-1 control-label">' . $_language->module['options'] . ':</label>
    <div class="col-md-8">

<a class="btn btn-primary" href="admincenter.php?site=dashboard_navigation&amp;action=addcat" class="input"><i class="bi bi-plus-circle"></i> ' .
        $_language->module[ 'new_category' ] . '</a>
        <a class="btn btn-primary" href="admincenter.php?site=dashboard_navigation&amp;action=add" class="input"><i class="bi bi-plus-circle"></i> ' .
        $_language->module[ 'new_link' ] . '</a>
    </div>
  </div>';

   echo '<form method="post" action="admincenter.php?site=dashboard_navigation">
    <table class="table">
<thead>
    <tr>
      <th width="25%" ><b>' . $_language->module[ 'name' ] . '</b></th>
      <th width="25%" ><b>Link</b></th>
            <th width="17%" align="center"><b>' . $_language->module[ 'accesslevel' ] . '</b></th>
            <th width="20%" ><b>' . $_language->module[ 'actions' ] . '</b></th>
            <th width="8%" ><b>' . $_language->module[ 'sort' ] . '</b></th>
    </tr></thead>';

    $ergebnis = safe_query("SELECT * FROM " . PREFIX . "navigation_dashboard_categories ORDER BY sort");
    $tmp = mysqli_fetch_assoc(safe_query("SELECT count(catID) as cnt FROM " . PREFIX . "navigation_dashboard_categories"));
    $anz = $tmp[ 'cnt' ];

    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();
    while ($ds = mysqli_fetch_array($ergebnis)) {

        $list = '<select name="sortcat[]">';
                for ($n = 1; $n <= $anz; $n++) {
                    $list .= '<option value="' . $ds[ 'catID' ] . '-' . $n . '">' . $n . '</option>';
                }
                $list .= '</select>';
                $list = str_replace(
                    'value="' . $ds[ 'catID' ] . '-' . $ds[ 'sort' ] . '"',
                    'value="' . $ds[ 'catID' ] . '-' . $ds[ 'sort' ] . '" selected="selected"',
                    $list
                );

        if ($ds[ 'default' ] == 1) {
            $sort = '<b>' . $ds[ 'sort' ] . '</b>';
            $catactions = '';
            @$name = getinput($ds[ 'name' ]);
        } else {
            $sort = $list;
            $catactions =
                '<a class="btn btn-warning" href="admincenter.php?site=dashboard_navigation&amp;action=editcat&amp;catID=' . $ds[ 'catID' ] .
                '" class="input"><i class="bi bi-pencil-square"></i> ' . $_language->module[ 'edit' ] . '</a>
                
                <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="admincenter.php?site=dashboard_navigation&amp;delcat=true&amp;catID=' . $ds[ 'catID' ] .
                '&amp;captcha_hash=' . $hash . '"><i class="bi bi-trash3"></i> 
    ' . $_language->module['delete'] . '
    </button>
    <!-- Button trigger modal END-->

     <!-- Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-menu-app"></i> ' . $_language->module[ 'dashnavi' ] . '</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="' . $_language->module[ 'close' ] . '"></button>
      </div>
      <div class="modal-body"><p><i class="bi bi-trash3"></i> ' . $_language->module['really_delete_category'] . '</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> ' . $_language->module[ 'close' ] . '</button>
        <a class="btn btn-danger btn-ok"><i class="bi bi-trash3"></i> ' . $_language->module['delete'] . '</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal END -->

';

            $name = $ds['name'];
                $translate = new multiLanguage(detectCurrentLanguage());
                $translate->detectLanguages($name);
                $name = $translate->getTextByLanguage($name);
                
                $data_array = array();
                $data_array['$name'] = $ds['name']; 
        }

        echo '<tr class="table-secondary">
            <td width="25%" class="td_head admin-nav-modal"><b>' . $name . '</b></td>
            <td width="25%" class="td_head admin-nav-modal"></td>
            <td width="17%" class="td_head admin-nav-modal"><b>' .
                    $_language->module[ 'admin_' . getinput($ds[ 'accesslevel' ]) ] . '</b></small></td>
            <td width="20%" class="td_head">' . $catactions . '</td>
            <td width="8%" class="td_head">' . $sort . '</td>
        </tr>';

        $links =
            safe_query("SELECT * FROM " . PREFIX . "navigation_dashboard_links WHERE catID='" . $ds[ 'catID' ] . "' ORDER BY sort");
        $tmp = mysqli_fetch_assoc(
            safe_query(
                "SELECT count(linkID) as cnt
                  FROM " . PREFIX . "navigation_dashboard_links WHERE catID='" . $ds[ 'catID' ] . "'"
            )
        );
        $anzlinks = $tmp[ 'cnt' ];

        $i = 1;
        $CAPCLASS = new \webspell\Captcha;
        $CAPCLASS->createTransaction();
        $hash = $CAPCLASS->getHash();
        if (mysqli_num_rows($links)) {
            while ($db = mysqli_fetch_array($links)) {
                if ($i % 2) {
                    $td = 'td1';
                } else {
                    $td = 'td2';
                }

                $name = $db['name'];
                $translate = new multiLanguage(detectCurrentLanguage());
                $translate->detectLanguages($name);
                $name = $translate->getTextByLanguage($name);
                
                $data_array = array();
                $data_array['$name'] = $db['name'];

                $linklist = '<select name="sortlinks[]">';
                for ($n = 1; $n <= $anzlinks; $n++) {
                    $linklist .= '<option value="' . $db[ 'linkID' ] . '-' . $n . '">' . $n . '</option>';
                }
                $linklist .= '</select>';
                $linklist = str_replace(
                    'value="' . $db[ 'linkID' ] . '-' . $db[ 'sort' ] . '"',
                    'value="' . $db[ 'linkID' ] . '-' . $db[ 'sort' ] . '" selected="selected"',
                    $linklist
                );

                echo '<tr>
                    <td class="' . $td . '">&nbsp;-&nbsp;<b>' . $name . '</b></td>
                    <td class="' . $td . '"><small>' . $db[ 'url' ] . '</small></td>
                    <td class="' . $td . '"><small><b>' .
                    $_language->module[ 'admin_' . getinput($db[ 'accesslevel' ]) ] . '</b></small></td>
                    <td class="' . $td . '">
<a href="admincenter.php?site=dashboard_navigation&amp;action=edit&amp;linkID=' . $db[ 'linkID' ] .'" class="btn btn-warning"><i class="bi bi-pencil-square"></i> ' . $_language->module[ 'edit' ] . '</a>

 <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete-link" data-href="admincenter.php?site=dashboard_navigation&delete=true&linkID=' . $db[ 'linkID' ] . '&captcha_hash=' . $hash . '"><i class="bi bi-trash3"></i> 
    ' . $_language->module['delete'] . '
    </button>
	
	
    <!-- Button trigger modal END-->
	
	
     <!-- Modal -->
<div class="modal fade" id="confirm-delete-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-menu-app"></i> ' . $_language->module[ 'dashnavi' ] . '</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="' . $_language->module[ 'close' ] . '"></button>
      </div>
      <div class="modal-body"><p><i class="bi bi-trash3"></i> ' . $_language->module['really_delete_link'] . '</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> ' . $_language->module[ 'close' ] . '</button>
        <a class="btn btn-danger btn-ok"><i class="bi bi-trash3"></i> ' . $_language->module['delete'] . '</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal END -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var confirmDeleteModal = document.getElementById("confirm-delete-link");
    confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
      var button = event.relatedTarget; // Bottone che ha attivato il modal
      var href = button.getAttribute("data-href"); // Ottiene il link di eliminazione
      var deleteButton = confirmDeleteModal.querySelector(".btn-ok");
      deleteButton.setAttribute("href", href); // Imposta il link corretto nel modal
    });
  });
</script>

 </td>
                    <td class="' . $td . '">' . $linklist . '</td>
                </tr>';
                $i++;
            }
        } else {
            echo '<tr>'.
                    '<td class="td1" colspan="5">' . $_language->module[ 'no_additional_links_available' ] . '</td>'.
                 '</tr>';
        }
    }
    
    echo '	<tr>
                <td class="td_head" colspan="6" align="right">
				<button class="btn btn-primary" type="submit" name="sortieren"><i class="bi bi-sort-numeric-up"></i>  ' . $_language->module[ 'to_sort' ] . '</button>
		
		</td>
            </tr>
        </table>
    </form></div></div>';
}
