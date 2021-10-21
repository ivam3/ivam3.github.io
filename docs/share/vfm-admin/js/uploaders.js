/*
* MIT Licensed
* http://www.23developer.com/opensource
* http://github.com/23/resumable.js v1.1.0
* Steffen Tiedemann Christensen, steffen@23company.com
*/
!function(){"use strict";var e=function(t){if(!(this instanceof e))return new e(t);if(this.version=1,this.support=!("undefined"==typeof File||"undefined"==typeof Blob||"undefined"==typeof FileList||!Blob.prototype.webkitSlice&&!Blob.prototype.mozSlice&&!Blob.prototype.slice),!this.support)return!1;var r=this;r.files=[],r.defaults={chunkSize:1048576,forceChunkSize:!1,simultaneousUploads:3,fileParameterName:"file",chunkNumberParameterName:"resumableChunkNumber",chunkSizeParameterName:"resumableChunkSize",currentChunkSizeParameterName:"resumableCurrentChunkSize",totalSizeParameterName:"resumableTotalSize",typeParameterName:"resumableType",identifierParameterName:"resumableIdentifier",fileNameParameterName:"resumableFilename",relativePathParameterName:"resumableRelativePath",totalChunksParameterName:"resumableTotalChunks",throttleProgressCallbacks:.5,query:{},headers:{},preprocess:null,preprocessFile:null,method:"multipart",uploadMethod:"POST",testMethod:"GET",prioritizeFirstAndLastChunk:!1,target:"/",testTarget:null,parameterNamespace:"",testChunks:!0,generateUniqueIdentifier:null,getTarget:null,maxChunkRetries:100,chunkRetryInterval:void 0,permanentErrors:[400,404,409,415,500,501],maxFiles:void 0,withCredentials:!1,xhrTimeout:0,clearInput:!0,chunkFormat:"blob",setChunkTypeFromFile:!1,maxFilesErrorCallback:function(e,t){var n=r.getOpt("maxFiles");alert("Please upload no more than "+n+" file"+(1===n?"":"s")+" at a time.")},minFileSize:1,minFileSizeErrorCallback:function(e,t){alert(e.fileName||e.name+" is too small, please upload files larger than "+n.formatSize(r.getOpt("minFileSize"))+".")},maxFileSize:void 0,maxFileSizeErrorCallback:function(e,t){alert(e.fileName||e.name+" is too large, please upload files less than "+n.formatSize(r.getOpt("maxFileSize"))+".")},fileType:[],fileTypeErrorCallback:function(e,t){alert(e.fileName||e.name+" has type not allowed, please upload files of type "+r.getOpt("fileType")+".")}},r.opts=t||{},r.getOpt=function(t){var r=this;if(t instanceof Array){var i={};return n.each(t,function(e){i[e]=r.getOpt(e)}),i}if(r instanceof c){if(void 0!==r.opts[t])return r.opts[t];r=r.fileObj}if(r instanceof f){if(void 0!==r.opts[t])return r.opts[t];r=r.resumableObj}if(r instanceof e)return void 0!==r.opts[t]?r.opts[t]:r.defaults[t]},r.events=[],r.on=function(e,t){r.events.push(e.toLowerCase(),t)},r.fire=function(){for(var e=[],t=0;t<arguments.length;t++)e.push(arguments[t]);var n=e[0].toLowerCase();for(t=0;t<=r.events.length;t+=2)r.events[t]==n&&r.events[t+1].apply(r,e.slice(1)),"catchall"==r.events[t]&&r.events[t+1].apply(null,e);"fileerror"==n&&r.fire("error",e[2],e[1]),"fileprogress"==n&&r.fire("progress")};var n={stopEvent:function(e){e.stopPropagation(),e.preventDefault()},each:function(e,t){if(void 0!==e.length){for(var r=0;r<e.length;r++)if(!1===t(e[r]))return}else for(r in e)if(!1===t(r,e[r]))return},generateUniqueIdentifier:function(e,t){var n=r.getOpt("generateUniqueIdentifier");if("function"==typeof n)return n(e,t);var i=e.webkitRelativePath||e.fileName||e.name;return e.size+"-"+i.replace(/[^0-9a-zA-Z_-]/gim,"")},contains:function(e,t){var r=!1;return n.each(e,function(e){return e!=t||(r=!0,!1)}),r},formatSize:function(e){return e<1024?e+" bytes":e<1048576?(e/1024).toFixed(0)+" KB":e<1073741824?(e/1024/1024).toFixed(1)+" MB":(e/1024/1024/1024).toFixed(1)+" GB"},getTarget:function(e,t){var n=r.getOpt("target");return"test"===e&&r.getOpt("testTarget")&&(n="/"===r.getOpt("testTarget")?r.getOpt("target"):r.getOpt("testTarget")),"function"==typeof n?n(t):n+(n.indexOf("?")<0?"?":"&")+t.join("&")}},i=function(e){n.stopEvent(e),e.dataTransfer&&e.dataTransfer.items?u(e.dataTransfer.items,e):e.dataTransfer&&e.dataTransfer.files&&u(e.dataTransfer.files,e)},a=function(e){e.preventDefault()};function s(e,t,r,n){var i;return e.isFile?e.file(function(e){e.relativePath=t+e.name,r.push(e),n()}):(e.isDirectory?i=e:e instanceof File&&r.push(e),"function"==typeof e.webkitGetAsEntry&&(i=e.webkitGetAsEntry()),i&&i.isDirectory?function(e,t,r,n){var i=e.createReader(),a=[];!function e(){i.readEntries(function(i){if(i.length)return a=a.concat(i),e();o(a.map(function(e){return s.bind(null,e,t,r)}),n)})}()}(i,t+i.name+"/",r,n):("function"==typeof e.getAsFile&&(e=e.getAsFile())instanceof File&&(e.relativePath=t+e.name,r.push(e)),void n()))}function o(e,t){if(!e||0===e.length)return t();e[0](function(){o(e.slice(1),t)})}function u(e,t){if(e.length){r.fire("beforeAdd");var n=[];o(Array.prototype.map.call(e,function(e){return s.bind(null,e,"",n)}),function(){n.length&&l(n,t)})}}var l=function(e,t){var i=0,a=r.getOpt(["maxFiles","minFileSize","maxFileSize","maxFilesErrorCallback","minFileSizeErrorCallback","maxFileSizeErrorCallback","fileType","fileTypeErrorCallback"]);if(void 0!==a.maxFiles&&a.maxFiles<e.length+r.files.length){if(1!==a.maxFiles||1!==r.files.length||1!==e.length)return a.maxFilesErrorCallback(e,i++),!1;r.removeFile(r.files[0])}var s=[],o=[],u=e.length,l=function(){if(!--u){if(!s.length&&!o.length)return;window.setTimeout(function(){r.fire("filesAdded",s,o)},0)}};n.each(e,function(e){var u=e.name,c=e.type;if(a.fileType.length>0){var p=!1;for(var d in a.fileType){a.fileType[d]=a.fileType[d].replace(/\s/g,"").toLowerCase();var m=(a.fileType[d].match(/^[^.][^/]+$/)?".":"")+a.fileType[d];if(u.substr(-1*m.length).toLowerCase()===m||-1!==m.indexOf("/")&&(-1!==m.indexOf("*")&&c.substr(0,m.indexOf("*"))===m.substr(0,m.indexOf("*"))||c===m)){p=!0;break}}if(!p)return a.fileTypeErrorCallback(e,i++),!1}if(void 0!==a.minFileSize&&e.size<a.minFileSize)return a.minFileSizeErrorCallback(e,i++),!1;if(void 0!==a.maxFileSize&&e.size>a.maxFileSize)return a.maxFileSizeErrorCallback(e,i++),!1;function h(n){r.getFromUniqueIdentifier(n)?o.push(e):function(){e.uniqueIdentifier=n;var i=new f(r,e,n);r.files.push(i),s.push(i),i.container=void 0!==t?t.srcElement:null,window.setTimeout(function(){r.fire("fileAdded",i,t)},0)}(),l()}var g=n.generateUniqueIdentifier(e,t);g&&"function"==typeof g.then?g.then(function(e){h(e)},function(){l()}):h(g)})};function f(e,t,r){var i=this;i.opts={},i.getOpt=e.getOpt,i._prevProgress=0,i.resumableObj=e,i.file=t,i.fileName=t.fileName||t.name,i.size=t.size,i.relativePath=t.relativePath||t.webkitRelativePath||i.fileName,i.uniqueIdentifier=r,i._pause=!1,i.container="",i.preprocessState=0;var a=void 0!==r,s=function(e,t){switch(e){case"progress":i.resumableObj.fire("fileProgress",i,t);break;case"error":i.abort(),a=!0,i.chunks=[],i.resumableObj.fire("fileError",i,t);break;case"success":if(a)return;i.resumableObj.fire("fileProgress",i,t),i.isComplete()&&i.resumableObj.fire("fileSuccess",i,t);break;case"retry":i.resumableObj.fire("fileRetry",i)}};return i.chunks=[],i.abort=function(){var e=0;n.each(i.chunks,function(t){"uploading"==t.status()&&(t.abort(),e++)}),e>0&&i.resumableObj.fire("fileProgress",i)},i.cancel=function(){var e=i.chunks;i.chunks=[],n.each(e,function(e){"uploading"==e.status()&&(e.abort(),i.resumableObj.uploadNextChunk())}),i.resumableObj.removeFile(i),i.resumableObj.fire("fileProgress",i)},i.retry=function(){i.bootstrap();var e=!1;i.resumableObj.on("chunkingComplete",function(){e||i.resumableObj.upload(),e=!0})},i.bootstrap=function(){i.abort(),a=!1,i.chunks=[],i._prevProgress=0;for(var e=i.getOpt("forceChunkSize")?Math.ceil:Math.floor,t=Math.max(e(i.file.size/i.getOpt("chunkSize")),1),r=0;r<t;r++)!function(e){window.setTimeout(function(){i.chunks.push(new c(i.resumableObj,i,e,s)),i.resumableObj.fire("chunkingProgress",i,e/t)},0)}(r);window.setTimeout(function(){i.resumableObj.fire("chunkingComplete",i)},0)},i.progress=function(){if(a)return 1;var e=0,t=!1;return n.each(i.chunks,function(r){"error"==r.status()&&(t=!0),e+=r.progress(!0)}),e=t?1:e>.99999?1:e,e=Math.max(i._prevProgress,e),i._prevProgress=e,e},i.isUploading=function(){var e=!1;return n.each(i.chunks,function(t){if("uploading"==t.status())return e=!0,!1}),e},i.isComplete=function(){var e=!1;return 1!==i.preprocessState&&(n.each(i.chunks,function(t){var r=t.status();if("pending"==r||"uploading"==r||1===t.preprocessState)return e=!0,!1}),!e)},i.pause=function(e){i._pause=void 0===e?!i._pause:e},i.isPaused=function(){return i._pause},i.preprocessFinished=function(){i.preprocessState=2,i.upload()},i.upload=function(){var e=!1;if(!1===i.isPaused()){var t=i.getOpt("preprocessFile");if("function"==typeof t)switch(i.preprocessState){case 0:return i.preprocessState=1,t(i),!0;case 1:return!0}n.each(i.chunks,function(t){if("pending"==t.status()&&1!==t.preprocessState)return t.send(),e=!0,!1})}return e},i.markChunksCompleted=function(e){if(i.chunks&&!(i.chunks.length<=e))for(var t=0;t<e;t++)i.chunks[t].markComplete=!0},i.resumableObj.fire("chunkingStart",i),i.bootstrap(),this}function c(e,t,r,i){var a=this;a.opts={},a.getOpt=e.getOpt,a.resumableObj=e,a.fileObj=t,a.fileObjSize=t.size,a.fileObjType=t.file.type,a.offset=r,a.callback=i,a.lastProgressCallback=new Date,a.tested=!1,a.retries=0,a.pendingRetry=!1,a.preprocessState=0,a.markComplete=!1;var s=a.getOpt("chunkSize");return a.loaded=0,a.startByte=a.offset*s,a.endByte=Math.min(a.fileObjSize,(a.offset+1)*s),a.fileObjSize-a.endByte<s&&!a.getOpt("forceChunkSize")&&(a.endByte=a.fileObjSize),a.xhr=null,a.test=function(){a.xhr=new XMLHttpRequest;var e=function(e){a.tested=!0;var t=a.status();"success"==t?(a.callback(t,a.message()),a.resumableObj.uploadNextChunk()):a.send()};a.xhr.addEventListener("load",e,!1),a.xhr.addEventListener("error",e,!1),a.xhr.addEventListener("timeout",e,!1);var t=[],r=a.getOpt("parameterNamespace"),i=a.getOpt("query");"function"==typeof i&&(i=i(a.fileObj,a)),n.each(i,function(e,n){t.push([encodeURIComponent(r+e),encodeURIComponent(n)].join("="))}),t=t.concat([["chunkNumberParameterName",a.offset+1],["chunkSizeParameterName",a.getOpt("chunkSize")],["currentChunkSizeParameterName",a.endByte-a.startByte],["totalSizeParameterName",a.fileObjSize],["typeParameterName",a.fileObjType],["identifierParameterName",a.fileObj.uniqueIdentifier],["fileNameParameterName",a.fileObj.fileName],["relativePathParameterName",a.fileObj.relativePath],["totalChunksParameterName",a.fileObj.chunks.length]].filter(function(e){return a.getOpt(e[0])}).map(function(e){return[r+a.getOpt(e[0]),encodeURIComponent(e[1])].join("=")})),a.xhr.open(a.getOpt("testMethod"),n.getTarget("test",t)),a.xhr.timeout=a.getOpt("xhrTimeout"),a.xhr.withCredentials=a.getOpt("withCredentials");var s=a.getOpt("headers");"function"==typeof s&&(s=s(a.fileObj,a)),n.each(s,function(e,t){a.xhr.setRequestHeader(e,t)}),a.xhr.send(null)},a.preprocessFinished=function(){a.preprocessState=2,a.send()},a.send=function(){var e=a.getOpt("preprocess");if("function"==typeof e)switch(a.preprocessState){case 0:return a.preprocessState=1,void e(a);case 1:return}if(!a.getOpt("testChunks")||a.tested){a.xhr=new XMLHttpRequest,a.xhr.upload.addEventListener("progress",function(e){new Date-a.lastProgressCallback>1e3*a.getOpt("throttleProgressCallbacks")&&(a.callback("progress"),a.lastProgressCallback=new Date),a.loaded=e.loaded||0},!1),a.loaded=0,a.pendingRetry=!1,a.callback("progress");var t=function(e){var t=a.status();if("success"==t||"error"==t)a.callback(t,a.message()),a.resumableObj.uploadNextChunk();else{a.callback("retry",a.message()),a.abort(),a.retries++;var r=a.getOpt("chunkRetryInterval");void 0!==r?(a.pendingRetry=!0,setTimeout(a.send,r)):a.send()}};a.xhr.addEventListener("load",t,!1),a.xhr.addEventListener("error",t,!1),a.xhr.addEventListener("timeout",t,!1);var r=[["chunkNumberParameterName",a.offset+1],["chunkSizeParameterName",a.getOpt("chunkSize")],["currentChunkSizeParameterName",a.endByte-a.startByte],["totalSizeParameterName",a.fileObjSize],["typeParameterName",a.fileObjType],["identifierParameterName",a.fileObj.uniqueIdentifier],["fileNameParameterName",a.fileObj.fileName],["relativePathParameterName",a.fileObj.relativePath],["totalChunksParameterName",a.fileObj.chunks.length]].filter(function(e){return a.getOpt(e[0])}).reduce(function(e,t){return e[a.getOpt(t[0])]=t[1],e},{}),i=a.getOpt("query");"function"==typeof i&&(i=i(a.fileObj,a)),n.each(i,function(e,t){r[e]=t});var s=a.fileObj.file.slice?"slice":a.fileObj.file.mozSlice?"mozSlice":a.fileObj.file.webkitSlice?"webkitSlice":"slice",o=a.fileObj.file[s](a.startByte,a.endByte,a.getOpt("setChunkTypeFromFile")?a.fileObj.file.type:""),u=null,l=[],f=a.getOpt("parameterNamespace");if("octet"===a.getOpt("method"))u=o,n.each(r,function(e,t){l.push([encodeURIComponent(f+e),encodeURIComponent(t)].join("="))});else if(u=new FormData,n.each(r,function(e,t){u.append(f+e,t),l.push([encodeURIComponent(f+e),encodeURIComponent(t)].join("="))}),"blob"==a.getOpt("chunkFormat"))u.append(f+a.getOpt("fileParameterName"),o,a.fileObj.fileName);else if("base64"==a.getOpt("chunkFormat")){var c=new FileReader;c.onload=function(e){u.append(f+a.getOpt("fileParameterName"),c.result),a.xhr.send(u)},c.readAsDataURL(o)}var p=n.getTarget("upload",l),d=a.getOpt("uploadMethod");a.xhr.open(d,p),"octet"===a.getOpt("method")&&a.xhr.setRequestHeader("Content-Type","application/octet-stream"),a.xhr.timeout=a.getOpt("xhrTimeout"),a.xhr.withCredentials=a.getOpt("withCredentials");var m=a.getOpt("headers");"function"==typeof m&&(m=m(a.fileObj,a)),n.each(m,function(e,t){a.xhr.setRequestHeader(e,t)}),"blob"==a.getOpt("chunkFormat")&&a.xhr.send(u)}else a.test()},a.abort=function(){a.xhr&&a.xhr.abort(),a.xhr=null},a.status=function(){return a.pendingRetry?"uploading":a.markComplete?"success":a.xhr?a.xhr.readyState<4?"uploading":200==a.xhr.status||201==a.xhr.status?"success":n.contains(a.getOpt("permanentErrors"),a.xhr.status)||a.retries>=a.getOpt("maxChunkRetries")?"error":(a.abort(),"pending"):"pending"},a.message=function(){return a.xhr?a.xhr.responseText:""},a.progress=function(e){void 0===e&&(e=!1);var t=e?(a.endByte-a.startByte)/a.fileObjSize:1;if(a.pendingRetry)return 0;switch(a.xhr&&a.xhr.status||a.markComplete||(t*=.95),a.status()){case"success":case"error":return 1*t;case"pending":return 0*t;default:return a.loaded/(a.endByte-a.startByte)*t}},this}return r.uploadNextChunk=function(){var e=!1;if(r.getOpt("prioritizeFirstAndLastChunk")&&(n.each(r.files,function(t){return t.chunks.length&&"pending"==t.chunks[0].status()&&0===t.chunks[0].preprocessState?(t.chunks[0].send(),e=!0,!1):t.chunks.length>1&&"pending"==t.chunks[t.chunks.length-1].status()&&0===t.chunks[t.chunks.length-1].preprocessState?(t.chunks[t.chunks.length-1].send(),e=!0,!1):void 0}),e))return!0;if(n.each(r.files,function(t){if(e=t.upload())return!1}),e)return!0;var t=!1;return n.each(r.files,function(e){if(!e.isComplete())return t=!0,!1}),t||r.fire("complete"),!1},r.assignBrowse=function(e,t){void 0===e.length&&(e=[e]),n.each(e,function(e){var n;"INPUT"===e.tagName&&"file"===e.type?n=e:((n=document.createElement("input")).setAttribute("type","file"),n.style.display="none",e.addEventListener("click",function(){n.style.opacity=0,n.style.display="block",n.focus(),n.click(),n.style.display="none"},!1),e.appendChild(n));var i=r.getOpt("maxFiles");void 0===i||1!=i?n.setAttribute("multiple","multiple"):n.removeAttribute("multiple"),t?n.setAttribute("webkitdirectory","webkitdirectory"):n.removeAttribute("webkitdirectory");var a=r.getOpt("fileType");void 0!==a&&a.length>=1?n.setAttribute("accept",a.map(function(e){return(e=e.replace(/\s/g,"").toLowerCase()).match(/^[^.][^/]+$/)&&(e="."+e),e}).join(",")):n.removeAttribute("accept"),n.addEventListener("change",function(e){l(e.target.files,e),r.getOpt("clearInput")&&(e.target.value="")},!1)})},r.assignDrop=function(e){void 0===e.length&&(e=[e]),n.each(e,function(e){e.addEventListener("dragover",a,!1),e.addEventListener("dragenter",a,!1),e.addEventListener("drop",i,!1)})},r.unAssignDrop=function(e){void 0===e.length&&(e=[e]),n.each(e,function(e){e.removeEventListener("dragover",a),e.removeEventListener("dragenter",a),e.removeEventListener("drop",i)})},r.isUploading=function(){var e=!1;return n.each(r.files,function(t){if(t.isUploading())return e=!0,!1}),e},r.upload=function(){if(!r.isUploading()){r.fire("uploadStart");for(var e=1;e<=r.getOpt("simultaneousUploads");e++)r.uploadNextChunk()}},r.pause=function(){n.each(r.files,function(e){e.abort()}),r.fire("pause")},r.cancel=function(){r.fire("beforeCancel");for(var e=r.files.length-1;e>=0;e--)r.files[e].cancel();r.fire("cancel")},r.progress=function(){var e=0,t=0;return n.each(r.files,function(r){e+=r.progress()*r.size,t+=r.size}),t>0?e/t:0},r.addFile=function(e,t){l([e],t)},r.addFiles=function(e,t){l(e,t)},r.removeFile=function(e){for(var t=r.files.length-1;t>=0;t--)r.files[t]===e&&r.files.splice(t,1)},r.getFromUniqueIdentifier=function(e){var t=!1;return n.each(r.files,function(r){r.uniqueIdentifier==e&&(t=r)}),t},r.getSize=function(){var e=0;return n.each(r.files,function(t){e+=t.size}),e},r.handleDropEvent=function(e){i(e)},r.handleChangeEvent=function(e){l(e.target.files,e),e.target.value=""},r.updateQuery=function(e){r.opts.query=e},this};"undefined"!=typeof module?module.exports=e:"function"==typeof define&&define.amd?define(function(){return e}):window.Resumable=e}();

