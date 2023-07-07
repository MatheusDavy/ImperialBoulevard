import { isMobile } from "./variables_functions";

export default function FontSize() {
    const fontConfig = () => {
        const width = window.screen.width
        const value = (62.5 * width) / 1920;

        if (!isMobile) document.querySelector('html').style.fontSize = `${value}%`
    }

    window.addEventListener('resize', fontConfig)
    window.addEventListener('load', fontConfig)
}