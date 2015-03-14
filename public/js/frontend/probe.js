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
                  '<input name="probe[questions]['+questionCount+'][requerid]" type="checkbox">'+

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


    
});


