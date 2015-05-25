/**
 * Created by Vilim Stubičan on 24.5.2015..
 */


$(document).ready(function(){
   $(window).scroll(function($event){
       var windowOffset = parseInt($(this).scrollTop());
       var headerOffset = parseInt($(".page-header").height());
       var headerPadding = parseInt($(".page-header").css("padding-top")) + parseInt($(".page-header").css("padding-bottom"));
       console.log(windowOffset, headerOffset);

       if(windowOffset > headerOffset + headerPadding) {
           $(".page-content .admin-menu").css("top", (windowOffset-headerOffset-headerPadding) + "px");
       } else {
           $(".page-content .admin-menu").css("top", "0px");
       }

   })
});