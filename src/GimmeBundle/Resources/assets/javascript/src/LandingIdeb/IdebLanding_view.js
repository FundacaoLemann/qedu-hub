(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebLanding/Assets/js/view/IdebLanding',
            [
                'jquery',
                'backbone'
            ],
            factory
        );
    } else {
        root.IdebLandingView = factory(root.jQuery, root.Backbone);
    }
}(this, function ($, Backbone) {
    var IdebLandingView = Backbone.View.extend({
        el: '.what-is-ideb',

        initialize: function(content) {
            $('#ideb-landing-page').fullpage({
                anchors:
                [
                    'o-que-e',
                    'no-brasil',
                    'anos-iniciais',
                    'anos-finais',
                    'ensino-medio',
                    'nos-estados',
                    'busca',
                    'excelencia',
                    'equidade',
                    'boas-praticas'
                ],
                resize : true,
                scrollingSpeed: 300,
                scrollOverflow: false,
                navigation: true,
                navigationTooltips:
                [
                    'O que é o Ideb',
                    'Ideb no Brasil',
                    'Anos iniciais',
                    'Anos finais',
                    'Ensino médio',
                    'Ideb nos estados',
                    'Procure por um Ideb',
                    'Excelência com Equidade',
                    'Escolas estudadas',
                    'Boas práticas'
                ],
                slidesNavigation: false,
            });

            this.listenTo(Backbone, 'ideb-search:focus', this.disableKeyboardScroll);
            this.listenTo(Backbone, 'ideb-search:blur', this.enableKeyboardScroll);
        },

        disableKeyboardScroll: function() {
            $('#ideb-landing-page').fullpage.setKeyboardScrolling(false);
        },

        enableKeyboardScroll: function() {
            $('#ideb-landing-page').fullpage.setKeyboardScrolling(true);
        }
    });

    return IdebLandingView;
}));
