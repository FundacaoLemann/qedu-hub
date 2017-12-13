(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/model/FlowIndicatorList',
            [
                'backbone'
            ],
            factory
        );
    } else {
        root.FlowIndicatorListModel = factory(root.Backbone);
    }
}(this, function (Backbone) {
    var FlowIndicatorListModel = Backbone.Model.extend({
        initialize: function(config) {
            this.url = '/api/locais/' + config.locationId + '/ideb/taxas-aprovacao/filhos?dependence=' + config.dependence
            + '&grade=' + config.grade;
        },

        getUrl: function() {
            return this.get('url');
        },

        getName: function() {
            return this.get('name');
        },

        getApprovalRates: function(grade) {
            return this.get('approvalRates')[grade];
        }
    });

    return FlowIndicatorListModel;
}));
