<?php
class ToolObg
{
	var $here;
	var $filename;
	var $act;

	var $config;
	const HIGHLIGHTER_URL = 'http://markup.su/api/highlighter';

	function __construct()
	{
		$this->here = dirname(__FILE__) . '\\';
		$this->filename = end(explode('/', $_SERVER['PHP_SELF']));;
		$this->act = trim($_REQUEST['act']);

		$this->db     = $GLOBALS['db'];
		$this->dbl    = new cls_mysql('127.0.0.1', 'root', '', 'localhost');
		$this->dbzs   = $GLOBALS['dbzs'];
		$this->dm     = $GLOBALS['dm'];
		$this->smarty = $GLOBALS['smarty'];

	    $this->smarty->template_dir = $this->here;
	    $this->post_ori = file_get_contents("php://input");

	    $this->smarty->assign('as', '<input type="input" value="" onkeyup="change_priv_val(this);" />');
	    $this->smarty->assign('server', $_SERVER);

	    $this->config = array(
			'user_id'    => 7000,
			'w_id'       => 1,
			'g_id'       => '',
			'order_sn'   => '',
			's_id'       => 1,
			'o_group_id' => 16,
			'order_id'   => '',
	    );
	}

	function print_ra($info)
	{
		if(empty($info)) {
			return false;
		}

		foreach($info as $v) {
			echo $v . '<br />';
		}
	}

	function print_ar($info)
    {
        if(!is_array($info) || empty($info)) {
            return false;
        }

        $title = array_keys($info['0']);

        // 定义首行
        $ret = '<table style="border-collapse:collapse;" border="2" >';
        $ret .= '<tr>';
        foreach($title as $tcol) {
            $ret .= "<td style='background: #CAE8EA; color: #4f6b72; font-size: 22px; font-weight: bold; text-align:center;'>{$tcol}</td>";
        }
        $ret .= '</tr>';

        // 添加内容
        foreach($info as $row) {
            $ret .= '<tr>';
            foreach($row as $col) {
                if(empty($col)) {
                    $col = '-';
                }
                $ret .= "<td style='word-wrap: break-word; max-width:800px;'>{$col}</td>";
            }
            $ret .= '</tr>';
        }
        $ret .= '</table>';

        return $ret;
    }

    function printMyList($info)
    {
        if(!is_array($info) || empty($info)) {
            return false;
        }

        $title = array_keys($info['0']);

        // 定义首行
        $ret = '<table style="border-collapse:collapse; font-size:8px; color:FFFFFF;" border="1">';
        $ret .= '<tr>';
        foreach($title as $tcol) {
            $ret .= "<td style='background: #CAE8EA; color: #4f6b72;  font-weight: bold; text-align:center;'>{$tcol}</td>";
        }
        $ret .= '</tr>';

        // 添加内容
        foreach($info as $row) {
            $ret .= '<tr>';
            foreach($row as $col) {
                if(empty($col)) {
                    $col = '-';
                }
                $ret .= "<td style='max-width:400px;'>{$col}</td>";
            }
            $ret .= '</tr>';
        }
        $ret .= '</table>';

        return $ret;
    }

	function link_button($info)
	{
		if(empty($info) || !is_array($info)) {
			return false;
		}

		$ret = array();
		foreach($info as $v) {
			if(empty($v['name']) || empty($v['url'])) {
				continue;
			}

			$ret[] = "<input type='button' value='{$v['name']}' onclick='window.location=\"{$v['url']}\";' />";
		}
		
		return implode('', $ret);
	}

	/**
	 * 批量并发请求
	 * @param  [type] $info array(
	 *     array(
	 *         (string) $url      请求地址
	 *         (array)  $data     POST过去的数据
	 *         (int)    $time_out CURL超时时间 
	 *     ), ...
	 * )
	 * @return [type]       array(
	 *     'WebContent'   返回内容
	 *     'HttpState'    HTTP状态码
	 * )
	 */
	function multiple_threads_request($info){ 
	    $multi_handle = curl_multi_init(); 

	    # 构建请求
	    $curl_array = array(); 
	    foreach($info as $key => $url_info) {
	        $curl_array[$key] = $this->create_curl_source($url_info['url'], $url_info['data'], $url_info['time_out']); 
	        curl_multi_add_handle($multi_handle, $curl_array[$key]); 
	    } 

	    $running = 1; 
	    while($running) {
	        usleep(10000); 
	        curl_multi_exec($multi_handle, $running); 
	    }
	     
	    $res = array(); 
	    foreach($info as $key => $url) 
	    { 
	        $res[$key] = array(
				'WebContent' => curl_multi_getcontent($curl_array[$key]), 
				'HttpState'  => curl_getinfo($curl_array[$key], CURLINFO_HTTP_CODE), # 取状态码
	        );
	    } 
	     
	    foreach($info as $key => $url){ 
	        curl_multi_remove_handle($multi_handle, $curl_array[$key]); 
	    } 
	    curl_multi_close($multi_handle);         
	    return $res; 
	} 

