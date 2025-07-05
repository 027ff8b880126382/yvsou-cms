<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
/**
 * Class DomainTreeChildId
 * 
 * @property int $child_id
 * @property string $domainid
 *
 * @package App\Models
 */
class DomainTreeChildId extends Model
{
    protected $table = 'domain_tree_child_ids';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'child_id',
        'domainid',
    ];
    protected $casts = [
        'child_id' => 'int'
    ];
    //
}
