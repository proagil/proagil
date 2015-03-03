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
            <a href="{{URL::action('AdminProjectTypeController@enumerate')}}">Tipo de Proyecto</a>
        </li>
    </ul>
</div>

<!--END sidebar-->