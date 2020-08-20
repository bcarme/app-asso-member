const filePath = document.getElementById('member_imageFile_file') || document.getElementById('document_imageFile_file') || document.getElementById('online_form_imageFile_file');

function displayImageName() {
    if (filePath.value !== '') {
        const imageName = filePath.value.split('\\');
        const imageLastName = imageName.pop();
        document.getElementById('displayVich').innerHTML = imageLastName;
    }
}

filePath.addEventListener('change', () => {
    displayImageName();
});