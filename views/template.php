<!DOCTYPE html>
<html lang="pt-br">
    <?php echo $titulo; ?>
    <body style="background: url(<?php echo base_url(); ?>assets/dist/img/background.jpg)">
        <?php echo $cabecalho;?>
        <div class="container-fluid">
            <?php
            if (isset($breadcrumbs) && $breadcrumbs) :
                echo "<ol class='breadcrumb hidden-print'>";
                echo $breadcrumbs;
                echo "</ol>";
            endif;

            echo $principal;
            ?>
        </div>
        <div class="footer">
            <?php echo $rodape;?>
        </div>
</body>
</html>