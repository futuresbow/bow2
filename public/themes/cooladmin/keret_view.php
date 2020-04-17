<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Adminisztráció</title>

    <!-- Fontfaces CSS-->
    <link href="<?= $stilusUrl;?>css/font-face.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="<?= $stilusUrl;?>vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="<?= $stilusUrl;?>vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>vendor/vector-map/jqvmap.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="<?= $stilusUrl;?>css/theme.css" rel="stylesheet" media="all">
    <link href="<?= $stilusUrl;?>css/extra.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
	
	
<div class="loading">Loading&#8230;</div>


	
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <img src="<?= $stilusUrl;?>images/icon/logo-white.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                
                <nav class="navbar-sidebar2">
					<?php $ci = getCI(); $foMenuk = $ci->Sql->gets('adminmenu', " WHERE szulo_id = 0 ORDER BY sorrend ASC");?>
					
					
                    <ul class="list-unstyled navbar__list">
						<?php $tag = ws_belepesEllenorzes(); foreach($foMenuk as $menupont): if(!$tag->is($menupont->jogkor)) continue;?>
						<?php $alMenuk = $ci->Sql->gets('adminmenu', " WHERE szulo_id = ".$menupont->id." ORDER BY sorrend ASC ");?>

						<?php if($alMenuk): ?>
						
                        <li class="<?= (strtolower(globalisMemoria("Nyitott menüpont"))==strtolower($menupont->felirat))?'active':''; ?> has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas <?= $menupont->ikonosztaly;?>"></i><?= $menupont->felirat;?>
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <?php foreach($alMenuk as $menupont): if(!$tag->is($menupont->jogkor)) continue;?>
                                
                                
                                <?php if($menupont->modul_eleres=='elvalaszto')  {?>

								<li class="separator"> </li>

								<?php } elseif($menupont->felirat=='dinamikus') { 
									ws_autoload($menupont->modul_eleres); 
									$fnc = $menupont->modul_eleres.'_adminmenu' ;
									$mlista = $fnc(); if($mlista)foreach($mlista as $msor) {?>
								
								<li class=""><a href="<?= $msor->modul_eleres?>"><?= $msor->felirat;?></a></li>

								<?php } } else { ?>

								<li><a href="<?= ADMINURL.$menupont->modul_eleres;?>" ><?= $menupont->felirat;?></a></li>

								<?php } ?>
                                
                                
                               <?php endforeach;?>
                            </ul>
                        </li>
                        
                        <?php else: ?>
                        
                        <li>
                            <a href="<?= ADMINURL.$menupont->modul_eleres; ?>">
                                <i class="<?= $menupont->ikonosztaly;?>"></i><?= $menupont->felirat;?></a>
                            
                        </li>
                        
                        <?php endif;?>
                        
                     
					<?php endforeach; ?>
					
					</ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="<?= ADMINURL; ?>">
                                    <img src="<?= $stilusUrl;?>images/icon/logo-white.png" alt="CoolAdmin" />
                                </a>
                            </div>
                            <div class="header-button2">
                                
                                <div class="header-button-item mr-0 js-sidebar-btn">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>
                                <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="<?= base_url();?>">
                                                <i class="zmdi zmdi-account"></i>Oldal megtekintése</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="<?= ADMINURL; ?>felhasznalok/kilepes">
                                                <i class="zmdi zmdi-settings"></i>Kijelentkezés</a>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
                <div class="logo">
                    <a href="#">
                        <img src="<?= $stilusUrl;?>images/icon/logo-white.png" alt="Cool Admin" />
                    </a>
                </div>
                <div class="menu-sidebar2__content js-scrollbar2">
                    <?php $tag = ws_belepesEllenorzes(); ?>
                    <div class="account2">
                        <div class="monocircle">
                            <?= $tag->monogram();?>
                        </div>
                        <h4 class="name"><?= $tag->teljesNev();?></h4>
                        <a href="<?= ADMINURL; ?>felhasznalok/kilepes">Kilépés</a>
                    </div>
                    <nav class="navbar-sidebar2">
                        <ul class="list-unstyled navbar__list">
                            <ul class="list-unstyled navbar__list">
						<?php $tag = ws_belepesEllenorzes(); foreach($foMenuk as $menupont): if(!$tag->is($menupont->jogkor)) continue;?>
						<?php $alMenuk = $ci->Sql->gets('adminmenu', " WHERE szulo_id = ".$menupont->id." ORDER BY sorrend ASC ");?>

						<?php if($alMenuk): $nyitva = false; if(strtolower(globalisMemoria("Nyitott menüpont"))==strtolower($menupont->felirat)) $nyitva = true;?>
						
                        <li class="<?= ($nyitva)?'active':''; ?> has-sub">
                            <a class="js-arrow <?= ($nyitva)?'open':''; ?>" href="#">
                                <i class="fas <?= $menupont->ikonosztaly;?>"></i><?= $menupont->felirat;?>
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            
                            <ul class="list-unstyled navbar__sub-list js-sub-list" style="<?= ($nyitva)?'display:block;':''; ?>">
                                <?php foreach($alMenuk as $menupont): if(!$tag->is($menupont->jogkor)) continue;?>
                                
                                
                                <?php if($menupont->modul_eleres=='elvalaszto')  {?>

								<li class="separator"> </li>

								<?php } elseif($menupont->felirat=='dinamikus') { 
									ws_autoload($menupont->modul_eleres); 
									$fnc = $menupont->modul_eleres.'_adminmenu' ;
									$mlista = $fnc(); if($mlista)foreach($mlista as $msor) {?>
								
								<li class=""><a href="<?= $msor->modul_eleres?>"><?= $msor->felirat;?></a></li>

								<?php } } else { ?>

								<li><a href="<?= ADMINURL.$menupont->modul_eleres;?>" ><?= $menupont->felirat;?></a></li>

								<?php } ?>
                                
                                
                               <?php endforeach;?>
                            </ul>
                        </li>
                        
                        <?php else: ?>
                        
                        <li>
                            <a href="<?= ADMINURL.$menupont->modul_eleres; ?>">
                                <i class="<?= $menupont->ikonosztaly;?>"></i><?= $menupont->felirat;?></a>
                            
                        </li>
                        
                        <?php endif;?>
                        
                     
					<?php endforeach; ?>
                            
                         
                        </ul>
                    </nav>
                </div>
            </aside>
            <!-- END HEADER DESKTOP-->

            <!-- BREADCRUMB-->
            <section class="au-breadcrumb m-t-75">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="au-breadcrumb-content">
                                    <div class="au-breadcrumb-left">
                                        <ul class="list-unstyled list-inline au-breadcrumb__list">
                                            
                                            <li class="list-inline-item active"><a href="<?= ADMINURL; ?>" title="">Főoldal</a></li>
                                            
                                            <?php $utvonal = globalisMemoria('utvonal');if($utvonal): ?>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <?php foreach($utvonal as $k => $elem):?>

											<li  class="list-inline-item active">

												<?php if(isset($elem['url'])): ?>

												<a href="<?= ADMINURL. $elem['url'];?>" title="<?= $elem['felirat'];?>"><?= $elem['felirat'];?></a>

												<?php else: ?>

												<?= $elem['felirat'];?>

												<?php endif; ?>

											</li>
											<?php if(isset($utvonal[$k+1])):?>
											<li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
											<?php endif;?>

											<?php endforeach;endif; ?>
                                            
                                           
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END BREADCRUMB-->

            <section>
				<?php if($this->input->get('m')):?>

					<div class="alert <?= ($this->input->get('c')=='hiba')?' alert-danger ':'';?>"><?= $this->input->get('m'); ?></div>

				<?php endif;?>
				<?php if(globalisMemoria('adminUzenet')): ?>

					<div class="alert " ><?= globalisMemoria('adminUzenet'); ?></div>

				<?php endif;?>
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
							
							
							
							
                            <div class="col-xl-12">
                               <?= $modulKimenet; ?>            
                            </div>
                        
                        </div>
                    </div>
                </div>
            </section>

            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="<?= $stilusUrl;?>vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="<?= $stilusUrl;?>vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="<?= $stilusUrl;?>vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="<?= $stilusUrl;?>vendor/slick/slick.min.js">
    </script>
    <script src="<?= $stilusUrl;?>vendor/wow/wow.min.js"></script>
    <script src="<?= $stilusUrl;?>vendor/animsition/animsition.min.js"></script>
    <script src="<?= $stilusUrl;?>vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="<?= $stilusUrl;?>vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="<?= $stilusUrl;?>vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="<?= $stilusUrl;?>vendor/circle-progress/circle-progress.min.js"></script>
    <script src="<?= $stilusUrl;?>vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= $stilusUrl;?>vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="<?= $stilusUrl;?>vendor/select2/select2.min.js">
    </script>
    <script src="<?= $stilusUrl;?>vendor/vector-map/jquery.vmap.js"></script>
    <script src="<?= $stilusUrl;?>vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="<?= $stilusUrl;?>vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="<?= $stilusUrl;?>vendor/vector-map/jquery.vmap.world.js"></script>

    <!-- Main JS-->
    <script src="<?= $stilusUrl;?>js/main.js"></script>
	
	
	 <script>



