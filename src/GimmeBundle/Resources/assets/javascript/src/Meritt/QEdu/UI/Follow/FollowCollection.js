(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Follow/Assets/js/FollowCollection',
            [
                'jquery',
                'backbone',
                'Meritt/QEdu/UI/Follow/Assets/js/FollowModel'
            ],
            factory
        );
    } else {
        root.FollowCollection = factory(root.jQuery, root.Backbone, root.FollowModel);
    }
}(this, function ($, Backbone, FollowModel) {
    var FollowCollection = Backbone.Collection.extend({
        url:   '/api/acompanhamentos/',
        model: FollowModel
    });
    return  FollowCollection;
}));