const config=require("./wpgulp.config.js"),gulp=require("gulp"),sass=require("gulp-sass"),minifycss=require("gulp-uglifycss"),autoprefixer=require("gulp-autoprefixer"),mmq=require("gulp-merge-media-queries"),rtlcss=require("gulp-rtlcss"),concat=require("gulp-concat"),uglify=require("gulp-uglify"),babel=require("gulp-babel"),imagemin=require("gulp-imagemin"),rename=require("gulp-rename"),lineec=require("gulp-line-ending-corrector"),filter=require("gulp-filter"),sourcemaps=require("gulp-sourcemaps"),notify=require("gulp-notify"),browserSync=require("browser-sync").create(),wpPot=require("gulp-wp-pot"),sort=require("gulp-sort"),cache=require("gulp-cache"),remember=require("gulp-remember"),plumber=require("gulp-plumber"),beep=require("beepbeep"),errorHandler=e=>{notify.onError("\n\n❌  ===> ERROR: <%= error.message %>\n")(e),beep()},browsersync=e=>{browserSync.init({proxy:config.projectURL,open:config.browserAutoOpen,injectChanges:config.injectChanges,watchEvents:["change","add","unlink","addDir","unlinkDir"]}),e()},reload=e=>{browserSync.reload(),e()};gulp.task("styles",()=>gulp.src(config.styleSRC,{allowEmpty:!0}).pipe(plumber(errorHandler)).pipe(sourcemaps.init()).pipe(sass({errLogToConsole:config.errLogToConsole,outputStyle:config.outputStyle,precision:config.precision})).on("error",sass.logError).pipe(sourcemaps.write({includeContent:!1})).pipe(sourcemaps.init({loadMaps:!0})).pipe(autoprefixer(config.BROWSERS_LIST)).pipe(sourcemaps.write("./")).pipe(lineec()).pipe(gulp.dest(config.styleDestination)).pipe(filter("**/*.css")).pipe(mmq({log:!0})).pipe(browserSync.stream()).pipe(rename({suffix:".min"})).pipe(minifycss({maxLineLen:10})).pipe(lineec()).pipe(gulp.dest(config.styleDestination)).pipe(filter("**/*.css")).pipe(browserSync.stream()).pipe(notify({message:"\n\n✅  ===> STYLES — completed!\n",onLast:!0}))),gulp.task("stylesRTL",()=>gulp.src(config.styleSRC,{allowEmpty:!0}).pipe(plumber(errorHandler)).pipe(sourcemaps.init()).pipe(sass({errLogToConsole:config.errLogToConsole,outputStyle:config.outputStyle,precision:config.precision})).on("error",sass.logError).pipe(sourcemaps.write({includeContent:!1})).pipe(sourcemaps.init({loadMaps:!0})).pipe(autoprefixer(config.BROWSERS_LIST)).pipe(lineec()).pipe(rename({suffix:"-rtl"})).pipe(rtlcss()).pipe(sourcemaps.write("./")).pipe(gulp.dest(config.styleDestination)).pipe(filter("**/*.css")).pipe(browserSync.stream()).pipe(mmq({log:!0})).pipe(rename({suffix:".min"})).pipe(minifycss({maxLineLen:10})).pipe(lineec()).pipe(gulp.dest(config.styleDestination)).pipe(filter("**/*.css")).pipe(browserSync.stream()).pipe(notify({message:"\n\n✅  ===> STYLES RTL — completed!\n",onLast:!0}))),gulp.task("vendorsJS",()=>gulp.src(config.jsVendorSRC,{since:gulp.lastRun("vendorsJS")}).pipe(plumber(errorHandler)).pipe(babel({presets:[["@babel/env",{targets:{browsers:config.BROWSERS_LIST}}]]})).pipe(remember(config.jsVendorSRC)).pipe(concat(config.jsVendorFile+".js")).pipe(lineec()).pipe(gulp.dest(config.jsVendorDestination)).pipe(rename({basename:config.jsVendorFile,suffix:".min"})).pipe(uglify()).pipe(lineec()).pipe(gulp.dest(config.jsVendorDestination)).pipe(notify({message:"\n\n✅  ===> VENDOR JS — completed!\n",onLast:!0}))),gulp.task("customJS",()=>gulp.src(config.jsCustomSRC,{since:gulp.lastRun("customJS")}).pipe(plumber(errorHandler)).pipe(babel({presets:[["@babel/preset-env",{targets:{browsers:config.BROWSERS_LIST}}]]})).pipe(remember(config.jsCustomSRC)).pipe(concat(config.jsCustomFile+".js")).pipe(lineec()).pipe(gulp.dest(config.jsCustomDestination)).pipe(rename({basename:config.jsCustomFile,suffix:".min"})).pipe(uglify()).pipe(lineec()).pipe(gulp.dest(config.jsCustomDestination)).pipe(notify({message:"\n\n✅  ===> CUSTOM JS — completed!\n",onLast:!0}))),gulp.task("images",()=>gulp.src(config.imgSRC).pipe(cache(imagemin([imagemin.gifsicle({interlaced:!0}),imagemin.jpegtran({progressive:!0}),imagemin.optipng({optimizationLevel:3}),imagemin.svgo({plugins:[{removeViewBox:!0},{cleanupIDs:!1}]})]))).pipe(gulp.dest(config.imgDST)).pipe(notify({message:"\n\n✅  ===> IMAGES — completed!\n",onLast:!0}))),gulp.task("clearCache",function(e){return cache.clearAll(e)}),gulp.task("translate",()=>gulp.src(config.watchPhp).pipe(sort()).pipe(wpPot({domain:config.textDomain,package:config.packageName,bugReport:config.bugReport,lastTranslator:config.lastTranslator,team:config.team})).pipe(gulp.dest(config.translationDestination+"/"+config.translationFile)).pipe(notify({message:"\n\n✅  ===> TRANSLATE — completed!\n",onLast:!0}))),gulp.task("default",gulp.parallel("styles","vendorsJS","customJS","images",browsersync,()=>{gulp.watch(config.watchPhp,reload),gulp.watch(config.watchTwig,reload),gulp.watch(config.watchStyles,gulp.parallel("styles")),gulp.watch(config.watchJsVendor,gulp.series("vendorsJS",reload)),gulp.watch(config.watchJsCustom,gulp.series("customJS",reload)),gulp.watch(config.imgSRC,gulp.series("images",reload))}));