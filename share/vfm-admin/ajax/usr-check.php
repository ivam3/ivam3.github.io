<?php
/**
 * VFM - veno file manager: ajax/usr-check.php
 *
 * Check if username exists before registration
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
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}
require_once '../class/class.setup.php';
require_once '../class/class.utils.php';
require_once '../class/class.gatekeeper.php';
require_once '../class/class.updater.php';

require_once '../users/users.php';
global $_USERS;

if (file_exists('../users/users-new.php')) {
    include '../users/users-new.php';
} else {
    $newusers = array();
}
global $newusers;
$updater = new Updater();

$postname = filter_input(INPUT_POST, "user_name", FILTER_SANITIZE_STRING);

if ($postname) {
    $postname = preg_replace('/\s+/', '', $postname);
    if ($updater->findUser($postname) || $updater->findUserPre($postname)) {
        echo 'error';
    } else {
        echo 'success';
    }
}
exit();
