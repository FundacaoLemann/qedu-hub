var gulp   = require('gulp'),
    concat = require('gulp-concat'),
    spawn  = require('gulp-spawn');

gulp.task('header', function() {
  return gulp.src([
      './javascript/src/Header/SentryBehavior.js',
      './javascript/src/Header/GlobalSearchModel.js',
      './javascript/src/Header/GlobalSearchView.js',
      './javascript/src/Header/GlobalSearchBehavior.js',
      './javascript/src/Header/IdebModal_view.js',
      './javascript/src/Header/IdebModal.js'
    ])
    .pipe(concat('Header.js'))
    .pipe(spawn({
        cmd: "./node_modules/uglify-js/bin/uglifyjs",
        args: [
            "--define",
            "__DEV__=1",
            "--beautify",
            "quote_keys=true"
        ]
    }))
    .pipe(gulp.dest('./javascript/dist/'));
});

gulp.task('landingideb', function() {
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
    .pipe(spawn({
        cmd: "./node_modules/uglify-js/bin/uglifyjs",
        args: []
    }))
    .pipe(concat('landingideb.js', {newLine:''}))
    .pipe(gulp.dest('./javascript/dist/'));
});


gulp.task('default', ['header', 'landingideb']);
