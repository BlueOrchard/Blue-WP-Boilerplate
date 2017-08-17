var gulp = require('gulp');
var sass = require('gulp-sass');
var merge = require('merge-stream');
var concat = require('gulp-concat');
var prefix = require('gulp-autoprefixer');
var clean = require('gulp-clean-css');
var wait = require('gulp-wait');

var devCSS = 'dev/css/';

gulp.task('cssPack', function() {
    var sassFiles,
        cssFiles,
        themeInfo;

    sassFiles = gulp.src(devCSS + 'style-style-main.scss')
        .pipe(wait(500))
        .pipe(sass());

    cssFiles = gulp.src(devCSS + '*.css');

    return merge(sassFiles, cssFiles)
           .pipe(concat('style.min.css'))
           .pipe(prefix())
           .pipe(clean({
                        level: {
                            1: {
                                specialComments : 0
                            }
                        }
                        }))
           .pipe(gulp.dest("./public/css/"));
});

gulp.task('default', ['cssPack'], function() {
    gulp.watch(devCSS + '*.css', ['cssPack']);
    gulp.watch(devCSS + '*.scss', ['cssPack']);
    gulp.watch(devCSS + 'import/*.scss', ['cssPack']);
    gulp.watch(devCSS + 'extra/*.scss', ['cssPack']);
})