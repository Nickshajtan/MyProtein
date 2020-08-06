/*
* run "npm install" to install all dependencies from package.json or run those manually
*
*/

'use strict';
var gulp           = require('gulp'),
    gutil          = require('gulp-util' ),
    data           = require('gulp-data'),
    path           = require('path'),
    sass           = require('gulp-sass'),
    less           = require('gulp-less'),
    stylus         = require('gulp-stylus').stylus,
    concat         = require('gulp-concat'),
    rename         = require('gulp-rename'),
    uglify         = require('gulp-uglify-es').default,
    sourcemaps     = require('gulp-sourcemaps'),
    autoprefixer   = require('gulp-autoprefixer'),
    LessAutoprefix = require('less-plugin-autoprefix'),
    autoprefix     = new LessAutoprefix({ browsers: ['last 2 versions'] }),
    fontmin        = require('gulp-fontmin'),
    htmlmin        = require('gulp-htmlmin'),
    imagemin       = require('gulp-imagemin'),
    imageminMoz    = require('imagemin-mozjpeg'),
    imageminSvgo   = require('imagemin-svgo'),
    browsersync    = require('browser-sync').create(),
    notify         = require('gulp-notify'),
    imageminSvgo    = require('imagemin-svgo'),
    svgmin          = require('gulp-svgmin'),
    svgsprite       = require('gulp-svg-sprite'),
    spritesmith     = require('gulp.spritesmith'),;

var gulpLoadPlugins = require('gulp-load-plugins');

var emittyPug,
    errorHandler;

var $ = gulpLoadPlugins({
	overridePattern: false,
	pattern: [
		'browser-sync',
		'emitty',
		'merge-stream',
		'vinyl-buffer',
		'append-prepend',
        'postcss-reporter',
        'postcss-scss',
        'gulp-postcss',
        'gulp-newer',
        'gulp-debug',
        'gulp-if',
        'gulp-plumber',
        'merge-stream',
        'gulp-cheerio',
	],
	scope: [
		'dependencies',
		'devDependencies',
		'optionalDependencies',
		'peerDependencies',
	],
});

var syntax = [ 'scss' ]; // Include your css syntax into array;
var retina = false;      // Retina settings; Bool

var pathOptions = {
  baseStyles:     './assets/styles/base/',
  scssStyles:     './assets/styles/scss/',
  sassStyles:     './assets/styles/sass/',
  lessStyles:     './assets/styles/less/',
  stylStyles:     './assets/styles/stylus/',
  pathScript:     './assets/js/',
  pathLibs:       './assets/libs/',
  pathResources:  './assets/resources/',
  pathFonts:      './assets/resources/fonts/',
  pathImg:        './assets/img/',
  pathSprite:      './assets/sprites/',
};

var notifyOptions = {
  message : 'Error:: <%= error.message %> \nLine:: <%= error.line %> \nCode:: <%= error.extract %>'
};

function browserSync(done) {
	browsersync.create().init({
        //Domain name or main directory ( choose server or proxy )
        //server: "passagency",  //server + /sync-options = settings 
        proxy: "avto.com", //proxy + /sync-options = settings; OSpanel domain name
        notify: false,
        port: 3000,
        open: true,
	});
    done();
}

function browserSyncReload() {
  browsersync.reload();
}

/*
* compile base theme scss
*/
gulp.task('base-theme-styles', function(){
  return gulp
  .src(path.join(pathOptions.baseStyles, 'base-theme-styles.scss'))
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
  .pipe(concat('base-theme-styles.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/css/'));
});

