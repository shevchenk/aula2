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
    },
    EnviarAlerta:function(evento,curso,tipo){
        url='AjaxDinamic/Proceso.EvaluacionPR@EnviarAlerta';
        data={curso:curso};
        if( $.trim(tipo)=='1' || $.trim(tipo)=='2' ){
            data={curso:curso, tipo:tipo}
        }
        //console.log(data);
        masterG.postAjax(url,data,evento);
    },
    VerEvaluaciones:function(evento,curso_id){
        url='AjaxDinamic/Proceso.EvaluacionPR@VerEvaluaciones';
        data = {curso_id:curso_id}
        masterG.postAjax(url,data,evento);
    },
    SolicitarCertificado:function(evento,curso_id){
        url='AjaxDinamic/Proceso.EvaluacionPR@SolicitarCertificado';
        data = {curso_id:curso_id}
        masterG.postAjax(url,data,evento);
    },

    DescargarCertificado : (evento, id)=>{
        url='AjaxDinamic/Proceso.EvaluacionPR@DescargarCertificadoV2';
        data = {id:id}
        masterG.postAjax(url,data,evento);
    } 
};

</script>
