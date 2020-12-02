(function ($) {
    $(document).ready(function () {


        $('.regis-form').on('submit', function (e) {
            e.preventDefault()
            var form_data = $(this).serialize()
            console.log(form_data)
            var data = form_data + '&action=action_register_ajax'
            $.ajax({
                type: "POST",
                url: ajax_object.ajax_url,
                data: data,
                dataType: 'JSON',
                success: function (res) {
                    console.log(res)
                }
            })
        })


    })

})(jQuery)
