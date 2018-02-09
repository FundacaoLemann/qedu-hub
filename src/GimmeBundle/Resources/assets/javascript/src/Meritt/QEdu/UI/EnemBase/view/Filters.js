(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemBase/Assets/js/view/Filters',
            [
                'jquery',
                'backbone'
            ],
            factory
        );
    } else {
        root.FiltersView = factory(root.jQuery, root.Backbone);
    }
}(this, function ($, Backbone) {
    return Backbone.View.extend({
        el: '.filters',

        events: {
            'click #edition .dropdown-menu li:not(.disabled) a' : 'selectEdition',
            'click #filter-education-network-type a' : 'selectEducationNetworkType'
        },

        selectEdition: function(e) {
            var edition = $(e.target).data('value');
            Backbone.trigger('schoolList:ChangeEdition', edition);
        },

        selectEducationNetworkType: function(e) {
            e.preventDefault();
            
            var educationNetwork = $(e.target).data('key');
            if (! educationNetwork) {
                educationNetwork = null;
            }

            Backbone.trigger('schoolList:ChangeEducationNetworkType', educationNetwork);
        }
    });
}));
