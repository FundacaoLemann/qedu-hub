(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/collection/SchoolResults',
            [
                'backbone',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/model/js/SchoolResults'
            ],
            factory
        );
    } else {
        root.SchoolResultsCollection = factory(root.Backbone, root.SchoolResultsModel);
    }
}(this, function (Backbone, SchoolResultsModel) {
    return Backbone.Collection.extend({
        model: SchoolResultsModel
    });
}));
