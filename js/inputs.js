let uniqid = $('meta[name=uniqid]').attr("content");
let exercicio = $('select[name ="_exercicio"]').val();

let types = ['autocomplete', 'select', 'radio', 'checkbox', 'text', 'textarea', 'custom'];
let buttons = ['create', 'update', 'delete', 'custom'];

function setData(type, fieldName, id= '', label='') {
    
    if($.inArray(type.toLowerCase(), types) === -1) {
        return false;
    }

    if (type == 'text') {
        $(`#${uniqid}_${fieldName}`).val(label);
        console.log(type, fieldName, id, label);
    }

    if (type == 'autocomplete') {
        $(`#s2id_${uniqid}_${fieldName}_autocomplete_input`).select2("data", {"id": id, "label": label}).trigger('change');
        $(`input[name="${uniqid}[${fieldName}]"]`).val(id);		
    }

    return true;
}

function submit(button) {

    if($.inArray(button.toLowerCase(), buttons) === -1) {
        return false;
    }

    if (button == 'create') {
        $("button[name='btn_create_and_list']").click();
    }

    if (button == 'update') {
        $("button[name='btn_update_and_list']").click();	
    }

    return true;
}

function setUrl(url) {
    location.href= url;
}

function checkSuccess(message) {
    return /alteração da mensagem concluída com sucesso!/i.test($('.alert-success').text());
}

function getUrlRoot() {
    return window.location.protocol + '//' + window.location.hostname;
}

function getUrlComplete() {
    return this.getUrlRoot() + window.location.pathname;
}
    