<script type="text/javascript">

$(document).ready(function() {
     $("#TableContenidoRespuesta").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });

});


HTMLCargarContenidoRespuesta=function(result){
    var html="";
    $('#TableContenidoRespuesta').DataTable().destroy();    

    $.each(result.data,function(index,r) {
        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='alumno'>"+r.alumno+"</td>"+
            "<td class='respuesta'>"+r.respuesta+"</td>"+
            "<td class='ruta_respuesta'><a href='file/content/"+r.ruta_respuesta+"' target='blank'>"+r.ruta_respuesta+"</a></td>"+
            "<td class='created_at'>"+r.created_at+"</td>";

        if( $.trim(r.comentario) != "" || $.trim(r.nota) != "" ){
            ruta_comentario = '';
            if( $.trim(r.ruta_comentario) != '' ){
                ruta_comentario = "<a href='file/content/"+r.ruta_comentario+"' target='blank'>"+r.ruta_comentario+"</a>";
            }
            html+='<td class="comentario">'+$.trim(r.comentario)+'<hr>'+ruta_comentario+'</td>';
            html+='<td class="nota">'+$.trim(r.nota)+'</td>';
        }
        else{
            html+=  '<td class="comentario">'+
                        '<textarea class="col-xs-12" id="txt_comentario'+r.id+'"></textarea><br><hr>'+
                        '<input type="text" style="" readonly="" class="col-xs-7 input-sm" id="txt_file_nombre'+r.id+'" value="">'+
                        '<input type="text" style="display: none;" id="txt_file_archivo'+r.id+'">'+
                        '<label class="col-xs-5 btn btn-default btn-flat  btn-xs" style="height: 30px; margin-top: 0px;">'+
                            '<i class="fa fa-file-image-o fa-lg"></i>Cargar Documento'+
                            '<input type="file" style="display: none;" onchange="onImagenRespuesta(event,'+r.id+');">'+
                        '</label>'+
                    '</td>';
            html+='<td class="nota"><input type="number" class="form-control" id="nota'+r.id+'" name="nota'+r.id+'" value="'+(r.nota*1)+'" max="99"></td>';
        }
        
        if( $.trim(r.nota) == '' && $.trim(r.comentario) == '' ){
            html+='<td class="nota"><button type="button" onClick="guardarNotaRpta('+r.id+', '+r.contenido_id+');" class="btn btn-primary">Guardar</button></td>';
        }
        else{
            html+='<td class="nota"><button type="button" onClick="guardarRecalificar('+r.id+', '+r.contenido_id+');" class="btn btn-warning">Re-Calificar</button></td>';
        }
         
        html+="</tr>";
    });
    $("#TableContenidoRespuesta tbody").html(html); 
    $("#TableContenidoRespuesta").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
        
    });
};

onImagenRespuesta = function (event, id) {
        var files = event.target.files || event.dataTransfer.files;
        if (!files.length)
            return;
        var image = new Image();
        var reader = new FileReader();
        reader.onload = (e) => {
            $('#TableContenidoRespuesta #txt_file_archivo'+id).val(e.target.result);
            $('#TableContenidoRespuesta .img-circle').attr('src',e.target.result);
        };
        reader.readAsDataURL(files[0]);
        $('#TableContenidoRespuesta #txt_file_nombre'+id).val(files[0].name);
        console.log(files[0].name);
};



guardarNotaRpta=function(id, contenido_id){

    $("#ContenidoRespuestaForm #txt_contenido_id, #ContenidoRespuestaForm #txt_contenido_respuesta_id, #ContenidoRespuestaForm #txt_nota_cr, #ContenidoRespuestaForm #txt_comentario, #ContenidoRespuestaForm #txt_file_nombre, #ContenidoRespuestaForm #txt_file_archivo").val('');
    $("#ContenidoRespuestaForm #txt_contenido_id").val(contenido_id);
    $("#ContenidoRespuestaForm #txt_contenido_respuesta_id").val(id);
    $("#ContenidoRespuestaForm #txt_nota_cr").val($('#nota'+id).val());
    $("#ContenidoRespuestaForm #txt_comentario").val($('#txt_comentario'+id).val());
    $("#ContenidoRespuestaForm #txt_file_nombre").val($('#txt_file_nombre'+id).val());
    $("#ContenidoRespuestaForm #txt_file_archivo").val($('#txt_file_archivo'+id).val());

    if( ($("#ContenidoRespuestaForm #txt_nota_cr").val()=='' || $("#ContenidoRespuestaForm #txt_nota_cr").val()=='0') && $("#ContenidoRespuestaForm #txt_comentario").val()=='' ){
        swal({
            title: "Validación",   
            text: "Para guardar la información debe ingresar: Nota o comentario del trabajo enviado.",
            //type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#8CD4F5",
            confirmButtonText: "Continuar!",
            closeOnConfirm: true
        });
    }
    

    if( $("#ContenidoRespuestaForm #txt_nota_cr").val() != '' && $("#ContenidoRespuestaForm #txt_nota_cr").val() > 0 ){
        swal({
          title: "¿Confirmación?",   
          text: "Desea guardar la nota, no podrá reversar los cambios...!",   
          //type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#8CD4F5",
          confirmButtonText: "Continuar!",
          closeOnConfirm: true
        },
        function(){
            AjaxContenidoRespuesta.GuardarNotaRpta(HTMLGuardarNotaRpta);
        }); 
    }
    else if( $("#ContenidoRespuestaForm #txt_comentario").val() != '' ) {
        swal({
          title: "¿Confirmación?",   
          text: "Desea guardar el comentario, no podrá reversar los cambios...!",   
          //type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#8CD4F5",
          confirmButtonText: "Continuar!",
          closeOnConfirm: true
        },
        function(){
            AjaxContenidoRespuesta.GuardarNotaRpta(HTMLGuardarNotaRpta);
        }); 
    }
    
    
};

HTMLGuardarNotaRpta=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        //var id = $("#ContenidoRespuestaForm #txt_contenido_id").val();
        AjaxContenidoRespuesta.Cargar(HTMLCargarContenidoRespuesta);
    }
}

guardarRecalificar = (id, contenido_id)=>{
    $("#ContenidoRespuestaForm #txt_contenido_id, #ContenidoRespuestaForm #txt_contenido_respuesta_id, #ContenidoRespuestaForm #txt_nota_cr, #ContenidoRespuestaForm #txt_comentario, #ContenidoRespuestaForm #txt_file_nombre, #ContenidoRespuestaForm #txt_file_archivo").val('');
    $("#ContenidoRespuestaForm #txt_contenido_id").val(contenido_id);
    $("#ContenidoRespuestaForm #txt_contenido_respuesta_id").val(id);
    swal({
          title: "¿Confirmación?",   
          text: "Desea recalificar, no podrá reversar los cambios...!",   
          //type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#8CD4F5",
          confirmButtonText: "Continuar!",
          closeOnConfirm: true
        },
        function(){
            AjaxContenidoRespuesta.GuardarRecalificar(HTMLGuardarRecalificar);
        });
}

HTMLGuardarRecalificar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxContenidoRespuesta.Cargar(HTMLCargarContenidoRespuesta);
    }
}
</script>
