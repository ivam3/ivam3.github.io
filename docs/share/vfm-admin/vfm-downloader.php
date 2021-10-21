<?php
/**
 * VFM - veno file manager downloader
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
require_once 'config.php';
require_once 'users/users.php';

require_once 'class/class.setup.php';
require_once 'class/class.gatekeeper.php';
require_once 'class/class.downloader.php';
require_once 'class/class.utils.php';
require_once 'class/class.logger.php';

// Redirect blacklisted IPs.
Utils::checkIP();

$setUp = new SetUp();
require_once 'translations/'.$setUp->lang.'.php';

$gateKeeper = new GateKeeper();
$downloader = new Downloader();
$logger = new Logger();

$timeconfig = $setUp->getConfig('default_timezone');
$timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
date_default_timezone_set($timezone);

$script_url = $setUp->getConfig('script_url');

$getzip = filter_input(INPUT_GET, 'zip', FILTER_SANITIZE_STRING);
$getfile = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
$hash = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_STRING);
$supah = filter_input(INPUT_GET, 'sh', FILTER_SANITIZE_STRING);

$alt = $setUp->getConfig('salt');
$altone = $setUp->getConfig('session_name');
$maxfiles = $setUp->getConfig('max_zip_files');
$maxfilesize = $setUp->getConfig('max_zip_filesize');

$android = false;
$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
if (stripos($useragent, 'android') !== false) {
    $android = true;
}

/**
* Download single file 
* (for non-logged users)
*/
if ($supah && is_numeric($getfile)) {
    $filenum = $getfile;
    // Check sharing link.
    $share_json = '_content/share/'.$supah.'.json';
    if (file_exists($share_json)) {
        $datarray = json_decode(file_get_contents($share_json), true);
        $time = $datarray['time'];

        // Check expiration time.
        if ($downloader->checkTime($time) == true) {
            $pieces = explode(",", $datarray['attachments']);
            /**
             * ONE TIME DOWNLOADER
             * remove empty json file
             */
            if (!count($pieces)) {
                unlink($share_json);
            }
            // Check if file is listed in json.
            if (isset($pieces[$filenum])) {
                $getfile = $pieces[$filenum];

                // Check if requested file exists.
                if ($downloader->checkFile($getfile) == true) {
                    $headers = $downloader->getHeaders($getfile);

                    /**
                     * EDIT: BLOCK UNLOGGED USERS
                     * AND USERS WITHOUT ACCESS TO THAT FOLDER
                     */
                    // if (!$gateKeeper->isUserLoggedIn() || !$downloader->subDir($headers['dirname'])) {

                    //     $_SESSION['error'] = '<i class="fa fa-ban"></i> Access denied';

                    //     if (!$gateKeeper->isUserLoggedIn()) {
                    //         $_SESSION['error'] = '<i class="fa fa-ban"></i> Please log in to download the files';
                    //     }
                    //     $cleandir = '';
                    //     $userdirs = GateKeeper::getUserInfo('dir');
                    //     $userpatharray = $userdirs !== null ? json_decode($userdirs, true) : array();
                    //     // check if user has only one folder
                    //     if (count($userpatharray) === 1) {
                    //         $cleandir = '?dir='.substr($setUp->getConfig('starting_dir').$userpatharray[0], 2);
                    //     }
                    //     header('Location:'.$script_url.$cleandir);
                    //     exit;
                    // }
                    /**
                     * EDIT-END: BLOCK UNLOGGED USERS
                     * AND USERS WITHOUT ACCESS TO THAT FOLDER
                     */

                    /**
                     * ONE TIME DOWNLOADER
                     * remove the item from the json file
                     */
                    if ($setUp->getConfig('one_time_download')) {
                        unset($pieces[$filenum]);
                        $datarray['attachments'] = implode(',', $pieces);
                        $send_dataarray = json_encode($datarray);
                        file_put_contents($share_json, $send_dataarray);
                    }
                    
                    if ($setUp->getConfig('direct_links')) {
                        if ($headers['content_type'] == 'audio/mp3') {
                            $logger->logPlay($headers['trackfile']);
                        } else {
                            $logger->logDownload($headers['trackfile']);
                        }
                        header('Location:'.$script_url.base64_decode($getfile));
                        exit;
                    }
                    if ($downloader->download(
                        $headers['file'], 
                        $headers['filename'], 
                        $headers['file_size'], 
                        $headers['content_type'],
                        $headers['disposition'],
                        $android 
                    ) === true
                    ) {
                        $logger->logDownload($headers['trackfile']);
                    }
                    exit;
                }
            }
        }
    }
}

/**
* Download single file, play Audio or show PDF 
* (for logged users)
*/
if ($getfile && $hash
    && $downloader->checkFile($getfile) == true
    && md5($alt.$getfile.$altone.$alt) === $hash
) {
    $playmp3 = filter_input(INPUT_GET, 'audio', FILTER_SANITIZE_STRING);
    $headers = $downloader->getHeaders($getfile, $playmp3);

    if (($gateKeeper->isUserLoggedIn() 
        && $downloader->subDir($headers['dirname']) == true) 
        || $gateKeeper->isLoginRequired() == false
    ) {

        if ($setUp->getConfig('direct_links')) {
            if ($headers['content_type'] == 'audio/mp3') {
                $logger->logPlay($headers['trackfile']);
            } else {
                $logger->logDownload($headers['trackfile']);
            }
            header('Location:'.$script_url.base64_decode($getfile));
            exit;
        }

        if ($downloader->download(
            $headers['file'], 
            $headers['filename'], 
            $headers['file_size'], 
            $headers['content_type'], 
            $headers['disposition'],
            $android
        ) === true
        ) {
            if ($headers['content_type'] == 'audio/mp3') {
                $logger->logPlay($headers['trackfile']);
            } else {
                $logger->logDownload($headers['trackfile']);
            }
        }
        exit;
    }
    $_SESSION['error'] = '<i class="fa fa-ban"></i> Access denied';
    header('Location:'.$script_url);
    exit;
}

/**
* Download zipped folder
*/
if ($getzip) {

    $zipname = filter_input(INPUT_GET, 'n', FILTER_SANITIZE_STRING);

    $decoded = base64_decode($getzip);
    $file = 'tmp/'.$decoded;

    if (!file_exists($file)) {
        $_SESSION['error'] = '<i class="fa fa-times"></i> File not found';
        header('Location:'.$script_url);
        exit;
    }

    if ($zipname) {
        $folder = base64_decode($zipname);
        $filename = basename($folder).'.zip';
    } else {
        $filename = $decoded.'.zip';
    }

    $file_size = Utils::getFileSize($file);
    $content_type = 'application/zip';
    $disposition = 'attachment';

    if ($downloader->download(
        $file, 
        $filename, 
        $file_size, 
        $content_type, 
        $disposition,
        $android
    ) === true
    ) {
        if ($zipname) {
            $logger->logDownload('./'.ltrim($folder), true);
        }
    }
    unlink($file);
    exit;
}
$_SESSION['error'] = $setUp->getString("link_expired");
header('Location:'.$script_url);
exit;
