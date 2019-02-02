// head {
var __nodeId__ = "ss_tm__main";
var __nodeNs__ = "ss_tm";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;
        },

        gm: function (data) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $("head").append($('<script type="text/javascript" src="' + data.src + '"></script>'));

            var ymapsWait = setInterval(function () {
                if (typeof ymaps !== 'undefined' && typeof ymaps.geolocation !== 'undefined') {
                    ymaps.geolocation.get({
                        provider:           'yandex',
                        autoReverseGeocode: true
                    }).then(function (result) {
                        w.mr('gd', {
                            meta: result.geoObjects.get(0).properties.get('metaDataProperty')
                        });
                    });

                    clearInterval(ymapsWait);
                }
            }, 200);
        },

        hm: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $window = $(window);

            var hd;

            var reset = function () {
                hd = {
                    mm: {},
                    sp: {},
                    ws: {}
                };
            };

            reset();

            $window.rebind("mousemove." + __nodeId__, function (e) {
                var date = new Date();

                hd.mm[date.getTime()] = [e.pageX, e.pageY];

                send();
            });

            $window.rebind("resize." + __nodeId__, function () {
                var date = new Date();

                hd.ws[date.getTime()] = [$window.width(), $window.height()];

                send();
            });

            $window.rebind("scroll." + __nodeId__, function () {
                var date = new Date();

                hd.sp[date.getTime()] = [$window.scrollLeft(), $window.scrollTop()];

                send();
            });

            $window.on("beforeunload", function () {
                w.mr('hd', hd);

                reset();
                clearTimeout(sendTimeout);
            });

            var sendTimeout;

            var send = function () {
                clearTimeout(sendTimeout);

                sendTimeout = setTimeout(function () {
                    w.mr('hd', {
                        e:  o.e,
                        hd: hd
                    });

                    reset();
                }, 1000);
            };
        }
    });
})(__nodeNs__, __nodeId__);
