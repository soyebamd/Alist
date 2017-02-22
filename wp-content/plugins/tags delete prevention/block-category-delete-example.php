<?php
/** 
 * Block deletion of certain categories by their ID.
 *
 * Copyright (C) 2010  hakre <http://hakre.wordpress.com/>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * USAGE: 
 * 
 * Pass IDs of categories to block as array to ::bootstrap();
 * 
 * @author hakre <http://hakre.wordpress.com>
 * @see http://wordpress.stackexchange.com/questions/4439/can-i-prevent-wp-users-even-admin-from-deleting-custom-categories
 */

return blockCategoriesDeletionPlugin::bootstrap(array(33, 34, 35)); // pass IDs of categories to block as array

class blockCategoriesDeletionPlugin {
	/**
	 * @var blockCategoriesDeletionPlugin
	 */
	static $instance;
	private $categoryIDs = array();
	public static function bootstrap(array $categoryIDs) {
		if (null===self::$instance) {
			self::$instance = new self($categoryIDs);
		} else {
			throw new BadFunctionCallException(sprintf('Plugin %s already instantiated', __CLASS__));
		}
		return self::$instance;
	}
	private function isCategoryDeleteRequest() {
		$notAnCategoryDeleteRequest = 
			empty($_REQUEST['taxonomy'])
			|| empty($_REQUEST['action'])
			|| $_REQUEST['taxonomy'] !== 'category'
			|| !( $_REQUEST['action'] === 'delete' || $_REQUEST['action'] === 'delete-tag');

		$isCategoryDeleteRequest = !$notAnCategoryDeleteRequest;
		
		return $isCategoryDeleteRequest;
	}
	public function __construct(array $categoryIDs) {
		$this->categoryIDs = $categoryIDs;
		if ($this->isCategoryDeleteRequest()) {
			add_filter('check_admin_referer', array($this, 'check_referrer'), 10, 2);
			add_filter('check_ajax_referer', array($this, 'check_referrer'), 10, 2);
		}
	}
	private function blockCategoryID($categoryID) {
		return in_array($categoryID, $this->categoryIDs);
	}
	/**
	 * @-wp-hook check_admin_referer
	 * @-wp-hook check_ajax_referer
	 */
	public function check_referrer($action, $result) {
		if (!$this->isCategoryDeleteRequest()) {
			return;
		}
		$prefix = 'delete-tag_';
		if (strpos($action, $prefix) !== 0)
			return;
		$actionID = substr($action, strlen($prefix));
		$categoryID = max(0, (int) $actionID);
		if ($this->blockCategoryID($categoryID)) {
			wp_die(__('This category is blocked for deletion.'));
		}
	}
}


#EOF;