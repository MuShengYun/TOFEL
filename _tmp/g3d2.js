"use strict";
var a = 0;
var b = 0;
var d = 0;
var _col_i = 0;
var aLoc, bLoc,dLoc;
var rotationMatrix;
var rotationMatrixLoc;
var canvas;
var gl;
var trackingMouse = false;
var trackballMove = false;
var useTrack = false;
var lastPos = [0, 0, 0];
var curx, cury;
var startX, startY;
var NumVertices  = 0;

var points = [];
var colors = [];


var angle = 1;
var  axis = [1,0,0];
var xaxis = [1,0,0,0];
var yaxis = [0,1,0,0];
var zaxis = [0,0,1,0];
//var theta = [ 0, 0, 0 ];

//var thetaLoc;
function trackballView(x, y) {
    if (useTrack) {
        var d, a;
        var v = [];

        v[0] = x;
        v[1] = y;

        d = v[0] * v[0] + v[1] * v[1];
        if (d < 1.0)
            v[2] = Math.sqrt(1.0 - d);
        else {
            v[2] = 0.0;
            a = 1.0 / Math.sqrt(d);
            v[0] *= a;
            v[1] *= a;
        }
    }
    else v = [0,0];
    return v;
}

function mouseMotion(x, y) {
    if (useTrack) {
        var dx, dy, dz;

        var curPos = trackballView(x, y);
        if (trackingMouse) {
            dx = curPos[0] - lastPos[0];
            dy = curPos[1] - lastPos[1];
            dz = curPos[2] - lastPos[2];

            if (dx || dy || dz) {
                angle = 0.3 * Math.sqrt(dx * dx + dy * dy + dz * dz);


                axis[0] = lastPos[1] * curPos[2] - lastPos[2] * curPos[1];
                axis[1] = lastPos[2] * curPos[0] - lastPos[0] * curPos[2];
                axis[2] = lastPos[0] * curPos[1] - lastPos[1] * curPos[0];

                lastPos[0] = curPos[0];
                lastPos[1] = curPos[1];
                lastPos[2] = curPos[2];
            }
        }
        render();
    }
}

function startMotion(x, y) {
    if(useTrack){
        trackingMouse = true;
        startX = x;
        startY = y;
        curx = x;
        cury = y;

        lastPos = trackballView(x, y);
        trackballMove = true;
    }
}

function stopMotion(x, y) {
    if (useTrack) {
        trackingMouse = false;

        angle = 0.0;
        trackballMove = false;
    }
}
window.onload = function init()
{
    canvas = document.getElementById( "gl-canvas" );

    gl = WebGLUtils.setupWebGL( canvas );
    if ( !gl ) { alert( "WebGL isn't available" ); }

    colorCube();

    gl.viewport( 0, 0, canvas.width, canvas.height );
    gl.clearColor( 1.0, 0.9, 0.9, 1.0 );

    gl.enable(gl.DEPTH_TEST);

    //
    //  Load shaders and initialize attribute buffers
    //
    var program = initShaders( gl, "vertex-shader", "fragment-shader" );
    gl.useProgram( program );

    var cBuffer = gl.createBuffer();
    gl.bindBuffer( gl.ARRAY_BUFFER, cBuffer );
    gl.bufferData( gl.ARRAY_BUFFER, flatten(colors), gl.STATIC_DRAW );

    var vColor = gl.getAttribLocation( program, "vColor" );
    gl.vertexAttribPointer( vColor, 4, gl.FLOAT, false, 0, 0 );
    gl.enableVertexAttribArray( vColor );

    var vBuffer = gl.createBuffer();
    gl.bindBuffer( gl.ARRAY_BUFFER, vBuffer );
    gl.bufferData( gl.ARRAY_BUFFER, flatten(points), gl.STATIC_DRAW );


    var vPosition = gl.getAttribLocation( program, "vPosition" );
    gl.vertexAttribPointer( vPosition, 4, gl.FLOAT, false, 0, 0 );
    gl.enableVertexAttribArray( vPosition );
  
   // thetaLoc = gl.getUniformLocation(program, "theta");
         aLoc = gl.getUniformLocation(program, "a");
    dLoc = gl.getUniformLocation(program, "d");
   bLoc = gl.getUniformLocation(program, "b");
    //event listeners for buttons
    rotationMatrix = mat4();
    rotationMatrixLoc = gl.getUniformLocation(program, "r");
    gl.uniformMatrix4fv(rotationMatrixLoc, false, flatten(rotationMatrix));
    canvas.addEventListener("mousedown", function (event) {
    
            var x = 2 * event.clientX / canvas.width - 1;
            var y = 2 * (canvas.height - event.clientY) / canvas.height - 1;
            startMotion(x, y);
         

    });

    canvas.addEventListener("mouseup", function (event) {
            useTrack = true;
            var x = 2 * event.clientX / canvas.width - 1;
            var y = 2 * (canvas.height - event.clientY) / canvas.height - 1;
            stopMotion(x, y);


    });

    canvas.addEventListener("mousemove", function (event) {
        
            var x = 2 * event.clientX / canvas.width - 1;
            var y = 2 * (canvas.height - event.clientY) / canvas.height - 1;
            mouseMotion(x, y);
       
    });
    document.getElementById( "xButton" ).onclick = function () {
        useTrack = false;
        axis = [1, 0, 0];
        angle = 1;
        
    };
    document.getElementById("stopButton").onclick = function () {
        useTrack = true;
        axis = [1, 1,0 ];
        angle = 0;
       
    };

    document.getElementById( "yButton" ).onclick = function () {
        useTrack = false;
        axis = [0, 1, 0];
        angle = 1;
       
    };
    document.getElementById( "zButton" ).onclick = function () {
        useTrack = false;
        axis = [0, 0, 1];
        angle =1 ;
        
    };

    document.getElementById("lrButton").onclick = function(){
        useTrack = false;
        axis[0] = xaxis[0];
        axis[1] = xaxis[1];
        axis[2] = xaxis[2];
        angle = 1;
    }

    document.getElementById("udButton").onclick = function(){
        useTrack = false;
        axis[0] = yaxis[0];
        axis[1] = yaxis[1];
        axis[2] = yaxis[2];
        angle = 1;
    }

    document.getElementById("turnButton").onclick = function(){
        useTrack = false;
        axis[0] = zaxis[0];
        axis[1] = zaxis[1];
        axis[2] = zaxis[2];
        angle = 1;
    }
    window.onkeydown = function (ev) {
        var ev = ev || window.event;
        switch (ev.keyCode) {
            case 39:
                a=a+0.01;
                break;
            case 38:
                b=b+0.01;
                break;
            case 40:
                b=b-0.01;
                break;
            case 37:
                a=a-0.01;
                break;
            case 49:
                a = a+xaxis[0]*0.02;
                b = b+xaxis[1]*0.02;
                d = d+xaxis[3]*0.02;
                break;
            case 50:
                a = a-xaxis[0]*0.02;
                b = b-xaxis[1]*0.02;
                d = d-xaxis[3]*0.02;
                break;
        }
    };
    render();
}

