$(document).ready(function()
{
  'use strict';
/*
* ----------------------------------------------------------------------------------------
* 01. Sidebar Toggle
* ----------------------------------------------------------------------------------------
*/
  $('.open-sidebar').click(function(evt){
    evt.preventDefault();
    if($(this).attr('data-sidebar-status') == 'false') {
        $('.sidebar , .content-area').addClass('no-sidebar');
        $(this).attr('data-sidebar-status', 'true');
        if(getCookie('sidebar_opened') == "") {
            setCookie('sidebar_opened', true, 180, 'mvcapp.work');
        }
    }else {
        $(this).attr('data-sidebar-status', 'false');
        $('.sidebar , .content-area').removeClass('no-sidebar');
        deleteCookie('sidebar_opened', 'mvcapp.work');
    }
  });
/*
* ----------------------------------------------------------------------------------------
* 02. Sidebar Nav Item (Adding Class Active on Click And Remove From The Siblings)
* ----------------------------------------------------------------------------------------
*/
  $('.sidebar .nav-link').click(function(){
    $(this).addClass('active');
    $(this).parent().siblings().find('.nav-link').removeClass('active');
    $(this).parent().siblings().find('.item-dropdown-menu').slideUp();

  });
/*
* ----------------------------------------------------------------------------------------
* 03. Sidebar Sub Item Menu Toggle
* ----------------------------------------------------------------------------------------
*/
  $('.sidebar .item-dropdown .nav-link').click(function(e){
    e.preventDefault();
    $('.sidebar').css('overflow', 'unset')
    $(this).parent().find('i').toggleClass('toggled');
    $(this).parent().siblings().find('i').removeClass('toggled');

    $(this).parent().find('.item-dropdown-menu').slideToggle(300);
    $(this).parent().siblings().find('.item-dropdown-menu').slideUp();

  });

/*
* ----------------------------------------------------------------------------------------
* 04. Switcher Toggle
* ----------------------------------------------------------------------------------------
*/
  $('.option-switcher').click(function(e){
    e.preventDefault();
    $('.option-box').toggleClass('active');
    $(this).find('i').toggleClass('fa-spin');
  });

/*
* ----------------------------------------------------------------------------------------
* 05. Hide The Sidebar If Option box Is Opening Or vice versa
* ----------------------------------------------------------------------------------------
*/
  if ($(window).width() < 768){
    $('.option-switcher').click(function(e){
      e.preventDefault();
      $('.sidebar , .content-area').addClass('no-sidebar');
    });

    $('.open-sidebar').click(function(e){
      e.preventDefault();
      $('.option-box').removeClass('active');
    });
  }

/*
* ----------------------------------------------------------------------------------------
* 06. Nice Scroll Option For Body And Another Parts (an md - lg screen)
* ----------------------------------------------------------------------------------------
*/

  if ($(window).width() > 768){
    // Body Nice Scroll
    // $("body").niceScroll({
    //   cursorcolor:"#58626c",
    //   cursorwidth:"13px",
    //   scrollspeed:300,
    //   zindex:99999999,
    // });
    // Sidebar Nice Scroll
    $(".sidebar").niceScroll(".sidebar-content", {
      scrollspeed:300,
      cursorborder:'none',
    });

  }

/*
* ----------------------------------------------------------------------------------------
* 07. Hidden Passive event listeners Errors
* ----------------------------------------------------------------------------------------
*/
  jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ){
      if ( ns.includes("noPreventDefault") ) {
        this.addEventListener("touchstart", handle, { passive: false });
      } else {
        this.addEventListener("touchstart", handle, { passive: true });
      }
    }
  };

/*
* ----------------------------------------------------------------------------------------
* 08. Card Dropdown
* ----------------------------------------------------------------------------------------
*/
  $('.card .card-header .dropdown-toggle').click(function(evt){
    evt.preventDefault();
    if($(this).attr('aria-expanded') == 'false') {
        $('.card .card-header .dropdown-menu').addClass('show');
        $(this).attr('aria-expanded', 'true');
    }else {
        $(this).attr('aria-expanded', 'false');
        $('.card .card-header .dropdown-menu').removeClass('show');
    }
  });
/*
* ----------------------------------------------------------------------------------------
* 09. NProgress Config
* ----------------------------------------------------------------------------------------
*/
    NProgress.start();
    setTimeout(function() {
       NProgress.done(); $('.fade').removeClass('out');
    }, 300);

});



/*
* ----------------------------------------------------------------------------------------
* Load Event
* ----------------------------------------------------------------------------------------
*/
