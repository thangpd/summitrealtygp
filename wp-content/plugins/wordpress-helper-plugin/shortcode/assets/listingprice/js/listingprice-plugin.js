(function ($) {
    $(document).on('ready', function () {
        $('.btn-zestimate').on('click', function (e) {
            e.preventDefault()
            let title = $('#listing-title').html()
            var data = {action: "get_price_zestimate", title: title};
            $.ajax({
                type: "GET",
                url: ajax_object.ajax_url,
                data: data,
                dataType: 'JSON',
                success: function (res) {
                    $('.zestimate-price').html(res.price);
                    $('.zestimate-price').removeClass('loading');
                    $('.zestimate-price').addClass('done');
                },
                beforeSend: function () {
                   $('.zestimate-price').addClass('loading');
                   $('.zestimate-price a').html('');
                }
            })
        });
    });
})(jQuery);