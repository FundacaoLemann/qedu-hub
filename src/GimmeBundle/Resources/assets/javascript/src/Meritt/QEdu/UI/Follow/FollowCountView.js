(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/FollowICountView',
            [
                'jquery',
                'backbone'
            ],
            factory
        );
    } else {
        root.FollowCountView = factory(root.jQuery, root.Backbone);
    }
}(this, function ($, Backbone) {
    return Backbone.View.extend({
        el: '.follow-count',
        events: {
            'qedu:requestFollowCount' : 'requestFollowCount'
        },

        initialize: function(config){
            this.url = config.url;
        },

        requestFollowCount: function(){
            $.ajax({
                url: this.url,
                type: 'GET',
                dataType: 'json',
                async: true,
                context: this
            })

            .done(function(data) {
                this.updateFollowCount(data);
            })

            .fail(function() {
                alert("Desculpe, tivemos um erro interno. Tente novamente mais tarde!");
            })
        },

        updateFollowCount: function(data){
            this.$el.html(data.text);
        }
    });
}));
