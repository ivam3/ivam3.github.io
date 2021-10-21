<?php
/**
 * VFM - veno file manager: chunk.php
 *
 * Resumable uploads
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
require 'config.php';
require 'users/users.php';

require_once 'class/class.setup.php';
require_once 'class/class.gatekeeper.php';
require_once 'class/class.actions.php';
require_once 'class/class.location.php';
require_once 'class/class.utils.php';
require_once 'class/class.logger.php';
require_once 'class/class.uploader.php';

$uploader = new Uploader();
$setUp = new SetUp('');

require "translations/".$setUp->lang.".php";

$gateKeeper = new GateKeeper();

if ($gateKeeper->isAccessAllowed() 
    && ($gateKeeper->isAllowed('upload_enable'))
) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $resumabledata = $uploader->setupFilename($_GET['resumableFilename']);
        $resumableFilename = $resumabledata['filename'];
        $extension = $resumabledata['extension'];
        $basename = $resumabledata['basename'];
        $fullfilepath = $_GET['loc'].$resumableFilename;

        // Skip invalid file
        if (!$uploader->veryFile($fullfilepath, $_GET['resumableTotalSize'])) {
            header("HTTP/1.0 200 Ok");
            exit;
        }
        $temp_dir = 'tmp/'.$_GET['resumableIdentifier'];
        $uploader_file = $temp_dir.'/'.$resumableFilename.'.part'.$_GET['resumableChunkNumber'];

        if (!file_exists($uploader_file)) {
            header("HTTP/1.0 204 No Content");
            exit;
        }
        header("HTTP/1.0 200 Ok");
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {

        @set_time_limit(0);

        $resumableIdentifier = filter_input(INPUT_POST, 'resumableIdentifier', FILTER_SANITIZE_STRING);
        $resumableChunkNumber = filter_input(INPUT_POST, 'resumableChunkNumber', FILTER_VALIDATE_INT);
        $resumableTotalSize = filter_input(INPUT_POST, 'resumableTotalSize', FILTER_VALIDATE_INT);
        $resumableTotalChunks = filter_input(INPUT_POST, 'resumableTotalChunks', FILTER_VALIDATE_INT);
        $resumableChunkSize = filter_input(INPUT_POST, 'resumableChunkSize', FILTER_VALIDATE_INT);

        $resumabledata = $uploader->setupFilename($_POST['resumableFilename']);
        $resumableFilename = $resumabledata['filename'];

        foreach ($_FILES as $file) {
            // init the destination file (format <filename.ext>.part<#chunk>
            // the file is stored in a temporary directory
            $temp_dir = 'tmp/'.$resumableIdentifier;

            $dest_file = $temp_dir.'/'.$resumableFilename.'.part'.$resumableChunkNumber;

            // create the temporary directory
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0775, true);
            }

            // move the temporary file
            if (!move_uploaded_file($file['tmp_name'], $dest_file)) {
                Utils::setError(
                    ' <span><i class="fa fa-exclamation-triangle"></i> Error saving chunk '
                    .$resumableChunkNumber.' for '.$resumableFilename.'</span> '
                );
            } else {

                // Check if all the parts present
                if ($uploader->checkChunks($temp_dir, $resumableTotalSize, $resumableChunkSize, $resumableTotalChunks)) {
                    // Create the final destination file
                    $uploader->createFileFromChunks(
                        $_GET['loc'],
                        $temp_dir,
                        $resumableFilename,
                        $resumableTotalSize,
                        $resumableTotalChunks,
                        $_GET['logloc']
                    );
                }
                exit;
            }
        }
    }
    exit;
}
