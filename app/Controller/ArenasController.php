<?php 

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
/*require_once("../../vendor/autoload.php");

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;
use Facebook\Helpers\FacebookCanvasHelper;*/


class ArenasController extends AppController
{
	public $uses = array('User', 'Fighter', 'Event', 'Surroundings');
    public $fighterCurrent = "";
    /*
     *Page d'accueil
	 *
	 *Permet l'accès à la connexion et l'inscription hors connexion
     * 
	 *Permet la déconnexion et la navigation vers les autres pages en temps que connecté
     */
    public function index(){	
	
        if($this->Auth->loggedIn())
        {
            $this->set('myname', strtok($this->User->findById($this->Auth->user('id'))['User']['email'],'@'));
        }
		else {
            $this->set('myname', "futur grand guerrier");
        }

        $this->set('classement',' ');
        $classement = $this->Fighter->find('all');
        $this->set('classement',$classement);

        //POUR CE CONNECTER, ERREUR SDK Facebook Pouet
		/*
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}
		$fb = new \Facebook\Facebook([
			'app_id' => '1720702151482399',
			'app_secret' => '498d1d995ef2a182e5f1760734ad57b6',
			'default_graph_version' => 'v2.4',
		]);


		$helper = $fb->getRedirectLoginHelper();
		try {
			$accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo $e;
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo $e;
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		if (isset($accessToken)) {
			// Logged in!
			$_SESSION['facebook_access_token'] = (string) $accessToken;
	}*/


		//POUR UTILISER LE MAIL LE NOM ETC
			/*$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

			try {
				$response = $fb->get('/me');
				$userNode = $response->getGraphUser();
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				// When validation fails or other local issues
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}

			$this->set('fb_name',$userNode->getName());

			echo 'Logged in as ' . $userNode->getName();*/
			// Now you can redirect to another page and use the
			// access token from $_SESSION['facebook_access_token']

    }
	
	/*
	 *Page Combattant
	 *
	 *Permet de créer de nouveau combattant et de voir les caractéristiques des combattants liés au compte
	 *
	 */
	
