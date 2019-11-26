<script type="text/javascript">
var AjaxProgramacionUnicaMaster={
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ProgramacionUnicaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#ProgramacionUnicaForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ProgramacionUnicaForm input[type='hidden']").not('.mant').remove();
        
        url='AjaxDinamic/Proceso.ProgramacionUnicaPR@Load';
        masterG.postAjax(url,data,evento);
    },
    CargaInicial:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ProgramacionUnicaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#ProgramacionUnicaForm").serialize().split("txt_").join("").split("slct_").join("");
        $("#ProgramacionUnicaForm input[type='hidden']").not('.mant').remove();
        
        url='AjaxDinamic/Proceso.ProgramacionUnicaPR@validarProgramacionMaster';
        masterG.postAjax(url,data,evento);
    },
    CargarAprobados:function(evento){
        data=$("#ModalAprobadosForm").serialize().split("txt_").join("").split("slct_").join("");
        url='AjaxDinamic/Proceso.ProgramacionUnicaPR@CargarAprobados';
        masterG.postAjax(url,data,evento);
    },
};

</script>
