<?php
/**
 * VFM - veno file manager: include/downloader.php
 * Show download buttons for shared links
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
* Downloader
*/
$expired = true;
$share_json = 'vfm-admin/_content/share/'.$getdownloadlist.'.json';
if ($getdownloadlist && file_exists($share_json)) {

    $expired = false;

    $datarray = json_decode(file_get_contents($share_json), true);
    $passa = true;
    $passcap = true;
    $passpass = true;

    $pass = (isset($datarray['pass']) ? $datarray['pass'] : false);

    if ($pass) { 
        $passa = false;
        $passpass = false;

        $postpass = filter_input(INPUT_POST, "dwnldpwd", FILTER_SANITIZE_STRING);

        if (md5($postpass) === $pass) {
            $passa = true;
            $passpass = true;
        }
    }

    if (!Utils::checkCaptcha('show_captcha_download')) {
        $passa = false;
        $passcap = false;
    }

    $hash = $datarray['hash'];
    $time = $datarray['time'];

    if ($passa === true) {

        $direct_links = $setUp->getConfig('direct_links');
        $target = '';

        $countfiles = 0;

        if ($downloader->checkTime($time) == true) { 

            $onetime_download = $setUp->getConfig('one_time_download') ? '1' : '0';
            ?>

            <div class="intero centertext bigzip">
                <a class="btn btn-primary btn-lg centertext zipshare" data-time="<?php echo $time; ?>" data-hash="<?php echo $hash; ?>" data-downloadlist="<?php echo $datarray['attachments']; ?>" data-onetime="<?php echo $onetime_download; ?>" href="javascript:void(0)">
                    <i class="fa fa-cloud-download fa-2x"></i> .zip
                </a>
            </div>

            <div class="intero">
                <ul class="multilink">
            <?php

            $pieces = explode(",", $datarray['attachments']);
            $totalsize = 0;

            foreach ($pieces as $pezzo) {

                $myfile = urldecode(base64_decode($pezzo));

                if (file_exists($myfile)) {

                    $filepathinfo = Utils::mbPathinfo($myfile);
                    $filename = $filepathinfo['basename'];
                    $extension = strtolower($filepathinfo['extension']);
                    $filesize = Utils::getFileSize($myfile);
                    $totalsize += $filesize;
                    $thisicon = array_key_exists($extension, $_IMAGES) ? $_IMAGES[$extension] : 'fa-file-o';

                    // Set pretty links
                    if ($setUp->getConfig('enable_prettylinks') == true) {
                        $downlink = "download/".$countfiles."/sh/".$getdownloadlist;
                        $modal_downlink = $countfiles."/sh/".$getdownloadlist;
                    } else {
                        $downlink = "vfm-admin/vfm-downloader.php?q=".$countfiles."&sh=".$getdownloadlist;
                        $modal_downlink = $countfiles."&sh=".$getdownloadlist;

                    }
                    $countfiles++;

                    // Set link to direct file
                    if ($direct_links === true || $extension === 'pdf') {
                        $target = 'target="_blank"';
                    }

                    $imgdata = 'data-ext="'.$extension.'"';
                    $icon = '<a class="btn btn-primary service-btn" href="'.$downlink.'" '.$target.'><i class="fa fa-download fa-lg"></i></a>';

                    $audiotypes = array(
                        'mp3',
                        'wav',
                        'flac',
                        'aac',
                    );

                    if (in_array($extension, $audiotypes) && $setUp->getConfig('share_playmusic') === true) {
                        $imgdata .= ' data-type="audio"';
                        $icon = '<a type="audio/mp3" class="sm2_button sm2_share btn btn-primary service-btn" href="'.$downlink.'&audio=play">
                            <i class="trackpause fa fa-volume-up fa-lg"></i>
                            <i class="trackplay fa fa-circle-o-notch fa-spin fa-lg"></i>
                            <i class="trackstop fa fa-volume-up fa-lg"></i></a>';
                    }

                    $imagetypes = array(
                        'jpg',
                        'jpeg',
                        'gif',
                        'png',
                    );

                    if (in_array($extension, $imagetypes) && $setUp->getConfig('share_thumbnails') === true) {
                        $imgdata .= ' data-name="'.$filename.'" data-link="'.$pezzo.'" data-linkencoded="'.$modal_downlink.'"';
                        $icon = '<a '.$imgdata.' class="btn btn-primary thumb vfm-gall service-btn" href="'.$downlink.'"><i class="fa fa-eye fa-lg"></i></a>';
                    }

                    $videotypes = array(
                        'mp4',
                        'webm',
                        'ogg',
                    );

                    if (in_array($extension, $videotypes) && $setUp->getConfig('share_playvideo') === true) {
                        $imgdata .= ' data-name="'.$filename.'" data-link="'.$pezzo.'" data-linkencoded="'.$modal_downlink.'"';
                        $icon = '<a '.$imgdata.' class="btn btn-primary vid vfm-gall service-btn" href="'.$downlink.'"><i class="fa fa-play fa-lg"></i></a>';
                    }
                    ?>
                    <li>
                        <a class="btn btn-primary main-btn" href="<?php echo $downlink; ?>" <?php echo $target; ?>>
                            <div class="wrap-title pull-left">
                            <span class="pull-left small overflowed">
                                <i class="fa <?php echo $thisicon; ?> fa-lg"></i> <?php echo $filename; ?>
                            </span>
                            </div>
                            <span class="pull-right small itemsize">
                                <?php echo $setUp->formatsize($filesize); ?>
                            </span>
                        </a>
                        <?php echo $icon; ?>
                    </li>
                    <?php
                }
            } ?>
            </ul></div>

            <?php
            // if more than 1 file file exists create a zip
            if ($countfiles > 1) {
                // check number of files and total size 
                // if under the limits, show the zip button
                $max_zip_filesize = $setUp->getConfig('max_zip_filesize');
                $max_zip_files = $setUp->getConfig('max_zip_files');
                $totalsize = $totalsize/1024/1024;

                if ($totalsize <= $max_zip_filesize && $countfiles <= $max_zip_files) { ?>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('.bigzip').fadeIn();
                    });
                    </script>
                    <?php
                }
            }
        } 

        // download link time expired
        // or no more file available
        if ($countfiles < 1 || $downloader->checkTime($time) == false) {
            unlink('vfm-admin/_content/share/'.$getdownloadlist.'.json');
            $expired = true;
        }
        
    } // END if $passa == true

    if ($passa !== true) { ?>

        <div class="row" id="dwnldpwd">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>">
                <?php
                if (strlen($pass) > 0) {

                    if ($postpass && $passpass !== true) { ?>
                        <script type="text/javascript">
                            var $error2 = $('<div class="alert-wrap"><div class="response nope alert-dismissible alert" role="alert">'
                            + ' <?php echo $setUp->getString("wrong_captcha"); ?>'
                            + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            + '<span aria-hidden="true">&times;</span></button></div></div>');
                            $('#error').append($error2);
                        </script>
                        <?php
                    } ?>
                    <div class="form-group">
                        <label for="dwnldpwd"><?php echo $setUp->getString("password"); ?></label>
                        <input type="password" name="dwnldpwd" class="form-control" placeholder="<?php echo $setUp->getString("password"); ?>">
                    </div>
                    <?php
                }
                /* ************************ CAPTCHA ************************* */
                if ($setUp->getConfig("show_captcha_download") == true ) { 
                    $capath = "vfm-admin/";
                    include "vfm-admin/include/captcha.php"; 
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $passcap !== true) { ?>
                        <script type="text/javascript">
                            var $error = $('<div class="alert-wrap"><div class="response nope alert-dismissible alert" role="alert">'
                            + ' <?php echo $setUp->getString("wrong_captcha"); ?>'
                            + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            + '<span aria-hidden="true">&times;</span></button></div></div>');
                            $('#error').append($error);
                        </script>  
                        <?php
                    }
                } ?>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-check"></i>
                      </button>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
        <?php
    }
}

if ($expired === true) { ?>
    <div class="intero centertext">
        <a class="btn btn-default btn-lg centertext whitewrap" href="./">
            <?php echo $setUp->getString("link_expired"); ?>
        </a>
    </div>
    <?php
}
