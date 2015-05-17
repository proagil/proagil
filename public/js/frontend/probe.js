/*======================================================================
PROAGIL WEB APP - 2015
Authors: AD, SJ
======================================================================*/

/*----------------------------------------------------------------------

        CONSTANST SECTION

----------------------------------------------------------------------*/

    var TYPE_INPUT      = 1,
        TYPE_TEXTAREA   = 2,
        TYPE_RADIO      = 3,
        TYPE_CHECKBOX   = 4;


$(function() {


 /*----------------------------------------------------------------------

        ADD PROBE FUNCTIONS

----------------------------------------------------------------------*/ 

      var questionCount = 0,
          optionCount = 0; 

      // add question row to DOM
      $(document).on('click','.add-question-row', function(e){

        e.preventDefault(); 

        var html = ''; 

        questionCount++; 

               html += '<div class="probe-question-content question-'+questionCount+'" style="display:none;">'+
                  '<label class="probe-label txt-right">Pregunta:</label>'+
                  '<input type="text" name="probe[questions]['+questionCount+'][question]" placeholder="Especifique una pregunta para el sondeo" class="probe-input form-control">'+   

                  '<label class="probe-label txt-right">Tipo de pregunta:</label>'+
                  '<select name="probe[questions]['+questionCount+'][form_element]" class="probe-input-i form-control type-answer-option" data-question-id="'+questionCount+'">';
                  $.each(answerTypes, function(index, type) {
                      html += '<option value="'+index+'">'+type+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Pregunta obligatoria:</label>'+
                  '<input name="probe[questions]['+questionCount+'][required]" type="checkbox">'+

                  '<div class="circle activity-option txt-center fs-big fc-pink pull-right delete-question-row" data-question-id="'+questionCount+'">'+
                    '<i class="fa fa-times fa-fw"></i>'+
                  '</div>'+                  
                '</div>'+

                '<div class="probe-options-question hidden question-options-content-'+questionCount+'">'+  
                  '<div class="all-options-content question-options-'+questionCount+'">'+
                  '</div>'+ 
                  '<div class="btn-add-question-option" data-question-id="'+questionCount+'">'+
                    '<div class="circle activity-option txt-center fs-big fc-turquoise">'+
                      '<i class="fa fa-plus fa-fw"></i>'+
                    '</div>'+                                          
                    '<span class="probe-label"> Agregar opci&oacute;n</span>'+   
                  '</div>'+
                '</div>';  

                 $(html).appendTo('.probe-questions-lists').fadeIn('slow');

   
    });

    // delete question row from DOM
    $(document).on('click', '.delete-question-row', function(e){

        e.preventDefault();

        var questionId = $(this).data('questionId');

          $(document).find('.question-'+questionId).fadeOut('slow', 
              function() { 
                $(this).remove()
          });

          $(document).find('.question-options-content-'+questionId).fadeOut('slow', 
              function() { 
                $(this).remove()
          });          

    });

    // on change answer type
    $(document).on('change', '.type-answer-option', function(e){

        var AnswerType = $(this).val(),
            questionId = $(this).data('questionId');       

            if(AnswerType == TYPE_RADIO || AnswerType == TYPE_CHECKBOX ){

              $(document).find('.question-options-content-'+questionId).removeClass('hidden').fadeIn('slow');               

            }else{

              $(document).find('.question-options-content-'+questionId).addClass('hidden').fadeOut('slow'); 
            }

    });

    $(document).on('click', '.btn-add-question-option', function(e){

        var questionId = $(this).data('questionId'),
            htmlOptions = '';    

        optionCount++; 

          htmlOptions += '<div class="question-option option-'+questionId+'-'+optionCount+'">'+
              '<input name="probe[questions]['+questionId+'][option]['+optionCount+'][name]" type="text" placeholder="Opción para la pregunta" class="probe-input-option form-control">'+
                '<div class="circle activity-option txt-center fs-big fc-pink delete-question-option" data-option-id="'+optionCount+'" data-question-id="'+questionId+'">'+
                    '<i class="fa fa-times fa-fw"></i>'+
                  '</div>'+                     
          '</div>';      

          $(htmlOptions).appendTo('.question-options-'+questionId).fadeIn('slow');

    });

    // delete question option from DOM
    $(document).on('click', '.delete-question-option', function(e){

        e.preventDefault();

        var questionId = $(this).data('questionId'),
            optionId = $(this).data('optionId')

          $(document).find('.option-'+questionId+'-'+optionId).fadeOut('slow', 
              function() { 
                $(this).remove()
          });

    });



    $(document).on('click', '.save-probe', function(e){

        var successValidation = 0,
            totalInputs = 0;

        //validate categories
        $('input[type="text"], textarea').each(function(){

          totalInputs++; 

          if($(this).val() == ''){
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $(this).addClass('error-probe-input');
            $('.error-alert-text').html(' Debe especificar un valor para los campos de textos indicados').parent().removeClass('hidden'); 
          }else{
              successValidation++; 
          }
        });


        // success validation, all inputs are valid
        if(successValidation==2){
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          $('.error-alert-text').html(' Debe especificar al menos una pregunta para el sondeo').parent().removeClass('hidden');
        }else if(successValidation==totalInputs){
          $('#form-create-probe').submit(); 
        }  
    });  



     /*----------------------------------------------------------------------

          EDIT PROBE FUNCTIONS

      ----------------------------------------------------------------------*/

     $(document).on('click', '.edit-probe-info', function(e){

      $('.edit-probe-info-save').removeClass('hidden');
      $('.edit-probe-info-default').addClass('hidden');

       var probeId = $(this).data('probeId'); 

       $.ajax({
          url: projectURL+'/sondeo/obtener-sondeo-informacion/'+probeId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                var htmlTitle = '<input type="text" value="'+response.data.title+'" name="values[title]" class="question-title-'+probeId+' probe-input-name probe-input form-control">'
                $('.question-title-'+probeId).replaceWith(htmlTitle);


                var htmlProbeType = '<select name="values[status]" class="question-status-'+probeId+' probe-input-i form-control type-answer-option">';
                  $.each(response.probe_status, function(index, type) {
                    if(index==response.data.status){
                        htmlProbeType += '<option value="'+index+'" selected>'+type+'</option>';
                    }else{
                        htmlProbeType += '<option value="'+index+'">'+type+'</option>';
                    }
                  }); 
                  htmlProbeType += '</select>';      
                  $('.question-status-'+probeId).replaceWith(htmlProbeType);   

                  var htmlDescription = '<textarea name="values[description]" class="question-description-'+probeId+' probe-input-description probe-input form-control">'+response.data.description+'</textarea>';              
                  $('.question-description-'+probeId).replaceWith(htmlDescription); 

              }
          },
          error: function(xhr, error) {

          }
      });      

    })

     $(document).on('click', '.cancel-edit-question-info', function(e){


       var probeId = $(this).data('probeId'); 

       $.ajax({
          url: projectURL+'/sondeo/obtener-sondeo-informacion/'+probeId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                var htmlTitle = '<div class="question-title-'+probeId+' fc-turquoise">T&iacute;tulo: <span class="fc-blue-i probe-label-value">'+response.data.title+'</span></div>';
                $('.question-title-'+probeId).replaceWith(htmlTitle);

                var probeStatus = (response.data.status==1)?'Cerrado':'Abierto'; 
                var htmlProbeType = '<div class="question-status-'+probeId+' fc-turquoise">Estado: <span class="fc-blue-i probe-label-value">'+probeStatus+'</span>';
   
                $('.question-status-'+probeId).replaceWith(htmlProbeType);   

                var htmlDescription = '<div class="question-description-'+probeId+' fc-turquoise">Descripci&oacute;n: <span class="fc-blue-i probe-label-value">'+response.data.description+'</span></div>';              
                $('.question-description-'+probeId).replaceWith(htmlDescription); 

                 $('.edit-probe-info-save').addClass('hidden');
                 $('.edit-probe-info-default').removeClass('hidden');

              }
          },
          error: function(xhr, error) {

          }
      });      

    })
 
    // alde
     $(document).on('click', '.save-edit-probe-info', function(e){

       var probeId = $(this).data('probeId'); 

       if($('input[name="values[title]').val()=='' || 
          $('textarea[name="values[description]').val() == ''){

            $('html, body').animate({ scrollTop: 0 }, 'slow');

            if($('input[name="values[title]').val()==''){
              $('input[name="values[title]').addClass('error-probe-input');
            }   

            if($('textarea[name="values[description]').val()==''){
              $('textarea[name="values[description]').addClass('error-probe-input');
            }                                 
            
            $('.error-alert-text').html(' Debe especificar un valor para los campos indicados').parent().removeClass('hidden');


       }else{

            var parameters = {
                'values[probe_id]'    : probeId,
                'values[title]'       : $('input[name="values[title]').val(),
                'values[status]'      : $('select[name="values[status]').val(), 
                'values[description]' : $('textarea[name="values[description]').val(),
            };


           $.ajax({
              url: projectURL+'/sondeo/guardar-sondeo-informacion/',
              type:'POST',
              dataType: 'JSON',
              data: parameters,
              success:function (response) {

                  if(!response.error){

                    console.log(response); 

                    var htmlTitle = '<div class="question-title-'+probeId+' fc-turquoise">T&iacute;tulo: <span class="fc-blue-i probe-label-value">'+response.data.title+'</span></div>';
                    $('.question-title-'+probeId).replaceWith(htmlTitle);

                    var statusText = (response.data.status==1)?'Cerrado':'Abierto';
                    var htmlProbeStatus = '<div class="question-status-'+probeId+' fc-turquoise">Estado: <span class="fc-blue-i probe-label-value">'+statusText+'</span></div>';   
                      $('.question-status-'+probeId).replaceWith(htmlProbeStatus);   

                    var htmlDescription = '<div class="question-description-'+probeId+' fc-turquoise">Descripci&oacute;n: <span class="fc-blue-i probe-label-value">'+response.data.description+'</span></div>';              
                      $('.question-description-'+probeId).replaceWith(htmlDescription); 


                      $('.edit-probe-info-save').addClass('hidden');
                      $('.edit-probe-info-default').removeClass('hidden');


                  }
              },
              error: function(xhr, error) {

              }
          });   

      }   

    })       

    /*Al hacer clic en el editar de una pregunta*/

    $(document).on('click', '.edit-question-element', function(e){

      var questionId = $(this).data('questionId'); 

      $('.question-options-default-'+questionId).addClass('hidden');
      $('.question-options-edit-'+questionId).removeClass('hidden');

       $.ajax({
          url: projectURL+'/sondeo/obtener-pregunta/'+questionId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                var answerTypes; 

                if(response.data.form_element==TYPE_INPUT || response.data.form_element == TYPE_TEXTAREA){

                  answerTypes = answerTypesOpen;

                }else{

                  answerTypes = answerTypesClose;

                }

                var htmlQuestion = '<input type="text" name="values['+questionId+'][question]"  value="'+response.data.question+'"class="probe-input probe-input-edit form-control question-title-'+questionId+'">';
                 $('.question-title-'+questionId).replaceWith(htmlQuestion);

                var htmlTypeQuestion = '<select name="values['+questionId+'][form_element]" class="probe-input-i form-control type-answer-option question-type-'+questionId+'" data-question-id="'+questionId+'">';
                  $.each(answerTypes, function(index, type) {
                    if(index==response.data.form_element){
                        htmlTypeQuestion += '<option value="'+index+'" selected>'+type+'</option>';
                    }else{
                        htmlTypeQuestion += '<option value="'+index+'">'+type+'</option>';
                    }

                  });
                  htmlTypeQuestion += '</select>'      
                  $('.question-type-'+questionId).replaceWith(htmlTypeQuestion);  

                  var checkValue = (response.data.required)?'checked':'';      

                  var htmlRequired = '<input class="question-required-'+questionId+'" name="values['+questionId+'][required]" type="checkbox" '+checkValue+'>'; 
                  $('.question-required-'+questionId).replaceWith(htmlRequired);       
          

              }
          },
          error: function(xhr, error) {

          }
      });      

    })

    /*Al hacer clic en el guardar de una pregunta editada*/
    $(document).on('click', '.save-edit-question', function(e){

      var questionId = $(this).data('questionId'); 

      if($('input[name="values['+questionId+'][question]"]').val() != ''){

        var parameters = {
            'values[question_id]'     : questionId,
            'values[question]'        : $('input[name="values['+questionId+'][question]"]').val(), 
            'values[form_element]'    : $('select[name="values['+questionId+'][form_element]"]').val(),
            'values[required]'        : (($('input[name="values['+questionId+'][required]"]').is(':checked'))?1:0)
        };


         $.ajax({
            url: projectURL+'/sondeo/guardar-pregunta/',
            type:'POST',
            data: parameters,
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                   var htmlQuestion = '<div class="probe-label probe-label-value question-title-'+questionId+'">'+response.data.question+'</div>'; 
                   $('.question-title-'+questionId).replaceWith(htmlQuestion);

                   var htmlTypeQuestion = '<div class="probe-label probe-label-value question-type-'+questionId+'">'+response.data.form_element_name+'</div>'; 
                   $('.question-type-'+questionId).replaceWith(htmlTypeQuestion);  

                    var requiredValue = (response.data.required)?'Si':'No'; 
                    var htmlRequired = '<div class="probe-label probe-label-value question-required-'+questionId+'">'+requiredValue+'</div>'; 
                   $('.question-required-'+questionId).replaceWith(htmlRequired);     

                  $('.question-options-default-'+questionId).removeClass('hidden');
                  $('.question-options-edit-'+questionId).addClass('hidden');
            

                }
            },
            error: function(xhr, error) {

            }
          });     

      }else{
        alert('vaciooo'); 
      }

    })

    $(document).on('click', '.cancel-edit-question', function(e){

      var questionId = $(this).data('questionId'); 


       $.ajax({
          url: projectURL+'/sondeo/obtener-pregunta/'+questionId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                   var htmlQuestion = '<div class="probe-label probe-label-value question-title-'+questionId+'">'+response.data.question+'</div>'; 
                   $('.question-title-'+questionId).replaceWith(htmlQuestion);

                   var htmlTypeQuestion = '<div class="probe-label probe-label-value question-type-'+questionId+'">'+response.data.form_element_name+'</div>'; 
                   $('.question-type-'+questionId).replaceWith(htmlTypeQuestion);  

                    var requiredValue = (response.data.required)?'Si':'No'; 
                    var htmlRequired = '<div class="probe-label probe-label-value question-required-'+questionId+'">'+requiredValue+'</div>'; 
                   $('.question-required-'+questionId).replaceWith(htmlRequired);     

                  $('.question-options-default-'+questionId).removeClass('hidden');
                  $('.question-options-edit-'+questionId).addClass('hidden');   
          

              }
          },
          error: function(xhr, error) {

          }
      });      

    })

    $(document).on('click', '.edit-probe-option ', function(e){

      var optionId = $(this).data('optionId'); 

         $.ajax({
          url: projectURL+'/sondeo/obtener-opcion/'+optionId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

              var htmlOption = '<input name="values['+optionId+'][name]" type="text" value="'+response.data.name+'" class="probe-input-option probe-input-option-edit form-control option-name-'+optionId+'">'
               $('.option-name-'+optionId).replaceWith(htmlOption);   

                    $('.options-default-'+optionId).addClass('hidden');
                    $('.options-edit-'+optionId).removeClass('hidden'); 
          

              }
          },
          error: function(xhr, error) {

          }
      });          

    })

    $(document).on('click', '.cancel-edit-option ', function(e){

      var optionId = $(this).data('optionId'); 

         $.ajax({
          url: projectURL+'/sondeo/obtener-opcion/'+optionId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

              var htmlOption = ' <label class="probe-label probe-label-value option-name-'+optionId+'">'+response.data.name+'</label>'
               $('.option-name-'+optionId).replaceWith(htmlOption);   

                    $('.options-default-'+optionId).removeClass('hidden');
                    $('.options-edit-'+optionId).addClass('hidden'); 
          

              }
          },
          error: function(xhr, error) {

          }
      });          

    })


    $(document).on('click', '.save-edit-option', function(e){

      var optionId = $(this).data('optionId'); 

      if($('input[name="values['+optionId+'][name]"]').val() != ''){

        var parameters = {
            'values[option_id]'       : optionId,
            'values[name]'            : $('input[name="values['+optionId+'][name]"]').val() 
        };


         $.ajax({
            url: projectURL+'/sondeo/guardar-opcion/',
            type:'POST',
            data: parameters,
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                   var htmlOption = '<label class="probe-label probe-label-value option-name-'+optionId+'">'+response.data.name+'</label>';
                  $('.option-name-'+optionId).replaceWith(htmlOption);     

                    $('.options-default-'+optionId).removeClass('hidden');
                    $('.options-edit-'+optionId).addClass('hidden'); 
            

                }
            },
            error: function(xhr, error) {

            }
          });     

      }else{
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $('input[name="values['+optionId+'][name]"]').addClass('error-probe-input');
        $('.error-alert-text').html('Debe especificar un valor para los campos indicados').parent().removeClass('hidden');
      }

    })
      

    // Delete question from DB
    $(document).on('click','.delete-saved-question-element',function(e){

       e.preventDefault(); 

        var questionId = $(this).data('questionId'); 

        var showAlert = swal({
          title: 'Eliminar Pregunta',
          text: 'Confirma que desea eliminar la pregunta del sondeo',
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
            url: projectURL+'/sondeo/eliminar-pregunta/'+questionId,
            type:'GET',
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                   $(document).find('.saved-question-'+questionId).fadeOut('slow', 
                      function() { 
                        $(this).remove()
                    });

                   $(document).find('.question-options-content-'+questionId).fadeOut('slow', 
                      function() { 
                        $(this).remove()
                    });                   

                }
            },
            error: function(xhr, error) {

            }
          });     

        });               

    });

    // Delete question option from DB
    $(document).on('click','.delete-saved-probe-option', function(e){

       e.preventDefault(); 

        var optionId = $(this).data('optionId'); 

        var showAlert = swal({
          title: 'Eliminar Pregunta',
          text: 'Confirma que desea eliminar la opción',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef6f66',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar',
          cancelButtonColor: '#ef6f66',
          closeOnConfirm: true
        },
        function(){

         $.ajax({
            url: projectURL+'/sondeo/eliminar-opcion/'+optionId,
            type:'GET',
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                   $(document).find('.saved-option-'+optionId).fadeOut('slow', 
                      function() { 
                        $(this).remove()
                    });

                }
            },
            error: function(xhr, error) {

            }
          });     

        });               
     
    });  

    $(document).on('click', '.btn-add-question-option-edit', function(e){

        var questionId = $(this).data('questionId'),
            htmlOptions = '';    

        optionCount++; 

          htmlOptions += '<div style="display:none" class="question-option option-'+questionId+'-'+optionCount+'">'+
              '<input name="probe['+questionId+']['+optionCount+'][name]" type="text" placeholder="Opción para la pregunta" class="probe-input-option form-control">'+
              '<div class="edit-option-quiestion-content options-edit-'+optionCount+'">'+
                  '<div data-question-id="'+questionId+'" data-option-id="'+optionCount+'"  class="save-new-option common-btn btn-mini txt-center btn-turquoise">Guardar</div>'+                               
                      '<div data-question-id="'+questionId+'" data-option-id="'+optionCount+'" class="delete-question-option common-btn btn-mini txt-center btn-pink">Cancelar</div>'+                            
                      '</div>'+                       
               '</div>';      

          $(htmlOptions).appendTo('.question-options-'+questionId).fadeIn('slow');

    });


    // save added question option
    $(document).on('click', '.save-new-option', function(e){

      var optionId = $(this).data('optionId'),
          questionId = $(this).data('questionId')


      if($('input[name="probe['+questionId+']['+optionId+'][name]"]').val() != ''){

        var parameters = {
            'values[question_id]'     : questionId,
            'values[name]'            : $('input[name="probe['+questionId+']['+optionId+'][name]"]').val()
        };


         $.ajax({
            url: projectURL+'/sondeo/guardar-nueva-opcion/',
            type:'POST',
            data: parameters,
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                  var dataId = response.data.id; 

                  var htmlOption = '<div class="anwswer-option-content saved-option-'+dataId+'">'+
                                        '<label class="probe-label txt-right">&nbsp;</label>'+
                                        '<label class="probe-label probe-label-value option-name-'+dataId+'">'+response.data.name+'</label>'+
                                        
                                        '<div class="edit-option-quiestion-content options-default-'+dataId+'">'+
                                         '<div data-option-id="'+dataId+'"class="edit-probe-option circle activity-option txt-center fs-big fc-yellow">'+
                                            '<i class="fa fa-pencil fa-fw"></i>'+
                                          '</div>'+ 
                                         '<div data-option-id="'+dataId+'" class="delete-saved-probe-option circle activity-option txt-center fs-big fc-pink">'+
                                            '<i class="fa fa-times fa-fw"></i>'+
                                          '</div>'+                                         
                                        '</div>'

                              '<div class="hidden edit-option-quiestion-content options-edit-'+dataId+'">'+
                                '<div data-option-id="'+dataId+'" class="save-edit-option common-btn btn-mini txt-center btn-turquoise">Guardar</div>'+                               
                                '<div data-option-id="'+dataId+'" class="cancel-edit-option common-btn btn-mini txt-center btn-pink">Cancelar</div>'+                            
                              '</div>'+                                        
                            '</div>';
                      
                    $('.option-'+questionId+'-'+optionId).replaceWith(htmlOption);     
            

                }
            },
            error: function(xhr, error) {

            }
          });     

      }else{
       $('input[name="probe['+questionId+']['+optionId+'][name]"]').addClass('error-probe-input');
        $('.error-alert-text').html('Debe especificar un valor para los campos indicados').parent().removeClass('hidden');
      }

    })


      // add question row to DOM on edit
      $(document).on('click','.add-new-question-row', function(e){

        e.preventDefault(); 

        var html = ''; 

        questionCount++; 

               html += '<form method="POST" accept-charset="UTF-8" action="'+projectURL+'/sondeo/guardar-nueva-pregunta/" id="form-new-question-'+questionCount+'">'+
                  '<div class="probe-question-content question-'+questionCount+'">'+
                  '<label class="probe-label txt-right">Pregunta:</label>'+
                  '<input type="text" name="probe[questions]['+questionCount+'][question]" placeholder="Especifique una pregunta para el sondeo" class="probe-input form-control">'+   
                  '<input type="hidden" name="probe[probe_id]" value="'+probeId+'" class="probe-input form-control">'+   

                  '<label class="probe-label txt-right">Tipo de pregunta:</label>'+
                  '<select name="probe[questions]['+questionCount+'][form_element]" class="probe-input-i form-control type-answer-option" data-question-id="'+questionCount+'">';
                  $.each(answerTypes, function(index, type) {
                      html += '<option value="'+index+'">'+type+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Pregunta obligatoria:</label>'+
                  '<input name="probe[questions]['+questionCount+'][required]" type="checkbox">'+

                    '<div class="hidden pull-right edit-btn-question-options question-options-default-x">'+        
                        '<div data-toggle="tooltip" data-placement="top" title="Eliminar" class="pull-right circle activity-option txt-center fs-big fc-pink delete-saved-question-element">'+
                          '<i class="fa fa-times fa-fw"></i>'+
                        '</div>'+  
                        '<div data-toggle="tooltip" data-placement="top" title="Editar" class="pull-right circle activity-option txt-center fs-big fc-yellow edit-question-element>'+
                          '<i class="fa fa-pencil fa-fw"></i>'+
                        '</div>'+  
                    '</div>'+

                    '<div class="pull-right edit-btn-question-options question-options-edit-x">'+                  
                      '<div data-question-id="'+questionCount+'" class="cancel-new-question common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>'+                           
                      '<div data-probe-id="'+probeId+'" data-question-id="'+questionCount+'"  class="save-new-question common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>'+          
                    '</div>'+                   
                '</div>'+

                '<div class=" hidden probe-options-question question-options-content-'+questionCount+'">'+  
                  '<div class="all-options-content question-options-'+questionCount+'">'+
                  '</div>'+ 
                  '</form>'+
                  '<div class="btn-add-question-option" data-question-id="'+questionCount+'">'+
                    '<div class="circle activity-option txt-center fs-big fc-turquoise">'+
                      '<i class="fa fa-plus fa-fw"></i>'+
                    '</div>'+                                          
                    '<span class="probe-label"> Agregar opci&oacute;n</span>'+   
                  '</div>'+
                '</div>';
                
                  
                 $(html).appendTo('.probe-questions-lists').fadeIn('slow');

   
    });

    $(document).on('click', '.save-new-question', function(e){

        var successValidation = 0,
            totalInputs = 0,
            questionId = $(this).data('questionId'); 

        //validate categories
        $('input[type="text"], textarea').each(function(){

          totalInputs++; 

          if($(this).val() == ''){
            $(this).addClass('error-probe-input');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $('.error-alert-text').html(' Debe especificar un valor para los campos de textos indicados').parent().removeClass('hidden'); 
          }else{
             $(this).removeClass('error-probe-input');
             $('.error-alert-text').parent().removeClass('hidden'); 
              successValidation++; 
          }
        });

        // success validation, all inputs are valid
        if(successValidation==2){
          $('html,body').animate({ scrollTop: 0 }, 'slow');
          $('.error-alert-text').html(' Debe especificar al menos una pregunta para el sondeo').parent().removeClass('hidden');
        }else if(successValidation==totalInputs){
          $('#form-new-question-'+questionId).submit(); 
          $('.error-alert-text').parent().removeClass('hidden'); 
        }  

    })

    $(document).on('click', '.cancel-new-question', function(e){

        e.preventDefault();

        var questionId = $(this).data('questionId');

          $(document).find('.question-'+questionId).fadeOut('slow', 
              function() { 
                $(this).remove()
          });

          $(document).find('.question-options-content-'+questionId).fadeOut('slow', 
              function() { 
                $(this).remove()
          });          

    });


    // share probe popover
    $('.share-probe-popover').popover({ 
        html : true, 
        placement: 'top',
        content: function() {
          return $('.social-icons-container').html();
        }
    });  


    $('.share-probe-popover').on('shown.bs.popover', function () {

      var probeTitle = $(this).data('probeTitle'),
          probeUrl = $(this).data('probeUrl'),
          popOverId = $(this).attr('aria-describedby');

      $('#'+popOverId).find('.popover-content').find('.share-option')
                      .attr('data-probe-title', probeTitle)
                      .attr('data-probe-url', probeUrl);    
  
    });     


  $(document).on('click','.share-probe-twitter', function(e){
      e.preventDefault();
   
      var probeTitle = $(this).data('probeTitle'),
          probeUrl = $(this).data('probeUrl'),
          longUrl = encodeURI(projectURL+'/sondeo/generar/'+probeUrl),
          bitLyUrl = '';  

          $.ajax({
            url:'http://api.bit.ly/v3/shorten',
            data:{longUrl:longUrl,apiKey:'R_35a2e8dc3c694cc1a2162681219676f0',login:'proagilwebapp'},
            dataType:'jsonp',
            success:function(response){

              if(response.status_text == 'OK'){

                bitLyUrl = response.data.url; 

              }else{

                bitLyUrl = longUrl; 

              }

              var urlToShare = 'http://twitter.com/share?url='+bitLyUrl,
              message = 'Les comparto este sondeo, me gustaría que lo respondieran';

              window.open(urlToShare + '&text=' + message, 'twitterwindow', 'scrollbars=yes,width=800,height=450,top='+(screen.height-450)/2+',left='+(screen.width-800)/2);

            },
            error: function(xhr, error) {

            }            
          });        
     
    });    


    $(document).on('click','.share-probe-facebook', function(e){
        e.preventDefault();
     
        var probeTitle = $(this).data('probeTitle'),
            probeUrl = $(this).data('probeUrl'),
            longUrl = encodeURI(projectURL+'/sondeo/generar/'+probeUrl),
            bitLyUrl = '';  

            $.ajax({
              url:'http://api.bit.ly/v3/shorten',
              data:{longUrl:longUrl,apiKey:'R_35a2e8dc3c694cc1a2162681219676f0',login:'proagilwebapp'},
              dataType:"jsonp",
              success:function(response){

                if(response.status_text == 'OK'){

                  bitLyUrl = response.data.url; 

                }else{

                  bitLyUrl = longUrl; 

                }

                var urlToShare = bitLyUrl,
                message = 'Les comparto este sondeo, me gustaría que lo respondieran';

                //message = message.replace(/\s/g,'+');
            
                FB.ui(
                {
                  method: 'feed',
                  href: 'http://proagil.dev:8000/',
                  description: message,
                  message: message,
                  caption: 'Sondeo', 
                  link: bitLyUrl,
                  picture: 'http://s11.postimg.org/duhv9zmv7/logo_sm.png'

                });


              },
              error: function(xhr, error) {

              }            
            });        
       
      });  

    $(document).on('click','.share-probe-linkedin', function(e){
        e.preventDefault();
     
        var probeTitle = $(this).data('probeTitle'),
            probeUrl = $(this).data('probeUrl'),
            longUrl = encodeURI(projectURL+'/sondeo/generar/'+probeUrl),
            bitLyUrl = '';  

            $.ajax({
              url:'http://api.bit.ly/v3/shorten',
              data:{longUrl:longUrl,apiKey:'R_35a2e8dc3c694cc1a2162681219676f0',login:'proagilwebapp'},
              dataType:"jsonp",
              success:function(response){

                if(response.status_text == 'OK'){

                  bitLyUrl = response.data.url; 

                }else{

                  bitLyUrl = longUrl; 

                }

                var urlToShare = bitLyUrl,
                message = 'Les comparto este sondeo, me gustaría que lo respondieran';

                message = message.replace(/\s/g,'+');
      
                var urlFacebook = 'http://www.linkedin.com/shareArticle?mini=true&url='+urlToShare+'&title='+message+'&summary='+message+'&source='+message; 
      
                window.open(urlFacebook, 'facebook-share-dialog', 'scrollbars=yes,width=800,height=450,top='+(screen.height-450)/2+',left='+(screen.width-800)/2);

              },
              error: function(xhr, error) {

              }            
            });        
       
      });  

 
   
});