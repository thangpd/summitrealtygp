<?php
/**
 * Date: 11/25/20
 * Time: 3:35 PM
 */

namespace Elhelper\model;


use Elhelper\inc\HelperShortcode;
use KubAT\PhpSimple\HtmlDomParser;

class BhhsModel {
	public $dom = '';

	public function __construct( $address ) {
		$htmldom = get_transient( 'bhhs_' . $address );
		if ( empty( $htmldom ) ) {
			$htmldom = $this->stringFilter( HelperShortcode::crawlingData( 'https://bhhs.findbuyers.com/address/' . $address ) );
//			$htmldom = $this->stringFilter( $this->stringyfyCrawledData() );
			set_transient( 'bhhs_' . $address, $htmldom, 86400 );
		}
		$this->dom = HtmlDomParser::str_get_html( $htmldom );

		return $this->dom;
	}

	function stringFilter( $htmldom ) {
		$array_replace_pattern = [
			'#(<!--(.*)>)#',
			'##'
		];
		$htmldom               = preg_replace( $array_replace_pattern, '', $htmldom );
		preg_match( '#contentagent">(.*)#', $htmldom, $match, PREG_OFFSET_CAPTURE );
		if ( isset( $match[0][1] ) ) {
			$htmldom = substr_replace( $htmldom, '', 0, $match[0][1] + 15 );
			$start   = 0;
			$htmldom = substr( $htmldom, $start, strlen( $htmldom ) );
		} else {
			$htmldom = '';
		}

		return $htmldom;
	}


