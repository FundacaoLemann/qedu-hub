(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/SetFollowProfileView',
            [
                'jquery',
                'backbone',
                'underscore'
            ],
            factory
        );
    } else {
        root.SetFollowProfileView = factory(root.jQuery, root.Backbone, root._);
    }
}(this, function ($, Backbone, _) {
    return Backbone.View.extend({
        el: '.subnav-section',
        events: {
            'click .following'          : 'controlSetFollowProfileModal',
            'click .l2 .follow-profile' : 'selectProfile',
            'click .l2 .active'         : 'doNothing',
            'click .l1 .pooler'         : 'doNothing'
        },

        initialize: function (config) {
            this.url  = config.url;
        },

        controlSetFollowProfileModal: function (e) {
            this.$el.find(".set-follow-profile").toggle();
            this.$el.find(".follow-button").toggleClass("set-follow-profile-open");

            e.preventDefault();
        },

        selectProfile: function (e) {
            var follow = this.$el.find(".following").attr("data-follow");
            var profileId = $(e.currentTarget).attr("data-id");

            $.ajax({
                url: this.url + follow,
                type: 'PUT',
                dataType: 'json',
                async: true,
                context: this,
                data: {
                    "profile": profileId
                },
                beforeSend: function() {
                    this.stylizesCurrentTarget(e);
                }
            })

            .done(function() {
                this.buildActiveProfile(e);
            })

            .fail(function() {
                alert("Desculpe, tivemos um erro interno. Tente novamente mais tarde!");
            });

            e.preventDefault();
        },

        buildActiveProfile: function (e) {
            this.$el.find(".set-follow-profile a")
                .removeClass("active follow-profile")
                .addClass("follow-profile");

            $(e.currentTarget)
                .removeClass("follow-loading follow-profile")
                .addClass("active")
                .find(".icon")
                .addClass("icon-ok icon-white");


            this.controlSetFollowProfileModal(e);
        },

        doNothing: function () {
            return false;
        },

        stylizesCurrentTarget: function (e) {
            this.$el.find(".set-follow-profile a").removeClass("follow-loading");
            this.$el.find(".set-follow-profile .icon").remove();

            $(e.currentTarget)
                .addClass("follow-loading")
                .append("<i class='icon'/>");
        }
    });
}));
