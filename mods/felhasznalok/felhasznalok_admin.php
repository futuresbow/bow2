<?php

class Felhasznalok_admin extends MY_Modul {
	
	public function jogkorok () {
	public function vasarlolista () {
		
	}
	public function lista () {
		globalisMemoria('utvonal', array(array('felirat' => 'Felhasználók listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Felhasználók");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'felhasznalok/szerkesztes/0', 'felirat' => 'Új felhasználó'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		$keresestorles = false;
			
			$mod = (int)$sr['keresomezo'];
			if($mod==0) $w = ' ( vezeteknev LIKE "%'.$sr['keresoszo'].'%"  OR keresztnev LIKE "%'.$sr['keresoszo'].'%" ) ';
			if($mod==1) $w = ' email LIKE "%'.$sr['keresoszo'].'%" ';
			
			$sql = "SELECT DISTINCT(id) FROM ".DBP."felhasznalok WHERE $w";
			$idArr = ws_valueArray($this->Sql->sqlSorok($sql), 'id');
			if($idArr) {
				$w = " WHERE id IN (".implode(',', $idArr).") ";
				
			} else {
				$tabla = $ALG->ujTablazat();
				$tabla->keresoTorles();
				redirect(ADMINURL."felhasznalok/lista?m=".urlencode("Nincs a keresésnek megfelelő találat!"));
				return;
			}
		}
		$limit = 30;
		foreach($lista as $sor) {
			
			$sor->statusznev = $sor->statusz==0?' Kikapcsolva ':' Bekapcsolva ';
			
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = array(
			array('felirat' => 'Név', 'mezonev' => 'nev'),
			array('felirat' => 'E-mail', 'mezonev' => 'email'),
			
		);
		//$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'felhasznalok/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'felhasznalok/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'email' => 'E-mail', 'statusznev' => 'Státusz' ,  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {
		
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'felhasznalok/lista', 'felirat' => 'Felhasználók') , array('felirat'=> 'Felhasználó szerkesztése')));
		$hiba = false;
		$urlapHiba = array();
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			
			if($a['jelszo']=='' ) {
				if($id == 0) {
					$hiba = true;
					$urlapHiba['jelszo'] = 'Adj meg egy jelszót';
				} else {
					unset($a['jelszo']);
				}
			} else {
				$a['jelszo']= md5(PASSWORD_SALT.$a['jelszo']);
			}
			if($a['vezeteknev']=='') {
				$hiba = true;
				$urlapHiba['vezeteknev'] = 'Név hiányzik';
			}
			if($a['keresztnev']=='') {
				$hiba = true;
				$urlapHiba['keresztnev'] = 'Név hiányzik';
			}
			if(!isEmail($a['email'])) {
				$hiba = true;
				$urlapHiba['email'] = 'Nem megfelelő E-mail.';
			}
			
			if(!$hiba) {
				if($id == 0) {
					$this->Sql->sqlSave($a, DBP.'felhasznalok');
				} else {
					$a['id'] = $id;
					$this->Sql->sqlUpdate($a, DBP.'felhasznalok');
					
				}
				redirect(ADMINURL.'felhasznalok/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
				return;
			} else {
				
			}
		}
		
		$sor = $this->Sql->get($id, DBP.'felhasznalok', 'id');
		if($hiba===true) {
			$sor = (object)$a;
		}
		if(!is_object($sor)) $sor = new stdClass();
		$sor->jelszo = '';
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Felhasználók");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'felhasznalok/lista', 'felirat' => 'Felhasználók listája') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Felhasználói adatok', 2);
		$doboz->adatBeallitas('urlapHiba', $urlapHiba);
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'vezeteknev', 'felirat' => 'Vezetéknév', 'ertek'=> @$sor->vezeteknev));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'keresztnev', 'felirat' => 'Keresztnév', 'ertek'=> @$sor->keresztnev));
		
		$doboz->duplaInput($input1, $input2);
		
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'email', 'felirat' => 'E-mail', 'ertek'=> @$sor->email));
		
		$doboz->szimplaInput($input2);
		
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'jelszo', 'felirat' => 'Jelszó '.(isset($sor->id)?' (hagyd üresen, ha nem változik)':''), 'ertek'=> @$sor->jelszo));
		
		$doboz->szimplaInput($input2);
		
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'Státusz', 'ertek'=> @$sor->statusz, 'opciok' => array(0=>'Kikapcsolva', 1=>'Bekapcsolva')));
		
			$jogValaszto = array();
		
			
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'felhasznalok/lista',
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
	public function torles() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		
		$this->db->query("DELETE FROM ".DBP."felhasznalok WHERE id =  ".$id);
		redirect(ADMINURL.'felhasznalok/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	public function kilepes() {
		$ci = getCI();
		ws_autoload('felhasznalok');
		$tag = new Tag_osztaly($this->ci->session->userdata('__belepett_felhasznalo'));
		$log = $tag->vezeteknev.' '.$tag->keresztnev." az adminról kilépett.";
		ws_log('felhasznalo', $log);
			
		$ci->session->unset_userdata('__belepett_felhasznalo');
		redirect(base_url());
	}
}