const language = document.querySelector(".language");
const arabicFields = document.querySelector(".ar-fields");
const englishFields = document.querySelector(".en-fields");

language.addEventListener("change", function () {
    switch (this.value) {
        case "en":
            arabicFields.classList.add("d-none");
            englishFields.classList.remove("d-none");
            break;
        case "ar":
            arabicFields.classList.remove("d-none");
            englishFields.classList.add("d-none");
    }
});
