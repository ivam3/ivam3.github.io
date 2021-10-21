<?php
/**
 * Footer Credits
 *
 * @package    VenoFileManager
 * @subpackage Administration
 */
?>
<div class="box box-default box-solid">
    <div class="box-header">
        <i class="fa fa-copyright"></i> <?php echo $setUp->getString('credits'); ?>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <label><?php echo $setUp->getString('text'); ?></label>
                <input type="text" class="form-control" name="credits" value="<?php echo $setUp->getConfig('credits'); ?>" placeholder="VFM">
            </div><!-- col-sm-6 -->

            <div class="col-sm-6">
                <label><?php echo $setUp->getString('link'); ?></label>
                <input type="url" class="form-control" name="credits_link" value="<?php echo $setUp->getConfig('credits_link'); ?>" placeholder="http://">
            </div>
        </div><!-- row -->

        <div class="row toggle-reverse">
            <div class="col-sm-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="hide_credits" 
                        <?php
                        if ($setUp->getConfig('hide_credits')) {
                            echo "checked";
                        } ?>><i class="fa fa-times fa-fw"></i> 
                        <?php print $setUp->getString("remove"); ?>
                    </label>
                </div>
            </div>
        </div>

    </div><!-- box-body -->
</div><!-- box -->
