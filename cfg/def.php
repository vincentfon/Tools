<?php
define('DS', DIRECTORY_SEPARATOR);
define('F_ROOT_PATH', rtrim(dirname(__FILE__), 'cfg'));
define('F_ROOT_LIBS', rtrim(dirname(__FILE__), 'cfg') . 'libs' . DS);


# smarty定义开始
define('SMARTY_DIR', F_ROOT_PATH . 'libs' . DS);
define('SMARTY_SYSPLUGINS_DIR', SMARTY_DIR . 'smartSysPlugins' . DS);
define('SMARTY_PLUGINS_DIR', SMARTY_DIR . 'smartPlugins' . DS);
define('SMARTY_DEBUG_TPL', SMARTY_DIR . 'debug.tpl');

define('SMARTY_TEMPLATES_DIR', F_ROOT_PATH . 'templates' . DS);
define('SMARTY_TEMPLATES_C_DIR', F_ROOT_PATH . 'templates' . DS . 'templates_c' . DS);
define('SMARTY_CACHE_DIR', F_ROOT_PATH . 'templates' . DS . 'templates_cache' . DS);
define('SMARTY_CONFIGS_DIR', F_ROOT_PATH . 'cfg' . DS . 'smartyCfg' . DS);

