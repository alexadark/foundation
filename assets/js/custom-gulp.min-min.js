"use strict";var _utilities=require("./_utilities"),trigger=(0,_utilities.$)(".header-menu__trigger"),nav=(0,_utilities.$)(".nav-main"),openMenu=function(){return nav.classList.toggle("hidden")};trigger.on("click",openMenu),Object.defineProperty(exports,"__esModule",{value:!0}),exports.$$=exports.$=void 0;var $=document.querySelector.bind(document);exports.$=$;var $$=document.querySelectorAll.bind(document);exports.$$=$$,Node.prototype.on=window.on=function(e,t){this.addEventListener(e,t)},NodeList.prototype.__proto__=Array.prototype,NodeList.prototype.on=NodeList.prototype.addEventListener=function(e,t){this.forEach(function(o){o.on(e,t)})},require("./_slide-menu.js");