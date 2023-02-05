window.onload = function() {

    setProgressBarValue();

    let done_progress = document.getElementById('done_progress');

    done_progress.addEventListener('onchange', (event) => {
        setProgressBarValue();
    });

    done_progress.addEventListener('input', (event) => {
        setProgressBarValue();
    });
}

setProgressBarValue = function(){

    let progress_value = document.getElementById('done_progress').value;
    document.getElementById('progress_bar_value').value = progress_value;

    let outgoing_files_block = document.getElementById('outgoing_files_block');

    if(progress_value > 99)
    {
        outgoing_files_block.classList.remove("d-none");
    } else {
        outgoing_files_block.classList.add("d-none");
    }
}

