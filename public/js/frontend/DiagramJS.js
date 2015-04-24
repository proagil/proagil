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

// Shortcuts.
//var rect = joint.shapes.basic.Rect;
var path = joint.shapes.basic.Path;
var circle = joint.shapes.basic.Circle;
var text = joint.shapes.basic.Text;


/*joint.shapes.basic.actor = joint.shapes.basic.Generic.extend({

    markup: '<g class="rotatable"><g class="scalable"><rect/></g><image/><text/></g>',

    defaults: joint.util.deepSupplement({

        type: 'basic.actor',
        size: { width: 100, height: 100 },
        attrs: {
            
            'image': { "xlink:href" : "../../images/actor.png",
            width : 100,
            height : 100 }
        }

    }, joint.shapes.basic.Generic.prototype.defaults)
});





var usuario = new joint.shapes.basic.actor({
    position : {
        x : 30,
        y : 20
    },
    size : {
        width : 100,
        height : 100
    },
    attrs : {
        image : {
            "xlink:href" : "../../images/actor.png",
            rx: 10,
            ry: 10,
            width : 100,
            height : 100

        }
    }
});*/

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
        image : {
            "xlink:href" : "../../images/actor.png",
            width : 100,
            height : 100
        }
    }
});

var rect= new joint.shapes.basic.Rect({
        size: {
            width: 100,
            height: 98
        },
        position: { 

        	x: 30, y: 130 

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

var circle= new joint.shapes.basic.Circle({
        size: {
            width: 130,
            height: 70
        },
        position: { 

            x: 20, y: 250

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

graph.addCell(image)
graph.addCell(rect)
graph.addCell(circle)




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


paper.$el.addClass('cursor')

/*joint.dia.Link = joint.dia.Cell.extend({
    markup: ['<path class="connection" stroke="black"/>', '<path class="marker-source" fill="black" stroke="black" />', '<path class="marker-target" fill="black" stroke="black" />', '<path class="connection-wrap"/>', '<g class="labels"/>', '<g class="marker-vertices"/>', '<g class="marker-arrowheads"/>', '<g class="link-tools"/>'].join(""),
    labelMarkup: ['<g class="label">', "<rect />", "<text />", "</g>"].join(""),
    toolMarkup: ['<g class="link-tool">', '<g class="tool-remove" event="remove">', '<circle r="11" />', '<path transform="scale(.8) translate(-16, -16)" d="M24.778,21.419 19.276,15.917 24.777,10.415 21.949,7.585 16.447,13.087 10.945,7.585 8.117,10.415 13.618,15.917 8.116,21.419 10.946,24.248 16.447,18.746 21.948,24.248z"/>', "<title>Remove link.</title>", "</g>", '<g class="tool-options" event="link:options">', '<circle r="11" transform="translate(25)"/>', '<path fill="white" transform="scale(.55) translate(29, -16)" d="M31.229,17.736c0.064-0.571,0.104-1.148,0.104-1.736s-0.04-1.166-0.104-1.737l-4.377-1.557c-0.218-0.716-0.504-1.401-0.851-2.05l1.993-4.192c-0.725-0.91-1.549-1.734-2.458-2.459l-4.193,1.994c-0.647-0.347-1.334-0.632-2.049-0.849l-1.558-4.378C17.165,0.708,16.588,0.667,16,0.667s-1.166,0.041-1.737,0.105L12.707,5.15c-0.716,0.217-1.401,0.502-2.05,0.849L6.464,4.005C5.554,4.73,4.73,5.554,4.005,6.464l1.994,4.192c-0.347,0.648-0.632,1.334-0.849,2.05l-4.378,1.557C0.708,14.834,0.667,15.412,0.667,16s0.041,1.165,0.105,1.736l4.378,1.558c0.217,0.715,0.502,1.401,0.849,2.049l-1.994,4.193c0.725,0.909,1.549,1.733,2.459,2.458l4.192-1.993c0.648,0.347,1.334,0.633,2.05,0.851l1.557,4.377c0.571,0.064,1.148,0.104,1.737,0.104c0.588,0,1.165-0.04,1.736-0.104l1.558-4.377c0.715-0.218,1.399-0.504,2.049-0.851l4.193,1.993c0.909-0.725,1.733-1.549,2.458-2.458l-1.993-4.193c0.347-0.647,0.633-1.334,0.851-2.049L31.229,17.736zM16,20.871c-2.69,0-4.872-2.182-4.872-4.871c0-2.69,2.182-4.872,4.872-4.872c2.689,0,4.871,2.182,4.871,4.872C20.871,18.689,18.689,20.871,16,20.871z"/>', "<title>Link options.</title>", "</g>", "</g>"].join(""),
    vertexMarkup: ['<g class="marker-vertex-group" transform="translate(<%= x %>, <%= y %>)">', '<circle class="marker-vertex" idx="<%= idx %>" r="10" />', '<path class="marker-vertex-remove-area" idx="<%= idx %>" d="M16,5.333c-7.732,0-14,4.701-14,10.5c0,1.982,0.741,3.833,2.016,5.414L2,25.667l5.613-1.441c2.339,1.317,5.237,2.107,8.387,2.107c7.732,0,14-4.701,14-10.5C30,10.034,23.732,5.333,16,5.333z" transform="translate(5, -33)"/>', '<path class="marker-vertex-remove" idx="<%= idx %>" transform="scale(.8) translate(9.5, -37)" d="M24.778,21.419 19.276,15.917 24.777,10.415 21.949,7.585 16.447,13.087 10.945,7.585 8.117,10.415 13.618,15.917 8.116,21.419 10.946,24.248 16.447,18.746 21.948,24.248z">', "<title>Remove vertex.</title>", "</path>", "</g>"].join(""),
    arrowheadMarkup: ['<g class="marker-arrowhead-group marker-arrowhead-group-<%= end %>">', '<path class="marker-arrowhead" end="<%= end %>" d="M 26 0 L 0 13 L 26 26 z" />', "</g>"].join(""),
    defaults: {
        type: "link",
        source: {},
        target: {}
    },
    disconnect: function() {
        return this.set({
            source: g.point(0, 0),
            target: g.point(0, 0)
        })
    },
    label: function(idx, value) {
        idx = idx || 0;
        var labels = this.get("labels") || [];
        if (arguments.length === 0 || arguments.length === 1) {
            return labels[idx]
        }
        var newValue = _.merge({}, labels[idx], value);
        var newLabels = labels.slice();
        newLabels[idx] = newValue;
        return this.set({
            labels: newLabels
        })
    },
    translate: function(tx, ty, opt) {
        var attrs = {};
        var source = this.get("source");
        var target = this.get("target");
        var vertices = this.get("vertices");
        if (!source.id) {
            attrs.source = {
                x: source.x + tx,
                y: source.y + ty
            }
        }
        if (!target.id) {
            attrs.target = {
                x: target.x + tx,
                y: target.y + ty
            }
        }
        if (vertices && vertices.length) {
            attrs.vertices = _.map(vertices, function(vertex) {
                return {
                    x: vertex.x + tx,
                    y: vertex.y + ty
                }
            })
        }
        return this.set(attrs, opt)
    },
    reparent: function(opt) {
        var newParent;
        if (this.collection) {
            var source = this.collection.get(this.get("source")
                .id);
            var target = this.collection.get(this.get("target")
                .id);
            var prevParent = this.collection.get(this.get("parent"));
            if (source && target) {
                newParent = this.collection.getCommonAncestor(source, target)
            }
            if (prevParent && (!newParent || newParent.id != prevParent.id)) {
                prevParent.unembed(this, opt)
            }
            if (newParent) {
                newParent.embed(this, opt)
            }
        }
        return newParent
    },
    isLink: function() {
        return true
    },
    hasLoop: function() {
        var sourceId = this.get("source")
            .id;
        var targetId = this.get("target")
            .id;
        return sourceId && targetId && sourceId == targetId
    }
});*/



