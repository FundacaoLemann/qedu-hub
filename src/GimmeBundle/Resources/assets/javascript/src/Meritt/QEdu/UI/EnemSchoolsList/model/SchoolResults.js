(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/model/SchoolResults',
            [
                'backbone',
                'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/model/SchoolParticipation'
            ],
            factory
        );
    } else {
        root.SchoolResultsModel = factory(root.Backbone, root.SchoolParticipationModel);
    }
}(this, function (Backbone, SchoolParticipationModel) {
    return Backbone.Model.extend({
        isRepresentative: function() {
            return this.get('isRepresentative');
        },

        getAverageCh: function() {
            return this.get('averageCh');
        },

        getAverageCn: function() {
            return this.get('averageCn');
        },

        getAverageLc: function() {
            return this.get('averageLc');
        },

        getAverageMt: function() {
            return this.get('averageMt');
        },

        getAverageRed: function() {
            return this.get('averageRed');
        },

        getParticipation: function() {
            return this.get('participation');
        },

        model: {
            participation: SchoolParticipationModel
        },

        parse: function(response) {
            for(var key in this.model)
            {
                var embeddedClass = this.model[key];
                var embeddedData = response[key];
                response[key] = new embeddedClass(embeddedData, {parse:true});
            }
            return response;
        }
    });
}));
