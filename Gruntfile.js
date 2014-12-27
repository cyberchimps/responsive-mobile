
module.exports = function(grunt) {

	require('load-grunt-tasks')(grunt);

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		checktextdomain: {
			options:{
				text_domain: '<%= pkg.name %>',
				correct_domain: true,
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'**/*.php',
					'!**/*.scss',
					'!**/class-tgm-plugin-activation.php',
					'!**/wp-updates-theme.php',
					'!node_modules/**',
					'!core/bootstrap/**',
					'!core/**',
					'!build/**',
					'!**/*~'
				],
				expand: true
			}
		},

		makepot: {
			target: {
				options: {
					domainPath: '/languages/',    // Where to save the POT file.
					mainFile: 'style.css',      // Main project file.
					potFilename: '<%= pkg.name %>.pot',   // Name of the POT file.
					type: 'wp-theme',  // Type of project (wp-plugin or wp-theme).
					exclude: ['core/includes/classes/class-tgm-plugin-activation.php', 'core/includes/functions-install.php', 'build/.*'],       // List of files or directories to ignore.
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = 'https://cyberchimps.com/forum/free/responsive/';
						pot.headers['plural-forms'] = 'nplurals=2; plural=n != 1;';
						pot.headers['last-translator'] = 'Ulrich Pogson <ulrich@cyberchimps.com>\n';
						pot.headers['language-team'] = 'CyberChimps Translate <support@cyberchimps.com>\n';
						pot.headers['x-poedit-basepath'] = '.\n';
						pot.headers['x-poedit-language'] = 'English\n';
						pot.headers['x-poedit-country'] = 'UNITED STATES\n';
						pot.headers['x-poedit-sourcecharset'] = 'utf-8\n';
						pot.headers['X-Poedit-KeywordsList'] = '__;_e;__ngettext:1,2;_n:1,2;__ngettext_noop:1,2;_n_noop:1,2;_c,_nc:4c,1,2;_x:1,2c;_ex:1,2c;_nx:4c,1,2;_nx_noop:4c,1,2;\n';
						pot.headers['x-textdomain-support'] = 'yes\n';
						return pot;
					}
				}
			}
		},

		exec: {
			update_po_wti: { // Update WebTranslateIt translation - grunt exec:update_po_wti
				cmd: 'wti pull',
				cwd: 'languages/',
			}
		},

		po2mo: {
			files: {
				src: 'languages/*.po',
				expand: true,
			},
		},

		sass: {
			dist: {
				options: {
					sourcemap: 'none',
					style: 'expanded'
				},
				files: {
					'css/style.css': 'css/sass/style.scss',
					'core/bootstrap/stylesheets/bootstrap.css': 'core/bootstrap/stylesheets/bootstrap.scss',
					'libraries/css/theme-options.css': 'libraries/css/theme-options.scss',
					'core/css/upsell.css': 'core/css/upsell.scss'
				}
			}
		},

		cssflip: {
			rtl: {
				files: {
					'core/bootstrap/stylesheets/bootstrap-rtl.css': 'core/bootstrap/stylesheets/bootstrap.css',
					'css/style-rtl.css': 'css/style.css'
				}
			}
		},

		cssjanus: {
			style: {
				options: {
					swapLtrRtlInUrl: false,
					swapLeftRightInUrl: false
				},
				expand: true,
				ext: '-rtl.css',
				src: [
					'css/style.css',
				]
			},
		},

		cssmin: {
			front: {
				expand: true,
				cwd: 'css/',
				src: ['*.css', '!*.min.css'],
				dest: 'css/',
				ext: '.min.css'
			},
			core: {
				expand: true,
				cwd: 'core/css/',
				src: ['*.css', '!*.min.css'],
				dest: 'core/css/',
				ext: '.min.css'
			},
			libraries: {
				expand: true,
				cwd: 'libraries/css/',
				src: ['*.css', '!*.min.css'],
				dest: 'libraries/css/',
				ext: '.min.css'
			}
		},

		concat: {
			options: {
				//separator: ';',
			},
			bootstrap: {
				src: [
					'core/bootstrap/javascripts/bootstrap/affix.js',
					'core/bootstrap/javascripts/bootstrap/alert.js',
					'core/bootstrap/javascripts/bootstrap/button.js',
					'core/bootstrap/javascripts/bootstrap/carousel.js',
					'core/bootstrap/javascripts/bootstrap/collapse.js',
					'core/bootstrap/javascripts/bootstrap/dropdown.js',
					'core/bootstrap/javascripts/bootstrap/popover.js',
					'core/bootstrap/javascripts/bootstrap/scrollspy.js',
					'core/bootstrap/javascripts/bootstrap/tab.js',
					'core/bootstrap/javascripts/bootstrap/tooltip.js',
					'core/bootstrap/javascripts/bootstrap/transition.js'
				],
				dest: 'core/bootstrap/javascripts/bootstrap.js',
			},
			javascript: {
				src: [
					'core/js/jquery-fitvids.js',
					'core/js/mobile-menu.js',
					'core/js/jquery-placeholder.js',
					'core/js/respond.js',
					'core/js/skip-link-focus-fix.js',
					'core/js/jquery-scroll-top.js'
				],
				dest: 'js/responsive-scripts.js',
			},
		},

		uglify: {
			options: {
				mangle: false
			},
			bootstrap: {
				files: {
					'core/bootstrap/javascripts/bootstrap.min.js': ['core/bootstrap/javascripts/bootstrap.js']
				}
			},
			javascript: {
				files: {
					'js/responsive-scripts.min.js': ['js/responsive-scripts.js'],
					'core/js/jquery-fitvids.min.js': ['core/js/jquery-fitvids.js'],
					'core/js/mobile-menu.min.js': ['core/js/mobile-menu.js'],
					'core/js/jquery-placeholder.min.js': ['core/js/jquery-placeholder.js'],
					'core/js/respond.min.js': ['core/js/respond.js'],
					'core/js/skip-link-focus-fix.min.js': ['core/js/skip-link-focus-fix.js'],
					'core/js/jquery-scroll-top.min.js': ['core/js/jquery-scroll-top.js'],
					'libraries/js/theme-options.min.js': ['libraries/js/theme-options.js']
				}
			},
		},

		watch: {
			scripts: {
				files: ['core/js/*.js'],
				tasks: ['js'],
				options: {
					spawn: false,
				},
			},
			styles: {
				files: ['css/sass/*.scss','core/css/*.scss','core/css/*.css'],
				tasks: ['css'],
				options: {
					spawn: false,
				},
			},
		},

		// Clean up build directory
		clean: {
			main: ['build/<%= pkg.name %>']
		},

		// Copy the theme into the build directory
		copy: {
			main: {
				src:  [
					'**',
					'!core/bootstrap/stylesheets/bootstrap/**',
					'!responsive/css/sass/**',
					'!node_modules/**',
					'!**/wp-updates-theme.php',
					'!build/**',
					'!.git/**',
					'!Gruntfile.js',
					'!package.json',
					'!.gitignore',
					'!.gitmodules',
					'!.wti',
					'!**/*.scss',
					'!/.sass-cache',
					'!**/Gruntfile.js',
					'!**/package.json',
					'!**/README.md',
					'!**/*~'
				],
				dest: 'build/<%= pkg.name %>/'
			}
		},

		//Compress build directory into <name>.zip and <name>-<version>.zip
		compress: {
			main: {
				options: {
					mode: 'zip',
					archive: './build/<%= pkg.name %>.zip'
				},
				expand: true,
				cwd: 'build/<%= pkg.name %>/',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		}

	});

	// Default task(s).
	grunt.registerTask( 'build', [ 'clean', 'copy', 'compress' ] );
	grunt.registerTask( 'css', [ 'sass', 'cssjanus', 'cssmin' ] );
	grunt.registerTask( 'js', [ 'concat', 'uglify' ] );
	grunt.registerTask( 'i18n', [ 'checktextdomain', 'makepot', 'exec', 'po2mo' ] );

};
