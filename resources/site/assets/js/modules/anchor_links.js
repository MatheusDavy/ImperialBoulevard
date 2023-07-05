/*
    SUMMARY

    0 - Global Variables
    1 - functions
    2 - Href Anchor 
    3 - Menus Anchor
        3.1 - External
        3.2 - Internal
*/

export default function anchorLinks() {

    /*-------------------- 0 - Global Variables ------------------*/
    let prevHref
    let isMobile = window.screen.width < 1080 ? true : false
    let zoomDesktop = Number(getComputedStyle(document.body).zoom)

    /*-------------------- 1 - functions --------------------*/
    function setSmoothScrollTo(endX, endY, duration) {
        const startX = window.scrollX || window.pageXOffset;
        const startY = window.scrollY || window.pageYOffset;
        const distanceX = endX - startX;
        const distanceY = endY - startY;
        const startTime = new Date().getTime();

        duration = typeof duration !== "undefined" ? duration : 400;

        const easeInOutQuart = (time, from, distance, duration) => {
            if ((time /= duration / 2) < 1)
                return (distance / 2) * time * time * time * time + from;
            return (-distance / 2) * ((time -= 2) * time * time * time - 2) + from;
        };

        const timer = setInterval(() => {
            const time = new Date().getTime() - startTime;
            const newX = easeInOutQuart(time, startX, distanceX, duration);
            const newY = easeInOutQuart(time, startY, distanceY, duration);
            if (time >= duration) {
                clearInterval(timer);
            }
            window.scroll(newX, newY);
        }, 1000 / 60);
    }

    function anchorVerify(id){
        const headerHeight = document.getElementById('header').clientHeight

        if (isMobile) {
            var targetOffset = document.getElementById(id).offsetTop

            $('html, body').animate({
                scrollTop: targetOffset - headerHeight
            }, 1000);

        } else {
            setSmoothScrollTo(0, (targetOffset * zoomDesktop), 1000)
        }
    }

    function openCloseMenu() {
        const menu = document.querySelector('#menu--mobile')
        menu.classList.toggle("isOpen")
    }

    /*-------------------- 2 - Href Anchor  ------------------*/

    window.onload = () => {
        const url = window.location.href

        const arrayUrl = url.split("")

        arrayUrl.forEach((element, index) => {
            let initialIndex
            const finalIndex = arrayUrl.length
            if (element === '#') {
                initialIndex = index + 1
                const idArray = (arrayUrl.slice(initialIndex, finalIndex))
                if (arrayUrl[index - 1] == '/') {
                    prevHref = arrayUrl.slice(0, index).join('')
                    console.log(prevHref)
                } else {
                    prevHref = arrayUrl.slice(0, index).join('') + '/'
                    console.log(prevHref)
                }
                const converteToStringIdArray = idArray.join('')
                const id = converteToStringIdArray
                anchorVerify(`#${id}`)

            }
        })

        if (!arrayUrl.includes('#')) {
            prevHref = arrayUrl.slice(0, arrayUrl.length - 1).join('') + '/'
            console.log(prevHref)
        }
    }

    /*-------------------- 3 - Default Anchor -----------------*/
    ////// 3.1 - External
    const anchorsFooter = document.querySelectorAll(".anchor--link--external")
    anchorsFooter.forEach((element) => {
        element.addEventListener("click", (event) => {
            const link = event.target.getAttribute('href')
            if (link) {
                const linkArray = link.split('')
                linkArray.forEach((element, index) => {
                    let initialIndex
                    const finalIndex = linkArray.length
                    if (element === '#') {
                        initialIndex = index + 1
                        const idArray = (linkArray.slice(initialIndex, finalIndex))
                        const href = linkArray.slice(0, index).join('')
                        if (href == prevHref) {
                            event.preventDefault()
                            const converteToStringIdArray = idArray.join('')
                            const id = converteToStringIdArray

                            if (isMobile || anchorLinks.classList.includes('menu--links')) {
                                openCloseMenu()
                            }

                            anchorVerify(id)

                        }
                    }
                })
            }
        })
    })

    ////// 3.2 - Internal
    const anchorsMobile = document.querySelectorAll(".anchor--link--internals")
    anchorsMobile.forEach((element) => {
        element.addEventListener("click", (event) => {
            event.preventDefault()
            const id = element.getAttribute('href')
            anchorVerify(id)
        })
    })
}