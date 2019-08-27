/*vticker*/!function(t){var e={speed:700,pause:4e3,showItems:1,mousePause:!0,height:0,animate:!0,margin:0,padding:0,startPaused:!1},i={moveUp:function(t,e){i.animate(t,e,"up")},moveDown:function(t,e){i.animate(t,e,"down")},animate:function(e,i,a){var n=e.itemHeight,s=e.options,r=e.element.children("ul"),l="up"===a?"li:first":"li:last",o=r.children(l).clone(!0);if(s.height>0&&(n=r.children("li:first").height()),n+=s.margin+2*s.padding,"down"===a&&r.css("top","-"+n+"px").prepend(o),i&&i.animate){if(e.animating)return;e.animating=!0;var d="up"===a?{top:"-="+n+"px"}:{top:0};r.animate(d,s.speed,function(){t(r).children(l).remove(),t(r).css("top","0px"),e.animating=!1})}else r.children(l).remove(),r.css("top","0px");"up"===a&&o.appendTo(r)},nextUsePause:function(){var e=t(this).data("state"),i=e.options;e.isPaused||e.itemCount<2||a.next.call(this,{animate:i.animate})},startInterval:function(){var e=t(this).data("state"),a=e.options,n=this;e.intervalId=setInterval(function(){i.nextUsePause.call(n)},a.pause)},stopInterval:function(){var e=t(this).data("state");e&&(e.intervalId&&clearInterval(e.intervalId),e.intervalId=void 0)},restartInterval:function(){i.stopInterval.call(this),i.startInterval.call(this)}},a={init:function(n){a.stop.call(this);var s=jQuery.extend({},e),r=(n=t.extend(s,n),t(this)),l={itemCount:r.children("ul").children("li").length,itemHeight:0,itemMargin:0,element:r,animating:!1,options:n,isPaused:!!n.startPaused,pausedByCode:!1};if(t(this).data("state",l),r.css({overflow:"hidden",position:"relative"}).children("ul").css({position:"absolute",margin:0,padding:0}).children("li").css({margin:n.margin,padding:n.padding}),isNaN(n.height)||0===n.height){r.children("ul").children("li").each(function(){var e=t(this);e.height()>l.itemHeight&&(l.itemHeight=e.height())}),r.children("ul").children("li").each(function(){t(this).height(l.itemHeight)});var o=n.margin+2*n.padding;r.height((l.itemHeight+o)*n.showItems+n.margin)}else r.height(n.height);var d=this;n.startPaused||i.startInterval.call(d),n.mousePause&&r.bind("mouseenter",function(){!0!==l.isPaused&&(l.pausedByCode=!0,i.stopInterval.call(d),a.pause.call(d,!0))}).bind("mouseleave",function(){(!0!==l.isPaused||l.pausedByCode)&&(l.pausedByCode=!1,a.pause.call(d,!1),i.startInterval.call(d))})},pause:function(e){var i=t(this).data("state");if(i){if(i.itemCount<2)return!1;i.isPaused=e,e?t(this).addClass("paused"):t(this).removeClass("paused")}},next:function(e){var a=t(this).data("state");if(a){if(a.animating||a.itemCount<2)return!1;i.restartInterval.call(this),i.moveUp(a,e)}},prev:function(e){var a=t(this).data("state");if(a){if(a.animating||a.itemCount<2)return!1;i.restartInterval.call(this),i.moveDown(a,e)}},stop:function(){t(this).data("state")&&i.stopInterval.call(this)},remove:function(){var e=t(this).data("state");if(e){i.stopInterval.call(this);var a=e.element;a.unbind(),a.remove()}}};t.fn.vTicker=function(e){return a[e]?a[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?void t.error("Method "+e+" does not exist on jQuery.vTicker"):a.init.apply(this,arguments)}}(jQuery);