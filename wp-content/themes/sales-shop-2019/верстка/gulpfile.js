var gulp       = require('gulp'),
gutil          = require('gulp-util' ),
sass           = require('gulp-sass'),
browserSync    = require('browser-sync'),
concat         = require('gulp-concat'),
uglify         = require('gulp-uglify'),
cleanCSS       = require('gulp-clean-css'),
rename         = require('gulp-rename'),
del            = require('del'),
cache          = require('gulp-cache'),
autoprefixer   = require('gulp-autoprefixer'),
ftp            = require('vinyl-ftp'),
notify         = require("gulp-notify"),
imagemin       = require('gulp-imagemin'),
rsync          = require('gulp-rsync'),
changed        = require('gulp-changed');
rigger         = require('gulp-rigger');
// Пользовательские скрипты проекта

gulp.task('browser-sync', function() {
	browserSync({
		server: {
			baseDir: 'dist'
		},
		notify: false,
		// tunnel: true,
		// tunnel: "projectmane", //Demonstration page: http://projectmane.localtunnel.me
	});
});

gulp.task('html', function () {
	gulp.src('app/**/*.html')
	.pipe(rigger())
	.pipe(gulp.dest('dist'))
	.pipe(browserSync.reload({stream: true}));
});

gulp.task('sass', function() {
	return gulp.src([
		'app/sass/**/*.sass',
		])
	.pipe(sass({outputStyle: 'expand'}).on("error", notify.onError()))
	.pipe(rename({suffix: '.min', prefix : ''}))
	.pipe(autoprefixer(['last 15 versions']))
	.pipe(cleanCSS())
	.pipe(gulp.dest('app/css'))
	.pipe(gulp.dest('dist/css'))
	.pipe(browserSync.reload({stream: true}));
});

gulp.task('js', function () {
    gulp.src('app/js/common.js')
        .pipe(rigger())
        .pipe(concat('scripts.min.js'))
        // .pipe(uglify())
        .pipe(gulp.dest('app/js/'))
        .pipe(gulp.dest('dist/js/'))
        .pipe(browserSync.reload({stream: true}))
});

// gulp.task('bootstrap', function() {
// 	return gulp.src([
// 		'app/libs/bootstrap/**/*.scss',
// 		])
// 	.pipe(sass({outputStyle: 'expand'}).on("error", notify.onError()))
// 	.pipe(rename({suffix: '.min', prefix : ''}))
// 	.pipe(autoprefixer(['last 15 versions']))
// 	.pipe(cleanCSS()) // Опционально, закомментировать при отладке
// 	.pipe(gulp.dest('app/libs/bootstrap'))
// 	.pipe(browserSync.reload({stream: true}));
// });

gulp.task('imagemin', function() {
	return gulp.src('app/img/**/*')
	.pipe(cache(imagemin()))
	.pipe(changed('dist/img'))
	.pipe(imagemin())
	.pipe(gulp.dest('dist/img'))
    .pipe(browserSync.reload({stream: true}))
});

gulp.task('fonts', function() {
	return gulp.src('app/fonts/**/*')
	.pipe(gulp.dest('dist/fonts'))
    .pipe(browserSync.reload({stream: true}))
});



gulp.task('watch', ['html', 'sass', 'js', 'browser-sync'], function() {
	gulp.watch('app/sass/**/*.sass', ['sass']);
	gulp.watch(['libs/**/*.js', 'app/js/common.js'], ['js']);
	gulp.watch('app/**/*.html', ['html']);
	
});

gulp.task('build', ['html', 'removedist', 'imagemin', 'sass', 'js'], function() {

	var buildFiles = gulp.src([
		// 'app/*.html',
		'app/.htaccess',
		]).pipe(gulp.dest('dist'));

	var buildCss = gulp.src([
		'app/css/*.css',
		]).pipe(gulp.dest('dist/css'));

	var buildJs = gulp.src([
		'app/js/scripts.min.js',
		]).pipe(gulp.dest('dist/js'));

	var buildFonts = gulp.src([
		'app/fonts/**/*',
		]).pipe(gulp.dest('dist/fonts'));

});

/*gulp.task('deploy', function() {

	var conn = ftp.create({
		host:      'hostname.com',
		user:      'username',
		password:  'userpassword',
		parallel:  10,
		log: gutil.log
	});

	var globs = [
	'dist/**',
	'dist/.htaccess',
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest('/path/to/folder/on/server'));

});

gulp.task('rsync', function() {
	return gulp.src('dist/**')
	.pipe(rsync({
		root: 'dist/',
		hostname: 'username@yousite.com',
		destination: 'yousite/public_html/',
		// include: ['*.htaccess'], // Скрытые файлы, которые необходимо включить в деплой
		recursive: true,
		archive: true,
		silent: false,
		compress: true
	}));
});*/

gulp.task('removedist', function() { 
	return del.sync('dist'); 
});

gulp.task('clearcache', function () { return cache.clearAll(); });

gulp.task('default', ['watch']);

/*gulp.task('common-js', function() {
	return gulp.src([
		'app/js/common.js',
		])
	.pipe(concat('common.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('app/js'));
});*/