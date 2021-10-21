<?php
/**
 * VFM - veno file manager: include/footer.php
 * script footer
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
$privacy_file = 'vfm-admin/privacy-info.html';
$privacy = file_exists($privacy_file) ? file_get_contents($privacy_file) : false;
?>
 <footer class="footer">
    <div class="container">
        <span class="pull-left">
            <a href="<?php echo $setUp->getConfig('script_url'); ?>">
                <?php echo $setUp->getConfig("appname"); ?>
            </a> &copy; <?php echo date('Y'); ?>
            <?php
            if ($privacy) {
            ?> | 
                <a href="#" data-toggle="modal" data-target="#privacy-info">
                    <?php echo $setUp->getString("privacy"); ?>
                </a>
            <?php
            } ?>
        </span>

        <?php
        // Credits
        if ($setUp->getConfig('hide_credits') !== true) { 
            $credits = $setUp->getConfig('credits');
            if ($credits) { ?>
                <span class="small pull-right">
                <?php
                if ($setUp->getConfig('credits_link')) { ?>
                    <a target="_blank" href="<?php echo $setUp->getConfig('credits_link'); ?>">
                        <?php echo $credits; ?>
                    </a>
                <?php
                } else {
                    echo $credits;
                } ?>
                </span>
            <?php
            } else { ?>
                <a class="pull-right" title="Built with Veno File Manager" target="_blank" href="http://filemanager.veno.it">
                    <i class="vfmi vfmi-typo"></i>
                </a>
            <?php
            } 
        } ?>
    </div>
</footer>
<div class="to-top"><i class="fa fa-chevron-up"></i></div>
<?php
if ($privacy) {
    echo $privacy;
}
