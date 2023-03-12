$(document).ready(function () {
    // choose all item in table
    $(".checkAll").on('change', function () {
        $(".checkBox").prop('checked', $(this).is(":checked"));
    });
})
