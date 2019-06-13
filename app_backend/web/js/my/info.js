layui.use(['upload', 'laydate'], function (){
    var $ = layui.jquery;
    var upload = layui.upload;
    var laydate = layui.laydate;

    var upload_inst = upload.render({
        elem: '#mos-my-info-avatar-btn',
        done: function (response){
            if(response.status == 1000)
            {
                $('#mos-my-info-avatar-upload-error').find('.mos-my-info-avatar-reload').off('click');
                $('#mos-my-info-avatar-upload-error').html('');
                $('#mos-my-info-avatar').attr('src', response.data.url);
                $('#mos-my-info-avatar-hidden').val(response.data.url);
                layer.msg(response.msg, {icon: 1});
            } else {
                layer.msg(response.msg, {icon: 2});
            }
        },
        error: function (){
            var upload_error = $('#mos-my-info-avatar-upload-error');
            upload_error.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini mos-my-info-avatar-reload">重试</a>');
            upload_error.find('.mos-my-info-avatar-reload').on('click', function (){
                upload_inst.upload();
            });
        }
    });
    var today = new Date();
    laydate.render({
        elem: '#mos-my-info-birthday',
        max: today.getFullYear() + '-' + (parseInt(today.getMonth()) + 1) + '-' + today.getDate()
    });
});