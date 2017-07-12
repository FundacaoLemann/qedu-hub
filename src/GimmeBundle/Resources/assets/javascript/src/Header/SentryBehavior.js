(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(
            'Meritt/QEdu/UI/Sentry/Assets/js/SentryBehavior',
            [
                'mcc',
                'raven'
            ],
            factory
        );
    } else {
        factory(root.mcc, root.Raven);
    }
}(this, function (mcc, Raven) {
    mcc.behavior(
        'Meritt/QEdu/UI/Sentry/Assets/js/SentryBehavior',
        function (config) {
            if (config.options === null) {
                config.options = {};
            }
            // Whitelist only URLs like qedu\..*, or qdu.org.br. Shortly, something with qedu in the name :P
            config.options['whitelistUrls'] = [/.*qedu.*/];
            Raven.config(config.dsn, config.options);
            Raven.setUser(config.user);
            Raven.install();
        }
    );
}));