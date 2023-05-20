$(".tag-select2").select2({
    tags: true,
    placeholder: "Chọn tag name",
    tokenSeparators: [',']
})
$(".color-select2").select2({
    tags: true,
    placeholder: "Chọn màu",
})

let editor_config = {
    path_absolute: "/",
    selector: "textarea.tinymce_editor_init",
    height: 300,
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | fontsizeselect",
    relative_urls: false,
    file_browser_callback: function (field_name, url, type, win) {
        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

        let cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
        if (type === 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'Filemanager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
        });
    }
};
tinymce.init(editor_config);

const tabs = $('.tab_button');
const contents = $('.content');
const line = $('.line');
$.each(tabs, (index, tab) => {
    $(tab).on('click', (e) => {
        $.each(tabs, (index, tab) => $(tab).removeClass('active'));
        $(tab).addClass('active');
        line.css({
            "width": e.target.offsetWidth,
            "left": e.target.offsetLeft
        })
        $.each(contents, (index, content) => $(content).removeClass('active'));
        $(contents[index]).addClass('active');
    });
})
