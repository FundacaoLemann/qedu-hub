(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/IdebResults/Assets/js/IdebStatusLocation',
            [
                'mcc',
                'Meritt/QEdu/UI/IdebResults/Assets/js/view/IdebStatusLocation'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.IdebStatusLocationView);
    }
}(this, function (mcc, IdebStatusLocationView) {
    mcc.behavior(
        'Meritt/QEdu/UI/IdebResults/Assets/js/IdebStatusLocation',

        function() {
            idebStatusLocation = new IdebStatusLocationView();
        }
    );
}));
