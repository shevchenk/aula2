<script type="text/javascript">
var AjaxProgramacionUnica={
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ProgramacionUnicaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#ProgramacionUnicaForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ProgramacionUnicaForm input[type='hidden']").not('.mant').remove();
        
        url='AjaxDinamic/Proceso.EvaluacionPR@Load';
        masterG.postAjax(url,data,evento);
    },
    CargaInicial:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ProgramacionUnicaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#ProgramacionUnicaForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ProgramacionUnicaForm input[type='hidden']").not('.mant').remove();
        
        url='AjaxDinamic/Proceso.EvaluacionPR@validarCurso';
        masterG.postAjax(url,data,evento);
    }
};

</script>
