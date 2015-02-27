<!DOCTYPE html>
<html lang="en">

<head>

	@include('admin.includes.head')

</head>

<body>

    <div id="wrapper">

		@include('admin.includes.side_menu')

		@include('admin.includes.top_menu')

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
						<h1>Administrador AppName</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum a tincidunt ligula, et viverra justo. Ut tincidunt dui sit amet elit fringilla sagittis. Ut bibendum neque non hendrerit iaculis. Quisque nisi tellus, venenatis at nisi quis, porttitor rutrum erat. Aliquam bibendum ante nec sapien pretium maximus. Vestibulum vel eros sed mauris viverra porta. Proin vel diam in libero ullamcorper sagittis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc sed euismod leo. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

	@include('admin.includes.javascript')

	    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>


</body>

</html>