function adminJs() {

	this.opcioHozzaadas = function(tid, tipus) {

		adatok = $('.termekForm').serialize() ;

		$.post('<?= ADMINURL?>termek/valtozatesopcio/'+tid+'?ajax=1&tipus='+tipus, adatok, function(r){

			$('.valtozat_es_opcio').html(r);

		});

	}

	this.opcioBetoltes = function(tid, tid2) {

		adatok = $('.termekForm').serialize() ;

		$.post('<?= ADMINURL?>termek/valtozatesopcio/'+tid+'?ajax=1&masolat='+tid2, adatok, function(r){

			$('.valtozat_es_opcio').html(r);

		});

	}

	

	this.kelFeltoltes = function(mpid) {

		 var fd = new FormData();

		var files = $('#imgupload')[0].files[0];

		fd.append('file',files);

		fd.append('request',1);

		fd.append('mpid',mpid);



		// AJAX request

		$.ajax({

			url: '<?= ADMINURL; ?>termek/imageupload/'+mpid+'?ajax=1',

			type: 'post',

			data: fd,

			contentType: false,

			processData: false,

			success: function(response){

				if(response != 0){

					aJs.kepgaleria(response);

				}else{

				alert('Nem sikerült a kép feltöltése');

				}

			}

		});

	}

	

	this.ajaxKepFeltoltes = function(id, url) {
		
		 var fd = new FormData();

		var files = $('#'+id)[0].files[0];

		fd.append('file',files);

		fd.append('request',1);

		

		// AJAX request

		$.ajax({

			url: url+'?ajax=1',

			type: 'post',

			data: fd,

			contentType: false,

			processData: false,

			success: function(response){

				if(response != 0){

					

					$('.ajaxVisszairas').html(response);

					$('.ajaxfile').val();

				}else{

					alert('A feltöltés nem sikerült');

					$('.ajaxfile').val();

				}

			}

		});

	}

	

	this.kepgaleria = function(response) {

		mpid = tid;

		var lista = JSON.parse(response);

		$('.kepkonyvtar').html('');

		console.log(lista);

		for(i = 0; i < lista.length; i++) {

			kep = lista[i];

			img = $('<img data-kep="'+kep.id+'" class="galeriakep" src="<?= base_url(); ?>'+kep.file+'" />');

			$(img).css('margin', '5px');

			$(img).click(function(){ $('#kepparamimput').val($(this).attr('data-kep'));$('.galeriakep').removeClass('kepborder');$(this).addClass('kepborder'); });

			blokk = $('<div class="keptaska"></div>');

			torlogomb = $('<button data-kep="'+kep.id+'" type="button" class="btn brn-danger btn-smal">Törlés</button>').

						click(function(){ $.post('<?= ADMINURL; ?>termek/keptorles/'+mpid+'?ajax=1', {'kep':$(this).attr('data-kep') });$(this).parent().fadeOut(); });

			$(blokk).append(img).append('<br>').append(torlogomb);

			$('.kepkonyvtar').append(blokk);

		}

	}
	this.kepHuzasInditas = function(tid) {
		var dropZone = document.getElementById('dropZone');

		// Optional.   Show the copy icon when dragging over.  Seems to only work for chrome.
		dropZone.addEventListener('dragover', function(e) {
			e.stopPropagation();
			e.preventDefault();
			e.dataTransfer.dropEffect = 'copy';
		});

		// Get file data on drop
		dropZone.addEventListener('drop', function(e) {
			e.stopPropagation();
			e.preventDefault();
			var files = e.dataTransfer.files; // Array of all files
			aJs.fatyolStart();
			for (var i=0, file; file=files[i]; i++) {
				if (file.type.match(/image.*/)) {
					var reader = new FileReader();

					reader.onload = function(e2) {
						// finished reading file data.
						var img = document.createElement('img');
						// e2.target.result;
						
						$.post('<?= ADMINURL; ?>termek/imageupload/'+editedTid+'?ajax=1', {file:e2.target.result, tid:editedTid}, function(r) { 
							aJs.kepgaleria(r);
							aJs.fatyolStop();
						});
						
					}

					reader.readAsDataURL(file); // start reading the file data.
				}
			}
		});
	}
	this.termekHozzaadas = function(rid,o) {

		this.readOnly();

		id = $(o).val();

		$.get('<?= ADMINURL; ?>rendelesek/termekhozzadas/'+rid+'?tid='+id+'&ajax=1', function (r) {

			if(r!=1) {

				alert("Hiba a termék hozzáadásánál!");

			} else {

				$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termeklista/'+rid+'?&ajax=1');

			}

			aJs.nemReadOnly();

		});

	}

	this.rendelesKoltsegHozzaadas = function(rid,o) {

		id = $(o).val();

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/koltseghozzaadas/'+rid+'?koltsegtipus='+id+'&ajax=1');

	}

	this.rendelesArmodositoTorles = function(rid,mid) {

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/armodositotorles/'+rid+'?mid='+mid+'&ajax=1');

	}

	this.rendelesTermeklista = function(rid) {

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termeklista/'+rid+'?&ajax=1');

	}

	

	this.rendelesTermekDb = function(rid, tid, mod) {

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekdarabmodositas/'+rid+'?tid='+tid+'&mod='+mod+'&ajax=1');

	}

	

	this.rendelesTermekValtozatMentes = function(rid, tid, o) {

		vid = $(o).prev('select').val();

		

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekvaltozatmodositas/'+rid+'?tid='+tid+'&vid='+vid+'&ajax=1');

	}

	this.rendelesTermekValtozatMentes2 = function(rid, tid, o) {

		vid = $(o).prev('select').val();

		

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekvaltozatmodositas/'+rid+'?tid='+tid+'&vid='+vid+'&ajax=1');

	}

	

	this.rendelesValtozatTorles = function(rid, tid, vid) {

		this.readOnly();

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/rendelesvaltozattorles/'+rid+'?tid='+tid+'&vid='+vid+'&ajax=1',function(){

			aJs.nemReadOnly();

		});

	}

	

	this.rendelesValtozatTorles2 = function(rid, tid, vid) {

		this.readOnly();

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/rendelesvaltozattorles/'+rid+'?tid='+tid+'&vid='+vid+'&ajax=1',function(){

			aJs.nemReadOnly();

		});

	}

	

	this.rendelesOpcioTorles = function(rid, tid, oid) {

		this.readOnly();

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekopciotorles/'+rid+'?tid='+tid+'&oid='+oid+'&ajax=1',function(){

			aJs.nemReadOnly();

		});

	}

	this.readOnly = function() {

		$('input').attr('readonly', true).fadeTo( "slow" , 0.5);

		$('select').attr('readonly', true).fadeTo( "slow" , 0.5);

		$('textarea').attr('readonly', true).fadeTo( "slow" , 0.5);

		

	}

	this.nemReadOnly = function() {

		$('input').prop('readonly', false).fadeTo( "slow" , 1);

		$('select').attr('readonly', false).fadeTo( "slow" , 1);

		$('textarea').attr('readonly', false).fadeTo( "slow" , 1);

		

	}

	this.rendelesArmodositoModositas = function(rid) {

		this.readOnly();

		$.post('<?= ADMINURL; ?>rendelesek/armodositomodositas/'+rid+'?ajax=1', $('#rendelesForm').serialize(),function() {

			$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termeklista/'+rid+'?ajax=1', function(){

				aJs.nemReadOnly();

			});

		});



	}

	this.cikkszamGeneralas = function() {
		$('#cikkszamertek').val(this.unicID());
	}
	this.unicID = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return Math.random().toString(36).substr(2, 3).toUpperCase()+"-"+Math.random().toString().substr(2, 4);
};
	this.rendelesTermekOpcioMentes = function(rid, tid, o) {

		this.readOnly();

		oid = $(o).prev('select').val();

		

		$('.rendeltTermekekDiv').load('<?= ADMINURL; ?>rendelesek/termekopciomodositas/'+rid+'?tid='+tid+'&oid='+oid+'&ajax=1', function() {

			aJs.nemReadOnly();

		});

	}

	this.cimMasolas = function() {

		$('#szall_nev').val($('#szaml_nev').val());

		$('#szall_orszag').val($('#szaml_orszag').val());

		$('#szall_telepules').val($('#szaml_telepules').val());

		$('#szall_utca').val($('#szaml_utca').val());

		$('#szall_irszam').val($('#szaml_irszam').val());

		

	}

	this.fatyolStop = function() {

		$('.loading').fadeOut(400);

	}

	this.fatyolStart = function() {

		$('.loading').show();

	}
	this.bruttoSzamitas = function() {
		
		ar = Number($('#arertek').val());
		afa = Number($('#afaertek').val());
		brutto = 0;
		if(afa!=0){
			brutto = ar + ((ar/100)*afa);
		} 
		$('#bruttoertek').val(brutto);
		return brutto;
	}
	this.jellemzoBetoltes = function(csoportid, tid) {
		
		
		$('#jellemzo_szerkeszto').load('<?= ADMINURL; ?>termek/jellemzoform/'+tid+'?ajax=1&csoportid='+csoportid );

	};
		
		
	
	this.nettoSzamitas = function() {
		
		ar = Number($('#bruttoertek').val());
		afa = Number($('#afaertek').val());
		netto = 0;
		if(afa!=0){
			netto = ar/( 1 + afa/100 );
			netto = (parseInt(netto*100))/100;
		} 
		$('#arertek').val(netto);
		return netto;
	}
	this.keszletNoveles = function(o, mod) {

		

		inp = $(o).parent().find('input') ;

		db = parseInt($(inp).val())+mod;

		console.log(db);

		if(db<=0) {

			$(inp).val(0);

		} else {

			$(inp).val(db)

		}

	}

}



var aJs = new adminJs();



	$().ready(function(){ aJs.fatyolStop(); window.onbeforeunload = function(event) {  aJs.fatyolStart(); };});

	

</script>



<script>

    $().ready(function () {

      // Basic instantiation:

      $('.cpic').colorpicker({

		   format: 'hex'

	});

});



      

    

  </script>

  

  <script>

$('.mcpic').colorpicker({

	format: 'hex'

});

</script>


	
	
	
</body>

</html>
<!-- end document-->
