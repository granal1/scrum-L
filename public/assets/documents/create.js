
document.getElementById('document_file').onchange = function () {
    let path_array = this.value.split("\\");
    document.getElementById('document_name').value = Array.from(path_array.values()).pop();
};
