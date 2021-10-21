<?php
/**
 * VFM - veno file manager: include/login.php
 * front-end login panel
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
* Login Area
*/
$disclaimerfile = 'vfm-admin/login-disclaimer.html';

if (!$gateKeeper->isAccessAllowed()) { ?>
    <section class="vfmblock">
        <div class="login">

            <div class="panel panel-default">
                <div class="panel-body">
                    <form enctype="multipart/form-data" method="post" role="form" action="<?php echo $location->makeLink(false, null, ""); ?>" class="loginform">
                        <div id="login_bar" class="form-group">
                            <div class="form-group">
                                <label class="sr-only" for="user_name">
                                    <?php echo $setUp->getString("username"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    <input type="text" name="user_name" value="" id="user_name" class="form-control" 
                                    placeholder="<?php echo $setUp->getString("username"); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="user_pass">
                                    <?php echo $setUp->getString("password"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input type="password" name="user_pass" id="user_pass" class="form-control" 
                                    placeholder="<?php echo $setUp->getString("password"); ?>" />
                                </div>
                            </div>
                            <?php
                            if (file_exists($disclaimerfile)) {
                                $disclaimer = file_get_contents($disclaimerfile);
                                echo $disclaimer; ?>
                                <input type="hidden" id="trans_accept_terms" value="<?php echo $setUp->getString("accept_terms_and_conditions"); ?>">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="agree" name="agree" required> <?php echo $setUp->getString("accept"); ?> 
                                        <a href="#" data-toggle="modal" data-target="#login-disclaimer">
                                            <u><?php echo $setUp->getString("terms_and_conditions"); ?></u>
                                        </a>
                                    </label>
                                </div>
                                <?php
                            } ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="vfm_remember" value="yes"> 
                                    <?php echo $setUp->getString("remember_me"); ?>
                                </label>
                            </div>
                            <?php 
                            /* ************************ CAPTCHA ************************* */
                            if ($setUp->getConfig("show_captcha") == true ) { 
                                $capath = "vfm-admin/";
                                include "vfm-admin/include/captcha.php"; 
                            }   ?>
                            <button type="submit" class="btn btn-primary btn-block" />
                                <i class="fa fa-sign-in"></i> 
                                <?php echo $setUp->getString("log_in"); ?>
                            </button>
                        </div>
                    </form>
                    <p class="lostpwd"><a href="?rp=req"><?php echo $setUp->getString("lost_password"); ?></a></p>
                </div>
            </div>
    <?php
    if ($setUp->getConfig("registration_enable") == true ) { ?>
            <p>
                <a class="btn btn-default btn-block" href="?reg=1">
                    <i class="fa fa-user-plus"></i> <?php echo $setUp->getString("registration"); ?>
                </a>
            </p>
            <?php
    }   ?>
        </div>
    </section>
    <?php
}

if ($gateKeeper->isAccessAllowed() 
    && $gateKeeper->showLoginBox()
) { ?>

        <section class="vfmblock">
            <form enctype="multipart/form-data" method="post" action="<?php echo $location->makeLink(false, null, ""); ?>" class="form-inline loginform" role="form">
                <div id="login_bar">
                    <div class="form-group">
                        <label class="sr-only" for="user_name">
                            <?php echo $setUp->getString("username"); ?>:
                        </label>
                        <input type="text" name="user_name" value="" id="user_name" class="form-control" 
                        placeholder="<?php echo $setUp->getString("username"); ?>" />
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="user_pass">
                            <?php echo $setUp->getString("password"); ?>: 
                        </label>
                        <input type="password" name="user_pass" id="user_pass" class="form-control" 
                        placeholder="<?php echo $setUp->getString("password"); ?>" />
                    </div>
                    <?php
                    /* ************************ CAPTCHA ************************* */
                    if ($setUp->getConfig("show_captcha") == true ) { 
                        $capath = "vfm-admin/";
                        include "vfm-admin/include/captcha.php"; 
                    }   ?>
                    <button type="submit" class="btn btn-primary" />
                        <i class="fa fa-sign-in"></i> 
                        <?php echo $setUp->getString("log_in"); ?>
                    </button>
                    <?php
                    if (file_exists($disclaimerfile)) {
                        $disclaimer = file_get_contents($disclaimerfile);
                        echo $disclaimer; ?>
                        <input type="hidden" id="trans_accept_terms" value="<?php echo $setUp->getString("accept_terms_and_conditions"); ?>">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="agree" name="agree" required> <?php echo $setUp->getString("accept"); ?> 
                                <a href="#" data-toggle="modal" data-target="#login-disclaimer">
                                    <u><?php echo $setUp->getString("terms_and_conditions"); ?></u>
                                </a>
                            </label>
                        </div>
                        <?php
                    }
                    if ($setUp->getConfig("registration_enable") == true ) { ?>
                <a class="btn btn-default" href="?reg=1">
                    <i class="fa fa-user-plus"></i> <?php echo $setUp->getString("registration"); ?>
                </a>
                            <?php
                    }   ?>
                </div>
            </form>
            <a class="small lostpwd" href="?rp=req"><?php echo $setUp->getString("lost_password"); ?></a>
        </section>
        <?php
}
