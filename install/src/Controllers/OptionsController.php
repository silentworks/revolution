<?php

namespace MODX\Installer\Controllers;

use MODX\Installer\HttpResponder;
use MODX\Installer\Services\Settings;
use MODX\Installer\Util;
use Slim\Http\Request;

class OptionsController
{
    /**
     * @var \MODX\Installer\HttpResponder
     */
    private $responder;

    /**
     * @var \MODX\Installer\Util
     */
    private $util;

    /**
     * @var \Slim\Http\Request
     */
    private $request;

    /**
     * @var string
     */
    private $installPath;

    /**
     * @var string
     */
    private $setupKey;

    /**
     * @var string
     */
    private $configKey;

    /**
     * @var string
     */
    private $corePath;
    /**
     * @var \MODX\Installer\Services\Settings
     */
    private $settings;

    /**
     * WelcomeAction constructor.
     * @param \MODX\Installer\HttpResponder $responder
     * @param \MODX\Installer\Util $util
     * @param \Slim\Http\Request $request
     * @param \MODX\Installer\Services\Settings $settings
     * @param array $config
     */
    public function __construct(
        HttpResponder $responder,
        Util $util,
        Request $request,
        Settings $settings,
        array $config = []
    ) {
        $this->responder = $responder;
        $this->util = $util;
        $this->request = $request;
        $this->settings = $settings;
        $this->corePath = $config['corePath'];
        $this->installPath = $config['installPath'];
        $this->setupKey = $config['setupKey'];
        $this->configKey = $config['configKey'];
    }

    public function index()
    {
        $defaultFolderPerms = sprintf("%04o", 0777 & (0777 - umask()));
        $defaultFilePerms = sprintf("%04o", 0666 & (0666 - umask()));

        $installMode = $this->settings->get('installmode', 0);

        $filesExist = 0;
        if (file_exists($this->installPath . 'manager/index.php') &&
            file_exists($this->installPath . 'index.php') &&
            file_exists($this->installPath . 'connectors/index.php')
        ) {
            $filesExist = $this->setupKey !== '@advanced@' ? 1 : 0;
        }

        $manifest= 0;
        if (file_exists($this->corePath . 'packages/core/manifest.php')) {
            $zipTime = filemtime($this->corePath . 'packages/core.transport.zip');
            $manifestTime = filemtime($this->corePath . 'packages/core/manifest.php');
            $manifest= $manifestTime <= $zipTime && $zipTime - 60 < $manifestTime ? 1 : 0;
        }

        $unpacked= 0;
        if ($manifest && file_exists($this->corePath . 'packages/core/modWorkspace/')) {
            $unpacked= 1;
        }

        $settings = $this->settings->fetch();
        $newFolderPerms = !empty($settings['new_folder_permissions']) ? $settings['new_folder_permissions'] : $defaultFolderPerms;
        $newFilePerms = !empty($settings['new_file_permissions']) ? $settings['new_file_permissions'] : $defaultFilePerms;

        return $this->responder->render('options', [
            'installmode' => $installMode,
            'unpacked' => $unpacked,
            'manifest' => $manifest,
            'files_exist' => $filesExist,
            'config_key' => $this->request->post('config_key', $this->configKey),
            'new_folder_permissions' => $newFolderPerms,
            'new_file_permissions' => $newFilePerms,
            'default_folder_permissions' => $defaultFolderPerms,
            'default_file_permissions' => $defaultFilePerms,
            'writableError' => !$this->util->isSetupConfigWritable(),
        ]);
    }
}