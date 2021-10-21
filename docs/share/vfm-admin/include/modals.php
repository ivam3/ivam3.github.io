<?php
/**
 * VFM - veno file manager: include/modals.php
 * popup windows
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
* Group Actions
*/
if ($gateKeeper->isAccessAllowed()) {

    $time = time();
    $hash = md5($setUp->getConfig('salt').$time);
    $pulito = rtrim($setUp->getConfig("script_url"), "/");

    $insert4 = $setUp->getString('insert_4_chars');

    if ($setUp->getConfig("show_pagination_num") == true 
        || $setUp->getConfig("show_pagination") == true 
        || $setUp->getConfig("show_search") == true
    ) {
        $activepagination = true;
    } else {
        $activepagination = 0;
    }
    $selectfiles = $setUp->getString("select_files");
    $toomanyfiles = $setUp->getString('too_many_files');

    $maxzipfiles = $setUp->getConfig('max_zip_files');
    $prettylinks = ($setUp->getConfig('enable_prettylinks') ? true : 0);
    ?>
    <script type="text/javascript">
        createShareLink(
            <?php echo json_encode($insert4); ?>, 
            <?php echo json_encode($time); ?>, 
            <?php echo json_encode($hash); ?>, 
            <?php echo json_encode($pulito); ?>, 
            <?php echo json_encode($activepagination); ?>,
            <?php echo json_encode($maxzipfiles); ?>,
            <?php echo json_encode($selectfiles); ?>, 
            <?php echo json_encode($toomanyfiles); ?>,
            <?php echo json_encode($prettylinks); ?>
        );
    </script>
    <div class="modal fade downloadmulti" id="downloadmulti" tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <p class="modal-title">
                        <?php echo " " .$setUp->getString('selected_files'); ?>: 
                        <span class="numfiles badge badge-danger"></span>
                    </p>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-files-o fa-5x"></i>
                        <span class="ziparrow"></span>
                        <i class="fa fa-file-archive-o fa-5x"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center"></div>
                </div>
            </div>
         </div>
    </div>
    <?php
    /**
     * Send files window
     */
    if ($gateKeeper->isAllowed('sendfiles_enable') && $gateKeeper->isAllowed('download_enable')) { ?>
            <div class="modal fade sendfiles" id="sendfilesmodal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h5 class="modal-title">
                                <?php echo " " .$setUp->getString("selected_files"); ?>: 
                                <span class="numfiles badge badge-danger"></span>
                            </h5>
                        </div>

                        <div class="modal-body">
                            <div class="form-group createlink-wrap">
                                <button id="createlink" class="btn btn-primary btn-block"><i class="fa fa-check"></i> 
                                    <?php echo $setUp->getString("generate_link"); ?></button>
                            </div>
        <?php
        if ($setUp->getConfig('secure_sharing')) { ?>
                            <div class="checkbox">
                                <label>
                                    <input id="use_pass" name="use_pass" type="checkbox"><i class="fa fa-key"></i> 
                                    <?php echo $setUp->getString("password_protection"); ?>
                                </label>
                            </div>
            <?php
        } ?>
                        <div class="form-group shalink">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a class="btn btn-primary sharebutt" href="#" target="_blank">
                                        <i class="fa fa-link fa-fw"></i>
                                    </a>
                                </span>
                                <input id="copylink" class="sharelink form-control" type="text" onclick="this.select()" readonly>
        <?php
        if ($setUp->getConfig('clipboard')) { ?>
                                <script type="text/javascript" src="vfm-admin/js/clipboard.min.js"></script>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        callClipboards();
                                    });
                                </script>
                                <span class="input-group-btn">
                                    <button id="clipme" class="clipme btn btn-primary" 
                                    data-toggle="popover" data-placement="bottom" 
                                    data-content="<?php echo $setUp->getString("copied"); ?>" 
                                    data-clipboard-target="#copylink">
                                        <i class="fa fa-clipboard fa-fw"></i>
                                    </button>
                                </span>
            <?php
        } ?>
                            </div>
                        </div>
        <?php
        if ($setUp->getConfig('secure_sharing')) { ?>
                            <div class="form-group seclink">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input class="form-control passlink setpass" type="text" onclick="this.select()" 
                                    placeholder="<?php echo $setUp->getString("random_password"); ?>">
                                </div>
                            </div>
            <?php
        } 
        $mailsystem = $setUp->getConfig('email_from');
        if (strlen($mailsystem) > 0) { ?>
                            <a class="openmail" data-toggle="collapse" href="#sendfiles">
                                <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle-thin fa-stack-2x"></i>
                                  <i class="fa fa-envelope fa-stack-1x"></i>
                                </span>
                            </a>
                            <form role="form" id="sendfiles" class="collapse">
                                <div class="mailresponse"></div>
                                
                                <input name="thislang" type="hidden" 
                                value="<?php echo $setUp->lang; ?>">

                                <label for="mitt">
                                    <?php echo $setUp->getString("from"); ?>:
                                </label>

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    <input name="mitt" type="email" class="form-control" id="mitt" 
                                    value="<?php echo $gateKeeper->getUserInfo('email'); ?>" 
                                     placeholder="<?php echo $setUp->getString("your_email"); ?>" required >
                                </div>
                            
                                <div class="wrap-dest">
                                    <div class="form-group">
                                        <label for="dest">
                                            <?php echo $setUp->getString("send_to"); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                            <input name="dest" type="email" data-role="multiemail" class="form-control addest" id="dest" 
                                            placeholder="" required >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group clear">
                                    <div class="btn btn-primary btn-xs shownext hidden">
                                        <i class="fa fa-plus"></i> <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <textarea class="form-control" name="message" id="mess" rows="3" 
                                    placeholder="<?php echo $setUp->getString("message"); ?>"></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                </div>

                                <input name="passlink" class="form-control passlink" type="hidden">
                                <input name="attach" class="attach" type="hidden">
                                <input name="sharelink" class="sharelink" type="hidden">
                            </form>
                            
                            <div class="mailpreload">
                                <div class="cta">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
            <?php
        } ?>
                        </div> <!-- modal-body -->
                    </div>
                </div>
            </div>
        <?php
    } // end sendfiles enabled

    /**
    * Rename files and folders
    */
    if ($gateKeeper->isAllowed('rename_enable')) { ?>

        <div class="modal fade changename" id="modalchangename" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $setUp->getString("rename"); ?></h4>
                    </div>

                    <div class="modal-body">
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>">
                            <input readonly name="thisdir" type="hidden" class="form-control" id="dir">
                            <input readonly name="thisext" type="hidden" class="form-control" id="ext">
                            <input readonly name="oldname" type="hidden" class="form-control" id="oldname">
                            <div class="input-group">
                                <label for="newname" class="sr-only">
                                    <?php echo $setUp->getString("rename"); ?>
                                </label>
                                <input name="newname" type="text" class="form-control" id="newname">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo $setUp->getString("rename"); ?>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } // end rename_enable

    /**
    * Manage Copy / Move files 
    * and Folder tree navigation
    */ 
    ?>
        <div class="modal fade archive-map" id="archive-map" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-list"></i> 
                            <?php echo $setUp->getString("select_destination_folder"); ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="hiddenalert"></div>
                        <div class="modal-result"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade archive-map" id="archive-map-move" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-list"></i> 
                            <?php echo $setUp->getString("select_destination_folder"); ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="hiddenalert"></div>
                        <div class="modal-result"></div>
                        <form class="moveform">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade archive-map" id="archive-map-copy" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-list"></i> 
                            <?php echo $setUp->getString("select_destination_folder"); ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="hiddenalert"></div>
                        <div class="modal-result"></div>
                        <form class="moveform">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
    <?php
    /**
     * Navigate with folder tree
     */
    if ($gateKeeper->isAllowed('move_enable') 
        || $gateKeeper->isAllowed('copy_enable') 
        || $setUp->getConfig("show_foldertree") == true
    ) {
        if (isset($_GET['dir']) && strlen($_GET['dir']) > 0) {
            $currentdir = "./".trim($_GET['dir'], "/")."/";
        } else {
            $currentdir = $setUp->getConfig('starting_dir');
        } ?>
        <script type="text/javascript">
        setupFolderTree(
            <?php echo json_encode($currentdir); ?>,
            <?php echo json_encode($setUp->getString("root")); ?>
        );
        </script>
        <?php
    }
    /**
    * Move or copy files
    */
    if ($gateKeeper->isAllowed('move_enable') || $gateKeeper->isAllowed('copy_enable')) { 
        ?>
        <script type="text/javascript">
        setupMove(
            <?php echo json_encode($activepagination); ?>,
            <?php echo json_encode($selectfiles); ?>,
            <?php echo json_encode($time); ?>, 
            <?php echo json_encode($hash); ?>
        );
        </script>

        <?php
    } // end move_enable

    /**
    * Delete multiple files
    */
    if ($gateKeeper->isAllowed('delete_enable')) { 
        $confirmthisdel = $setUp->getString('delete_this_confirm');
        $confirmdel = $setUp->getString('delete_confirm'); ?>
        <script type="text/javascript">
            setupDelete(
                <?php echo json_encode($confirmthisdel); ?>, 
                <?php echo json_encode($confirmdel); ?>, 
                <?php echo json_encode($activepagination); ?>, 
                <?php echo json_encode($time); ?>, 
                <?php echo json_encode($hash); ?>, 
                <?php echo json_encode($selectfiles); ?>
            );
        </script>
        <div class="modal fade deletemulti" id="deletemulti" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <p class="modal-title"> 
                            <?php echo $setUp->getString("selected_files"); ?>: 
                            <span class="numfiles badge badge-danger"></span>
                        </p>
                    </div>
                    <div class="text-center modal-body">
                        <form id="delform">
                            <a class="btn btn-primary btn-lg centertext bigd removelink" href="#">
                            <i class="fa fa-trash-o fa-5x"></i></a>
                            <p class="delresp"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } // end delete enabled

} // end isAccessAllowed

