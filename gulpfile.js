const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const sassDataURI = require('lib-sass-data-uri');
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');
const concat = require('gulp-concat');
const merge = require('gulp-merge');
const strip = require('gulp-strip-comments');

gulp.task('parse-template-scss', function() {
    return gulp.src('src/templates/joomladach2023/assets/scss/template.scss')
        .pipe(sass({
            errLogToConsole: true,
            functions: Object.assign(sassDataURI, {other: function() {}})
        }))
        .pipe(cleanCSS({compatibility: 'ie11'}))
        .pipe(gulp.dest('src/templates/joomladach2023/assets/css'))
});

gulp.task('parse-critical-scss', function() {
    return gulp.src('src/templates/joomladach2023/assets/scss/critical.scss')
        .pipe(sass({
            errLogToConsole: true,
            functions: Object.assign(sassDataURI, {other: function() {}})
        }))
        .pipe(cleanCSS({compatibility: 'ie11'}))
        .pipe(gulp.dest('src/templates/joomladach2023/assets/css'))
});

gulp.task('parse-script', function() {
  return merge(
    gulp.src(['src/templates/joomladach2023/assets/js/template.js'])
      .pipe(sourcemaps.init())
      .pipe(babel({
        presets: ['@babel/env']
      }))
      .pipe(sourcemaps.write())
  )
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(strip())
    .pipe(concat('template.min.js'))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('src/templates/joomladach2023/assets/js'));
});

gulp.task('watch', function() {
    gulp.watch('src/templates/joomladach2023/assets/scss/**/*.scss', gulp.series('parse-template-scss'));
    gulp.watch('src/templates/joomladach2023/assets/scss/**/*.scss', gulp.series('parse-critical-scss'));
    gulp.watch('src/templates/joomladach2023/assets/js/template.js', gulp.series('parse-script'));
});

gulp.task('default', function() {
  gulp.series('parse-template-scss')
  gulp.series('parse-critical-scss')
  gulp.series('parse-script')
});