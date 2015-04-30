/*======================================================================
PROAGIL WEB APP - 2015
Authors: AD, SJ
======================================================================*/

/*----------------------------------------------------------------------

        CONSTANST SECTION

----------------------------------------------------------------------*/

    var UNDONE_ACTIVITY = 1,
        DOING_ACTIVITY = 2,
        DONE_ACTIVITY = 3;

$(function() {

/*----------------------------------------------------------------------

        GENERIC FUNCTIONS

----------------------------------------------------------------------*/    

    //GENERIC: generate popover
    $('[data-toggle="popover"]').popover();

    //
    $(document).find('[data-toggle="tooltip"]').tooltip(); 

    //GENERIC: remove all active classes on load
    var active = $('.active'),
        cIn = $('.in');

    // GENERIC: generate fileupload div
    $('.file-upload').bootstrapFileInput();  

    // GENERIC: remove all active classes
    $(document).find(active).removeClass('active'); 
    $(document).find(cIn).removeClass('in'); 

    // GENERIC: go back function
    $('.btn-back').on('click', function(e){

      e.preventDefault(); 

      window.history.back(); 
    })

   $('#form-login input').keydown(function(e) {
      if (e.keyCode == 13) {
          $('#form-login').submit();
      }
  });  

  $('.btn-project-description').on('click', function(){

    $('#project-info-modal').modal();

  }) 

/*----------------------------------------------------------------------

        LOGIN FUNCTIONS

----------------------------------------------------------------------*/        

    //LOGIN: submit form
    $('.btn-login').on('click', function(){
        
        $('#form-login').submit();

        return false;

    });

/*----------------------------------------------------------------------

        FORGOT PASSWORD FUNCTIONS

----------------------------------------------------------------------*/       

    // FORGOT PASSWORD: submit form
    $('.btn-forgot-password').on('click', function(){

        $('#form-forgot-password').submit();

        return false;

    });

    // CHANGE PASSWORD: submit form
    $('.btn-change-password').on('click', function(){

        $('#form-change-password').submit();

        return false;

    });  

/*----------------------------------------------------------------------

        REGISTER FUNCTIONS

----------------------------------------------------------------------*/        

    //REGISTER: submit form
    $('.btn-register').on('click', function(){

        $('#form-register').submit();

        return false;

    });    

    // EDIT PROFILE
    $('.btn-edit-user-profile').on('click', function(){

        $('#form-edit-user-profile').submit();

        return false;

    });  

    // EDIT PROJECT
    $('.btn-edit-project').on('click', function(){

        $('#form-edit-project').submit();

        return false;

    }); 

/*----------------------------------------------------------------------

        DASHBOARD FUNCTIONS

----------------------------------------------------------------------*/                 
  
    // DASHBOARD: show/hide section (artefacts or activities)
    $('.section-arrow').on('click', function(){

        var section = $(this).data('section'); 
        
        if($('#'+section).hasClass('showed')){
            
            $(this).find('i').removeClass('fa-caret-down');
            $(this).find('i').addClass('fa-caret-right');
        
            $('#'+section).removeClass('showed');
            $('#'+section).fadeOut('slow');

        }else{
        
            $(this).find('i').removeClass('fa-caret-right');
            $(this).find('i').addClass('fa-caret-down');

            //$('#'+section).removeClass('hidden');
            $('#'+section).addClass('showed');
            $('#'+section).fadeIn('slow');
            
            
        }
        
    });

/*----------------------------------------------------------------------

         CREATE PROJECT FUNCTIONS

----------------------------------------------------------------------*/

  $(document).on('click','.btn-artefact-description', function(e){

    $('.loader').show(); 

    var artefactId = $(this).data('artefactId');

       $.ajax({
          url: projectURL+'/artefacto/obtener-informacion/'+artefactId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                    $('#artefact-description-modal').modal();

                    $('.artefact-name-i').html(response.data.name);
                    $('.artefact-description').html(response.data.description);


                    $('.loader').hide();  

              }
          },
          error: function(xhr, error) {

          }
      });      
  })

  var colaboratorCount = 0,
      iterationsCount = 0;  

  $(document).on('click','.btn-add-iteration', function(e){

    e.preventDefault();

    iterationsCount++;
    

        var iterationHtml = '<div style="display:none" class="iteration-inputs iteration-'+iterationsCount+'">'+
                '<div data-toggle="tooltip" data-placement="top" title="Eliminar" class="pull-right circle activity-option txt-center fs-big fc-pink btn-delete-new-iteration" data-iteration-id="'+iterationsCount+'">'+
                  '<i class="fa fa-times fa-fw"></i>'+
                '</div>'+                                
                '<div class="form-group">'+
                  '<label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">N&uacute;mero de iteraci&oacute;n</label>'+  
                  '<div class="col-md-4">'+
                    '<input placeholder="Ej,: 1" style="width: 80px;" class="iteration-number form-control app-input app-input-ii" name="values[iteration]['+iterationsCount+'][order]" type="number">'+                           
                  '</div>'+
                '</div>'+                               
                '<div class="form-group">'+
                  '<label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Nombre de iteraci&oacute;n</label>'+  
                  '<div class="col-md-4">'+
                    '<input placeholder="Ej.: Pruebas" class="form-control app-input app-input-ii" name="values[iteration]['+iterationsCount+'][name]" type="text" value="">'+                           
                  '</div>'+
                '</div>'+                           
                '<div class="form-group">'+
                  '<label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Artefactos a utilizar</label>'+  
                  '<div class="col-md-4">';
                    if(artefacts.length>0){
                          $.each(artefacts, function(index, artefact) {
                            iterationHtml += '<input name="values[iteration]['+iterationsCount+'][artefacts][]" type="checkbox" value="'+artefact.id+'">'+
                                              '<label>' +artefact.name +'</label>'+ 
                                              '<i style="cursor:pointer;" data-artefact-id="'+artefact.id+'" class="btn-artefact-description fc-turquoise fa fa-info-circle fa-fw"></i>'+
                                              '<br>';
                          });                           

                    }                            
                  iterationHtml += '</div>'+
                '</div>'+ 
                '<div class="form-group">'+
                  '<label class="col-md-4 subtitle-label fc-grey-iv control-label " for="textinput">Fecha inicio</label>'+  
                  '<div class="col-md-4">'+
                    '<input data-input-type="date" class="form-control app-input app-input-ii input-date" name="values[iteration]['+iterationsCount+'][init_date]" type="text" value="">'+                           
                  '</div>'+
                '</div>'+ 
                '<div class="form-group">'+
                  '<label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Fecha fin</label>'+  
                  '<div class="col-md-4">'+
                    '<input data-input-type="date" class="form-control app-input app-input-ii input-date" name="values[iteration]['+iterationsCount+'][end_date]" type="text" value="">'+                           
                  '</div>'+
                '</div>'+ 

                '<div class="colaborators-content colaborators-content-'+iterationsCount+'">'+
                '</div>'+ 
                                           
                '<div class="form-group">'+
                  '<label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">&nbsp;</labeL>'+
                  '<div class="col-md-4">'+
                    '<div class="btn-add-colaborator" data-iteration-id="'+iterationsCount+'" style="cursor:pointer;">'+
                      '<div class="circle activity-option txt-center fs-big fc-turquoise">'+
                        '<i class="fa fa-plus fa-fw"></i>'+
                      '</div>'+
                    '</div>'+
                    '<span class="fs-min">Invitar a colaboradores a trabajar en esta iteraci&oacute;n</span>'+
                  '</div>'+
                '</div>'+                               
              '</div>';

              $('html, body').animate({scrollTop:$(document).height()}, 'slow');

            $(iterationHtml).appendTo('.iterations-content').fadeIn('slow');
  });


  $(document).on('click','.btn-add-colaborator', function(e){

    colaboratorCount++;

    var iterationId = $(this).data('iterationId'); 

    var htmlColaborators = '<div style="display:none" class="each-colaborator new-colaborator-'+colaboratorCount+'">'+
                            '<div class="form-group">'+
                              '<label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Colaborador</label>'+  
                              '<div class="col-md-4">'+
                                '<input data-input-type="email" name="values[iteration]['+iterationId+'][colaborator]['+colaboratorCount+'][email]" placeholder="Correo electr&oacute;nico" class="form-control app-input app-input-ii"  type="text" value="">'+
                                '<select class="form-control app-input-ii" name="values[iteration]['+iterationId+'][colaborator]['+colaboratorCount+'][role]">';
                                    $.each(userRoles, function(index, role) {
                                        htmlColaborators += '<option value="'+index+'" selected>'+role+'</option>';
                                    });                                

                                htmlColaborators += '</select>'+
                                '<div data-colaborator-id="'+colaboratorCount+'" class="btn-delete-colaborator circle activity-option txt-center fs-big fc-pink">'+
                                  '<i class="fa fa-times fa-fw"></i>'+
                                '</div>'+                                                              
                              '</div>'+                                
                            '</div>'+                                    
                          '</div>';

                          $(htmlColaborators).appendTo('.colaborators-content-'+iterationId).fadeIn('slow');
  });


    $(document).on('click', '.btn-delete-new-iteration', function(e){

        e.preventDefault();

        var iterationId = $(this).data('iterationId');

          $(document).find('.iteration-'+iterationId).fadeOut('slow', 
              function() { 
                $(this).remove()
          });
     
    });


    $(document).on('click', '.btn-delete-colaborator', function(e){

        e.preventDefault();

        var colaboratorId = $(this).data('colaboratorId');

          $(document).find('.new-colaborator-'+colaboratorId).fadeOut('slow', 
              function() { 
                $(this).remove()
          });
     

    });

    $('body').on('focus','.input-date', function(){
          $(this).datepicker({
            format: 'dd-mm-yyyy',
            language: 'es',
            startDate: '0d'   
          });
    });

    $('body').on('focus','.iteration-number', function(){
          $(this).numeric(); 
    });    


   


