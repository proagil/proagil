$(function() {

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

    // CREATE PROJECT
    $('.btn-create-project').on('click', function(){

        $('#form-create-project').submit();

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
        
    })

});


