import { anchorVerify } from "./variables_functions"
/*
    SUMMARY

    0 - Global Variables
    1 - functions
    2 - Href Anchor 
    3 - Default Anchor
*/

export default function AnchorLinks() {

    /*-------------------- 0 - Global Variables ------------------*/
    let prevHref

    /*-------------------- 1 - functions --------------------*/
    function anchorHref(){
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
                } else {
                    prevHref = arrayUrl.slice(0, index).join('') + '/'
                }
                const id = idArray.join('')
                anchorVerify(id)

            }
        })
        if (!arrayUrl.includes('#')) {
            prevHref = arrayUrl.slice(0, arrayUrl.length - 1).join('') + '/'
        }
    }

    /*-------------------- 2 - Href Anchor  ------------------*/
    window.onload = () => anchorHref()

    /*-------------------- 3 - Default Anchor -----------------*/
    const anchors = document.querySelectorAll(".anchor--link")
    anchors.forEach((element) => {
        element.addEventListener("click", (event) => {
            const link = element.getAttribute('href')
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
                            const id = idArray.join('')
                            anchorVerify(id)
                        }
                    }
                })
            }
        })
    })

}