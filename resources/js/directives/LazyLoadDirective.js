export default {
    inserted: el => {
        function loadImage() {
            el.addEventListener("load", () => {
                setTimeout(() => el.classList.add("loaded"), 100);
            });
            el.addEventListener("error", () => console.log("error"));
            el.src = el.dataset.src;
        }

        function handleIntersect(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    loadImage();
                    observer.unobserve(el);
                }
            });
        }

        function createObserver() {
            const options = {
                root: null,
                threshold: "0"
            };
            const observer = new IntersectionObserver(handleIntersect, options);
            observer.observe(el);
        }

        // console.log('el',el);
        if(!$(el).hasClass("lazy") && !$(el).hasClass("owl-lazy") ){
            if (window["IntersectionObserver"]) {
                createObserver();
            } else {
                loadImage();
            }
        }
    }
};
