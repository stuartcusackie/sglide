<?php

namespace stuartcusackie\sglide;
use Storage;

class sglide {

	function __construct() {

		if(!file_exists(base_path('config/sglide.php'))) {
			throw new \Exception('SGlide config file missing. Please publish it.');
		}

		if(empty(config('sglide.default_disk'))) {
			throw new \Exception('Invalid SGlide config file. Please republish it.');
		}

	}

	/**
	 * Handle statamic fields and simple string paths
	 * and pass them to the appropriate glide function.
	 * 
	 * @param $style string
	 * @return array
	 */
	public function fromMixed($src, array $params, string $disk = null) {

		if(gettype($src) == 'object' && get_class($src) == 'Statamic\Fields\Value') {
			$src = $src->jsonSerialize();
		}

		if(gettype($src) == 'object' && get_class($src) == 'Statamic\Assets\Asset') {
			$src = $src->toArray();
		}

		if(is_string($src)) {
			return $this->fromPath($src, $disk, $params);
		}
		else if(is_array($src)) {
			return $this->generate($src['id'], $params);
		}
	   
		return $this->fallback($params);
	}

	/**
	 * Generate glide image data from a path string.
	 * Falls back to placeholder if file not available
	 * on disk.
	 * 
	 * @param $path string
	 * @param $params array
	 * @param $disk string
	 * @return object
	 */
	private function fromPath(string $path, string $disk = null, array $params = [])
	{
		if(is_null($disk)) {
			$disk = config('sglide.default_disk');
		}

		if(!Storage::disk($disk)->exists($path)) {
			 return $this->fallback($params);
		}

		return $this->generate(Storage::disk($disk)->url($path), $params);
	}

	/**
	 * Return glide data for an image at path.
	 * Modified from Edalzell\Blade\Directives\Glide
	 * 
	 * @param $field mixed
	 * @param $params array
	 * @return object
	 */
	private function generate(string $path, array $params = []) {

		// Default to webp unless specific
		if(!array_key_exists('fm', $params)) {
			$params['fm'] = 'webp';
		}

		$data = (new \Statamic\Tags\Glide)
			->setParser(\Statamic\Facades\Antlers::parser())
			->setContext([])
			->setParameters($params)
			->generate($path);

		return (object)$data[0];

	}

	/**
	 * Return glide data for a placeholder 
	 * image.
	 * 
	 * @param $params array
	 * @return object
	 */
	private function fallback($params = []) {

		return $this->generate('/vendor/sglide/images/no-image.jpg', $params);

	}

}