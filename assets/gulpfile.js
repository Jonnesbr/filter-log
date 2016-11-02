'use strict';

var gulp         = require('gulp');
var jshint       = require('gulp-jshint');
var complexity   = require('gulp-complexity');
var concat       = require('gulp-concat');
var uglify       = require('gulp-uglify');
var rename       = require('gulp-rename');
var sass         = require('gulp-sass');
var cleanCSS     = require('gulp-clean-css');
var imagemin     = require('gulp-imagemin');
var pngquant     = require('imagemin-pngquant');
var sourcemaps   = require('gulp-sourcemaps');
var livereload   = require('gulp-livereload');
var autoprefixer = require('gulp-autoprefixer');


gulp.task('js-complexity', function(){
    gulp.src(['./src/js/modules/*.js'])
        .pipe(complexity({
                cyclomatic: [3, 7, 12],
                halstead: [8, 13, 20],
                maintainability: 100
            })
        );
});


gulp.task('jshint', function(){
    gulp.src(['./src/js/modules/*.js'])
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(jshint.reporter('fail'))
});


gulp.task('concat-js',['jshint'], function(){
    return gulp.src([
                        './components/jquery/dist/jquery.min.js',
                        './components/jquery-ui/jquery-ui.min.js',
                        './components/bootstrap/dist/js/bootstrap.min.js',
                        './components/jquery-mask-plugin/dist/jquery.mask.min.js',
                        './components/jquery.maskMoney/dist/jquery.maskMoney.min.js',
                        './components/sweetalert2/dist/sweetalert2.min.js',
                        './components/es6-promise/es6-promise.min.js',
                        './src/js/modules/base.js',
                        './src/js/modules/login.js',
                        './src/js/modules/widgets.js',
                        './src/js/modules/validation.js',
                        './src/js/main.js'
                    ])
        .pipe(concat('app.js',{newLine: ';'}))
        .pipe(gulp.dest('./dist/js/'));
});


gulp.task('minify-js', ['concat-js'], function(){
    return gulp.src('./dist/js/app.js')
        .pipe(sourcemaps.init())
            .pipe(rename('app.min.js'))
            .pipe(uglify({mangle:false, unused:true}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./dist/js/'))
        .pipe(livereload());
});


gulp.task('sass', function(){
    return gulp.src('./src/sass/main.scss')
        .pipe(sass({outputStyle:'expanded'}).on('error', sass.logError))
        .pipe(gulp.dest('./src/css/'));
});


gulp.task('css',['sass'], function(){
    return gulp.src([
            './components/bootstrap/dist/css/bootstrap.css',
            './components/datetimepicker/build/jquery.datetimepicker.min.css',
            './components/font-awesome/css/font-awesome.min.css',
            './components/sweetalert2/dist/sweetalert2.min.css',
            './src/css/main.css'
        ])
       //.pipe(sourcemaps.init())
            .pipe(concat('style.css'))
            .pipe(autoprefixer())
            .pipe(rename('style.min.css'))
            .pipe(cleanCSS({compatibility: 'ie8'}))
       //.pipe(sourcemaps.write('./'))
       .pipe(gulp.dest('./dist/css/'))
       .pipe(livereload());
});


gulp.task('imagemin', function() {
    return gulp.src('./src/img/*')
        .pipe(imagemin(
            {
                progressive: true,
                svgoPlugins: [{removeViewBox: false}],
                use: [pngquant()]
            }
        ))
        .pipe(gulp.dest('./dist/img'))
        .pipe(livereload());
});


gulp.task('default', ['minify-js','sass','imagemin'], function(){
    livereload.listen();
    gulp.watch('./src/js/**/*.js',['minify-js']);
    gulp.watch('./src/sass/*.scss',['css']);
    gulp.watch('./src/img/**/*',['imagemin']);
});


//gulp.task('complexity', ['js-complexity']);
