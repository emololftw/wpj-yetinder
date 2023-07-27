<?php

declare(strict_types=1);

namespace App\Model\UI\Forms;

use App\Model\UI\FormFactory;
use Nette\Forms\Form;

readonly class CustomisationForm
{
	public function __construct(
		private FormFactory $formFactory
	) {
	}

	public function create(): Form
	{
		$form = $this->formFactory->create();

		$form->addSelect(
			'preferredGender',
			'Preferované pohlaví',
			[
				0 => 'Ženy',
				1 => 'Muži',
			]
		)
		->setRequired();

		$form->addInteger('dice', 'Hodtě si kostkou!')
			->setHtmlAttribute('x-model', 'diceValue')
			->addRule(Form::Range, 'Číslo musí být v rozsahu %d - %d', [1, 6])
			->setRequired();

		$form->addButton('roll', 'Hod!')
			->setOmitted()
			->setHtmlAttribute('x-on:click', 'rollTheDice')
			->setHtmlAttribute('class', 'absolute -mt-16 -right-[5%] !bg-blue-500 mb-10 !w-14 !h-14 !rounded-full hover:scale-110');

		$form->addSubmit('submit', 'Jít se seznamovat!')
			->setHtmlAttribute('class', 'mt-10');

		return $form;
	}
}
