module.exports = function(grunt) {

    // Load all Grunt tasks
    require('load-grunt-tasks')(grunt);
    
    // Show grunt task timetable
    require('time-grunt')(grunt);

    // Config
    grunt.initConfig({

        // Read package.json
        pkg: grunt.file.readJSON('package.json'),

        // Set refs to the main asset locations
        basepath: {
            root: 'web/assets',
            css:  '<%= basepath.root %>/css',
            less: '<%= basepath.root %>/less',
            js:   '<%= basepath.root %>/js'
        },

        // Set bundle path refs
        bundle: {
            core: {
                root:   'web/bundles/oboscore',
                css:    '<%= bundle.core.root %>/css',
                less:   '<%= bundle.core.root %>/less',
                js:     '<%= bundle.core.root %>/js',
                vendor: '<%= bundle.core.root %>/vendor'
            }
        },

        // Less compiler
        less: {
            options: {
                paths: [
                    'web/bower'
                ]
            },
            dev: {
                files: {
                    '<%= bundle.core.css %>/app.css': '<%= bundle.core.less %>/_*.less'
                }
            },
            prod: {
                options: {
                    compress: true,
                    plugins: [
                        new (require('less-plugin-autoprefix'))({
                            browsers: ["last 2 versions"]
                        })
                    ]
                },
                files: {
                    '<%= bundle.core.css %>/app.css' : '<%= bundle.core.less %>/_*.less'
                }
            }
        },

        // JS uglifier
        uglify: {
            all: {
                files: {
                    '<%= bundle.core.js %>/dist/app.js': [
                        '<%= bundle.core.js %>/src/**/_*.js',
                        '<%= bundle.core.vendor %>/twbs/bootstrap/js/*.js'
                    ]
                }
            }
        },

        // Watcher
        watch: {
            dev: {
                files: [
                    '<%= bundle.core.less %>/**/*',
                    '<%= bundle.core.js %>/src/**/*',
                    '<%= bundle.core.vendor %>/**/*'
                ],
                tasks: ['less:dev', 'uglify:all']
            }
        }
    });

    // Register tasks
    grunt.registerTask('default', ['watch:dev']);
};
