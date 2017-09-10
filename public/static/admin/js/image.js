$(function () {
    
    /*******************
     *
     * 前端图片处理逻辑
     *
     ******************/
    
    /**
     * 缩略图上传，实例化uploadify上传插件
     * @param  {[type]} file           [description]
     * @param  {[type]} data           [description]
     * @param  {[type]} response)      {                                                          data [description]
     * @param  {[type]} onUploadError: function(file, errorCode, errorMsg, errorString) {                              $('#upload_org_code_img').attr('src', '').hide();            $('#file_upload').val('');            layer.msg('上传失败，请重试：' + errorMsg, {icon : 5});        }    } [description]
     * @return {[type]}                [description]
     */
    $('#file_upload').uploadify({
        swf      : _uploadify_swf_, // 引入Uploadify 的核心Flash文件
        uploader : _uploader_, // PHP处理脚本的地址
        buttonText: '请选择图片',
        fileTypeDesc: 'Image File', // 选择文件对话框中图片类型提示文字
        fileTypeExts: '*.jpg;*.jpeg;*.png;*.gif', // 选择文件对话框中允许选择的文件类型
        onUploadSuccess : function(file, data, response) { // 上传成功回调函数
            data = JSON.parse(data);
            $('#upload_org_code_img').attr('src', data.data).show();
            $('#file_upload_image').val(data.data);
        },
        onUploadError: function(file, errorCode, errorMsg, errorString) { // 上传失败回调函数
            $('#upload_org_code_img').attr('src', '').hide();
            $('#file_upload_image').val('');
            layer.msg('上传失败，请重试：' + errorMsg, {icon : 5});
        }
    });

    /**
     * 营业执照上传，实例化uploadify上传插件
     * @param  {[type]} file           [description]
     * @param  {[type]} data           [description]
     * @param  {[type]} response)      {                                                          data [description]
     * @param  {[type]} onUploadError: function(file, errorCode, errorMsg, errorString) {                              $('#upload_org_code_img').attr('src', '').hide();            $('#file_upload').val('');            layer.msg('上传失败，请重试：' + errorMsg, {icon : 5});        }    } [description]
     * @return {[type]}                [description]
     */
    $('#file_upload_other').uploadify({
        swf      : _uploadify_swf_, // 引入Uploadify 的核心Flash文件
        uploader : _uploader_, // PHP处理脚本的地址
        buttonText: '请选择图片',
        fileTypeDesc: 'Image File', // 选择文件对话框中图片类型提示文字
        fileTypeExts: '*.jpg;*.jpeg;*.png;*.gif', // 选择文件对话框中允许选择的文件类型
        onUploadSuccess : function(file, data, response) { // 上传成功回调函数
            data = JSON.parse(data);
            $('#upload_org_code_img_other').attr('src', data.data).show();
            $('#file_upload_image_other').val(data.data);
        },
        onUploadError: function(file, errorCode, errorMsg, errorString) { // 上传失败回调函数
            $('#upload_org_code_img_other').attr('src', '').hide();
            $('#file_upload_image_other').val('');
            layer.msg('上传失败，请重试：' + errorMsg, {icon : 5});
        }
    });
});