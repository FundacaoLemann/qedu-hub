(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebLanding/Assets/js/view/IdebInStates',
            [
                'jquery',
                'backbone'
            ],
            factory
        );
    } else {
        root.IdebInStatesView = factory(root.jQuery, root.Backbone);
    }
}(this, function ($, Backbone) {
    var IdebInStatesView = Backbone.View.extend({
        el: '.ideb-in-states',

        events: {
            'click .situation-state:not(.active)' : 'selectSituation',
            'click .growth-state:not(.active)'    : 'selectGrowth',
            'click .goal-state:not(.active)'      : 'selectGoal'
        },

        selectSituation: function(e) {
            e.preventDefault();

            this.markAsActive('.situation-state');
            this.displayTab('.ideb-schools-map');
        },

        selectGrowth: function(e) {
            e.preventDefault();

            this.markAsActive('.growth-state');
            this.displayTab('.ideb-growth');
        },

        selectGoal: function(e) {
            e.preventDefault();

            this.markAsActive('.goal-state');
            this.displayTab('.ideb-goal');
        },

        markAsActive: function(el) {
            this.$('.active').removeClass('active');
            $(el).addClass('active');
        },

        displayTab: function(tab) {
            $('.situation-tab').hide();
            $(tab).show();
        }
    });

    return IdebInStatesView;
}));
