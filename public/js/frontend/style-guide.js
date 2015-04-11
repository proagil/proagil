/*======================================================================
PROAGIL WEB APP - 2015
Authors: AD, SJ
======================================================================*/

/*----------------------------------------------------------------------

        CONSTANST SECTION

----------------------------------------------------------------------*/


$(function() {

/*----------------------------------------------------------------------

        CREATE functions

----------------------------------------------------------------------*/    

  // change tabs function

  $('.tab').on('click', function(){

    var sectionName = $(this).data('tabName');

    console.log($(this));  

    //mark current tab as active
    $('.tab').addClass('tab-off').removeClass('tab-on');
    $(this).addClass('tab-on').removeClass('tab-off'); 


    // hide all sections
    $('.style-guide-section').addClass('hidden');

    // show current section
    $('#section-'+sectionName).removeClass('hidden');

  }) 

  // color picker 
    $('.color').ColorPicker({
      color: '#0000ff',
      onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
      },
      onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
      },
      onChange: function (hsb, hex, rgb) {
        $('.color').css('backgroundColor', '#' + hex);
      }
    });     

  


})