/**
* Show Thumbnails
*/
if (($setUp->getConfig("thumbnails") == true) 
    || ($setUp->getConfig("playvideo") == true)
) { ?>
<script type="text/javascript">
    var script_url = <?php echo json_encode($setUp->getConfig('script_url')); ?>;
    <?php 
    if ($setUp->getConfig('enable_prettylinks') == true) { ?>
    var baselink = "download/";
        <?php
    } else { ?>
    var baselink = "vfm-admin/vfm-downloader.php?q=";
        <?php
    } ?>
</script>
    <div class="modal fade zoomview" id="zoomview" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <div class="modal-title">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a class="vfmlink btn btn-primary" href="#">
                                    <i class="fa fa-download fa-lg"></i> 
                                </a> 
                            </span>
                            <input type="text" class="thumbtitle form-control" value="" onclick="this.select()" readonly >
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="vfm-zoom"></div>
                    <!--            
                     <div style="position:absolute; right:10px; bottom:10px;">Custom Watermark</div>
                    -->                
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function b64DecodeUnicode(str) {
        return decodeURI(decodeURIComponent(Array.prototype.map.call(atob(str), function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join('')));
    }
    </script>

    <?php
    /**
     * Load sharing audio preview
     */
    if ($setUp->getConfig('share_playmusic') === true) :
        ?>
    <script type="text/javascript">
            // Call SoundManager 
            if ($('.sm2_button.sm2_share').length) {
                var basicMP3Player = null;
                soundManager.setup({
                    url: 'vfm-admin/swf/',
                    debugMode: false,
                    preferFlash: false,
                    onready: function() {
                        basicMP3Player = new BasicMP3Player();
                    }
                });
            }
    </script>
        <?php
    endif;

    /**
     * Load video preview
     */
    if ($setUp->getConfig('playvideo') === true) : 
        $playerlang = $setUp->lang;
        if (!file_exists(dirname(dirname(__FILE__)).'/js/videojs/lang/'.$setUp->lang.'.js')) {
            $shortlang = $result = substr($setUp->lang, 0, 2);
            if (file_exists(dirname(dirname(__FILE__)).'/js/videojs/lang/'.$shortlang.'.js')) {
                $playerlang = $shortlang;
            } else {
                $playerlang = 'en';
            }
        }
        ?>
    <link href="vfm-admin/js/videojs/video-js.min.css" rel="stylesheet">
    <script src="vfm-admin/js/videojs/video.min.js?v=7.4.1"></script>
    <script src="vfm-admin/js/videojs/lang/<?php echo $playerlang; ?>.js"></script>
    <script type="text/javascript">

    function loadVid(thislink, thislinkencoded, thisname, thisID, ext){

        if (ext == 'ogv') {
            ext = 'ogg';
        }
        var vidlink = 'vfm-admin/ajax/streamvid.php?vid=' + thislink;
        var playerhtml = '<video id="my-video" class="video-js vjs-16-9" >' + '<source src="'+ vidlink +'" type="video/'+ ext +'">';
        $(".vfm-zoom").html(playerhtml);

        videojs('#my-video', { 
            controls: true,
            autoplay: true,
            preload: 'auto',
            language: '<?php echo $playerlang; ?>'
        }, function(){
            // video initialized
        });

        $("#zoomview .thumbtitle").val(thisname);
        $("#zoomview").data('id', thisID);
        $("#zoomview").modal();
        
        checkNextPrev(thisID);

        $(".vfmlink").attr("href", baselink + thislinkencoded);
        <?php 
        if ($setUp->getConfig('direct_links') == true) { ?>
            $(".vfmlink").attr('target','_blank');
            $("#zoomview .thumbtitle").val(script_url + b64DecodeUnicode(thislink));
            <?php
        } ?>
    }
    </script>
        <?php
    endif;

    /**
    * Load image preview 
    */ 
    if ($setUp->getConfig('thumbnails') == true) : ?>

    <script type="text/javascript">
    function loadImg(thislink, thislinkencoded, thisname, thisID, ext){
        $(".vfm-zoom").html("<i class=\"fa fa-refresh fa-spin\"></i><img class=\"preimg\" src=\"vfm-thumb.php?thumb="+ thislink +"&y=1\" \/>");
        $("#zoomview").data('id', thisID);
        $("#zoomview .thumbtitle").val(thisname);
        var firstImg = $('.preimg');
        firstImg.css('display','none');
        $("#zoomview").modal();

        firstImg.one('load', function() {
            $(".vfm-zoom .fa-refresh").fadeOut();
            $(this).fadeIn();
            checkNextPrev(thisID);
            $(".vfmlink").attr("href", baselink + thislinkencoded);
            if (ext == 'pdf') {
                $(".vfmlink").attr('target','_blank');
            }
            <?php
            if ($setUp->getConfig('direct_links') == true) { ?>
                $(".vfmlink").attr('target','_blank');
                $("#zoomview .thumbtitle").val(script_url + b64DecodeUnicode(thislink));
                <?php
            } ?>
        }).each(function() {
            if(this.complete) {
                $(this).load();
            }
        });   
    }
    </script>
        <?php
    endif;
} // end thumbnails || video