	public function fighter(){
		$this->set('fighter',null);
		//Récupération de la liste des noms des Fighter du User connecté
		
		$this->set('raw','Sélectionnez un Combattant.');
		$this->set('canLevelUp',false);
		if ($this->request->is('post')){
			//Affichage des charactéristique du Fighter Séléctioné
			if(array_key_exists('FighterChoose',$this->request->data)){
				$fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'),$this->request->data['FighterChoose']['Combattant']);
				$this->set('raw',$fighter);
                
				//Détermination de la possibilité de passer un niveau
				if($this->Fighter->canLevelUp($fighter)){
					$this->set('canLevelUp',true);
					$this->set('fighter',$fighter);
				}
				else $this->set('canLevelUp',false);
                $this->set('fighter',$fighter);
			}
            else if(array_key_exists('FighterKill',$this->request->data)){
				$fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'),$this->request->data['FighterKill']['Combattant']);
                $this->Fighter->kill($fighter);
                $this->redirect(array('action' => '../Arenas/fighter'));
				$this->set('raw','Combattant supprimé !');
                
			}
			//Création d'un nouveau Fighter avec un nom fournis par le User
			else if (array_key_exists('FighterCreate',$this->request->data)){
				if(count($this->Surroundings->getAllSurroundings) == 0)$this->Surroundings->genMap();
				//Création de l'Event d'arrivée dans l'arène
				$event = $this->Fighter->spawn($this->Auth->user('id'),$this->request->data['FighterCreate']['Nom']);
				//Message si l'arène est pleine et le Fighter n'a pas été créé
				if($event != null) {
                    $this->Event->record($event);
                    $fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'),$this->request->data['FighterCreate']['Nom']);
                    if(!empty($this->data['FighterCreate']['Avatar']))
                    {
                        $file = $this->data['FighterCreate']['Avatar'];

                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');

                        if(in_array($ext, $arr_ext))
                        {
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . '/img/' . $fighter['Fighter']['id'].'.'.$ext);
                        }
                    }

                    
                    $this->set('fighter',$fighter);
                                   }
				else {
                    echo('Desole, l\'arene est pleine ! Vous ne pouvez pas creer de nouveau combattant.');
				    $this->redirect(array('action' => '../Arenas/fighter'));
                }
			}
			//Passage de niveau du Fighter séléctionné
			else if (array_key_exists('FighterLevelUp',$this->request->data)){
				//Récupération du Fighter à partir de son nom et de son User
				$fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'),$this->request->data['FighterLevelUp']['Combattant']);
								
				// Méthode de passage de niveau avec le skill renseigné
				$fighter = $this->Fighter->levelUp($fighter,$this->request->data['FighterLevelUp']['Skill']);
				$this->set('raw',$fighter);
				
				//Détermination de la possibilité de passer un niveau
				if($this->Fighter->canLevelUp($fighter)){
					$this->set('canLevelUp',true);
					$this->set('fighter',$fighter);
				}
				else $this->set('canLevelUp',false);
			}
		}	
        $this->set('fighters',$this->Fighter->getFighterNameByUser($this->Auth->user('id')));		
        
}
	
	/*
	 *Page Vue
	 *
	 *Permet d'effectuer des actions avec les combattants liés au compte
	 *
	 * Déplacement - Attaque
	 *
	 */
	public function sight()
    {
        //Récupération de la liste des noms des Fighter du User connecté
        $this->set('fighters', $this->Fighter->getFighterNameByUser($this->Auth->user('id')));
        $this->set('manyWalls',$this->Surroundings->getAllWall());
        $this->set('fighterToSight', 0);   
        $this->set('manyEvents',"");
        
        if ($this->request->is('post')) {
            if(array_key_exists('FighterChoose',$this->request->data)){
				$fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'),$this->request->data['FighterChoose']['Combattant']);
                $this->set('fighterToSight', $fighter);
                $coord = array("coord_x"=>$fighter['Fighter']['coordinate_x'],"coord_y"=>$fighter['Fighter']['coordinate_y']);
                $range = $fighter['Fighter']['skill_sight'];
                $this->set('manyEvents',$this->Event->getEventList($coord, $range));
                
			}
            else if ((array_key_exists('FighterAction',$this->request->data))&&($this->request->data['FighterAction']['Action'] == 'move')) {
                $fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterAction']['Combattant']);
				$surroundings = $this->Surroundings->checkSurroundings($fighter, $this->request->data['FighterAction']['Direction']);
				$moved = false;
                foreach ($surroundings as $element){
                    switch ($element) {

                        case 0:    //Action de déplacement, création de l'Event correspondant
                            if(!$moved){
								$this->Event->record($this->Fighter->doMove($fighter, $this->request->data['FighterAction']['Direction']));
								$moved = true;
							}
							break;

                        case 1:
                            $event = $this->Fighter->doMove($fighter, $this->request->data['FighterAction']['Direction']);
                            $event['name'] .= 'sur un piège et meurt';
                            $this->Event->record($event);
                            $this->Fighter->kill($fighter);
                            break;

                        case 2:
                            $event = array('name' => $fighter['Fighter']['name'] . ' se fait tuer par le monstre', 'coordinate_x' => $fighter['Fighter']['coordinate_x'], 'coordinate_y' => $fighter['Fighter']['coordinate_y']);
                            $this->Event->record($event);
                            $this->Fighter->kill($fighter);
                            break;

                        case 3:
                            $event = array('name' => $fighter['Fighter']['name'] . ' est bloqué par un pilier', 'coordinate_x' => $fighter['Fighter']['coordinate_x'], 'coordinate_y' => $fighter['Fighter']['coordinate_y']);
                            $this->Event->record($event);
                            break;

                        case 4:
							if(!$moved){
								$this->Event->record($this->Fighter->doMove($fighter, $this->request->data['FighterAction']['Direction']));
								$moved = true;
							}
                            $fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterAction']['Combattant']);
                            $event = array('name' => $fighter['Fighter']['name'] . ' sent une brise suspecte', 'coordinate_x' => $fighter['Fighter']['coordinate_x'], 'coordinate_y' => $fighter['Fighter']['coordinate_y']);
                            $this->Event->record($event);
                            break;

                        case 5:
							if(!$moved){
								$this->Event->record($this->Fighter->doMove($fighter, $this->request->data['FighterAction']['Direction']));
								$moved = true;
							}
							$fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterAction']['Combattant']);
                            $event = array('name' => $fighter['Fighter']['name'] . ' sent une odeur nauseabonde', 'coordinate_x' => $fighter['Fighter']['coordinate_x'], 'coordinate_y' => $fighter['Fighter']['coordinate_y']);
                            $this->Event->record($event);
                            break;
                        default: ;
                    }
				}
 		        $fighter2 = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterAction']['Combattant']);
                $this->set('fighterToSight', $fighter2);
                $coord = array("coord_x"=>$fighter['Fighter']['coordinate_x'],"coord_y"=>$fighter['Fighter']['coordinate_y']);
                $range = $fighter['Fighter']['skill_sight'];
                $this->set('manyEvents',$this->Event->getEventList($coord, $range));
                
            } else if  ((array_key_exists('FighterAction',$this->request->data))&&($this->request->data['FighterAction']['Action'] == 'attack')) {
                $fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterAction']['Combattant']);
                $surroundings = $this->Surroundings->checkSurroundings($fighter, $this->request->data['FighterAction']['Direction']);
                switch ($surroundings[0]) {

                    case 0:
                    case 1:
                    case 3:
                    case 4:    //Action d'attaque, création de l'Event correspondant
                    case 5:
                        $this->Event->record($this->Fighter->doAttack($fighter, $this->request->data['FighterAction']['Direction']));
                        break;

                    case 2:
                        $this->Event->record($this->Fighter->doAttack($fighter, $this->request->data['FighterAction']['Direction']));
                        $this->Event->record($this->Fighter->killMob($fighter, $this->request->data['FighterAction']['Direction']));
                        $this->Surroundings->mobMove();
                        break;

                    default:
                        ;
                }
                $fighter2 = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'), $this->request->data['FighterAction']['Combattant']);
                $this->set('fighterToSight', $fighter2);
                $coord = array("coord_x"=>$fighter['Fighter']['coordinate_x'],"coord_y"=>$fighter['Fighter']['coordinate_y']);
                $range = $fighter['Fighter']['skill_sight'];
                $this->set('manyEvents',$this->Event->getEventList($coord, $range));
                
            }
        }
        $this->set('fighters', $this->Fighter->getFighterNameByUser($this->Auth->user('id')));
        
    }
	
	/*
	 *Page de Journal
	 *
	 *Permet de voir les événements passés dans l'arène
	 *
	 */
	public function diary(){
		$this->set('raw',' ');
		
		$this->set('fighters',$this->Fighter->getFighterNameByUser($this->Auth->user('id')));
		if ($this->request->is('post')){
			//Affichage des charactéristique du Fighter Séléctioné
			if(array_key_exists('FighterChoose',$this->request->data))
				$fighter = $this->Fighter->getFighterByUserAndName($this->Auth->user('id'),$this->request->data['FighterChoose']['Combattant']);
				$events = $this->Event->getEventList(array('coord_x'=>$fighter['Fighter']['coordinate_x'],'coord_y'=>$fighter['Fighter']['coordinate_y']),$fighter['Fighter']['skill_sight']);
            //var_dump($events);
            $this->set('raw',$events);
		}
	}
}
?>
