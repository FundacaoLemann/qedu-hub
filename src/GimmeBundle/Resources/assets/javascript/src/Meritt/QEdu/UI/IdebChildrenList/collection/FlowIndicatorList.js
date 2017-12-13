(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/collection/FlowIndicatorList',
            [
                'backbone',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/model/js/FlowIndicatorList'
            ],
            factory
        );
    } else {
        root.FlowIndicatorListCollection = factory(root.Backbone, root.FlowIndicatorListModel);
    }
}(this, function (Backbone, FlowIndicatorListModel) {
    var FlowIndicatorListCollection = Backbone.Collection.extend({
        model: FlowIndicatorListModel,

        initialize: function(models, config) {
            this.url = '/api/locais/' + config.locationId + '/ideb/taxas-aprovacao/filhos?dependence=' + config.dependence
            + '&grade=' + config.grade + '&edition=' + config.edition;
            console.log(this.url);
        }
    });

    return FlowIndicatorListCollection;
}));
