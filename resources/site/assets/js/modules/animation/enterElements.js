export default function AnimationElements() {

    /*
        SUMMARY
            0 - Const / Variables
            1 - Function
            2 - Init Animation
    */

    /*--------------/ 0 - Const / Variables /-------------*/
    const options = {
        root: null,
        rootMargin: "0px",
        threshold: 0.05
    };

    /*--------------/ 1 - Function /-------------*/
    function enterAnimations() {
        let revealCallback = (entries) => {
            entries.forEach((entry) => {
                let container = entry.target;

                if (entry.isIntersecting) {
                    container.classList.add("animated-element");
                    return;
                }

            });
        };

        let revealObserver = new IntersectionObserver(revealCallback, options);

        document.querySelectorAll("[data-animation]").forEach((reveal) => {
            revealObserver.observe(reveal);
        });
    }

    function staggerAnimations() {
        let revealCallback = (entries) => {
            entries.forEach((entry) => {
                const container = entry.target;
                const staggers = container.querySelectorAll('[data-sequencial-stagger]')

                if (entry.isIntersecting) {
                    gsap.to(staggers, {
                        y: 0,
                        x: 0,
                        opacity: 1,
                        duration: 0.7,
                        stagger: 0.2,
                    });
                    return;
                }

            });
        };

        let revealObserver = new IntersectionObserver(revealCallback, options);

        document.querySelectorAll("[data-sequencial]").forEach((reveal) => {
            revealObserver.observe(reveal);
        });
    }

    /*--------------/ 2 - Init Animation /-------------*/
    $(document).ready(function () {
        enterAnimations()
        staggerAnimations()
    });

}