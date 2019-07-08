<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
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
    

    AjaxCurso.Cargar(HTMLCargarCurso);
    
    $("#CursoForm #TableCurso select").change(function(){ AjaxCurso.Cargar(HTMLCargarCurso); });
    $("#CursoForm #TableCurso input").blur(function(){ AjaxCurso.Cargar(HTMLCargarCurso); });
    
    $('#ModalCurso').on('shown.bs.modal', function (event) {

        if( AddEdit==1 ){        
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax();');
            $("#ModalCursoForm").append("<input type='hidden' value='"+CursoG.id+"' name='id'>");
        }
        $('#ModalCursoForm #txt_curso').val( CursoG.curso );
        $('#ModalCursoForm #txt_imagen_nombre').val(CursoG.imagen_nombre);
        $('#ModalCursoForm #txt_imagen_archivo').val('');
        $('#ModalCursoForm .img-circle').attr('src',CursoG.imagen_archivo+'?nocache='+(new Date()).getTime());
        $('#ModalCursoForm #txt_imagen_cabecera_nombre').val(CursoG.imagen_cabecera_nombre);
        $('#ModalCursoForm #txt_imagen_cabecera_archivo').val('');
        $('#ModalCursoForm .img-circle_cabecera').attr('src',CursoG.imagen_cabecera_archivo+'?nocache='+(new Date()).getTime());
        $('#ModalCursoForm #txt_imagen_cabecera_tablet_nombre').val(CursoG.imagen_cabecera_tablet_nombre);
        $('#ModalCursoForm #txt_imagen_cabecera_tablet_archivo').val('');
        $('#ModalCursoForm .img-circle_cabecera_tablet').attr('src',CursoG.imagen_cabecera_tablet_archivo+'?nocache='+(new Date()).getTime());
        $('#ModalCursoForm #txt_imagen_cabecera_cel_nombre').val(CursoG.imagen_cabecera_cel_nombre);
        $('#ModalCursoForm #txt_imagen_cabecera_cel_archivo').val('');
        $('#ModalCursoForm .img-circle_cabecera_cel').attr('src',CursoG.imagen_cabecera_cel_archivo+'?nocache='+(new Date()).getTime());
        $('#ModalCursoForm #txt_tipo_respuesta').focus();
    });

    $('#ModalCurso').on('hidden.bs.modal', function (event) {
        $("#ModalCursoForm input[type='hidden']").not('.mant').remove();
    });
    
});

