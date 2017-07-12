(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Footer/Assets/js/IdebModal',
            [
                'mcc',
                'Meritt/QEdu/UI/Footer/Assets/js/view/IdebModal'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.IdebModalView);
    }
}(this, function (mcc, IdebModal) {
    mcc.behavior(
        'Meritt/QEdu/UI/Footer/Assets/js/IdebModal',

        function() {
            var modal = new IdebModal();

            modal.render();
        }
    );
}));
