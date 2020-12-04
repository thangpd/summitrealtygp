(function ($) {
    $(document).ready(function () {


        let $regis = $('.regis-form');
        $regis.on('submit', function (e) {
            e.preventDefault()
            let password = $(this).find('input[name="password"]');
            let md5pass = $.md5(password.val());
            password.val(md5pass);
            var form_data = $(this).serialize()
            console.log(form_data)
            var data = form_data + '&action=action_register_ajax'
            $.ajax({
                type: "POST",
                url: ajax_object.ajax_url,
                data: data,
                dataType: 'JSON',
                success: function (res) {
                    if (res.code === 200) {
                        $('.main-agileinfo').html(res.data)
                    }
                }
            })
        })
        $regis.validate({
            submitHandler: function (form) {
                // some other code
                // maybe disabling submit button
                // then:
                if ($form.valid()) {
                    $(form).submit();
                }
            }
        });


        let $active = $('.active-form');
        $active.on('submit', function (e) {
            e.preventDefault()
            var form_data = $(this).serialize()
            console.log(form_data)
            var data = form_data + '&action=action_active_ajax'
            $.ajax({
                type: "POST",
                url: ajax_object.ajax_url,
                data: data,
                dataType: 'JSON',
                success: function (res) {
                    console.log(res)
                    if (res.code === 200) {
                        $('.main-agileinfo').html(res.data)
                        let $verificationCircle = $('.verification__circle-wrapper.current');
                        $verificationCircle.removeClass('current')
                        let $verificationCircle_third = $('.verification__circle-wrapper:eq(2)');
                        console.log($verificationCircle_third)
                        $verificationCircle_third.addClass('current')
                    }
                }
            })
        })

        $active.validate({
            submitHandler: function (form) {
                // some other code
                // maybe disabling submit button
                // then:
                if (form.valid()) {
                    $(form).submit();
                }
            }
        })

    })

})(jQuery)
