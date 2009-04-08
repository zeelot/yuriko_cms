<?php
/*
 * By making this an interface, we force all content nodes to have a
 * common render() method but don't force the specific content
 * models to inherit ORM or AM, the developer can still inherit
 * any model as long as they have a render() method that displays the content.
 * 
 */
interface Content_Model{
	public function render();
}
