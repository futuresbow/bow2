<?php

class Kategoria_admin extends MY_Modul{
	var $data = array();
	
	public function lista() {
		globalisMemoria('utvonal', array(array('felirat' => 'Kategóriák')));
		if(isset($_GET['mibe'])) {
		$this->data['lista'] = $ci->Sql->kategoriaFa(0);
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Kategóriák");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'kategoria/szerkesztes/0', 'felirat' => 'Új kategória'));
		
		
		$ALG->tartalomDobozStart();
		
		
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim('Létrehozott kategóriák', 3);
		
		
		
		
		
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'osztaly' => 'btn-ok',
				'tipus' => 'hivatkozas',
				'felirat' => 'Új kategória',
				'link' => ADMINURL.'kategoria/szerkesztes/0',
			)
		));
		return $ALG->kimenet();
		
	}
	public function torol() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		$van = $this->Sql->get($id, DBP."kategoriak", 'szulo_id');
		if($van) {
			redirect(ADMINURL.'kategoria/lista?c=hiba&m='.urlencode('A kategória nem törölhető, mert van alkategóriája!'));
			return;
		}
		
		$van = $this->Sql->get($id, DBP."termekxkategoria", 'kategoria_id');
		if($van) {
			redirect(ADMINURL.'kategoria/lista?c=hiba&m='.urlencode('A kategória nem törölhető, mert termék van hozzárendelve'));
			return;
		}
		$this->db->query("DELETE FROM ".DBP."kategoriak WHERE id =  ".$id);
		redirect(ADMINURL.'kategoria/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	public function szerkesztes() {
		
		globalisMemoria('utvonal', array(array('url' => 'kategoria/lista', 'felirat' => 'Kategóriák'), array( 'felirat' => 'Kategória szerkesztés')));
		
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a');
			if($id==0) {
				$id = $this->sqlSave($a, DBP.'kategoriak');
			} else {
				$a['id'] = $id;
				$this->sqlUpdate($a, DBP.'kategoriak', 'id');
			}
			
			// kategoriakepek
			if($_FILES['kep']['name']!='') {
				if(imgcheck('kep')) {

					$filenev = 'kategoriakep_'.$id.'_'.rand(10,90).'.'.ws_ext($_FILES['kep']['name']);
					$path = 'assets/kategoriakepek/';
					if(move_uploaded_file($_FILES['kep']['tmp_name'],FCPATH.$path.$filenev )) {

						// all is fine...
						$a['kep'] = $path.$filenev;
						
						include_once(APPPATH.'libraries/Zebraimage.php');
						
						
						$image = new Zebra_Image();
						$image->source_path = FCPATH.$a['kep'];
						$image->target_path  = FCPATH.$a['kep'];
						
						$mod = ZEBRA_IMAGE_CROP_CENTER;
						
						$image->resize(600, 600, $mod);
						
						$this->Sql->sqlUpdate($a,'kategoriak' );
						
					} else {
						$p = urlencode("Hiba a kép feltöltésénél! (írási hiba)");
					}
				} else $p = urlencode("Hiba a kép feltöltésénél! (képhiba)");
			}
			redirect(ADMINURL.'kategoria/lista?m='.('Sikeres módosítás. '.$p));
		}
		
		$this->data['lista'] = $ci->Sql->kategoriaFa(0);
		$sor = $this->data['sor'] = $this->get($id, DBP.'kategoriak', 'id');
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Kategória szerkesztése");
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim('Kategória adatai');
		$input1 = new Szovegmezo(array('felirat' => 'Kategória neve', 'ertek' => @$sor->nev, 'nevtomb' => 'a', 'mezonev' => 'nev'));
		$input2 = new Szovegmezo(array('felirat' => 'Kategória elérés url szegmens (slug)', 'ertek' => @$sor->slug, 'nevtomb' => 'a', 'mezonev' => 'slug'));
		
		$doboz->duplaInput($input1, $input2)  ;
		
		$input1 = new Filefeltolto(array('felirat' => 'Kategória kép', 'nevtomb' => '', 'mezonev' => 'kep'));
		$input2 = new Szovegmezo(array('felirat' => 'Sorrend (egész szám)', 'ertek' => @$sor->sorrend, 'nevtomb' => 'a', 'mezonev' => 'sorrend'));
		
		$doboz->duplaInput($input1, $input2)  ;
		
		if(@$sor->kep!='') {
			$doboz = $ALG->ujDoboz();
			$doboz->dobozCim('Jelenlegi kategória kép');
			$doboz->HTMLHozzaadas('<center><img width="33%" src="'.base_url().$sor->kep.'" ></center>');
		}
		
		$ALG->tartalomHozzaadas($ci->load->view(ADMINTEMPLATE.'html/kategoria_szerkesztes', $this->data, true));
		
		
		$ALG->tartalomDobozVege();
		
		
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'kategoria/lista',
				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"
			),
			1 => array(
				'tipus' => 'submit',
				'felirat' => 'Mentés',
				'link' => '',
				'osztaly' => 'btn-ok',
				
			),
		));
		$ALG->urlapVege();
		return $ALG->kimenet();
		
		
	}
}