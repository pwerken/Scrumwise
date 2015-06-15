#!/usr/bin/php
<?php
require_once 'Scrumwise/Scrumwise.php';

$p = Scrumwise::getProject();

exit;


foreach($p->backlogItems as $bl) {
	if(count($bl->tasks) > 0)
		continue;

	if($bl->sprintID > 0) {
		echo "SKIP ".$bl->name."\n";
		continue;
	}
	echo ">>>> ".$bl->name."\n";
}

function clusterZut() {
	global $p;
	$tDC = $p->getTag('Deellevering-C');
	$tGR = $p->getTag('Cluster Overdruk GR');
	$tVP = $p->getTag('Cluster VloeistofpompInstallatie');

	clusterApp('Overdruk GR',		[$tDC, $tGR]);
	clusterApp('VloeistofpompInstallatie',	[$tDC, $tVP]);

	$tDD = $p->getTag('Deellevering-D');
	$tBE = $p->getTag('Cluster Bediening');
	$tDG = $p->getTag('Cluster Dienstgebouw');
	$tCF = $p->getTag('Cluster Interbuiscoördinatie');
	$tTU = $p->getTag('Cluster Tunnel');

	clusterApp('Bediening',	[$tDD, $tBE]);
	clusterApp('Dienstgebouw',	[$tDD, $tDG]);
	clusterApp('Interbuiscoördinatie',	[$tDD, $tCF]);
	clusterApp('Tunnel',	[$tDD, $tTU]);
}
function clusterApp($naam, $tags) {
	global $p;
	$t3B = $p->getTag('3B');
	$tGUI = $p->getTag('GUI');
	backlogItem('Cluster informatie '.$naam, NULL, array_merge($tags, [$t3B, $tGUI]));
	backlogItem('Applicatie '.$naam, NULL,         array_merge($tags, [$t3B, $tGUI]));
	backlogItem('GUI Cluster '.$naam, NULL,        array_merge($tags, [$tGUI]));
}

function simItems() {
	simItem('simSOS');
	simItem('simSOSsectie');
	simItem('simOmroepVB');
	simItem('simOmroepsectie');
	simItem('simHF');
	simItem('simVerlichtingVB');
	simItem('simVerlichtingszone');
	simItem('simVerkeerslichten');
	simItem('simVerkeerslicht');
	simItem('simMTMKoppeling');
	simItem('simMTMSignaalgever');
	simItem('simAfsluitboom');
	simItem('simHulppost');
	simItem('simCCTVVB');
	simItem('simCamera');
	simItem('simBeeldregSysteem');
	simItem('simOpgenomenCameraKnl');
	simItem('simNoodtelefoon');
	simItem('simNoodtelefoontoestel');
	simItem('simLangsventilatie');
	simItem('simVentilator');
	simItem('simLuchtkwaliteitsmeting');
	simItem('simZichtmeter');
	simItem('simRijVanVluchtdeuren');
	simItem('simVluchtdeur');
	simItem('simVluchtdeurindicatie');
	simItem('simContourverlichting');
	simItem('simGeluidsbaken');
	simItem('simHulpdienstpaneel');
	simItem('simCCTVDG');
	simItem('simToegang');
	simItem('simBlusvoorziening');
	simItem('simKlimaatregeling');
	simItem('simInbraakalarm');
	simItem('simVerlichtingDG');
	simItem('simBluswatervoorziening');
	simItem('simBluswaterreservoir');
	simItem('simBluswaterdistLeiding');
	simItem('simDrukverhogendeInstal');
	simItem('simBrandbluspomp');
	simItem('simJockeypomp');
	simItem('simEnergievoorziening');
	simItem('simNSA');
	simItem('simNoBreak');
	simItem('simTransformator');
	simItem('simNetaansluiting');
	simItem('simEnergiedistrNetwerk');
	simItem('simBeveiliging');
	simItem('simIntercom');
	simItem('simIntercomtoestel');
	simItem('simC2000');
	simItem('simTelefoonvoorziening');
	simItem('simVloeistofpompInstal');
	simItem('simPomp');
	simItem('simNiveaumeter');
	simItem('simOverdrukvoorzGrensr');
	simItem('simOverdrukventilatorTU');
	simItem('simCaDo');
	simItem('simBediening');
	simItem('simBeeldvoorzienMeldkamer');
	simItem('simTerreinverlichting');
	simItem('simWaarschuwingsInstal');
	simItem('simSignaalgever');
	simItem('simBrandmeldinstallatie');
	simItem('simEventRecorder');
	simItem('simKoppelingExterneSyst');
	simItem('simNoodbediening');
}
function simItem($naam) {
	global $p;
	$tSIM = $p->getTag('SIM');
	backlogItem($naam, 0.5, [$tSIM]);
}

