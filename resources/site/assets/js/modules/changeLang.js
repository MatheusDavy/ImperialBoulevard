import AjaxClass from "./ajaxClass";

export default function changeLang(){
    class ChangeLang extends AjaxClass {
        successFunction() {
            let urlCurrent = $("#routeCurrent").val();
            window.location.replace(urlCurrent);    
        }
    }

    $("#changeLang").on('change', function () {
        let lang = $("#changeLang").val();
        let url = $("#langFunction").val();

        let changeLang = new ChangeLang(null, 'POST', url, 'json', null);
        changeLang.dataString = 'lang=' + lang;
        changeLang.send();
    });
}
