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
    document.getElementById('progress_bar_value').value = document.getElementById('done_progress').value;
}

