$("form").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
        return false;
    }
});

/**
 * Created by jimbomilk on 4/5/2017.
 */
function readURL(input,tag) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(tag).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}