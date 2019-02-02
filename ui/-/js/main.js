// head {
var __nodeId__ = "ss_tm_ui__main";
var __nodeNs__ = "ss_tm_ui";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.bindEvents();
        },

        bindEvents: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.e('ss/tm/eventRecord', function (data) {
                var $session = $(".session[key='" + data.sessionKey + "']", $w);

                if ($session.length) {
                    w.r('loadRecord', {
                        record_id: data.recordId
                    });
                } else {
                    w.r('reload');
                }
            });
        }
    });
})(__nodeNs__, __nodeId__);
