import { setSmoothScrollTo } from "../Utils/variables_functions"
/*
    SUMMARY
    0 - AUTO YEAR
    1 - BACK TO TOP
*/


export default function Footer() {
    /*-----------------/ 0 - AUTO YEAR /--------------------*/
    const currentYear = new Date().getFullYear()
    const yearElement = document.querySelector('.auto--year')
    yearElement.innerHTML = currentYear

    /*---------------/ 1 - BACK TO TOP /--------------------------*/
    const anchor = document.getElementById('back-to-top')
    window.addEventListener('scroll', ()=>{
        const section = document.querySelector('.section_contact').offsetTop
        const scroll = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
        if(section < scroll){
            anchor.classList.add('animated')
        }else{
            anchor.classList.remove('animated')
        }
    })

    anchor.addEventListener('click', (event)=>{
        event.preventDefault()
        setSmoothScrollTo(0, 0, 1000)
    })
}