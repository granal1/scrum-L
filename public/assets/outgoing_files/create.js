
document.getElementById('document_file').onchange = function () {
    let path_array = this.value.split("\\");
    let file_name = Array.from(path_array.values()).pop();
    file_name = file_name.substring(0, file_name.length - 4);
    document.getElementById('document_name').value = file_name;
};