	/**
	 * 创建CURL资源
	 * @param  [type]  $url      请求地址
	 * @param  array   $data     POST过去的数据
	 * @param  integer $time_out CURL超时时间
	 * @return [type]            返回结果
	 */
	function create_curl_source($url, $data = array(), $time_out = 10)
	{
	    $ret = curl_init($url);
	    curl_setopt($ret, CURLOPT_URL, $url); // 所要访问的URL
	    curl_setopt($ret, CURLOPT_HEADER, 0); // 不输出Header信息
	    curl_setopt($ret, CURLOPT_RETURNTRANSFER, TRUE); // 不输出而是返回文件流
	    curl_setopt($ret, CURLOPT_CONNECTTIMEOUT, $time_out); // 发起连接等待时间
	    curl_setopt($ret, CURLOPT_FOLLOWLOCATION, TRUE); // 跟随重定向
	    curl_setopt($ret, CURLOPT_COOKIE, self::get_curl_cookie_str()); # 设定COOKIE
	    if(!empty($data)) {
	        curl_setopt($ret, CURLOPT_POST, 1);
	        curl_setopt($ret, CURLOPT_POSTFIELDS, http_build_query($data));
	    }
	    curl_setopt($ret, CURLOPT_NOBODY, FALSE);

	    return $ret;

	    /*$html   = curl_exec($ch); # 执行CURL
	    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); # 获取状态码
	    curl_close($ch); # 关闭CURL链接*/
	}

	// 返回CURL可用的COOKIE字符串
	function get_curl_cookie_str()
	{
	    $ret = array();
	    foreach($_COOKIE as $key => $val) {
	        $ret[] = "{$key}={$val}";
	    }
	    return implode('; ', $ret);
	}

	function select_ar($name, $select_ar, $select = '', $domDefine)
	{
		$ret = "<select class='class_{$name}' id='{$name}' name='{$name}' {$domDefine}>";
		foreach($select_ar as $k => $v) {
			$ret .= '<option data-text="' . $v . '" value="' . $k . '" ';
			if(!empty($select) && $k == $select) {
				$ret .= ' selected ';
			}
			$ret .= ' >' . $v . '</option>';
		}
		$ret .= "</select>";

		return $ret;
	}

	function show_id_choose($title='', $id_name = '', $alert = '')
	{
		$add_alert = '';
		if(!empty($alert)) {
			$add_alert = '
				<tr>
					<td colspan="2" class="mi alert">
						' . $alert . '
					</td>
				</tr>
			';
		}
		return '
		<table width="100%"  >
			<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
			' . $add_alert . '
			<tr>
				<th colspan="2" class="mi">
					' . $title . '
				</th>
			</tr>
			<tr>
				<td>
					' . $id_name . 'ID/SN:
				</td>
				<td>
					<input style="width:300px;" type="type" name="id" value="" />
				</td>
			</tr>
			<tr>
				<td colspan="2" class="mi">
					<input type="submit" class="button" value="提交" />	
				</td>
			</tr>
			</form>
		</table>
		';
	}

	function show_con_choose($title='', $id_name = '', $id = '', $alert = '')
	{
		$add_alert = '';
		if(!empty($alert)) {
			$add_alert = '
				<tr>
					<td colspan="2" class="mi alert">
						' . $alert . '
					</td>
				</tr>
			';
		}
		return '
		<table width="100%"  >
			<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
			<input type="hidden" name="change" value="1">
			<input type="hidden" name="id" value="' . $id . '">
			' . $add_alert . '
			<tr>
				<th colspan="2" class="mi">
					' . $title . '
				</th>
			</tr>
			<tr>
				<td>
					' . $id_name . '
				</td>
				<td>
					<textarea style="width:500px; height:300px;" name="con"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="mi">
					<input type="submit" class="button" value="提交" />	
				</td>
			</tr>
			</form>
		</table>
		';
	}

