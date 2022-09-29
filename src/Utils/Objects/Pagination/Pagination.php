<?php

namespace App\Utils\Objects\Pagination;

use JMS\Serializer\Annotation\Type;

class Pagination
{
	/**
	 * @Type("int")
	 * @var int
	 */
	protected $page;

	/**
	 * @Type("int")
	 * @var int
	 */
	protected $pageElements;

	/**
	 * @Type("int")
	 * @var int
	 */
	protected $totalPage;

	/**
	 * @Type("int")
	 * @var int
	 */
	protected $totalElements;

	/**
	 * @return int
	 */
	public function getPage(): int
	{
		return $this->page;
	}

	/**
	 * @param int $page
	 * @return Pagination
	 */
	public function setPage(int $page): Pagination
	{
		$this->page = $page;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPageElements(): int
	{
		return $this->pageElements;
	}

	/**
	 * @param int $pageElements
	 * @return Pagination
	 */
	public function setPageElements(int $pageElements): Pagination
	{
		$this->pageElements = $pageElements;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getTotalPage(): int
	{
		return $this->totalPage;
	}

	/**
	 * @param int $totalPage
	 * @return Pagination
	 */
	public function setTotalPage(int $totalPage): Pagination
	{
		$this->totalPage = $totalPage;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getTotalElements(): int
	{
		return $this->totalElements;
	}

	/**
	 * @param int $totalElements
	 * @return Pagination
	 */
	public function setTotalElements(int $totalElements): Pagination
	{
		$this->totalElements = $totalElements;
		return $this;
	}

}