/* eslint-env node */
module.exports = function Gruntfile( grunt ) {
	var pkg = grunt.file.readJSON( 'package.json' ),
		getReleasableAssets = function ( destination ) {
			var list = [],
				folders = [ 'assets', 'includes', 'languages', 'views', 'vendor' ],
				files = [ 'LICENSE', 'changelog.txt' ];

			folders.forEach( function ( folder ) {
				list.push( {
					expand: true, src: [ folder + '/**' ], dest: destination
				} );
			} );

			list.push( {
				src: files,
				dest: destination
			} );

			return list;
		};

	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-composer' );
	grunt.loadNpmTasks( 'grunt-replace' );

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
				files: getReleasableAssets( '_release/trunk/' ),
			},
			tag: {
				files: getReleasableAssets( '_release/tags/' + pkg.version + '/' )
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
	grunt.registerTask( 'tag', [ 'copy:tag', 'replace:tag' ] );
};
