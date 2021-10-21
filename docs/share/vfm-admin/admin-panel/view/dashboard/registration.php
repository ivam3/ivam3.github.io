<?php
/**
 * VFM - veno file manager: admin-panel/view/dashboard/registration.php
 * administration registration block
 *
 * @package VenoFileManager
 */

/**
* ROLE PERMISSIONS
**/
$regdirs = $setUp->getConfig('registration_user_folders');
if ($regdirs) {
    $regdirs = json_decode($regdirs, true);
    foreach ($regdirs as $dir) {
        echo " <input type=\"hidden\" value=\"".$dir."\" class=\"s-reguserfolders\">";
    }
} ?>
<div id="view-registration" class="anchor"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-user-plus"></i> <?php print $setUp->getString('registration'); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-aqua">
                            <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number"><?php print $setUp->getString("registration"); ?></span>
                                <div class="progress"></div>
                                <span class="progress-description">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="registration_enable" class="checkregs" 
                                            <?php
                                            if ($setUp->getConfig('registration_enable')) {
                                                echo "checked";
                                            } ?>> 
                                            <?php print $setUp->getString("enabled"); ?>
                                        </label>
                                    </div>
                                </span>
                            </div><!-- /.info-box-content -->
                        </div><!-- /.info-box -->   
                    </div>

                    <div class="col-md-4">
                        <label>
                            <?php print $setUp->getString("role"); ?>
                        </label>
                        <div class="form-group cooldropgroup">
                            <div class="input-group btn-group cooldrop">
                                <span class="input-group-addon">
                                    <i class="fa fa-check fa-fw"></i>
                                </span>
                                <select class="form-control coolselect" name="registration_role">
                                    <option value="user" 
                                    <?php
                                    if ($setUp->getConfig('registration_role') !== "admin") {
                                        echo "selected";
                                    } ?>>user</option>
                                    <option value="admin" 
                                    <?php
                                    if ($setUp->getConfig('registration_role') === "admin") {
                                        echo "selected";
                                    } ?>>admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php print $setUp->getString("keep_links"); ?></label>
                            <select class="form-control" name="registration_lifetime">
                            <?php 
                            $default_registration_lifetime = $setUp->getConfig('registration_lifetime', '-1 day');

                            foreach ($registration_lifetime as $key => $value) {
                                echo "<option ";
                                if ($default_registration_lifetime == $key) {
                                    echo "selected ";
                                }
                                echo "value=\"".$key."\">".$value."</option>";
                            } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group cooldropgroup">
                                    <label>
                                        <?php print $setUp->getString("user_folder"); ?>
                                    </label>
                                    <div class="input-group btn-group cooldrop">
                                        <span class="input-group-addon">
                                            <i class="fa fa-sitemap fa-fw"></i>
                                        </span>
                                        <select name="reguserfolders[]" id="r-reguserfolders" class="form-control assignfolder" multiple="multiple">
                                        <option value="vfm_reg_new_folder"><?php echo $setUp->getString("new_username_folder"); ?></option>
                                        <?php
                                        foreach ($admin->getFolders() as $folder) {
                                            echo '<option value="'.$folder.'">'.$folder.'</option>';
                                        } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group userquota cooldropgroup">
                                    <label><?php print $setUp->getString("available_space"); ?></label>
                                    <div class="input-group btn-group cooldrop">
                                        <span class="input-group-addon">
                                            <i class="fa fa-tachometer fa-fw"></i>
                                        </span>
                                        <select class="form-control coolselect" name="regquota">
                                            <option value=""><?php print $setUp->getString("unlimited"); ?></option>
                                            <?php
                                            foreach ($_QUOTA as $value) {
                                                $formatsize = $setUp->formatSize(($value*1024*1024));
                                                echo '<option value="'.$value.'"';
                                                if ($setUp->getConfig('registration_user_quota') == $value) {
                                                    echo ' selected';
                                                }
                                                echo '>'.$formatsize.'</option>';
                                            } ?>
                                        </select>
                                    </div> <!-- input-group -->
                                </div> <!-- userquota -->
                            </div> <!-- col-sm-12 -->
                        </div> <!-- row -->
                    </div> <!-- col-md-4 -->
                </div> <!-- row -->
            </div> <!-- box-body -->
        </div> <!-- box -->
    </div>
</div>