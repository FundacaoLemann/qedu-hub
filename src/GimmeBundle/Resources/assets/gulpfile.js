var gulp   = require('gulp'),
    concat = require('gulp-concat'),
    exec   = require('gulp-exec');

var uglifyjsBinary  = './node_modules/.bin/uglifyjs',
    uglifycssBinary = './node_modules/.bin/uglifycss',
    lessBinary      = './node_modules/.bin/lessc',
    coffeeBinary    = './node_modules/.bin/coffee';

var jsCmdVersionOne  = uglifyjsBinary + ' <%= file.path %> --define __DEV__=1 --beautify quote_keys=true',
    jsCmdVersionTwo  = uglifyjsBinary + ' <%= file.path %>',
    jsCompileCoffee  = coffeeBinary   + ' --print --stdio < <%= file.path %>',
    jsUglifyQuotes   = uglifyjsBinary + ' <%= file.path %> --beautify beautify=false,quote_keys=true --no-copyright',
    cssCmdVersionOne = lessBinary     + ' <%= file.path %> --compress',
    cssCmdVersionTwo = lessBinary     + ' <%= file.path %> --compress' + ' | ' + uglifycssBinary;

var execOptions       = {pipeStdout: true},
    noBreakLineOption = {newLine:''};


gulp.task('header.js', function() {
  return gulp.src([
      './javascript/src/Header/SentryBehavior.js',
      './javascript/src/Header/GlobalSearchModel.js',
      './javascript/src/Header/GlobalSearchView.js',
      './javascript/src/Header/GlobalSearchBehavior.js',
      './javascript/src/Header/IdebModal_view.js',
      './javascript/src/Header/IdebModal.js'
    ])
    .pipe(exec(jsCmdVersionOne, execOptions))
    .pipe(concat('Header.js'))
    .pipe(gulp.dest('./javascript/dist/'));
});

gulp.task('landingideb.js', function() {
  return gulp.src([
      './javascript/src/LandingIdeb/jquery.fullPage.js',
      './javascript/src/LandingIdeb/jquery.easings.min.js',
      './javascript/src/LandingIdeb/jquery.slimscroll.min.js',
      './javascript/src/LandingIdeb/IdebInStates_view.js',
      './javascript/src/LandingIdeb/IdebInStates.js',
      './javascript/src/LandingIdeb/Search_view.js',
      './javascript/src/LandingIdeb/Search.js',
      './javascript/src/LandingIdeb/IdebLanding_view.js',
      './javascript/src/LandingIdeb/IdebLanding.js'
    ])
    .pipe(exec(jsCmdVersionTwo, execOptions))
    .pipe(concat('landingideb.js', noBreakLineOption))
    .pipe(gulp.dest('./javascript/dist/'));
});


gulp.task('banner.css', function() {
  return gulp.src([
      './stylesheet/src/Banner/MeuMunicipioBanner.less',
      './stylesheet/src/Banner/ExcelenciaEquidadeBanner.less'
    ])
    .pipe(exec(cssCmdVersionOne, execOptions))
    .pipe(concat('banner.css', noBreakLineOption))
    .pipe(gulp.dest('./stylesheet/dist/'));
});

gulp.task('landingideb.css', function() {
  return gulp.src([
      './stylesheet/src/IdebLanding/jquery.fullPage.css',
      './stylesheet/src/IdebLanding/LandingPage.less',
      './stylesheet/src/IdebLanding/WhatIs.less',
      './stylesheet/src/IdebLanding/IdebInBrazil.less',
      './stylesheet/src/IdebLanding/IdebInStates.less',
      './stylesheet/src/IdebLanding/Search.less',
      './stylesheet/src/IdebLanding/ExcellenceWithEquity.less',
      './stylesheet/src/IdebLanding/BestPractices.less'
    ])
    .pipe(exec(cssCmdVersionTwo, execOptions))
    .pipe(concat('landingideb.css'))
    .pipe(gulp.dest('./stylesheet/dist/'));
});

gulp.task('dropdown-select2.css', function() {
    return gulp.src([
        './stylesheet/src/select2/select2.css',
        './stylesheet/src/select2/select2-bootstrap.css',
        './stylesheet/src/provabrasil/dropdowns-select2.less'
    ])
    .pipe(exec(cssCmdVersionOne, execOptions))
    .pipe(concat('dropdown-select2.css', noBreakLineOption))
    .pipe(gulp.dest('./stylesheet/dist/'))
});

gulp.task('provabrasil.js', function() {
    return gulp.src([
        './javascript/src/ProvaBrasil/Util/statemenu.coffee',
        './javascript/src/ProvaBrasil/Util/fixedLayout.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-fixed-layout.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-i18n.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-dropdown.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-tooltip.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-popover.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-smoothscroll.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-append-hash-to-url.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-highlight-by-hash.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-label_behind.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-chart.coffee',
        './javascript/src/ProvaBrasil/Util/behavior-full-height.coffee',
        './javascript/src/ProvaBrasil/Header/behavior-header.coffee',
        './javascript/src/ProvaBrasil/Footer/behavior-footer.coffee',
        './javascript/src/ProvaBrasil/Util/RotateBanner/behavior.coffee',
        './javascript/src/ProvaBrasil/Search/Global/model-globalsearch.coffee',
        './javascript/src/ProvaBrasil/Search/Global/view-globalsearch.coffee',
        './javascript/src/ProvaBrasil/Search/Global/behavior-globalsearch.coffee',
        './javascript/src/ProvaBrasil/Easteregg/harlemshake.coffee',
    ])
    .pipe(concat('provabrasil.js'))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsCompileCoffee, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
    .pipe(exec(jsUglifyQuotes, execOptions))
    .pipe(gulp.dest('./javascript/dist/'))
});

gulp.task('default', ['header.js', 'landingideb.js', 'banner.css', 'landingideb.css', 'dropdown-select2.css', 'provabrasil.js']);
