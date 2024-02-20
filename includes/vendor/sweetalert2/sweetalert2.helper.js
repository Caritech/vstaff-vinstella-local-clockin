//USE $swal for share global setting
var swal2 = Sweetalert2.mixin({
    confirmButtonColor: '#DD6B55',
    cancelButtonColor: '#CECECE',
})

//Sweetalert2 Helper
function swalFire(title, html) {
    swal2.fire({
        title: title,
        html: html,
        confirmButtonText: "OK",
        confirmButtonColor: '#8cd4f5',
    })
}

async function swalSuccess(title, html, additionalParams) {
    let params = {
        title: title,
        html: html,
        icon: 'success',
        confirmButtonText: "OK",
        confirmButtonColor: '#8cd4f5',
    };
    $.extend(params, additionalParams);
    var c = await swal2.fire(params)
    return c.value ?? false
}
async function swalError(title, html, additionalParams) {
    let params = {
        title: title,
        html: html,
        icon: 'error',
        confirmButtonText: "OK",
        confirmButtonColor: '#8cd4f5',
    };
    $.extend(params, additionalParams);
    var c = await swal2.fire(params)
    return c.value ?? false
}
async function swalErrorBig(title, html, additionalParams) {
    let params = {
        title: title,
        html: html,
        icon: 'error',
        width: '700px',
        confirmButtonText: "OK",
        confirmButtonColor: '#8cd4f5',
    };
    $.extend(params, additionalParams);
    var c = await swal2.fire(params)
    return c.value ?? false
}
async function swalInfo(title, html, additionalParams) {
    let params = {
        title: title,
        html: html,
        icon: 'info',
        confirmButtonText: "OK",
        confirmButtonColor: '#8cd4f5',
    };
    $.extend(params, additionalParams);
    var c = await swal2.fire(params)
    return c.value ?? false
}
async function swalWarning(title, html, additionalParams) {
    let params = {
        title: title,
        html: html,
        icon: 'warning',
        confirmButtonText: "OK",
        confirmButtonColor: '#8cd4f5',
    };
    $.extend(params, additionalParams);
    var c = await swal2.fire(params)
    return c.value ?? false
}
async function swalConfirm(title, html, additionalParams) {
    let params = {
        title: title,
        html: html,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Yes",
    };
    $.extend(params, additionalParams);
    var c = await swal2.fire(params)
    return c.value ?? false
}

function swalLoading(title, html = '') {
    const swalLoadingModal = swal2.fire({
        title: title,
        html: html,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showConfirmButton: false,
    });
    swal2.showLoading(); // Display the built-in loading spinner
}

/*
    params = {
        title: '',
        html: '',
        long_wait_message: '',
        long_wait_time: 10
    }
*/
function swalLoadingCountdown(params) {
    let title = params.title;
    let html = params.html ?? '';
    let long_wait_message = params.long_wait_message ?? '';
    let long_wait_time = params.long_wait_time ?? 30;
    let elapsedTime = 0; // Initialize elapsed time to 0

    // Create a custom HTML structure for the modal
    const customModalHtml = `
        <div style="overflow:hidden;display: flex;flex-direction: column;align-items: center;justify-content: space-between;">
            <div class="swal2-loader" style="display: flex;"></div>
            <div>${html}</div>
            <div id="long-wait-message" class="my-3" style="display:none">${long_wait_message}</div>
            <div class="elapsed-time"><span id="elapsedTimeSpan"></span> </div>
            <div class="elapsed-time"><span id="elapsedTimeCancelButton"></span> </div>
        </div>
    `;


    var timerInterval;
    const swalLoadingModal = swal2.fire({
        title: title,
        html: customModalHtml,
        allowOutsideClick: false,
        allowEscapeKey: true,
        allowEnterKey: false,
        showConfirmButton: false,
        showCancelButton: true,

        willOpen: () => {
            // Update the elapsed time every 0.1 seconds
            timerInterval = setInterval(() => {
                elapsedTime += 0.1; // Increment the elapsed time
                if (document.getElementById("elapsedTimeSpan") != null) {
                    document.getElementById("elapsedTimeSpan").textContent = elapsedTime.toFixed(1) + ' seconds';
                }
                if (elapsedTime > long_wait_time) {
                    $('#long-wait-message').show()
                }
                // if(elapsedTime == 2){
                //     console.log(111);
                //     if (document.getElementById("elapsedTimeCancelButton") != null) {
                //         document.getElementById("elapsedTimeCancelButton").innerHTMLhtml = "";
                //     }   
                // }
            }, 100); // Update every 0.1 second (100 milliseconds)
        },
        didClose: () => {
            clearInterval(timerInterval)
        }
    });
}



function swalClose() {
    swal2.close()
}