/*----------------------------------------------------------------------

        PROJECT DETAIL FUNCTIONS

----------------------------------------------------------------------*/        

    // PROJECT DETAIL: show activity description
    $('.btn-activity-description').on('click', function(e){

        var activityId = $(this).data('activityId');

        if($(this).hasClass('close-activity')){           

            // mark current circle as open
            $(this).removeClass('close-activity').addClass('open-activity');

            // change icon arrow
            //$(this).find('i').removeClass('fa-caret-down').addClass('fa-caret-right');

            // show description content
            $('#description-'+activityId).slideToggle('5000'); 
                

        }else{

            //mark current circle as close
            $(this).removeClass('open-activity').addClass('close-activity');

            // change icon arrow
            //$(this).find('i').removeClass('fa-caret-right').addClass('fa-caret-down');

            // hide description content
            $('#description-'+activityId).slideToggle('5000'); 

        }
        
    });

       var artefactsSlide = $('.artefacts-list').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:6,
                    nav:false,
                    loop:false
                }
            }
        });

      // Custom Navigation Events
      $('.next').on('click', function(){
        artefactsSlide.trigger('next.owl.carousel');
      })
      $('.prev').on('click', function(){
        artefactsSlide.trigger('prev.owl.carousel');
      }) 

      // go to artefact detail
      $('.artefact-detail').on('click', function(){

        var friendlyUrl = $(this).data('friendlyUrl'),
            projectId = $(this).data('projectId');

         window.location.href = projectURL+'/artefacto/'+friendlyUrl+'/proyecto/'+projectId;

      }); 

    $('.emojis-popover').popover({ 
        html : true, 
        content: function() {
          return $('.emoticons-container').html();
        }
    });  

    $('.emojis-popover').on('shown.bs.popover', function () {

      var activityId = $(this).data('activityId'); 

      var popOverId = $(this).attr('aria-describedby');

      $('#'+popOverId).find('.popover-content').attr('data-activity-id', activityId);  
  
    });     

