'use strict';

const gulp = require('gulp');
const nodeSass = require('node-sass');
const sass = require('gulp-sass')(nodeSass);
const csso = require('gulp-csso');
const sourcemaps = require('gulp-sourcemaps');
const merge = require('merge-stream');
const through2 = require('through2');
const scss = {
    'assets/**/*.scss': 'assets',
    'web/css/**/*.scss': 'web/css',
};

gulp.task('scss', () => {
    return merge(Object.keys(scss).map(source => {
        let destination = scss[source];

        return gulp.src(source)
            .pipe(sourcemaps.init())
            .pipe(sass().on('error', sass.logError))
            .pipe(csso({restructure: false, comments: 'exclamation'}))
            .pipe(sourcemaps.write('.'))
            .pipe(through2.obj(function (file, enc, cb) {
                let date = new Date();

                file.stat.atime = date;
                file.stat.mtime = date;

                cb(null, file);
            }))
            .pipe(gulp.dest(destination));
    }));
});

gulp.task('scss:watch', gulp.series('scss', () => {
    gulp.watch(Object.keys(scss), gulp.series('scss'));
}));

gulp.task('default', gulp.series('scss:watch'));
