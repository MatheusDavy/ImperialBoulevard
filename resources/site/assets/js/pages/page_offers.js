$("header").addClass("page-offers")

const btnQuestions = document.querySelectorAll('.button-questions')
btnQuestions.forEach(btn => {
    btn.addEventListener('click', ()=>{
        const container = btn.parentNode
        container.classList.toggle("show-response")
    })
})

function whatsappIcon(){
    const button = document.getElementById('whatsapp-link')
    const sectionToDisappear = document.getElementById('questions').offsetTop + (document.getElementById('questions').clientHeight * 0.14)
    const scroll = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
    if(scroll < sectionToDisappear){
        button.classList.add('show-button')
    }else{
        button.classList.remove('show-button')
    }
}
whatsappIcon()

window.onscroll = ()=>{
    whatsappIcon()
}