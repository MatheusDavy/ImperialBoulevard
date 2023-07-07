// FUNÇÕES/MÓDULOS SITE
import initCarousel from '../modules/initCarousel';

initCarousel();

/*------------ 0 - Const / Variable ---------------*/


/*------------  1 - Classes ---------------*/
class AnimationGradient {
    constructor() {

        //Create scene     
        this.canvas = document.querySelector("canvas");
        this.context = this.canvas.getContext("2d");

        //Circles/Balss properties     
        this.circlesNum = 3;
        this.minRadius = 100;
        this.maxRadius = 100;
        this.speed = 0.009;
        this.fills = '#D2A671';

        (window.onresize = () => {
            this.setCanvasSize();
            this.createCircles();
        })();

        this.drawAnimation();

    }

    setCanvasSize() {
        this.width = this.canvas.width = window.innerWidth;
        this.height = this.canvas.height = window.innerHeight;
    }

    createCircles() {
        this.context.filter = 'blur(97px)';
        this.circles = [];


        //This will create a circles (it will pass the properties to  "new Circle")
        for (let i = 0; i < this.circlesNum; i++) {
            const { width, height, minRadius, maxRadius, fills } = this;
            this.circles.push(new Circle({ width, height, minRadius, maxRadius, fills }))
        }
    }

    drawCircles() {
        this.circles.forEach((circle) => circle.draw(this.context, this.speed));
    }

    drawAnimation() {
        this.clearCanvas();
        this.drawCircles();
        window.requestAnimationFrame(() => this.drawAnimation());
    }

    clearCanvas() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
}
class Circle {
    constructor({ width, height, minRadius, maxRadius, fills }) {
        this.fills = fills
        this.x = Math.random() * width;
        this.y = Math.random() * height;
        this.radius = Math.random() * (maxRadius - minRadius) + minRadius;
        this.angle = Math.random() * 2 * Math.PI;
    }

    draw(context, speed) {
        this.angle += speed;

        const x = this.x + Math.cos(this.angle) * 200;
        const y = this.y + Math.sin(this.angle) * 200;

        context.fillStyle = this.fills;
        context.beginPath();
        context.arc(x, y, this.radius, 0, 2 * Math.PI);
        context.fill();
    }
}

/*------------ 2 - Functions ---------------*/
function animateSVG(element) {
    anime({
        targets: `${element} path`,
        strokeDashoffset: [anime.setDashoffset, 0],
        easing: 'easeInOutSine',
        duration: 2000,
        delay: 0,
        loop: false
    });

    anime({
        targets: element,
        easing: 'easeInOutSine',
        duration: 1000,
        delay: 0,
        loop: false
    });
}

/*------------ 4 - Onloads ---------------*/
// window.onload = () => new AnimationGradient();

/*------------ 5 Banner Home ---------------*/
const swiper = new Swiper('.heroBannerSlider', {
    loop: true,
    autoplay: true,
    speed: 2000,
    delay: 7000,
    effect: 'fade',
});

/*------------ 6 - Zoom Image ---------------*/
let zoomImg = document.querySelector(".f-panzoom");
const optionsZoom = {
    panMode: "mousemove",
    mouseMoveFactor: 3,
    click: false,
    wheel: false
};
const fp = new Panzoom(zoomImg, optionsZoom);
zoomImg.addEventListener('mouseenter', () => {
    fp.zoomTo(2)
});
zoomImg.addEventListener('mouseleave', () => {
    fp.zoomToFit()
});

/*-------------/ 7 - Animations SVG /-----------*/
window.onscroll = ()=>{
    const SVGSToBeAnimated = document.querySelectorAll('.svg-path-animate')
    SVGSToBeAnimated.forEach(svg => {
        
    })
}

