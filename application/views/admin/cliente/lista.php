<?php header("Content-Type: text/html; charset=UTF-8", true); ?>
<table id="table_perfil" class="table table-striped">
    <thead>
    <tr>
        <th class="">Cliente</th>
        <th class="">Endereço IP</th>
        <th class="text-center"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) :?>
        <tr>
            <td><?php echo $row['nome']?></td>
            <td><?php echo $row['ip']?></td>
            <td class="pull-right">
                <div class="btn-group">
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-wrench"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url().'Admin/Cliente/cadastro/'.$row['id'];?>" title="<?php echo $this->lang->line('editar');?>"><i class="fa fa-pencil fa-fw"></i><?php echo $this->lang->line('editar');?></a></li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<div class="pagination-filter">
    <?php if (isset($links) && !empty($links)){ ?>
        <ul class="pagination"><?php echo $links; ?></ul>
    <?php } ?>
</div>