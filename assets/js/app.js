/*
 *   Copyright (c) 2020
 *   All rights reserved.
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';

// JS import
import FOG from 'vanta/src/vanta.fog';
import * as THREE from 'three';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});

// Vanta.js Fog Design
const effect = FOG({
    el: "#home-background",
    // Effect options here
    mouseControls: true,
    touchControls: true,
    gyroControls: false,
    minHeight: 200.00,
    minWidth: 200.00,
    highlightColor: 0x9500ff,
    blurFactor: 0.66,
    speed: 2.00,
    zoom: 1.50,
    // Three.js is defined
    THREE: THREE
});