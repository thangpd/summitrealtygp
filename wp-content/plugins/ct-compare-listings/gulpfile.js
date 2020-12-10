var gulp                  = require('gulp');
var less                  = require('gulp-less');
var notify                = require('gulp-notify');
var plumber               = require('gulp-plumber');
var livreload             = require('gulp-livereload');
var gutil 		            = require("gulp-util");
var webpack 	            = require("webpack");
var path                  = require("path");
var WebpackNotifierPlugin = require('webpack-notifier');
var cleanCSS              = require('gulp-clean-css');




// webpack normal mode config
var config = {
  color: true,
  progress: true,
  watch: true,
  devtool: 'source-map',
  debug: true,
  entry: {
    'backend.js':'./assets/src/backend/backend.js',
    'frontend.js' : './assets/src/frontend/frontend.js'
  },
  output: {
    path: './assets/dist/js/',
    filename: '[name]'
  },
  resolve: {
   extensions: ['', '.js', '.json']
  },
  module: {
    // preLoaders: [
    //   {
    //     test: /\.jsx$|\.js$/,
    //     loader: 'eslint-loader',
    //     include: __dirname + '/assets',
    //     exclude: /frontend.js$|\/backend.js$/
    //   }
    // ],

    loaders: [
      { test: /\.js$/, loader: 'babel-loader',
        query: {
          presets: ['es2015', 'stage-0', 'react'],
        }
      }
    ],
  },
  plugins: [
      new WebpackNotifierPlugin({ title: 'Webpack' ,  sound: 'Glass' }),
  ],
  exclude: [
    path.resolve(__dirname, "node_modules"),
  ]
};

//gulp webpack task for normal mode
gulp.task('webpack', function() {
  webpack(config, function(err, stats) {
     if(err) throw new gutil.PluginError("webpack", err);
     gutil.log("[webpack]", stats.toString({
     }));
  });
});


gulp.task('js-minify', function() {
  config.plugins = [
    new webpack.optimize.UglifyJsPlugin(),
    new webpack.optimize.DedupePlugin(),
    new WebpackNotifierPlugin({title: 'Webpack'}),
	];
  config.watch = false;
  webpack(config, function(err, stats) {
     if(err) throw new gutil.PluginError("webpack", err);
     gutil.log("[webpack]", stats.toString({
     }));
  });
});




// Error handler for less
function errorAlert(error){
  notify.onError({title: "Gulp Compiled Error", message: "Check your terminal", sound: "Sosumi"})(error);
  console.log(error.toString());
  this.emit("end");
};



// gulp less task
gulp.task('less', function() {
	return gulp.src('./assets/src/less/*.less')
	.pipe(plumber({errorHandler: errorAlert}))
	.pipe(less())
	.pipe(notify({
    title: 'Gulp',
    subtitle: 'success',
    message: 'less task',
    sound: "Pop"
  }))
  .pipe(gulp.dest('./assets/dist/css/'));
});

// gulp less-admin task
gulp.task('less-admin', function() {
  return gulp.src('./assets/src/less/admin/*.less')
  .pipe(plumber({errorHandler: errorAlert}))
  .pipe(less())
  .pipe(notify({
    title: 'Gulp',
    subtitle: 'success',
    message: 'less task',
    sound: "Pop"
  }))
  .pipe(gulp.dest('./assets/dist/css/'));
});



gulp.task('minify-css', function() {
  return gulp.src(['./assets/dist/css/style.css', './assets/dist/css/ionicons.css', './assets/dist/css/simple-line-icons.css', './assets/dist/css/admin.css'])
    .pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(gulp.dest('./assets/dist/css/'));
});




// watch task
gulp.task('watch', function() {
	gulp.watch('./assets/src/less/**/*.less', ['less', 'less-admin']);
});




// webpack production task
gulp.task('production',['js-minify', 'minify-css']);

// default task
gulp.task('default', ['watch', 'less', 'less-admin', 'webpack']);
