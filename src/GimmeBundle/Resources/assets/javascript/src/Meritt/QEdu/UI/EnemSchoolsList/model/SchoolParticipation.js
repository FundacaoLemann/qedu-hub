(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/model/SchoolParticipationModel',
            [
                'backbone',
                'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/model/School'
            ],
            factory
        );
    } else {
        root.SchoolParticipationModel = factory(root.Backbone, root.SchoolModel);
    }
}(this, function (Backbone, SchoolModel) {
    return Backbone.Model.extend({
        getEdition: function() {
            return this.get('edition');
        },

        getParticipationCount: function() {
            return this.get('participationCount');
        },

        getParticipationRate: function() {
            return this.get('participationRate');
        },

        getSchool: function() {
            return this.get('school');
        },

        model: {
            school: SchoolModel
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
