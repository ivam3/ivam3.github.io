<?php
/**
 * VFM - veno file manager: include/uploadarea.php
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
* UPLOAD AREA
*/
if ($location->editAllowed() 
    && ($gateKeeper->isAllowed('upload_enable') || $gateKeeper->isAllowed('newdir_enable'))
) { ?>
    <section class="vfmblock uploadarea">
    <?php
    $post_url = Utils::removeQS($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], array('response'));
    /**
    * Upload files
    */
    if ($gateKeeper->isAllowed('upload_enable')) { 

        if ($gateKeeper->isAllowed('newdir_enable')) { 
            $upload_class = "span-6";
        } else {
            $upload_class = "intero";
        } ?>
        <form enctype="multipart/form-data" method="post" id="upForm" action="<?php echo htmlspecialchars($post_url);?>">
            <input type="hidden" name="location" value="<?php echo $location->getDir(true, false, false, 0); ?>">       
            <div id="upload_container" class="input-group pull-left <?php echo $upload_class; ?>">
                <span class="input-group-addon ie_hidden">
                    <i class="fa fa-files-o fa-fw"></i>
                </span>
                <span class="input-group-btn" id="upload_file">
                    <span class="upfile btn btn-primary btn-file">
                        <i class="fa fa-files-o fa-fw"></i>
                        <input name="userfile[]" type="file" class="upload_file" multiple />
                    </span>
                </span>
                <input class="form-control" type="text" readonly name="fileToUpload" id="fileToUpload" placeholder="<?php echo $setUp->getString("browse"); ?>">
                <span class="input-group-btn">
                    <button class="upload_sumbit btn btn-primary" type="submit" id="upformsubmit" disabled>
                        <i class="fa fa-upload fa-fw"></i>
                    </button>
                    <a href="javascript:void(0)" class="btn btn-primary" id="upchunk">
                        <i class="fa fa-upload fa-fw"></i>
                    </a>
                </span>
            </div>
        </form>
        <script type="text/javascript" src="vfm-admin/js/uploaders.js?v=<?php echo $vfm_version; ?>"></script>
        <?php
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $android = (stripos($useragent, 'android') !== false ? 'yes' : 'no');
        $singleprogress = ($setUp->getConfig('single_progress') ? true : 0);
        ?>
        <script type="text/javascript">
        $(document).ready(function(){
            resumableJsSetup(
                "<?php echo $android; ?>", 
                "<?php echo urlencode($location->getFullPath()); ?>&logloc=<?php echo urlencode($location->getDir(true, false, false, 0)); ?>", 
                "<?php echo $setUp->getString('browse'); ?>",
                <?php echo $singleprogress; ?>,
                <?php echo $setUp->getChunkSize(); ?>
            );
        });
        </script>
        <?php
    }
    /**
    * Create directory
    */
    if ($gateKeeper->isAllowed('newdir_enable')) { 
        if ($gateKeeper->isAllowed('upload_enable')) { 
            $newdir_class = "span-6";
        } else {
            $newdir_class = "intero";
        } ?>
        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($post_url);?>">
            <div id="newdir_container" class="input-group pull-right <?php echo $newdir_class; ?>">
                <span class="input-group-addon"><i class="fa fa-folder-open-o fa-fw"></i></span>
                <input name="userdir" type="text" class="upload_dirname form-control" 
                placeholder="<?php echo $setUp->getString("make_directory"); ?>" />
                <span class="input-group-btn">
                    <button class="btn btn-primary upfolder" type="submit">
                        <i class="fa fa-plus fa-fw"></i>
                    </button>
                    <div class="upfolder-over"></div>
                </span>
            </div>
        </form>
        <?php
    }

    if ($gateKeeper->isAllowed('upload_enable')
        && strlen($setUp->getConfig('preloader')) > 0
    ) {
        // upload progress bar
        $percentage_class = $setUp->getConfig('show_percentage') ? ' fullp' : ''; ?>
        <div class="intero<?php echo $percentage_class;?>">
            <div class="progress progress-striped active" id="progress-up">
                <div class="upbar progress-bar <?php echo $setUp->getConfig('progress_color'); ?>" 
                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <p class="pull-left propercent"></p>
                </div>
            </div>
        <?php
        // second progress bar for individual files
        if ($setUp->getConfig('single_progress')) { ?>
            <div class="progress progress-single" id="progress-up-single">
                <div class="upbarfile progress-bar <?php echo $setUp->getConfig('progress_color'); ?>" 
                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <p class="pull-left propercent"></p>
                </div>
            </div>
            <?php
        } ?>
        </div>
        <?php
    } ?>
    </section>
    <?php
}
