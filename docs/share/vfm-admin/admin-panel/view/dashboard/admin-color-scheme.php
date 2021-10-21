<?php
/**
 * Admin Color Scheme
 *
 * @package    VenoFileManager
 * @subpackage Administration
 */
?>
<div class="anchor" id="view-color-scheme"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <i class="fa fa-eyedropper"></i> <?php echo $setUp->getString("administration_color_scheme"); ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="row adminscheme">
                <?php
                $colorlist = array('blue', 'purple', 'red', 'yellow', 'green', 'white');
                foreach ($colorlist as $color) { 
                    if ($setUp->getConfig('admin_color_scheme') == $color) { 
                        $layoutclass = "minilayout active";
                        $state = "checked";
                    } else {
                        $layoutclass = "minilayout";
                        $state = "";
                    } ?>
                    <div class="col-lg-2 col-md-4 col-xs-6">
                        <div class="<?php echo $layoutclass; ?>">
                            <label>
                                <input type="radio" name="admin_color_scheme" value="<?php echo $color; ?>" <?php echo $state; ?> >
                                <?php echo $color; ?>
                                <div class="colorbar-scheme">
                                    <div class="colorbar primary-<?php echo $color; ?>"></div>
                                    <div class="colorbar primary-side-<?php echo $color; ?>"></div>
                                    <div class="colorbar secondary-side-<?php echo $color; ?>"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                <?php
                } ?>
                </div>
            </div>
        </div>
    </div>
</div>