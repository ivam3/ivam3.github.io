<?php
/**
 * Header Customizer
 *
 * @package    VenoFileManager
 * @subpackage Administration
 */
?>
<div class="box box-default box-solid">
    <div class="box-header">
        <i class="vfmi vfmi-wide2"></i> <?php echo $setUp->getString('custom_header'); ?>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <?php
                switch ($setUp->getConfig("align_logo")) {
                case "left":
                    $placealign = "text-left";
                    break;
                case "center":
                    $placealign = "text-center";
                    break;
                case "right":
                    $placealign = "text-right";
                    break;
                default:
                    $placealign = "text-left";
                }
                $setwide = $setUp->getConfig("banner_width", 'wide');

                $header_img = $setUp->getConfig('logo', false) ? '_content/uploads/'.$setUp->getConfig('logo') : 'admin-panel/images/placeholder.png';
                $deleterclass2 = $setUp->getConfig('logo', false) ? '' : ' hidden';
                ?>
                <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label><i class="fa fa-arrows-h fa-fw"></i> <?php echo $setUp->getString("layout"); ?></label>
                            <div class="form-group select-banner-width">
                                <label class="radio-inline" title="wide">
                                    <input form="settings-form" type="radio" name="banner_width" 
                                    <?php
                                    if ($setwide == "wide") {
                                        echo "checked";
                                    } ?> value="wide"> <i class="vfmi vfmi-wide"></i>
                                </label>
                                <label class="radio-inline" title="boxed">
                                    <input form="settings-form" type="radio" name="banner_width"
                                    <?php
                                    if ($setwide == "boxed") {
                                        echo " checked";
                                    } ?> value="boxed"> <i class="vfmi vfmi-boxed"></i>
                                </label>
                            </div>
                        </div> <!-- .form-group-->
                    </div>
                    <?php 
                    $setalign_logo = $setUp->getConfig("align_logo", 'center'); ?>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label><?php echo $setUp->getString("alignment"); ?></label>
                            <div class="form-group select-logo-alignment">
                                <label class="radio-inline">
                                    <input form="settings-form" type="radio" name="align_logo" 
                                    <?php
                                    if ($setalign_logo === "left") {
                                        echo "checked";
                                    } ?> value="left"> <i class="fa fa-align-left"></i>
                                </label>
                                <label class="radio-inline">
                                    <input form="settings-form" type="radio" name="align_logo" 
                                    <?php
                                    if ($setalign_logo === "center") {
                                        echo "checked";
                                    } ?> value="center"> <i class="fa fa-align-center"></i>
                                </label>
                                <label class="radio-inline">
                                    <input form="settings-form" type="radio" name="align_logo" 
                                    <?php
                                    if ($setalign_logo === "right") {
                                        echo "checked";
                                    } ?> value="right"> <i class="fa fa-align-right"></i>
                                </label>
                            </div>
                        </div> <!-- .form-group-->
                    </div>
                    <?php 
                    $setheader_padding = $setUp->getConfig("header_padding", 0); ?>
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label>
                                <i class="fa fa-arrows-v fa-fw"></i> <?php echo $setUp->getString("margin"); ?>
                            </label>
                            <div class="row">
                                <div class="col-xs-7">
                                    <input name="header_padding" class="slider form-control header-padding" data-slider-id="header_padding" type="text" data-slider-min="0" data-slider-max="200" data-slider-step="1" data-slider-tooltip="hide" data-slider-value="<?php echo $setheader_padding; ?>" />
                                </div>
                                <div class="col-xs-5 set-slider">
                                    <div class="input-group">
                                        <input type="number" class="set-val form-control" value="<?php echo $setheader_padding; ?>" min="0" max="200">
                                        <span class="input-group-addon">px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $setlogo_margin = $setUp->getConfig("logo_margin", 0); ?>
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label>
                                <i class="fa fa-long-arrow-down fa-fw"></i> <?php echo $setUp->getString("margin_bottom"); ?>
                            </label>
                            <div class="row">
                                <div class="col-sm-7">
                                    <input name="logo_margin" class="slider form-control logo-margin" data-slider-id="logo_margin" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-tooltip="hide" data-slider-value="<?php echo $setlogo_margin; ?>" />
                                </div>
                                <div class="col-sm-5 set-slider">
                                    <div class="input-group">
                                        <input type="number" class="set-val form-control" value="<?php echo $setlogo_margin; ?>" min="0" max="100">
                                        <span class="input-group-addon">px</span>
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div>
                   <?php $header_pos = $setUp->getConfig("header_position", 'below'); ?>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label><?php echo $setUp->getString("position"); ?></label>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input form="settings-form" type="radio" name="header_position" 
                                    <?php
                                    if ($header_pos === "below") {
                                        echo "checked";
                                    } ?> value="below"> <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 12 12" fill="currentColor">
                                        <path d="M0,1.8v8.3h12V1.8H0z M11.5,9.5H0.5V3.7h10.9V9.5z"/>
                                    </svg>
                                </label>
                                <label class="radio-inline">
                                    <input form="settings-form" type="radio" name="header_position" 
                                    <?php
                                    if ($header_pos === "above") {
                                        echo "checked";
                                    } ?> value="above"> <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 12 12" fill="currentColor">
                                        <path d="M12,10.2V1.8H0v8.3H12z M0.5,2.5h10.9v5.8H0.5V2.5z"/>
                                    </svg>
                                </label>
                            </div>
                        </div> <!-- .form-group-->
                    </div>
                </div><!-- row -->
            </div><!-- col-sm-6 -->
            <div class="col-sm-6">
                <div class="placeheader place-main-header form-group <?php echo $placealign; ?>">
                    <div class="wrap-image-header <?php echo $setwide; ?>">
                        <img class="logo-preview" src="<?php echo $header_img; ?>?t=<?php echo time(); ?>">
                    </div>
                    <button class="btn btn-danger btn-xs deletelogo<?php echo $deleterclass2; ?>" data-setting="logo">&times;</button>
                </div>
                <input type="hidden" name="remove_logo" value="0">

                <div class="form-group">
                    <span class="btn btn-default btn-file btn-block">
                        <?php echo $setUp->getString('upload'); ?> 
                        <i class="fa fa-upload"></i>
                        <input type="file" name="header_image" value="select" class="logo-selector" data-target=".logo-preview">
                    </span>
                </div>
                 <div class="form-group">
                    <h4><?php echo $setUp->getString("description"); ?></h4>
                    <textarea class="form-control summernote" name="description"><?php print $setUp->getConfig('description'); ?></textarea>
                </div>
            </div>
        </div><!-- row -->
    </div><!-- box-body -->
</div><!-- box -->
