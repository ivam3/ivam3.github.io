<?php
/**
 * VFM - veno file manager: include/list-files.php
 * list files inside current directory
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
* List Files
*/
if ($gateKeeper->isAccessAllowed() && $location->editAllowed()) { 

    if ($gateKeeper->isAllowed('view_enable')) {

        $listview = isset($_SESSION['listview']) ? $_SESSION['listview'] : $setUp->getConfig('list_view', 'list');
        if ($listview == 'grid') {
            $listclass = 'gridview';
            $switchclass = 'grid';
        } else {
            $listclass = 'listview';
            $switchclass = 'list';
        } ?>
    <div class="vfmblock">
    <section class="tableblock ghost ghost-hidden">

        <div class="action-group">

        <?php

        if ($gateKeeper->isAllowed('download_enable')
            || $gateKeeper->isAllowed('move_enable')
            || $gateKeeper->isAllowed('copy_enable')
            || $gateKeeper->isAllowed('delete_enable')
        ) {
            ?>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle groupact" data-toggle="dropdown">
                    <i class="fa fa-cog"></i> 
                    <?php echo $setUp->getString("group_actions"); ?> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                <?php
                if ($gateKeeper->isAllowed('download_enable')) { ?>
                    <li>
                        <a class="multid" href="#">
                            <i class="fa fa-cloud-download"></i> 
                            <?php echo $setUp->getString("download"); ?>
                        </a>
                    </li>
                    <?php
                }
                if ($gateKeeper->isAllowed('move_enable')) { ?>
                    <li>
                        <a class="multimove" href="#" data-toggle="modal" data-target="#archive-map-move" data-action="move">
                            <i class="fa fa-arrow-right"></i> 
                            <?php echo $setUp->getString("move"); ?>
                        </a>
                    </li>
                    <?php
                }
                if ($gateKeeper->isAllowed('copy_enable')) { ?>
                   <li>
                        <a class="multicopy" href="#" data-toggle="modal" data-target="#archive-map-copy" data-action="copy">
                            <i class="fa fa-files-o"></i> 
                            <?php echo $setUp->getString("copy"); ?>
                        </a>
                    </li>
                    <?php
                }
                if ($gateKeeper->isAllowed('delete_enable')) { ?>
                    <li><a class="multic" href="#">
                            <i class="fa fa-trash-o"></i> 
                            <?php echo $setUp->getString("delete"); ?>
                        </a>
                    </li>
                    <?php
                } ?>
                </ul>
            </div> <!-- .btn-group -->
            <?php
            if ($gateKeeper->isAllowed('sendfiles_enable') && $gateKeeper->isAllowed('download_enable') ) { ?>
            <button class="btn btn-default manda">
                <i class="fa fa-paper-plane"></i> 
                <?php echo $setUp->getString("share"); ?>
            </button>
                <?php
            } ?>
            <?php
        }
        ?>
            <div class="switchview pull-right <?php echo $switchclass; ?>" title="<?php echo $setUp->getString("view"); ?>"></div>
        </div> <!-- .action-group -->

        <form id="tableform">
            <table id="filetable" class="table <?php echo $listclass; ?>" width="100%" cellspacing="0">
                <thead>
                    <tr class="rowa one">
                        <td class="text-center">
                            <a href="#" title="<?php echo $setUp->getString("select_all"); ?>" id="selectall">
                                <i class="fa fa-check fa-lg"></i>
                            </a>
                        </td>
                        <td class="icon"></td>
                        <td class="mini h-filename">
                            <span class="visible-xs sorta nowrap">
                                <i class="fa fa-sort-alpha-asc"></i>
                            </span>
                            <span class="hidden-xs sorta nowrap">
                                <?php echo $setUp->getString("file_name"); ?>
                            </span>
                        </td>
                        <td class="taglia reduce mini h-filesize hidden-xs">
                            <span class="text-center sorta nowrap">
                                <?php echo $setUp->getString("size"); ?>
                            </span>
                        </td>
                        <td class="reduce mini h-filedate hidden-xs">
                            <span class="text-center sorta nowrap">
                                <?php echo $setUp->getString("last_changed"); ?>
                            </span>
                        </td>
                    <?php
                    if ($gateKeeper->isAllowed('rename_enable')) { ?>
                        <td class="mini text-center gridview-hidden hidden-xs">
                            <i class="fa fa-pencil"></i>
                        </td>
                        <?php
                    } ?>
                    <td class="mini text-center gridview-hidden">
                    <?php 
                    if ($gateKeeper->isAllowed('delete_enable')) {  ?>
                        <i class="fa fa-trash-o hidden-xs"></i>
                        <?php
                    } ?>
                     </td>
                    </tr>
                </thead>
                <tbody class="gridbody"></tbody>
            </table>
        </form>
    </section>
    <div class="cta overload"><i class="fa fa-circle-o-notch fa-lg fa-spin"></i></div>

    </div>
        <?php
    }
    ?>
    <section class="vfmblock tableblock text-center lead hidetable hidden">
        <span class="fa-stack fa-4x alpha-light">
            <i class="fa fa-circle-thin fa-stack-2x"></i>
            <?php
            // show upload or empty folder icon
            if ($gateKeeper->isAllowed('upload_enable')) { 
                echo '<i class="fa fa-cloud-upload fa-stack-1x" id="biguploader"></i>';
            } else {
                echo '<i class="fa fa-folder-open fa-stack-1x"></i>';
            } ?>
        </span>
    </section>
    <?php
} // end access allowed
