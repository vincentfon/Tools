<?php
require('../cfg/init.php');

class RunInit 
{
    function __construct()
    {
        $this->model  = $_REQUEST['model'];
        $this->action = $_REQUEST['action'];
    }

    # 主要分发器函数
    function run()
    {
        if(empty($this->model) || empty($this->action)) {
            sysMsg("参数有误<br /> 
            	model : {$this->model} <br /> 
            	action : {$this->action} <br /> 
            	?model=XXXX&action=XXXX");
        }

        $model  = $this->model;
        $action = $this->action;
        $modelFile = F_ROOT_LIBS . 'lib_' . $model . '.php';
        if(!file_exists($modelFile)) {
        	sysMsg("没有找到{$modelFile},请重试或与管理员联系!");
        }
        require($modelFile);
        if(!class_exists($model)) {
            sysMsg("无法找到{$model}模块,请重试或与管理员联系!");
        }

        $main = new $model;
        if(!method_exists($main, $action)) { 
        	sysMsg("[C:{$model}]没有[F:{$action}]方法!"); 
        }
        $ret  = $main->$action();

        return $ret;
    }

    function checkAction($name) {
        return substr(strtolower($name), 0, 3) == $this->openfunction;
    }
}

$main = new RunInit();
$main->run();