try{!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof exports?t(require("jquery")):t(jQuery)}(function(l){"use strict";var i,e=l(window),h=l(document),a=window.location,D=!0,W=!1,r=null,n="undefined",o="directive",t=".cropper",d=/^(e|n|w|s|ne|nw|sw|se|all|crop|move|zoom)$/,g=/^(x|y|width|height)$/,s=/^(naturalWidth|naturalHeight|width|height|aspectRatio|ratio|rotate)$/,p="cropper-modal",H="cropper-hidden",c="cropper-invisible",f="cropper-crop",m="cropper-disabled",u="mousedown touchstart",w="mousemove touchmove",v="mouseup mouseleave touchend touchleave touchcancel",x="wheel mousewheel DOMMouseScroll",b="resize"+t,y="dblclick",$="build"+t,C="built"+t,k="dragstart"+t,R="dragmove"+t,z="dragend"+t,L=function(t){return"number"==typeof t},Y=function(t,i){var e=[];return"number"==typeof i&&e.push(i),e.slice.apply(t,e)},X=function(t,i){var e=Y(arguments,2);return function(){return t.apply(i,e.concat(Y(arguments)))}},M=function(t,i){this.element=t,this.$element=l(t),this.defaults=l.extend({},M.DEFAULTS,l.isPlainObject(i)?i:{}),this.$original=r,this.ready=W,this.built=W,this.cropped=W,this.rotated=W,this.disabled=W,this.replaced=W,this.init()},T=Math.sqrt,I=Math.min,E=Math.max,_=Math.abs,P=Math.sin,O=Math.cos,U=parseFloat;M.prototype={constructor:M,support:{canvas:l.isFunction(l("<canvas>")[0].getContext)},init:function(){var e=this.defaults;l.each(e,function(t,i){switch(t){case"aspectRatio":e[t]=_(U(i))||NaN;break;case"autoCropArea":e[t]=_(U(i))||.8;break;case"minWidth":case"minHeight":e[t]=_(U(i))||0;break;case"maxWidth":case"maxHeight":e[t]=_(U(i))||1/0}}),this.image={rotate:0},this.load()},load:function(){var t,i,e=this,h=this.$element,a=this.element,s=this.image,r="";h.is("img")?i=h.prop("src"):h.is("canvas")&&this.support.canvas&&(i=a.toDataURL()),i&&(this.replaced&&(s.rotate=0),this.defaults.checkImageOrigin&&(h.prop("crossOrigin")||this.isCrossOriginURL(i))&&(r=" crossOrigin"),this.$clone=t=l("<img"+r+' src="'+i+'">'),t.one("load",function(){s.naturalWidth=this.naturalWidth||t.width(),s.naturalHeight=this.naturalHeight||t.height(),s.aspectRatio=s.naturalWidth/s.naturalHeight,e.url=i,e.ready=D,e.build()}),t.addClass(c).prependTo("body"))},isCrossOriginURL:function(t){var i=t.match(/^(https?:)\/\/([^\:\/\?#]+):?(\d*)/i);return!i||i[1]===a.protocol&&i[2]===a.hostname&&i[3]===a.port?W:D},build:function(){var t,i,e=this.$element,h=this.defaults;this.ready&&(this.built&&this.unbuild(),e.one($,h.build),t=l.Event($),e.trigger(t),t.isDefaultPrevented()||(this.$cropper=i=l(M.TEMPLATE),e.addClass(H),this.$clone.removeClass(c).prependTo(i),this.rotated||(this.$original=this.$clone.clone(),this.$original.addClass(H).prependTo(this.$cropper),this.originalImage=l.extend({},this.image)),this.$container=e.parent(),this.$container.append(i),this.$canvas=i.find(".cropper-canvas"),this.$dragger=i.find(".cropper-dragger"),this.$viewer=i.find(".cropper-viewer"),h.autoCrop?this.cropped=D:this.$dragger.addClass(H),h.dragCrop&&this.setDragMode("crop"),h.modal&&this.$canvas.addClass(p),!h.dashed&&this.$dragger.find(".cropper-dashed").addClass(H),!h.movable&&this.$dragger.find(".cropper-face").data(o,"move"),!h.resizable&&this.$dragger.find(".cropper-line, .cropper-point").addClass(H),this.addListeners(),this.initPreview(),this.built=D,this.update(),this.replaced=W,e.one(C,h.built),e.trigger(C)))},unbuild:function(){this.built&&(this.built=W,this.removeListeners(),this.$preview.empty(),this.$preview=r,this.$dragger=r,this.$canvas=r,this.$container=r,this.$cropper.remove(),this.$cropper=r)},update:function(t){this.initContainer(),this.initCropper(),this.initImage(),this.initDragger(),t?(this.setData(t,D),this.setDragMode("crop")):this.setData(this.defaults.data)},resize:function(){clearTimeout(this.resizing),this.resizing=setTimeout(l.proxy(this.update,this,this.getData()),200)},preview:function(){var t=this.image,e=this.dragger,h=t.width,a=t.height,s=e.left-t.left,r=e.top-t.top;this.$viewer.find("img").css({width:h,height:a,marginLeft:-s,marginTop:-r}),this.$preview.each(function(){var t=l(this),i=t.width()/e.width;t.find("img").css({width:h*i,height:a*i,marginLeft:-s*i,marginTop:-r*i})})},addListeners:function(){var t=this.defaults;this.$element.on(k,t.dragstart).on(R,t.dragmove).on(z,t.dragend),this.$cropper.on(u,l.proxy(this.dragstart,this)).on(y,l.proxy(this.dblclick,this)),t.zoomable&&this.$cropper.on(x,l.proxy(this.wheel,this)),t.multiple?this.$cropper.on(w,l.proxy(this.dragmove,this)).on(v,l.proxy(this.dragend,this)):h.on(w,this._dragmove=X(this.dragmove,this)).on(v,this._dragend=X(this.dragend,this)),e.on(b,this._resize=X(this.resize,this))},removeListeners:function(){var t=this.defaults;this.$element.off(k,t.dragstart).off(R,t.dragmove).off(z,t.dragend),this.$cropper.off(u,this.dragstart).off(y,this.dblclick),t.zoomable&&this.$cropper.off(x,this.wheel),t.multiple?this.$cropper.off(w,this.dragmove).off(v,this.dragend):h.off(w,this._dragmove).off(v,this._dragend),e.off(b,this._resize)},initPreview:function(){var t='<img src="'+this.url+'">';this.$preview=l(this.defaults.preview),this.$viewer.html(t),this.$preview.html(t).find("img").css("cssText","min-width:0!important;min-height:0!important;max-width:none!important;max-height:none!important;")},initContainer:function(){var t=this.$container;t!==r&&(this.container={width:E(t.width(),300),height:E(t.height(),150)})},initCropper:function(){var t,i=this.container,e=this.image;0<=e.naturalWidth*i.height/e.naturalHeight-i.width?(t={width:i.width,height:i.width/e.aspectRatio,left:0}).top=(i.height-t.height)/2:(t={width:i.height*e.aspectRatio,height:i.height,top:0}).left=(i.width-t.width)/2,this.$cropper&&this.$cropper.css({width:t.width,height:t.height,left:t.left,top:t.top}),this.cropper=t},initImage:function(){var t=this.image,i=this.cropper,e={_width:i.width,_height:i.height,width:i.width,height:i.height,left:0,top:0,ratio:i.width/t.naturalWidth};this.defaultImage=l.extend({},t,e),t._width!==i.width||t._height!==i.height?l.extend(t,e):(t=l.extend({},e,t),this.replaced&&(t.ratio=e.ratio)),this.image=t,this.renderImage()},renderImage:function(t){var i=this.image;"zoom"===t&&(i.left-=(i.width-i.oldWidth)/2,i.top-=(i.height-i.oldHeight)/2),i.left=I(E(i.left,i._width-i.width),0),i.top=I(E(i.top,i._height-i.height),0),this.$clone.css({width:i.width,height:i.height,marginLeft:i.left,marginTop:i.top}),t&&(this.defaults.done(this.getData()),this.preview())},initDragger:function(){var t,i=this.defaults,e=this.cropper,h=i.aspectRatio||this.image.aspectRatio,a=this.image.ratio;(t=0<=e.height*h-e.width?{height:e.width/h,width:e.width,left:0,top:(e.height-e.width/h)/2,maxWidth:e.width,maxHeight:e.width/h}:{height:e.height,width:e.height*h,left:(e.width-e.height*h)/2,top:0,maxWidth:e.height*h,maxHeight:e.height}).minWidth=0,t.minHeight=0,i.aspectRatio?(isFinite(i.maxWidth)?(t.maxWidth=I(t.maxWidth,i.maxWidth*a),t.maxHeight=t.maxWidth/h):isFinite(i.maxHeight)&&(t.maxHeight=I(t.maxHeight,i.maxHeight*a),t.maxWidth=t.maxHeight*h),0<i.minWidth?(t.minWidth=E(0,i.minWidth*a),t.minHeight=t.minWidth/h):0<i.minHeight&&(t.minHeight=E(0,i.minHeight*a),t.minWidth=t.minHeight*h)):(t.maxWidth=I(t.maxWidth,i.maxWidth*a),t.maxHeight=I(t.maxHeight,i.maxHeight*a),t.minWidth=E(0,i.minWidth*a),t.minHeight=E(0,i.minHeight*a)),t.minWidth=I(t.maxWidth,t.minWidth),t.minHeight=I(t.maxHeight,t.minHeight),t.height*=i.autoCropArea,t.width*=i.autoCropArea,t.left=(e.width-t.width)/2,t.top=(e.height-t.height)/2,t.oldLeft=t.left,t.oldTop=t.top,this.defaultDragger=t,this.dragger=l.extend({},t)},renderDragger:function(){var t=this.dragger,i=this.cropper;t.width>t.maxWidth?(t.width=t.maxWidth,t.left=t.oldLeft):t.width<t.minWidth&&(t.width=t.minWidth,t.left=t.oldLeft),t.height>t.maxHeight?(t.height=t.maxHeight,t.top=t.oldTop):t.height<t.minHeight&&(t.height=t.minHeight,t.top=t.oldTop),t.left=I(E(t.left,0),i.width-t.width),t.top=I(E(t.top,0),i.height-t.height),t.oldLeft=t.left,t.oldTop=t.top,this.dragger=t,this.disabled||this.defaults.done(this.getData()),this.$dragger.css({width:t.width,height:t.height,left:t.left,top:t.top}),this.preview()},reset:function(t){this.cropped&&(t&&(this.defaults.data={}),this.image=l.extend({},this.defaultImage),this.renderImage(),this.dragger=l.extend({},this.defaultDragger),this.setData(this.defaults.data))},clear:function(){this.cropped&&(this.cropped=W,this.setData({x:0,y:0,width:0,height:0}),this.$canvas.removeClass(p),this.$dragger.addClass(H))},destroy:function(){var t=this.$element;this.ready&&(this.unbuild(),t.removeClass(H).removeData("cropper"),this.rotated&&t.attr("src",this.$original.attr("src")))},replace:function(t,i){var e,h=this,a=this.$element,s=this.element;t&&t!==this.url&&t!==a.attr("src")&&(i||(this.rotated=W,this.replaced=D),a.is("img")?(a.attr("src",t),this.load()):a.is("canvas")&&this.support.canvas&&(e=s.getContext("2d"),l('<img src="'+t+'">').one("load",function(){s.width=this.width,s.height=this.height,e.clearRect(0,0,s.width,s.height),e.drawImage(this,0,0),h.load()})))},setData:function(t,i){var e=this.cropper,h=this.dragger,a=this.image,s=this.defaults.aspectRatio;this.built&&typeof t!==n&&((t===r||l.isEmptyObject(t))&&(h=l.extend({},this.defaultDragger)),l.isPlainObject(t)&&!l.isEmptyObject(t)&&(i||(this.defaults.data=t),t=this.transformData(t),L(t.x)&&t.x<=e.width-a.left&&(h.left=t.x+a.left),L(t.y)&&t.y<=e.height-a.top&&(h.top=t.y+a.top),s?L(t.width)&&t.width<=h.maxWidth&&t.width>=h.minWidth?(h.width=t.width,h.height=h.width/s):L(t.height)&&t.height<=h.maxHeight&&t.height>=h.minHeight&&(h.height=t.height,h.width=h.height*s):(L(t.width)&&t.width<=h.maxWidth&&t.width>=h.minWidth&&(h.width=t.width),L(t.height)&&t.height<=h.maxHeight&&t.height>=h.minHeight&&(h.height=t.height))),this.dragger=h,this.renderDragger())},getData:function(t){var i=this.dragger,e=this.image,h={};return this.built&&(h={x:i.left-e.left,y:i.top-e.top,width:i.width,height:i.height},h=this.transformData(h,D,t)),h},transformData:function(t,e,h){var a=this.image.ratio,s={};return l.each(t,function(t,i){i=U(i),g.test(t)&&!isNaN(i)&&(s[t]=e?h?Math.round(i/a):i/a:i*a)}),s},setAspectRatio:function(t){var i="auto"===t;t=U(t),(i||!isNaN(t)&&0<t)&&(this.defaults.aspectRatio=i?NaN:t,this.built&&(this.initDragger(),this.renderDragger()))},getImageData:function(){var e={};return this.ready&&l.each(this.image,function(t,i){s.test(t)&&(e[t]=i)}),e},getDataURL:function(t,i,e){var h,a=l("<canvas>")[0],s=this.getData(),r="";return l.isPlainObject(t)||(e=i,i=t,t={}),t=l.extend({width:s.width,height:s.height},t),this.cropped&&this.support.canvas&&(a.width=t.width,a.height=t.height,h=a.getContext("2d"),"image/jpeg"===i&&(h.fillStyle="#fff",h.fillRect(0,0,t.width,t.height)),h.drawImage(this.$clone[0],s.x,s.y,s.width,s.height,0,0,t.width,t.height),r=a.toDataURL(i,e)),r},setDragMode:function(t){var i=this.$canvas,e=this.defaults,h=W,a=W;if(this.built&&!this.disabled){switch(t){case"crop":e.dragCrop&&(h=D,i.data(o,t));break;case"move":a=D,i.data(o,t);break;default:i.removeData(o)}i.toggleClass(f,h).toggleClass("cropper-move",a)}},enable:function(){this.built&&(this.disabled=W,this.$cropper.removeClass(m))},disable:function(){this.built&&(this.disabled=D,this.$cropper.addClass(m))},rotate:function(t){var i=this.image;t=U(t)||0,this.built&&0!==t&&!this.disabled&&this.defaults.rotatable&&this.support.canvas&&(this.rotated=D,t=i.rotate=(i.rotate+t)%360,this.replace(this.getRotatedDataURL(t),!0))},getRotatedDataURL:function(t){var i=l("<canvas>")[0],e=i.getContext("2d"),h=t*Math.PI/180,a=_(t)%180,s=(90<a?180-a:a)*Math.PI/180,r=this.originalImage,n=r.naturalWidth,o=r.naturalHeight,d=_(n*O(s)+o*P(s)),g=_(n*P(s)+o*O(s));return i.width=d,i.height=g,e.save(),e.translate(d/2,g/2),e.rotate(h),e.drawImage(this.$original[0],-n/2,-o/2,n,o),e.restore(),i.toDataURL()},zoom:function(t){var i,e,h,a=this.image;t=U(t),this.built&&t&&!this.disabled&&this.defaults.zoomable&&(i=a.width*(1+t),e=a.height*(1+t),10<(h=i/a._width)||(h<1&&(i=a._width,e=a._height),h<=1?this.setDragMode("crop"):this.setDragMode("move"),a.oldWidth=a.width,a.oldHeight=a.height,a.width=i,a.height=e,a.ratio=a.width/a.naturalWidth,this.renderImage("zoom")))},dblclick:function(){this.disabled||(this.$canvas.hasClass(f)?this.setDragMode("move"):this.setDragMode("crop"))},wheel:function(t){var i,e=t.originalEvent;this.disabled||(t.preventDefault(),i=e.deltaY?(i=e.deltaY)%5==0?i/5:i%117.25==0?i/117.25:i/166.66665649414062:e.wheelDelta?-e.wheelDelta/120:e.detail?e.detail/3:0,this.zoom(.1*i))},dragstart:function(t){var i,e,h,a=t.originalEvent.touches,s=t;if(!this.disabled){if(a){if(1<(h=a.length)){if(!this.defaults.zoomable||2!==h)return;s=a[1],this.startX2=s.pageX,this.startY2=s.pageY,i="zoom"}s=a[0]}if(i=i||l(s.target).data(o),d.test(i)){if(t.preventDefault(),e=l.Event(k),this.$element.trigger(e),e.isDefaultPrevented())return;this.directive=i,this.cropping=W,this.startX=s.pageX,this.startY=s.pageY,"crop"===i&&(this.cropping=D,this.$canvas.addClass(p))}}},dragmove:function(t){var i,e,h=t.originalEvent.touches,a=t;if(!this.disabled){if(h){if(1<(e=h.length)){if(!this.defaults.zoomable||2!==e)return;a=h[1],this.endX2=a.pageX,this.endY2=a.pageY}a=h[0]}if(this.directive){if(t.preventDefault(),i=l.Event(R),this.$element.trigger(i),i.isDefaultPrevented())return;this.endX=a.pageX,this.endY=a.pageY,this.dragging()}}},dragend:function(t){var i;if(!this.disabled&&this.directive){if(t.preventDefault(),i=l.Event(z),this.$element.trigger(i),i.isDefaultPrevented())return;this.cropping&&(this.cropping=W,this.$canvas.toggleClass(p,this.cropped&&this.defaults.modal)),this.directive=""}},dragging:function(){var t,i,e,h,a,s,r,n=this.directive,o=this.image,d=this.cropper,g=d.width,l=d.height,p=this.dragger,c=p.width,f=p.height,m=p.left,u=p.top,w=m+c,v=u+f,x=D,b=this.defaults,y=b.aspectRatio,$={x:this.endX-this.startX,y:this.endY-this.startY};switch(y&&($.X=$.y*y,$.Y=$.x/y),n){case"all":m+=$.x,u+=$.y;break;case"e":if(0<=$.x&&(g<=w||y&&(u<=0||l<=v))){x=W;break}c+=$.x,y&&(f=c/y,u-=$.Y/2),c<0&&(n="w",c=0);break;case"n":if($.y<=0&&(u<=0||y&&(m<=0||g<=w))){x=W;break}f-=$.y,u+=$.y,y&&(c=f*y,m+=$.X/2),f<0&&(n="s",f=0);break;case"w":if($.x<=0&&(m<=0||y&&(u<=0||l<=v))){x=W;break}c-=$.x,m+=$.x,y&&(f=c/y,u+=$.Y/2),c<0&&(n="e",c=0);break;case"s":if(0<=$.y&&(l<=v||y&&(m<=0||g<=w))){x=W;break}f+=$.y,y&&(c=f*y,m-=$.X/2),f<0&&(n="n",f=0);break;case"ne":if(y){if($.y<=0&&(u<=0||g<=w)){x=W;break}f-=$.y,u+=$.y,c=f*y}else 0<=$.x?w<g?c+=$.x:$.y<=0&&u<=0&&(x=W):c+=$.x,$.y<=0?0<u&&(f-=$.y,u+=$.y):(f-=$.y,u+=$.y);f<0&&(n="sw",c=f=0);break;case"nw":if(y){if($.y<=0&&(u<=0||m<=0)){x=W;break}f-=$.y,u+=$.y,c=f*y,m+=$.X}else $.x<=0?0<m?(c-=$.x,m+=$.x):$.y<=0&&u<=0&&(x=W):(c-=$.x,m+=$.x),$.y<=0?0<u&&(f-=$.y,u+=$.y):(f-=$.y,u+=$.y);f<0&&(n="se",c=f=0);break;case"sw":if(y){if($.x<=0&&(m<=0||l<=v)){x=W;break}c-=$.x,m+=$.x,f=c/y}else $.x<=0?0<m?(c-=$.x,m+=$.x):0<=$.y&&l<=v&&(x=W):(c-=$.x,m+=$.x),0<=$.y?v<l&&(f+=$.y):f+=$.y;c<0&&(n="ne",c=f=0);break;case"se":if(y){if(0<=$.x&&(g<=w||l<=v)){x=W;break}f=(c+=$.x)/y}else 0<=$.x?w<g?c+=$.x:0<=$.y&&l<=v&&(x=W):c+=$.x,0<=$.y?v<l&&(f+=$.y):f+=$.y;c<0&&(n="nw",c=f=0);break;case"move":o.left+=$.x,o.top+=$.y,this.renderImage("move"),x=W;break;case"zoom":b.zoomable&&(this.zoom((i=o.width,e=o.height,h=_(this.startX-this.startX2),a=_(this.startY-this.startY2),s=_(this.endX-this.endX2),r=_(this.endY-this.endY2),(T(s*s+r*r)-T(h*h+a*a))/T(i*i+e*e))),this.endX2=this.startX2,this.endY2=this.startY2);break;case"crop":$.x&&$.y&&(t=this.$cropper.offset(),m=this.startX-t.left,u=this.startY-t.top,c=p.minWidth,f=p.minHeight,0<$.x?0<$.y?n="se":(n="ne",u-=f):0<$.y?(n="sw",m-=c):(n="nw",m-=c,u-=f),this.cropped||(this.cropped=D,this.$dragger.removeClass(H)))}x&&(p.width=c,p.height=f,p.left=m,p.top=u,this.directive=n,this.renderDragger()),this.startX=this.endX,this.startY=this.endY}},M.TEMPLATE=(i=(i="div,span,directive,data,point,cropper,class,line,dashed").split(","),'<0 6="5-container"><0 6="5-canvas"></0><0 6="5-dragger"><1 6="5-viewer"></1><1 6="5-8 8-h"></1><1 6="5-8 8-v"></1><1 6="5-face" 3-2="all"></1><1 6="5-7 7-e" 3-2="e"></1><1 6="5-7 7-n" 3-2="n"></1><1 6="5-7 7-w" 3-2="w"></1><1 6="5-7 7-s" 3-2="s"></1><1 6="5-4 4-e" 3-2="e"></1><1 6="5-4 4-n" 3-2="n"></1><1 6="5-4 4-w" 3-2="w"></1><1 6="5-4 4-s" 3-2="s"></1><1 6="5-4 4-ne" 3-2="ne"></1><1 6="5-4 4-nw" 3-2="nw"></1><1 6="5-4 4-sw" 3-2="sw"></1><1 6="5-4 4-se" 3-2="se"></1></0></0>'.replace(/\d+/g,function(t){return i[t]})),M.DEFAULTS={aspectRatio:"auto",autoCropArea:.8,data:{},done:l.noop,preview:"",multiple:W,autoCrop:D,dragCrop:D,dashed:D,modal:D,movable:D,resizable:D,zoomable:D,rotatable:D,checkImageOrigin:D,minWidth:0,minHeight:0,maxWidth:1/0,maxHeight:1/0,build:r,built:r,dragstart:r,dragmove:r,dragend:r},M.setDefaults=function(t){l.extend(M.DEFAULTS,t)},M.other=l.fn.cropper,l.fn.cropper=function(h){var a,s=Y(arguments,1);return this.each(function(){var t,i=l(this),e=i.data("cropper");e||i.data("cropper",e=new M(this,h)),"string"==typeof h&&l.isFunction(t=e[h])&&(a=t.apply(e,s))}),typeof a!==n?a:this},l.fn.cropper.Constructor=M,l.fn.cropper.setDefaults=M.setDefaults,l.fn.cropper.noConflict=function(){return l.fn.cropper=M.other,this}});}catch(e){}