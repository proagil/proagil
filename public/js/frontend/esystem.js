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

      var observationCount = 0,
          optionCount = 0; 

      // add question row to DOM
      $(document).on('click','.add-esystem-row', function(e){

        e.preventDefault(); 

        var html = ''; 

        observationCount++; 

               html +='<div class="probe-question-content observation-'+observationCount+'" style="display:none;">'+

               '<label class="probe-label txt-right">Caracter&iacute;stica: </label>'+
                  '<select name="esystem[values]['+observationCount+'][topic]" class="probe-input-ii form-control type-answer-option" data-observation-id="'+observationCount+'">';
                  $.each(topics, function(index, topic) {
                      html += '<option value="'+index+'">'+topic+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Observaci&oacute;n:</label>'+
                  '<textarea type="text" style="height:150px" name="esystem[values]['+observationCount+'][observation]" placeholder="Especifique una descripción para la característica seleccionada" class="probe-input esystem-textarea form-control"></textarea>'+   

                  '<div class="circle activity-option txt-center fs-big fc-pink pull-right delete-element-row" data-observation-id="'+observationCount+'">'+
                    '<i class="fa fa-times fa-fw"></i>'+
                  '</div>'+                  
                '</div>';

                 $(html).appendTo('.esystem-lists').fadeIn('slow');

   
    });

    // delete element row from DOM
    $(document).on('click', '.delete-element-row', function(e){

        e.preventDefault();

        var observationId = $(this).data('observationId');

          $(document).find('.observation-'+observationId).fadeOut('slow', 
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
            $('html, body').animate({ scrollTop: 0 }, 'slow');
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
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          $('.error-alert-text').html(' Debe especificar al menos una pregunta para el sondeo').parent().removeClass('hidden');
        }else if(successValidation==totalInputs){
          $('#form-create-esystem').submit(); 
          $('.error-alert-text').parent().addClass('hidden'); 
        }  
    });  



     /*----------------------------------------------------------------------

          EDIT EXISTING SYSTEM FUNCTIONS

      ----------------------------------------------------------------------*/

     $(document).on('click', '.edit-element-info', function(e){

       var systemId = $(this).data('systemId'),
           projectId = $(this).data('projectId'),
           html = ''; 

       $.ajax({
          url: projectURL+'/analisis-sistemas-existente/editar-informacion/'+systemId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                var interfaceValue = (response.data.interface!=null)?response.data.interface:''; 
                html += '<div class="probe-info-edit-content system-info-content">'+
                '<form method="POST" action="'+projectURL+'/analisis-sistemas-existente/guardar-informacion/'+systemId+'" accept-charset="UTF-8" id="form-save-esystem-info" enctype="multipart/form-data">'+

                  '<label class="probe-label txt-right">Nombre:</label>'+
                  '<input type="hidden" name="esystem[project_id]" value="'+projectId+'">'+ 
                   '<input type="hidden" name="esystem[iterface_id]" value="'+interfaceValue+'">'+ 
                  '<input type="text" name="esystem[name]" value="'+response.data.name+'" class="probe-input-name probe-input form-control">'+  

                  '<label class="probe-label txt-right">Interfaz:</label>'+

                  '<input id="interface" class="file-upload file-upload-e-system" title="Subir imagen" data-filename-placement="inside" name="interface" type="file">'+                             

               '</form>'+
               '</div>'; 

               $('.system-info-content').replaceWith(html); 

               $(document).find('.file-upload-e-system').bootstrapFileInput();  


                $('.edit-element-info-save').removeClass('hidden');
                $('.edit-element-info-default').addClass('hidden');              

              }
          },
          error: function(xhr, error) {

          }
      });      

    })


     $(document).on('click', '.cancel-edit-element-info', function(e){

       var systemId = $(this).data('systemId'),
           projectId = $(this).data('projectId'),
           html = ''; 

       $.ajax({
          url: projectURL+'/analisis-sistemas-existente/editar-informacion/'+systemId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                html += '<div class="probe-info-edit-content system-info-content">'+
                  '<div class="element-name-'+response.data.id+' fc-turquoise">Nombre: <span class="fc-blue-i probe-label-value">'+response.data.name+'</span>'+
                  '</div>';  

                  if(response.data.interface_image!=null){
                  html +=  '<div class="txt-center interface-preview">'+
                    '<img style="width:35%" src="'+projectURL+'/uploads/'+response.data.interface_image+'"/>'+
                  '</div>'; 
                  }
                html += '</div>'; 

               $('.system-info-content').replaceWith(html); 

                $('.edit-element-info-save').addClass('hidden');
                $('.edit-element-info-default').removeClass('hidden');              

              }
          },
          error: function(xhr, error) {

          }
      });      

    })
 
     $(document).on('click', '.save-edit-element-info', function(e){

        $('#form-save-esystem-info').submit();

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


                var htmlTextareaElement = '<textarea style="height:150px" type="text" name="values['+elementId+'][observation]" class="element-obs-'+elementId+' probe-input esystem-textarea form-control">'+response.data.observation+'</textarea>';    
                 $('.element-obs-'+elementId).replaceWith(htmlTextareaElement); 
          
              }
          },
          error: function(xhr, error) {

          }
      });      

    })

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

                   var htmlObsData = '<div class="probe-label esystem-label-value element-obs-'+elementId+'">'+response.data.observation+'</div>'; 
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

                   var htmlObsData = '<div class="probe-label esystem-label-value element-obs-'+elementId+'">'+response.data.observation+'</div>'; 
                   $('.element-obs-'+elementId).replaceWith(htmlObsData);

                  $('.element-options-default-'+elementId).removeClass('hidden');
                  $('.element-options-edit-'+elementId).addClass('hidden');
          

              }
          },
          error: function(xhr, error) {

          }
      });      

    })

    $(document).on('click','.add-new-element-row', function(e){

        e.preventDefault(); 

        var html = '',
            projectId =  $(this).data('projectId'),
            systemId =  $(this).data('systemId');


        observationCount++; 

               html +='<div class="probe-question-content observation-'+observationCount+'" style="display:none;">'+
              '<form method="POST" accept-charset="UTF-8" action="'+projectURL+'/analisis-sistemas-existente/guardar-nueva-observacion/" id="form-new-element-'+observationCount+'">'+
               '<label class="probe-label txt-right">Caracter&iacute;stica: </label>'+
                  '<select name="esystem[topic]" class="probe-input-i form-control type-answer-option" data-observation-id="'+observationCount+'">';
                  $.each(topics, function(index, topic) {
                      html += '<option value="'+index+'">'+topic+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Observaci&oacute;n:</label>'+
                  '<textarea type="text" style="height:150px" name="esystem[observation]" placeholder="Especifique una descripción para la característica seleccionada" class="probe-input esystem-textarea form-control"></textarea>'+   

                  '<div class="pull-right edit-btn-esystem-options element-options-edit-'+observationCount+'">'+                  
                    '<div data-element-id="'+observationCount+'" class="cancel-edit-new-element common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>'+                           
                    '<div data-element-id="'+observationCount+'" class="save-edit-new-element common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>'+          
                   '<input type="hidden" name="esystem[project_id]" value="'+projectId+'">'+
                    '<input type="hidden" name="esystem[system_id]" value="'+systemId+'">'+
                  '</form>'+
                  '</div>';  

                 $(html).appendTo('.elements-list').fadeIn('slow');

    });

    $(document).on('click', '.save-edit-new-element', function(e){

        var successValidation = 0,
            totalInputs = 0,
            elementId = $(this).data('elementId'); 

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
      if(successValidation==totalInputs){
          $('#form-new-element-'+elementId).submit(); 
          $('.error-alert-text').parent().removeClass('hidden'); 
        }  

    })

    // Delete question from DB
    $(document).on('click','.delete-saved-element',function(e){

       e.preventDefault(); 

        var elementId = $(this).data('elementId'); 

        var showAlert = swal({
          title: 'Eliminar Observación',
          text: 'Confirma que desea eliminar la observación del sistema existente',
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
            url: projectURL+'/analisis-sistemas-existente/eliminar-observacion/'+elementId,
            type:'GET',
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                   $(document).find('.saved-element-'+elementId).fadeOut('slow', 
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
   
});