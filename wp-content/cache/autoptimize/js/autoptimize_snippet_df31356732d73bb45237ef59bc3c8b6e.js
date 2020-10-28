try{!function(l){"use strict";var c={init:function(t){return this.each(function(){this.self=l(this),c.destroy.call(this.self),this.opt=l.extend(!0,{},l.fn.um_raty.defaults,t),c._adjustCallback.call(this),c._adjustNumber.call(this),"img"!==this.opt.starType&&c._adjustStarType.call(this),c._adjustPath.call(this),c._createStars.call(this),this.opt.cancel&&c._createCancel.call(this),this.opt.precision&&c._adjustPrecision.call(this),c._createScore.call(this),c._apply.call(this,this.opt.score),c._target.call(this,this.opt.score),this.opt.readOnly?c._lock.call(this):(this.style.cursor="pointer",c._binds.call(this)),this.self.data("options",this.opt)})},_adjustCallback:function(){for(var t=["number","readOnly","score","scoreName","target"],e=0;e<t.length;e++)"function"==typeof this.opt[t[e]]&&(this.opt[t[e]]=this.opt[t[e]].call(this))},_adjustNumber:function(){this.opt.number=c._between(this.opt.number,1,this.opt.numberMax)},_adjustPath:function(){this.opt.path=this.opt.path||"",this.opt.path&&"/"!==this.opt.path.charAt(this.opt.path.length-1)&&(this.opt.path+="/")},_adjustPrecision:function(){this.opt.half=!0,this.opt.targetType="score"},_adjustStarType:function(){this.opt.path="";for(var t=["cancelOff","cancelOn","starHalf","starOff","starOn"],e=0;e<t.length;e++)this.opt[t[e]]=this.opt[t[e]].replace(".","-")},_apply:function(t){c._fill.call(this,t),t&&(0<t&&this.score.val(c._between(t,0,this.opt.number)),c._roundStars.call(this,t))},_between:function(t,e,a){return Math.min(Math.max(parseFloat(t),e),a)},_binds:function(){this.cancel&&(c._bindOverCancel.call(this),c._bindClickCancel.call(this),c._bindOutCancel.call(this)),c._bindOver.call(this),c._bindClick.call(this),c._bindOut.call(this)},_bindClick:function(){var a=this;a.stars.on("click.um_raty",function(t){var e=l(this);a.score.val(a.opt.half||a.opt.precision?a.self.data("score"):this.alt||e.data("alt")),a.opt.click&&a.opt.click.call(a,+a.score.val(),t)})},_bindClickCancel:function(){var e=this;e.cancel.on("click.um_raty",function(t){e.score.removeAttr("value"),e.opt.click&&e.opt.click.call(e,null,t)})},_bindOut:function(){var a=this;a.self.on("mouseleave.um_raty",function(t){var e=+a.score.val()||void 0;c._apply.call(a,e),c._target.call(a,e,t),a.opt.mouseout&&a.opt.mouseout.call(a,e,t)})},_bindOutCancel:function(){var s=this;s.cancel.on("mouseleave.um_raty",function(t){var e=s.opt.cancelOff;if("img"!==s.opt.starType&&(e=s.opt.cancelClass+" "+e),c._setIcon.call(s,this,e),s.opt.mouseout){var a=+s.score.val()||void 0;s.opt.mouseout.call(s,a,t)}})},_bindOver:function(){var a=this,t=a.opt.half?"mousemove.um_raty":"mouseover.um_raty";a.stars.on(t,function(t){var e=c._getScoreByPosition.call(a,t,this);c._fill.call(a,e),a.opt.half&&(c._roundStars.call(a,e),a.self.data("score",e)),c._target.call(a,e,t),a.opt.mouseover&&a.opt.mouseover.call(a,e,t)})},_bindOverCancel:function(){var s=this;s.cancel.on("mouseover.um_raty",function(t){var e=s.opt.path+s.opt.starOff,a=s.opt.cancelOn;"img"===s.opt.starType?s.stars.attr("src",e):(a=s.opt.cancelClass+" "+a,s.stars.attr("class",e)),c._setIcon.call(s,this,a),c._target.call(s,null,t),s.opt.mouseover&&s.opt.mouseover.call(s,null)})},_buildScoreField:function(){return l("<input />",{name:this.opt.scoreName,type:"hidden"}).appendTo(this)},_createCancel:function(){var t=this.opt.path+this.opt.cancelOff,e=l("<"+this.opt.starType+" />",{title:this.opt.cancelHint,class:this.opt.cancelClass});"img"===this.opt.starType?e.attr({src:t,alt:"x"}):e.attr("data-alt","x").addClass(t),"left"===this.opt.cancelPlace?this.self.prepend("&#160;").prepend(e):this.self.append("&#160;").append(e),this.cancel=e},_createScore:function(){var t=l(this.opt.targetScore);this.score=t.length?t:c._buildScoreField.call(this)},_createStars:function(){for(var t=1;t<=this.opt.number;t++){var e=c._nameForIndex.call(this,t),a={alt:t,src:this.opt.path+this.opt[e]};"img"!==this.opt.starType&&(a={"data-alt":t,class:a.src}),a.title=c._getHint.call(this,t),l("<"+this.opt.starType+" />",a).appendTo(this),this.opt.space&&this.self.append(t<this.opt.number?"&#160;":"")}this.stars=this.self.children(this.opt.starType)},_error:function(t){l(this).text(t),l.error(t)},_fill:function(t){for(var e=0,a=1;a<=this.stars.length;a++){var s,i=this.stars[a-1],o=c._turnOn.call(this,a,t);if(this.opt.iconRange&&this.opt.iconRange.length>e){var r=this.opt.iconRange[e];s=c._getRangeIcon.call(this,r,o),a<=r.range&&c._setIcon.call(this,i,s),a===r.range&&e++}else s=this.opt[o?"starOn":"starOff"],c._setIcon.call(this,i,s)}},_getRangeIcon:function(t,e){return e?t.on||this.opt.starOn:t.off||this.opt.starOff},_getScoreByPosition:function(t,e){var a=parseInt(e.alt||e.getAttribute("data-alt"),10);if(this.opt.half){var s=c._getSize.call(this),i=parseFloat((t.pageX-l(e).offset().left)/s);a=this.opt.precision?a-1+i:a-1+(.5<i?1:.5)}return a},_getSize:function(){var t;return(t="img"===this.opt.starType?this.stars[0].width:parseFloat(this.stars.eq(0).css("font-size")))||c._error.call(this,"Could not be possible get the icon size!"),t},_turnOn:function(t,e){return this.opt.single?t===e:t<=e},_getHint:function(t){var e=this.opt.hints[t-1];return""===e?"":e||t},_lock:function(){var t=parseInt(this.score.val(),10),e=t?c._getHint.call(this,t):this.opt.noRatedMsg;this.style.cursor="",this.title=e,this.score.prop("readonly",!0),this.stars.prop("title",e),this.cancel&&this.cancel.hide(),this.self.data("readonly",!0)},_nameForIndex:function(t){return this.opt.score&&this.opt.score>=t?"starOn":"starOff"},_roundStars:function(t){var e=(t%1).toFixed(2);if(e>this.opt.round.down){var a="starOn";this.opt.halfShow&&e<this.opt.round.up?a="starHalf":e<this.opt.round.full&&(a="starOff");var s=this.opt[a],i=this.stars[Math.ceil(t)-1];c._setIcon.call(this,i,s)}},_setIcon:function(t,e){t["img"===this.opt.starType?"src":"className"]=this.opt.path+e},_setTarget:function(t,e){e&&(e=this.opt.targetFormat.toString().replace("{score}",e)),t.is(":input")?t.val(e):t.html(e)},_target:function(t,e){if(this.opt.target){var a=l(this.opt.target);a.length||c._error.call(this,"Target selector invalid or missing!");var s=e&&"mouseover"===e.type;if(void 0===t)t=this.opt.targetText;else if(null===t)t=s?this.opt.cancelHint:this.opt.targetText;else{"hint"===this.opt.targetType?t=c._getHint.call(this,Math.ceil(t)):this.opt.precision&&(t=parseFloat(t).toFixed(1));var i=e&&"mousemove"===e.type;s||i||this.opt.targetKeep||(t=this.opt.targetText)}c._setTarget.call(this,a,t)}},_unlock:function(){this.style.cursor="pointer",this.removeAttribute("title"),this.score.removeAttr("readonly"),this.self.data("readonly",!1);for(var t=0;t<this.opt.number;t++)this.stars[t].title=c._getHint.call(this,t+1);this.cancel&&this.cancel.css("display","")},cancel:function(e){return this.each(function(){var t=l(this);!0!==t.data("readonly")&&(c[e?"click":"score"].call(t,null),this.score.removeAttr("value"))})},click:function(t){return this.each(function(){!0!==l(this).data("readonly")&&(c._apply.call(this,t),this.opt.click&&this.opt.click.call(this,t,l.Event("click")),c._target.call(this,t))})},destroy:function(){return this.each(function(){var t=l(this),e=t.data("raw");e?t.off(".um_raty").empty().css({cursor:e.style.cursor}).removeData("readonly"):t.data("raw",t.clone()[0])})},getScore:function(){var t,e=[];return this.each(function(){t=this.score.val(),e.push(t?+t:void 0)}),1<e.length?e:e[0]},move:function(n){return this.each(function(){var t=parseInt(n,10),e=l(this).data("options"),a=(+n).toFixed(1).split(".")[1];t>=e.number&&(t=e.number-1,a=10);var s=c._getSize.call(this)/10,i=l(this.stars[t]),o=i.offset().left+s*parseInt(a,10),r=l.Event("mousemove",{pageX:o});i.trigger(r)})},readOnly:function(e){return this.each(function(){var t=l(this);t.data("readonly")!==e&&(e?(t.off(".um_raty").children("img").off(".um_raty"),c._lock.call(this)):(c._binds.call(this),c._unlock.call(this)),t.data("readonly",e))})},reload:function(){return c.set.call(this,{})},score:function(){var t=l(this);return arguments.length?c.setScore.apply(t,arguments):c.getScore.call(t)},set:function(s){return this.each(function(){var t=l(this),e=t.data("options"),a=l.extend({},e,s);t.um_raty(a)})},setScore:function(t){return this.each(function(){!0!==l(this).data("readonly")&&(c._apply.call(this,t),c._target.call(this,t))})}};l.fn.um_raty=function(t){return c[t]?c[t].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof t&&t?void l.error("Method "+t+" does not exist!"):c.init.apply(this,arguments)},l.fn.um_raty.defaults={cancel:!1,cancelClass:"raty-cancel",cancelHint:wp.i18n.__("Cancel this rating!","ultimate-member"),cancelOff:"cancel-off.png",cancelOn:"cancel-on.png",cancelPlace:"left",click:void 0,half:!1,halfShow:!0,hints:["bad","poor","regular","good","gorgeous"],iconRange:void 0,mouseout:void 0,mouseover:void 0,noRatedMsg:wp.i18n.__("Not rated yet!","ultimate-member"),number:5,numberMax:20,path:void 0,precision:!1,readOnly:!1,round:{down:.25,full:.6,up:.76},score:void 0,scoreName:"score",single:!1,space:!0,starHalf:"star-half.png",starOff:"star-off.png",starOn:"star-on.png",starType:"img",target:void 0,targetFormat:"{score}",targetKeep:!1,targetScore:void 0,targetText:"",targetType:"hint"}}(jQuery);}catch(e){}