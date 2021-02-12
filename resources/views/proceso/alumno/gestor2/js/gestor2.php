<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var TipoEvaluacionG={id:0, dni:"", alumno:"", curso:"", fecha_inicio:"", fecha_final:"", docente:"", estado:1}; // estado:1
var cursoG = '';
$(document).ready(function() {
    AjaxEvaluacionV2.CargaInicial(HTMLCargarEvaluacion);
    $('[data-toggle="tooltip"]').tooltip();

    $('#ModalEvaluacion').on('shown.bs.modal', function (event) {
        console.log('Cargando');
    });

    $('#ModalEvaluacion').on('hidden.bs.modal', function (event) {
    });
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
     tiempo= new Date().getTime();
     $("#imageCurso").attr("src",imagen+'?time='+tiempo);
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
        tiempo= new Date().getTime();

        html=
        '<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">'+
            '<a onClick="CargarContenido('+r.id+','+r.pu_id+','+r.curso_id+',\''+r.curso+'\',\''+r.imagen+'\')" href="#">'+
                '<img src="'+r.imagen+'?time='+tiempo+'" alt="'+r.curso+'" class="img-responsive">'+
            '</a>'+
            '<div style="text-align:center">'+
                '<h3 class="fh5co-work-title">Módulo: '+r.carrera+'</h3>'+
                /*'<a class="alertas btn btn-lg btn-info" data-toggle="tooltip" data-placement="bottom" title="Foro del Curso" onClick="VerForo(\''+r.curso+'\',\''+r.curso_id+'\',\''+r.curso_externo_id+'\');"><i class="fa fa-wechat fa-lg"></i></a>'+*/
                '<a class="alertas btn btn-lg btn-warning" data-toggle="tooltip" data-placement="bottom" title="Ver Detalle de evaluaciones" onClick="VerEvaluaciones(\''+r.curso+'\',\''+r.curso_id+'\',\''+r.curso_externo_id+'\');"><i class="fa fa-list fa-lg"></i></a>'+
                /*'<a class="alertas btn btn-lg btn-success" data-toggle="tooltip" data-placement="bottom" title="Solicita ayuda técnica" onClick="SolicitaAyuda(\''+r.curso+'\',\''+r.curso_externo_id+'\');"><i class="fa fa-slideshare fa-lg"></i></a>'+*/
                '<a class="alertas btn btn-lg btn-info" data-toggle="tooltip" data-placement="bottom" title="Certificado del curso" onClick="DescargarCertificado(\''+r.id+'\');"><i class="fa fa-download fa-lg"></i></a>'+
            '</div>'+
        '</div>';
        $("#cursosUnicos").append(html);
    });

    $.each(result.data2,function(index,r){
        if( $.trim(r.imagen)=='' ){
            r.imagen='archivo/no disponible.jpg';
        }
        if( $.trim(r.imagen2)=='' ){
            r.imagen2='archivo/no disponible.jpg';
        }

        if( $.trim(r.whatsapp)!='' ){
            r.whatsapp='https://api.whatsapp.com/send?phone=51'+r.whatsapp+'&text=Hola! Quiero inscribirme al curso de '+r.curso;
        }
        tiempo= new Date().getTime();

        html=
        '<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item imagenpago">'+
            '<a style="opacity: 0.3;" onClick="CursoNoInscrito(\''+r.curso+'\',\''+r.curso_externo_id+'\');" href="#">'+
                '<img src="'+r.imagen+'?time='+tiempo+'" alt="'+r.curso+'" class="img-responsive imagen1">'+
                '<img src="'+r.imagen2+'?time='+tiempo+'" alt="'+r.curso+'" class="img-responsive imagen2" style="display:none;">'+
            '</a>'+
            '<div style="text-align:center">'+
                '<h3 class="fh5co-work-title">Módulo: '+r.especialidad+'</h3>'+
                '<a class="alertas btn btn-lg btn-info" data-toggle="tooltip" data-placement="bottom" title="Descargar Brochure del Curso" onClick="DescargarBrochure(\''+$.trim(r.link)+'\');"><i class="fa fa-newspaper-o fa-lg"></i></a>'+
                '<a class="alertas btn btn-lg btn-warning" data-toggle="tooltip" data-placement="bottom" title="Solicitar que me llamen" onClick="SolicitarLlamada(\''+r.curso+'\',\''+r.curso_externo_id+'\');"><i class="fa fa-phone fa-lg"></i></a>'+
                '<a class="alertas btn btn-lg btn-success" data-toggle="tooltip" data-placement="bottom" title="Conectar con WhatsApp" onClick="ConectarWhatsApp(\''+r.whatsapp+'\');"><i class="fa fa-whatsapp fa-lg"></i></a>'+
                /*'<a class="alertas btn btn-lg btn-primary" data-toggle="tooltip" data-placement="bottom" title="Comprar Curso Online" onClick="ComprarCurso(\''+r.curso+'\',\''+r.curso_externo_id+'\');"><i class="fa fa-shopping-cart fa-lg"></i></a>'+*/
            '</div>'+
        '</div>';
        $("#cursosUnicos").append(html);
    });

    $('.imagenpago a').hover(
       function () {
          $(this).find(".imagen1").hide();
          $(this).find(".imagen2").show();
       },
       function () {
          $(this).find(".imagen2").hide();
          $(this).find(".imagen1").show();
       }
    );
};