function _cube(y, o, h, a, n, e, _, __) {
    quad(y, o, h, a);
    quad(n, e, _, __);
    quad(y, o, e, n); quad(o, h, _, e);
    quad(h, a, __, _); quad(a, y, n, __);
}

var _head_color = [Math.random(), Math.random(), Math.random(), 1.0];
var _hand_color = [Math.random(), Math.random(), Math.random(), 1.0];
var _feet_color = [Math.random(), Math.random(), Math.random(), 1.0];
var _color = [
    [0.0, 0.0, 0.0, 1.0],
    _head_color,
    _head_color,
    _head_color,
    [.976, .935, 0.891, 1.0],
    _head_color,
    [0.7, 0.0, 0.7, 1.0],
    [0.7, 0.0, 0.7, 1.0],
    [0.7, 0.0, 0.7, 1.0],
    [0.7, 0.0, 0.7, 1.0],
    _hand_color,  _hand_color,
    _hand_color,  _hand_color,
    _hand_color,  _hand_color,
    _hand_color,  _hand_color,
    _hand_color,  _hand_color,
    _hand_color,  _hand_color,
    _feet_color,  _feet_color,
    _feet_color,  _feet_color,
    _feet_color,  _feet_color,
    _feet_color,  _feet_color,
    _feet_color,  _feet_color,
    _feet_color,  _feet_color,
    [0.0, 0.0, 0.0, 1.0],
    [0.0, 0.0, 0.0, 1.0],
    [0.0, 0.0, 0.0, 1.0],
    [0.0, 0.0, 0.0, 1.0],
    [0.0, 0.0, 0.0, 1.0],
    // [0.0, 0.0, 0.0, 1.0],

];

