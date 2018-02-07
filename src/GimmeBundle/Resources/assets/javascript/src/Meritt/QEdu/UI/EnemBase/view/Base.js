(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemBase/Assets/js/view/Base',
            [
                'jquery',
                'backbone'
            ],
            factory
        );
    } else {
        root.EnemBaseView = factory(root.jQuery, root.Backbone);
    }
}(this, function ($, Backbone) {
    return Backbone.View.extend({
        initialize: function (config) {
            this.edition = config.edition;
            this.educationNetworkTypeId = config.educationNetworkTypeId;
            this.baseUrl = config.baseUrl;

            this.listenTo(Backbone,'schoolList:ChangeEdition', this.changeEdition);
            this.listenTo(Backbone,'schoolList:ChangeEducationNetworkType', this.changeEducationNetworkType);
        },

        reload: function() {
            var url = this.baseUrl
                + '?edition=' + this.edition;
            if (this.educationNetworkTypeId) {
                url += '&educationNetworkType=' + this.educationNetworkTypeId;
            }

            window.location.href = url;
        },

        changeEdition: function(edition) {
            this.edition = edition;
            this.reload();
        },

        changeEducationNetworkType: function(educationNetworkTypeId) {
            this.educationNetworkTypeId = educationNetworkTypeId;
            this.reload();
        }
    });
}));