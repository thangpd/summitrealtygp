(function ($) {
    $(document).ready(function () {
        let $regis = $('.regis-form');

        $regis.on('submit', function (e) {
            e.preventDefault()
            let password = $(this).find('input[name="password"]')
            let md5pass = $.md5(password.val())
            // password.val(md5pass);
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
                    } else {
                        $('.error-msg').html(res.msg)
                    }
                }
            })
        })
        $regis.validate();


        let $active = $('.active-form');
        $active.on('submit', function (e) {
            e.preventDefault()
            var form_data = $(this).serialize()
            console.log(form_data)
            var data = form_data + '&action=action_active_ajax'
            $(this).find('input[name="submit"]').addClass('.loader')

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
        if ($active.length > 0) {
            $active.find('#state').select2()
        }
        $active.validate()

        // Login form

        const $login = $('.login-form');
        $login.on('submit', function (e) {
            e.preventDefault();

            var form_data = $(this).serialize();
            var data = form_data + '&action=action_login_ajax';

            $.ajax({
                type: "POST",
                url: ajax_object.ajax_url,
                data: data,
                dataType: 'json',
                success: function (res) {
                    if (res.code == 200) {
                        $('#login-error-msg').html(res.msg);
                        window.location = res.redirect;
                    } else {
                        $('#login-error-msg').html('User or password is incorrect!');
                    }
                }
            });
        });


    })

})(jQuery)
