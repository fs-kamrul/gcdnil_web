class ThemeIconManagement {
    init() {
        $('.copyToTxt').on('click', event =>  {
            event.preventDefault();

            let dataTxt = $(event.currentTarget).data('txt');
            const textarea = document.createElement('textarea');
            textarea.style.position = 'fixed';
            textarea.style.top = 0;
            textarea.style.left = 0;

            textarea.value = dataTxt;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            let message = 'Successfully copy ' + dataTxt;
            kamruldashboard.showSuccess(message);
        });
    }
}

$(document).ready(() => {
    new ThemeIconManagement().init();
});
