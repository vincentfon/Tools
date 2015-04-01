<?php
if(!function_exists('p')) {
    function p() {
        $ret = '<pre>';
        $args = func_get_args();//获得传入的所有参数的数组
        foreach ($args as $v) {
            $ret .= print_r($v, true);
        }
        $ret .= '</pre>';
        echo $ret;
        exit;
    }
}

if(!function_exists('v')) {
    function v() {
        $args = func_get_args();//获得传入的所有参数的数组
        foreach ($args as $v) {
            var_dump($v)	;
        }
        exit;
    }
}

if(!function_exists('c')) {
    function c( $arrayA , $arrayB ) { 
        sort( $arrayA ); 
        sort( $arrayB ); 

        return $arrayA == $arrayB; 
    } 
}

if(!function_exists('m')) {
    function m() {
        $post_ori = array();
        $post_str = file_get_contents("php://input");
        parse_str($post_str, $post_ori);
        $post_str = empty($post_str) ? $_POST : $post_str;
        echo '<pre>';
        echo '<h3>URL</h3>';
        echo '<textarea style="width:500px; height:100px;" name="url">' . $_SERVER['SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING'] . '</textarea>';
        echo '<h3>POSTJSON</h3>';
        echo '<textarea style="width:500px; height:100px;" name="con">' . json_encode($post_ori) . '</textarea>';
        exit;
    }
}

if(!function_exists('mm')) {
	function mm() {
		echo ToolObg::getHead();
        $url      = trim($_POST['url']); # 请求链接
		echo ToolObg::show_table("请求模拟", array(
			'act' => array(
				'name'  => 'act',
				'value' => 'simple_mulit_request',
				'type'  => 'hidden',
			),
			'链接:' => array(
				'name'  => 'url',
				'value' =>  $_SERVER['SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING'],
			),
			'次数:' => array(
				'name'  => 'times',
				'value' => 1,
			),
			'超时:' => array(
				'name'  => 'time_out',
				'value' => 20,
			),
			'数据:' => array(
				'name'  => 'con',
				'value' => json_encode($_POST),
				'type'  => 'textarea',
			),
		), '', true, '/admin/fb.php?act=simple_mulit_request');
		exit;
    }  
}

if(!function_exists('c')) {
    function c( $arrayA , $arrayB ) { 
        sort( $arrayA ); 
        sort( $arrayB ); 

        return $arrayA == $arrayB; 
    } 
}

if(!function_exists('f')) {
    function f() {
    	$post_ori = array();
     	parse_str(file_get_contents("php://input"), $post_ori);
        $post_ori_j = json_encode($post_ori);
        $arg = var_export(func_get_args(), true);
        $tag = str_repeat("-", 100);

		$filename = 'D:/wamp/www/log/' . date("Y-m-d", time());
		$old_con  = file_get_contents($filename);
		$handle   = fopen($filename, 'w+');
        $con =  date('Y-m-d H:i:s') . "\n";
		$con .= "URL:\n{$_SERVER['SCRIPT_URI']}?{$_SERVER['QUERY_STRING']}\n\n";
		$con .= "POST:\n{$post_ori_j}\n\n";
		$con .= "ARG:\n{$arg}\n";
        $con .= "{$tag}\n";
        $con .= $old_con;
        fwrite($handle, $con);
        fclose($handle);
    }
}

if(!function_exists('fr')) {
    function fr() {
    	$post_ori = array();
     	parse_str(file_get_contents("php://input"), $post_ori);
        $post_ori_j = json_encode($post_ori);
        $arg = print_r(func_get_args(), true);
        $tag = str_repeat("-", 100);

		$filename = 'D:/wamp/www/log/' . date("Y-m-d", time()) . 'rule';
		$old_con  = file_get_contents($filename);
		$handle   = fopen($filename, 'w+');
        $con =  date('Y-m-d H:i:s') . "\n";
		$con .= "URL:\n{$_SERVER['SCRIPT_URI']}?{$_SERVER['QUERY_STRING']}\n\n";
		$con .= "POST:\n{$post_ori_j}\n\n";
		$con .= "ARG:\n{$arg}\n";
        $con .= "{$tag}\n";
        $con .= $old_con;
        fwrite($handle, $con);
        fclose($handle);
    }
}

if(!function_exists('fdo')) {
    function fdo() {
    	$post_ori = array();
     	parse_str(file_get_contents("php://input"), $post_ori);
        $post_ori_j = json_encode($post_ori);
        $arg = print_r(func_get_args(), true);
        $tag = str_repeat("-", 100);

		$filename = 'D:/wamp/www/log/' . date("Y-m-d", time()) . 'doc';
		$old_con  = file_get_contents($filename);
		$handle   = fopen($filename, 'w+');
        $con =  date('Y-m-d H:i:s') . "\n";
		$con .= "URL:\n{$_SERVER['SCRIPT_URI']}?{$_SERVER['QUERY_STRING']}\n\n";
		$con .= "POST:\n{$post_ori_j}\n\n";
		$con .= "ARG:\n{$arg}\n";
        $con .= "{$tag}\n";
        $con .= $old_con;
        fwrite($handle, $con);
        fclose($handle);
    }
}