/*!
 * jQuery Form Plugin
 * version: 4.2.2
 * Requires jQuery v1.7.2 or later
 * Project repository: https://github.com/jquery-form/form
 * Copyright 2017 Kevin Morris
 * Copyright 2006 M. Alsup
 * Dual licensed under the LGPL-2.1+ or MIT licenses
 * https://github.com/jquery-form/form#license
 */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof module&&module.exports?module.exports=function(t,r){return void 0===r&&(r="undefined"!=typeof window?require("jquery"):require("jquery")(t)),e(r),r}:e(jQuery)}(function(e){"use strict";function t(t){var r=t.data;t.isDefaultPrevented()||(t.preventDefault(),e(t.target).closest("form").ajaxSubmit(r))}function r(t){var r=t.target,a=e(r);if(!a.is("[type=submit],[type=image]")){var n=a.closest("[type=submit]");if(0===n.length)return;r=n[0]}var i=r.form;if(i.clk=r,"image"===r.type)if(void 0!==t.offsetX)i.clk_x=t.offsetX,i.clk_y=t.offsetY;else if("function"==typeof e.fn.offset){var o=a.offset();i.clk_x=t.pageX-o.left,i.clk_y=t.pageY-o.top}else i.clk_x=t.pageX-r.offsetLeft,i.clk_y=t.pageY-r.offsetTop;setTimeout(function(){i.clk=i.clk_x=i.clk_y=null},100)}function a(){if(e.fn.ajaxSubmit.debug){var t="[jquery.form] "+Array.prototype.join.call(arguments,"");window.console&&window.console.log?window.console.log(t):window.opera&&window.opera.postError&&window.opera.postError(t)}}var n=/\r?\n/g,i={};i.fileapi=void 0!==e('<input type="file">').get(0).files,i.formdata=void 0!==window.FormData;var o=!!e.fn.prop;e.fn.attr2=function(){if(!o)return this.attr.apply(this,arguments);var e=this.prop.apply(this,arguments);return e&&e.jquery||"string"==typeof e?e:this.attr.apply(this,arguments)},e.fn.ajaxSubmit=function(t,r,n,s){function u(r){var a,n,i=e.param(r,t.traditional).split("&"),o=i.length,s=[];for(a=0;a<o;a++)i[a]=i[a].replace(/\+/g," "),n=i[a].split("="),s.push([decodeURIComponent(n[0]),decodeURIComponent(n[1])]);return s}function c(r){function n(e){var t=null;try{e.contentWindow&&(t=e.contentWindow.document)}catch(e){a("cannot get iframe.contentWindow document: "+e)}if(t)return t;try{t=e.contentDocument?e.contentDocument:e.document}catch(r){a("cannot get iframe.contentDocument: "+r),t=e.document}return t}function i(){function t(){try{var e=n(v).readyState;a("state = "+e),e&&"uninitialized"===e.toLowerCase()&&setTimeout(t,50)}catch(e){a("Server abort: ",e," (",e.name,")"),s(L),j&&clearTimeout(j),j=void 0}}var r=p.attr2("target"),i=p.attr2("action"),o=p.attr("enctype")||p.attr("encoding")||"multipart/form-data";w.setAttribute("target",m),l&&!/post/i.test(l)||w.setAttribute("method","POST"),i!==f.url&&w.setAttribute("action",f.url),f.skipEncodingOverride||l&&!/post/i.test(l)||p.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"}),f.timeout&&(j=setTimeout(function(){T=!0,s(A)},f.timeout));var u=[];try{if(f.extraData)for(var c in f.extraData)f.extraData.hasOwnProperty(c)&&(e.isPlainObject(f.extraData[c])&&f.extraData[c].hasOwnProperty("name")&&f.extraData[c].hasOwnProperty("value")?u.push(e('<input type="hidden" name="'+f.extraData[c].name+'">',k).val(f.extraData[c].value).appendTo(w)[0]):u.push(e('<input type="hidden" name="'+c+'">',k).val(f.extraData[c]).appendTo(w)[0]));f.iframeTarget||h.appendTo(D),v.attachEvent?v.attachEvent("onload",s):v.addEventListener("load",s,!1),setTimeout(t,15);try{w.submit()}catch(e){document.createElement("form").submit.apply(w)}}finally{w.setAttribute("action",i),w.setAttribute("enctype",o),r?w.setAttribute("target",r):p.removeAttr("target"),e(u).remove()}}function s(t){if(!x.aborted&&!X){if((O=n(v))||(a("cannot access response document"),t=L),t===A&&x)return x.abort("timeout"),void S.reject(x,"timeout");if(t===L&&x)return x.abort("server abort"),void S.reject(x,"error","server abort");if(O&&O.location.href!==f.iframeSrc||T){v.detachEvent?v.detachEvent("onload",s):v.removeEventListener("load",s,!1);var r,i="success";try{if(T)throw"timeout";var o="xml"===f.dataType||O.XMLDocument||e.isXMLDoc(O);if(a("isXml="+o),!o&&window.opera&&(null===O.body||!O.body.innerHTML)&&--C)return a("requeing onLoad callback, DOM not available"),void setTimeout(s,250);var u=O.body?O.body:O.documentElement;x.responseText=u?u.innerHTML:null,x.responseXML=O.XMLDocument?O.XMLDocument:O,o&&(f.dataType="xml"),x.getResponseHeader=function(e){return{"content-type":f.dataType}[e.toLowerCase()]},u&&(x.status=Number(u.getAttribute("status"))||x.status,x.statusText=u.getAttribute("statusText")||x.statusText);var c=(f.dataType||"").toLowerCase(),l=/(json|script|text)/.test(c);if(l||f.textarea){var p=O.getElementsByTagName("textarea")[0];if(p)x.responseText=p.value,x.status=Number(p.getAttribute("status"))||x.status,x.statusText=p.getAttribute("statusText")||x.statusText;else if(l){var m=O.getElementsByTagName("pre")[0],g=O.getElementsByTagName("body")[0];m?x.responseText=m.textContent?m.textContent:m.innerText:g&&(x.responseText=g.textContent?g.textContent:g.innerText)}}else"xml"===c&&!x.responseXML&&x.responseText&&(x.responseXML=q(x.responseText));try{M=N(x,c,f)}catch(e){i="parsererror",x.error=r=e||i}}catch(e){a("error caught: ",e),i="error",x.error=r=e||i}x.aborted&&(a("upload aborted"),i=null),x.status&&(i=x.status>=200&&x.status<300||304===x.status?"success":"error"),"success"===i?(f.success&&f.success.call(f.context,M,"success",x),S.resolve(x.responseText,"success",x),d&&e.event.trigger("ajaxSuccess",[x,f])):i&&(void 0===r&&(r=x.statusText),f.error&&f.error.call(f.context,x,i,r),S.reject(x,"error",r),d&&e.event.trigger("ajaxError",[x,f,r])),d&&e.event.trigger("ajaxComplete",[x,f]),d&&!--e.active&&e.event.trigger("ajaxStop"),f.complete&&f.complete.call(f.context,x,i),X=!0,f.timeout&&clearTimeout(j),setTimeout(function(){f.iframeTarget?h.attr("src",f.iframeSrc):h.remove(),x.responseXML=null},100)}}}var u,c,f,d,m,h,v,x,y,b,T,j,w=p[0],S=e.Deferred();if(S.abort=function(e){x.abort(e)},r)for(c=0;c<g.length;c++)u=e(g[c]),o?u.prop("disabled",!1):u.removeAttr("disabled");(f=e.extend(!0,{},e.ajaxSettings,t)).context=f.context||f,m="jqFormIO"+(new Date).getTime();var k=w.ownerDocument,D=p.closest("body");if(f.iframeTarget?(b=(h=e(f.iframeTarget,k)).attr2("name"))?m=b:h.attr2("name",m):(h=e('<iframe name="'+m+'" src="'+f.iframeSrc+'" />',k)).css({position:"absolute",top:"-1000px",left:"-1000px"}),v=h[0],x={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(t){var r="timeout"===t?"timeout":"aborted";a("aborting upload... "+r),this.aborted=1;try{v.contentWindow.document.execCommand&&v.contentWindow.document.execCommand("Stop")}catch(e){}h.attr("src",f.iframeSrc),x.error=r,f.error&&f.error.call(f.context,x,r,t),d&&e.event.trigger("ajaxError",[x,f,r]),f.complete&&f.complete.call(f.context,x,r)}},(d=f.global)&&0==e.active++&&e.event.trigger("ajaxStart"),d&&e.event.trigger("ajaxSend",[x,f]),f.beforeSend&&!1===f.beforeSend.call(f.context,x,f))return f.global&&e.active--,S.reject(),S;if(x.aborted)return S.reject(),S;(y=w.clk)&&(b=y.name)&&!y.disabled&&(f.extraData=f.extraData||{},f.extraData[b]=y.value,"image"===y.type&&(f.extraData[b+".x"]=w.clk_x,f.extraData[b+".y"]=w.clk_y));var A=1,L=2,F=e("meta[name=csrf-token]").attr("content"),E=e("meta[name=csrf-param]").attr("content");E&&F&&(f.extraData=f.extraData||{},f.extraData[E]=F),f.forceSync?i():setTimeout(i,10);var M,O,X,C=50,q=e.parseXML||function(e,t){return window.ActiveXObject?((t=new ActiveXObject("Microsoft.XMLDOM")).async="false",t.loadXML(e)):t=(new DOMParser).parseFromString(e,"text/xml"),t&&t.documentElement&&"parsererror"!==t.documentElement.nodeName?t:null},_=e.parseJSON||function(e){return window.eval("("+e+")")},N=function(t,r,a){var n=t.getResponseHeader("content-type")||"",i=("xml"===r||!r)&&n.indexOf("xml")>=0,o=i?t.responseXML:t.responseText;return i&&"parsererror"===o.documentElement.nodeName&&e.error&&e.error("parsererror"),a&&a.dataFilter&&(o=a.dataFilter(o,r)),"string"==typeof o&&(("json"===r||!r)&&n.indexOf("json")>=0?o=_(o):("script"===r||!r)&&n.indexOf("javascript")>=0&&e.globalEval(o)),o};return S}if(!this.length)return a("ajaxSubmit: skipping submit process - no element selected"),this;var l,f,d,p=this;"function"==typeof t?t={success:t}:"string"==typeof t||!1===t&&arguments.length>0?(t={url:t,data:r,dataType:n},"function"==typeof s&&(t.success=s)):void 0===t&&(t={}),l=t.method||t.type||this.attr2("method"),(d=(d="string"==typeof(f=t.url||this.attr2("action"))?e.trim(f):"")||window.location.href||"")&&(d=(d.match(/^([^#]+)/)||[])[1]),t=e.extend(!0,{url:d,success:e.ajaxSettings.success,type:l||e.ajaxSettings.type,iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},t);var m={};if(this.trigger("form-pre-serialize",[this,t,m]),m.veto)return a("ajaxSubmit: submit vetoed via form-pre-serialize trigger"),this;if(t.beforeSerialize&&!1===t.beforeSerialize(this,t))return a("ajaxSubmit: submit aborted via beforeSerialize callback"),this;var h=t.traditional;void 0===h&&(h=e.ajaxSettings.traditional);var v,g=[],x=this.formToArray(t.semantic,g,t.filtering);if(t.data){var y=e.isFunction(t.data)?t.data(x):t.data;t.extraData=y,v=e.param(y,h)}if(t.beforeSubmit&&!1===t.beforeSubmit(x,this,t))return a("ajaxSubmit: submit aborted via beforeSubmit callback"),this;if(this.trigger("form-submit-validate",[x,this,t,m]),m.veto)return a("ajaxSubmit: submit vetoed via form-submit-validate trigger"),this;var b=e.param(x,h);v&&(b=b?b+"&"+v:v),"GET"===t.type.toUpperCase()?(t.url+=(t.url.indexOf("?")>=0?"&":"?")+b,t.data=null):t.data=b;var T=[];if(t.resetForm&&T.push(function(){p.resetForm()}),t.clearForm&&T.push(function(){p.clearForm(t.includeHidden)}),!t.dataType&&t.target){var j=t.success||function(){};T.push(function(r,a,n){var i=arguments,o=t.replaceTarget?"replaceWith":"html";e(t.target)[o](r).each(function(){j.apply(this,i)})})}else t.success&&(e.isArray(t.success)?e.merge(T,t.success):T.push(t.success));if(t.success=function(e,r,a){for(var n=t.context||this,i=0,o=T.length;i<o;i++)T[i].apply(n,[e,r,a||p,p])},t.error){var w=t.error;t.error=function(e,r,a){var n=t.context||this;w.apply(n,[e,r,a,p])}}if(t.complete){var S=t.complete;t.complete=function(e,r){var a=t.context||this;S.apply(a,[e,r,p])}}var k=e("input[type=file]:enabled",this).filter(function(){return""!==e(this).val()}).length>0,D="multipart/form-data",A=p.attr("enctype")===D||p.attr("encoding")===D,L=i.fileapi&&i.formdata;a("fileAPI :"+L);var F,E=(k||A)&&!L;!1!==t.iframe&&(t.iframe||E)?t.closeKeepAlive?e.get(t.closeKeepAlive,function(){F=c(x)}):F=c(x):F=(k||A)&&L?function(r){for(var a=new FormData,n=0;n<r.length;n++)a.append(r[n].name,r[n].value);if(t.extraData){var i=u(t.extraData);for(n=0;n<i.length;n++)i[n]&&a.append(i[n][0],i[n][1])}t.data=null;var o=e.extend(!0,{},e.ajaxSettings,t,{contentType:!1,processData:!1,cache:!1,type:l||"POST"});t.uploadProgress&&(o.xhr=function(){var r=e.ajaxSettings.xhr();return r.upload&&r.upload.addEventListener("progress",function(e){var r=0,a=e.loaded||e.position,n=e.total;e.lengthComputable&&(r=Math.ceil(a/n*100)),t.uploadProgress(e,a,n,r)},!1),r}),o.data=null;var s=o.beforeSend;return o.beforeSend=function(e,r){t.formData?r.data=t.formData:r.data=a,s&&s.call(this,e,r)},e.ajax(o)}(x):e.ajax(t),p.removeData("jqxhr").data("jqxhr",F);for(var M=0;M<g.length;M++)g[M]=null;return this.trigger("form-submit-notify",[this,t]),this},e.fn.ajaxForm=function(n,i,o,s){if(("string"==typeof n||!1===n&&arguments.length>0)&&(n={url:n,data:i,dataType:o},"function"==typeof s&&(n.success=s)),n=n||{},n.delegation=n.delegation&&e.isFunction(e.fn.on),!n.delegation&&0===this.length){var u={s:this.selector,c:this.context};return!e.isReady&&u.s?(a("DOM not ready, queuing ajaxForm"),e(function(){e(u.s,u.c).ajaxForm(n)}),this):(a("terminating; zero elements found by selector"+(e.isReady?"":" (DOM not ready)")),this)}return n.delegation?(e(document).off("submit.form-plugin",this.selector,t).off("click.form-plugin",this.selector,r).on("submit.form-plugin",this.selector,n,t).on("click.form-plugin",this.selector,n,r),this):this.ajaxFormUnbind().on("submit.form-plugin",n,t).on("click.form-plugin",n,r)},e.fn.ajaxFormUnbind=function(){return this.off("submit.form-plugin click.form-plugin")},e.fn.formToArray=function(t,r,a){var n=[];if(0===this.length)return n;var o,s=this[0],u=this.attr("id"),c=t||void 0===s.elements?s.getElementsByTagName("*"):s.elements;if(c&&(c=e.makeArray(c)),u&&(t||/(Edge|Trident)\//.test(navigator.userAgent))&&(o=e(':input[form="'+u+'"]').get()).length&&(c=(c||[]).concat(o)),!c||!c.length)return n;e.isFunction(a)&&(c=e.map(c,a));var l,f,d,p,m,h,v;for(l=0,h=c.length;l<h;l++)if(m=c[l],(d=m.name)&&!m.disabled)if(t&&s.clk&&"image"===m.type)s.clk===m&&(n.push({name:d,value:e(m).val(),type:m.type}),n.push({name:d+".x",value:s.clk_x},{name:d+".y",value:s.clk_y}));else if((p=e.fieldValue(m,!0))&&p.constructor===Array)for(r&&r.push(m),f=0,v=p.length;f<v;f++)n.push({name:d,value:p[f]});else if(i.fileapi&&"file"===m.type){r&&r.push(m);var g=m.files;if(g.length)for(f=0;f<g.length;f++)n.push({name:d,value:g[f],type:m.type});else n.push({name:d,value:"",type:m.type})}else null!==p&&void 0!==p&&(r&&r.push(m),n.push({name:d,value:p,type:m.type,required:m.required}));if(!t&&s.clk){var x=e(s.clk),y=x[0];(d=y.name)&&!y.disabled&&"image"===y.type&&(n.push({name:d,value:x.val()}),n.push({name:d+".x",value:s.clk_x},{name:d+".y",value:s.clk_y}))}return n},e.fn.formSerialize=function(t){return e.param(this.formToArray(t))},e.fn.fieldSerialize=function(t){var r=[];return this.each(function(){var a=this.name;if(a){var n=e.fieldValue(this,t);if(n&&n.constructor===Array)for(var i=0,o=n.length;i<o;i++)r.push({name:a,value:n[i]});else null!==n&&void 0!==n&&r.push({name:this.name,value:n})}}),e.param(r)},e.fn.fieldValue=function(t){for(var r=[],a=0,n=this.length;a<n;a++){var i=this[a],o=e.fieldValue(i,t);null===o||void 0===o||o.constructor===Array&&!o.length||(o.constructor===Array?e.merge(r,o):r.push(o))}return r},e.fieldValue=function(t,r){var a=t.name,i=t.type,o=t.tagName.toLowerCase();if(void 0===r&&(r=!0),r&&(!a||t.disabled||"reset"===i||"button"===i||("checkbox"===i||"radio"===i)&&!t.checked||("submit"===i||"image"===i)&&t.form&&t.form.clk!==t||"select"===o&&-1===t.selectedIndex))return null;if("select"===o){var s=t.selectedIndex;if(s<0)return null;for(var u=[],c=t.options,l="select-one"===i,f=l?s+1:c.length,d=l?s:0;d<f;d++){var p=c[d];if(p.selected&&!p.disabled){var m=p.value;if(m||(m=p.attributes&&p.attributes.value&&!p.attributes.value.specified?p.text:p.value),l)return m;u.push(m)}}return u}return e(t).val().replace(n,"\r\n")},e.fn.clearForm=function(t){return this.each(function(){e("input,select,textarea",this).clearFields(t)})},e.fn.clearFields=e.fn.clearInputs=function(t){var r=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var a=this.type,n=this.tagName.toLowerCase();r.test(a)||"textarea"===n?this.value="":"checkbox"===a||"radio"===a?this.checked=!1:"select"===n?this.selectedIndex=-1:"file"===a?/MSIE/.test(navigator.userAgent)?e(this).replaceWith(e(this).clone(!0)):e(this).val(""):t&&(!0===t&&/hidden/.test(a)||"string"==typeof t&&e(this).is(t))&&(this.value="")})},e.fn.resetForm=function(){return this.each(function(){var t=e(this),r=this.tagName.toLowerCase();switch(r){case"input":this.checked=this.defaultChecked;case"textarea":return this.value=this.defaultValue,!0;case"option":case"optgroup":var a=t.parents("select");return a.length&&a[0].multiple?"option"===r?this.selected=this.defaultSelected:t.find("option").resetForm():a.resetForm(),!0;case"select":return t.find("option").each(function(e){if(this.selected=this.defaultSelected,this.defaultSelected&&!t[0].multiple)return t[0].selectedIndex=e,!1}),!0;case"label":var n=e(t.attr("for")),i=t.find("input,select,textarea");return n[0]&&i.unshift(n[0]),i.resetForm(),!0;case"form":return("function"==typeof this.reset||"object"==typeof this.reset&&!this.reset.nodeType)&&this.reset(),!0;default:return t.find("form,input,label,select,textarea").resetForm(),!0}})},e.fn.enable=function(e){return void 0===e&&(e=!0),this.each(function(){this.disabled=!e})},e.fn.selected=function(t){return void 0===t&&(t=!0),this.each(function(){var r=this.type;if("checkbox"===r||"radio"===r)this.checked=t;else if("option"===this.tagName.toLowerCase()){var a=e(this).parent("select");t&&a[0]&&"select-one"===a[0].type&&a.find("option").selected(!1),this.selected=t}})},e.fn.ajaxSubmit.debug=!1});

/*!
 * jQuery Client v2.0.0
 * https://www.mediawiki.org/wiki/JQuery_Client
 *
 * Copyright 2010-2015 jquery-client maintainers and other contributors.
 * Released under the MIT license
 * http://jquery-client.mit-license.org
 */
!function(e){var r={};jQuery.client={profile:function(e){if(void 0===e&&(e=window.navigator),void 0!==r[e.userAgent+"|"+e.platform])return r[e.userAgent+"|"+e.platform];var o,n,i=e.userAgent+"|"+e.platform,a="unknown",t=function(e,r){var o;for(o=0;o<r.length;o++)e=e.replace(r[o][0],r[o][1]);return e},s=e.userAgent,p=a,c=a,l=a,m=a,f="x";return(n=new RegExp("("+["Opera","Navigator","Minefield","KHTML","Chrome","PLAYSTATION 3","Iceweasel"].join("|")+")").exec(s))&&(s=t(s,[[/(Firefox|MSIE|KHTML,?\slike\sGecko|Konqueror)/,""],["Chrome Safari","Chrome"],["KHTML","Konqueror"],["Minefield","Firefox"],["Navigator","Netscape"],["PLAYSTATION 3","PS3"]])),s=s.toLowerCase(),(n=new RegExp("("+["camino","chrome","firefox","iceweasel","netscape","konqueror","lynx","msie","opera","safari","ipod","iphone","blackberry","ps3","rekonq","android"].join("|")+")").exec(s))&&(p=t(n[1],[])),(n=new RegExp("("+["gecko","konqueror","msie","trident","edge","opera","webkit"].join("|")+")").exec(s))&&(c=t(n[1],[["konqueror","khtml"],["msie","trident"],["opera","presto"]])),(n=new RegExp("("+["applewebkit","gecko","trident","edge"].join("|")+")\\/(\\d+)").exec(s))&&(l=parseInt(n[2],10)),(n=new RegExp("("+["win","wow64","mac","linux","sunos","solaris","iphone"].join("|")+")").exec(e.platform.toLowerCase()))&&(m=t(n[1],[["sunos","solaris"],["wow64","win"]])),(n=new RegExp("("+["camino","chrome","firefox","iceweasel","netscape","netscape6","opera","version","konqueror","lynx","msie","safari","ps3","android"].join("|")+")(\\/|\\;?\\s|)([a-z0-9\\.\\+]*?)(\\;|dev|rel|\\)|\\s|$)").exec(s))&&(f=n[3]),"safari"===p&&f>400&&(f="2.0"),"opera"===p&&f>=9.8&&(f=(n=s.match(/\bversion\/([0-9.]*)/))&&n[1]?n[1]:"10"),"chrome"===p&&(n=s.match(/\bopr\/([0-9.]*)/))&&n[1]&&(p="opera",f=n[1]),"trident"===c&&l>=7&&(n=s.match(/\brv[ :/]([0-9.]*)/))&&n[1]&&(p="msie",f=n[1]),"chrome"===p&&(n=s.match(/\bedge\/([0-9.]*)/))&&(p="edge",f=n[1],c="edge",l=parseInt(n[1],10)),(n=s.match(/\bsilk\/([0-9.\-_]*)/))&&n[1]&&(p="silk",f=n[1]),o=parseFloat(f,10)||0,r[i]={name:p,layout:c,layoutVersion:l,platform:m,version:f,versionBase:"x"!==f?Math.floor(o).toString():"x",versionNumber:o}}}}();

/*!
 * polyfill URLSearchParams for IE and Edge
 * https://github.com/jerrybendy/url-search-params-polyfill
 * @author Jerry Bendy <jerry@icewingcc.com>
 * @licence MIT
 */
!function(t){"use strict";var n=t.URLSearchParams?t.URLSearchParams:null,r=n&&"a=1"===new n({a:1}).toString(),e=n&&"+"===new n("s=%2B").get("s"),o="__URLSearchParams__",i=u.prototype,a=!(!t.Symbol||!t.Symbol.iterator);if(!(n&&r&&e)){i.append=function(t,n){v(this[o],t,n)},i.delete=function(t){delete this[o][t]},i.get=function(t){var n=this[o];return t in n?n[t][0]:null},i.getAll=function(t){var n=this[o];return t in n?n[t].slice(0):[]},i.has=function(t){return t in this[o]},i.set=function(t,n){this[o][t]=[""+n]},i.toString=function(){var t,n,r,e,i=this[o],a=[];for(n in i)for(r=c(n),t=0,e=i[n];t<e.length;t++)a.push(r+"="+c(e[t]));return a.join("&")};var s=!!e&&n&&!r&&t.Proxy;t.URLSearchParams=s?new Proxy(n,{construct:function(t,n){return new t(new u(n[0]).toString())}}):u;var f=t.URLSearchParams.prototype;f.polyfill=!0,f.forEach=f.forEach||function(t,n){var r=p(this.toString());Object.getOwnPropertyNames(r).forEach(function(e){r[e].forEach(function(r){t.call(n,r,e,this)},this)},this)},f.sort=f.sort||function(){var t,n,r,e=p(this.toString()),o=[];for(t in e)o.push(t);for(o.sort(),n=0;n<o.length;n++)this.delete(o[n]);for(n=0;n<o.length;n++){var i=o[n],a=e[i];for(r=0;r<a.length;r++)this.append(i,a[r])}},f.keys=f.keys||function(){var t=[];return this.forEach(function(n,r){t.push(r)}),l(t)},f.values=f.values||function(){var t=[];return this.forEach(function(n){t.push(n)}),l(t)},f.entries=f.entries||function(){var t=[];return this.forEach(function(n,r){t.push([r,n])}),l(t)},a&&(f[t.Symbol.iterator]=f[t.Symbol.iterator]||f.entries)}function u(t){((t=t||"")instanceof URLSearchParams||t instanceof u)&&(t=t.toString()),this[o]=p(t)}function c(t){var n={"!":"%21","'":"%27","(":"%28",")":"%29","~":"%7E","%20":"+","%00":"\0"};return encodeURIComponent(t).replace(/[!'\(\)~]|%20|%00/g,function(t){return n[t]})}function h(t){return decodeURIComponent(t.replace(/\+/g," "))}function l(n){var r={next:function(){var t=n.shift();return{done:void 0===t,value:t}}};return a&&(r[t.Symbol.iterator]=function(){return r}),r}function p(t){var n={};if("object"==typeof t)for(var r in t)t.hasOwnProperty(r)&&v(n,r,t[r]);else{0===t.indexOf("?")&&(t=t.slice(1));for(var e=t.split("&"),o=0;o<e.length;o++){var i=e[o],a=i.indexOf("=");-1<a?v(n,h(i.slice(0,a)),h(i.slice(a+1))):i&&v(n,h(i),"")}}return n}function v(t,n,r){var e="string"==typeof r?r:null!==r&&"function"==typeof r.toString?r.toString():JSON.stringify(r);n in t?t[n].push(e):t[n]=[e]}}("undefined"!=typeof global?global:"undefined"!=typeof window?window:this);

/*! 
 * VFM - veno file manager 
 * upload functions 
 */
$(document).ready(function(){

	$('#remote_uploader').on('submit', function(e){
		e.preventDefault();

		var $butt = $(this).find('.send_remote_upload_url');
        var $form = $(this);
        var $modalresponse = $form.parent().find(".modal_response");
        if ($form.find("input[name='get_upload_url']").val()) {
            var serialize = $form.serialize();
            var reloadpage = '?dir='+$form.find("input[name='get_location']").val();
            $form.addClass('hidden');
            $modalresponse.find(".zipicon").removeClass('hidden');
            $.ajax({
                type: "POST",
                url: "vfm-admin/ajax/get-remote.php",
                data: serialize
                })
                .done(function( msg ) {
                	// console.log(msg)
                	window.location.replace(reloadpage);
                })
                .fail(function() {
                    $('.modal_response').html('<div class="alert alert-danger">Error connecting: ajax/get-remote.php</div>').fadeIn();
                    $form.removeClass('hidden');
                    $modalresponse.find(".zipicon").addClass('hidden');
            });
        }
	});
});

/* 
* Send upload notification 
* to selected users, and refresh page
*/
function notifyupload() {

	var locazio = window.location.pathname;
	var responseQS = '?';
	var urlParams = new URLSearchParams(window.location.search);
	var userslist = $("#userslist").serialize();

	if (urlParams.has('dir')){
		responseQS += 'dir=' + urlParams.get('dir') + '&';
	} 
	responseQS += 'response=1';

	var anyUserChecked = $('#userslist :checkbox:checked').length > 0;
    var now = $.now();

	var ajaxfile = 'sendupnotif.php';

    $.ajax({
        cache: false,
        type: "POST",
        url: "vfm-admin/ajax/" + ajaxfile +"?t=" + now,
        data: userslist
    })
    .done(function(msg) {
    	setTimeout(function() {
            location.href = locazio + responseQS
        }, 200);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
    	console.log(jqXHR);
    	console.log(textStatus);
    	console.log(errorThrown);
    });
}

/*
* call resumable.js
*/
function resumableJsSetup($android, $target, $placeholder, $singleprogress, $chunksize) {
	$android = $android || 'no';
	$singleprogress = $singleprogress || false;

	var ua = navigator.userAgent.toLowerCase();
	var android = $android;

	var r = new Resumable({
		target						: 'vfm-admin/chunk.php?loc='+$target,
		simultaneousUploads 		: 3, // Simultaneous chunks
		prioritizeFirstAndLastChunk	: true,
		chunkSize 					: $chunksize, // get available size from php ini, see class.setup.php
		// forceChunkSize 				: true, // Force all chunks to be less or equal than chunkSize. For some reason it fails the last chunk on some servers (Default: false)
		// maxFiles 					: 1, // uncomment this to disable multiple uploading
		// maxFileSize 					: 10*1024*1024, // uncomment this to limit the max file size (the example sets 10Mb)
	    minFileSizeErrorCallback:function(file, errorCount) {
	        setTimeout(function() {
	            alert(file.fileName||file.name +' is not valid.');
	        }, 1000);
	    },
	    permanentErrors : [403]
    });

    var percentVal = 0;
    var roundval = 0;

    if (r.support) {

        r.assignBrowse(document.getElementById('upchunk'));
        r.assignBrowse(document.getElementById('fileToUpload'));
        r.assignBrowse(document.getElementById('biguploader'));
        r.assignDrop(document.getElementById('uparea'));

        $("#fileToUpload").attr("placeholder", $placeholder);

        r.on('uploadStart', function(){
            $("#resumer").remove();
           	$("#upchunk").before('<button class="btn btn-primary" id="resumer"><i class="fa fa-pause"></i></button>');
            window.onbeforeunload = function() {
                return 'Are you sure you want to leave?';
            }
	        $('#resumer').on('click', function(){
	        	r.pause();
	        });
        });
        
        r.on('pause', function(){
            $("#resumer").remove();
            $("#upchunk").before('<button class="btn btn-primary" id="resumer"><i class="fa fa-play"></i></button>');
	        $('#resumer').on('click', function(){
	        	r.upload();
	        });
        });

        r.on('progress', function(){
            percentVal = r.progress()*100;
            roundval = percentVal.toFixed(1);
            $('.upbar p').html(roundval+'%');
            $(".upbar").width(percentVal+'%');
        });

        // upload progress for individual files
        if ($singleprogress == true) { 
            r.on('fileProgress', function(file){
                percentVal = file.progress(true)*100;
                $('.upbarfile p').html(file.fileName);
                $(".upbarfile").width(percentVal+'%');
            });
        }

        r.on('error', function(message, file){
            console.log(message);
        });

        r.on('fileAdded', function(file, event){
            r.upload();
        });

        // add file path 
        // to notification message
        r.on('fileSuccess', function(file, event){
            var newinput = '<input type="hidden" name="filename[]" value="'+file.fileName+'">';
            $("#userslist").append(newinput);
        });
 
        r.on('complete', function(){
            window.onbeforeunload = null;
            notifyupload();
        });

        // Drag & Drop
        $('#uparea').on(
            'dragstart dragenter dragover',
            function(e) {
                $(".overdrag").css('display','block');
        });
        $('.overdrag').on(
            'drop dragleave dragend mouseup',
            function(e) {
                $(".overdrag").css('display','none');
        });

    } else {

        // Resumable.js is not supported, fall back on the form.js method
        var ie = ((document.all) ? true : false);

        $("#upchunk").remove();
        $('#upformsubmit').prop('disabled', true).show();

        // form.js is not supported ( IE < 10 or Safari on Windows), fall back on the old classic form method
        if (ie || ($.client.profile().platform == 'win' && $.client.profile().name == 'safari' )) {
        // if (ie || ($.client.os == 'Windows' && $.client.browser == 'Safari' ) || android == 'yes') {
            $('#upload_file').css('display','table-cell');
            $('.ie_hidden').remove();
            $(document).on('click', '#upformsubmit', function(e) {
                $('#fileToUpload').val('Loading....');
            });
        } else {
        	// use form.js			
            $(document).on('click', '#fileToUpload', function() {
                $('.upload_file').trigger('click');
            });
            $(document).on('click', '#upformsubmit', function(e) {
                e.preventDefault();
                $('.upload_file').trigger('click');
            });
        
	        $(document).ready(function(){

	            var progress = $('#progress-up');
	            var probar = $('.upbar');
	            var prop = $('.upbar p');

	            $('#upForm').ajaxForm({
	                beforeSubmit: function() {            
	                    progress.css('opacity', 1);
	                },
	                uploadProgress: function(event, position, total, percentComplete) {
	                    
	                    probar.width(percentComplete + '%');
	                    prop.html(percentComplete.toFixed(1) + '%');
	                    if (percentComplete == 100) {
	                    	notifyupload();
	                    }
	                }
	            });
	        });
        }
    
        $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

	        // add file path 
	        // to notification message
		    var files = $(this)[0].files;
		    for (var i = 0; i < files.length; i++) {
		        var newinput = '<input type="hidden" name="filename[]" value="'+files[i].name+'">';
		        $("#userslist").append(newinput);
		    }
            if (input.length) {
                input.val(log);
                // auto start upload after select if browser is not IE
                if (!ie) {
                    $("#upForm").submit();
                } else {
                    $('#upformsubmit').prop('disabled', false);
                }
            }
        });
    }
};
