<?php


class Content_Type_Model extends ORM{

	
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'name';
		}
		return parent::unique_key($id);
	}

}