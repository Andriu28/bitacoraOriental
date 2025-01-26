let currentSection = 0;
const sections = document.querySelectorAll('.form-section');

function showSection(index) {
    sections.forEach((section, i) => {
        section.classList.toggle('active', i === index);
    });
}

function nextSection() {
    if (currentSection < sections.length - 1) {
        currentSection++;
        showSection(currentSection);
    }
}

function previousSection() {
    if (currentSection > 0) {
        currentSection--;
        showSection(currentSection);
    }
}
