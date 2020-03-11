import * as THREE from './node_modules/three/build/three.module.js';
import { OrbitControls } from './node_modules/three/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from './node_modules/three/examples/jsm/loaders/GLTFLoader.js';

const Render = function(el) {
    this.el = el;

    this.scene = null;
    this.camera = null;
    this.renderer = null;
    this.controls = null;
    this.loader = null;
    this.model = null;
    this.opacity = null;

    this.obj1 = null;

    this.setup = () => {
        // camera
        this.camera = new THREE.PerspectiveCamera();
        this.camera.aspect = null; // will be set dynamically
        this.camera.fov = 10;
        this.camera.near = 0.1;
        this.camera.far = 2000;
        this.camera.position.x = 0;
        this.camera.position.y = 0.2; // look from top
        this.camera.position.z = 1;

        // renderer
        this.renderer = new THREE.WebGLRenderer({ antialias: true });
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.gammaOutput = true;
        this.renderer.gammaFactor = 2.9;

        // controls
        this.controls = new OrbitControls(this.camera, this.renderer.domElement);
        this.controls.target.x = 0;
        this.controls.target.y = 0.025; // look slightly on top

        // lock axis
        //this.controls.minPolarAngle = Math.PI / 2;
        //this.controls.maxPolarAngle = Math.PI / 2;

        this.controls.autoRotate = true;
        this.controls.autoRotateSpeed = 10;
        this.controls.enableZoom = true;
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.25;
        this.controls.update();

        // scene
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0xeeeeee);
        this.scene.fog = new THREE.Fog(0xeeeeee, 2, 4);

        // ground
        let plane = new THREE.Mesh(
            new THREE.PlaneBufferGeometry(8, 8),
            new THREE.MeshPhongMaterial({ color: 0xffffff, specular: 0x101010 })
        );
        plane.rotation.x = -Math.PI / 2;
        plane.position.y = -0.01;
        this.scene.add(plane);

        // grid
        this.scene.add(new THREE.GridHelper(0.15, 24, 0x00b18b, 0xcfcfcf));

        // lights
        this.scene.add(new THREE.HemisphereLight(0xf2f2f2, 0x2b2b2b, 1));
      	this.scene.add(new THREE.DirectionalLight( 0xffffff, 0.5 ));

        // loader
        this.loader = new GLTFLoader();

        // opacity
        this.opacity = 0;

        this.setContainerDimensions();
        window.addEventListener('resize', () => {
            this.setContainerDimensions();
        });

        this.el.appendChild(this.renderer.domElement);

        this.animate();
    };

    this.animate = () => {
        requestAnimationFrame(this.animate);
        this.controls.update();
        this.renderer.render(this.scene, this.camera);
    };

    this.setContainerDimensions = () => {
        let w = this.el.clientWidth;
        let h = this.el.clientHeight;
        this.camera.aspect = w / h;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(w, h);
    };

    this.load = (filename, zoom = 1, rotate = [0, 0, 0], move = [0, 0, 0]) => {
        this.modelFadeTo(0, () => {
            this.scene.remove(this.model);
            this.loader.load(filename, gltf => {
                this.model = gltf.scene;

                // model: position
                this.model.position.x = move[0];
                this.model.position.y = move[1];
                this.model.position.z = move[2];

                // model: scale
                this.model.scale.set(zoom, zoom, zoom);

                // model: rotation
                this.model.rotateX(rotate[0] * (Math.PI / 180));
                this.model.rotateY(rotate[1] * (Math.PI / 180));
                this.model.rotateZ(rotate[2] * (Math.PI / 180));

                this.scene.add(this.model);

                this.modelFadeTo(1);
            });
        });
    };

    this.modelFadeTo = (to, fn = () => {}) => {
        if (this.model === null) {
            fn();
            return;
        }
        if (Math.round((this.opacity - to) * 1000) === 0) {
            this.opacity = to;
            this.modelSetOpacity(this.opacity);
            fn();
            return;
        }
        this.opacity += (this.opacity > to ? -1 : +1) * 0.05;
        this.modelSetOpacity(this.opacity);
        requestAnimationFrame(() => {
            this.modelFadeTo(to, fn);
        });
    };

    this.modelSetOpacity = opacity => {
        this.model.children[0].traverse(node => {
            if (node.material) {
                node.material.opacity = opacity;
                node.material.transparent = true;
            }
        });
    };
};

window.addEventListener('load', e => {
    document.querySelectorAll('.canvas').forEach(el => {
        let l = new Render(el);
        l.setup();

        let speed = 4000;
        setTimeout(() => {
            l.load('./assets/1.glb', 0.65, [0, 0, 0], [0, 0, 0]);
        }, speed * 1);
        setTimeout(() => {
            l.load('./assets/2.glb', 0.75, [180, 0, 0], [0, 0, 0.0065]);
        }, speed * 2);
        setTimeout(() => {
            l.load('./assets/3.glb', 0.25, [-90, 0, 0], [0, 0.0125, 0]);
        }, speed * 3);
        setTimeout(() => {
            l.load('./assets/4.glb', 0.1, [90, 0, 0], [0, 0, 0]);
        }, speed * 4);
        setTimeout(() => {
            l.load('./assets/5.glb', 0.75, [90, 0, 0], [0, 0.03, 0]);
        }, speed * 5);
        setTimeout(() => {
            l.load('./assets/6.glb', 1, [0, 0, 90], [0, 0, 0]);
        }, speed * 6);
        setTimeout(() => {
            l.load('./assets/7.glb', 0.4, [-90, 0, 0], [0, 0.02, 0]);
        }, speed * 7);
        setTimeout(() => {
            l.load('./assets/8.glb', 0.4, [0, 0, 90], [-0.0006, 0.018, -0.005]);
        }, speed * 8);
        setTimeout(() => {
            l.load('./assets/9.glb', 0.4, [0, 0, 180], [0, 0, 0]);
        }, speed * 9);
        setTimeout(() => {
            l.load('./assets/10.glb', 0.15, [90, 0, 0], [0, 0, 0]);
        }, speed * 10);
        setTimeout(() => {
            l.modelFadeTo(0);
        }, speed * 11);
    });
});
