<?php
namespace Shake\Application\UI;

use Nette;


/**
 * Application\UI\Presenter
 *
 * @package Shake
 * @author  Michal Mikoláš <nanuqcz@gmail.com>
 */
class Presenter extends Nette\Application\UI\Presenter
{

	protected function paginate($data, $service)
	{
		return $service->applyLimit(
			$data, 
			$this['paginator']->paginator->itemsPerPage, 
			$this['paginator']->paginator->offset
		);
	}



	public function &__get($name)
	{
		// Default behavior
		try {
			return parent::__get($name);

		// Automatic service getter from context
		} catch (\Nette\MemberAccessException $e) {
			// Repository
			if (strrpos($name, 'Repository') == (strlen($name) - 10)) {
				$repository = $this->context->getService($name);
				return $repository;
			}
			
			// Service
			if (strrpos($name, 'Service') == (strlen($name) - 7)) {
				$service = $this->context->getService($name);
				return $service;
			}

			throw $e;
		}
	}

}