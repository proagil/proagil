/*======================================================================
PROAGIL WEB APP - 2015
Authors: AD, SJ, MM
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

                  '<div class="circle activity-option txt-center fs-big fc-turquoise pull-right delete-question-row" data-question-id="'+questionCount+'">'+
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

        // on change answer type
    $(document).on('click', '.btn-add-question-option', function(e){

        var questionId = $(this).data('questionId'),
            htmlOptions = '';    

        optionCount++; 

          htmlOptions += '<div class="question-option option-'+questionId+'-'+optionCount+'">'+
              '<input name="probe[questions]['+questionId+'][option]['+optionCount+'][name]" type="text" placeholder="Opción para la pregunta" class="probe-input-option form-control">'+
                '<div class="circle activity-option txt-center fs-big fc-turquoise delete-question-option" data-option-id="'+optionCount+'" data-question-id="'+questionId+'">'+
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
            $(this).addClass('error-probe-input');
            $('.error-alert-text').html(' Debe especificar un valor para los campos de textos indicados').parent().removeClass('hidden'); 
          }else{
             $(this).removeClass('error-probe-input');
             $('.error-alert-text').parent().removeClass('hidden'); 
              successValidation++; 
          }
        });

        console.log('successValidation:'+ successValidation+' totalInputs '+totalInputs);

        // success validation, all inputs are valid
        if(successValidation==2){
          $('.error-alert-text').html(' Debe especificar al menos una pregunta para el sondeo').parent().removeClass('hidden');
        }else if(successValidation==totalInputs){
          $('#form-create-probe').submit(); 
          $('.error-alert-text').parent().removeClass('hidden'); 
        }  
    });  



     /*----------------------------------------------------------------------

          EDIT PROBE FUNCTIONS

      ----------------------------------------------------------------------*/

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

    $(document).on('click', '.save-edit-option', function(e){

      var optionId = $(this).data('optionId'); 

      if($('input[name="values['+optionId+'][name]"]').val() != ''){

        var parameters = {
            'values[option_id]'       : optionId,
            'values[name]'            : $('input[name="values['+optionId+'][name]"]').val(), 
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
        alert('vaciooo'); 
      }

    })    


 
   
});


