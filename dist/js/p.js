!function(e){var t={};function s(l){if(t[l])return t[l].exports;var n=t[l]={i:l,l:!1,exports:{}};return e[l].call(n.exports,n,n.exports,s),n.l=!0,n.exports}s.m=e,s.c=t,s.d=function(e,t,l){s.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:l})},s.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},s.t=function(e,t){if(1&t&&(e=s(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var l=Object.create(null);if(s.r(l),Object.defineProperty(l,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)s.d(l,n,function(t){return e[t]}.bind(null,n));return l},s.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="",s(s.s=0)}([function(e,t,s){"use strict";s.r(t);s(1),s(2),s(3),s(4),s(5),s(6)},function(e,t,s){},function(e,t,s){},function(e,t,s){},function(e,t,s){},function(e,t,s){},function(e,t){jQuery((function(e){e(".sf-public-file-upload-container input[type=checkbox]").prop("disabled",!1),e(document).on("click","a.shared-files-file-title, a.shared-files-preview-image",(function(t){var s=/^((?!chrome|android).)*safari/i.test(navigator.userAgent),l=e(this).data("file-type"),n=e(this).data("file-url"),i=e(this).data("external-url"),a=e(this).attr("href");if(e(this).data("image-url")&&(a=e(this).data("image-url")),l.startsWith("video")&&!s){t.preventDefault();var d='<video preload controls autoplay><source src="'+n+'" /></video>',o=basicLightbox.create(d);jQuery.post(n,{only_meta:1},(function(e){})),o.show()}else if("youtube"==l&&i){t.preventDefault();var r=i.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/),f=r&&11===r[2].length?r[2]:null,u=basicLightbox.create('<iframe allow="autoplay" src="//www.youtube.com/embed/'+f+'?autoplay=1" width="560" height="315" frameborder="0" allowfullscreen style="width: 560px;"></iframe>');jQuery.post(n,{youtube:1},(function(e){})),u.show()}else if("image"==l){t.preventDefault(),basicLightbox.create('<img src="'+a+'" />').show(),n&&jQuery.post(n,{only_meta:1},(function(e){}))}})),e(".shared-files-category-select").change((function(){e(".shared-files-ajax-form");var t={action:"sf_get_files",sf_category:e(this).val()};jQuery.post(ajaxurl,t,(function(t){var s=t.replace(/0$/,"");e(".shared-files-non-ajax").hide(),e(".shared-files-ajax-list").empty().append(s);var l="./?"+e(".shared-files-ajax-form select").serialize();window.history.pushState({urlPath:l},"",l)}))})),e(document).on("click",".shared-files-tag-link",(function(t){t.preventDefault();var s,l="";s=e(this).data("tag-slug"),1==e(this).data("hide-description")&&(l=1);var n={action:"sf_get_files",sf_tag:s,hide_description:l};jQuery.post(ajaxurl,n,(function(t){var l=t.replace(/0$/,"");e(".shared-files-non-ajax").hide(),e(".shared-files-category-select").val(e(".shared-files-category-select option:first").val()),e(".shared-files-ajax-list").empty().append(l);var n="";n=s?"./?sf_tag="+s:"./?sf_tag=",window.history.pushState({urlPath:n},"",n)}))})),e(".shared-files-search-files").keyup((function(){var e,t,s,l,n;t=(e=document.getElementById("search-files")).value.toUpperCase(),s=document.getElementById("shared-files-all-files").getElementsByTagName("li");var i=0,a=0;for(l=0;l<s.length;l++)(n=s[l].getElementsByClassName("shared-files-main-elements")[0])&&n.textContent.toUpperCase().indexOf(t)>-1?(s[l].style.display="",a++):(s[l].style.display="none",i++);""==e.value?(document.getElementById("shared-files-nothing-found").style.display="none",document.getElementById("shared-files-files-found").style.display="none",document.getElementById("myList").style.display="block",document.getElementById("shared-files-pagination").style.display="block",document.getElementById("shared-files-all-files").style.display="none"):s.length==i?(document.getElementById("shared-files-nothing-found").style.display="block",document.getElementById("shared-files-files-found").style.display="none",document.getElementById("myList").style.display="none",document.getElementById("shared-files-pagination").style.display="none",document.getElementById("shared-files-all-files").style.display="block"):(document.getElementById("shared-files-nothing-found").style.display="none",document.getElementById("shared-files-files-found").innerHTML=a+" "+(a>1?document.getElementById("shared-files-more-than-one-file-found").innerHTML:document.getElementById("shared-files-one-file-found").innerHTML),document.getElementById("shared-files-files-found").style.display="block",document.getElementById("myList").style.display="none",document.getElementById("shared-files-pagination").style.display="none",document.getElementById("shared-files-all-files").style.display="block")})),e(".shared-files-search-files-v2").keyup((function(){var t,s,l,n,i;s=(t=document.getElementById("search-files")).value.toUpperCase(),l=document.getElementById("shared-files-all-files").getElementsByTagName("li");var a=0,d=0;for(n=0;n<l.length;n++)(i=l[n].getElementsByClassName("shared-files-main-elements")[0])&&i.textContent.toUpperCase().indexOf(s)>-1?(l[n].style.display="",d++):(l[n].style.display="none",a++);""==t.value?(e("#shared-files-nothing-found").hide(),e("#shared-files-files-found").hide(),e("#myList").show(),e("#shared-files-pagination").show(),e("#shared-files-all-files").hide()):l.length==a?(e("#shared-files-nothing-found").show(),e("#shared-files-files-found").hide(),e("#myList").hide(),e("#shared-files-pagination").hide(),e("#shared-files-all-files").show()):(e("#shared-files-nothing-found").hide(),e("#shared-files-files-found").html(d+" "+(d>1?e("#shared-files-more-than-one-file-found").html():e("#shared-files-one-file-found").html())),e("#shared-files-files-found").show(),e("#myList").hide(),e("#shared-files-pagination").hide(),e("#shared-files-all-files").show())})),e(".shared-files-simple-search").keyup((function(){var t,s,l,n,i;s=(t=document.getElementsByClassName("shared-files-simple-search")[0]).value.toUpperCase(),l=document.getElementsByClassName("shared-files-simple-list")[0].getElementsByClassName("shared-files-simple-list-row");var a=0,d=0;for(n=0;n<l.length;n++)(i=l[n].getElementsByClassName("shared-files-simple-list-col-name")[0])&&i.textContent.toUpperCase().indexOf(s)>-1?(l[n].style.display="",d++):(l[n].style.display="none",a++);""==t.value?(e(".shared-files-simple-nothing-found").hide(),e("#shared-files-files-found").hide()):l.length==a?(e(".shared-files-simple-nothing-found").show(),e("#shared-files-files-found").hide()):(e(".shared-files-simple-nothing-found").hide(),e("#shared-files-files-found").html(d+" "+(d>1?e("#shared-files-more-than-one-file-found").html():e("#shared-files-one-file-found").html())),e("#shared-files-files-found").show())})),e(".shared-files-search-all-files").keyup((function(){var e,t,s,l,n;t=(e=document.getElementById("search-files")).value.toUpperCase(),uls=document.getElementsByClassName("shared-files-in-category");var i=0;for(z=0;z<uls.length;z++){s=uls[z].getElementsByTagName("li");var a=0;for(l=0;l<s.length;l++)(n=s[l].getElementsByClassName("shared-files-main-elements")[0])&&n.textContent.toUpperCase().indexOf(t)>-1?(s[l].style.display="",i++,a++):(s[l].style.display="none");uls[z].parentElement.style.display=0==a?"none":""}""==e.value?(document.getElementById("shared-files-nothing-found").style.display="none",document.getElementById("shared-files-files-found").style.display="none",document.getElementsByClassName("shared-files-all-files-and-categories")[0].style.display="none"):0==i?(document.getElementById("shared-files-nothing-found").style.display="block",document.getElementById("shared-files-files-found").style.display="none",document.getElementsByClassName("shared-files-all-files-and-categories")[0].style.display="block"):(document.getElementById("shared-files-nothing-found").style.display="none",document.getElementById("shared-files-files-found").innerHTML=i+" "+(i>1?document.getElementById("shared-files-more-than-one-file-found").innerHTML:document.getElementById("shared-files-one-file-found").innerHTML),document.getElementById("shared-files-files-found").style.display="block",document.getElementsByClassName("shared-files-all-files-and-categories")[0].style.display="block")}))}))}]);