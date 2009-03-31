<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Filesystem helper class.
 *
 * @author     Dave Stewart, with a lot of original functions by the Kohana or Code Igniter teams 
 */
 
class filesystem {

	/**
	 * Map
	 *
	 * Recusrively gets all files and folders in the directory, with an optional depth limit
	 *
	 * @param	string	the path to the folder
	 * @param	number	how many levels to process
	 * @return	array	The list of files and folders
	 */	
	 
	public static function map($path, $levels = NULL, $structured = FALSE, $files_first = FALSE)
	{
		// trim trailing slashes
			$levels		= is_null($levels) ? -1 : $levels;
			$path		= preg_replace('|/+$|', '', $path);
			
		// filesystem objects
			$files		= array();
			$folders	= array();
			$objects	= array_diff(scandir($path), array('.', '..'));
			
		// check through
			foreach($objects as $v)
			{
				$dir = $path . '/' .$v;
				if(is_dir($dir))
				{
					$folders[$v] = $levels != 0 ? filesystem::map($dir, $levels - 1, $structured, $files_first) : $v;
				}
				else
				{
					array_push($files, $v);
				}
			}
			
		// return
			if($structured)
			{
				return array('/folders' => $folders, '/files' => $files);
			}
			else
			{
				return $files_first ? array_merge($files, $folders) : array_merge($folders, $files);
			}
	}
	
	/**
	 * Get folders
	 *
	 * Returns all folders in the directory, excluding . and ..
	 *
	 * @param	string	path to the folder
	 * @param	string	Append the initial path to the return values
	 * @return	array	The list of folders
	 */	
	public static function get_folders($path, $appendPath = false)
	{
		// objects
			$folders	= array();
			$objects	= array_diff(scandir($path), array('.', '..'));
			
		// match
			foreach($objects as $object)
			{
				if(is_dir($path.$object))
				{
					array_push($folders, $appendPath ? $path.$object : $object);
				}
			}
			
		// return
			return $folders;
	}
	
	/**
	 * Get files
	 *
	 * Returns all files in the directory with an optional regexp OR file extension mask
	 *
	 * @param	string	path to the folder
	 * @param	string	Regular expression or file extension to limit the search to
	 * @param	string	Append the initial path to the return values
	 * @return	array	The list of files
	 */	
	 
	//print_r(filesystem::get_files('/', array('ico', 'xml')));
	//print_r(filesystem::get_files('/', '/(\.ico|\.xml)$/'));
	//print_r(filesystem::get_files('/'));

	public static function get_files($path, $mask = NULL, $appendPath = false)
	{
		// objects
			$files		= array();
			//$path		= preg_replace('%/+$%', '/', $path . '/'); // add trailing slash
			$objects	= array_diff(scandir($path), array('.', '..'));
			
		// mask
			if($mask != NULL)
			{
				// regular expression for detecing a regular expression
					$rxIsRegExp	= '/^([%|\/]|{).+(\1|})[imsxeADSUXJu]*$/';
				
				// an array of file extenstions
					if(is_array($mask))
					{
						$mask = '%\.(' .implode('|', $mask). ')$%i';
					}
					
				// if the supplied mask is NOT a regular expression...
				// assume it's a file extension and make it a regular expression
					else if(!preg_match($rxIsRegExp, $mask))
					{
						$mask = "/\.$mask$/i";
					}
			}

		
		// match
			foreach($objects as $object)
			{
				if(is_file($path.$object) && ($mask != NULL ? preg_match($mask, $object) : TRUE))
				{
					array_push($files, $appendPath ? $path.$object : $object);
				}
			}
			
		// return
			return $files;
	}
	
	/**
	 * Delete Files
	 *
	 * Deletes all files and optionally folders from the path specfied
	 *
	 * @param	string	path to file
	 * @param	bool	delete contained directories
	 * @param	bool	delete root directory (this is the same as a recursive delete_all - use with caution!)
	 * @return	void
	 */	
	public static function delete_files($path, $mask = NULL, $del_dir = FALSE, $del_root = FALSE, $level = 0)
	{	
		// Trim the trailing slash
			$path	= preg_replace('|/+$|', '', $path);

		// fail if a leading slash is encountered
			if($level == 0 && preg_match('%^[\\\\/]+%', $path))
			{
				trigger_error('filesystem::deletefiles - <span style="color:red">Absolute paths not allowed</span>', E_USER_WARNING);
				return;
			}

		// fail on directory error
			if ( ! $current_dir = @opendir($path))
			{
				return;
			}
		
		// file mask
			if($level == 0 && $mask != NULL)
			{
				// regular expression for detecing a regular expression
					$rxIsRegExp	= '/^([%|\/]|{).+(\1|})[imsxeADSUXJu]*$/';
				
				// an array of file extenstions
					if(is_array($mask))
					{
						$mask = '%\.(' .implode('|', $mask). ')$%';
					}
					
				// if the supplied mask is NOT a regular expression...
				// assume it's a file extension and make it a regular expression
					else if(!preg_match($rxIsRegExp, $mask))
					{
						$mask = "/\.$mask$/";
					}
			}
		
		// loop through files
			while(FALSE !== ($filename = @readdir($current_dir)))
			{
				if ($filename != "." and $filename != "..")
				{
					if (is_dir($path.'/'.$filename))
					{
						filesystem::delete_files($path.'/'.$filename, $mask, $del_dir, $del_root, $level + 1);
					}
					else
					{
						if($mask == NULL || preg_match($mask, $filename))
						{
							unlink($path.'/'.$filename);
						}
					}
				}
			}
			@closedir($current_dir);
		
		// remove folders
			if ($del_dir && $level > 0)
			{
				@rmdir($path);
			}
			if($del_root && $level == 0)
			{
				@rmdir($path);
			}
		
	}
	
