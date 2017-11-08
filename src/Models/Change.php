<?php
/**
 * Created by Sune
 */
namespace Westphalen\Laravel\Change\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Westphalen\Laravel\Change\Models\Change
 *
 * @property string $id
 * @property string $changeable_id
 * @property string $changeable_type
 * @property string $column
 * @property string $value
 * @property \Carbon\Carbon $expires_at
 * @property \Carbon\Carbon $applied_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $changeable
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereAppliedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereChangeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereChangeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change withoutApplied()
 * @method static \Illuminate\Database\Eloquent\Builder|\Westphalen\Laravel\Change\Models\Change withoutExpired()
 * @mixin \Eloquent
 */
class Change extends Model
{
    use UuidModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'column',
        'value',
        'expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'applied_at' => 'datetime',
    ];

    /**
     * Get parent model.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function changeable()
    {
        return $this->morphTo();
    }

    /**
     * Apply this change to its parent.
     *
     * @return  void
     */
    public function apply()
    {
        $this->changeable->{$this->column} = $this->value;
        $this->changeable->saveOrFail();

        $this->applied_at = Carbon::now();
        $this->saveOrFail();
    }

    /**
     * Check if the Change has expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at < Carbon::now();
    }

    /**
     * Check if the Change has been applied.
     *
     * @return bool
     */
    public function isApplied()
    {
        return $this->applied_at !== NULL;
    }

    /**
     * Scope to exclude expired changes.
     *
     * @param   \Illuminate\Database\Eloquent\Builder   $query
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutExpired($query)
    {
        return $query->where('expires_at', '<', Carbon::now());
    }

    /**
     * Scope to exclude applied changes.
     *
     * @param   \Illuminate\Database\Eloquent\Builder   $query
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutApplied($query)
    {
        return $query->whereNull('applied_at');
    }
}
