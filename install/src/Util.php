<?php

namespace MODX\Installer;

use DirectoryIterator;

class Util
{
    /**
     * @var string
     */
    private $corePath;

    /**
     * @var string
     */
    private $setupPath;

    /**
     * @var string
     */
    private $lexiconPath;

    /**
     * Util constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->lexiconPath = $config['lexiconPath'];
        $this->setupPath = $config['setupPath'];
        $this->corePath = $config['corePath'];
    }

    public function getMODXVersion($key)
    {
        $currentVersion = include $this->corePath . '/docs/version.inc.php';
        return isset($currentVersion[$key]) ? $currentVersion[$key] : false;
    }

    public function getAvailableLanguages()
    {
        $languages = array();

        /** @var DirectoryIterator $file */
        foreach (new DirectoryIterator($this->lexiconPath) as $file) {
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

    /**
     * Check if setup config file is writable
     *
     * @return bool
     */
    public function isSetupConfigWritable()
    {
        return is_writable($this->setupPath . 'config.core.php');
    }

    /**
     * @param $configKey
     * @return bool|int
     */
    public function updateSetupConfigKey($configKey = 'config')
    {
        $content = file_get_contents($this->setupPath . 'config.core.php');
        $pattern = "/define\s*\(\s*'MODX_CONFIG_KEY'\s*,.*\);/";
        $replacement = "define ('MODX_CONFIG_KEY', '{$configKey}');";
        $content = preg_replace($pattern, $replacement, $content);
        return file_put_contents($this->setupPath . 'config.core.php', $content);
    }
}