/*----------------------------------------------------------------------

        EDIT PROJECT FUNCTIONS

----------------------------------------------------------------------*/   

      $('.btn-delete-project').on('click', function(e){

         e.preventDefault(); 

         var projectId = $(this).data('projectId'); 


          var showAlert = swal({
            title: 'Eliminar proyecto',
            text: 'Al eliminar un proyecto se eliminan las actividades, colaboradores y artefactos asociados. ¿Realmente desea eliminarlo?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              window.location.href = projectURL+'/proyecto/eliminar/'+projectId;

          });               

       
      }); 

/*----------------------------------------------------------------------

        ACTIVITY ADD NEW

----------------------------------------------------------------------*/
    
    //ADD: new activity
    $('.btn-add-activity').on('click', function(){
      var projectId = $(this).data('projectId'); 

      window.location.href = projectURL+'/proyecto/actividad/crear/'+projectId;

    });       

/*----------------------------------------------------------------------

        EDIT ACTIVITY CATEGORIES FUNCTIONS

----------------------------------------------------------------------*/

      var htmlCategories = '',
          categoryCount = 0; 

          $('.btn-add-category').on('click', function(){

            categoryCount++; 

            htmlCategories +=  '<div class="form-group project-category-'+categoryCount+'" style="display:none">'+
                                  '<label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Categor&iacute;a</label>'+
                                    '<div class="col-md-4">'+
                                        '<input placeholder="Ej: Requisitos" class="form-control category-input app-input " name="values[new_category][]" type="text">'+
                                      '<div data-category-id="'+categoryCount+'" class="btn-delete-category circle activity-option txt-center fs-big fc-pink">'+
                                        '<i class="fa fa-times fa-fw"></i>'+
                                      '</div>'+
                                      '<br><br>'+
                                      '<span class="error fc-pink fs-min hidden">Debe indicar un nombre de categor&iacute;a</span>'+
                                    '</div>'+
                                  '</div>';  

                      $(htmlCategories).appendTo('.categories-content').fadeIn('slow');
  
                      htmlCategories = '';

          });

        // CREATE PROJECT SEND FORM
        $('.btn-create-project').on('click', function(e){

            e.preventDefault();

            // adding rules for inputs
            $('input, textarea').each(function() {
                $(this).rules('add', 
                    {
                        required: true
                    })

                if($(this).data('inputType')=='email'){
                  $(this).rules('add', 
                      {
                          email: true
                      })                  

                }
            }); 

            if($('#form-create-project').validate().form()){
                
                if (iterationsCount>0){

                   $('.btn-create-project').off('click').removeClass('btn-green').addClass('btn-green-disable'); 
                   $('#form-create-project').submit();

                   return false; 

                }else{

                  $('html, body').animate({ scrollTop: 0 }, 'slow');
                  $('.error-alert').removeClass('hidden'); 
                  $('.error-text').html('Debe indicar al menos una iteraci&oacute;n'); 
                }

            }else{
                
            }              

       });


        $(document).ready(function(){
          $('#form-create-project').validate({
              errorClass: 'error-input',
              errorPlacement: function(error,element) {
                  return true;
              },
              invalidHandler: function(event, validator){

                $('html, body').animate({ scrollTop: 0 }, 'slow');
                $('.error-alert').removeClass('hidden'); 

              },
              submitHanlder: function(form){


                }

            });  
        });       


        // DELETE SAVED CATEGORY FROM DB 
        $(document).on('click', '.btn-delete-saved-invitation', function(){

           var categoryId = $(this).data('categoryId'); 
               projectId = $(this).data('projectId'); 
               categoryName = $(this).data('categoryName'); 

            var showAlert = swal({
              title: 'Eliminar categoría',
              text: 'Confirma que desea eliminar la categoría de actividad: '+categoryName,
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef6f66',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar',
              cancelButtonColor: '#ef6f66',
              closeOnConfirm: true
            },
            function(){

                // show ajax loader
                $('.loader').show();

                 $.ajax({
                    url: projectURL+'/proyecto/eliminar-categorias/'+categoryId+'/'+projectId,
                    type:'GET',
                    dataType: 'JSON',
                    success:function (response) {

                        if(!response.error){

                         $(document).find('.project-saved-category-'+categoryId).fadeOut('slow', 
                            function() { 
                              $(this).remove()
                            }); 

                            // hide ajax loader
                            $('.loader').hide();
                       

                        }
                    },
                    error: function(xhr, error) {

                    }
                });

            });               

         
        });

        // DELETE CATEGORIES ADDED TO DOM
        $(document).on('click','.btn-delete-category', function(){

          var categoryId = $(this).data('categoryId'); 

           $(document).find('.project-category-'+categoryId).fadeOut('slow', 
              function() { 
                $(this).remove()
              });
        });


        // SEND EDITED CATEGORIES FORM
        $('.btn-edit-categories').on('click', function(){

          var successValidation = false,
              totalCategories = 0;

              //validate categories
              $('.category-input').each(function(){

                totalCategories++; 

                if($(this).val() == ''){
                  $(this).siblings('.error').removeClass('hidden'); 
                }else{
                   $(this).siblings('.error').addClass('hidden');
                    successValidation++; 
                }
              });

              // success validation, all categories are valid
              if(successValidation==totalCategories){
                $(document).find('#form-edit-categories').submit()
              }              

        }); 

