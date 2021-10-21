<?php
/**
 * Holds the informations about path location
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Search', false)) {
    /**
     * Search class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Search
    {
        /**
         * Deep search inside folders and subfolders
         *
         * @param string $path   diretory to open
         * @param string $search search term
         *
         * @return current directory
         */
        public function deepSearch($path, $search)
        {
            $result = array(
                'dirs' => array(),
                'files' => array(),
            );
            $finaldirs = array();
            $finalfiles = array();

            $directory = realpath($path);
            $search = Utils::unaccent($search);

            if ($directory) {

                $starting_dir = SetUp::getConfig('starting_dir');
                $iterator = new RecursiveDirectoryIterator($directory);
                $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
                $filter = new VfmFilterIterator($iterator);

                $all_files = new RecursiveIteratorIterator($filter, RecursiveIteratorIterator::SELF_FIRST);

                $realbase = realpath('../.'.$starting_dir);
                $shortbase = ltrim($starting_dir, './');

                $result['count_total'] = iterator_count($all_files);

                foreach ($all_files as $pathname => $fileInfo) {

                    $filename = Utils::unaccent($fileInfo->getFileName());

                    if (stripos($filename, $search) !== false) {

                        $srcqs = is_dir($pathname) ? '&sd=' : '&s=';

                        $explodelink = explode($realbase, $pathname);
                        $dirlocation = ltrim(ltrim(dirname($explodelink[1]), '.'), '/');
                        // For windows servers.
                        $dirlocation = str_replace('\\', '/', $dirlocation);
                        $linkdir = SetUp::getConfig('script_url').'?dir='.$shortbase.$dirlocation.$srcqs.$search;

                        $found = array();
                        $found['name'] = $this->highlightSearch($filename, $search);
                        $found['location'] = $dirlocation;
                        $found['link'] = $linkdir;

                        if (is_dir($pathname)) {
                            $result['dirs'][] = $found;
                        } else {
                            $result['files'][] = $found;
                        }
                    }
                }
                $result['count_filtered'] = (count($result['dirs']) + count($result['files']));
            }
            return $result;
        }

        /**
         * Highlight search term inside results
         *
         * @param string $content where to search
         * @param string $search  what to search
         *
         * @return current directory
         */
        public function highlightSearch($content, $search)
        {
            $keys = implode('|', explode(' ', $search));
            $content = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>', $content);

            return $content;
        }
    }
}
/**
 * Extend default RecursiveFilterIterator
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
class VfmFilterIterator extends RecursiveFilterIterator
{
    /**
     * Filter hidden dirs and files
     *
     * @return current directory
     */
    public function accept()
    {
        $startingdir = SetUp::getConfig('starting_dir');
        $hidefiles = strlen($startingdir) < 3 ? true : false;
        if ('.' == substr($this->current()->getFilename(), 0, 1)) {
            return false;
        }
        $hidden_stuff = array_merge(SetUp::getConfig('hidden_dirs'), SetUp::getConfig('hidden_files'));

        if ($hidefiles && in_array($this->current()->getFilename(), $hidden_stuff)) {
            return false;
        }
        return true;
    }
}
