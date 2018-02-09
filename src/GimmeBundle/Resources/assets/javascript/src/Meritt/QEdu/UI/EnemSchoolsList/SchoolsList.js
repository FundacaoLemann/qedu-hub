(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/SchoolsList',
            [
                'mcc',
                'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/view/SchoolsList'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.SchoolsListView);
    }
}(this, function (mcc, SchoolsList) {
    mcc.behavior(
        'Meritt/QEdu/UI/EnemSchoolsList/Assets/js/SchoolsList',

        function(config) {
            view = new SchoolsList(config);
        }
    );
}));
