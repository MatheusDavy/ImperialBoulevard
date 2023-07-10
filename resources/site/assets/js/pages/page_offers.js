$("header").addClass("page-offers")


const btnQuestions = document.querySelectorAll('.button-questions')
btnQuestions.forEach(btn => {
    btn.addEventListener('click', ()=>{
        const container = btn.parentNode
        container.classList.toggle("show-response")
    })
})