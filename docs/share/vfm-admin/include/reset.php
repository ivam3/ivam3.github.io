<?php
/**
 * VFM - veno file manager: include/reset.php
 * password reset form
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

?>
<section class="vfmblock">
    <div class="login">
        <noscript>
            <div class="alert alert-danger">Please activate JavaScript</div>
        </noscript>
<?php
$getusr = filter_input(INPUT_GET, "usr", FILTER_SANITIZE_STRING);
/**
* Reset password
*/
if ($getusr && $resetter->checkTok($getrp, $getusr) == true) : ?>
    <form role="form" method="post" id="rpForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        
        <div class="sendresponse"></div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-unlock-alt"></i> <?php print $setUp->getString('reset_password'); ?>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <input type="hidden" name="getrp" value="<?php print $getrp; ?>">
                    <input type="hidden" name="userh" value="<?php print $getusr; ?>">

                    <label for="reset_pwd">
                        <?php print $setUp->getString("new_password"); ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input name="reset_pwd" id="rep" type="password" 
                        class="form-control" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_pwd">
                        <?php print $setUp->getString("new_password")
                        ." (".$setUp->getString("confirm").")"; ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input name="reset_conf" id="repconf" type="password" 
                        class="form-control" value="">
                    </div>
                </div>
                <a class="btn btn-primary sendreset" href="#">
                    <i class="fa fa-refresh"></i>
                    <?php print $setUp->getString("reset_password"); ?>
                </a>
            </div>
            <div class="mailpreload">
                <div class="cta">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        $(".sendreset").on( "click", function() {
            $(".mailpreload").fadeIn(function(){
                var rep = $('#rep').val();
                var repconf = $('#repconf').val();
                var empty = $('#rpForm input').filter(function() {
                    return this.value === "";
                });
                if(empty.length) {
                    $(".mailpreload").fadeOut();
                    $('.sendresponse').html('<div class="alert alert-warning"><?php echo $setUp->getString("fill_all_fields"); ?></div>').fadeIn();
                } else if (rep  !== repconf) {
                    $(".mailpreload").fadeOut();
                    $('.sendresponse').html('<div class="alert alert-warning"><?php echo $setUp->getString("password_does_not_match"); ?></div>').fadeIn();
                } else {
                    $("#rpForm").submit();
                }
            });
        });
    </script>
    <?php   
endif;

/**
* Send link
*/
if (!$getusr || $resetter->checkTok($getrp, $getusr) !== true) : 

    if ($getusr && $resetter->checkTok($getrp, $getusr) !== true) { ?>
        <div class="alert alert-danger">
            <?php echo $setUp->getString("key_not_valid"); ?>
        </div>
    <?php
    }  

    $pulito = $setUp->getConfig("script_url");
    ?>
            <form role="form" method="post" id="sendpwd" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <div class="sendresponse"></div>
                <input name="cleanurl" type="hidden" value="<?php print $pulito; ?>">
                <input name="thislang" type="hidden" value="<?php print $setUp->lang; ?>">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-unlock-alt"></i> <?php print $setUp->getString('reset_password'); ?>
                    </div>
                    <div class="panel-body">
                        <label class="sr-only" for="user_email"><?php print $setUp->getString("email"); ?></label>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input name="user_email" id="reqmail" type="email" 
                                placeholder="<?php print $setUp->getString("email"); ?>" 
                                class="form-control" value="">
                            </div>
                        </div>
                        <?php 
                        /* ************************ CAPTCHA ************************* */
                        if ($setUp->getConfig("show_captcha_reset") == true ) { 
                            $capath = "vfm-admin/";
                            include "vfm-admin/include/captcha.php";
                        } ?>
                        <button type="submit" class="btn btn-block btn-primary">
                            <i class="fa fa-arrow-circle-right"></i>
                            <?php print $setUp->getString("send"); ?>
                        </button>
                    </div>
                    <div class="panel-footer">
                        <?php print $setUp->getString("enter_email_receive_link"); ?>
                    </div>
                    <div class="mailpreload">
                        <div class="cta">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </form>
    <?php 
endif; ?>
        <a href="?dir=">
            <i class="fa fa-sign-in"></i> <?php print $setUp->getString("log_in"); ?>
        </a>
    </div> <!-- .login -->
</section>