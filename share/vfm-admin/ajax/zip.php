<?php
/**
 * VFM - veno file manager: ajax/zip.php
 *
 * Generate zip archive
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
@set_time_limit(0);
require_once '../config.php';

require_once '../class/class.gatekeeper.php';
require_once '../class/class.zipper.php';
require_once '../class/class.setup.php';
require_once '../class/class.utils.php';
require_once '../class/class.logger.php';

$setUp = new SetUp();
$zipper = new Zipper();
$logger = new Logger();
require_once '../translations/'.$setUp->lang.'.php';

$getfiles = filter_input(INPUT_POST, 'filesarray', FILTER_SANITIZE_STRING);
$time = filter_input(INPUT_POST, "time", FILTER_SANITIZE_STRING);
$getfolder = filter_input(INPUT_POST, 'fold', FILTER_SANITIZE_STRING);
$hash = filter_input(INPUT_POST, 'dash', FILTER_SANITIZE_STRING);
$onetime = filter_input(INPUT_POST, 'onetime', FILTER_SANITIZE_STRING);

$alt = $setUp->getConfig('salt');
$altone = $setUp->getConfig('session_name');

$dozip = false;
$folder = false;
$files = false;

if (!$hash) {
    echo json_encode(array('error'=>$setUp->getString('access_denied')));
    exit;
}

if ($getfolder && $hash === md5($alt.$getfolder.$altone)) {   
    $folder = base64_decode($getfolder);
    $filename = $folder;
    $dozip = true;
}

if ($getfiles && $hash === md5($alt.$time)) {
    $files = explode(",", $getfiles);
    $dozip = true;
}

if ($dozip === true) {

    $zipfolder = $folder ? '../../'.$folder : false;

    $zippedfile = $zipper->createZip($files, $zipfolder, '../');

    if (isset($zippedfile['file'])) {
        $file = $zippedfile['file'];

        $filename = $folder ? $folder : $file;
        $queryname = $folder ? base64_encode($filename) : 0;

        $zippedfile['filename'] = $folder ? basename($folder).'.zip' : $filename.'.zip';

        if ($setUp->getConfig('enable_prettylinks') == true) {
            $downlink = 'download/zip/'.base64_encode($file).'/n/'.$queryname;
        } else {
            $downlink = 'vfm-admin/vfm-downloader.php?zip='.base64_encode($file).'&n='.$queryname;
        }
        $zippedfile['link'] = $downlink;
        $logarray = isset($zippedfile['logarray']) ? $zippedfile['logarray'] : false;

        if ($files && $logarray) {
            $logger->logDownload($logarray, false, '../');
        }
    }

    if ($onetime === '1') {
        unlink(dirname(dirname(__FILE__)). '/_content/share/'.$unlink.'.json');
    }

    echo json_encode($zippedfile);
    exit;
}
echo json_encode(array('error'=>$setUp->getString('nothing_found')));
exit;
