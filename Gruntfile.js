const path = require('path');

module.exports = function (grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    makepot: {
      target: {
        options: {
          cwd: '',
          domainPath: 'lang/',
          exclude: [],
          include: [],
          mainFile: 'style.css',
          potComments: '',
          potFilename: 'karmakit.pot',
          potHeaders: {
            poedit: true,
            'x-poedit-keywordslist': true
          },
          processPot: null,
          type: 'wp-plugin',
          updateTimestamp: true,
          updatePoFiles: false
        }
      }
    },
    compress: {
      main: {
        options: {
          archive: 'release/karma-kit-v<%= pkg.version %>.zip'
        },
        files: [
          {
            src: [
              'assets/**',
              'core/**',
              'widgets/**',
              'vendor/**',
              '*.php'
            ],
            expand: true,
            dest: 'karma-kit/'
          },

        ]
      }
    }

  });

  grunt.loadNpmTasks( 'grunt-wp-i18n' );
  grunt.loadNpmTasks('grunt-contrib-compress');

  grunt.registerTask('lang', ['makepot']);
  grunt.registerTask('release', ['compress']);
};