function reworkS6_2() {
	global $p;

	$tRE = $p->getTag('REWORK');
	$tPO = $p->getTag('POKEREN');

	$t3B = $p->getTag('3B');
	$tG  = $p->getTag('GUI');

	$tDB = $p->getTag('Deellevering-B');
	$tVG = $p->getTag('Cluster Verkeersgeleiding');

#	reworkItem('bfOverdrukVR',				[$tRE, $tPO, $t3B, $tDA, $tVR]);
#	reworkItem('sfOverdrukventilatorVR',	[$tRE, $tPO, $t3B, $tDA, $tVR]);
	reworkItem('gtoMTMKoppeling',			[$tRE, $tPO, $tG,  $tDB, $tVG]);
	reworkItem('gtoMTMSignaalgtever',		[$tRE, $tPO, $tG,  $tDB, $tVG]);

}

function reworkS6descr() {
	reworkItemDescr('sfAlarmStoring');
	reworkItemDescr('ofEventdetectie');
	reworkItemDescr('TransitiestatusPatroon');
	reworkItemDescr('sfStatusmelding');

	reworkItemDescr('bfVerlichtingVR');
	reworkItemDescr('bfKopdeurMTK');
	reworkItemDescr('bfDynVluchtrouteInd');
	reworkItemDescr('bfOmroepVR');
	reworkItemDescr('gtoKopdeurMTK');
	reworkItemDescr('gtoOmroepVR');
	reworkItemDescr('gtoVerlichtingVR');
	reworkItemDescr('gtoDynVluchtrouteInd');

	reworkItemDescr('bfTerreinverlichting');

	reworkItemDescr('cfVeiligeRuimte');
	reworkItemDescr('icfVRStateControle');

	reworkItemDescr('bfEnergievoorziening');
	reworkItemDescr('sfNetaansluiting');
	reworkItemDescr('sfNSA');
	reworkItemDescr('sfNoBreak');
	reworkItemDescr('sfTransformator');
	reworkItemDescr('sbEnergiedistrNetwerk');
	reworkItemDescr('sbBeveiliging');
	reworkItemDescr('gtoEnergievoorziening');
	reworkItemDescr('gtoNetaansluiting');
	reworkItemDescr('gtoNSA');
	reworkItemDescr('gtoNoBreak');
	reworkItemDescr('gtoTransformator');
	reworkItemDescr('gtoEnergiedistrNetwerk');
	reworkItemDescr('gtoBeveiliging');

	reworkItemDescr('bfHulppost');

	reworkItemDescr('bfLuchtkwaliteitsmeting');
	reworkItemDescr('sbZichtmeter');

	reworkItemDescr('bfRijVanVluchtdeuren');
	reworkItemDescr('sfVluchtdeur');
	reworkItemDescr('gtoRijVanVluchtdeuren');
	reworkItemDescr('gtoVluchtdeur');

	reworkItemDescr('bfVerlichtingVB');
	reworkItemDescr('sfDeelverlichting');
	reworkItemDescr('sfVerlichtingszone');

	reworkItemDescr('bfMTMKoppeling');
	reworkItemDescr('sbMTMSignaalgever');
}
function reworkItemDescr($naam) {
	global $p;

	echo $naam."\n";

	$b = $p->getBacklogItem('RE: '.$naam);
	if(!$b) {
		echo "NIET GEVONDEN!";
		die;
	}
	$descr = $b->getDescription();
	$b->setDescription($descr . "\n• 'description' parameter naar String 24");
}

