$(document).ready(function(){

    wangEditor.config.printLog = false;
    var editor = new wangEditor('description');
    editor.config.jsFilter = true;
    editor.config.menus = [
        'undo',
        'redo',
        'source',
        '|',
        'bold',
        'underline',
        'italic',
        '|',
        'alignleft',
        'aligncenter',
        'alignright',
        '|',
        'quote',
        'strikethrough',
        'eraser',
        'forecolor',
        'bgcolor',
        '|',
        'fontfamily',
        'fontsize',
        'head',
        'unorderlist',
        'orderlist',
        '|',
        'link',
        'unlink',
        'table',
        'emotion',
        '|',
        'img',
        'video',
        'insertcode',
        '|',
        'fullscreen',

    ];
    editor.config.emotions = {
    // 支持多组表情

    // 第一组，id叫做 'default'
    // 第二组，id叫做'weibo'
    'weibo': {
        title: '表情',  // 组名称
        data: [  // data 还可以直接赋值为一个表情包数组
            {
                'icon': 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/7a/shenshou_thumb.gif',
                'value': '[草泥马]'
            },
        ]
    }
    // 下面还可以继续，第三组、第四组、、、
};
    editor.create();

    // var testEditor;

    // $(function() {
    //     testEditor = editormd("test-editormd", {
    //         width   : "100%",
    //         height  : 600,
    //         syncScrolling : "single",
    //         path    : "/lib/editor.md/lib/",
    //         watch : false,
    //         toolbarIcons : function() {
    //             return ["undo", "redo", "|", "bold" , "italic" , "ucwords" , "uppercase" , "lowercase" , "hr" , "|" , "list-ul" , "list-ol" , "|" , "link" , "reference-link", "image", "||", "watch", "fullscreen", "preview"]
    //         },
    //     });
    // });
});
