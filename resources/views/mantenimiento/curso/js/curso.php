<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var AdicionalG=0;
var CursoG={id:0,curso:"",estado:1,imagen_archivo:'',imagen_nombre:'',imagen_cabecera_archivo:'',imagen_cabecera_nombre:''}; // Datos Globales
$(document).ready(function() {

    $("#TableCurso").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });
    

    AjaxCurso.CargarAjax(HTMLCargarCurso);
    AjaxCurso.CargarTipoEvaluacionAjax(HTMLCargarTipoEvaluacionAjax);
    
    $("#CursoForm #TableCurso select").change(function(){ AjaxCurso.Cargar(HTMLCargarCurso); });
    $("#CursoForm #TableCurso input").blur(function(){ AjaxCurso.Cargar(HTMLCargarCurso); });
    
    $('#ModalCurso').on('shown.bs.modal', function (event) {

        if( AddEdit==1 ){
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $('#ModalCursoForm #txt_id').val( CursoG.id );
        }
        $('#ModalCursoForm #txt_curso').val( CursoG.curso );
        $('#ModalCursoForm #slct_valida_evaluacion').val( CursoG.valida_evaluacion );
        $('#ModalCursoForm #txt_file_nombre').val( CursoG.imagen );
        $('#ModalCursoForm #txt_file_nombre2').val( CursoG.imagen2 );
        $('#ModalCursoForm #txt_link').val( CursoG.link );
        $('#ModalCursoForm #txt_whatsapp').val( CursoG.whatsapp );
        $('#ModalCursoForm #txt_dias').val( CursoG.dias );
        $('#ModalCursoForm #txt_intentos').val( CursoG.intentos );
        masterG.SelectImagen(CursoG.imagen,'#txt_file_imagen');
        masterG.SelectImagen(CursoG.imagen2,'#txt_file_imagen2');
        AjaxCurso.CargarUnidadContenido(HTMLCargarUnidadContenido);
    });

    $('#ModalCurso').on('hidden.bs.modal', function (event) {
        $("#ModalCursoForm input[type='hidden']").not('.mant').remove();
        $("#ModalCursoForm input, #ModalCursoForm textarea").val('');
    });
    
});

ValidaForm=function(){
    var r=true;
    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    CursoG.id='';
    CursoG.curso='';
    CursoG.imagen='';
    CursoG.imagen2='';
    CursoG.link='';
    CursoG.whatsapp='';
    CursoG.dias='';
    CursoG.intentos='3';
    CursoG.valida_evaluacion='1';
    if( val==0 ){
        CursoG.id=id;
        CursoG.curso=$("#TableCurso #trid_"+id+" .curso").text();
        CursoG.imagen=$("#TableCurso #trid_"+id+" .imagen").val();
        CursoG.imagen2=$("#TableCurso #trid_"+id+" .imagen2").val();
        CursoG.link=$("#TableCurso #trid_"+id+" .link").val();
        CursoG.whatsapp=$("#TableCurso #trid_"+id+" .whatsapp").val();
        CursoG.dias=$("#TableCurso #trid_"+id+" .dias").val();
        CursoG.intentos=$("#TableCurso #trid_"+id+" .intentos").val();
        CursoG.valida_evaluacion=$("#TableCurso #trid_"+id+" .valida_evaluacion").val();
    }
    $('#ModalCurso').modal('show');
}

AgregarEditarAjax=function(){
    if( ValidaForm() ){
        AjaxCurso.AgregarEditar(HTMLAgregarEditar);
    }
}

