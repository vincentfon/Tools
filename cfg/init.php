<?php
date_default_timezone_set('PRC');

error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

ini_set('session.cache_expire',  180);
ini_set('session.use_trans_sid', 0);
ini_set('session.use_cookies',   1);
ini_set('session.auto_start',    0);
ini_set('max_execution_time',    0);

# 功能开启
session_start();

# 基本配置
$load = array();
$load['file']['cfg'][] = 'cfg.php'; # 密码等等敏感信息定义
$load['file']['cfg'][] = 'def.php'; # 系统级常量定义
$load['file']['cfg'][] = 'fun.php'; # 常用的便捷函数定义

$load['file']['libs'][] = 'Smarty.class.php';
$load['file']['libs'][] = 'MysqliDb.php'; 

# 加载核心文件
foreach($load['file'] as $path => $files) {
	foreach($files as $file) {
		require("../{$path}/{$file}");
	}
}

# 定义使用全局变量
$smarty = new smarty();
$db     = new MysqliDb(
	$load['mysql']['host'],
	$load['mysql']['username'],
	$load['mysql']['password'],
	$load['mysql']['db'],
	$load['mysql']['port']
);

# 注销一些变量
unset($load['mysql']);

