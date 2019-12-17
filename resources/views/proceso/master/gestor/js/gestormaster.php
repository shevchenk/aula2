<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var ProgramacionUnicaG={id:0,tipo_respuesta:"",estado:1}; // Datos Globales
$(document).ready(function() {
    AjaxProgramacionUnicaMaster.CargaInicial(HTMLCargarProgramacionUnica);

    $('#ModalAprobados').on('shown.bs.modal', function (event) {
        AjaxProgramacionUnicaMaster.CargarAprobados(HTMLCargarAprobados);
    });

    $('#ModalAprobados').on('hidden.bs.modal', function (event) {
        $("#DivAprobados").html('');
    });
});

CargarContenido=function(id,curso_id,curso,imagen,boton){
     $("#ContenidoForm #txt_programacion_unica_id").val(id);
     $("#ModalAprobados #txt_programacion_unica_id").val(id);
     $("#ModalContenidoForm #txt_programacion_unica_id").val(id);
     $("#ModalContenidoForm #txt_curso_id").val(curso_id);
     $("#ModalContenidoForm #txt_curso").val(curso);
     $("#ContenidoForm #div_cabecera").text(curso);
     $("#imageCurso").attr("src",imagen);
     redimensionG.validar();
     ListarUnidadContenido();
     AjaxContenidoMaster.Cargar(HTMLCargarContenido);
     $("#ContenidoForm").css("display","");
     $("#CursosForm").css("display","none");
};

HTMLCargarProgramacionUnica=function(result){
    var html="";
    $("#cursosUnicos").html(html);
    $.each(result.data.data,function(index,r){
        if( $.trim(r.imagen)=='' ){
            r.imagen='archivo/no disponible.jpg';
        }
        html=
        '<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 work-item">'+
            '<a onClick="CargarContenido('+r.id+','+r.curso_id+',\''+r.curso+'\',\''+r.imagen+'\',this)" href="#">'+
                '<img src="'+r.imagen+'" alt="'+r.curso+'" class="img-responsive">'+
                '<h3 class="fh5co-work-title">'+r.carrera+'</h3>'+
            '</a>'+
        '</div>';
        $("#cursosUnicos").append(html);
    });
};

HTMLCargarAprobados=function(result){
    var html="";
    $("#DivAprobados").html(html);
    $.each(result.data,function(index,r){
        html=
        '<tr>'+
            '<td>'+(index+1)+'</td>'+
            '<td>'+r.dni+'</td>'+
            '<td>'+r.paterno+'</td>'+
            '<td>'+r.materno+'</td>'+
            '<td>'+r.nombre+'</td>'+
            '<td><a class="btn btn-success" style="font-size:18px;" href="ReportDinamic/Proceso.EvaluacionPR@DescargarCertificado?programacion_id='+r.id+'&nota_minima='+r.nota_final+'&quitar_firma=1" target="_blank"><i class="fa fa-file-pdf-o fa-lg"></i>&nbsp;'+r.nota_final+'</a></td>'+
            '<td><input class="chkall" type="checkbox" value="'+r.id+'"></td>'+
        '</tr>';
        $("#DivAprobados").append(html);
    });
}

VerAprobados=function(){
    $('#ModalAprobados').modal('show');
}

ChkAll=function(t){
    if( $(t).is(':checked') ) {
        $(".chkall").prop( "checked", true );
    }
    else{
        $(".chkall").prop( "checked", false );
    }
}

EnviarMasivo=function(){
    var datos=[];
    $(".chkall").each(function(){
        if( $(this).is(':checked') ) {
            datos.push($(this).val());
        }
    })

    if( datos.length==0 ){
        msjG.mensaje('warning','Seleccione almenos 1 check',4000);
    }
    else{
        window.open('ReportDinamic/Proceso.EvaluacionPR@DescargarCertificadoMasivo?programacion_id='+datos.join(",")+'&nota_minima=0&quitar_firma=1', '_blank');
    }
}
</script>
