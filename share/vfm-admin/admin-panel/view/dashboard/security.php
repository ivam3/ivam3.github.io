<?php
/**
 * VFM - veno file manager: admin-panel/view/dashboard/security.php
 * administration registration block
 *
 * @package VenoFileManager
 */
?>
<div id="view-security" class="anchor"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-shield"></i> <?php echo $setUp->getString("security"); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4><?php echo $setUp->getString("CAPTCHA"); ?></h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="show_captcha" 
                                    <?php
                                    if ($setUp->getConfig('show_captcha')) {
                                        echo "checked";
                                    } ?>> <i class="fa fa-sign-in fa-fw fa-lg"></i>  
                                    <?php echo $setUp->getString("log_in"); ?>
                                </label>
                            </div>
                        </div>
                        <?php
                        /*
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="show_captcha_admin" 
                                    <?php
                                    if ($setUp->getConfig('show_captcha_admin')) {
                                        echo "checked";
                                    } ?>> <i class="fa fa-dashboard fa-fw fa-lg"></i>  
                                    <?php echo $setUp->getString("administration"); ?> 
                                </label>
                            </div>
                        </div>
                        */ ?>
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="show_captcha_reset" 
                                    <?php
                                    if ($setUp->getConfig('show_captcha_reset')) {
                                        echo "checked";
                                    } ?>> <i class="fa fa-key fa-fw fa-lg"></i> 
                                    <?php echo $setUp->getString("reset_password"); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="show_captcha_download" 
                                    <?php
                                    if ($setUp->getConfig('show_captcha_download') == true) {
                                        echo "checked";
                                    } ?>><i class="fa fa-share fa-fw fa-lg"></i> 
                                    <?php echo $setUp->getString("share_files"); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="show_captcha_register" 
                                    <?php
                                    if ($setUp->getConfig('show_captcha_register')) {
                                        echo "checked";
                                    } ?>> <i class="fa fa-user-plus fa-fw fa-lg"></i> 
                                    <?php echo $setUp->getString("registration"); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox checkbox-bigger clear toggle">
                            <label>
                                <input type="checkbox" name="recaptcha" 
                                <?php
                                if ($setUp->getConfig('recaptcha')) {
                                    echo "checked";
                                } ?>><i class="fa fa-google fa-fw"></i> ReCAPTCHA 
                                <a title="sign up for an API key" target="_blank" href="https://www.google.com/recaptcha/admin">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="row toggled">
                            <div class="col-md-6">
                                <label>
                                    <?php echo $setUp->getString("site_key"); ?>
                                </label>
                                <input type="text" class="form-control" name="recaptcha_site" value="<?php echo $setUp->getConfig('recaptcha_site'); ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>
                                    <?php echo $setUp->getString("secret_key"); ?>
                                </label>
                                <input type="text" class="form-control" name="recaptcha_secret" value="<?php echo $setUp->getConfig('recaptcha_secret'); ?>">
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="recaptcha_invisible" 
                                        <?php
                                        if ($setUp->getConfig('recaptcha_invisible') == true) {
                                            echo "checked";
                                        } ?>><i class="fa fa-recycle"></i> <?php echo $setUp->getString("invisible_recaptcha"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <h4><?php echo $setUp->getString("ip_block"); ?></h4>
                    </div>
                    <div class="col-sm-6">
                        <p class="pull-right"><?php echo $setUp->getString("your_ip"); ?>: <span class="label label-info"><?php echo $_SERVER['REMOTE_ADDR']; ?></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="radio checkbox-big toggle-extensions clear">
                                    <label>
                                        <input type="radio" name="ip_list" class="togglext" value="reject"
                                        <?php if ($setUp->getConfig('ip_list') == "reject") echo " checked"; ?>>
                                        <span class="togglabel"><?php echo $setUp->getString("blacklist"); ?></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <?php 
                                    $ip_blacklist = $setUp->getConfig('ip_blacklist');
                                    $rejectlist = $ip_blacklist ? implode(",", $ip_blacklist) : false; ?>
                                    <input type="text" class="form-control taginput" name="ip_blacklist" data-tag="danger" 
                                    value="<?php echo $rejectlist; ?>" placeholder="xxx.xxx.x..">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="radio checkbox-big toggle-extensions clear">
                                    <label>
                                        <input type="radio" name="ip_list" class="togglext" value="allow" 
                                        <?php if ($setUp->getConfig('ip_list') == "allow") echo " checked"; ?>>
                                        <span class="togglabel"><?php echo $setUp->getString("whitelist"); ?></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <?php 
                                    $ip_whitelist = $setUp->getConfig('ip_whitelist');
                                    $allowlist = $ip_whitelist ? implode(",", $ip_whitelist) : false; ?>
                                    <input type="text" class="form-control taginput" name="ip_whitelist" data-tag="success" 
                                    value="<?php echo $allowlist; ?>" placeholder="xxx.xxx.x..">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo $setUp->getString("url_redirect"); ?></label>
                            <input type="text" class="form-control" name="ip_redirect" placeholder="http://google.com" value="<?php echo $setUp->getConfig('ip_redirect'); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>