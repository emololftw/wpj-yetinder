<?php

declare(strict_types=1);

namespace App\Model\UI\Forms;

use App\Model\UI\FormFactory;
use Nette\Forms\Form;

readonly class AnalysisDaysForm
{
	public function __construct(
		private FormFactory $formFactory
	) {
	}

	public function create(): Form
	{
		$form = $this->formFactory
			->setInlineLayout()
			->create();

		$form->addInteger('quantityOfDays', 'Počet dní zpět')
			->addRule(Form::Min, 'Minimální číslo je %d', 1)
			->addRule(Form::Max, 'Maximální číslo je %d', 31)
			->setRequired();

		$form->addSubmit('submit', 'Filtrovat');

		return $form;
	}
}
