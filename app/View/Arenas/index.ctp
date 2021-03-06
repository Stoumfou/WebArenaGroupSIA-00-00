<?php
$this->Html->meta('description', 'WebArena le site de jeu de combat d\'arène multijoueurs', array('inline' => false));
?>

<div class="jumbotron">
    <h1>WebArenas</h1>

    <p>Bienvenue dans WebArenas <span id="PlayerName"><?php echo $myname; ?></span></p>

    <p> Es-tu prêt à entrer dans l'arène ?</p>

    <div class="row">
        <?php echo $this->Html->link('Go !', array('controller' => 'Arenas', 'action' => 'fighter'), array('class'=>'btn btn-lg btn-primary')) ?>
    </div>
</div>
<div class="panel panel-info">
<div class="panel-heading"><div class="panel-title"><h2>Principe du jeu</h2></div></div>
    <div class="panel-body"><p>
    WebArenas est un site de jeu multi-joueurs de combat dans une arène.<br/>
    Tu vas pouvoir créer ton combattant et explorer l'arène en quête d'autres joueurs à affronter, mais attention, ton
    parcours pourra être semé d'embûches !</p>
<p>
    Tu pourras déplacer ton combattant case par case dans l'arène sous forme d'un damier (pas de déplacement en diagonale).<br/>
    Ton combattant à 3 caractéristiques : la force (pour faire des dégâts), la vie (si elle tombe à 0 ton personnage est mort), la vue (pour voir les évènements autour de toi)<br/>
    Les attaques se font vers une direction (nord, sud, est, ouest).<br/>
    Tu gagnes de l'expérience en tuant les autres joueurs et pourras monter de tous les 4 points d'expériences et ainsi choisir une caractéristique à améliorer.<br/>
    3 types de pièges sont présents dans l'arène : le monstre, il te tue en un coup si tu marches sur sa case. Des indications te seront fournis si tu es près de lui. Les pièges te feront des dégâts si tu marches dessus, les colonnes te bloqueront le passage.
</p>
        </div>
    </div>

<div class="panel panel-default">
    <div class="panel-heading"><div class="panel-title"><h2>Classement</h2></div></div>
    <div class="panel-body">
<table id="classementTable" class="table table-bordered table-striped table-responsive table-hover">
    <thead><tr>
        <th>Name</th>
        <th>Level</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($classement as $fighter) {
        echo '<tr>';
        echo '<td>' . $fighter['Fighter']['name'] . '</td>';
        echo '<td>' . $fighter['Fighter']['level'] . '</td>';
        echo '</tr>';
    } ?>
</tbody></table></div>
<script>$(document).ready(function() {
            $('#classementTable').DataTable();
    } );</script>