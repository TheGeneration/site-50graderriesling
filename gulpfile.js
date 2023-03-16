'use strict';

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const autoprefixer = require('gulp-autoprefixer');
const childProcess = require('child_process');
const sourcemaps = require('gulp-sourcemaps');
const log = require('fancy-log');

// Lint JavaScript code to ensure quality
const eslint = require('gulp-eslint-new');

// Sass frontend
const frontendStylesSrc = [
	'./resources/assets/sass/**/*.scss',
	'!./resources/assets/sass/editor.scss',
];

gulp.task('sass:frontend', () => {
	return gulp
		.src(frontendStylesSrc)
		.pipe(sourcemaps.init())
		.pipe(sass({ outputStyle: 'compressed' }))
		.on('error', sass.logError)
		.pipe(rename({ suffix: '.min' }))
		.pipe(
			autoprefixer({
				cascade: false,
			})
		)
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./assets/css'));
});

// Sass editor css
const editorStylesSrc = ['./resources/assets/sass/editor.scss'];

gulp.task('sass:editor', () => {
	return gulp
		.src(editorStylesSrc)
		.pipe(sass({ outputStyle: 'compressed' }))
		.on('error', sass.logError)
		.pipe(rename({ suffix: '.min' }))
		.pipe(
			autoprefixer({
				cascade: false,
			})
		)
		.pipe(gulp.dest('./assets/css'));
});

// JS frontend
const frontendJsSrc = ['./resources/assets/javascripts/**/*.js'];

gulp.task('js:frontend', () => {
	return gulp
		.src(frontendJsSrc)
		.pipe(eslint())
		.pipe(eslint.formatEach('compact', process.stderr))
		.pipe(eslint.failAfterError())
		.on('error', () => {
			log('Error in js:frontend');
		})
		.pipe(concat('app.js'))
		.pipe(
			terser({ mangle: true }).on('error', (terser) => {
				console.error(terser.message);
				this.emit('end');
			})
		)
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('./assets/js/'));
});

// PHP
gulp.task('php', (done) => {
	const cmd = childProcess.spawn('./vendor/bin/phpcs', []);

	let hasError = false;

	cmd.stdout.on('data', (data) => {
		log(data.toString());
		hasError = true;
	});

	cmd.on('exit', () => {
		if (hasError) {
			log('PHP CS got errors! Check the console.');
		} else {
			log('PHP CS was successful!');
		}

		done();
	});
});

gulp.task('watch:sass', () => {
	gulp.series(['sass:frontend'])();

	gulp.watch(frontendStylesSrc, gulp.series(['sass:frontend']));
	gulp.watch(editorStylesSrc, gulp.series(['sass:editor']));
});

gulp.task('watch:js', () => {
	gulp.watch(frontendJsSrc, gulp.series(['js:frontend']));
});

gulp.task('watch:php', () => {
	return gulp.watch(
		['*.php', 'inc/**/*.php', 'partials/**/*.php'],
		{ events: 'all' },
		gulp.series(['php'])
	);
});

gulp.task('watch', gulp.parallel('watch:sass', 'watch:js', 'watch:php'));

gulp.task('build', gulp.parallel('js:frontend', 'sass:frontend'));

gulp.task('default', gulp.series(['build']));
