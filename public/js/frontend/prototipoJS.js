
/************ paper del contenedor *************/
var graph2 = new joint.dia.Graph;
var paper2 = new joint.dia.Paper({
    el: $('.paper'),
    gridSize: 50,
    perpendicularLinks: false,
    model: graph2,
    width: 1000,
    height: 1000,
    embeddingMode: true
    
});

/***********************************************/

/********************************************** Menúes*******************************************/
var graph = new joint.dia.Graph;
var paper = new joint.dia.Paper({
    el: $('.stencil_menu'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph,
    interactive: false,
    width: 200,
    height:280
    
});

var menu = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 0
    },
    size : {
        width : 170,
        height : 40
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/menu.png',
            width : 170,
            height : 40
        }
    }
});


var menuCarpetas = new joint.shapes.basic.Image({
    position : {
        x : 0,
        y : 50
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/menuCarpetas.png',
            width : 100,
            height : 100
        }
    }
});


var MenuItem = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 40
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/MenuItem.png',
            width : 100,
            height : 100
        }
    }
});

var MenuItem3 = new joint.shapes.basic.Image({
    position : {
        x : 0,
        y : 170
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/MenuItem2.png',
            width : 100,
            height : 100
        }
    }
});

var navegacion = new joint.shapes.basic.Image({
    position : {
        x : 95,
        y : 170
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/navegacion.png',
            width : 100,
            height : 100
        }
    }
});

/*Se agregan las imagenes en el stencil*/
graph.addCell(menu)
graph.addCell(menuCarpetas)
graph.addCell(MenuItem)
graph.addCell(MenuItem3)
graph.addCell(navegacion)



var selected;
var selected2;

var menu2, menuCarpetas2;
/*Funcion que devuelve la imagen, que el usuario le dio click, al contenedor*/
paper.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == menu.id) {

         menu2 = menu.clone();
        menu2.resize(771, 45);
        menu2.attr('image/width', '771');
        menu2.attr('image/height', '45');
        graph2.addCell(menu2)

    }else if(cellView.model.id == menuCarpetas.id){   

        menuCarpetas2 = menuCarpetas.clone();
        menuCarpetas2.resize(97, 162);
        menuCarpetas2.attr('image/width', '97');
        menuCarpetas2.attr('image/height', '162');
        graph2.addCell(menuCarpetas2)

    }else if(cellView.model.id == MenuItem.id){   

        var MenuItem2 = MenuItem.clone();
        MenuItem2.resize(376, 103);
        MenuItem2.attr('image/width', '376');
        MenuItem2.attr('image/height', '103');
        graph2.addCell(MenuItem2)

    }else if(cellView.model.id == MenuItem3.id){   

        var MenuItem4 = MenuItem3.clone();
        MenuItem4.resize(152, 179);
        MenuItem4.attr('image/width', '152');
        MenuItem4.attr('image/height', '179');
        graph2.addCell(MenuItem4)

    }else if(cellView.model.id == navegacion.id){   

        var navegacion2 = navegacion.clone();
        navegacion2.resize(543, 55);
        navegacion2.attr('image/width', '543');
        navegacion2.attr('image/height', '55');
        graph2.addCell(navegacion2)

    };
    
})



/*Se agrega una clase a los elementos del contenedor*/
paper.$el.addClass('cursor');



// cache important html elements
var $sx = $('#sx');
var $wh = $('#wh');
var $ps = $('#ps');


$sx.on('input change', function() {
    paper2.scale(parseFloat(this.value), parseFloat(this.value));
});

$ps.on('input change', function() {
    paper2.setDimensions(parseFloat(this.value), parseFloat(this.value));

    tam= parseFloat(this.value);
});

/***** Evento que permite aparecer las opciones de atributos y realizar cambios en los elementos **/
paper2.on('cell:pointerdown', function(cellView,evt, x, y) { 
  
     selected2 = cellView.model;
     //console.log(selected2);
    document.getElementById("draggable").style.display = "inline";

 
});


$wh.on('input change', function() {

   if (selected2.attributes.type == 'erd.Normal'){

     selected2.resize(parseFloat(this.value), 70);
   }else{

    selected2.resize(parseFloat(this.value), parseFloat(this.value));
   }

});


//Evento  que permite desaparecer el cuadro de atributos
paper2.on('blank:pointerclick ', function(cellView,evt, x, y) { 

    document.getElementById("draggable").style.display = "none";

});

/*Al darle click aprece/desaprece los elementos de ese menu*/
 $('.section-arrow-diag').on('click', function(){

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

/******************************************************************************************************/


/********************************************** Botones***********************************************/
var graph3 = new joint.dia.Graph;
var paper3 = new joint.dia.Paper({
    el: $('.stencil_button'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph3,
    interactive: false,
    width: 200,
    height:210
    
});

var boton = new joint.shapes.basic.Image({
    position : {
        x : 20,
        y : 20
    },
    size : {
        width : 150,
        height : 40
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/boton.png',
            width : 150,
            height : 40
        }
    }
});


var boxVacio = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 70
    },
    size : {
        width : 30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/boxVacio.png',
            width : 30,
            height : 30
        }
    }
});


var check = new joint.shapes.basic.Image({
    position : {
        x : 100,
        y : 70
    },
    size : {
        width : 30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/check.png',
            width : 30,
            height : 30
        }
    }
});

var off = new joint.shapes.basic.Image({
    position : {
        x : 30,
        y : 100
    },
    size : {
        width : 50,
        height : 50
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/OFF.png',
            width : 50,
            height : 50
        }
    }
});

var onBoton = new joint.shapes.basic.Image({
    position : {
        x : 100,
        y : 100
    },
    size : {
        width : 50,
        height : 50
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/ON.png',
            width : 50,
            height : 50
        }
    }
});

var opciones = new joint.shapes.basic.Image({
    position : {
        x : 75,
        y : 160
    },
    size : {
        width : 50,
        height : 50
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/opciones.png',
            width : 50,
            height : 50
        }
    }
});



/*Se agregan las imagenes en el stencil*/
graph3.addCell(boton)
graph3.addCell(boxVacio)
graph3.addCell(check)
graph3.addCell(off)
graph3.addCell(onBoton)
graph3.addCell(opciones)

paper3.$el.addClass('cursor');



paper3.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == boton.id) {

       var boton2 = boton.clone();
        boton2.resize(160, 46);
        boton2.attr('image/width', '160');
        boton2.attr('image/height', '46');
        graph2.addCell(boton2)
     
    }else if(cellView.model.id == boxVacio.id){   

        var boxVacio2 = boxVacio.clone();
        boxVacio2.resize(25, 26);
        boxVacio2.attr('image/width', '25');
        boxVacio2.attr('image/height', '26');
        graph2.addCell(boxVacio2)

    }else if(cellView.model.id == check.id){   

        var check2 = check.clone();
        check2.resize(23, 26);
        check2.attr('image/width', '23');
        check2.attr('image/height', '26');
        graph2.addCell(check2)

    }else if(cellView.model.id == off.id){   

        var off2 = off.clone();
        off2.resize(66, 34);
        off2.attr('image/width', '66');
        off2.attr('image/height', '34');
        graph2.addCell(off2)

    }else if(cellView.model.id == onBoton.id){   

        var onBoton2 = onBoton.clone();
        onBoton2.resize(66, 36);
        onBoton2.attr('image/width', '66');
        onBoton2.attr('image/height', '36');
        graph2.addCell(onBoton2)

    
    }else if(cellView.model.id == opciones.id){   

        var opciones2 = opciones.clone();
        opciones2.resize(44, 42);
        opciones2.attr('image/width', '44');
        opciones2.attr('image/height', '42');
        graph2.addCell(opciones2)

    };
    
})




