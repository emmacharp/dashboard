<?php

require_once(TOOLKIT . '/class.administrationpage.php');
require_once(EXTENSIONS . '/dashboard/extension.driver.php');

Class contentExtensionDashboardIndex extends AdministrationPage {
	
	public function __construct(&$parent) {
		parent::__construct($parent);
	}
	
	public function __viewIndex() {
		
		$this->setPageType('form');
		$this->setTitle(__('Symphony') . ' &ndash; ' . __('Dashboard'));
		
		$this->addScriptToHead(URL . '/extensions/dashboard/assets/jquery-ui-1.8.2.custom.min.js', 29421);
		$this->addStylesheetToHead(URL . '/extensions/dashboard/assets/dashboard.css', 'screen', 29422);
		$this->addScriptToHead(URL . '/extensions/dashboard/assets/dashboard.js', 29423);
		
		$heading = new XMLElement('h2', __('Dashboard'));
		
		$create_new = new XMLElement('a', __('Create New'), array(
			'class'	=> 'create button',
			'href'	=> '#',
			'id'	=> 'select-panel-type'
		));
	
		$panel_types = array();
		Administration::instance()->ExtensionManager->notifyMembers('DashboardPanelTypes', '/backend/', array(
			'types' => &$panel_types
		));
		
		$panel_types_options = array();
		foreach($panel_types as $handle => $name) {
			$panel_types_options[] = array($handle, false, $name);
		}
	
		$heading->appendChild($create_new);
		$heading->appendChild(Widget::Select('panel-type', $panel_types_options));
		
		if(Administration::instance()->Author->isDeveloper()) {
			$heading->appendChild(
				new XMLElement('a', __('Enable Edit Mode'), array(
					'class'	=> 'edit-mode button',
					'href'	=> '#',
					'title' => __('Disable Edit Mode')
				))
			);
		}
		
		$this->Form->appendChild($heading);
		
		$container = new XMLElement('div', NULL, array('id' => 'dashboard'));
		
		$primary = new XMLElement('div', NULL, array('class' => 'primary sortable-container'));
		$secondary = new XMLElement('div', NULL, array('class' => 'secondary sortable-container'));
		
		$panels = Extension_Dashboard::getPanels();
		
		foreach($panels as $p) {
			
			$html = Extension_Dashboard::buildPanelHTML($p);
			
			switch($p['placement']) {
				case 'primary': $primary->appendChild($html); break;
				case 'secondary': $secondary->appendChild($html); break;
			}
			
		}
		
		$container->appendChild($primary);
		$container->appendChild($secondary);		
		$this->Form->appendChild($container);
		
	}
	
}