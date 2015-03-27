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

      var observationCount = 0,
          optionCount = 0; 

      // add question row to DOM
      $(document).on('click','.add-esystem-row', function(e){

        e.preventDefault(); 

        var html = ''; 

        observationCount++; 

               html +=    '<div class="probe-question-content observation-'+observationCount+'" style="display:none;">'+

               '<label class="probe-label txt-right">Caracter&iacute;stica: </label>'+
                  '<select name="esystem[values]['+observationCount+'][topic]" class="probe-input-ii form-control type-answer-option" data-observation-id="'+observationCount+'">';
                  $.each(topics, function(index, topic) {
                      html += '<option value="'+index+'">'+topic+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Observaci&oacute;n:</label>'+
                  '<textarea type="text" name="esystem[values]['+observationCount+'][observation]" placeholder="Especifique una descripción para la característica seleccionada" class="probe-input esystem-textarea form-control"></textarea>'+   

                  '<div class="circle activity-option txt-center fs-big fc-pink pull-right delete-question-row" data-observation-id="'+observationCount+'">'+
                    '<i class="fa fa-times fa-fw"></i>'+
                  '</div>'+                  
                '</div>';

                 $(html).appendTo('.esystem-lists').fadeIn('slow');

   
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


    // Validate and Save existing system on CREATE
    $(document).on('click', '.save-esystem', function(e){

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
             $('.error-alert-text').parent().addClass('hidden'); 
              successValidation++; 
          }
        });

        // success validation, all inputs are valid
        if(successValidation==1){
          $('.error-alert-text').html(' Debe especificar al menos una pregunta para el sondeo').parent().removeClass('hidden');
        }else if(successValidation==totalInputs){
          $('#form-create-esystem').submit(); 
          $('.error-alert-text').parent().addClass('hidden'); 
        }  
    });  



     /*----------------------------------------------------------------------

          EDIT EXISTING SYSTEM FUNCTIONS

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
 
     $(document).on('click', '.save-edit-probe-info', function(e){

       var probeId = $(this).data('probeId'); 

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

                var htmlTitle = '<div class="question-title-'+probeId+' fc-turquoise">Titulo: <span class="fc-blue-i probe-label-value">'+response.data.title+'</span></div>';
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

    })       

    /*Al hacer clic en el editar de una caracteristica*/

    $(document).on('click', '.edit-element', function(e){

      var elementId = $(this).data('elementId'); 

      $('.element-options-default-'+elementId).addClass('hidden');
      $('.element-options-edit-'+elementId).removeClass('hidden');

       $.ajax({
          url: projectURL+'/analisis-sistemas-existente/obtener-caracteristica/'+elementId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                console.log(response); 

                var htmlSelectElement = '<select name="values['+elementId+'][topic]" class="probe-input-i form-control type-answer-option element-topic-'+elementId+'" data-element-id="'+elementId+'">';
                  $.each(topics, function(index, topic) {
                    if(index==response.data.existing_system_topic_id){
                        htmlSelectElement += '<option value="'+index+'" selected>'+topic+'</option>';
                    }else{
                        htmlSelectElement += '<option value="'+index+'">'+topic+'</option>';
                    }

                  });
                  htmlSelectElement += '</select>'      
                  $('.element-topic-'+elementId).replaceWith(htmlSelectElement);   


                var htmlTextareaElement = '<textarea type="text" name="values['+elementId+'][observation]" class="element-obs-'+elementId+' probe-input esystem-textarea form-control">'+response.data.observation+'</textarea>';    
                 $('.element-obs-'+elementId).replaceWith(htmlTextareaElement); 
          
              }
          },
          error: function(xhr, error) {

          }
      });      

    })

    /*Al hacer clic en el guardar de una pregunta editada*/
    $(document).on('click', '.save-edit-element', function(e){

      var elementId = $(this).data('elementId');

      if($('textarea[name="values['+elementId+'][observation]"]').val() != ''){

        $('textarea[name="values['+elementId+'][observation]"]').removeClass('error-probe-input');
        $('.error-alert-text').html('').parent().addClass('hidden');

        var parameters = {
            'values[element_id]'         : elementId,
            'values[observation]'        : $('textarea[name="values['+elementId+'][observation]"]').val(), 
            'values[topic_id]'           : $('select[name="values['+elementId+'][topic]"]').val(),

        };


         $.ajax({
            url: projectURL+'/analisis-sistemas-existente/guardar-elemento/',
            type:'POST',
            data: parameters,
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                   var htmlTopicData = '<div class="probe-label probe-label-value element-topic-'+elementId+'">'+response.data.topic_name+'</div>'; 
                   $('.element-topic-'+elementId).replaceWith(htmlTopicData);

                   var htmlObsData = '<div class="probe-label probe-label-value element-obs-'+elementId+'">'+response.data.observation+'</div>'; 
                   $('.element-obs-'+elementId).replaceWith(htmlObsData);

                  $('.element-options-default-'+elementId).removeClass('hidden');
                  $('.element-options-edit-'+elementId).addClass('hidden');
            

                }
            },
            error: function(xhr, error) {

            }
          });     

      }else{
       $('textarea[name="values['+elementId+'][observation]"]').addClass('error-probe-input');
       $('.error-alert-text').html('Debe especificar un valor para los campos indicados').parent().removeClass('hidden');
      }

    })

    $(document).on('click', '.cancel-edit-element', function(e){

      var elementId = $(this).data('elementId'); 

       $.ajax({
          url: projectURL+'/analisis-sistemas-existente/obtener-caracteristica/'+elementId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                   var htmlTopicData = '<div class="probe-label probe-label-value element-topic-'+elementId+'">'+response.data.topic_name+'</div>'; 
                   $('.element-topic-'+elementId).replaceWith(htmlTopicData);

                   var htmlObsData = '<div class="probe-label probe-label-value element-obs-'+elementId+'">'+response.data.observation+'</div>'; 
                   $('.element-obs-'+elementId).replaceWith(htmlObsData);

                  $('.element-options-default-'+elementId).removeClass('hidden');
                  $('.element-options-edit-'+elementId).addClass('hidden');
          

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
        alert('vaciooo'); 
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
          confirmButtonText: 'Si, eliminar',
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
 
   
});