
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
      }
        
    
    
    }
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
          'xlink:href' : '../../images/actor.png',
            width : 100,
            height : 100
        }
    }
});

var circle= new joint.shapes.basic.Circle({
        size: {
            width: 130,
            height: 70
        },
        position: { 

            x: 20, y: 165

        },
        attrs: {
            circle: {
                rx: 10,
                ry: 10,
                width: 800,
                height: 800,
                fill: "#ffffff",

                
            },
            text: {
                text: "Uso",
                fill: "black",
                "font-size": 10,
                stroke: "#000000",
                "stroke-width": 0,

            }
        }
});

var rect= new joint.shapes.basic.Rect({
        size: {
            width: 100,
            height: 98
        },
        position: { 

        	x: 35, y: 270 

        },
        attrs: {
            rect: {
                rx: 10,
                ry: 10,
                width: 800,
                height: 800,
                fill: "#ffffff",
                
                
            },
            text: {
                text: "cuadrado",
                fill: "#000000",
                "font-size": 10,
                stroke: "#000000",
                "stroke-width": 0,
                
            }
        }
});



/*Se agregan las imagenes en el stencil*/
graph.addCell(image)
graph.addCell(rect)
graph.addCell(circle)



/*Funcion que devuelve la imagen, que el usuario le dio click, al contenedor*/
paper.on('cell:pointerdown ', function(cellView,evt, x, y) { 

    if (cellView.model.id == rect.id) {


       var rect2 = rect.clone();
       rect2.attr('rect/magnet', true);
        graph2.addCell(rect2)
    
    }else if (cellView.model.id == circle.id) {

        var circle2 = circle.clone();
        circle2.attr('circle/magnet', true);

        graph2.addCell(circle2)

    }else if (cellView.model.id == image.id) {

        var actor = image.clone();

        actor.attr('image/magnet', true);
        graph2.addCell(actor)

    };

    
})

/*Se agrega una clase a los elementos del contenedor*/
paper.$el.addClass('cursor');


// cache important html elements
var $sx = $('#sx');
var $wh = $('#wh');
var $texto = $('#texto');



$sx.on('input change', function() {
    paper2.scale(parseFloat(this.value), parseFloat(this.value));
});




paper2.on('cell:pointerclick ', function(cellView,evt, x, y) { 

//Primero cuando le de click va a parecer el cuadro de atributos para luego cuando haga cambios solo se haga en ese elemento

    document.getElementById("draggable").style.display = "inline";

    $wh.on('input change', function() {

     
     cellView.model.resize(parseFloat(this.value), parseFloat(this.value));


    });

    $texto.on('input change', function() {

        cellView.model.attr('text', this.value );
    });


});

paper2.on('blank:pointerclick ', function(cellView,evt, x, y) { 

//Primero cuando le de click va a parecer el cuadro de atributos para luego cuando haga cambios solo se haga en ese elemento

    document.getElementById("draggable").style.display = "none";

});

/*Funciones de cada boton del toolbar_container*/
function eliminar(){

    graph2.clear();
    document.getElementById("draggable").style.display = "none";
}

  function eliminarElemento(){

     paper2.on('cell:pointerdown', function(cellView,evt, x, y) { 

        cellView.model.id.remove();
     
   });

}

   /* function guardar($id){

       $conexion = pg_connect("host=localhost dbname=proagil_db user=postgres password=root")
       or die('Could not connect: ' . pg_last_error());

        $consulta="SELECT * FROM use_diagram WHERE id_project=".$id;



        $resultado=pg_query($conexion,$consulta) or die (mysql_error()); 

        if (pg_num_rows($resultado)) { 

            $query = "INSERT INTO use_diagram (id_project, diagrama)
                      VALUES ('$id', '$jsonString')";

           $result= pg_query($conexion,$query);

        }else{

            $query = "UPDATE use_diagram 
                      SET diagrama = '$jsonString'
                      WHERE id_project = $id";
                      
             $result= pg_query($conexion,$query);
        }
       
    
 
    pg_close($conexion);
    

    }*/




       

function guardar(use_caseId) { 

    /*Aqui paso a json los diagramas*/
    
    var jsonDiagrama=  graph2.toJSON();

    var jsonString = JSON.stringify(jsonDiagrama);

    //console.log(jsonString);
     var parameters = {

        'id'             : use_caseId,
        'diagrama'       : jsonString,
                
    };
    //console.log(parameters);

 

       $.ajax({
            type: 'POST',
            url: projectURL+'/diagrama-de-casos-de-uso/actualizar',
            data: parameters,
            dataType: 'JSON',
            success: function (response) {

              //console.log(response); 
      
            },

            error: function (err) {
                console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            }


        });

      // graph2.fromJSON(JSON.parse(jsonString))

}

$(document).ready(function(){

    var use_caseid = $('#ident').attr('name');

      

       //console.log(use_caseid);

       $.ajax({
          url: projectURL+'/diagrama-de-casos-de-uso/obtener/'+use_caseid,
          type:'GET',
          dataType: 'JSON',
          success:function (response) {

             

              if(!response.error){

               console.log(response['data']);

               if(response['data']!= 'NULL'){

                   var  grafico= JSON.parse(response['data']);
                   graph2.fromJSON(grafico);
                   // graph2.clear();  
                   // graph2.fromJSON(response['data']);   
                   // graph2.fromJSON(JSON.parse(response['data']));

                  

              }
               }
          },
          error: function(xhr, error) {


          }
      });      

});