/***************************************************************************************/



/********************************************** icononografía***********************************************/
var graph4 = new joint.dia.Graph;
var paper4 = new joint.dia.Paper({
    el: $('.stencil_icon'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph4,
    interactive: false,
    width: 200,
    height: 100
    
});

var botoneliminar = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 10
    },
    size : {
        width :   30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/botoneliminar.png',
            width : 30,
            height : 30
        }
    }
});


var botonbuscar = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 10
    },
    size : {
        width : 30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/botonbuscar.png',
            width : 30,
            height : 30
        }
    }
});


var botoncalendario = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 10
    },
    size : {
        width : 30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/botoncalendario.png',
            width : 30,
            height : 30
        }
    }
});

var botonconfiguracion = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 10
    },
    size : {
        width : 30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/botonconfiguracion.png',
            width : 30,
            height : 30
        }
    }
});

var botonrecargar = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 50
    },
    size : {
        width : 30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/botonrecargar.png',
            width : 30,
            height : 30
        }
    }
});

var cargar = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 50
    },
    size : {
        width : 30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/cargar.png',
            width : 30,
            height : 30
        }
    }
});

var carrito = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 50
    },
    size : {
        width : 30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/carrito.png',
            width : 30,
            height : 30
        }
    }
});


/*Se agregan las imagenes en el stencil*/
graph4.addCell(botoneliminar)
graph4.addCell(botonbuscar)
graph4.addCell(botoncalendario)
graph4.addCell(botonconfiguracion)
graph4.addCell(botonrecargar)
graph4.addCell(cargar)
graph4.addCell(carrito)

paper4.$el.addClass('cursor');



paper4.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == botoneliminar.id) {

        var botoneliminar2 = botoneliminar.clone();
        botoneliminar2.resize(36, 36);
        botoneliminar2.attr('image/width', '36');
        botoneliminar2.attr('image/height', '36');
        graph2.addCell(botoneliminar2)

    }else if(cellView.model.id == botonbuscar.id){   

        var botonbuscar2 = botonbuscar.clone();
        botonbuscar2.resize(34, 38);
        botonbuscar2.attr('image/width', '34');
        botonbuscar2.attr('image/height', '38');
        graph2.addCell(botonbuscar2)

    }else if(cellView.model.id == botoncalendario.id){   

        var botoncalendario2 = botoncalendario.clone();
        botoncalendario2.resize(36, 33);
        botoncalendario2.attr('image/width', '36');
        botoncalendario2.attr('image/height', '33');
        graph2.addCell(botoncalendario2)

    }else if(cellView.model.id == botonconfiguracion.id){   

        var botonconfiguracion2 = botonconfiguracion.clone();
        botonconfiguracion2.resize(34, 33);
        botonconfiguracion2.attr('image/width', '34');
        botonconfiguracion2.attr('image/height', '33');
        graph2.addCell(botonconfiguracion2)

    }else if(cellView.model.id == botonrecargar.id){   

        var botonrecargar2 = botonrecargar.clone();
        botonrecargar2.resize(35, 37);
        botonrecargar2.attr('image/width', '35');
        botonrecargar2.attr('image/height', '37');
        graph2.addCell(botonrecargar2)

    
    }else if(cellView.model.id == cargar.id){   

        var cargar2 = cargar.clone();
        cargar2.resize(31, 33);
        cargar2.attr('image/width', '31');
        cargar2.attr('image/height', '33');
        graph2.addCell(cargar2)

    }else if(cellView.model.id == carrito.id){   

        var carrito2 = carrito.clone();
        carrito2.resize(40, 41);
        carrito2.attr('image/width', '40');
        carrito2.attr('image/height', '41');
        graph2.addCell(carrito2)

    };
    
})

/***************************************************************************************/

/********************************************** Multimedia***********************************************/
var graph5 = new joint.dia.Graph;
var paper5 = new joint.dia.Paper({
    el: $('.stencil_multimedia'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph5,
    interactive: false,
    width: 200,
    height: 300
    
});

var imagenSmall = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 10
    },
    size : {
        width :   30,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/imagen3.png',
            width : 30,
            height : 30
        }
    }
});


var imagenMedium = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 10
    },
    size : {
        width : 50,
        height : 50
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/imagen2.png',
            width : 50,
            height : 50
        }
    }
});


var imagenLarge = new joint.shapes.basic.Image({
    position : {
        x : 110,
        y : 10
    },
    size : {
        width : 70,
        height : 70
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/imagen.png',
            width : 70,
            height : 70
        }
    }
});


var video = new joint.shapes.basic.Image({
    position : {
        x : 40,
        y : 100
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/video.png',
            width : 100,
            height : 100
        }
    }
});

var video2 = new joint.shapes.basic.Image({
    position : {
        x : 40,
        y : 200
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/video2.png',
            width : 100,
            height : 100
        }
    }
});


/*Se agregan las imagenes en el stencil*/
graph5.addCell(imagenSmall)
graph5.addCell(imagenMedium)
graph5.addCell(imagenLarge)
graph5.addCell(video)
graph5.addCell(video2)


paper5.$el.addClass('cursor');



paper5.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == imagenSmall.id) {

        var imagenSmall2 = imagenSmall.clone();
        imagenSmall2.resize(55, 55);
        imagenSmall2.attr('image/width', '55');
        imagenSmall2.attr('image/height', '55');
        graph2.addCell(imagenSmall2)

    }else if(cellView.model.id == imagenMedium.id){   

        var imagenMedium2 = imagenMedium.clone();
        imagenMedium2.resize(81, 83);
        imagenMedium2.attr('image/width', '81');
        imagenMedium2.attr('image/height', '83');
        graph2.addCell(imagenMedium2)

    }else if(cellView.model.id == imagenLarge.id){   

        var imagenLarge2 = imagenLarge.clone();
        imagenLarge2.resize(109, 107);
        imagenLarge2.attr('image/width', '109');
        imagenLarge2.attr('image/height', '107');
        graph2.addCell(imagenLarge2)

    }else if(cellView.model.id == video.id){   

        var video3 = video.clone();
        video3.resize(436, 381);
        video3.attr('image/width', '436');
        video3.attr('image/height', '381');
        graph2.addCell(video3)

    }else if(cellView.model.id == video2.id){   

        var video4 = video2.clone();
        video4.resize(332, 206);
        video4.attr('image/width', '332');
        video4.attr('image/height', '206');
        graph2.addCell(video4)

    
    };
    
})

/***************************************************************************************/


