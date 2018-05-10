

function table(x,z){
  var manager = new THREE.LoadingManager();
  var textureLoader = new THREE.TextureLoader( manager );
  var texture = textureLoader.load( 'js/Objet/table & chair/tabel & chair0036.jpg' );

  var loader = new THREE.OBJLoader( manager );
  loader.load( 'js/Objet/table & chair/3.obj', function ( object ) {
    object.traverse( function ( child ) {
      if ( child instanceof THREE.Mesh ) {
        child.material.map = texture;
      }
    } );
    object.position.y = 0;
    object.position.z = z;
    object.position.x = x;
    object.receiveShadow = true;
    object.rotation.y = Math.PI/2
    object.scale.set(0.09,0.09,0.09);
    scene.add( object );
  });
}

function woodBarX(x,z){
  var manager = new THREE.LoadingManager();
  manager.onProgress = function ( item, loaded, total ) {
    console.log( item, loaded, total );
  };
  var textureLoader = new THREE.TextureLoader( manager );
  var texture = textureLoader.load( 'js/textures/parquet.jpg' );

  var loader = new THREE.OBJLoader( manager );
  loader.load( 'js/Objet/woodBar.obj', function ( object ) {
    object.traverse( function ( child ) {
      if ( child instanceof THREE.Mesh ) {
        child.material.map = texture;
      }
    } );
    object.position.y = 0;
    object.position.z = z;
    object.position.x = x;
    object.receiveShadow = true;
    object.castShadow = true;            // default false
    object.scale.set(0.007,0.007,0.007);
    scene.add( object );
  });
}


function caisse(){
  var loader = new THREE.FBXLoader();
  loader.load( 'js/Objet/Comptoir/Caisse.fbx', function ( object ) {
    object.traverse( function ( child ) {
      if ( child.isMesh ) {
        child.castShadow = true;
        child.receiveShadow = true;
      }
    } );
    object.position.z = 80;
    object.position.x = 0;
    object.receiveShadow = true;
    object.castShadow = true;            // default false
    object.scale.set(0.08,0.08,0.08);
    scene.add( object );
  } )
}


function caisse2 () {
  var manager = new THREE.LoadingManager();
  manager.onProgress = function ( item, loaded, total ) {
    console.log( item, loaded, total );
  };
  var loader = new THREE.OBJLoader( manager );
  loader.load( 'js/Objet/bar/bar.obj', function ( object ) {
    object.traverse( function ( child ) {

    } );
    object.position.z = 78;
    object.position.x = -5;
    object.rotation.y = 2*Math.PI/2;
    object.scale.set(0.007,0.007,0.007);
    object.receiveShadow = true;
    object.castShadow = true;            // default false
    scene.add( object );
  })
}

function fauteuil (x,z) {
  var manager = new THREE.LoadingManager();
  manager.onProgress = function ( item, loaded, total ) {
    console.log( item, loaded, total );
  };
  var loader = new THREE.OBJLoader( manager );
  loader.load( 'js/Objet/fauteil/divani.obj', function ( object ) {
    object.traverse( function ( child ) {

    } );
    object.position.z = z;
    object.position.x = x;
    object.scale.set(0.007,0.009,0.009);
    object.receiveShadow = true;
    object.castShadow = true;            // default false
    scene.add( object );
  })
}

function lamp(x,z){
  var sphere = new THREE.SphereBufferGeometry( 0.5, 16, 8 );
  sphere.castShadow = true; //default is false
  var light1 = new THREE.PointLight( 0xfcfcfc, 0.4, 70 );
  light1.add( new THREE.Mesh( sphere, new THREE.MeshBasicMaterial( { color: 0xfcfcfc } ) ) );
  light1.castShadow = true;            // default false
  light1.position.x = x
  light1.position.z = z
  light1.position.y = 25
  scene.add( light1 );
}