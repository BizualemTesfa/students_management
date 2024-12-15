// General Script for Form Validation and Offline Behavior
document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
        form.addEventListener("submit", (event) => {
            let isValid = true;
            const inputs = form.querySelectorAll("[required]");
            inputs.forEach((input) => {
                if (!input.value.trim()) {
                    input.classList.add("error");
                    isValid = false;
                } else {
                    input.classList.remove("error");
                }
            });
            if (!isValid) {
                event.preventDefault();
            }
        });
    });

    // Register Service Worker
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("/offline/service-worker.js").then(() => {
            console.log("Service Worker Registered");
        });
    }
});
