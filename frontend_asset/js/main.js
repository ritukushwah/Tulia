(function($){"use strict";function t(e){O.removeClass("active"),e.addClass("active")}
var b=$(".owl-features"),O=$(".feature-link");b.owlCarousel({loop:!0,responsiveClass:!0,margin:20,autoplay:!0,items:1,nav:!1,dots:!1,animateOut:"slideOutDown",animateIn:"fadeInUp"}),b.on("changed.owl.carousel",function(e){var o=e.item.index+1-e.relatedTarget._clones.length/2,n=e.item.count;(o>n||0==o)&&(o=n-o%n),o--;var a=$(".feature-link:nth("+o+")");t(a)}),O.on("click",function(){var e=$(this).data("owl-item");b.trigger("to.owl.carousel",e),t($(this))}),jQuery(document).ready(function($)
{init_gototop();init_loader();init_pagescroll();init_fullheigh();});function init_gototop()
{if($('#back-to-top').length)
{var scrollTrigger=100,backToTop=function()
{var scrollTop=$(window).scrollTop();if(scrollTop>scrollTrigger)
{$('#back-to-top').addClass('show');}
else
{$('#back-to-top').removeClass('show');}};backToTop();$(window).on('scroll',function()
{backToTop();});$('#back-to-top').on('click',function(e)
{e.preventDefault();$('html,body').animate({scrollTop:0},900);});}}
function init_loader()
{$(".ava-loader-overlay").delay(300).fadeOut("slow");}
$(window).scroll(function(){if($(".navbar").offset().top>0){$(".navbar-fixed-top").addClass("top-nav-collapse");}else{$(".navbar-fixed-top").removeClass("top-nav-collapse");}});function init_pagescroll(){$('a.page-scroll').on('click',function(e){if(location.pathname.replace(/^\//,'')===this.pathname.replace(/^\//,'')&&location.hostname===this.hostname){var target=$(this.hash);target=target.length?target:$('[name='+this.hash.slice(1)+']');if(target.length){$('html,body').animate({scrollTop:target.offset().top},500);return false;}}});}
$(document).ready(function(){$('.navbar-collapse ul li a').click(function(){$('.navbar-toggle:visible').click();});});function init_fullheigh(){$(".full-height").height($(window).height()),$(window).on("resize",function(){$(".full-height").height($(window).height())})}
var MATH_PROPS='E LN10 LN2 LOG2E LOG10E PI SQRT1_2 SQRT2 abs acos asin atan ceil cos exp floor log round sin sqrt tan atan2 pow max min'.split(' ');var HAS_SKETCH='__hasSketch';var M=Math;var CANVAS='canvas';var WEBGL='webgl';var DOM='dom';var doc=document;var win=window;var instances=[];var defaults={fullscreen:true,autostart:true,autoclear:true,autopause:true,container:doc.body,interval:1,globals:true,retina:false,type:CANVAS};var keyMap={8:'BACKSPACE',9:'TAB',13:'ENTER',16:'SHIFT',27:'ESCAPE',32:'SPACE',37:'LEFT',38:'UP',39:'RIGHT',40:'DOWN'};})(jQuery);