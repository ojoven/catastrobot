<?php

// Require external libraries
require_once 'functions.php';
require_once 'vendor/simple_html_dom.php';

// Init vars
$htmlResponse = '';
$folderDps = 'data/htmls/dps';
$folderProperties = 'data/htmls/properties';
$urlBase = 'http://www4.gipuzkoa.net/ogasuna/catastro/';
$urlPost = $urlBase . 'porDP.asp';
$urlReferer = $urlPost;
$municipio = 'DONOSTIA-SAN SEBASTIAN';
$alreadyProperties = array();
$propertyReferer = 'http://www4.gipuzkoa.net/ogasuna/catastro/refCatastral.asp';

$pathToPortalsCSV = 'data/csvs/portals.csv';
// Portal Titles
clearFile($pathToPortalsCSV);

$portalTitles = array(
	'Calle',
	'Portal',
	'Ref. Catastral',
	'Zona',
	'Superficie Parcela'
);
writeToCSV($pathToPortalsCSV, $portalTitles);

$pathToPropertiesCSV = 'data/csvs/properties.csv';

// Property Titles
clearFile($pathToPropertiesCSV);

$propertyTitles = array(
	'Calle',
	'Portal',
	'Finca',
	'Ref. Catastral',
	'Zona',
	'Valor Suelo Total',
	'Valor Catastral Total',
	'Escalera',
	'Planta',
	'Mano',
	'Destino',
	'Superficie (m2)',
	'Tipo',
	'Valor Catastral Local',
	'Valor Suelo Local',
	'Valor Construcción Local',
	'Año Construcción'
);
writeToCSV($pathToPropertiesCSV, $propertyTitles);

