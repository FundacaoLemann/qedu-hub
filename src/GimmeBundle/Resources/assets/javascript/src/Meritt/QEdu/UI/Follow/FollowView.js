(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/FollowView',
            [
                'jquery',
                'backbone',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowModel',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowListView',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowDetailView',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowCollection'
            ],
            factory
        );
    } else {
        root.FollowView = factory(root.jQuery, root.Backbone, root.FollowModel, root.FollowListView, root.FollowDetailView, root.FollowCollection);
    }
}(this, function ($, Backbone, FollowModel, FollowListView, FollowDetailView, FollowCollection) {
    var FollowView = Backbone.View.extend({
        el: '.qedu-user-following',

        events: {
            'click .btn-qedu' : 'focusSearch',
            'qedu:unfollow'   : 'removeFromCollection',
            'qedu:follow'     : 'addToCollection'
        },

        initialize: function() {
            this.collection = window.c = new FollowCollection();
            this.collection.fetch();
            this.activeModel = new FollowModel();

            this.listenTo(this.collection, 'sync', this.setFirstModelAsActiveModel);
            this.listenTo(this.collection, 'all', function(){
                if ( !this.collection.length ) {
                   this.setUnfollow();
                } else {
                    this.setFollow();
                }
            });

            this.followList = new FollowListView({
                'collection':  this.collection,
                'el':          this.$('.scrollbar'),
                'activeModel': this.activeModel
            });

            this.followDetail = new FollowDetailView({
                'collection':  this.collection,
                'el':          this.$('.info-follow'),
                'activeModel': this.activeModel
            });
        },

        setFollow: function() {
            this.$('.follow-title').html('Acompanhando');
            this.$el.removeClass('not-following-img');
            this.$el.find('.nofollow-content').hide();
            this.$el.find('.scrollbar').show();
            this.$el.find('.info-follow').show();
        },

        setUnfollow: function() {
            this.$('.follow-title').html('Acompanhe seus locais favoritos');
            this.$el.addClass('not-following-img');
            this.$el.find('.nofollow-content').show();
            this.$el.find('.scrollbar').hide();
            this.$el.find('.info-follow').hide();
        },

        setFirstModelAsActiveModel: function() {
            var first = this.collection.at(0);

            if (first) {
                first = first.toJSON();
                this.activeModel.set(first);
            } else {
                this.activeModel.clear();
            }
        },

        removeFromCollection: function(e, model) {
            this.collection.remove(model);
            this.setFirstModelAsActiveModel();

            $('.subnav-section').triggerHandler('qedu:unfollow');
        },

        addToCollection: function(e, model) {
            this.collection.add(model);
            this.setFirstModelAsActiveModel();
        },

        focusSearch: function(e) {
            $('.qedu-search input').focus();

            e.preventDefault();
        },

        render: function() {
            this.followList.render();
            this.followDetail.render();
        }
    });
    return FollowView;
}));
