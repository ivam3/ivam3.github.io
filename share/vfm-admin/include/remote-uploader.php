 <?php
/**
 * VFM - veno file manager: include/remote-uploader.php
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
    /**
    * Upload from url
    */
if ($location->editAllowed()
    && $gateKeeper->isAllowed('upload_enable')
    && $setUp->getConfig('remote_uploader')
    && $setUp->getConfig('remote_extensions')
) { 

// $list_extensions = $setUp->getConfig('remote_extensions') ? implode(', ', $fruit);
    ?>
    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#upload_from_url">
        <i class="fa fa-globe"></i>  <?php echo $setUp->getString("remote_upload"); ?>
    </button>
        <div class="modal fade" id="upload_from_url" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-globe"></i> <?php echo $setUp->getString("enter_the_url_to_download"); ?></h5>
                        <button class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="remote_uploader">
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <input class="form-control" type="url" name="get_upload_url" placeholder="http://">
                                    <input type="hidden" name="get_location" value="<?php echo $location->getDir(false, false, false, 0); ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary send_remote_upload_url" type="submit"><i class="fa fa-download"></i></button>
                                    </span>
                                </div>
                            </div>
                             <p class="text-left"><?php echo $setUp->getString("allowed_ext"); ?>: 
                                <span class="badge">
                                    <?php echo implode('</span> <span class="badge">', $setUp->getConfig('remote_extensions')) ?>
                                </span>
                            </p>
                        </form>
                        <div class="modal_response text-center">
                            <div class="modal-body zipicon hidden">
                                <i class="fa fa-folder-open-o fa-5x"></i>
                                <span class="ziparrow"><i class="fa fa-angle-double-left fa-3x fa-fw passing-animated-reverse"></i></span>
                                <i class="fa fa-file-o fa-5x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php  
}