/*----------------------------------------------------------------------

        ACTIVITY CREATE FUNCTIONS

----------------------------------------------------------------------*/   

    //CREATE: submit form
    $('.btn-create-activity').on('click', function(){

      $("#submit-btn").off("click");
      $('#submit-btn').removeClass("btn-green");
      $('#submit-btn').addClass("btn-green-disable");
        
      $('#form-create-activity').submit();

    });
    
/*----------------------------------------------------------------------

        ACTIVITY DELETE FUNCTIONS

----------------------------------------------------------------------*/       

      $('.btn-delete-activity').on('click', function(e){

         e.preventDefault(); 

         var activityId = $(this).data('activityId'); 

          var showAlert = swal({
            title: '¿Está seguro que desea eliminar la actividad?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              window.location.href = projectURL+'/proyecto/actividad/eliminar/'+activityId;

          });  
       
      }); 

/*----------------------------------------------------------------------

        ACTIVITY EDIT FUNCTIONS

----------------------------------------------------------------------*/
     //EDIT: list btn
    $('.btn-edit-activity-id').on('click', function(){
      var activityId = $(this).data('activityId'); 

      window.location.href = projectURL+'/proyecto/actividad/editar/'+activityId;

    });       

    //EDIT: submit form
    $('.btn-edit-activity').on('click', function(){

        $(".btn-edit-activity").off("click");
        $('.btn-edit-activity').removeClass("btn-yellow");
        $('.btn-edit-activity').addClass("btn-yellow-disable");

      $('#form-edit-activity').submit();

      return false;

    }); 