/********************************************** Browser***********************************************/
var graph6 = new joint.dia.Graph;
var paper6 = new joint.dia.Paper({
    el: $('.stencil_browser'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph6,
    interactive: false,
    width: 200,
    height: 600
    
});

var browserBlanco = new joint.shapes.basic.Image({
    position : {
        x : 20,
        y : 10
    },
    size : {
        width :   150,
        height : 150
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/browserBlanco.png',
            width : 150,
            height : 150
        }
    }
});


var browserOscuro = new joint.shapes.basic.Image({
    position : {
        x : 20,
        y : 160
    },
    size : {
        width : 150,
        height : 150
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/browserOscuro.png',
            width : 150,
            height : 150
        }
    }
});


var bannerSmall = new joint.shapes.basic.Image({
    position : {
        x : 20,
        y : 300
    },
    size : {
        width : 70,
        height : 50
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/banner.png',
            width : 70,
            height : 70
        }
    }
});


var bannerMedium = new joint.shapes.basic.Image({
    position : {
        x : 100,
        y : 300
    },
    size : {
        width : 100,
        height : 50
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/banner3.png',
            width : 100,
            height : 50
        }
    }
});

var bannerLarge = new joint.shapes.basic.Image({
    position : {
        x : 40,
        y : 350
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/banner2.png',
            width : 100,
            height : 100
        }
    }
});

var scrollvertical = new joint.shapes.basic.Image({
    position : {
        x : 20,
        y : 460
    },
    size : {
        width : 30,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/scrollvertical.png',
            width : 30,
            height : 100
        }
    }
});

var scrollHorizontal = new joint.shapes.basic.Image({
    position : {
        x : 80,
        y : 480
    },
    size : {
        width : 100,
        height : 20
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/scrollHorizontal.png',
            width : 100,
            height : 20
        }
    }
});

var scrollH2 = new joint.shapes.basic.Image({
    position : {
        x : 40,
        y : 460
    },
    size : {
        width : 20,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/scrollH2.png',
            width : 20,
            height : 100
        }
    }
});

var url = new joint.shapes.basic.Image({
    position : {
        x : 80,
        y : 450
    },
    size : {
        width : 70,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/url.png',
            width : 70,
            height : 30
        }
    }
});

var paginacion1 = new joint.shapes.basic.Image({
    position : {
        x : 80,
        y : 500
    },
    size : {
        width : 100,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/paginacion1.png',
            width : 100,
            height : 30
        }
    }
});
var paginacion2 = new joint.shapes.basic.Image({
    position : {
        x : 80,
        y : 520
    },
    size : {
        width : 100,
        height : 30
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/web/paginacion2.png',
            width : 100,
            height : 30
        }
    }
});



/*Se agregan las imagenes en el stencil*/
graph6.addCell(browserBlanco)
graph6.addCell(browserOscuro)
graph6.addCell(bannerSmall)
graph6.addCell(bannerMedium)
graph6.addCell(bannerLarge)
graph6.addCell(scrollvertical)
graph6.addCell(scrollHorizontal)
graph6.addCell(scrollH2)
graph6.addCell(url)
graph6.addCell(paginacion1)
graph6.addCell(paginacion2)



paper6.$el.addClass('cursor');



paper6.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == browserBlanco.id) {

        var browserBlanco2 = browserBlanco.clone();
        browserBlanco2.resize(737, 737);
        browserBlanco2.attr('image/width', '737');
        browserBlanco2.attr('image/height', '716');
        graph2.addCell(browserBlanco2)

    }else if(cellView.model.id == browserOscuro.id){   

        var browserOscuro2 = browserOscuro.clone();
        browserOscuro2.resize(736, 738);
        browserOscuro2.attr('image/width', '736');
        browserOscuro2.attr('image/height', '738');
        graph2.addCell(browserOscuro2)

    }else if(cellView.model.id == bannerSmall.id){   

        var bannerSmall2 = bannerSmall.clone();
        bannerSmall2.resize(476, 72);
        bannerSmall2.attr('image/width', '476');
        bannerSmall2.attr('image/height', '72');
        graph2.addCell(bannerSmall2)

    }else if(cellView.model.id == bannerMedium.id){   

        var bannerMedium2 = bannerMedium.clone();
        bannerMedium2.resize(733, 95);
        bannerMedium2.attr('image/width', '733');
        bannerMedium2.attr('image/height', '95');
        graph2.addCell(bannerMedium2)

    }else if(cellView.model.id == bannerLarge.id){   

        var bannerLarge2 = bannerLarge.clone();
        bannerLarge2.resize(265, 268);
        bannerLarge2.attr('image/width', '265');
        bannerLarge2.attr('image/height', '268');
        graph2.addCell(bannerLarge2)

    
    }else if(cellView.model.id == scrollvertical.id){   

        var scrollvertical2 = scrollvertical.clone();
        scrollvertical2.resize(28, 554);
        scrollvertical2.attr('image/width', '28');
        scrollvertical2.attr('image/height', '554');
        graph2.addCell(scrollvertical2)

    
    }else if(cellView.model.id == scrollHorizontal.id){   

        var scrollHorizontal2 = scrollHorizontal.clone();
        scrollHorizontal2.resize(557, 29);
        scrollHorizontal2.attr('image/width', '557');
        scrollHorizontal2.attr('image/height', '29');
        graph2.addCell(scrollHorizontal2)

    
    }else if(cellView.model.id == scrollH2.id){   

        var scrollH22 = scrollH2.clone();
        scrollH22.resize(28, 398);
        scrollH22.attr('image/width', '28');
        scrollH22.attr('image/height', '398');
        graph2.addCell(scrollH22)

    
    }else if(cellView.model.id == url.id){   

        var url2 = url.clone();
        url2.resize(224, 41);
        url2.attr('image/width', '224');
        url2.attr('image/height', '41');
        graph2.addCell(url2)

    
    }else if(cellView.model.id == scrollH2.id){   

        var scrollH22 = scrollH2.clone();
        scrollH22.resize(28, 398);
        scrollH22.attr('image/width', '28');
        scrollH22.attr('image/height', '398');
        graph2.addCell(scrollH22)

    
    }else if(cellView.model.id == paginacion2.id){   

        var paginacion22 = paginacion2.clone();
        paginacion22.resize(342, 53);
        paginacion22.attr('image/width', '342');
        paginacion22.attr('image/height', '53');
        graph2.addCell(paginacion22)

    
    }else if(cellView.model.id == paginacion1.id){   

        var paginacion3 = paginacion1.clone();
        paginacion3.resize(340, 36);
        paginacion3.attr('image/width', '340');
        paginacion3.attr('image/height', '36');
        graph2.addCell(paginacion3)

    
    };
    
})

/***************************************************************************************/

/******************************************Fin web******************************************************************/



/*********************************************Movil****************************************************************/
/********************************************** dispositivo**********************************************/
var graph7 = new joint.dia.Graph;
var paper7 = new joint.dia.Paper({
    el: $('.stencil_disp'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph7,
    interactive: false,
    width: 200,
    height: 230
    
});

var samsung = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 10
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/samsung.png',
            width : 70,
            height : 100
        }
    }
});


