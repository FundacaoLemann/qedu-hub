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
    cssCmdVersionTwo = lessBinary     + ' <%= file.path %> --compress' + ' | ' + uglifycssBinary,
    cssCmdInputPath  = lessBinary     + ' -x --include-path=generic/:stylesheet/src/ <%= file.path %> ';

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

gulp.task('provabrasil.css', function() {
    return gulp.src([
        './generic/css/bootstrap/reset.less',
        './generic/css/bootstrap/variables.less',
        './stylesheet/src/ProvaBrasil/variables.less',
        './generic/css/bootstrap/mixins.less',
        './stylesheet/src/ProvaBrasil/mixins.less',
        './generic/css/bootstrap/scaffolding.less',
        './generic/css/bootstrap/grid.less',
        './generic/css/bootstrap/layouts.less',
        './generic/css/bootstrap/type.less',
        './stylesheet/src/ProvaBrasil/type.less',
        './generic/css/bootstrap/code.less',
        './generic/css/bootstrap/forms.less',
        './stylesheet/src/ProvaBrasil/forms.less',
        './generic/css/bootstrap/tables.less',
        './stylesheet/src/ProvaBrasil/tables.less',
        './generic/css/bootstrap/sprites.less',
        './stylesheet/src/ProvaBrasil/sprites.less',
        './generic/css/bootstrap/dropdowns.less',
        './stylesheet/src/ProvaBrasil/dropdowns.less',
        './generic/css/bootstrap/wells.less',
        './stylesheet/src/ProvaBrasil/wells.less',
        './generic/css/bootstrap/component-animations.less',
        './generic/css/bootstrap/close.less',
        './generic/css/bootstrap/buttons.less',
        './stylesheet/src/ProvaBrasil/buttons.less',
        './generic/css/bootstrap/button-groups.less',
        './stylesheet/src/ProvaBrasil/button-groups.less',
        './generic/css/bootstrap/alerts.less',
        './stylesheet/src/ProvaBrasil/alerts.less',
        './generic/css/bootstrap/navs.less',
        './stylesheet/src/ProvaBrasil/navs.less',
        './generic/css/bootstrap/navbar.less',
        './stylesheet/src/ProvaBrasil/navbar.less',
        './stylesheet/src/ProvaBrasil/subnav.less',
        './stylesheet/src/ProvaBrasil/subnav-detail.less',
        './stylesheet/src/ProvaBrasil/navtabs-compact.less',
        './generic/css/bootstrap/breadcrumbs.less',
        './stylesheet/src/ProvaBrasil/subnav-breadcrumbs.less',
        './generic/css/bootstrap/pagination.less',
        './generic/css/bootstrap/pager.less',
        './generic/css/bootstrap/modals.less',
        './generic/css/bootstrap/tooltip.less',
        './stylesheet/src/ProvaBrasil/tooltip.less',
        './generic/css/bootstrap/popovers.less',
        './generic/css/bootstrap/thumbnails.less',
        './stylesheet/src/ProvaBrasil/thumbnails.less',
        './generic/css/bootstrap/labels-badges.less',
        './stylesheet/src/ProvaBrasil/labels-badges.less',
        './generic/css/bootstrap/progress-bars.less',
        './generic/css/bootstrap/accordion.less',
        './generic/css/bootstrap/carousel.less',
        './generic/css/bootstrap/hero-unit.less',
        './generic/css/bootstrap/utilities.less',
        './stylesheet/src/ProvaBrasil/utilities.less',
        './stylesheet/src/ProvaBrasil/dropdownlinks.less',
        './stylesheet/src/ProvaBrasil/responsive.less',
        './stylesheet/src/ProvaBrasil/responsive-1200px-min.less',
        './stylesheet/src/ProvaBrasil/provabrasil.less',
        './stylesheet/src/ProvaBrasil/print.less',
        './stylesheet/src/ProvaBrasil/special_resources.less',
        './stylesheet/src/ProvaBrasil/lines.less',
        './stylesheet/src/ProvaBrasil/feedback.less',
        './stylesheet/src/ProvaBrasil/footer.less',
        './stylesheet/src/ProvaBrasil/scrollbar.less',
        './stylesheet/src/ProvaBrasil/more-slider.less',
        './stylesheet/src/ProvaBrasil/browser-frame.less',
        './stylesheet/src/ProvaBrasil/proficiency/colors.less', // Proficiency Base Colors and Backgrounds
        './stylesheet/src/ProvaBrasil/global-search.less',
        './stylesheet/src/ProvaBrasil/side-toolbar.less',
        './stylesheet/src/ProvaBrasil/avatar.less',
        './stylesheet/src/ProvaBrasil/home/home.less',
        './stylesheet/src/ProvaBrasil/home/features.less',
        './stylesheet/src/ProvaBrasil/home/register.less',
        './stylesheet/src/ProvaBrasil/home/news.less',
        './stylesheet/src/ProvaBrasil/buttonknow.less',
        './stylesheet/src/ProvaBrasil/didactic/didactic.less',
        './stylesheet/src/ProvaBrasil/didactic/title.less',
        './stylesheet/src/ProvaBrasil/didactic/contextinfo.less',
        './stylesheet/src/ProvaBrasil/didactic/filter.less',
        './stylesheet/src/ProvaBrasil/didactic/agitation.less',
        './stylesheet/src/ProvaBrasil/didactic/learningblock.less',
        './stylesheet/src/ProvaBrasil/didactic/compareblock.less',
        './stylesheet/src/ProvaBrasil/didactic/evolutionblock.less',
        './stylesheet/src/ProvaBrasil/context/block/ideb.less',
        './stylesheet/src/ProvaBrasil/survey/home.less',
        './stylesheet/src/ProvaBrasil/survey/question.less',
        './stylesheet/src/ProvaBrasil/survey/filter.less',
        './stylesheet/src/ProvaBrasil/survey/dashboard/block.less',
        './stylesheet/src/ProvaBrasil/censo/filter.less',
        './stylesheet/src/ProvaBrasil/censo/item.less',
        './stylesheet/src/ProvaBrasil/educacenso/grouptable.less',
        './stylesheet/src/ProvaBrasil/educacenso/dashboard/block.less',
        './stylesheet/src/ProvaBrasil/dashboard/index.less',
        './stylesheet/src/ProvaBrasil/dashboard/school/block.less',
        './stylesheet/src/ProvaBrasil/proficiency/building-chart.less',
        './stylesheet/src/ProvaBrasil/proficiency/dashboard/block.less',
        './stylesheet/src/ProvaBrasil/proficiency/page.less',
        './stylesheet/src/ProvaBrasil/proficiency/stamp.less',
        './stylesheet/src/ProvaBrasil/proficiency/buttons-filter.less',
        './stylesheet/src/ProvaBrasil/survey/contextinfo.less',
        './stylesheet/src/ProvaBrasil/survey/context.less',
        './stylesheet/src/ProvaBrasil/school/nse.less',
        './stylesheet/src/ProvaBrasil/censo/aggregated.less',
        './stylesheet/src/ProvaBrasil/censo/school.less',
        './stylesheet/src/ProvaBrasil/search/guided.less',
        './generic/css/jquery.loadmask/jquery.loadmask.css',
        './stylesheet/src/ProvaBrasil/nouislider.less',
        './stylesheet/src/ProvaBrasil/income_rate/base.less',
        './stylesheet/src/ProvaBrasil/income_rate/data_by_grade.less',
        './stylesheet/src/ProvaBrasil/income_rate/aggregated.less',
        './stylesheet/src/ProvaBrasil/income_rate/filter.less',
        './stylesheet/src/ProvaBrasil/income_rate/lateral_bar.less',
        './stylesheet/src/ProvaBrasil/income_rate/download.less',
        './stylesheet/src/ProvaBrasil/income_rate/tech_notes.less',
        './stylesheet/src/ProvaBrasil/distortion/filter.less',
        './stylesheet/src/ProvaBrasil/distortion/grade-data.less',
        './stylesheet/src/ProvaBrasil/distortion/evolution.less',
        './stylesheet/src/ProvaBrasil/distortion/map.less',
        './stylesheet/src/ProvaBrasil/distortion/credits.less',
        './stylesheet/src/ProvaBrasil/distortion/general.less',
        './stylesheet/src/ProvaBrasil/distortion/table-schools.less',
        './stylesheet/src/ProvaBrasil/distortion/color-scale.less',
        './stylesheet/src/ProvaBrasil/distortion/progress-color-scale.less',
        './stylesheet/src/ProvaBrasil/distortion/panes.less',
        './stylesheet/src/ProvaBrasil/controls/dropdown-remote.less',
        './stylesheet/src/ProvaBrasil/util/facebook/share-button.less',
        './stylesheet/src/ProvaBrasil/util/qedu-line.less',
        './stylesheet/src/ProvaBrasil/util/legend.less',
        './stylesheet/src/ProvaBrasil/util/facebook/block.less',
        './stylesheet/src/ProvaBrasil/estudo/excelencia-com-equidade/block.less',
        './stylesheet/src/ProvaBrasil/util/rotateBanner.less',
        './stylesheet/src/ProvaBrasil/util/testimony.less',
        './stylesheet/src/ProvaBrasil/util/tour.less',
        './stylesheet/src/ProvaBrasil/error/404.less',
        './generic/css/graphs/graph.less',
        './generic/css/graphs/bars.less',
        './generic/css/intro.js/introjs.css',
        './generic/css/intro.js/introjs-ie.css',
        './generic/css/jquery.elastislide/jquery.elastislide.css',
        './stylesheet/src/Meritt/QEdu/UI/Fonts/LucidaGrande.css',
        './stylesheet/src/Meritt/QEdu/UI/Mixins.less',
        './stylesheet/src/Meritt/QEdu/UI/UIComponents.less',
        './stylesheet/src/Meritt/QEdu/UI/Variables.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/InnerHeader.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/SearchForm.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/FollowMenu.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/ProfileMenu.less',
        './stylesheet/src/Meritt/QEdu/UI/Header/SignUp.less',
        './stylesheet/src/Meritt/QEdu/UI/Footer/InnerFooter.less',
        './stylesheet/src/Meritt/QEdu/UI/Footer/InnerIdebModal.less',
        './stylesheet/src/Meritt/QEdu/UI/Follow/Button.less',
        './stylesheet/src/Meritt/QEdu/UI/Follow/Count.less',
        './stylesheet/src/Meritt/QEdu/UI/Modal/FillMoreInfoIfSecretaryModal.less',
        './stylesheet/src/Meritt/QEdu/UI/Modal/FillProfileModal.less',
        './stylesheet/src/Meritt/QEdu/UI/Modal/InnerModal.less',
        './stylesheet/src/Meritt/QEdu/UI/Follow/InnerFollowCampaignModal.less'
    ])
        .pipe(concat('pb-concat.css'))
        .pipe(gulp.dest('./stylesheet/dist/'))
        .pipe(exec(lessBinary + ' -x --include-path=generic/:stylesheet/src/ <%= file.path %> > ./stylesheet/dist/provabrasil.css', {maxBuffer: 1024 * 5000000}))
});

gulp.task('default', ['header.js', 'landingideb.js', 'banner.css', 'landingideb.css', 'dropdown-select2.css', 'provabrasil.js', 'provabrasil.css']);