function reworkS6() {
	global $p;

	$tRE = $p->getTag('REWORK');

	$t3B = $p->getTag('3B');
	$tG  = $p->getTag('GUI');

	$tDA = $p->getTag('Deellevering-A');
	$tDB = $p->getTag('Deellevering-B');
	$tDD = $p->getTag('Deellevering-D');

	$tAL = $p->getTag('Cluster Algemeen');
	$tVR = $p->getTag('Cluster Veiligeruimte');
	$tEN = $p->getTag('Cluster Energie');
	$tTU = $p->getTag('Cluster Tunnel');
	$tCF = $p->getTag('Cluster Interbuiscoördinatie');
	$tHP = $p->getTag('Cluster Hulppost');
	$tVE = $p->getTag('Cluster Ventilatie');
	$tVD = $p->getTag('Cluster Vluchtdeur');
	$tVL = $p->getTag('Cluster Verlichting');
	$tVG = $p->getTag('Cluster Verkeersgeleiding');

	reworkItem('sfAlarmStoring',			[$tRE, $t3B, $tDA, $tAL]);
	reworkItem('ofEventdetectie',			[$tRE, $t3B, $tDA, $tAL]);
	reworkItem('TransitiestatusPatroon',	[$tRE, $t3B, $tDA, $tAL]);
	reworkItem('sfStatusmelding',			[$tRE, $t3B, $tDA, $tAL]);

	reworkItem('bfVerlichtingVR',			[$tRE, $t3B, $tDA, $tVR]);
	reworkItem('bfKopdeurMTK',				[$tRE, $t3B, $tDA, $tVR]);
	reworkItem('bfDynVluchtrouteInd',		[$tRE, $t3B, $tDA, $tVR]);
	reworkItem('bfOmroepVR',				[$tRE, $t3B, $tDA, $tVR]);
	reworkItem('gtoKopdeurMTK',				[$tRE, $tG , $tDA, $tVR]);
	reworkItem('gtoOmroepVR',				[$tRE, $tG , $tDA, $tVR]);
	reworkItem('gtoVerlichtingVR',			[$tRE, $tG , $tDA, $tVR]);
	reworkItem('gtoDynVluchtrouteInd',		[$tRE, $tG , $tDA, $tVR]);

	reworkItem('bfTerreinverlichting',		[$tRE, $t3B, $tDA, $tTU]);

	reworkItem('cfVeiligeRuimte',			[$tRE, $t3B, $tDA, $tVR]);
	reworkItem('gtoVeiligeRuimte',			[$tRE, $tG , $tDA, $tVR]);
	reworkItem('icfVRStateControle',		[$tRE, $t3B, $tDD, $tCF]);

	reworkItem('bfEnergievoorziening',		[$tRE, $t3B, $tDB, $tEN]);
	reworkItem('gtoEnergievoorziening',		[$tRE, $tG , $tDB, $tEN]);
	reworkItem('sfNetaansluiting',			[$tRE, $t3B, $tDB, $tEN]);
	reworkItem('gtoNetaansluiting',			[$tRE, $tG , $tDB, $tEN]);
	reworkItem('sfNSA',						[$tRE, $t3B, $tDB, $tEN]);
	reworkItem('gtoNSA',					[$tRE, $tG , $tDB, $tEN]);
	reworkItem('sfNoBreak',					[$tRE, $t3B, $tDB, $tEN]);
	reworkItem('gtoNoBreak',				[$tRE, $tG , $tDB, $tEN]);
	reworkItem('sfTransformator',			[$tRE, $t3B, $tDB, $tEN]);
	reworkItem('gtoTransformator',			[$tRE, $tG , $tDB, $tEN]);
	reworkItem('sbEnergiedistrNetwerk',		[$tRE, $t3B, $tDB, $tEN]);
	reworkItem('gtoEnergiedistrNetwerk',	[$tRE, $tG , $tDB, $tEN]);
	reworkItem('sbBeveiliging',				[$tRE, $t3B, $tDB, $tEN]);
	reworkItem('gtoBeveiliging',			[$tRE, $tG , $tDB, $tEN]);

	reworkItem('bfHulppost',				[$tRE, $t3B, $tDB, $tHP]);

	reworkItem('bfLuchtkwaliteitsmeting',	[$tRE, $t3B, $tDB, $tVE]);
	reworkItem('sbZichtmeter',				[$tRE, $t3B, $tDB, $tVE]);

	reworkItem('bfRijVanVluchtdeuren',		[$tRE, $t3B, $tDB, $tVD]);
	reworkItem('sfVluchtdeur',				[$tRE, $t3B, $tDB, $tVD]);
	reworkItem('gtoRijVanVluchtdeuren',		[$tRE, $tG , $tDB, $tVD]);
	reworkItem('gtoVluchtdeur',				[$tRE, $tG , $tDB, $tVD]);

	reworkItem('bfVerlichtingVB',			[$tRE, $t3B, $tDB, $tVL]);
	reworkItem('sfDeelverlichting',			[$tRE, $t3B, $tDB, $tVL]);
	reworkItem('sfVerlichtingszone',		[$tRE, $t3B, $tDB, $tVL]);

	reworkItem('bfMTMKoppeling',			[$tRE, $t3B, $tDB, $tVG]);
	reworkItem('sbMTMSignaalgever',			[$tRE, $t3B, $tDB, $tVG]);
}
function reworkItem($naam, $tags) {
	global $p;

	$b = backlogItem('RE: '.$naam, 0, $tags);
	$b->setType('Bug');

	tasks3Brework($b);
}
function gTOs() {
	global $p;
	$tG  = $p->getTag('GUI');

	$tDB = $p->getTag('Deellevering-B');
	$tDC = $p->getTag('Deellevering-C');
	$tDD = $p->getTag('Deellevering-D');

	$tHP = $p->getTag('Cluster Hulppost');
	$tVE = $p->getTag('Cluster Ventilatie');
	$tVG = $p->getTag('Cluster Verkeersgeleiding');
	$tVL = $p->getTag('Cluster Verlichting');
	$tVD = $p->getTag('Cluster Vluchtdeur');

#	gTO('gTOHulppost',					2, [$tG, $tDB, $tHP]);
#	gTO('gTOLuchtkwaliteitsmetingVB',	2, [$tG, $tDB, $tVE]);
#	gTO('gTOZichtmeterVB',				2, [$tG, $tDB, $tVE]);
#	gTO('gTOMTMKoppelingVB',			3, [$tG, $tDB, $tVG]);
#	gTO('gTOMTMSignaalgeverVB',			1, [$tG, $tDB, $tVG]);
#	gTO('gTOVerlichtingVB',				1, [$tG, $tDB, $tVL]);
#	gTO('gTODeelverlichtingVB',			3, [$tG, $tDB, $tVL]);
#	gTO('gTOVerlichtingszoneVB',		5, [$tG, $tDB, $tVL]);
#	gTO('gTORijVanVluchtdeurenVB',		1, [$tG, $tDB, $tVD]);
#	gTO('gTOVluchtdeurVB',				2, [$tG, $tDB, $tVD]);
}
function gTOs_VR_EN() {
	global $p;
	$tG  = $p->getTag('GUI');
	$tDA = $p->getTag('Deellevering-A');
	$tVR = $p->getTag('Cluster Veiligeruimte');
	$tEN = $p->getTag('Cluster Energie');

	gTO('gtoKopdeuren',					1, [$tG, $tDA, $tVR]);
#	gTO('gTOKopdeurMTKVR',				1, [$tG, $tDA, $tVR]);
#	gTO('gTOVerlichtingVR',				5, [$tG, $tDA, $tVR]);
#	gTO('gTODynVluchtrouteIndVR',		5, [$tG, $tDA, $tVR]);
#	gTO('gTOOmroepVR',					3, [$tG, $tDA, $tVR]);
#	gTO('gTOVeiligeRuimteVR',			3, [$tG, $tDA, $tVR]);
#	gTO('gTOOverdrukVR',				1, [$tG, $tDA, $tVR]);
#	gTO('gTOOverdrukventilatorVR',		1, [$tG, $tDA, $tVR]);
##	gTO('icfVRStateControleVR',		  0.5, [$tG, $tDD, ...]);
#
#	gTO('gTOBeveiliging',				1, [$tG, $tDA, $tEN]);
#	gTO('gTOEnergieDistributieNetwerk',	1, [$tG, $tDA, $tEN]);
#	gTO('gTOTransformator',				1, [$tG, $tDA, $tEN]);
#	gTO('gTONSA',						1, [$tG, $tDA, $tEN]);
#	gTO('gTONobreak',					1, [$tG, $tDA, $tEN]);
#	gTO('gTONetaansluiting',			1, [$tG, $tDA, $tEN]);
#	gTO('gTOEnergieVoorziening',		1, [$tG, $tDA, $tEN]);

}
function gTOs_ER_AL() {
	global $p;
	$tG  = $p->getTag('GUI');
	$tDA = $p->getTag('Deellevering-A');
	$tER = $p->getTag('Cluster Eventrecording');
	$tTU = $p->getTag('Cluster Tunnel');

	gTO('gTOEventRecorder',				1, [$tG, $tDA, $tER]);
	gTO('gTOTerreinverlichting',		1, [$tG, $tDA, $tTU]);
}
function gTOs_S5() {
	global $p;
	$tG  = $p->getTag('GUI');
	$tDB = $p->getTag('Deellevering-B');
	$tRVV= $p->getTag('Cluster Vluchtdeur');
	$tVEN= $p->getTag('Cluster Ventilatie');
	$tVER= $p->getTag('Cluster Verlichting');
	$tVKG= $p->getTag('Cluster Verkeersgeleiding');

	gTO('gTORijVanVluchtdeuren',	1, [$tG, $tDB, $tRVV]);
	gTO('gTOVluchtdeur',			1, [$tG, $tDB, $tRVV]);

	gTO('gTOLuchtkwaliteitsmeter',	1, [$tG, $tDB, $tVEN]);
	gTO('gTOZichtmeter',			1, [$tG, $tDB, $tVEN]);

	gTO('gTOVerlichting',			1, [$tG, $tDB, $tVER]);
	gTO('gTODeelverlichting',		1, [$tG, $tDB, $tVER]);
	gTO('gTOVerlichtingszone',		1, [$tG, $tDB, $tVER]);

	gTO('gTOMTMKoppeling',			1, [$tG, $tDB, $tVKG]);
	gTO('gTOMTMSignaalgever',		1, [$tG, $tDB, $tVKG]);

}
function gTOs_S6() {
	global $p;
	$tG  = $p->getTag('GUI');
	$tDB = $p->getTag('Deellevering-B');
	$tSOS= $p->getTag('Cluster SOS');
	$tVKG= $p->getTag('Cluster Verkeersgeleiding');

	gTO('gTOAfsluitboom',			1, [$tG, $tDB, $tVKG]);
	gTO('gTOVerkeerslichten',		1, [$tG, $tDB, $tVKG]);
	gTO('gTOVerkeerslicht',			1, [$tG, $tDB, $tVKG]);
	gTO('gTOVBAfsluiter',			1, [$tG, $tDB, $tVKG]);

	gTO('gTOSOS',					1, [$tG, $tDB, $tSOS]);
	gTO('gTOSOSSectie',				1, [$tG, $tDB, $tSOS]);
	gTO('gTOFileverplaatsing',		1, [$tG, $tDB, $tSOS]);
}
function gTOoverig() {
	global $p;
	$tG  = $p->getTag('GUI');

	$tDB = $p->getTag('Deellevering-B');
	$tDC = $p->getTag('Deellevering-C');
	$tDD = $p->getTag('Deellevering-D');

	$tCA = $p->getTag('Cluster CaDo');
	$tHP = $p->getTag('Cluster Hulppost');
	$tIC = $p->getTag('Cluster Intercom');
	$tNB = $p->getTag('Cluster Noodbediening');
	$tVE = $p->getTag('Cluster Ventilatie');
	$tVD = $p->getTag('Cluster Vluchtdeur');
	$tBL = $p->getTag('Cluster Blusvoorziening');
	$tTV = $p->getTag('Cluster CCTV');
	$tOR = $p->getTag('Cluster Omroep');
	$tGR = $p->getTag('Cluster Overdruk GR');
	$tVP = $p->getTag('Cluster VloeistofpompInstallatie');
	$tBE = $p->getTag('Cluster Bediening');
	$tDG = $p->getTag('Cluster Dienstgebouw');
	$tCF = $p->getTag('Cluster Interbuiscoördinatie');
	$tTU = $p->getTag('Cluster Tunnel');

	gTO('gtoCaDoTU',					1, [$tG, $tDB, $tCA]);
	gTO('gtoCaDosTU',					1, [$tG, $tDB, $tCA]);
	gTO('gtoVerlichtToeritmonitorTU',	1, [$tG, $tDB, $tCA]);

	gTO('gtoHulppostenVB',				1, [$tG, $tDB, $tHP]);
	gTO('gtoNoodtelefoonVB',			1, [$tG, $tDB, $tHP]);
	gTO('gtoNoodtelefoontoestelVB',		1, [$tG, $tDB, $tHP]);

	gTO('gtoIntercomTU',				1, [$tG, $tDB, $tIC]);
	gTO('gtoIntercomtoestelTU',			1, [$tG, $tDB, $tIC]);

	gTO('gtoNoodbedieningTU',			1, [$tG, $tDB, $tNB]);

	gTO('gtoLangsventilatieVB',			1, [$tG, $tDB, $tVE]);
	gTO('gtoVentilatieclusterVB',		1, [$tG, $tDB, $tVE]);
	gTO('gtoVentilatorVB',				1, [$tG, $tDB, $tVE]);
	gTO('gtoZichthandhavingVB',			1, [$tG, $tDB, $tVE]);

	gTO('gtoVluchtdeurindicatieVB',		1, [$tG, $tDB, $tVD]);
	gTO('gtoContourverlichtingVB',		1, [$tG, $tDB, $tVD]);
	gTO('gtoGeluidsbakenVB',			1, [$tG, $tDB, $tVD]);

	gTO('gtoBluswatervoorzieningTU',	1, [$tG, $tDC, $tBL]);
	gTO('gtoBluswaterreservoirTU',		1, [$tG, $tDC, $tBL]);
	gTO('gtoBluswaterdistLeidingTU',	1, [$tG, $tDC, $tBL]);
	gTO('gtoDrukverhogendeInstalTU',	1, [$tG, $tDC, $tBL]);
	gTO('gtoBrandbluspompTU',			1, [$tG, $tDC, $tBL]);
	gTO('gtoJockeypompTU',				1, [$tG, $tDC, $tBL]);

	gTO('gtoCCTVVB',					1, [$tG, $tDC, $tTV]);
	gTO('gtoCamera',					1, [$tG, $tDC, $tTV]);
	gTO('gtoKanaal',					1, [$tG, $tDC, $tTV]);
	gTO('gtoPreset',					1, [$tG, $tDC, $tTV]);
	gTO('gtoFavorietenlijst',			1, [$tG, $tDC, $tTV]);
	gTO('gtoBeeldregSysteem',			1, [$tG, $tDC, $tTV]);
	gTO('gtoOpgenomenCameraKnl',		1, [$tG, $tDC, $tTV]);
	gTO('gtoCCTVDG',					1, [$tG, $tDC, $tTV]);
	gTO('gtoHulpdienstpaneelVB',		1, [$tG, $tDC, $tTV]);
	gTO('gtoHulpdienstpanelenVB',		1, [$tG, $tDC, $tTV]);
	gTO('gtoBeeldvoorzienMeldkamerTU',	1, [$tG, $tDC, $tTV]);
	gTO('gtoCCTVTU',					1, [$tG, $tDC, $tTV]);
	gTO('gtoOmroepCCTVAfstemmingVB',	1, [$tG, $tDC, $tTV]);

	gTO('gtoOmroepVB',					1, [$tG, $tDC, $tOR]);
	gTO('gtoOmroepsectieVB',			1, [$tG, $tDC, $tOR]);
	gTO('gtoHFVB',						1, [$tG, $tDC, $tOR]);
	gTO('gtoGeluidsbakenmonitorVB',		1, [$tG, $tDC, $tOR]);
	gTO('gtoOmroepmonitorVB',			1, [$tG, $tDC, $tOR]);
	gTO('gtoOmroepsysteemTU',			1, [$tG, $tDC, $tOR]);

	gTO('gtoOverdrukvoorzGrensrTU',		1, [$tG, $tDC, $tGR]);
	gTO('gtoOverdrukventilatorTU',		1, [$tG, $tDC, $tGR]);

	gTO('gtoVloeistofpompInstalTU',		1, [$tG, $tDC, $tVP]);
	gTO('gtoPompTU',					1, [$tG, $tDC, $tVP]);
	gTO('gtoNiveaumeterTU',				1, [$tG, $tDC, $tVP]);
	gTO('gtoVloeistofafvoersysteemTU',	1, [$tG, $tDC, $tVP]);

	gTO('gtoBedieningTU',				1, [$tG, $tDD, $tBE]); #!!

	gTO('gtoKlimaatregelingDG',			1, [$tG, $tDD, $tDG]);
	gTO('gtoToegangDG',					1, [$tG, $tDD, $tDG]);
	gTO('gtoToegangsdeurDG',			1, [$tG, $tDD, $tDG]);
	gTO('gtoInbraakalarmDG',			1, [$tG, $tDD, $tDG]);
	gTO('gtoBlusvoorzieningDG',			1, [$tG, $tDD, $tDG]);
	gTO('gtoVerlichtingDG',				1, [$tG, $tDD, $tDG]);

	gTO('gtoVerkeersbuisVB',			1, [$tG, $tDD, $tCF]);
	gTO('gtoVRStateControleTU',			1, [$tG, $tDD, $tCF]);
	gTO('gtoVloeistofStateControlTU',	1, [$tG, $tDD, $tCF]);
	gTO('gtoTweeBuisStateControleTU',	1, [$tG, $tDD, $tCF]);

	gTO('gtoTelefoonvoorzieningTU',		1, [$tG, $tDD, $tTU]);
	gTO('gtoWaarschuwingsInstalTU',		1, [$tG, $tDD, $tTU]);
	gTO('gtoSignaalgeverTU',			1, [$tG, $tDD, $tTU]);
	gTO('gtoC2000TU',					1, [$tG, $tDD, $tTU]);
	gTO('gtoBrandmeldinstallatieTU',	1, [$tG, $tDD, $tTU]);
	gTO('gtoKoppelingExterneSystTU',	1, [$tG, $tDD, $tTU]);
}

