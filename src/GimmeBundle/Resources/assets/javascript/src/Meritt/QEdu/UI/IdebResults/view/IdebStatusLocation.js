(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebResults/Assets/js/view/IdebStatusLocation',
            [
                'jquery',
                'backbone',
                'underscore'
            ],
            factory
        );
    } else {
        root.IdebStatusLocationView = factory(root.jQuery, root.Backbone, root._);
    }
}(this, function ($, Backbone, _) {
    return Backbone.View.extend({
        el: '.ideb-legend-goals',

        initialize: function() {
            this.$el.find('.ideb-tooltip').popover({
                html      : true,
                placement : 'top',
                title     : 'Situação das escolas',
                content   : 'A escola é situada levando em consideração três parâmetros: variação do Ideb entre '
                            + '2011 e 2013, o cumprimento da meta prevista para 2013 e valor do Ideb em relação a 6,00.'
                            + ' Esta classificação foi elaborada pela equipe do QEdu para auxiliar no entendimento do '
                            + 'Ideb. Saiba mais sobre a análise da situação das escolas.'
            });
        }
    });
}));
