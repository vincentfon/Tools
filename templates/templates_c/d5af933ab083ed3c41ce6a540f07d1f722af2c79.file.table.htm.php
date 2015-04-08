<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-04-08 17:06:14
         compiled from "D:\wamp\www\Tools\templates\table.htm" */ ?>
<?php /*%%SmartyHeaderCode:170785523323cceeda0-20531932%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5af933ab083ed3c41ce6a540f07d1f722af2c79' => 
    array (
      0 => 'D:\\wamp\\www\\Tools\\templates\\table.htm',
      1 => 1428483972,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '170785523323cceeda0-20531932',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5523323ccf00f8_22334135',
  'variables' => 
  array (
    'type' => 0,
    'head' => 0,
    'tableCore' => 0,
    'end' => 0,
    'data' => 0,
    'key' => 0,
    'item' => 0,
    'valuedata' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5523323ccf00f8_22334135')) {function content_5523323ccf00f8_22334135($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['type']->value=='display') {?>
<?php echo $_smarty_tpl->tpl_vars['head']->value;?>

<table width="100%" class="postform">
	<tr>
		<th colspan="2" class="mi">
			<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['title'];?>

		</th>
	</tr>
	<form action="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['action'];?>
" method="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['method'];?>
" enctype="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['enctype'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['name'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['class'];?>
"  id="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['id'];?>
">
		<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['table'];?>

	</form>
</table>
<?php echo $_smarty_tpl->tpl_vars['end']->value;?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='input') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td><input type="text" style="<?php echo $_smarty_tpl->tpl_vars['data']->value['css'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['data']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['value'];?>
" /></td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='password') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td><input type="password" style="<?php echo $_smarty_tpl->tpl_vars['data']->value['css'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['value'];?>
" /></td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='hidden') {?>
 <input type="hidden" style="<?php echo $_smarty_tpl->tpl_vars['data']->value['css'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['value'];?>
" />
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='textarea') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td>
		<textarea style="<?php echo $_smarty_tpl->tpl_vars['data']->value['css'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['tableCore']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['value'];?>
</textarea>
	</td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='radio') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td>
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value['radio']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<label>
			<input type="radio" name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['data']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['value']==$_smarty_tpl->tpl_vars['key']->value) {?>checked<?php }?> /> <?php echo $_smarty_tpl->tpl_vars['item']->value['value'];?>

		</label>
	<?php } ?>
	</td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='checkbox') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td>
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value['checkbox']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<label>
			<input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['data']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['checked'][$_smarty_tpl->tpl_vars['key']->value]==1) {?>checked<?php }?> /> 
			<?php echo $_smarty_tpl->tpl_vars['item']->value['value'];?>

		</label>
	<?php } ?>
	</td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='select') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td>
	<select name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
">
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value==$_smarty_tpl->tpl_vars['data']->value['value']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
		<?php } ?>
	</select>
	</td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='input_date') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td>
	<input type="text" style="<?php echo $_smarty_tpl->tpl_vars['data']->value['css'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['data']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['value'];?>
" onclick="$.calendar({ format:'yyyy-MM-dd HH:mm:ss' , btnBar:true});"/>
	</td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='input_add') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['input_add']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
		<div>
			<input type="text" style="width:400px; margin-top:5px;" id="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['data']->value['css'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
" />
			<input type="button" class="smallbutton red" value="删除" onclick="$(this).parent().remove();"/>
		</div>
		<?php } ?>
		<input type="button" class='smallbutton blue' id="input_add_tag_<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" value="添加" onclick="addInputTag('<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
', '<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
', '<?php echo $_smarty_tpl->tpl_vars['data']->value['css'];?>
');"/>
	</td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='select_input') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td>
		<select name="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
">
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value['select_input']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
			<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value==$_smarty_tpl->tpl_vars['data']->value['value']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
			<?php } ?>
		</select>
		<input type="input" value="" onkeyup="change_priv_val(this);" />
	</td>
</tr>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['type']->value=='input_add_ar') {?>
<tr>
	<td><?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
</td>
	<td>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['count']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
		<div>
			<?php  $_smarty_tpl->tpl_vars['valuedata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['valuedata']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['valuedata']->key => $_smarty_tpl->tpl_vars['valuedata']->value) {
$_smarty_tpl->tpl_vars['valuedata']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['valuedata']->key;
?>
			<span style="padding-left:10px; color:RoyalBlue;"><?php echo $_smarty_tpl->tpl_vars['data']->value['name'][$_smarty_tpl->tpl_vars['key']->value];?>
 : </span>
			<input type="text" style="width:150px; margin-top:5px;" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['valuedata']->value[$_smarty_tpl->tpl_vars['item']->value];?>
" />
			<?php } ?>
			<input type="button" class="smallbutton red" value="删除" onclick="$(this).parent().remove();"/>
			<hr />
		</div>
		<?php } ?>
		<input type="button" class='smallbutton blue' id="input_add_tag_<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" value="添加" onclick='addInputTagAr("<?php echo $_smarty_tpl->tpl_vars['data']->value['tag_name'];?>
", <?php echo $_smarty_tpl->tpl_vars['data']->value['input_add_ar_json'];?>
);'/>
	</td>
</tr>
<?php }?><?php }} ?>
