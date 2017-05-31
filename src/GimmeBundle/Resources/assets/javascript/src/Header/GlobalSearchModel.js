(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Header/Assets/js/GlobalSearchModel',
            [ 'backbone' ],
            factory
        );
    } else {
        root.GlobalSearchModel = factory(root.Backbone);
    }
}(this, function (Backbone) {
    return Backbone.Model.extend({
        defaults: {
            states: [],
            cities: [],
            schools: [],
            last_update: null
        },
        removeAll: function () {
            return this.set(
                {
                    'schools': [],
                    'cities': [],
                    'citygroups': [],
                    'states': [],
                    'last_update': new Date()
                },
                {
                    'silent': true
                }
            );
        }
    });
}));