<?php
/**
 * ROLE PERMISSIONS
 */

$rolename = $setUp->getString("role_guest");
$rolekey = '_guest';
?>
<div id="view-permissions" class="anchor"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-balance-scale"></i> <?php echo $setUp->getString('permissions'); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <h4><?php echo $rolename; ?></h4>
                <div class="row toggle-reverse-next">
                    <div class="col-sm-6">
                        <div class="form-group bg-warning py-2">
                            <div class="checkbox checkbox-bigger clear">
                                <label>
                                    <input type="checkbox" name="require_login" 
                                    <?php
                                    if ($setUp->getConfig('require_login')) {
                                        echo "checked";
                                    } ?>>
                                    <i class="fa fa-lock fa-fw"></i> 
                                    <?php print $setUp->getString("require_login"); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reverse-toggle-target">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="toggle">
                                <div class="checkbox checkbox-big toggle">
                                    <label>
                                        <input type="checkbox" name="view_enable<?php echo $rolekey; ?>" 
                                        <?php
                                        if ($setUp->getConfig('view_enable'.$rolekey)) {
                                            echo "checked";
                                        } ?>> 
                                            <span class="fa-stack">
                                              <i class="fa fa-file-o fa-stack-2x"></i>
                                              <i class="fa fa-eye fa-stack-1x"></i>
                                            </span>
                                        <?php print $setUp->getString("view_files"); ?>
                                    </label>
                                </div>
                            </div>
                            <div class="toggleme">
                                <div class="checkbox checkbox-big toggle">
                                    <label>
                                        <input type="checkbox" name="download_enable<?php echo $rolekey; ?>" 
                                        <?php
                                        if ($setUp->getConfig('download_enable'.$rolekey)) {
                                            echo "checked";
                                        } ?>> 
                                            <span class="fa-stack">
                                              <i class="fa fa-file-o fa-stack-2x"></i>
                                              <i class="fa fa-download fa-stack-1x"></i>
                                            </span>
                                        <?php print $setUp->getString("download_files"); ?>
                                    </label>
                                </div>

                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="sendfiles_enable<?php echo $rolekey; ?>" 
                                        <?php
                                        if ($setUp->getConfig('sendfiles_enable'.$rolekey)) {
                                            echo "checked";
                                        } ?>> 
                                            <span class="fa-stack">
                                              <i class="fa fa-file-o fa-stack-2x"></i>
                                              <i class="fa fa-paper-plane-o fa-stack-1x"></i>
                                            </span>
                                        <?php print $setUp->getString("share_files"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="viewdirs_enable<?php echo $rolekey; ?>" 
                                    <?php
                                    if ($setUp->getConfig('viewdirs_enable'.$rolekey)) {
                                        echo "checked";
                                    } ?>> 
                                        <span class="fa-stack">
                                          <i class="fa fa-folder fa-stack-2x"></i>
                                          <i class="fa fa-eye fa-stack-1x fa-inverse"></i>
                                        </span>
                                    <?php print $setUp->getString("view_folders"); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            <hr>
            <?php

            $allroles = array(
                'user' => $setUp->getString("role_user"),
            );
            require dirname(dirname(__FILE__)).'/users/roles.php';

            if (is_array($getroles)) {
                foreach ($getroles as $role) {
                    $allroles[$role] = $setUp->getString("role_".$role);
                }
            }
            $allroles['admin'] = $setUp->getString("role_admin");

            foreach ($allroles as $key => $rolename) {
                $rolekey = $key == 'admin' ? '' : '_'.$key;
                ?>
                <h4><?php echo $rolename; ?></h4>
                <div class="row">
                    <div class="col-sm-6">
                <?php
                if ($key == 'user') {
                    ?>
                    <div class="toggle">
                        <div class="checkbox checkbox-big toggle">
                            <label>
                                <input type="checkbox" name="view_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('view_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-eye fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("view_files"); ?>
                            </label>
                        </div>
                    </div>
                    <div class="toggleme">
                        <div class="checkbox checkbox-big toggle">
                            <label>
                                <input type="checkbox" name="download_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('download_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-download fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("download_files"); ?>
                            </label>
                        </div>
                        <div class="checkbox checkbox-big">
                            <label>
                                <input type="checkbox" name="sendfiles_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('sendfiles_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-paper-plane-o fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("share_files"); ?>
                            </label>
                        </div>
                    </div>
                    <?php
                } // End user perms
                ?>
                <?php
                if ($key !== 'user') {
                    ?>
                        <div class="checkbox checkbox-big">
                            <label>
                                <input type="checkbox" name="sendfiles_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('sendfiles_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-paper-plane-o fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("share_files"); ?>
                            </label>
                        </div>
                    <?php
                } // End user perms
                ?>
                        <div class="checkbox checkbox-big">
                            <label>
                                <input type="checkbox" name="upload_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('upload_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-upload fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("upload_files"); ?>
                            </label>
                        </div>
                <?php
                if ($key !== 'user') {
                    ?>
                        <div class="checkbox checkbox-big">
                            <label>
                                <input type="checkbox" name="delete_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('delete_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-trash fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("delete_files"); ?>
                            </label>
                        </div>

                        <div class="checkbox checkbox-big">
                            <label>
                                <input type="checkbox" name="rename_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('rename_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-pencil-square-o fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("rename_files"); ?>
                            </label>
                        </div>

                        <div class="checkbox checkbox-big">
                            <label>
                                <input type="checkbox" name="move_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('move_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-arrow-right fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("move_files"); ?>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="copy_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('copy_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-file-o fa-stack-2x"></i>
                                      <i class="fa fa-files-o fa-stack-1x"></i>
                                    </span>
                                <?php print $setUp->getString("copy_files"); ?>
                            </label>
                        </div>
                    <?php
                } ?>
                    </div>

                    <div class="col-sm-6">
                <?php
                if ($key == 'user') {
                    ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="viewdirs_enable_user" 
                                <?php
                                if ($setUp->getConfig('viewdirs_enable_user')) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-folder fa-stack-2x"></i>
                                      <i class="fa fa-eye fa-stack-1x fa-inverse"></i>
                                    </span>
                                <?php print $setUp->getString("view_folders"); ?>
                            </label>
                        </div>
                    <?php
                } ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="newdir_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('newdir_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-folder fa-stack-2x"></i>
                                      <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                    </span>
                                <?php print $setUp->getString("create_new_folders"); ?>
                            </label>
                        </div>
                <?php
                if ($key !== 'user') {
                    ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="delete_dir_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('delete_dir_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-folder fa-stack-2x"></i>
                                      <i class="fa fa-trash fa-stack-1x fa-inverse"></i>
                                    </span>
                                <?php print $setUp->getString("delete_folders"); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="rename_dir_enable<?php echo $rolekey; ?>" 
                                <?php
                                if ($setUp->getConfig('rename_dir_enable'.$rolekey)) {
                                    echo "checked";
                                } ?>> 
                                    <span class="fa-stack">
                                      <i class="fa fa-folder fa-stack-2x"></i>
                                      <i class="fa fa-pencil-square-o fa-stack-1x fa-inverse"></i>
                                    </span>
                                <?php print $setUp->getString("rename_folders"); ?>
                            </label>
                        </div>
                    <?php
                } ?>

                    </div>
                </div>

                <hr>
                <?php
            }

            if (GateKeeper::isMasterAdmin()) { ?>
                <h4><?php echo $setUp->getString("role_superadmin"); ?></h4>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="superadmin_can_preferences" 
                                    <?php
                                    if ($setUp->getConfig('superadmin_can_preferences')) {
                                        echo "checked";
                                    } ?>><i class="fa fa-dashboard fa-lg"></i>
                                    <?php print $setUp->getString("preferences"); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="superadmin_can_users" 
                                    <?php
                                    if ($setUp->getConfig('superadmin_can_users')) {
                                        echo "checked";
                                    } ?>><i class="fa fa-users fa-lg"></i>
                                    <?php print $setUp->getString("users"); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="superadmin_can_appearance" 
                                    <?php
                                    if ($setUp->getConfig('superadmin_can_appearance')) {
                                        echo "checked";
                                    } ?>><i class="fa fa-paint-brush fa-lg"></i>
                                    <?php print $setUp->getString("appearance"); ?>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="superadmin_can_translations" 
                                    <?php
                                    if ($setUp->getConfig('superadmin_can_translations')) {
                                        echo "checked";
                                    } ?>><i class="fa fa-language fa-lg"></i>
                                    <?php print $setUp->getString("translations"); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="superadmin_can_statistics" 
                                    <?php
                                    if ($setUp->getConfig('superadmin_can_statistics')) {
                                        echo "checked";
                                    } ?>><i class="fa fa-pie-chart fa-lg"></i>
                                    <?php print $setUp->getString("statistics"); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div> <!-- box-body -->
        </div> <!-- box -->
    </div>
</div>
