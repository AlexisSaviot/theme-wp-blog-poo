<?php
if (!defined('ABSPATH')) exit;

/**
 * Get the data from SliderModel to make them usable for the view
 * 
 * METHODS :
 * - getSlider($id) return a slider object by is ID
 */
class SliderController extends Controller
{
	public function __construct()
	{
		parent::__construct('slider', 'SliderModel');
	}

	public function getSlider(int $id): SliderModel
	{
		return $this->get($id);
	}
}
