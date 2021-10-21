<?php
/**
 *  Admin functions
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Admin', false)) {
    /**
     * Admin Class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Admin
    {
        /**
         * Get the url of the application
         *
         * @return url of the app
         */
        public static function getAppUrl()
        {
            /**
            * Check if http or https
            */
            if (!empty($_SERVER['HTTPS'])
                && $_SERVER['HTTPS'] !== 'off'
                || $_SERVER['SERVER_PORT'] == 443
            ) {
                $http = 'https://';
            } else {
                $http = 'http://';
            }
            /**
            * Setup the application url
            */
            $actual_link = $http.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
            $chunks = explode('vfm-admin', $actual_link);
            $cleanqs = $chunks[0];
            return $cleanqs;
        }

        /**
         * Filter IP
         *
         * @param string $ip the IP to filter
         *
         * @return validated IP or false
         */
        public function filterIP($ip)
        {
            return filter_var(trim($ip), FILTER_VALIDATE_IP);
        }

        /**
         * Return folders available inside given directory
         *
         * @param string $dir realtive path
         *
         * @return $folders array
         */
        public function getFolders($dir = '')
        {
            $directory = '.'.SetUp::getConfig('starting_dir');
            $files = array_diff(
                scandir($dir.$directory),
                array('.', '..')
            );
            $files = preg_grep('/^([^.])/', $files);

            $folders = array();

            foreach ($files as $item) {
                if (is_dir($directory.$item) && $directory.$item !== '../vfm-admin') {
                    array_push($folders, $item);
                }
            }
            return $folders;
        }

        /**
         * Return languages list as array
         *
         * @param string $dir realtive path to translations
         *
         * @return $languages array
         */
        public function getLanguages($dir = '')
        {
            global $translations_index;

            $files = glob($dir.'translations/*.php');
            $languages = array();

            foreach ($files as $item) {
                $fileinfo = Utils::mbPathinfo($item);
                $langvar = $fileinfo['filename'];
                $langname = isset($translations_index[$langvar]) ? $translations_index[$langvar] : $langvar;
                $languages[$langvar] = $langname;
            }
            return $languages;
        }


        /**
         * Update users file
         *
         * @param array $_USERS file users
         * @param array $users  updated users
         *
         * @return file updated
         */
        public function updateUsers($_USERS, $users)
        {
            global $_USERS;
            global $users;
            global $setUp;

            $usrs = '$_USERS = ';

            if (false == (file_put_contents('users/users.php', "<?php\n\n $usrs".var_export($users, true).";\n"))) {
                Utils::setError('Error writing on users/users.php, check CHMOD');
            } else {
                $_USERS = $users;
                Utils::setSuccess($setUp->getString("users_updated"));
            }
        }

        /**
         * Print alert messages
         *
         * @return the alert
         */
        public function printAlert()
        {
            $_ERROR = isset($_SESSION['error']) ? $_SESSION['error'] : false;
            $_SUCCESS = isset($_SESSION['success']) ? $_SESSION['success'] : false;
            $_WARNING = isset($_SESSION['warning']) ? $_SESSION['warning'] : false;

            if (isset($_GET['res'])) {
                $_SUCCESS = urldecode($_GET['res']);
            }

            $alert = false;
            $output = '';

            $closebutt = '<button type="button" class="close" aria-label="Close">'.'<span aria-hidden="true">&times;</span></button>';

            if ($_ERROR) {
                $alert = true;
                $output .= '<div class="alert bs-callout bs-callout-danger fade in" role="alert">
                <i class="fa fa-times"></i> '.$_ERROR.$closebutt.'</div>';
            }
            if ($_WARNING) {
                $alert = true;
                $output .= '<div class="alert bs-callout bs-callout-warning fade in" role="alert">
                <i class="fa fa-exclamation"></i> '.$_WARNING.$closebutt.'</div>';

            }
            if ($_SUCCESS) {
                $alert = true;
                $output .= '<div class="alert bs-callout bs-callout-success fade in" role="alert">
                <i class="fa fa-check"></i> '.$_SUCCESS.$closebutt.'</div>';

            }
            if ($alert === true) {
                unset($_SESSION['success']);
                unset($_SESSION['error']);
                unset($_SESSION['warning']);
                return $output;
            }
            return false;
        }

        /**
         * Upload Image
         *
         * @param string $file     file to upload
         * @param string $filename file name
         * @param bool   $svg      accept svg
         *
         * @return the file or false
         */
        public function uploadImage($file, $filename = false, $svg = true)
        {
            if (get_magic_quotes_gpc()) {
                $newimage = time().'-'.stripslashes($file['name']);
            } else {
                $newimage = time().'-'.$file['name']; 
            }
            $allowedExts = array("gif", "jpeg", "jpg", "png");

            if ($svg == true) {
                $allowedExts[] = 'svg';
            }

            $extension = strtolower(pathinfo($newimage, PATHINFO_EXTENSION));
            // $filename = strtolower(pathinfo($newimage, PATHINFO_FILENAME));

            if (!is_dir('_content/uploads/')) {
                mkdir('_content/uploads/');
            }

            if (in_array($extension, $allowedExts)) {

                $newimage = $filename ? $filename.'.'.$extension : $newimage;

                if ($file["error"] > 0) {
                    Utils::setError('Error uploading:'.$file["error"]);
                    return;
                } else {
                    move_uploaded_file($file["tmp_name"], "_content/uploads/" . $newimage);
                    Utils::setSuccess("uploaded");
                    return $newimage;
                }
            } else {
                Utils::setError('Invalid file. Allowed extensions: '.implode(", ", $allowedExts));
                return false;
            }
        }

        /**
         * Get image or transparent placeholder
         *
         * @param string $file file path to search
         *
         * @return the file or false
         */
        public function printImgPlace($file = '')
        {
            $output = 'admin-panel/images/placeholder.png';
            if (file_exists($file)) {
                $output = $file;
            }
            return $output;
        }

    }
}
