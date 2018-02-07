(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/model/SchoolModel',
            [
                'backbone'
            ],
            factory
        );
    } else {
        root.SchoolModel = factory(root.Backbone);
    }
}(this, function (Backbone) {
    return Backbone.Model.extend({
        getName: function() {
            return this.get('name');
        },

        getUrl: function() {
            return this.get('url');
        }
    });
}));
