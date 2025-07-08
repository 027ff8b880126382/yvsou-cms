<?php
/**
 * © 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo   All rights reserved.
 * Author: Lican Huang
 * License: Dual Licensed – GPLv3 or Commercial
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * As an alternative to GPLv3, commercial licensing is available for organizations
 * or individuals requiring proprietary usage, private modifications, or support.
 *
 * Contact: yvsoucom@gmail.com
 * GPL License: https://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class DomainManager
 * 
 * @property int $userid
 * @property string $m_type
 * @property string $domainid
 * @property string $ownerrights
 * @property string $owngrouprights
 * @property string $grantgrouprights
 * @property string $grantuserrights
 * @property string $anyuserrights
 * @property bool $bChange
 * @property bool $bAddchild
 * @property bool $dDelchild
 * @property bool $bHide
 * @property bool $bTrash
 * @property string $IP
 * @property Carbon $cDate
 * @property int $sem
 *
 * @package App\Models
 */
class DomainManager extends Model
{
	protected $table = 'domain_managers';
	protected $primaryKey = 'domainid';
	protected $keyType = 'string'; // because it's not an integer
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'userid' => 'int',
		'bChange' => 'bool',
		'bAddchild' => 'bool',
		'dDelchild' => 'bool',
		'bHide' => 'bool',
		'bTrash' => 'bool',
		'cDate' => 'datetime',
		'sem' => 'int'
	];


	protected $fillable = [
		'userid',
		'domainid',
		'm_type',
		'ownerrights',
		'owngrouprights',
		'grantgrouprights',
		'grantuserrights',
		'anyuserrights',
		'bChange',
		'bAddchild',
		'dDelchild',
		'bHide',
		'bTrash',
		'IP',
		'cDate',
		'sem'
	];

	public static function getFirstGroupid(): string|null
	{
		return self::query()->value('domainid');
	}

	public static function setPublic(string $groupid): bool
	{
		$updated = self::where('domainid', $groupid)
			->update(['bHide' => 0]);

		return $updated > 0;
	}

	public static function setPrivate(string $groupid): bool
	{
		$updated = self::where('domainid', $groupid)
			->update(['bHide' => 1]);

		return $updated > 0;
	}
}
