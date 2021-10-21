<?php
/**
* ACTIVITIES
**/
?>
<div id="view-activities" class="anchor"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-bar-chart"></i> 
                <?php echo $setUp->getString("activity_register"); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number"><?php echo $setUp->getString("statistics"); ?></span>
                                <div class="progress"></div>
                                <span class="progress-description">
                                    <div class="checkbox">
                                        <label>
                                        <input type="checkbox" name="log_file" class="checkstats"
                                            <?php
                                            if ($setUp->getConfig('log_file') === true) {
                                                echo "checked";
                                            } ?>><?php echo $setUp->getString("enabled"); ?>
                                        </label>
                                    </div>
                                </span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->   
                    </div> <!-- col 4 -->

                    <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>
                                        <i class="fa fa-envelope"></i> 
                                        <?php echo $setUp->getString("email_notifications"); ?>
                                    </label>
                                    <input type="text" placeholder="admin1@mail.ext, admin2@ma..." class="form-control" name="upload_email" value="<?php echo $setUp->getConfig('upload_email'); ?>">
                                </div>

                                <div class="col-sm-6">
                                    <label><?php echo $setUp->getString("select_notification"); ?>:</label><br>
                                        <input class="checkbox" id="notify_login" type="checkbox" name="notify_login"
                                        <?php 
                                        if ($setUp->getConfig('notify_login')) {
                                                echo "checked";
                                        } ?>><label for="notify_login" data-toggle="tooltip" class="tooltipper" data-placement="top" 
                                        title="<?php echo $setUp->getString("notify_login"); ?>">
                                        <i class="fa fa-sign-in"></i>
                                    </label>

                                    <input class="checkbox" id="notify_upload" type="checkbox" name="notify_upload" 
                                        <?php
                                        if ($setUp->getConfig('notify_upload')) {
                                                echo "checked";
                                        } ?>><label for="notify_upload" data-toggle="tooltip" class="tooltipper" data-placement="top" 
                                        title="<?php echo $setUp->getString("notify_upload"); ?>">
                                        <i class="fa fa-upload"></i>
                                    </label>                    
                                    
                                    <input class="checkbox" id="notify_download" type="checkbox" name="notify_download" 
                                        <?php
                                        if ($setUp->getConfig('notify_download')) {
                                                echo "checked";
                                        } ?>><label for="notify_download" data-toggle="tooltip" class="tooltipper" data-placement="top" 
                                        title="<?php echo $setUp->getString("notify_download"); ?>">
                                        <i class="fa fa-download"></i>
                                    </label>
                                    
                                    <input class="checkbox" id="notify_newfolder" type="checkbox" name="notify_newfolder" 
                                        <?php
                                        if ($setUp->getConfig('notify_newfolder')) {
                                                echo "checked";
                                        } ?>><label for="notify_newfolder" data-toggle="tooltip" class="tooltipper" data-placement="top" 
                                        title="<?php echo $setUp->getString("notify_newfolder"); ?>">
                                        <i class="fa fa-folder-o"></i>
                                    </label>

                                    <input class="checkbox" id="notify_registration" type="checkbox" name="notify_registration" 
                                        <?php
                                        if ($setUp->getConfig('notify_registration')) {
                                                echo "checked";
                                        } ?>><label for="notify_registration" data-toggle="tooltip" class="tooltipper" data-placement="top" 
                                        title="<?php echo $setUp->getString("notify_registration"); ?>">
                                        <i class="fa fa-user-plus"></i>
                                    </label>

                                </div> <!-- col sm 6 -->
                            </div> <!-- row -->
                            <span class="help-block">
                                <?php echo $setUp->getString("set_email_to_receive_notifications"); ?>
                            </span>
                    </div><!-- col md 7 -->
                </div><!-- row -->
            </div><!-- box-body -->
        </div><!-- box -->
    </div><!-- col 12 -->
</div><!-- row -->