var tabVertical = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 10
    },
   
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/tabVertical.png',
            width : 100,
            height : 100
        }
    }
});


var tabHorizontal = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 120
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/tabHorizontal.png',
            width : 180,
            height : 100
        }
    }
});



graph7.addCell(samsung)
graph7.addCell(tabVertical)
graph7.addCell(tabHorizontal)
graph7.addCell(paginacion2)


paper7.$el.addClass('cursor');



paper7.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == samsung.id) {

        var samsung2 = samsung.clone();
        samsung2.resize(283, 545);
        samsung2.attr('image/width', '283');
        samsung2.attr('image/height', '545');
        graph2.addCell(samsung2)

    }else if(cellView.model.id == tabVertical.id){   

        var tabVertical2 = tabVertical.clone();
        tabVertical2.resize(413, 651);
        tabVertical2.attr('image/width', '413');
        tabVertical2.attr('image/height', '651');
        graph2.addCell(tabVertical2)

    }else if(cellView.model.id == tabHorizontal.id){   

        var tabHorizontal2 = tabHorizontal.clone();
        tabHorizontal2.resize(652, 410);
        tabHorizontal2.attr('image/width', '652');
        tabHorizontal2.attr('image/height', '410');
        graph2.addCell(tabHorizontal2)

    };

    
 
    
})

/***************************************************************************************/
/*************************************Miscelaneo******************************************/

var graph8 = new joint.dia.Graph;
var paper8 = new joint.dia.Paper({
    el: $('.stencil_misc'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph8,
    interactive: false,
    width: 200,
    height: 700
    
});

var googlenow = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 10
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/googlenow.png',
            width : 70,
            height : 30
        }
    }
});


var menuAndroid = new joint.shapes.basic.Image({
    position : {
        x : 100,
        y : 10
    },
   
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/menu.png',
            width : 70,
            height : 30
        }
    }
});


var menuAndroid2 = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 50
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/menu2.png',
            width : 180,
            height : 100
        }
    }
});

var llamada = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 170
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/llamada.png',
            width : 100,
            height : 100
        }
    }
});

var tecladoandroid = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 270
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/tecladoandroid.png',
            width : 100,
            height : 100
        }
    }
});

var teclado = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 350
    },
   
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/teclado.PNG',
            width : 100,
            height : 100
        }
    }
});

var agregarContactos = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 460
    },
   
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/agregarContactos.PNG',
            width : 100,
            height : 100
        }
    }
});
var infocontacto = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 460
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/infocontacto.PNG',
            width : 100,
            height : 100
        }
    }
});


var bandejaEntrada = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 580
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/bandejaEntrada.PNG',
            width : 100,
            height : 100
        }
    }
});
var RedactarCorreo = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 580
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/RedactarCorreo.PNG',
            width : 100,
            height : 100
        }
    }
});
var Nointernet = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 170
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/Nointernet.PNG',
            width : 100,
            height : 100
        }
    }
});


graph8.addCell(googlenow)
graph8.addCell(menuAndroid)
graph8.addCell(menuAndroid2)
graph8.addCell(llamada)
graph8.addCell(tecladoandroid)
graph8.addCell(teclado)
graph8.addCell(agregarContactos)
graph8.addCell(infocontacto)
graph8.addCell(bandejaEntrada)
graph8.addCell(RedactarCorreo)
graph8.addCell(Nointernet)


paper8.$el.addClass('cursor');



paper8.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == googlenow.id) {

        var googlenow2 = googlenow.clone();
        googlenow2.resize(326, 86);
        googlenow2.attr('image/width', '326');
        googlenow2.attr('image/height', '86');
        graph2.addCell(googlenow2)

    }else if(cellView.model.id == menuAndroid.id){   

        var menuAndroid3 = menuAndroid.clone();
        menuAndroid3.resize(216, 40);
        menuAndroid3.attr('image/width', '216');
        menuAndroid3.attr('image/height', '40');
        graph2.addCell(menuAndroid3)

    }else if(cellView.model.id == menuAndroid2.id){   

        var menuAndroid23 = menuAndroid2.clone();
        menuAndroid23.resize(329, 188);
        menuAndroid23.attr('image/width', '329');
        menuAndroid23.attr('image/height', '188');
        graph2.addCell(menuAndroid23)

    }else if(cellView.model.id == llamada.id){   

        var llamada2 = llamada.clone();
        llamada2.resize(325, 425);
        llamada2.attr('image/width', '325');
        llamada2.attr('image/height', '425');
        graph2.addCell(llamada2)

    }else if(cellView.model.id == tecladoandroid.id){   

        var tecladoandroid2 = tecladoandroid.clone();
        tecladoandroid2.resize(324, 201);
        tecladoandroid2.attr('image/width', '324');
        tecladoandroid2.attr('image/height', '201');
        graph2.addCell(tecladoandroid2)

    }else if(cellView.model.id == teclado.id){   

        var teclado2 = teclado.clone();
        teclado2.resize(324, 201);
        teclado2.attr('image/width', '324');
        teclado2.attr('image/height', '201');
        graph2.addCell(teclado2)


    }else if(cellView.model.id == agregarContactos.id){   

        var agregarContactos2 = agregarContactos.clone();
        agregarContactos2.resize(360, 531);
        agregarContactos2.attr('image/width', '360');
        agregarContactos2.attr('image/height', '531');
        graph2.addCell(agregarContactos2)

    }else if(cellView.model.id == infocontacto.id){   

        var infocontacto2 = infocontacto.clone();
        infocontacto2.resize(358, 458);
        infocontacto2.attr('image/width', '358');
        infocontacto2.attr('image/height', '458');
        graph2.addCell(infocontacto2)

    }else if(cellView.model.id == tecladoandroid.id){   

        var tecladoandroid2 = tecladoandroid.clone();
        tecladoandroid2.resize(324, 201);
        tecladoandroid2.attr('image/width', '324');
        tecladoandroid2.attr('image/height', '201');
        graph2.addCell(tecladoandroid2)

    }else if(cellView.model.id == teclado.id){   

        var teclado2 = teclado.clone();
        teclado2.resize(359, 219);
        teclado2.attr('image/width', '359');
        teclado2.attr('image/height', '219');
        graph2.addCell(teclado2)

    }else if(cellView.model.id == bandejaEntrada.id){   

        var bandejaEntrada2 = bandejaEntrada.clone();
        bandejaEntrada2.resize(359, 555);
        bandejaEntrada2.attr('image/width', '359');
        bandejaEntrada2.attr('image/height', '555');
        graph2.addCell(bandejaEntrada2)

    }else if(cellView.model.id == RedactarCorreo.id){   

        var RedactarCorreo2 = RedactarCorreo.clone();
        RedactarCorreo2.resize(359, 547);
        RedactarCorreo2.attr('image/width', '359');
        RedactarCorreo2.attr('image/height', '547');
        graph2.addCell(RedactarCorreo2)

    }else if(cellView.model.id == Nointernet.id){   

        var Nointernet2 = Nointernet.clone();
        Nointernet2.resize(359, 547);
        Nointernet2.attr('image/width', '359');
        Nointernet2.attr('image/height', '547');
        graph2.addCell(Nointernet2)

    };

    
 
    
})
/*****************************************Iconografía android*********************************************/
var graph11 = new joint.dia.Graph;
var paper11 = new joint.dia.Paper({
    el: $('.stencil_iconAndroid'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph11,
    interactive: false,
    width: 200,
    height: 180
    
});

var senal = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 5
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/senal.PNG',
            width : 47,
            height : 35
        }
    }
});


