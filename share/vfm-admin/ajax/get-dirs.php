<?php
/**
 * VFM - veno file manager: ajax/get-dirs.php
 * Send folders to datatables
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
require_once '../class/class.location.php';

$setUp = new SetUp();

require_once "../translations/".$setUp->lang.".php";

$gateKeeper = new GateKeeper();

$response = array();
$totaldata = array();
$response['recordsTotal'] = 0;
$response['recordsFiltered'] = 0;

$request = $_GET;
$location = new Location('../../'.$request['dir']);

if ($gateKeeper->isAccessAllowed() && $gateKeeper->isAllowed('viewdirs_enable')) {

    // $fullpath = str_replace('\\', '/', dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME']))))."/".$location->getDir(false, false, false, 0);
    $fullpath = $location->getFullPath();
    $searchvalue = filter_var($request['search']['value'], FILTER_SANITIZE_STRING);

    include_once '../class/class.dir.php';
    include_once '../class/class.dirs.php';

    $thedirs = new Dirs($location, $fullpath, '../../');
    $getdirs = $thedirs->dirs;

    $response ['recordsTotal'] = count($getdirs);
    $response["draw"] = isset($request['draw']) ? intval($request['draw']) : 0;

    $length = isset($request['length']) ? intval($request['length']) : 10;
    $start = isset($request['start']) ? intval($request['start']) : 0;
    $sortby = isset($request['order'][0]['column']) ? intval($request['order'][0]['column']) : 1;
    $orderdir = isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'desc';
    $search = strlen($searchvalue) > 1 ? $searchvalue : false;
    // Search item
    if ($search) {
        $search = Utils::unaccent($search);
        foreach ($getdirs as $key => $getdir) {
            $unaccent = Utils::unaccent(Utils::normalizeName($getdir->getNameHtml()));
            if (stripos($unaccent, $search) === false) {
                unset($getdirs[$key]);
            }
        }
    } 
    // Sort by date
    if ($sortby == 2) {
        usort(
            $getdirs, 
            function ($a, $b) {
                return $a->getModTime() - $b->getModTime();
            }
        );
    }

    // Sort by name
    if ($sortby == 1) {
        usort(
            $getdirs, 
            function ($a, $b) {
                return strnatcasecmp($a->getNameHtml(), $b->getNameHtml());
            }
        );
    }
    // Reverse sorting
    if ($orderdir == 'desc') {
        $getdirs = array_reverse($getdirs);
    }

    $alt = $setUp->getConfig('salt');
    $altone = $setUp->getConfig('session_name');

    $response ['recordsFiltered'] = count($getdirs);

    $counter = 0;
    $totcounter = 0;

    foreach ($getdirs as $key => $dir) {

        $totcounter++;
        // Start output at start paging
        if ($totcounter > $start) {
            $counter++;
            // Exit if reach length
            if ($length !== -1 && $counter > $length) {
                break;
            }

            $data = array();

            $dirname = $dir->getName();
            $normalized = Utils::normalizeName($dirname);
            $dirpath = $fullpath.$dirname;
            $dirtime = $setUp->formatModTime($dir->getModTime());
            $nameencoded = $dir->getNameEncoded();
            $locationDir = $location->getDir(false, true, false, 0);
            $del = $locationDir.$nameencoded;
            $delquery = base64_encode($del);
            $cash = md5($delquery.$alt.$altone);
            $thislink = $location->makeLink(false, null, $del);
            $thisdel = $location->makeLink(false, $del, $locationDir);
            $thisdir = urldecode($locationDir);
            $dash = md5($alt.base64_encode($thisdir.$normalized).$altone);

            if ($setUp->getConfig("show_folder_counter") === true) {
                $quanti = $dir->countContents('../../'.$location->getDir(false, false, false, 0).$dirname);
                $quantifiles = $quanti['files'];
                $quantedir = $quanti['folders'];
                $data['counter'] = '<a href="'.$thislink.'"><span class="badge"><i class="fa fa-folder-o"></i> '.$quantedir.'</span>
                <span class="badge"><i class="fa fa-files-o"></i> '.$quantifiles.'</span></a>';
            } else { 
                $data['counter'] = '';
            }

            $data['folder_name'] = '<div class="relative">
            <a class="full-lenght" href="'.$thislink.'"><span class="icon text-center"><i class="fa fa-folder fa-lg fa-fw"></i> '.$normalized.'</span></a>
            <span class="hover"><i class="fa fa-folder-open-o fa-fw"></i></span></div>';

            $data['last_change'] = $dirtime;

            // Mobile dropdown.
            if ($setUp->getConfig('download_dir_enable')
                || $gateKeeper->isAllowed('rename_dir_enable')
                || $gateKeeper->isAllowed('delete_dir_enable')
            ) {
                $data['mini_menu'] = '<div class="dropdown"><a class="round-butt butt-mini dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i></a><ul class="dropdown-menu dropdown-menu-right">';
                
                if ($setUp->getConfig("download_dir_enable") === true && $gateKeeper->isAllowed('download_enable')) {
                    $data['mini_menu'] .= '<li>
                    <a class="zipdir" data-zip="'.base64_encode($thisdir.$normalized).'" data-dash="'.$dash.'" data-thisname="'.$normalized.'" href="javascript:void(0)">
                    <i class="fa fa-cloud-download"></i> '.$setUp->getString("download").'</a></li>';
                }       
                if ($gateKeeper->isAllowed('rename_dir_enable')) {
                    $data['mini_menu'] .= '<li>
                    <a class="rename" data-thisdir="'.$thisdir.'" data-thisname="'.$normalized.'" href="javascript:void(0)" >
                    <i class="fa fa-edit"></i> '.$setUp->getString("rename").'</a></li>';
                }
                if ($gateKeeper->isAllowed('delete_dir_enable')) {
                    $data['mini_menu'] .= '<li><a class="del" data-link="'.$thisdel.'&h='.$cash.'&fa='.$delquery.'" data-name="'.$normalized.'" href="javascript:void(0)">
                    <i class="fa fa-trash-o"></i> '.$setUp->getString("delete").'</a></li>';
                }
                $data['mini_menu'] .= '</ul></div></td>';
            } // END mobile dropdown.

            if ($setUp->getConfig("download_dir_enable") && $gateKeeper->isAllowed('download_enable')) {
                $data['download_dir'] = '<button class="round-butt butt-mini zipdir" data-zip="'.base64_encode($thisdir.$normalized).'" data-dash="'.$dash.'" data-thisname="'.$normalized.'">
                <i class="fa fa-cloud-download"></i></button>';
            }
            if ($gateKeeper->isAllowed('rename_dir_enable')) {
                $data['rename_dir'] = '
                <button class="round-butt butt-mini rename" data-thisdir="'.$thisdir.'" data-thisname="'.$normalized.'">
                <i class="fa fa-pencil-square-o"></i></button>';
            }
            if ($gateKeeper->isAllowed('delete_dir_enable')) {
                $data['delete_dir'] = '<button class="round-butt butt-mini del" data-name="'.$normalized.'" data-link="'.$thisdel.'&h='.$cash.'&fa='.$delquery.'">
                <i class="fa fa-times"></i></button>';
            }
            array_push($totaldata, $data);
        } // end service menu
    } // END foreach dir 
} // end allowed

$response['data'] = $totaldata;

echo json_encode($response);
exit;
