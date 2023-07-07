import { setSmoothScrollTo } from "../Utils/variables_functions";

export class Menu {
    heightToActiveHeader;
    tl2;
    positions;
    menu;
    menuOrange;
    header;
    hasBanner;

    constructor() {
        this.positions = ['0px', '60px', '130px', '210px', '280px', '360px', '430px', '490px'];
        this.menu = document.querySelector('.menu-button');
        this.html = document.querySelector('html')
        this.body = document.body
        this.setMenuTimeline()
        this.anchorLinks()
    }
    
    static tl = gsap.timeline({ paused: true });

    setMenuTimeline() {
        Menu.tl.to(".menu-content", { display: 'flex', })
        Menu.tl.to(".menu-content", { opacity: 1 }, '<')

        this.menu.addEventListener('click', () => {
            if (this.menu.classList.contains('open')) {
                Menu.tl.reverse();
                this.body.classList.remove("block-scroll")
                this.html.removeAttribute('data-lenis-prevent')
            } else {
                Menu.tl.play();
                this.body.classList.add("block-scroll")
                this.html.setAttribute('data-lenis-prevent', '')
            }

            this.menu.classList.toggle('open')
        })

    }

    actionsMenu(action) {
        switch (action) {
            case 'restart': {
                Menu.tl.restart()
                break;
            }
            case 'reverse': {
                Menu.tl.reverse();
                break;
            }
            case 'pause': {
                Menu.tl.pause()
                break;
            }
            case 'play': {
                Menu.tl.play()
                break;
            }


        }
    }

    anchorActions(id) {
        var targetOffset = document.getElementById(id).offsetTop
        this.menu.click()
        setTimeout(()=>{
            setSmoothScrollTo(0, targetOffset, 1000)
        }, 1000)
    }

    anchorLinks() {
        const links = document.querySelectorAll(".menu-content--nav .menu-content--item a")
        links.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault()
                const id = link.getAttribute('href').replace('#', '')
                this.anchorActions(id)
            })
        })
    }
}
