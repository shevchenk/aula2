<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var ContenidoG={id:0};

$(document).ready(function() {
    $(".fecha").datetimepicker({
        format: "yyyy-mm-dd",
        language: 'es',
        showMeridian: true,
        time:true,
        minView:2,
        autoclose: true,
        todayBtn: false
    });
    
    $(".hora").datetimepicker({
        format: "hh:ii:00",
        language: 'es',
        showMeridian: true,
        time:true,
        startView:1,
        minView:0,
        maxView:1,
        pickDate: true,
        autoclose: true,
        todayBtn: false
    });
    AjaxContenidoMaster.ListarTipoContenido(HTMLListarTipoContenido);

    $('#ModalContenido').on('shown.bs.modal', function (event) {
        $('#ModalContenidoForm #txt_contenido').val( ContenidoG.contenido );
        $('#ModalContenidoForm #slct_unidad_contenido_id').selectpicker( 'val',ContenidoG.unidad_contenido_id );
        $('#ModalContenidoForm #txt_titulo_contenido').val( ContenidoG.titulo_contenido );
        $('#ModalContenidoForm #txt_file_nombre').val( ContenidoG.ruta_contenido );
        $('#ModalContenidoForm #txt_foto_nombre').val( ContenidoG.foto_contenido );
        $('#ModalContenidoForm #txt_file_archivo, #ModalContenidoForm #txt_foto_archivo').val( '' );
        ruta=''; ruta2='';
        $("#chk_archivo,#chk_archivo2").prop("checked",true);
        if( ContenidoG.ruta_contenido!='' ){
            ruta='file/content/'+ContenidoG.ruta_contenido;
            $("#chk_archivo").prop("checked",false);
        }
        if( ContenidoG.foto_contenido!='' ){
            ruta2='file/content/'+ContenidoG.foto_contenido;
            $("#chk_archivo2").prop("checked",false);
        }

        masterG.SelectImagen(ruta,'#txt_file_imagen','');
        masterG.SelectImagen(ruta2,'#txt_foto_imagen','');
        $('#ModalContenidoForm #slct_tipo_respuesta').selectpicker('val', ContenidoG.tipo_respuesta );
        $('#ModalContenidoForm #txt_fecha_inicio').val( ContenidoG.fecha_inicio );
        $('#ModalContenidoForm #txt_fecha_final').val( ContenidoG.fecha_final );
        $('#ModalContenidoForm #txt_hora_inicio').val( ContenidoG.hora_inicio );
        $('#ModalContenidoForm #txt_hora_final').val( ContenidoG.hora_final );
        $('#ModalContenidoForm #txt_fecha_ampliada').val( ContenidoG.fecha_ampliada );
        $('#ModalContenidoForm #txt_fecha_inicio_d').val( ContenidoG.fecha_inicio_d );
        $('#ModalContenidoForm #txt_fecha_final_d').val( ContenidoG.fecha_final_d );
        $('#ModalContenidoForm #txt_fecha_ampliada_d').val( ContenidoG.fecha_ampliada_d );
        $('#ModalContenidoForm #txt_video').val( ContenidoG.video );
        $('#ModalContenidoForm #slct_estado').selectpicker( 'val',ContenidoG.estado );
        ReferenciaHTML(ContenidoG.referencia);

        if( AddEdit==1 ){
            $("#chk_archivo").prop("checked",false);
            $(this).find('.modal-footer .btn-primary').text('Guardar').attr('onClick','AgregarEditarAjax3();');
        }
        else{
            $(this).find('.modal-footer .btn-primary').text('Actualizar').attr('onClick','AgregarEditarAjax3();');
            $("#ModalContenidoForm").append("<input type='hidden' value='"+ContenidoG.id+"' name='id'>");
        }
        ValidaTipoRespuesta();
    });

    $('#ModalContenido').on('hidden.bs.modal', function (event) {
        $("#ModalContenidoForm input[type='hidden']").not('.mant').remove();
        $('#ModalContenidoForm input[id="txt_referencia"]').not('.mant').remove();
    });

    $( "#ModalContenidoForm #slct_tipo_respuesta" ).change(function() {
        ValidaTipoRespuesta();
    });
});

