<?php
/**
 * VFM - veno file manager: include/breadcrumbs.php
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
/**
* BreadCrumbs
*/
if ($gateKeeper->isAccessAllowed()
) { ?>
    <ol class="breadcrumb">
    <?php
    if ($setUp->getConfig("show_path") !== true) { 
        $cleandir = "?dir=".substr($setUp->getConfig('starting_dir').$gateKeeper->getUserInfo('dir'), 2);
        $stolink = $location->makeLink(false, null, $location->getDir(false, true, false, 1));
        $stodeeplink = $location->makeLink(false, null, $location->getDir(false, true, false, 0));

        if (strlen($stolink) > strlen($cleandir)) {
                $parentlink = $location->makeLink(false, null, $location->getDir(false, true, false, 1));
        } else {
                $parentlink = "?dir=";
        }
        if (strlen($stodeeplink) > strlen($cleandir)
        ) { ?>
        <li class="noli">
            <a href="<?php echo $parentlink; ?>">
                <i class="fa fa-angle-left"></i> <i class="fa fa-folder-open"></i>
            </a>
        </li>
            <?php
        }
    }

    if ($setUp->getConfig("show_foldertree") == true && $gateKeeper->isAllowed('viewdirs_enable')) { ?>
        <li class="noli">
            <a href="#" data-toggle="modal" data-target="#archive-map" data-action="breadcrumbs">
                <i class="fa fa-sitemap"></i> 
            </a>
        </li>
        <?php
    } 
    
    if ($setUp->getConfig("show_path") == true) { 
        if (strlen($setUp->getConfig('starting_dir')) < 3 ) {
            ?>
        <li class="noli">
            <a href="?dir=">
                <i class="fa fa-folder-open"></i> <?php echo $setUp->getString("root"); ?>
            </a>
        </li>
            <?php
        }
        $totdirs = count($location->path);
        foreach ($location->path as $key => $dir) {
                $stolink = $location->makeLink(false, null, $location->getDir(false, true, false, $totdirs -1 - $key)); ?>
                <li><a href="<?php echo $stolink; ?>">
                    <i class="fa fa-folder-open-o"></i> 
                    <?php echo urldecode($location->getPathLink($key, false)); ?>
                </a></li>
            <?php
        } 
    } ?>
    </ol>
<?php
}
