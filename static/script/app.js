particlesJS('particles-js', {
  "particles": {
    "number": {
      "value": 100,
      "density": {
        "enable": true,
        "value_area": 800
      }
    },
    "color": {
      "value": "FFF" 
    },
    "shape": {
      "type": "star",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.8, 
      "random": true,
      "anim": {
        "enable": true,
        "speed": 4, 
        "opacity_min": 0, 
        "sync": false
      }
    },
    "size": {
      "value": 3,
      "random": true,
      "anim": {
        "enable": true,
        "speed": 4, 
        "size_min": 1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": false 
    },
    "move": {
      "enable": true,
      "speed": 2,
      "direction": "forward", 
      "random": true,
      "straight": false,
      "out_mode": "out",
      "bounce": true, 
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": false 
      },
      "onclick": {
        "enable": false 
      },
      "resize": true
    }
  },
  "retina_detect": true,
  "config_demo": {
    "hide_card": false,
    "background_color": "#000000", 
    "background_image": "",
    "background_position": "50% 50%",
    "background_repeat": "no-repeat",
    "background_size": "cover"
  }
});
