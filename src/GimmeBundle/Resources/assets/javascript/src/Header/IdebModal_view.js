(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Footer/Assets/js/view/IdebModal',
            [
                'jquery',
                'backbone'
            ],
            factory
        );
    } else {
        root.IdebModalView = factory(root.jQuery, root.Backbone);
    }
}(this, function ($, Backbone) {
    var IdebModalView = Backbone.View.extend({
        el: '#ideb-modal',

        initialize: function() {
            var isIdeb    = this.checkUrl(),
                hasCookie = this.checkCookie();

            if (!isIdeb) {
                return false;
            }

            if (hasCookie) {
                return false;
            }

            this.showModal();
            this.setCookie();
        },

        checkUrl: function() {
            var url = location.search,
                regex  = /PortalIdeb/,
                isIdeb = regex.test(url);

            return isIdeb;
        },

        checkCookie: function() {
            var regexCookie = /PortalIdeb/,
                isIdebModal = regexCookie.test(document.cookie);

            return isIdebModal;
        },

        setCookie: function() {
            document.cookie = 'PortalIdeb = true';
        },

        showModal: function() {
            this.$el.modal('show');
        }
    });

    return IdebModalView;
}));
