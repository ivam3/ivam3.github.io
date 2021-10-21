<?php
/**
 * UPLOADS
 */
?>
<div class="anchor" id="view-uploads"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cloud-upload"></i> <?php print $setUp->getString("upload"); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-folder-open"></i> 
                                <?php print $setUp->getString("uploads_dir"); ?>
                            </label>
                            <?php
                            $cleandir = substr($setUp->getConfig('starting_dir'), 2);
                            $cleandir = substr_replace($cleandir, "", -1); ?>
                            <input type="text" class="form-control blockme" name="starting_dir" value="<?php echo $cleandir; ?>">
                            <p class="help-block"><code>download</code> <?php print $setUp->getString("is_reserved_for_pretty_links_rewriting"); ?>.</p>
                        </div>

                        <div class="radio checkbox-big toggle-extensions clear">
                            <label>
                                <input type="radio" name="selectivext" class="togglext" value="reject"
                                <?php if ($setUp->getConfig('selectivext') == "reject") echo " checked"; ?>>
                                <span class="togglabel"><?php print $setUp->getString("rejected_ext"); ?></span>
                            </label>
                        </div>

                        <div class="form-group">
                            <?php 
                            $upload_reject_extension = $setUp->getConfig('upload_reject_extension');
                            $rejectlist = $upload_reject_extension ? implode(",", $upload_reject_extension) : false; ?>
                            <input type="text" class="form-control taginput" name="upload_reject_extension" data-tag="danger" 
                            value="<?php echo $rejectlist; ?>" placeholder="php,ht...">
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="radio checkbox-big toggle-extensions clear">
                                    <label>
                                        <input type="radio" name="selectivext" class="togglext" value="allow" 
                                        <?php if ($setUp->getConfig('selectivext') == "allow") echo " checked"; ?>>
                                        <span class="togglabel"><?php print $setUp->getString("allowed_ext"); ?></span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <?php 
                                    $upload_allow_type = $setUp->getConfig('upload_allow_type');
                                    $allowlist = $upload_allow_type ? implode(",", $upload_allow_type) : false; ?>
                                    <input type="text" class="form-control taginput" name="upload_allow_type" data-tag="success" 
                                    value="<?php echo $allowlist; ?>" placeholder="jpg,gif,pn..">
                                </div>
                            </div>
                        </div>
                    </div> <!-- col-sm-6 -->

                    <div class="col-sm-6">

                        <div class="form-group">
                            <label><?php print $setUp->getString("maximum_upload_filesize"); ?></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="max_upload_filesize" value="<?php echo $setUp->getConfig('max_upload_filesize'); ?>">
                                <span class="input-group-addon">MB</span>
                            </div> 
                        </div>

                    <?php
                    if (!function_exists('curl_version')) { ?>
                        <p class="bg-warning">The Remote Uploader needs the <strong>PHP Curl</strong> extension enabled</p>
                        <?php
                    } else { 
                        $remotechecked = $setUp->getConfig('remote_uploader') ? 'checked' : '';
                        ?>
                        <div class="checkbox-big toggle-extensions clear">
                            <label>
                                <input type="checkbox" name="remote_uploader"  class="togglext" <?php echo $remotechecked; ?>>
                                <i class="fa fa-globe fa-lg fa-fw"></i> <?php echo $setUp->getString("remote_upload"); ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo $setUp->getString("allowed_ext"); ?>
                            </label>
                            <?php 
                            $remote_allow_type = $setUp->getConfig('remote_extensions');
                            $remote_allowlist = $remote_allow_type ? implode(",", $remote_allow_type) : false; ?>
                            <input type="text" class="form-control taginput" name="remote_extensions" data-tag="success" 
                            value="<?php echo $remote_allowlist; ?>" placeholder="jpg,gif,pn..">
                        </div>
                        <?php
                    } ?>

                    </div> <!-- col 6 -->


                </div> <!-- row -->
            </div> <!-- box-body -->

        </div> <!-- box -->
    </div> <!-- col-12 -->
</div> <!-- row -->
