(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/view/LearningRatesList',
            [
                'jquery',
                'backbone',
                'underscore'
            ],
            factory
        );
    } else {
        root.LearningRatesListView = factory(root.jQuery, root.Backbone, root._);
    }
}(this, function ($, Backbone, _) {
    var LearningRatesListView = Backbone.View.extend({
        el: '#learning-rates',

        initialize: function() {
            this.template = _.template( $('#tmp-learning-rates').html() );
            this.childrenList = [];
            this.listenTo(Backbone,'childrenList:LearningRates', this.getChildrenList);
        },

        render: function() {
            this.$el.find('tbody').html(this.template({
                'collection': this.childrenList,
                'view'      : this
            }));
        },

        getChildrenList: function(childrenList) {
            this.childrenList = childrenList;
            this.render();
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

    return LearningRatesListView;
}));
