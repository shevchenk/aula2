<script type="text/javascript">
var AjaxCurso={
    AgregarEditar:function(evento){
        var data=$("#ModalCursoForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Mantenimiento.CursoEM@New';
        if(AddEdit==0){
            url='AjaxDinamic/Mantenimiento.CursoEM@Edit';
        }
        masterG.postAjax(url,data,evento);
    },
    CargarAjax:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#CursoForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#CursoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#CursoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.CursoEM@validarCursoMaster';
        
        masterG.postAjax(url,data,evento);
    },
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#CursoForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#CursoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#CursoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.CursoEM@Load';
        
        masterG.postAjax(url,data,evento);
    },
    CargarUnidadContenido:function(evento){
        data=$("#ModalCursoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ModalCursoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.CursoEM@CargarUnidadContenido';
        
        masterG.postAjax(url,data,evento);
    },
    CargarTipoEvaluacionAjax:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#CursoForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#CursoForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#CursoForm input[type='hidden']").not('.mant').remove();
        url='AjaxDinamic/Mantenimiento.CursoEM@CargarTipoEvaluacionMaster';
        
        masterG.postAjax(url,data,evento);
    },
};

</script>
