(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/view/FlowIndicatorList',
            [
                'jquery',
                'backbone',
                'underscore',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/js/model/FlowIndicatorList',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/js/collection/FlowIndicatorList'
            ],
            factory
        );
    } else {
        root.FlowIndicatorListView = factory(root.jQuery, root.Backbone, root._, root.FlowIndicatorListModel, root.FlowIndicatorListCollection);
    }
}(this, function ($, Backbone, _, FlowIndicatorListModel, FlowIndicatorListCollection) {
    var FlowIndicatorListView = Backbone.View.extend({
        el: '#flow-indicator',

        initialize: function(config) {
            this.template = _.template( $('#tmp-flow-indicator').html() );

            this.collection = new FlowIndicatorListCollection([], config);
            this.collection.fetch();

            this.childrenList = null;

            this.listenTo(this.collection, 'sync', this.render);
            this.listenTo(Backbone,'childrenList:FlowIndicator', this.getChildrenList);
        },

        render: function() {
            this.$el.find('tbody').html(this.template({
                'collection': this.collection,
                'view'      : this
            }));
        },

        getChildrenList: function(childrenList) {
            this.childrenList = childrenList;
            this.render();
        },

        getFlowForModel: function(model) {
            if(!this.childrenList){
                return {
                    "performance": "-"
                }
            }

            var result = this.childrenList.findWhere({"url": model.get("url")});
            if(!result) {
                return {
                    "performance": "-"
                };
            }

            return result.toJSON();
        },

        getLabelForLevel: function(level) {
            switch (level) {
                case 1:
                    return 'Alerta';
                case 2:
                    return 'Atenção';
                case 3:
                    return 'Melhorar';
                case 4:
                    return 'Manter';
                default:
                    return 'Sem dados';
            }
        }
    });

    return FlowIndicatorListView;
}));
