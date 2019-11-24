<script type="text/javascript">
var AjaxTipoEvaluacion={
    Cargar:function(evento,pag){
        var programacion_id = $("#EvaluacionForm #txt_programacion_id").val();
        var estado_cambio = $("#EvaluacionForm #txt_estado_cambio").val();
        var valida_evaluacion = $("#EvaluacionForm #txt_valida_evaluacion").val();
        data={programacion_id:programacion_id,estado_cambio:estado_cambio,valida_evaluacion:valida_evaluacion};
        url='AjaxDinamic/Proceso.TipoEvaluacionPR@LoadValidacion';
        masterG.postAjax(url,data,evento);
    },
    CargarPreguntas:function(evento){
        var programacion_unica_id = $("#ResultEvaluacion #txt_programacion_unica_id").val();
        var programacion_id = $("#ResultEvaluacion #txt_programacion_id").val();
        var tipo_evaluacion_id = $("#ResultEvaluacion #txt_tipo_evaluacion_id").val();
        var valida_evaluacion = $("#EvaluacionForm #txt_valida_evaluacion").val();
        var nota_minima = $("#EvaluacionForm #txt_nota_minima").val();
        $("#ContenidoForm input[type='hidden']").not('.mant').remove();

        var data={programacion_unica_id:programacion_unica_id,
                  programacion_id:programacion_id,
                  tipo_evaluacion_id : tipo_evaluacion_id,
                  valida_evaluacion:valida_evaluacion,
                  nota_minima:nota_minima,
                  validacion: 1
                  };
        url='AjaxDinamic/Proceso.EvaluacionPR@cargarPreguntas';
        masterG.postAjax(url,data,evento);
    },
    VerResultPreguntas:function(evento){
        //var programacion_unica_id = $("#ResultEvaluacion #txt_programacion_unica_id").val();
        var programacion_id = $("#ResultFinalEvaluacion #txt_programacion_id").val();
        var evaluacion_id = $("#ResultFinalEvaluacion #txt_evaluacion_id").val();
        $("#ContenidoForm input[type='hidden']").not('.mant').remove();

        var data={programacion_id:programacion_id,
                  evaluacion_id : evaluacion_id};
        url='AjaxDinamic/Proceso.EvaluacionPR@verResultPreguntas';
        masterG.postAjax(url,data,evento);
    },
    GuardarEvaluacion:function(evento){
        var evaluaciones_id = 1;
        var data = {datos:JSON.stringify(data_alter_preg)};
        //alert(JSON.stringify(data_alter_preg));
        url='AjaxDinamic/Proceso.EvaluacionPR@guardarEvaluacion';
        masterG.postAjax(url,data,evento);
    },
    GuardarNota:function(nota){
        var data={programacion_id : $("#EvaluacionForm #txt_programacion_id").val(),
                  nota : nota};
        url='AjaxDinamic/Proceso.EvaluacionPR@guardarNota';
        masterG.postAjax(url,data);
    },
};

</script>
