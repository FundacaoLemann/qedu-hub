(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/FollowModel',
            [
                'jquery',
                'backbone'
            ],
            factory
        );
    } else {
        root.FollowModel = factory(root.jQuery, root.Backbone);
    }
}(this, function ($, Backbone) {
    var FollowModel = Backbone.Model.extend({
        urlRoot: '/api/acompanhamentos/',
        getName: function() {
            var educationEntity = this.get('educationEntity');
            switch (this.get('type')) {
                case 'School':
                    return this.getEducationEntityName() + ' (' + educationEntity.location.name + ' - ' + educationEntity.location.location.shortName + ')';
                case 'City':
                    return this.getEducationEntityName() + ' - ' + educationEntity.location.shortName;
                case 'State':
                    return this.getEducationEntityName() + ' - ' + educationEntity.shortName;
                default:
                    return this.getEducationEntityName();
            }
        },

        getEducationEntityName: function() {
            return this.get('educationEntity').name;
        },

        getImage: function() {
            return this.get('educationEntity').image;
        },

        getURL: function() {
            return this.get('educationEntity').url;
        },

        hasProvaBrasil: function() {
            var educationEntity = this.get('educationEntity');

            if ( this.get('type') == 'escola' ) {
                if ( !educationEntity.provaBrasil ) {
                    return 'hidden';
                }
            }
        },

        getBreadcumb: function() {
            var educationEntity = this.get('educationEntity');

            switch (this.get('type')) {
                case 'School':
                    return [{
                        'name': 'Brasil',
                        'url': '/brasil/'
                    }, {
                        'name': educationEntity.location.location.name,
                        'url': educationEntity.location.location.url
                    }, {
                        'name': educationEntity.location.name,
                        'url': educationEntity.location.url,
                        'final': true
                    }];
                case 'City':
                    return [{
                        'name': 'Brasil',
                        'url': '/brasil/'
                    }, {
                        'name': educationEntity.location.name,
                        'url': educationEntity.location.url,
                        'final': true
                    }];
                default:
                    return [{
                        'name': 'Brasil',
                        'url': '/brasil/',
                        'final': true
                    }];
            }
        },

        getDetail: function() {
            return this.get('educationEntity');
        },

        getProfile: function() {
            var profile = this.get('profile');

            if (profile instanceof Object == true) {
                return profile;
            }

            return '';
        }
    });

    return FollowModel;
}));