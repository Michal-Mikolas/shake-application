<?php
namespace Shake\Application\UI;

use Shake\Utils\Strings,
	Shake\VisualPaginator;
use Nette;


/**
 * Application\UI\Presenter
 *
 * @author  Michal Mikoláš <nanuqcz@gmail.com>
 */
class Presenter extends Nette\Application\UI\Presenter
{

	protected function paginate($data, $service)
	{
		return $service->applyLimit(
			$data,
			$this['paginator']->getPaginator()->itemsPerPage,
			$this['paginator']->getPaginator()->offset
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
				$repository = $this->context->$name;
				return $repository;
			}

			// Service
			if (strrpos($name, 'Service') == (strlen($name) - 7)) {
				$service = $this->context->$name;
				return $service;
			}

			throw $e;
		}
	}

}
