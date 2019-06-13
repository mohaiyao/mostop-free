var $ = null;
var element = null;

// 创建 tab
var create_tab = function (title, url){
    var tab_li = $('.layui-layout-admin .layui-body .layui-tab-title li');
    var tab_li_length = tab_li.length;
    var find_this_li = false;
    var find_li_last = false;
    $.each(tab_li, function (k, v){
        if($(v).find('span').text() == title && $(v).find('span').data('url') == url)
        {
            find_this_li = $(v);
            return false;
        }
        if(k == tab_li_length - 1)
        {
            find_li_last = $(v);
        }
    });

    if(typeof find_this_li == 'boolean')
    {
        element.tabAdd('tab', {
            title: '<span data-url="' + url + '">' + title + '</span>',
            content: '<iframe src="' + url + '"></iframe>'
        });
        $(window).resize();
        find_this_li = $(find_li_last).next('li');
        $(find_this_li).on('mousedown', function (e){
            var li_index = $('.layui-layout-admin .layui-body .layui-tab-title li').index($(this));
            if(e.button == 2)
            {
                $('.mos-index-tab-right-click .layui-nav-child dd').removeClass('layui-this');
                $('.mos-index-tab-right-click').attr('data-tab', li_index).css({'left': e.pageX, 'top': e.pageY}).show();
            }
        });
    }

    tab_li.removeClass('layui-this');
    $(find_this_li).click();
};

layui.use(['element', 'layer'], function(){
    element = layui.element;
    $ = layui.jquery;

    // iframe 内容自适应
    $(window).on('resize', function (){
        var content = $('.layui-layout-admin .layui-body .layui-tab-content .layui-tab-item');
        var iframe_height = $('.layui-layout-admin .layui-body').height() - $('.layui-layout-admin .layui-body .layui-tab-title').height() - 1;
        content.find('iframe').each(function (){
            $(this).height(iframe_height);
            $(this).parent('.layui-tab-item').height(iframe_height);
        });
    }).resize();

    // menu 点击
    $('.mos-index-side-nav .layui-nav-item[data-menu="' + $('.mos-index-menu-nav .layui-this > a').data('menu') + '"]').show();
    element.on('nav(menu)', function (elem){
        var menu_num = elem.data('menu');
        $('.mos-index-side-nav .layui-nav-item').hide();
        $('.mos-index-side-nav .layui-nav-item[data-menu=' + menu_num + ']').show();
    });

    // side 点击
    element.on('nav(side)', function (elem){
        var url = elem.data('url');
        url && create_tab(elem.text(), elem.data('url'));
    });

    // 监听 iframe
    window.addEventListener('message', function (e){
        if(e.data.type == 'create_tab')
        {
            // 创建 tab
            create_tab(e.data.title, e.data.url);
        }
    });

    // 页面禁止右键
    $(document).bind('contextmenu', function (){
        return false;
    });

    // tab 右击
    $('.layui-layout-admin .layui-body .layui-tab-title li').on('mousedown', function (e){
        var li_index = $('.layui-layout-admin .layui-body .layui-tab-title li').index($(this));
        if(e.button == 2)
        {
            $('.mos-index-tab-right-click .layui-nav-child dd').removeClass('layui-this');
            $('.mos-index-tab-right-click').attr('data-tab', li_index).css({'left': e.pageX, 'top': e.pageY}).show();
        }
    });

    // tab 右击点击
    element.on('nav(tab-right)', function (elem){
        var tab_index = $('.mos-index-tab-right-click').attr('data-tab');
        var type = elem.data('type');
        if(type == 'refresh')
        {
            var tab_content = $('.layui-layout-admin .layui-body .layui-tab-content div:eq(' + tab_index + ')').find('iframe');
            tab_content.attr('src', tab_content.attr('src'));
        } else if(type == 'close') {
            var tab_index_li = $('.layui-layout-admin .layui-body .layui-tab-title li:eq(' + tab_index + ')');
            tab_index != 0 && tab_index_li.find('i').click();
        } else if(type == 'close_other') {
            var tab_index_li = $('.layui-layout-admin .layui-body .layui-tab-title li:eq(' + tab_index + ')');
            var tab_index_li_one = $('.layui-layout-admin .layui-body .layui-tab-title li:eq(0)');
            $('.layui-layout-admin .layui-body .layui-tab-title li').not(tab_index_li).not(tab_index_li_one).find('i').click();
        } else if(type == 'close_all') {
            var tab_index_li_one = $('.layui-layout-admin .layui-body .layui-tab-title li:eq(0)');
            $('.layui-layout-admin .layui-body .layui-tab-title li').not(tab_index_li_one).find('i').click();
        } else if(type == 'link') {
            var tab_content = $('.layui-layout-admin .layui-body .layui-tab-content div:eq(' + tab_index + ')').find('iframe');
            window.open(tab_content.attr('src'));
        }
        $('.mos-index-tab-right-click').hide();
    });

    // tab 聚焦处理滚动条兼容问题
    element.on('tab(tab)', function (elem){
        $(window.frames[elem.index].document).find('body').append('<div></div>');
        $(window.frames[elem.index].document).scrollTop(window.frames[elem.index].window.scroll_top - 1);
    });

    // 左右折叠展开
    $('.mos-index-fold-expand').on('click', function (){
        if($('.layui-side').hasClass('layui-hide'))
        {
            $('.layui-side').removeClass('layui-hide');
            $(this).css({'left': '200px'});
            $(this).find('i').removeClass('layui-icon-spread-left').addClass('layui-icon-shrink-right');
            $('.layui-body').css({'left': '200px'});
            $('.layui-footer').css({'left': '200px'});
        } else {
            $('.layui-side').addClass('layui-hide');
            $(this).css({'left': 0});
            $(this).find('i').removeClass('layui-icon-shrink-right').addClass('layui-icon-spread-left');
            $('.layui-body').css({'left': 0});
            $('.layui-footer').css({'left': 0});
        }
    });
});