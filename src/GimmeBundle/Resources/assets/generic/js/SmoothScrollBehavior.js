define(
    'Meritt/QEdu/UI/Assets/js/SmoothScrollBehavior',
    [
        'jquery',
        'mcc'
    ],
    function ($, mcc) {
        mcc.behavior(
            'Meritt/QEdu/UI/Assets/js/SmoothScrollBehavior',
            function(config)
            {
                $(config.target).smoothScroll();
            }
        );
    }
);