/*
* compile theme scss
*/
if( syntax.indexOf( 'scss' ) != -1 ){
    
    // Styles for first site screen
    gulp.task('scss-head-styles', function(){
      return gulp
      .src(path.join(pathOptions.scssStyles, 'theme/head/first-screen.scss'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('scss-header-theme-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Other site styles
    gulp.task('scss-other-styles', function(){
      return gulp
      .src(path.join(pathOptions.scssStyles, 'theme/other/main.scss'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('scss-other-theme-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Vendor styles
    gulp.task('scss-vendor-styles', function(){
      return gulp
      .src(path.join(pathOptions.scssStyles, 'vendor/vendor.scss'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('scss-vendor-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Theme-parts styles
    gulp.task('scss-parts-styles', function(){
      return gulp
      .src(path.join(pathOptions.scssStyles, 'theme/theme-parts/**/*.scss'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(rename({suffix: '.min', dirname: ""}))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    console.log( 'SCSS syntax: Enable' );
}

/*
* compile theme sass
*/
if( syntax.indexOf( 'sass' ) != -1 ){
    
    // Styles for first site screen
    gulp.task('sass-head-styles', function(){
      return gulp
      .src(path.join(pathOptions.sassStyles, 'theme/head/first-screen.sass'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('sass-header-theme-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Other site styles
    gulp.task('sass-other-styles', function(){
      return gulp
      .src(path.join(pathOptions.sassStyles, 'theme/other/main.sass'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('sass-other-theme-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Vendor styles
    gulp.task('sass-vendor-styles', function(){
      return gulp
      .src(path.join(pathOptions.sassStyles, 'vendor/vendor.sass'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('sass-vendor-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Theme-parts styles
    gulp.task('sass-parts-styles', function(){
      return gulp
      .src(path.join(pathOptions.sassStyles, 'theme/theme-parts/**/*.sass'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(rename({suffix: '.min', dirname: ""}))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    console.log( 'SASS syntax: Enable' );
}

/*
* compile theme less
*/
if( syntax.indexOf( 'less' ) != -1 ){
    
    // Styles for first site screen
    gulp.task('less-head-styles', function () {
      return gulp
        .src(path.join(pathOptions.lessStyles, 'theme/head/first-screen.less'))
        .pipe(sourcemaps.init())
        .pipe(less({ paths: [ path.join(__dirname, 'less', 'includes') ], plugins: [autoprefix] }).on('error',  notify.onError(notifyOptions)))
        .pipe(concat('less-header-theme-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Other site styles
    gulp.task('less-other-styles', function () {
      return gulp
        .src(path.join(pathOptions.lessStyles, 'theme/other/main.less'))
        .pipe(sourcemaps.init())
        .pipe(less({ paths: [ path.join(__dirname, 'less', 'includes') ], plugins: [autoprefix] }).on('error',  notify.onError(notifyOptions)))
        .pipe(concat('less-other-theme-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Vendor styles
    gulp.task('less-vendor-styles', function () {
      return gulp
        .src(path.join(pathOptions.lessStyles, 'vendor/vendor.less'))
        .pipe(sourcemaps.init())
        .pipe(less({ paths: [ path.join(__dirname, 'less', 'includes') ], plugins: [autoprefix] }).on('error',  notify.onError(notifyOptions)))
        .pipe(concat('less-vendor-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Theme-parts styles
    gulp.task('less-parts-styles', function(){
      return gulp
      .src(path.join(pathOptions.lessStyles, 'theme/theme-parts/**/*.less'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(rename({suffix: '.min', dirname: ""}))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    console.log( 'LESS syntax: Enable' );
}

/*
* compile theme stylus
*/
if( syntax.indexOf( 'stylus' ) != -1 ){
    var data = {red: '#ff0000'};
    
    // Styles for first site screen
    gulp.task('stylus-head-styles', function () {
      return gulp
        .src(path.join(pathOptions.stylStyles, 'theme/head/first-screen.styl'))
        .pipe(data(function(file){return {
            componentPath: '/' + (file.path.replace(file.base, '').replace(/\/[^\/]*$/, ''))
        };}))
        .pipe(sourcemaps.init())
        .pipe(stylus({
            compress: true,
            linenos: true,
            'include css': true,
            rawDefine: { data: data }
        }))
        .pipe(concat('stylus-header-theme-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Other site styles
    gulp.task('stylus-other-styles', function () {
      return gulp
        .src(path.join(pathOptions.stylStyles, 'theme/other/main.styl'))
        .pipe(data(function(file){return {
            componentPath: '/' + (file.path.replace(file.base, '').replace(/\/[^\/]*$/, ''))
        };}))
        .pipe(sourcemaps.init())
        .pipe(stylus({
            compress: true,
            linenos: true,
            'include css': true,
            rawDefine: { data: data }
        }))
        .pipe(concat('stylus-other-theme-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Vendor styles
    gulp.task('stylus-vendor-styles', function () {
      return gulp
        .src(path.join(pathOptions.stylStyles, 'vendor/vendor.styl'))
        .pipe(data(function(file){return {
            componentPath: '/' + (file.path.replace(file.base, '').replace(/\/[^\/]*$/, ''))
        };}))
        .pipe(sourcemaps.init())
        .pipe(stylus({
            compress: true,
            linenos: true,
            'include css': true,
            rawDefine: { data: data }
        }))
        .pipe(concat('stylus-vendor-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/css/'));
    });
    
    // Theme-parts styles
    gulp.task('stylus-parts-styles', function(){
      return gulp
      .src(path.join(pathOptions.stylStyles, 'theme/theme-parts/**/*.styl'))
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(rename({suffix: '.min', dirname: ""}))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/css/'));
    });
    
    console.log( 'STYLUS syntax: Enable' );
}

/*
* wrap front styling for gutenberg admin
*/
gulp.task('gtb-acf-styles', function(){
  return gulp
  .src(path.join(pathOptions.baseStyles, 'gtb.scss'))
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
  .pipe(concat('gtb.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/css/'));
});

gulp.task('gtb-wp-styles', function(){
  return gulp
  .src(path.join(pathOptions.baseStyles, 'gtb-wp.scss'))
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
  .pipe(concat('gtb-wp.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/css/'));
});

/*
* compile gutenberg js ( theme core )
*/
gulp.task('gtb-scripts', function() {
  return gulp
  .src(['./includes/helpers/gutenberg/js/**/*.js', '!./includes/helpers/gutenberg/js/**/*.min.js'])
  .pipe(sourcemaps.init())
  .pipe(rename({suffix: '.min', dirname: ""}))
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./includes/helpers/gutenberg/js/'));
});

/*
* compile config js ( theme core )
*/
gulp.task('admin-scripts', function() {
  return gulp
  .src(['./includes/config/admin/assets/js/**/*.js', '!./includes/config/admin/assets/js/**/*.min.js'])
  .pipe(sourcemaps.init())
  .pipe(rename({suffix: '.min', dirname: ""}))
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./includes/config/admin/assets/js/'));
});

/*
* compile theme js
*/
gulp.task('theme-scripts', function() {
  return gulp
  .src(path.join(pathOptions.pathScript, 'theme/**/*.js'))
  .pipe(concat('theme.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/js/'));
});

/*
* compile theme parts js
*/
gulp.task('theme-part-scripts', function() {
  return gulp
  .src(path.join(pathOptions.pathScript, 'theme-parts/**/*.js'))
  .pipe(sourcemaps.init())
  .pipe(rename({suffix: '.min', dirname: ""}))
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/js/'));
});

/*
* compile vendor scripts
*/
gulp.task('vendor-scripts', function() {
  return gulp
  .src(path.join(pathOptions.pathScript, 'vendor/**/*.js'))
  .pipe(concat('vendor.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/js/'));
});

/*
* optimize theme images
*/
gulp.task('compress-img', function(done) {
    return gulp
    .src(path.join(pathOptions.pathImg, '**/*'))
    .pipe(sourcemaps.init())
    .pipe(imagemin([
            imagemin.gifsicle({
				interlaced: true,
			}),
			imagemin.optipng({
				optimizationLevel: 3,
			}),
			imageminMoz({
				progressive: true,
				quality: 80,
			}),
            imageminSvgo({
                js2svg: {
                    pretty: !minify,
                    indent: '\t',
                },
                plugins: [
                    {removeViewBox: true},
                    {removeTitle: true},
				    {sortAttrs: true},
                ]
            })
        ]))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./assets/public/img/'))
    .on('end', done);
});

/*
* minify html code
*/
gulp.task('compress-html', function(done) {
  return gulp
    .src(['*.html', './**/*.html'])
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(gulp.dest('./assets/public/'))
    .on('end', done);
});

/*
* minify fonts
*/
function minifyFont(text, cb) {
    gulp
    .src(path.join(pathOptions.pathFonts, '**/*.ttf'))
    .pipe(fontmin({
            text: text
    }))
    .pipe(gulp.dest('./assets/public/resources/fonts/'))
    .on('end', cb);
}
gulp.task('compress-fonts', function(cb) {
    var buffers = [];
    gulp.src('index.php')
    .on('data', function(file) {
            buffers.push(file.contents);
    })
    .on('end', function() {
            var text = Buffer.concat(buffers).toString('utf-8');
            minifyFont(text, cb);
    });
});

/*
* generate images sprite
*/
gulp.task('img-sprite', function () {
  var spriteData = gulp.src(path.join(pathOptions.pathSprite, 'img-usual/**/*.*')).pipe($.plumber({
			errorHandler,
  }))
  .pipe(spritesmith({
    imgName: 'sprite.png',
    imgPath: '../img/sprite.png',
    cssName: '_img-sprite.scss',
    retinaSrcFilter: path.join(pathOptions.pathSprite, 'img-retina/*.*'),
    retinaImgName: 'sprite@2x.png',
    retinaImgPath: '../img/sprite@2x.png',
    padding: 5,
  }));
  
  // Pipe image stream onto disk
  var imgStream = spriteData.img
    .pipe(gulp.dest('./assets/public/sprites/'));
  
  // Pipe CSS stream onto disk
  var cssStream = spriteData.css
    .pipe(gulp.dest(path.join(pathOptions.baseStyles, '_mixins/')));
  
  // Return a merged stream to handle both `end` events
  return merge(imgStream, cssStream);
});

/*
* generate svg sprite
*/
function svgminConfig() {
      return imageminSvgo({
                js2svg: {
                    pretty: !minify,
                    indent: '\t',
                },
                plugins: [
                    {removeViewBox: true},
                    {removeTitle: true},
				    {sortAttrs: true},
                ]
       }),
       svgmin({
			js2svg: {
				pretty: true
			}
       })
}
gulp.task('svg-sprite', function () {
	  return gulp.src(path.join(pathOptions.pathSprite, 'svg/**/*.*'))
      .pipe($.plumber({
			errorHandler,
      }))
      .pipe($.if(argv.debug, $.debug()))
      .pipe($.svgstore())
      .pipe($.if(!argv.minifySvg, $.replace(/^\t+$/gm, '')))
      .pipe($.if(!argv.minifySvg, $.replace(/\n{2,}/g, '\n')))
      .pipe($.if(!argv.minifySvg, $.replace('?><!', '?>\n<!')))
      .pipe($.if(!argv.minifySvg, $.replace('><svg', '>\n<svg')))
      .pipe($.if(!argv.minifySvg, $.replace('><defs', '>\n\t<defs')))
      .pipe($.if(!argv.minifySvg, $.replace('><symbol', '>\n<symbol')))
      .pipe($.if(!argv.minifySvg, $.replace('></svg', '>\n</svg')))
      .pipe( svgminConfig() )
      .pipe(cheerio({
			run: function ($) {
				$('[fill]').removeAttr('fill');
				$('[stroke]').removeAttr('stroke');
				$('[style]').removeAttr('style');
			},
			parserOptions: {xmlMode: true}
		}))
      .pipe(replace('&gt;', '>'))
      .pipe(svgsprite({
      mode: {
           view: {
              bust: false,
              render: {
                scss: true
              }
            },
            symbol: {
                sprite: "../img/sprite.svg",
                render: {
                    scss: {
                        dest: path.join(pathOptions.baseStyles, '_mixins/_svg-sprite.scss'),
                        template: path.join(pathOptions.baseStyles, '_mixins/_svg-sprite_template.scss')
                    }
                }
            }
        }
        }))
        .pipe(gulp.dest('./assets/public/sprites/'));

});

/*
* copy resources dir
*/
gulp.task('copy-dir-resources', function(done) {
    return gulp
    .src(path.join(pathOptions.pathResources, '**/*.*'))
    .on('data', function(file){  
			console.log({
                contents: file.contents,                 
                path: file.path,                         
                cwd: file.cwd,                           
                base: file.base,                         
                // path component helpers                
                relative: file.relative,                 
                dirname: file.dirname,                   
                basename: file.basename,                 
                stem: file.stem,                         
                extname: file.extname   
            });                 
    })    
    .pipe(gulp.dest('./assets/public/resources/') );
});

gulp.task('fonts-styles', function(){
  return gulp
  .src(path.join(pathOptions.pathFonts, 'fonts.css'))
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer({ browsers: ['last 99 versions'], cascade: false }))
  .pipe(concat('fonts.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/'));
});

/*
* copy libs dir
*/
gulp.task('copy-dir-libs', function(done) {
    return gulp
    .src(path.join(pathOptions.pathLibs, '**/*.*'))
    .on('data', function(file){  
			console.log({
                contents: file.contents,                 
                path: file.path,                         
                cwd: file.cwd,                           
                base: file.base,                         
                // path component helpers                
                relative: file.relative,                 
                dirname: file.dirname,                   
                basename: file.basename,                 
                stem: file.stem,                         
                extname: file.extname   
            });                
    })    
    .pipe(gulp.dest('./assets/public/libs/') );
});

/*
* compile instagram js witheout API
*/
gulp.task('inst-script-no-api', function() {
  return gulp
  .src('./includes/helpers/instagram/assets/jquery.instagramFeed.js')
  .pipe(concat('jquery.instagramFeed.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/js/'));
});

/*
* compile instagram js with API
*/
gulp.task('inst-script-api', function() {
  return gulp
  .src('./includes/helpers/instagram/assets/instApi.js')
  .pipe(concat('instApi.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/js/'));
});

/*
*  run task for one time theme core styles & js files compiling
*/
gulp.task('theme-core', gulp.series('admin-scripts','gtb-scripts'));

/*
*  run task for one time vendor styles, js files compiling
*/
if( syntax.indexOf( 'scss' ) != -1 ){
    gulp.task('vendor', gulp.series('scss-vendor-styles','vendor-scripts', 'copy-dir-libs', 'copy-dir-resources', 'fonts-styles'));
}
if( syntax.indexOf( 'sass' ) != -1 ){
    gulp.task('vendor', gulp.series('sass-vendor-styles','vendor-scripts', 'copy-dir-libs', 'copy-dir-resources', 'fonts-styles'));
}
if( syntax.indexOf( 'less' ) != -1 ){
    gulp.task('vendor', gulp.series('less-vendor-styles','vendor-scripts', 'copy-dir-libs', 'copy-dir-resources', 'fonts-styles'));
}
if( syntax.indexOf( 'stylus' ) != -1 ){
    gulp.task('vendor', gulp.series('stylus-vendor-styles','vendor-scripts', 'copy-dir-libs', 'copy-dir-resources', 'fonts-styles'));
}

/*
* run task to minify files, main time html files
*/
gulp.task('compress', gulp.series('compress-html'));

/*
* run task to one time complete theme-parts single scripts & styles
*/
if( syntax.indexOf( 'scss' ) != -1 ){
    gulp.task('theme-part-assets', gulp.series('scss-parts-styles','theme-part-scripts'));
}
if( syntax.indexOf( 'sass' ) != -1 ){
    gulp.task('theme-part-assets', gulp.series('sass-parts-styles','theme-part-scripts'));
}
if( syntax.indexOf( 'less' ) != -1 ){
    gulp.task('theme-part-assets', gulp.series('less-parts-styles','theme-part-scripts'));
}
if( syntax.indexOf( 'stylus' ) != -1 ){
    gulp.task('theme-part-assets', gulp.series('stylus-parts-styles','theme-part-scripts'));
}

/* 
* run task for continuous track of theme files 
*/
gulp.task('watch-theme', function() {
    gulp.watch('./assets/styles/base/**/*.scss',   gulp.series('gtb-acf-styles','gtb-wp-styles','base-theme-styles')).on( 'change', browserSyncReload );
    if( syntax.indexOf( 'scss' ) != -1 ){
        gulp.watch('./assets/styles/scss/theme/**/*.scss',   gulp.series('scss-head-styles','scss-other-styles','scss-parts-styles','gtb-acf-styles','gtb-wp-styles','base-theme-styles')).on( 'change', browserSyncReload );
    }
    if( syntax.indexOf( 'sass' ) != -1 ){
        gulp.watch('./assets/styles/sass/theme/**/*.sass',   gulp.series('sass-head-styles','sass-other-styles','sass-parts-styles','gtb-acf-styles','gtb-wp-styles','base-theme-styles')).on( 'change', browserSyncReload );
    }
    if( syntax.indexOf( 'less' ) != -1 ){
        gulp.watch('./assets/styles/less/theme/**/*.less',   gulp.series('less-head-styles','less-other-styles','less-parts-styles','gtb-acf-styles','gtb-wp-styles','base-theme-styles')).on( 'change', browserSyncReload );
    }
    if( syntax.indexOf( 'stylus' ) != -1 ){
        gulp.watch('./assets/styles/stylus/theme/**/*.styl', gulp.series('stylus-head-styles','stylus-other-styles','stylus-parts-styles','gtb-acf-styles','gtb-wp-styles','base-theme-styles')).on( 'change', browserSyncReload );
    }
	gulp.watch('./assets/resources/fonts/fonts.css',  gulp.series('fonts-styles', 'copy-dir-resources')).on( 'change', browserSyncReload );
	gulp.watch('./assets/js/theme/*.js',  gulp.series('theme-scripts')).on( 'change', browserSyncReload );
	gulp.watch('./assets/js/theme-parts/*.js',  gulp.series('theme-part-scripts')).on( 'change', browserSyncReload );
	gulp.watch('./assets/js/vendor/*.js',  gulp.series('vendor-scripts')).on( 'change', browserSyncReload );
	gulp.watch('./includes/helpers/instagram/assets/*.js',  gulp.series('inst-script-api', 'inst-script-no-api')).on( 'change', browserSyncReload );
	gulp.watch(['./assets/img/**/*', './assets/img/*'], gulp.series('compress-img')).on( 'change', browserSyncReload );
    gulp.watch(['./**/*.php', '*.php']).on('change', browserSyncReload );
});

gulp.task('default', gulp.parallel('watch-theme', 'copy-dir-libs', 'copy-dir-resources', 'fonts-styles', 'vendor', browserSync));