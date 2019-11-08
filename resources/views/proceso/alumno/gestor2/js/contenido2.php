<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var ContenidoG={id:0,curso_id:0,contenido:'',ruta_contenido:'',file_archivo:'',tipo_respuesta:0,fecha_inicio:'',
fecha_final:'',fecha_ampliada:'',estado:1}; // Datos Globales
$(document).ready(function() {

    $('#div_contenido_respuesta').hide();

    $(".fecha").datetimepicker({
        format: "yyyy-mm-dd",
        language: 'es',
        showMeridian: true,
        time:true,
        minView:2,
        autoclose: true,
        todayBtn: false
    });

    // PROCESO DE RESPUESTA
    $('#btnGrabarRpta').on('click', function () {
      AjaxContenidoV2.AgregarRespuestaContenido(HTMLCargarContenRpta);
      $('#txt_respuesta').val('');
    });
    // --
});

HTMLCargarContenido=function(result){
    var html="";
    var aux_uc='';
    $.each(result.data,function(index,r){
        if(index==0){
            html+='<div class="panel box box-primary">'+ 
                        '<div class="box-header with-border collapsed" data-toggle="collapse" data-parent="#DivContenido" href="#collapse'+index+'" width="100%">'+
                            '<div class="UnidadContenido">'+r.unidad_contenido+'</div>'+
                        '</div>'+
                        '<div id="collapse'+index+'" class="panel-collapse collapse">'+
                            '<div class="box-body">';
            aux_uc=r.unidad_contenido_id;
        }

        if( r.unidad_contenido_id!=aux_uc ){
            html+=          '</div>'+
                        '</div>'+
                    '</div>';
            html+='<div class="panel box box-primary">'+ 
                        '<div class="box-header with-border collapsed" data-toggle="collapse" data-parent="#DivContenido" href="#collapse'+index+'" width="100%">'+
                            '<div class="UnidadContenido">'+r.unidad_contenido+'</div>'+
                        '</div>'+
                        '<div id="collapse'+index+'" class="panel-collapse collapse">'+
                            '<div class="box-body">';
            
            aux_uc=r.unidad_contenido_id;
            pos=1;
        }

        var referencias='';
        if( $.trim(r.referencia)!='' ){
            var res_uri = r.referencia.split("|");
            referencias=''+
                '<button type="button" class="btn bg-navy btn-flat btn-sm dropdown-toggle parpadea form-control" data-toggle="dropdown" aria-expanded="false">'+
                    'Referencias'+
                    '<i class="caret"></i>'+
                '</button>'+
                '<ul class="dropdown-menu">';
                var contador=0;
                for (i = 0; i < res_uri.length; i++) {
                    var url= res_uri[i].split('*')[0];
                    var nombre= res_uri[i].split('*')[1];
                    if ( $.trim(nombre)=='' ){ contador++; nombre='Link Nro '+contador; }
                    referencias+=''+
                    '<li>'+
                        '<a href="'+url+'" target="_blank">'+
                            '<i class="fa fa-book fa-lg"></i>'+nombre+
                        '</a>'+
                    '</li>';
                }
            referencias+=''+
                '</ul>';
        }

        var contenidos=''+
                    '<div class="col-md-12 col-sm-12">'+
                        '<div class="formatotexto">'+
                            r.contenido+
                        '</div>'+
                    '</div>';
        
        if(r.tipo_respuesta == 1){
        contenidos=''+
                    '<div class="col-md-6 col-sm-6" style="border-right: 2px solid #e9e9e9;">'+
                        '<div class="formatotexto">'+
                            r.contenido+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-6 col-sm-6">'+
                        '<div class="formatotexto">'+
                            '<ul>'+
                                '<li>Fecha Ini. : '+r.fecha_inicio+'</li>'+
                                '<li>Fecha Fin. : '+r.fecha_final+'</li>'+
                                '<li>Fecha Amp. : '+r.fecha_ampliada+'</li>'+
                            '</ul>'+
                        '</div>'+
                    '</div>';
        }
        else if(r.tipo_respuesta == 2){
                var dia = new Date(r.fecha_inicio);
                var dia_semana = ["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo"];
        contenidos=''+
                    '<div class="col-md-6 col-sm-6" style="border-right: 2px solid #e9e9e9;">'+
                        '<div class="text-justify formatotexto">'+
                            r.contenido+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-6 col-sm-6">'+
                        '<div class="text-justify formatotexto">'+
                            '<ul>'+
                                '<li>Fecha : '+r.fecha_inicio+'</li>'+
                                '<li>Día : '+dia_semana[dia.getDay()]+'</li>'+
                                '<li>Hora Inicio : '+r.hora_inicio+'</li>'+
                                '<li>Hora Final : '+r.hora_final+'</li>'+
                            '</ul>'+
                        '</div>'+
                    '</div>';
        }

        html+=  '<div class="col-lg-4 col-md-6 CabContenidoG CabContenido" id="trid_'+r.id+'">'+
                    '<input type="hidden" class="contenido" value="'+r.contenido+'">'+
                    '<input type="hidden" class="ruta_contenido" value="'+r.ruta_contenido+'">'+
                    '<input type="hidden" class="foto_contenido" value="'+r.foto_contenido+'">'+
                    '<input type="hidden" class="unidad_contenido_id" value="'+r.unidad_contenido_id+'">'+
                    '<input type="hidden" class="titulo_contenido" value="'+r.titulo_contenido+'">'+
                    '<input type="hidden" class="fecha_inicio" value="'+r.fecha_inicio+'">'+
                    '<input type="hidden" class="fecha_final" value="'+r.fecha_final+'">'+
                    '<input type="hidden" class="hora_inicio" value="'+r.hora_inicio+'">'+
                    '<input type="hidden" class="hora_final" value="'+r.hora_final+'">'+
                    '<input type="hidden" class="fecha_ampliada" value="'+r.fecha_ampliada+'">'+
                    '<input type="hidden" class="fecha_inicio_d" value="'+r.fecha_inicio_d+'">'+
                    '<input type="hidden" class="fecha_final_d" value="'+r.fecha_final_d+'">'+
                    '<input type="hidden" class="fecha_ampliada_d" value="'+r.fecha_ampliada_d+'">'+
                    '<input type="hidden" class="tipo_respuesta" value="'+r.tipo_respuesta+'">'+
                    '<input type="hidden" class="referencia" value="'+r.referencia+'">'+
                    '<input type="hidden" class="estado" value="'+r.estado+'">'+
                    '<input type="hidden" class="video" value="'+r.video+'">'+
                    '<div class="row">'+
                        '<div class="col-md-12" style="text-align: center;">';
                        if( r.ruta_contenido!='' || r.video!='' ){
                            href=r.video;
                            if( r.ruta_contenido!='' ){
                                href="file/content/"+r.ruta_contenido;
                            }
                            html+=''+
                            '<a href="'+href+'" target="_blank">';
                        }
                            html+=''+
                            '<img src="file/content/'+r.foto_contenido+'" alt="" style="width: 100%; max-height:250px;">';
                        if( r.ruta_contenido!='' || r.video!='' ){
                            html+=''+
                            '</a>';
                        }
                        html+=''+
                        '</div>'+
                        '<div class="col-md-12">'+
                            '<div class="formatotitulo" style="background-color:'+r.color+'">'+
                                '<div class="btn-group">'+
                                    '<span>'+r.titulo_contenido+'</span>'+
                                    referencias+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        contenidos+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-lg-8 col-md-10">';
                        if( r.tipo_respuesta==1 ){
                            html+=''+
                            '<button type="button" onClick="CargarContenidoProgramacion('+r.id+','+r.programacion_unica_id+',\''+r.unidad_contenido+'\',\''+r.titulo_contenido+'\',\''+r.fecha_inicio+'\',\''+r.fecha_final+'\',\''+r.fecha_ampliada+'\''+')" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Responder Tarea">'+
                                '<span class="fa fa-list fa-lg"></span>Responder Tarea'+
                            '</button>';
                        }
                        html+=''+
                        '</div>'+
                    '</div>'+
                '</div>';
    });
    if(result.data.length>0){
            html+=          '</div>'+
                        '</div>'+
                    '</div>';
    }
    $("#DivContenido").html(html);
};


