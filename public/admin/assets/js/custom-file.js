document.querySelector('#files').addEventListener('change', function (e) {
    const fileName = Array.from(this.files).map(file => file.name).join(', ');
    this.nextElementSibling.textContent = fileName || "Choose Files"; // Updates the label with file name(s)
});
