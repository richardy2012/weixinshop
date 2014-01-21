<?php if (!defined('THINK_PATHSLAPP')) exit();?><!--添加栏目-->
<div class="dialog_content">
	<form id="info_form" action="{:U('item_cate/add')}" method="post">
	<table width="100%" class="table_form">
		<tr> 
			<th width="100">上级栏目:</th>
			<td>
				<select class="J_cate_select mr10" data-pid="0" data-uri="{:U('item_cate/ajax_getchilds')}" data-selected="{$spid}"></select>
				<input type="hidden" name="pid" id="J_cate_id" />
			</td>
		</tr>
		<tr>
			<th>商品分类名称 :</th>
			<td>
				<input type="text" name="name" id="J_name" class="input-text" size="30">
		        <input type="hidden" value="" name="fcolor" id="J_color">
		        <a href="javascript:;" class="color_picker_btn"><img class="J_color_picker" data-it="J_name" data-ic="J_color" src="__ROOT__/weTall/static/images/color.png"></a>
			</td>
		</tr>
        <tr>
            <th>商品分类图片 :</th>
            <td>
            	<input type="text" name="img" id="J_img" class="input-text fl mr10" size="30">
            	<div id="J_upload_img" class="upload_btn"><span>上传</span></div>
            </td>
        </tr>
        <tr>
			<th>分类类型 :</th>
            <td>
            	<label><input type="radio" name="type" value="0" checked>商品类型 </label>&nbsp;&nbsp;
                <!--<label><input type="radio" name="type" value="1"> {:L('item_cate_type_tag')}</label>-->
            </td>
        </tr>
        <tr>
			<th>首页显示 :</th>
            <td>
                <label><input type="radio" name="is_index" value="0" > 不显示</label>&nbsp;&nbsp;
                <label><input type="radio" name="is_index" value="1" checked> 显示</label>
            </td>
        </tr>
		<tr>
			<th>审核状态 :</th>
            <td>
                <label><input type="radio" name="status" value="0" > 未审核</label>&nbsp;&nbsp;
                <label><input type="radio" name="status" value="1" checked> 已审核</label>
            </td>
        </tr>
	<!--	<tr>
			<th>{:L('seo_title')} :</th>
			<td><input type="text" name="seo_title" class="input-text" style="width:300px;"></td>
		</tr>
		<tr>
			<th>{:L('seo_keys')} :</th>
			<td><input type="text" name="seo_keys" class="input-text" style="width:300px;"></td>
		</tr>
		<tr>
			<th>{:L('seo_desc')} :</th>
			<td><textarea name="seo_desc" style="width:295px; height:50px;"></textarea></td>
		</tr>-->
	</table>
	</form>
</div>
<script src="__ROOT__/weTall/static/js/jquery/plugins/colorpicker.js"></script>
<script src="__ROOT__/weTall/static/js/fileuploader.js"></script>
<script>
$(function(){
	$.formValidator.initConfig({formid:"info_form",autotip:true});
	$('#J_name').formValidator({onshow:lang.please_input+lang.item_cate_name,onfocus:lang.please_input+lang.item_cate_name}).inputValidator({min:1,onerror:lang.please_input+lang.item_cate_name});
	
	$('#info_form').ajaxForm({success:complate, dataType:'json'});
	function complate(result){
		if(result.status == 1){
			$.dialog.get(result.dialog).close();
			$.pinphp.tip({content:result.msg});
			window.location.reload();
		} else {
			$.pinphp.tip({content:result.msg, icon:'alert'});
		}
	}

	//分类联动
	$('.J_cate_select').cate_select();

	//颜色选择器
	$('.J_color_picker').colorpicker();

	//上传图片
    var uploader = new qq.FileUploaderBasic({
    	allowedExtensions: ['jpg','gif','jpeg','png','bmp','pdg'],
        button: document.getElementById('J_upload_img'),
        multiple: false,
        action: "{:U('item_cate/ajax_upload_img')}",
        inputName: 'img',
        forceMultipart: true, //用$_FILES
        messages: {
        	typeError: lang.upload_type_error,
        	sizeError: lang.upload_size_error,
        	minSizeError: lang.upload_minsize_error,
        	emptyError: lang.upload_empty_error,
        	noFilesError: lang.upload_nofile_error,
        	onLeave: lang.upload_onLeave
        },
        showMessage: function(message){
        	$.pinphp.tip({content:message, icon:'error'});
        },
        onSubmit: function(id, fileName){
        	$('#J_upload_img').addClass('btn_disabled').find('span').text(lang.uploading);
        },
        onComplete: function(id, fileName, result){
        	$('#J_upload_img').removeClass('btn_disabled').find('span').text(lang.upload);
            if(result.status == '1'){
        		$('#J_img').val(result.data);
        	} else {
        		$.pinphp.tip({content:result.msg, icon:'error'});
        	}
        }
    });
});
</script>