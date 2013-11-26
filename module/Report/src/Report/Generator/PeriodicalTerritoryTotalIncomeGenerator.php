<?php
namespace Report\Generator;

use Zend\Stdlib\InitializableInterface as Initializable;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Report\Contract\AbstractGenerator;
use Report\Contract\Parameter;
use Report\Strategy\Chart as ChartStrategy;
use Report\Strategy\Tabular as TabularStrategy;
use Report\Contract\CallbackDataSerializer;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Kelas yang menggenerate data laporan total penerimaan tahunan masing-masing daerah.
 * 
 * @author zakyalvan
 */
class PeriodicalTerritoryTotalIncomeGenerator extends AbstractGenerator implements Initializable {
	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\InitializableInterface::init()
	 */
	public function init() {
		$this->dataClass = 'Report\Generator\Data\PeriodicalTerritoryTotalIncome';
		$chartStrategy = new ChartStrategy();
		$chartStrategy->setDataSerializer(new CallbackDataSerializer(function(ArrayCollection $datas) {
			
		}));
		$this->strategies['chart'] = $chartStrategy;
		
		$tabularStrategy = new TabularStrategy();
		$tabularStrategy->setDataSerializer(new CallbackDataSerializer(function(ArrayCollection $datas) {
			
		}));
		$this->strategies['tabular'] = $tabularStrategy;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Report\Contract\AbstractGenerator::checkCanGenerate()
	 */
	protected function checkCanGenerate(Parameter $parameter) {
		if($parameter->getAnnualPeriods()->count() > 0 && $parameter->getTerritories()->count() > 0 && $parameter->getSources()->count() > 0) {
			return true;
		}
		return false;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Report\Contract\AbstractGenerator::buildDataQuery()
	 */
	protected function buildDataQuery(Parameter $parameter, EntityManager $entityManager) {
		/* @var $queryBuilder QueryBuilder */ 
		$queryBuilder = $entityManager->createQueryBuilder();
		$queryBuilder->select('')
			->from('Application\Entity\Territory', 'territory')
			->leftJoin('Income\Entity\Income', 'income', Join::WITH, $queryBuilder->expr()->eq('income.territory.id', 'territory.id'))
			->innerJoin('income.annualPeriod', 'annualPeriod')
			->where($queryBuilder->expr()->andX(
				
			))
			->setParameter('', '');
			
		return $queryBuilder;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Report\Contract\AbstractGenerator::createDataObject()
	 */
	protected function createDataObject($object) {
		return $object;
	}
}