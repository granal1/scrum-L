//АВТОПОДБОР_высоты_поля_textarea
function adaptTextarea(id) {
    var field = document.getElementById(id);
    field.setAttribute('style', 'height:' + (field.scrollHeight) + 'px;overflow-y:hidden;');
    field.addEventListener("input", OnInput, false);
    function OnInput() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';//////console.log(this.scrollHeight);
    }
};
