$(".tag-select2").select2({
    tags: true,
    placeholder: "Tạo thẻ mới",
    tokenSeparators: [','],
    selectionCssClass: ":all: custom-selection"
})
$(".color-select2").select2({
    tags: true,
    placeholder: "Chọn màu sắc",
    selectionCssClass: ":all: custom-selection"
})

let editor_config = {
    path_absolute: "/",
    selector: "textarea.tinymce_editor_init",
    width: 1124,
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
$('#feature_image_path').on('change', (e) => {
    const file = e.target.files[0];
    const feature_image_path = $('.feature_image_path');
    const feature_image_path_amount = $('.feature_image_path--amount');
    if (file.type.match('image.*')) {
        feature_image_path.empty();
        feature_image_path_amount.text(1);
        const reader = new FileReader();
        reader.onload = (e) => feature_image_path.html('<img src="' + e.target.result + '">');
        reader.readAsDataURL(file);
    }
});
$('#image_path').on('change', (e) => {
    const files = e.target.files;
    const image_path = $('.image_path');
    const image_path_amount = $('.image_path--amount');
    image_path.empty();
    image_path_amount.text(files.length);
    $.each(files, (index, file) => {
        if (file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = (e) => image_path.append('<img src="' + e.target.result + '" alt="">');
            reader.readAsDataURL(file);
        }
    });
});
