(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebChildrenList/Assets/js/model/ChildrenList',
            [
                'backbone'
            ],
            factory
        );
    } else {
        root.ChildrenListModel = factory(root.Backbone);
    }
}(this, function (Backbone) {
    return Backbone.Model.extend({
        initialize: function(config) {
            this.url = '/api/locais/' + config.locationId + '/ideb/filhos?dependence=' + config.dependence
            + '&grade=' + config.grade;
        },

        getUrl: function() {
            return this.get('url');
        },

        getName: function() {
            return this.get('name');
        },

        getIdeb: function() {
            return this.get('ideb');
        },

        getPerformance: function() {
            return this.get('performance');
        },

        getLearning: function() {
            return this.get('learning');
        },

        getGoalCriterion: function() {
            return this.get('goalCriterion');
        },

        getGrowthCriterion: function() {
            return this.get('growthCriterion');
        },

        getScoreCriterion: function() {
            return this.get('scoreCriterion');
        },

        getTotalCount: function() {
            return this.get('totalCount');
        },

        getLevelCount: function(level) {
            if (1 <= level && level <= 4) {
                return this.get('levelCount')[level];
            }

            return null;
        },

        getLevelProportion: function(level) {
            var totalCount = this.getTotalCount();

            if (totalCount > 0) {
                var levelCount = this.getLevelCount(level);
                if (levelCount >= 0) {
                    return Math.round(levelCount / totalCount * 100) + ' %';
                }
            }

            return '-';
        },

        getLevel: function() {
            return this.get('level');
        },

        getAveragePortuguese: function() {
            var averages = this.get('averages');
            return averages['portuguese'];
        },

        getAverageMath: function() {
            var averages = this.get('averages');
            return averages['math'];
        }
    });
}));
