<?php
/*
class Termek_osztaly extends MY_Model {
	
	var $jellemzok;
	var $darab = 1;
	var $darabAr = null;
	var $valtozatok;
	var $kivalasztottValtozat;
	var $kivalasztottValtozat2;
	var $opciok;
	var $kepek;
	var $rendeles = false; // ha rendelést töltünk be, akkor a megrendelés terméktáblákból dolgozunk
	var $kivalasztottOpciok;
	var $termekTabla = 'termekek';
	var $megrendeltTermekTabla = 'rendeles_termekek';
	
	public function __construct($id = false, $rendeles = false) {
		$this->rendeles = $rendeles;
		if($id === false) {
			$this->id = 0;
			return false;
		}
		// törzsadatok
		if($rendeles) {
			$termekTabla = $this->megrendeltTermekTabla;
		} else {
			$termekTabla = $this->termekTabla;
			
		}
		$sql = "SELECT * FROM  ".DBP."$termekTabla WHERE id = $id LIMIT 1";
		
		$rs = $this->sqlSor($sql);
		if($rs) {
			foreach($rs as $k => $v) $this->$k = $v;
			if($this->afa==0) {
			
			
		} else {
			return false;
		}
		if($rendeles) {
		
	}
	/*
	public function kuponKedvezmeny($kupon) { 
		$tabla = DBP.'termek_armodositok';
		if($this->rendeles) $tabla = DBP.'rendeles_termek_armodositok';
		
		$valtozat = $this->get($termek_armodositok_id, $tabla, 'id');
		$this->kivalasztottValtozat =  $valtozat;
	}
	public function valtozatBeallitas2($termek_armodositok_id) {
		$tabla = DBP.'termek_armodositok';
		if($this->rendeles) $tabla = DBP.'rendeles_termek_armodositok';
		
		$valtozat = $this->get($termek_armodositok_id, $tabla, 'id');
		$this->kivalasztottValtozat2 =  $valtozat;
	}
	public function darabszamBeallitas($darab) {
		$this->darab = $darab;
	}
	public function kosarOsszNettoAr() {
		if(is_null($this->darabAr)) $this->kosarDarabAr();
		return $this->darabAr*$this->darab;
	}
	function vannakKosarOpciok() {
		if(!empty($this->kivalasztottOpciok)) return true;
		return false;
	}
	public function kosarOsszAfa() {
		$osszNetto = $this->darabAr*$this->darab;
		$osszAfa = round(($osszNetto/100)*$this->afa, 0);
		
		return $osszAfa;
	}
	public function kosarOsszBruttoAr() {
		if(is_null($this->darabAr)) $this->kosarDarabAr();
		$osszNetto = $this->darabAr*$this->darab;
		$osszAfa = round(($osszNetto/100)*$this->afa, 0);
		
		return $osszNetto+$osszAfa;
	}
	
		$ar = $this->ar;
		
		if(!empty($this->kivalasztottValtozat)) {
			if($this->kivalasztottValtozat->ar > 0)
				$ar = $this->kivalasztottValtozat->ar;
		}
		if(!empty($this->kivalasztottOpciok)) {
			foreach($this->kivalasztottOpciok as $opcio) {
				
				$ar += $opcio->ar;
			}
		}
		$this->darabAr = $ar;
		return $ar;
	}
	/*
	public function kosarDarabszam() {
		return $this->darab;
	}
	public function opcioBeallitas($termek_armodositok_id, $tabla = 'termek_armodositok') {
		$opcio = $this->get(DBP.$termek_armodositok_id, $tabla, 'id');
		$this->kivalasztottOpciok[] = $opcio;
	}
	/*
	public function kosarTermekNev() {
		$nevKiegeszites = '';
		if(!empty($this->kivalasztottValtozat)) {
			$nevKiegeszites = " - ".$this->kivalasztottValtozat->nev;
		}
		if(!empty($this->kivalasztottValtozat2)) {
			$nevKiegeszites .= " - ".$this->kivalasztottValtozat2->nev;
		}
		if($this->rendeles) {
			return $this->nev.$nevKiegeszites;
		}
		return $this->jellemzo('Név').$nevKiegeszites;
	}
	public function vannakOpciok() {
		if(empty($this->opciok)) {
			$this->opciokBetoltes();
		}
		
		if(empty($this->opciok)) {
			return false;
		}
		return true;
	}
	/*
	public function opciok() {
		if(empty($this->opciok)) {
			$this->opciokBetoltes();
		}
		
		if(empty($this->opciok)) {
			return false;
		}
		return $this->opciok;
	}
	/*
	public function opciokBetoltes() {
		$id = $this->id;
		if($this->rendeles) $id = $this->termek_id;
		
		$sql = "SELECT * FROM ".DBP."termek_armodositok WHERE tipus = 1 AND termek_id = {$id} ORDER BY sorrend ASC ";
		$this->opciok = $this->sqlSorok($sql);
	}
	public function vannakValtozatok() {
		if(empty($this->valtozatok)) {
			$this->valtozatokBetoltes();
		}
		
		if(empty($this->valtozatok)) {
			return false;
		}
		return true;
	}
	
	public function vannakValtozatok2() {
		if(empty($this->valtozatok2)) {
			$this->valtozatokBetoltes2();
		}
		
		if(empty($this->valtozatok2)) {
			return false;
		}
		return true;
	}
	
	public function valtozatok() {
		if(empty($this->valtozatok)) {
			$this->valtozatokBetoltes();
		}
		
		if(empty($this->valtozatok)) {
			return false;
		}
		return $this->valtozatok;
	}
	public function valtozatok2() {
		if(empty($this->valtozatok2)) {
			$this->valtozatokBetoltes2();
		}
		
		if(empty($this->valtozatok2)) {
			return false;
		}
		return $this->valtozatok2;
	}
	public function megrendeltValtozat() {
		
		// csak rendelés esetén lehetséges
		if($this->rendeles===false) return false;
		// ha van mentett változat, visszaadjuk:
		$sql = "SELECT * FROM ".DBP."rendeles_termek_armodositok WHERE rendeles_termek_id = {$this->id} AND tipus = 0 ";
		
		return $this->Sql->sqlSor($sql);
		
	}
	public function megrendeltValtozat2() {
		
		// csak rendelés esetén lehetséges
		if($this->rendeles===false) return false;
		// ha van mentett változat, visszaadjuk:
		$sql = "SELECT * FROM ".DBP."rendeles_termek_armodositok WHERE rendeles_termek_id = {$this->id} AND tipus = 2 ";
		
		return $this->Sql->sqlSor($sql);
		
	}
	
	public function megrendeltOpciok() {
		
		// csak rendelés esetén lehetséges
		if($this->rendeles===false) return false;
		// ha van mentett változat, visszaadjuk:
		$sql = "SELECT * FROM ".DBP."rendeles_termek_armodositok WHERE rendeles_termek_id = {$this->id} AND tipus = 1 ";
		
		return $this->Sql->sqlSorok($sql);
		
	}
	
	public function megrendeltOsszAr() {
		if($this->rendeles===false) return 0;
		return $this->megrendeltEgysegAr()*$this->darab;
	}
	public function megrendeltOsszBruttoAr() {
		if($this->rendeles===false) return 0;
		return round($brutto, 2);
	}
	public function megrendeltEgysegAr() {
		if($this->rendeles===false) return 0;
		
		// a nettó alapár a termékár vagy ha van kiválasztva változat, akkor annak az ára
		$ar = $this->ar;
		$valtozat = $this->megrendeltValtozat();
		if(isset($valtozat->ar)) if($valtozat->ar!=0) $ar = $valtozat->ar;
		
		// majd hozzáadjuk az opciókat
		$opciok = $this->megrendeltOpciok();
		if($opciok) foreach($opciok as $sor) {
			$ar += $sor->ar;
		}
		// TODO: mi van ha az opció más ÁFAkörbe tartozik??
		return $ar;
		
	}
	
		if($this->rendeles===false) return 0;
		
		// a nettó alapár a termékár vagy ha van kiválasztva változat, akkor annak az ára
		$ar = $this->ar;
		$afa = $this->afa;
		
		$valtozat = $this->megrendeltValtozat();
		if(isset($valtozat->ar)) {
			if($valtozat->ar>0) {
				$ar = $valtozat->ar;
				$afa = $valtozat->afa;
			}
		}
		
		$valtozat = $this->megrendeltValtozat2();
		if(isset($valtozat->ar)) {
			if($valtozat->ar>0) {
				$ar = $valtozat->ar;
				$afa = $valtozat->afa;
			}
		}
		$ar = $ar+($ar/100)*$afa;
		// majd hozzáadjuk az opciókat
		$opciok = $this->megrendeltOpciok();
		if($opciok) foreach($opciok as $sor) {
			$ar += $sor->ar+($sor->ar/100)*$sor->afa;
		}
		// TODO: mi van ha az opció más ÁFAkörbe tartozik??
		return $ar;
		
	}
	public function valtozatokBetoltes() {
		$tabla = DBP.'termek_armodositok';
		$id = $this->id;
		if($this->rendeles) $id = $this->termek_id;
		
		//if($this->rendeles) $tabla = 'rendeles_termek_armodositok';
		$sql = "SELECT * FROM $tabla WHERE tipus = 0 AND termek_id = {$id} ORDER BY sorrend ASC ";
		$this->valtozatok = $this->sqlSorok($sql);
	}
	public function valtozatokBetoltes2() {
		$tabla = DBP.'termek_armodositok';
		$id = $this->id;
		if($this->rendeles) $id = $this->termek_id;
		
		//if($this->rendeles) $tabla = 'rendeles_termek_armodositok';
		$sql = "SELECT * FROM $tabla WHERE tipus = 2 AND termek_id = {$id} ORDER BY sorrend ASC ";
		$this->valtozatok2 = $this->sqlSorok($sql);
	}
	
	public function jellemzo($nev, $nyelv = 'hu') {
		if(empty($this->jellemzok)) {
			$this->jellemzoBetoltes();
		}
		if(isset($this->jellemzok[$nev])) {
			
			// szöveges tartalom
			if(isset($this->jellemzok[$nev]->adat[$nyelv])) return $this->jellemzok[$nev]->adat[$nyelv];
			// egyéb tartalom
			if(isset($this->jellemzok[$nev]->adat)) return $this->jellemzok[$nev]->adat;
			
			
		}
		
		return false;
	}
	
	public function jellemzoSor($nev, $nyelv = 'hu') {
		if(empty($this->jellemzok)) {
			$this->jellemzoBetoltes();
		}
		if(isset($this->jellemzok[$nev])) {
			$mezo = 'ertek_'.$this->jellemzok[$nev]->tipus;
			// szöveges tartalom
			if(isset($this->jellemzok[$nev]->adat[$nyelv]->$mezo)) return $this->jellemzok[$nev]->adat[$nyelv];
			// egyéb tartalom
			if(isset($this->jellemzok[$nev]->adat->$mezo)) return $this->jellemzok[$nev]->adat;
			
			
		}
		
		return false;
	}
	
	public function jellemzoBetoltes($termek_csoport_id = false) {
		
		if(!isset($this->id)) $this->id=0 ;
		if(!$termek_csoport_id) $termek_csoport_id = (int)@$this->termek_csoport_id;
		$this->jellemzok = array();
		
		$nyelvek = explode(',', beallitasOlvasas('nyelvek'));
		foreach($nyelvek as $nyelv) {
			foreach($this->jellemzok as $k => $v) {
				if($v->tipus == 2 or $v->tipus == 3 or $v->tipus == 4 or $v->tipus == 5) {
					// nyelvfüggő jellemzők
						$this->jellemzok[$k]->adat[$nyelv] = $adatok->{$v->slug};
					} else {
					
				} else {
					if(isset($adatok->{$v->slug})) {
						$this->jellemzok[$k]->adat = $adatok->{$v->slug};
				}
		}
	}
	public function link() {
		$id =  $this->id;
		if($this->rendeles) $id = $this->termek_id;
		return base_url().'reszletes/'.strToUrl($id.'-'.$this->jellemzo('Név'));
	}
	public function fokep() {
		if(!$this->kepek) {
			$this->kepBetoltes();
		}
		if($this->kepek) return $this->kepek[0]->file;
		return false;
	}
	public function kepBetoltes() {
		if($this->kepek) return $this->kepek[0]->file;
		if(!isset($this->id)) return false;
		$id = $this->id;
		if($this->rendeles) $id = $this->termek_id;
		$sql = "WHERE termek_id = {$id} ORDER BY sorrend ASC ";
		$this->kepek = $this->Sql->gets(DBP."termek_kepek", $sql);
		return $this->kepek;
	}
}