// Streets (extracted from streets.php)
$streets = json_decode('["AÑORGA-TXIKI, GRUPO","AÑORGA, AVENIDA DE","ABALOTZ, AUTOVIA DE","ADARRA, PLAZOLETA","ADUNA, PLAZA","AGERRE, CAMINO DE","AGIRRE MIRAMON","AGITI, CAMINO DE","AGORRENE, PASEO DE","AIENAS","AIETE, PASEO DE","AINGERU ZAINDARIA, CAMINO DE","AINTZIETA, PASEO DE","AITZOL PARKEA","AIZKOLENE","AIZKORRI","ALAIALDE, GRUPO","ALAIONDO, GRUPO","ALCALDE JOSE ELOSEGI","ALDAKONEA","ALDAMAR","ALDAPA","ALDAPABIDE","ALDAPETA, CUESTA DE","ALDERDI EDER, PARQUE DE","ALEJANDRIA","ALFONSO VIII","ALFONSO XIII, PLAZA","ALGARBE","ALIÑATEGI","ALICE GULICK, PARQUE DE","ALIRI, CAMINO DE","ALKAINBIDE","ALKIZA, PLAZA DE","ALKOLEA","ALKOLEA, PASAJE DE","ALMORTZA","ALTO DE AMARA","ALTO DE LOS ROBLES","ALTO SAN BARTOLOME","ALTXUENE, CAMINO DE","ALTZA, PASEO DE","AMAIA, PARQUE DE","AMAIUR, PARQUE DE","AMARA","AMASORRAIN KALEA","AMERICA, PLAZA DE","AMETZAGAÑA","AMEZKETA, CAMINO DE","AMEZKETARREN KALEA","AMEZTI","ANDER ARZELUS LUZEAR, PLAZA DE","ANDEREÑO E. ZIPITRIA","ANDIA","ANDOAIN","ANDRE ZIGARROGILEEN PLAZA","ANDRESTEGI","ANGEL","ANGELA FIGUERA PLAZA","ANOETA, PASEO DE","ANTONDEGI GAIN, CAMINO DE","ANTONIO ARZAK","ANTONIO GAZTAÑETA","ANTONIO MARIA LABAIEN","ANTONIO VALVERDE","APAOR","APARTADO DE CORREOS","APOSTOLADO","ARABA, PARQUE DE","ARAGOI","ARAUNDI","ARBIZA, CAMINO DE","ARBIZKETA PARKEA","ARBOL DE GERNIKA, PASEO","ARBOLA, PASEO DE","ARBUSTOS, PASEO DE LOS","ARGEL, PASEO DE","ARKAZIETA, PARQUE DE","ARMERIAS, PLAZA DE","AROSTEGI","ARQUITECTOS KORTAZAR","ARRAPIDE, PASEO DE","ARRASATE","ARRIBERRI, GRUPO","ARRIOLA, PASEO DE","ARRITXULO, CAMINO DE","ARRIZAR, GRUPO","ARROAS","ARROKA","ARROKA, PLAZA DE","ARTIKUTZA, PLAZA DE","ARTOLATEGI","ARTURO CAMPION","ARTXIPI, CAMINO DE","ASTIGARRAGA, PLAZA","ASTILLEROS","ATARI EDER, PLAZA DE","ATARIZAR","ATEGORRIETA, AVENIDA DE","ATEGORRIETA,CALZADA VIEJA","ATOTXAKO ZELAIA PLAZA","ATOTXARREKA, CAMINO","AUTONOMIA","AVES, PASEO DE LAS","AZERILEKU BIDEA","AZKARATENE","AZKOITIA, PLAZA DE","AZKUENE","AZPEITIA","BADERAS","BAIONA, PLAZA DE","BALDOMERO ANABITARTE, PZ","BALENTEGI","BALLENEROS","BARATZATEGI","BARAZAR","BARCELONA ETORBIDEA","BARKAIZTEGI, CAMINO","BASCONGADA, PASEO DE","BASOERDI, PARQUE DE","BASOTXIKI","BASOZABAL, CAMINO DE","BAZTAN","BELARTZA KALEA","BELIZALDE","BELOKA, PASEO DE","BELTRAN PAGOLA","BENGOETXEA","BENITA ASAS PLAZA","BENTABERRI","BENTABERRI, PLAZA DE","BENTATXIKI, CAMINO DE","BERABERA, PASEO DE","BERGARA","BERIO, PASEO DE","BERIO,PARQUE DEPORTIVO DE","BERMINGHAM","BERNARDO ESTORNES LASA","BERNART ETXEPARE, PLAZA","BEROIZ","BERRA BEHEA","BERRA BIDEA","BERRATXO BIDEA","BERRIDI, CAMINO DE","BERTSOLARI TXIRRITA PS","BERTSOLARI XALBADOR","BIARRITZ, PLAZA DE","BILBAO, PLAZA DE","BILINTX","BITERI, PLAZA DE","BITORIANO IRAOLA, PLAZA","BIZKAIA, PASEO DE","BLAS DE LEZO","BLAS DE OTERO, PLAZA DE","BORDATXIPI, PASEO DE","BORROTO","BOULEVARD, ALAMEDA","BRETXA PLAZA","BRUNET","BUEN PASTOR, PLAZA","BUENAVISTA, AVENIDA DE","BURDINAZKO ZUBIA","BUZTINTXULO","BUZTINZURI, CAMINO","CAMINO","CAMPANARIO","CARLOS BLASCO DE IMAZ, PZ","CARLOS I, AVENIDA DE","CARMELO ETXEGARAI","CARQUIZANO","CASA NAO","CASARES, PASEO DE","CASERIO PARADA","CASTELAO, PARQUE DE","CASTILLA","CATALINA DE ERAUSO","CATALUÑA, PLAZA DE","CEDRO, PLAZA DEL","CENTENARIO, PLAZA DEL","CERVANTES, PLAZA DE","CESAR CHICOTE","CLARA CAMPOAMOR, PLAZA DE","CLAUDIO A. LUZURIAGA","COFRADIAS DONOSTIARRAS","COLOMBINE","COLON, PASEO DE","CONCHA, PASEO DE LA","CONSTITUCION, PLAZA DE LA","CONSULADO","CORSARIOS VASCOS","CORTA","CRISTINA-ENEA, PARQUE DE","CRISTOBAL BALENCIAGA, PS","DAIRA DE BOJADOR, PLAZA","DARIETA, CAMINO DE","DEPORTE, PLAZA DEL","DOCTOR BEGIRISTAIN, PASEO","DOCTOR CLAUDIO DELGADO","DOCTOR MADINABEITIA","DOCTOR MARAÑON, PASEO DEL","DOMINGO AGUIRRE, PASEO","DONIBANE GARAZI","DONOSTI ZARRA, GRUPO","DULCE MARIA LOYNAZ","DUNAS","DUQUE DE BAENA, PASEO DEL","DUQUE DE MANDAS, PASEO DEL","EASO","EASO, PLAZA","EBRO","EDERRENA","EDUARDO CHILLIDA, PASEO","EGIA","EGIA, CALZADA DE","EGUZKI EDER","EGUZKITZA, PLAZA DE","EIBAR, PLAZA DE","ELENATEGI","ELGOIBAR KALEA","ELHUYAR, PLAZA DE","ELIAS SALABERRIA","ELISABETE MAIZTEGI","ELIZASU","ELKANO","EMBELTRAN","ENRIQUE CASAS PLAZA","ERMITA, CAMINO DE LA","ERRAMUNENE","ERREKALDE, AVENIDA DE","ERREKATXULO KALEA","ERRONDO GAINEKO","ERRONDO, PASEO DE","ERROTA BERRI PARKEA","ERROTA-AUNDIETA, PLAZA DE","ERROTA, CAMINO DE","ERROTABURU, PASEO DE","ERROTATXO","ERROTATXO, PLAZUELA","ERROTAZAR, CAMINO DE","ESCOLTA REAL","ESCRITOR JOSE ARTETXE","ESKALANTEGI","ESKALANTEGI PARKEA","ESPAÑA, PLAZA DE","ESPARTXOKO ZUBIA","ESTERLINES","ESTUDIOS, PLAZA DE LOS","ETARTE, CAMINO DE","ETUME, CAMINO DE","ETXAIDE","ETXEBERRI, PLAZA DE LOS","ETZABAL","ETZIETA, PARQUE","EUGENIO IMAZ KALEA","EUROPA, PLAZA DE","EUSKADI, PLAZA DE","EUSKAL HERRIA","EUSTASIO AMILIBIA","EXTREMADURA","FARO, PASEO DEL","FE, PASEO DE LA","FEDERICO GARCIA LORCA, PS","FELIPE IV, AVENIDA DE","FELIX GABILONDO, PLAZA DE","FELIX IRANZO PASEALEKUA","FERMIN CALBETON","FERNANDO MUGICA KALEA","FERNANDO SASIAIN KALEA","FERRERIAS","FLORES","FRANCES","FRANCIA, PASEO DE","FRANCISCO LOPEZ ALEN","FRANTZISKO GASKUE","FRANTZISKO GRANDMONTAGNE","FUENTERRABIA","FUEROS, PASEO DE LOS","FUNICULAR, PLAZA DEL","GABRIEL ARESTI, PASEO","GABRIEL CELAYA, PLAZA","GABRIEL M. LAFITTE, PLAZA","GALICIA, PASEO DE","GANTXEGI, CAMINO DE","GARBERA BIRIBILUNEA","GARBERA ZEHARBIDEA","GARBERA, CAMINO DE","GARIBAI","GARRO","GASCUÑA, PLAZA DE","GAZTAÑAGA, PLAZA DE","GAZTELU","GENERAL ARTETXE","GENERAL ETXAGUE","GENERAL JAUREGI","GENERAL LERSUNDI","GERRAENE BIDEA","GETARIA","GIPUZKOA, PLAZA DE","GIUSEPPE VERDI PLAZA","GLORIA","GOIAZTXIKI, CAMINO DE","GOIKO GALTZARA BERRI","GOIZUETA","GOLOSALDE","GOMISTEGI","GORGATXO, PLAZA DE","GORRITI","GRACIA OLAZABAL","GRAN VIA","GREGORIO ORDOÑEZ","GUARDAPLATA, CAMINO DE","GUARNIZO, PARQUE DE","GUDAMENDI, CAMINO DE","GUINEA ECUATORIAL, PLAZA DE","GURUTZE ALDE, GRUPO","GURUTZE, PASEO DE","GURUTZEGI KALEA","HARRIA PARKEA","HARROBIETAKO PLAZA","HERIZ, PASEO DE","HERMANOS OTAMENDI","HERNANI","HERRERA, PASEO DE","HERRIKO LURRA, PLAZA DE","HERRIKO PLAZA","HIPICA, CAMINO DE LA","HIRU DAMATXO, PLAZA DE","HUERTAS","HUMBOLDT","IÑAKI ALDABALDE, PLAZA DE","IÑIGO","IBAETA, PLAZA DE","IBAETAKO PARKEA","IBAIALDE","IDIAKEZ","IGARA, CAMINO DE","IGELDO PLAZA","IGELDO, PASEO DE","IGELTEGI","IGLESIA","IGNACIO MERCADER, PLAZA","IGNACIO UGARTE, PLAZA DE","IJENTEA","ILLARRA BERRI","ILLARRA, CAMINO DE","ILLUNBE","INDALECIO PRIETO","INDIANOENE","INESSA DE GAXEN","INFANTA BEATRIZ","INFANTA CRISTINA","INFANTE DON JAIME","INFANTE DON JUAN","INTXAURDEGI","INTXAURRONDO","IPARRAGIRRE","IRADIENE","IRASMOENE","IRIBAR","IRIBAR, PLAZA DE","IRIGOIEN","IRUN, PLAZA DE","IRURAK","IRURESORO, PASAJE DE","IRURESORO, PLAZA DE","ISABEL II, AVENIDA DE","ISIDRO ANSORENA","ISLA DE SANTA CLARA","ISTINGORRA","ISTURIN","ITSASALDE","IZA","IZABURU","IZOSTEGI, PASEO DE","IZTUETA","IZURUN, PLAZA DE","JACQUES COUSTEAU PLAZA","JAIALAI","JAVIER BARKAIZTEGI","JESUS M ALKAIN PLAZA","JESUS MARIA DE LEIZAOLA P","JOANA DE ALBRET","JOLASTOKIETA","JORGE OTEIZA, PLAZA DE","JOSE ARANA","JOSE GOIKOA","JOSE M\u00aa ARIZMENDIARRIETA","JOSE MARIA BUSCA ISUSI","JOSE MARIA SALABERRIA","JOSE MARIA SERT, PLAZA DE","JOSE MARIA SOROA","JOSE MIGUEL BARANDIARAN P","JOSE SEBASTIAN LABOA","JOSEBA ZUBIMENDI","JUAN ABELINO BARRIOLA PS","JUAN ASTIGARRIBIA KALEA","JUAN CARLOS GUERRA","JUAN DE ANTXIETA, PLAZA","JUAN DE BILBAO","JUAN DE GARAI","JUAN FERMIN GILISAGASTI","JUAN GOROSTIDI, PLAZA DE","JUAN OLASAGASTI","JUAN XXIII, PASEO DE","JUAN ZARAGUETA","JUANISTEGI, CAMINO","JULIANAENE","JULIMASENE","JULIO BEOBIDE","JULIO CARO BAROJA, PLAZA DE","JULIO URKIJO, PASEO DE","KAÑUETA BIDEA","KAIARRIBA, PLAZA DE","KAIMINGAINTXO, PLAZA DE","KAPITAIÑENE","KARLOS SANTAMARIA, PLAZA DE","KARMELE SAINT-MARTIN","KASKARRE","KATALINA ELEIZEGI","KATXOLA","KOLDO MITXELENA, PARQUE","KONKORRENEA","KONPORTA","KONPORTA, PLAZA DE","KRISTOBALDEGI, CAMINO DE","LANBERRI","LANDARBASO, CAMINO DE","LAPABIDE","LAPURDI, PLAZA DE","LARRAÑATEGI, CAMINO","LARRAGA, CAMINO DE","LARRAMENDI","LARRATXO, PASEO DE","LARRAUNDI","LARRERDI PLAZA","LASALA, PLAZA DE","LASARMENDI, CAMINO","LASARTE, PLAZA DE","LASTA, PLAZA DE","LASTUENE PARKEA","LATSARI, PLAZA DE","LAUAIZETA","LAUAIZETA PARKEA","LAUTXIMINIETA, PLAZA DE","LAZKANO BIRIBILUNEA","LAZKANO, PASEO DE","LEARRITZA, PASEO DE","LEGAZPI","LEIRE PLAZA","LEOSIÑETA","LIBERTAD, AVENIDA DE LA","LIZARDI","LIZARDIA PLAZA","LIZARRA KALEA","_logROÑO","LOIOLA","LOIOLA, TRAVESIA DE","LOIOLATARRA","LOISTARAIN","LORENZO ALZATE, PLAZA DE","LORETE, CAMINO DE","LOUIS-LUCIEN BONAPARTE","LOURDES IRIONDO PLAZA","LUGAÑENE PASEALEKUA","LUGAÑENEKO ZUBIA","LUGARITZ BIRIBILUNEA","LUGARITZ PASEALEKUA","LUIS MARTIN SANTOS, PLAZA DE","LUIS MURUGARREN","LUIS PEDRO PEÑA SANTIAGO","LUIS PRADERA","LUISES","LUISES OBREROS, PLAZA DE LOS","MACONDO","MADALENA JAUREGIBERRI,PS","MADRID, AVENIDA DE","MAESTRO ARBOS, PASEO","MAESTRO GURIDI","MAESTRO SANTESTEBAN","MALDATXO","MANTEO KALEA","MANTEROLA","MANTULENE","MANUEL LARDIZABAL, PASEO","MANUEL LEKUONA","MANUEL VAZQUEZ MONTALBAN","MARABIETA, CAMINO DE","MARBIL PARKEA","MARBIL, CAMINO DE","MARCELINO SOROA, PLAZA DE","MARI","MARIA CRISTINAREN ZUBIA","MARIA DE MAEZTU","MARIA DOLORES AGIRRE","MARIA DOLORES GOIA, PLAZA DE","MARIA ZAMBRANO, PLAZA DE","MARIE CURIE PARKEA","MARINA","MARINO TABUYO","MARINOS, PLAZA DE LOS","MARKOTEGI BIDEA","MARQUES MIRAFLORES","MARRUS, CAMINO DE","MARRUTXIPI","MARRUTXIPI BEHEKO, CAMINO","MARTINEZ DE ITXASKUE, PZ","MARTUTENE, PASEO DE","MARUGAME, PLAZA","MATEO ERROTA","MATIA","MATXIÑENE","MAULEON","MAURICE RAVEL, PLAZA DE","MAYOR","MELODI","MELODI, PARQUE DE","MENDIALAI","MENDIGAIN","MENDIOLA, CAMINO DE","MENTXU GAL LORATEGIAK","MERCADERES, PLAZA DE","MERKEZABAL","MIGUEL DE UNAMUNO, PARQUE","MIGUEL IMAZ","MIGUEL MUÑOA, PLAZA","MIGUEL PELAY OROZCO","MIKELETEGI, PASEO DE","MIKELETES, PASEO DE LOS","MIRACONCHA, PASEO DE","MIRACRUZ","MIRAMAR","MIRAMAR, PARQUE DE","MIRAMON, PARQUE DE","MIRAMON, PASEO DE","MIRANDA","MISERICORDIA","MOLINAO, CAMINO DE","MOLLABERRIA","MOLLAERDIA","MONS, PASEO DE","MONTE ERNIO","MONTE URGULL","MONTES FRANCOS, PARQUE","MONTESOL, GRUPO","MORAZA","MORLANS, PASEO DE","MORLANS, ROTONDA DE","MUELLE, PASEO DEL","MUGITEGI","MUNDAIZ","MUNDAIZ ZUBIA","MUNIBE","MUNTO","MUNTOGORRI, CAMINO","MURGIL, CAMINO DE","NAFARROA BEHEREA, PLAZA","NARRICA","NAVARRA, AVENIDA DE","NEMESIO ETXANIZ","NEMESIO OTAÑO, PLAZA DE","NESTOR BASTERRETXEA PLAZA","NICANOR ZABALETA, PLAZA","NORNAHI, PLAZA DE","NTRA. SRA. DE UBA, PASEO DE","NTRA. SRA. DEL CORO","NTRA. SRA. DEL PILAR, GR","NTRA.SRA. DE ARANZAZU, GRUPO","NUEVA","NUEVO, PASEO","OÑATI, PLAZA DE","OIARTZUN","OIHENART","OKENDO","OKENDO PLAZA","OKENDOTEGI, CAMINO DE","OLAETA PLAZA FERRERIAS","OLARAIN","OLETA, CALZADA DE","OLMOS, PASEO DE LOS","ONDARBIDE","ONDARRETA, PASEO DE","ONDARRETAKO LORATEGIA","ORIAMENDI, PASEO DE","ORIO, PARQUE DE","ORIXE, PASEO","OTXANDA PARKEA","OTXOKI PARKEA","OTXOKI, PASEO DE","PABLO GOROSABEL","PABLO SARASATE","PABLO SOROZABAL, PLAZA DE","PADRE CLARET, PLAZA DEL","PADRE DONOSTIA, PLAZA","PADRE LARROCA","PADRE MEAGHER, PLAZA DEL","PADRE ORKOLAGA, PASEO","PADRE VINUESA, PLAZA","PAGOLA KALEA","PAKEA, PLAZA DE","PALACIO","PALOMA MIRANDA, PLAZA DE","PAMPLONA","PARAISO","PARQUE","PARTICULAR ATEGORRIETA","PASAIAKO PORTUKO ZEHARBID","PASAJES","PASAJES SAN PEDRO,AV","PATXIKUENE","PATXILLARDEGI, GRUPO","PEÑA Y GOÑI","PEÑAFLORIDA","PEDRO AXULAR","PEDRO CORMENZANA","PEDRO EGAÑA","PEDRO JOSE, CAMINO DE","PEDRO MANUEL COLLADO","PEDRO MANUEL UGARTEMENDIA","PELLO MARI OTAÑO","PEPE ARTOLA","PERUJOANTXO","PESCADERIA","PESCADORES DE TERRANOVA","PESCADORES DEL GRAN SOL","PETRITEGI, CAMINO DE","PETRITZA, CAMINO DE","PILLOTEGI, CAMINO DE","PINARES, PLAZA DE","PINOS, CAMINO DE LOS","PIO BAROJA, PASEO DE","PIO XII, PLAZA DE","PLAZABURU","PLYMOUTH, PLAZA DE","PODABINES","POKOPANDEGI, CAMINO","POLLOE, PLAZA DE","PORTUENE","PORTUETXE","PORTUTXO, PLAZA DE","PREBOSTES, PLAZA DE LOS","PRIM","PUERTO","PUIO","PUTZUETA, CAMINO DE","RAFAEL MUNOA","RAMON LABAYEN ALKATEAREN PLAZA","RAMON MARIA LILI, PASEO","RAMON Y CAJAL","REAL CIA.GUIP DE CARACAS","REINA REGENTE","RENO, PLAZA DE","RENTERIA","REPUBLICA ARGENTINA,PS","RESINES Y OLORIZ PARKEA","RESURRECCION MARIA AZKUE","REYES CATOLICOS","RIBERA DE LOIOLA PS","RICARDO IZAGIRRE, PLAZA","RIO BIDASOA","RIO DEBA","RIO OIARTZUN","RODIL KALEA","ROGELIO GORDON","ROMAN IRIGOYEN, PLAZA DE","RONDA","ROSARIO ARTOLA","ROTETA","ROTETA AZPIKOA","ROTETA BEHEKO","ROTETA GOIKOA","SABENE, CAMINO DE","SAGASTIEDER, PASEO DE","SAGASTIZAR, PLAZA DE","SAGRADA FAMILIA","SALAMANCA, PASEO DE","SALUD","SALVADOR ALLENDE PARKEA","SAN ANTONIO","SAN BARTOLOME","SAN BARTOLOME, CALLEJON","SAN BLAS","SAN CRISTOBAL","SAN FRANCISCO","SAN FRANCISCO JAVIER","SAN IGNACIO, CALZADA DE","SAN JERONIMO","SAN JUAN","SAN JUAN DE DIOS, CAMINO DE","SAN JUAN DE LUZ, PLAZA DE","SAN LORENZO","SAN LUIS GONZAGA, PLAZA","SAN MARCIAL","SAN MARCIAL, PLAZA DE","SAN MARCOS, CAMINO DE","SAN MARTIN","SAN ROQUE","SAN VICENTE","SANCHEZ TOCA","SANCHO EL SABIO, AVENIDA","SANSERREKA, PASEO DE","SANSUSTENE","SANTA BARBARA","SANTA CATALINA","SANTA CATALINAKO ZUBIA","SANTA CORDA","SANTA KRUZ PLAZA","SANTIAGO PLAZA","SARRIEGI, PLAZA DE","SARRUETA PASEALEKUA","SARRUETA, ROTONDA DE","SASUATEGI, CAMINO DE","SATRUSTEGI, AVENIDA DE","SAUCE, PLAZA DEL","SECUNDINO ESNAOLA","SEGUNDO IZPIZUA","SERAPIO MUGICA, PASEO DE","SERRANO ANGUITA","SIBILIA","SIERRA DE ALOÑA","SIERRA DE ARALAR","SIERRA DE URBASA","SIMONA DE LAJUST","SIUSTEGI, PARQUE DE","SOKAMUTURRA KALESKA","SOLDADOS, PLAZA DE LOS","SORALUZE","SUBIDA AL CASTILLO","SUKIA","SUSTRAIARTE","TEJERIA","TELESFORO ARANZADI","TERESA DE CALCUTA PLAZA","TOKI EDER, PASEO DE","TOLAREGOIA","TOLARIETA, CAMINO DE","TOLOSA, AVENIDA DE","TOMAS GARBIZU KALEA","TOMAS GROS","TONTORGOXO","TORCUATO LUCA DE TENA","TORIBIO ALZAGA CALLE DE","TRANVIA","TRENBIDE ZAHAR","TRENTO","TRINIDAD, PLAZA DE LA","TRIUNFO","TRUEBA","TTURKOENE","TUNIZ","TXALIN, CAMINO DE","TXALUPAGILLENE, PLAZA DE","TXAPALDEGI, PLAZA DE","TXAPARRENE, PASEO DE","TXAPILLO","TXAPINENE","TXIMISTARRI, CAMINO","TXINGURRI, PASEO DE","TXOFRE","TXOFRE, PLAZA DEL","TXURDIÑENE, CAMINO","TXURRUKA","UBA, CAMINO DE","UBARBURU, PASEO DE","UBEGI TR DE","ULIA, PASEO DE","UNTZAENE","UR ZALEAK, PASAJE DE","URBIA","URBIETA","URBITARTE, PASEO DE","URDANETA","URDINZUKO ZUBIA","URNIETA","URRETXU","URSALTO","URUMEA, PASEO DEL","USANDIZAGA","USURBIL","VALENCIA, PLAZA DE","VALENTIN OLANO","VALLE LERSUNDI, PLAZA DE","VASCONIA, PLAZA DE","VICENTA MOGUEL","VICTOR HUGO","VIRGEN DEL CARMEN","VIRGEN DEL CORO","VITORIA-GASTEIZ","WIESBADEN","XABIER AIZARNA PASEALEKUA","XABIER LIZARDI","XABIER ZUBIRI, PLAZA DE","ZABALETA","ZANDARDEGI, CAMINO","ZAPATARI, PLAZA DE","ZARAGOZA, PLAZA DE","ZARATEGI, PASEO DE","ZARAUTZ KALEA","ZEMORIYA","ZILARGIÑENE, CAMINO DE","ZORROAGA, PASEO DE","ZORROAGAGAINA KALEA","ZUATZU","ZUAZNABAR","ZUBEROA, PLAZA DE","ZUBIAURRE, PASEO DE","ZUBIBERRI, CAMINO DE","ZUBIETA","ZUBIETA, PLAZA DE","ZUBIMUSU, PARQUE DE","ZUBIONDO","ZUHAIZTI, PLAZA","ZULOAGA, PLAZA DE","ZUMALAKARREGI, AVENIDA DE","ZURRIOLA HIRIBIDEA","ZURRIOLA PASEALEKUA","ZURRIOLAKO ZUBIA","ZUZENENE, CAMINO DE","31 DE AGOSTO"]', true);