	/**
	 * Read File
	 *
	 * Opens the file specfied in the path and returns its contents as a string.
	 *
	 * @access	public
	 * @param	string	path to file
	 * @return	string
	 */	
	public static function read_file($file)
	{
		if ( ! file_exists($file))
		{
			return FALSE;
		}
	
		if (function_exists('file_get_contents'))
		{
			return file_get_contents($file);		
		}

		if ( ! $fp = @fopen($file, FOPEN_READ))
		{
			return FALSE;
		}
		
		flock($fp, LOCK_SH);
	
		$data = '';
		if (filesize($file) > 0)
		{
			$data =& fread($fp, filesize($file));
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		return $data;
	}
	
	
	
	/**
	* Write File
	*
	* Writes data to the file specified in the path.
	* Creates a new file if non-existent.
	*
	* @access	public
	* @param	string	path to file
	* @param	string	file data
	* @return	bool
	*/

	public static function write_file($path, $data, $append = FALSE)
	{
		$mode = $append ? 'a' : 'w';
		if ( ! $fp = fopen($path, $mode))
		{
			return FALSE;
		}
		
		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);	

		return TRUE;
	}


	/**
	 * Recursively creates new folders from the specified path or paths
	 *
	 * @param   mixed   a single path or an array of paths
	 * @param   number  initial permissions for 
	 * @return  mixed   the cleaned path or array of paths
	 */
	public static function make_path($path, $permissions = 0755)
	{
		if(is_array($path))
		{
			foreach($path as $p)
			{
				$arr = array();
				array_push($arr, filesystem::make_path($p, $permissions));
			}
			return $arr;
		}
		else
		{
			$path		= preg_replace('%/+%', '/', $path);		// remove double slashes
			$path		= preg_replace('%/$%', '', $path);		// remove trailing slash
			$folders	= preg_split('%(?!^)/%', $path);		// split into path segments, preserving any initial leading slash
	
			$path		= '';
			foreach($folders as $folder){
				$path .= $folder . '/';
				if(!file_exists($path)){
					mkdir ($path, $permissions);
					}
				}
			return dir($path);
		}
	}		
	
	/**
	 * Download a file to the user's browser. This function is
	 * binary-safe and will work with any MIME type that Kohana is aware of.
	 *
	 * @param   string  a file path or file name, or data
	 * @param   string  suggested filename to display in the download
	 * @return  void
	 */
	public static function download($filedata, $filename = NULL)
	{
		// file
		
			if (is_file($filedata))
			{
				$filepath	= str_replace('\\', '/', realpath($filedata));
				$filesize	= filesize($filepath);
				$filename	= substr(strrchr('/'.$filepath, '/'), 1);	// Make sure the filename does not have directory info
				$extension	= strtolower(substr(strrchr($filepath, '.'), 1));
			}
			else
			{
				$filesize	= strlen($filedata);
				$extension	= strtolower(substr(strrchr($filename, '.'), 1));
			}
	
		// Mimetype
		
			$mimes	= Kohana::config('mimes.'.$extension);
			$mime	= $mimes[0];
			if (empty($mime))
			{
				$mime = array('application/octet-stream');
			}

		// headers
		
			// Generate the server headers
				header('Content-Type: '.$mime[0]);
				header('Content-Disposition: attachment; filename="'.(empty($nicename) ? $filename : $nicename).'"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: '.sprintf('%d', $filesize));
	
			// More caching prevention
				header('Expires: 0');
		
				if (Kohana::user_agent('browser') === 'Internet Explorer')
				{
					// Send IE headers
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
				}
				else
				{
					// Send normal headers
					header('Pragma: no-cache');
				}
	
		// output

			if (isset($filepath))
			{
				$handle = fopen($filepath, 'rb');
				fpassthru($handle);
				fclose($handle);
			}
			else
			{
				echo $filedata;
			}
	}

} // End file


?>