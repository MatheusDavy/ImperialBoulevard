export default function hoverBackgroundGradient() {

    const navigation = navigator.userAgent.indexOf('Chrome')

    // If not chrome
    if (navigation == -1) {
        // it code will change all classes
        const buttonGradient = document.querySelectorAll(".button-hover-linearGradient")
        
        try {
            buttonGradient.forEach((button) => {
                button.classList.remove('button-hover-linearGradient')
                button.classList.add('button-hover-linearGradient-otherS-browsers')
            })
        } catch (error) {
            console.log(error)
        }
    }

}