<?php
/**
 * GENERAL SETTINGS
 */

/**
 * Timezones list with GMT offset
 *
 * @return array
 */
function tzList() 
{
    $zones_array = array();
    $timestamp = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }
    return $zones_array;
} ?>
<div class="anchor" id="view-general"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cog"></i> <?php print $setUp->getString("general_settings"); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php print $setUp->getString("app_name"); ?></label>
                            <input type="text" class="form-control" 
                            value="<?php print $setUp->getConfig('appname'); ?>" name="appname">
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="show_usermenu" 
                                        <?php
                                        if ($setUp->getConfig('show_usermenu')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-user fa-fw"></i> 
                                        <?php print $setUp->getString("show_usermenu"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row toggle">
                            <div class="col-sm-12">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="show_langmenu" 
                                        <?php
                                        if ($setUp->getConfig('show_langmenu')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-flag fa-fw"></i> 
                                        <?php print $setUp->getString("show_langmenu"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row toggled">
                            <div class="col-sm-12">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="show_langname" 
                                        <?php
                                        if ($setUp->getConfig('show_langname')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-commenting-o fa-fw"></i> 
                                        <?php print $setUp->getString("show_current_language"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="browser_lang" 
                                        <?php
                                        if ($setUp->getConfig('browser_lang')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-language fa-fw"></i> 
                                        <?php print $setUp->getString("detect_browser_language"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="global_search" 
                                        <?php
                                        if ($setUp->getConfig('global_search')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-search fa-fw"></i> 
                                        <?php print $setUp->getString("global_search"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="show_foldertree" 
                                        <?php
                                        if ($setUp->getConfig('show_foldertree')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-sitemap fa-fw"></i> 
                                        <?php print $setUp->getString("archive_map"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="show_path" 
                                        <?php
                                        if ($setUp->getConfig('show_path')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-ellipsis-h fa-fw"></i> 
                                        <?php print $setUp->getString("display_breadcrumbs"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <div class="checkbox checkbox-big">
                                    <label>
                                        <input type="checkbox" name="upload_notification_enable" 
                                        <?php
                                        if ($setUp->getConfig('upload_notification_enable')) {
                                            echo "checked";
                                        } ?>><i class="fa fa-envelope-o fa-fw"></i> 
                                        <?php print $setUp->getString("can_notify_uploads"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>
                                    <i class="fa fa-file-archive-o fa-fw" aria-hidden="true"></i> <?php print $setUp->getString("zip_multiple_files"); ?>
                                </label>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-lg-6">
                                <label>
                                    <?php print $setUp->getString("max_files"); ?>
                                </label>
                                <input type="number" class="form-control" name="max_zip_files" value="<?php echo $setUp->getConfig('max_zip_files'); ?>">
                            </div>

                            <div class="col-xs-6 col-sm-12 col-lg-6 form-group">
                                <label><?php print $setUp->getString("max_filesize"); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="max_zip_filesize" value="<?php echo $setUp->getConfig('max_zip_filesize'); ?>">
                                    <span class="input-group-addon">MB</span>
                                </div> 
                            </div>
                        </div>
                    </div> <!-- col 6 -->
                    <div class="col-sm-6">
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php print $setUp->getString("application_url"); ?></label>
                                    <input type="text" class="form-control" placeholder="http://.../" 
                                    value="<?php print $setUp->getConfig('script_url'); ?>" name="script_url">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-lg-4">
                                <label>
                                    <?php print $setUp->getString("default_lang"); ?>
                                </label>
                                <select class="form-control" name="lang">
                                    <?php
                                    foreach ($translations as $key => $lingua) { ?>
                                        <option value="<?php echo $key; ?>" 
                                        <?php
                                        if ($key == $setUp->getConfig('lang')) {
                                            echo "selected";
                                        } 
                                        ?>>
                                        <?php echo $lingua; ?></option>
                                        <?php
                                    } ?>
                                </select>
                            </div>
                            <div class="col-xs-6 col-sm-12 col-lg-4">
                                <label><?php print $setUp->getString("direction"); ?></label>
                                <select class="form-control" name="txt_direction">
                                    <option value="LTR" 
                                    <?php
                                    if ($setUp->getConfig('txt_direction') == "LTR") {
                                                echo "selected";
                                    } ?> >Left to Right</option>
                                    <option value="RTL" 
                                    <?php
                                    if ($setUp->getConfig('txt_direction') == "RTL") {
                                                echo "selected";
                                    } ?> >Right to Left</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <label><?php print $setUp->getString("time_format"); ?></label>
                                <select class="form-control" name="time_format">
                                    <option 
                                    <?php
                                    if ($setUp->getConfig('time_format') == "d/m/Y - H:i") {
                                                echo "selected";
                                    } ?> >d/m/Y</option>
                                    <option 
                                    <?php
                                    if ($setUp->getConfig('time_format') == "m/d/Y - H:i") {
                                                echo "selected";
                                    } ?> >m/d/Y</option>
                                    <option 
                                    <?php
                                    if ($setUp->getConfig('time_format') == "Y/m/d - H:i") {
                                                echo "selected";
                                    } ?> >Y/m/d</option>
                                </select>
                            </div>
                        </div><!-- row -->
                    </div> <!-- col-sm-6 -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php 
                            if (strlen($setUp->getConfig('default_timezone')) < 3 ) {
                                    $thistime = "UTC";
                            } else {
                                    $thistime = $setUp->getConfig('default_timezone');
                            } ?>
                            <label><?php print $setUp->getString("default_timezone"); ?></label>
                            <select class="form-control" name="default_timezone">
                            <?php 
                            foreach (tzList() as $tim) { 
                                print "<option value=\"".$tim['zone']."\" ";
                                if ($tim['zone'] == $thistime) {
                                    print "selected";
                                }
                                print ">".$tim['diff_from_GMT'] . ' - ' . $tim['zone']."</option>";
                            } ?>
                            </select>
                        </div>

                        <div class="toggled">
                            <div class="checkbox checkbox-big clear">
                                <label>
                                    <input type="checkbox" name="enable_prettylinks" id="disable-prettylinks" 
                                    <?php
                                    if ($setUp->getConfig('enable_prettylinks')) {
                                            echo "checked";
                                    } ?>><?php echo $setUp->getString("prettylinks"); ?> 
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <?php print $setUp->getString("prettylink_old"); ?>:<br>
                                    <code>/vfm-admin/vfm-downloader.php?q=xxx</code><br>
                                    <?php print $setUp->getString("prettylink"); ?>:<br>
                                    <code>/download/xxx</code>
                                </div>
                            </div>
                        </div>
                        <div class="checkbox clear">
                            <label>
                                <input type="checkbox" name="direct_links" 
                                <?php
                                if ($setUp->getConfig('direct_links')) {
                                    echo "checked";
                                } ?>><i class="fa fa-eye fa-fw"></i><i class="fa fa-long-arrow-right fa-fw"></i><i class="fa fa-files-o fa-fw"></i> 
                                <?php print $setUp->getString("direct_links"); ?>
                            </label>
                        </div>
                    </div> <!-- col-sm-6 -->
                </div> <!-- row -->
            </div> <!-- box-body -->
            <!-- <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" data-toggle="tooltip" data-placement="left">
                    <i class="fa fa-save"></i>
                </button>
            </div> -->
        </div> <!-- box -->
    </div> <!-- col-12 -->
</div> <!-- row -->
