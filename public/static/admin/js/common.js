/**
 * 全屏编辑或查看
 * @param  {[type]} title [description]
 * @param  {[type]} url   [description]
 * @return {[type]}       [description]
 */
function o2o_edit(title, url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/**
 * 添加或编辑，在弹出视窗下 
 * @param  {[type]} title [description]
 * @param  {[type]} url   [description]
 * @param  {[type]} w     [description]
 * @param  {[type]} h     [description]
 * @return {[type]}       [description]
 */
function o2o_s_edit(title, url, w, h){
	layer_show(title, url, w, h);
}

/**
 * 删除
 * @param  {[type]} url [description]
 * @param  {[type]} id  [description]
 * @return {[type]}     [description]
 */
function o2o_del(url,id){
	layer.confirm('确认要删除吗？',function(index){
		window.location.href = url;
	});
}

/**
 * 异步排序
 * @param  {Object} [description]
 * @param  {[type]} [description]
 * @param  {[type]} [description]
 * @return {[type]} [description]
 */
$('.ajax-sort').change(function () {
	var postData = {
		id: $(this).attr('attr-id'),
		sort: parseInt($(this).val().trim())
	};

	$.post(url, postData, function(result, textStatus, xhr) {
		if(result.code == 0){
			layer.msg(result.msg, {icon: 6});
			window.setTimeout(function(){
                location.href = result.data;
            }, 1000);
		}
		else{
			layer.msg(result.msg, {icon: 5});
		}
	}, 'json');
});

/**
 * 异步获取二级城市
 * @param  {[type]}   [description]
 * @return {[type]}   [description]
 */
$('.cityId').change(function () {
	var id = parseInt($(this).val()),
		html = '<option value="0">--请选择--</option>',
		$obj = $('.se_city_id'),
		url = _city_url_,
		postData = { id: id };

	if(!id){
		$obj.html(html);
		return false;
	}

	$.post(url, postData, function (result, textStatus, xhr) {
		if(result.code == 0){
			$.each(result.data, function (i, v) {
				html += '<option value="' + v.id + '">' + v.name + '</option>';
			});
			$obj.html(html);
			return true;
		}
		else{
			layer.msg(result.msg, {icon: 5});
			return false;
		}
	}, 'json');		
});

/**
 * 异步获取分类
 * @param  {[type]} ) [description]
 * @return {[type]}   [description]
 */
$('.categoryId').change(function () {
	var id = parseInt($(this).val()),
		html = '',
		$obj = $('.se_category_id'),
		url = _category_url_,
		postData = { id: id };

	if(!id){
		$obj.html(html);
		return false;
	}

	$.post(url, postData, function (result, textStatus, xhr) {
		if(result.code == 0){
			$.each(result.data, function (i, v) {
				html += '<input type="checkbox" id="checkbox-moban" name="se_category_id[]" value="' + v.id + '"/>&nbsp;' + '<label for="checkbox-moban">' + v.name + '</label>&nbsp;';
			});
			$obj.html(html);
			return true;
		}
		else{
			layer.msg(result.msg, {icon: 5});
			return false;
		}
	}, 'json');		
});

// 有效性标志位
var ok = {
	magtag: false,
	username: false
};

/**
 * 异步获取经纬度
 * @param  {[type]} ) [description]
 * @return {[type]}   [description]
 */
$('.maptag').click(function () {
	var address = $(this).val().trim(),
		url = _lng_lat_url_,
		postData = {address: address};

	$.post(url, postData, function (result, textStatus, xhr) {
		if(result.code == 0){
			layer.msg('经度：' + result.data.result.location.lng + ', 纬度：' + result.data.result.location.lat);
			ok.magtag = true;
			return true;
		}
		else{
			layer.msg(result.msg, {icon: 5});
			ok.magtag = false;
			return false;
		}
	}, 'json');
});

/**
 * 异步验证用户名
 * @param  {[type]} ) [description]
 * @return {[type]}   [description]
 */
$('input[name="username"]').blur(function () {
	var username = $(this).val().trim(),
		url = _get_uname_url,
		postData = {username: username};

	$.post(url, postData, function (result, textStatus, xhr) {
		if(result.code == 0){
			ok.username = true;
			return true;
		}
		else{
			layer.msg(result.msg, {icon: 5});
			ok.username = false;
			return false;
		}
	}, 'json');
});

/**
 * 商户注册前端验证
 * @param  {[type]} ) [description]
 * @return {[type]}   [description]
 */
$('#regis').submit(function () {
	if(!ok.magtag){
		$('.maptag').click();
		$('input[name="address"]').focus();
		return false;
	}
	else if(!ok.username){
		$('input[name="username"]').blur().focus();
		return false;
	}

	return true;
});

/**
 * 关于h-ui.admin的日期插件My97 DatePicker与Think php模版标签冲突的解决方法
 * @param  {[type]} flag [description]
 * @return {[type]}      [description]
 */
function selecttime(flag){
    if(flag == 1){
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }else{
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:startTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }
 }