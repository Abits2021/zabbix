<?php
/*
** Zabbix
** Copyright (C) 2000-2012 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


class CCollectionValidator extends CValidator {

	/**
	 * If set to false, the array cannot be empty.
	 *
	 * @var bool
	 */
	public $empty = false;

	/**
	 * Name of a field that must have unique values in the whole collection.
	 *
	 * @var string
	 */
	public $uniqueField;

	/**
	 * Error message if the string is empty.
	 *
	 * @var string
	 */
	public $messageEmpty;

	/**
	 * Error message if duplicate objects exist.
	 *
	 * @var string
	 */
	public $messageDuplicate;

	/**
	 * Checks if the given array of objects is valid.
	 *
	 * @param array $value
	 *
	 * @return bool
	 */
	public function validate($value)
	{
		// check if it's empty
		if (!$this->empty && !$value) {
			$this->error($this->messageEmpty);

			return false;
		}

		// check for objects with duplicate values
		if ($this->uniqueField) {
			if ($duplicate = CArrayHelper::findDuplicate($value, $this->uniqueField)) {
				$this->error($this->messageDuplicate, $duplicate[$this->uniqueField]);

				return false;
			}
		}

		return true;
	}

}
