<?php
/**
 * VFM - veno file manager: include/header.php
 * site header: top banner, description
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

$admin_login = ($parentfile === 'login.php' ? true : false);
$logoAlignment = $setUp->getConfig('align_logo');
$logo_margin = ' style="margin-bottom:'.$setUp->getConfig('logo_margin', 0).'px;"';
$header_padding = ' style="padding:'.$setUp->getConfig('header_padding', 0).'px 0;"';

$fulldesc = $setUp->getDescription();
$banner_width = $setUp->getConfig("banner_width", 'wide');
$setwide = ($banner_width == 'boxed') ? 'container' : '';
?>

            <header class="vfm-header"<?php echo $header_padding; ?>>
            <?php
            /**
             * ************************************************
             * ******************* Top Banner *****************
             * ************************************************
             */
            if ($setUp->getConfig('logo')) {

                if ($admin_login == true) { 
                    $logopath = "_content/uploads/";
                } else {
                    $logopath = "vfm-admin/_content/uploads/";
                }
                ?>
                <div class="<?php echo $setwide; ?>">
                <div class="head-banner text-<?php echo $logoAlignment; ?>">
                    <a href="<?php echo $setUp->getConfig("script_url"); ?>">
                        <img alt="<?php echo $setUp->getConfig('appname'); ?>" src="<?php print $logopath.$setUp->getConfig('logo'); ?>"<?php echo $logo_margin; ?>>
                    </a>
                </div>
                </div>
                <?php
            }
            /**
             * ************************************************
             * ****************** Description *****************
             * ************************************************
             */
            if ($gateKeeper->isAccessAllowed() 
                && !$getdownloadlist 
                && $admin_login == false
                && $fulldesc
            ) { ?>
                <div class="container">                      
                    <div class="description lead"><?php echo $fulldesc; ?></div> 
                </div> <!-- .container -->
                <?php
            } ?>
            </header>