function gTO($naam, $pts, $tags) {
	global $p;

	$b = backlogItem($naam, $pts, $tags);
	tasksGUI($b);
}

function backlogItem($naam, $pts, $tags) {
	global $p;

	echo "$naam\n";
	$b = $p->addBacklogitem($naam);
	$b->setRoughEstimate($pts, 'Points');
	$b->setType('Feature');

	foreach($tags as $tag)
		$b->tag($tag);

	return $b;
}

function addTasks3B($naam) {
	global $p;
	$b = $p->getBacklogItem($naam);
	if(!$b) {
		echo "$naam niet gevonden!";
		return;
	}
	tasks3B($b);
}
function addTasksGUI($naam) {
	global $p;
	$b = $p->getBacklogItem($naam);
	if(!$b) {
		echo "$naam niet gevonden!";
		return;
	}
	tasksGUI($b);
}

function tasks3B($b) {
	$b->addTask('SDD opstellen');
	$b->addTask('SDD review');
	$b->addTask('SDD review verwerken');
	$b->addTask('STD opstellen');
	$b->addTask('STD review ontwerper');
	$b->addTask('STD review tester');
	$b->addTask('STD review verwerken');
	$b->addTask('Code schrijven');
	$b->addTask('PCT uitvoeren');
	$b->addTask('Pre-Test uitvoeren');
	$b->addTask('SDD definitief maken');
	$b->addTask('STD definitief maken');
	$b->addTask('Code bijwerken naar laatste versie SDD');
	$b->addTask('Code definitief maken');
	$b->addTask('Code export maken');
	$b->addTask('STR genereren');
	$b->addTask('Def. of Done invullen');
}
function tasksGUI($b) {
	tasks3B($b);
	$b->addTask('GUI aspect detectie');
	$b->addTask('GUI aspect pop-up');
	$b->addTask('GUI aspect detailplattegrond');
	$b->addTask('GUI aspect overzichtsplattegrond');
	$b->addTask('GUI-3B loop test');
	$b->addTask('Afstemming SDD Graphics met RWS');
}
function tasksSIM($b) {
	$b->addTask('Code schrijven');
	$b->addTask('Code peer-review');
}

function tasks3Brework($b) {
	$b->addTask('SDD bijwerken');
	$b->addTask('SDD review');
	$b->addTask('SDD review verwerken');
	$b->addTask('STD bijwerken');
	$b->addTask('STD review ontwerper');
	$b->addTask('STD review tester');
	$b->addTask('STD review verwerken');
	$b->addTask('Code bijwerken');
	$b->addTask('Pre-Test uitvoeren');
	$b->addTask('SDD definitief maken');
	$b->addTask('STD definitief maken');
	$b->addTask('Code bijwerken naar laatste versie SDD');
	$b->addTask('Code definitief maken');
	$b->addTask('Code export maken');
	$b->addTask('STR genereren');
	$b->addTask('Def. of Done invullen');
}
