/* eslint-env node */
module.exports = function Gruntfile( grunt ) {
	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-composer' );
	// grunt.loadNpmTasks( 'grunt-concat-with-template' );
	// grunt.loadNpmTasks( 'grunt-template-replace' );
	// grunt.loadNpmTasks('grunt-string-replace');
	grunt.loadNpmTasks('grunt-replace');

	// Initialize config
	grunt.initConfig( {
		makepot: {
			all: {
				options: {
					potFilename: 'wikilookup.pot',
					include: [ 'includes/.*', 'views/.*' ],
					domainPath: '/languages',
					mainFile: 'wikilookup.php',
					type: 'wp-plugin'
				}
			}
		},
		clean: {
			trunk: [ '_release/trunk', 'vendor' ]
		},
		copy: {
			trunk: {
				files: [
					{ expand: true, src: [ 'assets/**' ], dest: '_release/trunk/' },
					{ expand: true, src: [ 'includes/**' ], dest: '_release/trunk/' },
					{ expand: true, src: [ 'languages/**' ], dest: '_release/trunk/' },
					{ expand: true, src: [ 'vendor/**' ], dest: '_release/trunk/' },
					{ expand: true, src: [ 'views/**' ], dest: '_release/trunk/' },
					{
						src: [
							'LICENSE'
						],
						dest: '_release/trunk/'
					}
				]
			},
			tag: {
				files: [
					{ expand: true, src: [ 'assets/**' ], dest: '_release/tags/' + pkg.version + '/' },
					{ expand: true, src: [ 'includes/**' ], dest: '_release/tags/' + pkg.version + '/' },
					{ expand: true, src: [ 'languages/**' ], dest: '_release/tags/' + pkg.version + '/' },
					{ expand: true, src: [ 'vendor/**' ], dest: '_release/tags/' + pkg.version + '/' },
					{ expand: true, src: [ 'views/**' ], dest: '_release/tags/' + pkg.version + '/' },
					{
						src: [
							'LICENSE'
						],
						dest: '_release/tags/' + pkg.version + '/'
					}
				]
			}
		},
		replace: {
			trunk: {
				files: [
					{
						src: 'readme.txt',
						dest: '_release/trunk/readme.txt'
					},
					{
						src: 'wikilookup.php',
						dest: '_release/trunk/wikilookup.php'
					}
				],
				options: {
					patterns: [
						{
							match: 'currentTag',
							replacement:  pkg.version
						}
					]
				}
			},
			tag: {
				files: [
					{
						src: 'readme.txt',
						dest: '_release/tags/' + pkg.version + '/readme.txt'
					},
					{
						src: 'wikilookup.php',
						dest: '_release/tags/' + pkg.version + '/wikilookup.php'
					}
				],
				options: {
					patterns: [
						{
							match: 'currentTag',
							replacement:  pkg.version
						}
					]
				}
			}
		}
	} );

	grunt.registerTask( 'lang', 'makepot' );
	grunt.registerTask( 'trunk', [ 'clean:trunk', 'composer:install:no-dev', 'copy:trunk', 'replace:trunk' ] );
	grunt.registerTask( 'releaseTag', [ 'copy:tag', 'replace:tag' ] );
};
