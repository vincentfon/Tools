<?php
function fonTestAddXhprof() {
	if(!class_exists('Tools')) { 
		require('D:\wamp\www\mllwork\meilele_admin\admin\includes\lib_Tools.php'); 
	} # 引入工具
    if(!class_exists('RuleDb')) { 
    	require('D:\wamp\www\mllwork\meilele_admin\admin\includes\lib_RuleDb.php'); 
    } # 引入数据库
	$xhprof_runs = new XHProfRuns_Default();
	$xhprof_data = xhprof_disable();
	$xhprof_id   = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");
	$data = array(
		'run_id'   => $xhprof_id,
		'link'     => "http://e.meilele.com/xhprof_html/index.php?source=xhprof_foo&run={$xhprof_id}",
		'url'      => $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'],
		'get'      => $_SERVER['QUERY_STRING'],
		'post'     => json_encode($_POST),
		'add_time' => time(),
		'bt'       => '',
	);
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=localhost","root",""); 
	$pdo->exec("insert into fon_xhprof_data values('','{$data['run_id']}','{$data['link']}','{$data['url']}','{$data['get']}','{$data['post']}','{$data['add_time']}')");
}