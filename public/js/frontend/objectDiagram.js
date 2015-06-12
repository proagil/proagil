
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
    embeddingMode: true,
    
    defaultLink: function() {

       if (document.getElementById("dropdownlineas").className== "0"){

        return new joint.dia.Link;

       } else if(document.getElementById("dropdownlineas").className== "1"){

        return new joint.dia.Link({

            source: { },
            target: { },
             attrs: {
                
                '.connection': {
                    'stroke-width': 1,
                    'stroke-dasharray': [5,5],
                    stroke: 'black'
                 }
            } 

        })

      } else if (document.getElementById("dropdownlineas").className== "2"){


        return new joint.dia.Link({

            source: { },
            target: { },
             attrs: {
                
                '.marker-target': {
                    d: 'M 10 0 L 0 5 L 10 10 z'
                }
            }

         })
      } else if(document.getElementById("dropdownlineas").className== "3"){

        return new uml.Generalization;

      } else if(document.getElementById("dropdownlineas").className== "4"){

        return new uml.Aggregation;

      } else if(document.getElementById("dropdownlineas").className== "5"){

        return new uml.Composition;
      }
    
    }
});





var uml = joint.shapes.uml;


var clase = new uml.Class({  

      size: {
            width: 130,
            height: 70
        },
      position: { 

            x: 30, y: 20

        },

      attrs: {
        rect: {


        }

      },

      name: 'BloodGroup',
      attributes: ['bloodGroup: String'],
      methods: ['+ isCompatible(): Boolean']

});



var estado = new uml.State({
        size: {
            width: 120,
            height: 98
        },
        position: { 

            x: 40, y: 140

        },
        attrs : {


        '.uml-state-body': {}

         },
       name: "state 1",
       events: ["entry / init()"]
});


var textos = new joint.shapes.basic.Text({

          position: {
              x: 50,
              y: 270

          },

          size: {
              width: 100, 
              height: 50 
          },
          
          attrs: {
            text: { 

              text: "Texto",
              fill: "black",
              "font-size": 10,
               

            }
          }

                

});


var include = new joint.shapes.basic.Text({

          position: {
              x: 30,
              y: 340

          },

          size: {
              width: 70, 
              height: 20 
          },
          
          attrs: {
            text: { 

              text: "<<include>>",
              fill: "black",
              "font-size": 5,
               

            }
          }

               

});

var exclude = new joint.shapes.basic.Text({

          position: {
              x: 110,
              y: 340

          },

          size: {
              width: 70, 
              height: 20 
          },
          
          attrs: {
            text: { 

              text: "<<exclude>>",
              fill: "black",
              "font-size": 5,
               

            }
          }

               

});

var selected;
var selected2;

/*Se agregan las imagenes en el stencil*/
graph.addCell(clase)
graph.addCell(estado)
graph.addCell(textos)
graph.addCell(include)
graph.addCell(exclude)





/*Funcion que devuelve la imagen, que el usuario le dio click, al contenedor*/
paper.on('cell:pointerdown ', function(cellView,evt, x, y) { 

    if (cellView.model.id == clase.id) {


       var clase2 = clase.clone();
       clase2.attr('rect/magnet', true);
        graph2.addCell(clase2)
    
    }else if (cellView.model.id == estado.id) {

        var estado2 = estado.clone();
        estado2.attr('.uml-state-body/magnet', true);

        graph2.addCell(estado2)


    }else if(cellView.model.id == textos.id){   

        var tx = textos.clone();
         graph2.addCell(tx)

    }else if(cellView.model.id == include.id){   

        var incld = include.clone();
         graph2.addCell(incld)

    }else if(cellView.model.id == exclude.id){   

        var excld = exclude.clone();
         graph2.addCell(excld);
    };
    
})

/*Se agrega una clase a los elementos del contenedor*/
paper.$el.addClass('cursor');


// cache important html elements
var $sx = $('#sx');
var $wh = $('#wh');
var $texto = $('#texto');
var $ps = $('#ps');


$sx.on('input change', function() {
    paper2.scale(parseFloat(this.value), parseFloat(this.value));
});

$ps.on('input change', function() {
    paper2.setDimensions(parseFloat(this.value), parseFloat(this.value));
});

//Evento que permite aparecer las opciones de atributos y realizar cambios en los elementos
paper2.on('cell:pointerdown', function(cellView,evt, x, y) { 

     selected2 = cellView.model;
  
    document.getElementById("draggable").style.display = "inline";

});


$wh.on('input change', function() {
   
      
     selected2.resize(parseFloat(this.value), parseFloat(this.value));
    

});

$texto.on('input change', function() {
    
      //console.log(cellView);
     //console.log(cellView.model.attributes.type);
      //console.log(textos);

  if (selected2.attributes.type == 'uml.Class'){

    selected2.prop('name', this.value );

  }else if (selected2.attributes.type == 'basic.Text'){

    selected2.attr('text/text', this.value );

  }
  
});

//Evento  que permite desaparecer el cuadro de atributos
paper2.on('blank:pointerclick ', function(cellView,evt, x, y) { 

    document.getElementById("draggable").style.display = "none";

});


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


function guardar(objectId) { 

    /*Aqui paso a json los diagramas*/
    
   var jsonDiagrama=  graph2.toJSON();

   var jsonString = JSON.stringify(jsonDiagrama);

    //console.log(jsonString);
   var parameters = {

        'id'             : objectId,
        'diagrama'       : jsonString,
                
    };
    //console.log(parameters);

    $.ajax({
      type: 'POST',
      url: projectURL+'/diagrama-de-objetos-de-dominio/actualizar',
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

    var objectid = $('#ident').attr('name');

    $.ajax({
      url: projectURL+'/diagrama-de-objetos-de-dominio/obtener/'+objectid,
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


function exportar(){

    
  var svgDoc = paper2.svg;
  var serializer = new XMLSerializer();
  var svgString = serializer.serializeToString(svgDoc);


}











