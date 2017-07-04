var gulp = require('gulp');
var sass = require('gulp-sass');
var merge = require('merge-stream');
var concat = require('gulp-concat');
var prefix = require('gulp-autoprefixer');
var clean = require('gulp-clean-css');

var devCSS = 'dev/css/';

gulp.task('cssPack', function() {
    var sassFiles,
        cssFiles,
        themeInfo;

    sassFiles = gulp.src(devCSS + 'style-style-main.scss')
        .pipe(sass());

    cssFiles = gulp.src(devCSS + '*.css');

    return merge(sassFiles, cssFiles)
           .pipe(concat('style.css'))
           .pipe(prefix())
           .pipe(gulp.dest("."));
});

gulp.task('default', ['cssPack'], function() {
    gulp.watch(devCSS + '*.css', ['cssPack']);
    gulp.watch(devCSS + '*.scss', ['cssPack']);
    gulp.watch(devCSS + 'import/*.scss', ['cssPack']);
})