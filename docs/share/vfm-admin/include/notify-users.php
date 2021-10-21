<?php
/**
 * VFM - veno file manager: template/notify-users.php
 *
 * List users with access to current folder 
 * and an e-mail addres associated to select and notify uploads
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
if ($location->editAllowed() 
    && $gateKeeper->isAllowed('upload_enable')
) { 
    $usercount = 0;

    if ($setUp->getConfig('upload_notification_enable') == true
        && $gateKeeper->getUserInfo('email') !== null
    ) { 
        $notificables = array();
        foreach ($_USERS as $user) {
            $showuser = false;
            if (isset($user['email']) && strlen($user['email']) >= 5
                && $user['name'] !== $gateKeeper->getUserInfo('name')
            ) {
                if (isset($user['dir']) && strlen($user['dir']) >= 1) {
                    $userpatharray = array();
                    $userpatharray = json_decode($user['dir']);
                    $startdir = SetUp::getConfig('starting_dir');

                    foreach ($userpatharray as $value) {
                        $userpath = $startdir.$value."/"; 
                        $pos = strpos($location->getDir(true, false, false, 0), $userpath);
                        if ($pos !== false) {
                            $showuser = true;
                            break;
                        }
                    }
                } else {
                    $showuser = true;
                } 
                if ($showuser === true) { 
                    $notificable = array();
                    $notificable['email'] = $user['email'];
                    $notificable['name'] = $user['name'];

                    // show email only to SuperAdmins
                    $notificable['showmail'] = ($gateKeeper->isSuperAdmin() ? "<small>(".$notificable['email'].")</small>" : "");
                    
                    array_push($notificables, $notificable);
                    $usercount++;
                }
            }
        }
    }
    if ($usercount > 0) { ?>
            <?php 
                // select all by default

                // <script type="text/javascript">
                    
                //     $(document).ready(function (e) {
                //         $('.selectme').prop('checked', true);
                //         checkNotiflist();
                //     });
                // </script>
            ?>
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#userslistmodal">
                <i class="fa fa-circle-o check-notif"></i> 
                <?php echo $setUp->getString("upload_notifications"); ?> 
            </button>
        <?php
    } ?>
            <div class="modal fade" id="userslistmodal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">
                                <?php echo $setUp->getString("notify_users"); ?>
                            </h4>
                        </div>
                        <div class="modal-body">
        <?php
        if ($usercount > 0) {  ?>
                            <a class="selectallusers" href="#"><i class="fa fa-check"></i> Select All</a>
            <?php
        } ?>
                            <form class="form" id="userslist">
                                <input type="hidden" name="thislang" value="<?php echo $setUp->lang; ?>">
                                <input type="hidden" name="path" value="<?php echo urlencode($location->getDir(true, false, false, 0)); ?>">
        <?php
        if ($usercount > 0) { 
            foreach ($notificables as $notifuser) { ?>
                                <div class="checkbox">
                                    <label>
                                        <input class="selectme" type="checkbox" name="senduser[]" value="<?php echo $notifuser['email']; ?>">
                                        <?php echo '<span class="label label-primary">'.$notifuser['name'].'</span> '.$notifuser['showmail']; ?>
                                    </label>
                                </div>
                <?php
            } ?>
                                <h5><?php echo $setUp->getString("message"); ?></h5>
                                <textarea class="form-control" name="uploader_message"></textarea>
            <?php
        } ?>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userslistmodal">
                            <?php echo $setUp->getString("close"); ?> 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
}
