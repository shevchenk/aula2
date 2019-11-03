<script type="text/javascript">
var AddEdit=0; //0: Editar | 1: Agregar
var ProgramacionUnicaG={id:0,tipo_respuesta:"",estado:1}; // Datos Globales
$(document).ready(function() {
    AjaxProgramacionUnicaMaster.CargaInicial(HTMLCargarProgramacionUnica);
});

CargarContenido=function(id,curso_id,curso,imagen,boton){
     $("#ContenidoForm #txt_programacion_unica_id").val(id);
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
                '<h3 class="fh5co-work-title">'+r.curso+'</h3>'+
                '<p>Fecha de Inicio: '+r.fecha_inicio+'</p>'+
            '</a>'+
        '</div>';
        $("#cursosUnicos").append(html);
    });
};

</script>
