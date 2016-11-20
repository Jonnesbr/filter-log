<?php header("Content-Type: text/html; charset=UTF-8", true); ?>
<table id="table_perfil" class="table table-striped">
    <thead>
    <tr>
        <th class="">Cliente</th>
        <th class="">Endereço IP</th>
        <th class="text-center">Status</th>
        <th class="text-center"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) :?>
        <tr>
            <td><?php echo $row['nome']?></td>
            <td><?php echo $row['ip']?></td>
            <td class="center-vertical"><?php echo ($row['status']) ? '<span class="label label-success ">Ativo</span>' : '<span class="label label-danger">Inativo</span>' ;?></td>
            <td class="center-vertical">
                <div class="btn-group" role="group" aria-label="...">
                    <a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url().'Admin/Cliente/cadastro/' . $row['id'];?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <?php if ($row['status'] == STATUS_ATIVO) : ?>
                        <a type="button" class="btn btn-danger btn-sm btn-status" href="#" data-index="Admin/Cliente/index/" data-url="Admin/Cliente/status/" data-id="<?php echo $row['id']?>" title="Inativar Cliente"><i class='fa fa-lock' aria-hidden='true'></i></a>
                    <?php else : ?>
                        <a type="button" class="btn btn-success btn-sm btn-status" href="#" data-index="Admin/Cliente/index/" data-url="Admin/Cliente/status/" data-id="<?php echo $row['id']?>" title="Ativar Cliente"><i class="fa fa-unlock" aria-hidden="true"></i></a>
                    <?php endif?>
                    <a type="button" class="btn btn-danger btn-sm btn-delete" href="#" data-index="Admin/Cliente/index/" data-url="Admin/Cliente/delete/" data-id="<?php echo $row['ip']?>" title="Excluir Cliente"><i class="fa fa-trash" aria-hidden="true"></i></a>
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