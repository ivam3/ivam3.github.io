<?php
/**
 * VFM - veno file manager: include/navbar.php
 * user menu, user panel and language selector
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @link      http://filemanager.veno.it/
 */
if (!defined('VFM_APP')) {
    return;
}
// $parent = basename($_SERVER["SCRIPT_FILENAME"]);
$islogin = ($parentfile === "login.php" ? true : false); 
$stepback = $islogin ? '' : 'vfm-admin/';
$navbarclass = $setUp->getConfig("header_position") == 'above' ? '' : ' navbar-fixed-top'
?>
<nav class="navbar navbar-inverse<?php echo $navbarclass; ?>">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-vfm-menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php // Brand button 
            if (!$setUp->getConfig('hide_logo', false)) {
                ?>
            <a class="navbar-brand" href="<?php echo $setUp->getConfig("script_url"); ?>">
                <?php 
                if ($setUp->getConfig('navbar_logo')) { ?>
                    <img src="<?php echo $stepback.'_content/uploads/'.$setUp->getConfig('navbar_logo'); ?>">
                    <?php
                } else {
                    echo $setUp->getConfig("appname");
                } ?>
            </a>
                <?php
            } ?>
        </div>
        <div class="collapse navbar-collapse" id="collapse-vfm-menu">
            <ul class="nav navbar-nav navbar-right">
<?php
// User menu
if ($gateKeeper->isUserLoggedIn()) {

    $username = $gateKeeper->getUserInfo('name');
    $avaimg = $gateKeeper->getAvatar($username, $stepback);

    if ($setUp->getConfig("show_usermenu") == true ) { ?>
                <li>
                    <a class="edituser" href="#" data-toggle="modal" data-target="#userpanel">
                        <?php echo $avaimg; ?>
                        <span class="hidden-sm">
                            <strong><?php echo $username; ?></strong>
                        </span>
                    </a>
                </li>
        <?php
    }
    if ($gateKeeper->isSuperAdmin()) { ?>
                <li>
                    <a href="<?php echo $setUp->getConfig("script_url"); ?>vfm-admin/">
                        <i class="fa fa-cogs fa-fw"></i> 
                        <span class="hidden-sm hidden-md">
                            <?php echo $setUp->getString("administration"); ?>
                        </span>
                    </a>
                </li>
        <?php
    } ?>
                <li>
                    <a href="<?php echo $setUp->getConfig("script_url").$location->makeLink(true, null, ""); ?>">
                        <i class="fa fa-sign-out fa-fw"></i> 
                        <span class="hidden-sm hidden-md">
                            <?php echo $setUp->getString("log_out"); ?>
                        </span>
                    </a>
                </li>
    <?php
} // end logged user

// Global search
if (SetUp::getConfig('global_search') && $gateKeeper->isAccessAllowed() && $gateKeeper->isAllowed('viewdirs_enable')) { ?>
                <li>
                    <a href="#" data-toggle="modal" data-target="#global-search">
                        <i class="fa fa-search fa-fw"></i> 
                        <span class="hidden-sm hidden-md">
                            <?php echo $setUp->getString("search"); ?>
                        </span>
                    </a>
                </li>
    <?php
}

// Language selector 
if (SetUp::getConfig('show_langmenu')) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa fa-flag fa-fw"></i>
                        <?php
                        if ($setUp->getConfig('show_langname')) { ?>
                        <span class="hidden-sm hidden-md">
                            <?php echo $setUp->getString("LANGUAGE_NAME"); ?>
                        </span>
                            <?php
                        } else { ?>
                            <span class="hidden-sm hidden-md hidden-lg">
                                <?php echo $setUp->getString("language"); ?>
                            </span>
                            <?php
                        } ?> 
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu lang-menu">
                        <?php echo $setUp->printLangMenu($stepback); ?>
                    </ul>
                </li>
    <?php
} ?>
            </ul>
        </div>
    </div>
</nav>

<?php
/**
 * Global search
 */ 
if (SetUp::getConfig('global_search') && $gateKeeper->isAccessAllowed() && $gateKeeper->isAllowed('viewdirs_enable')) { ?>
        <div class="modal fade" id="global-search" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-search-plus fa-fw"></i> <?php echo $setUp->getString("global_search"); ?></h5>
                        <button class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="search-form" class="disabled">
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <input class="form-control" id="s-input" type="text" name="s" placeholder="<?php echo $setUp->getString("search"); ?>...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary submit-search disabled" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="modal_response">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                initSearch(
                    '<?php echo $setUp->getString("files"); ?>', 
                    '<?php echo $setUp->getString("folders"); ?>' 
                );
            });
        </script>
    <?php
} ?>

<?php
/**
 * User Panel
 */