function colorCube()
{
    // quad( 8, 9, 10, 11 );
    quad( 0, 1, 2, 3 );
    quad( 4, 5, 6, 7 );
    quad( 0, 1, 5, 4 );
    quad( 1, 2, 6, 5 );
    quad( 2, 3, 7, 6 );
    quad( 3, 0, 4, 7 );
    quad( 8, 9, 13, 32 );
    quad( 9, 10, 14, 13 );
    quad( 10, 11, 39, 14 );
    quad( 11, 8, 12, 15 );
    _cube(16, 17, 18, 19, 20, 21, 22, 23);
    _cube(24, 25, 26, 27, 28, 29, 30, 31);
    _cube(32, 33, 34, 12, 35, 36, 37, 38);
    _cube(39, 40, 41, 15, 42, 43, 44, 45);
    quad( 35, 42, 45, 38 );
    quad( 32, 13, 14, 39 );
    quad( 46, 47, 48, 49 );
    quad( 50, 51, 52, 53 );
    quad( 54, 55, 56, 57 );
    quad( 58, 59, 60, 61 );
    quad( 60, 62, 63, 64 );
    quad( 63, 65, 66, 67 );
    quad( 67, 68, 69, 70 );
    quad( 69, 71, 72, 73 );
    quad( 74, 75, 76, 77 );
    quad( 74, 78, 79, 80 );
    quad( 81, 82, 83, 84 );
    quad( 85, 86, 87, 88 );
    quad( 89, 90, 91, 92 );
    quad( 93, 94, 95, 96 );
    quad( 91, 96, 97, 98 );
}

function quad(a, b, c, d)
{
    var vertices = [
        vec4( -0.3, -0.3,  0.0, 1.0 ),
        vec4( -0.3,  0.3,  0.0, 1.0 ),
        vec4(  0.3,  0.3,  0.0, 1.0 ),
        vec4(  0.3, -0.3,  0.0, 1.0 ),
        vec4( -0.3, -0.3,  0.6, 1.0 ),
        vec4( -0.3,  0.3,  0.6, 1.0 ),
        vec4(  0.3,  0.3,  0.6, 1.0 ),
        vec4(  0.3, -0.3,  0.6, 1.0 ),
        vec4(  .2,  .2,   0,  1.0),
        vec4( -.2,  .2,   0,  1.0),
        vec4( -.2, -.2,   0,  1.0), // 10
        vec4(  .2, -.2,   0,  1.0), // 11
        vec4(  .2,  .2, -.3,  1.0), // 12
        vec4( -.2,  .2, -.4,  1.0), // 13
        vec4( -.2, -.2, -.4,  1.0), // 14
        vec4(  .2, -.2, -.3,  1.0), // 15

        vec4(  .2,  .2, -.1,  1.0),
        vec4(  .2,  .2, -.2,  1.0),
        vec4(  .2,  .3, -.2,  1.0),
        vec4(  .2,  .3, -.1,  1.0),
        vec4(  .1,  .2, -.1,  1.0),
        vec4(  .1,  .2, -.2,  1.0),
        vec4(  .1,  .3, -.2,  1.0),
        vec4(  .1,  .3, -.1,  1.0),

        vec4(  .2, -.2, -.1,  1.0),
        vec4(  .2, -.2, -.2,  1.0),
        vec4(  .2, -.3, -.2,  1.0),
        vec4(  .2, -.3, -.1,  1.0),
        vec4(  .1, -.2, -.1,  1.0),
        vec4(  .1, -.2, -.2,  1.0),
        vec4(  .1, -.3, -.2,  1.0),
        vec4(  .1, -.3, -.1,  1.0),

        vec4(  .2,  .2, -.4,  1.0), // 32
        vec4(  .3,  .2, -.4,  1.0), // 33
        vec4(  .3,  .2, -.3,  1.0), // 34
        vec4(  .2,  .1, -.4,  1.0), // 35
        vec4(  .3,  .1, -.4,  1.0), // 36
        vec4(  .3,  .1, -.3,  1.0), // 37
        vec4(  .2,  .1, -.3,  1.0), // 38

        vec4(  .2, - .2, -.4,  1.0), // 39
        vec4(  .3, - .2, -.4,  1.0), // 40
        vec4(  .3, - .2, -.3,  1.0), // 41
        vec4(  .2, - .1, -.4,  1.0), // 42
        vec4(  .3, - .1, -.4,  1.0), // 43
        vec4(  .3, - .1, -.3,  1.0), // 44
        vec4(  .2, - .1, -.3,  1.0), // 45

        vec4(  .301,  .1,  .4,  1.0),
        vec4(  .301,  .2,  .4,  1.0),
        vec4(  .301,  .2,  .5,  1.0),
        vec4(  .301,  .1,  .5,  1.0),

        vec4(  .301, -.1,  .4,  1.0),
        vec4(  .301, -.2,  .4,  1.0),
        vec4(  .301, -.2,  .5,  1.0),
        vec4(  .301, -.1,  .5,  1.0),

        vec4(  .301,  .2,  .2,  1.0),
        vec4(  .301, -.2,  .2,  1.0),
        vec4(  .301, -.2,  .1,  1.0),
        vec4(  .301,  .2,  .1,  1.0),

        vec4( .21, .08, -.05, 1.0), // 58
        vec4( .21, .15, -.05, 1.0),
        vec4( .21, .15, -.07, 1.0),
        vec4( .21, .08, -.07, 1.0),
        vec4( .21, .15, -.15, 1.0),
        vec4( .21, .13, -.15, 1.0),
        vec4( .21, .13, -.07, 1.0),
        vec4( .21, .13, -.13, 1.0),
        vec4( .21, .08, -.13, 1.0),
        vec4( .21, .08, -.15, 1.0),
        vec4( .21, .10, -.15, 1.0),
        vec4( .21, .10, -.23, 1.0),
        vec4( .21, .08, -.23, 1.0),
        vec4( .21, .15, -.23, 1.0),
        vec4( .21, .15, -.21, 1.0),
        vec4( .21, .10, -.21, 1.0),

        vec4( .21, .015, -.05, 1.0), // 74
        vec4( .21, -.035, -.05, 1.0),
        vec4( .21, -.035, -.07, 1.0),
        vec4( .21, .015, -.07, 1.0),
        vec4( .21, .035, -.05, 1.0),
        vec4( .21, .035, -.23, 1.0),
        vec4( .21, .015, -.23, 1.0),
        vec4( .21, .015, -.13, 1.0), // 81
        vec4( .21, -.035, -.13, 1.0),
        vec4( .21, -.035, -.15, 1.0),
        vec4( .21, .015, -.15, 1.0),
        vec4( .21, .015, -.21, 1.0), // 85
        vec4( .21, -.035, -.21, 1.0),
        vec4( .21, -.035, -.23, 1.0),
        vec4( .21, .015, -.23, 1.0),

        vec4( .21, -.08, -.05, 1.0), //89
        vec4( .21, -.10, -.05, 1.0),
        vec4( .21, -.10, -.23, 1.0),
        vec4( .21, -.08, -.23, 1.0),

        vec4( .21, -.15, -.05, 1.0), //93
        vec4( .21, -.17, -.05, 1.0),
        vec4( .21, -.17, -.23, 1.0),
        vec4( .21, -.15, -.23, 1.0),
        vec4( .21, -.15, -.21, 1.0),
        vec4( .21, -.10, -.21, 1.0),


    ];

    var vertexColors = [
        [ 0.0, 0.0, 0.0, 1.0 ],  // black
        [ 1.0, 0.0, 0.0, 1.0 ],  // red
        [ 1.0, 1.0, 0.0, 1.0 ],  // yellow
        [ 0.0, 1.0, 0.0, 1.0 ],  // green
        [ 0.0, 0.0, 1.0, 1.0 ],  // blue
        [ 1.0, 0.0, 1.0, 1.0 ],  // magenta
        [ 0.0, 1.0, 1.0, 1.0 ],  // cyan
        [ 1.0, 1.0, 1.0, 1.0 ]   // white
    ];
    var RNDColor;
    if (_col_i < _color.length)
        RNDColor = _color[_col_i++];
    else
        RNDColor = [0.0, 0.0, 0.0, 0.1];
    // We need to parition the quad into two triangles in order for
    // WebGL to be able to render it.  In this case, we create two
    // triangles from the quad indices

    //vertex color assigned by the index of the vertex

    var indices = [ a, b, c, a, c, d ];

    for ( var i = 0; i < indices.length; ++i ) {
        points.push( vertices[indices[i]] );
        //colors.push( vertexColors[indices[i]] );

        // for solid colored faces use
        colors.push(RNDColor);

    }
    NumVertices += 6;
}

