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
 * Class DomainPostId
 * 
 * @property int $id
 * @property int $postid
 * @property string $groupid
 * @property int $lang
 * @property int $guserid
 * @property Carbon $gDate
 * @property bool $isTrash
 *
 * @package App\Models
 */
class DomainPostId extends Model
{
	protected $table = 'domain_post_ids';
	 
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = false;
 

	protected $casts = [
		'postid' => 'int',
		'lang' => 'int',
		'guserid' => 'int',
		'gDate' => 'datetime',
		'isTrash' => 'bool'
	];

	protected $fillable = [
		'postid',
		'groupid',
		'lang',
		'guserid',
		'gDate',
		'isTrash'
	];
}
