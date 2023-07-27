<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Services\DatabaseService;
use App\Model\Services\SessionQueryService;
use App\Model\UI\Forms\CustomisationForm;
use App\Model\UI\LatteFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SwipeController extends FrontAbstractController
{
	#[Route('/swipe/{id<\d+>?}/{priority<0|1>?}')]
	public function list(LatteFactory $latteFactory, DatabaseService $databaseService, ?int $id, ?int $priority): Response|NotFoundHttpException
	{
		if($id === null) {
			return $this->redirect('swipe/select');
		}

		return $latteFactory->create(__DIR__ . '/@templates/Swipe.latte', [
			'id' => $id,
			'priority' => (bool) $priority,
			'linkForPros' => $this->generateUrl('app_swipe_rate', ['id' => $id, 'positive' => 1]),
			'linkForCons' => $this->generateUrl('app_swipe_rate', ['id' => $id, 'positive' => 0]),
			'result' => $databaseService->findById($id) ?? throw $this->createNotFoundException(),
		]);
	}

	#[Route('/swipe/select')]
	public function select(
		LatteFactory $latteFactory,
		CustomisationForm $customisationForm,
		DatabaseService $databaseService
	): Response {
		$form = $customisationForm->create();
		if($form->isSuccess()) {
			$values = $form->getValues();
			$v = $databaseService->findListOfYetis(...$values);
			if(is_array($v)) {
				return $this->redirectToRoute('app_swipe_list', ['id' => $v[0], 'priority' => (int) $v[1]]);
			}
		}
		return $latteFactory->create(__DIR__ . '/@templates/Swipe.select.latte', [
			'customisationForm' => $form,
		]);
	}

	#[Route('/swipe/rate/{id<\d+>}/{positive<0|1>}')]
	public function rate(
		int $id,
		int $positive,
		DatabaseService $databaseService,
		SessionQueryService $sessionQueryService,
	): Response {
		$db = $databaseService->rateYeti($id, (bool) $positive);

		$session = $sessionQueryService->getQuery();

		if($session === null || !$db) {
			return $this->redirectToRoute('app_swipe_nothing');
		}

		return $this->redirectToRoute('app_swipe_list', ['id' => $session[0], 'priority' => (int) $session[1]]);
	}

	#[Route('/swipe/nothing')]
	public function nothing(LatteFactory $latteFactory): Response
	{
		return $latteFactory->create(__DIR__ . '/@templates/Swipe.nothing.latte');
	}
}
