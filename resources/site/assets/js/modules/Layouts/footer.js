/*
    SUMMARY
    0 - AUTO YEAR
*/

export default function Footer() {
    /*-----------------/ 0 - AUTO YEAR /--------------------*/
    const currentYear = new Date().getFullYear()
    const yearElement = document.querySelector('.auto--year')
    yearElement.innerHTML = currentYear
}