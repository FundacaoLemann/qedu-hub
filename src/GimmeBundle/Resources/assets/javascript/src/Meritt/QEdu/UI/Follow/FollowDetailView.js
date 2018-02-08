(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/FollowDetailView',
            [
                'jquery',
                'backbone',
                'underscore',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowModel'
            ],
            factory
        );
    } else {
        root.FollowDetailView = factory(root.jQuery, root.Backbone, root._, root.FollowModel);
    }
}(this, function ($, Backbone, _, FollowModel) {
    var FollowDetailView = Backbone.View.extend({
        template: _.template( $('#tmp-follow-detail').html() ),

        events: {
            'click .unfollow': 'unfollow'
        },

        initialize: function(config) {
            this.activeModel = config.activeModel;
            this.listenTo(this.activeModel, 'change', this.render);
        },

        unfollow: function() {
            this.activeModel.destroy({
                context: this
            })

            .done(function(){
                $('.qedu-user-following').triggerHandler('qedu:unfollow', [this.activeModel]);
            });

            return false;
        },

        render: function() {
            if ( !this.activeModel.id ) {
                this.$el.html('');
                return;
            }
            this.$el.html(this.template({
                'activeModel': this.activeModel
            }));
        }
    });

    return FollowDetailView;
}));
