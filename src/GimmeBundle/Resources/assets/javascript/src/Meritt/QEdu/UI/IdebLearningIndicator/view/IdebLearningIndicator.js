(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebLearningIndicator/Assets/js/view/IdebLearningIndicator',
            [
                'jquery',
                'backbone',
                'underscore',
            ],
            factory
        );
    } else {
        root.IdebLearningIndicatorView = factory(root.jQuery, root.Backbone, root._);
    }
}(this, function ($, Backbone, _) {
    var IdebLearningIndicatorView = Backbone.View.extend({
        el: '.mask-learning',

        events: {
            'click .btn-action' : 'changeView'
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

    return IdebLearningIndicatorView;
}));
