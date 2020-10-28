try{
/*!
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
function InfoBox(opt_opts){opt_opts=opt_opts||{};google.maps.OverlayView.apply(this,arguments);this.content_=opt_opts.content||"";this.disableAutoPan_=opt_opts.disableAutoPan||false;this.maxWidth_=opt_opts.maxWidth||0;this.pixelOffset_=opt_opts.pixelOffset||new google.maps.Size(0,0);this.position_=opt_opts.position||new google.maps.LatLng(0,0);this.zIndex_=opt_opts.zIndex||null;this.boxClass_=opt_opts.boxClass||"infoBox";this.boxStyle_=opt_opts.boxStyle||{};this.closeBoxMargin_=opt_opts.closeBoxMargin||"2px";this.closeBoxURL_=opt_opts.closeBoxURL||"//www.google.com/intl/en_us/mapfiles/close.gif";if(opt_opts.closeBoxURL===""){this.closeBoxURL_="";}
this.closeBoxTitle_=opt_opts.closeBoxTitle||" Close ";this.infoBoxClearance_=opt_opts.infoBoxClearance||new google.maps.Size(1,1);if(typeof opt_opts.visible==="undefined"){if(typeof opt_opts.isHidden==="undefined"){opt_opts.visible=true;}else{opt_opts.visible=!opt_opts.isHidden;}}
this.isHidden_=!opt_opts.visible;this.alignBottom_=opt_opts.alignBottom||false;this.pane_=opt_opts.pane||"floatPane";this.enableEventPropagation_=opt_opts.enableEventPropagation||false;this.div_=null;this.closeListener_=null;this.moveListener_=null;this.contextListener_=null;this.eventListeners_=null;this.fixedWidthSet_=null;}
InfoBox.prototype=new google.maps.OverlayView();InfoBox.prototype.createInfoBoxDiv_=function(){var i;var events;var bw;var me=this;var cancelHandler=function(e){e.cancelBubble=true;if(e.stopPropagation){e.stopPropagation();}};var ignoreHandler=function(e){e.returnValue=false;if(e.preventDefault){e.preventDefault();}
if(!me.enableEventPropagation_){cancelHandler(e);}};if(!this.div_){this.div_=document.createElement("div");this.setBoxStyle_();if(typeof this.content_.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+this.content_;}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(this.content_);}
this.getPanes()[this.pane_].appendChild(this.div_);this.addClickHandler_();if(this.div_.style.width){this.fixedWidthSet_=true;}else{if(this.maxWidth_!==0&&this.div_.offsetWidth>this.maxWidth_){this.div_.style.width=this.maxWidth_;this.div_.style.overflow="auto";this.fixedWidthSet_=true;}else{bw=this.getBoxWidths_();this.div_.style.width=(this.div_.offsetWidth-bw.left-bw.right)+"px";this.fixedWidthSet_=false;}}
this.panBox_(this.disableAutoPan_);if(!this.enableEventPropagation_){this.eventListeners_=[];events=["mousedown","mouseover","mouseout","mouseup","click","dblclick","touchstart","touchend","touchmove"];for(i=0;i<events.length;i++){this.eventListeners_.push(google.maps.event.addDomListener(this.div_,events[i],cancelHandler));}
this.eventListeners_.push(google.maps.event.addDomListener(this.div_,"mouseover",function(e){this.style.cursor="default";}));}
this.contextListener_=google.maps.event.addDomListener(this.div_,"contextmenu",ignoreHandler);google.maps.event.trigger(this,"domready");}};InfoBox.prototype.getCloseBoxImg_=function(){var img="";if(this.closeBoxURL_!==""){img="<img";img+=" src='"+this.closeBoxURL_+"'";img+=" align=right";img+=" title='"+this.closeBoxTitle_+"'";img+=" style='";img+=" position: relative;";img+=" cursor: pointer;";img+=" margin: "+this.closeBoxMargin_+";";img+="'>";}
return img;};InfoBox.prototype.addClickHandler_=function(){var closeBox;if(this.closeBoxURL_!==""){closeBox=this.div_.firstChild;this.closeListener_=google.maps.event.addDomListener(closeBox,"click",this.getCloseClickHandler_());}else{this.closeListener_=null;}};InfoBox.prototype.getCloseClickHandler_=function(){var me=this;return function(e){e.cancelBubble=true;if(e.stopPropagation){e.stopPropagation();}
google.maps.event.trigger(me,"closeclick");me.close();};};InfoBox.prototype.panBox_=function(disablePan){var map;var bounds;var xOffset=0,yOffset=0;if(!disablePan){map=this.getMap();if(map instanceof google.maps.Map){if(!map.getBounds().contains(this.position_)){map.setCenter(this.position_);}
var iwOffsetX=this.pixelOffset_.width;var iwOffsetY=this.pixelOffset_.height;var iwWidth=this.div_.offsetWidth;var iwHeight=this.div_.offsetHeight;var padX=this.infoBoxClearance_.width;var padY=this.infoBoxClearance_.height;if(map.panToBounds.length==2){var padding={left:0,right:0,top:0,bottom:0};padding.left=-iwOffsetX+padX;padding.right=iwOffsetX+iwWidth+padX;if(this.alignBottom_){padding.top=-iwOffsetY+padY+iwHeight;padding.bottom=iwOffsetY+padY;}else{padding.top=-iwOffsetY+padY;padding.bottom=iwOffsetY+iwHeight+padY;}
map.panToBounds(new google.maps.LatLngBounds(this.position_),padding);}else{var mapDiv=map.getDiv();var mapWidth=mapDiv.offsetWidth;var mapHeight=mapDiv.offsetHeight;var pixPosition=this.getProjection().fromLatLngToContainerPixel(this.position_);if(pixPosition.x<(-iwOffsetX+padX)){xOffset=pixPosition.x+iwOffsetX-padX;}else if((pixPosition.x+iwWidth+iwOffsetX+padX)>mapWidth){xOffset=pixPosition.x+iwWidth+iwOffsetX+padX-mapWidth;}
if(this.alignBottom_){if(pixPosition.y<(-iwOffsetY+padY+iwHeight)){yOffset=pixPosition.y+iwOffsetY-padY-iwHeight;}else if((pixPosition.y+iwOffsetY+padY)>mapHeight){yOffset=pixPosition.y+iwOffsetY+padY-mapHeight;}}else{if(pixPosition.y<(-iwOffsetY+padY)){yOffset=pixPosition.y+iwOffsetY-padY;}else if((pixPosition.y+iwHeight+iwOffsetY+padY)>mapHeight){yOffset=pixPosition.y+iwHeight+iwOffsetY+padY-mapHeight;}}
if(!(xOffset===0&&yOffset===0)){var c=map.getCenter();map.panBy(xOffset,yOffset);}}}}};InfoBox.prototype.setBoxStyle_=function(){var i,boxStyle;if(this.div_){this.div_.className=this.boxClass_;this.div_.style.cssText="";boxStyle=this.boxStyle_;for(i in boxStyle){if(boxStyle.hasOwnProperty(i)){this.div_.style[i]=boxStyle[i];}}
if((typeof this.div_.style.WebkitTransform==="undefined")||(this.div_.style.WebkitTransform.indexOf("translateZ")===-1&&this.div_.style.WebkitTransform.indexOf("matrix")===-1)){this.div_.style.WebkitTransform="translateZ(0)";}
if(typeof this.div_.style.opacity!=="undefined"&&this.div_.style.opacity!==""){this.div_.style.MsFilter="\"progid:DXImageTransform.Microsoft.Alpha(Opacity="+(this.div_.style.opacity*100)+")\"";this.div_.style.filter="alpha(opacity="+(this.div_.style.opacity*100)+")";}
this.div_.style.position="absolute";this.div_.style.visibility='hidden';if(this.zIndex_!==null){this.div_.style.zIndex=this.zIndex_;}}};InfoBox.prototype.getBoxWidths_=function(){var computedStyle;var bw={top:0,bottom:0,left:0,right:0};var box=this.div_;if(document.defaultView&&document.defaultView.getComputedStyle){computedStyle=box.ownerDocument.defaultView.getComputedStyle(box,"");if(computedStyle){bw.top=parseInt(computedStyle.borderTopWidth,10)||0;bw.bottom=parseInt(computedStyle.borderBottomWidth,10)||0;bw.left=parseInt(computedStyle.borderLeftWidth,10)||0;bw.right=parseInt(computedStyle.borderRightWidth,10)||0;}}else if(document.documentElement.currentStyle){if(box.currentStyle){bw.top=parseInt(box.currentStyle.borderTopWidth,10)||0;bw.bottom=parseInt(box.currentStyle.borderBottomWidth,10)||0;bw.left=parseInt(box.currentStyle.borderLeftWidth,10)||0;bw.right=parseInt(box.currentStyle.borderRightWidth,10)||0;}}
return bw;};InfoBox.prototype.onRemove=function(){if(this.div_){this.div_.parentNode.removeChild(this.div_);this.div_=null;}};InfoBox.prototype.draw=function(){this.createInfoBoxDiv_();var pixPosition=this.getProjection().fromLatLngToDivPixel(this.position_);this.div_.style.left=(pixPosition.x+this.pixelOffset_.width)+"px";if(this.alignBottom_){this.div_.style.bottom=-(pixPosition.y+this.pixelOffset_.height)+"px";}else{this.div_.style.top=(pixPosition.y+this.pixelOffset_.height)+"px";}
if(this.isHidden_){this.div_.style.visibility="hidden";}else{this.div_.style.visibility="visible";}};InfoBox.prototype.setOptions=function(opt_opts){if(typeof opt_opts.boxClass!=="undefined"){this.boxClass_=opt_opts.boxClass;this.setBoxStyle_();}
if(typeof opt_opts.boxStyle!=="undefined"){this.boxStyle_=opt_opts.boxStyle;this.setBoxStyle_();}
if(typeof opt_opts.content!=="undefined"){this.setContent(opt_opts.content);}
if(typeof opt_opts.disableAutoPan!=="undefined"){this.disableAutoPan_=opt_opts.disableAutoPan;}
if(typeof opt_opts.maxWidth!=="undefined"){this.maxWidth_=opt_opts.maxWidth;}
if(typeof opt_opts.pixelOffset!=="undefined"){this.pixelOffset_=opt_opts.pixelOffset;}
if(typeof opt_opts.alignBottom!=="undefined"){this.alignBottom_=opt_opts.alignBottom;}
if(typeof opt_opts.position!=="undefined"){this.setPosition(opt_opts.position);}
if(typeof opt_opts.zIndex!=="undefined"){this.setZIndex(opt_opts.zIndex);}
if(typeof opt_opts.closeBoxMargin!=="undefined"){this.closeBoxMargin_=opt_opts.closeBoxMargin;}
if(typeof opt_opts.closeBoxURL!=="undefined"){this.closeBoxURL_=opt_opts.closeBoxURL;}
if(typeof opt_opts.closeBoxTitle!=="undefined"){this.closeBoxTitle_=opt_opts.closeBoxTitle;}
if(typeof opt_opts.infoBoxClearance!=="undefined"){this.infoBoxClearance_=opt_opts.infoBoxClearance;}
if(typeof opt_opts.isHidden!=="undefined"){this.isHidden_=opt_opts.isHidden;}
if(typeof opt_opts.visible!=="undefined"){this.isHidden_=!opt_opts.visible;}
if(typeof opt_opts.enableEventPropagation!=="undefined"){this.enableEventPropagation_=opt_opts.enableEventPropagation;}
if(this.div_){this.draw();}};InfoBox.prototype.setContent=function(content){this.content_=content;if(this.div_){if(this.closeListener_){google.maps.event.removeListener(this.closeListener_);this.closeListener_=null;}
if(!this.fixedWidthSet_){this.div_.style.width="";}
if(typeof content.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+content;}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(content);}
if(!this.fixedWidthSet_){this.div_.style.width=this.div_.offsetWidth+"px";if(typeof content.nodeType==="undefined"){this.div_.innerHTML=this.getCloseBoxImg_()+content;}else{this.div_.innerHTML=this.getCloseBoxImg_();this.div_.appendChild(content);}}
this.addClickHandler_();}
google.maps.event.trigger(this,"content_changed");};InfoBox.prototype.setPosition=function(latlng){this.position_=latlng;if(this.div_){this.draw();}
google.maps.event.trigger(this,"position_changed");};InfoBox.prototype.setZIndex=function(index){this.zIndex_=index;if(this.div_){this.div_.style.zIndex=index;}
google.maps.event.trigger(this,"zindex_changed");};InfoBox.prototype.setVisible=function(isVisible){this.isHidden_=!isVisible;if(this.div_){this.div_.style.visibility=(this.isHidden_?"hidden":"visible");}};InfoBox.prototype.getContent=function(){return this.content_;};InfoBox.prototype.getPosition=function(){return this.position_;};InfoBox.prototype.getZIndex=function(){return this.zIndex_;};InfoBox.prototype.getVisible=function(){var isVisible;if((typeof this.getMap()==="undefined")||(this.getMap()===null)){isVisible=false;}else{isVisible=!this.isHidden_;}
return isVisible;};InfoBox.prototype.getWidth=function(){var width=null;if(this.div_){width=this.div_.offsetWidth;}
return width;};InfoBox.prototype.getHeight=function(){var height=null;if(this.div_){height=this.div_.offsetHeight;}
return height;};InfoBox.prototype.show=function(){this.isHidden_=false;if(this.div_){this.div_.style.visibility="visible";}};InfoBox.prototype.hide=function(){this.isHidden_=true;if(this.div_){this.div_.style.visibility="hidden";}};InfoBox.prototype.open=function(map,anchor){var me=this;if(anchor){this.setPosition(anchor.getPosition());this.moveListener_=google.maps.event.addListener(anchor,"position_changed",function(){me.setPosition(this.getPosition());});}
this.setMap(map);if(this.div_){this.panBox_(this.disableAutoPan_);}};InfoBox.prototype.close=function(){var i;if(this.closeListener_){google.maps.event.removeListener(this.closeListener_);this.closeListener_=null;}
if(this.eventListeners_){for(i=0;i<this.eventListeners_.length;i++){google.maps.event.removeListener(this.eventListeners_[i]);}
this.eventListeners_=null;}
if(this.moveListener_){google.maps.event.removeListener(this.moveListener_);this.moveListener_=null;}
if(this.contextListener_){google.maps.event.removeListener(this.contextListener_);this.contextListener_=null;}
this.setMap(null);};}catch(e){}