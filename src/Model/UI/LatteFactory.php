<?php

declare(strict_types=1);

namespace App\Model\UI;

use Latte\Engine;
use Symfony\Component\HttpFoundation\Response;

/**
 * Templating system / replacing Twig templates
 *
 * @author Jaroslav Klíma <twitter@emololftw>
 */
readonly class LatteFactory
{
	/**
	 * @param string $projectDir The project root directory (./) passed from .yml file
	 */
	public function __construct(
		private string $projectDir
	) {
	}

	/**
	 * Creating Nette's native templating system, which is used in whole application
	 *
	 * @param string $file Absolute path to template
	 * @param array $params Variables accessible in the template ecosystem
	 * @return Response
	 */
	public function create(string $file, array $params = []): Response
	{
		$latte = new Engine();
		$latte->setTempDirectory($this->projectDir . '/var/cache/latte');
		$latteString = $latte->renderToString($file, $params);
		return new Response($latteString); // Need pass string template, original response throws session_start() issue
	}
}