ValidaForm3=function(){
    var r=true;

    if( $.trim( $("#ModalContenidoForm #slct_unidad_contenido_id").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione Unidad de Contenido',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_titulo_contenido").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Titulo de Contenido',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_contenido").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Contenido',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Seleccione Tipo de Contenido',4000);
    }
    else if( $("#chk_archivo").is(":checked")==false && $.trim( $("#ModalContenidoForm #txt_file_nombre").val() )=='' ){
        r=false;
        msjG.mensaje('warning','Ingrese Archivo',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_fecha_inicio").val() )=='' && ($.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='1' || $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='2')){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha Inicio',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_hora_inicio").val() )=='' && $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='2'){
        r=false;
        msjG.mensaje('warning','Ingrese Hora Inicio',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_fecha_final").val() )=='' && $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='1'){
        r=false;
        msjG.mensaje('warning','Ingrese Fecha Final',4000);
    }
    else if( $.trim( $("#ModalContenidoForm #txt_hora_final").val() )=='' && $.trim( $("#ModalContenidoForm #slct_tipo_respuesta").val() )=='2'){
        r=false;
        msjG.mensaje('warning','Ingrese Hora Final',4000);
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
    ContenidoG.unidad_contenido_id='';
    ContenidoG.titulo_contenido='';
    ContenidoG.contenido='';
    ContenidoG.ruta_contenido='';
    ContenidoG.foto_contenido='';
    ContenidoG.tipo_respuesta='';
    ContenidoG.fecha_inicio='';
    ContenidoG.fecha_final='';
    ContenidoG.hora_inicio='';
    ContenidoG.hora_final='';
    ContenidoG.fecha_ampliada='';
    ContenidoG.fecha_inicio_d='';
    ContenidoG.fecha_final_d='';
    ContenidoG.fecha_ampliada_d='';
    ContenidoG.referencia='';
    ContenidoG.video='';
    ContenidoG.estado='1';
    if( val==0 ){
        ContenidoG.id=id;
        ContenidoG.contenido=$("#DivContenido #trid_"+id+" .contenido").val();
        ContenidoG.unidad_contenido_id=$("#DivContenido #trid_"+id+" .unidad_contenido_id").val();
        ContenidoG.titulo_contenido=$("#DivContenido #trid_"+id+" .titulo_contenido").val();
        ContenidoG.ruta_contenido=$("#DivContenido #trid_"+id+" .ruta_contenido").val();
        ContenidoG.foto_contenido=$("#DivContenido #trid_"+id+" .foto_contenido").val();
        ContenidoG.tipo_respuesta=$("#DivContenido #trid_"+id+" .tipo_respuesta").val();
        ContenidoG.fecha_inicio=$("#DivContenido #trid_"+id+" .fecha_inicio").val();
        ContenidoG.fecha_final=$("#DivContenido #trid_"+id+" .fecha_final").val();
        ContenidoG.hora_inicio=$("#DivContenido #trid_"+id+" .hora_inicio").val();
        ContenidoG.hora_final=$("#DivContenido #trid_"+id+" .hora_final").val();
        ContenidoG.fecha_ampliada=$("#DivContenido #trid_"+id+" .fecha_ampliada").val();
        ContenidoG.fecha_inicio_d=$("#DivContenido #trid_"+id+" .fecha_inicio_d").val();
        ContenidoG.fecha_final_d=$("#DivContenido #trid_"+id+" .fecha_final_d").val();
        ContenidoG.fecha_ampliada_d=$("#DivContenido #trid_"+id+" .fecha_ampliada_d").val();
        ContenidoG.referencia=$("#DivContenido #trid_"+id+" .referencia").val();
        ContenidoG.video=$("#DivContenido #trid_"+id+" .video").val();
        ContenidoG.estado=$("#DivContenido #trid_"+id+" .estado").val();
    }
    $('#ModalContenido').modal('show');
}

CambiarEstado3=function(estado,id){
    sweetalertG.confirm("¿Estás seguro?", "Confirme la eliminación", function(){
        AjaxContenidoMaster.CambiarEstado(HTMLCambiarEstado3,estado,id);
    });
}

HTMLCambiarEstado3=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        AjaxContenidoMaster.Cargar(HTMLCargarContenido);
    }
}

AgregarEditarAjax3=function(){
    if( ValidaForm3() ){
        AjaxContenidoMaster.AgregarEditar(HTMLAgregarEditar3);
    }
}

