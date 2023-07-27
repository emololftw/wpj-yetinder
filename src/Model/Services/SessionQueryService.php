<?php

declare(strict_types=1);

namespace App\Model\Services;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Service for querying Yetis with native sessions
 *
 * @author Jaroslav Klíma <twitter@emololftw>
 */
readonly class SessionQueryService
{
	private const KeyId = 'yetinder.query';

	public function __construct(
		private RequestStack $requestStack,
	) {
	}

	public function get(): SessionInterface
	{
		return $this->requestStack->getSession();
	}

	public function setQuery(array $priority, array $secondary): void
	{
		$flipAndReset = function (array $arr) {
			$flip = array_flip($arr);
			$newArray = [];
			foreach ($flip as $k => $unused) {
				$newArray[$k] = false;
			}

			return $newArray;
		};
		$session = $this->get();
		$session->remove(self::KeyId);
		$e = ['priority' => $flipAndReset($priority), 'secondary' => $flipAndReset($secondary)];
		$session->set(self::KeyId, $e);
	}

	public function getQuery(): ?array
	{
		$session = $this->get()->get(self::KeyId);
		$priority = true;
		foreach($session as $key => $value) {
			if($key !== 'priority') {
				$priority = false;
			}

			if(empty($value)) {
				continue;
			}
			foreach ($value as $k => $v) {
				if($v === false) {
					$session[$key][$k] = true;
					$this->get()->set(self::KeyId, $session);
					return [$k, $priority];
				}
			}

		}

		return null;
	}
}
