<?php
/**
* EMAIL SETTINGS
**/
?>
<div class="anchor" id="view-email"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-envelope"></i> 
                <?php print $setUp->getString("email"); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
     
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>
                                <i class="fa fa-envelope-o"></i> 
                                <?php print $setUp->getString("email_from"); ?>
                            </label>
                            <input type="email" class="form-control input-lg" 
                            name="email_from" value="<?php print $setUp->getConfig('email_from'); ?>"
                            placeholder="noreply@example.com">
                        </div>
                    </div>

                    <?php
                    $email_logo = $setUp->getConfig('email_logo', false) ? '_content/uploads/'.$setUp->getConfig('email_logo') : 'admin-panel/images/placeholder.png';
                    $deleterclass = $setUp->getConfig('email_logo', false) ? '' : ' hidden';
                    ?>
                    <div class="col-sm-6">
                        <label><i class="fa fa-certificate fa-fw"></i> <?php print $setUp->getString("logo"); ?></label>
                        <div class="placeheader form-group text-center">
                            <img class="mail-logo-preview" src="<?php echo $email_logo; ?>?t=<?php echo time(); ?>">
                            <button class="btn btn-danger btn-xs deletelogo<?php echo $deleterclass; ?>" data-setting="email_logo">&times;</button>
                        </div>

                        <input type="hidden" name="remove_email_logo" value="0">

                        <div class="form-group">
                            <span class="btn btn-default btn-file btn-block">
                                <?php echo $setUp->getString('upload'); ?> 
                                <i class="fa fa-upload"></i>
                                <input type="file" name="email_logo" value="select" class="logo-selector" data-target=".mail-logo-preview">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="checkbox checkbox-big clear toggle">
                    <label>
                        <input type="checkbox" name="smtp_enable" id="smtp_enable" 
                        <?php
                        if ($setUp->getConfig('smtp_enable') == true) {
                            echo "checked";
                        } ?>>SMTP mail
                    </label>
                </div>

                <div class="toggled">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>
                                    <?php print $setUp->getString("smtp_server"); ?>
                                </label>
                                <input type="text" class="form-control" 
                                name="smtp_server" value="<?php print $setUp->getConfig('smtp_server'); ?>"
                                placeholder="mail.example.com">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>
                                        <?php print $setUp->getString("port"); ?>
                                    </label>
                                    <input type="text" class="form-control" 
                                    name="port" value="<?php print $setUp->getConfig('port'); ?>"
                                    placeholder="25">
                                </div>

                                <div class="col-md-6">
                                    <label><?php print $setUp->getString("secure_connection"); ?></label>

                                    <select class="form-control" name="secure_conn">
                                        <option 
                                    <?php
                                    if ($setUp->getConfig('secure_conn') == "") {
                                        echo "selected";
                                    } ?> value="none">none</option>
                                        <option 
                                    <?php
                                    if ($setUp->getConfig('secure_conn') == "ssl") {
                                        echo "selected";
                                    } ?> value="ssl">SSL</option>
                                        <option 
                                    <?php
                                    if ($setUp->getConfig('secure_conn') == "tls") {
                                        echo "selected";
                                    } ?> value="tls">TLS</option>
                                    </select>
                                </div> <!-- col 6 -->
                            </div> <!-- row -->
                        </div> <!-- col 6 -->
                    </div> <!-- row -->
        
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="checkbox clear toggle">
                                <label>
                                    <input type="checkbox" name="smtp_auth" 
                                    <?php
                                    if ($setUp->getConfig('smtp_auth') == true) {
                                        echo "checked";
                                    } ?>>
                                    <?php print $setUp->getString("smtp_auth"); ?>
                                </label>
                            </div>
                    
                            <div class="row toggled">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            <?php print $setUp->getString("username"); ?>
                                        </label>
                                        <input type="text" class="form-control" 
                                        name="email_login" value="<?php print $setUp->getConfig('email_login'); ?>"
                                        placeholder="login@example.com">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            <?php print $setUp->getString("password"); ?>
                                        </label>
                                        <input type="password" class="form-control" 
                                        name="email_pass" value=""
                                        placeholder="<?php print $setUp->getString("password"); ?>">
                                    </div>
                                </div> <!-- col 6 -->
                            </div> <!-- row toggled -->

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="debug_smtp" 
                                        <?php
                                        if ($setUp->getConfig('debug_smtp') === true) {
                                            echo "checked";
                                        } ?>>
                                        <i class="fa fa-wrench"></i> DEBUG SMTP 
                                            <a title="display SMTP connection responses inside e-mail forms" class="tooltipper" data-placement="right" href="javascript:void(0)">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                    </label>
                                </div>
                            </div>
                        </div> <!-- col 12 -->
                    </div> <!-- row -->
                </div> <!-- toggled -->

            </div> <!-- box-body -->
        </div> <!-- box -->



    </div>  <!-- col 12 -->
</div> <!-- row -->