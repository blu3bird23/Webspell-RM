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

$_language->readModule('static', false, true);

$ergebnis = safe_query("SELECT * FROM ".PREFIX."navigation_dashboard_links WHERE modulname='ac_static'");
    while ($db=mysqli_fetch_array($ergebnis)) {
      $accesslevel = 'is'.$db['accesslevel'].'admin';

if (!$accesslevel($userID) || mb_substr(basename($_SERVER[ 'REQUEST_URI' ]), 0, 15) != "admincenter.php") {
    die($_language->module[ 'access_denied' ]);
}
}

if (isset($_POST[ 'save' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
        if (isset($_POST[ 'staticID' ]) && $_POST[ 'staticID' ]) {
            if (isset($_POST[ "displayed" ])) {
                $displayed = '1';
            } else {
                $displayed = '0';
            }

            print_r($_POST[ "displayed" ]);
            safe_query(
                "UPDATE
                    `" . PREFIX . "settings_static`
                SET
                    title='" . $_POST[ 'title' ] . "',
                    accesslevel='" . $_POST[ 'accesslevel' ] . "',
                    content='" . $_POST[ 'message' ] . "',
                    date='" . time() . "',
                    displayed='" . $displayed . "'
                WHERE
                    staticID='" . $_POST[ 'staticID' ] . "'"
            );
            $id = $_POST[ 'staticID' ];
        } else {

            if (isset($_POST[ "displayed" ])) {
                $displayed = '1';
            } else {
                $displayed = '0';
            }
    


            safe_query(
                "INSERT INTO
                    `" . PREFIX . "settings_static` (
                        `title`, `accesslevel`,`content`,`date`,`displayed`
                    )
                   VALUES(
                        '" . $_POST[ 'title' ] . "', '" . $_POST[ 'accesslevel' ] . "','" . $_POST[ 'message' ] . "','" . time() . "','" . $displayed . "'
                    ) "
            );
            $id = mysqli_insert_id($_database);
        }
        \webspell\Tags::setTags('static', $id, $_POST[ 'tags' ]);
    } else {
        echo $_language->module[ 'transaction_invalid' ];
    }
} elseif (isset($_GET[ 'delete' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_GET[ 'captcha_hash' ])) {
        \webspell\Tags::removeTags('static', $_GET[ 'staticID' ]);
        safe_query("DELETE FROM `" . PREFIX . "settings_static` WHERE staticID='" . $_GET[ 'staticID' ] . "'");
    } else {
        echo $_language->module[ 'transaction_invalid' ];
    }
}

if (isset($_GET[ 'action' ]) && $_GET[ 'action' ] == "add") {
    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();
    

  echo '<div class="card">
        <div class="card-header">
            ' . $_language->module[ 'static_pages' ] . '
        </div>
            
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admincenter.php?site=settings_static">' . $_language->module['static_pages'] . '</a></li>
    <li class="breadcrumb-item active" aria-current="page">' . $_language->module['add_static_page'] . '</li>
  </ol>
</nav>
     <div class="card-body">';  
	
  echo'<form class="form-horizontal" method="post" id="post" name="post" action="admincenter.php?site=settings_static" enctype="post" onsubmit="return chkFormular();">
  <div class="row">

<div class="col-md-6">

  <div class="mb-3 row">
    <label class="col-sm-3 control-label">' . $_language->module['title'] . ':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" name="title" size="60" value="new" /></em></span>
    </div>
  </div>

  <div class="mb-3 row">
    <label class="col-sm-3 control-label">' . $_language->module[ 'tags' ] . ':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" name="tags" size="60" value="" /></em></span>
    </div>
  </div>

</div>
<div class="col-md-6">

  <div class="mb-3 row">
    <label class="col-sm-2 control-label">' . $_language->module[ 'accesslevel' ] . ':</label>
    <div class="col-sm-8 form-check form-switch" style="padding: 0px 43px;">
	   <input class="form-check-input" name="accesslevel" type="radio" value="0" checked="checked" />&nbsp;&nbsp;' . $_language->module[ 'public' ] . '<br /><br />
       <input class="form-check-input" name="accesslevel" type="radio" value="1" />&nbsp;&nbsp;' . $_language->module[ 'registered_only' ] . '<br /><br />
       <input class="form-check-input" name="accesslevel" type="radio" value="2" />&nbsp;&nbsp;' . $_language->module[ 'clanmember_only' ] . '
    </div>
  </div>

  </div>

  <div class="col-md-6">
<div class="mb-3 row">
    <label class="col-sm-3 control-label">' . $_language->module[ 'editor_is_displayed' ] . ':</label>
  <div class="col-sm-8 form-check form-switch" style="padding: 0px 43px;">
  <input class="form-check-input" type="checkbox" name="displayed" value="1" checked="checked" />
    </div>
  </div>
</div>


  </div>


 
  <div class="mb-3 row">
    
    <div class="col-md-12"><span class="text-muted small"><em>
      <textarea class="ckeditor" id="ckeditor"  id="message" name="message" rows="20" cols="" style="width: 100%;"></textarea>
    </div>
  </div>
  <div class="mb-3 row">
    <div class="col-md-12">
		<input type="hidden" name="captcha_hash" value="' . $hash . '" />
		<button class="btn btn-success" type="submit" name="save"  />' . $_language->module['add_static_page'] . '</button>
    </div>
  </div>

  
  </form></div></div>';
  
} elseif (isset($_GET[ 'action' ]) && $_GET[ 'action' ] == "edit") {
    $_language->readModule('bbcode', true, true);

    $staticID = $_GET[ 'staticID' ];
    $ergebnis = safe_query("SELECT * FROM `" . PREFIX . "settings_static` WHERE staticID='" . $staticID . "'");
    $ds = mysqli_fetch_array($ergebnis);
    $content = $ds[ 'content' ];

    $clanmember = "";
    $user = "";
    $public = "";
    if ($ds[ 'accesslevel' ] == 2) {
        $clanmember = "checked=\"checked\"";
    } elseif ($ds[ 'accesslevel' ] == 1) {
        $user = "checked=\"checked\"";
    } else {
        $public = "checked=\"checked\"";
    }

    if ($ds[ "displayed" ] == '1') {
        $editor = 'ckeditor';
    } else {
        $editor = '1';
    }

    $tags = \webspell\Tags::getTags('static', $staticID);


    if ($ds[ 'displayed' ] == '1') {
        $displayed = '<input class="form-check-input" type="checkbox" name="displayed" value="1" checked="checked" />';
    } else {
        $displayed = '<input class="form-check-input" type="checkbox" name="displayed" value="1" />';
    }


    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();

    $tags = \webspell\Tags::getTags('static', $staticID);
    #$editor = $ds['displayed'];

     echo '<div class="card">
        <div class="card-header">
            ' . $_language->module[ 'static_pages' ] . '
        </div>
            
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admincenter.php?site=settings_static">' . $_language->module['static_pages'] . '</a></li>
    <li class="breadcrumb-item active" aria-current="page">' . $_language->module['edit_static_page'] . '</li>
  </ol>
</nav>
     <div class="card-body">';  
	
	echo '<form class="form-horizontal" method="post" id="post" name="post" action="admincenter.php?site=settings_static" enctype="post" onsubmit="return chkFormular();">
	<div class="row">

<div class="col-md-6">

  <div class="mb-3 row">
    <label class="col-sm-3 control-label">' . $_language->module[ 'title' ] . ':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" name="title" size="60" value="' . getinput($ds[ 'title' ]) . '" /></em></span>
    </div>
  </div>

<div class="mb-3 row">
    <label class="col-sm-3 control-label">' . $_language->module[ 'tags' ] . ':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
    <input class="form-control" type="text" name="tags" size="60" value="' . getinput($tags) . '" /></em></span>
    </div>
  </div>

</div>
<div class="col-md-6">

  <div class="mb-3 row">
    <label class="col-sm-2 control-label">' . $_language->module[ 'accesslevel' ] . ':</label>
    <div class="col-sm-8 form-check form-switch" style="padding: 0px 43px;">
		<input class="form-check-input" name="accesslevel" type="radio" value="0" ' . $public . ' />&nbsp;&nbsp;' . $_language->module[ 'public' ] . '<br /><br />
      <input class="form-check-input" name="accesslevel" type="radio" value="1" ' . $user . ' />&nbsp;&nbsp;' . $_language->module[ 'registered_only' ] . '<br /><br />
      <input class="form-check-input" name="accesslevel" type="radio" value="2" ' . $clanmember . ' />&nbsp;&nbsp;' . $_language->module[ 'clanmember_only' ] . '
    </div>



</div>



  </div>
<div class="col-md-6">

  <div class="mb-3 row">
    <label class="col-sm-3 control-label">' . $_language->module[ 'editor_is_displayed' ] . ':</label>
  <div class="col-sm-8 form-check form-switch" style="padding: 0px 43px;">
  ' . $displayed . '
    </div>
  </div>




  </div>

  </div>

  <div class="mb-3 row">
  <div class="col-md-12"><span class="text-muted small"><em>
      <textarea  class="'.$editor.'" id="ckeditor" name="message" rows="20" cols="" style="width: 100%;">' . getinput($content) . '</textarea></em></span>
    </div>
  </div>
  <div class="mb-3 row">
    <div class="col-md-12">
		<input type="hidden" name="captcha_hash" value="' . $hash . '" />
	<input type="hidden" name="staticID" value="' . $staticID . '" />
		<button class="btn btn-warning" type="submit" name="save"  />' . $_language->module['edit_static_page'] . '</button>
    </div>
  </div>

  
	</form></div></div>';
} else {

    echo '<div class="card">
        <div class="card-header">
            ' . $_language->module[ 'static_pages' ] . '
        </div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">' . $_language->module[ 'static_pages' ] . '</li>
  </ol>
</nav>

<div class="card-body">

<div class="form-group row">
    <label class="col-md-1 control-label">' . $_language->module['options'] . ':</label>
    <div class="col-md-8">
      <a href="admincenter.php?site=settings_static&amp;action=add" class="btn btn-primary" type="button">' . $_language->module[ 'new_static_page' ] . '</a>
    </div>
  </div>';

    $ergebnis = safe_query("SELECT * FROM " . PREFIX . "settings_static ORDER BY staticID");
	
  echo'<table class="table table-striped">
    <thead>
      <th><b>' . $_language->module['id'] . '</b></th>
      <th><b>' . $_language->module['title'] . '</b></th>
      <th><b>' . $_language->module['accesslevel'] . '</b></th>
      <th><b>' . $_language->module['actions'] . '</b></th>
    </thead>';

	  $i = 1;
    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();

    while ($ds = mysqli_fetch_array($ergebnis)) {
        if ($i % 2) {
            $td = 'td1';
        } else {
            $td = 'td2';
        }
        if ($ds[ 'accesslevel' ] == 2) {
            $accesslevel = $_language->module[ 'clanmember_only' ];
        } elseif ($ds[ 'accesslevel' ] == 1) {
            $accesslevel = $_language->module[ 'registered_only' ];
        } else {
            $accesslevel = $_language->module[ 'public' ];
        }

            $title = $ds[ 'title' ];

            $translate = new multiLanguage(detectCurrentLanguage());
            $translate->detectLanguages($title);
            $title = $translate->getTextByLanguage($title);
            

        echo '<tr>
      <td>' . $ds['staticID'] . '</td>
      <td><a href="../index.php?site=static&amp;staticID=' . $ds['staticID'] . '" target="_blank">' . $title . '</a></td>
      <td>' . $accesslevel . '</td>
      <td><a href="admincenter.php?site=settings_static&amp;action=edit&amp;staticID=' . $ds['staticID'] . '" class="hidden-xs hidden-sm btn btn-warning" type="button">' . $_language->module[ 'edit' ] . '</a>


<!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-href="admincenter.php?site=settings_static&amp;delete=true&amp;staticID=' . $ds['staticID'] . '&amp;captcha_hash=' . $hash . '">
    ' . $_language->module['delete'] . '
    </button>
    <!-- Button trigger modal END-->

     <!-- Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">' . $_language->module[ 'static_pages' ] . '</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="' . $_language->module[ 'close' ] . '"></button>
      </div>
      <div class="modal-body"><p>' . $_language->module['really_delete'] . '</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . $_language->module[ 'close' ] . '</button>
        <a class="btn btn-danger btn-ok">' . $_language->module['delete'] . '</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal END -->

    </td>
    </tr>';
    
    $i++;
	}
	echo'</table>';
}
echo '</div></div>';
?>