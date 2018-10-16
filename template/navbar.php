<?php require_once('php/logout.php'); ?>

<nav id="navbar" class="navbar navbar-inverse">
  <div class="container-fluid">

    <div class="navbar-header">
      <?php if(!$noMobileNavbar): ?>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php endif ?>
      <a class="navbar-brand" href="#">Oma<b>Pankki</b></a>
    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
      <!--
      <ul class="nav navbar-nav">
         <li><a href="">Tilit ja Kortit</a></li>
         <li><a href="">E-Laskut</a></li>
         <li><a href="">Omat tiedot</a></li>
         <li><a href="">Viestit</a></li>
      </ul>
      -->
      <?php if(!$noMobileNavbar): ?>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="?logout=true" class="logout">Kirjaudu ulos <span class="glyphicon glyphicon-log-in"></span></a></li>
      </ul>
   <?php endif ?>

    </div>

  </div>
</nav>
