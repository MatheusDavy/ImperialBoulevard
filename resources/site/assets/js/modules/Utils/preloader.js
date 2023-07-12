export default function Preloader () {
    const preloader = document.getElementById("preloader")
    let timeline = gsap.timeline({ paused: true });
    timeline.to(preloader, {opacity: 0})
    timeline.to(preloader, {display: 'none'}, '<')
    

    window.addEventListener('load', ()=>{
        timeline.play()
    })
}