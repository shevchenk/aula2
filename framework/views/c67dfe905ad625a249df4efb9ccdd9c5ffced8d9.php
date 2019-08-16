<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Plantilla</title>

        <?php $__env->startSection('include'); ?>
        <?php echo e(Html::style('lib/bootstrap/css/bootstrap.min.css')); ?> 
        <?php echo e(Html::script('lib/bootstrap/js/bootstrap.min.js')); ?>


        <?php echo $__env->yieldSection(); ?>
    </head>

    <body class="skin-blue sidebar-mini sidebar-collapse">
        <div class="wrapper">
            <div class="content-wrapper">
                <table style="width: 100% !important">
                    <tr>
                        <td class="c1">
                            <b>CARRERA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            <?php echo e($head->carrera); ?>

                        </td>
                        <td class="c1">
                            <b>SEMESTRE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            <?php echo e($head->semestre); ?>

                        </td>
                    </tr>
                    <tr>
                        <td class="c1">
                            <b>CURSO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            <?php echo e($head->curso); ?>

                        </td>
                        <td class="c1">
                            <b>CICLO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            <?php echo e($head->ciclo); ?>

                        </td>
                    </tr>
                    <tr>
                        <td class="c1">
                            <b>PROFESOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            <?php echo e($head->profesor); ?>

                        </td>
                        <td class="c1">
                            <b>TIPO EVALUACIÓN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                        </td>
                        <td class="c2">
                            <?php echo e($head->tipo_evaluacion); ?>

                        </td>
                    </tr>
                </table>
                <hr>
                <div>
                    <?php if(isset($preguntas)): ?>
                    <ol>
                        <?php $__currentLoopData = $preguntas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php  
                        $k=explode('|',$key); 
                        $img='';
                        if($k[1]!=null){
                        $img='<img src="img/question/'.$k[1].'" style="width:200px"><br>';
                        }
                         ?>
                        <li><?php echo $img ?><?php echo e($k[0]); ?></li>
                        <ul>
                            <?php $__currentLoopData = $val; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($k->respuesta); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                    <?php endif; ?>
                </div>

            </div>
        </div><!-- ./wrapper -->
    </body>
</html>