ValidaForm=function(){
    var r=true;

    if( $.trim( $("#ModalCursoForm #txt_imagen_nombre").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Imagen',4000);
    }

    return r;
}

AgregarEditar=function(val,id){
    AddEdit=val;
    CursoG.id='';
    CursoG.curso='';
    CursoG.imagen_archivo='';
    CursoG.imagen_nombre='';
    CursoG.imagen_cabecera_archivo='';
    CursoG.imagen_cabecera_nombre='';
    CursoG.imagen_cabecera_tablet_archivo='';
    CursoG.imagen_cabecera_tablet_nombre='';
    CursoG.imagen_cabecera_cel_archivo='';
    CursoG.imagen_cabecera_cel_nombre='';
    if( val==0 ){
        CursoG.id=id;
        CursoG.curso=$("#TableCurso #trid_"+id+" .curso").text();
        CursoG.foto=$("#TableCurso #trid_"+id+" .foto").val();
        CursoG.foto_cab=$("#TableCurso #trid_"+id+" .foto_cab").val();
        CursoG.foto_cab_tablet=$("#TableCurso #trid_"+id+" .foto_cab_tablet").val();
        CursoG.foto_cab_cel=$("#TableCurso #trid_"+id+" .foto_cab_cel").val();
        if(CursoG.foto!='undefined'){
            CursoG.imagen_archivo='img/course/'+CursoG.foto;
            CursoG.imagen_nombre=CursoG.foto;
        }else {
            CursoG.imagen_archivo='';
            CursoG.imagen_nombre='';
        }

        if(CursoG.foto_cab!='undefined'){
            CursoG.imagen_cabecera_archivo='img/course/'+CursoG.foto_cab;
            CursoG.imagen_cabecera_nombre=CursoG.foto_cab;
        }else {
            CursoG.imagen_cabecera_archivo='';
            CursoG.imagen_cabecera_nombre='';
        }

        if(CursoG.foto_cab_tablet!='undefined'){
            CursoG.imagen_cabecera_tablet_archivo='img/coursetablet/'+CursoG.foto_cab_tablet;
            CursoG.imagen_cabecera_tablet_nombre=CursoG.foto_cab_tablet;
        }else {
            CursoG.imagen_cabecera_tablet_archivo='';
            CursoG.imagen_cabecera_tablet_nombre='';
        }

        if(CursoG.foto_cab_cel!='undefined'){
            CursoG.imagen_cabecera_cel_archivo='img/coursecel/'+CursoG.foto_cab_cel;
            CursoG.imagen_cabecera_cel_nombre=CursoG.foto_cab_cel;
        }else {
            CursoG.imagen_cabecera_cel_archivo='';
            CursoG.imagen_cabecera_cel_nombre='';
        }
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
        
        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='curso'>"+r.curso+"</td>";
        html+="<td>";
            if( $.trim(r.foto)!=''){    
                html+="<a  target='_blank' href='img/course/"+r.foto+"'>"+
                        "<img src='img/course/"+r.foto+"?nocache="+(new Date()).getTime()+"' style='height: 100px;width: 120px;'>"+
                      "</a>";
            }
            html+="</td>";
            html+="<td>";
            if( $.trim(r.foto_cab)!=''){    
                html+="<a  target='_blank' href='img/course/"+r.foto_cab+"'>"+
                        "<img src='img/course/"+r.foto_cab+"?nocache="+(new Date()).getTime()+"' style='height: 100px;width: 100%;'>"+
                      "</a>";
            }
            html+="</td>";
            html+="<td>";
            if( $.trim(r.foto_cab_tablet)!=''){    
                html+="<a  target='_blank' href='img/coursetablet/"+r.foto_cab_tablet+"'>"+
                        "<img src='img/coursetablet/"+r.foto_cab_tablet+"?nocache="+(new Date()).getTime()+"' style='height: 100px;width: 100%;'>"+
                      "</a>";
            }
            html+="</td>";
            html+="<td>";
            if( $.trim(r.foto_cab_cel)!=''){    
                html+="<a  target='_blank' href='img/coursecel/"+r.foto_cab_cel+"'>"+
                        "<img src='img/coursecel/"+r.foto_cab_cel+"?nocache="+(new Date()).getTime()+"' style='height: 100px;width: 100%;'>"+
                      "</a>";
            }
            html+="</td>";
        html+='<td>';
            if( $.trim(r.foto)!=''){
        html+="<input type='hidden' class='foto' value='"+r.foto+"'>";}
            if( $.trim(r.foto_cab)!=''){
        html+="<input type='hidden' class='foto_cab' value='"+r.foto_cab+"'>";}
            if( $.trim(r.foto_cab_tablet)!=''){
        html+="<input type='hidden' class='foto_cab_tablet' value='"+r.foto_cab_tablet+"'>";}
            if( $.trim(r.foto_cab_cel)!=''){
        html+="<input type='hidden' class='foto_cab_cel' value='"+r.foto_cab_cel+"'>";}
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

onImagen1 = function (event) {
        var files = event.target.files || event.dataTransfer.files;
        if (!files.length)
            return;
        var image = new Image();
        var reader = new FileReader();
        reader.onload = (e) => {
            $('#ModalCursoForm #txt_imagen_archivo').val(e.target.result);
            $('#ModalCursoForm .img-circle').attr('src',e.target.result);
        };
        reader.readAsDataURL(files[0]);
        $('#ModalCursoForm #txt_imagen_nombre').val(files[0].name);
        console.log(files[0].name);
    };

onImagen2 = function (event) {
        var files = event.target.files || event.dataTransfer.files;
        if (!files.length)
            return;
        var image = new Image();
        var reader = new FileReader();
        reader.onload = (e) => {
            $('#ModalCursoForm #txt_imagen_cabecera_archivo').val(e.target.result);
            $('#ModalCursoForm .img-circle_cabecera').attr('src',e.target.result);
        };
        reader.readAsDataURL(files[0]);
        $('#ModalCursoForm #txt_imagen_cabecera_nombre').val(files[0].name);
        console.log(files[0].name);
    };
</script>
