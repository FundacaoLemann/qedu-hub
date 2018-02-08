(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/FollowListView',
            [
                'jquery',
                'backbone',
                'underscore',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowModel'
            ],
            factory
        );
    } else {
        root.FollowListView = factory(root.jQuery, root.Backbone, root._, root.FollowModel);
    }
}(this, function ($, Backbone, _, FollowModel) {
    var FollowListView = Backbone.View.extend({
        template: _.template( $('#tmp-follow-list').html() ),

        events: {
            "click .child": "changeActive"
        },

        initialize: function(config) {
            this.activeModel = config.activeModel;

            this.listenTo(this.collection, 'sync remove add', this.render);
            this.listenTo(this.activeModel, 'change:id', this.render);
        },

        changeActive: function(e) {
            var index = $(e.currentTarget).attr('data-id');
            this.activeModel.set(this.collection.get(index).toJSON());

            return false;
        },

        getClassForItem: function(model) {
            return this.activeModel.id === model.id ? 'active' : '';
        },

        render: function() {
            this.$el.html(this.template({
                'collection': this.collection,
                'view': this
            }));
        }
    });
    return FollowListView;
}));