var tiempo = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 5
    },
   
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/tiempo.PNG',
           width : 47,
           height : 35
        }
    }
});



var wifi = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 5
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/wifi.PNG',
            width : 47,
            height : 35
        }
    }
});

var reloj = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 5
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/reloj.PNG',
            width : 47,
            height : 35
        }
    }
});

var favoritoicon = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 40
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/favoritoicon.PNG',
            width : 47,
            height : 35
        }
    }
});
var adjuntar = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 40
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/adjuntar.PNG',
            width : 47,
            height : 35
        }
    }
});
var advertencia = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 40
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/advertencia.PNG',
            width : 47,
            height : 35
        }
    }
});
var bluetooth = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 40
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/bluetooth.PNG',
            width : 47,
            height : 35
        }
    }
});
var camaraicon = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 75
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/camaraicon.PNG',
            width : 47,
            height : 35
        }
    }
});
var pregunta = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 75
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/pregunta.PNG',
            width : 47,
            height : 35
        }
    }
});
var confiIcon = new joint.shapes.basic.Image({
    position : {
         x : 90,
        y : 75
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/confiIcon.PNG',
            width : 47,
            height : 35
        }
    }
});

var enviar = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 75
    },
  
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/enviar.PNG',
            width : 47,
            height : 35
        }
    }
});

var llamar = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 110
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/llamar.PNG',
            width : 50,
            height : 50
        }
    }
});
var colgar = new joint.shapes.basic.Image({
    position : {
        x : 50,
        y : 110
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/colgar.PNG',
            width : 50,
            height : 50
        }
    }
});
var play = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 110
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/play.PNG',
           width : 50,
            height : 50
        }
    }
});
var stop = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 110
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/stop.PNG',
            width : 50,
            height : 50
        }
    }
});

graph11.addCell(senal)
graph11.addCell(tiempo)
graph11.addCell(wifi)
graph11.addCell(reloj)
graph11.addCell(favoritoicon)
graph11.addCell(pregunta)
graph11.addCell(llamar)
graph11.addCell(adjuntar)
graph11.addCell(advertencia)
graph11.addCell(stop)
graph11.addCell(colgar)
graph11.addCell(play)
graph11.addCell(enviar)
graph11.addCell(confiIcon)
graph11.addCell(camaraicon)
graph11.addCell(bluetooth)




paper11.$el.addClass('cursor');



paper11.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == senal.id) {

        var senal2 = senal.clone();
        senal2.resize(47, 35);
        senal2.attr('image/width', '47');
        senal2.attr('image/height', '35');
        graph2.addCell(senal2)

    }else if(cellView.model.id == tiempo.id){   

        var tiempo2 = tiempo.clone();
        tiempo2.resize(47, 35);
        tiempo2.attr('image/width', '47');
        tiempo2.attr('image/height', '35');
        graph2.addCell(tiempo2)

    }else if(cellView.model.id == wifi.id){   

        var wifi2 = wifi.clone();
        wifi2.resize(47, 35);
        wifi2.attr('image/width', '47');
        wifi2.attr('image/height', '35');
        graph2.addCell(wifi2)

    }else if(cellView.model.id == reloj.id){   

        var reloj2 = reloj.clone();
        reloj2.resize(23, 19);
        reloj2.attr('image/width', '47');
        reloj2.attr('image/height', '35');
        graph2.addCell(reloj2)

    }else if(cellView.model.id == favoritoicon.id){   

        var favoritoicon2 = favoritoicon.clone();
        favoritoicon2.resize(47, 35);
        favoritoicon2.attr('image/width', '47');
        favoritoicon2.attr('image/height', '35');
        graph2.addCell(favoritoicon2)

    }
    else if(cellView.model.id == pregunta.id){   

        var pregunta2 = pregunta.clone();
        pregunta2.resize(47, 35);
        pregunta2.attr('image/width', '47');
        pregunta2.attr('image/height', '35');
        graph2.addCell(pregunta2)

    }
    else if(cellView.model.id == llamar.id){   

        var llamar2 = llamar.clone();
        llamar2.resize(74, 70);
        llamar2.attr('image/width', '74');
        llamar2.attr('image/height', '70');
        graph2.addCell(llamar2)

    }
    else if(cellView.model.id == colgar.id){   

        var colgar2 = colgar.clone();
        colgar2.resize(74, 70);
        colgar2.attr('image/width', '74');
        colgar2.attr('image/height', '70');
        graph2.addCell(colgar2)

    }
    else if(cellView.model.id == play.id){   

        var play2 = play.clone();
        play2.resize(74, 70);
        play2.attr('image/width', '74');
        play2.attr('image/height', '70');
        graph2.addCell(play2)

    }else if(cellView.model.id == stop.id){   

        var stop2 = stop.clone();
        stop2.resize(74, 70);
        stop2.attr('image/width', '74');
        stop2.attr('image/height', '70');
        graph2.addCell(stop2)

    }else if(cellView.model.id == adjuntar.id){   

        var adjuntar2 = adjuntar.clone();
        adjuntar2.resize(47, 35);
        adjuntar2.attr('image/width', '47');
        adjuntar2.attr('image/height', '35');
        graph2.addCell(adjuntar2)

    }else if(cellView.model.id == camaraicon.id){   

        var camaraicon2 = camaraicon.clone();
        camaraicon2.resize(47, 35);
        camaraicon2.attr('image/width', '47');
        camaraicon2.attr('image/height', '35');
        graph2.addCell(camaraicon2)

    }else if(cellView.model.id == confiIcon.id){   

        var confiIcon2 = confiIcon.clone();
        confiIcon2.resize(47, 35);
        confiIcon2.attr('image/width', '47');
        confiIcon2.attr('image/height', '35');
        graph2.addCell(confiIcon2)

    }else if(cellView.model.id == enviar.id){   

        var enviar2 = enviar.clone();
        enviar2.resize(47, 35);
        enviar2.attr('image/width', '47');
        enviar2.attr('image/height', '35');
        graph2.addCell(enviar2)

    }else if(cellView.model.id == advertencia.id){   

        var advertencia2 = advertencia.clone();
        advertencia2.resize(47, 35);
        advertencia2.attr('image/width', '47');
        advertencia2.attr('image/height', '35');
        graph2.addCell(advertencia2)

    }else if(cellView.model.id == bluetooth.id){   

        var bluetooth2 = bluetooth.clone();
        bluetooth2.resize(47, 35);
        bluetooth2.attr('image/width', '47');
        bluetooth2.attr('image/height', '35');
        graph2.addCell(bluetooth2)

    };

    
 
    
})
/***************************************************************************************/

