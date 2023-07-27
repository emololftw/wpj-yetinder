<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Services\DatabaseService;
use App\Model\UI\LatteFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends FrontAbstractController
{
	#[Route('/')]
	public function list(LatteFactory $latteFactory, DatabaseService $databaseService): Response
	{
		return $latteFactory->create(__DIR__ . '/@templates/Home.latte', [
			'yetis' => $databaseService->findLast10(),
			'addYetiLink' => $this->generateUrl('app_membership_add'),
			'swipeLink' => $this->generateUrl('app_swipe_list'),
            'analysisLink' => $this->generateUrl('app_analysis_index'),
		]);
	}
}
