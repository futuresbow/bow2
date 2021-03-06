<?php

class Admin_modul extends MY_Modul {
	
	var $adminTemplate = 'vezerlo/';
	var $data = array();
	
	function __construct(){
		parent::__construct();
		$tag = ws_belepesEllenorzes();
		if(!$tag) redirect(base_url());
		if($tag->adminjogok==0) redirect(base_url());
		$this->adminTemplate = beallitasOlvasas('ADMINTEMA').'/';
		define('ADMINTEMPLATE' , $this->adminTemplate);
		// alias
		define('ADMINTEMA' , $this->adminTemplate);
		define('ADMINURL' , base_url().'webshopadmin/');
		$this->data['stilusUrl'] = base_url().TEMAMAPPA.'/'.$this->adminTemplate;
		$this->data['utvonal'] = false;
		$this->ci->load->library('Forms');
	}
	public function adatBeallitas($kulcs, $ertek) {
		$this->data[$kulcs] = $ertek;
	}
	public function index() {
		$this->data['modulKimenet'] = '... modul nem elérhető ...';
		globalisMemoria("Nyitott menüpont",'admin/fooldal');
		$ci = getCI();
		if($ci->uri->segment(2)!='') {
			$modul = $ci->uri->segment(2);
			$metodus = $ci->uri->segment(3);
			
			// jogosultság ellenőrzés, menüpont
			$menusor = $this->Sql->sqlSor("SELECT * FROM adminmenu WHERE modul_eleres = '$modul/$metodus' LIMIT 1");
			// ha nincs, keresülk az első almenüt adott modullal
			$sql = "SELECT * FROM adminmenu WHERE szulo_id != 0 AND  modul_eleres LIKE '$modul/%' LIMIT 1" ;
			if(!$menusor) $menusor = $this->Sql->sqlSor( $sql);
			
			if(isset($menusor->id)) {
				if($menusor->szulo_id != 0 ) {
					globalisMemoria("Nyitott menüpont",$modul.'/'.$metodus);
				}
			}
						
			
			$class = $modul.'_admin';
			if( is_file(FCPATH.'mods/'.$modul.'/'.$class.'.php')) {

				include_once(FCPATH.'mods/'.$modul.'/'.$class.'.php');
				$obj = new $class;
				
				if(method_exists($obj, $metodus) ){					
					$jogkorRs = $this->Sql->sqlSor("SELECT * FROM hozzaferesek WHERE eleres = '".$modul.'/'.$class.'/'.$metodus."' LIMIT 1");
					$jogkor = 0;
					if(!$jogkorRs) {
						// nincs még ilyen hozzáférési opció, ezért felvisszük szuperadmin johkörrel, hogy adminisztrálható legyen
						$a = array('eleres' => $modul.'/'.$class.'/'.$metodus, 'jogkor' => JOG_SUPERADMIN );
						
						$this->Sql->sqlSave($a, 'hozzaferesek', 'id');
						$jogkor = 0;
					} else {
						$jogkor = $jogkorRs->jogkor;
					}
					
					
					$tag = belepettTag();
					if(  !$tag->is( $jogkor ) )  {
						$this->data['modulKimenet'] = '<b>Nincs megfelelő jogosultságod.</b>';
					} else {
						$this->data['modulKimenet'] = $obj->$metodus();					}
				}
			}
		} else {
			include_once(FCPATH.'mods/admin/admin_admin.php');
			$obj = new Admin_admin;
				
			$this->data['modulKimenet'] = $obj->index();
		}
		$this->data['adminAdatok']  = ws_moduladminadatok();
		
		
		if(!is_null($this->ci->input->get('ajax'))) {
			print $this->data['modulKimenet'];
		} else {
			$this->ci->load->view($this->adminTemplate.'keret_view', $this->data);
	
		}
	}
}

