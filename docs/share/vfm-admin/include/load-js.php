<?php
/**
 * VFM - veno file manager: include/load-js.php
 * Load javascript files
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
$debug_mode = $setUp->getConfig('debug_mode');
/**
 * ********************
 * Init soundmanager
 * ********************
 */
if (($gateKeeper->isAccessAllowed() && $setUp->getConfig("playmusic") === true) || $setUp->getConfig('share_playmusic') === true) {
    if ($debug_mode === true) {
        ?>
    <script src="vfm-admin/js/soundmanager/soundmanager2.js?v=2.97"></script>
    <script src="vfm-admin/js/soundmanager/vfm-inlineplayer.js?v=2.97"></script>
        <?php
    } else {
        ?>
    <script src="vfm-admin/js/soundmanager/soundmanager2.min.js?v=2.97"></script>
        <?php
    }
}

if ($debug_mode === true) { ?>
    <script type="text/javascript" src="vfm-admin/js/modernizr.js"></script>    
    <script type="text/javascript" src="vfm-admin/js/bootbox.js"></script>    
    <script type="text/javascript" src="vfm-admin/js/app.js?v=<?php echo $vfm_version; ?>"></script>
    <?php
} else { ?>
    <script type="text/javascript" src="vfm-admin/js/app.min.js?v=<?php echo $vfm_version; ?>"></script>
    <?php
} ?> 
<script type="text/javascript" src="vfm-admin/js/bootstrap.min.js?v=3.3.7"></script>
<script type="text/javascript">
    // confirm
    bootbox.addLocale('vfm', 
    {
        OK : '<?php echo $setUp->getString("OK"); ?>',
        CANCEL : '<?php echo $setUp->getString("CANCEL"); ?>',
        CONFIRM : '<?php echo $setUp->getString("CONFIRM"); ?>'
    });
    bootbox.setLocale('vfm');
</script>
<?php
if ($gateKeeper->isUserLoggedIn()) : ?>
    <script type="text/javascript" src="vfm-admin/js/avatars.js?v=<?php echo $vfm_version; ?>"></script>
    <?php
endif;

