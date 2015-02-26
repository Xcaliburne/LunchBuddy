<?php

function AfficheHeader() {
    ?>
    <header class="navbar-inverse navbar-fixed-top">
        <section class="navbar-header">
            <a class="navbar-brand" href="Index.php">LunchBuddy</a>
        </section>
        <section class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">     
                <li><a href="parametres.php">Paramètres</a></li>
                <li><a href="Rendezvous.php">Rendez-vous</a></li> 
                <li><a href="Deconnexion.php"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
            </ul>
        </section>
    </header>
    <?php
}

function AfficheFooter() {
    ?>
    <footer class=" navbar navbar-inverse navbar-fixed-bottom">
    </footer>
    <?php
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

