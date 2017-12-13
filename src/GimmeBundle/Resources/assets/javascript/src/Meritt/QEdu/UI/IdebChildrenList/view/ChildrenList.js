(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/view/ChildrenList',
            [
                'jquery',
                'backbone',
                'underscore',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/js/model/ChildrenList',
                'Meritt/QEdu/UI/IdebChildrenList/Assets/js/collection/ChildrenList'
            ],
            factory
        );
    } else {
        root.ChildrenListView = factory(root.jQuery, root.Backbone, root._, root.Loader, root.ChildrenListModel, root.ChildrenListCollection);
    }
}(this, function ($, Backbone, _, Loader, ChildrenListModel, ChildrenListCollection) {
    var ChildrenListView = Backbone.View.extend({
        el: '.ideb-children-list',
        forceIdeb: false,

        initialize: function(config) {
            this.template = _.template( $('#tmp-schools-list').html() );

            this.collection = new ChildrenListCollection(config);
            this.collection.fetch();

            if (config.forceIdeb) {
                this.forceIdeb = true;
            }

            this.listenTo(this.collection, 'sync', this.render);
        },

        render: function() {
            this.$el.find('#school-situation tbody').html(this.template({
                'collection': this.collection,
                'view'      : this
            }));

            setTimeout(_.bind(function(){
                Backbone.trigger('childrenList:LearningRates', this.collection);
            }, this), 1000);

            Backbone.trigger('childrenList:FlowIndicator', this.collection);
        },

        getClassForGoalCriterion: function(goalCriterion) {
            if (goalCriterion) {
                return 'ib-check'
            } else {
                return 'ib-wrong'
            }
        },

        getClassForGrowthCriterion: function(growthCriterion) {
            if (growthCriterion) {
                return 'ib-check'
            } else {
                return 'ib-wrong'
            }
        },

        getClassForScoreCriterion: function(scoreCriterion) {
            if (scoreCriterion) {
                return 'ib-check'
            } else {
                return 'ib-wrong'
            }
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
        },

        getLearning: function(model) {
            var ideb = model.getIdeb();
            var learning = model.getLearning();

            if (ideb === '-' || learning === '-') {
                return '-';
            }

            return learning;
        },

        getPerformance: function(model) {
            var ideb = model.getIdeb();
            var performance = model.getPerformance();

            if (ideb === '-' || performance === '-') {
                return '-';
            }

            return performance;
        },

        getIdebScore: function(model) {
            if (!this.forceIdeb) {
                var performance = model.getPerformance();
                var learning = model.getLearning();
                if (performance === '-' || learning === '-') {
                    return '-';
                }
            }

            return model.getIdeb();
        }
    });

    return ChildrenListView;
}));
