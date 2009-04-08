<?php


class Content_Category_Model extends ORM{

	protected $has_many = array('pages' => 'content_pages');

}