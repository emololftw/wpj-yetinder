<?php

declare(strict_types=1);

namespace App\Model\Services;

use App\Model\UI\Formatter;
use Generator;
use Noxem\DateTime\DT;

/**
 * Analysis model preparing data for Frontend charts
 *
 * @author Jaroslav Klíma <twitter@emololftw>
 */
class AnalysisDataService
{
	private int $quantityOfDays = 10;

	/**
	 * @param DatabaseService $databaseService
	 */
	public function __construct(
		private readonly DatabaseService $databaseService
	) {
	}

	public function setQuantityOfDays(int $days): self
	{
		$this->quantityOfDays = $days;
		return $this;
	}

	public function buildRegistrationDataStack(int $gender = null): array
	{
		$db = $this->databaseService;

		$retArr = [];
		foreach ($this->createDays() as $day) {
			$retArr[] = $db->aggregateRegistrationsByDate($day, $gender);
		}
		return $retArr;
	}

	public function buildRatingsDataStack(string $key = null): array
	{
		$db = $this->databaseService;

		$retArr = [];
		foreach ($this->createDays() as $day) {
			$item = $db->aggregateRatingsByDate($day);
			$retArr[] = $key ? $item[$key] : $item;
		}

		return $retArr;
	}

	public function createDays(): Generator
	{
		$now = DT::now()->modifyDays(-$this->quantityOfDays + 1)->setTime(0, 0);
		foreach (range(0, $this->quantityOfDays - 1) as $dayNumber) {
			yield $now->modifyDays(+$dayNumber);
		}
	}

	public function toDates(): string
	{
		$str = '';

		/** @var DT $dt */
		foreach ($this->createDays() as $dt) {
			$str .= "'" . $dt->format(Formatter::CzechDateFormat) . "',";
		}

		return substr($str, 0, -1);
	}
}
