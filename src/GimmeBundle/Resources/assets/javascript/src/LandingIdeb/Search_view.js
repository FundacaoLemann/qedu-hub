(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebLanding/Assets/js/view/Search',
            [
                'jquery',
                'backbone'
            ],
            factory
        );
    } else {
        root.SearchView = factory(root.jQuery, root.Backbone);
    }
}(this, function ($, Backbone) {
    var SearchView = Backbone.View.extend({
        inputValue: 'Digite um nome',

        el: '.ideb-search',
        events: {
            'focus input' : 'hideValue',
            'blur input' : 'showValue'
        },

        hideValue: function(e) {
            var input = this.$(e.currentTarget);
            if (input.val() == '') {
                this.$('.search-label').hide();
            }

            Backbone.trigger('ideb-search:focus');;
        },

        showValue: function(e) {
            var input = this.$(e.currentTarget);
            if (input.val() == '') {
                this.$('.search-label').show();
            }

            Backbone.trigger('ideb-search:blur');
        }
    });

    return SearchView;
}));