/*----------------------------------------------------------------------

        ACTIVITY ENUMERATE FUNCTIONS

----------------------------------------------------------------------*/             

    //ACTIVITY: change activity status
    $('.btn-change-activity-status').on('click', function(){

        var activityStatus = $(this).attr('data-activity-status'),
            acitivityId = $(this).attr('data-activity-id'),
            self = $(this); 

        switch(parseInt(activityStatus)) {

            case UNDONE_ACTIVITY:

                $('.loader').show();

                $.ajax({
                    url: projectURL+'/actividad/cambiar-estado/'+acitivityId+'/'+DOING_ACTIVITY,
                    type:'GET',
                    dataType: 'JSON',
                    success:function (response) {

                        if(!response.error){

                            self.removeClass('fc-grey-iv').addClass('fc-yellow');
                            self.attr('data-activity-status', response.new_status); 

                            $('.activity-title-'+acitivityId).removeClass('txt-strike');   

                             $('.loader').hide();             

                        }
                    },
                    error: function(xhr, error) {

                         $('.loader').hide();  

                    }
                });            

                break;

            case DOING_ACTIVITY:

                $.ajax({
                    url: projectURL+'/actividad/cambiar-estado/'+acitivityId+'/'+DONE_ACTIVITY,
                    type:'GET',
                    dataType: 'JSON',
                    success:function (response) {

                        if(!response.error){

                            self.removeClass('fc-yellow').addClass('fc-green');
                            self.attr('data-activity-status', response.new_status); 

                             $('.activity-title-'+acitivityId).addClass('txt-strike');  

                             $('.loader').hide();             

                        }
                    },
                    error: function(xhr, error) {

                         $('.loader').hide();  

                    }
                });  

                break;

            case DONE_ACTIVITY:

                $.ajax({
                    url: projectURL+'/actividad/cambiar-estado/'+acitivityId+'/'+UNDONE_ACTIVITY,
                    type:'GET',
                    dataType: 'JSON',
                    success:function (response) {

                        if(!response.error){

                            self.removeClass('fc-green').addClass('fc-grey-iv');
                            self.attr('data-activity-status', response.new_status); 

                              $('.activity-title-'+acitivityId).removeClass('txt-strike');

                             $('.loader').hide();             

                        }
                    },
                    error: function(xhr, error) {

                         $('.loader').hide();  

                    }
                });  
                
                break;                

        }

    })

