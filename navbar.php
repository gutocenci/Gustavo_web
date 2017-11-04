<?php
$page = str_replace('/', '', str_replace('.php', '', $_SERVER['SCRIPT_NAME']));
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Gustavo Cenci</a>
    </div>
    <ul class="nav navbar-nav">
      <li<?php echo $page == 'motoristas' ? ' class="active"' : '';?>><a href="motoristas.php">Motoristas</a></li>
      <li<?php echo $page == 'passageiros' ? ' class="active"' : '';?>><a href="passageiros.php">Passageiros</a></li>
      <li<?php echo $page == 'corridas' ? ' class="active"' : '';?>><a href="corridas.php">Corridas</a></li>
    </ul>
  </div>
</nav>