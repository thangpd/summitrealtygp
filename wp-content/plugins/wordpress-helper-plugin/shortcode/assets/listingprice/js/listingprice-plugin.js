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
                }
            })
        })


        // var address = $(this).find('input[name="address"]').val();
        // var nonce = $(this).attr("data-nonce")
        // var data = {action: "search_bhhs_form", post_id: post_id, nonce: nonce};
        /*var data = {action: "search_bhhs_form", address: address};
        $('.res-search').html('');
        $.ajax({
            type: "GET",
            url: ajax_object.ajax_url,
            data: data,
            dataType: 'JSON',
            success: function (res) {
                console.log('ok')
                console.log(res.code)
                let $res = $('.res-search');
                $res.append(res.title)
                $res.append(res.threedots)
                $res.append(res.soldprice)
            }
        })*/

    })
})(jQuery);