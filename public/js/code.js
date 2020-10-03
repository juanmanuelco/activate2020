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
