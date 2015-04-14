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

    var colorCount = 0,
        fontCount = 0;  

    $('.color-picker').colpick({
      layout:'hex',
      submit:0,
      colorScheme:'light',
      color: $(this).val(),
      onShow: function(el){

        console.log($(el).color); 

      },
      onChange:function(hsb,hex,rgb,el,bySetColor) {
        $(el).css('border-color','#'+hex); 
        // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
        if(!bySetColor) $(el).val(hex);
      }
    }).keyup(function(){
       console.log(this.value); 
      $(this).colpickSetColor(this.value);
    });       

    // add color
    $('.btn-add-color').on('click', function(){

      colorCount++; 

      var colorHtml =  '<div class="color-row color-row-'+colorCount+'" style="display:none;">'+
                        '<input type="text" data-input-type="colors" name="values[primary_color][]" class="form-control app-input color-picker"></input>'+
                         '<div data-color-id="'+colorCount+'" class="btn-delete-color circle activity-option txt-center fs-big fc-pink">'+
                              '<i class="fa fa-times fa-fw"></i>'+
                        '</div>'+                         
                        '<br><label class="error fc-pink fs-min hidden">Debe indicar un color v&aacute;lido</label>'+
                        '</div>';
                  

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

      var colorHtml =  '<div class="color-row color-row-'+colorCount+'" style="display:none;">'+
                        '<input type="text" data-input-type="colors" name="values[secundary_color][]" class="form-control app-input color-picker"></input>'+
                         '<div data-color-id="'+colorCount+'" class="btn-delete-color circle activity-option txt-center fs-big fc-pink">'+
                              '<i class="fa fa-times fa-fw"></i>'+
                        '</div>'+                              
                        '<br><label class="error fc-pink fs-min hidden">Debe indicar un color v&aacute;lido</label>'+
                        '</div>'; 
                  

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

    $(document).on('click','.btn-delete-color', function(){

      var colorId = $(this).data('colorId'); 

       $(document).find('.color-row-'+colorId).fadeOut('slow', 
          function() { 
            $(this).remove()
          });
    });

    // add new font values
    $('.add-new-font').on('click', function(){

      fontCount++; 

      var fontHtml =  '<div class="font-info font-content-'+fontCount+'" style="display:none;">'+
                        '<div class="form-group style-guide-form-group">'+
                          '<label class="col-md-4 title-label control-label" for="textinput">Fuente<span class="fc-pink fs-med">*</span></label>'+  
                          '<div class="col-md-4">'+
                            '<input data-font-type="name" data-input-type="fonts" class="form-control app-input" placeholder="Nombre de fuente. Ej: Arial" name="values[font_name][]" type="text" value="">'+
                            '<br><label class="error-name fc-pink fs-min hidden">Debe indicar un nombre de fuente</label>'+
                            '<input data-font-type="size" data-input-type="fonts" class="form-control app-input" placeholder="Tamaño de fuente. Ej: 14px" name="values[font_size][]" type="text" value="">'+
                             '<div data-font-id="'+fontCount+'" class="btn-delete-font circle activity-option txt-center fs-big fc-pink">'+
                                  '<i class="fa fa-times fa-fw"></i>'+
                            '</div>'+                            
                            '<br><label class="error-size fc-pink fs-min hidden">Debe indicar un tama&ntilde;o de fuente</label>'+
                          '</div>'+
                        '</div>'+  
                      '</div>';   

        $(fontHtml).appendTo('.fonts-content').fadeIn('slow');                 

    });

    $(document).on('click','.btn-delete-font', function(){

      var fontId = $(this).data('fontId'); 

       $(document).find('.font-content-'+fontId).fadeOut('slow', 
          function() { 
            $(this).remove()
          });
    });

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


/*----------------------------------------------------------------------

        EDIT functions

----------------------------------------------------------------------*/    

    var newColorCount = 0,
        newFontCount = 0;   

    // add color
    $('.btn-add-new-color').on('click', function(){

      newColorCount++; 

      var colorHtml =  '<div class="color-row color-new-row-'+newColorCount+'" style="display:none;">'+
                        '<input type="text" data-input-type="colors" name="values[primary_color][]" class="form-control app-input color-picker"></input>'+
                         '<div data-color-id="'+newColorCount+'" class="btn-delete-new-color circle activity-option txt-center fs-big fc-pink">'+
                              '<i class="fa fa-times fa-fw"></i>'+
                        '</div>'+                         
                        '<br><label class="error fc-pink fs-min hidden">Debe indicar un color v&aacute;lido</label>'+
                        '</div>';
                  

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

     $('.btn-add-new-secundary-color').on('click', function(){

      newColorCount++; 

      var colorHtml =  '<div class="color-row color-new-row-'+newColorCount+'" style="display:none;">'+
                        '<input type="text" data-input-type="colors" name="values[secundary_color][]" class="form-control app-input color-picker"></input>'+
                         '<div data-color-id="'+newColorCount+'" class="btn-delete-new-color circle activity-option txt-center fs-big fc-pink">'+
                              '<i class="fa fa-times fa-fw"></i>'+
                        '</div>'+                              
                        '<br><label class="error fc-pink fs-min hidden">Debe indicar un color v&aacute;lido</label>'+
                        '</div>'; 
                  

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

    $(document).on('click','.btn-delete-new-color', function(){

      var colorId = $(this).data('colorId'); 

       $(document).find('.color-new-row-'+colorId).fadeOut('slow', 
          function() { 
            $(this).remove()
          });
    });

    // add new font values
    $('.add-new-font-edit').on('click', function(){

      newFontCount++; 

      var fontHtml =  '<div class="font-info font-new-content-'+newFontCount+'" style="display:none;">'+
                        '<div class="form-group style-guide-form-group">'+
                          '<label class="col-md-4 title-label control-label" for="textinput">Fuente<span class="fc-pink fs-med">*</span></label>'+  
                          '<div class="col-md-4">'+
                            '<input data-font-type="name" data-input-type="fonts" class="form-control app-input" placeholder="Nombre de fuente. Ej: Arial" name="values[font_name][]" type="text" value="">'+
                            '<br><label class="error-name fc-pink fs-min hidden">Debe indicar un nombre de fuente</label>'+
                            '<input data-font-type="size" data-input-type="fonts" class="form-control app-input" placeholder="Tamaño de fuente. Ej: 14px" name="values[font_size][]" type="text" value="">'+
                             '<div data-font-id="'+newFontCount+'" class="btn-delete-new-font circle activity-option txt-center fs-big fc-pink">'+
                                  '<i class="fa fa-times fa-fw"></i>'+
                            '</div>'+                            
                            '<br><label class="error-size fc-pink fs-min hidden">Debe indicar un tama&ntilde;o de fuente</label>'+
                          '</div>'+
                        '</div>'+  
                      '</div>';   

        $(fontHtml).appendTo('.fonts-content').fadeIn('slow');                 

    });

    $(document).on('click','.btn-delete-new-font', function(){

      var fontId = $(this).data('fontId'); 

       $(document).find('.font-new-content-'+fontId).fadeOut('slow', 
          function() { 
            $(this).remove()
          });
    });

    $('.btn-delete-saved-color').on('click',function(e){

       e.preventDefault(); 

        var colorId = $(this).data('colorId'); 

        var showAlert = swal({
          title: 'Eliminar color',
          text: 'Confirma que desea eliminar el color de la guía de estilos',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef6f66',
          confirmButtonText: 'Si, eliminar',
          cancelButtonText: 'Cancelar',
          cancelButtonColor: '#ef6f66',
          closeOnConfirm: true
        },
        function(){

         $.ajax({
            url: projectURL+'/guia-de-estilos/eliminar-color/'+colorId,
            type:'GET',
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                   $(document).find('.color-row-saved-'+colorId).fadeOut('slow', 
                      function() { 
                        $(this).remove();
                    });
                 

                }
            },
            error: function(xhr, error) {

            }
          });     

        });               

    });   


    $('.btn-delete-saved-font').on('click', function(e){

       e.preventDefault(); 

        var fontId = $(this).data('fontId'); 

        var showAlert = swal({
          title: 'Eliminar fuente',
          text: 'Confirma que desea eliminar la fuente de la guía de estilos',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef6f66',
          confirmButtonText: 'Si, eliminar',
          cancelButtonText: 'Cancelar',
          cancelButtonColor: '#ef6f66',
          closeOnConfirm: true
        },
        function(){

         $.ajax({
            url: projectURL+'/guia-de-estilos/eliminar-fuente/'+fontId,
            type:'GET',
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                   $(document).find('.font-saved-content-'+fontId).fadeOut('slow', 
                      function() { 
                        $(this).remove();
                    });
                 

                }
            },
            error: function(xhr, error) {

            }
          });     

        });               

    });   

    $('.edit-style-guide').on('click', function(){

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
                $(document).find('#form-edit-guide-style').submit(); 
              }  
      
    })  

    $('.btn-delete-style-guide').on('click',function(e){

      console.log('xxx'); 

       e.preventDefault(); 

        var styleGuideId = $(this).data('styleGuideId'),
            styleGuideName = $(this).data('styleGuideName'); 

        var showAlert = swal({
          title: 'Eliminar color',
          text: 'Confirma que desea eliminar la guía de estilos: '+styleGuideName,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef6f66',
          confirmButtonText: 'Si, eliminar',
          cancelButtonText: 'Cancelar',
          cancelButtonColor: '#ef6f66',
          closeOnConfirm: true
        },
        function(){

          window.location.href = projectURL+'/guia-de-estilos/eliminar/'+styleGuideId;  

        });               

    });                

})
