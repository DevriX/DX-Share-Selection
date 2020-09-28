module.exports = function( grunt ) {
	// Project configuration.
	grunt.initConfig( {
		watch: {
			scripts: {
				files: ['assets/js/*.js'],
				tasks: ['uglify'],
			},
			css: {
				files: 'assets/css/*.css',
				tasks: ['cssmin'],
			},
		},
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: [{
					expand: true,
					cwd: 'assets/css',
					src: ['*.css', '!*.min.css'],
					dest: 'assets/dist/css',
					ext: '.min.css'
				}]
			}
		},
		uglify: {
			target: {
				files: [{
					expand: true,
					cwd: 'assets/js',
					src: ['*.js', '!*.min.js'],
					dest: 'assets/dist/js',
					ext: '.min.js'
				}],
			},
		},
	} );

	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );

	grunt.registerTask( 'default', ['watch'] );
	grunt.registerTask('css', ['cssmin']);
	grunt.registerTask('js', ['uglify']);
	grunt.registerTask('minify', ['cssmin']);
	grunt.registerTask('minifyjs', ['uglify']);
};
