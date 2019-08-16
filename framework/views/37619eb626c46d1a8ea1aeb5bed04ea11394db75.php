  

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




<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>API
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
                <h3>Redireccionamiento ok: | <?php echo e($mensaje); ?></h3>
            </div><!-- .box -->
        </div><!-- .col -->
    </div><!-- .row -->
</section><!-- .content -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>