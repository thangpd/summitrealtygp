(function ($) {
    $(document).on('ready', function () {
        console.log($('body'))
        $('.bhhs-form').on('submit', function (e) {
            e.preventDefault()
            var address = $(this).find('input[name="address"]').val();
            // var nonce = $(this).attr("data-nonce")
            // var data = {action: "search_bhhs_form", post_id: post_id, nonce: nonce};
            var data = {action: "search_bhhs_form", address: address};
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
            })

        })
    })
})(jQuery);