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

use App\Services\RightsService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class DomainComment
 * 
 * @property int $id
 * @property int $postid
 * @property string $comment_ip
 * @property Carbon $comment_date
 * @property string $comment_content
 * @property int $comment_approved
 * @property int $comment_parent
 * @property int $userid
 * @property int $post_version
 *
 * @package App\Models
 */
class DomainComment extends Model
{
	protected $table = 'domain_comments';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'postid' => 'int',
		'comment_date' => 'datetime',
		'comment_approved' => 'int',
		'comment_parent' => 'int',
		'userid' => 'int',
		'post_version' => 'int',
	];

	protected $fillable = [
		'postid',
		'comment_ip',
		'comment_date',
		'comment_content',
		'comment_approved',
		'comment_parent',
		'userid',
		'post_version',
	];


	public function makecoment(int $commentid)
	{
		return DomainComment::findOrFail($commentid);
	}
	public function user()
	{
		return $this->belongsTo(User::class, 'userid');
	}

	public function children()
	{
		return $this->hasMany(DomainComment::class, 'comment_parent', 'id');
	}



}
