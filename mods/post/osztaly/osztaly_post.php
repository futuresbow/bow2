<?php


class Post_osztaly extends MY_Model {
	function load($id) {
		
		$kategoria = $this->sqlSor("SELECT * FROM ".DBP."post_kategoriak WHERE kategorianev LIKE '$kategoriaNev' LIMIT 1");
		if(!$kategoria) return false;
		$kategoria_id = $kategoria->id;
		$sql = "SELECT p.* FROM ".DBP."post p, ".DBP."postxkategoria x WHERE x.kategoria_id = $kategoria_id AND x.post_id = p.id ORDER BY datum LIMIT $limit";
		$lista = $this->sqlSorok($sql);
		foreach($lista as $k => $post) {
			$lista[$k]->link= base_url().beallitasOlvasas('post.oldal.url').'/'.$post->id.'/'.strToUrl($post->cim);
		}
		return $lista;
	}
		if($order != "") $order = " ORDER BY ". $order;
		$kategoria = $this->sqlSor("SELECT * FROM ".DBP."post_kategoriak WHERE kategorianev LIKE '$slug' LIMIT 1");
		if(!$kategoria) return false;
		$kategoria_id = $kategoria->id;
		$sql = "SELECT p.* FROM ".DBP."post p, ".DBP."postxkategoria x WHERE x.kategoria_id = $kategoria_id AND x.post_id = p.id $order LIMIT $limit";
		$lista = $this->sqlSorok($sql);
		foreach($lista as $k => $post) {
			$lista[$k]->link= base_url().beallitasOlvasas('post.oldal.url').'/'.$post->id.'/'.strToUrl($post->cim);
		}
		return $lista;
	}
}