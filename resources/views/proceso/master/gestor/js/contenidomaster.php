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
});

ListarUnidadContenido=function(){
    AjaxContenidoMaster.ListarUnidadContenido(SlctListarUnidadContenido);
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

}

HTMLCargarContenido=function( result ){
    var html="";
    var pos=0;
    var aux_uc='';
    $.each(result.data,function(index,r){
        pos++;
        nombre= $.trim(r.ruta_contenido).split('/');
        foto= $.trim(r.foto_contenido).split('/');
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

        if( r.unidad_contenido_id!=aux_uc || pos%4==0 ){

            if( r.unidad_contenido_id!=aux_uc ){
            html+=      '</div>'+
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
        }

        color="bg-blue";
        if(r.tipo_respuesta == 1){
            color="bg-red";
        }else if(r.tipo_respuesta == 2){
            color="bg-green";
        }else if(r.tipo_respuesta == 3){
            color="bg-orange";
        }else if(r.tipo_respuesta == 4 || r.tipo_respuesta == 5){
            color="alert-info";
        }


        html+='<div class="col-lg-4" id="trid_'+r.id+'" style="margin-top: 15px; -moz-box-shadow: 0 0 ; -webkit-box-shadow: 0 0; box-shadow: 0 0;">'+
               '<input type="hidden" class="ruta_contenido" value="'+r.ruta_contenido+'">'+
               '<input type="hidden" class="imagen_nombre" value="'+foto[1]+'">'+
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
                            '<div class="text-justify '+color+'" style="margin-bottom: 15px; margin-top:10px; font-size: 15px; padding: 5px 5px; background-color: #F5F5F5; border-radius: 10px; border: 3px solid #F8F8F8;">'+
                                '<p style="text-align:center">'+r.titulo_contenido+'</p>'+
                                //'<small>Curso: '+r.curso+'</small>'+
                            '</div>'+
                        '</div>';
                archivo='';
                if(r.tipo_respuesta<2){
                    if( r.ruta_contenido!='' ){
                        archivo='<a href="file/content/'+r.ruta_contenido+'" target="_blank">';
                    }
                    html+='<div class="col-md-5 text-center" style="border-right: 2px solid #e9e9e9;">'+
                            archivo+'<img class="img-responsive" src="file/content/'+r.foto_contenido+'" alt="" width="100%" height="" style="margin:10px auto;height: 150px;min-width: 150px;"></a>'+
                        '</div>';
                }
                else{
                    if( r.ruta_contenido!='' ){
                        archivo='<a class="btn btn-flat btn-info" href="file/content/'+r.ruta_contenido+'" target="_blank">Sobre el Ponente</a>';
                    }
                    html+='<div class="col-md-5 text-center" style="border-right: 2px solid #e9e9e9;">'+
                            '<a href="'+r.video+'" target="_blank"><img class="img-responsive" src="file/content/'+r.foto_contenido+'" alt="" width="100%" height="" style="margin:10px auto;height: 150px;min-width: 150px;"></a>'+
                            archivo+
                        '</div>';
                }
                    html+='<div class="col-md-7" style="border-left: 2px solid #e9e9e9;">'+
                        '<div class="text-justify" style="margin-bottom: 15px; margin-top:10px; font-size: 15px; padding: 5px 5px; background-color: #F5F5F5; border-radius: 10px; border: 3px solid #F8F8F8;">'+
                            '<p class="contenido">'+r.contenido+'</p>'+
                        '</div>';

                if(r.tipo_respuesta == 1){
                 html+='<div>'+
                            '<p style="font-weight: normal;">'+
                                '<label style="font-weight: bold;">Fecha Ini. : </label> '+r.fecha_inicio+'</br>'+
                                '<label style="font-weight: bold;">Fecha Fin. : </label> '+r.fecha_final+'</br>'+
                                '<label style="font-weight: bold;">Fecha Amp. : </label> '+ r.fecha_ampliada +
                            '</p>'+
                        '</div>';
                }else if(r.tipo_respuesta == 2){
                        var dia = new Date(r.fecha_inicio);
                        var dia_semana = ["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo"];
                     html+='<div>'+
                                '<p style="font-weight: normal;">'+
                                    '<label style="font-weight: bold;">Fecha: </label> '+r.fecha_inicio+'</br>'+
                                    '<label style="font-weight: bold;">Día: </label> '+dia_semana[dia.getDay()] +'</br>'+
                                    '<label style="font-weight: bold;">Hora Inicio. : </label> '+r.hora_inicio+'</br>'+
                                    '<label style="font-weight: bold;">Hora Final. : </label> '+r.hora_final+
                                '</p>'+
                            '</div>';
                }else{
                  html+='<div></div>';
                }

                html+='</div>'+
                '</div>';

                if(r.referencia)
                {
                  var res_uri = r.referencia.split("|");
                  html+='<div class="row">'+
                            '<div class="col-md-12 btn-default" style="font-weight: normal; padding-right: 5px; padding-left: 5px; margin-top: 5px; overflow:hidden;">'+
                                '';
                                for (i = 0; i < res_uri.length; i++) {
                                  html+='<span class="fa fa-book fa-lg"></span> <a href="'+res_uri[i]+'" target="_blank">'+ res_uri[i] +'</a><br/>';
                                }
                      html+='</div>'+
                        '</div>';
                }

                html+='<div class="row">'+
                              '<div class="col-md-3" style="padding-right: 0px; padding-left: 5px; margin-top: 5px; overflow:hidden;">'+
                                '<button type="button" '+estadohtml+' class="col-xs-12 btn btn-danger"  data-placement="top" title="Eliminar"><span class="fa fa-trash fa-lg"></span> Eliminar</button>'+
                              '</div>'+
                              '<div class="col-md-3" style="padding-right: 0px; padding-left: 5px; margin-top: 5px; overflow:hidden;">'+
                                '<button type="button" onClick="AgregarEditar3(0,'+r.id+')" style="" class="col-xs-12 btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar"><span class="fa fa-edit fa-lg"></span> Editar</button>'+
                              '</div>'+
                              '<div class="col-md-3" style="padding-right: 0px; padding-left: 5px; margin-top: 5px; overflow:hidden;">';
                      if(r.tipo_respuesta==1){
                                html+='<button type="button" onClick="CargarContenidoProgramacion('+r.id+','+r.programacion_unica_id+',\''+r.unidad_contenido+'\',\''+r.titulo_contenido+'\',\''+r.fecha_inicio+'\',\''+r.fecha_final+'\',\''+r.fecha_ampliada+'\''+')" style="" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="Ampliación de Respuesta"><span class="fa fa-list fa-lg"></span>Ampl.</button>';
                      }
                                html+='</div>'+
                                      '<div class="col-md-3" style="padding-right: 0px; padding-left: 5px; margin-top: 5px; overflow:hidden;">';
                       if(r.tipo_respuesta==1){
                                html+='<button type="button" onClick="CargarContenidoRespuesta('+r.id+',\''+r.unidad_contenido+'\',\''+r.titulo_contenido+'\',\''+r.fecha_inicio+'\',\''+r.fecha_final+'\',\''+r.fecha_ampliada+'\''+')" class="col-xs-12 btn btn-info" data-toggle="tooltip" data-placement="top" title="Respuesta de Contenido"><span class="fa fa-list fa-lg"></span>Resp.</button>';
                            }
                              html+='</div>'+
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

VerCursos=function(){
    $("#CursosForm").css("display","");
    $("#ContenidoForm").css("display","none");
}
</script>
