var gulp = require('gulp'),
    less = require('gulp-less'),
    concatJs = require('gulp-concat'),
    minifyJs = require('gulp-uglify'),
    clean = require('gulp-clean');

gulp.task('less', function() {
    return gulp.src([
        'web-src/less/style.less',
        'web-src/less/admin/admin.less'
    ])
        .pipe(less({compress: true}))
        .pipe(gulp.dest('web/css/'));
});

gulp.task('css', function() {
    return gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.css',
        'bower_components/chosen/chosen.css',
        'bower_components/AdminLTE/dist/css/AdminLTE.min.css',
        'bower_components/AdminLTE/dist/css/skins/skin-blue.min.css',
        'web-src/css/**/*.css'
    ])
        .pipe(less({compress: true}))
        .pipe(gulp.dest('web/css/'));
});

gulp.task('fonts', function () {
    return gulp.src([
        'bower_components/bootstrap/fonts/*',
        'bower_components/font-awesome/**',
        'web-src/fonts/*'
    ])
        .pipe(gulp.dest('web/fonts/'))
});

gulp.task('images', function () {
    return gulp.src([
        'web-src/images/**/*'
    ])
        .pipe(gulp.dest('web/images/'))
});

gulp.task('uploads', function () {
    return gulp.src([
        'web-src/uploads/**/*'
    ])
        .pipe(gulp.dest('web/uploads/'))
});


gulp.task('pages-js', function() {
    return gulp.src([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
        'bower_components/chosen/chosen.jquery.js',
        'bower_components/AdminLTE/dist/js/app.min.js',
        'web-src/js/**/*.js'
    ])
        .pipe(minifyJs())
        .pipe(gulp.dest('web/js/'));
});

gulp.task('clean', function () {
    return gulp.src(['web/css/*', 'web/js/*', 'web/fonts/*', 'web/images/*'])
        .pipe(clean());
});

gulp.task('default', ['clean'], function () {
    var tasks = ['less', 'css', 'fonts', 'pages-js', 'images', 'uploads'];
    tasks.forEach(function (val) {
        gulp.start(val);
    });
});

gulp.task('watch', function () {
    var less = gulp.watch('web-src/less/*.less', ['less']),
        js = gulp.watch('web-src/js/*.js', ['pages-js']);
});