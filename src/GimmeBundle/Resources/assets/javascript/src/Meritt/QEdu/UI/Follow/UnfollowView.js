(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/UnfollowView',
            [
                'jquery',
                'backbone',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowModel'
            ],
            factory
        );
    } else {
        root.UnfollowView = factory(root.jQuery, root.Backbone, root.FollowModel);
    }
}(this, function ($, Backbone, FollowModel) {
    return Backbone.View.extend({
        el: '.subnav-section',

        events: {
            'click .unfollow'    : 'unfollow',
            'qedu:unfollow'      : 'doesNotFollowAnymore'
        },

        initialize: function(config) {
            this.url = config.url;
        },

        controlSetFollowProfileModal: function(e) {
            this.$el.find(".set-follow-profile").toggle();
            this.$el.find(".follow-button").toggleClass("set-follow-profile-open");

            e.preventDefault();
        },

        unfollow: function(e) {
            var follow = this.$el.find(".following").attr("data-follow");
            var model  = new FollowModel({
                'id': follow
            });

            model.urlRoot = this.url;
            model.destroy({
                beforeSend: function() {
                    this.stylizesCurrentTarget(e);
                },
                context: this
            })

            .done(function() {
                this.$el.find(".set-follow-profile a").removeClass("active").addClass("follow-profile");
                this.$el.find(".unfollow").removeClass("follow-loading");

                $('.qedu-user-following').trigger('qedu:unfollow', [model]);

                this.doesNotFollowAnymore();
                this.controlSetFollowProfileModal(e);
            })

            .fail(function(data) {
                alert("Desculpe, tivemos um erro interno. Tente novamente mais tarde!");
            })

            e.preventDefault();
        },

        doesNotFollowAnymore: function() {
            this.$el.find(".following")
                .addClass("not-following")
                .removeClass("following");

            this.$el.find(".follow-button-label-center").text("Acompanhar");
            this.$el.find(".follow-count").trigger("qedu:requestFollowCount");
        },

        stylizesCurrentTarget: function(e) {
            this.$el.find(".set-follow-profile a").removeClass("follow-loading");
            this.$el.find(".set-follow-profile .icon").remove();

            $(e.currentTarget)
                .addClass("follow-loading")
                .append("<i class='icon'/>");
        }
    });
}));