/*****************************************IOS******************************************************************/
/***********************************Dsipositivo***********************************/
var graph9 = new joint.dia.Graph;
var paper9 = new joint.dia.Paper({
    el: $('.stencil_dispios'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph9,
    interactive: false,
    width: 200,
    height: 210
    
});

var iphone = new joint.shapes.basic.Image({
    position : {
        x : 30,
        y : 10
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/iphone.png',
            width : 50,
            height : 80
        }
    }
});


var iphone2 = new joint.shapes.basic.Image({
    position : {
        x : 120,
        y : 10
    },
   
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/iphone2.png',
            width : 50,
            height : 80
        }
    }
});


var iPadVertical = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 100
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/iPadVertical.png',
            width : 180,
            height : 100
        }
    }
});



graph9.addCell(iphone)
graph9.addCell(iphone2)
graph9.addCell(iPadVertical)



paper9.$el.addClass('cursor');



paper9.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == iphone.id) {

        var iphone3 = iphone.clone();
        iphone3.resize(960, 720);
        iphone3.attr('image/width', '960');
        iphone3.attr('image/height', '720');
        graph2.addCell(iphone3)

    }else if(cellView.model.id == iphone2.id){   

        var iphone23 = iphone2.clone();
        iphone23.resize(960, 720);
        iphone23.attr('image/width', '960');
        iphone23.attr('image/height', '720');
        graph2.addCell(iphone23)

    }else if(cellView.model.id == iPadVertical.id){   

        var iPadVertical2 = iPadVertical.clone();
        iPadVertical2.resize(434, 647);
        iPadVertical2.attr('image/width', '434');
        iPadVertical2.attr('image/height', '647');
        graph2.addCell(iPadVertical2)

    };

    
 
    
})
/***************************************************************************************/
/*****************************************Iconografía*********************************************/
var graph10 = new joint.dia.Graph;
var paper10 = new joint.dia.Paper({
    el: $('.stencil_iconios'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph10,
    interactive: false,
    width: 200,
    height: 400
    
});

var camara = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 5
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/camara.png',
            width : 50,
            height : 50
        }
    }
});


var cambiarcamara = new joint.shapes.basic.Image({
    position : {
        x : 70,
        y : 5
    },
   
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/cambiarcamara.png',
            width : 50,
            height : 50
        }
    }
});




var flash = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 5
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/flash.png',
            width :50,
            height : 50
        }
    }
});

var mail = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 50
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/mail.png',
            width : 50,
            height : 50
        }
    }
});

var mensaje = new joint.shapes.basic.Image({
    position : {
        x : 70,
        y : 50
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/mensaje.png',
            width : 50,
            height : 50
        }
    }
});

var facebook = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 50
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/facebook.png',
            width : 50,
            height : 50
        }
    }
});
var twitter = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 110
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/twitter.png',
            width : 50,
            height : 50
        }
    }
});
var anadir = new joint.shapes.basic.Image({
    position : {
        x : 70,
        y : 110
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Add2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var Alarma = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 110
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Alarm2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var camaranegra = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 170
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Camera2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var ControlCenter = new joint.shapes.basic.Image({
    position : {
        x : 70,
        y : 170
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/ControlCenter2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var fav = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 170
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Favorites2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var folder = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 220
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Folder2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var heart = new joint.shapes.basic.Image({
    position : {
        x : 70,
        y : 220
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Heart2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var musica = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 280
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/MusicAlbums2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var send = new joint.shapes.basic.Image({
    position : {
        x : 70,
        y : 280
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Sent2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var iCloud = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 220
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/iCloud.PNG',
            width : 40,
            height : 40
        }
    }
});
var settings = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 280
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Settings2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var wireless = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 340
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Wireless2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var sound = new joint.shapes.basic.Image({
    position : {
        x : 70,
        y : 340
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Sound2x.PNG',
            width : 40,
            height : 40
        }
    }
});
var tone = new joint.shapes.basic.Image({
    position : {
        x : 130,
        y : 340
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/Tones2x.PNG',
            width : 40,
            height : 40
        }
    }
});



graph10.addCell(camara)
graph10.addCell(cambiarcamara)
graph10.addCell(flash)
graph10.addCell(mail)
graph10.addCell(mensaje)
graph10.addCell(facebook)
graph10.addCell(anadir)
graph10.addCell(Alarma)
graph10.addCell(camaranegra)
graph10.addCell(ControlCenter)
graph10.addCell(fav)
graph10.addCell(twitter)
graph10.addCell(folder)
graph10.addCell(heart)
graph10.addCell(iCloud)
graph10.addCell(musica)
graph10.addCell(settings)
graph10.addCell(sound)
graph10.addCell(send)
graph10.addCell(tone)
graph10.addCell(wireless)


paper10.$el.addClass('cursor');



paper10.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == camara.id) {

        var camara2 = camara.clone();
        camara2.resize(101, 41);
        camara2.attr('image/width', '101');
        camara2.attr('image/height', '41');
        graph2.addCell(camara2)

    }else if(cellView.model.id == cambiarcamara.id){   

        var cambiarcamara2 = cambiarcamara.clone();
        cambiarcamara2.resize(75, 47);
        cambiarcamara2.attr('image/width', '75');
        cambiarcamara2.attr('image/height', '47');
        graph2.addCell(cambiarcamara2)

    }else if(cellView.model.id == flash.id){   

        var flash2 = flash.clone();
        flash2.resize(85, 47);
        flash2.attr('image/width', '85');
        flash2.attr('image/height', '47');
        graph2.addCell(flash2)

    }else if(cellView.model.id == mail.id){   

        var mail2 = mail.clone();
        mail2.resize(67, 80);
        mail2.attr('image/width', '67');
        mail2.attr('image/height', '80');
        graph2.addCell(mail2)

    }else if(cellView.model.id == mensaje.id){   

        var mensaje2 = mensaje.clone();
        mensaje2.resize(67, 80);
        mensaje2.attr('image/width', '67');
        mensaje2.attr('image/height', '80');
        graph2.addCell(mensaje2)

    }else if(cellView.model.id == facebook.id){   

        var facebook2 = facebook.clone();
        facebook2.resize(63, 78);
        facebook2.attr('image/width', '63');
        facebook2.attr('image/height', '78');
        graph2.addCell(facebook2)

    }else if(cellView.model.id == twitter.id){   

        var twitter2 = twitter.clone();
        twitter2.resize(66, 82);
        twitter2.attr('image/width', '66');
        twitter2.attr('image/height', '82');
        graph2.addCell(twitter2)

    }else if(cellView.model.id == anadir.id){   

        var anadir2 = anadir.clone();
        anadir2.resize(44, 44);
        anadir.attr('image/width', '44');
        anadir2.attr('image/height', '44');
        graph2.addCell(anadir2)

    }else if(cellView.model.id == Alarma.id){   

        var Alarma2 = Alarma.clone();
        Alarma2.resize(50, 50);
        Alarma2.attr('image/width', '50');
        Alarma2.attr('image/height', '50');
        graph2.addCell(Alarma2)

    }else if(cellView.model.id == camaranegra.id){   

        var camaranegra2 = camaranegra.clone();
        camaranegra2.resize(50, 38);
        camaranegra2.attr('image/width', '50');
        camaranegra2.attr('image/height', '38');
        graph2.addCell(camaranegra2)

    }else if(cellView.model.id == ControlCenter.id){   

        var ControlCenter2 = ControlCenter.clone();
        ControlCenter2.resize(44, 58);
        ControlCenter2.attr('image/width', '44');
        ControlCenter2.attr('image/height', '58');
        graph2.addCell(ControlCenter2)

    }else if(cellView.model.id == fav.id){   

        var fav2 = fav.clone();
        fav2.resize(56, 50);
        fav2.attr('image/width', '56');
        fav2.attr('image/height', '50');
        graph2.addCell(fav2)

    }else if(cellView.model.id == folder.id){   

        var folder2 = folder.clone();
        folder2.resize(42, 34);
        folder2.attr('image/width', '42');
        folder2.attr('image/height', '34');
        graph2.addCell(folder2)

    }else if(cellView.model.id == heart.id){   

        var heart2 = heart.clone();
        heart2.resize(42, 38);
        heart2.attr('image/width', '42');
        heart2.attr('image/height', '38');
        graph2.addCell(heart2)

    }else if(cellView.model.id == musica.id){   

        var musica2 = musica.clone();
        musica2.resize(42, 38);
        musica2.attr('image/width', '42');
        musica2.attr('image/height', '38');
        graph2.addCell(musica2)

    }else if(cellView.model.id == settings.id){   

        var settings2 = settings.clone();
        settings2.resize(50, 50);
        settings2.attr('image/width', '50');
        settings2.attr('image/height', '50');
        graph2.addCell(settings2)

    }else if(cellView.model.id == iCloud.id){   

        var iCloud2 = iCloud.clone();
        iCloud2.resize(50, 50);
        iCloud2.attr('image/width', '50');
        iCloud2.attr('image/height', '50');
        graph2.addCell(iCloud2)

    }else if(cellView.model.id == send.id){   

        var send2 = send.clone();
        send2.resize(46, 44);
        send2.attr('image/width', '46');
        send2.attr('image/height', '44');
        graph2.addCell(send2)

    }else if(cellView.model.id == tone.id){   

        var tone2 = tone.clone();
        tone2.resize(44, 50);
        tone2.attr('image/width', '44');
        tone2.attr('image/height', '50');
        graph2.addCell(tone2)

    }else if(cellView.model.id == wireless.id){   

        var wireless2 = wireless.clone();
        wireless2.resize(42, 30);
        wireless2.attr('image/width', '42');
        wireless2.attr('image/height', '30');
        graph2.addCell(wireless2)

    }else if(cellView.model.id == sound.id){   

        var sound2 = sound.clone();
        sound2.resize(52, 44);
        sound2.attr('image/width', '52');
        sound2.attr('image/height', '44');
        graph2.addCell(sound2)

    };

    
 
    
})
/***************************************************************************************/
/*********************************************Miscelaneos******************************/
var graph12 = new joint.dia.Graph;
var paper12 = new joint.dia.Paper({
    el: $('.stencil_miscIos'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph12,
    interactive: false,
    width: 200,
    height: 550
    
});

var alarmaGrande = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 5
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/alarma.PNG',
            width : 100,
            height : 100
        }
    }
});


