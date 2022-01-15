var quill_toolbar = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 'code-block', 'code'],
    ['link', 'image', 'formula'],

    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    [{ 'direction': 'rtbl' }],                         // text direction

    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'font': [] }],
    [{ 'align': [] }],

    ['clean', 'position']                                         // remove formatting button
];


function deleteRow(url, identity) {
    Swal.fire({
        title: '¿Estas seguro(a)?',
        text: "Este cambio no podrá ser revertido",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--confirm, var(--confirm, #3085d6))',
        cancelButtonColor: 'var(--cancel, #d33)',
        confirmButtonText: '¡Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('loading_gif').style.display = 'block'
            fetch(url,{
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                body: JSON.stringify({_method: 'DELETE'})
            })
            .then(res => res.json())
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: NO_ELIMINO,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
            })
            .then(response =>{
                console.log(response)

                document.getElementById('td_row_' + identity).remove();
            })
            .finally(()=>{
                document.getElementById('loading_gif').style.display = 'none'
                //location.reload();
            });
        }
    })
}

function addPermission(element){
    let params = (element.id).split('_');
    let url = location.origin + '/permission/assign';
    let body = {'permission' : params[0], 'role': params[1], 'active' : element.checked };
    let destiny = `td_${params[0]}_${params[1]}`;
    loading(destiny, url, 'POST', body, element.checked);
}

function addRol(element){
    let params = (element.id).split('_');
    let url = location.origin + '/role/assign';
    let body = {'user' : params[0], 'role': params[1], 'active' : element.checked };
    let destiny = `td_${params[0]}_${params[1]}`;
    loading(destiny, url, 'POST', body, element.checked);
}

function addGroupRol(element){
    let params = (element.id).split('_');
    let url = location.origin + '/group/assign';
    let body = {'group' : params[0], 'role': params[1], 'active' : element.checked };
    let destiny = `td_${params[0]}_${params[1]}`;
    loading(destiny, url, 'POST', body, element.checked);
}

function markPermission(element) {
    let input = document.getElementById(element)
    if(input.checked) document.getElementById(element).removeAttribute('checked')
    else   document.getElementById(element).setAttribute('checked', '');
    addPermission(input);
}

function markRol(element) {
    let input = document.getElementById(element)
    if(input.checked) document.getElementById(element).removeAttribute('checked')
    else   document.getElementById(element).setAttribute('checked', '');
    addRol(input);
}

function markGroupRol(element) {
    let input = document.getElementById(element)
    if(input.checked) document.getElementById(element).removeAttribute('checked')
    else   document.getElementById(element).setAttribute('checked', '');
    addGroupRol(input);
}


function loading(destiny, url, method, data, type){
    $.ajax(url, {
        method: method,
        data: data,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        xhr: ()=> {
            var xhr = new XMLHttpRequest();
            xhr.upload.onprogress = (e) => {
                let percent = Math.round((e.loaded / e.total) * 100);
                document.getElementById('progress_nav').style.width = percent + '%';
                if(destiny.length > 0 ){
                    document.getElementById(destiny).style.backgroundImage = `linear-gradient(to left,white ${100-percent}%, #64acad ${percent}%)`;
                }

            };
            return xhr;
        },
        success: (success) => {
            document.getElementById('progress_nav').style.width =  '100%';
            if(destiny.length > 0 ) {
                document.getElementById(destiny).style.backgroundImage = null;
                document.getElementById(destiny).style.backgroundColor = type ? 'rgba(0,5,50,0.7)' : null;
            }

            if(type){
                (new Audio(location.origin + '/sounds/default.ogg')).play();
            }else{
                (new Audio(location.origin +'/sounds/remove.ogg')).play();
            }
            Swal.fire({
                icon: 'success',
                title: GUARDADO,
                showConfirmButton: false,
                timer: 850
            })
        },
        error: (error)=> {
            document.getElementById('progress_nav').style.width =  '100%';
            if(destiny.length > 0 ) {
                document.getElementById(destiny).style.backgroundImage = null;
                document.getElementById(destiny).style.backgroundColor ='red';
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: JSON.parse(error.responseText).message
            })
        },
        complete: ()=> {
            document.getElementById('progress_nav').style.width =  '0%';
        }
    });
}

