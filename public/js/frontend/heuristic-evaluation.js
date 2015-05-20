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

        ADD HEURISTIC EVALUATION FUNCTIONS

----------------------------------------------------------------------*/ 

      var observationCount = 0,
          optionCount = 0; 

      // add question row to DOM
      $(document).on('click','.add-element-row', function(e){

        e.preventDefault(); 

        var html = ''; 

        observationCount++; 

               html +='<div class="probe-question-content observation-'+observationCount+'" style="display:none;">'+

               '<label class="probe-label txt-right">Heur&iacute;stica: </label>'+
                  '<select name="evaluation[values]['+observationCount+'][heuristic]" class="probe-input-ii form-control type-answer-option" data-observation-id="'+observationCount+'">';
                  $.each(heuristics, function(index, heuristic) {
                      html += '<option value="'+index+'">'+heuristic+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Problema:</label>'+
                  '<textarea type="text" style="height:75px" name="evaluation[values]['+observationCount+'][problem]" placeholder="Especifique el problema de interfaz de usuario" class="probe-input evaluation-textarea form-control"></textarea>'+                

                  '<label class="probe-label txt-right">Valoraci&oacute;n: </label>'+
                  '<select name="evaluation[values]['+observationCount+'][valoration]" class="probe-input-ii form-control type-answer-option" data-observation-id="'+observationCount+'">';
                  $.each(valorations, function(index, valoration) {
                      html += '<option value="'+index+'">'+valoration+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Soluci&oacute;n:</label>'+
                  '<textarea type="text" style="height:75px" name="evaluation[values]['+observationCount+'][solution]" placeholder="Especifique la solución al problema propuesto" class="probe-input evaluation-textarea form-control"></textarea>'+   

                  '<div class="circle activity-option txt-center fs-big fc-pink pull-right delete-element-row" data-observation-id="'+observationCount+'">'+
                    '<i class="fa fa-times fa-fw"></i>'+
                  '</div>'+                  
                '</div>';

                 $(html).appendTo('.evaluation-list').fadeIn('slow');

   
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
    $(document).on('click', '.save-evaluation', function(e){

        var successValidation = 0,
            totalInputs = 0;

        //validate categories
        $('input[type="text"], textarea').each(function(){

          totalInputs++; 

          if($(this).val() == ''){
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $(this).addClass('error-probe-input');
            $('.error-alert-text').html(' Debe especificar un valor para los campos de texto indicados').parent().removeClass('hidden'); 
          }else{
             $(this).removeClass('error-probe-input');
             $('.error-alert-text').parent().addClass('hidden'); 
              successValidation++; 
          }
        });

        // success validation, all inputs are valid
        if(successValidation==1){
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          $('.error-alert-text').html(' Debe especificar al menos un problema para la evaluaci&oacute;n heur&iacute;stica').parent().removeClass('hidden');
        }else if(successValidation==totalInputs){
          $('#form-create-esystem').submit(); 
          $('.error-alert-text').parent().addClass('hidden'); 
        }  
    });  



     /*----------------------------------------------------------------------

          EDIT HEURISTIC EVALUATION FUNCTIONS

      ----------------------------------------------------------------------*/

     $(document).on('click', '.edit-element-info', function(e){

       var evaluationId = $(this).data('evaluationId'),
           projectId = $(this).data('projectId'),
           html = ''; 

       $.ajax({
          url: projectURL+'/evaluacion-heuristica/editar-informacion/'+evaluationId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                html += '<input type="text" name="evaluation[name]" value="'+response.data.name+'" class="evaluation-info-content evaluation-title probe-input-name probe-input form-control">'; 

               $('.evaluation-info-content').replaceWith(html); 

                $('.edit-element-info-save').removeClass('hidden');
                $('.edit-element-info-default').addClass('hidden');              

              }
          },
          error: function(xhr, error) {

          }
      });      

    })


     $(document).on('click', '.cancel-edit-element-info', function(e){

       var evaluationId = $(this).data('evaluationId'),
           projectId = $(this).data('projectId'),
           html = ''; 

       $.ajax({
          url: projectURL+'/evaluacion-heuristica/editar-informacion/'+evaluationId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                html += '<div class="probe-info-edit-content evaluation-info-content">'+
                          '<div class="element-name-'+evaluationId+' fc-turquoise">Nombre: <span class="fc-blue-i probe-label-value">'+response.data.name+'</span>'+
                          '</div>'+
                '</div>'; 


               $('.evaluation-info-content').replaceWith(html); 

                $('.edit-element-info-save').addClass('hidden');
                $('.edit-element-info-default').removeClass('hidden');              

              }
          },
          error: function(xhr, error) {

          }
      });      

    })
 
     $(document).on('click', '.save-edit-element-info', function(e){

       var evaluationId = $(this).data('evaluationId'); 

       if($('input[name="evaluation[name]"]').val()!=''){

          $('input[name="evaluation[name]"]').removeClass('error-probe-input');
          $('.error-alert-text').html(' Debe especificar un valor para los campos de texto indicados').parent().addClass('hidden');        

            var parameters = {
                'values[evaluation_id]'    : evaluationId,
                'values[name]'             : $('input[name="evaluation[name]"]').val()
            };


           $.ajax({
              url: projectURL+'/evaluacion-heuristica/guardar-informacion/',
              type:'POST',
              dataType: 'JSON',
              data: parameters,
              success:function (response) {

                  if(!response.error){

                      var html = '<div class="probe-info-edit-content evaluation-info-content">'+
                                    '<div class="element-name-'+evaluationId+' fc-turquoise">Nombre: <span class="fc-blue-i probe-label-value">'+response.data.name+'</span>'+
                                    '</div>'+
                                  '</div>'; 

                      $('.evaluation-info-content').replaceWith(html);            

                      $('.edit-element-info-save').addClass('hidden');
                      $('.edit-element-info-default').removeClass('hidden');


                  }
              },
              error: function(xhr, error) {

              }
          });   

      }else{

        $('input[name="evaluation[name]"]').addClass('error-probe-input');
        $('.error-alert-text').html(' Debe especificar un valor para los campos de texto indicados').parent().removeClass('hidden'); 

      }   


    })       

    /*Al hacer clic en el editar de una caracteristica*/

    $(document).on('click', '.edit-element', function(e){

      var elementId = $(this).data('elementId'); 

      $('.element-options-default-'+elementId).addClass('hidden');
      $('.element-options-edit-'+elementId).removeClass('hidden');

       $.ajax({
          url: projectURL+'/evaluacion-heuristica/obtener-problema/'+elementId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

            console.log(response); 

              if(!response.error){

                    var htmlHeuristicsSelect = '<select name="values['+elementId+'][heuristic]" class="probe-input-ii form-control type-answer-option element-heuristic-'+elementId+'">';
                    $.each(heuristics, function(index, heuristic) {
                        htmlHeuristicsSelect += '<option value="'+index+'">'+heuristic+'</option>';
                        if(index==response.data.heuristic_id){
                            htmlHeuristicsSelect += '<option value="'+index+'" selected>'+heuristic+'</option>';
                        }else{
                            htmlHeuristicsSelect += '<option value="'+index+'">'+heuristic+'</option>';
                        }
                    });
                    htmlHeuristicsSelect += '</select>';

                    $('.element-heuristic-'+elementId).replaceWith(htmlHeuristicsSelect); 

                    var htmlTextareaProblem = '<textarea type="text" style="height:75px" name="values['+elementId+'][problem]" placeholder="Especifique el problema de interfaz de usuario" class="probe-input evaluation-textarea form-control element-problem-'+elementId+'">'+response.data.problem+'</textarea>';                
                    $('.element-problem-'+elementId).replaceWith(htmlTextareaProblem); 
                    
                    var htmlSelectValoration = '<select name="values['+elementId+'][valoration]" class="probe-input-ii form-control type-answer-option element-valoration-'+elementId+'">';
                    $.each(valorations, function(index, valoration) {
                        if(index==response.data.valoration_value){
                            htmlSelectValoration += '<option value="'+index+'" selected>'+valoration+'</option>';
                        }else{
                            htmlSelectValoration += '<option value="'+index+'">'+valoration+'</option>';
                        }
                    });
                    htmlSelectValoration += '</select>';
                    $('.element-valoration-'+elementId).replaceWith(htmlSelectValoration); 

                    var htmlTextareaSolution = '<textarea type="text" style="height:75px" name="values['+elementId+'][solution]" placeholder="Especifique la solución al problema propuesto" class="probe-input evaluation-textarea form-control element-solution-'+elementId+'">'+response.data.solution+'</textarea>';   
                    $('.element-solution-'+elementId).replaceWith(htmlTextareaSolution); 
          
              }
          },
          error: function(xhr, error) {

          }
      });      

    })

    $(document).on('click', '.save-edit-element', function(e){

      var elementId = $(this).data('elementId');

      if($('textarea[name="values['+elementId+'][solution]"]').val() != '' && 
        $('textarea[name="values['+elementId+'][problem]"]').val() != ''){

        $('textarea[name="values['+elementId+'][solution]"]').removeClass('error-probe-input');
        $('textarea[name="values['+elementId+'][problem]"]').removeClass('error-probe-input');
        $('.error-alert-text').html('').parent().addClass('hidden');

        var parameters = {
            'values[element_id]'          : elementId,
            'values[problem]'             : $('textarea[name="values['+elementId+'][problem]"]').val(), 
            'values[solution]'            : $('textarea[name="values['+elementId+'][solution]"]').val(), 
            'values[valoration_id]'       : $('select[name="values['+elementId+'][valoration]"]').val(),
            'values[heuristic_id]'        : $('select[name="values['+elementId+'][heuristic]"]').val(),

        };


         $.ajax({
            url: projectURL+'/evaluacion-heuristica/guardar-elemento/',
            type:'POST',
            data: parameters,
            dataType: 'JSON',
            success:function (response) {

                if(!response.error){

                  var htmlHeuristic = '<div class="probe-label evaluation-label-value element-heuristic-'+elementId+'">'+response.data.heuristic_name+'</div>'; 
                  $('.element-heuristic-'+elementId).replaceWith(htmlHeuristic); 
                  
                  var htmlValoration = '<div class="probe-label evaluation-label-value element-valoration-'+elementId+'">'+response.data.valoration_name+'</div>';                 
                  $('.element-valoration-'+elementId).replaceWith(htmlValoration); 

                  var htmlSolution = '<div class="probe-label evaluation-label-value element-solution-'+elementId+'">'+response.data.solution+'</div>'; 
                  $('.element-solution-'+elementId).replaceWith(htmlSolution); 

                  var htmlProblem = '<div class="probe-label evaluation-label-value element-problem-'+elementId+'">'+response.data.problem+'</div>'; 
                  $('.element-problem-'+elementId).replaceWith(htmlProblem); 

                  $('.element-options-default-'+elementId).removeClass('hidden');
                  $('.element-options-edit-'+elementId).addClass('hidden');
            
                }
            },
            error: function(xhr, error) {

            }
          });     

      }else{

        if($('textarea[name="values['+elementId+'][solution]"]').val()==''){

            $('textarea[name="values['+elementId+'][solution]"]').addClass('error-probe-input');
            $('.error-alert-text').html('Debe especificar un valor para los campos indicados').parent().removeClass('hidden');

        }else if($('textarea[name="values['+elementId+'][problem]"]').val()==''){

            $('textarea[name="values['+elementId+'][problem]"]').addClass('error-probe-input');
            $('.error-alert-text').html('Debe especificar un valor para los campos indicados').parent().removeClass('hidden');

        }

         $('html, body').animate({ scrollTop: 0 }, 'slow');

      }

    })

    $(document).on('click', '.cancel-edit-element', function(e){

      var elementId = $(this).data('elementId'); 

       $.ajax({
          url: projectURL+'/evaluacion-heuristica/obtener-problema/'+elementId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                  var htmlHeuristic = '<div class="probe-label evaluation-label-value element-heuristic-'+elementId+'">'+response.data.heuristic_name+'</div>'; 
                  $('.element-heuristic-'+elementId).replaceWith(htmlHeuristic); 
                  
                  var htmlValoration = '<div class="probe-label evaluation-label-value element-valoration-'+elementId+'">'+response.data.valoration_name+'</div>';                 
                  $('.element-valoration-'+elementId).replaceWith(htmlValoration); 

                  var htmlSolution = '<div class="probe-label evaluation-label-value element-solution-'+elementId+'">'+response.data.solution+'</div>'; 
                  $('.element-solution-'+elementId).replaceWith(htmlSolution); 

                  var htmlProblem = '<div class="probe-label evaluation-label-value element-problem-'+elementId+'">'+response.data.problem+'</div>'; 
                  $('.element-problem-'+elementId).replaceWith(htmlProblem); 

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
            evaluationId =  $(this).data('evaluationId');


        observationCount++; 

               html +='<div class="probe-question-content observation-'+observationCount+'" style="display:none;">'+
              '<form method="POST" action="'+projectURL+'/evaluacion-heuristica/guardar-nuevo-problema/" accept-charset="UTF-8" id="form-new-element-'+observationCount+'">'+  
                  '<input type="hidden" name="evaluation[project_id]" value="'+projectId+'">'+
                  '<input type="hidden" name="evaluation[evaluation_id]" value="'+evaluationId+'">'+
               '<label class="probe-label txt-right">Heur&iacute;stica: </label>'+
                  '<select name="evaluation[heuristic]" class="probe-input-ii form-control type-answer-option" data-observation-id="'+observationCount+'">';
                  $.each(heuristics, function(index, heuristic) {
                      html += '<option value="'+index+'">'+heuristic+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Problema:</label>'+
                  '<textarea type="text" style="height:75px" name="evaluation[problem]" placeholder="Especifique el problema de interfaz de usuario" class="probe-input evaluation-textarea form-control"></textarea>'+                

                  '<label class="probe-label txt-right">Valoraci&oacute;n: </label>'+
                  '<select name="evaluation[valoration]" class="probe-input-ii form-control type-answer-option" data-observation-id="'+observationCount+'">';
                  $.each(valorations, function(index, valoration) {
                      html += '<option value="'+index+'">'+valoration+'</option>';

                  });
                  html += '</select>'+

                  '<label class="probe-label txt-right">Soluci&oacute;n:</label>'+
                  '<textarea type="text" style="height:75px" name="evaluation[solution]" placeholder="Especifique la solución al problema propuesto" class="probe-input evaluation-textarea form-control"></textarea>'+   

                  '<div class="pull-right edit-btn-esystem-options element-options-edit-'+observationCount+'">'+                  
                    '<div data-observation-id="'+observationCount+'" class="delete-element-row common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>'+                           
                    '<div data-element-id="'+observationCount+'" class="save-edit-new-element common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>'+          
                  '</div>'+                   
                '</div>'+
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
            $('.error-alert-text').html(' Debe especificar un valor para los campos de texto indicados').parent().removeClass('hidden'); 
          }else{
             $(this).removeClass('error-probe-input');
             $('.error-alert-text').parent().addClass('hidden'); 
              successValidation++; 
          }
        });

        console.log('successValidation '+successValidation+' '+'totalInputs '+totalInputs); 

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
          title: 'Eliminar Problema',
          text: 'Confirma que desea eliminar el problema de la evaluación heurística',
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
            url: projectURL+'/evaluacion-heuristica/eliminar-problema/'+elementId,
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