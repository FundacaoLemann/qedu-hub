(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebFlowIndicator/Assets/js/view/IdebFlowIndicator',
            [
                'jquery',
                'backbone',
                'underscore',
            ],
            factory
        );
    } else {
        root.IdebFlowIndicatorView = factory(root.jQuery, root.Backbone, root._);
    }
}(this, function ($, Backbone, _) {
    return Backbone.View.extend({
        el: '.mask-flow',

        events: {
            'click .btn-qedu' : 'changeView'
        },

        changeView: function(e) {
            this.toggleLoader();
            this.toggleFadeClass();

            setTimeout(_.bind(function(){
                this.toggleSlideClass();
                this.toggleFadeClass();
                this.toggleLoader();
            }, this), 1000);

            e.preventDefault();
        },

        toggleLoader: function() {
            this.$el.toggleClass('ideb-loader');
        },

        toggleSlideClass: function() {
            this.$el.find('.mask').toggleClass('slide-next');
        },

        toggleFadeClass: function() {
            this.$el.find('.row').toggleClass('fade-out');
        }
    });
}));
