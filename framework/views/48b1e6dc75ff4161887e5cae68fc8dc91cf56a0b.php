  

<?php $__env->startSection('include'); ?>
##parent-placeholder-d3ecb0d890368d7659ee54010045b835dacb8efe##
<?php echo e(Html::style('lib/datatables/dataTables.bootstrap.css')); ?>

<?php echo e(Html::script('lib/datatables/jquery.dataTables.min.js')); ?>

<?php echo e(Html::script('lib/datatables/dataTables.bootstrap.min.js')); ?>


<?php echo e(Html::style('lib/bootstrap-select/dist/css/bootstrap-select.min.css')); ?>

<?php echo e(Html::script('lib/bootstrap-select/dist/js/bootstrap-select.min.js')); ?>

<?php echo e(Html::script('lib/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js')); ?>


<?php echo e(Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>

<?php echo e(Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>

<?php echo e(Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js')); ?>


<?php echo $__env->make( 'mantenimiento.curso.js.curso_ajax' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make( 'mantenimiento.curso.js.curso' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Curso
        <small>Mantenimiento</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-sitemap"></i> Mantenimiento</a></li>
        <li class="active">Curso</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form id="CursoForm">
                    <div class="box-body table-responsive no-padding">
                        <table id="TableCurso" class="table table-bordered table-hover">
                            <thead>
                                <tr class="cabecera">
                                    <th class="col-xs-3">
                                        <div class="form-group">
                                            <label><h4>Curso:</h4></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                                <input type="text" class="form-control" name="txt_curso" id="txt_curso" placeholder="Curso" onkeypress="return masterG.enterGlobal(event, '.input-group', 1);">
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-xs-1">
                                        <div class="form-group">
                                            <label><h4>Imagen de Lista:</h4></label>
                                        </div>
                                    </th>
                                    <th class="col-xs-4">
                                        <div class="form-group">
                                            <label><h4>Imagen de Cabecera:</h4></label>
                                        </div>
                                    </th>
                                    <th class="col-xs-1">[Editar]</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr class="cabecera">
                                    <th>Curso</th>
                                    <th>Imagen de Lista</th>
                                    <th>Imagen de Cabecera</th>
                                    <th>[Editar]</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- .box-body -->
                </form><!-- .form -->
            </div><!-- .box -->
        </div><!-- .col -->
    </div><!-- .row -->
</section><!-- .content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('form'); ?>
<?php echo $__env->make( 'mantenimiento.curso.form.curso' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>