const fs = require('fs');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

let moduleStatus = fs.readFileSync('modules_statuses.json')
moduleStatus = JSON.parse(moduleStatus)

const moduleFolder = './modules'

const dirs = p => fs.readdirSync(p).filter(f => fs.statSync(path.resolve(p,f)).isDirectory())

let modules = dirs(moduleFolder)

modules.forEach(function(m){
    if(moduleStatus[m] === true)
    {
        /**
         * if module active
         */
        let js = path.resolve(moduleFolder,m,'webpack.mix.js');
        require(js);
    }
});
