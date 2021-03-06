<?php
/*
* Admin lapok létrehozásáért felelős osztály
*/


class Forms {
	
	var $lapCim = 'Admin oldal';
	var $data = array('szelessegOsztaly' => 'narrow');
	var $tartalom = array();
	
	public function __construct() {
		$this->data['lapCim'] = $this->lapCim;
	}
	
	public function adatBeallitas($kulcs, $ertek) {
		$this->data[$kulcs] = $ertek;
	}
	public function ujDoboz() {
		$d = $this->tartalom[] = new ALGDoboz();
		return $d; 
	}
	public function ujTablazat() {
		$d = $this->tartalom[] = new ALGTablazat();
		return $d; 
	}
	public function tartalomHozzaadas($html) {
		$this->tartalom[] =  $html;
		 
	}
	public function urlapGombok($gombok) {
		$ci = getCI();
		$this->tartalom[] = $ci->load->view(ADMINTEMPLATE.'forms/urlapgombok_view', array('gombok' => $gombok), true);
	}
	public function urlapStart($adatok) {
		
		$this->tartalom[] = '<form '.@$adatok['attr'].'>';
	}	
	public function urlapVege() {
		
		$this->tartalom[] = '</form>';
	}
	public function tartalomDobozStart() {
		$ci = getCI();
		$this->tartalom[] = $ci->load->view(ADMINTEMPLATE.'forms/tartalomdobozstart_view', null, true);
	}
	public function tartalomDobozVege() {
		$ci = getCI();
		$this->tartalom[] = $ci->load->view(ADMINTEMPLATE.'forms/tartalomdobozvege_view', null, true);
	}
	public function kimenet() {
		$ci = getCI();
		
		$out = $ci->load->view(ADMINTEMPLATE.'forms/fejlec_view', $this->data, true);
		$out .= $this->tartalomKimenet();
		$out .= $ci->load->view(ADMINTEMPLATE.'forms/lablec_view', $this->data, true);
		return $out;
	}
	
	public function tartalomKimenet() {
		
		$out = '';
		foreach($this->tartalom as $sor) {
			
			if(is_object($sor)) {
				$out .= $sor->kimenet();
			} else {
				$out .= $sor;
			}
			
		}
		return $out;
	}
	
}

class ALGDoboz {
	
	var $tartalom = array();
	var $data = array('dobozCim' => 'Doboz címe', 'dobozCimHMeret' => 2,'urlapHiba' => array());
	
	public function dobozCim($cim, $meret = 3) { $this->data['dobozCim'] = $cim;$this->data['dobozCimHMeret'] = $meret; }
	
	public function adatBeallitas($kulcs, $ertek) {
		$this->data[$kulcs] = $ertek;
	}
	public function jodit($selector='#szoveg') {		// WYSWYG editor (Jodit)		$ci = getCI();				$this->ScriptHozzaadas('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">');		$this->ScriptHozzaadas('<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>');		$this->ScriptHozzaadas($ci->load->view(ADMINTEMPLATE.'forms/jodit_init', array('selector' => $selector), true));	}
	public function duplaInput($input1 = false, $input2 = false) {
		
		$ci = getCI();
		$this->tartalom[] = $ci->load->view(ADMINTEMPLATE.'forms/duplainput', array('urlapHiba' => $this->data['urlapHiba'],'input1' => $input1, 'input2' => $input2), true);
		
	}
	public function szimplaInput($input1) {
		
		$ci = getCI();
		$this->tartalom[] = $ci->load->view(ADMINTEMPLATE.'forms/szimplainput_view', array('urlapHiba' => $this->data['urlapHiba'],'input1' => $input1), true);
		
	}
	public function dobozElemJelolonegyzetek($jelolok) {
		
		$ci = getCI();
		$this->tartalom[] = $ci->load->view(ADMINTEMPLATE.'forms/boxitemcheckbox_view', array('urlapHiba' => $this->data['urlapHiba'],'jelolok' => $jelolok), true);
		
	}
	public function dobozElem($html) {
		$ci = getCI();
		$this->tartalom[] = $ci->load->view(ADMINTEMPLATE.'forms/boxitem_view', array('html' => $html), true );
		

	}
	public function HTMLHozzaadas($html) {
		$ci = getCI();
		$this->tartalom[] = $ci->load->view(ADMINTEMPLATE.'forms/description_view', array('html' => $html), true );
		
	}
	public function ScriptHozzaadas($html) {
		$ci = getCI();
		$this->tartalom[] = $html;
		
	}
	
	public function kimenet() {
		$ci = getCI();
		$out = $ci->load->view(ADMINTEMPLATE.'forms/dobozfejlec_view', $this->data, true);
		$out .= $this->tartalomKimenet();
		$out .= $ci->load->view(ADMINTEMPLATE.'forms/dobozlablec_view', $this->data, true);
		return $out;
	}
	public function tartalomKimenet() {
		$out = '';
		foreach($this->tartalom as $sor) $out .=   $sor;
		return $out;
	}
	
	
}
class ALGTablazat {
	
