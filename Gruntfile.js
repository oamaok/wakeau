module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      dist: {
        files: {
          'build/css/wakeau.css': 'src/sass/main.sass'
        }
      }
    },
    postcss: {
      options: {
        map: false,
        processors: [
          require('autoprefixer')({browsers: 'last 2 versions'})
        ]
      },
      dist: {
        src: 'build/css/*.css'
      }
    },
    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'build/css',
          src: ['*.css', '!*.min.css'],
          dest: 'web/assets/css',
          ext: '.min.css'
        }]
      }
    },
    watch: {
      sass: {
        files: ['src/sass/**/*.sass'],
        tasks: ['sass:dist','postcss', 'cssmin']
      },
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-postcss');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.registerTask('build', ['sass:dist', 'postcss', 'cssmin'])
  grunt.registerTask('default', ['watch:sass']);
};