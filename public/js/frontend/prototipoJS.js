
/* paper del stencil_container*/
var graph = new joint.dia.Graph;
var paper = new joint.dia.Paper({
    el: $('.stencil_container'),
    gridSize: 10,
    perpendicularLinks: false,
    model: graph,
    interactive: false,
    width: 200
    
});

/* paper del contenedor de las figuras*/
var graph2 = new joint.dia.Graph;
var paper2 = new joint.dia.Paper({
    el: $('.paper'),
    gridSize: 50,
    perpendicularLinks: false,
    model: graph2,
    width: 650,
    height: 650,
    embeddingMode: true
    
});



var image = new joint.shapes.basic.Image({
    position : {
        x : 30,
        y : 20
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        text: { text: 'Usuario'},
        image : {
          'xlink:href' : '/images/actor.png',
            width : 100,
            height : 100
        }
    }
});



/*Se agregan las imagenes en el stencil*/
graph.addCell(image)


var selected;
var selected2;


/*Funcion que devuelve la imagen, que el usuario le dio click, al contenedor*/
paper.on('cell:pointerdown ', function(cellView,evt, x, y) { 

   if (cellView.model.id == image.id) {

        var actor = image.clone();

        actor.attr('image/magnet', true);
        graph2.addCell(actor)

    }else if(cellView.model.id == textos.id){   

        var tx = textos.clone();
         graph2.addCell(tx)

    };

    
})

/*Se agrega una clase a los elementos del contenedor*/
paper.$el.addClass('cursor');


// cache important html elements
var $sx = $('#sx');
var $wh = $('#wh');
var $texto = $('#texto');
var $ps = $('#ps');
var $rotar = $('#rotar');
var tam;

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

$texto.on('input change', function() {

        selected2.attr('text/text', this.value );
});

$rotar.on('input change', function() {

        selected2.rotate(parseInt(this.value) );
});

//Evento  que permite desaparecer el cuadro de atributos
paper2.on('blank:pointerclick ', function(cellView,evt, x, y) { 

    document.getElementById("draggable").style.display = "none";

});
/******************************************************************************************************/

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
                   

          }
                    
        }
      },
      error: function(xhr, error) {


      }
  });      

});


/*function exportar(usecasename){

  var arrow = $(".marker-arrowhead");
  arrow.remove();

  var tool = $(".link-tools");
  tool.remove();
  
  var svgDoc = paper2.svg;
  var serializer = new XMLSerializer();
  var svgString = serializer.serializeToString(svgDoc);
//console.log(svgString);

var width= 500;
render(svgString, width, width); 

}*/





function render(svg, width, height) {

  document.createElement('canvas')
  var c = document.createElement('canvas');
  c.width = width || 1000;
  c.height = height || 1000;
  document.getElementById('canvas').innerHTML = '';
  document.getElementById('canvas').appendChild(c);

  canvg(c, svg, { log: true, renderCallback: function (dom) {
       

    var dataURL = c.toDataURL('image/png');
     //var link = document.createElement("a");
     //link.href=  dataURL;
     //link.download = 

    console.log(dataURL);
       
  }});
}


function traer(){

 if (selected) selected.toFront();

}

function llevar(){

 if (selected) selected.toBack();
}



