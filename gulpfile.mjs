// ESM modules | latest build packages

'use strict';

//
//
// gulp pot
//
// "gulp": "^5.0.0",
// "del": "^8.0.0",
// "gulp-wp-pot": "^2.5.0",
// "gulp-rename": "^2.0.0",
// "gulp-replace": "^1.1.4",
//
//

import gulp from 'gulp'
import {deleteSync} from 'del';
import wpPot from 'gulp-wp-pot'
import replace from 'gulp-replace'
import rename from 'gulp-rename'

const config = {
  "text_domain"       : "rmcc-theme",
  "destFolder"        : "languages",
  "twig_files"        : "views/**/*.twig",
  "php_files"         : "{*.php,inc/*.php,inc/extra/*.php,templates/*.php,views/temp/**/*.php}",
  "cacheFolder"       : "views/temp",
};

const gettext_regex = {
  simple: /(__|_e|translate|esc_attr__|esc_attr_e|esc_html__|esc_html_e)\(\s*?['"].+?['"]\s*?,\s*?['"].+?['"]\s*?\)/g,
  plural: /_n\(\s*?['"].*?['"]\s*?,\s*?['"].*?['"]\s*?,\s*?.+?\s*?,\s*?['"].+?['"]\s*?\)/g,
  disambiguation: /(_x|_ex|_nx|esc_attr_x|esc_html_x)\(\s*?['"].+?['"]\s*?,\s*?['"].+?['"]\s*?,\s*?['"].+?['"]\s*?\)/g,
  noop: /(_n_noop|_nx_noop)\((\s*?['"].+?['"]\s*?),(\s*?['"]\w+?['"]\s*?,){0,1}\s*?['"].+?['"]\s*?\)/g,
};

gulp.task('compile-twig', () => {
  return gulp.src(config.twig_files)
    .pipe(replace(gettext_regex.simple, match => `<?php ${match}; ?>`))
    .pipe(replace(gettext_regex.plural, match => `<?php ${match}; ?>`))
    .pipe(replace(gettext_regex.disambiguation, match => `<?php ${match}; ?>`))
    .pipe(replace(gettext_regex.noop, match => `<?php ${match}; ?>`))
    .pipe(rename({
      extname: '.php',
    }))
    .pipe(gulp.dest(config.cacheFolder));
});

gulp.task('generate-pot', () => {
  const output = gulp.src(config.php_files)
    .pipe(wpPot({
      domain: config.text_domain
    }))
    .pipe(gulp.dest(`${config.destFolder}/${config.text_domain}.pot`))
  return output;
});

gulp.task('clean', async function(){
  return deleteSync([config.cacheFolder+'/**', config.cacheFolder], {force: true});
});

gulp.task('pot', gulp.series('compile-twig', 'generate-pot', 'clean'));

//
//
// gulp style
//
// "sass": "^1.85.1",
// "gulp-sass": "^6.0.1",
// "gulp-postcss": "^10.0.0",
// "autoprefixer": "^10.4.21",
// "cssnano": "^7.0.6",
//
//

import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';

var paths = {
    styles: {
      src: "src/scss/*.scss",
      dest: "src/css/"
    }
};

function style() {
  return gulp
  .src(paths.styles.src)
  .pipe(sass({quietDeps: true, silenceDeprecations: ["legacy-js-api", "import"]}))
  .on("error", sass.logError)
  // .pipe(postcss([autoprefixer(), cssnano()]))
  .pipe(gulp.dest(paths.styles.dest));
}

gulp.task('style', style);
var build = gulp.parallel(style);
gulp.task('build', build);
gulp.task('default', build);