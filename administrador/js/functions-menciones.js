document.addEventListener('DOMContentLoaded',function(){
    tablemenciones =  $('#tablemenciones').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        "ajax":{
            "url": window.location.origin + "/liceoEjido/administrador/models/menciones/table_menciones.php",
            "dataSrc":""
        },
        "columns": [
            {"data":"acciones"},
            {"data":"mencion_nombre"},
            {"data":"mencion_estado"},
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
    });

    var formMencion = document.querySelector('#formMencion');
    formMencion.onsubmit = function(e){
        e.preventDefault();

        var idmencion = document.querySelector('#idmencion').value;
        var nombre = document.querySelector('#nombre').value;
        var estado =  document.querySelector('#listEstado').value;
        

        if(nombre == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = window.location.origin +'/liceoEjido/administrador/models/menciones/ajax-menciones.php';
        var form = new FormData(formMencion);
        request.open('POST',url,true);
        request.send(form);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var data = JSON.parse(request.responseText);
                if(data.status) {
                    $('#modalMencion').modal('hide');
                    formMencion.reset();
                    swal('Mencion',data.msg,'success');
                    tablemenciones.ajax.reload();
                } else {
                    swal('Atencion',data.msg,'error');
                }
            }
        }
    }

})

function openModalMenciones(){
    document.querySelector('#idmencion').value = 0;
    document.querySelector('#formMencion').reset();
    $('#modalMencion').modal('show');

} 
function editarMencion(id) {
   var idmencion = id;

   var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/menciones/edit-menciones.php?idmencion='+idmencion;
        request.open('GET',url,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if(data.status) {
                    document.querySelector('#idmencion').value = data.data.mencion_id;
                    document.querySelector('#nombre').value = data.data.mencion_nombre;
                    document.querySelector('#listEstado').value = data.data.mencion_estado;

                   $('#modalMencion').modal('show');   
                } else {
                    swal('Atencion',data.msg,'error');
                }
            }
        }
} 
function eliminarMenciones(id) {
    var idmencion = id;

    swal({
        title: "Eliminar Mención",
        text: "Realmente desea eliminar la mención?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(confirm){
        if(confirm) {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var url = './models/menciones/delet-menciones.php';
            request.open('POST',url,true);
            var strData = "idmencion="+idmencion;
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200) {
                    var data = JSON.parse(request.responseText);
                    if(data.status) {
                        swal('Eliminar',data.msg,'success');
                        tablemenciones.ajax.reload();
                    } else {
                        swal('Atencion',data.msg,'error');
                    }
                }
            }
        }
    })
}