<?php

namespace MODX\Installer\Services;

class Lexicon
{
    /**
     * @var array
     */
    private $config = [
        'lexiconPath' => '../../lang/'
    ];

    protected $lexicon = [];

    /**
     * Lexicon constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            $this->config = $config;
        }
    }

    /**
     * Accessor method for the lexicon array.
     *
     * @access public
     * @param string $prefix If set, will only return the lexicon entries with this prefix.
     * @param boolean If true, will strip the prefix from the returned indexes
     * @return array The internal lexicon.
     */
    public function fetch($prefix = '', $removePrefix = false)
    {
        if (!empty($prefix)) {
            $lex = [];
            $lang = $this->lexicon;
            foreach ($lang as $k => $v) {
                if (strpos($k, $prefix) !== false) {
                    $key = $removePrefix ? str_replace($prefix, '', $k) : $k;
                    $lex[$key] = $v;
                }
            }
            return $lex;
        }
        return $this->lexicon;
    }

    /**
     * Returns the currently specified language.
     * @return string The IANA language code
     */
    public function getLanguage()
    {
        $language = 'en';
        if (isset($_COOKIE['modx_setup_language'])) {
            $language= $_COOKIE['modx_setup_language'];
        }
        return $language;
    }

    /**
     * Loads a lexicon topic.
     *
     * @param string/array $topics A string name of a topic (or an array of topic names)
     * @return boolean True if successful.
     */
    public function load($topics)
    {
        $loaded = false;
        $language = $this->getLanguage();

        if (!is_array($topics)) {
            $topics = [$topics];
        }

        foreach ($topics as $topic) {
            $topicFile = $this->config['lexiconPath'] . $language . '/' . $topic . '.inc.php';
            if (file_exists($topicFile)) {
                $loaded = false;
                $_lang = [];

                include $topicFile;

                if (is_array($_lang) && !empty($_lang)) {
                    $this->lexicon = array_merge($this->lexicon, $_lang);
                    $loaded = true;
                }
            }
        }
        return $loaded;
    }
}