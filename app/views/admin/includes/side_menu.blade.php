<!--INIT sidebar-->

<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                PROAGIL ADMIN
            </a>
        </li>
        <li>
            <a href="{{URL::action('AdminLoginController@index')}}">Inicio</a>
        </li>
        <li>
            <a href="{{URL::action('AdminProjectTypeController@enumerate')}}">{{Config::get('constant.admin.entity.project_type')}}</a>
        </li>
        <li>
            <a href="{{URL::action('AdminArtefactController@enumerate')}}">{{Config::get('constant.admin.entity.artefact')}}</a>
        </li>        
    </ul>
</div>

<!--END sidebar-->