<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\NegativeBalanceException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class User
 * @property int $id
 * @property string $name
 * @property-read integer $balance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection<int, UserTransaction> $transactions
 */
final class User extends Model
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    public function transactions(): HasMany
    {
        return $this->hasMany(UserTransaction::class, 'user_id');
    }

    public function modifyBalance($amount) : void
    {
        if (($this->balance + $amount) < 0) {
            throw new NegativeBalanceException('Negative user balance');
        }

        $this->balance += $amount;
    }
}
