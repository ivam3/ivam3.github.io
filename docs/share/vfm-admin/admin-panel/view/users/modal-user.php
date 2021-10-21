<?php
/**
* MODAL USER PANEL
*/
?>          
<div class="modal fade" id="modaluser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user"></i> 
                    <span class="modalusername"></span>
                </h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" autocomplete="off" 
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=users&action=update" 
                enctype="multipart/form-data" class="removegroup">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>
                                <?php echo $setUp->getString("username"); ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user fa-fw"></i>
                                </span>
                                <input type="hidden" class="form-control getuser getuser-name" name="usernameold" id="r-usernameold" value="">
                                <input type="text" class="form-control deleteme getuser getuser-name" name="username" id="r-username" value="">
                            </div>
                        </div>
                        <?php
                        $allroles = array(
                            'user' => $setUp->getString("role_user"),
                        );
                        require dirname(__FILE__).'/roles.php';

                        if (is_array($getroles)) {
                            foreach ($getroles as $role) {
                                $allroles[$role] = $setUp->getString("role_".$role);
                            }
                        }
                        $allroles['admin'] = $setUp->getString("role_admin");
                        $allroles['superadmin'] = $setUp->getString("role_superadmin");
                        ?>
                        <div class="col-md-6 form-group cooldropgroup">
                            <label>
                                <?php echo $setUp->getString("role"); ?>
                            </label>
                            <div class="input-group btn-group cooldrop">
                                <span class="input-group-addon">
                                    <i class="fa fa-check fa-fw"></i>
                                </span>
                                <select class="form-control coolselect getuser getuser-role" name="role" id="r-role">
                                    <?php
                                    foreach ($allroles as $key => $role) {
                                        echo '<option value="'.$key.'">'.$role.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div> <!-- row -->

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>
                                <?php echo $setUp->getString("password"); ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock fa-fw"></i>
                                </span>
                                <input type="password" class="form-control" name="userpassnew" id="r-userpassnew"
                                placeholder="<?php print $setUp->getString("new_password"); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>
                                <?php echo $setUp->getString("email"); ?>
                            </label>
                            <input type="hidden" class="form-control getuser getuser-email" name="usermailold" id="r-usermailold" value="">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope fa-fw"></i>
                                </span>
                                <input type="email" class="form-control getuser getuser-email" 
                                name="usermail" id="r-usermail"
                                value="" 
                                placeholder="<?php print $setUp->getString("email"); ?>">
                            </div>
                        </div>
                    </div> <!-- row -->

                    <div class="row">
                        <div class="col-md-6 form-group cooldropgroup">
                            <label>
                                <?php print $setUp->getString("user_folder"); ?>
                            </label>
                            <?php
                            if (empty($availableFolders)) {
                                print "<fieldset disabled>";
                            } ?>
                            <div class="input-group btn-group cooldrop">
                                <span class="input-group-addon">
                                    <i class="fa fa-sitemap fa-fw"></i>
                                </span>
                                <select name="userfolders[]" id="r-userfolders" 
                                class="form-control assignfolder" multiple="multiple">
                                <?php
                                foreach ($admin->getFolders() as $folder) {
                                    print "<option value=\"".$folder."\"";
                                    print ">".$folder."</option>";
                                } ?>
                                </select>
                            </div>
                            <?php
                            if (empty($availableFolders)) {
                                print "</fieldset>";
                            } ?>
                        </div>

                        <div class="col-md-6">
                            <label><?php print $setUp->getString("make_directory"); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-folder fa-fw"></i>
                                </span>
                                <input type="text" class="form-control getfolder assignnew" 
                                name="userfolder" 
                                placeholder="<?php print $setUp->getString("add_new"); ?>">
                            </div>
                        </div> <!-- col-md-6 -->
                    </div> <!-- row -->

                    <div class="row" style="min-height:60px;">
                        <div class="col-md-6 userquota cooldropgroup">
                            <label><?php print $setUp->getString("available_space"); ?></label>

                            <div class="input-group btn-group cooldrop">
                                <span class="input-group-addon">
                                    <i class="fa fa-tachometer fa-fw"></i>
                                </span>

                                <select class="form-control coolselect getuser-quota" name="quota" id="r-quota">
                                    <option value=""><?php print $setUp->getString("unlimited"); ?></option>
                                    <?php
                                    foreach ($_QUOTA as $value) {
                                        $formatsize = $setUp->formatSize(($value*1024*1024));
                                        echo '<option value="'.$value.'">'.$formatsize.'</option>';
                                    } ?>
                                </select>
                            </div> <!-- input-group -->
                        </div> <!-- col-md-6 userquota -->
                    </div> <!-- row -->
                    <?php
                    /**
                    * Set additional custom fields
                    */
                    if (is_array($customfields)) { ?>
                        <div class="row">
                        <?php
                        foreach ($customfields as $customkey => $customfield) {
                            if (isset($customfield['type'])) { ?>
                            <div class="col-md-6 form-group">
                                <label><?php echo $customfield['name']; ?></label>
                                <?php
                                if ($customfield['type'] === 'textarea') { ?>
                                    <textarea name="<?php echo $customkey; ?>" class="form-control getuser getuser-<?php echo $customkey; ?>" rows="2"></textarea>
                                <?php
                                }
                                if ($customfield['type'] === 'select' && is_array($customfield['options'])) {
                                    $multiselect = '';
                                    if (isset($customfield['multiple']) && $customfield['multiple'] == true) {
                                         $multiselect = ($customfield['multiple'] == true ? 'multiple="multiple"' : '');
                                    } ?>
                                    <select name="<?php echo $customkey; ?>" class="form-control coolselect getuser getuser-<?php echo $customkey; ?>" <?php echo $multiselect; ?>>
                                    <?php
                                    foreach ($customfield['options'] as $optionval => $optiontitle) { ?>
                                        <option value="<?php echo $optionval; ?>"><?php echo $optiontitle; ?></option>
                                    <?php
                                    } ?>
                                    </select>
                                <?php
                                }
                                if ($customfield['type'] === 'text' || $customfield['type'] === 'email') { ?>
                                     <input type="<?php echo $customfield['type']; ?>" name="<?php echo $customkey; ?>" class="form-control getuser getuser-<?php echo $customkey; ?>">
                                <?php
                                } ?>
                            </div>
                            <?php
                            }
                        } ?>
                        </div> <!-- row -->
                    <?php
                    } ?>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="btn-group pull-right">
                                <button class="btn btn-info">
                                    <i class="fa fa-refresh"></i> 
                                    <small>
                                        <?php print $setUp->getString("update_profile"); ?>
                                    </small>
                                </button>

                                <button class="btn btn-danger remove">
                                    <i class="fa fa-trash-o"></i> 
                                    <small><?php print $setUp->getString("delete"); ?></small>
                                    <input type="hidden" name="delme" class="delme" value="">
                                </button>
                            </div><!-- btn-group -->
                        </div><!-- col-md-12 form-group -->
                    </div><!-- row -->

                </form>
            </div> <!-- modal-body -->

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
<script type="text/javascript">
$('#modaluser form').submit(function(e){
    if ($('#r-username').val().length < 1) {
        $('#r-username').focus();
        e.preventDefault();
        return false;
    }
});
</script>
