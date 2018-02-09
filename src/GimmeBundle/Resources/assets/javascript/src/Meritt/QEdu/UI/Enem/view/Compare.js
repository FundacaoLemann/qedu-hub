(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Enem/Assets/js/view/Compare',
            [
                'jquery',
                'backbone',
                'underscore'
            ],
            factory
        );
    } else {
        root.CompareView = factory(root.jQuery, root.Backbone, root._);
    }
}(this, function ($, Backbone, _) {
    return Backbone.View.extend({
        el: '.score-ct',

        initialize: function(config) {
            if (! config.canBeCompared) {
                this.render();
            }
        },

        render: function() {
            this.$el.addClass('cannot-compare');

            this.$('.description').parent().append(_.template($('#tmp-compare-note').html()));
            this.$('.score').append(_.template($('#tmp-compare-sign').html().trim()));

            this.$('[class*="compare-"]').hide().show(500);
        }
    });
}));
