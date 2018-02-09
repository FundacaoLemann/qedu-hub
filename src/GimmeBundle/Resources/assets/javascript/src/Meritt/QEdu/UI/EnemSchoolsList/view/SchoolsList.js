(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/view/SchoolsList',
            [
                'jquery',
                'backbone',
                'underscore',
                'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/collection/SchoolResults'
            ],
            factory
        );
    } else {
        root.SchoolsListView = factory(root.jQuery, root.Backbone, root._, root.SchoolResultsCollection);
    }
}(this, function ($, Backbone, _, SchoolResultsCollection) {
    return Backbone.View.extend({
        el: '.enem-children-list',

        initialize: function (config) {
            this.template = _.template($('#tmp-schools-list').html());

            this.collection = new SchoolResultsCollection(config.models, {parse: true});

            this.render();
        },

        render: function () {
            this.$('tbody').html(this.template({
                'collection': this.collection,
                'view'      : this
            }));
        }
    });
}));