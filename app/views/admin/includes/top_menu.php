<!--INIT TOP MENU-->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header user pull-right">
            <?=(Session::get('admin_user')!=NULL?Session::get('admin_user')->first_name.' '.Session::get('admin_user')->last_name:'')?>
        	// <a href="<?=URL::action('AdminLoginController@logout')?>"> Cerrar Sesi&oacute;n </a>
        </div>
      </div>
    </nav>  
<!--END TOP MENU-->