DescargarCertificado = (id)=>{
    AjaxEvaluacionV2.DescargarCertificado(DescargarCertificadoHTML,id);
}

DescargarCertificadoHTML = (r)=>{
    if( r.rst==1 ){
        window.open(r.archivo_certificado, '_blank');
    }
    else if( r.rst==2 ){ 
        msjG.mensaje("success","Estamos generando su certificado",8000);
    }
    else if( r.rst==3 ){ 
        msjG.mensaje("warning","Tiene deuda pendiente",8000);
    }
}

ComprarCurso=function(curso, curso_id){
    cursoG= curso_id;
    msjG.mensaje("info","Estimado alumno, el pago online esta en construcción. Que tenga buen día.",6000);
}

ConectarWhatsApp=function(whatsapp){
    if( whatsapp!='' ){
        window.open(whatsapp, '_blank');
    }
    else{
        msjG.mensaje("info","El WhatsApp del curso aún no ha sido activado.",6000);
    }
}

DescargarBrochure=function(link){
    if( link!='' ){
        window.open(link, '_blank');
    }
    else{
        msjG.mensaje("info","El brochure del curso aún no ha sido cargado.",6000);
    }
}

SolicitarLlamada=function(curso, curso_id){
    cursoG = curso_id;
    sweetalertG.pregunta('Usted no esta inscrito a este curso','¿desea que se comuniquen con usted para inscribirla(o) al curso de "'+curso+'"?', EnviarAlerta)
}

VerForo=function(curso,curso_id,curso_externo_id){
    cursoG= curso_id;
    msjG.mensaje("info","Estimado alumno, el foro esta en construcción. Que tenga buen día.",6000);
}

VerEvaluaciones=function(curso,curso_id,curso_externo_id){
    cursoG= curso_externo_id;
    $("#ModalEvaluacion #txt_curso").val(curso);
    $("#ModalEvaluacion #btnsolicitar").attr("onClick","SolicitarCertificado("+curso_id+","+curso_externo_id+")");
    $('#ModalEvaluacion').modal('show');
    AjaxEvaluacionV2.VerEvaluaciones(VerEvaluacionesHTML,curso_id);
}

SolicitarCertificado=function(curso_id, curso_externo_id){
    AjaxEvaluacionV2.SolicitarCertificado(SolicitarCertificadoHTML,curso_id);
}

SolicitarCertificadoHTML=function(r){
    if( r.rst==1 ){
        AjaxEvaluacionV2.EnviarAlerta(EnviarAlertaHTML,cursoG,2);
    }
    else{
        msjG.mensaje("info","Estimado alumno, Usted no ha aprobado el curso aún",8000);
    }
}

VerEvaluacionesHTML=function(result){
    var html='';
    $("#misevaluaciones tbody").html(html);
    $.each(result.data,function(index,r){
        html='<tr>';
        html+='<td>'+r.tipo_evaluacion+'</td>';
        html+='<td>'+r.nota+'</td>';
        html+='<td>'+r.fecha_examen+'</td>';
        if( index==0 ){
            html+='<td id="notafinalalumno" style="text-align:center;" rowspan="'+result.data.length+'">'+r.nota_final+'</td>';
        }

        if( r.nota_final>0 ){
            $("#notafinalalumno").text(r.nota_final);
        }
        html+='</tr>';
        $("#misevaluaciones tbody").append(html);
    });
}

SolicitaAyuda=function(curso,curso_id){
    cursoG = curso_id;
    sweetalertG.pregunta('Usted esta solicitando ayuda técnica','¿desea que se comuniquen con usted para brindarle ayuda técnica del curso de "'+curso+'"', EnviarAlertaPersonalizada)
}


CursoNoInscrito=function(curso,curso_id){
    cursoG = curso_id;
    sweetalertG.pregunta('Usted no esta inscrito a este curso','¿desea que se comuniquen con usted para inscribirla(o) al curso de "'+curso+'"?', EnviarAlerta)
}

EnviarAlerta=function(){
    AjaxEvaluacionV2.EnviarAlerta(EnviarAlertaHTML,cursoG);
}

EnviarAlertaPersonalizada=function(){
    AjaxEvaluacionV2.EnviarAlerta(EnviarAlertaHTML,cursoG,1);
}

EnviarAlertaHTML=function(r){
    if( r.rst==1 ){
        msjG.mensaje("info","Estimado alumno, un gestor se estará comunicando con Ud. Que tenga buen día.",8000);
    }
}

</script>
