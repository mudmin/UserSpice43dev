<?php
function _assert( $expr, $msg){ if( !$expr ) print "<br/><b>ASSERTION FAIL: </b>{$msg}<br>";  }

function prepareMenuTree($menuResults){
	/*
	Get instance of tree manager and build the tree
	*/
	$treeManager = treeManager::get();
	$menuTree = $treeManager->getTree($menuResults, 'id','parent','display_order');
	/*
	Indent the tree
	*/
	//$menuTree = $treeManager->slapTree($recordsTree, 1 ); //1 for indent count

	return $menuTree;
}

function prepareIndentedMenuTree($menuResults){
	/*
	Get instance of tree manager and build the tree
	*/
	$treeManager = treeManager::get();
	$menuTree = $treeManager->getTree($menuResults, 'id','parent','display_order');
	/*
	Indent the tree
	*/
	$menuIndentedTree = $treeManager->slapTree($menuTree, 1,'menu_title' ); //1 for indent count

	return $menuIndentedTree;
}

function prepareDropdownString($menuItem){
	$itemString='';
	$itemString.='<li class="dropdown">';
	$itemString.='<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].' <span class="caret"></span></a>';
	$itemString.='<ul class="dropdown-menu">';
	foreach ($menuItem['children'] as $childItem){
		$itemString.=prepareItemString($childItem);
	}
	$itemString.='</ul></li>';
	return $itemString;
}

function prepareItemString($menuItem){
	$itemString='';
	$itemString.='<li><a href="'.US_URL_ROOT.$menuItem['link'].'"><span class="'.$menuItem['icon_class'].'"></span> '.$menuItem['label'].'</a></li>';
	return $itemString;

}
?>
