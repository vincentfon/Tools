<?php
class Demo {
	function tabletest() {
		$ttable = TTable::getInstance();
		$ttable->setTable(array(
			'name'   => 'myform',
			'action' => 'http://dev.meilele.com/fv.php',
		));
		$ttable->table('input', array(
			'tag_name' => 'input',
			'name'     => 'input',
			'value'    => 'input',
			'id'       => 'input',
		), array(
			'height' => '40px',
		));
		$ttable->table('radio', array(
			'tag_name' => 'radio',
			'name'     => 'radio',
			'value'    => '2',
			'radio'    => array(
				'1' => '11',
				'2' => '22',
				'3' => '33',
			),
			'id'       => 'radio_id',
			'class'    => 'radio_class',
		));

		$ttable->table('checkbox', array(
			'tag_name' => 'checkbox',
			'name'     => 'checkbox',
			'value'    => array(
				'2', '3'
			),
			'checkbox'    => array(
				'1' => '11',
				'2' => '22',
				'3' => '33',
			),
			'id'       => 'checkbox_id',
			'class'    => 'checkbox_class',
		));
		$ttable->table('select', array(
			'tag_name' => 'select',
			'name'     => 'select',
			'value'    => '3',
			'select'    => array(
				'0' => '-请选择-',
				'1' => '11',
				'2' => '22',
				'3' => '33',
			),
			'id'       => 'select_id',
			'class'    => 'select_class',
		));

		$ttable->table('input_date', array(
			'tag_name' => 'input_date',
			'name'     => 'input_date',
			'value'    => 'input_date',
			'id'       => 'input_date',
		), array(
			'height' => '40px',
		));

		$ttable->table('input_add', array(
			'tag_name' => 'input_add',
			'name'     => 'input_add',
			'value'    => '3',
			'input_add'    => array(
				'0' => '-请选择-',
				'1' => '11',
				'2' => '22',
				'3' => '33',
			),
			'id'       => 'input_add_id',
			'class'    => 'input_add_class',
		));
		$ttable->table('input_add_ar', array(
			'tag_name' => 'input_add_ar',
			'name'  => array(
				'post_name' => '名称',
				'post_val'  => '数值',
				'post_note' => '备注',
				'post_add'  => '添加',
			),
			'value' => array(
				'post_name' => array(1, 2, 3),
				'post_val'  => array(4, 5, 6),
				'post_note' => array(7, 8, 9),
				'post_add' => array(7, 8, 9),
			),
			'id'       => 'input_add_ar_id',
			'class'    => 'input_add_ar_class',
		));

		$ttable->display();
	}
}