var llamadaios = new joint.shapes.basic.Image({
    position : {
        x : 90,
        y : 5
    },
   
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/llamada.PNG',
            width : 100,
            height : 100
        }
    }
});




var playlist = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 130
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/playlist.PNG',
            width :100,
            height : 100
        }
    }
});

var tecladoIos = new joint.shapes.basic.Image({
    position : {
        x : 110,
        y : 120
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/teclado.PNG',
            width : 100,
            height : 100
        }
    }
});

var tecladogrande = new joint.shapes.basic.Image({
    position : {
        x : 10,
        y : 230
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/tecladogrande.PNG',
            width : 100,
            height : 100
        }
    }
});

var password = new joint.shapes.basic.Image({
    position : {
        x : 40,
        y : 330
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/password.PNG',
            width : 100,
            height : 100
        }
    }
});
var msj = new joint.shapes.basic.Image({
    position : {
        x : 40,
        y : 440
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/msj.PNG',
            width : 100,
            height : 100
        }
    }
});
var enviarmensaje = new joint.shapes.basic.Image({
    position : {
        x : 100,
        y : 230
    },
    
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/IOS/enviarmensaje.PNG',
            width : 100,
            height : 100
        }
    }
});



graph12.addCell(llamadaios)
graph12.addCell(playlist)
graph12.addCell(tecladoIos)
graph12.addCell(tecladogrande)
graph12.addCell(password)
graph12.addCell(enviarmensaje)
graph12.addCell(msj)
graph12.addCell(alarmaGrande)





paper12.$el.addClass('cursor');



paper12.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == llamadaios.id) {

        var llamadaios2 = llamadaios.clone();
        llamadaios2.resize(327, 488);
        llamadaios2.attr('image/width', '327');
        llamadaios2.attr('image/height', '488');
        graph2.addCell(llamadaios2)

    }else if(cellView.model.id == playlist.id){   

        var playlist2 = playlist.clone();
        playlist2.resize(323, 360);
        playlist2.attr('image/width', '323');
        playlist2.attr('image/height', '360');
        graph2.addCell(playlist2)

    }else if(cellView.model.id == tecladoIos.id){   

        var tecladoIos2 = tecladoIos.clone();
        tecladoIos2.resize(326, 214);
        tecladoIos2.attr('image/width', '326');
        tecladoIos2.attr('image/height', '214');
        graph2.addCell(tecladoIos2)

    }else if(cellView.model.id == tecladogrande.id){   

        var tecladogrande2 = tecladogrande.clone();
        tecladogrande2.resize(490, 326);
        tecladogrande2.attr('image/width', '490');
        tecladogrande2.attr('image/height', '326');
        graph2.addCell(tecladogrande2)

    }else if(cellView.model.id == password.id){   

        var password2 = password.clone();
        password2.resize(327, 297);
        password2.attr('image/width', '327');
        password2.attr('image/height', '297');
        graph2.addCell(password2)

    }else if(cellView.model.id == enviarmensaje.id){   

        var enviarmensaje2 = enviarmensaje.clone();
        enviarmensaje2.resize(355, 355);
        enviarmensaje2.attr('image/width', '355');
        enviarmensaje2.attr('image/height', '355');
        graph2.addCell(enviarmensaje2)

    }else if(cellView.model.id == msj.id){   

        var msj2 = msj.clone();
        msj2.resize(336, 280);
        msj2.attr('image/width', '336');
        msj2.attr('image/height', '280');
        graph2.addCell(msj2)

    }else if(cellView.model.id == alarmaGrande.id){   

        var alarmaGrande2 = alarmaGrande.clone();
        alarmaGrande2.resize(162, 219);
        alarmaGrande2.attr('image/width', '162');
        alarmaGrande2.attr('image/height', '219');
        graph2.addCell(alarmaGrande2)

    };


});



/*****************************Funciones de cada boton del toolbar_container***********************************/

