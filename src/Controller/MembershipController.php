<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\UI\Forms\AddYetiForm;
use App\Model\UI\LatteFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembershipController extends FrontAbstractController
{
	#[Route('/add')]
	public function add(LatteFactory $latteFactory, AddYetiForm $addYetiForm): Response
	{
		$form = $addYetiForm->create();
		$success = $form->isSuccess();
		if($form->isSuccess()) {
			$form->reset();
		}

		return $latteFactory->create(__DIR__ . '/@templates/Add.latte', [
			'form' => $form,
			'isFormSuccess' => $success,
		]);
	}
}