HTMLAgregarEditar=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        $('#ModalCurso').modal('hide');
        AjaxCurso.Cargar(HTMLCargarCurso);
    }else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarCurso=function(result){
    var html="";
    $('#TableCurso').DataTable().destroy();
    
    $.each(result.data.data,function(index,r){
        imagen='';
        if( r.imagen!='' ){
            tiempo= new Date().getTime();
            imagen='<img src="'+r.imagen+'?time='+tiempo+'" style="width: 200px;height: 200px;">';
        }
        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='curso'>"+r.curso+"</td>"+
            "<td class='unidad_contenido'><ul><li>"+$.trim(r.unidad_contenido).split("|").join("</li><li>")+"</li></ul></td>"+
            '<td>'+imagen+'<input type="hidden" class="imagen" value="'+r.imagen+'">'+
            '<input type="hidden" class="valida_evaluacion" value="'+r.valida_evaluacion+'">'+
            '<input type="hidden" class="imagen2" value="'+r.imagen2+'">'+
            '<input type="hidden" class="link" value="'+r.link+'">'+
            '<input type="hidden" class="whatsapp" value="'+r.whatsapp+'">'+
            '<input type="hidden" class="dias" value="'+r.dias+'">'+
            '<input type="hidden" class="intentos" value="'+r.intentos+'">'+
            '</td>';
        html+="<td>";
        html+='<a class="btn btn-primary btn-sm" onClick="AgregarEditar(0,'+r.id+')"><i class="fa fa-edit fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#TableCurso tbody").html(html); 
    $("#TableCurso").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "lengthMenu": [10],
        "language": {
            "info": "Mostrando página "+result.data.current_page+" / "+result.data.last_page+" de "+result.data.total,
            "infoEmpty": "No éxite registro(s) aún",
        },
        "initComplete": function () {
            $('#TableCurso_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarCurso','AjaxCurso',result.data,'#TableCurso_paginate');
        }
    });
};

AgregarUC=function(){
    AdicionalG++;
    var html='<tr>';
    html+='<td><textarea name="txt_unidad_contenido[]" class="form-control"></textarea><input type="hidden" name="txt_id_unidad_contenido[]" value="0_'+AdicionalG+'"></td>';
    html+='<td><select name="slct_tipo_evaluacion_0_'+AdicionalG+'[]" class="form-control selectpicker show-menu-arrow" multiple data-selected-text-format="count">'+$("#slct_tipo_evaluacion").html()+'</select></td>';
    html+='<td><a class="btn btn-sm btn-danger" onClick="EliminarTr(this);"><i class="fa fa-trash fa-lg"></i></a></td>';
    html+='</tr>';
    
    $("#tb_te").append(html);
    $(".selectpicker").selectpicker("refresh");
}

EliminarTr=function(t){
    $(t).parent().parent().remove();
}

HTMLCargarUnidadContenido=function(result){
    var html='';
    $("#tb_te").html(html);
    $.each(result.data,function(index,r){
        var html='<tr>';
        html+='<td>';
        html+='<textarea name="txt_unidad_contenido[]" class="form-control">'+r.unidad_contenido+'</textarea>';
        html+='<input type="hidden" name="txt_id_unidad_contenido[]" value="'+r.id+'">';
        html+='</td>';
        html+='<td><select name="slct_tipo_evaluacion_'+r.id+'[]" class="form-control selectpicker show-menu-arrow" multiple data-selected-text-format="count" >'+$("#slct_tipo_evaluacion").html()+'</select></td>';
        html+='<td><a class="btn btn-sm btn-danger" onClick="EliminarTr(this);"><i class="fa fa-trash fa-lg"></i></a></td>';
        html+='</tr>';
        $("#tb_te").append(html);
        $("#tb_te tr").last().find("select").selectpicker('val',$.trim(r.tipo_evaluacion_id).split(","));
    });
        $(".selectpicker").selectpicker("refresh");
}

HTMLCargarTipoEvaluacionAjax=function(result){
    var html='';
    $("#slct_tipo_evaluacion").html(html);
    $.each(result.data,function(index,r){
        html='<option value="'+r.id+'">';
        html+=r.tipo_evaluacion;
        html+='</option>';
        $("#slct_tipo_evaluacion").append(html);
    });
}

</script>