ValidaForm3=function(){
    var r=true;

    if( $.trim( $("#ModalContenidoForm #txt_contenido").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Contenido',4000);
    }
     else if( $.trim( $("#ModalContenidoForm #txt_file_nombre").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Ruta de Contenido',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione Tipo de Respuesta',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_fecha_inicio").val() )=='' && $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='1'){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha Inicio',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_fecha_final").val() )=='' && $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='1' ){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha Final',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_fecha_ampliada").val() )=='' && $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='1'){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha Ampliada',4000);
    }
    return r;
}

AgregarEditar3=function(val,id){
    AddEdit=val;
    ContenidoG.id='';
    ContenidoG.contenido='';
    ContenidoG.ruta_contenido='';
    ContenidoG.file_archivo='';
    ContenidoG.tipo_respuesta='';
    ContenidoG.fecha_inicio='';
    ContenidoG.fecha_final='';
    ContenidoG.fecha_ampliada='';
    ContenidoG.estado='1';
    $('#respuesta').css("display","none");
    if( val==0 ){

        ContenidoG.id=id;
        ContenidoG.contenido=$("#TableContenido #trid_"+id+" .contenido").text();
        ContenidoG.ruta_contenido=$("#TableContenido #trid_"+id+" .ruta_contenido").text();
        ContenidoG.tipo_respuesta=$("#TableContenido #trid_"+id+" .tipo_respuesta").val();
        ContenidoG.fecha_inicio=$("#TableContenido #trid_"+id+" .fecha_inicio").text();
        ContenidoG.fecha_final=$("#TableContenido #trid_"+id+" .fecha_final").text();
        ContenidoG.fecha_ampliada=$("#TableContenido #trid_"+id+" .fecha_ampliada").text();
        ContenidoG.estado=$("#TableContenido #trid_"+id+" .estado").val();
        if(ContenidoG.tipo_respuesta=='1'){
                $('#respuesta').css("display","");
        }
    }
    $('#ModalContenido').modal('show');
}