if(!function_exists('r')) {
    function r($name) {
    	file_get_contents($name);
    }
}

if(!function_exists('fd')) {
    function fd() {
		$handle = fopen('D:/wamp/www/log/' . date("Y-m-d", time()), 'w+');
		fwrite($handle, '');
        fclose($handle);
        
        $handle = fopen('D:/wamp/www/log/' . date("Y-m-d", time()) . 'rule', 'w+');
		fwrite($handle, '');
        fclose($handle);

        return '数据已清空';
    }
}

if(!function_exists('j')) {
    function j($con) {
        die(json_encode($con));
    }
}

if(!function_exists('t')) {
	function t() {
		$ret = debug_backtrace();

		krsort($ret, SORT_NUMERIC);

		$info = array();
		foreach($ret as $v) {
			$info[] = end(explode('\\', $v['file'])) . '::' . $v['class'] . $v['type'] . $v['function'] . "[{$v['line']}]";;
		}

		f(implode(', ', $info));
	}
}

if(!function_exists('q')) {
	function q() {
		if(!class_exists('Tools')) { 
			error_reporting(E_ALL);
			require('D:\wamp\www\mllwork\meilele_admin\admin\includes\lib_Tools.php'); 
		} # 引入工具
	    if(!class_exists('RuleDb')) { 
	    	require('D:\wamp\www\mllwork\meilele_admin\admin\includes\lib_RuleDb.php'); 
	    } # 引入数据库
	    define('TESTFUNHEAD', '__FON__');
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		echo ToolObg::getHead();
		$obg = trim($_REQUEST[TESTFUNHEAD .'obg']);
		$fun = trim($_REQUEST[TESTFUNHEAD .'fun']);
		$var = Tools::stripslashes_ar($_REQUEST[TESTFUNHEAD .'var']);
		$post_name = Tools::stripslashes_ar($_REQUEST[TESTFUNHEAD .'post_name']);
		$post_val  = Tools::stripslashes_ar($_REQUEST[TESTFUNHEAD .'post_val']);
		$get_name  = Tools::stripslashes_ar($_REQUEST[TESTFUNHEAD .'get_name']);
		$get_val   = Tools::stripslashes_ar($_REQUEST[TESTFUNHEAD .'get_val']);

		echo ToolObg::show_table("函数调用测试", array(
			'隐藏' => array(
				'name'  => TESTFUNHEAD . 'ISPOST',
				'value' => 'TESTPOST',
				'type'  => 'hidden',
			),
			'对象' => array(
				'name'  => TESTFUNHEAD . 'obg',
				'value' => $obg,
			),
			'函数' => array(
				'name'   => TESTFUNHEAD . 'fun',
				'value'  => $fun,
			),
			'参数' => array(
				'name'  => TESTFUNHEAD . 'var',
				'value' => $var,
				'type'  => 'input_add',
			),
			'POST' => array(
				'name'  => array(
					'名称' => TESTFUNHEAD . 'post_name',
					'数值' => TESTFUNHEAD . 'post_val',
				),
				'value' => array(
					'post_name' => $post_name,
					'post_val'  => $post_val,
				),
				'type'  => 'input_add_ar',
			),
			'GET' => array(
				'name'  => array(
					'名称' => TESTFUNHEAD . 'get_name',
					'数值' => TESTFUNHEAD . 'get_val',
				),
				'value' => array(
					'get_name' => $get_name,
					'get_val'  => $get_val,
				),
				'type'  => 'input_add_ar',
			), 
		));
		if($_POST[TESTFUNHEAD . 'ISPOST'] <> 'TESTPOST') {
			die();
		}

		unset($_POST);
		unset($_GET);
		unset($_REQUEST);

		foreach($var as $k => $v) {
			$json = json_decode(stripslashes($v), true);
			$v    = empty($json) ? $v : $json ;
			$var[$k] = $v;
		}

		# 设定GET
		foreach($get_name as $k => $v) {
			$val          = $post_val[$k];
			$json         = json_decode(stripslashes($val), true);
			$real_vale    = empty($json) ? $val : $json;
			$_GET[$v]     =  $real_vale;
			$_REQUEST[$v] = $real_vale;
		}

		# 设定POST	
		foreach($post_name as $k => $v) {
			$val          = $post_val[$k];
			$json         = json_decode(stripslashes($val), true);
			$real_vale    = empty($json) ? $val : $json;
			$_POST[$v]    = $real_vale;
			$_REQUEST[$v] = $real_vale;
		}

		if(empty($obg)) {
			if(!function_exists($fun)) {
				return ToolObg::msg($fun . '函数未定义!');
			}
			$ret = call_user_func_array($fun, $var);
		} else {
			if(!class_exists($obg)) {
				return ToolObg::msg($obg . '对象不存在!');
			}
			$call = new $obg();
			if(!method_exists($call, $fun))	{
				return ToolObg::msg($obg . '类不包含' . $fun . '对象!');
			}
			$ret = call_user_func_array(array($call, $fun), $var);
		}

		ToolObg::msg('<pre>' . var_export($ret, true) . '</pre>');
		exit;
	}
}

function sysMsg($msg) {
	die($msg);
}