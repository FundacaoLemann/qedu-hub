(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/DataFileDownload',
            [
                'mcc',
                'jquery'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.jQuery);
    }
}(this, function (mcc, $) {
    mcc.behavior(
        'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/DataFileDownload',

        function(config) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    );
}));
