<?php
/**
* DISPLAY MASTER-ADMIN
*/
?>
<div class="col-sm-6">
    <button class="btn btn-default btn-lg btn-block" data-toggle="modal" data-target="#masteradminpanel">
        <i class="vfmi vfmi-king"></i> Master Admin
    </button>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="masteradminpanel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" autocomplete="off" 
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=users&action=updatemaster" 
                enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="vfmi vfmi-king"></i> Master Admin
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group pull-left intero">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>
                                    <?php echo $setUp->getString("username"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user fa-fw"></i>
                                    </span>
                                    <input type="hidden" class="form-control" name="masterusernameold" value="<?php echo $king['name']; ?>">

                                    <input type="text" class="form-control" name="masterusername" value="<?php echo $king['name']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>
                                    <?php echo $setUp->getString("role"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-check fa-fw"></i>
                                    </span>
                                    <input type="text" class="form-control" readonly value="<?php echo $setUp->getString('role_'.$king['role']); ?>">
                                </div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                            <label>
                                    <?php echo $setUp->getString("password"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock fa-fw"></i>
                                    </span>
                                    <input type="password" class="form-control" name="masteruserpassnew" placeholder="<?php print $setUp->getString("new_password"); ?>">
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>
                                    <?php echo $setUp->getString("email"); ?>
                                </label>
                                <input type="hidden" class="form-control" name="masterusermailold" value="<?php echo $kingmail; ?>">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope fa-fw"></i>
                                    </span>
                                    <input type="email" class="form-control" name="masterusermail" value="<?php echo $kingmail; ?>" placeholder="<?php print $setUp->getString("email"); ?>">
                                </div>
                            </div>
                        </div> <!-- row -->
                    </div>
                </div><!-- /.modal-body -->
                <div class="modal-footer">
                    <button class="btn btn-info btn-lg">
                        <i class="fa fa-refresh"></i> 
                        <?php echo $setUp->getString("update_profile"); ?>
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