/*----------------------------------------------------------------------

        ACTIVITY DETAIL FUNCTIONS

----------------------------------------------------------------------*/

    // function: save comment 
    $('.save-comment').on('click', function(){

      var activityId = $(this).data('activityId'); 

      if($('#comment-textarea-'+activityId).val()!=''){

         $('.loader').show();

        $('.comments-content').find('.error').addClass('hidden'); 

          $.ajax({
              url: projectURL+'/actividad/comentar/',
              type:'POST',
              data: $('#form-comment-activity-'+activityId).serialize(),
              dataType: 'JSON',
              success:function (response) {

                  if(!response.error){

                    var html = ''; 

                          html += '<div class="comment-content" id="comment-'+response.comment.id+'" style="display:none;">'+
                                    '<div class="user-avatar">';

                                    if(response.comment.user_avatar>0){
                                       html += '<img class="img-circle comment-user-avatar" src="'+projectURL+'/uploads/'+ response.comment.avatar_file+'"/>';
                                    }else{
                                       html += '<img class="img-circle comment-user-avatar" src="'+projectURL+'/images/dummy-user.png"/>';
                                    }

                                html += '</div>'+
                                '<span class="fs-min f-bold"></i>' + response.comment.user_first_name +'<i class="fs-med fa fa-calendar fc-green fa-fw"></i> '+response.comment.date+ '</span>'+
                                '<div class="comment-text">'+
                                    response.comment.comment +
                                '</div>';

                                if(response.comment.editable){
                                   html += '<div class="comment-action">'+
                                              '<div  class="btn-delete-comment txt-center fs-big fc-pink" data-comment-id="'+response.comment.id+'">'+
                                                '<i class="fa fa-times fa-fw"></i>'+
                                              '</div>'+
                                            '</div>';  
                                }
                            html += '</div>';

                      $('#comment-textarea-'+activityId).val(''); 
                      $(html).prependTo('.comment-list-'+activityId).fadeIn('slow');

                      html = ''; 

                    $('.loader').hide();          

                  }
              },
              error: function(xhr, error) {

                   $('.loader').hide();  

              }
          });  


      }else{

        $('#comment-textarea-'+activityId).addClass('error-input'); 

      }

    });

      // function: delete comment
      $(document).on('click', '.btn-delete-comment', function(){

         var commentId = $(this).data('commentId'); 

          var showAlert = swal({
            title: 'Eliminar comentario',
            text: 'Confirma que desea eliminar su comentario en esta actividad',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              // show ajax loader
              $('.loader').show();

               $.ajax({
                  url: projectURL+'/actividad/eliminar-comentario/'+commentId,
                  type:'GET',
                  dataType: 'JSON',
                  success:function (response) {

                      if(!response.error){

                       $(document).find('#comment-'+commentId).fadeOut('slow', 
                          function() { 
                            $(this).remove()
                          }); 

                          // hide ajax loader
                          $('.loader').hide();
                     

                      }
                  },
                  error: function(xhr, error) {
                      // hide ajax loader
                      $('.loader').hide();

                  }
              });

          });               

       
      });


    // filter activities
    $('.btn-filter').on('click', function(e){

      e.preventDefault(); 

      var categoryId = $(this).data('categoryId'),
          filterString =  $('input[name="filters[category]"]').val();
         

          if($(this).hasClass('unselected-tag')){

            $(this).addClass('selected-tag').removeClass('unselected-tag').removeClass('tags-list-off').addClass('tags-list-on'); 


              if(filterString!=''){

                filterString = filterString+','+categoryId;

              }else{

                filterString = categoryId; 

              }

              $('input[name="filters[category]"]').val(filterString);


          }else{

              $(this).addClass('unselected-tag').removeClass('selected-tag').addClass('tags-list-off').removeClass('tags-list-on'); 


              filtersArray = filterString.split(',');
              filtersArray = _.without(filtersArray, categoryId.toString());

              $('input[name="filters[category]"]').val(filtersArray.toString());

          }
            
             console.log($('input[name="filters[category]"]').val()); 

          $('#form-filter-activity').submit();

    })

    $('.btn-status').on('click', function(e){

      e.preventDefault(); 

      var statusId = $(this).data('statusId'),
          statusString =  $('input[name="filters[status]"]').val();
         

          if($(this).hasClass('unselected-tag')){

            $(this).addClass('selected-tag').removeClass('unselected-tag').removeClass('tags-list-off').addClass('tags-list-on'); 


              if(statusString!=''){

                statusString = statusString+','+statusId;

              }else{

                statusString = statusId; 

              }

              $('input[name="filters[status]"]').val(statusString);


          }else{


              $(this).addClass('unselected-tag').removeClass('selected-tag').addClass('tags-list-off').removeClass('tags-list-on'); 


              statusArray = statusString.split(',');
              statusArray = _.without(statusArray, statusId.toString());

              $('input[name="filters[status]"]').val(statusArray.toString());

          }
            
             console.log($('input[name="filters[status]"]').val()); 

          $('#form-filter-activity').submit();      

    });


});

/*----------------------------------------------------------------------

       EDIT PROJECT

----------------------------------------------------------------------*/


        $(document).on('click', '.delete-project-artefact', function(){

           var artefactId = $(this).data('artefactId'), 
               artefactFriendlyUrl = $(this).data('artefactFriendlyUrl'),
               artefactName = $(this).data('artefactName'),
               projectId = $(this).data('projectId'); 


            var showAlert = swal({
              title: 'Eliminar artefacto',
              text: 'Confirma que desea eliminar el artefacto '+artefactName,
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef6f66',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar',
              cancelButtonColor: '#ef6f66',
              closeOnConfirm: true
            },
            function(){

                var parameters = {
                    'values[artefact_friendly_url]'      : artefactFriendlyUrl,
                    'values[artefact_id]'                : artefactId, 
                    'values[project_id]'                 : projectId 
                };

                // show ajax loader
                $('.loader').show();

                 $.ajax({
                    url: projectURL+'/proyecto/eliminar-artefacto/',
                    type:'POST',
                    data: parameters,
                    dataType: 'JSON',
                    success:function (response) {

                        if(!response.error){

                         $(document).find('.artefact-'+artefactId).fadeOut('slow', 
                            function() { 
                              $(this).remove();
                          });

                         setTimeout(function(){
                            location.reload(); 
                        }, 1000);

                            // hide ajax loader
                            $('.loader').hide();
                       
                        }
                    },
                    error: function(xhr, error) {

                    }
                });

            });               

         
        });

    //PUBLIC PROBE: submit form
    $('.btn-send-public-probe').on('click', function(){
        
        $('#form-save-probe-results').submit();

        return false;

    });

