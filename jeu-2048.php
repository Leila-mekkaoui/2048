<!-- jeu-2048.php -->
<html>
 <head>

	<?php require_once 'fonctions-2048.php';
		$score=0;
		$grille=array_fill(0,4,array_fill(0,4,0));;
	?>

 	<meta charset="utf-8" />
	<link rel="stylesheet" href="style2048.css" />
 	<title> jeu-2048 </title>
 	
 </head>

 <body>
 	<h1>2048</h1>
    <p class="regle">
        Le but du jeu est de faire glisser des tuiles sur une grille, pour combiner les tuiles de mêmes valeurs et créer 
        ainsi une tuile portant le nombre 2048. 
        Les nombres peuvent se déplacer à droite, à gauche, en haut ou en bas. Quand deux cases de même valeur se rencontrent, 
        elles fusionnent en une case qui vaut la somme des 2 cases fusionnées. Après chaque action du joueur, une nouvelle case 
        apparaît avec pour valeur 2 ou 4. Le but est donc d'obtenir une case valant 2048 avant que la grille ne soit pleine et 
        qu'aucun mouvement ne soit plus possible.</p>

    <p class="score">Score : <?php affiche_score(); ?> </p> 
	<p> <?php nouvelle(); ?> </p>

    <form name="jeu-2048" method="get" action="jeu-2048.php">
        <div class="centre">
            <input type="submit" name="action-joueur" value="restart" class="bouton"/>
        </div>
        
    </form>

    <table>
		<?php 
			for($i=0; $i<4;$i++)
			{
				?>
				<tr>
					<?php 
					for($j=0;$j<4;$j++)
					{
						affiche_case($i, $j);
					}
					?>
				</tr>
				
				<?php
			}
		
		?>

    </table>
    
    <form name="jeu-2048" method="get" action="jeu-2048.php">
        <div class="centre">
            <input type="submit" name="action-joueur" value="h" class="bouton"/>
            </br>
            <input type="submit" name="action-joueur" value="g" class="bouton"/>
            <input type="submit" name="action-joueur" value="b" class="bouton"/>
            <input type="submit" name="action-joueur" value="d" class="bouton"/>
        </div>
        
    </form>

    <a href="2048jpp.html">Recharge la plage 2048</a>
 	
 	<?php
		matrice_vers_fichier();
 	?>
 
 </body>
</html>	