	var $tartalom = array();
	var $sortable = false;
	var $data = array();
	var $lapozo = false;
	var $start = 0;
	var $limit = 10;
	var $ossz = 0;
	
	
	public function __construct() {
		$ci = getCI();
		// tábla keresés beállítások
		if($ci->input->get('sr')) {
			$_SESSION['tabla_kereses'] = $ci->input->get('sr');
		}
		if(!isset($_SESSION['tabla_kereses'])) {
			$_SESSION['tabla_kereses']= array('keresomezo' => '','keresoszo' => '');
			
		}
		$this->data['tabla_kereses'] = $_SESSION['tabla_kereses'];
		$this->data['sortable'] = false;
		$this->data['sortableId'] = '';
	}
	public function lapozo($start= 0, $limit = 20, $osszTalalat = 0) {
		$this->lapozo = true;
		$this->data['start'] = $start;
		$this->data['limit'] = $limit;
		$this->data['osszTalalat'] = $osszTalalat;
		
		$params = $_GET;
		
		if($start>0) {
			$prev = $start-$limit;
			if($prev <0) $prev = 0;
			
			$params['start'] = $prev;
			$this->data['prev'] = http_build_query($params);
			$params['start'] = 0;
			$this->data['first'] = http_build_query($params);
		}
		$gombok = array();
		if($limit<$osszTalalat) {
			$i = 0;
			$startx = 0;
			while(  $startx < $osszTalalat) {
				//print $start.' '.$limit.' '.$osszTalalat.'<br>' ;
				$i++;
				if($i>10) exit;
				$params['start'] = $startx;
				
				
				$gombok[] =  array('class' => (($startx==$start)?'active':''),'link' => http_build_query($params), 'felirat' => (($startx/$limit)+1));
				$startx += $limit;
			}
		}
		$this->data['lapozoGombok'] = $gombok;
		
		$next = $start+$limit;
		if($next < $osszTalalat) {
			
			
			$params['start'] = $next;
			$this->data['next'] = http_build_query($params);
			$params['start'] = $limit*( floor($osszTalalat/$limit));
			$this->data['last'] = http_build_query($params);
			
		}
					
		
		
	}
	public function sorrendezheto($id = 'sort') {
		$this->sortable = true ;
		$this->data['sortable'] = true;
		$this->data['sortableId'] = str_replace('***', 'none', $id);
		
	}
	public function keresoTorles() {
		$_SESSION['tabla_kereses']= array('keresomezo' => '','keresoszo' => '');
	}
	public function adatBeallitas($kulcs, $ertek) {
		$this->data[$kulcs] = $ertek;
	}
	
	public function kimenet() {
		$ci = getCI();
		$out = $ci->load->view(ADMINTEMPLATE.'forms/tablazat_fejlec_view', $this->data, true);
		$out .= $ci->load->view(ADMINTEMPLATE.'forms/tablazat_sorok_view', $this->data, true);
		
		if($this->lapozo) {			$this->lapozo($this->start,$this->limit,$this->ossz);
			$out .= $ci->load->view(ADMINTEMPLATE.'forms/tablazat_lapozo', $this->data, true);
		}
		if($this->sortable) {
			if(!globalisMemoria('sortableKodBetoltve')) {
				globalisMemoria('sortableKodBetoltve', true);
				$out .= $ci->load->view(ADMINTEMPLATE.'forms/tablazat_sortable', $this->data, true);
			}
			$out .= $ci->load->view(ADMINTEMPLATE.'forms/tablazat_sortable_futtatas', $this->data, true);
		}
		return $out;
	}
	
	
}

class Szovegmezo {
	var $data = array();
	
