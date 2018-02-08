(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/ButtonView',
            [
                'jquery',
                'backbone',
                'underscore',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowModel'
            ],
            factory
        );
    } else {
        root.ButtonView = factory(root.jQuery, root.Backbone, root._, root.FollowModel);
    }
}(this, function ($, Backbone, _, FollowModel) {
    return Backbone.View.extend({
        el: '.subnav-section',

        events: {
            'click .not-following' : 'clickToFollow'
        },

        initialize: function(config) {
            this.url                  = config.url;
            this.educational_group_id = config.educational_group_id;
            this.follow               = config.follow;

            this.$el.find(".follow-button").attr("data-follow", this.follow);
        },

        clickToFollow: function(e) {
            $.ajax({
                url: this.url,
                type: 'POST',
                dataType: 'json',
                context: this,
                data: {
                    "id": this.educational_group_id
                },
                beforeSend: function() {
                    $(".not-following").addClass("follow-loading");
                }
            })

            .done(function(data) {
                var model = new FollowModel(data);

                $('.qedu-user-following').triggerHandler('qedu:follow', [model]);
                $('.set-follow-profile').toggle();

                this.follow = data.id;
                this.following();
                dataLayer.push({
                    'event': 'followTrigger',
                    'followActionVariable': 'click follow',
                    'followLabelVariable': data.type
                });
            })

            .fail(function() {
                this.$el.find(".not-following").removeClass("follow-loading");
                alert("Desculpe, tivemos um erro interno. Tente novamente mais tarde!");
            })

            e.preventDefault();
        },

        following: function() {
            this.$el.find(".not-following")
                .addClass("following")
                .removeClass("not-following follow-loading")
                .attr("data-follow", this.follow)
                .triggerHandler("click");

            this.$el.find(".follow-count").triggerHandler("qedu:requestFollowCount");
            this.$el.find(".follow-button-label-center").text("Acompanhando");
        }
    });
}));