function render()
{
    gl.clear( gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
    
    
  //  gl.uniform3fv(thetaLoc, theta);
    gl.uniform1f(aLoc, a);
    gl.uniform1f(bLoc, b);
  gl.uniform1f(dLoc, d);
  
    axis = normalize(axis);
    xaxis = multv(xaxis,rotate(angle,axis));
    // console.log(xaxis[0],xaxis[1],xaxis[2]);
    yaxis = multv(yaxis,rotate(angle,axis));
    // console.log(yaxis[0],yaxis[1],yaxis[2]);
    zaxis = multv(zaxis,rotate(angle,axis));
    // console.log(zaxis[0],zaxis[1],zaxis[2]);
    rotationMatrix = mult(rotationMatrix, rotate(angle, axis));
    gl.uniformMatrix4fv(rotationMatrixLoc, false, flatten(rotationMatrix));

    gl.drawArrays(gl.TRIANGLES, 0, NumVertices);


    requestAnimFrame( render );
}

function multv( u, v )
{
    var result = [];

    if ( u.length != v.length ) {
        throw "mult(): vectors are not the same dimension";
    }else {
        for ( var i = 0; i < v.length; ++i ) {
            var sum = 0.0;
            for ( var k = 0; k < u.length; ++k ) {
                sum += u[k] * v[k][i];
            }
            result.push( sum );
        }
    }
        return result;
}
