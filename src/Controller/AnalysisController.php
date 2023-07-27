<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Services\AnalysisDataService;
use App\Model\UI\Forms\AnalysisDaysForm;
use App\Model\UI\LatteFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnalysisController extends FrontAbstractController
{
	#[Route('/analysis/{days<\d+>}')]
	public function index(
		LatteFactory $latteFactory,
		AnalysisDataService $analysisDataService,
		AnalysisDaysForm $analysisDaysForm,
		int $days = 10
	): Response {
		if($days < 1 || $days > 31) {
			throw $this->createNotFoundException();
		}

		$daysForm = $analysisDaysForm->create();
		if($daysForm->isSuccess()) {
			return $this->redirectToRoute('app_analysis_index', ['days' => $daysForm->getValues()->quantityOfDays]);
		}

		$daysForm->setDefaults(['quantityOfDays' => $days]);
		return $latteFactory->create(__DIR__ . '/@templates/Analysis.latte', [
			'analysisData' => $analysisDataService->setQuantityOfDays($days),
			'daysForm' => $daysForm,
		]);
	}
}
