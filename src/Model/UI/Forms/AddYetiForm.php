<?php

declare(strict_types=1);

namespace App\Model\UI\Forms;

use App\Model\Services\DatabaseService;
use App\Model\SQLTableNames;
use App\Model\UI\Formatter;
use App\Model\UI\FormFactory;
use Nette\Forms\Form;

class AddYetiForm
{
	public function __construct(
		private readonly FormFactory $formFactory,
		private readonly DatabaseService $databaseService
	) {
	}

	public function create(): Form
	{
		$form = $this->formFactory->create();

		$form->addText('nickname', 'Jméno, pořádně mrazivé.')
			->addRule(Form::MAX_LENGTH, 'Maximální počet znaků je %d', 50)
			->addRule(Form::MIN_LENGTH, 'Tohle je pořádné jméno? Zadejte alespoň %d znaků', 5)
			->setRequired();

		$form->addInteger('height', 'Výška (nezapomeňte, Yeti fakt nemá 180 cm)')
			->addRule(Form::MIN, 'Tohle není Yeti, ale člověk, minimální výška Yetiho je: %d', 200)
			->addRule(Form::MAX, 'Tohle není Yeti, ale Empire State Building, maximální výška Yetiho je: %d', 400)
			->setRequired();

		$form->addInteger('weight', 'Váha')
			->addRule(Form::MIN, 'Tohle není Yeti, ale člověk, minimální váha Yetiho je: %d', 99)
			->addRule(Form::MAX, 'Tohle není Yeti, ale titanic, maximální váha Yetiho je: %d', 3000)
			->setRequired();

		$form->addText('address', 'Bydliště')
			->addRule(Form::MinLength, 'Adresa musí být minimálně %d dlouhá', 5)
			->addRule(Form::MaxLength, 'Maximální počet znaků je %d', 255)
			->setRequired();

		$form->addSelect('gender', 'Pohlaví', [
			0 => 'Žena',
			1 => 'Muž',
		])
			->setPrompt('Vyberte prosím pohlaví')
			->setRequired();

		$form->addInteger('rate', 'Hodnocení (zvýhodníme někoho?!)')
			->setDefaultValue(0)
			->setRequired();

		$form->addText('born_at', 'Datum narození')
			->setDefaultValue(Formatter::toDbDate())
			->setHtmlAttribute('type', 'date')
			->setRequired();

		$form->addSubmit('submit', 'Přidat!');

		if($form->isSuccess()) {
			$this->processForm($form);
		}

		return $form;
	}

	public function processForm(Form $form): void
	{
		$arrayOfValues = [
			'nickname',
			'height',
			'weight',
			'address',
			'gender',
			'rate',
			'born_at',
		];

		$v = $form->getValues();
		if($this->databaseService->get()
			->select('*')
			->from(SQLTableNames::MainTableName)
			->where('nickname = ?')
				->setParameter(0, $v->nickname)
			->executeQuery()
			->rowCount() > 0
		) {
			$form->addError('Toto jméno již někdo používá, vyberte prosím jiné.');
		}

		$qB = $this->databaseService->get()
			->insert(SQLTableNames::MainTableName);

		foreach ($arrayOfValues as $i => $column) {
			$qB->setValue($column, '?');
			$qB->setParameter($i, $v->{$column});
		}

		$qB->setValue('roll_dice', '?')
			->setValue('created_at', '?')
			->setParameter($i+1, random_int(1, 6))
			->setParameter($i+2, Formatter::toDbDate());

		$qB->executeQuery();
	}
}