if ($gateKeeper->isAccessAllowed()) : 
    ?>
    <script type="text/javascript" src="vfm-admin/js/datatables.min.js?v=1.10.16"></script>
    <?php
    /**
     * Setup Files Table
     */
    $tablesettings = array();
    $tablesettings['dir'] = $location->getDir(false, false, false, 0);

    $filetableconfig = array();

    $filecolumns = array(
        'alpha' => 2,
        'size' => 3,
        'date' => 4,
    );
    $filetableconfig['ilenght'] = isset($_SESSION['ilenght']) ? $_SESSION['ilenght'] : $setUp->getConfig('filedefnum', 10); 
    $filetableconfig['sort_col'] = isset($_SESSION['sort_col']) ? $_SESSION['sort_col'] : $filecolumns[$setUp->getConfig('filedeforder', 'date')]; 
    $default_order = ($filetableconfig['sort_col'] === 4) ? 'desc' : 'asc';
    $filetableconfig['sort_order'] = isset($_SESSION['sort_order']) ? $_SESSION['sort_order'] : $default_order;

    $filetableconfig['paginate'] = $setUp->getConfig("show_pagination") ? 'on' : 'off';
    $filetableconfig['pagination_type'] = ($setUp->getConfig("show_pagination_num") === true) ? 'full_numbers' : 'simple';
    $filetableconfig['show_search'] = $setUp->getConfig("show_search");
    $filetableconfig['search'] = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);

    $filecoulmns = array();

    $filecoulmns[] = array(
        'orderable' => false,
        'class' => 'checkb text-center',
        'data' => 'check',
    );
    $filecoulmns[] = array(
        'orderable' => false,
        'class' => 'icon itemicon text-center',
        'data' => 'icon',
    );
    $filecoulmns[] = array(
        'class' => 'name',
        'data' => 'file_name',
    );
    $filecoulmns[] = array(
        'class' => 'mini reduce nowrap hidden-xs',
        'data' => 'size',
    );
    $filecoulmns[] = array(
        'class' => 'mini reduce hidden-xs nowrap',
        'data' => 'last_change',
    );
    if ($gateKeeper->isAllowed('rename_enable')) { 
        $filecoulmns[] = array(
            'orderable' => false,
            'class' => 'icon text-center hidden-xs',
            'data' => 'edit',
        );
    }
    $filecoulmns[] = array(
        'orderable' => false,
        'class' => 'text-center',
        'data' => 'delete',
    ); 
    $filetableconfig['columns'] = $filecoulmns; 

    /**
    * Setup Folders table
    */
    $foldertableconfig = array();

    $foldercolumns = array(
        'alpha' => 1,
        'date' => 2,
    );
    $foldertableconfig['dirlenght'] = isset($_SESSION['dirlenght']) ? $_SESSION['dirlenght'] : $setUp->getConfig('folderdefnum', 5); 
    $foldertableconfig['sort_dir_col'] = isset($_SESSION['sort_dir_col']) ? $_SESSION['sort_dir_col'] : $foldercolumns[$setUp->getConfig('folderdeforder', 'alpha')];
    $default_dir_order = ($foldertableconfig['sort_dir_col'] === 1) ? 'asc' : 'desc';
    $foldertableconfig['sort_dir_order'] = isset($_SESSION['sort_dir_order']) ? $_SESSION['sort_dir_order'] : $default_dir_order; 

    $foldertableconfig['paginate'] = $setUp->getConfig('show_pagination_folders') ? 'on' : 'off';
    $foldertableconfig['pagination_type'] = ($setUp->getConfig('show_pagination_num_folder') === true) ? 'full_numbers' : 'simple';
    $foldertableconfig['search'] = filter_input(INPUT_GET, 'sd', FILTER_SANITIZE_STRING);

    $foldercoulmns = array();

    $foldercoulmns[] = array(
        'orderable' => false,
        'class' => 'icon nowrap folder-badges',
        'data' => 'counter',
    );
    $foldercoulmns[] = array(
        'class' => 'name',
        'data' => 'folder_name',
    );
    $foldercoulmns[] = array(
        'class' => 'hidden-xs mini reduce nowrap',
        'data' => 'last_change',
    );

    if ($location->editAllowed()) { 
        // Mobile menu.
        if (($setUp->getConfig("download_dir_enable") === true && $gateKeeper->isAllowed('download_enable'))
            || $gateKeeper->isAllowed('rename_dir_enable')
            || $gateKeeper->isAllowed('delete_dir_enable')
        ) {   
            $foldercoulmns[] = array(
                'orderable' => false,
                'class' => 'text-right visible-xs',
                'data' => 'mini_menu',
            );
        }
        if ($setUp->getConfig("download_dir_enable") === true && $gateKeeper->isAllowed('download_enable')) {
            $foldercoulmns[] = array(
                'orderable' => false,
                'class' => 'text-center hidden-xs',
                'data' => 'download_dir',
            );
        }
        if ($gateKeeper->isAllowed('rename_dir_enable')) {
            $foldercoulmns[] = array(
                'orderable' => false,
                'class' => 'text-center hidden-xs',
                'data' => 'rename_dir',
            );
        }
        if ($gateKeeper->isAllowed('delete_dir_enable')) {
            $foldercoulmns[] = array(
                'orderable' => false,
                'class' => 'text-center hidden-xs',
                'data' => 'delete_dir',
            );
        }
    }
    $foldertableconfig['columns'] = $foldercoulmns; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            var tablesettings = <?php echo json_encode($tablesettings); ?>;
            var filetableconfig = <?php echo json_encode($filetableconfig); ?>;
            var foldertableconfig = <?php echo json_encode($foldertableconfig); ?>;

            callTables(tablesettings, filetableconfig, foldertableconfig);
            // zip folders
            callBindZip('<?php echo $setUp->getString("confirm_folder_download"); ?>');
        });
    </script>
    <?php
endif;
