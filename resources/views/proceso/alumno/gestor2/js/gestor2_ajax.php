<script type="text/javascript">
var AjaxEvaluacionV2={
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#TipoEvaluacionForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#TipoEvaluacionForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#TipoEvaluacionForm input[type='hidden']").not('.mant').remove();

        url='AjaxDinamic/Proceso.EvaluacionPR@Load';
        masterG.postAjax(url,data,evento);
    },
    CargaInicial:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#TipoEvaluacionForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#TipoEvaluacionForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#TipoEvaluacionForm input[type='hidden']").not('.mant').remove();

        url='AjaxDinamic/Proceso.EvaluacionPR@validarCurso';
        masterG.postAjax(url,data,evento);
    }
};

</script>
