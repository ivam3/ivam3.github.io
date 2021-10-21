<?php
/**
 * VFM - veno file manager: include/register.php
 * front-end registration panel
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
* Get additional custom fields
*/
if (!$gateKeeper->isUserLoggedIn()) {
    $customfields = false;
    if (file_exists('vfm-admin/users/customfields.php')) {
        include 'vfm-admin/users/customfields.php';
    }
    /**
    * Registration Mask
    */
    if ($setUp->getConfig("registration_enable") == true) { ?>
        <section class="vfmblock">
            <div class="login">
                <div id="regresponse"></div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-user-plus"></i> <?php print $setUp->getString('registration'); ?>
                    </div>
                    <div class="panel-body">
                        <form id="regform" action="<?php print $location->makeLink(false, null, ""); ?>">
                            <input type="hidden" id="trans_fill_all" value="<?php echo $setUp->getString("fill_all_fields"); ?>">
                            <input type="hidden" id="trans_pwd_match" value="<?php echo $setUp->getString("passwords_dont_match"); ?>">
                            <input type="hidden" id="trans_accept_terms" value="<?php echo $setUp->getString("accept_terms_and_conditions"); ?>">
                            <div id="login_bar" class="form-group">
                                <div class="form-group">
                                    <div class="has-feedback">
                                        <label for="user_name">* 
                                            <?php echo $setUp->getString("username"); ?>
                                        </label>  
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="fa fa-user fa-fw"></i>
                                            </span>
                                            <input type="text" name="user_name" value="" id="user_name" class="form-control" />
                                        </div>
                                        <span class="glyphicon glyphicon-minus form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_pass">* 
                                        <?php echo $setUp->getString("password"); ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                        <input type="password" name="user_pass" id="user_pass" class="form-control" data-toggle="popover" title="<?php echo $setUp->getString("minimum_length").': '.$setUp->getConfig("password_length", 4); ?>" data-length="<?php echo $setUp->getConfig("password_length", 4); ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_pass">* 
                                        <?php echo $setUp->getString("password")." (".$setUp->getString("confirm").")"; ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                        <input type="password" name="user_pass_confirm" id="user_pass_check" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_email">* 
                                        <?php echo $setUp->getString("email"); ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                        <input type="email" name="user_email" class="form-control" />
                                    </div>
                                </div>
                                <?php
                                /**
                                * Additional user custom fields
                                */
                                if (is_array($customfields)) { ?>
                                    <?php
                                    foreach ($customfields as $customkey => $customfield) { ?>
                                        <div class="form-group">
                                            <label><?php echo $customfield['name']; ?></label>
                                        <?php
                                        if ($customfield['type'] === 'textarea') { ?>
                                            <textarea name="<?php echo $customkey; ?>" class="form-control" rows="2"></textarea>
                                        <?php
                                        }
                                        if ($customfield['type'] === 'select' && is_array($customfield['options'])) { ?>
                                            <select name="<?php echo $customkey; ?>" class="form-control coolselect">
                                            <?php
                                            foreach ($customfield['options'] as $optionval => $optiontitle) { ?>
                                                <option value="<?php echo $optionval; ?>"><?php echo $optiontitle; ?></option>
                                            <?php
                                            } ?>
                                            </select>
                                        <?php
                                        }
                                        if ($customfield['type'] === 'text' || $customfield['type'] === 'email') { ?>
                                             <input type="<?php echo $customfield['type']; ?>" name="<?php echo $customkey; ?>" class="form-control">
                                        <?php
                                        } ?>
                                        </div>
                                    <?php
                                    }
                                } ?>

                                <?php
                                $disclaimerfile = 'vfm-admin/registration-disclaimer.html';
                                if (file_exists($disclaimerfile)) {
                                    $disclaimer = file_get_contents($disclaimerfile);
                                    echo $disclaimer; ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="agree" name="agree" required> <?php echo $setUp->getString("accept"); ?> 
                                            <a href="#" data-toggle="modal" data-target="#disclaimer">
                                                <u><?php echo $setUp->getString("terms_and_conditions"); ?></u>
                                            </a>
                                        </label>
                                    </div>
                                <?php
                                } ?>
                                <div class="form-group">
                                <?php 
                                /* ************************ CAPTCHA ************************* */
                                if ($setUp->getConfig("show_captcha_register") == true ) { 
                                    $capath = "vfm-admin/";
                                    include "vfm-admin/include/captcha.php"; 
                                }   ?>
                                    <button type="submit" class="btn btn-primary btn-block" />
                                        <i class="fa fa-check"></i> 
                                        <?php echo $setUp->getString("register"); ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mailpreload">
                        <div class="cta">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
                <a href="?dir="><i class="fa fa-sign-in"></i>  <?php print $setUp->getString("log_in"); ?></a>
            </div>
        </section>
        <script type="text/javascript" src="vfm-admin/js/registration.min.js"></script>
        <script type="text/javascript">
        // Call password strength
        $(document).ready(function(){
            $('#user_pass').on('keyup', function() {
                var password = $(this);
                var response = passwordStrength(password);
                console.log(response);
            });
            $('input[data-toggle="popover"]').popover({
                placement: 'top',
                trigger: 'focus'
            });
        });
        </script>
        <?php
    }
}
