/**
 * Created by Оксана и Алексей on 04.04.15.
 */

$(document).ready(function () {

    $(document).on("submit", '.signup-form', function (e) {
        //e.preventDefault();
        var form = $(this);
        $.ajax({
            url: document.location,
            type: "POST",
            data: form.serialize(),
            dataType: 'json',
            success: function (data) {
                console.log('data=');
                console.log(data);
                if (data.message) $(".breadcrumb").after(data.message);
            }
        });
        setTimeout( '$(".alert").slideUp()' , 5000);
        return false;
    });

});
