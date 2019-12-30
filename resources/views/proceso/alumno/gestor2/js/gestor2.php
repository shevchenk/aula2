<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var TipoEvaluacionG={id:0, dni:"", alumno:"", curso:"", fecha_inicio:"", fecha_final:"", docente:"", estado:1}; // estado:1
var cursoG = '';
$(document).ready(function() {
    AjaxEvaluacionV2.CargaInicial(HTMLCargarEvaluacion);
});


CargarContenido=function(programacion_id,id,curso_id,curso,imagen,boton){
    AjaxContenidoV2.ValidaCarga(ValidaCarga,programacion_id,id,curso_id,curso,imagen);
};

ValidaCarga=function(result){
    if(result.val==1){
        CargarContenidoOk(result.programacion_id,result.id,result.curso_id,result.curso,result.imagen);
    }
    else{
        $("#ContenidoForm").css("display","none");
        msjG.mensaje("info","Estimado alumno, el curso "+result.curso+" inicia el "+result.fecha,5000);
    }
}

CargarContenidoOk=function(programacion_id,id,curso_id,curso,imagen){
     $("#ContenidoForm #txt_programacion_id").val(programacion_id);
     $("#ContenidoForm #txt_programacion_unica_id").val(id);
     $("#ModalContenidoForm #txt_programacion_unica_id").val(id);
     $("#ModalContenidoForm #txt_curso_id").val(curso_id);
     $("#ModalContenidoForm #txt_curso").val(curso);
     $("#ContenidoForm #div_cabecera").text(curso);
     $("#imageCurso").attr("src",imagen);
     redimensionG.validar();
     AjaxContenidoV2.Cargar(HTMLCargarContenido);
     $("#ContenidoForm").css("display","");
     $("#CursosForm").css("display","none");
     $('#div_contenido_respuesta').hide();
}

HTMLCargarEvaluacion=function(result){
    var html="";
    $("#cursosUnicos").html(html);
    $.each(result.data.data,function(index,r){
        if( $.trim(r.imagen)=='' ){
            r.imagen='archivo/no disponible.jpg';
        }
        html=
        '<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">'+
            '<a onClick="CargarContenido('+r.id+','+r.pu_id+','+r.curso_id+',\''+r.curso+'\',\''+r.imagen+'\')" href="#">'+
                '<img src="'+r.imagen+'" alt="'+r.curso+'" class="img-responsive">'+
                '<h3 class="fh5co-work-title">'+r.carrera+'</h3>'+
            '</a>'+
        '</div>';
        $("#cursosUnicos").append(html);
    });

    $.each(result.data2,function(index,r){
        if( $.trim(r.imagen)=='' ){
            r.imagen='archivo/no disponible.jpg';
        }
        html=
        '<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item" style="opacity: 0.3;">'+
            '<a onClick="CursoNoInscrito(\''+r.curso+'\',\''+r.curso_externo_id+'\');" href="#">'+
                '<img src="'+r.imagen+'" alt="'+r.curso+'" class="img-responsive">'+
                '<h3 class="fh5co-work-title">'+r.especialidad+'</h3>'+
            '</a>'+
        '</div>';
        $("#cursosUnicos").append(html);
    });
};


CursoNoInscrito=function(curso,curso_id){
    cursoG = curso_id;
    sweetalertG.confirm('Curso No Inscrito','Estimado alumno, desea inscribirse en el curso "'+curso+'"', EnviarAlerta)
    //msjG.mensaje("info","Estimado alumno, no ha sido inscrito en el curso  "+curso,10000);
}

EnviarAlerta=function(){
    AjaxEvaluacionV2.EnviarAlerta(EnviarAlertaHTML,cursoG);
}

EnviarAlertaHTML=function(r){
    if( r.rst==1 ){
        msjG.mensaje("info","Estimado alumno, un gestor se estará comunicando con Ud. Que tenga buen día.",8000);
    }
}

</script>
