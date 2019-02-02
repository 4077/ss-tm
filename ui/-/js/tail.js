// head {
var __nodeId__ = "ss_tm_ui__tail";
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
            w.bind();
        },

        bindEvents: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.e('ss/tm/eventRecord', function (data) {
                if (o.envId === data.envId) {
                    w.mr('loadNewRecords');
                }
            });
        },

        bind: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $(".record", $w).each(function () {
                w.bindRecord($(this));
            });
        },

        bindRecords: function (ids) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $.each(ids, function (n, id) {
                w.bindRecord($(".record[record_id='" + id + "']", $w));
            });
        },

        bindRecord: function ($record) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $(".client_cell", $record).bind("click", function () {
                w.r('eventInfo', {
                    record_id: $(this).closest(".record").attr("record_id")
                });
            });
        },

        drawHumandata: function (recordId, data) {

        }
    });
})(__nodeNs__, __nodeId__);
