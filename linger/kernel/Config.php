<?php
/*
 |------------------------------------------------------------------
 | linger.iliubang.cn
 |------------------------------------------------------------------
 | @author    : liubang
 | @date      : 16/3/26 下午11:09
 | @copyright : (c) iliubang.cn
 | @license   : MIT (http://opensource.org/licenses/MIT)
 |------------------------------------------------------------------
 */

namespace linger\kernel;

class Config implements \ArrayAccess
{

        /**
         * Global configuration
         *
         * @var array
         */
        private $g_config = [];

        /**
         * config file or config array
         *
         * @var string
         */
        private $prepare = null;

        /**
         * @var null|self
         */
        private static $instance = null;


        private function __construct()
        {
        }

        /**
         * @return Config|null
         */
        public static function getInstance()
        {
                if (!self::$instance instanceof self) {
                        self::$instance = new self();
                }

                return self::$instance;
        }

        /**
         * @param $opt
         * @return $this
         */
        public function prepare($opt)
        {
                $this->prepare = $opt;

                return $this;
        }


        /**
         * @param string $file
         * @param bool   $processSections
         * @param int    $scannerMode
         *
         * @return array|mixed
         */
        private static function parseIniFile($file, $processSections = FALSE, $scannerMode = INI_SCANNER_NORMAL)
        {
                $explodeStr = '.';
                $escapeChar = "'";
                $data = \parse_ini_file($file, $processSections, $scannerMode);
                if (!$processSections) {
                        $data = [$data];
                }
                foreach ($data as $sectionKey => $section) {
                        foreach ($section as $key => $value) {
                                if (\strpos($key, $explodeStr)) {
                                        if (\substr($key, 0, 1) !== $escapeChar) {
                                                $subKeys = \explode($explodeStr, $key);
                                                $subs = &$data[$sectionKey];
                                                foreach ($subKeys as $subKey) {
                                                        if (!isset($subs[$subKey])) {
                                                                $subs[$subKey] = '';
                                                        }
                                                        $subs = &$subs[$subKey];
                                                }
                                                $subs = $value;
                                                unset($data[$sectionKey][$key]);
                                        } else {
                                                $newKey = \trim($key, $escapeChar);
                                                $data[$sectionKey][$newKey] = $value;
                                                unset($data[$sectionKey][$key]);
                                        }
                                }
                        }
                }
                if (!$processSections) {
                        $data = $data[0];
                }
                return $data;
        }

        /**
         * @param $config
         *
         * @return array
         */
        private static function changeArrayKeyCase($config)
        {
                $arr = [];
                foreach ($config as $key => $val) {
                        $key = \strtolower($key);
                        $arr[$key] = \is_array($val) ? self::changeArrayKeyCase($val) : $val;
                }
                return $arr;
        }


        /**
         * @return $this
         * @throws \Exception
         */
        public function loadConfig()
        {
                $config = $this->prepare;

                if (\is_string($config)) {
                        if (\is_file($config)) {
                                $ext = \substr($config, \strlen($config) - 4);
                                if ($ext === '.ini') {
                                        $config = self::parseIniFile($config);
                                }
                                if ($ext === '.php') {
                                        $config = require $config;
                                }
                        } else {
                                throw new \Exception("File {$config} not exist!");
                        }
                }
                if (\is_array($config)) {
                        $this->g_config = \array_merge(require LINGER_ROOT . '/conf/config.php', $config);
                } else {
                        throw new \Exception('Requires a file or an array as a parameter');
                }

                $this->g_config = self::changeArrayKeyCase($this->g_config);

                return $this;
        }

        /**
         * get config
         *
         * @param string $key
         *
         * @return array|bool
         */
        public function get($key = '')
        {
                if (empty($key)) {
                        return $this->g_config;
                }
                $key = \strtolower($key);
                if (\strpos($key, '.')) {
                        $val = $this->g_config;
                        $keys = \explode('.', $key);
                        foreach ($keys as $key) {
                                if (isset($val[$key])) {
                                        $val = $val[$key];
                                } else {
                                        return FALSE;
                                }
                        }
                        return $val;
                }
                return $this->g_config[$key];
        }

        /**
         * set config
         *
         * @param string $key
         * @param string $val
         */
        public function set($key, $val = '')
        {
                if (empty($val)) {
                        $this->g_config = self::changeArrayKeyCase($key);
                } else {
                        $key = \strtolower($key);
                        $this->g_config[$key] = $val;
                }
        }

        /**
         * $config = linger\kernel\Config::singleton();
         * isset($config['key'])
         *
         * @param mixed $offset
         *
         * @return bool
         */
        public function offsetExists($offset)
        {
                return isset($this->g_config[$offset]);
        }

        /**
         * $config = linger\kernel\Config::singleton();
         * $val = $config['key'];
         *
         * @param mixed $offset
         *
         * @return mixed
         */
        public function offsetGet($offset)
        {
                return $this->g_config[$offset];
        }

        /**
         * $config = linger\kernel\Config::singleton();
         * $config['key'] = $val;
         *
         * @param mixed $offset
         * @param mixed $value
         */
        public function offsetSet($offset, $value)
        {
                $this->g_config[$offset] = $value;
        }

        /**
         * $config = linger\kernel\Config::singleton();
         * unset($config['key']);
         *
         * @param mixed $offset
         */
        public function offsetUnset($offset)
        {
                unset($this->g_config[$offset]);
        }

}