function eliminar(){

    var showAlert = swal({
            title: 'Nuevo lienzo',
            text: 'Se eliminarán todos los elementos del lienzo. ¿Realmente desea hacerlo?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#a8d76f',
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },

            function(){

                document.getElementById("draggable").style.display = "none";
                 graph2.clear();
              
            });

    
}



paper2.on('cell:pointerdown', function(cellView,evt, x, y) { 

    
    selected = cellView.model;
    $.Shortcut.on("DELETE", function (e) {
    // e is the jQuery normalized KeyEvent
    selected.remove();
    })
     
 });

function eliminarElemento(){

    
    if (selected) selected.remove();
     

}


function guardar(PrototypeId) { 

    /*Aqui paso a json los diagramas*/
    
   var jsonDiagrama=  graph2.toJSON();

   var jsonString = JSON.stringify(jsonDiagrama);

    //console.log(jsonString);
   var parameters = {

        'id'             : PrototypeId,
        'diagrama'       : jsonString,
                
    };
    //console.log(parameters);

    $.ajax({
      type: 'POST',
      url: projectURL+'/prototipo/actualizar',
      data: parameters,
      dataType: 'JSON',
      success: function (response) {

                  
          swal({
            title: 'Guardado',
            text: 'El prototipo ha sido guardado',
            type: 'success',
            confirmButtonColor: '#a8d76f',
      
          });
      
       },

      error: function (err) {
         console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
      }


    });

      // graph2.fromJSON(JSON.parse(jsonString))

}
var PrototypeId;
$(document).ready(function(){

    PrototypeId = $('#ident').attr('name');

    $.ajax({
      url: projectURL+'/prototipo/obtener/'+PrototypeId,
      type:'GET',
      dataType: 'JSON',
      success:function (response) {

        if(!response.error){

               //console.log(response['data']);

          if(response['data'] != 'NULL'){

              var  grafico= JSON.parse(response['data']);
              graph2.fromJSON(grafico);
                   

          }else{

           // console.log("there is no diagram saved")
          }
                    
        }
      },
      error: function(xhr, error) {


      }
  });      

});


var filename;

$('#btn-download').on('click', function(){

    filename = $(this).data('download');
   
  
    var svgDoc = paper2.svg;
    var serializer = new XMLSerializer();
    var svgString = serializer.serializeToString(svgDoc);
    var width= 500;
    render(svgString, width, width, filename); 


});


function render(svg, width, height, filename) {

  //document.createElement('canvas')
  var c = document.createElement('canvas');
  c.width = width || 1000;
  c.height = height || 1000;
  //document.getElementById('canvas').innerHTML = '';
  //document.getElementById('canvas').appendChild(c);

  canvg(c, svg, { log: true, renderCallback: function (dom) {
       

  var dataURL = c.toDataURL('image/png');
  //console.log(filename);
  
  link = document.getElementById('btn-download');
  link.href=  dataURL;
  link.download = filename;
  
  //  console.log(link);
       
  }});
}



function traer(){

 if (selected) selected.toFront();

}

function llevar(){

 if (selected) selected.toBack();
}

  $('#web').on('click', function(){

       
        
    $('#web').addClass('active');
    $('#movil').removeClass('active');
    $("#stencil-movil").css('display', 'none');
    $("#stencil-web").css('display', 'block');
    

      

  });

  $('#movil').on('click', function(){

     
        
    $('#movil').addClass('active');
    $('#web').removeClass('active');
    $("#stencil-web").css('display', 'none');
    $("#stencil-movil").css('display', 'block');
        

  });



var myUndoManager = new Backbone.UndoManager();
myUndoManager.register(graph2);
myUndoManager.startTracking();

$('#undo-button').on('click', function(){
   //console.log(pila);
   myUndoManager.undo();
  
});

$('#redo-button').on('click', function(){
   //console.log(pila);
   myUndoManager.redo();
  
});

$.Shortcut.on("ctrl + Z", function (e) {
    // e is the jQuery normalized KeyEvent
    myUndoManager.undo();
})

$.Shortcut.on("ctrl + Y", function (e) {
    // e is the jQuery normalized KeyEvent
    myUndoManager.redo();
})

var elemento;
graph2.on('add', function(cell) { 
     
    $.Shortcut.on("ctrl + C", function (e) {
    // e is the jQuery normalized KeyEvent
    
    elemento= cell.clone();
    })

    $.Shortcut.on("ctrl + V", function (e) {
    // e is the jQuery normalized KeyEvent
    graph2.addCell(elemento);
    })



});
 

/*cambiar titulo del diagrama*/

 $(document).on('click', '.edit-proto-info', function(e){

      $('.edit-proto-info-save').removeClass('hidden');
      $('.edit-proto-info-default').addClass('hidden');

       var protoId = $(this).data('proto'); 
      // console.log(protoId);
      

      $.ajax({
          url: projectURL+'/prototipo/obtener-prototipo-informacion/'+protoId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                var htmlTitle = '<input type="text" value="'+response.data.title+'" name="values[title]" class="question-title-'+protoId+' proto-input-name proto-input form-control">'
                $('.question-title-'+protoId).replaceWith(htmlTitle);


                

              }
          },
          error: function(xhr, error) {

          }
      });     
})

$(document).on('click', '.cancel-edit-question-info', function(e){


       var protoId = $(this).data('proto'); 
       //console.log(protoId);

       $.ajax({
          url: projectURL+'/prototipo/obtener-prototipo-informacion/'+protoId,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

              if(!response.error){

                var htmlTitle = '<div class="question-title-'+protoId+' "><span class="fc-blue-i proto-label-value">'+response.data.title+'</span></div>';
                $('.question-title-'+protoId).replaceWith(htmlTitle);

                 $('.edit-proto-info-save').addClass('hidden');
                 $('.edit-proto-info-default').removeClass('hidden');

              }
          },
          error: function(xhr, error) {

          }
      });      

    })
 
    // alde
     $(document).on('click', '.save-edit-proto-info', function(e){

       var protoId = $(this).data('proto'); 

       if($('input[name="values[title]"]').val()==''){

            $('html, body').animate({ scrollTop: 0 }, 'slow');

            if($('input[name="values[title]"]').val()==''){
              $('input[name="values[title]"]').addClass('error-proto-input');
            }                                  
            
            $('.error-alert-text').html(' Debe especificar un título para el campo indicado').parent().removeClass('hidden');


       }else{

            var parameters = {
                'values[id]'    : protoId,
                'values[title]'       : $('input[name="values[title]"]').val(),
                
            };


           $.ajax({
              url: projectURL+'/prototipo/actualizar/nombre/'+protoId,
              type:'POST',
              dataType: 'JSON',
              data: parameters,
              success:function (response) {

                  if(!response.error){

                    

                    var htmlTitle = '<div class="question-title-'+protoId+' titulo-proto"><span class="fc-blue-i proto-label-value">'+response.data.title+'</span></div>';
                    $('.question-title-'+protoId).replaceWith(htmlTitle);

                  
                    $('.edit-proto-info-save').addClass('hidden');
                    $('.edit-proto-info-default').removeClass('hidden');


                  }
              },
              error: function(xhr, error) {

              }
          });   

      }   

    })       




   





