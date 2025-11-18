class kamruldashboard {

    constructor() {

    }
    static showNotice(messageType, message, messageHeader = '') {
        toastr.clear();

        toastr.options = {
            closeButton: true,
            positionClass: 'toast-bottom-right',
            onclick: null,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 10000,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
        //
        if (!messageHeader) {
            switch (messageType) {
                case 'error':
                    messageHeader = 'Error!';
                    break;
                case 'success':
                    messageHeader = 'Success!';
                    break;
            }
        }
        toastr[messageType](message, messageHeader);
    }
    static showSuccess(message, messageHeader = '') {
        this.showNotice('success', message, messageHeader);
    }
    static showError(message, messageHeader = '') {
        this.showNotice('error', message, messageHeader);
    }
}

$(document).ready(() => {
    new kamruldashboard();
    window.kamruldashboard = kamruldashboard;
});