HTMLAgregarEditar3=function(result){
    if( result.rst==1 ){
        msjG.mensaje('success',result.msj,4000);
        $('#ModalContenido').modal('hide');
        $("#chk_archivo").prop("checked",false);
        AjaxContenidoMaster.Cargar(HTMLCargarContenido);
    }
    else{
        msjG.mensaje('warning',result.msj,3000);
    }
}

ListarUnidadContenido=function(){
    AjaxContenidoMaster.ListarUnidadContenido(SlctListarUnidadContenido);
}

ValidaTipoRespuesta=function(){
    $("#ModalContenidoForm #video,#ModalContenidoForm #respuesta,#ModalContenidoForm #tarea,#ModalContenidoForm #profesor_tarea").css('display','none');
    tipoRespuesta= $('#ModalContenidoForm #slct_tipo_respuesta').val();
    if( tipoRespuesta=='1' ) {
        $( "#ModalContenidoForm #respuesta,#ModalContenidoForm #tarea,#ModalContenidoForm #profesor_tarea" ).css("display","");
        $( "#ModalContenidoForm #respuesta .anotacion" ).html("Fecha de entrega de tareas");
        $( "#ModalContenidoForm #respuesta .profesor" ).html("Fecha de revisión de tareas");
    }else if( tipoRespuesta=='2' ) {
        $( "#ModalContenidoForm #video,#ModalContenidoForm #respuesta" ).css("display","");
        $( "#ModalContenidoForm #respuesta .anotacion" ).html("Videoconferencia");
    }
}

SlctListarUnidadContenido=function( result ){
    var html="<option value>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.unidad_contenido+"</option>";
    });
    $("#ModalContenidoForm #slct_unidad_contenido_id").html(html);
    $("#ModalContenidoForm #slct_unidad_contenido_id").selectpicker('refresh');
}

HTMLListarTipoContenido=function( result ){
    var html="<option value=''>.::Seleccione::.</option>";
    $.each(result.data,function(index,r){
        html+="<option value="+r.id+">"+r.tipo_contenido+"</option>";
    });
    $("#ModalContenidoForm #slct_tipo_respuesta").html(html); 
    $("#ModalContenidoForm #slct_tipo_respuesta").selectpicker('refresh');
}

