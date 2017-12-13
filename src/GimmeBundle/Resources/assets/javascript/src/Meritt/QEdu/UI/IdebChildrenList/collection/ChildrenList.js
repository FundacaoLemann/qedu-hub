(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/collection/ChildrenList',
            [
                'backbone',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/model/js/ChildrenList'
            ],
            factory
        );
    } else {
        root.ChildrenListCollection = factory(root.Backbone, root.ChildrenListModel);
    }
}(this, function (Backbone, ChildrenListModel) {
    return Backbone.Collection.extend({
        model: ChildrenListModel,

        initialize: function(config) {
            this.url = '/api/locais/' + config.locationId + '/ideb/filhos?dependence=' + config.dependence
            + '&grade=' + config.grade + '&edition=' + config.edition;
        }
    });
}));
