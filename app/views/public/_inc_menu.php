<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="#">UNP</a>
        <ul class="nav">
            <li class="dropdown"><a href="<?php echo WWWROOT?>" class="dropdown">Início</a></li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">Produtos<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo WWWROOT?>/products">Listar Produtos</a></li>
                    <li><a href="<?php echo WWWROOT?>/products/add">Novo Produto</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">Usuários<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo WWWROOT?>/users">Listar Usuários</a></li>
                    <li><a href="<?php echo WWWROOT?>/users/add">Novo Usuário</a></li>
                </ul>
            </li>
            <?php if ($_SESSION):?>
            <li><a href="<?php echo WWWROOT?>/session/logout"><?php echo $_SESSION['nome']?> - Logout</a></li>
            <?php else:?>
            <li><a href="<?php echo WWWROOT?>/session/login">Login</a></li>
            <?php endif;?>
        </ul>
    </div>
</div>