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

    //mark current tab as active
    $('.tab').addClass('tab-off').removeClass('tab-on');
    $(this).addClass('tab-on').removeClass('tab-off'); 


    // hide all sections
    $('.style-guide-section').addClass('hidden');

    // show current section
    $('#section-'+sectionName).removeClass('hidden');

  }) 

    var colorCount = 0; 

    // add color
    $('.btn-add-color').on('click', function(){

      colorCount++; 

      var colorHtml =  '<input type="text" data-input-type="colors" name="values[primary_color][]" class="form-control app-input color-picker"></input>'+
                        '<br><label class="error fc-pink fs-min hidden">Debe indicar un color v&aacute;lido</label>';
                  

      $(colorHtml).appendTo('.primary-color-content').fadeIn('slow');

     $(document).find('.color-picker').colpick({
      layout:'hex',
      submit:0,
      colorScheme:'light',
      onChange:function(hsb,hex,rgb,el,bySetColor) {
        $(el).css('border-color','#'+hex);
        // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
        if(!bySetColor) $(el).val(hex);
      }
    }).keyup(function(){
      $(this).colpickSetColor(this.value);
    });     

    })

     $('.btn-add-secundary-color').on('click', function(){

      colorCount++; 

      var colorHtml =  '<input type="text" data-input-type="colors" name="values[secundary_color][]" class="form-control app-input color-picker"></input>'+
                        '<br><label class="error fc-pink fs-min hidden">Debe indicar un color v&aacute;lido</label>';
                  

      $(colorHtml).appendTo('.secundary-color-content').fadeIn('slow');

       $(document).find('.color-picker').colpick({
        layout:'hex',
        submit:0,
        colorScheme:'light',
        submitText: 'oo',
        onChange:function(hsb,hex,rgb,el,bySetColor) {
          $(el).css('border-color','#'+hex);
          // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
          if(!bySetColor) $(el).val(hex);
        }
      }).keyup(function(){
        $(this).colpickSetColor(this.value);
      });     

    }) 

    // add new font values
    $('.add-new-font').on('click', function(){

      var fontHtml =  '<div class="font-info" style="display:none;">'+
                        '<div class="form-group style-guide-form-group">'+
                          '<label class="col-md-4 title-label control-label" for="textinput">Fuente<span class="fc-pink fs-med">*</span></label>'+  
                          '<div class="col-md-4">'+
                            '<input data-font-type="name" data-input-type="fonts" class="form-control app-input" placeholder="Nombre de fuente. Ej: Arial" name="values[font_name][]" type="text" value="">'+
                            '<br><label class="error-name fc-pink fs-min hidden">Debe indicar un nombre de fuente</label>'+
                            '<input data-font-type="size" data-input-type="fonts" class="form-control app-input" placeholder="Tamaño de fuente. Ej: 14px" name="values[font_size][]" type="text" value="">'+
                            '<br><label class="error-size fc-pink fs-min hidden">Debe indicar un tama&ntilde;o de fuente</label>'+
                          '</div>'+
                        '</div>'+  
                      '</div>';   

        $(fontHtml).appendTo('.fonts-content').fadeIn('slow');                 

    })

    $('.save-style-guide').on('click', function(){

          var successValidation = 0,
              totalValues = 0;

              //validate style guide elements
              $('input[type="text"]').each(function(){


                if(typeof $(this).data('inputType')!== 'undefined'){

                  totalValues++; 

                  switch($(this).data('inputType')) {
                    case 'information':
                      if($(this).val() == ''){
                        $(this).siblings('.error').removeClass('hidden'); 

                        //$('*[data-tab-name="information"]').addClass('fc-pink');
                      }else{
                         $(this).siblings('.error').addClass('hidden');
                          successValidation++; 

                      }
                    break; 
                    case 'colors':
                      if($(this).val() != '' && $(this).val().match(/[0-9A-Fa-f]{6}/g)){
                        $(this).siblings('.error').addClass('hidden'); 
                        successValidation++; 

                      }else{
   
                        $(this).siblings('.error').removeClass('hidden');   

                      }  
                    break; 
                    case 'fonts':
                        if($(this).data('fontType')=='name'){

                          if($(this).val() == ''){

                            $(this).siblings('.error-name').removeClass('hidden'); 

                            $('*[data-tab-name="fonts"]').addClass('fc-pink');
                          }else{
                             $(this).siblings('.error-name').addClass('hidden');

                              successValidation++; 

                          }                          

                        }else{

                          if($(this).val() == ''){

                            $(this).siblings('.error-size').removeClass('hidden'); 

                          }else{
                             $(this).siblings('.error-size').addClass('hidden');

                              successValidation++; 

                          }                            
                          
                        }
                    break;                                         
                  }

                }
              });

              console.log('successValidation: '+successValidation+' totalValues: '+totalValues);

              // success validation, all categories are valid
              if(successValidation==totalValues){
                $(document).find('#form-save-guide-style').submit(); 
              }  
      
    })    

})
