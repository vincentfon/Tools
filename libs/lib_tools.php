<?php
class Tools {
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
	function getTable($title='', $con_ar = array(), $alert = '' , $default_key = false, $post_url = '', $js_end = '') {
		$smt = new smarty();

		
		$table  = '';
		$html   = '';
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

				$con = $smt->fetch('getTableFetch.htm');
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
}