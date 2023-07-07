export default function ImageEnter() {
    document.addEventListener("DOMContentLoaded", function () {
        const options = {
            root: null,
            rootMargin: "0px",
            threshold: 0.05
        };

        // IMAGE ANIMATION
        let revealCallback = (entries) => {
            entries.forEach((entry) => {
                let container = entry.target;

                if (entry.isIntersecting) {
                    container.classList.add("animating");
                    return;
                }

            });
        };

        let revealObserver = new IntersectionObserver(revealCallback, options);

        document.querySelectorAll(".reveal").forEach((reveal) => {
            revealObserver.observe(reveal);
        });
    });
}