// Karma configuration
// Generated on Tue Jun 30 2015 01:18:30 GMT+1000 (AEST)

module.exports = function(config) {
  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: './',


    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['jasmine'],


    // list of files / patterns to load in the browser
    files: [
      'js/jquery-1.7.2.min.js',
      'js/excanvas.min.js',
      'js/chart.min.js',
      'js/bootstrap.js',
      'js/base.js',
      'js/signin.js',
      'lib/jquery-ui.js',
      'lib/moment.min.js',
      'lib/angular/angular.js',
      'jasmine/lib/angular-mocks.js',
      'lib/*.js',

      'app.js',
      'app.config.js',
      'app.service.js',
      'modules/**/*.js',

      'test/*Spec.js'
    ],


    // list of files to exclude
    exclude: [
        'lib/angular.js',
        'lib/angular-chart.js',
        'lib/Chart.StackedBar.js'
    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
    },


    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['progress'],


    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,


    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,


    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['Safari'],


    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false
  })
}