	function radio_ar($name, $radio_ar, $value = 0) {
		$ret   = '';
		$value = empty($value) ? reset($radio_ar) : $value;
		foreach ($radio_ar as $k => $v) {
			$checked = $k == $value ? 'checked' : '';
			$ret .= '<label><input type="radio" class="class_' . $name . '" id="' . $name . '" name="' . $name . '" value="' . $k . '" ' . $checked . '>' . $v . '<label>';
		}

		return $ret;
	}

	/**
	 * !使用前需要Jquery的支持
	 * @param  string  $title       定义表单头部
	 * @param  array   $con_ar     	基本格式
	 *     # 普通type : hidden text select checkbox
	 *     'act' => array(
	 *			'name'  => 'act',
	 *			'value' => 'CallRuleTest',
	 *			'type'  => 'hidden',
	 *     ),
	 *     # input_add_ar 联动数组
	 *     '邮箱' => array(
	 *			'name'  => array(
	 *				'标题1' => 'name1',
	 *				'标题2' => 'name2',
	 *			),
	 *			'value' => array(
	 *				'name1' => $name1,
	 *				'name2' => $name2,
	 *			),
	 *			'type'  => 'input_add_ar'
	 *		),
	 *		# input_add 数组
	 *		'测试' => array(
	 *			'name'  => 'aaa',
	 *			'value' => array(1,2,3), # 支持数组与字符串
	 *			'type'	=> 'input_add',
	 *		),
	 * @param  string  $alert       显示提示信息
	 * @param  boolean $default_key 引用功能开关
	 * @return [type]               [description]
	 */
	function show_table($title='', $con_ar = array(), $alert = '' , $default_key = false, $post_url = '', $js_end = '')
	{
		$add_alert = '';
		if(!empty($alert)) {
			$add_alert = '
				<tr>
					<td colspan="2" class="alert">
						说明:' . $alert . '
					</td>
				</tr>
			';
		}
		$table  = '';
		if(!empty($con_ar)) {
			$act = self::getActVal($con_ar);
			if(!$act) {
				array_push($con_ar, array(
					'name'  => 'act',
					'value' => trim($_REQUEST['act']),
					'type'  => 'hidden',
				));
				$act = trim($_REQUEST['act']);
			}
			foreach($con_ar as $k => $v) {
				$input_con = '';
				$addFun    = '';
				switch($v['type']) {
					case 'textarea':
						$textarea_width = isset($v['textarea']['width']) ? $v['textarea']['width'] : 700;
						$textarea_height = isset($v['textarea']['height']) ? $v['textarea']['height'] : 200;
						$input_con = '<textarea style="width:' . $textarea_width . 'px; height:' . $textarea_height . 'px;" id="' . $v['name'] . '" name = "' . $v['name'] . '">' . $v['value'] . '</textarea>';
					break;

					case 'select':
						if($v['add'] != 'none') {
							$v['select']['0'] = '--请选择--';
							ksort($v['select']);
						}
						$input_con = $this->select_ar($v['name'], $v['select'], $v['value']) . '<input type="input" value="" onkeyup="change_priv_val(this);" />';
					break;

					case 'input_add':
						$add_js['input_add'] = true;
						if(is_array($v['value'])) {
							foreach ($v['value'] as $value) {
								$value = htmlentities($value, ENT_COMPAT, 'UTF-8');
								$input_con .= '<div><input type="text" style="width:400px; margin-top:5px;" id="' . $v['name'] . '" name="' . $v['name'] . '[]" value="' . $value . '" /><span style="cursor:pointer; color:Crimson; padding-left:5px;" onclick="$(this).parent().remove();">删除</span><br /></div>';
							}
						} else {
							$input_con = '<div><input type="text" style="width:400px; margin-top:5px;" id="' . $v['name'] . '" name="' . $v['name'] . '[]" value="' . htmlentities($v['value'], ENT_COMPAT, 'UTF-8') . '" /><span style="cursor:pointer; color:Crimson; padding-left:5px;" onclick="$(this).parent().remove();">删除</span><br /></div>';
						}
						$input_con .= '<span style="cursor:pointer; color:LightSeaGreen; font-weight:bold;" id="input_add_tag_' . $v['name'] . '" onclick="addInputTag(\'' . $v['name'] . '\')">添加</span>';
					break;

					case 'input_add_ar':
						$flag = reset($v['name']);
						if(is_array($v['value'][$flag])) {
							foreach($v['value'][$flag] as $k1 => $v1) {
								$input_con .= '<div>';
								foreach($v['name'] as $k2 => $v2) {
									$input_con .= '<span style="padding-left:10px; color:RoyalBlue;">' . $k2 . ': </span><input type="text" style="width:150px; margin-top:5px;" name="' . $v2 . '[]" value="' . $v['value'][$v2][$k1] . '" />';
								}
								$input_con .= '<span style="cursor:pointer; color:Crimson; padding-left:5px;" onclick="$(this).parent().remove();">删除</span><hr /></div>';
							}
						} else {
							$input_con = '<div>';
							foreach($v['name'] as $k1 => $v1) {
								$input_con .= '<span style="padding-left:10px; color:RoyalBlue;">' . $k1 . ': </span><input type="text" style="width:150px; margin-top:5px;" id="' . $v1 . '" name="' . $v1 . '[]" value="" />';
							}
							$input_con .= '<span style="cursor:pointer; color:Crimson; padding-left:5px;" onclick="$(this).parent().remove();">删除</span><hr /></div>';
						}
						$input_con .= '<span style="cursor:pointer; color:LightSeaGreen; font-weight:bold;" id="input_add_ar_tag_' . $flag . '" onclick="addInputTagAr(\'' . $flag . '\', Array(' . Tools::implode(array_keys($v['name'])) . '), Array(' . Tools::implode($v['name']) . '))">添加</span>';
					break;

					case 'checkbox':
						$input_con = $this->checkbox_ar($v['name'], $v['checkbox'], $v['value']);
					break;

					case 'hidden':
						$table  .= '<input type="hidden" id="' . $v['name'] . '" name="' . $v['name'] . '" value="' . $v['value'] . '" />';
						continue;
					break;

					case 'radio':
						$input_con = self::radio_ar($v['name'], $v['radio'], $v['value']);
					break;

					case 'password':
						$input_con  .= '<input style="width:400px;" type="password" id="' . $v['name'] . '" name="' . $v['name'] . '" value="' . $v['value'] . '" />';
						continue;
					break;

					case 'select_input':
						$input_con  .= '<input style="width:400px;" type="password" id="' . $v['name'] . '" name="' . $v['name'] . '" value="' . $v['value'] . '" />';
						$input_con = $this->select_ar(
							$v['name'] . 'Select', 
							$v['select'], 
							$v['value'], 
							"onChange='changeParValue(this);'"
							) . '<input type="input" value="" onkeyup="change_priv_val(this);" />';
					break;
					default:
						$add_date = '';
						if($v['date']) {
							$add_date = "onclick=\"return showCalendar('{$v['name']}', '%Y-%m-%d %H:%M:%S', '24', true, '{$v['name']}');\"";
						}
						$input_con = '<input type="text" style="width:400px;" id="' . $v['name'] . '" name="' . $v['name'] . '" value="' . $v['value'] . '" ' . $add_date . ' />';
					break;
				}
				if($v['type'] == 'hidden') {
					continue;
				}

				if(!empty($v['js'])) {
					$add_js_fun .= "$('.class_{$v['name']}').{$v['js']['action']}(function() {
						showAddInfoChangeSystem($(this));
					});";
				}

				$table  .= '
					<tr>
						<td class="mi" ' . $addFun . '>
							' . $k . '
						</td>
						<td>
							' . $input_con . '					
						</td>
					</tr>
				';
			}
		}
		$default_key_str = '';
		if($default_key) {
			$default_key_str .= '<input type="button" class="button red" style="" onclick="updateDefault();" value="添加引用" />';
			$default_key_str .= '<input type="button" class="button" onclick="useDefault();" value="引用默认" />';
			$default_key_str .= '<input type="button" class="button yellow" onclick="showQuickList();" value="引用历史" />';
		}
		$js_add = '<script type="text/javascript">';
		if($title) {
			$js_add .= 'document.title="' . $title . '"';
		}
		$js_add .= '
				function addInputTag(name) {
					var tag = $("#input_add_tag_" + name);
					tag.before(\'<div><input type="text" style="width:400px; margin-top:5px;" name="\' + name + \'[]" value="" /><span style="cursor:pointer; color:Crimson; padding-left:5px;" onclick="$(this).parent().remove();">删除</span><br /></div>\');
				}

				function changeParValue(that) {
					var id_name = $(that).attr("id");
					var obg = $(".class_" + id_name + " :selected");
					$(that).next().val(obg.text());
				}

				function addInputTagAr(tagname, title, name) {
					var tag = $("#input_add_ar_tag_" + tagname);
					var str = \'<div>\';
					for(key in title) {
						str += \'<span style="padding-left:10px; color:RoyalBlue;">\' + title[key] + \': </span><input type="text" style="width:150px; margin-top:5px;" id="\' + title[key] + \'" name="\' + name[key] + \'[]" value="" />\';
					}
					str += \'<span style="cursor:pointer; color:Crimson; padding-left:5px;" onclick="$(this).parent().remove();">删除</span><hr /></div>\';
					tag.before(str);
				}

				$(document).ready(function() { 
					' . $add_js_fun . '
				});
		';
		$js_add .= '</script>';
		$post_url = empty($post_url) ? $_SERVER['REQUEST_URI'] : $post_url;
		return $js_add . '

		<form action="' . $post_url . '" method="post" name="subform">
			<table width="100%"  >
				<tr>
					<th colspan="2" class="mi">
						' . $title . '
					</th>
				</tr>
				' . $table . '
				' . $add_alert . '
				<tr>
					<td colspan="2" >
						<input type="submit" class="button" value="提交" />
						' . $default_key_str . '	
						<span id="backMsgShow" style="color:red;"></span>
					</td>
				</tr>
			</table>
		</form>
		' . $js_end;
	}

	function getActVal($info) {
		$ret = '';

		foreach($info as $v) {
			if($v['name'] == 'act') { 
				$ret = $v['value']; 
			}
		}

		return $ret;
	}

	function checkbox_ar($name, $checkbox, $value) {

		if(empty($name) || empty($checkbox) || !is_array($checkbox)) {
			return '';
		}

		$ret = '';
		foreach($checkbox as $k => $v) {
			if(in_array($k, $value)) {
				$ret .= '<label><input type="checkbox" id="' . $name . '" class="class_' . $name . '" name="' . $name . '[]" value="' . $k . '" checked />	' . $v . '  </label>';
			} else {
				$ret .= '<label><input type="checkbox"  id="' . $name . '" class="class_' . $name . '"  name="' . $name . '[]" value="' . $k . '" />	' . $v . '  </label>';
			}
		}

		return $ret;
	}

	function sys_msg($msg, $url = '', $time = 3) {
		$this->smarty->assign('back_url', $url);
		$this->smarty->assign('back_time', $time);
		$this->smarty->assign('noMianMenu', 1);
		$this->smarty->assign('msg', $msg);
		$this->smarty->assign('type', 'sys_msg');
		$this->smarty->assign('head', 1);
		$this->smarty->assign('jquery', 1);
		die($this->smarty->fetch('./fb.htm'));
	}

	function msg($msg) {
		echo self::print_ar(array(array(
			'消息' => $msg,
		)));
	}

	function get_array_back($info) 
	{
		$ret = array();

		$tmp_info = explode("\n", $info);
		foreach($tmp_info as $k => $v) {
			// $v = str_replace(array("\t", "\n", "\r"), '', $v);
			$v = trim($v, "\t\n\r");
			if(!empty($v)) {
				$ret[$k] = $v;
			}
		}

		return $ret;
	}

	function j($con)
	{
		die(json_encode($con));
	}

	function call_url_for_result($url, $time = 30, $data = array(), $json = false, $for_result = false) 
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        if(!empty($data)){
            if($json){
                $data = json_encode($data);
            }else{
                $data = http_build_query($data);
            }
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($curl, CURLOPT_POST, 0);
        }

        curl_setopt($curl, CURLOPT_NOBODY, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, $time);

        list($s_usec, $s_sec) = explode(" ", microtime());
        $result = curl_exec($curl);
        list($e_usec, $e_sec) = explode(" ", microtime());
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $total_time = (float)(($e_sec - $s_sec) + ($e_usec - $s_usec));
        curl_close($curl);

        if($for_result) {
        	$json = json_decode($result, true);
        	return $json ? $json : $result;
        }

        return array(
            'url'       => $url,
            'result'    => $result,
            'http_code' => $http_code,
            'time_cost' => $total_time,
        );
    }

    function HightCodeEx($con, $type, $class='mytextarea', $name='', $id='') {
    	$class_name = '.' . $class;
    	$con = '<textarea name="' . $name . '" id="' . $id .'"
    			class="' . $class . '">' 
    		. $con . 
    		'</textarea>';
    	return self::HightCode($con, $type, $class_name, $id);
    }


    # $con 展示的内容信息
    # $type 展示的类型
    # $tag_name JQUERY标识
    function HightCode($con, $type, $tag_name='.mytextarea', $edit='') {
    	# 所有支持的类型
    	$type_config = array(
    		'sql' => array(
    			'file' => '<script src="/admin/js/codemirror/mode/sql/sql.js"></script>',
    			'mode' => 'text/x-mysql',
    		),
    		'php' => array(
    			'file' => '<script src="/admin/js/codemirror/mode/php/php.js"></script>',
    			'mode' => 'text/x-php',
    		)
    	);

    	if(!array_key_exists($type, $type_config)) { return $con; }
    	$editHandle = empty($edit) ? '' : "window.{$edit} = " ;

    	$ret = '';
		$ret .= '<script src="/admin/js/codemirror/lib/codemirror.js"></script>';
		$ret .= '<link rel=stylesheet href="/admin/js/codemirror/lib/codemirror.css">';
		$ret .= '<script src="/admin/js/codemirror/mode/xml/xml.js"></script>';
		$ret .= '<script src="/admin/js/codemirror/mode/javascript/javascript.js"></script>';
		$ret .= '<script src="/admin/js/layer/layer.min.js"></script>';
		$ret .= '<script src="/admin/js/codemirror/mode/css/css.js"></script>';
		$ret .= '<script src="/admin/js/codemirror/mode/htmlmixed/htmlmixed.js"></script>';
		$ret .= $type_config[$type]['file'];
		$ret .= '<script src="/admin/js/codemirror/addon/edit/matchbrackets.js"></script>';
		$ret .= '<style>.CodeMirror {font-family: monospace; border: 1px solid #ccc; font-family: Monaco, Menlo, Consolas, "COURIER NEW", monospace; font-size: 18px; height: auto; }</style>';
		$ret .= $con;
		$ret .= '<script type="text/javascript">
			$("' . $tag_name . '").each(function() { 
				' . $editHandle . ' CodeMirror.fromTextArea(this, {
                    lineNumbers: true,
                    mode: "' . $type_config[$type]['mode'] . '",
                    matchBrackets: false,
                    lineWrapping: true,
        			autoMatchParens: true,
            	});
			}); 
	  	</script>';

	  	return $ret;
    }

    function headerFile($file_name)
    {
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: public");
        header("Cache-Control: maxage=3600"); 
        header("Pragma: public");
        header('Expires: 0');
        header("Content-type: application/txt;charset=GBK");
        header("Content-Disposition: attachment; filename={$file_name}");
    }

    function getHead() {
    	$smarty = empty($GLOBALS['smarty']) ? $GLOBALS['smt'] : $GLOBALS['smarty'];
    	if(empty($smarty)) {
    		return false;
    	}
		$smarty->assign('head', 1);
		$smarty->assign('main_menu', $GLOBALS['main_menu']);
		$my_way = 'D:\wamp\www\mllwork\meilele_admin\admin\fb.htm';
		$htm = file_exists($my_way) ? $my_way : 'fb.htm';
		$ret = $smarty->fetch($htm);
		$smarty->assign('head', 0);
		return $ret;
	}

	function arStrShow($info, $in_ar = array(), $out_ar = array()) {
		if(empty($info) || !is_array($info)) { return ''; }

		$ret = '';	
		if(!empty($out_ar) && !empty($in_ar)) {
			foreach($info as $k => $v) {
				if(in_array($k, array_diff($in_ar, $out_ar))) {
					$ret .= "[{$k}:{$v}]";
				}
			}
		} elseif(!empty($out_ar)) {
			foreach($info as $k => $v) {
				if(in_array($k, $out_ar)) { continue; }
				$ret .= "[{$k}:{$v}]";
			}
		} elseif(!empty($in_ar)) {
			foreach($info as $k => $v) {
				if(in_array($k, $in_ar)) {
					$ret .= "[{$k}:{$v}]";
				}
			}
		} else {
			foreach($info as $k => $v) {
				$ret .= "[{$k}:{$v}]";
			}
		}

		return $ret;
	}

	function buildFormSubmit($link, $array, $id_name = 'hiddenSubmit') {
		$ret = '<form style="display:none;" method="post" action="' . $link . '" target="_self" id="' . $id_name . '">';
		foreach($array as $k => $v) {
			if(is_array($v)) {
				foreach($v as $vv) {
					$ret .= "<input type='text' name='{$k}[]' value='{$vv}'>";
				}
			} else {
				$ret .= "<input type='text' name='{$k}' value='{$v}'>";
			}
		}
		$ret .= '</form>';
		return $ret;
	}

	/**
	 * 调用后台Soap的通用函数
	 * @param  $config_info = array(
	 *     'fun_name'  = 函数名称
	 *     'user_name' = 用户名称
	 * );
	 * 后面的参数会自动传递给Soap调用参数
	 * 
	 * @return [type]           [description]
	 */
	function requestSoapServer($config_info)
	{
	    if(empty($config_info['fun_name']) || empty($config_info['user_name'])) {
	        return array(
	            'error' => 1,
	            'msg'   => '传入参数基础信息有误!',
	        );
	    }

	    $fun_name  = $config_info['fun_name'];
	    $user_name = $config_info['user_name'];

	    $location = 'http://dev.meilele.com/admin/soap_public_server.php';
	    $uri      = 'http://dev.meilele.com/admin/';
	    $client   = new SoapClient ( null , array(
	        'location' => $location,
	        'uri'      => $uri,
	    ));

	    $db_key = stockUniRE('BUS1_VerifyKey', array());
	    if(!empty($db_key['error'])) {
	        return false;
	    }
	    $db_key = $db_key['msg']['0']['key'];

	    # 定义请求变量
	    $args = array(array(
	        'user_name' => $user_name,
	        'auth_key'  => md5($user_name . $db_key),
	    ));
	    foreach(func_get_args() as $k => $v) {
	        if($k == 0) {
	            continue;
	        }
	        $args[] = $v;        
	    }
	    $result = $client->__soapCall($fun_name, $args);

	    return $result;
	}

	function hmac($data, $key) {
	    // RFC 2104 HMAC implementation for php.
	    // Creates an md5 HMAC.
	    // Eliminates the need to install mhash to compute a HMAC
	    // Hacked by Lance Rushing(NOTE: Hacked means written)

	    $key  = ecs_iconv('GB2312', 'UTF8', $key);
	    $data = ecs_iconv('GB2312', 'UTF8', $data);

	    $b = 64; // byte length for md5
	    if (strlen($key) > $b)
	    {
	        $key = pack('H*', md5($key));
	    }

	    $key    = str_pad($key, $b, chr(0x00));
	    $ipad   = str_pad('', $b, chr(0x36));
	    $opad   = str_pad('', $b, chr(0x5c));
	    $k_ipad = $key ^ $ipad ;
	    $k_opad = $key ^ $opad;

	    return md5($k_opad . pack('H*', md5($k_ipad . $data)));
	}

	/**
	 * 分页HTML函数
	 * @param  integer $totalnum 总页数
	 * @param  integer $perpage  每页显示数
	 * @param  integer $page     目前所处页数
	 * @param  array   $rangepage 展示的可选页个数
	 * @return [type]            [description]
	 */
	function pageSplitStr($totalnum = 1, $perpage = 1, $page = 1, $rangepage = 6)
	{
		$page = max($page,1);
		$totalpage = ceil($totalnum/$perpage);
		$page = intval($page) > $totalpage ? $totalpage : intval($page);

		$startpage = max(1, $page - $rangepage);
		$endpage   = min($totalpage, $startpage + $rangepage*2 - 1);
		$startpage = min($startpage, $endpage - $rangepage*2 + 1);
		if($startpage < 1) {
			$startpage = 1;
		}

		$html = '';
		$html .= "共{$totalpage}页{$totalnum}条数据&nbsp;&nbsp;&nbsp;&nbsp;";
		$html .= '每页显示数:<input type="text" style="width:30px;" id="jumpPageList" value="' . $perpage . '" onkeypress="if (event.keyCode == 13) setPrePageNum(this);" />&nbsp;&nbsp;&nbsp;&nbsp;';
		$html .= '跳转到:<input type="text" style="width:30px;" id="jumpPageList" value="' . $page . '" onkeypress="if (event.keyCode == 13) pageJumpToSet(this);" />&nbsp;&nbsp;&nbsp;&nbsp;';
		# 第二页开始就有了上一页
		$html .= $page > 1 ? '<a href="#" onclick="setPage(' . ($page - 1) . ')"><span class="arrow"><span class="aleft">◆</span></span>上一页</a> ' : '';
		# 显示第一页
		$html .= $startpage > 2 ? '<a href="#" onclick="setPage(1)">1</a> ... ':'';

		for($i = $startpage; $i <= $endpage; $i++){
			if($page == $i){
				$html .= '<strong>'.$i.'</strong> ';
			}else{
				$html .= '<a href="#" onclick="setPage(' . $i . ')">' . $i . '</a> ';
			}
			if($i == $totalpage) {
				break;	
			}
		}

		# 最后一页
		$html .= ($totalpage - $endpage) > 2 ? '... <a href="#"onclick="setPage(' . $totalpage . ')">'.$totalpage.'</a> ' :'';
		# 小于最后一页就有上一页
		$html .= $page < $totalpage ? '<a href="#" onclick="setPage(' . ($page + 1) . ')">下一页<span class="arrow"><span class="aright">◆</span></span></a> ':'';

		return $html;
	}

	function printSplitList($totalnum, $perpage, $page, $rangepage = 6) {
		$ret = '<table style="width:100%;"><tr><td>';
		$ret .= self::pageSplitStr($totalnum, $perpage, $page, $rangepage);
		$ret .= '</tr></td></table>';
		return $ret;
	}

	function ajaxInfoHtml($name, $url, $title = '', $type = 'input') {
		if($type == 'link') {
			return "<a href='#' onclick='showAjaxInfo(\"{$url}\", \"{$title}\")'>{$name}</a>";
		}

		return "<input type='button' class='button blue' value='{$name}' onclick='showAjaxInfo(\"{$url}\", \"{$title}\")' />";
	}

	function quickHistory($fun) {
		$info = $this->db->getAll("SELECT id, con, `default`, FROM_UNIXTIME(`add_time`) add_time
			FROM ecs_fv_tools_config
			WHERE user_id='{$_SESSION['admin_id']}'
				AND type='{$fun}'
			ORDER BY `default` DESC, add_time DESC
			LIMIT 100");

		$ret = array();
		foreach($info as $v) {
			$v['default'] = $v['default'] == 1 ? '<span style="color:red; font-weight:bold;">默认</span>' : '历史';
			parse_str($v['con'], $show);
			unset($show['act']);
			unset($show['quick_fun']);
			unset($show['old_act']);
			$v['con'] = print_r($show, true);
			$ret[] = $v;
		}

		return $ret;
	}

	function delQuickHistory() {
		$id = (int) $_REQUEST['id'];
		if(empty($id)) { return Tools::jerr('ID信息为空!'); }

		$this->db->query("DELETE FROM ecs_fv_tools_config WHERE id={$id} LIMIT 1");
		return Tools::jret('操作成功!');
	}

	function setQuickDefault() {
		$id = (int) $_REQUEST['id'];
		if(empty($id)) { return Tools::jerr('ID信息为空!'); }

		$this->db->query("UPDATE ecs_fv_tools_config SET `default`=1 WHERE id={$id} LIMIT 1");
		$this->db->query("UPDATE ecs_fv_tools_config a1 
			JOIN ecs_fv_tools_config a2 ON a2.type=a1.type AND a2.id <> {$id}
			SET a2.`default`=0 ");
		return Tools::jret('操作成功!');
	}
}
