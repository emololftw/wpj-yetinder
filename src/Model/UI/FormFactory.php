<?php

declare(strict_types=1);

namespace App\Model\UI;

use Nette\Forms\Form;

class FormFactory
{
	private int $layout = 0;

	/**
	 * Create Form instance with pre-rendered rules
	 *
	 * @return Form
	 */
	public function create(): Form
	{
		$form = new Form;

		$form->addProtection();
		$form->onRender[] = 'App\\Model\\UI\\FormFactory::prepareTailwindComponents';

		$form->onRender[] = match($this->layout) {
			1 => 'App\\Model\\UI\\FormFactory::inlineLayout',
			default => 'App\\Model\\UI\\FormFactory::prepareLayout'
		};

		return $form;
	}

	/**
	 * Setter for layout
	 *
	 * @return $this
	 */
	public function setInlineLayout(): self
	{
		$clone = clone $this;
		$clone->layout = 1;
		return $clone;
	}

	/**
	 * @param Form $form
	 * @return void
	 */
	public static function prepareLayout(Form $form): void
	{
		$renderer = $form->getRenderer();
		$renderer->wrappers['form']['container'] = 'div class="relative"';
		$renderer->wrappers['pair']['container'] = 'div class=""';
		$renderer->wrappers['controls']['container'] = "div class='w-full flex flex-col gap-y-4'";
		$renderer->wrappers['control']['errorcontainer'] = "span class='text-rose-600 font-medium'";
		$renderer->wrappers['error']['container'] = "span class='error-container text-rose-700 bg-rose-100'";
	}

	/**
	 * @param Form $form
	 * @return void
	 */
	public static function inlineLayout(Form $form): void
	{
		$renderer = $form->getRenderer();
		self::prepareLayout($form);
		$renderer->wrappers['controls']['container'] = "div class='w-full flex gap-x-4 items-end'";
	}

	/**
	 * Apply tailwind.css rules to default HTML elements
	 *
	 * @param Form $form
	 * @return void
	 */
	public static function prepareTailwindComponents(Form $form): void
	{
		foreach ($form->getControls() as $control) {
			$type = (string) $control->getOption('type');

			if ($type === 'button') {
				$control->getControlPrototype()->addClass('btn bg-midnight text-white w-full');
			} elseif ($type === 'select') {
				$control->getControlPrototype()->addClass('form-control form-select');
			} elseif ($type === 'color') {
				$control->getControlPrototype()->addClass('form-control form-control-color');
			} elseif ($type === 'file') {
				$control->getControlPrototype()->addClass('form-control-file');
			} elseif (in_array($type, ['checkbox', 'radio'], true)) {
				$control->getLabelPrototype()->addClass('form-check-label');
				$control->getControlPrototype()->addClass('form-check-input me-2');
			} else {
				$control->getControlPrototype()->addClass('form-control');
			}

			if ($form->isSubmitted()) {
				$control->getControlPrototype()->addClass($control->getErrors() ? 'is-invalid' : null);
			}

			$control->getLabelPrototype()->addClass('form-label font-semibold');

			if ($control->isRequired()) {
				$control->getLabelPrototype()->addClass('required');
			}
		}
	}
}
