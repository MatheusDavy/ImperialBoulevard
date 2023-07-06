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
        this.setMenuTimeline()
    }

    setMenuTimeline() {
        Menu.tl.to(".menu-content", { display: 'flex',})
        Menu.tl.to(".menu-content", { opacity: 1 }, '<')

        this.menu.addEventListener('click', () => {
            if(this.menu.classList.contains('open')){
                Menu.tl.reverse();
            }else{
                Menu.tl.play();
            }
            this.menu.classList.toggle('open')
        })

    }

    static tl = gsap.timeline({ paused: true });

    actionsMenu(action) {
        switch (action) {
            case 'restart': {
                Menu.tl.restart()
                break;
            }
            case 'reverse': {
                Menu.tl.reverse();
                console.log('call')
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
}
