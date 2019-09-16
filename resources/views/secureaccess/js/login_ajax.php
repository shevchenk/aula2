<script type="text/javascript">
var AjaxLogin={
    IniciarLogin:function(evento){
        var datos=$("#logForm").serialize();
        var url='AjaxDinamic/SecureAccess.PersonaSA@ValidaPersona';
        masterG.postAjax(url,datos,evento);
    }
}
</script>