	public function stringyfyCrawledData() {
		$str = <<<HTML
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->

<!--<![endif]-->


  <meta charset="UTF-8">
  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <title>Estimated Home Value for 805 Peachtree St Ne Unit 416, Atlanta, Ga 30308 | HSF Affiliates</title>

  <meta property="og:title" content="Estimated Home Value for 805 Peachtree St Ne Unit 416, Atlanta, Ga 30308">
  <meta property="og:type" content="website">

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-N63D67T');</script>
  <!-- End Google Tag Manager -->
    <meta property="og:image" content="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/eb25277d5ecfe6480efcac2c17429289.png">

  <meta property="og:url" content="https://bhhs.findbuyers.com/address/805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308">
  <meta property="og:site_name" content="Berkshire Hathaway HomeServices">
  <meta property="og:description" content="Find the home value for 805 Peachtree St Ne Unit 416, Atlanta, Ga 30308 using the Home Valuation Tool from HSF Affiliates">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="fb:app_id" content="2045816055644405">
  <meta name="description" content="Discover the value of the home located at 805 Peachtree St Ne Unit 416, Atlanta, Ga 30308. Find other home values at HSF Affiliates">
  <meta name="keywords" content="home value for 805 Peachtree St Ne Unit 416, Atlanta, Ga 30308, find home value for 805 Peachtree St Ne Unit 416, Atlanta, Ga 30308, home valuation, HSF Affiliates">
  <meta name="copyright" content="Copyright 2020 Buyside. All rights reserved.">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><script type="text/javascript">(window.NREUM||(NREUM={})).loader_config={licenseKey:"d4c899ec1b",applicationID:"344212703"};window.NREUM||(NREUM={}),__nr_require=function(e,t,n){function r(n){if(!t[n]){var i=t[n]={exports:{}};e[n][0].call(i.exports,function(t){var i=e[n][1][t];return r(i||t)},i,i.exports)}return t[n].exports}if("function"==typeof __nr_require)return __nr_require;for(var i=0;i<n.length;i++)r(n[i]);return r}({1:[function(e,t,n){function r(){}function i(e,t,n){return function(){return o(e,[u.now()].concat(c(arguments)),t?null:this,n),t?void 0:this}}var o=e("handle"),a=e(6),c=e(7),f=e("ee").get("tracer"),u=e("loader"),s=NREUM;"undefined"==typeof window.newrelic&&(newrelic=s);var d=["setPageViewName","setCustomAttribute","setErrorHandler","finished","addToTrace","inlineHit","addRelease"],p="api-",l=p+"ixn-";a(d,function(e,t){s[t]=i(p+t,!0,"api")}),s.addPageAction=i(p+"addPageAction",!0),s.setCurrentRouteName=i(p+"routeName",!0),t.exports=newrelic,s.interaction=function(){return(new r).get()};var m=r.prototype={createTracer:function(e,t){var n={},r=this,i="function"==typeof t;return o(l+"tracer",[u.now(),e,n],r),function(){if(f.emit((i?"":"no-")+"fn-start",[u.now(),r,i],n),i)try{return t.apply(this,arguments)}catch(e){throw f.emit("fn-err",[arguments,this,e],n),e}finally{f.emit("fn-end",[u.now()],n)}}}};a("actionText,setName,setAttribute,save,ignore,onEnd,getContext,end,get".split(","),function(e,t){m[t]=i(l+t)}),newrelic.noticeError=function(e,t){"string"==typeof e&&(e=new Error(e)),o("err",[e,u.now(),!1,t])}},{}],2:[function(e,t,n){function r(){return c.exists&&performance.now?Math.round(performance.now()):(o=Math.max((new Date).getTime(),o))-a}function i(){return o}var o=(new Date).getTime(),a=o,c=e(8);t.exports=r,t.exports.offset=a,t.exports.getLastTimestamp=i},{}],3:[function(e,t,n){function r(e,t){var n=e.getEntries();n.forEach(function(e){"first-paint"===e.name?d("timing",["fp",Math.floor(e.startTime)]):"first-contentful-paint"===e.name&&d("timing",["fcp",Math.floor(e.startTime)])})}function i(e,t){var n=e.getEntries();n.length>0&&d("lcp",[n[n.length-1]])}function o(e){e.getEntries().forEach(function(e){e.hadRecentInput||d("cls",[e])})}function a(e){if(e instanceof m&&!g){var t=Math.round(e.timeStamp),n={type:e.type};t<=p.now()?n.fid=p.now()-t:t>p.offset&&t<=Date.now()?(t-=p.offset,n.fid=p.now()-t):t=p.now(),g=!0,d("timing",["fi",t,n])}}function c(e){d("pageHide",[p.now(),e])}if(!("init"in NREUM&&"page_view_timing"in NREUM.init&&"enabled"in NREUM.init.page_view_timing&&NREUM.init.page_view_timing.enabled===!1)){var f,u,s,d=e("handle"),p=e("loader"),l=e(5),m=NREUM.o.EV;if("PerformanceObserver"in window&&"function"==typeof window.PerformanceObserver){f=new PerformanceObserver(r);try{f.observe({entryTypes:["paint"]})}catch(v){}u=new PerformanceObserver(i);try{u.observe({entryTypes:["largest-contentful-paint"]})}catch(v){}s=new PerformanceObserver(o);try{s.observe({type:"layout-shift",buffered:!0})}catch(v){}}if("addEventListener"in document){var g=!1,y=["click","keydown","mousedown","pointerdown","touchstart"];y.forEach(function(e){document.addEventListener(e,a,!1)})}l(c)}},{}],4:[function(e,t,n){function r(e,t){if(!i)return!1;if(e!==i)return!1;if(!t)return!0;if(!o)return!1;for(var n=o.split("."),r=t.split("."),a=0;a<r.length;a++)if(r[a]!==n[a])return!1;return!0}var i=null,o=null,a=/Version\/(\S+)\s+Safari/;if(navigator.userAgent){var c=navigator.userAgent,f=c.match(a);f&&c.indexOf("Chrome")===-1&&c.indexOf("Chromium")===-1&&(i="Safari",o=f[1])}t.exports={agent:i,version:o,match:r}},{}],5:[function(e,t,n){function r(e){function t(){e(a&&document[a]?document[a]:document[i]?"hidden":"visible")}"addEventListener"in document&&o&&document.addEventListener(o,t,!1)}t.exports=r;var i,o,a;"undefined"!=typeof document.hidden?(i="hidden",o="visibilitychange",a="visibilityState"):"undefined"!=typeof document.msHidden?(i="msHidden",o="msvisibilitychange"):"undefined"!=typeof document.webkitHidden&&(i="webkitHidden",o="webkitvisibilitychange",a="webkitVisibilityState")},{}],6:[function(e,t,n){function r(e,t){var n=[],r="",o=0;for(r in e)i.call(e,r)&&(n[o]=t(r,e[r]),o+=1);return n}var i=Object.prototype.hasOwnProperty;t.exports=r},{}],7:[function(e,t,n){function r(e,t,n){t||(t=0),"undefined"==typeof n&&(n=e?e.length:0);for(var r=-1,i=n-t||0,o=Array(i<0?0:i);++r<i;)o[r]=e[t+r];return o}t.exports=r},{}],8:[function(e,t,n){t.exports={exists:"undefined"!=typeof window.performance&&window.performance.timing&&"undefined"!=typeof window.performance.timing.navigationStart}},{}],ee:[function(e,t,n){function r(){}function i(e){function t(e){return e&&e instanceof r?e:e?f(e,c,o):o()}function n(n,r,i,o){if(!p.aborted||o){e&&e(n,r,i);for(var a=t(i),c=v(n),f=c.length,u=0;u<f;u++)c[u].apply(a,r);var d=s[w[n]];return d&&d.push([b,n,r,a]),a}}function l(e,t){h[e]=v(e).concat(t)}function m(e,t){var n=h[e];if(n)for(var r=0;r<n.length;r++)n[r]===t&&n.splice(r,1)}function v(e){return h[e]||[]}function g(e){return d[e]=d[e]||i(n)}function y(e,t){u(e,function(e,n){t=t||"feature",w[n]=t,t in s||(s[t]=[])})}var h={},w={},b={on:l,addEventListener:l,removeEventListener:m,emit:n,get:g,listeners:v,context:t,buffer:y,abort:a,aborted:!1};return b}function o(){return new r}function a(){(s.api||s.feature)&&(p.aborted=!0,s=p.backlog={})}var c="nr@context",f=e("gos"),u=e(6),s={},d={},p=t.exports=i();p.backlog=s},{}],gos:[function(e,t,n){function r(e,t,n){if(i.call(e,t))return e[t];var r=n();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(e,t,{value:r,writable:!0,enumerable:!1}),r}catch(o){}return e[t]=r,r}var i=Object.prototype.hasOwnProperty;t.exports=r},{}],handle:[function(e,t,n){function r(e,t,n,r){i.buffer([e],r),i.emit(e,t,n)}var i=e("ee").get("handle");t.exports=r,r.ee=i},{}],id:[function(e,t,n){function r(e){var t=typeof e;return!e||"object"!==t&&"function"!==t?-1:e===window?0:a(e,o,function(){return i++})}var i=1,o="nr@id",a=e("gos");t.exports=r},{}],loader:[function(e,t,n){function r(){if(!E++){var e=b.info=NREUM.info,t=p.getElementsByTagName("script")[0];if(setTimeout(u.abort,3e4),!(e&&e.licenseKey&&e.applicationID&&t))return u.abort();f(h,function(t,n){e[t]||(e[t]=n)});var n=a();c("mark",["onload",n+b.offset],null,"api"),c("timing",["load",n]);var r=p.createElement("script");r.src="https://"+e.agent,t.parentNode.insertBefore(r,t)}}function i(){"complete"===p.readyState&&o()}function o(){c("mark",["domContent",a()+b.offset],null,"api")}var a=e(2),c=e("handle"),f=e(6),u=e("ee"),s=e(4),d=window,p=d.document,l="addEventListener",m="attachEvent",v=d.XMLHttpRequest,g=v&&v.prototype;NREUM.o={ST:setTimeout,SI:d.setImmediate,CT:clearTimeout,XHR:v,REQ:d.Request,EV:d.Event,PR:d.Promise,MO:d.MutationObserver};var y=""+location,h={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-1184.min.js"},w=v&&g&&g[l]&&!/CriOS/.test(navigator.userAgent),b=t.exports={offset:a.getLastTimestamp(),now:a,origin:y,features:{},xhrWrappable:w,userAgent:s};e(1),e(3),p[l]?(p[l]("DOMContentLoaded",o,!1),d[l]("load",r,!1)):(p[m]("onreadystatechange",i),d[m]("onload",r)),c("mark",["firstbyte",a.getLastTimestamp()],null,"api");var E=0},{}],"wrap-function":[function(e,t,n){function r(e){return!(e&&e instanceof Function&&e.apply&&!e[a])}var i=e("ee"),o=e(7),a="nr@original",c=Object.prototype.hasOwnProperty,f=!1;t.exports=function(e,t){function n(e,t,n,i){function nrWrapper(){var r,a,c,f;try{a=this,r=o(arguments),c="function"==typeof n?n(r,a):n||{}}catch(u){p([u,"",[r,a,i],c])}s(t+"start",[r,a,i],c);try{return f=e.apply(a,r)}catch(d){throw s(t+"err",[r,a,d],c),d}finally{s(t+"end",[r,a,f],c)}}return r(e)?e:(t||(t=""),nrWrapper[a]=e,d(e,nrWrapper),nrWrapper)}function u(e,t,i,o){i||(i="");var a,c,f,u="-"===i.charAt(0);for(f=0;f<t.length;f++)c=t[f],a=e[c],r(a)||(e[c]=n(a,u?c+i:i,o,c))}function s(n,r,i){if(!f||t){var o=f;f=!0;try{e.emit(n,r,i,t)}catch(a){p([a,n,r,i])}f=o}}function d(e,t){if(Object.defineProperty&&Object.keys)try{var n=Object.keys(e);return n.forEach(function(n){Object.defineProperty(t,n,{get:function(){return e[n]},set:function(t){return e[n]=t,t}})}),t}catch(r){p([r])}for(var i in e)c.call(e,i)&&(t[i]=e[i]);return t}function p(t){try{e.emit("internal-error",t)}catch(n){}}return e||(e=i),n.inPlace=u,n.flag=a,n}},{}]},{},["loader"]);</script>
  <meta name="author" content="Buyside">

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, minimal-ui">
  <meta http-equiv="Cache-Control" content="no-cache">

  <link rel="apple-touch-icon" sizes="57x57" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/android-chrome-192x192.png" sizes="192x192">
  <link rel="icon" type="image/png" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/favicons/manifest.json">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-TileImage" content="/mstile-144x144.png">
  <meta name="theme-color" content="#ffffff">

      <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/libs/vue/vue.min.js" type="text/javascript"></script>
  
    <script src="https://bmlsdevcdn.s3.amazonaws.com/assets/components/buyside.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/resources/production/components/market-trends/market-trends.js" type="text/javascript"></script>

  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700|Nunito:300|Oswald:400,700|Gabriela|Montserrat" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css">
  <link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/css/site.css" rel="stylesheet" type="text/css" media="all">
  <link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/css/form.css" rel="stylesheet" type="text/css" media="all">
  <link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/css/agent.css" rel="stylesheet" type="text/css" media="all">
  <link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/css/select2.css" rel="stylesheet" type="text/css" media="all">
  <link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/css/page.css" rel="stylesheet" type="text/css" media="all">

        <link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/emap/emap.css" rel="stylesheet" type="text/css">
    
  <style type="text/css">
    .info.legend.leaflet-control {
      background: rgba(255, 255, 255, 0.75) !important;
      border-radius: 0;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5) !important;
      font-size: 0;
      line-height: 0 !important;
      margin: 0 5px 5px 0 !important;
      padding: 5px 10px !important;
    }

    .info.legend.leaflet-control br {
      display: none;
    }

    .info.legend.leaflet-control p {
      font-size: 0;
      line-height: 20px;
      margin: 0;
      overflow: hidden;
    }

    .info.legend.leaflet-control p:before {
      color: rgba(0, 0, 0, 0.75);
      content: 'Active';
      float: left;
      font-size: 12px;
      font-weight: normal;
    }

    .info.legend.leaflet-control p:after {
      color: rgba(0, 0, 0, 0.75);
      content: 'Very Active';
      float: right;
      font-size: 12px;
      font-weight: normal;
    }

    .info.legend.leaflet-control i {
      height: 20px;
      margin: 0;
      width: 20px;
    }

    .leaflet-control-attribution {
      display: none;
    }

    .sectionagent-location .row-map .layer-text {
      background-color: rgba(255, 255, 255, 0.75);
      bottom: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      float: left;
      left: 5px;
      padding: 5px 20px;
    }

    .sectionagent-location .row-map .layer-text p {
      color: rgba(0, 0, 0, 0.75);
      font-size: 24px;
      font-weight: bold;
      line-height: 40px;
      padding: 0;
    }

    @media screen and (min-width: 960px) {
      .sectionagent-location .row-map .layer-text {
        font-size: 32px;
        padding: 5px 40px;
      }
    }

    @media screen and (max-width: 719px) {
      .sectionagent-location .row-map > #map {
        padding-top: 50%;
      }
    }

    @media screen and (max-width: 599px) {
      .sectionagent-location .row-map > #map {
        padding-top: 67%;
      }

      .info.legend.leaflet-control {
        padding: 5px !important;
      }

      .info.legend.leaflet-control p {
        line-height: 15px;
      }

      .info.legend.leaflet-control p:before, .info.legend.leaflet-control p:after {
        font-size: 10px;
      }

      .info.legend.leaflet-control i {
        height: 15px;
        width: 15px;
      }

      .sectionagent-location .row-map .layer-text {
        padding: 5px 10px;
      }

      .sectionagent-location .row-map .layer-text p {
        font-size: 14px;
        line-height: 30px;
      }
    }

    @media screen and (max-width: 479px) {
      .sectionagent-location .row-map > #map {
        padding-top: 320px;
      }
    }

    .info.legend.leaflet-control {
      width: 180px !important;
    }

    @media screen and (max-width: 599px) {
      .info.legend.leaflet-control {
        width: 130px !important;
      }
    }
  </style>

  
  <link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhsne_images/favicon.png" rel="icon" type="image/png">
<link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhsne_images/favicon.png" rel="shortcut icon" type="image/png">
<style type="text/css" media="all">
            body, .backgroundagent, .ui-tooltip, .sectionagent-three ul.menu li:after { background-color: #552448 !important; }
            .coloragent, article.normal-box normal-text p a { color: #552448 !important; }
            .sectionagent-precis { background: #552448;  }
            .sectionagent-precis .row-data p { text-shadow: 0 0 5px #552448, 0 0 3px #552448, 0 0 1px #552448; }
            .sectionagent-precis .row-data p.nth-1 { background: rgba(128,128,128,0.5); }
            .sectionagent-precis .row-data p.nth-2 { background: rgba(128,128,128,0.25); }
            .sectionagent-precis .row-data p a { box-shadow: 0 0 5px #552448, 0 0 3px #552448, 0 0 1px #552448; color: #552448 !important; }
   .sitebgcolor {background: #c41230 none repeat scroll 0 0 !important;}
   .whitebgcolor {background: #fff none repeat scroll 0 0 !important;} 
         .bordercolor{border:1px solid #ccc}
   .buttonbg{background:#5ab333 !important;}
         h1.blackfont {color: #1a1a1a !important;} 
.row-slider .row-button .buttonagent {
    background: #552448 none repeat scroll 0 0;}
.buttonagent {
    background: #552448 none repeat scroll 0 0;}
.btngreen {
    background-color: #552448 !important;
}
#agent-footer {
  margin: auto; }
 </style>
<link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/bhhs.css" rel="stylesheet" type="text/css" media="all">
<style type="text/css" media="all">
body, .backgroundagent, .ui-tooltip, .sectionagent-three ul.menu li:after { background-color: #552448 !important; }
.coloragent, article.normal-box normal-text p a { color: #552448 !important; }

.chevron:before, .chevron:after {
  background: #552448;
}
#smarteragent-headeralt { margin-bottom: 180px !important; }
@media screen and (max-width: 719px) { #smarteragent-headeralt { margin-bottom: 110px !important; } }
.emap .type-title p.error { color: #f00 !important; font-size: 20px !important;}
@media screen and (max-width: 719px) { .emap .type-title p.error { display: block; } }
</style>
  <style type="text/css">
    /* START DEV-165 */
    .ui-tooltip .type-plain h2 {
      color: #404040;
      font-size: 14px;
      margin: 5px 0 0 0;
    }

    .ui-tooltip .type-plain h2:first-child {
      margin: 0;
    }

    .ui-tooltip .type-plain p {
      color: #808080;
      font-size: 12px;
      margin: 5px 0 0 0;
    }

    .ui-tooltip .type-plain p:first-child {
      margin: 0;
    }

    .ui-tooltip .type-plain ul {
      margin: 5px 0 0 0;
      padding: 0;
    }

    .ui-tooltip .type-plain ul li {
      color: #808080;
      font-size: 12px;
      list-style-type: square;
      margin: 0 0 0 20px;
      padding: 0;
    }

    .article-titlebar .type-tooltip {
      background: rgba(255, 255, 255, 0.5);
      border-radius: 10px;
      display: inline-block;
      font-family: Georgia, "Times New Roman", Times, serif;
      font-style: italic;
      font-weight: bold;
      height: 20px;
      line-height: 20px;
      text-align: center;
      text-decoration: none;
      width: 20px;
      font-size: 20px;
      margin-left: 10px;
    }

    .article-text .type-tooltip {
      background: rgba(112, 161, 189, 0.5);
      border-radius: 10px;
      display: inline-block;
      font-family: Georgia, "Times New Roman", Times, serif;
      font-style: italic;
      font-weight: bold;
      height: 20px;
      line-height: 20px;
      text-align: center;
      text-decoration: none;
      width: 20px;
      font-size: 20px;
      margin-left: 10px;
    }

    .ui-tooltip {
      background: #fff !important;
      border: none !important;
      box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1), 0 0 10px rgba(0, 0, 0, 0.2) !important;
      border-radius: 5px !important;
      color: #999 !important;
      display: block !important;
      font-size: 11px !important;
      font-weight: normal !important;
      padding: 10px !important;
      overflow: visible !important;
      width: 200px !important;
      z-index: 9 !important;
      z-index: 10000 !important;
    }

    .ui-tooltip .ui-tooltip-content::after {
      display: none !important;
    }

    .ui-tooltip.type-plain {
      background: #fff !important;
      border: none !important;
      box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1), 0 0 10px rgba(0, 0, 0, 0.2) !important;
      border-radius: 5px !important;
      color: #808080 !important;
      display: block !important;
      font-size: 11px !important;
      font-weight: normal !important;
      padding: 10px !important;
      overflow: visible !important;
      width: 200px !important;
      z-index: 9 !important;
    }

    .ui-tooltip-content::after {
      display: none !important;
    }

    .ui-tooltip.type-plain {
      max-width: 50% !important;
      z-index: 10000 !important;
    }

    /* END DEV-165 */

    /* DEV-276 Show recent nearby sales data in 3 columns */
    .sectionagent.spacetop-m {
      margin-top: 20px;
    }

    .sectionagent.spacetop-l {
      margin-top: 40px;
    }

    .highlight_sold_data {
      color: #F7858C;
    }

    @media screen and (min-width: 960px) {
      .sectionagent-map ul.menu {
        margin: 0 auto;
        max-width: 1200px;
        text-align: left;
      }

      .sectionagent-map ul.menu li {
        display: inline-block;
        width: 33.3%;
      }
    }

    /* DEV-276 Show recent nearby sales data in 3 columns */
  </style>

  <link href="https://api.tiles.mapbox.com/mapbox.js/v2.1.5/mapbox.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js" type="text/javascript"></script>

  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.min.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery-ui.min.js" type="text/javascript"></script>

  <script src="https://code.highcharts.com/highcharts.js"></script>

  <script src="https://api.tiles.mapbox.com/mapbox.js/v2.1.5/mapbox.js"></script>
  <script src="https://unpkg.com/leaflet@0.7.2/dist/leaflet.js"></script>

  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.maskedinput.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.number.js" type="text/javascript"></script>
  <script src="https://d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/2.4/jquery.liveaddress.min.js"></script>

  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.ui.touch-punch.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.select2.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.utility.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.site.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.form.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.animate.js" type="text/javascript"></script>
  <script src="/assets_findbuyers/js/jquery.agent.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.page.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/trumbowyg.min.js" type="text/javascript"></script>
  <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/jquery.eform.js" type="text/javascript"></script>


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/4.1.1/iframeResizer.contentWindow.min.js"></script>
  <script type="text/javascript">
    $.base_url = 'https://bhhs.findbuyers.com/';
    $(document).ready(function () {
      $.ajax_row_loading = 'https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/row-load.gif';
    });

    $.map_colors = Array();
        $.map_colors.push('#ffeda0')
        $.map_colors.push('#fed976')
        $.map_colors.push('#feb24c')
        $.map_colors.push('#fd8d3c')
        $.map_colors.push('#fc4e2a')
        $.map_colors.push('#e31a1c')
        $.map_colors.push('#bd0026')
        $.map_colors.push('#800026')
    
    $.buyers_bedroom_colors = Array();
        $.buyers_bedroom_colors.push('#ddd3da')
        $.buyers_bedroom_colors.push('#bba7b5')
        $.buyers_bedroom_colors.push('#997b91')
        $.buyers_bedroom_colors.push('#764f6c')
        $.buyers_bedroom_colors.push('#552448')
        var buyers_bedroom_colors = Array();
    if ($.buyers_bedroom_colors.length == 5) {
      buyers_bedroom_colors = $.buyers_bedroom_colors;
    }
    else {
      buyers_bedroom_colors = ['#ccd3d8', '#99a7b6', '#667b92', '#334f6d', '#002349'];
    }
  </script>

    <script src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/js/scripts_production.js" type="text/javascript"></script>
  
        <script>
      (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
          (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
          m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
      })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

      ga('create', 'UA-19333627-16', 'auto');
      ga('send', 'pageview');
    </script>
    <script type="text/javascript">

    /* Replace #your_subdomain# by the subdomain of a Site in your OneAll account */
    var oneall_subdomain = 'findbuyers';

    /* The library is loaded asynchronously */
    var oa = document.createElement('script');
    oa.type = 'text/javascript';
    oa.async = true;
    oa.src = '//' + oneall_subdomain + '.api.oneall.com/socialize/library.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(oa, s);

  </script>

  <script src="/assets_findbuyers/js/super-widget.js?v=20324" type="text/javascript"></script>
  <link href="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/css/print.css" rel="stylesheet" type="text/css" media="all">

  <!-- @Start DEV-332 Google tag manager and Seer -->
    <!-- @End DEV-332 Google tag manager and Seer -->

  
  
<!--  <script type="text/javascript">-->
<!--    window.heap=window.heap||[],heap.load=function(e,t){window.heap.appid=e,window.heap.config=t=t||{};var r=t.forceSSL||"https:"===document.location.protocol,a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=(r?"https:":"http:")+"//cdn.heapanalytics.com/js/heap-"+e+".js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(a,n);for(var o=function(e){return function(){heap.push([e].concat(Array.prototype.slice.call(arguments,0)))}},p=["addEventProperties","addUserProperties","clearEventProperties","identify","resetIdentity","removeEventProperty","setEventProperties","track","unsetEventProperty"],c=0;c<p.length;c++)heap[p[c]]=o(p[c])};-->
<!--      heap.load("1947805420");-->
<!--  </script>-->
<!--  <script type="text/javascript" defer="defer" src="//script.opentracker.net/?site=stage-findbuyers-com.hvs.buyermls.com"></script>-->
      <script>
      !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on","addSourceMiddleware","addIntegrationMiddleware","setAnonymousId","addDestinationMiddleware"];analytics.factory=function(e){return function(){var t=Array.prototype.slice.call(arguments);t.unshift(e);analytics.push(t);return analytics}};for(var e=0;e<analytics.methods.length;e++){var t=analytics.methods[e];analytics[t]=analytics.factory(t)}analytics.load=function(e,t){var n=document.createElement("script");n.type="text/javascript";n.async=!0;n.src="https://cdn.segment.com/analytics.js/v1/"+e+"/analytics.min.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=t};analytics.SNIPPET_VERSION="4.1.0";
        analytics.load("LWdh6x60FzZ4lxHp95cWadNBWo33WyeO");
        analytics.page();
      }}();
    </script>
  


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N63D67T"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<input type="hidden" id="use_google_tag_manager" value="">
<input type="hidden" id="send_seer_attempt_notification" value="">
<input type="hidden" id="send_seer_success_notification" value="">
<input type="hidden" id="send_epw_event_to_ga" value="">
<input type="hidden" id="send_ca_event_to_ga" value="">

<!-- custom google analytics event object for the epw and contact agent buttons -->
<input type="hidden" id="ga_epw_click_event_data" value="">
<input type="hidden" id="ga_ca_click_event_data" value="">

&nbsp;&nbsp;  <!-- CONTENT -->
  <div id="contentagent">

          <div id="section-form" style="background-image: url(https://bhhs.findbuyers.com/assets_findbuyers/images/background-image.jpg); display:none" class="section sectionagent sectionagent-search">
        <div class="article article-text normal-box narrow up">
          <div class="row row-text tweener">
            <h1>Great news!</h1>
            <h2>We found buyers for your home!</h2>
            <p>Please confirm your information before we continue</p>
          </div>

          <form name="frmTweener" id="frmTweener" method="post" action="https://bhhs.findbuyers.com/findbuyers/update_tweener_data" autocomplete="off" class="custom_icons2">
            <div class="row row-field narrow tweener-bedroom hide">
              <div class="fieldagent wide icon icon-bed">
                                                <select name="tweener_bedroom" id="tweener_bedroom" class="text-input format-error valid-required">
<option value="">Please Select Beds...</option>
<option value="0">0  Beds</option>
<option value="1">1  Beds</option>
<option value="2" selected="selected">2  Beds</option>
<option value="3">3  Beds</option>
<option value="4">4  Beds</option>
<option value="5">5  Beds</option>
<option value="6">6  Beds</option>
<option value="7">7  Beds</option>
<option value="8">8  Beds</option>
<option value="9">9  Beds</option>
<option value="10">10  Beds</option>
<option value="11">11  Beds</option>
<option value="12">12  Beds</option>
<option value="13">13  Beds</option>
<option value="14">14  Beds</option>
<option value="15">15  Beds</option>
<option value="16">16  Beds</option>
<option value="17">17  Beds</option>
<option value="18">18  Beds</option>
<option value="19">19  Beds</option>
<option value="20">20  Beds</option>
</select>              </div>
            </div>
            <div class="row row-field narrow tweener-bathroom hide">
              <div class="fieldagent wide icon icon-bath">
                                                <select name="tweener_bathroom" id="tweener_bathroom" class="text-input format-error valid-required">
<option value="">Please Select Baths...</option>
<option value="0">0  Baths</option>
<option value="1">1  Baths</option>
<option value="1.5">1.5  Baths</option>
<option value="2" selected="selected">2  Baths</option>
<option value="2.5">2.5  Baths</option>
<option value="3">3  Baths</option>
<option value="3.5">3.5  Baths</option>
<option value="4">4  Baths</option>
<option value="4.5">4.5  Baths</option>
<option value="5">5  Baths</option>
<option value="5.5">5.5  Baths</option>
<option value="6">6  Baths</option>
<option value="6.5">6.5  Baths</option>
<option value="7">7  Baths</option>
<option value="7.5">7.5  Baths</option>
<option value="8">8  Baths</option>
<option value="8.5">8.5  Baths</option>
<option value="9">9  Baths</option>
<option value="9.5">9.5  Baths</option>
<option value="10">10  Baths</option>
<option value="10.5">10.5  Baths</option>
<option value="11">11  Baths</option>
<option value="11.5">11.5  Baths</option>
<option value="12">12  Baths</option>
<option value="12.5">12.5  Baths</option>
<option value="13">13  Baths</option>
<option value="13.5">13.5  Baths</option>
<option value="14">14  Baths</option>
<option value="14.5">14.5  Baths</option>
<option value="15">15  Baths</option>
<option value="15.5">15.5  Baths</option>
<option value="16">16  Baths</option>
<option value="16.5">16.5  Baths</option>
<option value="17">17  Baths</option>
<option value="17.5">17.5  Baths</option>
<option value="18">18  Baths</option>
<option value="18.5">18.5  Baths</option>
<option value="19">19  Baths</option>
<option value="19.5">19.5  Baths</option>
<option value="20">20  Baths</option>
</select>              </div>
            </div>
            <div class="row row-field narrow tweener-property-type hide">
              <div class="fieldagent wide icon icon-address">
                <select autocomplete="off" class="text-input format-error valid-required" name="tweener_property_type" id="tweener_property_type">
                  <option value="">Select Property Type</option>
                  <option>Single Family Detached</option><option>Twin/Semi-Attached</option><option>Townhouse/Row/Cluster</option><option>Condo</option><option>Co-Op</option><option>Adult Community</option><option>Cluster/Patio Home</option><option>Mfg/Mobile Home</option><option>Duplex/Triplex/Quadplex</option><option>Land</option><option>Farm/Ranches</option><option>Tenancy in Common</option>                </select>
                <input type="hidden" name="tweenerPropertyType" id="tweenerPropertyType" value="Condominium">
              </div>
            </div>
            <div class="row row-field narrow tweener-approx-value hide">
              <div class="fieldagent wide icon icon-price">
                <input type="text" placeholder="My Property's Approximate Value" class="text-input format-error valid-required" name="tweener_approx_value" id="tweener_approx_value" value="438451" maxlength="11">
                <input type="hidden" name="tweener_approx_value_exist" id="tweener_approx_value_exist" value="1">
              </div>
            </div>
            <div class="row row-field narrow tweener-LivingArea hide">
              <div class="fieldagent wide icon icon-bath">
                <input type="text" placeholder="Living Area" class="text-input" name="tweener_LivingArea" id="tweener_LivingArea" value="1,445">
              </div>
            </div>
            <div class="row row-button">
              <input type="hidden" name="random_key" id="random_key" value="377eba3a9562b5726bb02f1083bdf9c2">
              <input type="button" value="Take me to my Report" class="buttonagent buttonagent-submit backgroundagent update-tweener-details">
              <input type="hidden" id="wlc_redirect_on_price_zips" value="">
              <input type="hidden" id="wlc_redirect_price_range" value="">
              <input type="hidden" id="wlc_redirect_zipcodes" value="0">
              <input type="hidden" id="wlc_redirect_url" value="">
            </div>
          </form>
        </div>
      </div>
    
    <div class="section sectionagent sectionagent-summary page2-content owner-settings-show-content" style="padding-bottom:25px; display:block">
      
      <div class="owner-settings-show" id="verified_listings"></div>

      <div class="article article-text normal-box owner-settings-hide  wide row-ajaxblock">
        <p>Market Report for:</p>
        <h1>805 Peachtree St Ne Unit 416<br>Atlanta, Ga 30308</h1>
        <div class="row row-edit">
          <p>
            <span class=""><span id="span_beds">2 beds</span></span>
            <span class=""><span id="span_baths"> | 2</span> baths</span>
            <span class=""><span id="span_livingsize"> | 1,445</span> sq.ft.</span>
          </p>
                                <div style="padding:0;">
              <a data-title="Find the home value for 805 Peachtree St Ne Unit 416, Atlanta, Ga 30308 using the Home Valuation Tool from HSF Affiliates" data-url="https://bhhs.findbuyers.com/805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308" href="https://www.addthis.com/bookmark.php?v=250&amp;pub=ra-555dd16978a6719d" class="addthis_button" style="background:none !important;border:none !important;padding:0 !important;margin:0!important;">
                <img width="105" height="30" style="border: 0" alt="Bookmark and Share" src="https://bhhs.findbuyers.com/assets/images/button-transparent-addthis.png" class="button button-transparent button-addthis">
              </a>
              <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-555dd16978a6719d" type="text/javascript"></script>
            </div>
                  </div>
      </div>

            
      <div class="article article-form normal-box owner-not-verified owner-settings-hide" style="display: '';">
              </div>
    </div>

    <div class="section sectionagent sectionagent-value animateout-fade animateout-childslide page2-content animateout-hide" style="display: block; opacity: 0;">
      <div class="article article-text normal-box normal-text" id="estimated_values_content">
            <h1>Estimated Home Value        </h1>
      <p>These values are generated by automated computer modeling drawn from public records and should not be considered a definitive statement of this property's worth.</p>
    </div>
    <div class="article article-image xwide" id="estimated_values_map">
      <div id="map-prevent-scroll" style="width: 100%; height: 363px; position: absolute; z-index: 9999;"></div>
      <div class="article article-image xwide" id="map-estimated-values" style="width: 100%; height: 363px; position: relative; overflow: hidden;"><div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);"><div class="gm-style" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;"><div tabindex="0" aria-label="Map" aria-roledescription="map" role="img" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: pan-x pan-y;"><div style="z-index: 1; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);"><div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div style="position: absolute; z-index: 982; transform: matrix(1, 0, 0, 1, -56, -55);"><div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: -512px; top: 0px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div><div style="position: absolute; left: -512px; top: -256px; width: 256px; height: 256px;"><div style="width: 256px; height: 256px;"></div></div></div></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: -1;"><div style="position: absolute; z-index: 982; transform: matrix(1, 0, 0, 1, -56, -55);"><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: 0px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: 0px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: -256px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: -256px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: -256px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: 0px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -512px; top: 0px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -512px; top: -256px;"></div></div></div><div style="width: 32px; height: 32px; overflow: hidden; position: absolute; left: -10px; top: -34px; z-index: 0;"><img alt="" src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/marker.png" draggable="false" style="position: absolute; left: 0px; top: 0px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 32px; height: 32px;"></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div style="position: absolute; z-index: 982; transform: matrix(1, 0, 0, 1, -56, -55);"><div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i69625!3i104914!4i256!2m3!1e0!2sm!3i534254966!3m12!2sen-US!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q&amp;token=36124" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i69624!3i104914!4i256!2m3!1e0!2sm!3i534254990!3m12!2sen-US!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q&amp;token=107275" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i69624!3i104913!4i256!2m3!1e0!2sm!3i534254990!3m12!2sen-US!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q&amp;token=96870" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i69625!3i104913!4i256!2m3!1e0!2sm!3i534254966!3m12!2sen-US!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q&amp;token=25719" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i69626!3i104913!4i256!2m3!1e0!2sm!3i534254966!3m12!2sen-US!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q&amp;token=106857" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i69626!3i104914!4i256!2m3!1e0!2sm!3i534254966!3m12!2sen-US!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q&amp;token=117262" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -512px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i69623!3i104914!4i256!2m3!1e0!2sm!3i534254990!3m12!2sen-US!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q&amp;token=26137" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -512px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i69623!3i104913!4i256!2m3!1e0!2sm!3i534254990!3m12!2sen-US!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q&amp;token=15732" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div></div></div></div><div class="gm-style-pbc" style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0; transition-duration: 0.2s;"><p class="gm-style-pbt"></p></div><div style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;"><div style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);"><div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;"><div title="" style="width: 32px; height: 32px; overflow: hidden; position: absolute; opacity: 0.0001; cursor: pointer; touch-action: none; left: -10px; top: -34px; z-index: 0;"><img alt="" src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/marker.png" draggable="false" style="position: absolute; left: 0px; top: 0px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 32px; height: 32px;"></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div></div></div></div><iframe aria-hidden="true" frameborder="0" tabindex="-1" style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: none;"></iframe><div></div><div></div><div></div><div></div><div><button draggable="false" title="Toggle fullscreen view" aria-label="Toggle fullscreen view" type="button" class="gm-control-active gm-fullscreen-control" style="background: none rgb(255, 255, 255); border: 0px; margin: 10px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; border-radius: 2px; height: 40px; width: 40px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; overflow: hidden; top: 0px; right: 0px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A" alt="" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A" alt="" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A" alt="" style="height: 18px; width: 18px;"></button></div><div></div><div></div><div></div><div></div><div><div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom" draggable="false" controlwidth="40" controlheight="40" style="margin: 10px; user-select: none; position: absolute; bottom: 54px; right: 40px;"><div class="gmnoprint" controlwidth="40" controlheight="40" style="display: none; position: absolute;"><div style="width: 40px; height: 40px;"><button draggable="false" title="Rotate map 90 degrees" aria-label="Rotate map 90 degrees" type="button" class="gm-control-active" style="background: none rgb(255, 255, 255); display: none; border: 0px; margin: 0px 0px 32px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; width: 40px; height: 40px; top: 0px; left: 0px; overflow: hidden; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="height: 18px; width: 18px;"></button><button draggable="false" title="Tilt map" aria-label="Tilt map" type="button" class="gm-tilt gm-control-active" style="background: none rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; width: 40px; height: 40px; top: 0px; left: 0px; overflow: hidden; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="width: 18px;"></button></div></div><div class="gm-svpc" dir="ltr" title="Drag Pegman onto the map to open Street View" controlwidth="40" controlheight="40" style="background-color: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; width: 40px; height: 40px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: none; position: absolute; left: 0px; top: 0px;"><div style="position: absolute; left: 50%; top: 50%;"></div><div style="position: absolute; left: 50%; top: 50%;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2223%22%20height%3D%2238%22%20viewBox%3D%220%200%2023%2038%22%3E%0A%3Cpath%20d%3D%22M16.6%2C38.1h-5.5l-0.2-2.9-0.2%2C2.9h-5.5L5%2C25.3l-0.8%2C2a1.53%2C1.53%2C0%2C0%2C1-1.9.9l-1.2-.4a1.58%2C1.58%2C0%2C0%2C1-1-1.9v-0.1c0.3-.9%2C3.1-11.2%2C3.1-11.2a2.66%2C2.66%2C0%2C0%2C1%2C2.3-2l0.6-.5a6.93%2C6.93%2C0%2C0%2C1%2C4.7-12%2C6.8%2C6.8%2C0%2C0%2C1%2C4.9%2C2%2C7%2C7%2C0%2C0%2C1%2C2%2C4.9%2C6.65%2C6.65%2C0%2C0%2C1-2.2%2C5l0.7%2C0.5a2.78%2C2.78%2C0%2C0%2C1%2C2.4%2C2s2.9%2C11.2%2C2.9%2C11.3a1.53%2C1.53%2C0%2C0%2C1-.9%2C1.9l-1.3.4a1.63%2C1.63%2C0%2C0%2C1-1.9-.9l-0.7-1.8-0.1%2C12.7h0Zm-3.6-2h1.7L14.9%2C20.3l1.9-.3%2C2.4%2C6.3%2C0.3-.1c-0.2-.8-0.8-3.2-2.8-10.9a0.63%2C0.63%2C0%2C0%2C0-.6-0.5h-0.6l-1.1-.9h-1.9l-0.3-2a4.83%2C4.83%2C0%2C0%2C0%2C3.5-4.7A4.78%2C4.78%200%200%2C0%2011%202.3H10.8a4.9%2C4.9%2C0%2C0%2C0-1.4%2C9.6l-0.3%2C2h-1.9l-1%2C.9h-0.6a0.74%2C0.74%2C0%2C0%2C0-.6.5c-2%2C7.5-2.7%2C10-3%2C10.9l0.3%2C0.1%2C2.5-6.3%2C1.9%2C0.3%2C0.2%2C15.8h1.6l0.6-8.4a1.52%2C1.52%2C0%2C0%2C1%2C1.5-1.4%2C1.5%2C1.5%2C0%2C0%2C1%2C1.5%2C1.4l0.9%2C8.4h0Zm-10.9-9.6h0Zm17.5-.1h0Z%22%20style%3D%22fill%3A%23333%3Bopacity%3A0.7%3Bisolation%3Aisolate%22%2F%3E%0A%3Cpath%20d%3D%22M5.9%2C13.6l1.1-.9h7.8l1.2%2C0.9%22%20style%3D%22fill%3A%23ce592c%22%2F%3E%0A%3Cellipse%20cx%3D%2210.9%22%20cy%3D%2213.1%22%20rx%3D%222.7%22%20ry%3D%220.3%22%20style%3D%22fill%3A%23ce592c%3Bopacity%3A0.5%3Bisolation%3Aisolate%22%2F%3E%0A%3Cpath%20d%3D%22M20.6%2C26.1l-2.9-11.3a1.71%2C1.71%2C0%2C0%2C0-1.6-1.2H5.7a1.69%2C1.69%2C0%2C0%2C0-1.5%2C1.3l-3.1%2C11.3a0.61%2C0.61%2C0%2C0%2C0%2C.3.7l1.1%2C0.4a0.61%2C0.61%2C0%2C0%2C0%2C.7-0.3l2.7-6.7%2C0.2%2C16.8h3.6l0.6-9.3a0.47%2C0.47%2C0%2C0%2C1%2C.44-0.5h0.06c0.4%2C0%2C.4.2%2C0.5%2C0.5l0.6%2C9.3h3.6L15.7%2C20.3l2.5%2C6.6a0.52%2C0.52%2C0%2C0%2C0%2C.66.31h0l1.2-.4a0.57%2C0.57%2C0%2C0%2C0%2C.5-0.7h0Z%22%20style%3D%22fill%3A%23fdbf2d%22%2F%3E%0A%3Cpath%20d%3D%22M7%2C13.6l3.9%2C6.7%2C3.9-6.7%22%20style%3D%22fill%3A%23cf572e%3Bopacity%3A0.6%3Bisolation%3Aisolate%22%2F%3E%0A%3Ccircle%20cx%3D%2210.9%22%20cy%3D%227%22%20r%3D%225.9%22%20style%3D%22fill%3A%23fdbf2d%22%2F%3E%0A%3C%2Fsvg%3E%0A" aria-label="Street View Pegman Control" style="height: 30px; width: 30px; position: absolute; transform: translate(-50%, -50%); pointer-events: none;"><img src="data:image/svg+xml,%3Csvg%20width%3D%2224px%22%20height%3D%2238px%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20viewBox%3D%220%200%2024%2038%22%3E%0A%3Cpath%20d%3D%22M22%2C26.6l-2.9-11.3a2.78%2C2.78%2C0%2C0%2C0-2.4-2l-0.7-.5a6.82%2C6.82%2C0%2C0%2C0%2C2.2-5%2C6.9%2C6.9%2C0%2C0%2C0-13.8%2C0%2C7%2C7%2C0%2C0%2C0%2C2.2%2C5.1l-0.6.5a2.55%2C2.55%2C0%2C0%2C0-2.3%2C2s-3%2C11.1-3%2C11.2v0.1a1.58%2C1.58%2C0%2C0%2C0%2C1%2C1.9l1.2%2C0.4a1.63%2C1.63%2C0%2C0%2C0%2C1.9-.9l0.8-2%2C0.2%2C12.8h11.3l0.2-12.6%2C0.7%2C1.8a1.54%2C1.54%2C0%2C0%2C0%2C1.5%2C1%2C1.09%2C1.09%2C0%2C0%2C0%2C.5-0.1l1.3-.4a1.85%2C1.85%2C0%2C0%2C0%2C.7-2h0Zm-1.2.9-1.2.4a0.61%2C0.61%2C0%2C0%2C1-.7-0.3l-2.5-6.6-0.2%2C16.8h-9.4L6.6%2C21l-2.7%2C6.7a0.52%2C0.52%2C0%2C0%2C1-.66.31h0l-1.1-.4a0.52%2C0.52%2C0%2C0%2C1-.31-0.66v0l3.1-11.3a1.69%2C1.69%2C0%2C0%2C1%2C1.5-1.3h0.2l1-.9h2.3a5.9%2C5.9%2C0%2C1%2C1%2C3.2%2C0h2.3l1.1%2C0.9h0.2a1.71%2C1.71%2C0%2C0%2C1%2C1.6%2C1.2l2.9%2C11.3a0.84%2C0.84%2C0%2C0%2C1-.4.7h0Z%22%20style%3D%22fill%3A%23333%3Bfill-opacity%3A0.2%22%2F%3E%22%0A%3C%2Fsvg%3E%0A%0A" aria-label="Pegman is on top of the Map" style="display: none; height: 30px; width: 30px; position: absolute; transform: translate(-50%, -50%); pointer-events: none;"><img src="data:image/svg+xml,%3Csvg%20width%3D%2240px%22%20height%3D%2250px%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20viewBox%3D%220%200%2040%2050%22%3E%0A%3Cpath%20d%3D%22M34.00%2C-30.40l-2.9-11.3a2.78%2C2.78%2C0%2C0%2C0-2.4-2l-0.7-.5a6.82%2C6.82%2C0%2C0%2C0%2C2.2-5%2C6.9%2C6.9%2C0%2C0%2C0-13.8%2C0%2C7%2C7%2C0%2C0%2C0%2C2.2%2C5.1l-0.6.5a2.55%2C2.55%2C0%2C0%2C0-2.3%2C2s-3%2C11.1-3%2C11.2v0.1a1.58%2C1.58%2C0%2C0%2C0%2C1%2C1.9l1.2%2C0.4a1.63%2C1.63%2C0%2C0%2C0%2C1.9-.9l0.8-2%2C0.2%2C12.8h11.3l0.2-12.6%2C0.7%2C1.8a1.54%2C1.54%2C0%2C0%2C0%2C1.5%2C1%2C1.09%2C1.09%2C0%2C0%2C0%2C.5-0.1l1.3-.4a1.85%2C1.85%2C0%2C0%2C0%2C.7-2h0Zm-1.2.9-1.2.4a0.61%2C0.61%2C0%2C0%2C1-.7-0.3l-2.5-6.6-0.2%2C16.8h-9.4L18.60%2C-36.00l-2.7%2C6.7a0.52%2C0.52%2C0%2C0%2C1-.66.31h0l-1.1-.4a0.52%2C0.52%2C0%2C0%2C1-.31-0.66v0l3.1-11.3a1.69%2C1.69%2C0%2C0%2C1%2C1.5-1.3h0.2l1-.9h2.3a5.9%2C5.9%2C0%2C1%2C1%2C3.2%2C0h2.3l1.1%2C0.9h0.2a1.71%2C1.71%2C0%2C0%2C1%2C1.6%2C1.2l2.9%2C11.3a0.84%2C0.84%2C0%2C0%2C1-.4.7h0Zm1.2%2C59.1-2.9-11.3a2.78%2C2.78%2C0%2C0%2C0-2.4-2l-0.7-.5a6.82%2C6.82%2C0%2C0%2C0%2C2.2-5%2C6.9%2C6.9%2C0%2C0%2C0-13.8%2C0%2C7%2C7%2C0%2C0%2C0%2C2.2%2C5.1l-0.6.5a2.55%2C2.55%2C0%2C0%2C0-2.3%2C2s-3%2C11.1-3%2C11.2v0.1a1.58%2C1.58%2C0%2C0%2C0%2C1%2C1.9l1.2%2C0.4a1.63%2C1.63%2C0%2C0%2C0%2C1.9-.9l0.8-2%2C0.2%2C12.8h11.3l0.2-12.6%2C0.7%2C1.8a1.54%2C1.54%2C0%2C0%2C0%2C1.5%2C1%2C1.09%2C1.09%2C0%2C0%2C0%2C.5-0.1l1.3-.4a1.85%2C1.85%2C0%2C0%2C0%2C.7-2h0Zm-1.2.9-1.2.4a0.61%2C0.61%2C0%2C0%2C1-.7-0.3l-2.5-6.6-0.2%2C16.8h-9.4L18.60%2C24.00l-2.7%2C6.7a0.52%2C0.52%2C0%2C0%2C1-.66.31h0l-1.1-.4a0.52%2C0.52%2C0%2C0%2C1-.31-0.66v0l3.1-11.3a1.69%2C1.69%2C0%2C0%2C1%2C1.5-1.3h0.2l1-.9h2.3a5.9%2C5.9%2C0%2C1%2C1%2C3.2%2C0h2.3l1.1%2C0.9h0.2a1.71%2C1.71%2C0%2C0%2C1%2C1.6%2C1.2l2.9%2C11.3a0.84%2C0.84%2C0%2C0%2C1-.4.7h0Z%22%20style%3D%22fill%3A%23333%3Bfill-opacity%3A0.2%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M15.40%2C38.80h-4a1.64%2C1.64%2C0%2C0%2C1-1.4-1.1l-3.1-8a0.9%2C0.9%2C0%2C0%2C1-.5.1l-1.4.1a1.62%2C1.62%2C0%2C0%2C1-1.6-1.4l-1.1-13.1%2C1.6-1.3a6.87%2C6.87%2C0%2C0%2C1-3-4.6A7.14%2C7.14%200%200%2C1%202%204a7.6%2C7.6%2C0%2C0%2C1%2C4.7-3.1%2C7.14%2C7.14%2C0%2C0%2C1%2C5.5%2C1.1%2C7.28%2C7.28%2C0%2C0%2C1%2C2.3%2C9.6l2.1-.1%2C0.1%2C1c0%2C0.2.1%2C0.5%2C0.1%2C0.8a2.41%2C2.41%2C0%2C0%2C1%2C1%2C1s1.9%2C3.2%2C2.8%2C4.9c0.7%2C1.2%2C2.1%2C4.2%2C2.8%2C5.9a2.1%2C2.1%2C0%2C0%2C1-.8%2C2.6l-0.6.4a1.63%2C1.63%2C0%2C0%2C1-1.5.2l-0.6-.3a8.93%2C8.93%2C0%2C0%2C0%2C.5%2C1.3%2C7.91%2C7.91%2C0%2C0%2C0%2C1.8%2C2.6l0.6%2C0.3v4.6l-4.5-.1a7.32%2C7.32%2C0%2C0%2C1-2.5-1.5l-0.4%2C3.6h0Zm-10-19.2%2C3.5%2C9.8%2C2.9%2C7.5h1.6V35l-1.9-9.4%2C3.1%2C5.4a8.24%2C8.24%2C0%2C0%2C0%2C3.8%2C3.8h2.1v-1.4a14%2C14%2C0%2C0%2C1-2.2-3.1%2C44.55%2C44.55%2C0%2C0%2C1-2.2-8l-1.3-6.3%2C3.2%2C5.6c0.6%2C1.1%2C2.1%2C3.6%2C2.8%2C4.9l0.6-.4c-0.8-1.6-2.1-4.6-2.8-5.8-0.9-1.7-2.8-4.9-2.8-4.9a0.54%2C0.54%2C0%2C0%2C0-.4-0.3l-0.7-.1-0.1-.7a4.33%2C4.33%2C0%2C0%2C0-.1-0.5l-5.3.3%2C2.2-1.9a4.3%2C4.3%2C0%2C0%2C0%2C.9-1%2C5.17%2C5.17%2C0%2C0%2C0%2C.8-4%2C5.67%2C5.67%2C0%2C0%2C0-2.2-3.4%2C5.09%2C5.09%2C0%2C0%2C0-4-.8%2C5.67%2C5.67%2C0%2C0%2C0-3.4%2C2.2%2C5.17%2C5.17%2C0%2C0%2C0-.8%2C4%2C5.67%2C5.67%2C0%2C0%2C0%2C2.2%2C3.4%2C3.13%2C3.13%2C0%2C0%2C0%2C1%2C.5l1.6%2C0.6-3.2%2C2.6%2C1%2C11.5h0.4l-0.3-8.2h0Z%22%20style%3D%22fill%3A%23333%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M3.35%2C15.90l1.1%2C12.5a0.39%2C0.39%2C0%2C0%2C0%2C.36.42l0.14%2C0%2C1.4-.1a0.66%2C0.66%2C0%2C0%2C0%2C.5-0.4l-0.2-3.8-3.3-8.6h0Z%22%20style%3D%22fill%3A%23fdbf2d%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M5.20%2C28.80l1.1-.1a0.66%2C0.66%2C0%2C0%2C0%2C.5-0.4l-0.2-3.8-1.2-3.1Z%22%20style%3D%22fill%3A%23ce592b%3Bfill-opacity%3A0.25%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M21.40%2C35.70l-3.8-1.2-2.7-7.8L12.00%2C15.5l3.4-2.9c0.2%2C2.4%2C2.2%2C14.1%2C3.7%2C17.1%2C0%2C0%2C1.3%2C2.6%2C2.3%2C3.1v2.9m-8.4-8.1-2-.3%2C2.5%2C10.1%2C0.9%2C0.4v-2.9%22%20style%3D%22fill%3A%23e5892b%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M17.80%2C25.40c-0.4-1.5-.7-3.1-1.1-4.8-0.1-.4-0.1-0.7-0.2-1.1l-1.1-2-1.7-1.6s0.9%2C5%2C2.4%2C7.1a19.12%2C19.12%2C0%2C0%2C0%2C1.7%2C2.4h0Z%22%20style%3D%22fill%3A%23cf572e%3Bopacity%3A0.6%3Bisolation%3Aisolate%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M14.40%2C37.80h-3a0.43%2C0.43%2C0%2C0%2C1-.4-0.4l-3-7.8-1.7-4.8-3-9%2C8.9-.4s2.9%2C11.3%2C4.3%2C14.4c1.9%2C4.1%2C3.1%2C4.7%2C5%2C5.8h-3.2s-4.1-1.2-5.9-7.7a0.59%2C0.59%2C0%2C0%2C0-.6-0.4%2C0.62%2C0.62%2C0%2C0%2C0-.3.7s0.5%2C2.4.9%2C3.6a34.87%2C34.87%2C0%2C0%2C0%2C2%2C6h0Z%22%20style%3D%22fill%3A%23fdbf2d%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M15.40%2C12.70l-3.3%2C2.9-8.9.4%2C3.3-2.7%22%20style%3D%22fill%3A%23ce592b%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M9.10%2C21.10l1.4-6.2-5.9.5%22%20style%3D%22fill%3A%23cf572e%3Bopacity%3A0.6%3Bisolation%3Aisolate%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M12.00%2C13.5a4.75%2C4.75%2C0%2C0%2C1-2.6%2C1.1c-1.5.3-2.9%2C0.2-2.9%2C0s1.1-.6%2C2.7-1%22%20style%3D%22fill%3A%23bb3d19%22%3E%3C%2Fpath%3E%0A%3Ccircle%20cx%3D%227.92%22%20cy%3D%228.19%22%20r%3D%226.3%22%20style%3D%22fill%3A%23fdbf2d%22%3E%3C%2Fcircle%3E%0A%3Cpath%20d%3D%22M4.70%2C13.60a6.21%2C6.21%2C0%2C0%2C0%2C8.4-1.9v-0.1a8.89%2C8.89%2C0%2C0%2C1-8.4%2C2h0Z%22%20style%3D%22fill%3A%23ce592b%3Bfill-opacity%3A0.25%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M21.20%2C27.20l0.6-.4a1.09%2C1.09%2C0%2C0%2C0%2C.4-1.3c-0.7-1.5-2.1-4.6-2.8-5.8-0.9-1.7-2.8-4.9-2.8-4.9a1.6%2C1.6%2C0%2C0%2C0-2.17-.65l-0.23.15a1.68%2C1.68%2C0%2C0%2C0-.4%2C2.1s2.3%2C3.9%2C3.1%2C5.3c0.6%2C1%2C2.1%2C3.7%2C2.9%2C5.1a0.94%2C0.94%2C0%2C0%2C0%2C1.24.49l0.16-.09h0Z%22%20style%3D%22fill%3A%23fdbf2d%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M19.40%2C19.80c-0.9-1.7-2.8-4.9-2.8-4.9a1.6%2C1.6%2C0%2C0%2C0-2.17-.65l-0.23.15-0.3.3c1.1%2C1.5%2C2.9%2C3.8%2C3.9%2C5.4%2C1.1%2C1.8%2C2.9%2C5%2C3.8%2C6.7l0.1-.1a1.09%2C1.09%2C0%2C0%2C0%2C.4-1.3%2C57.67%2C57.67%2C0%2C0%2C0-2.7-5.6h0Z%22%20style%3D%22fill%3A%23ce592b%3Bfill-opacity%3A0.25%22%3E%3C%2Fpath%3E%0A%3C%2Fsvg%3E%0A" aria-label="Street View Pegman Control" style="display: none; height: 40px; width: 40px; position: absolute; transform: translate(-60%, -45%); pointer-events: none;"></div></div></div></div><div><div style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;"><a target="_blank" rel="noopener" href="https://maps.google.com/maps?ll=33.776621,-84.384313&amp;z=18&amp;t=m&amp;hl=en-US&amp;gl=US&amp;mapclient=apiv3" title="Open this area in Google Maps (opens a new window)" style="position: static; overflow: visible; float: none; display: inline;"><div style="width: 66px; height: 26px; cursor: pointer;"><img alt="" src="https://maps.gstatic.com/mapfiles/api-3/images/google4.png" draggable="false" style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; user-select: none; border: 0px; padding: 0px; margin: 0px;"></div></a></div></div><div></div><div><div class="gmnoprint" style="z-index: 1000001; position: absolute; right: 166px; bottom: 0px; width: 54px;"><div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a style="text-decoration: none; cursor: pointer; display: none;">Map Data</a><span>Map data ©2020 Google</span></div></div></div><div class="gmnoprint gm-style-cc" draggable="false" style="z-index: 1000001; user-select: none; height: 14px; line-height: 14px; position: absolute; right: 95px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a href="https://www.google.com/intl/en-US_US/help/terms_maps.html" target="_blank" rel="noopener" style="text-decoration: none; cursor: pointer; color: rgb(0, 0, 0);">Terms of Use</a></div></div><div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px; position: absolute; right: 0px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a target="_blank" rel="noopener" title="Report errors in the road map or imagery to Google" dir="ltr" href="https://www.google.com/maps/@33.776621,-84.384313,18z/data=!10m1!1e1!12b1?source=apiv3&amp;rapsrc=apiv3" style="font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); text-decoration: none; position: relative;">Report a map error</a></div></div><div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;"><div style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(0, 0, 0); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">Map data ©2020 Google</div></div></div><div style="background-color: white; padding: 15px 21px; border: 1px solid rgb(171, 171, 171); font-family: Roboto, Arial, sans-serif; color: rgb(34, 34, 34); box-sizing: border-box; box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; z-index: 10000002; display: none; width: 300px; height: 180px; position: absolute; left: 219px; top: 92px;"><div style="padding: 0px 0px 10px; font-size: 16px; box-sizing: border-box;">Map Data</div><div style="font-size: 13px;">Map data ©2020 Google</div><button draggable="false" title="Close" aria-label="Close" type="button" class="gm-ui-hover-effect" style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; top: 0px; right: 0px; width: 37px; height: 37px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224px%22%20height%3D%2224px%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23000000%22%3E%0A%20%20%20%20%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22%2F%3E%0A%20%20%20%20%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22%2F%3E%0A%3C%2Fsvg%3E%0A" style="pointer-events: none; display: block; width: 13px; height: 13px; margin: 12px;"></button></div></div></div></div>
    </div>


                  <div class="article article-list narrow">
            <ul class="menu">
              <li class="animate-child" style="top: 200px;"><h2 class="coloragent slider01" id="ca-estimate" data-slidervalue="380000|474000">$427,000</h2><p>Range: $380,000 to $474,000</p><p class="text-small">Powered by</p><a href="http://collateralanalytics.com" target="_blank"><img src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/images/agentlogo-collateral.png"></a></li><li class="animate-child" style="top: 200px;"><h2 class="coloragent slider01" id="zillow-estimate" data-slidervalue="427407|472397">$449,902</h2><p>Range: $427,407 to $472,397</p><p class="text-small">Zestimate from</p><a target="_blank" href="https://www.zillow.com/"><img src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/assets_findbuyers/images/agentlogo-zillow.png"></a></li><li class="animate-child" style="display: none; top: 200px;"><h2 class="coloragent slider01" id="valuation-estimate" data-slidervalue="" style="margin: 90px 0 0;">$0</h2><p id="valuation-range">Your Estimated Value</p></li>            </ul>
        </div>
      
  </div>

    <div class="section sectionagent animatein-fade animateout-fade page2-content animateout-hide" style="display: block; opacity: 0;" id="buyer_list_contact_agent">
    <div class="article article-text normal-box normal-text narrow thin-top">
      <h2>The best evaluation comes from a Berkshire Hathaway HomeServices Network real estate professional <br> performing a Comparative Market Analysis (CMA) <br>
It's free, and comes with no obligation</h2>      <div class="row row-button">
                  <a class="buttonagent buttonagent-click click-show2 type-br" data-show="agentform-01">Contact a Berkshire Hathaway HomeServices Network Member</a>
              </div>
    </div>
  </div>
  
  <div class="section sectionagent hide" id="agentform-01">
    <div class="article article-text normal-box normal-text xnarrow relate">
      <form name="publicMessage" id="publicMessage" method="post" action="https://bhhs.findbuyers.com/findbuyers/send_message_contact_form" autocomplete="off" class="custom_icons2">
        <div id="brokerage_contact_info" style="text-align:center; margin-top: 16px;"><div style="font-size: larger;">Berkshire Hathaway HomeServices</div><div>(770) 972-3811</div></div>        <div class="row row-field">
          <div class="fieldagent narrow icon icon-name">
            <input class="text-input format-error valid-required" placeholder="Your First Name" type="text" name="firstname" id="firstname" value="">
          </div>
          <div class="fieldagent narrow icon icon-name">
            <input class="text-input format-error valid-required" placeholder="Your Last Name" type="text" name="lastname" id="lastname" value="">
          </div>
        </div>
        <div class="row row-field">
          <div class="fieldagent wide icon icon-email">
            <input class="text-input format-error valid-required valid-email" placeholder="Your Email" type="text" name="email" id="email" value="">
          </div>
        </div>
        <div class="row row-field">
          <div class="fieldagent wide icon icon-phone">
            <input class="text-input format-error valid-required format-phone" placeholder=" Your Phone Number" type="text" name="tel" id="tel">
          </div>
        </div>
        
        <div class="row row-field working-with-agent-yes hide">
          <div class="fieldagent wide icon icon-name">
            <input placeholder="Agent's Name" type="text" name="agent_name" id="agent_name" class="text-input format-error">
          </div>
        </div>
        <div class="row row-field" id="add_interest">
          <div class="fieldagent wide icon icon-name">
            <select name="interest" id="interest" class="text-input format-error republic-interest valid-required" data-class="public-interest">
              <option value="" selected="">I am a</option>
              <option value="1">buyer</option>
              <option value="2">seller</option>
              <option value="3">buyer and seller</option>
              <option value="4">broker/agent</option>
            </select>
          </div>
        </div>
        <div class="row row-field public-interest sell-home hide">
          <div class="fieldagent wide icon icon-address">
            <input class="text-input valid-required" name="address" id="listing_address" placeholder="Address" type="text" value="805 Peachtree St Ne Unit 416, Atlanta, Ga 30308">
            <input type="hidden" name="FullStreetAddress" id="FullStreetAddress" value="">
            <input type="hidden" name="address1" id="address1" value="">
            <input type="hidden" name="address2" id="address2" value="">
            <input type="hidden" name="UnitNumber" id="UnitNumber" value="">
            <input type="hidden" name="StreetName" id="StreetName" value="">
            <input type="hidden" name="StreetNumber" id="StreetNumber" value="">
            <input type="hidden" name="StreetSuffix" id="StreetSuffix" value="">
            <input type="hidden" name="City" id="City" value="">
            <input type="hidden" name="State" id="State" value="">
            <input type="hidden" name="PostalCode" id="PostalCode" value="">
            <input type="hidden" name="Zip4" id="Zip4" value="">
            <input type="hidden" name="Latitude" id="Latitude" value="33.776621">
            <input type="hidden" name="Longitude" id="Longitude" value="-84.384313">
          </div>
        </div>
        <div class="row row-field public-interest sell-home hide">
          <div class="fieldagent wide icon icon-price">
            <input placeholder="My Property's Approximate Value" type="text" name="approximate_value" id="approximate_value" class="text-input valid-required" maxlength="11">
          </div>
        </div>
        <div class="row row-field public-interest sell-home hide">
          <div class="fieldagent wide icon icon-time">
            <select name="time_frame" id="time_frame" class="text-input" placeholder="Time Frame for Selling">
<option value="0" selected="selected">Time Frame for Selling</option>
<option value="15">Immediately</option>
<option value="90">1 to 3 Months</option>
<option value="180">3 - 6 Months</option>
<option value="365">6 - 12 Months</option>
<option value="730">12+ Months</option>
</select>          </div>
        </div>
        <div class="row row-field public-interest sell-home-hidden hide">
          <div class="fieldagent wide icon icon-bed">
            <input type="hidden" name="bedroom" id="bedroom" value="2">
          </div>
        </div>
        <div class="row row-field public-interest sell-home-hidden hide">
          <div class="fieldagent wide icon icon-bed">
            <input type="hidden" name="bathroom" id="bathroom" value="2.0">
          </div>
        </div>
        <div class="row row-field public-interest contact-agent hide ">
          <div class="fieldagent wide">
            <textarea name="message" id="message" placeholder="" class="text-input"></textarea>
          </div>
        </div>
        <div class="row row-button">
          <input type="hidden" name="type" id="type" value="listing">
          <input type="hidden" name="random_key" id="random_key" value="377eba3a9562b5726bb02f1083bdf9c2">
          <input type="hidden" name="to_agent_id" id="to_agent_id" value="78014">
          <input type="hidden" name="to_team_id" id="to_team_id" value="">
          <input type="hidden" name="brand_id" id="brand_id" value="25356">
          <input type="hidden" name="brokerage_id" id="brokerage_id" value="29959">
          <input type="button" value="Send" name="contact_agent_public" id="contact_agent_public" class="buttonagent buttonagent-click">
        </div>
      </form>
    </div>
  </div>
  
          <div class="section sectionagent sectionagent-stats animatein-fade animateout-fade children-4 page2-content animateout-hide" style="display: block; opacity: 0;" id="heatmap_section">
        <div class="article article-titlebar backgroundagent" id="heatmap_container_title" style="margin-top: 40px;">
          <h1>We know where and what buyers are searching for...                      </h1>
          <p>These statistics reflect the overall trends among buyers in this area for the last 90 days.</p>
        </div>
        <input type="hidden" id="heatmap_zoom_level" value="11">
        <div class="section sectionagent sectionagent-location" id="buyer_heat_map">
          <div class="article article-text">
            <div class="row row-map">
              <div class="layer-text" style="display:none"><p>BUYER HEATMAP</p></div>
              <div id="map" style="width: 100%;"></div>
            </div>
          </div>
        </div>

        <div class="article article-list normal-box" id="num_buyers_by_price_range" style="margin-top: 40px;"></div>

        <div class="article article-list normal-box" id="num_showings_by_price_range" style="margin-top: 40px;"></div>

                  <div class="article article-list normal-box thin-bottom" style="margin-top: 40px;">
            <h2>By Bedroom</h2>
                        <div class="row row-googlechart short" id="buyers_by_bedroom"><div style="position: relative;"><div dir="ltr" style="position: relative; width: 145px; height: 280px;"><div style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;" aria-label="A chart."><svg width="145" height="280" aria-label="A chart." style="overflow: hidden;"><defs id="_ABSTRACT_RENDERER_ID_1"></defs><rect x="0" y="0" width="145" height="280" stroke="none" stroke-width="0" fill="#ffffff"></rect><g><rect x="105" y="20" width="40" height="133" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g column-id="1 Bed"><rect x="105" y="20" width="40" height="28" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="122" y="30.2" font-family="Lato" font-size="12" stroke="none" stroke-width="0" fill="#808080">1</text><text text-anchor="start" x="122" y="46.2" font-family="Lato" font-size="12" stroke="none" stroke-width="0" fill="#808080">Bed</text></g><circle cx="111" cy="26" r="6" stroke="none" stroke-width="0" fill="#bba7b5"></circle></g><g column-id="2 Bed"><rect x="105" y="55" width="40" height="28" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="122" y="65.2" font-family="Lato" font-size="12" stroke="none" stroke-width="0" fill="#808080">2</text><text text-anchor="start" x="122" y="81.2" font-family="Lato" font-size="12" stroke="none" stroke-width="0" fill="#808080">Bed</text></g><circle cx="111" cy="61" r="6" stroke="none" stroke-width="0" fill="#997b91"></circle></g><g column-id="3 Bed"><rect x="105" y="90" width="40" height="28" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="122" y="100.2" font-family="Lato" font-size="12" stroke="none" stroke-width="0" fill="#808080">3</text><text text-anchor="start" x="122" y="116.2" font-family="Lato" font-size="12" stroke="none" stroke-width="0" fill="#808080">Bed</text></g><circle cx="111" cy="96" r="6" stroke="none" stroke-width="0" fill="#764f6c"></circle></g><g column-id="4+ Bed"><rect x="105" y="125" width="40" height="28" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="122" y="135.2" font-family="Lato" font-size="12" stroke="none" stroke-width="0" fill="#808080">4+</text><text text-anchor="start" x="122" y="151.2" font-family="Lato" font-size="12" stroke="none" stroke-width="0" fill="#808080">Bed</text></g><circle cx="111" cy="131" r="6" stroke="none" stroke-width="0" fill="#552448"></circle></g></g><g><path d="M45,95L45,68A45,45,0,0,1,87.79754323328191,99.09423525312737L62.119017293312766,107.43769410125094A18,18,0,0,0,45,95" stroke="#ffffff" stroke-width="1" fill="#bba7b5"></path></g><g><path d="M27.318829486883605,109.62713633745696L0.7970737172090097,104.56784084364239A45,45,0,0,1,45,68L45,95A18,18,0,0,0,27.318829486883605,109.62713633745696" stroke="#ffffff" stroke-width="1" fill="#552448"></path></g><g><path d="M45,131L45,158A45,45,0,0,1,0.7970737172090097,104.56784084364239L27.318829486883605,109.62713633745696A18,18,0,0,0,45,131" stroke="#ffffff" stroke-width="1" fill="#764f6c"></path></g><g><path d="M62.119017293312766,107.43769410125094L87.79754323328191,99.09423525312737A45,45,0,0,1,45,158L45,131A18,18,0,0,0,62.119017293312766,107.43769410125094" stroke="#ffffff" stroke-width="1" fill="#997b91"></path></g><g></g></svg><div aria-label="A tabular representation of the data in the chart." style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;"><table><thead><tr><th>Beds</th><th>%</th></tr></thead><tbody><tr><td>Studio</td><td>0</td></tr><tr><td>1 Bed</td><td>20</td></tr><tr><td>2 Bed</td><td>30</td></tr><tr><td>3 Bed</td><td>28</td></tr><tr><td>4+ Bed</td><td>22</td></tr></tbody></table></div></div></div><div aria-hidden="true" style="display: none; position: absolute; top: 290px; left: 155px; white-space: nowrap; font-family: Lato; font-size: 12px;">4+</div><div></div></div></div>
            <script type="text/javascript">
              google.charts.load("visualization", "1", {packages:["corechart"]});
              google.charts.setOnLoadCallback(buyersByBedsChart);
              function buyersByBedsChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Beds', '%', {role: 'tooltip', p: {html: true}}],
                  ['Studio', 0, 'Studio<br />'+0+'%'],
                  ['1 Bed', 20, '1 Bed<br />'+20+'%'],
                  ['2 Bed', 30, '2 Bed<br />'+30+'%'],
                  ['3 Bed', 28, '3 Bed<br />'+28+'%'],
                  ['4+ Bed', 22, '4+ Bed<br />'+22+'%']]);
                var options = {
                  title: '',
                  colors: buyers_bedroom_colors,
                  chartArea: {left: 0, top: 20, width: '100%', height: '200px',},
                  legend: {textStyle: {bold: false, color: '#808080', fontName: 'Lato', fontSize: 12}, top: 20},
                  pieHole: 0.4,
                  pieSliceTextStyle: {bold: true, color: '#fff', fontName: 'Lato', fontSize: 14},
                  tooltip: {textStyle: {bold: false, color: '#808080', fontName: 'Lato', fontSize: 12}, isHtml: true}
                };
                var chart = new google.visualization.PieChart(document.getElementById('buyers_by_bedroom'));
                chart.draw(data, options);
              }
              //
              // $(window).resize(function () {
              //   buyersByBedsChart();
              // });
              //
              // $(document).ready(function () {
              //   buyersByBedsChart();
              // });
              //
              $(window).load(function () {
                buyersByBedsChart();
              });
              //
              // $(window).trigger('resize');
            </script>
          </div>
        
        
      </div>
    
    
          <div class="row row-button cta-button page2-content" style="display: block">
        <div class="row row-button">
          <a class="buttonagent buttonagent-click click-show2 nohash type-br" data-target="buyer_list_contact_jumper" data-show="agentform-02" id="funnel_contact" style="margin-bottom: 20px; display: none;">
            Contact a Berkshire Hathaway HomeServices Network Member          </a>
        </div>
      </div>
    
    
    
    <form name="frmBuyerSearch" id="frmBuyerSearch" action="https://bhhs.findbuyers.com/findbuyers/buyers_list_phase2" method="post" autocomplete="off">
      <!-- Basic Search -->
      <input type="hidden" name="search_by" id="search_by" value="zipcode">
      <input type="hidden" name="zipcode" id="zipcode" value="30308">
      <input type="hidden" name="city" id="city" value="Atlanta">
      <input type="hidden" name="State" id="State" value="Ga">
      <input type="hidden" name="address1" id="address1" value="805 Peachtree St Ne Unit 416">
      <input type="hidden" name="beds" id="beds" value="2">
      <input type="hidden" name="baths" id="baths" value="2">
      <input type="hidden" name="from_price" id="from_price" value="380000">
      <input type="hidden" name="to_price" id="to_price" value="474000">
      <input type="hidden" name="brand_id" id="brand_id" value="25356">
      <input type="hidden" name="brokerage_id" id="brokerage_id" value="29959">
      <input type="hidden" name="show_stats_by_brand" id="show_stats_by_brand" value="1">
      <input type="hidden" name="entire_buyside_network" id="entire_buyside_network" value="0">
      <input type="hidden" name="LMI" id="LMI" value="1">
      <input type="hidden" name="agent_id" id="agent_id" value="78014">
      <input type="hidden" name="team_id" id="team_id" value="">
      <input type="hidden" name="agent_branded_page" id="agent_branded_page" value="0">
      <input type="hidden" name="fb_latitude" id="fb_latitude" value="33.776621">
      <input type="hidden" name="fb_longitude" id="fb_longitude" value="-84.384313">
      <input type="hidden" name="buyer_matches_interval" id="buyer_matches_interval" value="90">
      <input type="hidden" name="min_featured_buyers_to_display_list" id="min_featured_buyers_to_display_list" value="6">
            <input type="hidden" name="address_key" id="address_key" value="805 Peachtree St Ne Unit 416">
    </form>
    <input type="hidden" name="limit" id="limit" value="0">
    <input type="hidden" name="page_limit" id="page_limit" value="12">
    <input type="hidden" name="autoload" id="autoload" value="1">

    
              <div class="section sectionagent sectionagent-headline animatein-fade animateout-fade animatein-childslide animateout-childslide page2-content animateout-hide" style="display: block; opacity: 0;" ;="" id="supplyside_trends">
        <div class="article article-titlebar backgroundagent" style="margin-top: 40px;">
          <h1>Supply-Side Trends</h1>
          <p>Certain supply-side metrics can help to value your home. Talking to a real estate professional can help you identify the appropriate metrics important to your home.</p>
        </div>
        <div class="section sectionagent sectionagent-location" id="supplyside-trends-chart"><img alt="Loading . . ." src="https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/row-load.gif" style="padding-bottom: 15px; margin: 0px auto; padding-top: 120px;"></div>
                  <div class="article article-text normal-box normal-text">
            <ul class="menu">
              <li class="animate-child" style="top: 200px;"><strong class="coloragent" id="med_price">$240,000</strong>MEDIAN SOLD PRICE IN THE LAST 90 DAYS                in 30308</li>
              <li class="animate-child" style="top: 200px;"><strong class="coloragent" id="totalcount">165</strong>NUMBER OF HOMES SOLD IN THE LAST 90 DAYS                in 30308</li>
              <!--<li class="animate-child"><strong class="coloragent" id="aggregatepercentage">+9%</strong>PERCENTAGE CHANGE OF PROPERTIES SOLD IN THE LAST 90 DAYS VS. PREVIOUS 90 DAYS in 30308</li>-->
            </ul>
          </div>
              </div>
    
    
          <div class="section sectionagent sectionagent-map animatein-fade animateout-fade page2-content animateout-hide" style="display: block; opacity: 0;" id="recent_sales">
        <div class="article article-titlebar backgroundagent" style="margin-top: 40px;">
          <h1>Recent Nearby Sales</h1>
          <p>These are nearby homes similar to yours that have sold within the last 18 months and within a 1.5mi radius.  They can be used to help gauge the value of your home in current market conditions.</p>        </div>
        <div id="recent-sale-map-prevent-zoom" style="width: 100%; margin-top: -20px; height: 430px; position: absolute; z-index: 99; display: none;"></div>
        <div class="article article-image" id="map_recent_sales" style="width: 100%;height: 430px;"></div>
        <div class="article article-list normal-box" id="result">
        </div>
      </div>
     
    <div id="buyer_list_contact_jumper"></div>
    <div id="buyer_list_contact"></div>
                  <div class="section sectionagent sectionagent-background animatein-fade animateout-fade page2-content animateout-hide" style="margin-top: 40px; background-image: url(&quot;https://bhhs.findbuyers.com/assets_findbuyers/images/agentimage-background.jpg&quot;); display: block; opacity: 0;">
          <div class="article article-text normal-box normal-text narrow">
                          <p>Thinking of selling your home? A HSF Affiliates agent can perform a free
                comparable market analysis (CMA) on your property.</p>
                        <div class="row row-button">
              <a class="buttonagent buttonagent-click click-show2 nohash type-br" data-target="buyer_list_contact_jumper" data-show="agentform-02">
                Contact a Berkshire Hathaway HomeServices Network Member              </a>
            </div>
                                  </div>
        </div>
      
      <div class="section sectionagent hide" id="agentform-02">
                <div class="article article-text normal-box normal-text xnarrow">
                    <form name="publicMessage" id="publicMessageContact" method="post" action="https://bhhs.findbuyers.com/findbuyers/send_message_contact_form_contact" autocomplete="off" class="custom_icons2">
            <div id="brokerage_contact_info" style="text-align:center;"><div style="font-size: larger;">Berkshire Hathaway HomeServices</div><div>(770) 972-3811</div></div>            <div class="row row-field">
              <!--<div class="fieldagent wide icon icon-name">
                        <input class="text-input format-error" name="fullname_contact" id="fullname_contact" placeholder="Your Name" type="text" value=""/>
                    </div>-->
              <div class="fieldagent narrow icon icon-name">
                <input class="text-input format-error" name="fname_contact" id="fname_contact" placeholder="Your First Name" type="text" value="">
              </div>
              <div class="fieldagent narrow icon icon-name">
                <input class="text-input format-error" name="lname_contact" id="lname_contact" placeholder="Your Last Name" type="text" value="">
              </div>
            </div>
            <div class="row row-field">
              <div class="fieldagent wide icon icon-email">
                <input class="text-input format-error" name="email_contact" id="email_contact" placeholder="Your Email" type="text" value="">
              </div>
            </div>
            <div class="row row-field">
              <div class="fieldagent wide icon icon-phone">
                <input class="text-input format-error format-phone" name="tel_contact" id="tel_contact" placeholder=" Your Phone Number" type="text">
              </div>
            </div>
                        <div class="row row-field working-with-agent-contact-yes hide">
              <div class="fieldagent wide icon icon-name">
                <input placeholder="Agent's Name" type="text" name="agent_name_contact" id="agent_name_contact" class="text-input format-error">
              </div>
            </div>
            <div class="row row-field">
              <div class="fieldagent wide icon icon-name">
                <select name="interest_contact" id="interest_contact" class="text-input format-error valid-required" onchange="republic_interest_contact()" data-class="public-interest-contact">
                  <option value="0" selected="">I am a</option>
                  <option value="1">Buyer</option>
                  <option value="2">Seller</option>
                  <option value="3">Buyer and Seller</option>
                  <option value="4">Broker/Agent</option>
                </select>
              </div>
            </div>
            <div class="row row-field public-interest-contact sell-home-contact hide">
              <div class="fieldagent wide icon icon-address">
                <input class="text-input valid-required" name="address_contact" id="listing_address_contact" placeholder="Address" type="text" value="805 Peachtree St Ne Unit 416, Atlanta, Ga 30308">
                <input type="hidden" name="FullStreetAddress_contact" id="FullStreetAddress" value="">
                <input type="hidden" name="address1_contact" id="address1" value="">
                <input type="hidden" name="address2_contact" id="address2" value="">
                <input type="hidden" name="UnitNumber_contact" id="UnitNumber" value="">
                <input type="hidden" name="StreetName_contact" id="StreetName" value="">
                <input type="hidden" name="StreetNumber_contact" id="StreetNumber" value="">
                <input type="hidden" name="StreetSuffix_contact" id="StreetSuffix" value="">
                <input type="hidden" name="City_contact" id="City" value="">
                <input type="hidden" name="State_contact" id="State" value="">
                <input type="hidden" name="PostalCode_contact" id="PostalCode" value="">
                <input type="hidden" name="Zip4_contact" id="Zip4" value="">
                <input type="hidden" name="Latitude_contact" id="Latitude" value="33.776621">
                <input type="hidden" name="Longitude_contact" id="Longitude" value="-84.384313">
                <input type="hidden" name="brokerage_id" id="brokerage_id" value="29959">
                <input type="hidden" name="buyer_status" id="buyer_status" value="0">
              </div>
            </div>
            <div class="row row-field public-interest-contact sell-home-contact hide">
              <div class="fieldagent wide icon icon-price">
                <input placeholder="My Property's Approximate Value" type="text" name="approximate_value_contact" id="approximate_value_contact" class="text-input valid-required" maxlength="11">
              </div>
            </div>
            <div class="row row-field public-interest-contact sell-home-contact hide">
              <div class="fieldagent wide icon icon-time">
                <select name="time_frame_contact" id="time_frame_contact" class="text-input valid-required" style="margin-top: 5px;" placeholder="Time Frame for Selling">
<option value="0" selected="selected">Time Frame for Selling</option>
<option value="15">Immediately</option>
<option value="90">1 to 3 Months</option>
<option value="180">3 - 6 Months</option>
<option value="365">6 - 12 Months</option>
<option value="730">12+ Months</option>
</select>              </div>
            </div>
            <div class="row row-field public-interest-contact contact-agent-contact hide">
              <div class="fieldagent wide">
                <textarea name="message_contact" id="message_contact" placeholder="Hello, I am interested in learning more about being listed here." class="text-input"></textarea>
              </div>
            </div>
            <div class="row row-field public-interest-contact sell-home-contact-hidden hide">
              <div class="fieldagent wide icon icon-bed">
                <input type="hidden" name="bedroom_contact" id="bedroom_contact" value="2">
              </div>
            </div>
            <div class="row row-field public-interest-contact sell-home-contact-hidden hide">
              <div class="fieldagent wide icon icon-bed">
                <input type="hidden" name="bathroom_contact" id="bathroom_contact" value="2">
              </div>
            </div>
            <div class="row row-button">
              <input type="hidden" name="type" id="type" value="listing">
              <input type="hidden" name="random_key" id="random_key" value="377eba3a9562b5726bb02f1083bdf9c2">
              <input type="hidden" name="to_agent_id_contact" id="to_agent_id_contact" value="78014">
              <input type="hidden" name="to_team_id_contact" id="to_team_id_contact" value="">
              <input type="hidden" name="agent_id_contact" id="agent_id_contact" value="">
              <input type="hidden" name="buyer_id_contact" id="buyer_id_contact" value="">
              <input type="button" value="Send" name="contact_agent_public_contact" id="contact_agent_public_contact" onclick="submit_contact()" class="buttonagent buttonagent-click">
            </div>
          </form>
        </div>
      </div>
    
    
    <div class="section sectionagent animatein-fade animateout-fade page2-content animatein-show animateout-show" style="opacity: 1; display: block;">
      <div class="article article-text normal-box normal-text">
        <p class="text-small">Information presented on this site and webpage is deemed reliable but is not guaranteed
                and should be independently verified by the users of the site. The providers of this website and associated
                content make no warranty, either expressed or implied, as to the accuracy of the data contained from this
                Web Page.</p>
        <p class="text-small">* indicates that public record data for this field is not available for this
          property.</p>
        
        <p class="text-small"><a href="https://bhhs.findbuyers.com/about-this-report">About this report</a></p>
      </div>
    </div>

    <form name="frmPropertyDetails" id="frmPropertyDetails" action="https://bhhs.findbuyers.com/" method="post" autocomplete="off">
      <input type="hidden" name="show_estimated_values" id="show_estimated_values" value="COLLATERAL_ANALYTICS,ZILLOW,RPR,EPPRAISAL">
      <input type="hidden" name="COLLATERAL_estimate" id="COLLATERAL_estimate" value="0">
      <input type="hidden" name="COLLATERAL_range_low" id="COLLATERAL_range_low" value="0">
      <input type="hidden" name="COLLATERAL_range_high" id="COLLATERAL_range_high" value="0">

      <input type="hidden" name="COLLATERAL_ANALYTICS_estimate" id="COLLATERAL_ANALYTICS_estimate" value="427000">
      <input type="hidden" name="COLLATERAL_ANALYTICS_range_low" id="COLLATERAL_ANALYTICS_range_low" value="380000">
      <input type="hidden" name="COLLATERAL_ANALYTICS_range_high" id="COLLATERAL_ANALYTICS_range_high" value="474000">

      <input type="hidden" name="RPR_estimate" id="RPR_estimate" value="0">
      <input type="hidden" name="RPR_range_low" id="RPR_range_low" value="0">
      <input type="hidden" name="RPR_range_high" id="RPR_range_high" value="0">

      <input type="hidden" name="OBI_estimate" id="OBI_estimate" value="0">
      <input type="hidden" name="OBI_range_low" id="OBI_range_low" value="0">
      <input type="hidden" name="OBI_range_high" id="OBI_range_high" value="0">

      <input type="hidden" name="ZILLOW_estimate" id="ZILLOW_estimate" value="449902">
      <input type="hidden" name="ZILLOW_range_low" id="ZILLOW_range_low" value="427407">
      <input type="hidden" name="ZILLOW_range_high" id="ZILLOW_range_high" value="472397">

      <input type="hidden" name="smartZipEstimate" id="smartZipEstimate" value="0">
      <input type="hidden" name="smartZipMinPrice" id="smartZipMinPrice" value="0">
      <input type="hidden" name="smartZipMaxPrice" id="smartZipMaxPrice" value="0">

      <input type="hidden" name="EPPRAISAL_estimate" id="EPPRAISAL_estimate" value="0">
      <input type="hidden" name="EPPRAISAL_range_low" id="EPPRAISAL_range_low" value="0">
      <input type="hidden" name="EPPRAISAL_range_high" id="EPPRAISAL_range_high" value="0">

      <input type="hidden" name="CORELOGIC_estimate" id="CORELOGIC_estimate" value="0">
      <input type="hidden" name="CORELOGIC_range_low" id="CORELOGIC_range_low" value="0">
      <input type="hidden" name="CORELOGIC_range_high" id="CORELOGIC_range_high" value="0">

      <input type="hidden" name="valuation_estimate" id="valuation_estimate" value="438451">
      <input type="hidden" name="valuation_low" id="valuation_low" value="380000">
      <input type="hidden" name="valuation_high" id="valuation_high" value="474000">

      <input type="hidden" name="PropertyType" id="PropertyType" value="Condominium">
      <input type="hidden" name="Beds" id="Beds" value="2">
      <input type="hidden" name="Baths" id="Baths" value="2">
      <input type="hidden" name="LivingArea" id="LivingArea" value="1,445">
      <input type="hidden" name="LotSize" id="LotSize" value="1446">
      <input type="hidden" name="County" id="County" value="FULTON">
      <input type="hidden" name="pd_latitude" id="pd_latitude" value="33.776621">
      <input type="hidden" name="pd_longitude" id="pd_longitude" value="-84.384313">
      <input type="hidden" name="pd_zip4" id="pd_zip4" value="0">
      <input type="hidden" id="latlng_by_zipcode" value="0">

      <input type="hidden" name="random_key" id="random_key" value="377eba3a9562b5726bb02f1083bdf9c2">
      <input type="hidden" name="source" id="source" value="BHHS">
      <input type="hidden" name="page_source" id="page_source" value="bhhs.findbuyers.com">
      <input type="hidden" name="lead_source" id="lead_source" value="bhhs.findbuyers.com">
      <input type="hidden" name="brand_id" id="brand_id" value="25356">
      <input type="hidden" name="brokerage_id" id="brokerage_id" value="29959">
      <input type="hidden" name="show_stats_by_brand" id="show_stats_by_brand" value="1">
      <input type="hidden" name="entire_buyside_network" id="entire_buyside_network" value="0">
      <input type="hidden" name="agentID" id="agentID" value="78014">
      <input type="hidden" name="team_id" id="team_id" value="">
      <input type="hidden" name="agent_lead_routing" id="agent_lead_routing" value="0">
      <input type="hidden" name="buyer_matches_interval" id="buyer_matches_interval" value="90">
      <input type="hidden" name="va_user_emails" id="va_user_emails" value="0">

      <input type="hidden" name="ListPrice" id="ListPrice" value="">
      <input type="hidden" name="SoldPrice" id="SoldPrice" value="">
      <input type="hidden" name="TotalRooms" id="TotalRooms" value="">

      <input type="hidden" name="CurrentSoldCount" id="CurrentSoldCountVal" value="165">
      <input type="hidden" name="SoldCountPercent" id="SoldCountPercent" value="9.2715231788079">
      <input type="hidden" name="SoldCountTrend" id="SoldCountTrend" value="-1">
      <input type="hidden" name="CurrentMedianPrice" id="CurrentMedianPrice" value="240000">

      <input type="hidden" name="funnelone_count" id="funnelone_count" value="0">
      <input type="hidden" name="funneltwo_count" id="funneltwo_count" value="0">
      <input type="hidden" name="funnelthree_count" id="funnelthree_count" value="0">
      <input type="hidden" name="funnelfour_count" id="funnelfour_count" value="0">
      <input type="hidden" name="funnelfive_count" id="funnelfive_count" value="0">

      <input type="hidden" name="totalBuyers" id="totalBuyers" value="">
      <input type="hidden" name="company_buyers_count" id="company_buyers_count" value="">
      <input type="hidden" name="buyersInThisArea" id="buyersInThisArea" value="">
      <input type="hidden" name="beds_buyers_count" id="beds_buyers_count" value="">
      <input type="hidden" name="matchingBuyers" id="matchingBuyers" value="">

      <input type="hidden" name="display_data" id="display_data" value="1">
      <input type="hidden" name="showoff_featured_buyers" id="showoff_featured_buyers" value="0">
      <input type="hidden" name="use_funnel_random_value" id="use_funnel_random_value" value="">

      <input type="hidden" name="buyer_views_count" id="buyer_views_count" value="0">
      <input type="hidden" name="recent_sales_count" id="recent_sales_count" value="165">

      <input type="hidden" name="fulladdress" id="fulladdress" value="805 Peachtree St Ne Unit 416, Atlanta, Ga 30308">
      <input type="hidden" name="address1" id="address1" value="805 Peachtree St Ne Unit 416">
      <input type="hidden" name="address2" id="address2" value="">
      <input type="hidden" name="city" id="city" value="Atlanta">
      <input type="hidden" name="State" id="State" value="Ga">
      <input type="hidden" name="zipcode" id="zipcode" value="30308">
      <input type="hidden" name="saleTransYear" id="saleTransYear" value="2015">
      <input type="hidden" name="phase_type" id="phase_type" value="phase2">
      <input type="hidden" name="show_supplyside_trends" id="show_supplyside_trends" value="1">
      <input type="hidden" name="recent_showings_activity" id="recent_showings_activity" value="0">
      <input type="hidden" name="recent_views_activity" id="recent_views_activity" value="0">

      <input type="hidden" name="recent_sales_hide" id="recent_sales_hide" value="0">
      <input type="hidden" name="user_token" id="user_token" value="">
      <input type="hidden" name="is_listing_verified" id="is_listing_verified" value="">
      <input type="hidden" name="is_listing_claimed" id="is_listing_claimed" value="">
      <input type="hidden" name="show_owner_view" id="show_owner_view" value="0">
      <input type="hidden" name="user_display_name" id="user_display_name" value="">
      <input type="hidden" name="user_first_name" id="user_first_name" value="">
      <input type="hidden" name="user_last_name" id="user_last_name" value="">
      <input type="hidden" name="user_email" id="user_email" value="">
      <input type="hidden" name="vaemail" id="vaemail" value="">
      <input type="hidden" name="ownerName" id="ownerName" value="KNUTSON,NEIL M and KNUTSON,JUSTINA RAE">

      <input type="hidden" name="contact_id" id="contact_id" value="">
      <input type="hidden" name="contact_fn" id="contact_id" value="">
      <input type="hidden" name="contact_ln" id="contact_id" value="">
      <input type="hidden" name="contact_email" id="contact_id" value="">

    </form>

    <form name="frmShowHide" id="frmShowHide" action="https://bhhs.findbuyers.com/" method="post" autocomplete="off">
      <!--Show first 3 blocks-->
      <input type="hidden" name="rpr_block_show" id="rpr_block_show" value="0">
      <input type="hidden" name="collateral_block_show" id="collateral_block_show" value="0">
      <input type="hidden" name="collateral_analytics_block_show" id="collateral_analytics_block_show" value="1">
      <input type="hidden" name="OBI_block_show" id="OBI_block_show" value="0">
      <input type="hidden" name="zillow_block_show" id="zillow_block_show" value="1">
      <input type="hidden" name="eppraisal_block_show" id="eppraisal_block_show" value="0">
      <input type="hidden" name="corelogic_block_show" id="corelogic_block_show" value="0">
        <input type="hidden" name="smartZip_block_show&quot;" id="smartZip_block_show" value="0">

      <!--Show first 3 blocks-->

      <input type="hidden" name="show_buyers_activity" id="show_buyers_activity" value="1">
    </form>

  </div>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDNlq-LeVQGoubUXL_a8p6LYPXR5Bjs_Q" type="text/javascript"></script>

  <script type="text/javascript">
    function rad(x) {
      return x * Math.PI / 180;
    }

    function getDistance(Lat1, Lng1, Lat2, Lng2) {
      var R = 6378137; // Earth’s mean radius in meter
      var M = 3961;
      var dLat = rad(Lat2 - Lat1);
      var dLong = rad(Lng2 - Lng1);
      var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(rad(Lat1)) * Math.cos(rad(Lat2)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

      var d = M * c;
      return d;
      //var d = R * c;
      //return d; // returns the distance in meter
    }

    function getEstimatedValuesMap(lat, lon, latlng_by_zipcode, type_property) {
      var evmap;
      var streetViewService = new google.maps.StreetViewService();
      var STREETVIEW_MAX_DISTANCE = 50;

      var myLatlng = new google.maps.LatLng(lat, lon);
      if (lat && lon) {
        streetViewService.getPanoramaByLocation(myLatlng, STREETVIEW_MAX_DISTANCE, function (streetViewPanoramaData, status) {

          if ((status === google.maps.StreetViewStatus.OK)
            && (latlng_by_zipcode == 0)
            && type_property != 'Condo'
            && type_property != 'Apartment'
            && type_property != 'Condominium')
          {
            var pano;
            //var     latlng = new google.maps.LatLng(lat, lon);
            var panoOptions = {
              position: myLatlng,
              pov: {
                heading: 0,
                pitch: 0
              },
              zoomControl: false,
              scaleControl: false,
              scrollwheel: false,
              draggable: false,
              panControl: false,
              disableDefaultUI: true,
              disableAutoPan: {
                type: Boolean,
                value: false
              }
            };
            pano = new google.maps.StreetViewPanorama(document.getElementById('map-estimated-values'), panoOptions);
            var move = true;

            $("#map-estimated-values").on("mouseenter", function () {
              move = false;
            });

            $("#map-estimated-values").on("mouseleave", function () {
              move = true;
            });

            var i_heading = 0;

            window.setInterval(function () {
              var pov = pano.getPov();
              pov.heading = i_heading;
              pano.setPov(pov);
              if (move) {
                i_heading += 0.2;
              }
            }, 30);
          }
          else {
            let optionsConfigMap = {
              center: myLatlng,
              zoom: 18,
              mapTypeId: google.maps.MapTypeId.SATELLITE,
              mapTypeControl: true,
              zoomControl: false,
              scaleControl: false,
              scrollwheel: false,
              draggable: false,
              panControl: false,
            }

            if(type_property == 'Condo' || type_property == 'Apartment' || type_property == 'Condominium'){
              optionsConfigMap.mapTypeId = google.maps.MapTypeId.Terrain;
              optionsConfigMap.mapTypeControl = false;
            }

            evmap = new google.maps.Map(document.getElementById('map-estimated-values'),optionsConfigMap);

            var image = new google.maps.MarkerImage('https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/marker.png',
              new google.maps.Size(32, 32),
              new google.maps.Point(0, 0),
              new google.maps.Point(10, 34));

            var marker = new google.maps.Marker({
              map: evmap,
              position: myLatlng,
              icon: image
            });
            loadMap(evmap);
          }
        });
      }
      else {
        $('#estimated_values_content').hide();
        $('#estimated_values_map').hide();
      }
    }

    function recent_sales_data() {
      var url = $.base_url + 'findbuyers/recent_sales_data';

      $.ajax({
        url: url,
        type: "POST",
        data: $("#frmPropertyDetails").serialize(),
        beforeSend: function () {
        },
        cache: false,
        success: function (data) {
          $.jsonObj = jQuery.parseJSON(data);
          if ($.jsonObj.SubjectProperty <= 0 || $.jsonObj.Comparables.length <= 0) {
            $('#recent_sales').hide();
            $('#recent_sales_hide').val(1);
          }
          else {
            $('#recent_sales_hide').val(0);
            // Create a map object and specify the DOM element for display.
            var myLatLng = {
              lat: parseFloat($.jsonObj.SubjectProperty.Latitude),
              lng: parseFloat($.jsonObj.SubjectProperty.Longitude)
            };

            if (is_touch_device() == true) {
              var map = new google.maps.Map(document.getElementById('map_recent_sales'), {
                center: myLatLng,
                scrollwheel: false,
                zoomControl: false,
                zoom: 14,
                draggable: false,
                panControl: false,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
              });
            }
            else {
              var map = new google.maps.Map(document.getElementById('map_recent_sales'), {
                center: myLatLng,
                scrollwheel: false,
                zoomControl: true,
                zoom: 14,
                draggable: true,
                panControl: true,
                mapTypeControl: false,
                streetViewControl: false,
              });
            }

            //var sourceLat = myLatLng.lat;
            //var sourceLng = myLatLng.lng;
            var bounds = new google.maps.LatLngBounds();

            //$.each($.jsonObj.SubjectProperty, function(i, property) {
            var myLatlng = new google.maps.LatLng(parseFloat($.jsonObj.SubjectProperty.Latitude), parseFloat($.jsonObj.SubjectProperty.Longitude));
            // Create a marker and set its position.

            //var image = new google.maps.MarkerImage($.base_url+"assets/images/mapicons/black-marker.png",
            var image = new google.maps.MarkerImage('https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/marker.png',
              new google.maps.Size(32, 32),
              new google.maps.Point(0, 0),
              new google.maps.Point(10, 34));

            var marker = new google.maps.Marker({
              map: map,
              position: myLatlng,
              icon: image,
              title: $.jsonObj.SubjectProperty.City,
            });
            bounds.extend(myLatlng);
            //});

            var destLat;
            var destLng;
            var distance = 0;
            var result = '';
            var recent_sales = 0;

            result += '<ul class="menu">';
            $.each($.jsonObj.Comparables, function (i, property) {

              if (property.Beds > 0 || property.Baths > 0 || property.LivingArea > 0 || property.SoldPrice > 0 || property.Latitude != 0 || property.Longitude != 0 || property.City != '') {
                //destLat  = property.Latitude;
                //destLng  = property.Longitude;
                distance = 0;//getDistance(sourceLat, sourceLng, destLat, destLng);

                if (distance < 1) {
                  recent_sales = 1;
                  var myLatlng = new google.maps.LatLng(property.Latitude, property.Longitude);

                  //var image = new google.maps.MarkerImage($.base_url+"assets/images/mapicons/marker"+(i+1)+".png",
                  var image = new google.maps.MarkerImage('https://s3.amazonaws.com/bmlsdevcdn/findbuyers/bhhshf_images/marker' + (i+1) + '.png',
                    new google.maps.Size(20, 34),
                    new google.maps.Point(0, 0),
                    new google.maps.Point(10, 34));

                  // Create a marker and set its position.
                  var marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    icon: image,
                    title: property.City,
                  });

                  bounds.extend(myLatlng);
                  //map.fitBounds(bounds);

                  if (property.Beds > 0 || property.Baths > 0 || property.LivingArea > 0 || property.SoldPrice > 0 || property.SoldDate != '0000-00-00') {
                    result += '<li>';
                    result += '<h2>' + property.FullAddress + '<br />';
                    if (property.Beds > 0) {
                      result += property.Beds + ' Beds | ';
                    }
                    if (property.Baths > 0) {
                      result += property.Baths + ' Baths | ';
                    }
                    if (property.LivingArea > 0) {
                      result += property.LivingArea.toLocaleString() + ' sq.ft';
                    }
                    result += '</h2>';
                    if (property.SoldPrice > 0 || property.SoldDate != '0000-00-00') {
                      result += '<p>';
                      if (property.SoldPrice <= 0) {
                        var SoldDate = new Date(property.SoldDate);
                        SoldDate = (SoldDate.getMonth() + 1) + '/' + SoldDate.getDate() + '/' + SoldDate.getFullYear();
                        result += '<font class="highlight_sold_data">Sold</font> on ' + SoldDate;
                      }
                      else {
                        if (property.SoldPrice > 0) {
                          result += '<font class="highlight_sold_data">Sold';
                                                    result += ' for $' + $.number(property.SoldPrice);
                                                    result += '</font>';
                        }
                        if (property.SoldPrice > 0) {
                          var SoldDate = new Date(property.SoldDate);
                          SoldDate = (SoldDate.getMonth() + 1) + '/' + SoldDate.getDate() + '/' + SoldDate.getFullYear();
                          result += ' on ' + SoldDate;
                        }
                      }
                      result += '<p>';
                    }
                    result += '</li>';
                  }
                }
              }
            });

            //center the map to the geometric center of all markers
            map.setCenter(bounds.getCenter());
            map.fitBounds(bounds);
            if (map.getZoom() > 15) {
              map.setZoom(15);
            }

            result += '</ul>';
            if (recent_sales == 1) {
              $("#result").html(result);
            }
            else {
              $('#result').hide();
            }
          }
        },
        error: function (request, status, error) {
          //consol.log(request.responseText);
          //alert(request.responseText);
          //alert(error);
        }
      });
    }

    var loadMap = function (map) {

      $(function () {
        var el = $('#map-estimated-values');

        //var map;
        function enableScrollingWithMouseWheel() {
          map.setOptions({scrollwheel: true});
        }

        function disableScrollingWithMouseWheel() {
          map.setOptions({scrollwheel: false});
        }

        function init() {
          /*map = new google.maps.Map(el[0], {
              zoom: 10,
              center: new google.maps.LatLng(47.49840560, 19.04075779),
              scrollwheel: false // disableScrollingWithMouseWheel as default
          });*/
          google.maps.event.addListener(map, 'mousedown', function () {
            enableScrollingWithMouseWheel()
          });
        }

        init();
        $('body').on('mousedown', function (event) {
          var clickedInsideMap = $(event.target).parents('#map-estimated-values').length > 0;
          if (!clickedInsideMap) {
            disableScrollingWithMouseWheel();
          }
        });
        $(window).scroll(function () {
          disableScrollingWithMouseWheel();
        });
      });
    };

  </script>

  <script type="text/javascript">
    function func_click() {
      $('.success').html('');
      $('.button-after').click()
    }

    function split(val) {
      return val.split(/@@@*/);
    }

    function extractLast(term) {
      return split(term).pop();
    }

    function insert_search_log_redirectrule() {
      $.ajax({
        url: $.base_url + 'findbuyers/insert_search_log_redirectrule',
        type: "POST",
        data: $("#frmPropertyDetails").serialize(),
        beforeSend: function () {
        },
        cache: false,
        success: function (data) {
          console.log(data);
        },
        error: function (request, status, error) {
          //consol.log(request.responseText);
          //alert(request.responseText);
          //alert(error);
        }
      });
    }

    function insert_data() {
      if ((parseInt($("#Beds").val()) > 0 || $('#display_data').val() == 1) && (parseFloat($("#Baths").val()) > 0 || $('#display_data').val() == 1) && $("#PropertyType").val() != '' && parseInt($("#valuation_estimate").val()) > 0) {
        var show_estimated_values = $('#show_estimated_values').val().split(',');

        var cnt = 0;
        if (show_estimated_values.length > 3) {
          for (var i = 0; i < show_estimated_values.length; i++) {
            switch (show_estimated_values[i]) {
              case 'RPR':
                if ($('#rpr_block_show').val() == 1 && cnt < 3) {
                  cnt++;
                  $('#rpr-estimate').parent('li').show();
                }
                else {
                  $('#rpr-estimate').parent('li').hide();
                }
                break;

              case 'COLLATERAL':
                if ($('#collateral_block_show').val() == 1 && cnt < 3) {
                  cnt++;
                  $('#collateral-estimate').parent('li').show();
                }
                else {
                  $('#collateral-estimate').parent('li').hide();
                }
                break;

              case 'COLLATERAL_ANALYTICS':
                if ($('#collateral_analytics_block_show').val() == 1 && cnt < 3) {
                  cnt++;
                  $('#ca-estimate').parent('li').show();
                }
                else {
                  $('#ca-estimate').parent('li').hide();
                }
                break;

              case 'OBI':
                if ($('#OBI_block_show').val() == 1 && cnt < 3) {
                  cnt++;
                  $('#obi-estimate').parent('li').show();
                }
                else {
                  $('#obi-estimate').parent('li').hide();
                }
                break;

              case 'ZILLOW':
                if ($('#zillow_block_show').val() == 1 && cnt < 3) {
                  cnt++;
                  $('#zillow-estimate').parent('li').show();
                }
                else {
                  $('#zillow-estimate').parent('li').hide();
                  $('.zillow-estimate').hide();
                }
                break;

              case 'EPPRAISAL':
                if ($('#eppraisal_block_show').val() == 1 && cnt < 3) {
                  cnt++;
                  $('#eppraisal-estimate').parent('li').show();
                }
                else {
                  $('#eppraisal-estimate').parent('li').hide();
                  $('.eppraisal-estimate').hide();
                }
                break;

              case 'CORELOGIC':
                if ($('#corelogic_block_show').val() == 1 && cnt < 3) {
                  cnt++;
                  $('#corelogic-estimate').parent('li').show();
                }
                else {
                  $('#corelogic-estimate').parent('li').hide();
                }
                break;
            }
          }
        }

        // If applicable, show Tweener estimate if no AVM API estimate is available
        if (cnt == 0 && $('#rpr_block_show').val() == 0 && $('#collateral_block_show').val() == 0
          && $('#collateral_analytics_block_show').val() == 0 && $('#OBI_block_show').val() == 0
          && $('#zillow_block_show').val() == 0 && $('#eppraisal_block_show').val() == 0 && $('#corelogic_block_show').val() == 0) {
          $('#valuation-estimate').text("$" + $.number($('#valuation_estimate').val()));
          $('#valuation-estimate').parent('li').show();
        }

        $('#promptagent-loading').fadeOut('slow');
        $('#section-form').css('display', 'none');
        $('.page2-content').css('display', 'block');
        if (($('#is_listing_verified').val() == 1) && ($('#user_token').val())) {
          $('.owner-verified-hide').hide();
        }

        if ($('#recent_showings_activity').val() <= 0) {
          $('.recent_showings_activity').hide();
        }

        if ($('#recent_views_activity').val() <= 0) {
          $('.recent_views_activity').hide();
        }

        if ($('#showoff_featured_buyers').val() == 1) {
          loadBuyers();
        }

        var Latitude = $('#pd_latitude').val();
        var Longitude = $('#pd_longitude').val();
        var brokerage = $('#brokerage_id').val();
        var zipcode = $('#zipcode').val();
        var latlng_by_zipcode = $('#latlng_by_zipcode').val();
        var type_property = $('#PropertyType').val();

        if (Latitude && Longitude) {
          getEstimatedValuesMap(parseFloat(Latitude), parseFloat(Longitude), latlng_by_zipcode,type_property);
          if ($('#show_buyers_activity').val() == 1) {
            get_json_value(parseFloat(Latitude), parseFloat(Longitude));
          }
        }
        else {
          if ($('#show_buyers_activity').val() == 1) {
            get_json_value('', '');
          }
        }

        if ($('#show_buyers_activity').val() == 1) {
          if ($('#phase_type').val() == 'phase2') {
            buyers_by_area_phase2();
          }
          else {
            buyers_by_area();
          }
        }

        if ($('#phase_type').val() == 'phase2') {
                  }

        if ($('#show_buyers_activity').val() == 1) {
          buyers_by_price_range_phase1();
          showings_by_price_range_phase1();
        }
        if ($('#show_supplyside_trends').val() == 1) {
          supplyside_trends_chart();
        }

        recent_sales_data();

        $.ajax({
          url: $.base_url + 'findbuyers/insert_search_log',
          type: "POST",
          data: $("#frmPropertyDetails").serialize(),
          beforeSend: function () {
          },
          cache: false,
          success: function (data) {
            //console.log(data);
            if (data) {
              $('input[name=random_key]').val(data);
              $('input[name=verify_search_id]').val(data);
              $('input[name=sul_search_id]').val(data);
            }
          },
          error: function (request, status, error) {
            //consol.log(request.responseText);
            //alert(request.responseText);
            //alert(error);
          }
        });

      }
      else {

        $('#promptagent-loading').fadeOut('slow');
        $('#section-form').css('display', 'block');
        $('.page2-content').css('display', 'none');

      }
    }

    $(document).ready(function () {

      if (is_touch_device() == true) {
        $('#recent-sale-map-prevent-zoom').show();
      }
      else {
        $('#recent-sale-map-prevent-zoom').hide();
      }

      $(document).on('click', '.buyer-list-contact', function (e) {
        $('#buyer_status').val($(this).data('buyerstatus'));
        $('#agent_id_contact').val($(this).data('agentid'));
        $('#buyer_id_contact').val($(this).data('buyerid'));
      });

      $('#map-prevent-scroll').click(function () {
        $(this).css('z-index', 0);
      });

      $(window).scroll(function () {
        $('#map-prevent-scroll').css('z-index', 9999);
      });

      $('#buyers_list').html('');
      $('#limit').val(0);
      $.load_more = false;

      if ((parseInt($("#Beds").val()) > 0 || $('#display_data').val() == 1) && (parseFloat($("#Baths").val()) > 0 || $('#display_data').val() == 1) && $("#PropertyType").val() != '' && parseInt($("#valuation_estimate").val()) > 0) {
        insert_data();
        /*$('#promptagent-loading').fadeOut('slow');
        $('#section-form').css('display','none');
        $('.page2-content').css('display','block');*/
      }
      else {
        $('#promptagent-loading').fadeOut('slow');
        $('#section-form').css('display', 'block');
      }

      
      $('#featured-buyers-load-more').click(function () {
        $('.featured_buyers_load_more').hide();
        $.load_more = true;
        loadBuyers();
      });

      $(".click-show2").click(function () {
        var currentId = $(this).data('show');
        //alert(currentId);
        $('#' + currentId).slideToggle();
      });

      $('body').on('click', '.nohash', function () {
        var currentId = $(this).data('show');
        $('#' + currentId).show();
                //$('html, body').animate({scrollTop:window.parent.$('#hvc_form_div').offset().top}, 500);
        window.parent.postMessage({
          'func': 'scrollToContact',
          'message': 'Contact form request ...'
        }, "*");
              });

      $('#tweener_property_type').change(function () {
        $('#tweenerPropertyType').val('');
        if ($('#tweener_property_type').val()) {
          $('#tweenerPropertyType').val($('#tweener_property_type').val());
        }
        if ($('#tweener_property_type').val() == 'Land') {
          $(".tweener-bedroom").hide();
          $(".tweener-bathroom").hide();
        }
        else {
          if ($("#Beds").val() == '' || $("#Beds").val() <= 0) {
            $(".tweener-bedroom").show();
          }
          if ($("#Baths").val() == '' || $("#Baths").val() <= 0) {
            $(".tweener-bathroom").show();
          }
        }
      });

      $('#are_you_working_with_agent').click(function () {
        if ($(this).is(':checked')) {
          $(this).val(1);
          $('.working-with-agent-yes').removeClass('hide');
          $('#agent_name').addClass('valid-required');
        }
        else {
          $(this).val(0);
          $('#agent_name').val('');
          $('#agent_name').removeClass('valid-required');
          $('.working-with-agent-yes').addClass('hide');
        }
      });

      $('#are_you_working_with_agent_contact').click(function () {
        if ($(this).is(':checked')) {
          $(this).val(1);
          $('.working-with-agent-contact-yes').removeClass('hide');
          $('#agent_name_contact').addClass('valid-required');
        }
        else {
          $(this).val(0);
          $('#agent_name_contact').val('');
          $('#agent_name_contact').removeClass('valid-required');
          $('.working-with-agent-contact-yes').addClass('hide');
        }
      });

    });
  </script>

  <div class="promptagent sectionagent sectionagent-search" id="promptagent-verify" style="display: none;">
    <div class="promptagent-article promptagent-test">
      <a class="click-close" id="dont_verify_listing">Close</a>
      <div class="row row-text row-textsmall align-center">
        <h1>Verify Ownership</h1>
        <p>Claim your property by answering the following questions.</p>
      </div>
      <form name="frmVerifyListing" id="frmVerifyListing" action="https://bhhs.findbuyers.com/findbuyers/verify_listing" method="post" autocomplete="off">
        <div class="row row-field100">
          <label>Email</label>
          <div class="fieldagent wide" style="border: 1px solid #ccc !important;">
            <input type="text" name="sul_email" id="sul_email" value="" class="text-input" placeholder="Email">
          </div>
        </div>
        <div class="row row-field100">
          <label>When did you purchase your property?</label>
          <div class="row row-field" style="border: 1px solid #ccc !important;">
            <div class="fieldagent wide">
              <select class="text-input" name="verify_purchase_year" id="verify_purchase_year">
                <option value="">Please select . . .</option>
                <option value="2019">2019</option><option value="2017">2017</option><option value="2015">2015</option><option value="2013">2013</option><option value="2011">2011</option><option value="2009">2009</option><option value="2007">2007</option><option value="2005">2005</option><option value="2003">2003</option><option value="2001">2001</option>                <option value="0">My purchase year is not displayed</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row row-button">
          <input type="hidden" name="verify_search_id" id="verify_search_id" value="377eba3a9562b5726bb02f1083bdf9c2">
          <input type="hidden" name="verify_full_address" id="verify_full_address" value="805 Peachtree St Ne Unit 416, Atlanta, Ga 30308">
          <input type="hidden" name="verify_address1" id="verify_address1" value="805 Peachtree St Ne Unit 416">
          <input type="hidden" name="verify_address2" id="verify_address2" value="">
          <input type="hidden" name="verify_city" id="verify_city" value="Atlanta">
          <input type="hidden" name="verify_state" id="verify_state" value="Ga">
          <input type="hidden" name="verify_zipcode" id="verify_zipcode" value="30308">
          <input type="hidden" name="verify_beds" id="verify_beds" value="2">
          <input type="hidden" name="verify_baths" id="verify_baths" value="2">
          <input type="hidden" name="verify_living_area" id="verify_living_area" value="1,445">
          <input type="hidden" name="verify_property_type" id="verify_property_type" value="Condominium">
          <input type="hidden" name="verify_sale_transfer_year" id="verify_sale_transfer_year" value="2015">
          <input class="buttonagent buttonagent-submit backgroundagent xwide" name="verify_listing" id="verify_listing" type="button" value="Next Step">
        </div>
      </form>
    </div>
  </div>

  <div class="promptagent sectionagent sectionagent-search" id="promptagent-login" style="display: none;">
    <div class="promptagent-article promptagent-test">
      <a class="click-close" onclick="$('#promptagent-login').fadeOut('fast');">Close</a>
      <div class="row row-text row-textsmall align-center">
        <h1>Verify Ownership</h1>
        <p>To claim and/or edit this property, please login by any of the following means.</p>
      </div>
      <div id="oa_social_login_container" style="visibility: visible; background-color: rgb(239, 223, 223); color: rgb(184, 12, 20); padding: 10px; line-height: 16px; font-size: 11px; border: 1px dashed rgb(184, 12, 20); display: block;"><strong>[OneAll]</strong> To enforce the security of our services we require each domain to be whitelisted. Please <a style="color:#333;text-decoration: underline;" target="_blank" href="http://app.oneall.com/applications/application/settings/security/?applicationid=460413">click here to open your security settings</a> and whitelist the domain <strong>summitrealtygp.com</strong>. Clear your browser cache and reload this page afterwards.</div>
    </div>
  </div>

  <div class="promptagent sectionagent sectionagent-search" id="promptagent-epw-success" style="display: none;">
    <div class="promptagent-article promptagent-test">
      <a class="click-close" onclick="$('#promptagent-epw-success').fadeOut('fast');">Close</a>
      <div class="row row-text row-textsmall align-center">
        <h1>Thank You</h1>
        <p>You will be sent a valuation report on this property every month.</p>
        <p style="display: none !important;">
          If you are the owner of this property, you can claim and/or edit your property details. Verify your identity
          by logging in via any of the following means.</p>
      </div>
      <div id="oa_social_login_container_epw" style="visibility: visible; background-color: rgb(239, 223, 223); color: rgb(184, 12, 20); padding: 10px; line-height: 16px; font-size: 11px; border: 1px dashed rgb(184, 12, 20); display: block;"><strong>[OneAll]</strong> To enforce the security of our services we require each domain to be whitelisted. Please <a style="color:#333;text-decoration: underline;" target="_blank" href="http://app.oneall.com/applications/application/settings/security/?applicationid=460413">click here to open your security settings</a> and whitelist the domain <strong>summitrealtygp.com</strong>. Clear your browser cache and reload this page afterwards.</div>
    </div>
  </div>

  <div class="promptagent sectionagent sectionagent-search" id="verify-ownership-success" style="display: none;">
    <div class="promptagent-article promptagent-test">
      <a class="click-close close-verify-ownership-success">Close</a>
      <div class="row row-text row-textsmall align-center">
        <h1>Thank You</h1>
        <p>Thank you for claiming your home. We have enrolled you to receive monthly updates on your home.</p>
      </div>
      <div class="row row-button">
        <input class="buttonagent buttonagent-submit backgroundagent wide close-verify-ownership-success" name="close_verify_ownership_success" id="close_verify_ownership_success" type="button" value="Close">
      </div>
    </div>
  </div>

  <div class="promptagent sectionagent sectionagent-search" id="promptagent-update" style="display: none;">
    <form name="frmUpdateListing" id="frmUpdateListing" action="https://bhhs.findbuyers.com/findbuyers/update_listing_details" method="post" autocomplete="off">
      <div class="promptagent-article promptagent-test">
        <a class="click-close" onclick="$('html, body').animate({ scrollTop: 0 }, 'fast');$('#promptagent-update').fadeOut('fast');">Close</a>
        <h1 class="coloragent">Property details</h1>
        <p>Please confirm your property details.</p>
        <div class="row row-field100 narrow" style="display: block;">
          <div class="row row-field50">
            <div class="row row-field">
              <div class="fieldagent wide icon icon-bed">
                                <select name="sul_beds" id="sul_beds" class="text-input format-error valid-required">
<option value="">Please Select Beds...</option>
<option value="0">0  Beds</option>
<option value="1">1  Beds</option>
<option value="2" selected="selected">2  Beds</option>
<option value="3">3  Beds</option>
<option value="4">4  Beds</option>
<option value="5">5  Beds</option>
<option value="6">6  Beds</option>
<option value="7">7  Beds</option>
<option value="8">8  Beds</option>
<option value="9">9  Beds</option>
<option value="10">10  Beds</option>
<option value="11">11  Beds</option>
<option value="12">12  Beds</option>
<option value="13">13  Beds</option>
<option value="14">14  Beds</option>
<option value="15">15  Beds</option>
<option value="16">16  Beds</option>
<option value="17">17  Beds</option>
<option value="18">18  Beds</option>
<option value="19">19  Beds</option>
<option value="20">20  Beds</option>
</select>              </div>
            </div>
          </div>
          <div class="row row-field50">
            <div class="row row-field">
              <div class="fieldagent wide icon icon-bath">
                                <select name="sul_baths" id="sul_baths" class="text-input format-error valid-required">
<option value="">Please Select Baths...</option>
<option value="0">0  Baths</option>
<option value="1">1  Baths</option>
<option value="1.5">1.5  Baths</option>
<option value="2" selected="selected">2  Baths</option>
<option value="2.5">2.5  Baths</option>
<option value="3">3  Baths</option>
<option value="3.5">3.5  Baths</option>
<option value="4">4  Baths</option>
<option value="4.5">4.5  Baths</option>
<option value="5">5  Baths</option>
<option value="5.5">5.5  Baths</option>
<option value="6">6  Baths</option>
<option value="6.5">6.5  Baths</option>
<option value="7">7  Baths</option>
<option value="7.5">7.5  Baths</option>
<option value="8">8  Baths</option>
<option value="8.5">8.5  Baths</option>
<option value="9">9  Baths</option>
<option value="9.5">9.5  Baths</option>
<option value="10">10  Baths</option>
<option value="10.5">10.5  Baths</option>
<option value="11">11  Baths</option>
<option value="11.5">11.5  Baths</option>
<option value="12">12  Baths</option>
<option value="12.5">12.5  Baths</option>
<option value="13">13  Baths</option>
<option value="13.5">13.5  Baths</option>
<option value="14">14  Baths</option>
<option value="14.5">14.5  Baths</option>
<option value="15">15  Baths</option>
<option value="15.5">15.5  Baths</option>
<option value="16">16  Baths</option>
<option value="16.5">16.5  Baths</option>
<option value="17">17  Baths</option>
<option value="17.5">17.5  Baths</option>
<option value="18">18  Baths</option>
<option value="18.5">18.5  Baths</option>
<option value="19">19  Baths</option>
<option value="19.5">19.5  Baths</option>
<option value="20">20  Baths</option>
</select>              </div>
            </div>
          </div>
        </div>
        <div class="row row-field narrow">
          <div class="fieldagent wide icon icon-address">
            <input type="text" name="sul_living_area" id="sul_living_area" value="1,445" class="text-input" placeholder="Living Area">
          </div>
        </div>
        <div class="row row-button">
          <input type="hidden" name="sul_full_address" id="sul_full_address" value="805 Peachtree St Ne Unit 416, Atlanta, Ga 30308">
          <input type="hidden" name="sul_search_id" id="sul_search_id" value="377eba3a9562b5726bb02f1083bdf9c2">
          <input class="buttonagent buttonagent-submit backgroundagent xwide" name="update_listing_details" id="update_listing_details" type="button" value="Done">
        </div>
      </div>
    </form>
  </div>

  <div class="promptagent sectionagent sectionagent-search" id="promptagent-success">
    <div class="promptagent-article narrow">
      <div class="row row-text row-textsmall align-center">
        <h1 class="text-success">Thank you</h1>
        <p class="suc-msg">Your property condition and estimated prices have been updated.</p>
        <p><a onclick="$('#promptagent-success').fadeOut('fast');">Close</a></p>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    /* Replace #your_callback_uri# with the url to your own callback script */
    var your_callback_script = 'https://bhhs.findbuyers.com/address/805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308';

    /* Embeds the buttons into the container oa_social_login_container */
    var _oneall = _oneall || [];
    _oneall.push(['social_login', 'set_providers', ['facebook', 'google', 'linkedin']]);
    _oneall.push(['social_login', 'set_callback_uri', your_callback_script]);
    _oneall.push(['social_login', 'do_render_ui', 'oa_social_login_container']);
  </script>

  <script type="text/javascript">
    /* Replace #your_callback_uri# with the url to your own callback script */
    var your_callback_script = 'https://bhhs.findbuyers.com/address/805+Peachtree+St+Ne+Unit+416-Atlanta-Ga-30308';

    /* Embeds the buttons into the container oa_social_login_container */
    var _oneall = _oneall || [];
    _oneall.push(['social_login', 'set_providers', ['facebook', 'google', 'linkedin']]);
    _oneall.push(['social_login', 'set_callback_uri', your_callback_script]);
    _oneall.push(['social_login', 'do_render_ui', 'oa_social_login_container_epw']);
  </script>

  <script type="text/javascript">
    $(document).ready(function () {

      $('#btn-public-view').click(function () {
        $('.owner-verified').hide();

        $('#monthly_valuation_first_name').val('');
        $('#monthly_valuation_last_name').val('');
        $('#monthly_valuation_email').val('');
        //$('#fullname').val('');
        $('#firstname').val('');
        $('#lastname').val('');
        $('#email').val('');
        //$('#fullname_contact').val('');
        $('#fname_contact').val('');
        $('#lname_contact').val('');
        $('#email_contact').val('');

        if ($('.row-slider').hasClass('type-hide')) {
        }
        else {
          $('.row-slider').addClass('type-hide');
        }
        $('.slider-public-view').show();

        if (($('#is_listing_verified').val() == 1) && ($('#user_token').val())) {
          $('.owner-not-verified').hide();
          $('.owner-not-verified-show').show();
        }
        else {
          $('.owner-not-verified').show();
        }

        $('.page2-content').fadeIn('fast');
        $('.owner-settings-show').fadeOut('fast');
        $('.owner-settings-hide').fadeIn('fast');
        $('.text-settings').removeClass('active');
        $(this).parent('li').addClass('active');
      });

      $('#btn-owner-view').click(function () {

        $('.row-slider').removeClass('type-hide');
        $('.slider-public-view').hide();
        //$('#fullname').val($('#user_display_name').val());
        $('#firstname').val($('#user_first_name').val());
        $('#lastname').val($('#user_last_name').val());
        $('#email').val($('#user_email').val());
        //$('#fullname_contact').val($('#user_display_name').val());
        $('#fname_contact').val($('#user_first_name').val());
        $('#lname_contact').val($('#user_last_name').val());
        $('#email_contact').val($('#user_email').val());

        if (($('#is_listing_verified').val() == 0) && ($('#user_token').val())) {
          $('#promptagent-verify').fadeIn('fast');
        }
        else {
          $('.owner-verified').show();
          $('.owner-not-verified').hide();
          $('.text-public').removeClass('active');
          $('#btn-public-view').parent('li').removeClass('active');
          $('.text-owner.owner-verified').addClass('active');
        }

      });

      $('#btn-owner-settings').click(function () {

        $('.row-slider').removeClass('type-hide');
        $('.slider-public-view').hide();
        $('#agentform-01').hide();
        $('#agentform-02').hide();

        $('.page2-content').fadeOut('fast');
        $('.owner-settings-show-content').fadeIn('fast');
        $('.owner-settings-show').fadeIn('fast');
        $('.owner-settings-hide').fadeOut('fast');
        $('.text-public').removeClass('active');
        $('.text-owner').removeClass('active');
        $(this).parent('li').addClass('active');

        $.ajax({
          url: $.base_url + 'findbuyers/verified_listings',
          type: "POST",
          data: '',
          beforeSend: function () {
            $('.verified-listings').hide();
            $('#verified_listings').html('<p style="padding-top: 10px; text-align: center; margin: 0px auto; width: 85px;" id="loading-img"><img alt="Loading . . ." src="' + $.base_url + 'assets/images/loading.GIF' + '" style="float: left;width: 16px; height: 16px;"> Sending...</p>');
          },
          cache: false,
          success: function (data) {
            $('#loading-img').remove();
            $('#verified_listings').html('');
            $('#verified_listings').before(data);
          },
          error: function (request, status, error) {
            $('#loading-img').remove();
          }
        });

      });

      $('#btn-owner-view-verified').click(function () {

        $('.row-slider').removeClass('type-hide');
        $('.slider-public-view').hide();

        $('.page2-content').fadeIn('fast');
        $('.owner-settings-show').fadeOut('fast');
        $('.owner-settings-hide').fadeIn('fast');
        $('.text-settings').removeClass('active');
        $('.owner-not-verified').hide();
        $('.text-public').removeClass('active');
        $(this).parent('li').addClass('active');

      });

      if ($('#is_listing_verified').val() == 0) {
        setTimeout("$.rowSlider();", 2000);
        //setTimeout("$('.owner-verified').hide();", 3000);
      }
      else {
        //$.rowSlider();
        setTimeout("$.rowSlider();", 2000);
      }

      if (($('#is_listing_verified').val() == 1) && ($('#user_token').val())) {
        $('.owner-verified-hide').hide();
      }

      $(document).ajaxComplete(function () {
        var s1 = $('#showings-activity-chart').html();
        var s2 = $('#num_showings_by_location').html();
        var s3 = $('#showings_by_bedroom').html();
        var s4 = $('#phase2_num_showings_by_price_range').html();
        if ((s1 == '' || s1 == undefined) && (s2 == '' || s2 == undefined) && (s3 == '' || s3 == undefined) && (s4 == '' || s4 == undefined)) {
          $('.recent_showings_activity').hide();
        }
        else {
          if ($('#btn-owner-settings').parent('li').hasClass('active')) {
            $('.recent_showings_activity').hide();
          }
          else {
            $('.recent_showings_activity').show();
          }
        }
      });

      
    });
  </script>


HTML;

		return $str;
	}

	public function getTitle() {
		$elems  = $this->dom->find( '.article.article-text.normal-box.owner-settings-hide.wide.row-ajaxblock' );
		$strres = $elems[0];
		$strres = str_replace( $strres->find( 'div' )[0]->find( 'div' )[0]->innertext, '', $strres );

		return $strres;
	}

	public function getPrice() {
		$price = $this->dom->find( '#zillow-estimate' );
		if ( ! empty( $price ) ) {
			return $price[0]->innertext;
		} else {
			return 'Not Found';
		}
	}

	public function get3dot() {
		$elems = $this->dom->find( '.article.article-list.narrow' );

		$strres = $elems[0]->innertext;

//		$strres = preg_replace( '#(style="(.*?)")#', '', $strres );

		return $strres;
	}

	public function getBedroomSection() {
		$elems = $this->dom->find( '.sectionagent-stats.animatein-fade.animateout-fade.children-4' );

		$strres = $elems[0]->innertext;
		echo '<pre>';
		print_r( $strres );
		echo '</pre>';
		die;


	}

	public function getSoldPrice() {
		$elems  = $this->dom->find( '.article.article-text.normal-box.normal-text' );
		$strres = $elems[3]->innertext;

		return $strres;
	}

	public function getZestimatePrice() {

	}
}