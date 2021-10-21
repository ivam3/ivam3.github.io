<?php
/**
 * VFM - veno file manager: ajax/shorten.php
 *
 * Generate short sharing link
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
require_once '../config.php';

require_once '../class/class.utils.php';
require_once '../class/class.downloader.php';
require_once '../class/class.setup.php';

$utils = new Utils;
$downloader = new Downloader();
$setUp = new SetUp();

$attachments = filter_input(INPUT_POST, "atts", FILTER_SANITIZE_STRING);
$time = filter_input(INPUT_POST, "time", FILTER_SANITIZE_STRING);
$hash = filter_input(INPUT_POST, "hash", FILTER_SANITIZE_STRING);
$pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);

if (strlen($pass) > 0) {
    $hpass = md5($pass);
} else {
    $hpass = false;
}

$saveData = array();

$saveData['pass'] = $hpass;
$saveData['time'] = $time;
$saveData['hash'] = $hash;
$saveData['attachments'] = $attachments;
$attachash = md5($time.$attachments.$pass);
/** 
 * Use this second function $attacash
 * to shorten the name to 12 chars instead of default 32
 */
// $attachash = substr(md5($time.$attachments.$pass), 0, 12);

// create the temporary directory
if (!is_dir('../_content/share')) {
    mkdir('../_content/share', 0755, true);
}
// save dowloadable link if it does not already exists
if (!file_exists('../_content/share/'.$attachash.'.json') || $pass!==false) {
    $fp = fopen('../_content/share/'.$attachash.'.json', 'w');
    fwrite($fp, json_encode($saveData));
    fclose($fp);
}
// remove old files
$shortens = glob("../_content/share/*.json");

foreach ($shortens as $shorten) {
    if (is_file($shorten)) {
        $filetime = filemtime($shorten);

        if ($downloader->checkTime($filetime) == false) {
            unlink($shorten);
        }
    }
}
echo $attachash;
