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
 * Class UserLog
 * 
 * @property string $user_login
 * @property string $log_type
 * @property Carbon $log_date
 * @property string $ip
 * @property int $blog_id
 * @property string $content
 * @property string $where
 * @property int $loginfailnum
 * @property int $floginsum
 *
 * @package App\Models
 */
class UserLog extends Model
{
	protected $table = 'user_logs';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'log_date' => 'datetime',
		'blog_id' => 'int',
		'loginfailnum' => 'int',
		'floginsum' => 'int'
	];

	protected $fillable = [
		'user_login',
		'log_type',
		'log_date',
		'ip',
		'blog_id',
		'content',
		'where',
		'loginfailnum',
		'floginsum'
	];
}
