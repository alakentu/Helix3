'use strict';

process.env.DISABLE_NOTIFIER = true;

const gulp	= require('gulp'),
	  zip 	= require('gulp-zip'),
	  clean = require('gulp-clean');

var paths = {
	template: {
		src: 'templates/shaper_helix3/**/*.*',
		dest: 'build/template'
	},
	tpl_language: {
		src: 'language/en-GB/*.ini',
		dest: 'build/template/language/en-GB'
	},
	plugin: {
		src: 'plugins/system/helix3/**/*.*',
		dest: 'build/plugins/system'
	},
	plg_language: {
		src: [
			'administrator/en-GB/en-GB.plg_system_helix3.ini',
			'administrator/en-GB/en-GB.plg_system_helix3.sys.ini'
		],
		dest: 'build/plugins/system/language/en-GB'
	},
	ajax: {
		src: 'plugins/ajax/helix3/**/*.*',
		dest: 'build/plugins/ajax'
	},
	ajax_lang: {
		src: [
			'administrator/en-GB/en-GB.plg_ajax_helix3.ini',
			'administrator/en-GB/en-GB.plg_ajax_helix3.sys.ini'
		],
		dest: 'build/plugins/ajax/language/en-GB'
	},
	installer: {
		src: ['installer.script.php', 'installer.xml'],
		dest: 'build'
	},
};

gulp.task('cleanBuild', function() {
    return gulp.src('build', { 
		read: false, 
		allowEmpty: true 
	}).pipe(clean());
});

gulp.task('cleanZip', function() {
    return gulp.src('dist/helix3_template.zip', { 
		read: false, 
		allowEmpty: true 
	}).pipe(clean());
});

gulp.task('copyTemplate', function() {
    return gulp.src(paths.template.src).pipe(gulp.dest(paths.template.dest));
});

gulp.task('copyTemplateLang', function() {
    return gulp.src(paths.tpl_language.src).pipe(gulp.dest(paths.tpl_language.dest));
});

gulp.task('copySysPlugin', function() {
    return gulp.src(paths.plugin.src).pipe(gulp.dest(paths.plugin.dest));
});

gulp.task('copySysPluginLang', function() {
    return gulp.src(paths.plg_language.src).pipe(gulp.dest(paths.plg_language.dest));
});

gulp.task('copyAjaxPlugin', function() {
    return gulp.src(paths.ajax.src).pipe(gulp.dest(paths.ajax.dest));
});

gulp.task('copyAjaxPluginLang', function() {
    return gulp.src(paths.ajax_lang.src).pipe(gulp.dest(paths.ajax_lang.dest));
});

gulp.task('copyInstallers', function() {
    return gulp.src(paths.installer.src).pipe(gulp.dest(paths.installer.dest));
});

gulp.task('makeZip', function() {
	return gulp.src('build/**/*.*')
		.pipe(zip("helix3_template.zip"))
		.pipe(gulp.dest('dist'));
});

gulp.task('build', gulp.series('cleanBuild', 'cleanZip', 'copyTemplate', 'copyTemplateLang', 'copySysPlugin', 'copySysPluginLang', 'copyAjaxPlugin', 'copyAjaxPluginLang', 'copyInstallers', 'makeZip'));