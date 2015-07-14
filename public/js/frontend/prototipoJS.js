
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
    height: 180
    
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
        x : 40,
        y : 100
    },
    size : {
        width : 100,
        height : 100
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
        x : 40,
        y : 100
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
          'xlink:href' : '/images/wireframes/Android/tecladoandroid.png',
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

        var llamada2 = llamada2.clone();
        llamada2.resize(325, 425);
        llamada2.attr('image/width', '325');
        llamada2.attr('image/height', '425');
        graph2.addCell(llamada2)

    }else if(cellView.model.id == tecladoandroid.id){   

        var tecladoandroid2 = menuAndroid2.clone();
        tecladoandroid2.resize(324, 201);
        tecladoandroid2.attr('image/width', '324');
        tecladoandroid2.attr('image/height', '201');
        graph2.addCell(tecladoandroid2)

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
    height: 180
    
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

graph10.addCell(camara)
graph10.addCell(cambiarcamara)
graph10.addCell(flash)
graph10.addCell(mail)
graph10.addCell(mensaje)
graph10.addCell(facebook)
graph10.addCell(twitter)


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

    };

    
 
    
})
/***************************************************************************************/





/*****************************Funciones de cada boton del toolbar_container***********************************/

function eliminar(){

    graph2.clear();
    document.getElementById("draggable").style.display = "none";
}



paper2.on('cell:pointerdown', function(cellView,evt, x, y) { 

    
    selected = cellView.model;

     
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

             
      
       },

      error: function (err) {
         console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
      }


    });

      // graph2.fromJSON(JSON.parse(jsonString))

}

$(document).ready(function(){

    var PrototypeId = $('#ident').attr('name');

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

            console.log("there is no diagram saved")
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
  console.log(filename);
  
  link = document.getElementById('btn-download');
  link.href=  dataURL;
  link.download = filename;
  
    console.log(link);
       
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
