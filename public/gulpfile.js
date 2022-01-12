// Include The Plugins
var gulp          = require('gulp'),
    prefix        = require('gulp-autoprefixer'),
    concat        = require('gulp-concat'),
    sass          = require('gulp-sass'),
    imagemin      = require('gulp-imagemin'),
    minify        = require('gulp-uglify'),
    rename        = require('gulp-rename');


// Css Task
gulp.task('css', function () {
  return gulp.src('stage/dashboard/sass/main.scss')
            .pipe(sass({outputStyle: 'compressed'})) //expanded
            .pipe(prefix('last 2 versions'))
            .pipe(concat('app.min.css'))
            .pipe(gulp.dest('dist/dashboard/css'))

});

// JS Task
gulp.task('js', function(cb) {

  // All JS File In Directly Folder
  gulp.src([
      'stage/dashboard/js/*.js',
    ])
    .pipe(concat('app.min.js'))
    .pipe(minify())
    .pipe(gulp.dest('dist/dashboard/js'))

  // Singel Page Js
  gulp.src([
      'stage/dashboard/js/pages/*.js',
    ])
    .pipe(minify())
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(gulp.dest('dist/dashboard/js/pages'))

  cb();
});

// Images Task
gulp.task('imgminify', function() {
  return gulp.src('stage/dashboard/images/*')
    .pipe(imagemin([
        imagemin.gifsicle({interlaced: true}),
        imagemin.mozjpeg({quality: 75, progressive: true}),
        imagemin.optipng({optimizationLevel: 5}),
        imagemin.svgo({
        plugins: [
            {removeViewBox: true},
            {cleanupIDs: false}
        ]
        })
    ]))
    .pipe(gulp.dest('dist/dashboard/images'))
});

// Watch Task
gulp.task('watch', function () {
  gulp.watch('stage/dashboard/sass/**/*.scss', ['css']);
  gulp.watch('stage/dashboard/js/**/*.js', ['js']);
  gulp.watch('stage/dashboard/images/*', ['imgminify']);

});