/*----------------------------------------------------------------------

        CHECKLIST ADD NEW

----------------------------------------------------------------------*/
    
    //ADD: new activity
    $('.btn-add-checklist').on('click', function(){

      var projectId = $(this).data('projectId'); 
      console.log(projectId); 
      window.location.href = projectURL+'/listas-de-comprobacion/crear/'+projectId;

    });   

   //CREATE: submit form
    $('.btn-create-checklist').on('click', function(){

        var successValidation = false,
              totalPrinciples = 0;

        //validate categories
        $('.principle-input').each(function(){

          totalPrinciples++; 

          if($(this).val() == ''){
            $(this).siblings('.error').removeClass('hidden'); 
          }else{
             $(this).siblings('.error').addClass('hidden');
              successValidation++; 
          }
        
        });

        // success validation, all categories are valid
        if(successValidation==totalPrinciples){

          $(".btn-create-checklist").off("click");
          $('.btn-create-checklist').removeClass("btn-green");
          $('.btn-create-checklist').addClass("btn-green-disable");

          $(document).find('#form-create-checklist').submit();
        }

    });
    
    var htmlPrinciples = '',
        principleCount =  $(document).find('.principles-content').attr('id');

    $('.btn-add-principle').on('click', function(){

      //Add Principle
      console.log(principleCount);
      htmlPrinciples +=  '<div class="form-group checklist-principle-'+principleCount+'" style="display:none">'+
                            '<label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Principio</label>'+
                              '<div class="col-md-4">'+
                                  '<input class="form-control principle-input app-input" name="values[new_principle]['+principleCount+'][rule]" type="text">'+
                                  '<br><br>'+
                                  '<span class="error fc-pink fs-min hidden">Debe indicar el principio </span>'+
                              '</div>'+                                  
                          '</div>'+

                          '<div class="form-group checklist-principle-'+principleCount+'" style="display:none">'+
                            '<label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Descripci&oacute;n</label>'+
                              '<div class="col-md-4">'+
                                  '<textarea class="form-control principle-input app-input" name="values[new_principle]['+principleCount+'][description]" type="text"></textarea>'+
                                '<br><br>'+
                                '<span class="error fc-pink fs-min hidden">Debe indicar una descripcici&oacute;n del principio</span>'+
                              '</div>'+
                          '</div>'+

                          '<div class="form-group checklist-principle-'+principleCount+'">'+
                            '<label class="col-md-4 title-label control-label"></label>'+
                            '<div class="col-md-4">'+
                              '<div data-principle-id="'+principleCount+'" class="form-group btn-delete-principle-alert circle activity-option txt-center fs-big fc-pink pull-right">'+
                                '<i class="fa fa-times fa-fw"></i>'+
                              '</div>'
                            '</div>'+
                          '</div>';
      ;  

      $(htmlPrinciples).appendTo('.principles-content').fadeIn('slow');
      principleCount++;
      
      htmlPrinciples = '';
      $('.principles-content').attr('id',principleCount);

    });

    //DELETE: checklist
    $('.btn-checklist-delete').on('click', function(){

    var checklistId = $(this).data('checklistId'),
        checklistTitle = $(this).data('checklistTitle');

      var showAlert = swal({
        title: '¿Está seguro que desea eliminar la lista de comprobacion: '+checklistTitle+' ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef6f66',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#ef6f66',
        closeOnConfirm: true
      },
      function(){

          window.location.href = projectURL+'/listas-de-comprobacion/eliminar/'+checklistId;

      });               

    });

    $(document).on('click', '.btn-delete-principle-alert', function(e){

        console.log('entro');
        var principleId = $(this).data('principleId');  
      
        var showAlert = swal({
          title: 'Eliminar principio',
          text: '¿Realmente desea eliminarlo?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef6f66',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar',
          cancelButtonColor: '#ef6f66',
          closeOnConfirm: true
        },
        function(){

          $(document).find('.checklist-principle-'+principleId).fadeOut('slow', 
          function() { 
            $(this).remove()
          });

        });             
    }); 

    //EDIT: checklist
    $('.btn-edit-checklist').on('click', function(){

      var successValidation = false,
          totalPrinciples = 0;

          //validate categories
          $('.principle-input').each(function(){

            totalPrinciples++; 

            if($(this).val() == ''){
              $(this).siblings('.error').removeClass('hidden'); 
            }else{
               $(this).siblings('.error').addClass('hidden');
                successValidation++; 
            }
          });

          // success validation, all categories are valid
          if(successValidation==totalPrinciples){

            $(".btn-edit-checklist").off("click");
            $('.btn-edit-checklist').removeClass("btn-yellow");
            $('.btn-edit-checklist').addClass("btn-yellow-disable");

            $(document).find('#form-edit-checklist').submit();
          }

    });

    //VERIFY: checklist
    $('.btn-checklist-show').on('click', function(){
      var checklistId = $(this).data('checklistId'); 

      window.location.href = projectURL+'/listas-de-comprobacion/mostrar/'+checklistId;

    });

    //VERIFY: checklist
    $('.btn-checklist-verify').on('click', function(){
      var checklistId = $(this).data('checklistId'); 

      window.location.href = projectURL+'/listas-de-comprobacion/verificar/'+checklistId;

    }); 

       //VERIFY: submit form
    $('.btn-verify-checklist').on('click', function(){

        $(".btn-verify-checklist").off("click");
        $('.btn-verify-checklist').removeClass("btn-green");
        $('.btn-verify-checklist').addClass("btn-green-disable");
        
        $('#form-verify-checklist').submit();

        return false;

    });

    //Reassign: activity
    $('.btn-reassign-activity').on('click', function(){
      var activityId = $(this).data('activityId'),
          successValidation = false;
      
      if($('#assigned-user-'+activityId).val() == 0){
        
        $('#assigned-user-'+activityId).siblings('.error-modal-'+activityId).removeClass('hidden'); 
      }else{
        
        $('#assigned-user-'+activityId).siblings('.error-modal-'+activityId).addClass('hidden');
          successValidation=true; 
      }
      if(successValidation){

        $(".btn-reassign-activity").off("click");
        $('.btn-reassign-activity').removeClass("btn-yellow");
        $('.btn-reassign-activity').addClass("btn-yellow-disable");

        $('#form-reassign-activity-'+activityId).submit();
      }

      return false;

    });

    $('.btn-delete-checklist').on('click', function(){

    var checklistId = $(this).data('checklistId'),
        checklistTitle = $(this).data('checklistTitle');

      var showAlert = swal({
        title: '¿Está seguro que desea eliminar la lista de comprobación: '+checklistTitle+' ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef6f66',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#ef6f66',
        closeOnConfirm: true
      },
      function(){

          window.location.href = projectURL+'/listas-de-comprobacion/eliminar/'+checklistId;

      });               

    });

