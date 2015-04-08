<?php
/**
 * 主键表单提交的类
 */
class TTable {
	protected static $_instance;

	private $tableCore = array(
		'enctype' => 'multipart/form-data',
		'name'    => '',
		'action'  => '', # Form需要提交的地址
		'id'      => '',
		'method'  => '_POST',
		'module'  => array(),
		'table'   => '',
	);

	public function __construct() {
		self::$_instance = $this;

		$this->smt = new smarty();
		$this->dwt = 'table.htm';
	}

	public function setTable($data = array()) {
		if($data['form']) {
			$this->tableCore['form'] = $data['form'];
		}

		if($data['name']) {
			$this->tableCore['form'] = $data['form'];	
		}

		if($data['action']) {
			$this->tableCore['action'] = $data['action'];
		}

		return true;
	}

	public static function getInstance()
    {
        return self::$_instance;
    }	

    // 清除smarty的变量设置
    public function cleanSmt() {
    	$this->smt->tpl_vars = array();

    	return true;
    }

    /**
     * 展示最终的结果
     * @return [type] [description]
     */
    public function display() {
        $this->cleanSmt();

        $this->smt->assign('head', $this->smt->fetch('head.htm'));
        $this->smt->assign('end', $this->smt->fetch('end.htm'));
        $this->smt->assign('type', __FUNCTION__);
        $this->smt->assign('tableCore', $this->tableCore);

        $this->smt->display($this->dwt);
        exit;
    }

    public function css($css) {
    	if(empty($css) || !is_array($css)) {
    		return '';	
    	}

    	$ret = array();
		foreach($css as $k => $v) {
			$ret[] = $k . ':' . $v;
		}

		return implode(';', $ret);
    }

    public function table($showType='', $data=array(), $css=array(), $trigger=array()) {
        $showType = strtolower($showType);
    	switch($showType) {
    		case 'hidden':
    		break;

    		case 'password':
    		break;

    		case 'textarea':
    		break;

    		case 'radio':
    		break;

    		case 'checkbox':
                if(is_array($data['value'])) {
                    foreach($data['value'] as $v) {
                        $data['checked'][$v] = '1';
                    }
                }
    		break;

    		case 'select':
    		break;

            case 'select_input':
            break;

    		case 'input_date':
    		break;

            case 'input_add':
            break;

            case 'input_add_ar':
                $data['input_add_ar_json'] = json_encode($data['name']);
                $data['count'] = array_keys(current($data['value']));
            break;

    		case 'input':
    		default:
    		break;
    	}
        $data['css'] = $this->css($css);

    	$this->cleanSmt();
		$this->smt->assign('type', $showType);
    	$this->smt->assign('data', $data);
    	$this->tableCore['table'] .= $this->smt->fetch($this->dwt);

    	return $this->cleanSmt();
    }
   
    /**
     * 获取展示结果
     * @return [type] [description]
     */
    public function fetch() {

    }

    
}