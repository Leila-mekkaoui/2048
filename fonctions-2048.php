<!-- jeu-2048.php -->
<html>
 <head>
 	<meta charset="utf-8" />
 	<title>
 	 2048
 	</title>

 	<style type="text/css">
		.gras{
			font-weight: bold;
			}
		.gauche {
			color: #2073a5;
			}
		.droite {
			color: #a52020;
		}
		.haut {
			color: #187a16;
		}

		.bas {
			color: #cb8d26;
		}
		
 	</style>
 </head>
 
 <body>
	 <?php 
	
	//ajoute un certain message $mesg dans les logs
	function write_log($mesg){
		file_put_contents('logs-2048.txt', $mesg ."\n", FILE_APPEND);
		
		}	
	
	//affiche le contenue des $nb1 dernière ligne des logs
	function affiche_logs($nbl){
		$logs= file("logs-2048.txt");
		$taille = sizeof($logs);

		$h= "h";
		$b= "b";
		$g= "g";
		$d= "d";
		$r= "restart";
		
		
		foreach ($logs as $i => $line)
		{
			if ($i > ( $taille - $nbl - 1) )
			{
				
				$valll = strval(htmlspecialchars($line));
				
				echo $valll;

				
				
				
				
				if(strcmp($valll, $r)==1)
				{
					$cl= "gras";
				}
				
				elseif(strcmp($valll, $h)==1)
					{
						$cl="haut";
						}
						
				elseif(strcmp($valll,$b)==1)
						{
							$cl="bas";
							}
							
				elseif(strcmp($valll,"d")==1){
								$cl="droite";
								}
				else {$cl="gauche";}
				
				
				echo "Line " . ($i+1) . " : " ; 
				?> 
				
				<div class="<?php echo $cl ; ?>"> 
					<?php echo $valll ; ?>    
				</div>  
				<?php 
				echo "<br />\n"; 
				
				
				
			}
		}
	}

	//récupère le score enregistrer et modifie le score en conséquence
	function affiche_score()
	{
		global $score;

		fichier_vers_score();
		
		nouvelle();
		echo $score;
		
		score_vers_fichier();
	}
	
	//enregistre le score dans un fichier
	function score_vers_fichier()
	{	global $score;
		file_put_contents('score.txt',$score);
		}
		
	//récupère le score enregistrer dans un fichier
	function fichier_vers_score()
	{	global $score;
		$score=file_get_contents('score.txt');
		}
		
	//initialise le score et la grille, et met deux valeurs dans la grille
	function nouvelle_partie()
	{	
		global $grille;
		global $score;

		if(isset($_GET['action-joueur'])&& $_GET['action-joueur']=== "restart")
		{
			$score=$score-$score;
			score_vers_fichier();
			
			for($i=0; $i<4;$i++)
			{
				for($j=0;$j<4;$j++)
				{
					$grille[$i][$j]=0;
				}
			}

		for($i=0; $i<2; $i++){
			$posi=tirage_position_vide();
			$x=$posi[0];
			$y=$posi[1];
			$grille[$x][$y]=tirage_2ou4(); //ici ça demande que des 2, changer plus tard et vérifier si ça marche 
		}}
	}
	
	//enregistre la grille dans un fichier
	function matrice_vers_fichier()
	{
		global $grille;
		file_put_contents('grille.txt', "" );
		for($i=0; $i<4;$i++)
			{
				for($j=0;$j<4;$j++)
				{
					file_put_contents('grille.txt', $grille[$i][$j]. " ", FILE_APPEND);
				}
				file_put_contents('grille.txt', "\n", FILE_APPEND);
			}
		}
		
	//recupuère la grille enregistrée
	function fichier_vers_matrice()
	{	global $grille;
		$chaine = file_get_contents('grille.txt');
		// on remplace dans $chaine tous les sauts de ligne par des espaces
		$chaine = str_replace("\n", " ", $chaine);
		$chaine = str_replace("  ", " ", $chaine);
		// $valeurs est un tableau 1D qui va contenir tous les nombres de la grille
		$valeurs = explode(' ', $chaine);
		$n = 0;
		for ($i = 0; $i < 4 ; $i++)
		{
			for ($j = 0; $j < 4; $j++) 
			{
				$grille[$i][$j] = (int) ($valeurs[$n]);
				$n++;
			}
		}
	}
	
	//affiche la grille selon sa valeur
	function affiche_case($i, $j)
	{
		global $grille;
		$content=$grille[$i][$j];
		switch ($content) 
		{ 
			case 32:
				echo '<td width="50px" height="50px" class="tren">'. $content .'</td>';
				break;
			case 2:
				echo '<td width="50px" height="50px" class="deux">'. $content .'</td>';
				break;
			case 4:
				echo '<td width="50px" height="50px" class="quat">'. $content .'</td>';
				break;
			case 8:
				echo '<td width="50px" height="50px" class="huit">'. $content .'</td>';
				break;
			case 16:
				echo '<td width="50px" height="50px" class="seiz">'. $content .'</td>';
				break;
			case 64:
				echo '<td width="50px" height="50px" class="soix">'. $content .'</td>';
				break;
			case 128:
				echo '<td width="50px" height="50px" class="cent">'. $content .'</td>';
				break;
			case 256:
				echo '<td width="50px" height="50px" class="deuc">'. $content .'</td>';
				break;
			case 512:
				echo '<td width="50px" height="50px" class="cinq">'. $content .'</td>';
				break;
			case 1024:
				echo '<td width="50px" height="50px" class="mill">'. $content .'</td>';
				break;
			case 2048:
				echo '<td width="50px" height="50px" class="deum">'. $content .'</td>';
				break;
			case 0:
				echo '<td width="50px" height="50px" class="zero">' .'</td>';
				break;
		}
	}
	
	//condition de début de partie, et de fin
	function nouvelle()
	{
		if($_GET['action-joueur']=== 'restart')
		{
			nouvelle_partie();
		}
			else{fichier_vers_matrice();}
			
		
		if($_GET['action-joueur'] != 'restart' && grille_pleine()==false)
		{
			for($i=0;$i<4;$i++){
				decale_choix($i);
				fusion_choix($i);
				decale_choix($i);
			}
			place_nouveau_nb();
		}
			elseif(isset($score)){echo "La grille est pleine";} //prends else à la première itération
	}
	
	//choisis les coordonées d'une case de tableau vide et les renvoie dans un tableau [2]
	function tirage_position_vide()
	{
	global $grille;
		
			do{
			$i=rand(0,3);
			$j=rand(0,3);
			}
			while($grille[$i][$j]!=0);//!!
			
			return array($i, $j);
	}
	
	//supposer dire quand la grille n'a plus de place
	function grille_pleine()
	{
		global $grille;
		global $score;
		
			for($i=0;$i<4;$i++){
				for($j=0;$j<4;$j++){
					if($grille[$i][$j]==0){
						return false;
					}
				}
			}
			return true;
	}

	//tirage aléatoire entre 2 ou 4
	function tirage_2ou4(){
		$init=rand(1,2);
		$init=$init*2;
		return $init;
	}

	//place aléatoirement un 2 ou 4 après chaque mouvement
	function place_nouveau_nb(){
		global $grille;

		$posi=tirage_position_vide();
		$x=$posi[0];
		$y=$posi[1];

		$grille[$x][$y]=tirage_2ou4();
	}

	function decale_ligne_gauche($l){
		global $grille;

		$ligne = array_fill(0,4,0);
		$i = 0;
		for ($j = 0; $j < 4; $j++)
		{
			if ($grille[$l][$j] != 0)
			{
				$ligne[$i] = $grille[$l][$j];
				$i++;
			}
		}

		$grille[$l] = $ligne;
		
	}

	function decale_ligne_droite($l){
		global $grille;

		$ligne = array_fill(0,4,0);
		$i = 3;
		for ($j = 3; $j > -1; $j--)
		{
			if ($grille[$l][$j] != 0)
			{
				$ligne[$i] = $grille[$l][$j];
				$i--;
			}
		}

		
		$grille[$l] = $ligne;	
	}

	function decale_colonne_haut($l){
		global $grille;

		$colonne = array_fill(0,4,0);
		$i = 0;
		for ($j = 0; $j<4; $j++)
		{
			if ($grille[$j][$l] != 0)
			{
				$colonne[$i] = $grille[$j][$l];
				$i++;
			}
		}

		for($k=0;$k<4;$k++){
			$grille[$k][$l]=$colonne[$k];
		}
	}

	function decale_colonne_bas($l){
		global $grille;

		$colonne = array_fill(0,4,0);
		$i = 3;
		for ($j = 3; $j>-1; $j--)
		{
			if ($grille[$j][$l] != 0)
			{
				$colonne[$i] = $grille[$j][$l];
				$i--;
			}
		}

		for($k=0;$k<4;$k++){
			$grille[$k][$l]=$colonne[$k];
		}
	}

	function decale_choix($l){
		$mouvement= $_GET['action-joueur'];

		switch ($mouvement) 
		{
			case 'g':
				decale_ligne_gauche($l);
				break;
			case 'd':
				decale_ligne_droite($l);
				break;
			case 'h':
				decale_colonne_haut($l);
				break;
			case 'b':
				decale_colonne_bas($l);
				break;
		}	
	}