/*----------------------------------------------------------------------

        STORM IDEAS ADD NEW

----------------------------------------------------------------------*/

    //ADD: new storm-ideas
    $('.btn-add-storm-ideas').on('click', function(){

      var projectId = $(this).data('projectId'); 
       
      window.location.href = projectURL+'/tormenta-de-ideas/crear/'+projectId;

    }); 

    
    //DELETE: storm-ideas
    $('.btn-delete-storm-ideas').on('click', function(){

    var stormIdeasId = $(this).data('stormIdeasId'),
        stormIdeasTitle = $(this).data('stormIdeasTitle');

      var showAlert = swal({
        title: '¿Está seguro que desea eliminar la tormenta de ideas: '+stormIdeasTitle+' ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef6f66',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#ef6f66',
        closeOnConfirm: true
      },
      function(){

          window.location.href = projectURL+'/tormenta-de-ideas/eliminar/'+stormIdeasId;

      });               

    });


   //CREATE: submit form
    $('.btn-create-storm-ideas').on('click', function(){


      $(".btn-create-storm-ideas").off("click");
      $('.btn-create-storm-ideas').removeClass("btn-green");
      $('.btn-create-storm-ideas').addClass("btn-green-disable");

      $(document).find('#form-create-storm-ideas').submit();
      

    });

   //EDIT: submit form
    $('.btn-edit-storm-ideas').on('click', function(){


      $(".btn-edit-storm-ideas").off("click");
      $('.btn-edit-storm-ideas').removeClass("btn-yellow");
      $('.btn-edit-storm-ideas').addClass("btn-yellow-disable");

      $(document).find('#form-edit-storm-ideas').submit();
      

    });