function show_image_profile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#profile_avatar').attr('src', e.target.result);
            let formData = new FormData();
            formData.append("files", input.files[0]);
            $.ajax(location.origin+'/profile/image', {
                method: 'POST',
                data: formData,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                processData: false,
                contentType: false,
                xhr: ()=> {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.onprogress = (e) => {
                        let percent = Math.round((e.loaded / e.total) * 100);
                        document.getElementById('progress_nav').style.width = percent + '%';
                    };
                    return xhr;
                },
                success: (success) => {
                    document.getElementById('progress_nav').style.width = '100%';
                },
                error: (error)=> {
                    document.getElementById('progress_nav').style.width = '100%';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: JSON.parse(error.responseText).message
                    })
                },
                complete: ()=> {
                    document.getElementById('progress_nav').style.width =  '0%';
                }
            });
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function show_image_preview(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img_receiver').attr('src', e.target.result);
            document.getElementById('image_label').style.display = 'none'

            let formData = new FormData();
            formData.append("files", input.files[0]);
            $.ajax(location.origin+'/imageFIle', {
                method: 'POST',
                data: formData,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                processData: false,
                contentType: false,
                xhr: ()=> {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.onprogress = (e) => {
                        let percent = Math.round((e.loaded / e.total) * 100);
                        document.getElementById('progress_nav').style.width = percent + '%';
                    };
                    return xhr;
                },
                success: (success) => {
                    document.getElementById('progress_nav').style.width = '100%';
                    image_component.addImage(success);
                },
                error: (error)=> {
                    document.getElementById('progress_nav').style.width = '100%';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: JSON.parse(error.responseText).message
                    })
                },
                complete: ()=> {
                    document.getElementById('progress_nav').style.width =  '0%';
                }
            });
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

let elem = document.getElementById('role_all');
if(elem != null){
    elem.onclick = () => {
        let roles = document.getElementsByClassName('roles_checked');
        let users = document.getElementsByClassName('users_checked');
        if (document.getElementById('role_all').checked) {
            for(let i=0; i < roles.length ; i ++){
                roles[i].checked = true;
            }
            for(let i=0; i < users.length ; i ++){
                users[i].checked = true;
            }
        }else{
            for(let i=0; i < roles.length ; i ++){
                roles[i].checked = false;
            }
            for(let i=0; i < users.length ; i ++){
                users[i].checked = false;
            }
        }
    }
}


function setChecked(element){
    let users = document.getElementsByClassName(element.id);
    if (element.checked) {
        for(let i=0; i < users.length ; i ++){
            users[i].checked = true;
        }
    }else{
        for(let i=0; i < users.length ; i ++){
            users[i].checked = false;
            document.getElementById('role_all').checked = false;
        }
    }
}

function  setCheckedCustom(role) {
    let role_current =  document.getElementById(role)
    let users_role = document.getElementsByClassName(role);
    let result = 0;
    for(let i = 0; i < users_role.length; i++){
        if(!users_role[i].checked) result ++;
    }
    if(result > 0) {
        role_current.checked = false;
        document.getElementById('role_all').checked = false;
    }else{
        role_current.checked = true;
    }
}

function changeConfiguration(element, field) {
    let data = {'field' : field, 'status' : element.checked};
    loading('', location.origin + '/profile/configuration', 'POST', data, true)
}

function save_direction() {
    let data = {
        'country'   : document.getElementById('country').value,
        'state'     : document.getElementById('state').value,
        'city'      : document.getElementById('city').value,
        'address1'  : document.getElementById('address1').value,
        'address2'  : document.getElementById('address2').value,
        'postcode'  : document.getElementById('postcode').value
    }
    loading('', location.origin + '/profile/direction', 'POST', data, true)
}
function change_password() {
    let new_pass = document.getElementById('new_password').value;
    let conf_pass = document.getElementById('confirm_password').value;
    if(new_pass.length < 8 || conf_pass.length < 8){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La contraseña debe tener un mínimo de 8 caracteres'
        })
        return;
    }
    if(new_pass !== conf_pass){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Contraseñas no coinciden'
        })
        return;
    }
    let data = {
        'password' : document.getElementById('password').value,
        'new_password' : document.getElementById('new_password').value,
        'confirm_password' : document.getElementById('confirm_password').value
    }
    loading('', location.origin + '/profile/password', 'POST', data, true)
}

function compile() {
    var html = document.getElementById("gjs-html");
    var css = document.getElementById("gjs-css");
    var code = document.getElementById("code").contentWindow.document;

    document.body.onkeyup = function(){
        code.open();
        code.writeln(html.value+"<style>"+css.value+"</style>");
        code.close();
    };
};

function changeZoom(id, element){
    document.getElementById(id).style.width = element.value + "%";
    document.getElementById(id).style.height = (80000/element.value) + "px";
}
