<?php header("Content-Type: text/html; charset=UTF-8", true); ?>
<table id="table_usuario" class="table table-striped">
	<thead>
		<tr>
			<th class=""><?php echo $this->lang->line('nome');?></th>
			<th class=""><?php echo $this->lang->line('email');?></th>
			<th class=""><?php echo $this->lang->line('perfil');?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($result as $row) :?>
				<tr>
					<td><?php echo $row['nome']?></td>
					<td><?php echo $row['email']?></td>
					<td><?php echo $row['perfil']?></td>
					<td class="text-right">
						<div class="btn-group">
  							<a class="btn btn-primary" href="#"><i class="fa fa-bars fa-fw"></i> <?php echo $this->lang->line('acoes');?></a>
  							<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    							<span class="fa fa-caret-down"></span>
    						</a>
							<ul class="dropdown-menu">
								<li>
									<a class="editar-lista" href="<?php echo base_url().'Admin/Usuario/cadastro/'.$row['id'];?>" title="<?php echo $this->lang->line('editar');?>"><i class="fa fa-pencil fa-fw"></i><?php echo $this->lang->line('editar');?></a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
		<?php
			endforeach;?>
	</tbody>
</table>
<div class="pagination-filter">
<?php if (isset($links) && !empty($links)){ ?>
	<ul class="pagination"><?php echo $links; ?></ul>
<?php } ?>
</div>