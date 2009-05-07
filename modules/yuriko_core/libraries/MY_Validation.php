<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
 * @TODO remove this when updating cms to K2.4
*/

class Validation extends Validation_Core{

	/**
	 * Add an error to an input.
	 *
	 * @chainable
	 * @param   string  input name
	 * @param   string  unique error name
	 * @param   string  arguments to pass to lang file
	 * @return  object
	 */
	public function add_error($field, $name, $args = NULL)
	{
		$this->errors[$field] = array($name, $args);

		return $this;
	}

	/**
	 * Return the errors array.
	 *
	 * @param   boolean  load errors from a lang file
	 * @return  array
	 */
	public function errors($file = NULL)
	{
		if ($file === NULL)
		{
			$errors = array();
			foreach($this->errors as $field => $error)
			{
				$errors[$field] = $error[0];
			}
			return $errors;
		}
		else
		{
			$errors = array();
			foreach ($this->errors as $input => $error)
			{
				// Key for this input error
				$key = "$file.$input.$error[0]";

				if (($errors[$input] = Kohana::lang($key, $error[1])) === $key)
				{
					// Get the default error message
					$errors[$input] = Kohana::lang("$file.$input.default");
				}
			}

			return $errors;
		}
	}

	public function validate($object = NULL, $field_name = NULL)
	{
		if ($object === NULL)
		{
			// Use the current object
			$object = $this;
		}

		// Get all field names
		$fields = $this->field_names();

		// Copy the array from the object, to optimize multiple sets
		$array = $this->getArrayCopy();

		foreach ($fields as $field)
		{
			if ($field === '*')
			{
				// Ignore wildcard
				continue;
			}

			if ( ! isset($array[$field]))
			{
				if (isset($this->array_fields[$field]))
				{
					// This field must be an array
					$array[$field] = array();
				}
				else
				{
					$array[$field] = NULL;
				}
			}
		}

		// Swap the array back into the object
		$this->exchangeArray($array);

		// Get all defined field names
		$fields = array_keys($array);

		foreach ($this->pre_filters as $field => $callbacks)
		{
			foreach ($callbacks as $callback)
			{
				if ($field === '*')
				{
					foreach ($fields as $f)
					{
						$this[$f] = is_array($this[$f]) ? array_map($callback, $this[$f]) : call_user_func($callback, $this[$f]);
					}
				}
				else
				{
					$this[$field] = is_array($this[$field]) ? array_map($callback, $this[$field]) : call_user_func($callback, $this[$field]);
				}
			}
		}

		if ($this->submitted === FALSE)
			return FALSE;

		foreach ($this->rules as $field => $callbacks)
		{
			foreach ($callbacks as $callback)
			{
				// Separate the callback and arguments
				list ($callback, $args) = $callback;

				// Function or method name of the rule
				$rule = is_array($callback) ? $callback[1] : $callback;

				if ($field === '*')
				{
					foreach ($fields as $f)
					{
						// Note that continue, instead of break, is used when
						// applying rules using a wildcard, so that all fields
						// will be validated.

						if (isset($this->errors[$f]))
						{
							// Prevent other rules from being evaluated if an error has occurred
							continue;
						}

						if (empty($this[$f]) AND ! in_array($rule, $this->empty_rules))
						{
							// This rule does not need to be processed on empty fields
							continue;
						}

						if ($args === NULL)
						{
							if ( ! call_user_func($callback, $this[$f]))
							{
								$this->errors[$f] = array($rule, NULL);

								// Stop validating this field when an error is found
								continue;
							}
						}
						else
						{
							if ( ! call_user_func($callback, $this[$f], $args))
							{
								$this->errors[$f] = array($rule, $args);

								// Stop validating this field when an error is found
								continue;
							}
						}
					}
				}
				else
				{
					if (isset($this->errors[$field]))
					{
						// Prevent other rules from being evaluated if an error has occurred
						break;
					}

					if ( ! in_array($rule, $this->empty_rules) AND ! $this->required($this[$field]))
					{
						// This rule does not need to be processed on empty fields
						continue;
					}

					if ($args === NULL)
					{
						if ( ! call_user_func($callback, $this[$field]))
						{
							$this->errors[$field] = array($rule, NULL);

							// Stop validating this field when an error is found
							break;
						}
					}
					else
					{
						if ( ! call_user_func($callback, $this[$field], $args))
						{
							$this->errors[$field] = array($rule, NULL);

							// Stop validating this field when an error is found
							break;
						}
					}
				}
			}
		}

		foreach ($this->callbacks as $field => $callbacks)
		{
			foreach ($callbacks as $callback)
			{
				if ($field === '*')
				{
					foreach ($fields as $f)
					{
						// Note that continue, instead of break, is used when
						// applying rules using a wildcard, so that all fields
						// will be validated.

						if (isset($this->errors[$f]))
						{
							// Stop validating this field when an error is found
							continue;
						}

						call_user_func($callback, $this, $f);
					}
				}
				else
				{
					if (isset($this->errors[$field]))
					{
						// Stop validating this field when an error is found
						break;
					}

					call_user_func($callback, $this, $field);
				}
			}
		}

		foreach ($this->post_filters as $field => $callbacks)
		{
			foreach ($callbacks as $callback)
			{
				if ($field === '*')
				{
					foreach ($fields as $f)
					{
						$this[$f] = is_array($this[$f]) ? array_map($callback, $this[$f]) : call_user_func($callback, $this[$f]);
					}
				}
				else
				{
					$this[$field] = is_array($this[$field]) ? array_map($callback, $this[$field]) : call_user_func($callback, $this[$field]);
				}
			}
		}

		// Return TRUE if there are no errors
		return $this->errors === array();
	}

}