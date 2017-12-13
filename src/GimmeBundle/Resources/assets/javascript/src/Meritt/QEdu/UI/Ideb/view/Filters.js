(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Ideb/Assets/js/view/Filters',
            [
                'jquery',
                'backbone',
                'underscore'
            ],
            factory
        );
    } else {
        root.FiltersView = factory(root.jQuery, root.Backbone, root._);
    }
}(this, function ($, Backbone, _) {
    return Backbone.View.extend({
        el: '.filters',

        events: {
            'click .active a'   : 'noAction',
            'click .disabled a' : 'noAction',
            'click'             : 'hidePopover'
        },

        initialize: function(config) {
            this.disabledTitle          = config.disabledTitle;
            this.disabledContent        = config.disabledContent;

            this.$("ul:not(.dropdown-menu-blocked) .disabled a").popover({
                html      : true,
                placement : "top",
                title     : this.disabledTitle,
                content   : this.disabledContent
            }).addClass("trigger-popover");
            this.$("[data-toggle='tooltip']").tooltip();
        },

        hidePopover: function(e) {
            if (!$(e.target).hasClass('trigger-popover') && $(e.target).parents('.popover.in').length === 0) {
                this.$("ul:not(.dropdown-menu-blocked) .disabled a").popover('hide');
            }
        },

        noAction: function (e) {
            e.preventDefault();
            return false;
        }
    });
}));
