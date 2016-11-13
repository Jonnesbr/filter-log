<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url(); ?>Admin/Dashboard/index">
        <img class="logo-menu" src="<?php echo base_url(); ?>assets/dist/img/logo-menu.png">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-left">
        <?php
        if ($menuLogadoAdmin) :
            foreach ($menuLogadoAdmin as $descricao => $link) :
                ?>
                <li class="dropdown">
                  <a href="<?php echo (!is_array($link)) ? base_url() . 'Admin/' . $link  : 'class="dropdown-toggle" data-toggle="dropdown"'; ?>" role="button" aria-expanded="false">
                    <?php
                    echo $descricao;
                    echo (is_array($link)) ? '<span class="caret"></span>' : '';
                    ?>
                  </a>
                  <?php
                  if (is_array($link)) :
                    ?>
                    <ul class="dropdown-menu" role="menu">
                      <?php
                      foreach ($link as $descricao => $link)
                        echo "<li><a href='" . base_url() . 'Admin/' . $link . "'>{$descricao}</a></li>";
                      ?>
                    </ul>
                    <?php
                  endif;
                  ?>
                </li>
                <?php
            endforeach;
        endif;
        ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <i class="fa fa-user"></i> <?php echo $adminLogadoNome; ?> <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li>
              <a href="<?php echo base_url(); ?>Admin/Login/logout" class='navbar-link'><i class="fa fa-sign-out"></i> <?php echo $this->lang->line('sair'); ?></a>
            </li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>