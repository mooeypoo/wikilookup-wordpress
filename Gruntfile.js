/* eslint-env node */
module.exports = function Gruntfile( grunt ) {
	var pkg = grunt.file.readJSON( 'package.json' );

		grunt.loadNpmTasks( 'grunt-wp-i18n' );

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
		}
	} );

	grunt.registerTask( 'default', 'makepot' );
};
