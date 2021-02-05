<script type="text/javascript">
var AjaxProgramacionUnica={
    Cargar:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ProgramacionUnicaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        $("#ProgramacionUnicaForm").append("<input type='hidden' value='<?php echo Auth::user()->dni;?>' name='dni'>");
        data=$("#ProgramacionUnicaForm").serialize().split("txt_").join("").split("slct_").join("")+"&vista_docente=1";
        $("#ProgramacionUnicaForm input[type='hidden']").not('.mant').remove();
        
        url='AjaxDinamic/Proceso.ProgramacionUnicaPR@Load';
        masterG.postAjax(url,data,evento);
    },
    CargaInicial:function(evento,pag){
        if( typeof(pag)!='undefined' ){
            $("#ProgramacionUnicaForm").append("<input type='hidden' value='"+pag+"' name='page'>");
        }
        data=$("#ProgramacionUnicaForm").serialize().split("txt_").join("").split("slct_").join("")+"&vista_docente=1";
        $("#ProgramacionUnicaForm input[type='hidden']").not('.mant').remove();
        
        url='AjaxDinamic/Proceso.ProgramacionUnicaPR@validarProgramacion';
        masterG.postAjax(url,data,evento);
    },
    ReplicarTemplate:function(evento,curso_id,id){
        var data={programacion_unica_id:id,curso_id:curso_id};
        url='AjaxDinamic/Proceso.ProgramacionUnicaPR@ReplicarTemplate';
        masterG.postAjax(url,data,evento);
    }
};

</script>
