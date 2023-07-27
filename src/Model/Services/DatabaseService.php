<?php

declare(strict_types=1);

namespace App\Model\Services;

use App\Model\SQLTableNames;
use App\Model\UI\Formatter;
use DateTimeInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class for Doctrine DBAL querying (without ORM)
 *
 * @author Jaroslav Klíma <twitter@emololftw>
 */
readonly class DatabaseService
{
	public function __construct(
		private ManagerRegistry $managerRegistry,
		private SessionQueryService $sessionQueryService,
		private RequestStack $requestStack,
	) {
	}

	/**
	 * Getter for native Doctrine DBAL Query Builder
	 *
	 * @return QueryBuilder
	 */
	public function get(): QueryBuilder
	{
		return $this->getConnection()->createQueryBuilder();
	}

	/**
	 * Getter for default Connection
	 *
	 * @return Connection|object
	 */
	public function getConnection(): Connection
	{
		return $this->managerRegistry->getConnection('default');
	}

	public function findAll(): array
	{
		return $this->get()
			->select('*')
			->from(SQLTableNames::MainTableName)
			->executeQuery()
			->fetchAssociative();
	}

	public function findById(int $id): ?array
	{
		$fetch = $this->get()
			->select('*')
			->from(SQLTableNames::MainTableName)
			->where('id = ?')
				->setParameter(0, $id)
			->executeQuery()
			->fetchAssociative();

		return $fetch === false ? null : $fetch;
	}

	public function findLast10(): array
	{
		return $this->get()
			->select('*')
			->from(SQLTableNames::MainTableName)
			->orderBy('rate', 'DESC')
			->addOrderBy('weight', 'ASC') // The rating is made up of two components, one is the weight and the other is the user rating
			->setMaxResults(10)
			->executeQuery()
			->fetchAllAssociative();
	}

	public function addYetiLog(int $entityYetiId, bool $isPositive): void
	{
		$this->get()
			->insert(SQLTableNames::RatingTableName)
			->setValue('yeti_id', '?')
			->setValue('address', '?')
			->setValue('rated_at', '?')
			->setValue('is_positive', '?')
				->setParameter(0, $entityYetiId)
				->setParameter(1, $this->requestStack->getCurrentRequest()->getClientIp())
				->setParameter(2, Formatter::toDbDate())
				->setParameter(3, (int) $isPositive)
			->executeQuery();
	}

	/**
	 * @param DateTimeInterface $dateTime
	 * @return array
	 */
	public function aggregateRatingsByDate(DateTimeInterface $dateTime): array
	{
		$qB = $this->get();
		$qB->select('COUNT(*) as totalRatings, AVG(is_positive) as averageRating')
			->from(SQLTableNames::RatingTableName)
			->andWhere('rated_at = ?')
			->setParameter(1, $dateTime->format(Formatter::HtmlDate));

		return $qB->executeQuery()->fetchAssociative();
	}

	public function aggregateRegistrationsByDate(DateTimeInterface $dateTime, int $gender = null): int
	{
		// Using prepared statements :)
		$qB = $this->get();
		$qB->select('COUNT(*) as totalRegistrations')
			->from(SQLTableNames::MainTableName)
				->where('created_at = :createdAt')
			->setParameter('createdAt', $dateTime->format(Formatter::HtmlDate));

		if($gender !== null) {
			$qB->andWhere('gender = :preferredGender')
				->setParameter('preferredGender', $gender);
		}

		return $qB->executeQuery()->fetchAssociative()['totalRegistrations'];
	}

	public function rateYeti(int $id, bool $isPositive): bool
	{
		$exp = $this->get()
			->update(SQLTableNames::MainTableName)
			->where('id = ?')
				->setParameter(0, $id)
			->set('rate', 'rate ' . ($isPositive ? '+' : '-') . ' 1')
			->executeQuery();

		$this->addYetiLog($id, $isPositive);

		return $exp->rowCount() === 1;
	}

	public function findListOfYetis(int $preferredGender, int $dice): ?array
	{
		$fetchPartOfData = function (bool $preferred) use ($preferredGender, $dice) {
			$exp = 'roll_dice ' . ($preferred ? '=' : '!=') . ' ?';

			return array_map(
				fn (array $v) => $v['id'],
				$this->get()
					->select('*')
					->from(SQLTableNames::MainTableName)
					->where($exp)
						->setParameter(0, $dice)
					->andWhere('gender = ?')
					->setParameter(1, $preferredGender)
					->orderBy('roll_dice', 'DESC')
					->setMaxResults(100)
					->executeQuery()
					->fetchAllAssociative()
			);
		};

		$this->sessionQueryService->setQuery($fetchPartOfData(true), $fetchPartOfData(false));
		return $this->sessionQueryService->getQuery();
	}
}
