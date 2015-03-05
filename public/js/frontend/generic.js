// CONSTANST SECTION

    var UNDONE_ACTIVITY = 1,
        DOING_ACTIVITY = 2,
        DONE_ACTIVITY = 3;

$(function() {

    //GENERIC: tooltip
    $('[data-toggle="popover"]').popover();

    //GENERIC: remove all active classes on load
    var active = $('.active'); 
    
    $(document).find(active).removeClass('active'); 

    //LOGIN
    $('.btn-login').on('click', function(){

        $('#form-login').submit();

        return false;

    });

    // FORGOT PASSWORD
    $('.btn-forgot-password').on('click', function(){

        $('#form-forgot-password').submit();

        return false;

    });

    // CHANGE PASSWORD
    $('.btn-change-password').on('click', function(){

        $('#form-change-password').submit();

        return false;

    });    

    //REGISTER
    $('.btn-register').on('click', function(){

        $('#form-register').submit();

        return false;

    });    

    $('.file-upload').bootstrapFileInput();  

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
  
    
    // DASHBOARD: show/hide section (artefacts or activities)
    $('.section-arrow').on('click', function(){

        var section = $(this).data('section'); 
        
        if($('#'+section).hasClass('show')){
            
            $(this).find('i').removeClass('fa-caret-down');
            $(this).find('i').addClass('fa-caret-right');
        
            $('#'+section).removeClass('show');
            $('#'+section).addClass('hidden');
            
            $('.artefacts-content').animate({'height':'10px'}, 'slow'); 

        }else{
        
            $(this).find('i').removeClass('fa-caret-right');
            $(this).find('i').addClass('fa-caret-down');

            $('#'+section).removeClass('hidden');
            $('#'+section).addClass('show');
            
            $('.artefacts-content').animate({'height':'215px'}, 'slow'); 
            
            
        }
        
    });

    // PROJECT DETAIL: show activity description
    $('.btn-activity-description').on('click', function(){

        var activityId = $(this).data('activityId');

        if($(this).hasClass('close-activity')){           

            // mark current circle as open
            $(this).removeClass('close-activity').addClass('open-activity');

            // change icon arrow
            $(this).find('i').removeClass('fa-caret-down').addClass('fa-caret-right');

            // show description content
            $('#description-'+activityId).slideToggle('5000'); 
                

        }else{

            //mark current circle as close
            $(this).removeClass('open-activity').addClass('close-activity');

            // change icon arrow
            $(this).find('i').removeClass('fa-caret-right').addClass('fa-caret-down');

            // hide description content
            $('#description-'+activityId).slideToggle('5000'); 

        }
        
    });

    //ACTIVITY: change activity status
    $('.btn-change-activity-status').on('click', function(){

        var activityStatus = $(this).data('activityStatus'),
            acitivityId = $(this).data('activityId'),
            self = $(this); 

        switch(activityStatus) {

            case UNDONE_ACTIVITY:

                $('.loader').show();

                $.ajax({
                    url: projectURL+'/actividad/cambiar-estado/'+acitivityId+'/'+DOING_ACTIVITY,
                    type:'GET',
                    dataType: 'JSON',
                    success:function (response) {

                        if(!response.error){

                            self.removeClass('fc-grey-iv').addClass('fc-yellow');
                            self.data('activity-status', response.new_status); 

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
                            self.data('activity-status', response.new_status); 

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
                            self.data('activity-status', response.new_status); 

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

});


