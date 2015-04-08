function addInputTag(name, id, css) {
	var str = '<div>';
	str += '<input type="text" style="width:400px; margin-top:5px;" name="' + name + '[]" id="' + id + '" css="' + css + '" value="" /> ';
	str += '<input type="button" class="smallbutton red" value="删除" onclick="$(this).parent().remove();"/>';
	$("#input_add_tag_" + name).before(str);
}

/**
 * 更改元素之前的值为选中值
 * @param  {[type]} that [description]
 * @return {[type]}      [description]
 */
function change_priv_val(that) {
	var choose = false;
	$(that).prev().children().each(function() {
		if($(this).text().indexOf(that.value) >= 0) {
			if(!choose) {
				$(this).attr('selected', true);
			}
			if($(this).text() == that.value) {
				choose = true;
			}
		}
	})
}

function addInputTagAr(tagname, data) {
	console.log(data);
	return;
	var tag = $("#input_add_ar_tag_" + tagname);
	var str = '<div>';
	for(key in title) {
		str += '<span style="padding-left:10px; color:RoyalBlue;">' + title[key] + ': </span><input type="text" style="width:150px; margin-top:5px;" name="' + name[key] + '[]" value="" />';
	}
	str += '<span style="cursor:pointer; color:Crimson; padding-left:5px;" onclick="$(this).parent().remove();">删除</span><hr /></div>';
	tag.before(str);
}