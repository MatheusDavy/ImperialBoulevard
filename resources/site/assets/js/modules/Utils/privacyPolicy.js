export default function PolicyPrivacy () {
    
    /*-------------/ Const /--------------------*/
    const modal = document.getElementById('privacy-policy')
    const modalAcceptPolicy = document.getElementById('accept-policy')
    const linkPolicyPrivacy = document.querySelectorAll(".link-policy-privacy")
    
    /*-------------/ Function /--------------------*/
    function checkAcceptTerms () {
        const wasAccept = localStorage.getItem('@meetingPlus-acceptTerms')
        if (!wasAccept) {
            modalAcceptPolicy.classList.add('open-modal')
        }
    }

    /*-------------/ Policy Privacy /--------------------*/
    linkPolicyPrivacy.forEach(link => {
        link.addEventListener("click", ()=>{
            event.preventDefault()
            const modalPolicyPrivacy = document.getElementById("privacy-policy")
            modalPolicyPrivacy.classList.add("open-modal")
        })
    })
    

    $('#close-privacy-policy').click(function() {
        modal.classList.remove("open-modal")
    });

    /*-------------/ Accept Policy /--------------------*/
    $('#accept-privacy').click(function() {
        localStorage.setItem('@meetingPlus-acceptTerms', true)
        modalAcceptPolicy.classList.remove("open-modal")
    });

    window.addEventListener("load", ()=>{
        checkAcceptTerms()
    })
}