if ($gateKeeper->isUserLoggedIn() && $setUp->getConfig("show_usermenu") == true ) { 
    /**
    * Get additional custom fields
    */
    $customfields = false;
    if (file_exists('vfm-admin/users/customfields.php')) {
        include 'vfm-admin/users/customfields.php';
    } ?>
    <script type="text/javascript">
    $(document).ready(function(){
        Avatars('<?php echo $avaimg; ?>', '<?php echo $username; ?>');
    });
    </script>
    <div class="modal userpanel fade" id="userpanel" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <ul class="nav nav-pills" role="tablist">
              <li role="presentation" class="active">
                <a href="#upprof" aria-controls="home" role="tab" data-toggle="pill">
                    <i class="fa fa-edit"></i> 
                    <?php echo $setUp->getString("update_profile"); ?>
                </a>
              </li>
              <li role="presentation">
                <a href="#upava" aria-controls="home" role="tab" data-toggle="pill">
                    <i class="fa fa-user"></i> 
                    <?php echo $setUp->getString("avatar"); ?>
                </a>
              </li>
            <?php
            // additional custom fields.
            if (is_array($customfields)) { ?>
              <li role="presentation">
                <a href="#customfields" aria-controls="home" role="tab" data-toggle="pill">
                    <i class="fa fa-id-card-o"></i> 
                </a>
              </li>
                <?php
            } ?>
            </ul>
          </div>

          <div class="modal-body">
            <form role="form" method="post" id="usrForm" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade text-center" id="upava">
                <div class="avatar-response"></div>
                <div class="avatar-panel">
                    <div class="updated"></div>
                    <img class="avadefault img-circle" data-name="<?php echo $gateKeeper->getUserInfo('name'); ?>" />
                    <div class="cropit-preview"></div>
                    <i class="fa fa-times fa-lg pull-right text-muted remove-avatar"></i>
                    <input type="range" class="cropit-image-zoom-input slider" />
                    <input type="file" id="uppavatar" class="cropit-image-input">
                </div>

                <!-- And clicking on this button will open up select file dialog -->
                <div class="select-image-btn uppa btn btn-default">
                    <?php echo $setUp->getString("upload"); ?> <i class="fa fa-upload fa-fw"></i>
                </div>
                <div class="export btn btn-primary hidden">
                    <?php echo $setUp->getString("update"); ?> <i class="fa fa-check-circle fa-fw"></i>
                </div> 
                <input type="hidden" class="image-name" value="<?php echo md5($gateKeeper->getUserInfo('name')); ?>">

              </div> <!-- tabpanel -->

              <div role="tabpanel" class="tab-pane fade in active" id="upprof">
                  <div class="form-group">
                    <label for="user_new_name">
                        <?php echo $setUp->getString("username"); ?>
                    </label>
                    <input name="user_old_name" type="hidden" readonly class="form-control" value="<?php echo $gateKeeper->getUserInfo('name'); ?>">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                        <input name="user_new_name" type="text" class="form-control" value="<?php echo $gateKeeper->getUserInfo('name'); ?>">
                    </div>
                    <label for="user_new_email">
                        <?php echo $setUp->getString("email"); ?>
                    </label>
                    <input name="user_old_email" type="hidden" readonly class="form-control" value="<?php echo $gateKeeper->getUserInfo('email'); ?>">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                        <input name="user_new_email" type="text" 
                        class="form-control" value="<?php echo $gateKeeper->getUserInfo('email'); ?>">
                    </div>
                    <label for="user_new_pass">
                        <?php echo $setUp->getString("new_password"); ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                        <input name="user_new_pass" id="newp" type="password" class="form-control">
                    </div>
                    <label for="user_new_pass_confirm">
                        <?php echo $setUp->getString("new_password")
                        ." (".$setUp->getString("confirm").")"; ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                        <input name="user_new_pass_confirm" id="checknewp" type="password" class="form-control">
                    </div>
                </div>
              </div> <!-- tabpanel -->
    <?php
    /**
     * Set additional custom fields
     */
    if (is_array($customfields)) {                         
        $customlist = htmlspecialchars(json_encode($customfields)); ?>
              <div role="tabpanel" class="tab-pane fade" id="customfields">
                <input type="hidden" name="user-customfields" value="<?php echo $customlist; ?>">
        <?php
        foreach ($customfields as $customkey => $customfield) {
            $optionselecta = $gateKeeper->getUserInfo($customkey);
            if (isset($customfield['type'])) { ?>
                <div class="form-group">
                    <label><?php echo $customfield['name']; ?></label>
                <?php
                if ($customfield['type'] === 'textarea') { ?>
                    <textarea name="<?php echo $customkey; ?>" class="form-control getuser getuser-<?php echo $customkey; ?>" rows="2">
                        <?php echo $optionselecta; ?>        
                    </textarea>
                    <?php
                }
                if ($customfield['type'] === 'select' && is_array($customfield['options'])) {
                    $multiselect = '';
                    if (isset($customfield['multiple']) && $customfield['multiple'] == true) {
                         $multiselect = ($customfield['multiple'] == true ? 'multiple="multiple"' : '');
                    } ?>
                    <select name="<?php echo $customkey; ?>" class="form-control" <?php echo $multiselect; ?>>
                    <?php
                    foreach ($customfield['options'] as $optionval => $optiontitle) { 
                        $selected = ($optionselecta == $optionval) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $optionval; ?>" <?php echo $selected ;?>>
                            <?php echo $optiontitle; ?>
                        </option>
                        <?php
                    } ?>
                    </select>
                    <?php
                }
                if ($customfield['type'] === 'text' || $customfield['type'] === 'email') { ?>
                    <input type="<?php echo $customfield['type']; ?>" name="<?php echo $customkey; ?>" class="form-control" value="<?php echo $optionselecta; ?>">
                    <?php
                } ?>
                </div>
                <?php
            } // end customfield type
        } // end foreach ?>
              </div> <!-- tabpanel -->
        <?php
    } ?>
            </div><!-- tab-content -->

            <div class="form-group">
                <label for="user_old_pass">
                    * <?php echo $setUp->getString("current_pass"); ?>
                </label> 
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-unlock fa-fw"></i></span>
                    <input name="user_old_pass" type="password" id="oldp" required class="form-control">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-refresh"></i>
                    <?php print $setUp->getString("update"); ?>
                </button>
            </div>

            </form>
          </div> <!-- modal-body -->
        </div> <!-- modal-content -->
      </div> <!-- modal-dialog -->
    </div> <!-- modal -->
    <?php
}
