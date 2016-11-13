<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $this->lang->line('configuracao_permissoes_acesso');?></h3>
  </div>
  <div class="panel-body">
    <?php
    if (isset($retorno['mensagem']) && $retorno['mensagem']) :
        $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
        echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
    endif;

    echo form_open(base_url() . 'Admin/PermissaoAcesso/cadastro/' . $id_perfil);
        ?>
        <div class="row">
          <div class="col-md-12 form-group">
              <h4>
                <?php echo $this->lang->line('permissoes_do_perfil') . ' <span class="text-info">' . $perfil . '</span>'; ?>
              </h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 form-group">
            <div class='checkbox'>
              <label>
                <?php
                $checked = (set_checkbox('select_all', '1')) ? set_checkbox('select_all', '1') : false;
                echo form_checkbox(array("name" => "select_all", "value" => "1", 'checked' => $checked, 'class' => 'select-all'));
                echo $this->lang->line('selecionar_todos');
                ?>
              </label>
            </div>
            <?php
            if ($perfilRegras) :
                $contexto = null;
                foreach ($perfilRegras as $regra) :
                    if ($contexto != $regra['contexto']) :
                        $contexto = $regra['contexto'];
                        echo "<label for='{$contexto}' class='margin-top-1'>{$contexto}</label>";
                    endif;
                    ?>
                    <div class='checkbox'>
                      <label>
                        <?php
                        $checked = (set_checkbox('perfil_regra[]', $regra['id'])) ? set_checkbox('perfil_regra[]', $regra['id']) : (in_array($regra['id'], $perfilRegraPermissoes));
                        echo form_checkbox(array("name" => "perfil_regra[]", "value" => "{$regra['id']}", 'checked' => $checked, 'class' => 'checkbox-check'));
                        echo $regra['descricao'];
                        ?>
                      </label>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-7 text-right">
            <input name="submitCadastro" class="btn btn-success" id="submitCadastro" type="submit" value="<?php echo $this->lang->line('salvar'); ?>"/>
            <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Perfil" value="<?php echo $this->lang->line('voltar'); ?>"/>
           </div>
        </div>
    <?php echo form_close(); ?>
  </div>
</div>
