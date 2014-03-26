<?php
namespace gerh\Evecorp\Test\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Henning Gerhardt
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EveitemRepositoryTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $mockObjectManager;

	/**
	 * @var \gerh\Evecorp\Domain\Repository\EveitemRepository
	 */
	protected $fixture;

	public function setUp() {
		$this->mockObjectManager = $this->getMock('TYPO3\CMS\Extbase\Object\ObjectManagerInterface');
		/** @var $fixture \gerh\Evecorp\Domain\Repository\EveitemRepository|\PHPUnit_Framework_MockObject_MockObject */
		$this->fixture = $this->getMock('gerh\Evecorp\Domain\Repository\EveitemRepository', array(), array($this->mockObjectManager));
	}

	/**
	 * @test
	 */
	public function getCorrectUpdateableItems() {
		$this->markTestIncomplete('Not yet full implemented.');

		$timeToCache = 1;
		$currentTime = \time();
		$oldTime = $currentTime - ($timeToCache * 60);

		$mockModelOne = $this->getMock('gerh\Evecorp\Domain\Model\Eveitem');
		$mockModelOne->setEveName('Tritanium');
		$mockModelOne->setEveId(34);
		$mockModelOne
			->expects(($this->once()))
			->method('getCacheTime')
			->will($this->returnValue($currentTime));

		$mockModelTwo = $this->getMock('gerh\Evecorp\Domain\Model\Eveitem');
		$mockModelTwo->setEveName('Pyrite');
		$mockModelTwo->setEveId(35);
		$mockModelTwo
			->expects(($this->once()))
			->method('getCacheTime')
			->will($this->returnValue($oldTime));

		$this->fixture->add(mockModelOne);
		$this->fixture->add(mockModelTwo);

		$actual = $this->fixture->findAllUpdateableItems($timeToCache);
		$this->assertSame($mockModelTwo, $actual);		
	}
}
