<?php
/**
 * Manage zip archives
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Zipper', false)) {
    /**
     * Zipper class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Zipper
    {
        /**
         * Create ZIP archive
         *
         * @param array  $files    files array to download
         * @param string $folder   folder path or false
         * @param string $relative specific path for logging
         *
         * @return file served
         */
        public function createZip(
            $files = false,
            $folder = false,
            $relative = ''
        ) {
            $response = array('error' => false);

            global $setUp;

            @set_time_limit(0);

            $script_url = $setUp->getConfig('script_url');
            $maxfiles = $setUp->getConfig('max_zip_files');
            $maxfilesize = $setUp->getConfig('max_zip_filesize');
            $starting_dir = $setUp->getConfig('starting_dir');
            $maxbytes = $maxfilesize*1024*1024;

            if ($files && is_array($files)) {
                $totalsize = 0;
                $filesarray = array();
                foreach ($files as $pezzo) {
                    // Keep files inside main dir and avoid tricky injections.
                    $cleanfile = ltrim(urldecode(base64_decode($pezzo)), './');
                    if ($starting_dir == './') {
                        $cleanfile = ltrim($cleanfile, 'vfm-admin/');
                    }
                    $myfile = "../../".$cleanfile;
                    if (file_exists($myfile)) {
                        $totalsize = $totalsize + Utils::getFileSize($myfile);
                        array_push($filesarray, $myfile);
                    }
                }
                $howmany = count($filesarray);
            }

            if ($folder) {

                $folder = ltrim($folder, './');
                if ($starting_dir == './') {
                    $folder = ltrim($folder, 'vfm-admin/');
                }

                $folderpath = "../../".$folder;

                if (!is_dir($folderpath)) {
                    $response['error'] = '<strong>'.$folder.'</strong> does not exist';
                    return $response;
                }

                $folderpathinfo = Utils::mbPathinfo($folder);
                $folderbasename = Utils::checkMagicQuotes($folderpathinfo['filename']);

                // Create recursive directory iterator
                $filesarray = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($folderpath),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );
                $foldersize = Utils::getDirSize($folderpath);
                $totalsize = $foldersize['size'];
                $howmany = 0;
                foreach ($filesarray as $piece) {
                    if (!is_dir($piece)) {
                        $howmany++;
                    }
                }
            }

            $response['totalsize'] = $totalsize;
            $response['numfiles'] = $howmany;

            // skip if size or number exceedes
            if ($totalsize > $maxbytes) {
                $response['error'] = '<strong>'.$setUp->formatsize($totalsize).'</strong>: '
                .$setUp->getString('size_exceeded').'<br>(&lt; '.$setUp->formatsize($maxbytes).')';
                return $response;
            }
            if ($howmany > $maxfiles) {
                $response['error'] = '<strong>'.number_format($howmany).'</strong>: '
                .$setUp->getString('too_many_files').' '.number_format($maxfiles);
                return $response;
            }

            if ($howmany < 1) {
                $response['error'] = '<i class="fa fa-files-o"></i> - <strong>0</strong>';
                return $response;
            }
            // create /tmp/ folder if needed
            if (!is_dir($relative.'tmp')) {
                if (!mkdir('tmp', 0755)) {
                    $response['error'] = 'Cannot create a tmp dir for .zip files';
                    return $response;
                }
            }

            // create temp zip
            $file = tempnam($relative.'tmp', 'zip_');

            if (!$file) {
                $response['error'] = 'Cannot create: tempnam("tmp","zip") from createZip()';
                return $response;
            }

            $zip = new ZipArchive();

            if ($zip->open($file, ZipArchive::OVERWRITE) !== true) {
                $response['error'] = 'cannot open: '.$file;
                return $response;
            }

            session_write_close();

            $counter = 0;
            $logarray = array();

            foreach ($filesarray as $piece) {

                $filepathinfo = Utils::mbPathinfo($piece);
                $basename = Utils::checkMagicQuotes($filepathinfo['filename']).'.'.$filepathinfo['extension'];

                // Skip directories (they would be added automatically)
                if (!is_dir($piece) && file_exists($piece)) {
                    $counter++;
                    if ($counter > 100) {
                        $zip->close();
                        $zip->open($file, ZipArchive::CHECKCONS);
                        $counter = 0;
                    }
                    // Add current file to archive
                    if ($folder) {
                        $relativePath = substr($piece, strlen($folderpath));
                        $zip->addFile($piece, $relativePath);
                    } else {
                        $zip->addFile($piece, $basename);
                        array_push($logarray, './'.ltrim($piece, './'));
                    }
                }
            }
            $zip->close();

            // delete tmp file if is older than 4 hours 
            $oldtmp = glob($relative.'tmp/*');
            foreach ($oldtmp as $oldfile) {
                if (is_file($oldfile)) {
                    if (filemtime($oldfile) < time() - 60*60*4) {
                        unlink($oldfile);
                    }
                }
            }

            $response['dir'] = $folder;
            $response['file'] = basename($file);

            if ($folder) {
                array_push($logarray, './'.ltrim($folder, './'));
            }
            $response['logarray'] = $logarray;
            return $response;
        }
    }
}
