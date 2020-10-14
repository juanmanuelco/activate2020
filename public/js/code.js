var quill_toolbar = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 'code-block'],

    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    [{ 'direction': 'rtl' }],                         // text direction

    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'font': [] }],
    [{ 'align': [] }],

    ['clean']                                         // remove formatting button
];

function deleteRow(url) {
    Swal.fire({
        title: '¿Estas seguro(a)?',
        text: "Este cambio no podrá ser revertido",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
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
                    text: 'No se pudo eliminar el registro',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
            })
            .then(response =>{
                console.log(response)
            })
            .finally(()=>{
                document.getElementById('loading_gif').style.display = 'none'
                location.reload();
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
        },
        error: (error)=> {
            document.getElementById('progress_nav').style.width =  '100%';
            if(destiny.length > 0 ) {
                document.getElementById(destiny).style.backgroundImage = null;
                document.getElementById(destiny).style.backgroundColor ='red';
            }
        },
        complete: ()=> {
            document.getElementById('progress_nav').style.width =  '0%';
        }
    });
}
function show_image_preview(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img_receiver').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

$("#image_content").change(function() {
    show_image_preview(this);
});
