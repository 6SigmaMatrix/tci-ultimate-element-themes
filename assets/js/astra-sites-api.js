(function ($) {
    TCISitesAPI = {
        _api_url: tciSitesApi.ApiURL,
        /**
         * API Request
         */
        _api_request: function (args) {
            // Set API Request Data.
            var data = {
                url: TCISitesAPI._api_url + args.slug,
                cache: false,
            };
            if (astraRenderGrid.headers) {
                data.headers = astraRenderGrid.headers;
            }
            $.ajax(data)
                .done(function (items, status, XHR) {
                    if ('success' === status && XHR.getResponseHeader('x-wp-total')) {
                        var data = {
                            args: args,
                            items: items,
                            items_count: XHR.getResponseHeader('x-wp-total') || 0,
                        };
                        console.log(data);
                        if ('undefined' !== args.trigger && '' !== args.trigger) {
                            $(document).trigger(args.trigger, [data]);
                        }
                    } else {
                        $(document).trigger('astra-sites-api-request-error');
                    }
                })
                .fail(function (jqXHR, textStatus) {
                    $(document).trigger('astra-sites-api-request-fail');
                })
                .always(function () {
                    $(document).trigger('astra-sites-api-request-always');
                });
        },
    };
})(jQuery);