/* Fusion -----------------------------------------------------------------------------------------------------------------*/
	function fusion_ligne_gauche($l){
		global $grille;
		global $score;

		if ($grille[$l][0] == $grille[$l][1])
		{
			$grille[$l][0] = 2 * $grille[$l][0];
			$grille[$l][1] = 0;

			$score=$score+$grille[$l][0] ;//score
			//write_log($score);
			
			if ($grille[$l][2] == $grille[$l][3])
			{
				$grille[$l][2] = 2 * $grille[$l][2];
				$grille[$l][3] = 0;	
				
				$score=$score+$grille[$l][2];//score
			}		
		}
		else if ($grille[$l][1] == $grille[$l][2])
		{
			$grille[$l][1] = 2 * $grille[$l][1];
			$grille[$l][2] = 0;
			
			$score=$score+$grille[$l][1];//score
		}	
		else if ($grille[$l][2] == $grille[$l][3])
		{
			$grille[$l][2] = 2 * $grille[$l][2];
			$grille[$l][3] = 0;

			$score=$score+$grille[$l][2];//score
		}

	}

	function fusion_ligne_droite($l){
		global $grille;
		global $score;

		if ($grille[$l][2] == $grille[$l][3])
		{
			$grille[$l][3] = 2 * $grille[$l][3];

			$score=$score+$grille[$l][3];//score

			$grille[$l][2] = 0;
			if ($grille[$l][0] == $grille[$l][1])
			{
				$grille[$l][1] = 2 * $grille[$l][1];
				$grille[$l][0] = 0;	
				
				$score=$score+$grille[$l][1];//score
			}		
		}
		else if ($grille[$l][1] == $grille[$l][2])
		{
			$grille[$l][2] = 2 * $grille[$l][2];
			$grille[$l][1] = 0;

			$score=$score+$grille[$l][2];//score
		}	
		else if ($grille[$l][0] == $grille[$l][1])
		{
			$grille[$l][1] = 2 * $grille[$l][1];
			$grille[$l][0] = 0;

			$score=$score+$grille[$l][1];//score
		}

		
	}

	function fusion_colonne_haut($l){
		global $grille;
		global $score;

		if ($grille[0][$l] == $grille[1][$l])
		{
			$grille[0][$l] = 2 * $grille[0][$l];
			$grille[1][$l] = 0;

			$score=$score+$grille[0][$l];//score

			if ($grille[2][$l] == $grille[3][$l])
			{
				$grille[2][$l] = 2 * $grille[2][$l];
				$grille[3][$l] = 0;		

				$score=$score+$grille[2][$l];//score
			}		
		}
		else if ($grille[1][$l] == $grille[2][$l])
		{
			$grille[1][$l] = 2 * $grille[1][$l];
			$grille[2][$l] = 0;

			$score=$score+$grille[1][$l];//score
		}	
		else if ($grille[2][$l] == $grille[3][$l])
		{
			$grille[2][$l] = 2 * $grille[2][$l];
			$grille[3][$l] = 0;

			$score=$score+$grille[1][$l];//score
		}

		 
	}

	function fusion_colonne_bas($l){
		global $grille;
		global $score;

		if ($grille[2][$l] == $grille[3][$l])
		{
			$grille[3][$l] = 2 * $grille[3][$l];
			$grille[2][$l] = 0;

			$score=$score+$grille[3][$l];//score

			if ($grille[0][$l] == $grille[1][$l])
			{
				$grille[1][$l] = 2 * $grille[1][$l];
				$grille[0][$l] = 0;		

				$score=$score+$grille[1][$l];//score
			}		
		}
		else if ($grille[1][$l] == $grille[2][$l])
		{
			$grille[2][$l] = 2 * $grille[2][$l];
			$grille[1][$l] = 0;

			$score=$score+$grille[2][$l];//score
		}	
		else if ($grille[0][$l] == $grille[1][$l])
		{
			$grille[1][$l] = 2 * $grille[1][$l];
			$grille[0][$l] = 0;

			$score=$score+$grille[1][$l];//score
		}

		
	}

	function fusion_choix($l){
		$mouvement= $_GET['action-joueur'];

		switch ($mouvement) 
		{
			case 'g':
				fusion_ligne_gauche($l);
				break;
			case 'd':
				fusion_ligne_droite($l);
				break;
			case 'h':
				fusion_colonne_haut($l);
				break;
			case 'b':
				fusion_colonne_bas($l);
				break;
		}
		
	}
	?>

 </body>
</html>	
