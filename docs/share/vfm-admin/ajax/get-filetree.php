<?php
/**
 * VFM - veno file manager: ajax/get-filetree.php
 *
 * Display folder tree
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
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}
require_once '../config.php';
require_once '../users/users.php';

require_once '../class/class.utils.php';
require_once '../class/class.setup.php';
require_once '../class/class.gatekeeper.php';
require_once '../class/class.actions.php';

$setUp = new SetUp();

$currentdir = filter_input(INPUT_POST, 'currentdir', FILTER_SANITIZE_STRING);
$__root = filter_input(INPUT_POST, '__root', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

$movedir = $setUp->getConfig('starting_dir');

$href = ($action == 'breadcrumbs') ? true : false;
$movelink = ($action == 'breadcrumbs') ? '' : 'movelink';

// check if any folder is assigned to the current user
if (GateKeeper::getUserInfo('dir') !== null) {
    $userpatharray = array();
    $userpatharray = json_decode(GateKeeper::getUserInfo('dir'), true);

    $output = '<div class="wrap-foldertree"><span class="toggle-all-tree"><i class="fa fa-minus-square tree-toggler"></i></span>';

    // Natural sort order
    natcasesort($userpatharray);
    // show all available directories trees
    foreach ($userpatharray as $userdir) {
        $path = $setUp->getConfig('starting_dir').$userdir.'/';

        $output .= '<ul class="foldertree">';
        $output .= '<li class="folderoot">';

        if ($path === $currentdir) { 
            $output .= '<i class="fa fa-folder-open"></i> <span class="search-highlight">'.$userdir.'</span>';
        } else { 
            $output .= '<a href="?dir='.ltrim($path, './').'" data-dest="'.urlencode($path).'" class="'.$movelink.'">';
            $output .= '<i class="fa fa-folder-o"></i> '.$userdir;
            $output .= '</a>';
        }
        $output .= Actions::walkDir($path, $currentdir, $href, '../.');
        $output .= '</li></ul>';
    }
    $output .= '</div>';

    echo json_encode($output);

} else {
    // no directory assigned, access to all folders
    $movedir = $setUp->getConfig('starting_dir');
    $cleandir = substr(
        $setUp->getConfig('starting_dir'), 2
    );
    $cleandir = substr_replace($cleandir, '', -1); 
    $cleandir = strlen($cleandir) > 0 ? $cleandir : $__root;

    $output = '<div class="wrap-foldertree"><span class="toggle-all-tree"><i class="fa fa-minus-square tree-toggler"></i></span>';

    $output .= '<ul class="foldertree">';
    $output .= '<li class="folderoot">';

    if ($movedir === $currentdir) {
        $output .= '<i class="fa fa-folder-open"></i> <span class="search-highlight">'.$cleandir.'</span>';
    } else {
        $output .= '<a href="?dir='.ltrim($movedir, './').'" data-dest="'.urlencode($movedir).'" class="'.$movelink.'">';
        $output .= '<i class="fa fa-folder-o"></i> '.$cleandir;
        $output .= '</a>';
    }

    $output .= Actions::walkDir($movedir, $currentdir, $href, '../.');
    $output .= '</li></ul></div>';
    
    echo json_encode($output);
}
exit;
