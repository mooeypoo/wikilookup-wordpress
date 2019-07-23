/* eslint-env node */
module.exports = function Gruntfile( grunt ) {
	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-composer' );

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
			wordpress: [ '_release/trunk', 'vendor' ]
		},

		copy: {
			wordpress: {
				files: [
					{ expand: true, src: [ 'assets/**' ], dest: '_release/trunk/' },
					{ expand: true, src: [ 'includes/**' ], dest: '_release/trunk/' },
					{ expand: true, src: [ 'languages/**' ], dest: '_release/trunk/' },
					{ expand: true, src: [ 'vendor/**' ], dest: '_release/trunk/' },
					{ expand: true, src: [ 'views/**' ], dest: '_release/trunk/' },
					{
						src: [
							'LICENSE',
							'readme.txt',
							'wikilookup.php'
						],
						dest: '_release/trunk/'
					}
				]
			}
		}
	} );

	grunt.registerTask( 'lang', 'makepot' );
	grunt.registerTask( 'deploy', [ 'clean:wordpress', 'composer:install:no-dev', 'copy:wordpress' ] );
};
