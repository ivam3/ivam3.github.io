<?php
/**
 * VFM - veno file manager administration
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
define('VFM_APP', true);
require_once 'admin-panel/view/admin-head.php';

// update usernames prior to v 2.6.3 to unsensitive
if (file_exists('_unsensitive-users.php')) {
    if (count($_USERS) > 1 && version_compare($vfm_version, '2.6.3', '>')) {
        include '_unsensitive-users.php';
    } else {
        unlink('_unsensitive-users.php');
    }
}

// user available quota (in MB)
$_QUOTA = array(
    "10",
    "20",
    "50",
    "100",
    "200",
    "500",
    "1024", // 1GB
    "2048", // 2GB
    "5120", // 5GB
    ); 
// exipration for downloadable links
$share_lifetime = array(
    // "days" => "menu value"
    "1" => "24 h",
    "2" => "48 h",
    "3" => "72 h",
    "5" => "5 days",
    "7" => "7 days",
    "10" => "10 days",
    "30" => "30 days",
    "365" => "1 year",
    "36500" => "Unlimited",
    );

// exipration for registration links
// unit (('sec' | 'second' | 'min' | 'minute' | 'hour' | 'day' | 'month' | 'year') 's'?) 
$registration_lifetime = array(
    // "days" => "menu value"
    // "-1 minute" => "1 min",
    // "-2 minutes" => "2 min",
    "-1 hour" => "1 h",
    "-3 hours" => "3 h",
    "-6 hours" => "6 h",
    "-12 hours" => "12 h",
    "-1 day" => "1 day",
    "-2 days" => "2 days",
    "-7 days" => "7 days",
    "-1 month" => "30 days",
    );
?>
<!doctype html>
<html lang="<?php echo $setUp->lang; ?>">
<head>
    <title><?php print $setUp->getString('administration')." | ".$setUp->getConfig('appname'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php echo $setUp->printIcon("_content/uploads/"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="admin-panel/css/admin.min.css">
    <?php 
    $rtlclass = "";
    if ($setUp->getConfig("txt_direction") == "RTL") {
        $rtlclass = "rtl"; ?>
        <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
        <?php
    } ?>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!--[if lt IE 9]>
    <script src="js/html5.js" type="text/javascript"></script>
    <script src="js/respond.min.js" type="text/javascript"></script>
    <![endif]-->
    <link rel="stylesheet" href="admin-panel/plugins/tagsinput/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="admin-panel/plugins/summernote/summernote.css">
    <link rel="stylesheet" href="admin-panel/plugins/bootstrap-slider/slider.css">
    <link rel="stylesheet" href="admin-panel/plugins/bootstrap-multiselect/bootstrap-multiselect.css">

    <link rel="stylesheet" href="admin-panel/css/admin-skins.css">
</head>
<?php $skin = $setUp->getConfig('admin_color_scheme') ? $setUp->getConfig('admin_color_scheme') : 'blue'; ?>
<body class="skin-<?php print $skin; ?> fixed sidebar-mini admin-body <?php echo $rtlclass; ?>"  data-target="#scrollspy" data-spy="scroll" data-offset="100">

    <div class="anchor" id="view-preferences"></div>
    <div class="wrapper">
        <header class="main-header">
            <a href="./" class="logo">
                <?php print $setUp->getConfig('appname'); ?>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle visible-xs" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo $setUp->getConfig('script_url'); ?>">
                                <i class="fa fa-home fa-fw"></i> 
                            </a>
                        </li>
                        <li>
                            <a href="../?logout" title="<?php echo $setUp->getString("log_out"); ?>">
                                <i class="fa fa-sign-out fa-fw"></i> 
                            </a>
                        </li>
                        <li class="dropdow">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-flag fa-fw"></i>
                                <?php // echo $setUp->getString("LANGUAGE_NAME"); ?>
                            </a>
                            <ul class="dropdown-menu lang-menu">
                                <?php print ($setUp->printLangMenu()); ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <?php require "admin-panel/view/sidebar.php"; ?>
        <div class="content-wrapper">
            <?php echo $admin->printAlert(); ?>
            <?php
            switch ($get_section) {

            case 'users':
                if (GateKeeper::canSuperAdmin('superadmin_can_users')) { ?>
                    <div class="content-header">
                        <h3><i class="fa fa-users"></i> 
                            <?php print $setUp->getString("users"); ?>
                        </h3>
                    </div>
                    <div class="content body">
                        <div class="row">
                            <?php
                            include "admin-panel/view/users/new-user.php";
                            if (GateKeeper::isMasterAdmin()) {
                                include "admin-panel/view/users/master-admin.php";
                            }
                            ?>
                        </div>
                        <?php
                        include "admin-panel/view/users/list-users.php";
                        include "admin-panel/view/users/modal-user.php";
                        ?>
                    </div>
                    <?php
                }
                break;

            case 'appearance':
                if (GateKeeper::canSuperAdmin('superadmin_can_appearance')) { ?>
                    <div class="content-header">
                        <h3><i class="fa fa-paint-brush"></i>
                        <?php print $setUp->getString("appearance"); ?>
                        </h3>
                    </div>
                    <div class="content">
                        <form role="form" method="post" id="settings-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=appearance" enctype="multipart/form-data">
                        <?php
                        include "admin-panel/view/appearance/appearance.php";
                        ?>
                            <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-lg btn-block clear">
                                            <i class="fa fa-refresh"></i> 
                                            <?php print $setUp->getString("save_settings"); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="fixed-label">
                                <button type="submit" class="btn btn-default" title="<?php echo $setUp->getString("save_settings"); ?>">
                                    <i class="fa fa-save"></i> 
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                break;

            case 'translations':
                if (GateKeeper::canSuperAdmin('superadmin_can_translations')) { ?>

                    <div class="content-header">
                        <h3>
                            <i class="fa fa-language"></i> 
                            <?php print $setUp->getString("language_manager"); ?>
                        </h3>
                    </div>
                    <div class="content">
                    <?php
                    if ($get_action == 'edit') {
                        if ($editlang || ($postnewlang && strlen($postnewlang) == 2 && !array_key_exists($postnewlang, $translations))) {
                            include "admin-panel/view/language/edit.php";
                        }
                    } else {
                        include "admin-panel/view/language/panel.php";
                    } 
                    ?>
                    </div>
                    <?php
                }
                break;

            case 'logs':
                if (GateKeeper::canSuperAdmin('superadmin_can_statistics')) { ?>
                    <div class="content-header">
                        <h3><i class="fa fa-pie-chart"></i>
                        <?php print $setUp->getString("statistics"); ?>
                        </h3>
                    </div>
                    <div class="content">
                        <?php
                        include "admin-panel/view/analytics/selector.php";
                        include "admin-panel/view/analytics/charts.php";
                        include "admin-panel/view/analytics/table.php";
                        include "admin-panel/view/analytics/range.php";
                        include "admin-panel/view/analytics/loader.php";
                        ?>
                    </div>
                    <?php
                }
                break;

            default:
                if (GateKeeper::canSuperAdmin('superadmin_can_preferences')) { ?>
                <div class="content-header">
                    <h3><i class="fa fa-tachometer"></i> 
                        <?php print $setUp->getString("preferences"); ?>
                    </h3>
                </div>
                <div class="content">
                    <form role="form" method="post" id="settings-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
                        <?php
                        include "admin-panel/view/dashboard/general.php"; 
                        include "admin-panel/view/dashboard/uploads.php"; 
                        include "admin-panel/view/dashboard/lists.php"; 
                        include "admin-panel/view/dashboard/permissions.php";
                        include "admin-panel/view/dashboard/registration.php"; 
                        include "admin-panel/view/dashboard/share.php"; 
                        include "admin-panel/view/dashboard/email.php";
                        include "admin-panel/view/dashboard/security.php"; 
                        include "admin-panel/view/dashboard/activities.php";
                        include "admin-panel/view/dashboard/admin-color-scheme.php"; 
                        ?>
                        <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-lg btn-block clear">
                                        <i class="fa fa-refresh"></i> 
                                        <?php print $setUp->getString("save_settings"); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">       
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="debug_mode" 
                                    <?php
                                    if ($setUp->getConfig('debug_mode') === true) {
                                        echo "checked";
                                    } ?>>
                                    <i class="fa fa-wrench"></i> DEBUG MODE 
                                        <a title="Display all PHP notices" class="tooltipper" data-placement="right" href="javascript:void(0)">
                                            <i class="fa fa-question-circle"></i>
                                        </a>
                                </label>
                            </div>
                        </div>
                        <div class="fixed-label hidden">
                            <button type="submit" class="btn btn-default" title="<?php echo $setUp->getString("save_settings"); ?>">
                                <i class="fa fa-save"></i> 
                            </button>
                        </div>
                    </form>
                </div> <!-- content -->
                    <?php
                } else { 
                    $username = GateKeeper::getUserInfo('name');
                    ?>
                <div class="content">
                    <h2>
                        <?php echo GateKeeper::getAvatar($username, '').' <a href="'.$setUp->getConfig('script_url').'">'.$username.'</a>'; ?>
                    </h2>
                </div>
                    <?php
                }
                break;
            } ?>
        <br>
        <br>
        <br>
    </div> <!-- content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right">
            <a href="https://filemanager.veno.it/" target="_blank" title="Current version">
                <i class="vfmi vfmi-mark"></i> 
                <small> <?php echo $vfm_version; ?></small>
            </a>
        </div>
        <a href="<?php echo $setUp->getConfig('script_url'); ?>"><strong><?php echo $setUp->getConfig('appname'); ?></strong></a> &copy; <?php echo date('Y'); ?>
    </footer>
    <script type="text/javascript" src="js/bootstrap.min.js?v=3.3.7"></script>
    <script type="text/javascript" src="js/avatars.js?v=<?php echo $vfm_version; ?>"></script>
    <script type="text/javascript" src="js/datatables.min.js?v=1.10.16"></script>

    <script src="admin-panel/js/app.min.js?v=<?php echo $vfm_version; ?>"></script>
    <script src="admin-panel/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="admin-panel/plugins/summernote/summernote.min.js"></script>
    <script src="admin-panel/plugins/tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="admin-panel/plugins/datepicker/jquery-ui.min.js"></script>
    <script src="admin-panel/plugins/bootstrap-slider/bootstrap-slider.js"></script>
    <script src="admin-panel/plugins/bootstrap-multiselect/bootstrap-multiselect.min.js"></script>

    <?php if ($lang !== 'en') { ?>
    <script src="admin-panel/plugins/datepicker/i18n/datepicker-<?php echo $lang; ?>.js"></script>
    <?php }?>

    <?php $debug = $setUp->getConfig("debug_mode") ? '' : 'min.'; ?>
    <script type="text/javascript" src="admin-panel/js/admin.<?php echo $debug; ?>js?v=<?php echo $vfm_version; ?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            /**
            * start pretty multiselect for user folders
            */  
            multiselectWithOptions(' <?php echo $setUp->getString("select_all"); ?>','<?php echo $setUp->getString("selected_files"); ?>', '<?php echo $setUp->getString("available_folders"); ?>');
            /**
            * update default folders for self registered users
            */ 
            var regdata = [];
            var regfolders = $(".s-reguserfolders");
            regfolders.each(function(){
                regdata.push($(this).val());
            });
            $("#r-reguserfolders").val(regdata);
            $(".assignfolder").multiselect('refresh');
        });
    </script>
</body>
</html>