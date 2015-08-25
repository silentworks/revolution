<?php

namespace MODX\Installer;

use DirectoryIterator;

class Util
{
    /**
     * @var array
     */
    private $config;

    /**
     * Util constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getMODXVersion($key)
    {
        $currentVersion = include MODX_CORE_PATH . '/docs/version.inc.php';
        return isset($currentVersion[$key]) ? $currentVersion[$key] : false;
    }

    public function getAvailableLanguages()
    {
        $languages = array();

        /** @var DirectoryIterator $file */
        foreach (new DirectoryIterator($this->config['lexiconPath']) as $file) {
            $basename = $file->getFilename();
            if (!in_array($basename,
                array('.', '..', '.htaccess', '.svn', '.git')) && $file->isDir()
            ) {
                if (file_exists($file->getPathname() . '/default.inc.php')) {
                    $languages[] = $basename;
                }
            }
        }
        sort($languages);

        return $languages;
    }
}