// We loop over the streets
foreach ($streets as $street) {

	_log('Getting info street: ' . $street);

	$portal = 1;
	$notWorkingPortalNumbers = 0;
	$maxNotWorkingPortalNumbers = 5;

	$streetLatin1 = str_replace('%25', '%', rawurlencode(str_replace('Ñ', '%D1', $street)));

	// We get the portals for that street
	$urlPortalsStreet = 'http://www4.gipuzkoa.net/ogasuna/catastro/selPortal.asp?mapa=DONOSTIA-SAN%20SEBASTIAN&calle=' . $streetLatin1 . '&portal=';

	$htmlPortalsStreet = file_get_contents($urlPortalsStreet);
	$htmlPortalsStreet = iconv("ISO-8859-1", "UTF-8", $htmlPortalsStreet);
	$html = str_get_html($htmlPortalsStreet);

	$portals = array();
	foreach ($html->find('a') as $link) {

		if ($link->plaintext != "") {
			$portals[] = $link->plaintext;
		}

	}

	// Now that we have the portals, let's get the HTML for each of them
	foreach ($portals as $portal) {

		_log('Getting info portal: ' . $portal);

		// First we check if the portal for that street is already saved
		$pathToPortalStreet = $folderDps . '/' . $street . '_' . $portal . '.html';

		if (file_exists($pathToPortalStreet)) {

			// If saved, we get the HTML from it
			$htmlResponse = file_get_contents($pathToPortalStreet);

		} else {

			$params = array(
				'municipio' => $municipio,
				'calle' => iconv("UTF-8", "ISO-8859-1", $street),
				'portal' => $portal
			);

			$htmlStringObjectMoved = curlPostViaShell($urlPost, $params);

			// We parse the DOM of the HTML requested
			$htmlObjectMoved = str_get_html($htmlStringObjectMoved);

			// The link is correct if we get a Object Moved on <h1> tag
			$correctLink = $htmlObjectMoved->find('h1', 0);

			if (!$correctLink) continue;

			// We get the link
			$link = $htmlObjectMoved->find('a', 0);

			if (!$link) continue;

			$propertyUrl = $link->href;
			$propertyUrl = htmlspecialchars_decode($propertyUrl);
			$url = $urlBase . $propertyUrl;
			$htmlResponse = getURLWithReferer($url, $urlReferer);

			// We save the HTML
			file_put_contents($pathToPortalStreet, $htmlResponse);

		}

		// We save the info of the portal to portals.csv
		$html = str_get_html($htmlResponse);
		$portalInfoArray = array();

		foreach ($html->find('td') as $td) {
			$possibleTdText = $td->plaintext;
			if (strpos($possibleTdText, ':') !== false && strlen(trim($possibleTdText)) < 80) { // It's one of the table cells with info
				$possibleTdArray = explode(':', $possibleTdText);

				$portalInfoArray[] = $possibleTdArray;
			}
		}

		$portalRow = array(
			removeSpaces($portalInfoArray[2][1]), // calle
			removeSpaces($portalInfoArray[4][1]), // portal
			removeSpaces($portalInfoArray[3][1]), // ref. catastral
			removeSpaces($portalInfoArray[1][1]), // zona
			removeSpaces($portalInfoArray[5][1]), // superficie parcela
		);

		writeToCSV($pathToPortalsCSV, $portalRow);

		// We get now the HTMLs for each property
		foreach ($html->find('tr') as $tr) {

			$firstTdLink = $tr->find('a', 0);
			if (!$firstTdLink) continue;

			$onclick = $firstTdLink->getAttribute('onclick');

			if (!$onclick) continue;

			$firstTdText = $firstTdLink->plaintext;

			$propertyValues = explode('&nbsp;', $firstTdText);

			$url = $urlBase . 'finca.asp';
			$params = array(
				'idFinca' => $propertyValues[0],
				'codDigito' => $propertyValues[1]
			);

			if (in_array($propertyValues[0], $alreadyProperties)) continue;

			$alreadyProperties[] = $propertyValues[0];
			$alreadyProperties = array_slice($alreadyProperties, -10, 10);
			print_r($alreadyProperties);

			_log('Getting info property: ' . $propertyValues[0]);

			$pathToProperty = $folderProperties . '/' . $street . '_' . $portal . '_'. $propertyValues[0] . '.html';

			if (file_exists($pathToProperty)) {

				$htmlResponseProperty = file_get_contents($pathToProperty);

			} else {

				$htmlResponseProperty = curlPost($url, $params, $propertyReferer);
				file_put_contents($pathToProperty, $htmlResponseProperty);
				chmod($pathToProperty, 0777);
			}

			// We save the info of the property to properties.csv
			$html = str_get_html($htmlResponseProperty);
			$propertyInfoArray = array();

			if (!$html) continue;

			foreach ($html->find('td') as $td) {
				$possibleTdText = $td->plaintext;
				if (strpos($possibleTdText, ':') !== false && strlen(trim($possibleTdText)) < 80) { // It's one of the table cells with info
					$possibleTdArray = explode(':', $possibleTdText);

					$propertyInfoArray[] = $possibleTdArray;
				}
			}

			if (strpos($propertyInfoArray[0][0], 'Año')) {
				unset($propertyInfoArray[0]);
				$propertyInfoArray = array_values($propertyInfoArray);
			}

			$propertyRow = array(
				removeSpaces($propertyInfoArray[3][1]), // calle
				removeSpaces($propertyInfoArray[5][1]), // portal
				removeSpaces($propertyInfoArray[1][1]), // finca
				removeSpaces($propertyInfoArray[4][1]), // ref. catastral
				removeSpaces($propertyInfoArray[2][1]), // zona
				str_replace('&euro;', '', removeSpaces($propertyInfoArray[6][1])), // valor suelo
				str_replace('&euro;', '', removeSpaces($propertyInfoArray[7][1])), // valor catastral
			);

			// Now we get the info from locals
			$tableToSearchIn = $html->find('table', 12);
			foreach ($tableToSearchIn->find('tr') as $index => $localRow) {
				if ($index == 0 || $index == 1) continue;

				$propertyRowCopy = $propertyRow;

				foreach ($localRow->find('td') as $td) {
					$propertyRowCopy[] = $td->plaintext;
				}

				writeToCSV($pathToPropertiesCSV, $propertyRowCopy);
			}

		}

	}

}

?>
<h1>CATASTRO BOT</h1>

<?php echo $htmlResponse; ?>