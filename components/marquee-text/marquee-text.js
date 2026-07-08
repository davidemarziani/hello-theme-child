document.addEventListener("DOMContentLoaded", () => {
    const marquees = document.querySelectorAll(".marquee-text");

    marquees.forEach((marquee) => {
        const track = marquee.querySelector(".marquee-text__track");
        const speed = parseFloat(marquee.dataset.speed || 40);
        const direction = marquee.dataset.direction || "left";

        const distance = track.scrollWidth / 2;

        const fromX = direction === "left" ? 0 : -distance;
        const toX = direction === "left" ? -distance : 0;

        const tween = gsap.fromTo(track,
            { x: fromX },
            {
                x: toX,
                duration: speed,
                ease: "none",
                repeat: -1
            }
        );

        // smooth hover stop (decelerazione)
        marquee.addEventListener("mouseenter", () => {
            gsap.to(tween, {
                timeScale: 0,
                duration: 0.8,
                ease: "power3.out"
            });
        });

        marquee.addEventListener("mouseleave", () => {
            gsap.to(tween, {
                timeScale: 1,
                duration: 0.8,
                ease: "power3.inOut"
            });
        });
    });
});