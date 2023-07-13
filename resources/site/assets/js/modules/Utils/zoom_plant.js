export default function ZooomPlant() {
    const image = document.querySelector('#modal-zoom-plant .image')
    const description = document.querySelector("#modal-zoom-plant .description")
    const modal = document.querySelector('#modal-zoom-plant')
    const buttonOpenModal = document.querySelector(".plant-mobile")
    const buttonCloseModal = document.getElementById("btn-close__zoom-modal-plant")

    buttonOpenModal.addEventListener("click", () => {
        modal.classList.add("activate-modal")
    })

    buttonCloseModal.addEventListener("click", () => {
        modal.classList.remove("activate-modal")
    })
    

    function doOnOrientationChange() {
        switch (window.orientation) {
            case -90:
            case 90:
                image.classList.add('active')
                description.classList.remove("active")
                break;
            default:
                image.classList.remove('active')
                description.classList.add("active")
                break;
        }
    }


    window.addEventListener('orientationchange', doOnOrientationChange);
    doOnOrientationChange();
}