HTMLCargarContenido=function( result ){
    var html="";
    var aux_uc='';
    $.each(result.data,function(index,r){
        estadohtml='onClick="CambiarEstado3(1,'+r.id+')"';
        if(r.estado==1){
            estadohtml='onClick="CambiarEstado3(0,'+r.id+')"';
        }
        if(index==0){
            html+='<div class="panel box box-primary">'+ 
                        '<div class="box-header with-border collapsed" data-toggle="collapse" data-parent="#DivContenido" href="#collapse'+index+'" width="100%">'+
                            '<div class="progress active" style="height: auto !important; width: 90%; margin-inline: auto;">'+
                                '<div class="progress-bar progress-bar-default progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; font-size:24px; line-height:20pt;">'+
                                  '<div style="margin: 10px 10px;">'+r.unidad_contenido+'</div>'+
                                '</div>'+
                            '</div>'+
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
                            '<div class="progress active" style="height: auto !important; width: 90%; margin-inline: auto;">'+
                                '<div class="progress-bar progress-bar-default progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; font-size:24px; line-height:20pt;">'+
                                  '<div style="margin: 10px 10px;">'+r.unidad_contenido+'</div>'+
                                '</div>'+
                            '</div>'+
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
                '<button type="button" class="btn bg-navy btn-flat btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
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
                        '<div class="col-md-12">'+
                            '<div class="formatotitulo '+r.color+'">'+
                                '<div class="btn-group">'+
                                    '<span>'+r.titulo_contenido+'</span>'+
                                    referencias+
                                '</div>'+
                            '</div>'+
                        '</div>'+
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
                            '<img src="file/content/'+r.foto_contenido+'" alt="" style="max-width: 60%;">';
                        if( r.ruta_contenido!='' || r.video!='' ){
                            html+=''+
                            '</a>';
                        }
                        html+=''+
                        '</div>'+
                        contenidos+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-lg-3 col-md-6">'+
                            '<button type="button" '+estadohtml+' class="col-xs-12 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">'+
                                '<span class="fa fa-trash fa-lg"></span> Eliminar'+
                            '</button>'+
                        '</div>'+
                        '<div class="col-lg-3 col-md-6">'+
                            '<button type="button" onclick="AgregarEditar3(0,'+r.id+')" class="col-xs-12 btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">'+
                                '<span class="fa fa-edit fa-lg"></span> Editar'+
                            '</button>'+
                        '</div>'+
                        '<div class="col-lg-3 col-md-6">';
                        if( r.tipo_respuesta==1 ){
                            html+=''+
                            '<button type="button" onClick="CargarContenidoProgramacion('+r.id+','+r.programacion_unica_id+',\''+r.unidad_contenido+'\',\''+r.titulo_contenido+'\',\''+r.fecha_inicio+'\',\''+r.fecha_final+'\',\''+r.fecha_ampliada+'\''+')" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ampliación de Respuesta">'+
                                '<span class="fa fa-list fa-lg"></span>Ampl.'+
                            '</button>';
                        }
                        html+=''+
                        '</div>'+
                        '<div class="col-lg-3 col-md-6">';
                        if( r.tipo_respuesta==1 ){
                            html+=''+
                            '<button type="button" onClick="CargarContenidoRespuesta('+r.id+',\''+r.unidad_contenido+'\',\''+r.titulo_contenido+'\',\''+r.fecha_inicio+'\',\''+r.fecha_final+'\',\''+r.fecha_ampliada+'\''+')" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Respuesta de Contenido">'+
                                '<span class="fa fa-list fa-lg"></span>Resp.'+
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
}

AgregarReferencia= function(){
  var html='';
        html+='<div class="col-md-12"><div class="col-md-11"><div class="form-group">'+
             '<input type="text"  class="form-control" id="txt_referencia" name="txt_referencia[]">';
        html+="</div></div>";
        html+='<div class="col-md-1"><div class="form-group">'+
              '<button type="button" onclick="EliminarReferencia(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-sm"></i> </button>';
        html+="</div></div></div>";
  $("#referencia").append(html);

};
ReferenciaHTML=function(referencias){
    var html="";
    if(referencias.length>0){
        var referencia=referencias.split('|');
        for (i = 0; i < referencia.length; i++) {
            html+='<div class="col-md-12"><div class="col-md-11"><div class="form-group">'+
                  '<input type="text"  class="form-control" id="txt_referencia" name="txt_referencia[]" value="'+referencia[i]+'">';
            html+="</div></div>";
            html+='<div class="col-md-1"><div class="form-group">'+
                  '<button type="button" onclick="EliminarReferencia(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-sm"></i> </button>';
            html+="</div></div></div>";
        };
    }

    $("#referencia").html(html);
};

EliminarReferencia=function(boton){
    var tr = boton.parentNode.parentNode.parentNode;
    $(tr).remove();
};

CargarContenidoProgramacion=function(id,programacion_unica_id,unidad,titulo,fi,ff,fa){
    var html="<h3>"+unidad+"=> "+titulo+"</h3><br>"+
            "Fecha Inicio: "+fi+"  |  "+
            "Fecha Fin: "+ff;
        if( $.trim(fa)!='' ){
            html+="  |  Fecha Ampliada: "+fa;
        }
     $("#titulo_tarea_pro").html(html);
     $("#ContenidoProgramacionForm #txt_contenido_id").val(id);
     $("#ModalContenidoProgramacionForm #txt_contenido_id").val(id);
     $("#ModalContenidoProgramacionForm #btn_listarpersona").data( 'filtros', 'estado:1|programacion_unica_id:'+programacion_unica_id );
     //AjaxContenidoProgramacion.Cargar(HTMLCargarContenidoProgramacion);
     $("#ContenidoProgramacionForm").css("display","");
     $("#ContenidoRespuestaForm").css("display","none");

};
CargarContenidoRespuesta=function(id,unidad,titulo,fi,ff,fa){
    var html="<h3>"+unidad+"=> "+titulo+"</h3><br>"+
            "Fecha Inicio: "+fi+"  |  "+
            "Fecha Fin: "+ff;
        if( $.trim(fa)!='' ){
            html+="  |  Fecha Ampliada: "+fa;
        }
     $("#titulo_tarea").html(html);
     $("#ContenidoRespuestaForm #txt_contenido_id").val(id);
     //AjaxContenidoRespuesta.Cargar(HTMLCargarContenidoRespuesta);
     $("#ContenidoRespuestaForm").css("display","");
     $("#ContenidoProgramacionForm").css("display","none");

};

VerCursos=function(){
    $("#CursosForm").css("display","");
    $("#ContenidoForm").css("display","none");
}
</script>
