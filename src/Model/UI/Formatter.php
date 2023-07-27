<?php

declare(strict_types=1);

namespace App\Model\UI;

/**
 * Standardizing date format for whole application
 *
 * @author Jaroslav Klíma <twitter@emololftw>
 */
readonly class Formatter
{
	public const CzechDateFormat = 'd. m. Y';

	public const HtmlDate = 'Y-m-d';

	public static function toDbDate(): string
	{
		return (new \DateTimeImmutable())->format(self::HtmlDate);
	}
}
