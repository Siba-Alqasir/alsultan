const mix = require('laravel-mix')
const exec = require('child_process').exec
require('dotenv').config()

const glob = require('glob')
const path = require('path')

function mixAssetsDir(query, cb) {
  ;(glob.sync('resources/' + query) || []).forEach(f => {
    f = f.replace(/[\\\/]+/g, '/')
    cb(f, f.replace('resources', 'public/admin-assets/'))
  })
}

const sassOptions = {
  precision: 5,
  includePaths: ['node_modules', 'resources/assets/']
}

// plugins Core stylesheets
mixAssetsDir('sass/base/plugins/**/!(_)*.scss', (src, dest) =>
  mix.sass(src, dest.replace(/(\\|\/)sass(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions })
)

// pages Core stylesheets
mixAssetsDir('sass/base/pages/**/!(_)*.scss', (src, dest) =>
  mix.sass(src, dest.replace(/(\\|\/)sass(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions })
)

// Core stylesheets
mixAssetsDir('sass/base/core/**/!(_)*.scss', (src, dest) =>
  mix.sass(src, dest.replace(/(\\|\/)sass(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions })
)

// script js
mixAssetsDir('js/scripts/**/*.js', (src, dest) => mix.scripts(src, dest))

mixAssetsDir('vendors/js/**/*.js', (src, dest) => mix.scripts(src, dest))
mixAssetsDir('vendors/css/**/*.css', (src, dest) => mix.copy(src, dest))
mixAssetsDir('vendors/**/**/images', (src, dest) => mix.copy(src, dest))
mixAssetsDir('vendors/css/editors/quill/fonts/', (src, dest) => mix.copy(src, dest))
mixAssetsDir('fonts', (src, dest) => mix.copy(src, dest))
mixAssetsDir('fonts/**/**/*.css', (src, dest) => mix.copy(src, dest))
mix.copyDirectory('resources/images', 'public/admin-assets/images')
mix.copyDirectory('resources/data', 'public/admin-assets/data')
mix.copyDirectory('resources/assets/summernote', 'public/admin-assets/summernote')

mix.js('resources/js/core/app-menu.js', 'public/admin-assets/js/core')
  .js('resources/js/core/app.js', 'public/admin-assets/js/core')
  .js('resources/assets/js/scripts.js', 'public/admin-assets/js/core')
  .sass('resources/sass/core.scss', 'public/admin-assets/css', { sassOptions })
  .sass('resources/sass/overrides.scss', 'public/admin-assets/css', { sassOptions })
  .sass('resources/sass/base/custom-rtl.scss', 'public/admin-assets/css-rtl', { sassOptions })
  .sass('resources/assets/scss/style-rtl.scss', 'public/admin-assets/css-rtl', { sassOptions })
  .sass('resources/assets/scss/style.scss', 'public/admin-assets/css', { sassOptions })

mix.then(() => {
  if (process.env.MIX_CONTENT_DIRECTION === 'rtl') {
    let command = `node ${path.resolve('node_modules/rtlcss/bin/rtlcss.js')} -d -e ".css" ./public/admin-assets/css/ ./public/admin-assets/css/`
    exec(command, function (err, stdout, stderr) {
      if (err !== null) {
        console.log(err)
      }
    })
  }
})
