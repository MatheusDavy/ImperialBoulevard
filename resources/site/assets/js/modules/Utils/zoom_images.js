/*
    SUMMARY

    0 - functions
    1 - images open zoom modal
    2 - btn close zoom modal

*/
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
//// Just add (class="images--zoom") in the <img> to work the modal ////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

export default function zoomImages() {
    /*------------------ 0 - functions ---------------*/
    function addSourceToImageModal(imageClicked) {
        const sourceImage = imageClicked.dataset.src
        const imageModal = document.getElementById('image__zoom-modal')

        openCloseZoomModal(true)
        imageModal.setAttribute('src', sourceImage)
    }
    
    function openCloseZoomModal(opened) {
        const modal = document.getElementById("modal-zoom-images")
        const imageModal = document.getElementById('image__zoom-modal')
        if (opened === true) {
            modal.classList.add("activate-modal")
            imageModal.style.opacity = 1

        }  else{
            modal.classList.remove("activate-modal")

            imageModal.style.opacity = 0
            imageModal.setAttribute('src', '')
        }
    }

    /*------------------ 1 - images open zoom modal ---------------*/
    // open zoom modal when clicked in images
    const imagesZoom = document.querySelectorAll('.images--zoom')
    imagesZoom.forEach((image)=>{
        image.addEventListener("click", () => {
            addSourceToImageModal(image)
        })
    })
    
    /*------------------ 2 - btn close zoom modal ---------------*/
    const btnCloseModal = document.getElementById("btn-close__zoom-modal")
    btnCloseModal.addEventListener('click', () => {
        openCloseZoomModal(false)
    })

}