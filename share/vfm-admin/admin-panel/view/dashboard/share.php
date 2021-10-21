<?php
/**
* FILE SHARING
**/
?>
<div id="view-share" class="anchor"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-share"></i>  <?php print $setUp->getString("share_files"); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>

            <div class="box-body">
                <div class="form-group toggled">
                    <div class="row">
                        <div class="col-sm-6">
                            <label><?php echo $setUp->getString("keep_links"); ?></label>
                            <select class="form-control" name="lifetime">
                            <?php 
                            foreach ($share_lifetime as $key => $value) {
                                echo "<option ";
                                if ($setUp->getConfig('lifetime') == $key) {
                                    echo "selected ";
                                }
                                echo "value=\"".$key."\">".$value."</option>";
                            } ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <div class="checkbox checkbox-bigger">
                                <label>
                                    <input type="checkbox" name="one_time_download" 
                                    <?php
                                    if ($setUp->getConfig('one_time_download') == true) {
                                        echo "checked";
                                    } ?>><i class="fa fa-arrow-circle-o-down"></i> 
                                    <?php echo $setUp->getString("one_time_download"); ?>
                                    <a title="<?php echo $setUp->getString("remove_link_once_downloaded"); ?>" class="tooltipper" data-placement="right" href="javascript:void(0)">
                                        <i class="fa fa-question-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="secure_sharing" 
                                    <?php
                                    if ($setUp->getConfig('secure_sharing') == true) {
                                        echo "checked";
                                    } ?>><i class="fa fa-key"></i> 
                                    <?php echo $setUp->getString("password_protection"); ?>
                                </label>
                            </div>
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="clipboard" 
                                    <?php
                                    if ($setUp->getConfig('clipboard') == true) {
                                        echo "checked";
                                    } ?>><i class="fa fa-clipboard"></i> 
                                    <?php echo $setUp->getString("copy_to_clipboard"); ?>
                                </label>
                            </div>


                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="share_thumbnails" 
                                    <?php
                                    if ($setUp->getConfig('share_thumbnails')) {
                                        echo "checked";
                                    } ?>><i class="fa fa-window-maximize fa-fw"></i>
                                    <?php echo $setUp->getString("can_thumb"); ?>
                                </label>
                            </div>
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="share_playmusic" 
                                    <?php
                                    if ($setUp->getConfig('share_playmusic') == true) {
                                        echo "checked";
                                    } ?>><i class="fa fa-music fa-fw"></i> 
                                    <?php echo $setUp->getString("mp3_player"); ?>
                                </label>
                            </div>
                            <div class="checkbox checkbox-big">
                                <label>
                                    <input type="checkbox" name="share_playvideo" 
                                    <?php
                                    if ($setUp->getConfig('share_playvideo') == true) {
                                        echo "checked";
                                    } ?>><i class="fa fa-film fa-fw"></i> 
                                    <?php echo $setUp->getString("video_player"); ?>
                                </label>
                            </div>



                        </div>
                    </div>
                </div> <!-- toggled -->
            </div> <!-- box-body -->
        </div> <!-- box -->
    </div> <!-- col -->
</div> <!-- row -->