	public function __construct($adat) { 
		$this->data = $adat; 
		
	}
	public function kimenet() {
		$ci = getCI();
		if($this->data['nevtomb']!='') {
			$this->data['name'] = $this->data['nevtomb'].'['.$this->data['mezonev'].']'; 
		} else { 
			$this->data['name'] = $this->data['mezonev'];
		}
		
		return $ci->load->view(ADMINTEMPLATE.'forms/input_szoveg_view', $this->data, true);
	} 
} class Urlapgomb {
	var $data = array();	
	public function __construct($adat) { 
		$this->data = $adat; 
	}
	public function kimenet() {
		$ci = getCI();
		if($this->data['nevtomb']!='') {
			$this->data['name'] = $this->data['nevtomb'].'['.$this->data['mezonev'].']'; 
		} else { 
			$this->data['name'] = $this->data['mezonev'];
		}		return $ci->load->view(ADMINTEMPLATE.'forms/input_gomb_view', $this->data, true);
	} 
} 
class AjaxFeltolto {
	var $data = array();
	
	public function __construct($adat) { 
		$this->data = $adat; 
		
	}
	public function kimenet() {
		$ci = getCI();
		if($this->data['nevtomb']!='') {
			$this->data['name'] = $this->data['nevtomb'].'['.$this->data['mezonev'].']'; 
		} else { 
			$this->data['name'] = $this->data['mezonev'];
		}
		
		return $ci->load->view(ADMINTEMPLATE.'forms/input_ajaxfeltolto', $this->data, true);
	} 
} 
class Filefeltolto {
	var $data = array();
	
	public function __construct($adat) { 
		$this->data = $adat; 
		
	}
	public function kimenet() {
		$ci = getCI();
		if($this->data['nevtomb']!='') {
			$this->data['name'] = $this->data['nevtomb'].'['.$this->data['mezonev'].']'; 
		} else { 
			$this->data['name'] = $this->data['mezonev'];
		}
		
		return $ci->load->view(ADMINTEMPLATE.'forms/input_file_view', $this->data, true);
	} 
} 
class Szovegdoboz {
	var $data = array();
	
	public function __construct($adat) { 
		$this->data = $adat; 
		$this->data['tipus'] = 'textarea';
		
	}
	public function kimenet() {
		$ci = getCI();
		if($this->data['nevtomb']!='') {
			$this->data['name'] = $this->data['nevtomb'].'['.$this->data['mezonev'].']'; 
		} else { 
			$this->data['name'] = $this->data['mezonev'];
		}
		
		return $ci->load->view(ADMINTEMPLATE.'forms/input_textarea_view', $this->data, true);
	} 
}
class HTMLtartalom {
	var $data = array();
	
	public function __construct($html) { 
		$this->data['html'] = $html; 
		
		
	}
	public function kimenet() {
		return $this->data['html'];
	} 
} 
class Jelolonegyzet {
	var $data = array();
	
	public function __construct($adat) { 
		$this->data = $adat; 
		
	}
	public function kimenet() {
		$ci = getCI();
		
		if($this->data['nevtomb']!='') {
			$this->data['name'] = $this->data['nevtomb'].'['.$this->data['mezonev'].']'; 
		} else { 
			$this->data['name'] = $this->data['mezonev'];
		}
		
		return $ci->load->view(ADMINTEMPLATE.'forms/input_checkbox_view', $this->data, true);
	} 
} 
class Legordulo {
	var $data = array();
	
	public function __construct($adat) { 
		$this->data = $adat; 
		$this->data['tipus'] = 'legordulo';
	}
	public function kimenet() {
		$ci = getCI();
		if($this->data['nevtomb']!='') {
			$this->data['name'] = $this->data['nevtomb'].'['.$this->data['mezonev'].']'; 
		} else { 
			$this->data['name'] = $this->data['mezonev'];
		}
		 
		return $ci->load->view(ADMINTEMPLATE.'forms/input_select_view', $this->data, true);
	} 
} class Adminlapgenerator extends Forms {	}

