
var graph = new joint.dia.Graph;

var paper = new joint.dia.Paper({
    el: $('#paper'),
    width: 650,
    height: 400,
    gridSize: 20,
    model: graph,
    linkConnectionPoint: joint.util.shapePerimeterConnectionPoint
});

var image = new joint.shapes.basic.Image({
    position : {
        x : 100,
        y : 100
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
            "xlink:href" : "actor.png",
            width : 100,
            height : 100
        }
    }
});

graph.addCell(image);

graph.on('all', function(eventName, cell) {
    console.log(arguments);
});