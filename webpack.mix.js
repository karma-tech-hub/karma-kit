const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-banner');

const pkg = require('./package.json');
const fs = require('fs');
const path = require('path');
const isFile = (pathItem) => !!path.extname(pathItem);
const isScss = (pathItem) =>  '.scss' === path.extname(pathItem);
const isJs = (pathItem) =>  '.js' === path.extname(pathItem);

const mapModules = (fromDir) => {
    const dirs = fs.readdirSync(fromDir, 'utf8');

    dirs.forEach((subDir) => {
        const f = `${fromDir}/${subDir}`;
        let output = f;

        if (isFile(f)){
            if (isScss(f) && f.includes('src')){
                output = output.replace('src', 'css').replace('/scss', '').replace('.scss', '.css')
                mix.sass(f, output)
            }
            if (isJs(f) && f.includes('src')){
                output = output.replace('src', 'js')
                mix.js(f, output)
            }
        }else{
            mapModules(`${fromDir}/${subDir}`)
        }
    })
}

mapModules('widgets')

mix.options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .webpackConfig({
        externals: {
            "jquery": "jQuery"
        }
    })
    .banner({
        banner: (function () {
            return [
                '/**',
                ' * @project        Karma Kit',
                ' * @author         Karma Team',
                ' * @website        https://karamtechhub.com',
                ' * @version       ' + pkg.version,
                ' *',
                ' */',
                '',
            ].join('\n');
        })(),
        raw: true,
    })
    .disableNotifications();


