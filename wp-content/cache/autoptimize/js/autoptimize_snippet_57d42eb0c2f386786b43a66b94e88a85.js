try{(function($){$.fn.validationEngine=function(settings){if($.validationEngineLanguage){allRules=$.validationEngineLanguage.allRules}else{allRules={"required":{"regex":"none","alertText":validationError.required,"alertTextCheckboxMultiple":validationError.requiredCheckboxMulti,"alertTextCheckboxe":validationError.requiredCheckbox},"length":{"regex":"none","alertText":"*Between ","alertText2":" and ","alertText3":" characters allowed"},"minCheckbox":{"regex":"none","alertText":"* Checks allowed Exceeded"},"confirm":{"regex":"none","alertText":"* Your field is not matching"},"telephone":{"regex":"/^[0-9\-\(\)\ ]+$/","alertText":validationError.invalidTelephone},"email":{"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\\.)+[a-zA-Z0-9]{2,4}$/","alertText":validationError.invalidEmail},"date":{"regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/","alertText":validationError.invalidDate},"onlyNumber":{"regex":"/^[0-9\ ]+$/","alertText":validationError.numbersOnly},"noSpecialCaracters":{"regex":"/^[0-9a-zA-Z]+$/","alertText":validationError.noSpecialChar},"ajaxUser":{"file":"validateUser.php","alertTextOk":"* This user is available","alertTextLoad":"* Loading, please wait","alertText":"* This user is already taken"},"ajaxName":{"file":"validateUser.php","alertText":"* This name is already taken","alertTextOk":"* This name is available","alertTextLoad":"* Loading, please wait"},"onlyLetter":{"regex":"/^[a-zA-Z\ \']+$/","alertText":validationError.letterOnly}}}
settings=jQuery.extend({allrules:allRules,inlineValidation:true,ajaxSubmit:false,promptPosition:"topRight",success:false,failure:function(){}},settings);$.validationEngine.ajaxValidArray=new Array()
$(this).bind("submit",function(caller){$.validationEngine.onSubmitValid=true;if($.validationEngine.submitValidation(this,settings)==false){if($.validationEngine.submitForm(this,settings)==true){return false;}}else{settings.failure&&settings.failure();return false;}})
if(settings.inlineValidation==true){$(this).find("[class^=validate]").not("[type=checkbox]").bind("blur",function(caller){_inlinEvent(this)})
$(this).find("[class^=validate][type=checkbox]").bind("click",function(caller){_inlinEvent(this)})
function _inlinEvent(caller){if($.validationEngine.intercept==false||!$.validationEngine.intercept){$.validationEngine.onSubmitValid=false;$.validationEngine.loadValidation(caller,settings);}else{$.validationEngine.intercept=false;}}}};$.validationEngine={submitForm:function(caller){if($.validationEngine.settings.ajaxSubmit){$.ajax({type:"POST",url:$.validationEngine.settings.ajaxSubmitFile,async:true,data:$(caller).serialize(),success:function(data){console.log(data);if(data){$(caller).css("opacity",1)
$(caller).animate({opacity:0,height:0},function(){$(caller).css("display","none")
$(caller).before("<div class='ajaxSubmit'>"+$.validationEngine.settings.ajaxSubmitMessage+"</div>")
$.validationEngine.closePrompt(".formError",true)
$(".ajaxSubmit").slideDown("slow")
if($.validationEngine.settings.success){$.validationEngine.settings.success&&$.validationEngine.settings.success();return false;}})}else{data=eval("("+data+")");errorNumber=data.jsonValidateReturn.length
for(index=0;index<errorNumber;index++){fieldId=data.jsonValidateReturn[index][0];promptError=data.jsonValidateReturn[index][1];type=data.jsonValidateReturn[index][2];$.validationEngine.buildPrompt(fieldId,promptError,type);}}}})
return true;}
if($.validationEngine.settings.success){$.validationEngine.settings.success&&$.validationEngine.settings.success();return true;}
return false;},buildPrompt:function(caller,promptText,type,ajaxed){var divFormError=document.createElement('div')
var formErrorContent=document.createElement('div')
$(divFormError).addClass("formError")
if(type=="pass"){$(divFormError).addClass("greenPopup")}
if(type=="load"){$(divFormError).addClass("blackPopup")}
if(ajaxed){$(divFormError).addClass("ajaxed")}
$(divFormError).addClass($(caller).attr("id"))
$(formErrorContent).addClass("formErrorContent")
$("body").append(divFormError)
$(divFormError).append(formErrorContent)
if($.validationEngine.showTriangle!=false){var arrow=document.createElement('div')
$(arrow).addClass("formErrorArrow")
$(divFormError).append(arrow)
if($.validationEngine.settings.promptPosition=="bottomLeft"||$.validationEngine.settings.promptPosition=="bottomRight"){$(arrow).addClass("formErrorArrowBottom")
$(arrow).html('<div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div>');}
if($.validationEngine.settings.promptPosition=="topLeft"||$.validationEngine.settings.promptPosition=="topRight"){$(divFormError).append(arrow)
$(arrow).html('<div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div>');}}
$(formErrorContent).html(promptText)
callerTopPosition=$(caller).offset().top;callerleftPosition=$(caller).offset().left;callerWidth=$(caller).width()
inputHeight=$(divFormError).height()
if($.validationEngine.settings.promptPosition=="topRight"){callerleftPosition+=callerWidth-30;callerTopPosition+=-inputHeight-10;}
if($.validationEngine.settings.promptPosition=="topLeft"){callerTopPosition+=-inputHeight-10;}
if($.validationEngine.settings.promptPosition=="centerRight"){callerleftPosition+=callerWidth+13;}
if($.validationEngine.settings.promptPosition=="bottomLeft"){callerHeight=$(caller).height();callerleftPosition=callerleftPosition;callerTopPosition=callerTopPosition+callerHeight+15;}
if($.validationEngine.settings.promptPosition=="bottomRight"){callerHeight=$(caller).height();callerleftPosition+=callerWidth-30;callerTopPosition+=callerHeight+15;}
$(divFormError).css({top:callerTopPosition,left:callerleftPosition,opacity:0})
return $(divFormError).animate({"opacity":0.87},function(){return true;});},updatePromptText:function(caller,promptText,type,ajaxed){updateThisPrompt=$(caller).attr("id");updateThisPrompt="."+updateThisPrompt;(type=="pass")?$(updateThisPrompt).addClass("greenPopup"):$(updateThisPrompt).removeClass("greenPopup");(type=="load")?$(updateThisPrompt).addClass("blackPopup"):$(updateThisPrompt).removeClass("blackPopup");(ajaxed)?$(updateThisPrompt).addClass("ajaxed"):$(updateThisPrompt).removeClass("ajaxed");$(updateThisPrompt).find(".formErrorContent").html(promptText)
callerTopPosition=$(caller).offset().top;inputHeight=$(updateThisPrompt).height()
if($.validationEngine.settings.promptPosition=="bottomLeft"||$.validationEngine.settings.promptPosition=="bottomRight"){callerHeight=$(caller).height()
callerTopPosition=callerTopPosition+callerHeight+15}
if($.validationEngine.settings.promptPosition=="centerRight"){callerleftPosition+=callerWidth+13;}
if($.validationEngine.settings.promptPosition=="topLeft"||$.validationEngine.settings.promptPosition=="topRight"){callerTopPosition=callerTopPosition-inputHeight-10}
$(updateThisPrompt).animate({top:callerTopPosition});},loadValidation:function(caller,settings){$.validationEngine.settings=settings
rulesParsing=$(caller).attr('class');rulesRegExp=/\[(.*)\]/;getRules=rulesRegExp.exec(rulesParsing);str=getRules[1]
pattern=/\W+/;result=str.split(pattern);var validateCalll=$.validationEngine.validateCall(caller,result)
return validateCalll},validateCall:function(caller,rules){var promptText=""
var prompt=$(caller).attr("id");var caller=caller;ajaxValidate=false
var callerName=$(caller).attr("name");$.validationEngine.isError=false;$.validationEngine.showTriangle=true
callerType=$(caller).attr("type");for(i=0;i<rules.length;i++){switch(rules[i]){case"optional":if(!$(caller).val()){$.validationEngine.closePrompt(caller)
return $.validationEngine.isError}
break;case"required":_required(caller,rules);break;case"custom":_customRegex(caller,rules,i);break;case"ajax":if(!$.validationEngine.onSubmitValid){_ajax(caller,rules,i);}
break;case"length":_length(caller,rules,i);break;case"minCheckbox":_minCheckbox(caller,rules,i);break;case"confirm":_confirm(caller,rules,i);break;default:;};};if($.validationEngine.isError==true){radioHackOpen();if($.validationEngine.isError==true){($("div."+prompt).size()==0)?$.validationEngine.buildPrompt(caller,promptText,"error"):$.validationEngine.updatePromptText(caller,promptText);}}else{radioHackClose();$.validationEngine.closePrompt(caller);}
function radioHackOpen(){if($("input[name="+callerName+"]").size()>1&&callerType=="radio"){caller=$("input[name="+callerName+"]:first");$.validationEngine.showTriangle=false;var callerId="."+$(caller).attr("id");if($(callerId).size()==0){$.validationEngine.isError=true;}else{$.validationEngine.isError=false;}}
if($("input[name="+callerName+"]").size()>1&&callerType=="checkbox"){caller=$("input[name="+callerName+"]:first");$.validationEngine.showTriangle=false;var callerId="div."+$(caller).attr("id");if($(callerId).size()==0){$.validationEngine.isError=true;}else{$.validationEngine.isError=false;}}}
function radioHackClose(){if($("input[name="+callerName+"]").size()>1&&callerType=="radio"){caller=$("input[name="+callerName+"]:first");}
if($("input[name="+callerName+"]").size()>1&&callerType=="checkbox"){caller=$("input[name="+callerName+"]:first");}}
function _required(caller,rules){callerType=$(caller).attr("type");if(callerType=="text"||callerType=="password"||callerType=="textarea"){if(!$(caller).val()){$.validationEngine.isError=true;promptText+=$.validationEngine.settings.allrules[rules[i]].alertText+"<br />";}}
if(callerType=="radio"||callerType=="checkbox"){callerName=$(caller).attr("name");if($("input[name="+callerName+"]:checked").size()==0){$.validationEngine.isError=true;if($("input[name="+callerName+"]").size()==1){promptText+=$.validationEngine.settings.allrules[rules[i]].alertTextCheckboxe+"<br />";}else{promptText+=$.validationEngine.settings.allrules[rules[i]].alertTextCheckboxMultiple+"<br />";}}}
if(callerType=="select-one"){callerName=$(caller).attr("id");if(!$("select[name="+callerName+"]").val()){$.validationEngine.isError=true;promptText+=$.validationEngine.settings.allrules[rules[i]].alertText+"<br />";}}
if(callerType=="select-multiple"){callerName=$(caller).attr("id");if(!$("#"+callerName).val()){$.validationEngine.isError=true;promptText+=$.validationEngine.settings.allrules[rules[i]].alertText+"<br />";}}}
function _customRegex(caller,rules,position){customRule=rules[position+1];pattern=eval($.validationEngine.settings.allrules[customRule].regex);if(!pattern.test($(caller).attr('value'))){$.validationEngine.isError=true;promptText+=$.validationEngine.settings.allrules[customRule].alertText+"<br />";}}
function _ajax(caller,rules,position){customAjaxRule=rules[position+1];postfile=$.validationEngine.settings.allrules[customAjaxRule].file;fieldValue=$(caller).val();ajaxCaller=caller;fieldId=$(caller).attr("id");ajaxValidate=true;ajaxisError=$.validationEngine.isError;if(!ajaxisError){$.ajax({type:"POST",url:postfile,async:true,data:"validateValue="+fieldValue+"&validateId="+fieldId+"&validateError="+customAjaxRule,beforeSend:function(){if($.validationEngine.settings.allrules[customAjaxRule].alertTextLoad){if(!$("div."+fieldId)[0]){return $.validationEngine.buildPrompt(ajaxCaller,$.validationEngine.settings.allrules[customAjaxRule].alertTextLoad,"load");}else{$.validationEngine.updatePromptText(ajaxCaller,$.validationEngine.settings.allrules[customAjaxRule].alertTextLoad,"load");}}},success:function(data){data=eval("("+data+")");ajaxisError=data.jsonValidateReturn[2];customAjaxRule=data.jsonValidateReturn[1];ajaxCaller=$("#"+data.jsonValidateReturn[0])[0];fieldId=ajaxCaller;ajaxErrorLength=$.validationEngine.ajaxValidArray.length
existInarray=false;if(ajaxisError=="false"){_checkInArray(false)
if(!existInarray){$.validationEngine.ajaxValidArray[ajaxErrorLength]=new Array(2)
$.validationEngine.ajaxValidArray[ajaxErrorLength][0]=fieldId
$.validationEngine.ajaxValidArray[ajaxErrorLength][1]=false
existInarray=false;}
$.validationEngine.ajaxValid=false;promptText+=$.validationEngine.settings.allrules[customAjaxRule].alertText+"<br />";$.validationEngine.updatePromptText(ajaxCaller,promptText,"",true);}else{_checkInArray(true)
$.validationEngine.ajaxValid=true;if($.validationEngine.settings.allrules[customAjaxRule].alertTextOk){$.validationEngine.updatePromptText(ajaxCaller,$.validationEngine.settings.allrules[customAjaxRule].alertTextOk,"pass",true);}else{ajaxValidate=false;$.validationEngine.closePrompt(ajaxCaller);}}
function _checkInArray(validate){for(x=0;x<ajaxErrorLength;x++){if($.validationEngine.ajaxValidArray[x][0]==fieldId){$.validationEngine.ajaxValidArray[x][1]=validate
existInarray=true;}}}}});}}
function _confirm(caller,rules,position){confirmField=rules[position+1];if($(caller).attr('value')!=$("#"+confirmField).attr('value')){$.validationEngine.isError=true;promptText+=$.validationEngine.settings.allrules["confirm"].alertText+"<br />";}}
function _length(caller,rules,position){startLength=eval(rules[position+1]);endLength=eval(rules[position+2]);feildLength=$(caller).attr('value').length;if(feildLength<startLength||feildLength>endLength){$.validationEngine.isError=true;promptText+=$.validationEngine.settings.allrules["length"].alertText+startLength+$.validationEngine.settings.allrules["length"].alertText2+endLength+$.validationEngine.settings.allrules["length"].alertText3+"<br />"}}
function _minCheckbox(caller,rules,position){nbCheck=eval(rules[position+1]);groupname=$(caller).attr("name");groupSize=$("input[name="+groupname+"]:checked").size();if(groupSize>nbCheck){$.validationEngine.isError=true;promptText+=$.validationEngine.settings.allrules["minCheckbox"].alertText+"<br />";}}
return($.validationEngine.isError)?$.validationEngine.isError:false;},closePrompt:function(caller,outside){if(outside){$(caller).fadeTo("fast",0,function(){$(caller).remove();});return false;}
if(!ajaxValidate){closingPrompt=$(caller).attr("id");$("."+closingPrompt).fadeTo("fast",0,function(){$("."+closingPrompt).remove();});}},submitValidation:function(caller,settings){var stopForm=false;$.validationEngine.settings=settings
$.validationEngine.ajaxValid=true
$(caller).find(".formError").remove();var toValidateSize=$(caller).find("[class^=validate]").size();$(caller).find("[class^=validate]").each(function(){callerId=$(this).attr("id")
if(!$("."+callerId).hasClass("ajaxed")){var validationPass=$.validationEngine.loadValidation(this,settings);return(validationPass)?stopForm=true:"";}});ajaxErrorLength=$.validationEngine.ajaxValidArray.length
for(x=0;x<ajaxErrorLength;x++){if($.validationEngine.ajaxValidArray[x][1]==false){$.validationEngine.ajaxValid=false}}
if(stopForm||!$.validationEngine.ajaxValid){destination=$(".formError:not('.greenPopup'):first").offset().top;$("html:not(:animated),body:not(:animated)").animate({scrollTop:destination},1100);return true;}else{return false}}}})(jQuery);}catch(e){}