CambiarEstado3=function(estado,id){
    sweetalertG.confirm("¿Estás seguro?", "Confirme la eliminación", function(){
        AjaxContenidoV2.CambiarEstadoRespuestaContenido(HTMLCambiarEstado3,estado,id);
    });
}

HTMLCambiarEstado3=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        //AjaxContenidoV2.Cargar(HTMLCargarContenido);
        AjaxContenidoV2.CargarRespuestaContenido(HTMLCargarContenidoRpta);
    }
}

HTMLCargarContenRpta=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxContenidoV2.CargarRespuestaContenido(HTMLCargarContenidoRpta);
    }else if( result.rst==3 ){
        msjG.mensaje('warning',result.msj,5000);
        AjaxContenidoV2.CargarRespuestaContenido(HTMLCargarContenidoRpta);
    }
    else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

HTMLCargarContenidoRpta=function(result){
    var html="";

    $.each(result.data,function(index,r){
        estadohtml='<a id="'+r.id+'" onClick="CambiarEstado3(1,'+r.id+')" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-lg"></i></a>';
        if(r.estado==1){
            estadohtml='<a id="'+r.id+'" onClick="CambiarEstado3(0,'+r.id+')" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-lg"></i></a>';
        }

        html+="<tr id='trid_"+r.id+"'>"+
            "<td class='created_at'>"+r.created_at+"</td>"+
            "<td class='respuesta'>"+r.respuesta+"</td>"+
            "<td class='ruta_respuesta'><a href='file/content/"+r.ruta_respuesta+"' target='blank'>"+r.ruta_respuesta+"</a></td>";
        html+="<td><input type='hidden' class='estado' value='"+r.estado+"'>"+estadohtml+"</td>";
        html+="</tr>";
    });
    $("#TableRespuestaAlu tbody").html(html);
};

CargarContenidoProgramacion=function(id, programacion_unica_id,unidad,titulo,fi,ff,fa){
     

     var html="<h3>"+unidad+"=> "+titulo+"</h3><br>"+
            "Fecha Inicio: "+fi+"  |  "+
            "Fecha Fin: "+ff;
        if( $.trim(fa)!='' ){
            html+="  |  Fecha Ampliada: "+fa;
        }
     $("#titulo_tarea_pro").html(html);
     $("#frmRepuestaAlum #txt_contenido_id").val(id);
     $("#frmRepuestaAlum #programacion_unica_id").val(programacion_unica_id);
     AjaxContenidoV2.CargarRespuestaContenido(HTMLCargarContenidoRpta);
     $('#div_contenido_respuesta').show();
};

VerCursos=function(){
    $("#CursosForm").css("display","");
    $("#ContenidoForm").css("display","none");
}

CancelarTarea=function(){
    $('#div_contenido_respuesta').css("display",'none');
}

</script>
