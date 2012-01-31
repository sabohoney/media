<?php
/**
 * CakePHP Plupload Plugin
 * Plupload Controller
 * 
 * Copyright (c) 2011 junichi11
 * 
 * @author junichi11
 * @license MIT LICENCE
 */
class UploaduisController extends MediaAppController {
	var $name = 'Uploaduis';
	var $uses = array('Upfile', 'Media.Attachment', 'Media.Related');
	var $helpers = array('Session', 'Pjax.Pjax');
	var $components = array('Session', 'RequestHandler', 'Pjax.Pjax');

	//===============================================
	// action 
	//===============================================
	function popup($model = null) {
		if (!$model) {
			// error
		}
	}

	function upload() {
		if (!empty($this->data)) {
			$this->Upfile->create();
			if ($this->Upfile->saveAll($this->data, array('validate' => 'first'))) {
				$this->Upfile->recursive = 2;
				$this->data = $this->Upfile->read(null, $this->Upfile->getLastInsertID());
			}
			$this->set(compact('file'));
		}
	}

	function dataset() {
		
		$this->log($this->_getSubmitName(array('registry', 'delete')), LOG_DEBUG);
		if (($this->RequestHandler->isPost() || $this->RequestHandler->isAjax()) && $this->data) {
			
			if (isset($this->data['Upfile']['id'])) {
				
				switch ($this->_getSubmitName(array('registry', 'delete'))) {
					case 'delete':
						//$this->data = $this->Upfile->read(null, $this->data['Upfile']['id']);
						//$this->data['Attachment'][0]['delete'] = true;
						if ($this->Upfile->delete($this->data['Upfile']['id']) !== false) {
							$this->redirect(array(
								'plugin' => 'media',
								'controller' => 'uploaduis',
								'action' => 'popup'
							));
						}
						break;
					default:
					case 'registry':
							$this->Upfile->recursive = 2;
							$this->data = $this->Upfile->read(null, $this->data['Upfile']['id']);
						break;
				}
			}
		}
	}

	function search() {
		
		if ($this->RequestHandler->isAjax() || $this->RequestHandler->isPost()) {
			
			$this->layout = 'ajax';
			Configure::write('debug', 0);
			if ($this->data) {
				$conditions = empty($this->data['Related']['basename']) ? array() : array('Related.basename LIKE' => "%{$this->data['Related']['basename']}%");
				$limit = 10;
				$order = array('Related.created' => 'desc');
				$pageOption = compact('conditions', 'limit', 'order');
				$this->Session->write('pageOption', $pageOption);
			} else if ($this->Session->check('pageOption')) {
				$pageOption = $this->Session->read('pageOption');
			}
			// 検索処理
			$this->paginate = array(
				'Related' => $pageOption,
			);

			// send to view
			$this->set('rows', $this->paginate('Related'));
			
			// View Status
			$viewstatus = isset($this->data['Related']['viewstatus']) ? $this->data['Related']['viewstatus'] : ($this->Session->check('viewstatus') ? $this->Session->read('viewstatus') : '');
			switch ($viewstatus) {
				case 1:
					$this->Session->write('viewstatus', 1);
					$this->render('tabular');
					break;
				case 2:
					$this->Session->write('viewstatus', 2);
					$this->set('assocAlias', 'Related');
					$this->render('thumbnail');
					break;
				default:
					$this->redirect(array(
						'plugin' => 'media',
						'controller' => 'uploaduis',
						'action' => 'error',
					));
					break;
			}
		}
	}

	function delete() {
		
		if ($this->RequestHandler->isAjax() || $this->RequestHandler->isPost()) {
			
			$this->layout = 'ajax';
			Configure::write('debug', 0);
			if ($this->data['Upfile']['id']) {
				
				if ($this->Upfile->delete($this->data['Upfile']['id']) !== false) {
					$this->redirect(array(
						'plugin' => 'media',
						'controller' => 'uploaduis',
						'action' => 'popup'
					));
				}
			}
		}
	}

	function error() {}
}
